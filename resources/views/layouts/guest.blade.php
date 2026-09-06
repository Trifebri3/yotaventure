<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'YOIN') }} - Super Admin Portal</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-[#F8FAFC] selection:bg-[#005952] selection:text-white">
        
        <div class="min-h-screen flex flex-col justify-center items-center py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
            
            {{-- Subtle Background Geometric Lines --}}
            <div class="absolute inset-0 pointer-events-none opacity-20">
                <svg class="w-full h-full" viewBox="0 0 1440 800" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
                    <path d="M 0 120 C 500 40, 950 200, 1440 100" stroke="#005952" stroke-width="1.5" stroke-dasharray="6 6" />
                    <path d="M 0 700 C 450 620, 1000 760, 1440 650" stroke="#005952" stroke-width="1.5" stroke-dasharray="6 6" />
                </svg>
            </div>

            {{-- Top Link back to Public Website --}}
            <div class="absolute top-6 left-6 sm:top-8 sm:left-8 z-10">
                <a 
                    href="{{ url('/') }}" 
                    class="inline-flex items-center gap-2 text-xs font-bold text-gray-600 hover:text-[#005952] transition-colors py-1.5 px-3 rounded-full bg-white border border-gray-200 shadow-2xs hover:shadow-xs"
                >
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    <span>Website Publik</span>
                </a>
            </div>

            {{-- Main Logo & Header --}}
            <div class="mb-6 flex flex-col items-center text-center">
                <a href="{{ url('/') }}" class="inline-block transition-transform hover:scale-105 duration-300">
                    <img 
                        src="{{ asset('logo.png') }}" 
                        alt="PT Yota Inovasi Nusantara (YOIN)" 
                        class="h-12 sm:h-14 w-auto object-contain"
                    >
                </a>
                <div class="mt-4 flex items-center gap-2">
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-teal-50 border border-teal-200 text-[#005952] text-[11px] font-bold uppercase tracking-wider">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#005952]"></span>
                        <span>Super Admin Portal</span>
                    </span>
                </div>
            </div>

            {{-- Card Container --}}
            <div class="w-full sm:max-w-md bg-white rounded-3xl border border-gray-200/90 shadow-xl overflow-hidden p-7 sm:p-9 relative z-10">
                {{ $slot }}
            </div>

            {{-- Footer Copyright --}}
            <div class="mt-8 text-center text-xs text-gray-400">
                &copy; {{ date('Y') }} PT Yota Inovasi Nusantara (YOIN). All rights reserved.
            </div>

        </div>
    </body>
</html>
