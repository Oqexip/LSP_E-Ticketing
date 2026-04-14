<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    // Menampilkan daftar semua transaksi
    public function index()
    {
        $totalPending = Transaction::where('status', 'Pending')->count();
        $totalLunas = Transaction::where('status', 'Lunas')->count();
        $totalGagal = Transaction::where('status', 'Gagal')->count();
        $totalTransactionsCount = Transaction::count();

        $sort = request('sort', 'waktu');
        $order = request('order', 'desc');

        $query = Transaction::with(['booking.user', 'booking.schedule'])
            ->leftJoin('bookings', 'transactions.booking_id', '=', 'bookings.id')
            ->leftJoin('users', 'bookings.user_id', '=', 'users.id')
            ->leftJoin('schedules', 'bookings.schedule_id', '=', 'schedules.id')
            ->select('transactions.*');

        if ($sort === 'id') {
            $query->orderBy('transactions.id', $order);
        } elseif ($sort === 'pemesan') {
            $query->orderBy('users.name', $order);
        } elseif ($sort === 'penerbangan') {
            $query->orderBy('schedules.plane_name', $order);
        } elseif ($sort === 'metode') {
            $query->orderBy('transactions.payment_method', $order);
        } elseif ($sort === 'jumlah') {
            $query->orderBy('transactions.amount', $order);
        } elseif ($sort === 'status') {
            $query->orderBy('transactions.status', $order);
        } else {
            $query->orderBy('transactions.created_at', $order);
        }

        $transactions = $query->paginate(10)->withQueryString();

        return view('admin.transactions.index', compact('transactions', 'totalPending', 'totalLunas', 'totalGagal', 'totalTransactionsCount'));
    }

    // Menampilkan detail transaksi
    public function show($id)
    {
        $transaction = Transaction::with(['booking.user', 'booking.schedule'])->findOrFail($id);
        return view('admin.transactions.show', compact('transaction'));
    }

    // Konfirmasi transaksi (status → Lunas)
    public function confirm($id)
    {
        $transaction = Transaction::with('booking')->findOrFail($id);

        $transaction->update(['status' => 'Lunas']);
        $transaction->booking->update(['status' => 'Lunas']);

        return back()->with('success', 'Transaksi #' . $transaction->id . ' berhasil dikonfirmasi.');
    }

    // Tolak transaksi (status → Gagal, kembalikan stok)
    public function reject($id)
    {
        $transaction = Transaction::with('booking.schedule')->findOrFail($id);

        $transaction->update(['status' => 'Gagal']);
        $transaction->booking->update(['status' => 'Gagal']);

        // Kembalikan stok kursi
        $transaction->booking->schedule->increment('stock', $transaction->booking->total_seats);

        return back()->with('success', 'Transaksi #' . $transaction->id . ' ditolak. Stok kursi dikembalikan.');
    }
}
