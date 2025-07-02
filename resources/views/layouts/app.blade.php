<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Percetakan Perdana') }}</title> {{-- Ubah default title --}}

    <link rel="preconnect" href="https://fonts.bunny.net">
    {{-- Mengubah font dari figtree ke instrument-sans --}}
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Menambahkan style inline untuk memastikan font diterapkan --}}
    {{-- Pastikan font 'Instrument Sans' juga terdaftar di tailwind.config.js Anda --}}
    <style>
        body {
            font-family: 'Instrument Sans', sans-serif;
        }
    </style>
</head>
{{-- Menambahkan kelas warna background dan teks dari welcome.blade.php --}}

<body class="font-sans antialiased bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-200">
    {{-- Hapus bg-gray-100 agar mengikuti background body --}}
    <div class="min-h-screen">
        @include('layouts.navigation')

        @isset($header)
            {{-- Menambahkan kelas dark mode ke header --}}
            <header class="bg-white shadow dark:bg-gray-800 dark:shadow-md">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <main>
            {{ $slot }}
        </main>
    </div>
    @stack('scripts')
</body>

</html>
