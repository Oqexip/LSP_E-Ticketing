<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\User;
use App\Models\Schedule;
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
            $schedules = Schedule::latest()->get();
            $bookings = Booking::with(['user', 'schedule'])->latest()->get();
            return view('admin.dashboard', compact('schedules', 'bookings'));
        }

        // Jika user, kirim data jadwal untuk dipesan
        $schedules = Schedule::where('stock', '>', 0)->get();
        return view('user.dashboard', compact('schedules'));
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
