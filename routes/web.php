<?php

use App\Http\Controllers\Admin\ScheduleController as AdminScheduleController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\TransactionController as AdminTransactionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

// Guest: Login & Register
Route::get('/', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'postLogin'])->name('login.post');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'postRegister'])->name('register.post');

// Auth: Hanya untuk yang sudah login
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/booking/{id}', [BookingController::class, 'show'])->name('booking.index'); 
    Route::post('/booking/{id}', [BookingController::class, 'store'])->name('booking.store');
    Route::get('/history', [BookingController::class, 'history'])->name('booking.history');

    // User: Transaksi
    Route::get('/transaction/{id}', [TransactionController::class, 'show'])->name('transaction.show');
    Route::post('/transaction/{id}/pay', [TransactionController::class, 'pay'])->name('transaction.pay');

    // Admin: Jadwal
    Route::get('/admin/schedules/create', [AdminScheduleController::class, 'create']);
    Route::post('/admin/schedules/store', [AdminScheduleController::class, 'store']);
    Route::get('/admin/schedules/edit/{id}', [AdminScheduleController::class, 'edit']);
    Route::post('/admin/schedules/update/{id}', [AdminScheduleController::class, 'update']);
    Route::get('/admin/schedules/delete/{id}', [AdminScheduleController::class, 'destroy']);
    
    Route::get('/admin/bookings', [AdminBookingController::class, 'index']);

    // Admin: Transaksi
    Route::get('/admin/transactions', [AdminTransactionController::class, 'index'])->name('admin.transactions.index');
    Route::post('/admin/transactions/{id}/confirm', [AdminTransactionController::class, 'confirm'])->name('admin.transactions.confirm');
    Route::post('/admin/transactions/{id}/reject', [AdminTransactionController::class, 'reject'])->name('admin.transactions.reject');
});