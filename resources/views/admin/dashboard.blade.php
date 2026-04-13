@extends('layouts.app')

@section('title', 'Admin Dashboard - E-Ticketing Easy')
@section('page-title', 'Dashboard Admin')
@section('page-subtitle', 'Kelola jadwal dan pantau transaksi')

@section('content')
    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        {{-- Total Jadwal --}}
        <div class="glass-card p-5">
            <div class="flex items-center justify-between gap-3">
                <div class="min-w-0">
                    <p class="text-xs text-gray-500 uppercase tracking-wider">Total Jadwal</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $schedules->count() }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Total Booking --}}
        <div class="glass-card p-5">
            <div class="flex items-center justify-between gap-3">
                <div class="min-w-0">
                    <p class="text-xs text-gray-500 uppercase tracking-wider">Total Booking</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $bookings->count() }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-green-50 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Total Revenue --}}
        <div class="glass-card p-5" title="Rp {{ number_format($bookings->where('status', 'Lunas')->sum('total_price')) }}">
            <div class="flex items-center justify-between gap-3">
                <div class="min-w-0">
                    <p class="text-xs text-gray-500 uppercase tracking-wider">Total Revenue</p>
                    <p class="text-lg font-bold text-accent-500 mt-1 truncate">Rp {{ number_format($bookings->where('status', 'Lunas')->sum('total_price')) }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-amber-50 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Total Kursi Terjual --}}
        <div class="glass-card p-5">
            <div class="flex items-center justify-between gap-3">
                <div class="min-w-0">
                    <p class="text-xs text-gray-500 uppercase tracking-wider">Kursi Terjual</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $bookings->where('status', 'Lunas')->sum('total_seats') }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-purple-50 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Section 1: Jadwal Pesawat --}}
    <div class="glass-card overflow-hidden mb-8">
        <div class="flex items-center justify-between p-5 border-b border-gray-100">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center">
                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-gray-900 font-semibold">Daftar Jadwal Penerbangan</h3>
                    <p class="text-xs text-gray-500">{{ $schedules->count() }} jadwal aktif</p>
                </div>
            </div>
            <a href="/admin/schedules/create" class="btn-gradient !py-2 !px-4 text-sm inline-flex items-center gap-1.5 no-underline">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Jadwal
            </a>
        </div>

        @if($schedules->isEmpty())
            <div class="p-8 text-center">
                <p class="text-gray-500">Belum ada jadwal penerbangan.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="table-modern">
                    <thead>
                        <tr>
                            <th>Pesawat</th>
                            <th>Rute</th>
                            <th>Keberangkatan</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($schedules as $s)
                            <tr>
                                <td>
                                    <div class="flex items-center gap-2">
                                        <div class="w-7 h-7 rounded-lg bg-blue-50 flex items-center justify-center shrink-0">
                                            <svg class="w-3.5 h-3.5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                            </svg>
                                        </div>
                                        <span class="font-medium text-gray-900">{{ $s->plane_name }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="flex items-center gap-1.5">
                                        <span>{{ Str::before($s->origin, ' (') }}</span>
                                        <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                        </svg>
                                        <span>{{ Str::before($s->destination, ' (') }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <p class="text-gray-700">{{ \Carbon\Carbon::parse($s->departure)->format('d M Y') }}</p>
                                        <p class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($s->departure)->format('H:i') }} WIB</p>
                                    </div>
                                </td>
                                <td class="font-medium text-accent-500 whitespace-nowrap">Rp {{ number_format($s->price) }}</td>
                                <td>
                                    @if($s->stock > 20)
                                        <span class="badge badge-success">{{ $s->stock }}</span>
                                    @elseif($s->stock > 5)
                                        <span class="badge badge-warning">{{ $s->stock }}</span>
                                    @else
                                        <span class="badge badge-danger">{{ $s->stock }}</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="/admin/schedules/edit/{{ $s->id }}"
                                            class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-blue-50 text-blue-600 text-xs font-medium hover:bg-blue-100  no-underline">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                            Edit
                                        </a>
                                        <a href="/admin/schedules/delete/{{ $s->id }}"
                                            onclick="return confirm('Hapus jadwal {{ $s->plane_name }}?')"
                                            class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-red-50 text-red-600 text-xs font-medium hover:bg-red-100  no-underline">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            Hapus
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-5 pb-5 mt-4">
                {{ $schedules->appends(request()->except('sched_page'))->links() }}
            </div>
        @endif
    </div>

    {{-- Section 2: Konfirmasi Transaksi --}}
    <div class="glass-card overflow-hidden mb-8">
        <div class="flex items-center justify-between p-5 border-b border-gray-100">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-amber-50 flex items-center justify-center">
                    <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-gray-900 font-semibold">Menunggu Konfirmasi</h3>
                    <p class="text-xs text-gray-500">{{ $pendingTransactions->count() }} transaksi perlu dikonfirmasi</p>
                </div>
            </div>
            <a href="{{ route('admin.transactions.index') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium no-underline inline-flex items-center gap-1">
                Lihat Semua
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                </svg>
            </a>
        </div>

        @if($pendingTransactions->isEmpty())
            <div class="p-8 text-center">
                <div class="mb-3 flex justify-center">
                    <svg class="w-12 h-12 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <p class="text-gray-500">Tidak ada transaksi yang menunggu konfirmasi.</p>
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
                            <th>Waktu</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pendingTransactions as $t)
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
                                    <button onclick="showProof('{{ asset('storage/' . $t->payment_proof) }}')"
                                        class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg bg-blue-50 text-blue-600 text-xs font-medium hover:bg-blue-100 cursor-pointer border-none">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        Lihat
                                    </button>
                                </td>
                                <td>
                                    <div>
                                        <p class="text-gray-700">{{ $t->created_at->format('d/m/Y') }}</p>
                                        <p class="text-xs text-gray-400">{{ $t->created_at->format('H:i') }}</p>
                                    </div>
                                </td>
                                <td>
                                    <div class="flex items-center justify-center gap-2">
                                        <form action="{{ route('admin.transactions.confirm', $t->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="button" onclick="confirmAction(event, this.closest('form'), 'Konfirmasi Transaksi #{{ $t->id }}?', 'Menyetujui transaksi ini akan mengubah statusnya menjadi Lunas.', 'success')"
                                                class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-green-50 text-green-600 text-xs font-medium hover:bg-green-100 cursor-pointer border-none">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                </svg>
                                                Konfirmasi
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.transactions.reject', $t->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="button" onclick="confirmAction(event, this.closest('form'), 'Tolak Transaksi #{{ $t->id }}?', 'Stok kursi dari pemesanan ini akan segera dikembalikan.', 'warning')"
                                                class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-red-50 text-red-600 text-xs font-medium hover:bg-red-100 cursor-pointer border-none">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                                Tolak
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-5 pb-5 mt-4">
                {{ $pendingTransactions->appends(request()->except('pend_page'))->links() }}
            </div>
        @endif
    </div>

    {{-- Section 3: Riwayat Transaksi --}}
    <div class="glass-card overflow-hidden">
        <div class="flex items-center justify-between p-5 border-b border-gray-100">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-green-50 flex items-center justify-center">
                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-gray-900 font-semibold">Riwayat Transaksi</h3>
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
                {{ $bookings->appends(request()->except('book_page'))->links() }}
            </div>
        @endif
    </div>

    {{-- Image Preview Modal --}}
    <div id="proof-modal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/60 backdrop-blur-sm" onclick="closeProof()">
        <div class="relative max-w-2xl w-full mx-4" onclick="event.stopPropagation()">
            <button onclick="closeProof()" class="absolute -top-3 -right-3 w-8 h-8 bg-white rounded-full shadow-lg flex items-center justify-center text-gray-500 hover:text-gray-900 cursor-pointer border-none z-10">
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

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeProof();
    });

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
