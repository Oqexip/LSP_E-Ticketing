@extends('layouts.app')

@section('title', 'Riwayat Pemesanan - E-Ticketing Easy')
@section('page-title', 'Riwayat Pemesanan')
@section('page-subtitle', 'Semua pesanan tiket Anda')

@section('content')
    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-sm mb-6 animate-fade-in">
        <a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-gray-900 transition-colors">Dashboard</a>
        <span class="text-gray-300">/</span>
        <span class="text-gray-900 font-medium">Riwayat Pemesanan</span>
    </div>

    @if ($orders->isEmpty())
        {{-- Empty State --}}
        <div class="glass-card p-12 text-center animate-fade-in-up">
            <div class="mb-4 flex justify-center">
                <svg class="w-16 h-16 text-gray-300 animate-float" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum Ada Pesanan</h3>
            <p class="text-gray-500 mb-6">Anda belum memiliki riwayat pemesanan tiket.</p>
            <a href="{{ route('dashboard') }}" class="btn-gradient inline-flex items-center gap-2 no-underline">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                Cari Penerbangan
            </a>
        </div>
    @else
        {{-- Summary Card --}}
        <div class="glass-card p-5 mb-6 animate-fade-in-up">
            <div class="flex flex-wrap items-center gap-6">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-900">{{ $orders->count() }}</p>
                        <p class="text-[10px] text-gray-500 uppercase tracking-wider">Total Pesanan</p>
                    </div>
                </div>
                <div class="h-8 w-px bg-gray-200 hidden sm:block"></div>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center">
                        <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-accent-500">Rp {{ number_format($orders->sum('total_price')) }}</p>
                        <p class="text-[10px] text-gray-500 uppercase tracking-wider">Total Pengeluaran</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Booking Cards --}}
        <div class="space-y-4">
            @foreach ($orders as $index => $item)
                <div class="glass-card p-5 hover:border-gray-300 transition-all duration-300 animate-fade-in-up stagger-{{ ($index % 5) + 1 }}">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        {{-- Left: Flight Info --}}
                        <div class="flex items-start gap-4 flex-1">
                            <div class="w-11 h-11 rounded-xl bg-blue-50 flex items-center justify-center shrink-0 mt-0.5">
                                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                </svg>
                            </div>
                            <div class="min-w-0 flex-1">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <h4 class="text-gray-900 font-semibold">{{ $item->schedule->plane_name }}</h4>
                                    @if($item->status === 'Lunas')
                                        <span class="badge badge-success">{{ $item->status }}</span>
                                    @elseif($item->status === 'Pending')
                                        <span class="badge badge-warning">{{ $item->status }}</span>
                                    @else
                                        <span class="badge badge-info">{{ $item->status }}</span>
                                    @endif
                                </div>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="text-sm text-gray-600">{{ Str::before($item->schedule->origin, ' (') }}</span>
                                    <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                    </svg>
                                    <span class="text-sm text-gray-600">{{ Str::before($item->schedule->destination, ' (') }}</span>
                                </div>
                                <p class="text-xs text-gray-400 mt-1">
                                    {{ $item->created_at->format('d M Y, H:i') }} · {{ $item->total_seats }} kursi
                                </p>
                            </div>
                        </div>

                        {{-- Right: Price --}}
                        <div class="text-right sm:text-right shrink-0">
                            <p class="text-[10px] text-gray-400 uppercase tracking-wider">Total Bayar</p>
                            <p class="text-lg font-bold text-accent-500">Rp {{ number_format($item->total_price) }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection
