@extends('layouts.app')

@section('title', 'Booking - E-Ticketing Easy')
@section('page-title', 'Konfirmasi Pemesanan')
@section('page-subtitle', 'Periksa dan konfirmasi detail pesanan Anda')

@section('content')
    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-sm mb-6 animate-fade-in">
        <a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-gray-900 ">Dashboard</a>
        <span class="text-gray-300">/</span>
        <span class="text-gray-900 font-medium">Konfirmasi Pemesanan</span>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Flight Detail Card (Left / Top) --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Flight Info Card --}}
            <div class="glass-card p-6">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">{{ $schedule->plane_name }}</h3>
                        <p class="text-xs text-gray-500">Detail Penerbangan</p>
                    </div>
                </div>

                {{-- Visual Route --}}
                <div class="bg-gray-50 rounded-xl p-6 mb-5">
                    <div class="flex items-center justify-between">
                        <div class="text-center">
                            <p class="text-2xl font-bold text-gray-900">{{ Str::before($schedule->origin, ' (') }}</p>
                            <p class="text-sm text-blue-600 font-medium mt-1">{{ Str::between($schedule->origin, '(', ')') ?: $schedule->origin }}</p>
                            <p class="text-xs text-gray-400 mt-2">Keberangkatan</p>
                            <p class="text-sm text-gray-900 font-semibold">{{ \Carbon\Carbon::parse($schedule->departure)->format('H:i') }}</p>
                        </div>

                        <div class="flex-1 mx-6">
                            <div class="flex items-center">
                                <div class="w-3 h-3 rounded-full bg-blue-500 border-2 border-blue-200"></div>
                                <div class="flex-1 h-[2px] bg-gradient-to-r from-blue-400 via-gray-300 to-amber-400 relative">
                                    <svg class="absolute left-1/2 -translate-x-1/2 -top-2.5 w-5 h-5 text-gray-400 animate-plane-fly" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                    </svg>
                                </div>
                                <div class="w-3 h-3 rounded-full bg-amber-500 border-2 border-amber-200"></div>
                            </div>
                            <p class="text-center text-[10px] text-gray-400 mt-2 uppercase tracking-widest">Langsung</p>
                        </div>

                        <div class="text-center">
                            <p class="text-2xl font-bold text-gray-900">{{ Str::before($schedule->destination, ' (') }}</p>
                            <p class="text-sm text-amber-600 font-medium mt-1">{{ Str::between($schedule->destination, '(', ')') ?: $schedule->destination }}</p>
                            <p class="text-xs text-gray-400 mt-2">Tujuan</p>
                            <p class="text-sm text-gray-900 font-semibold">—</p>
                        </div>
                    </div>
                </div>

                {{-- Flight Details Grid --}}
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                    <div class="p-3 rounded-xl bg-gray-50 text-center">
                        <p class="text-[10px] text-gray-400 uppercase tracking-wider">Tanggal</p>
                        <p class="text-sm font-semibold text-gray-900 mt-1">{{ \Carbon\Carbon::parse($schedule->departure)->format('d M Y') }}</p>
                    </div>
                    <div class="p-3 rounded-xl bg-gray-50 text-center">
                        <p class="text-[10px] text-gray-400 uppercase tracking-wider">Jam</p>
                        <p class="text-sm font-semibold text-gray-900 mt-1">{{ \Carbon\Carbon::parse($schedule->departure)->format('H:i') }} WIB</p>
                    </div>
                    <div class="p-3 rounded-xl bg-gray-50 text-center">
                        <p class="text-[10px] text-gray-400 uppercase tracking-wider">Harga/Kursi</p>
                        <p class="text-sm font-semibold text-accent-500 mt-1">Rp {{ number_format($schedule->price) }}</p>
                    </div>
                    <div class="p-3 rounded-xl bg-gray-50 text-center">
                        <p class="text-[10px] text-gray-400 uppercase tracking-wider">Stok</p>
                        <p class="text-sm font-semibold mt-1">
                            <span class="@if($schedule->stock > 20) text-green-500 @elseif($schedule->stock > 5) text-yellow-500 @else text-red-500 @endif">
                                {{ $schedule->stock }} Kursi
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Booking Form Card (Right / Bottom) --}}
        <div class="lg:col-span-1">
            <div class="glass-card p-6 sticky top-24">
                <h4 class="text-lg font-bold text-gray-900 mb-1">Formulir Pemesanan</h4>
                <p class="text-xs text-gray-500 mb-5">Tentukan jumlah kursi yang ingin dipesan</p>

                <form action="/booking/{{ $schedule->id }}" method="POST" class="space-y-5">
                    @csrf

                    {{-- Seat Input --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah Kursi</label>
                        <input type="number" name="total_seats" min="1" max="{{ $schedule->stock }}" required
                            id="input_kursi" value="1"
                            class="input-admin text-center text-lg font-bold w-full">
                        <p class="text-xs text-gray-400 mt-1.5">Maksimal {{ $schedule->stock }} kursi</p>
                    </div>

                    {{-- Price Summary --}}
                    <div class="bg-gray-50 rounded-xl p-4 space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500">Harga per kursi</span>
                            <span class="text-sm text-gray-700">Rp {{ number_format($schedule->price) }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500">Jumlah kursi</span>
                            <span class="text-sm text-gray-700" id="display_seats">1</span>
                        </div>
                        <div class="border-t border-gray-200 pt-3 flex justify-between items-center">
                            <span class="text-sm font-semibold text-gray-900">Total Harga</span>
                            <span class="text-xl font-bold text-accent-500" id="total_harga">Rp {{ number_format($schedule->price) }}</span>
                        </div>
                    </div>

                    {{-- Submit --}}
                    <button type="submit" class="btn-gradient-amber w-full text-center font-semibold py-3 rounded-xl text-white cursor-pointer border-none flex items-center justify-center gap-2   hover:transform hover:-translate-y-0.5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Konfirmasi & Pesan Sekarang
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    const inputKursi = document.getElementById('input_kursi');
    const displayTotal = document.getElementById('total_harga');
    const displaySeats = document.getElementById('display_seats');
    const hargaSatuan = {{ $schedule->price }};

    inputKursi.addEventListener('input', function() {
        const jumlah = parseInt(inputKursi.value) || 0;
        const total = jumlah * hargaSatuan;

        displaySeats.innerText = jumlah;
        displayTotal.innerText = "Rp " + total.toLocaleString('id-ID');
    });
</script>
@endsection