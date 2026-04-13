@extends('layouts.auth')

@section('title', 'Daftar - E-Ticketing Easy')

@section('content')
    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-gray-900">Buat Akun Baru</h2>
        <p class="text-gray-500 mt-1 text-sm">Daftar untuk mulai memesan tiket pesawat</p>
    </div>

    {{-- Error Messages --}}
    @if($errors->any())
        <div class="flash-message flash-error mb-4">
            <svg class="w-5 h-5 text-amber-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4.5c-.77-.833-2.694-.833-3.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/>
            </svg>
            <div>
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        </div>
    @endif

    <form action="{{ route('register.post') }}" method="POST" class="space-y-5">
        @csrf

        {{-- Nama --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
            <div class="relative">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </span>
                <input type="text" name="name" required value="{{ old('name') }}"
                    class="input-styled" placeholder="Nama lengkap Anda">
            </div>
        </div>

        {{-- Email --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
            <div class="relative">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </span>
                <input type="email" name="email" required value="{{ old('email') }}"
                    class="input-styled" placeholder="nama@email.com">
            </div>
        </div>

        {{-- Password --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
            <div class="relative">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </span>
                <input type="password" name="password" required
                    class="input-styled" placeholder="Minimal 6 karakter">
            </div>
        </div>

        {{-- Submit Button --}}
        <button type="submit" class="btn-gradient w-full text-center flex items-center justify-center gap-2 mt-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
            </svg>
            Daftar Sekarang
        </button>
    </form>
@endsection

@section('footer')
    <p class="text-gray-500 text-sm">
        Sudah punya akun?
        <a href="{{ route('login') }}" class="text-gray-900 hover:text-gray-700 font-medium ">Login di sini</a>
    </p>
@endsection
