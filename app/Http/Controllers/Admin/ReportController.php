<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Schedule;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // Date filters
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->format('Y-m-d'));

        $start = Carbon::parse($startDate)->startOfDay();
        $end = Carbon::parse($endDate)->endOfDay();

        // Summary Stats
        $totalTransactions = Transaction::whereBetween('created_at', [$start, $end])->count();
        $totalRevenue = Transaction::where('status', 'Lunas')
            ->whereBetween('created_at', [$start, $end])
            ->sum('amount');
        $totalPending = Transaction::where('status', 'Pending')
            ->whereBetween('created_at', [$start, $end])
            ->count();
        $totalRejected = Transaction::where('status', 'Gagal')
            ->whereBetween('created_at', [$start, $end])
            ->count();
        $totalConfirmed = Transaction::where('status', 'Lunas')
            ->whereBetween('created_at', [$start, $end])
            ->count();
        $totalSeatsSold = Transaction::where('transactions.status', 'Lunas')
            ->whereBetween('transactions.created_at', [$start, $end])
            ->join('bookings', 'transactions.booking_id', '=', 'bookings.id')
            ->sum('bookings.total_seats');

        // Revenue by Day (for chart)
        $dailyRevenue = Transaction::where('status', 'Lunas')
            ->whereBetween('created_at', [$start, $end])
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(amount) as total'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Transaction count by Day (for chart)
        $dailyTransactions = Transaction::whereBetween('created_at', [$start, $end])
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as total'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // By Payment Method
        $byPaymentMethod = Transaction::where('status', 'Lunas')
            ->whereBetween('created_at', [$start, $end])
            ->whereNotNull('payment_method')
            ->select('payment_method', DB::raw('COUNT(*) as count'), DB::raw('SUM(amount) as total'))
            ->groupBy('payment_method')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        // By Status
        $byStatus = Transaction::whereBetween('created_at', [$start, $end])
            ->select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->get();

        // Top Routes
        $topRoutes = Booking::join('schedules', 'bookings.schedule_id', '=', 'schedules.id')
            ->where('bookings.status', 'Lunas')
            ->whereBetween('bookings.created_at', [$start, $end])
            ->select(
                'schedules.origin',
                'schedules.destination',
                'schedules.plane_name',
                DB::raw('COUNT(*) as booking_count'),
                DB::raw('SUM(bookings.total_seats) as seats_sold'),
                DB::raw('SUM(bookings.total_price) as revenue')
            )
            ->groupBy('schedules.origin', 'schedules.destination', 'schedules.plane_name')
            ->orderByDesc('revenue')
            ->limit(5)
            ->get();

        // Recent Transactions Sorting setup
        $sort = $request->input('sort', 'waktu');
        $order = $request->input('order', 'desc');
        
        $recentTransactionsQuery = Transaction::with(['booking.user', 'booking.schedule'])
            ->leftJoin('bookings', 'transactions.booking_id', '=', 'bookings.id')
            ->leftJoin('users', 'bookings.user_id', '=', 'users.id')
            ->leftJoin('schedules', 'bookings.schedule_id', '=', 'schedules.id')
            ->whereBetween('transactions.created_at', [$start, $end])
            ->select('transactions.*'); 

        if ($sort === 'id') {
            $recentTransactionsQuery->orderBy('transactions.id', $order);
        } elseif ($sort === 'pemesan') {
            $recentTransactionsQuery->orderBy('users.name', $order);
        } elseif ($sort === 'penerbangan') {
            $recentTransactionsQuery->orderBy('schedules.plane_name', $order);
        } elseif ($sort === 'metode') {
            $recentTransactionsQuery->orderBy('transactions.payment_method', $order);
        } elseif ($sort === 'jumlah') {
            $recentTransactionsQuery->orderBy('transactions.amount', $order);
        } elseif ($sort === 'status') {
            $recentTransactionsQuery->orderBy('transactions.status', $order);
        } else {
            $recentTransactionsQuery->orderBy('transactions.created_at', $order);
        }

        $recentTransactions = $recentTransactionsQuery->paginate(10)->withQueryString();

        return view('admin.reports.index', compact(
            'startDate',
            'endDate',
            'totalTransactions',
            'totalRevenue',
            'totalPending',
            'totalRejected',
            'totalConfirmed',
            'totalSeatsSold',
            'dailyRevenue',
            'dailyTransactions',
            'byPaymentMethod',
            'byStatus',
            'topRoutes',
            'recentTransactions'
        ));
    }

    public function export(Request $request)
    {
        $type = $request->input('type', 'pdf');
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->format('Y-m-d'));

        $start = Carbon::parse($startDate)->startOfDay();
        $end = Carbon::parse($endDate)->endOfDay();

        $transactions = Transaction::with(['booking.user', 'booking.schedule'])
            ->whereBetween('created_at', [$start, $end])
            ->latest()
            ->get();

        if ($type === 'csv') {
            $filename = "report_transactions_{$startDate}_{$endDate}.csv";
            $headers = [
                "Content-type"        => "text/csv",
                "Content-Disposition" => "attachment; filename=$filename",
                "Pragma"              => "no-cache",
                "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                "Expires"             => "0"
            ];

            $callback = function() use($transactions) {
                $file = fopen('php://output', 'w');
                // Tulis header CSV
                fputcsv($file, ['ID Transaksi', 'Tanggal', 'Nama Pelanggan', 'Rute Penerbangan', 'Total Kursi', 'Total Harga', 'Status', 'Metode Pembayaran']);

                // Tulis baris data
                foreach ($transactions as $t) {
                    fputcsv($file, [
                        $t->id,
                        $t->created_at->format('d/m/Y H:i'),
                        $t->booking->user->name ?? '-',
                        ($t->booking->schedule->origin ?? '-') . ' -> ' . ($t->booking->schedule->destination ?? '-'),
                        $t->booking->total_seats ?? 0,
                        $t->amount,
                        $t->status,
                        $t->payment_method ?? '-'
                    ]);
                }

                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        }

        // Default export PDF
        $totalRevenue = $transactions->where('status', 'Lunas')->sum('amount');
        
        $pdf = Pdf::loadView('admin.reports.pdf', compact('transactions', 'startDate', 'endDate', 'totalRevenue'));
        return $pdf->download("report_transactions_{$startDate}_{$endDate}.pdf");
    }
}
