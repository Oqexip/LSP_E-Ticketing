@extends('layouts.app')

@section('title', 'Konfirmasi Transaksi - E-Ticketing Easy')
@section('page-title', 'Konfirmasi Transaksi')
@section('page-subtitle', 'Kelola dan konfirmasi pembayaran pelanggan')

@section('content')
    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
        <div class="glass-card p-5 animate-fade-in-up stagger-1">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wider">Pending</p>
                    <p class="text-3xl font-bold text-amber-500 mt-1">{{ $transactions->where('status', 'Pending')->count() }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-amber-50 flex items-center justify-center">
                    <svg class="w-6 h-6 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>
        <div class="glass-card p-5 animate-fade-in-up stagger-2">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wider">Lunas</p>
                    <p class="text-3xl font-bold text-green-500 mt-1">{{ $transactions->where('status', 'Lunas')->count() }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-green-50 flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>
        <div class="glass-card p-5 animate-fade-in-up stagger-3">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wider">Gagal</p>
                    <p class="text-3xl font-bold text-red-500 mt-1">{{ $transactions->where('status', 'Gagal')->count() }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-red-50 flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Transactions Table --}}
    <div class="glass-card overflow-hidden animate-fade-in-up stagger-4">
        <div class="flex items-center justify-between p-5 border-b border-gray-100">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-green-50 flex items-center justify-center">
                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-gray-900 font-semibold">Daftar Transaksi</h3>
                    <p class="text-xs text-gray-500">{{ $transactions->count() }} transaksi</p>
                </div>
            </div>
        </div>

        @if($transactions->isEmpty())
            <div class="p-12 text-center">
                <div class="mb-4 flex justify-center">
                    <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <p class="text-gray-500">Belum ada transaksi.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="table-modern">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Pemesan</th>
                            <th>Penerbangan</th>
                            <th>Jumlah</th>
                            <th>Metode</th>
                            <th>Bukti</th>
                            <th>Status</th>
                            <th>Waktu</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactions as $t)
                            <tr>
                                <td>
                                    <span class="text-xs font-mono text-gray-500">#{{ $t->id }}</span>
                                </td>
                                <td>
                                    <div class="flex items-center gap-2">
                                        <div class="w-7 h-7 rounded-full bg-gradient-to-br from-gray-700 to-gray-900 flex items-center justify-center text-white text-[10px] font-bold shrink-0">
                                            {{ strtoupper(substr($t->booking->user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <span class="text-gray-900 font-medium">{{ $t->booking->user->name }}</span>
                                            <p class="text-xs text-gray-400">{{ $t->booking->user->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <p class="text-gray-900 font-medium">{{ $t->booking->schedule->plane_name }}</p>
                                        <div class="flex items-center gap-1 mt-0.5">
                                            <span class="text-xs text-gray-400">{{ Str::before($t->booking->schedule->origin, ' (') }}</span>
                                            <svg class="w-3 h-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                            </svg>
                                            <span class="text-xs text-gray-400">{{ Str::before($t->booking->schedule->destination, ' (') }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <p class="font-medium text-accent-500">Rp {{ number_format($t->amount) }}</p>
                                        <p class="text-xs text-gray-400">{{ $t->booking->total_seats }} kursi</p>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-sm text-gray-700">{{ $t->payment_method ?? '-' }}</span>
                                </td>
                                <td>
                                    @if($t->payment_proof)
                                        <button onclick="showProof('{{ asset('storage/' . $t->payment_proof) }}')"
                                            class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg bg-blue-50 text-blue-600 text-xs font-medium hover:bg-blue-100 transition-colors cursor-pointer border-none">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                            Lihat
                                        </button>
                                    @else
                                        <span class="text-xs text-gray-400">Belum upload</span>
                                    @endif
                                </td>
                                <td>
                                    @if($t->status === 'Lunas')
                                        <span class="badge badge-success">{{ $t->status }}</span>
                                    @elseif($t->status === 'Pending')
                                        <span class="badge badge-warning">{{ $t->status }}</span>
                                    @else
                                        <span class="badge badge-danger">{{ $t->status }}</span>
                                    @endif
                                </td>
                                <td>
                                    <div>
                                        <p class="text-gray-700">{{ $t->created_at->format('d/m/Y') }}</p>
                                        <p class="text-xs text-gray-400">{{ $t->created_at->format('H:i') }}</p>
                                    </div>
                                </td>
                                <td>
                                    @if($t->status === 'Pending' && $t->payment_proof)
                                        <div class="flex items-center justify-center gap-2">
                                            <form action="{{ route('admin.transactions.confirm', $t->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" onclick="return confirm('Konfirmasi transaksi #{{ $t->id }}?')"
                                                    class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-green-50 text-green-600 text-xs font-medium hover:bg-green-100 transition-colors cursor-pointer border-none">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                    </svg>
                                                    Konfirmasi
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.transactions.reject', $t->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" onclick="return confirm('Tolak transaksi #{{ $t->id }}? Stok kursi akan dikembalikan.')"
                                                    class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-red-50 text-red-600 text-xs font-medium hover:bg-red-100 transition-colors cursor-pointer border-none">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                    </svg>
                                                    Tolak
                                                </button>
                                            </form>
                                        </div>
                                    @elseif($t->status === 'Pending' && !$t->payment_proof)
                                        <span class="text-xs text-gray-400 italic">Belum bayar</span>
                                    @else
                                        <span class="text-xs text-gray-400">—</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    {{-- Image Preview Modal --}}
    <div id="proof-modal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/60 backdrop-blur-sm" onclick="closeProof()">
        <div class="relative max-w-2xl w-full mx-4 animate-fade-in-up" onclick="event.stopPropagation()">
            <button onclick="closeProof()" class="absolute -top-3 -right-3 w-8 h-8 bg-white rounded-full shadow-lg flex items-center justify-center text-gray-500 hover:text-gray-900 transition-colors cursor-pointer border-none z-10">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
            <div class="bg-white rounded-2xl overflow-hidden shadow-2xl">
                <div class="p-4 border-b border-gray-100">
                    <h4 class="font-semibold text-gray-900">Bukti Pembayaran</h4>
                </div>
                <div class="p-4 bg-gray-50">
                    <img id="proof-image" src="" alt="Bukti Pembayaran" class="w-full max-h-[70vh] object-contain rounded-xl">
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    function showProof(url) {
        const modal = document.getElementById('proof-modal');
        const image = document.getElementById('proof-image');
        image.src = url;
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeProof() {
        const modal = document.getElementById('proof-modal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    // Close modal on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeProof();
    });
</script>
@endsection
