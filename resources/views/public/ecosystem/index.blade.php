@extends('public.layouts.app')

@section('title', 'Ekosistem & Inisiatif Nusantara | YOIN Inovasi Nusantara')

@section('content')
<div 
    x-data="{
        activeDomain: 'all',
        searchTerm: '',
        lightboxImg: null,
        lightboxCaption: ''
    }"
    class="bg-[#FAFCFC] min-h-screen pt-28 sm:pt-36 pb-24 text-gray-900 font-sans"
>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Breadcrumbs --}}
        <nav class="flex items-center gap-2 text-xs text-gray-500 mb-6">
            <a href="{{ url('/') }}" class="hover:text-[#005952] transition-colors" x-text="$store.lang.t('Beranda', 'Home')">Beranda</a>
            <span>/</span>
            <span class="text-gray-900 font-semibold" x-text="$store.lang.t('Direktori Ekosistem', 'Ecosystem Directory')">Direktori Ekosistem</span>
        </nav>

        {{-- Hero Header --}}
        <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-8 pb-10 border-b border-gray-200">
            <div class="max-w-3xl">
                <div class="flex items-center gap-2 mb-3">
                    <span class="w-2.5 h-2.5 rounded-full bg-[#005952]"></span>
                    <span class="text-xs font-bold tracking-[0.25em] text-[#005952] uppercase" x-text="$store.lang.t('ARSITEKTUR EKOSISTEM YOIN', 'YOIN ECOSYSTEM ARCHITECTURE')">
                        ARSITEKTUR EKOSISTEM YOIN
                    </span>
                </div>
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-gray-950 tracking-tight leading-tight">
                    YOIN is the home behind what we build.
                </h1>
                <p class="mt-4 text-base sm:text-lg text-gray-600 leading-relaxed font-normal" x-text="$store.lang.t('Sebagai platform payung ekosistem (parent ecosystem platform), YOIN menjadi gerbang terpusat, pengindeks portofolio, dan simpul dokumentasi yang menghubungkan domain, brand inisiatif, produk, hingga karya nyata di seluruh nusantara.', 'As a parent ecosystem platform, YOIN serves as a central gateway, portfolio directory, and living documentation hub connecting strategic domains, initiative brands, products, and tangible works across Indonesia.')">
                    Sebagai platform payung ekosistem (parent ecosystem platform), YOIN menjadi gerbang terpusat, pengindeks portofolio, dan simpul dokumentasi yang menghubungkan domain, brand inisiatif, produk, hingga karya nyata di seluruh nusantara.
                </p>
            </div>

            {{-- Metric Counters Bar --}}
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 w-full lg:w-auto shrink-0">
                <div class="bg-white p-4 rounded-2xl border border-gray-200 shadow-xs text-center min-w-[120px]">
                    <span class="text-2xl font-black text-[#005952] block">{{ $stats['domains_count'] }}</span>
                    <span class="text-[11px] font-bold text-gray-500 uppercase tracking-wider block mt-0.5" x-text="$store.lang.t('Domain', 'Domains')">Domain</span>
                </div>
                <div class="bg-white p-4 rounded-2xl border border-gray-200 shadow-xs text-center min-w-[120px]">
                    <span class="text-2xl font-black text-[#005952] block">{{ $stats['initiatives_count'] }}</span>
                    <span class="text-[11px] font-bold text-gray-500 uppercase tracking-wider block mt-0.5" x-text="$store.lang.t('Inisiatif / Brand', 'Initiatives / Brands')">Inisiatif / Brand</span>
                </div>
                <div class="bg-white p-4 rounded-2xl border border-gray-200 shadow-xs text-center min-w-[120px]">
                    <span class="text-2xl font-black text-[#005952] block">{{ $stats['projects_count'] }}</span>
                    <span class="text-[11px] font-bold text-gray-500 uppercase tracking-wider block mt-0.5" x-text="$store.lang.t('Karya & Project', 'Works & Projects')">Karya & Project</span>
                </div>
                <div class="bg-white p-4 rounded-2xl border border-gray-200 shadow-xs text-center min-w-[120px]">
                    <span class="text-2xl font-black text-[#005952] block">{{ $stats['clients_count'] }}</span>
                    <span class="text-[11px] font-bold text-gray-500 uppercase tracking-wider block mt-0.5" x-text="$store.lang.t('Mitra Klien', 'Client Partners')">Mitra Klien</span>
                </div>
            </div>
        </div>

        {{-- Domain Filter Nav Tabs --}}
        <div class="pt-8 pb-6 flex flex-wrap items-center gap-2 border-b border-gray-100">
            <button 
                @click="activeDomain = 'all'" 
                type="button"
                class="px-4 py-2 rounded-xl text-xs font-bold tracking-wide transition-all cursor-pointer"
                :class="activeDomain === 'all' 
                    ? 'bg-[#005952] text-white shadow-sm' 
                    : 'bg-white hover:bg-gray-100 text-gray-700 border border-gray-200'"
            >
                <span x-text="$store.lang.t('Semua Domain', 'All Domains')">Semua Domain</span> ({{ $domains->count() }})
            </button>

            @foreach($domains as $domain)
                <button 
                    @click="activeDomain = '{{ $domain->slug }}'" 
                    type="button"
                    class="px-4 py-2 rounded-xl text-xs font-bold tracking-wide transition-all cursor-pointer"
                    :class="activeDomain === '{{ $domain->slug }}' 
                        ? 'bg-[#005952] text-white shadow-sm' 
                        : 'bg-white hover:bg-gray-100 text-gray-700 border border-gray-200'"
                >
                    <span x-text="$store.lang.t('{{ addslashes($domain->name_id) }}', '{{ addslashes($domain->name_en) }}')">
                        {{ $domain->name_id }}
                    </span>
                    <span class="opacity-70 text-[10px]">({{ $domain->initiatives->count() }})</span>
                </button>
            @endforeach
        </div>

        {{-- Domain & Initiatives Roster --}}
        <div class="py-10 space-y-16">
            @foreach($domains as $domain)
                <div 
                    x-show="activeDomain === 'all' || activeDomain === '{{ $domain->slug }}'" 
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    class="space-y-8"
                >
                    {{-- Domain Banner Header --}}
                    <div class="bg-white rounded-3xl border border-gray-200/90 shadow-sm relative overflow-hidden">
                        
                        {{-- Top Visual Cover Header --}}
                        <div class="relative h-48 sm:h-64 w-full overflow-hidden bg-gray-900">
                            <img 
                                src="{{ $domain->cover_image ?: 'https://images.unsplash.com/photo-1451187580459-43490279c0fa?auto=format&fit=crop&w=1200&q=80' }}" 
                                alt="{{ $domain->name_id }}" 
                                class="w-full h-full object-cover opacity-60 filter brightness-95"
                            >
                            <div class="absolute inset-0 bg-gradient-to-t from-gray-950 via-gray-950/40 to-transparent"></div>
                            
                            {{-- Top Badges & Action Link --}}
                            <div class="absolute top-4 left-4 right-4 flex items-center justify-between z-10">
                                <div class="flex items-center gap-2">
                                    <span class="px-3 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-wider bg-white/95 backdrop-blur-md text-[#005952] border border-white/40 shadow-xs">
                                        DOMAIN #{{ $loop->iteration }}
                                    </span>
                                    <span class="px-3 py-1 rounded-full text-[10px] font-mono font-bold uppercase tracking-wider bg-black/70 backdrop-blur-md text-white border border-white/20">
                                        {{ $domain->status }}
                                    </span>
                                </div>
                                <a 
                                    href="{{ route('public.ecosystem.domain', $domain->slug) }}" 
                                    class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/95 hover:bg-[#005952] text-gray-900 hover:text-white backdrop-blur-md text-xs font-bold transition-all shadow-sm cursor-pointer"
                                >
                                    <span x-text="$store.lang.t('Eksplorasi Domain Lengkap', 'Explore Full Domain')">Eksplorasi Domain Lengkap</span>
                                    <span>→</span>
                                </a>
                            </div>

                            {{-- Bottom Content inside Banner --}}
                            <div class="absolute bottom-4 sm:bottom-6 left-4 sm:left-8 right-4 sm:right-8 text-white z-10">
                                <div class="flex items-center gap-4">
                                    @if($domain->icon_image)
                                        <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl overflow-hidden bg-white/10 backdrop-blur-md border border-white/30 p-1 shrink-0 shadow-md">
                                            <img src="{{ $domain->icon_image }}" alt="{{ $domain->name_id }}" class="w-full h-full object-cover rounded-xl">
                                        </div>
                                    @endif
                                    <div>
                                        <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black text-white tracking-tight drop-shadow-md">
                                            <span x-text="$store.lang.t('{{ addslashes($domain->name_id) }}', '{{ addslashes($domain->name_en) }}')">
                                                {{ $domain->name_id }}
                                            </span>
                                        </h2>
                                        <p class="text-xs sm:text-sm text-teal-100 mt-1 font-medium line-clamp-1 drop-shadow-xs max-w-2xl">
                                            <span x-text="$store.lang.t('{{ addslashes($domain->tagline_id ?? '') }}', '{{ addslashes($domain->tagline_en ?? '') }}')">
                                                {{ $domain->tagline_id }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Card Body: Problem, Solution, Field Gallery, and SDGs --}}
                        <div class="p-6 sm:p-8">
                            {{-- Core Problem & Solution Highlight --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                {{-- Problem Statement --}}
                                <div class="bg-slate-50 rounded-2xl p-5 border-l-4 border-slate-700 border-y border-r border-slate-200">
                                    <div class="flex items-center gap-2 text-xs font-bold text-slate-900 mb-2 uppercase tracking-wider">
                                        <span class="w-2 h-2 rounded-full bg-slate-800"></span>
                                        <span x-text="$store.lang.t('Tantangan / Masalah Riil yang Dihadapi', 'The Challenge / Problem We Address')">
                                            Tantangan / Masalah Riil yang Dihadapi
                                        </span>
                                    </div>
                                    <p class="text-xs sm:text-sm text-slate-700 leading-relaxed font-normal">
                                        <span x-text="$store.lang.t('{{ addslashes($domain->problem_statement_id ?? '') }}', '{{ addslashes($domain->problem_statement_en ?? '') }}')">
                                            {{ $domain->problem_statement_id }}
                                        </span>
                                    </p>
                                </div>

                                {{-- Solution Statement --}}
                                <div class="bg-slate-50 rounded-2xl p-5 border-l-4 border-[#004741] border-y border-r border-slate-200">
                                    <div class="flex items-center gap-2 text-xs font-bold text-[#004741] mb-2 uppercase tracking-wider">
                                        <span class="w-2 h-2 rounded-full bg-[#004741]"></span>
                                        <span x-text="$store.lang.t('Arah Solusi & Pendekatan Rekayasa', 'Solution Direction & Engineering Approach')">
                                            Arah Solusi & Pendekatan Rekayasa
                                        </span>
                                    </div>
                                    <p class="text-xs sm:text-sm text-slate-800 leading-relaxed font-normal">
                                        <span x-text="$store.lang.t('{{ addslashes($domain->solution_statement_id ?? '') }}', '{{ addslashes($domain->solution_statement_en ?? '') }}')">
                                            {{ $domain->solution_statement_id }}
                                        </span>
                                    </p>
                                </div>
                            </div>

                            {{-- DOKUMENTASI & GALERI AKSI LAPANGAN DOMAIN --}}
                            @if(!empty($domain->gallery) && count($domain->gallery) > 0)
                                <div class="mt-6 pt-6 border-t border-gray-100">
                                    <div class="flex items-center justify-between mb-3">
                                        <div class="flex items-center gap-2 text-xs font-extrabold uppercase tracking-wider text-gray-800">
                                            <svg class="w-4 h-4 text-[#005952]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <span x-text="$store.lang.t('Galeri Dokumentasi & Aksi Lapangan', 'Field Action & Photo Gallery')">Galeri Dokumentasi & Aksi Lapangan</span>
                                        </div>
                                        <span class="text-[11px] text-gray-500 font-medium">{{ count($domain->gallery) }} Foto Terverifikasi</span>
                                    </div>
                                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
                                        @foreach(array_slice($domain->gallery, 0, 4) as $photo)
                                            <div 
                                                @click="lightboxImg = '{{ $photo }}'; lightboxCaption = '{{ addslashes($domain->name_id) }}'"
                                                class="group relative h-28 sm:h-32 rounded-xl overflow-hidden cursor-pointer shadow-2xs border border-gray-200/80 bg-gray-100"
                                            >
                                                <img src="{{ $photo }}" alt="{{ $domain->name_id }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                                <div class="absolute inset-0 bg-black/25 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                                    <span class="p-2 rounded-full bg-white/90 text-gray-900 shadow-md">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7" />
                                                        </svg>
                                                    </span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            {{-- SDGs Alignment Badges --}}
                            @if(!empty($domain->sdgs) && count($domain->sdgs) > 0)
                                <div class="mt-5 pt-4 border-t border-gray-100 flex flex-wrap items-center gap-2">
                                    <span class="text-[10px] font-extrabold uppercase tracking-wider text-gray-500 mr-1" x-text="$store.lang.t('Keterkaitan SDGs:', 'SDGs Alignment:')">Keterkaitan SDGs:</span>
                                    @foreach($domain->sdgs as $sdg)
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-teal-50 text-[#005952] border border-teal-200/80 shadow-2xs">
                                            {{ $sdg }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Initiatives Grid under this Domain --}}
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-sm font-bold uppercase tracking-wider text-gray-500 flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#005952]"></span>
                                <span x-text="$store.lang.t('Inisiatif & Brand di Bawah Domain Ini', 'Initiatives & Brands in this Domain')">
                                    Inisiatif & Brand di Bawah Domain Ini
                                </span>
                                <span class="text-xs text-gray-400">({{ $domain->initiatives->count() }})</span>
                            </h3>
                        </div>

                        @if($domain->initiatives->isEmpty())
                            <div class="bg-white rounded-2xl p-8 text-center border border-dashed border-gray-300 text-gray-400 text-xs">
                                <span x-text="$store.lang.t('Inisiatif dalam domain ini sedang dalam tahap inkubasi dan riset tertutup.', 'Initiatives in this domain are currently under private research and incubation.')">
                                    Inisiatif dalam domain ini sedang dalam tahap inkubasi dan riset tertutup.
                                </span>
                            </div>
                        @else
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach($domain->initiatives as $initiative)
                                    <div class="bg-white rounded-3xl border border-gray-200/90 p-6 shadow-xs flex flex-col justify-between hover:shadow-xl hover:border-[#005952]/40 transition-all group">
                                        <div>
                                            {{-- Top Card Photo & Brand Logo Emblem Container --}}
                                            <div class="relative h-44 sm:h-48 w-full rounded-2xl overflow-hidden bg-gray-100 mb-5">
                                                <img 
                                                    src="{{ $initiative->cover_image ?: ($initiative->hero_image ?: 'https://images.unsplash.com/photo-1551836022-d5d88e9218df?q=80&w=800&auto=format&fit=crop') }}" 
                                                    alt="{{ $initiative->name }}" 
                                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 filter brightness-95"
                                                />
                                                <div class="absolute inset-0 bg-gradient-to-t from-gray-950/85 via-gray-950/30 to-transparent"></div>

                                                {{-- Top Badges --}}
                                                <div class="absolute top-3 left-3 z-10">
                                                    <span class="px-2.5 py-0.5 rounded-md bg-white/95 backdrop-blur-md text-[10px] font-extrabold uppercase text-gray-800 tracking-wider shadow-xs">
                                                        {{ $initiative->stage }}
                                                    </span>
                                                </div>
                                                <div class="absolute top-3 right-3 z-10">
                                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-black/60 backdrop-blur-md text-[10px] font-bold text-emerald-400">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                                                        {{ $initiative->status }}
                                                    </span>
                                                </div>

                                                {{-- Center Brand Logo / Typographic Insignia --}}
                                                <div class="absolute inset-0 flex flex-col items-center justify-center p-4 text-center select-none pointer-events-none z-10">
                                                    @if($initiative->logo_image && (str_contains($initiative->logo_image, '/storage/') || str_ends_with($initiative->logo_image, '.svg') || str_contains($initiative->logo_image, 'logo')))
                                                        <img src="{{ $initiative->logo_image }}" alt="{{ $initiative->name }}" class="max-h-12 max-w-[150px] object-contain drop-shadow-md brightness-110">
                                                    @else
                                                        @if($initiative->slug === 'yoin-digital')
                                                            <div class="flex flex-col items-center drop-shadow-sm">
                                                                <h3 class="text-3xl font-black tracking-tight text-white">YOIN</h3>
                                                                <span class="text-[9px] font-bold tracking-[0.3em] text-white uppercase -mt-1 font-mono">DIGITAL</span>
                                                            </div>
                                                        @elseif($initiative->slug === 'agronex')
                                                            <div class="flex flex-col items-center drop-shadow-sm">
                                                                <h3 class="text-2xl font-black tracking-wide text-white">AGRONEX</h3>
                                                            </div>
                                                        @elseif($initiative->slug === 'yoimo')
                                                            <div class="flex flex-col items-center drop-shadow-sm">
                                                                <h3 class="text-2xl font-black tracking-wider text-white">YOIMO</h3>
                                                            </div>
                                                        @elseif($initiative->slug === 'buatara')
                                                            <div class="flex items-center gap-1 drop-shadow-md">
                                                                <h3 class="text-2xl font-black tracking-widest text-white">BUATARA</h3>
                                                            </div>
                                                        @elseif($initiative->slug === 'yota-adiwidya-center' || $initiative->slug === 'yac')
                                                            <div class="flex flex-col items-center drop-shadow-sm">
                                                                <h3 class="text-2xl font-black tracking-wider text-white">YAC</h3>
                                                                <span class="text-[7.5px] font-bold tracking-[0.2em] text-white uppercase -mt-0.5 font-mono">YOIN ADIWIDYA CENTER</span>
                                                            </div>
                                                        @else
                                                            <div class="flex flex-col items-center drop-shadow-sm">
                                                                <h3 class="text-xl font-black tracking-wider text-white drop-shadow">{{ strtoupper($initiative->name) }}</h3>
                                                            </div>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>

                                            {{-- Initiative Name & Tagline --}}
                                            <h4 class="text-xl font-extrabold text-gray-950 group-hover:text-[#005952] transition-colors tracking-tight">
                                                {{ $initiative->name }}
                                            </h4>
                                            <p class="text-xs text-gray-500 mt-1 font-medium">
                                                <span x-text="$store.lang.t('{{ addslashes($initiative->tagline_id ?? '') }}', '{{ addslashes($initiative->tagline_en ?? '') }}')">
                                                    {{ $initiative->tagline_id }}
                                                </span>
                                            </p>                                             {{-- Problem Statement for this Initiative --}}
                                            <div class="mt-4 p-3.5 bg-slate-50 border-l-4 border-slate-700 border-y border-r border-slate-200 rounded-xl">
                                                <span class="text-[10px] font-bold text-slate-900 uppercase tracking-wider block mb-1">
                                                    <span x-text="$store.lang.t('Masalah yang Diselesaikan:', 'Problem It Solves:')">Masalah yang Diselesaikan:</span>
                                                </span>
                                                <p class="text-xs text-slate-700 leading-relaxed line-clamp-3">
                                                    <span x-text="$store.lang.t('{{ addslashes($initiative->problem_statement_id ?? '') }}', '{{ addslashes($initiative->problem_statement_en ?? '') }}')">
                                                        {{ $initiative->problem_statement_id }}
                                                    </span>
                                                </p>
                                            </div>

                                            {{-- Mini Galeri Foto Inisiatif --}}
                                            @if(!empty($initiative->gallery) && count($initiative->gallery) > 0)
                                                <div class="mt-4 pt-3 border-t border-gray-100">
                                                    <span class="text-[9px] font-bold uppercase tracking-wider text-gray-400 block mb-1.5" x-text="$store.lang.t('Dokumentasi Visual Inisiatif:', 'Visual Documentation:')">Dokumentasi Visual Inisiatif:</span>
                                                    <div class="flex items-center gap-2">
                                                        @foreach(array_slice($initiative->gallery, 0, 3) as $photo)
                                                            <div 
                                                                @click="lightboxImg = '{{ $photo }}'; lightboxCaption = '{{ addslashes($initiative->name) }}'"
                                                                class="h-12 w-16 rounded-lg overflow-hidden bg-gray-100 border border-gray-200/80 cursor-pointer shadow-2xs hover:scale-105 transition-transform"
                                                            >
                                                                <img src="{{ $photo }}" alt="{{ $initiative->name }}" class="w-full h-full object-cover">
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif

                                            {{-- SDGs Badges --}}
                                            @if(!empty($initiative->sdgs))
                                                <div class="mt-3 flex flex-wrap gap-1">
                                                    @foreach(array_slice($initiative->sdgs, 0, 2) as $sdg)
                                                        <span class="px-2 py-0.5 rounded text-[9px] font-bold bg-teal-50 text-[#005952] border border-teal-200/80">
                                                            {{ $sdg }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            @endif

                                            {{-- Focus Badges --}}
                                            @if(!empty($initiative->focus_areas))
                                                <div class="mt-3 flex flex-wrap gap-1.5">
                                                    @foreach(array_slice($initiative->focus_areas, 0, 3) as $focus)
                                                        <span class="px-2 py-0.5 rounded-md text-[10px] font-medium bg-gray-50 text-gray-600 border border-gray-200">
                                                            {{ $focus }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>

                                        {{-- Dual Gateways: Detail Story vs External Brand Website --}}
                                        <div class="mt-6 pt-5 border-t border-gray-100 flex items-center justify-between gap-3">
                                            <a 
                                                href="{{ route('public.ecosystem.initiative', $initiative->slug) }}" 
                                                class="text-xs font-bold text-gray-700 hover:text-[#005952] transition-colors"
                                            >
                                                <span x-text="$store.lang.t('Story & Produk', 'Story & Products')">Story & Produk</span> →
                                            </a>

                                            @if($initiative->external_website_url)
                                                <a 
                                                    href="{{ $initiative->external_website_url }}" 
                                                    target="_blank" 
                                                    rel="noopener noreferrer" 
                                                    class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg bg-teal-50 hover:bg-[#005952] text-[#005952] hover:text-white border border-teal-200/80 text-xs font-bold transition-all shadow-2xs"
                                                >
                                                    <span>{{ $initiative->external_url_label ?: 'Visit Website →' }}</span>
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                                    </svg>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Ecosystem Philosophy Callout --}}
        <div class="mt-16 bg-slate-950 rounded-3xl p-8 sm:p-12 text-white border border-slate-800 shadow-xl relative overflow-hidden">
            <div class="relative z-10 max-w-3xl">
                <span class="text-xs font-mono font-bold tracking-[0.25em] text-white uppercase block mb-3">
                    ARSITEKTUR INDEPENDEN & TERHUBUNG
                </span>
                <h3 class="text-2xl sm:text-3xl font-black tracking-tight leading-tight">
                    Masing-masing inisiatif bertumbuh dengan mandat mandiri, disatukan oleh komitmen nilai nusantara.
                </h3>
                <p class="mt-4 text-sm sm:text-base text-gray-300 leading-relaxed font-normal" x-text="$store.lang.t('Website utama YOIN tidak menggantikan keberadaan brand atau unit kerja individual. Kami menyediakan lapisan fondasi tata kelola, infrastruktur teknologi terpadu, dan jaringan strategis agar setiap entitas dapat fokus menyelesaikan masalah mendasar di bidangnya.', 'YOIN\'s primary website does not replace individual initiative brands or units. We provide the governance foundation, integrated technology infrastructure, and strategic ecosystem network so each entity can focus on solving critical challenges in its domain.')">
                    Website utama YOIN tidak menggantikan keberadaan brand atau unit kerja individual. Kami menyediakan lapisan fondasi tata kelola, infrastruktur teknologi terpadu, dan jaringan strategis agar setiap entitas dapat fokus menyelesaikan masalah mendasar di bidangnya.
                </p>

                <div class="mt-8 flex flex-wrap items-center gap-4">
                    <a 
                        href="{{ route('public.portfolio.index') }}" 
                        class="px-6 py-3 rounded-xl bg-white text-gray-950 hover:bg-gray-100 font-bold text-xs tracking-wide transition-all shadow-sm cursor-pointer"
                    >
                        <span x-text="$store.lang.t('Jelajahi Arsip Karya & Portofolio', 'Explore Works & Portfolio Archive')">Jelajahi Arsip Karya & Portofolio</span> →
                    </a>
                    <a 
                        href="{{ route('public.collaboration.index') }}" 
                        class="px-6 py-3 rounded-xl bg-white/10 hover:bg-white/20 text-white font-bold text-xs tracking-wide transition-all border border-white/20 cursor-pointer"
                    >
                        <span x-text="$store.lang.t('Bermitra & Berkolaborasi', 'Partner & Collaborate')">Bermitra & Berkolaborasi</span>
                    </a>
                </div>
            </div>
        </div>

    </div>

    {{-- Fullscreen Image Lightbox Modal --}}
    <div 
        x-show="lightboxImg" 
        x-cloak 
        @keydown.escape.window="lightboxImg = null"
        @click="lightboxImg = null" 
        class="fixed inset-0 z-50 bg-black/85 backdrop-blur-md flex items-center justify-center p-4 cursor-zoom-out"
    >
        <div class="relative max-w-4xl max-h-[88vh] overflow-hidden rounded-3xl shadow-2xl bg-black border border-white/20" @click.stop>
            <img :src="lightboxImg" :alt="lightboxCaption" class="max-w-full max-h-[75vh] object-contain mx-auto">
            <div class="p-4 bg-gray-950 text-white flex items-center justify-between text-xs border-t border-white/10">
                <span class="font-bold truncate text-teal-200" x-text="lightboxCaption"></span>
                <button @click="lightboxImg = null" class="px-4 py-1.5 rounded-full bg-white/20 hover:bg-white/30 text-white font-bold cursor-pointer transition-colors">
                    ✕ <span x-text="$store.lang.t('Tutup', 'Close')">Tutup</span>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
