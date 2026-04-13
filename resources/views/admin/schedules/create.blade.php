@extends('layouts.app')

@section('title', 'Tambah Jadwal - E-Ticketing Easy')
@section('page-title', 'Tambah Jadwal Baru')
@section('page-subtitle', 'Buat jadwal penerbangan baru')

@section('content')
    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-sm mb-6 animate-fade-in">
        <a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-gray-900 ">Dashboard</a>
        <span class="text-gray-300">/</span>
        <span class="text-gray-900 font-medium">Tambah Jadwal Baru</span>
    </div>

    <div class="max-w-2xl mx-auto">
        <div class="glass-card p-8">
            {{-- Header --}}
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Detail Penerbangan</h3>
                    <p class="text-xs text-gray-500">Isi data jadwal penerbangan</p>
                </div>
            </div>

            <form action="/admin/schedules/store" method="POST" class="space-y-5">
                @csrf

                {{-- Nama Pesawat --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Pesawat</label>
                    <input type="text" name="plane_name" placeholder="Contoh: Garuda Indonesia GA-123" required
                        class="input-admin" value="{{ old('plane_name') }}">
                </div>

                {{-- Origin & Destination --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Asal (Origin)</label>
                        <input type="text" name="origin" placeholder="Contoh: Jakarta (CGK)" required
                            class="input-admin" value="{{ old('origin') }}">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tujuan (Destination)</label>
                        <input type="text" name="destination" placeholder="Contoh: Bali (DPS)" required
                            class="input-admin" value="{{ old('destination') }}">
                    </div>
                </div>

                {{-- Departure --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Waktu Keberangkatan</label>
                    <input type="datetime-local" name="departure" required
                        class="input-admin" value="{{ old('departure') }}">
                </div>

                {{-- Price & Stock --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Harga per Tiket (Rp)</label>
                        <input type="number" name="price" placeholder="Contoh: 1500000" required
                            class="input-admin" value="{{ old('price') }}">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Stok Kursi</label>
                        <input type="number" name="stock" placeholder="Contoh: 50" required
                            class="input-admin" value="{{ old('stock') }}">
                    </div>
                </div>

                {{-- Actions --}}
                <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                    <a href="{{ route('dashboard') }}" class="text-sm text-gray-400 hover:text-gray-900  flex items-center gap-1.5 no-underline">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Kembali
                    </a>
                    <button type="submit" class="btn-gradient-green inline-flex items-center gap-2 text-white font-semibold py-2.5 px-6 rounded-xl border-none cursor-pointer  ">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Simpan Jadwal
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection