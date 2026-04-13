<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Schedule;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    // Menampilkan halaman detail sebelum memesan
    public function show($id)
    {
        $schedule = Schedule::findOrFail($id);
        return view('user.booking_detail', compact('schedule'));
    }

    // Memproses pesanan ke database
    public function store(Request $request, $id)
    {
        $schedule = Schedule::findOrFail($id);

        $request->validate([
            'total_seats' => 'required|integer|min:1|max:' . $schedule->stock,
        ]);

        // Hitung total harga
        $total_price = $request->total_seats * $schedule->price;

        // Simpan ke tabel Bookings (status Pending, menunggu pembayaran)
        $booking = Booking::create([
            'user_id' => Auth::id(),
            'schedule_id' => $schedule->id,
            'total_seats' => $request->total_seats,
            'total_price' => $total_price,
            'status' => 'Pending'
        ]);

        // Kurangi stok di tabel schedules
        $schedule->decrement('stock', $request->total_seats);

        // Buat transaction otomatis
        Transaction::create([
            'booking_id' => $booking->id,
            'amount' => $total_price,
            'status' => 'Pending',
        ]);

        // Redirect ke halaman pembayaran
        return redirect()->route('transaction.show', $booking->transaction->id)
            ->with('success', 'Pemesanan berhasil! Silakan lakukan pembayaran.');
    }

    // Menampilkan riwayat pesanan user yang sedang login
    public function history()
    {
        $orders = Booking::where('user_id', Auth::id())
                        ->with(['schedule', 'transaction']) 
                        ->latest()
                        ->get();

        return view('user.history', compact('orders'));
    }
}