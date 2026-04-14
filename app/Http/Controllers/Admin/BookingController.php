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
        $totalBookingsCount = Booking::count();
        $totalRevenue = Booking::where('status', 'Lunas')->sum('total_price');
        $totalSeatsSold = Booking::where('status', 'Lunas')->sum('total_seats');

        $sort = request('sort', 'waktu');
        $order = request('order', 'desc');

        $query = Booking::with(['user', 'schedule'])
            ->leftJoin('users', 'bookings.user_id', '=', 'users.id')
            ->leftJoin('schedules', 'bookings.schedule_id', '=', 'schedules.id')
            ->select('bookings.*');

        if ($sort === 'id') {
            $query->orderBy('bookings.id', $order);
        } elseif ($sort === 'pemesan') {
            $query->orderBy('users.name', $order);
        } elseif ($sort === 'pesawat') {
            $query->orderBy('schedules.plane_name', $order);
        } elseif ($sort === 'rute') {
            $query->orderBy('schedules.origin', $order);
        } elseif ($sort === 'kursi') {
            $query->orderBy('bookings.total_seats', $order);
        } elseif ($sort === 'total_bayar') {
            $query->orderBy('bookings.total_price', $order);
        } elseif ($sort === 'status') {
            $query->orderBy('bookings.status', $order);
        } else {
            $query->orderBy('bookings.created_at', $order);
        }

        $bookings = $query->paginate(10)->withQueryString();

        return view('admin.bookings.index', compact('bookings', 'totalBookingsCount', 'totalRevenue', 'totalSeatsSold'));
    }
}