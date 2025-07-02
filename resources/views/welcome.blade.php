<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Percetakan Perdana - Wujudkan Ide Anda dalam Cetakan</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            {{-- Menggunakan CDN Tailwind CSS untuk kemudahan demonstrasi --}}
            <script src="https://cdn.tailwindcss.com"></script>
            <script>
                tailwind.config = {
                    darkMode: 'class',
                    theme: {
                        extend: {
                            fontFamily: {
                                sans: ['Instrument Sans', 'ui-sans-serif', 'system-ui'],
                            },
                        },
                    },
                }
            </script>
        @endif

        {{-- Menambahkan style inline untuk memastikan font dan background diterapkan --}}
        <style>
            body {
                font-family: 'Instrument Sans', sans-serif;
            }
        </style>
    </head>
    <body class="bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-200 antialiased">
        <div class="relative flex flex-col items-center justify-center min-h-screen">
            
            <!-- Header Navigasi -->
            <header class="w-full absolute top-0 left-0 p-6 lg:p-8">
                <div class="max-w-7xl mx-auto flex justify-between items-center">
                    {{-- Logo Toko --}}
                    <a href="/" class="text-2xl font-bold text-gray-900 dark:text-white">
                        Percetakan<span class="text-blue-600 dark:text-blue-500">Perdana</span>
                    </a>

                    @if (Route::has('login'))
                        <nav class="flex items-center gap-4 text-sm">
                            @auth
                                <a
                                    href="{{ url('/dashboard') }}"
                                    class="px-4 py-2 font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 rounded-md transition"
                                >
                                    Dashboard
                                </a>
                            @else
                                <a
                                    href="{{ route('login') }}"
                                    class="px-4 py-2 font-medium text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition"
                                >
                                    Log in
                                </a>

                                @if (Route::has('register'))
                                    <a
                                        href="{{ route('register') }}"
                                        class="px-4 py-2 font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-md shadow-sm transition"
                                    >
                                        Register
                                    </a>
                                @endif
                            @endauth
                        </nav>
                    @endif
                </div>
            </header>

            <!-- Main Content -->
            <main class="w-full max-w-7xl mx-auto px-6 lg:px-8 py-24 lg:py-32">
                <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                    
                    <!-- Kolom Teks -->
                    <div class="text-center lg:text-left">
                        <span class="inline-block px-3 py-1 text-sm font-semibold text-blue-800 bg-blue-100 dark:bg-blue-900/50 dark:text-blue-200 rounded-full mb-4">
                            Solusi Cetak Profesional
                        </span>
                        <h1 class="text-4xl lg:text-5xl font-extrabold tracking-tight text-gray-900 dark:text-white">
                            Wujudkan Ide Anda Bersama Kami.
                        </h1>
                        <p class="mt-4 text-lg text-gray-600 dark:text-gray-400">
                            Kami menyediakan layanan cetak berkualitas tinggi untuk segala kebutuhan bisnis dan personal Anda, dari kartu nama hingga spanduk besar.
                        </p>

                        <!-- Layanan Kami -->
                        <ul class="mt-8 space-y-3 text-left">
                            <li class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-blue-500 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                <span>Kartu Nama, Brosur, dan Flyer</span>
                            </li>
                            <li class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-blue-500 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                <span>Banner, Spanduk, dan Baliho</span>
                            </li>
                             <li class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-blue-500 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                <span>Stiker, Label, dan Kemasan Produk</span>
                            </li>
                             <li class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-blue-500 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                <span>Jasa Desain Grafis Profesional</span>
                            </li>
                        </ul>

                        <!-- Tombol Aksi -->
                        <div class="mt-10 flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4">
                            <a href="#" class="w-full sm:w-auto inline-block px-8 py-3 font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-lg transition transform hover:-translate-y-1">
                                Pesan Sekarang
                            </a>
                             <a href="#" class="w-full sm:w-auto inline-block px-8 py-3 font-semibold text-gray-800 dark:text-white bg-gray-200/80 dark:bg-gray-700/80 hover:bg-gray-300 dark:hover:bg-gray-600 rounded-lg transition">
                                Hubungi Kami
                            </a>
                        </div>
                    </div>

                    <!-- Kolom Gambar -->
                    <div class="hidden lg:block">
                        <img 
                            src="https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?q=80&w=1964&auto=format&fit=crop" 
                            alt="Abstrak gradien biru dan ungu sebagai representasi desain modern" 
                            class="w-full h-full object-cover rounded-2xl shadow-2xl transform hover:scale-105 transition-transform duration-500 ease-in-out"
                        >
                    </div>

                </div>
            </main>

            <!-- Footer -->
            <footer class="w-full text-center p-6 text-sm text-gray-500 dark:text-gray-400">
                © {{ date('Y') }} Percetakan Perdana. All rights reserved. Ditenagai oleh <a href="https://laravel.com" class="underline hover:text-blue-500">Laravel</a>.
            </footer>
        </div>
    </body>
</html>