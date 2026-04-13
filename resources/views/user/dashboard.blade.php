@extends('layouts.app')

@section('title', 'Dashboard - E-Ticketing Easy')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Temukan penerbangan terbaik untuk Anda')

@section('content')
    {{-- Welcome Banner --}}
    <div class="glass-card p-6 mb-8">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h3 class="text-xl font-bold text-gray-900">
                    Halo, {{ Auth::user()->name }}!
                </h3>
                <p class="text-gray-500 mt-1">Siap untuk petualangan berikutnya? Pilih penerbangan di bawah ini.</p>
            </div>
            <div class="flex items-center gap-3">
                <div class="text-center px-4 py-2 rounded-xl bg-blue-50 border border-blue-100">
                    <p class="text-2xl font-bold text-blue-600">{{ $schedules->count() }}</p>
                    <p class="text-[10px] text-gray-500 uppercase tracking-wider">Penerbangan</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Flight Cards --}}
    @if($schedules->isEmpty())
        <div class="glass-card p-12 text-center stagger-2">
            <div class="mb-4 flex justify-center">
                <svg class="w-16 h-16 text-gray-300 animate-float" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum Ada Penerbangan</h3>
            <p class="text-gray-500">Maaf, saat ini tidak ada jadwal penerbangan yang tersedia.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            @foreach($schedules as $index => $item)
                <div class="glass-card p-6 hover:border-gray-300   hover:shadow-lg hover:shadow-gray-200/50 group stagger-{{ ($index % 5) + 1 }}">
                    {{-- Header --}}
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center">
                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                </svg>
                            </div>
                            <span class="text-gray-900 font-semibold text-sm">{{ $item->plane_name }}</span>
                        </div>
                        @if($item->stock > 20)
                            <span class="badge badge-success">Tersedia</span>
                        @elseif($item->stock > 5)
                            <span class="badge badge-warning">Terbatas</span>
                        @else
                            <span class="badge badge-danger">Hampir Habis</span>
                        @endif
                    </div>

                    {{-- Route Visual --}}
                    <div class="mb-5">
                        <div class="flex items-center justify-between mb-2">
                            <div class="text-left">
                                <p class="text-lg font-bold text-gray-900">{{ Str::before($item->origin, ' (') }}</p>
                                <p class="text-xs text-gray-400">{{ Str::between($item->origin, '(', ')') ?: $item->origin }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-lg font-bold text-gray-900">{{ Str::before($item->destination, ' (') }}</p>
                                <p class="text-xs text-gray-400">{{ Str::between($item->destination, '(', ')') ?: $item->destination }}</p>
                            </div>
                        </div>
                        {{-- Route Line --}}
                        <div class="flex items-center gap-2 px-1">
                            <div class="w-2 h-2 rounded-full bg-gray-400"></div>
                            <div class="flex-1 h-[2px] bg-gradient-to-r from-gray-400 to-gray-300 relative">
                                <svg class="absolute left-1/2 -translate-x-1/2 -top-2 w-4 h-4 text-gray-400 group-hover:animate-plane-fly" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                </svg>
                            </div>
                            <div class="w-2 h-2 rounded-full bg-gray-300"></div>
                        </div>
                    </div>

                    {{-- Info Grid --}}
                    <div class="grid grid-cols-3 gap-3 mb-5">
                        <div class="text-center p-2 rounded-lg bg-gray-50">
                            <p class="text-[10px] text-gray-400 uppercase">Berangkat</p>
                            <p class="text-xs font-semibold text-gray-700 mt-0.5">{{ \Carbon\Carbon::parse($item->departure)->format('d M') }}</p>
                            <p class="text-[10px] text-gray-400">{{ \Carbon\Carbon::parse($item->departure)->format('H:i') }}</p>
                        </div>
                        <div class="text-center p-2 rounded-lg bg-gray-50">
                            <p class="text-[10px] text-gray-400 uppercase">Kursi</p>
                            <p class="text-xs font-semibold text-gray-700 mt-0.5">{{ $item->stock }}</p>
                            <p class="text-[10px] text-gray-400">tersisa</p>
                        </div>
                        <div class="text-center p-2 rounded-lg bg-gray-50">
                            <p class="text-[10px] text-gray-400 uppercase">Harga</p>
                            <p class="text-xs font-semibold text-accent-500 mt-0.5">{{ number_format($item->price / 1000) }}K</p>
                            <p class="text-[10px] text-gray-400">/kursi</p>
                        </div>
                    </div>

                    {{-- Price & Button --}}
                    <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                        <div>
                            <p class="text-[10px] text-gray-400 uppercase">Mulai dari</p>
                            <p class="text-lg font-bold text-gray-900">Rp {{ number_format($item->price) }}</p>
                        </div>
                        <a href="/booking/{{ $item->id }}"
                            class="btn-gradient !py-2.5 !px-5 text-sm inline-flex items-center gap-1.5 no-underline">
                            Pesan
                            <svg class="w-4 h-4  group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection