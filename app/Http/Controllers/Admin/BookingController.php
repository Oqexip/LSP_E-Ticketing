<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    // Melihat daftar semua pesanan dari semua user
    public function index()
    {
        // Mengambil data booking beserta relasi user dan schedule
        $bookings = Booking::with(['user', 'schedule'])->latest()->get();
        return view('admin.bookings.index', compact('bookings'));
    }
}