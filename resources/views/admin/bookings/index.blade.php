@extends('layouts.app')

@section('title', 'Semua Transaksi - E-Ticketing Easy')
@section('page-title', 'Semua Transaksi')
@section('page-subtitle', 'Daftar semua transaksi dari seluruh pengguna')

@section('content')
    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-sm mb-6 animate-fade-in">
        <a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-gray-900 ">Dashboard</a>
        <span class="text-gray-300">/</span>
        <span class="text-gray-900 font-medium">Semua Transaksi</span>
    </div>

    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
        <div class="glass-card p-5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900">{{ $bookings->count() }}</p>
                    <p class="text-[10px] text-gray-500 uppercase tracking-wider">Total Transaksi</p>
                </div>
            </div>
        </div>
        <div class="glass-card p-5" title="Rp {{ number_format($bookings->where('status', 'Lunas')->sum('total_price')) }}">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-green-50 flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-lg font-bold text-accent-500 truncate">Rp {{ number_format($bookings->where('status', 'Lunas')->sum('total_price')) }}</p>
                    <p class="text-[10px] text-gray-500 uppercase tracking-wider">Total Revenue</p>
                </div>
            </div>
        </div>
        <div class="glass-card p-5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-purple-50 flex items-center justify-center">
                    <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900">{{ $bookings->where('status', 'Lunas')->sum('total_seats') }}</p>
                    <p class="text-[10px] text-gray-500 uppercase tracking-wider">Kursi Terjual</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Transactions Table --}}
    <div class="glass-card overflow-hidden">
        <div class="flex items-center justify-between p-5 border-b border-gray-100">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-green-50 flex items-center justify-center">
                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-gray-900 font-semibold">Daftar Transaksi</h3>
                    <p class="text-xs text-gray-500">{{ $bookings->count() }} transaksi dari semua user</p>
                </div>
            </div>
        </div>

        @if($bookings->isEmpty())
            <div class="p-8 text-center">
                <p class="text-gray-500">Belum ada transaksi.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="table-modern">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Pemesan</th>
                            <th>Pesawat</th>
                            <th>Rute</th>
                            <th>Kursi</th>
                            <th>Total Bayar</th>
                            <th>Status</th>
                            <th>Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bookings as $b)
                            <tr>
                                <td>
                                    <span class="text-xs font-mono text-gray-500">#{{ $b->id }}</span>
                                </td>
                                <td>
                                    <div class="flex items-center gap-2">
                                        <div class="w-7 h-7 rounded-full bg-gradient-to-br from-blue-600 to-blue-800 flex items-center justify-center text-white text-[10px] font-bold shrink-0">
                                            {{ strtoupper(substr($b->user->name, 0, 1)) }}
                                        </div>
                                        <span class="text-gray-900">{{ $b->user->name }}</span>
                                    </div>
                                </td>
                                <td>{{ $b->schedule->plane_name }}</td>
                                <td>
                                    <div class="flex items-center gap-1.5">
                                        <span>{{ Str::before($b->schedule->origin, ' (') }}</span>
                                        <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                        </svg>
                                        <span>{{ Str::before($b->schedule->destination, ' (') }}</span>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-info">{{ $b->total_seats }}</span>
                                </td>
                                <td class="font-medium text-accent-500 whitespace-nowrap">Rp {{ number_format($b->total_price) }}</td>
                                <td>
                                    @if($b->status === 'Lunas')
                                        <span class="badge badge-success">{{ $b->status }}</span>
                                    @elseif($b->status === 'Pending')
                                        <span class="badge badge-warning">{{ $b->status }}</span>
                                    @else
                                        <span class="badge badge-info">{{ $b->status }}</span>
                                    @endif
                                </td>
                                <td>
                                    <div>
                                        <p class="text-gray-700">{{ $b->created_at->format('d/m/Y') }}</p>
                                        <p class="text-xs text-gray-400">{{ $b->created_at->format('H:i') }}</p>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-5 pb-5 mt-4">
                {{ $bookings->links() }}
            </div>
        @endif
    </div>
@endsection
