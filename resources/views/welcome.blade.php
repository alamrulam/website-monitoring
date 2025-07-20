<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Monitoring Proyek</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased">
    <div class="relative flex justify-center items-center min-h-screen bg-gray-900">
        <div class="absolute inset-0 bg-cover bg-center"
            style="background-image: url('https://images.unsplash.com/photo-1523989339328-14184b58470e?q=80&w=2070&auto=format&fit=crop');">
            <div class="absolute inset-0 bg-gradient-to-t from-black via-black/60 to-transparent"></div>
        </div>
        <div class="max-w-7xl mx-auto p-6 lg:p-8 relative z-10 text-white">
            <div class="flex justify-center">
                {{-- Logo diganti dengan gambar --}}
                <img src="{{ asset('images/logo-saya.png') }}" alt="Logo Sistem" class="h-20 w-auto">
            </div>
            <div class="mt-8 text-center">
                <h1 class="text-4xl md:text-6xl font-bold tracking-tight">Sistem Monitoring Proyek</h1>
                <p class="mt-4 text-lg text-gray-300 max-w-2xl mx-auto">Manajemen proyek jalan menjadi lebih mudah,
                    transparan, dan akuntabel.</p>
            </div>
            <div class="mt-16 flex justify-center">
                @if (Route::has('login'))
                    <div class="text-center">
                        @auth
                            <a href="{{ url('/dashboard') }}"
                                class="font-semibold text-gray-200 hover:text-white">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}"
                                class="rounded-md px-8 py-3 text-lg font-semibold text-white bg-indigo-600 hover:bg-indigo-500 shadow-lg transform hover:scale-105 transition duration-300 ease-in-out">Masuk
                                ke Sistem</a>
                        @endauth
                    </div>
                @endif
            </div>
        </div>
    </div>
</body>

</html>
