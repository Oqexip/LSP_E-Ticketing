<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\User;
use App\Models\Schedule;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }
    public function register()
    {
        return view('auth.register');
    }

    public function postRegister(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user'
        ]);
        return redirect('/')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    public function postLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            return redirect('/dashboard');
        }
        return back()->withErrors(['email' => 'Email atau password salah.'])->withInput();
    }

    public function dashboard()
    {
        if (Auth::user()->role == 'admin') {
            $schedules = Schedule::latest()->paginate(5, ['*'], 'sched_page');
            $bookings = Booking::with(['user', 'schedule'])->latest()->paginate(5, ['*'], 'book_page');
            $pendingTransactions = Transaction::with(['booking.user', 'booking.schedule'])
                ->where('status', 'Pending')
                ->whereNotNull('payment_proof')
                ->latest()
                ->paginate(5, ['*'], 'pend_page');
            return view('admin.dashboard', compact('schedules', 'bookings', 'pendingTransactions'));
        }

        // Jika user, kirim data jadwal untuk dipesan
        $schedules = Schedule::where('stock', '>', 0)->paginate(6);
        return view('user.dashboard', compact('schedules'));
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
