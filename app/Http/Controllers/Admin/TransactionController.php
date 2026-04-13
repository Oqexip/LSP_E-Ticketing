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
        $transactions = Transaction::with(['booking.user', 'booking.schedule'])
            ->latest()
            ->get();

        return view('admin.transactions.index', compact('transactions'));
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
