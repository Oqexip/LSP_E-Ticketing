<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pinto Air — Terbang Lebih Mudah</title>
    <meta name="description" content="Pinto Air - Sistem pemesanan tiket pesawat online yang mudah, cepat, dan terpercaya. Pesan tiket penerbangan Anda sekarang.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* ========== Landing Page Specific ========== */
        @keyframes hero-float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            25% { transform: translateY(-15px) rotate(1deg); }
            75% { transform: translateY(5px) rotate(-1deg); }
        }

        @keyframes dash-move {
            0% { stroke-dashoffset: 100; }
            100% { stroke-dashoffset: 0; }
        }

        @keyframes count-pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        @keyframes blob-morph {
            0%, 100% { border-radius: 60% 40% 30% 70% / 60% 30% 70% 40%; }
            25% { border-radius: 30% 60% 70% 40% / 50% 60% 30% 60%; }
            50% { border-radius: 50% 50% 40% 60% / 40% 50% 60% 50%; }
            75% { border-radius: 40% 60% 50% 50% / 60% 40% 50% 60%; }
        }

        .hero-plane {
            animation: hero-float 6s ease-in-out infinite;
        }

        .blob-shape {
            animation: blob-morph 12s ease-in-out infinite;
        }

        .route-dash {
            stroke-dasharray: 8 6;
            animation: dash-move 15s linear infinite;
        }

        .stat-counter {
            animation: count-pulse 3s ease-in-out infinite;
        }

        /* Smooth scroll */
        html {
            scroll-behavior: smooth;
        }

        /* Scroll-triggered animations */
        .reveal {
            opacity: 0;
            transform: translateY(40px);
            transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .reveal-left {
            opacity: 0;
            transform: translateX(-40px);
            transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .reveal-left.visible {
            opacity: 1;
            transform: translateX(0);
        }

        .reveal-right {
            opacity: 0;
            transform: translateX(40px);
            transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .reveal-right.visible {
            opacity: 1;
            transform: translateX(0);
        }

        /* Navbar blur on scroll */
        .nav-scrolled {
            background: rgba(255, 255, 255, 0.92) !important;
            box-shadow: 0 1px 3px rgba(0,0,0,0.06);
        }
    </style>
</head>

<body class="h-screen bg-gray-50 font-sans antialiased overflow-hidden">

    {{-- ============ NAVBAR ============ --}}
    <nav id="navbar" class="fixed top-0 left-0 right-0 z-50 bg-white/70 backdrop-blur-xl border-b border-gray-200/60 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                {{-- Logo --}}
                <a href="/" class="flex items-center gap-3" id="nav-logo">
                    <div class="w-9 h-9 bg-gradient-to-br from-blue-600 to-blue-800 rounded-xl flex items-center justify-center shadow-lg shadow-blue-900/20">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                        </svg>
                    </div>
                    <span class="text-lg font-bold text-gray-900 tracking-tight">Pinto Air</span>
                </a>

                {{-- Auth Buttons --}}
                <div class="flex items-center gap-3">
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn-gradient !py-2 !px-5 text-sm no-underline" id="nav-dashboard-btn">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors no-underline" id="nav-login-btn">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" class="btn-gradient !py-2 !px-5 text-sm no-underline" id="nav-register-btn">
                            Daftar Gratis
                        </a>
                    @endauth

                    {{-- Mobile Menu Button --}}
                    <button onclick="toggleMobileMenu()" class="md:hidden text-gray-500 hover:text-gray-900 ml-2" id="mobile-menu-toggle">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Mobile Menu --}}
            <div id="mobile-menu" class="hidden md:hidden pb-4 border-t border-gray-100 mt-2">
                <div class="flex flex-col gap-2 pt-3">
                    <a href="#features" class="text-sm text-gray-600 hover:text-gray-900 py-2 px-3 rounded-lg hover:bg-gray-50">Fitur</a>
                    <a href="#routes" class="text-sm text-gray-600 hover:text-gray-900 py-2 px-3 rounded-lg hover:bg-gray-50">Rute</a>
                    <a href="#how-it-works" class="text-sm text-gray-600 hover:text-gray-900 py-2 px-3 rounded-lg hover:bg-gray-50">Cara Pesan</a>
                    <a href="#testimonials" class="text-sm text-gray-600 hover:text-gray-900 py-2 px-3 rounded-lg hover:bg-gray-50">Testimoni</a>
                </div>
            </div>
        </div>
    </nav>


    {{-- ============ HERO SECTION ============ --}}
    <section class="relative h-screen flex items-center justify-center pt-16 overflow-hidden" id="hero">
        {{-- Background Decorations --}}
        <div class="absolute inset-0 z-0">
            <div class="absolute top-20 right-[10%] w-[400px] h-[400px] bg-blue-100/40 rounded-full blur-3xl blob-shape"></div>
            <div class="absolute bottom-10 left-[5%] w-[500px] h-[500px] bg-gray-200/30 rounded-full blur-3xl blob-shape" style="animation-delay: 3s;"></div>
            <div class="absolute top-[30%] left-[50%] w-[200px] h-[200px] bg-amber-100/20 rounded-full blur-3xl blob-shape" style="animation-delay: 6s;"></div>
        </div>

        <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                {{-- Left: Hero Content --}}
                <div class="animate-fade-in-up">

                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-gray-900 leading-tight tracking-tight">
                        Terbang Lebih
                        <span class="relative inline-block">
                            <span class="relative z-10 bg-gradient-to-r from-blue-600 to-blue-800 bg-clip-text text-transparent">Mudah</span>
                            <svg class="absolute -bottom-2 left-0 w-full" viewBox="0 0 200 12" fill="none">
                                <path d="M2 8c30-6 60-6 90-2s70 4 106-2" stroke="#3b82f6" stroke-width="3" stroke-linecap="round" class="route-dash" opacity="0.4"/>
                            </svg>
                        </span>
                        <br>& Terpercaya
                    </h1>

                    <p class="mt-6 text-lg text-gray-500 leading-relaxed max-w-xl">
                        Pinto Air menghubungkan Anda ke berbagai destinasi di Indonesia.
                    </p>

                    <div class="flex flex-col sm:flex-row gap-4 mt-8">
                        @auth
                            <a href="{{ route('dashboard') }}" class="btn-gradient text-center no-underline inline-flex items-center justify-center gap-2" id="hero-dashboard-btn">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                </svg>
                                Lihat Penerbangan
                            </a>
                        @else
                            <a href="{{ route('register') }}" class="btn-gradient text-center no-underline inline-flex items-center justify-center gap-2" id="hero-register-btn">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                </svg>
                                Mulai Pesan Tiket
                            </a>
                            <a href="{{ route('login') }}" class="px-6 py-3 rounded-xl border border-gray-200 text-gray-700 font-semibold text-center hover:bg-gray-50 hover:border-gray-300 transition-all no-underline" id="hero-login-btn">
                                Sudah Punya Akun?
                            </a>
                        @endauth
                    </div>

                    {{-- Trust Indicators --}}
                    <div class="flex items-center gap-6 mt-10 pt-8 border-t border-gray-100">
                        <div class="stat-counter" style="animation-delay: 0s;">
                            <p class="text-2xl font-bold text-gray-900">500+</p>
                            <p class="text-xs text-gray-400 uppercase tracking-wider">Penerbangan</p>
                        </div>
                        <div class="w-px h-10 bg-gray-200"></div>
                        <div class="stat-counter" style="animation-delay: 0.5s;">
                            <p class="text-2xl font-bold text-gray-900">10K+</p>
                            <p class="text-xs text-gray-400 uppercase tracking-wider">Penumpang</p>
                        </div>
                        <div class="w-px h-10 bg-gray-200"></div>
                        <div class="stat-counter" style="animation-delay: 1s;">
                            <p class="text-2xl font-bold text-gray-900">50+</p>
                            <p class="text-xs text-gray-400 uppercase tracking-wider">Rute</p>
                        </div>
                    </div>
                </div>

                {{-- Right: Hero Visual --}}
                <div class="relative hidden lg:flex items-center justify-center">
                    {{-- Main Card --}}
                    <div class="relative animate-fade-in-up stagger-2">
                        {{-- Floating Boarding Pass Card --}}
                        <div class="glass-card p-6 shadow-xl shadow-gray-200/50 max-w-sm w-full hero-plane">
                            {{-- Header --}}
                            <div class="flex items-center justify-between mb-5">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 bg-gradient-to-br from-blue-600 to-blue-800 rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                        </svg>
                                    </div>
                                    <span class="text-sm font-bold text-gray-900">BOARDING PASS</span>
                                </div>
                                <span class="badge badge-success">Confirmed</span>
                            </div>

                            {{-- Route --}}
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <p class="text-2xl font-extrabold text-gray-900">CGK</p>
                                    <p class="text-xs text-gray-400">Jakarta</p>
                                </div>
                                <div class="flex-1 mx-4 relative">
                                    <div class="flex items-center gap-2">
                                        <div class="w-2 h-2 rounded-full bg-blue-500"></div>
                                        <div class="flex-1 h-[2px] bg-gradient-to-r from-blue-500 to-blue-300"></div>
                                        <svg class="w-5 h-5 text-blue-500 animate-plane-fly" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                        </svg>
                                        <div class="flex-1 h-[2px] bg-gradient-to-r from-blue-300 to-blue-500"></div>
                                        <div class="w-2 h-2 rounded-full bg-blue-500"></div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-2xl font-extrabold text-gray-900">DPS</p>
                                    <p class="text-xs text-gray-400">Bali</p>
                                </div>
                            </div>

                            {{-- Details Grid --}}
                            <div class="grid grid-cols-3 gap-3 p-3 bg-gray-50 rounded-xl mb-4">
                                <div class="text-center">
                                    <p class="text-[10px] text-gray-400 uppercase">Tanggal</p>
                                    <p class="text-xs font-semibold text-gray-700">14 Apr</p>
                                </div>
                                <div class="text-center">
                                    <p class="text-[10px] text-gray-400 uppercase">Waktu</p>
                                    <p class="text-xs font-semibold text-gray-700">08:30</p>
                                </div>
                                <div class="text-center">
                                    <p class="text-[10px] text-gray-400 uppercase">Kursi</p>
                                    <p class="text-xs font-semibold text-gray-700">12A</p>
                                </div>
                            </div>

                            {{-- Barcode-like design --}}
                            <div class="flex items-center gap-[3px] justify-center pt-3 border-t border-dashed border-gray-200">
                                @for($i = 0; $i < 30; $i++)
                                    <div class="w-[3px] bg-gray-800 rounded-full" style="height: {{ rand(12, 28) }}px;"></div>
                                @endfor
                            </div>
                        </div>

                        {{-- Decorative floating badges --}}
                        <div class="absolute -top-6 -right-6 glass-card p-3 shadow-lg animate-float stagger-3">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-full bg-green-50 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold text-gray-900">Pembayaran Aman</p>
                                    <p class="text-[10px] text-gray-400">100% Terverifikasi</p>
                                </div>
                            </div>
                        </div>

                        <div class="absolute -bottom-4 -left-8 glass-card p-3 shadow-lg animate-float stagger-5">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-full bg-amber-50 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold text-gray-900">Booking Instan</p>
                                    <p class="text-[10px] text-gray-400">Proses cepat</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ============ SCRIPTS ============ --}}
    <script>
        // Scroll-triggered animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, observerOptions);

        document.querySelectorAll('.reveal, .reveal-left, .reveal-right').forEach(el => {
            observer.observe(el);
        });

        // Navbar scroll effect
        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 20) {
                navbar.classList.add('nav-scrolled');
            } else {
                navbar.classList.remove('nav-scrolled');
            }
        });

        // Mobile menu toggle
        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        }

        // Smooth scroll for mobile menu links
        document.querySelectorAll('#mobile-menu a').forEach(link => {
            link.addEventListener('click', () => {
                document.getElementById('mobile-menu').classList.add('hidden');
            });
        });
    </script>
</body>

</html>
