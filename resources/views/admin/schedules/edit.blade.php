@extends('layouts.app')

@section('title', 'Edit Jadwal - Pinto Air')
@section('page-title', 'Edit Jadwal')
@section('page-subtitle', 'Perbarui data jadwal penerbangan')

@section('content')
    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-sm mb-6 animate-fade-in">
        <a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-gray-900 ">Dashboard</a>
        <span class="text-gray-300">/</span>
        <span class="text-gray-900 font-medium">Edit Jadwal</span>
    </div>

    <div class="max-w-2xl mx-auto">
        <div class="glass-card p-8">
            {{-- Header --}}
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center">
                    <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Edit: {{ $schedule->plane_name }}</h3>
                    <p class="text-xs text-gray-500">Perbarui data jadwal penerbangan</p>
                </div>
            </div>

            <form action="/admin/schedules/update/{{ $schedule->id }}" method="POST" class="space-y-5">
                @csrf

                {{-- Nama Pesawat --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Pesawat</label>
                    <input type="text" name="plane_name" value="{{ $schedule->plane_name }}" required
                        class="input-admin">
                </div>

                {{-- Origin & Destination --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Asal (Origin)</label>
                        <input type="text" name="origin" value="{{ $schedule->origin }}" required
                            class="input-admin">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tujuan (Destination)</label>
                        <input type="text" name="destination" value="{{ $schedule->destination }}" required
                            class="input-admin">
                    </div>
                </div>

                {{-- Departure --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Waktu Keberangkatan</label>
                    <input type="datetime-local" name="departure"
                        value="{{ date('Y-m-d\TH:i', strtotime($schedule->departure)) }}" required min="{{ now()->format('Y-m-d\TH:i') }}"
                        class="input-admin @error('departure') border-red-500 @enderror">
                    @error('departure')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Price & Stock --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Harga per Tiket (Rp)</label>
                        <input type="number" name="price" value="{{ $schedule->price }}" required
                            class="input-admin">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Stok Kursi</label>
                        <input type="number" name="stock" value="{{ $schedule->stock }}" required
                            class="input-admin">
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
                    <button type="submit" class="btn-gradient inline-flex items-center gap-2 text-white font-semibold py-2.5 px-6 rounded-xl border-none cursor-pointer  ">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                        </svg>
                        Update Jadwal
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection