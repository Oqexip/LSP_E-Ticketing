@extends('layouts.app')

@section('title', 'Laporan - E-Ticketing Easy')
@section('page-title', 'Laporan & Analitik')
@section('page-subtitle', 'Pantau performa bisnis dan statistik transaksi')

@section('content')
    {{-- Date Filter --}}
    <div class="glass-card p-5 mb-6">
        <form method="GET" action="{{ route('admin.reports.index') }}" class="flex flex-wrap items-end gap-4">
            <div class="flex-1 min-w-[180px]">
                <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1.5">Tanggal Mulai</label>
                <input type="date" name="start_date" value="{{ $startDate }}"
                    class="input-admin w-full">
            </div>
            <div class="flex-1 min-w-[180px]">
                <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1.5">Tanggal Akhir</label>
                <input type="date" name="end_date" value="{{ $endDate }}"
                    class="input-admin w-full">
            </div>
            <div class="flex gap-2">
                <button type="submit" class="btn-gradient !py-2.5 !px-5 text-sm inline-flex items-center gap-2 cursor-pointer border-none">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                    </svg>
                    Filter
                </button>
                <a href="{{ route('admin.reports.index') }}" class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl bg-gray-100 text-gray-600 text-sm font-medium hover:bg-gray-200 no-underline">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    Reset
                </a>
            </div>
            
            <div class="flex gap-2 ml-auto">
                {{-- Export CSV --}}
                <a href="{{ route('admin.reports.export', ['type' => 'csv', 'start_date' => $startDate, 'end_date' => $endDate]) }}" class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl bg-blue-50 text-blue-600 hover:bg-blue-100 text-sm font-medium no-underline">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    CSV
                </a>
                {{-- Export PDF --}}
                <a href="{{ route('admin.reports.export', ['type' => 'pdf', 'start_date' => $startDate, 'end_date' => $endDate]) }}" class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl bg-rose-50 text-rose-600 hover:bg-rose-100 text-sm font-medium no-underline">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    PDF
                </a>
            </div>
        </form>
    </div>

    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        {{-- Total Revenue --}}
        <div class="glass-card p-5 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-bl from-green-100 to-transparent rounded-bl-full opacity-60"></div>
            <div class="flex items-center justify-between gap-3 relative">
                <div class="min-w-0">
                    <p class="text-xs text-gray-500 uppercase tracking-wider">Total Pendapatan</p>
                    <p class="text-xl font-bold text-green-600 mt-1 truncate" title="Rp {{ number_format($totalRevenue) }}">Rp {{ number_format($totalRevenue) }}</p>
                    <p class="text-[10px] text-gray-400 mt-1">{{ $totalConfirmed }} transaksi lunas</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-green-50 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Total Transaksi --}}
        <div class="glass-card p-5 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-bl from-blue-100 to-transparent rounded-bl-full opacity-60"></div>
            <div class="flex items-center justify-between gap-3 relative">
                <div class="min-w-0">
                    <p class="text-xs text-gray-500 uppercase tracking-wider">Total Transaksi</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $totalTransactions }}</p>
                    <p class="text-[10px] text-gray-400 mt-1">Periode terpilih</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Pending --}}
        <div class="glass-card p-5 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-bl from-amber-100 to-transparent rounded-bl-full opacity-60"></div>
            <div class="flex items-center justify-between gap-3 relative">
                <div class="min-w-0">
                    <p class="text-xs text-gray-500 uppercase tracking-wider">Menunggu Konfirmasi</p>
                    <p class="text-3xl font-bold text-amber-600 mt-1">{{ $totalPending }}</p>
                    <p class="text-[10px] text-gray-400 mt-1">Perlu ditindaklanjuti</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-amber-50 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Kursi Terjual --}}
        <div class="glass-card p-5 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-bl from-purple-100 to-transparent rounded-bl-full opacity-60"></div>
            <div class="flex items-center justify-between gap-3 relative">
                <div class="min-w-0">
                    <p class="text-xs text-gray-500 uppercase tracking-wider">Kursi Terjual</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $totalSeatsSold }}</p>
                    <p class="text-[10px] text-gray-400 mt-1">{{ $totalRejected }} transaksi ditolak</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-purple-50 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Charts Row --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        {{-- Revenue Chart --}}
        <div class="glass-card p-6">
            <div class="flex items-center gap-3 mb-5">
                <div class="w-8 h-8 rounded-lg bg-green-50 flex items-center justify-center">
                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-gray-900 font-semibold">Grafik Pendapatan</h3>
                    <p class="text-xs text-gray-500">Pendapatan harian (transaksi lunas)</p>
                </div>
            </div>
            <div class="h-[280px] relative">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>

        {{-- Status Distribution --}}
        <div class="glass-card p-6">
            <div class="flex items-center gap-3 mb-5">
                <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center">
                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-gray-900 font-semibold">Distribusi Status</h3>
                    <p class="text-xs text-gray-500">Persentase status transaksi</p>
                </div>
            </div>
            <div class="h-[280px] relative flex items-center justify-center">
                <canvas id="statusChart"></canvas>
            </div>
        </div>
    </div>

    {{-- Payment Method & Top Routes --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        {{-- Payment Methods --}}
        <div class="glass-card overflow-hidden">
            <div class="flex items-center gap-3 p-5 border-b border-gray-100">
                <div class="w-8 h-8 rounded-lg bg-amber-50 flex items-center justify-center">
                    <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-gray-900 font-semibold">Metode Pembayaran</h3>
                    <p class="text-xs text-gray-500">Berdasarkan transaksi lunas</p>
                </div>
            </div>

            @if($byPaymentMethod->isEmpty())
                <div class="p-8 text-center">
                    <p class="text-gray-500">Belum ada data metode pembayaran.</p>
                </div>
            @else
                <div class="divide-y divide-gray-50">
                    @foreach($byPaymentMethod as $pm)
                        @php
                            $maxTotal = $byPaymentMethod->max('total');
                            $percentage = $maxTotal > 0 ? ($pm->total / $maxTotal) * 100 : 0;
                            $isEwallet = in_array($pm->payment_method, ['GoPay', 'OVO', 'DANA', 'ShopeePay']);
                            $colors = [
                                'GoPay' => ['bg-green-50', 'text-green-600', 'bg-green-500'],
                                'OVO' => ['bg-purple-50', 'text-purple-600', 'bg-purple-500'],
                                'DANA' => ['bg-blue-50', 'text-blue-600', 'bg-blue-500'],
                                'ShopeePay' => ['bg-orange-50', 'text-orange-600', 'bg-orange-500'],
                            ];
                            $color = $colors[$pm->payment_method] ?? ['bg-gray-50', 'text-gray-600', 'bg-gray-500'];
                        @endphp
                        <div class="p-4 hover:bg-gray-50/50">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg {{ $color[0] }} flex items-center justify-center">
                                        @if($isEwallet)
                                            <svg class="w-4 h-4 {{ $color[1] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                            </svg>
                                        @else
                                            <svg class="w-4 h-4 {{ $color[1] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                            </svg>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $pm->payment_method }}</p>
                                        <p class="text-xs text-gray-400">{{ $pm->count }} transaksi</p>
                                    </div>
                                </div>
                                <p class="text-sm font-semibold text-accent-500">Rp {{ number_format($pm->total) }}</p>
                            </div>
                            <div class="w-full h-1.5 bg-gray-100 rounded-full overflow-hidden">
                                <div class="h-full {{ $color[2] }} rounded-full transition-all duration-500" style="width: {{ $percentage }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Top Routes --}}
        <div class="glass-card overflow-hidden">
            <div class="flex items-center gap-3 p-5 border-b border-gray-100">
                <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center">
                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-gray-900 font-semibold">Rute Terpopuler</h3>
                    <p class="text-xs text-gray-500">Top 5 rute berdasarkan pendapatan</p>
                </div>
            </div>

            @if($topRoutes->isEmpty())
                <div class="p-8 text-center">
                    <p class="text-gray-500">Belum ada data rute.</p>
                </div>
            @else
                <div class="divide-y divide-gray-50">
                    @foreach($topRoutes as $i => $route)
                        <div class="p-4 hover:bg-gray-50/50">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-600 to-blue-800 flex items-center justify-center text-white text-xs font-bold shrink-0">
                                        {{ $i + 1 }}
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-1.5">
                                            <span class="text-sm font-medium text-gray-900">{{ Str::before($route->origin, ' (') }}</span>
                                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                            </svg>
                                            <span class="text-sm font-medium text-gray-900">{{ Str::before($route->destination, ' (') }}</span>
                                        </div>
                                        <p class="text-xs text-gray-400 mt-0.5">{{ $route->plane_name }} · {{ $route->seats_sold }} kursi · {{ $route->booking_count }} booking</p>
                                    </div>
                                </div>
                                <p class="text-sm font-semibold text-accent-500 whitespace-nowrap">Rp {{ number_format($route->revenue) }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    {{-- Recent Transactions Table --}}
    <div class="glass-card overflow-hidden">
        <div class="flex items-center justify-between p-5 border-b border-gray-100">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-green-50 flex items-center justify-center">
                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-gray-900 font-semibold">Transaksi Terbaru</h3>
                    <p class="text-xs text-gray-500">10 transaksi terakhir dalam periode</p>
                </div>
            </div>
        </div>

        @if($recentTransactions->isEmpty())
            <div class="p-8 text-center">
                <div class="mb-3 flex justify-center">
                    <svg class="w-12 h-12 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <p class="text-gray-500">Tidak ada transaksi dalam periode ini.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="table-modern">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Pemesan</th>
                            <th>Penerbangan</th>
                            <th>Metode</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                            <th>Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentTransactions as $t)
                            <tr>
                                <td>
                                    <span class="text-xs font-mono text-gray-500">#{{ $t->id }}</span>
                                </td>
                                <td>
                                    <div class="flex items-center gap-2">
                                        <div class="w-7 h-7 rounded-full bg-gradient-to-br from-blue-600 to-blue-800 flex items-center justify-center text-white text-[10px] font-bold shrink-0">
                                            {{ strtoupper(substr($t->booking->user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <span class="text-gray-900 font-medium">{{ $t->booking->user->name }}</span>
                                            <p class="text-xs text-gray-400">{{ $t->booking->user->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="flex items-center gap-1 text-xs text-gray-500">
                                        <span>{{ Str::before($t->booking->schedule->origin, ' (') }}</span>
                                        <svg class="w-3 h-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                        </svg>
                                        <span>{{ Str::before($t->booking->schedule->destination, ' (') }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-sm text-gray-700">{{ $t->payment_method ?? '-' }}</span>
                                </td>
                                <td>
                                    <p class="font-medium text-accent-500 whitespace-nowrap">Rp {{ number_format($t->amount) }}</p>
                                </td>
                                <td>
                                    @if($t->status === 'Lunas')
                                        <span class="badge badge-success">{{ $t->status }}</span>
                                    @elseif($t->status === 'Gagal')
                                        <span class="badge badge-danger">{{ $t->status }}</span>
                                    @else
                                        <span class="badge badge-warning">{{ $t->status }}</span>
                                    @endif
                                </td>
                                <td>
                                    <div>
                                        <p class="text-gray-700">{{ $t->created_at->format('d/m/Y') }}</p>
                                        <p class="text-xs text-gray-400">{{ $t->created_at->format('H:i') }}</p>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-5 pb-5 mt-4">
                {{ $recentTransactions->links() }}
            </div>
        @endif
    </div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
<script>
    // Revenue Chart
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    const revenueGradient = revenueCtx.createLinearGradient(0, 0, 0, 280);
    revenueGradient.addColorStop(0, 'rgba(34, 197, 94, 0.15)');
    revenueGradient.addColorStop(1, 'rgba(34, 197, 94, 0)');

    new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($dailyRevenue->pluck('date')->map(fn($d) => \Carbon\Carbon::parse($d)->format('d M'))) !!},
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: {!! json_encode($dailyRevenue->pluck('total')) !!},
                borderColor: 'rgba(34, 197, 94, 1)',
                backgroundColor: revenueGradient,
                borderWidth: 2.5,
                fill: true,
                tension: 0.4,
                pointRadius: 4,
                pointBackgroundColor: '#fff',
                pointBorderColor: 'rgba(34, 197, 94, 1)',
                pointBorderWidth: 2,
                pointHoverRadius: 6,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1f2937',
                    titleFont: { family: 'Inter', size: 12 },
                    bodyFont: { family: 'Inter', size: 12 },
                    padding: 12,
                    cornerRadius: 10,
                    callbacks: {
                        label: function(context) {
                            return 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { font: { family: 'Inter', size: 11 }, color: '#9ca3af' }
                },
                y: {
                    grid: { color: 'rgba(0,0,0,0.04)' },
                    ticks: {
                        font: { family: 'Inter', size: 11 },
                        color: '#9ca3af',
                        callback: function(value) {
                            if (value >= 1000000) return 'Rp ' + (value / 1000000).toFixed(1) + 'Jt';
                            if (value >= 1000) return 'Rp ' + (value / 1000).toFixed(0) + 'Rb';
                            return 'Rp ' + value;
                        }
                    }
                }
            }
        }
    });

    // Status Donut Chart
    const statusCtx = document.getElementById('statusChart').getContext('2d');
    const statusData = {!! json_encode($byStatus) !!};
    const statusColors = {
        'Lunas': '#22c55e',
        'Pending': '#f59e0b',
        'Gagal': '#ef4444'
    };

    new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: statusData.map(s => s.status),
            datasets: [{
                data: statusData.map(s => s.count),
                backgroundColor: statusData.map(s => statusColors[s.status] || '#94a3b8'),
                borderWidth: 0,
                hoverOffset: 8,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '70%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true,
                        pointStyle: 'circle',
                        font: { family: 'Inter', size: 12 }
                    }
                },
                tooltip: {
                    backgroundColor: '#1f2937',
                    titleFont: { family: 'Inter', size: 12 },
                    bodyFont: { family: 'Inter', size: 12 },
                    padding: 12,
                    cornerRadius: 10,
                }
            }
        }
    });
</script>
@endsection
