<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    // Menampilkan detail transaksi + form upload bukti bayar
    public function show($id)
    {
        $transaction = Transaction::with(['booking.schedule', 'booking.user'])->findOrFail($id);

        // Pastikan user hanya bisa akses transaksinya sendiri
        if ($transaction->booking->user_id !== Auth::id()) {
            abort(403);
        }

        return view('user.transaction_detail', compact('transaction'));
    }

    // Proses upload bukti bayar
    public function pay(Request $request, $id)
    {
        $transaction = Transaction::with('booking')->findOrFail($id);

        // Pastikan user hanya bisa bayar transaksinya sendiri
        if ($transaction->booking->user_id !== Auth::id()) {
            abort(403);
        }

        // Pastikan transaksi masih Pending
        if ($transaction->status !== 'Pending') {
            return back()->with('error', 'Transaksi ini sudah diproses.');
        }

        $request->validate([
            'payment_method' => 'required|string|max:255',
            'payment_proof' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Upload bukti bayar
        $path = $request->file('payment_proof')->store('payment_proofs', 'public');

        // Update transaksi
        $transaction->update([
            'payment_method' => $request->payment_method,
            'payment_proof' => $path,
        ]);

        return redirect()->route('transaction.show', $transaction->id)
            ->with('success', 'Bukti pembayaran berhasil diupload! Menunggu konfirmasi admin.');
    }
}
