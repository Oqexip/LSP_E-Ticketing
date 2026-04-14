@extends('layouts.app')

@section('title', 'Detail Transaksi - Pinto Air')
@section('page-title', 'Detail Transaksi')
@section('page-subtitle', 'Informasi lengkap pesanan pelanggan')

@section('content')
    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-sm mb-6 animate-fade-in">
        <a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-gray-900">Dashboard</a>
        <span class="text-gray-300">/</span>
        <a href="{{ route('admin.bookings.index') }}" class="text-gray-400 hover:text-gray-900">Semua Transaksi</a>
        <span class="text-gray-300">/</span>
        <span class="text-gray-900 font-medium">Detail #{{ $booking->id }}</span>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Left: Flight & Booking Info --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Status Banner --}}
            <div class="glass-card p-5
                @if($booking->status === 'Lunas') border-green-200 bg-green-50/50
                @elseif($booking->status === 'Gagal') border-red-200 bg-red-50/50
                @else border-amber-200 bg-amber-50/50
                @endif">
                <div class="flex items-center gap-4">
                    @if($booking->status === 'Lunas')
                        <div class="w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-green-800">Pembayaran Lunas</h3>
                            <p class="text-sm text-green-600">Pemesanan telah dikonfirmasi dan pembayaran diterima.</p>
                        </div>
                    @elseif($booking->status === 'Gagal')
                        <div class="w-12 h-12 rounded-xl bg-red-100 flex items-center justify-center">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-red-800">Pemesanan Dibatalkan / Gagal</h3>
                            <p class="text-sm text-red-600">Stok kursi telah dikembalikan.</p>
                        </div>
                    @else
                        <div class="w-12 h-12 rounded-xl bg-amber-100 flex items-center justify-center">
                            <svg class="w-6 h-6 text-amber-600 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-amber-800">Menunggu Pembayaran</h3>
                            <p class="text-sm text-amber-600">Pelanggan belum menyelesaikan pembayaran.</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Flight Info Card --}}
            <div class="glass-card p-6">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">{{ $booking->schedule->plane_name }}</h3>
                        <p class="text-xs text-gray-500">Detail Penerbangan</p>
                    </div>
                </div>

                {{-- Visual Route --}}
                <div class="bg-gray-50 rounded-xl p-6 mb-5">
                    <div class="flex items-center justify-between">
                        <div class="text-center">
                            <p class="text-2xl font-bold text-gray-900">{{ Str::before($booking->schedule->origin, ' (') }}</p>
                            <p class="text-sm text-blue-600 font-medium mt-1">{{ Str::between($booking->schedule->origin, '(', ')') ?: $booking->schedule->origin }}</p>
                        </div>

                        <div class="flex-1 mx-6">
                            <div class="flex items-center">
                                <div class="w-3 h-3 rounded-full bg-blue-500 border-2 border-blue-200"></div>
                                <div class="flex-1 h-[2px] bg-gradient-to-r from-blue-400 via-gray-300 to-amber-400 relative">
                                    <svg class="absolute left-1/2 -translate-x-1/2 -top-2.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                    </svg>
                                </div>
                                <div class="w-3 h-3 rounded-full bg-amber-500 border-2 border-amber-200"></div>
                            </div>
                            <p class="text-center text-[10px] text-gray-400 mt-2 uppercase tracking-widest">Langsung</p>
                        </div>

                        <div class="text-center">
                            <p class="text-2xl font-bold text-gray-900">{{ Str::before($booking->schedule->destination, ' (') }}</p>
                            <p class="text-sm text-amber-600 font-medium mt-1">{{ Str::between($booking->schedule->destination, '(', ')') ?: $booking->schedule->destination }}</p>
                        </div>
                    </div>
                </div>

                {{-- Details Grid --}}
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                    <div class="p-3 rounded-xl bg-gray-50 text-center">
                        <p class="text-[10px] text-gray-400 uppercase tracking-wider">Tanggal</p>
                        <p class="text-sm font-semibold text-gray-900 mt-1">{{ \Carbon\Carbon::parse($booking->schedule->departure)->format('d M Y') }}</p>
                    </div>
                    <div class="p-3 rounded-xl bg-gray-50 text-center">
                        <p class="text-[10px] text-gray-400 uppercase tracking-wider">Jam</p>
                        <p class="text-sm font-semibold text-gray-900 mt-1">{{ \Carbon\Carbon::parse($booking->schedule->departure)->format('H:i') }} WIB</p>
                    </div>
                    <div class="p-3 rounded-xl bg-gray-50 text-center">
                        <p class="text-[10px] text-gray-400 uppercase tracking-wider">Jumlah Kursi</p>
                        <p class="text-sm font-semibold text-gray-900 mt-1">{{ $booking->total_seats }} Kursi</p>
                    </div>
                    <div class="p-3 rounded-xl bg-gray-50 text-center">
                        <p class="text-[10px] text-gray-400 uppercase tracking-wider">Total Harga</p>
                        <p class="text-sm font-semibold text-accent-500 mt-1">Rp {{ number_format($booking->total_price) }}</p>
                    </div>
                </div>
            </div>

            {{-- Payment Proof (if exists via transaction) --}}
            @if($booking->transaction && $booking->transaction->payment_proof)
                <div class="glass-card p-6">
                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-10 h-10 rounded-xl bg-green-50 flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900">Bukti Pembayaran</h3>
                            <p class="text-xs text-gray-500">Metode: {{ $booking->transaction->payment_method }}</p>
                        </div>
                    </div>
                    <div class="rounded-xl overflow-hidden border border-gray-200 bg-gray-50 flex justify-center">
                        <img src="{{ asset('storage/' . $booking->transaction->payment_proof) }}"
                             alt="Bukti Pembayaran"
                             class="max-w-full max-h-[500px] object-contain">
                    </div>
                </div>
            @endif
        </div>

        {{-- Right: Customer Info & Summary --}}
        <div class="lg:col-span-1 space-y-6">
            {{-- Customer Info --}}
            <div class="glass-card p-6">
                <h4 class="text-lg font-bold text-gray-900 mb-1">Informasi Pemesan</h4>
                <p class="text-xs text-gray-500 mb-5">Detail kontak pelanggan</p>

                <div class="flex items-center gap-4 py-2">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-600 to-blue-800 flex items-center justify-center text-white text-lg font-bold shrink-0">
                        {{ strtoupper(substr($booking->user->name, 0, 1)) }}
                    </div>
                    <div>
                        <span class="text-gray-900 font-medium block">{{ $booking->user->name }}</span>
                        <p class="text-sm text-gray-500">{{ $booking->user->email }}</p>
                    </div>
                </div>
            </div>

            {{-- Booking Summary --}}
            <div class="glass-card p-6">
                <h4 class="text-lg font-bold text-gray-900 mb-1">Ringkasan Pemesanan</h4>
                <p class="text-xs text-gray-500 mb-5">ID Booking: #{{ $booking->id }}</p>

                <div class="space-y-4">
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="text-sm text-gray-500">Waktu Pesan</span>
                        <span class="text-sm font-medium text-gray-900">{{ $booking->created_at->format('d M Y, H:i') }}</span>
                    </div>
                    @if($booking->transaction)
                        <div class="flex justify-between items-center py-2 border-b border-gray-100">
                            <span class="text-sm text-gray-500">ID Transaksi</span>
                            <span class="text-sm font-mono font-medium text-gray-900">#{{ $booking->transaction->id }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-gray-100">
                            <span class="text-sm text-gray-500">Metode Bayar</span>
                            <span class="text-sm font-medium text-gray-900">{{ $booking->transaction->payment_method ?? 'Belum dipilih' }}</span>
                        </div>
                    @endif
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="text-sm text-gray-500">Jumlah Kursi</span>
                        <span class="text-sm font-medium text-gray-900">{{ $booking->total_seats }} Kursi</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="text-sm text-gray-500">Status</span>
                        @if($booking->status === 'Lunas')
                            <span class="badge badge-success">{{ $booking->status }}</span>
                        @elseif($booking->status === 'Gagal')
                            <span class="badge badge-danger">{{ $booking->status }}</span>
                        @else
                            <span class="badge badge-warning">{{ $booking->status }}</span>
                        @endif
                    </div>
                    <div class="flex justify-between items-center pt-3">
                        <span class="text-sm font-semibold text-gray-900">Total Bayar</span>
                        <span class="text-xl font-bold text-accent-500">Rp {{ number_format($booking->total_price) }}</span>
                    </div>
                </div>

                <div class="mt-6">
                    <a href="{{ route('admin.bookings.index') }}" class="w-full py-3 rounded-xl text-gray-600 font-semibold bg-gray-50 hover:bg-gray-100 transition-colors inline-flex items-center justify-center gap-2 border border-gray-200 no-underline text-center">
                        Kembali ke Daftar
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    function confirmAction(e, form, title, text, icon) {
        e.preventDefault();
        Swal.fire({
            title: title,
            text: text,
            icon: icon,
            showCancelButton: true,
            confirmButtonColor: icon === 'warning' ? '#d33' : '#3085d6',
            cancelButtonColor: '#aaa',
            confirmButtonText: 'Ya, Lanjutkan',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    }
</script>
@endsection
