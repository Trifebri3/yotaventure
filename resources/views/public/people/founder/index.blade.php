@extends('public.layouts.app')

@section('title', 'Dewan Pendiri (Co-Founders) - PT Yota Inovasi Nusantara (YOIN)')

@section('content')
<div class="bg-white text-gray-900 font-sans pt-28 sm:pt-36 pb-24 select-none min-h-screen">

    {{-- Breadcrumb --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-6">
        <nav class="flex items-center gap-2 text-xs text-gray-500">
            <a href="{{ url('/') }}" class="hover:text-[#005952] transition-colors" x-text="$store.lang.t('Beranda', 'Home')">Beranda</a>
            <span>/</span>
            <a href="{{ route('public.people.index') }}" class="hover:text-[#005952] transition-colors" x-text="$store.lang.t('Insan & Tim', 'People & Team')">Insan & Tim</a>
            <span>/</span>
            <span class="text-[#005952] font-semibold" x-text="$store.lang.t('Pendiri', 'Founders')">Pendiri</span>
        </nav>
    </div>

    {{-- Sub-Navigation Pills --}}
    @include('public.people._nav')

    {{-- Editorial Hero Header --}}
    <header class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-16 sm:mb-20">
        <div class="max-w-4xl">
            <span class="text-xs font-bold tracking-[0.25em] text-[#005952] uppercase block mb-3" x-text="$store.lang.t('DEWAN PENDIRI & ARSITEK VISI', 'FOUNDING BOARD & VISION ARCHITECTS')">
                DEWAN PENDIRI & ARSITEK VISI
            </span>
            <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black text-gray-950 tracking-tight leading-[1.12]">
                <span x-text="$store.lang.t('Para Pendiri di Balik Ekosistem YOIN', 'The Founders Behind the YOIN Holding Ecosystem')">
                    Para Pendiri di Balik Ekosistem YOIN
                </span>
            </h1>
            <p class="mt-4 sm:mt-6 text-base sm:text-xl text-gray-600 font-light leading-relaxed">
                <span x-text="$store.lang.t('Menggabungkan keahlian mendalam dalam kecerdasan buatan, agrikultur presisi, manajemen rantai pasok global, dan komitmen teguh terhadap keberlanjutan masa depan.', 'Combining deep domain expertise in artificial intelligence, precision agriculture, global supply chains, and an unyielding commitment to environmental sustainability.')">
                    Menggabungkan keahlian mendalam dalam kecerdasan buatan, agrikultur presisi, manajemen rantai pasok global, dan komitmen teguh terhadap keberlanjutan masa depan.
                </span>
            </p>
        </div>
    </header>

    {{-- FOUNDERS CARDS (SUPER AESTHETIC MAGAZINE EDITORIAL) --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-24">
        <div class="space-y-16 sm:space-y-20">
            @foreach($founders as $index => $founder)
                <div class="relative bg-gradient-to-br from-gray-50 to-white rounded-3xl border border-gray-200/90 p-6 sm:p-10 lg:p-12 hover:shadow-2xl hover:border-slate-400 transition-all duration-300">
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 sm:gap-12 items-start">
                        
                        {{-- Portrait Column --}}
                        <div class="lg:col-span-4 flex flex-col items-center lg:items-start text-center lg:text-left">
                            <div class="relative w-full max-w-[320px] aspect-4/5 rounded-3xl overflow-hidden shadow-xl bg-gray-900 ring-1 ring-black/10">
                                @if($founder->photo)
                                    <img 
                                        src="{{ asset($founder->photo) }}" 
                                        alt="{{ $founder->name }}" 
                                        class="w-full h-full object-cover object-top hover:scale-105 transition-transform duration-500"
                                    >
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-slate-300 text-7xl font-black">
                                        {{ substr($founder->name, 0, 1) }}
                                    </div>
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                                <div class="absolute bottom-4 left-4 right-4">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#004741] text-white text-xs font-bold shadow-xs">
                                        <span class="w-1.5 h-1.5 rounded-full bg-white"></span>
                                        <span>{{ $founder->role_id }}</span>
                                    </span>
                                </div>
                            </div>

                            {{-- Social Media Badges --}}
                            <div class="flex items-center gap-2 mt-5">
                                @if($founder->getSocialLink('linkedin'))
                                    <a href="{{ $founder->getSocialLink('linkedin') }}" target="_blank" rel="noopener" class="p-2.5 rounded-xl bg-gray-100 hover:bg-[#004741] text-gray-700 hover:text-white transition-colors" title="LinkedIn">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                                    </a>
                                @endif
                                @if($founder->getSocialLink('instagram'))
                                    <a href="{{ $founder->getSocialLink('instagram') }}" target="_blank" rel="noopener" class="p-2.5 rounded-xl bg-gray-100 hover:bg-[#004741] text-gray-700 hover:text-white transition-colors" title="Instagram">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                                    </a>
                                @endif
                                @if($founder->getSocialLink('twitter'))
                                    <a href="{{ $founder->getSocialLink('twitter') }}" target="_blank" rel="noopener" class="p-2.5 rounded-xl bg-gray-100 hover:bg-[#004741] text-gray-700 hover:text-white transition-colors" title="X (Twitter)">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                                    </a>
                                @endif
                            </div>
                        </div>

                        {{-- Narrative & Trajectory Column --}}
                        <div class="lg:col-span-8">
                            <div class="flex flex-wrap items-center justify-between gap-3 mb-4">
                                <div class="flex items-center gap-2">
                                    <h2 class="text-2xl sm:text-4xl font-black text-gray-950 tracking-tight">
                                        {{ $founder->name }}
                                    </h2>
                                    <span class="inline-flex items-center text-[#004741]" title="Verified Founder Profile">
                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                </div>
                                <span class="text-xs font-mono px-3 py-1 rounded-full bg-gray-100 text-gray-700 font-semibold">
                                    {{ $founder->role_en ?: $founder->role_id }}
                                </span>
                            </div>

                            {{-- Editorial Quote --}}
                            @if($founder->getMeta('quote'))
                                <blockquote class="my-5 p-4 rounded-2xl bg-slate-50 border-l-4 border-[#004741] text-slate-800 text-sm sm:text-base italic font-serif leading-relaxed">
                                    "{{ $founder->getMeta('quote') }}"
                                </blockquote>
                            @endif

                            {{-- Bio Narrative --}}
                            <div class="prose prose-sm max-w-none text-gray-600 leading-relaxed space-y-3 font-light">
                                <p x-show="$store.lang.isID()">
                                    {{ $founder->bio_id }}
                                </p>
                                <p x-show="$store.lang.isEN()" x-cloak>
                                    {{ $founder->bio_en ?: $founder->bio_id }}
                                </p>
                            </div>

                            {{-- Trajectory / Milestone Tags (from meta JSON) --}}
                            @if($founder->getMeta('trajectory'))
                                <div class="mt-6 pt-6 border-t border-gray-100">
                                    <span class="text-[11px] font-bold uppercase tracking-wider text-gray-400 block mb-3" x-text="$store.lang.t('REKAM JEJAK & FOKUS KEPEMIMPINAN', 'LEADERSHIP MILESTONES & DOMAIN FOCUS')">
                                        REKAM JEJAK & FOKUS KEPEMIMPINAN
                                    </span>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach((array)$founder->getMeta('trajectory') as $item)
                                            <span class="px-3 py-1 rounded-lg bg-gray-100 border border-gray-200/60 text-gray-700 text-xs font-medium">
                                                @if(is_array($item))
                                                    @if(!empty($item['year']))
                                                        <strong class="text-[#004741]">{{ $item['year'] }}</strong>
                                                    @endif
                                                    @if(!empty($item['year']) && (!empty($item['title']) || !empty($item['milestone'])))
                                                        • 
                                                    @endif
                                                    {{ $item['title'] ?? ($item['milestone'] ?? implode(' - ', array_filter($item))) }}
                                                @else
                                                    {{ $item }}
                                                @endif
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            {{-- Action Links --}}
                            <div class="mt-8 flex items-center gap-4">
                                <a 
                                    href="{{ route('public.people.founder.show', $founder->slug) }}" 
                                    class="px-5 py-2.5 rounded-full bg-[#004741] hover:bg-slate-950 text-white text-xs font-bold transition-all shadow-sm inline-flex items-center gap-2"
                                >
                                    <span x-text="$store.lang.t('Baca Kisah Lengkap', 'Read Full Memoir')">Baca Kisah Lengkap</span>
                                    <span>→</span>
                                </a>
                                @if($founder->stories->count() > 0)
                                    <a 
                                        href="{{ route('public.people.storyfounder.show', $founder->stories->first()->slug) }}" 
                                        class="text-xs font-bold text-gray-600 hover:text-[#004741] transition-colors underline underline-offset-4"
                                    >
                                        <span x-text="$store.lang.t('Manifes & Esai Kepemimpinan', 'Leadership Essays & Manifestos')">Manifes & Esai Kepemimpinan</span> ({{ $founder->stories->count() }})
                                    </a>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

</div>
@endsection
