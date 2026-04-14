@extends('layouts.app')

@section('title', 'Detail Transaksi - Pinto Air')
@section('page-title', 'Detail Transaksi')
@section('page-subtitle', 'Informasi lengkap pesanan dan pembayaran')

@section('content')
    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-sm mb-6 animate-fade-in">
        <a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-gray-900 ">Dashboard</a>
        <span class="text-gray-300">/</span>
        <a href="{{ route('admin.transactions.index') }}" class="text-gray-400 hover:text-gray-900 ">Transaksi</a>
        <span class="text-gray-300">/</span>
        <span class="text-gray-900 font-medium">Detail #{{ $transaction->id }}</span>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Left: Flight & Transaction Info --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Status Banner --}}
            <div class="glass-card p-5
                @if($transaction->status === 'Lunas') border-green-200 bg-green-50/50
                @elseif($transaction->status === 'Gagal') border-red-200 bg-red-50/50
                @else border-amber-200 bg-amber-50/50
                @endif">
                <div class="flex items-center gap-4">
                    @if($transaction->status === 'Lunas')
                        <div class="w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-green-800">Pembayaran Dikonfirmasi</h3>
                            <p class="text-sm text-green-600">Transaksi telah berhasil dikonfirmasi dan lunas.</p>
                        </div>
                    @elseif($transaction->status === 'Gagal')
                        <div class="w-12 h-12 rounded-xl bg-red-100 flex items-center justify-center">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-red-800">Pembayaran Ditolak/Gagal</h3>
                            <p class="text-sm text-red-600">Transaksi dibatalkan. Stok kursi telah dikembalikan.</p>
                        </div>
                    @else
                        <div class="w-12 h-12 rounded-xl bg-amber-100 flex items-center justify-center">
                            <svg class="w-6 h-6 text-amber-600 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-amber-800">
                                @if($transaction->payment_proof)
                                    Menunggu Konfirmasi Admin
                                @else
                                    Menunggu Pembayaran Pelanggan
                                @endif
                            </h3>
                            <p class="text-sm text-amber-600">
                                @if($transaction->payment_proof)
                                    Pelanggan telah mengupload bukti pembayaran. Segera periksa dan konfirmasi.
                                @else
                                    Pelanggan belum mengupload bukti pembayaran.
                                @endif
                            </p>
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
                        <h3 class="text-lg font-bold text-gray-900">{{ $transaction->booking->schedule->plane_name }}</h3>
                        <p class="text-xs text-gray-500">Detail Penerbangan</p>
                    </div>
                </div>

                {{-- Visual Route --}}
                <div class="bg-gray-50 rounded-xl p-6 mb-5">
                    <div class="flex items-center justify-between">
                        <div class="text-center">
                            <p class="text-2xl font-bold text-gray-900">{{ Str::before($transaction->booking->schedule->origin, ' (') }}</p>
                            <p class="text-sm text-blue-600 font-medium mt-1">{{ Str::between($transaction->booking->schedule->origin, '(', ')') ?: $transaction->booking->schedule->origin }}</p>
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
                            <p class="text-2xl font-bold text-gray-900">{{ Str::before($transaction->booking->schedule->destination, ' (') }}</p>
                            <p class="text-sm text-amber-600 font-medium mt-1">{{ Str::between($transaction->booking->schedule->destination, '(', ')') ?: $transaction->booking->schedule->destination }}</p>
                        </div>
                    </div>
                </div>

                {{-- Details Grid --}}
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                    <div class="p-3 rounded-xl bg-gray-50 text-center">
                        <p class="text-[10px] text-gray-400 uppercase tracking-wider">Tanggal</p>
                        <p class="text-sm font-semibold text-gray-900 mt-1">{{ \Carbon\Carbon::parse($transaction->booking->schedule->departure)->format('d M Y') }}</p>
                    </div>
                    <div class="p-3 rounded-xl bg-gray-50 text-center">
                        <p class="text-[10px] text-gray-400 uppercase tracking-wider">Jam</p>
                        <p class="text-sm font-semibold text-gray-900 mt-1">{{ \Carbon\Carbon::parse($transaction->booking->schedule->departure)->format('H:i') }} WIB</p>
                    </div>
                    <div class="p-3 rounded-xl bg-gray-50 text-center">
                        <p class="text-[10px] text-gray-400 uppercase tracking-wider">Jumlah Kursi</p>
                        <p class="text-sm font-semibold text-gray-900 mt-1">{{ $transaction->booking->total_seats }} Kursi</p>
                    </div>
                    <div class="p-3 rounded-xl bg-gray-50 text-center">
                        <p class="text-[10px] text-gray-400 uppercase tracking-wider">Total Harga</p>
                        <p class="text-sm font-semibold text-accent-500 mt-1">Rp {{ number_format($transaction->amount) }}</p>
                    </div>
                </div>
            </div>

            {{-- Uploaded Payment Proof --}}
            @if($transaction->payment_proof)
                <div class="glass-card p-6">
                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-10 h-10 rounded-xl bg-green-50 flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900">Bukti Pembayaran</h3>
                            <p class="text-xs text-gray-500">Metode: {{ $transaction->payment_method }}</p>
                        </div>
                    </div>
                    <div class="rounded-xl overflow-hidden border border-gray-200 bg-gray-50 flex justify-center">
                        <img src="{{ asset('storage/' . $transaction->payment_proof) }}" 
                             alt="Bukti Pembayaran" 
                             class="max-w-full max-h-[500px] object-contain">
                    </div>
                </div>
            @endif
        </div>

        {{-- Right: Summary & Customer Info --}}
        <div class="lg:col-span-1 space-y-6">
            <div class="glass-card p-6">
                <h4 class="text-lg font-bold text-gray-900 mb-1">Informasi Pemesan</h4>
                <p class="text-xs text-gray-500 mb-5">Detail kontak pelanggan</p>

                <div class="flex items-center gap-4 py-2">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-600 to-blue-800 flex items-center justify-center text-white text-lg font-bold shrink-0">
                        {{ strtoupper(substr($transaction->booking->user->name, 0, 1)) }}
                    </div>
                    <div>
                        <span class="text-gray-900 font-medium block">{{ $transaction->booking->user->name }}</span>
                        <p class="text-sm text-gray-500">{{ $transaction->booking->user->email }}</p>
                    </div>
                </div>
            </div>

            <div class="glass-card p-6">
                <h4 class="text-lg font-bold text-gray-900 mb-1">Ringkasan Transaksi</h4>
                <p class="text-xs text-gray-500 mb-5">ID: #{{ $transaction->id }}</p>

                <div class="space-y-4">
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="text-sm text-gray-500">Waktu Order</span>
                        <span class="text-sm font-medium text-gray-900">{{ $transaction->created_at->format('d M Y, H:i') }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="text-sm text-gray-500">Metode Bayar</span>
                        <span class="text-sm font-medium text-gray-900">{{ $transaction->payment_method ?? 'Belum dipilih' }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="text-sm text-gray-500">Jumlah Kursi</span>
                        <span class="text-sm font-medium text-gray-900">{{ $transaction->booking->total_seats }} Kursi</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="text-sm text-gray-500">Status</span>
                        @if($transaction->status === 'Lunas')
                            <span class="badge badge-success">{{ $transaction->status }}</span>
                        @elseif($transaction->status === 'Gagal')
                            <span class="badge badge-danger">{{ $transaction->status }}</span>
                        @else
                            <span class="badge badge-warning">{{ $transaction->status }}</span>
                        @endif
                    </div>
                    <div class="flex justify-between items-center pt-3">
                        <span class="text-sm font-semibold text-gray-900">Total Nominal</span>
                        <span class="text-xl font-bold text-accent-500">Rp {{ number_format($transaction->amount) }}</span>
                    </div>
                </div>

                @if($transaction->status === 'Pending')
                    <div class="mt-6 flex flex-col gap-3">
                        <form action="{{ route('admin.transactions.confirm', $transaction->id) }}" method="POST" class="w-full">
                            @csrf
                            <button type="button" onclick="confirmAction(event, this.closest('form'), 'Konfirmasi Transaksi #{{ $transaction->id }}?', 'Menyetujui transaksi ini akan mengubah statusnya menjadi Lunas.', 'success')" class="btn-gradient w-full text-center font-semibold py-3 rounded-xl text-white inline-flex items-center justify-center gap-2 no-underline border-none hover:transform hover:-translate-y-0.5 cursor-pointer">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Konfirmasi Pembayaran
                            </button>
                        </form>
                        
                        <form action="{{ route('admin.transactions.reject', $transaction->id) }}" method="POST" class="w-full">
                            @csrf
                            <button type="button" onclick="confirmAction(event, this.closest('form'), 'Tolak Transaksi #{{ $transaction->id }}?', 'Stok kursi dari pemesanan ini akan segera dikembalikan.', 'warning')" class="w-full py-3 rounded-xl text-red-600 font-semibold bg-red-50 hover:bg-red-100 transition-colors inline-flex items-center justify-center gap-2 border-none cursor-pointer">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                Tolak Pembayaran
                            </button>
                        </form>
                    </div>
                @endif
                
                <div class="mt-4">
                    <a href="{{ route('admin.transactions.index') }}" class="w-full py-3 rounded-xl text-gray-600 font-semibold bg-gray-50 hover:bg-gray-100 transition-colors inline-flex items-center justify-center gap-2 border border-gray-200 no-underline text-center">
                        Batal / Kembali
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
