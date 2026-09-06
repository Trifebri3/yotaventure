@extends('public.layouts.app')

@section('title', $initiative->name . ' | Profil Inisiatif Ekosistem YOTA')

@section('content')
<div class="bg-[#FAFCFC] min-h-screen pt-28 sm:pt-36 pb-24 text-gray-900 font-sans">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Breadcrumbs --}}
        <nav class="flex items-center gap-2 text-xs text-gray-500 mb-6">
            <a href="{{ url('/') }}" class="hover:text-[#005952] transition-colors" x-text="$store.lang.t('Beranda', 'Home')">Beranda</a>
            <span>/</span>
            <a href="{{ route('public.ecosystem.index') }}" class="hover:text-[#005952] transition-colors" x-text="$store.lang.t('Ekosistem', 'Ecosystem')">Ekosistem</a>
            <span>/</span>
            <a href="{{ route('public.ecosystem.domain', $initiative->domain->slug) }}" class="hover:text-[#005952] transition-colors">
                <span x-text="$store.lang.t('{{ addslashes($initiative->domain->name_id) }}', '{{ addslashes($initiative->domain->name_en) }}')">
                    {{ $initiative->domain->name_id }}
                </span>
            </a>
            <span>/</span>
            <span class="text-gray-900 font-semibold">{{ $initiative->name }}</span>
        </nav>

        {{-- ======================================================== --}}
        {{-- 1. INSTITUTIONAL HERO PROFILE BANNER                    --}}
        {{-- ======================================================== --}}
        <div class="bg-white rounded-3xl border border-gray-200/90 shadow-sm overflow-hidden relative mb-10">
            
            {{-- Optional Cover Image Backdrop --}}
            @if($initiative->cover_image)
                <div class="w-full h-44 sm:h-56 md:h-64 relative overflow-hidden bg-gray-900">
                    <img 
                        src="{{ $initiative->cover_image }}" 
                        alt="{{ $initiative->name }} Cover" 
                        class="w-full h-full object-cover opacity-80 filter brightness-95"
                    />
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>
                </div>
            @else
                <div class="w-full h-24 sm:h-32 bg-gradient-to-r from-[#004741] via-[#003430] to-slate-900"></div>
            @endif

            {{-- Profile Content Block --}}
            <div class="p-6 sm:p-10 relative z-10 -mt-16 sm:-mt-20">
                <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6">
                    
                    {{-- Left: Logo & Identity --}}
                    <div class="flex flex-col sm:flex-row items-start sm:items-end gap-5">
                        {{-- Logo Emblem --}}
                        <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-3xl bg-white p-2 shadow-xl border-4 border-white shrink-0 overflow-hidden flex items-center justify-center bg-slate-50 border-slate-200">
                            @if($initiative->logo_image)
                                <img src="{{ $initiative->logo_image }}" alt="{{ $initiative->name }} Logo" class="w-full h-full object-contain rounded-2xl" />
                            @else
                                <div class="w-full h-full rounded-2xl bg-[#005952] text-white flex items-center justify-center font-black text-2xl tracking-wider">
                                    {{ strtoupper(substr($initiative->name, 0, 2)) }}
                                </div>
                            @endif
                        </div>

                        {{-- Text Identity --}}
                        <div class="space-y-1">
                            <div class="flex items-center gap-2">
                                <span class="px-2.5 py-0.5 rounded-md text-[10px] font-extrabold uppercase tracking-wider bg-slate-900 text-white font-mono border border-slate-800">
                                    {{ $initiative->stage }}
                                </span>
                                <span class="px-2.5 py-0.5 rounded-md text-[10px] font-mono font-bold text-gray-500 bg-gray-100 border border-gray-200 uppercase">
                                    {{ $initiative->status }}
                                </span>
                                <a 
                                    href="{{ route('public.ecosystem.domain', $initiative->domain->slug) }}" 
                                    class="text-xs font-semibold text-teal-700 hover:text-[#005952] hover:underline"
                                >
                                    Domain: {{ $initiative->domain->name_id }}
                                </a>
                            </div>

                            <h1 class="text-2xl sm:text-4xl lg:text-5xl font-black text-gray-950 tracking-tight leading-tight">
                                {{ $initiative->name }}
                            </h1>

                            <p class="text-sm sm:text-base text-gray-600 font-medium max-w-2xl leading-relaxed">
                                <span x-text="$store.lang.t('{{ addslashes($initiative->tagline_id ?? '') }}', '{{ addslashes($initiative->tagline_en ?? '') }}')">
                                    {{ $initiative->tagline_id }}
                                </span>
                            </p>
                        </div>
                    </div>

                    {{-- Right: Direct Action Buttons (Lihat Website, Lihat Portofolio) --}}
                    <div class="flex flex-wrap sm:flex-nowrap items-center gap-2.5 shrink-0 self-stretch sm:self-end">
                        @if($initiative->external_website_url)
                            <a 
                                href="{{ $initiative->external_website_url }}" 
                                target="_blank" 
                                rel="noopener noreferrer" 
                                class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-2xl bg-[#005952] hover:bg-[#004741] text-white text-xs sm:text-sm font-bold tracking-wide transition-all shadow-md hover:scale-105"
                            >
                                <span>{{ $initiative->external_url_label ?: 'Kunjungi Situs Resmi →' }}</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                </svg>
                            </a>
                        @endif

                        <a 
                            href="#portofolio-karya" 
                            class="inline-flex items-center justify-center gap-1.5 px-5 py-3 rounded-2xl bg-white hover:bg-gray-100 text-gray-800 border border-gray-300 text-xs sm:text-sm font-bold tracking-wide transition-all shadow-xs"
                        >
                            <svg class="w-4 h-4 text-[#005952]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                            <span x-text="$store.lang.t('Lihat Portofolio', 'View Portfolio')">Lihat Portofolio</span>
                        </a>
                    </div>
                </div>

                {{-- Social Media Links & Contact Channels --}}
                @if(!empty($initiative->social_links) || $initiative->contact_email)
                    <div class="mt-6 pt-6 border-t border-gray-100 flex flex-wrap items-center justify-between gap-4">
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider mr-1" x-text="$store.lang.t('Kanal Resmi:', 'Official Channels:')">Kanal Resmi:</span>
                            
                            @if(!empty($initiative->social_links['instagram']))
                                <a href="{{ $initiative->social_links['instagram'] }}" target="_blank" rel="noopener" class="px-3 py-1.5 rounded-xl bg-gray-50 hover:bg-slate-200 border border-gray-200 text-gray-700 hover:text-slate-950 text-xs font-semibold flex items-center gap-1.5 transition-colors">
                                    <span>Instagram</span>
                                    <span class="text-[10px] text-gray-400">↗</span>
                                </a>
                            @endif

                            @if(!empty($initiative->social_links['linkedin']))
                                <a href="{{ $initiative->social_links['linkedin'] }}" target="_blank" rel="noopener" class="px-3 py-1.5 rounded-xl bg-gray-50 hover:bg-slate-200 border border-gray-200 text-gray-700 hover:text-slate-950 text-xs font-semibold flex items-center gap-1.5 transition-colors">
                                    <span>LinkedIn</span>
                                    <span class="text-[10px] text-gray-400">↗</span>
                                </a>
                            @endif

                            @if(!empty($initiative->social_links['github']))
                                <a href="{{ $initiative->social_links['github'] }}" target="_blank" rel="noopener" class="px-3 py-1.5 rounded-xl bg-gray-50 hover:bg-slate-200 border border-gray-200 text-gray-700 hover:text-slate-950 text-xs font-semibold flex items-center gap-1.5 transition-colors">
                                    <span>GitHub</span>
                                    <span class="text-[10px] text-gray-400">↗</span>
                                </a>
                            @endif

                            @if(!empty($initiative->social_links['youtube']))
                                <a href="{{ $initiative->social_links['youtube'] }}" target="_blank" rel="noopener" class="px-3 py-1.5 rounded-xl bg-gray-50 hover:bg-slate-200 border border-gray-200 text-gray-700 hover:text-slate-950 text-xs font-semibold flex items-center gap-1.5 transition-colors">
                                    <span>YouTube</span>
                                    <span class="text-[10px] text-gray-400">↗</span>
                                </a>
                            @endif
                        </div>

                        @if($initiative->contact_email)
                            <a href="mailto:{{ $initiative->contact_email }}" class="text-xs font-semibold text-[#005952] hover:underline flex items-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                <span>{{ $initiative->contact_email }}</span>
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        {{-- ======================================================== --}}
        {{-- 2. STRATEGIC ALIGNMENT: SDGS, ISU PEMERINTAH, FOKUS & LOKUS--}}
        {{-- ======================================================== --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            
            {{-- A. SDGs Alignment Card --}}
            <div class="bg-white rounded-3xl p-6 sm:p-7 border border-gray-200/90 shadow-sm flex flex-col justify-between">
                <div>
                    <div class="flex items-center gap-2.5 mb-3">
                        <span class="w-8 h-8 rounded-xl bg-blue-50 border border-blue-200 text-blue-700 flex items-center justify-center font-bold text-xs">
                            SDG
                        </span>
                        <div>
                            <h3 class="text-xs font-bold uppercase tracking-wider text-gray-900" x-text="$store.lang.t('Kaitan SDGs PBB', 'UN SDGs Alignment')">
                                Kaitan SDGs PBB
                            </h3>
                            <span class="text-[10px] text-gray-500" x-text="$store.lang.t('Tujuan Pembangunan Berkelanjutan', 'Sustainable Development Goals')">Tujuan Pembangunan Berkelanjutan</span>
                        </div>
                    </div>
                    <p class="text-xs text-gray-600 mb-4 leading-relaxed font-normal">
                        <span x-text="$store.lang.t('Inisiatif ini dirancang selaras dengan target pembangunan global:', 'This initiative directly contributes to global sustainable development targets:')">
                            Inisiatif ini dirancang selaras dengan target pembangunan global:
                        </span>
                    </p>
                    <div class="flex flex-wrap gap-2">
                        @if(!empty($initiative->sdgs))
                            @foreach($initiative->sdgs as $sdg)
                                <span class="px-3 py-1.5 rounded-xl text-xs font-semibold bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200/80 text-blue-900 flex items-center gap-1.5">
                                    <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                                    <span>{{ $sdg }}</span>
                                </span>
                            @endforeach
                        @else
                            <span class="px-3 py-1.5 rounded-xl text-xs font-semibold bg-blue-50 text-blue-900 border border-blue-200/70">
                                SDG 9: Industri, Inovasi & Infrastruktur
                            </span>
                            <span class="px-3 py-1.5 rounded-xl text-xs font-semibold bg-blue-50 text-blue-900 border border-blue-200/70">
                                SDG 8: Pekerjaan Layak & Pertumbuhan Ekonomi
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- B. Agenda & Isu Strategis Pemerintah --}}
            <div class="bg-white rounded-3xl p-6 sm:p-7 border border-gray-200/90 shadow-sm flex flex-col justify-between">
                <div>
                    <div class="flex items-center gap-2.5 mb-3">
                        <span class="w-8 h-8 rounded-xl bg-slate-100 border border-slate-300 text-slate-900 flex items-center justify-center font-bold text-xs">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </span>
                        <div>
                            <h3 class="text-xs font-bold uppercase tracking-wider text-gray-900" x-text="$store.lang.t('Isu & Agenda Pemerintah', 'National Policy Agenda')">
                                Isu & Agenda Pemerintah
                            </h3>
                            <span class="text-[10px] text-gray-500" x-text="$store.lang.t('Prioritas Transformasi Nasional', 'National Strategic Priorities')">Prioritas Transformasi Nasional</span>
                        </div>
                    </div>
                    <p class="text-xs text-gray-600 mb-4 leading-relaxed font-normal">
                        <span x-text="$store.lang.t('Terkoneksi langsung dengan isu kebijakan publik dan hilirisasi nasional:', 'Directly addressing public policy priorities and national downstreaming:')">
                            Terkoneksi langsung dengan isu kebijakan publik dan hilirisasi nasional:
                        </span>
                    </p>
                    <div class="flex flex-wrap gap-2">
                        @if(!empty($initiative->government_issues))
                            @foreach($initiative->government_issues as $issue)
                                <span class="px-3 py-1.5 rounded-xl text-xs font-semibold bg-slate-100 text-slate-900 border border-slate-300 flex items-center gap-1.5">
                                    <span class="w-2 h-2 rounded-full bg-slate-700"></span>
                                    <span>{{ $issue }}</span>
                                </span>
                            @endforeach
                        @else
                            <span class="px-3 py-1.5 rounded-xl text-xs font-semibold bg-slate-100 text-slate-900 border border-slate-300">
                                Kedaulatan Inovasi & Kemandirian Teknologi
                            </span>
                            <span class="px-3 py-1.5 rounded-xl text-xs font-semibold bg-slate-100 text-slate-900 border border-slate-300">
                                Peningkatan Daya Saing Ekonomi Digital
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- C. Fokus Tematik & Lokus Intervensi --}}
            <div class="bg-white rounded-3xl p-6 sm:p-7 border border-gray-200/90 shadow-sm flex flex-col justify-between">
                <div>
                    <div class="flex items-center gap-2.5 mb-3">
                        <span class="w-8 h-8 rounded-xl bg-teal-50 border border-teal-200 text-[#005952] flex items-center justify-center font-bold text-xs">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </span>
                        <div>
                            <h3 class="text-xs font-bold uppercase tracking-wider text-gray-900" x-text="$store.lang.t('Fokus & Lokus Wilayah', 'Focus & Target Locus')">
                                Fokus & Lokus Wilayah
                            </h3>
                            <span class="text-[10px] text-gray-500" x-text="$store.lang.t('Cakupan Daerah Intervensi', 'Geographical Intervention Scope')">Cakupan Daerah Intervensi</span>
                        </div>
                    </div>

                    {{-- Lokus Wilayah --}}
                    <div class="mb-3.5 p-3 rounded-2xl bg-teal-50/60 border border-teal-200/70">
                        <span class="text-[10px] font-bold text-[#005952] uppercase tracking-wider block mb-0.5" x-text="$store.lang.t('Lokus Wilayah:', 'Target Locus:')">Lokus Wilayah:</span>
                        <p class="text-xs font-semibold text-teal-950">
                            {{ $initiative->locus ?: 'Nasional (Headquarter: Bandung, Jawa Barat)' }}
                        </p>
                    </div>

                    {{-- Fokus Tematik --}}
                    <div>
                        <span class="text-[10px] font-bold text-gray-500 uppercase tracking-wider block mb-1.5" x-text="$store.lang.t('Area Fokus:', 'Focus Areas:')">Area Fokus:</span>
                        <div class="flex flex-wrap gap-1.5">
                            @if(!empty($initiative->focus_areas))
                                @foreach($initiative->focus_areas as $focus)
                                    <span class="px-2.5 py-1 rounded-lg text-xs font-medium bg-gray-100 text-gray-700">
                                        {{ $focus }}
                                    </span>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- ======================================================== --}}
        {{-- 3. PROBLEM & MISSION BLUEPRINT                          --}}
        {{-- ======================================================== --}}
        <div class="bg-white rounded-3xl p-8 sm:p-10 border border-gray-200/90 shadow-sm mb-12">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                {{-- Masalah Riil yang Diselesaikan --}}
                <div class="bg-slate-50 rounded-2xl p-6 border-l-4 border-slate-700 border-y border-r border-slate-200">
                    <div class="flex items-center gap-2 text-xs font-bold text-slate-900 mb-2.5 uppercase tracking-wider">
                        <span class="w-2.5 h-2.5 rounded-full bg-slate-800"></span>
                        <span x-text="$store.lang.t('Masalah Riil yang Diselesaikan', 'Real Problem Addressed')">
                            Masalah Riil yang Diselesaikan
                        </span>
                    </div>
                    <p class="text-sm text-slate-800 leading-relaxed font-normal">
                        <span x-text="$store.lang.t('{{ addslashes($initiative->problem_statement_id ?? '') }}', '{{ addslashes($initiative->problem_statement_en ?? '') }}')">
                            {{ $initiative->problem_statement_id }}
                        </span>
                    </p>
                </div>

                {{-- Mandat Misi & Nilai Inti --}}
                <div class="bg-slate-50 rounded-2xl p-6 border-l-4 border-[#004741] border-y border-r border-slate-200">
                    <div class="flex items-center gap-2 text-xs font-bold text-[#004741] mb-2.5 uppercase tracking-wider">
                        <span class="w-2.5 h-2.5 rounded-full bg-[#004741]"></span>
                        <span x-text="$store.lang.t('Mandat Misi & Rekayasa Nilai', 'Mission Mandate & Value Engineering')">
                            Mandat Misi & Rekayasa Nilai
                        </span>
                    </div>
                    <p class="text-sm text-slate-800 leading-relaxed font-normal">
                        <span x-text="$store.lang.t('{{ addslashes($initiative->mission_id ?? '') }}', '{{ addslashes($initiative->mission_en ?? '') }}')">
                            {{ $initiative->mission_id }}
                        </span>
                    </p>
                </div>
            </div>

            {{-- Storytelling Section --}}
            @if($initiative->story_id)
                <div class="mt-8 pt-8 border-t border-gray-100">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-3" x-text="$store.lang.t('Kisah & Filosofi Lahirnya Inisiatif', 'Story & Genesis of the Initiative')">
                        Kisah & Filosofi Lahirnya Inisiatif
                    </h3>
                    <div class="prose prose-sm max-w-none text-gray-700 leading-relaxed font-normal">
                        <span x-text="$store.lang.t('{{ addslashes($initiative->story_id) }}', '{{ addslashes($initiative->story_en ?: $initiative->story_id) }}')">
                            {{ $initiative->story_id }}
                        </span>
                    </div>
                </div>
            @endif
        </div>

        {{-- ======================================================== --}}
        {{-- 4. DOKUMENTASI & GALERI FOTO KEGIATAN (GALLERY)          --}}
        {{-- ======================================================== --}}
        @if(!empty($initiative->gallery))
            <div class="mb-14">
                <div class="flex items-center justify-between pb-3 border-b border-gray-200 mb-6">
                    <div>
                        <h2 class="text-2xl font-black text-gray-950 tracking-tight" x-text="$store.lang.t('Dokumentasi & Galeri Visual', 'Documentation & Visual Gallery')">
                            Dokumentasi & Galeri Visual
                        </h2>
                        <p class="text-xs text-gray-500 mt-1" x-text="$store.lang.t('Aktivitas lapangan, laboratorium rekayasa, dan implementasi nyata inisiatif.', 'Field activities, engineering labs, and real on-ground deployment.')">
                            Aktivitas lapangan, laboratorium rekayasa, dan implementasi nyata inisiatif.
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-5">
                    @foreach($initiative->gallery as $photo)
                        <div class="group relative rounded-3xl overflow-hidden bg-gray-100 aspect-video shadow-xs border border-gray-200 hover:shadow-xl transition-all duration-300">
                            <img 
                                src="{{ $photo }}" 
                                alt="{{ $initiative->name }} Foto" 
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" 
                            />
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-end p-4">
                                <span class="text-xs text-white font-semibold">{{ $initiative->name }} • Dokumentasi</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- ======================================================== --}}
        {{-- 5. PRODUK, PLATFORM & GERAKAN TURUNAN                   --}}
        {{-- ======================================================== --}}
        @if($initiative->products->isNotEmpty())
            <div class="mb-14 space-y-6">
                <div class="pb-3 border-b border-gray-200">
                    <h2 class="text-2xl font-black text-gray-950 tracking-tight" x-text="$store.lang.t('Produk & Platform yang Dihasilkan', 'Products & Platforms Built')">
                        Produk & Platform yang Dihasilkan
                    </h2>
                    <p class="text-xs text-gray-500 mt-1" x-text="$store.lang.t('Lini produk, teknologi, atau gerakan turunan di bawah bendera inisiatif ini.', 'Product lines, technologies, or derivative movements spawned under this initiative.')">
                        Lini produk, teknologi, atau gerakan turunan di bawah bendera inisiatif ini.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($initiative->products as $product)
                        <div class="bg-white rounded-3xl border border-gray-200 p-6 shadow-xs flex flex-col justify-between hover:shadow-md hover:border-[#005952]/40 transition-all">
                            <div>
                                <div class="flex items-center justify-between mb-3">
                                    <span class="px-2.5 py-0.5 rounded-md text-[10px] font-extrabold uppercase tracking-wider bg-teal-50 text-[#005952] border border-teal-200">
                                        {{ $product->type }}
                                    </span>
                                    <span class="text-xs font-bold text-gray-500 uppercase">{{ $product->status }}</span>
                                </div>
                                <h3 class="text-xl font-black text-gray-950">{{ $product->name }}</h3>
                                <p class="text-xs text-gray-600 mt-1">
                                    <span x-text="$store.lang.t('{{ addslashes($product->description_id ?? '') }}', '{{ addslashes($product->description_en ?? '') }}')">
                                        {{ $product->description_id }}
                                    </span>
                                </p>

                                {{-- Problem & Solution --}}
                                <div class="mt-4 space-y-2.5 text-xs">
                                    <div class="p-3 bg-slate-50 border-l-4 border-slate-700 border-y border-r border-slate-200 rounded-xl">
                                        <span class="font-bold text-slate-900 block mb-0.5">Tantangan:</span>
                                        <span class="text-slate-700" x-text="$store.lang.t('{{ addslashes($product->problem_statement_id ?? '') }}', '{{ addslashes($product->problem_statement_en ?? '') }}')">
                                            {{ $product->problem_statement_id }}
                                        </span>
                                    </div>
                                    <div class="p-3 bg-slate-50 border-l-4 border-[#004741] border-y border-r border-slate-200 rounded-xl">
                                        <span class="font-bold text-[#004741] block mb-0.5">Solusi:</span>
                                        <span class="text-slate-800" x-text="$store.lang.t('{{ addslashes($product->solution_statement_id ?? '') }}', '{{ addslashes($product->solution_statement_en ?? '') }}')">
                                            {{ $product->solution_statement_id }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            @if($product->website_url)
                                <div class="mt-5 pt-4 border-t border-gray-100 text-right">
                                    <a href="{{ $product->website_url }}" target="_blank" rel="noopener" class="text-xs font-bold text-[#005952] hover:underline inline-flex items-center gap-1">
                                        <span>Buka Platform Produk</span> →
                                    </a>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- ======================================================== --}}
        {{-- 6. PORTOFOLIO KARYA & PROYEK NYATA                      --}}
        {{-- ======================================================== --}}
        <div id="portofolio-karya" class="mb-14 space-y-6">
            <div class="flex items-center justify-between pb-3 border-b border-gray-200">
                <div>
                    <h2 class="text-2xl font-black text-gray-950 tracking-tight" x-text="$store.lang.t('Portofolio Karya & Proyek Nyata', 'Tangible Works & Portfolio Projects')">
                        Portofolio Karya & Proyek Nyata
                    </h2>
                    <p class="text-xs text-gray-500 mt-1" x-text="$store.lang.t('Studi kasus dan implementasi nyata yang telah diselesaikan.', 'Case studies and real implementations successfully deployed.')">
                        Studi kasus dan implementasi nyata yang telah diselesaikan.
                    </p>
                </div>
                <a href="{{ route('public.portfolio.index', ['initiative' => $initiative->slug]) }}" class="text-xs font-bold text-[#005952] hover:underline">
                    Semua Portofolio Ekosistem →
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($initiative->projects as $project)
                    <div class="bg-white rounded-3xl border border-gray-200 p-6 shadow-xs flex flex-col justify-between hover:shadow-md hover:border-[#005952]/40 transition-all">
                        <div>
                            <div class="flex items-center justify-between mb-3 text-[11px] text-gray-500">
                                <span class="font-bold text-gray-700">{{ $project->client?->name ?? 'Internal Inisiatif' }}</span>
                                <span class="px-2 py-0.5 rounded bg-slate-900 text-white font-bold text-[10px]">{{ $project->status }}</span>
                            </div>

                            <h3 class="text-lg font-black text-gray-950 tracking-tight">
                                {{ $project->name }}
                            </h3>

                            {{-- Problem Statement --}}
                            <div class="mt-3 p-3 bg-slate-50 border-l-4 border-slate-700 border-y border-r border-slate-200 rounded-xl text-xs">
                                <span class="font-bold text-slate-900 block mb-0.5" x-text="$store.lang.t('Tantangan:', 'Challenge:')">Tantangan:</span>
                                <p class="text-slate-700 line-clamp-2">
                                    <span x-text="$store.lang.t('{{ addslashes($project->problem_statement_id ?? '') }}', '{{ addslashes($project->problem_statement_en ?? '') }}')">
                                        {{ $project->problem_statement_id }}
                                    </span>
                                </p>
                            </div>

                            {{-- Outcome / Result --}}
                            <div class="mt-2.5 p-3 bg-slate-50 border-l-4 border-[#004741] border-y border-r border-slate-200 rounded-xl text-xs">
                                <span class="font-bold text-[#004741] block mb-0.5" x-text="$store.lang.t('Hasil Terukur:', 'Measurable Outcome:')">Hasil Terukur:</span>
                                <p class="text-slate-800 line-clamp-2">
                                    <span x-text="$store.lang.t('{{ addslashes($project->result_outcome_id ?? '') }}', '{{ addslashes($project->result_outcome_en ?? '') }}')">
                                        {{ $project->result_outcome_id }}
                                    </span>
                                </p>
                            </div>

                            {{-- Tech badges --}}
                            @if(!empty($project->technologies))
                                <div class="mt-3 flex flex-wrap gap-1">
                                    @foreach(array_slice($project->technologies, 0, 3) as $tech)
                                        <span class="px-2 py-0.5 rounded text-[10px] bg-gray-100 text-gray-600 font-medium">
                                            {{ $tech }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <div class="mt-6 pt-4 border-t border-gray-100 flex items-center justify-between">
                            <a href="{{ route('public.portfolio.show', $project->slug) }}" class="text-xs font-bold text-[#005952] hover:underline inline-flex items-center gap-1">
                                <span x-text="$store.lang.t('Pelajari Studi Kasus', 'View Case Study')">Pelajari Studi Kasus</span> →
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 bg-white p-8 rounded-2xl text-center border border-dashed border-gray-300 text-gray-400 text-xs">
                        Belum ada karya publik yang tercatat untuk inisiatif ini.
                    </div>
                @endforelse
            </div>
        </div>

        {{-- ======================================================== --}}
        {{-- 7. COLLABORATION CTA FOOTER                             --}}
        {{-- ======================================================== --}}
        <div class="bg-gradient-to-br from-[#004741] via-[#003430] to-slate-950 rounded-3xl p-8 sm:p-12 text-white text-center sm:text-left flex flex-col sm:flex-row items-center justify-between gap-6 shadow-xl">
            <div class="max-w-xl">
                <span class="px-3 py-1 rounded-full bg-white/15 text-white border border-white/20 text-xs font-bold uppercase tracking-wider inline-block mb-2">
                    Kemitraan & Kolaborasi
                </span>
                <h3 class="text-2xl sm:text-3xl font-black tracking-tight">
                    Ingin bermitra dengan {{ $initiative->name }}?
                </h3>
                <p class="text-slate-200 text-xs sm:text-sm mt-1 leading-relaxed font-normal">
                    Diskusikan solusi rekayasa, riset aksi, atau kolaborasi rantai nilai untuk menciptakan dampak berkelanjutan bersama.
                </p>
            </div>
            <div class="flex items-center gap-3 shrink-0">
                <a 
                    href="{{ route('public.collaboration.index') }}" 
                    class="px-6 py-3 rounded-2xl bg-white hover:bg-slate-100 text-slate-950 font-bold text-xs sm:text-sm shadow-md transition-transform hover:scale-105"
                >
                    Jajaki Kolaborasi →
                </a>
            </div>
        </div>

    </div>
</div>
@endsection
