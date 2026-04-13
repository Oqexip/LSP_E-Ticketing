<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'E-Ticketing Easy')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-gray-50 font-sans antialiased overflow-hidden">
    {{-- Subtle Background --}}
    <div class="fixed inset-0 z-0">
        {{-- Gradient Base --}}
        <div class="absolute inset-0 bg-gradient-to-br from-gray-50 via-white to-gray-100"></div>

        {{-- Decorative Elements --}}
        <div class="absolute top-[-10%] right-[-5%] w-[500px] h-[500px] rounded-full bg-gray-200/40 blur-3xl animate-float"></div>
        <div class="absolute bottom-[-15%] left-[-10%] w-[600px] h-[600px] rounded-full bg-gray-300/30 blur-3xl animate-float" style="animation-delay: 1.5s;"></div>
        <div class="absolute top-[40%] left-[30%] w-[300px] h-[300px] rounded-full bg-gray-200/20 blur-3xl animate-float" style="animation-delay: 3s;"></div>

        {{-- Subtle Dots --}}
        <div class="absolute top-[15%] left-[20%] w-1 h-1 bg-gray-300 rounded-full"></div>
        <div class="absolute top-[25%] right-[30%] w-1.5 h-1.5 bg-gray-200 rounded-full"></div>
        <div class="absolute top-[60%] left-[70%] w-1 h-1 bg-gray-300 rounded-full"></div>
        <div class="absolute top-[70%] left-[15%] w-1.5 h-1.5 bg-gray-200 rounded-full"></div>
        <div class="absolute top-[10%] right-[15%] w-1 h-1 bg-gray-300 rounded-full"></div>
    </div>

    {{-- Content --}}
    <div class="relative z-10 min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-md">
            {{-- Brand Logo --}}
            <div class="text-center mb-8">
                <div class="inline-flex items-center gap-3 mb-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-600 to-blue-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-900/20">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                        </svg>
                    </div>
                    <div class="text-left">
                        <h1 class="text-xl font-bold text-gray-900 tracking-tight">Pinto Air</h1>
                    </div>
                </div>
            </div>

            {{-- Card --}}
            <div class="glass-card p-8 shadow-xl shadow-gray-200/50">
                @yield('content')
            </div>

            {{-- Footer --}}
            <div class="text-center mt-6">
                @yield('footer')
            </div>
        </div>
    </div>
</body>

</html>
