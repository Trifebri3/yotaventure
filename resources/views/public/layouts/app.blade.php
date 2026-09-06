<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @hasSection('meta')
        @yield('meta')
    @else
        @stack('meta')
        <meta name="description" content="YOIN Inovasi Nusantara - Mitra Strategis Transformasi Digital Anda. Menghadirkan Solusi Teknologi Kelas Dunia untuk Kemanusiaan.">
        <title>{{ $title ?? 'YOIN Inovasi Nusantara | Ekosistem Inovasi & Transformasi Digital' }}</title>
    @endif

    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Styles & Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] { display: none !important; }
        body {
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
        }
    </style>
</head>
<body class="bg-white text-gray-900 antialiased selection:bg-[#005952] selection:text-white">
    
    {{-- Header --}}
    @include('public.layouts.header')

    {{-- Main Content --}}
    <main class="min-h-screen">
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('public.layouts.footer')

</body>
</html>
