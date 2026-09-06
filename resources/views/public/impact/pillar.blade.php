@extends('public.layouts.app')

@section('title', $pillar->title_id . ' - Pilar #' . $pillar->pillar_number . ' | YOIN Inovasi Nusantara')

@section('content')
<div 
    x-data="{
        lightboxOpen: false,
        activeImage: '',
        activeCaption: '',
        openLightbox(img, caption) {
            this.activeImage = img;
            this.activeCaption = caption;
            this.lightboxOpen = true;
        }
    }" 
    class="bg-gray-50 text-gray-900 min-h-screen font-sans selection:bg-[#005952] selection:text-white"
>
    {{-- ======================================================== --}}
    {{-- 1. HERO BANNER & BREADCRUMB                              --}}
    {{-- ======================================================== --}}
    <section class="relative bg-gradient-to-b from-gray-950 via-gray-900 to-gray-950 text-white pt-32 sm:pt-40 pb-20 sm:pb-24 overflow-hidden">
        {{-- Ambient Glows & Grid Pattern --}}
        <div class="absolute inset-0 bg-[radial-gradient(#005952_1px,transparent_1px)] [background-size:28px_28px] opacity-20 pointer-events-none"></div>
        <div class="absolute top-1/3 left-1/2 -translate-x-1/2 w-[700px] h-[350px] bg-gradient-to-tr from-[#004741]/40 to-slate-800/40 blur-[130px] rounded-full pointer-events-none"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Breadcrumb --}}
            <nav class="flex items-center gap-2 text-xs font-mono text-gray-400 mb-6">
                <a href="{{ url('/') }}" class="hover:text-white transition-colors">Beranda</a>
                <span>/</span>
                <a href="{{ route('public.impact.index') }}" class="hover:text-white transition-colors">Dampak & ESG</a>
                <span>/</span>
                <span class="text-white font-bold">Pilar #0{{ $pillar->pillar_number }}</span>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
                {{-- Left Header Content --}}
                <div class="lg:col-span-7 space-y-6">
                    <div class="flex flex-wrap items-center gap-3">
                        <span class="px-3.5 py-1.5 rounded-full bg-white/10 text-white border border-white/20 text-xs font-mono font-bold tracking-wider">
                            PILAR #0{{ $pillar->pillar_number }}
                        </span>
                        <span class="text-xs font-mono font-extrabold uppercase tracking-[0.2em] text-gray-300">
                            {{ $pillar->name }}
                        </span>
                        @if($pillar->metric_value)
                            <span class="px-3 py-1 rounded-xl bg-[#005952] text-white text-xs font-mono font-black shadow-sm">
                                {{ $pillar->metric_value }}
                            </span>
                        @endif
                    </div>

                    <h1 class="text-3xl sm:text-5xl font-black tracking-tight text-white leading-tight">
                        <span x-text="$store.lang.t('{{ addslashes($pillar->title_id) }}', '{{ addslashes($pillar->title_en ?: $pillar->title_id) }}')">
                            {{ $pillar->title_id }}
                        </span>
                    </h1>

                    <p class="text-base sm:text-lg text-gray-300 leading-relaxed font-normal">
                        <span x-text="$store.lang.t('{{ addslashes($pillar->description_id) }}', '{{ addslashes($pillar->description_en ?: $pillar->description_id) }}')">
                            {{ $pillar->description_id }}
                        </span>
                    </p>

                    {{-- Metric Label if exists --}}
                    @if($pillar->metric_label_id)
                        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white/10 backdrop-blur-md border border-white/15 text-xs text-white font-semibold">
                            <span class="w-2 h-2 rounded-full bg-white animate-pulse"></span>
                            <span x-text="$store.lang.t('Target Capaian: {{ addslashes($pillar->metric_label_id) }}', 'Impact Focus: {{ addslashes($pillar->metric_label_en ?: $pillar->metric_label_id) }}')">
                                Target Capaian: {{ $pillar->metric_label_id }}
                            </span>
                        </div>
                    @endif

                    {{-- Actions --}}
                    <div class="pt-2 flex flex-wrap items-center gap-4">
                        <a 
                            href="{{ $pillar->target_url ?: 'https://siyota.org' }}" 
                            target="_blank" 
                            rel="noopener noreferrer"
                            class="inline-flex items-center gap-3 px-6 py-3.5 rounded-xl bg-[#004741] hover:bg-black text-white text-sm font-bold shadow-lg shadow-black/20 hover:shadow-xl transition-all duration-200 border border-white/20"
                        >
                            <span x-text="$store.lang.t('Lihat Dokumentasi Lengkap di siyota.org', 'Explore Complete Docs on siyota.org')">
                                Lihat Dokumentasi Lengkap di siyota.org
                            </span>
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        </a>
                        <a 
                            href="{{ route('public.impact.index') }}#pillars" 
                            class="inline-flex items-center gap-2 px-5 py-3.5 rounded-xl bg-white/10 hover:bg-white/20 text-white text-sm font-bold border border-white/15 transition-colors"
                        >
                            <span>← Kembali ke 9 Pilar</span>
                        </a>
                    </div>
                </div>

                {{-- Right Hero Photo --}}
                <div class="lg:col-span-5">
                    <div class="relative rounded-3xl overflow-hidden shadow-2xl border border-white/10 group">
                        <img src="{{ $pillar->photo_image }}" alt="{{ $pillar->name }}" class="w-full h-80 sm:h-96 object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-gray-950 via-transparent to-transparent"></div>
                        <div class="absolute bottom-4 left-4 right-4 text-xs font-mono text-white flex items-center justify-between">
                            <span>Gerakan Terpadu SIYOTA</span>
                            <span>Pilar #0{{ $pillar->pillar_number }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ======================================================== --}}
    {{-- 2. KENAPA ADA PILAR INI & KITA NGAPAIN                   --}}
    {{-- ======================================================== --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-20">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 sm:gap-12">
            
            {{-- KENAPA ADA PILAR INI? (LATAR BELAKANG) --}}
            <div class="bg-white rounded-3xl border border-slate-200 p-8 sm:p-10 shadow-sm relative overflow-hidden">
                <div class="relative">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-lg bg-slate-900 border border-slate-800 text-white text-xs font-bold font-mono uppercase tracking-wider mb-4">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>Latar Belakang Mandat</span>
                    </div>

                    <h2 class="text-2xl sm:text-3xl font-black text-gray-900 leading-tight">
                        <span x-text="$store.lang.t('Kenapa Ada Pilar Ini?', 'Why Does This Pillar Exist?')">
                            Kenapa Ada Pilar Ini?
                        </span>
                    </h2>

                    <p class="mt-4 text-sm sm:text-base text-gray-700 leading-relaxed font-normal">
                        <span x-text="$store.lang.t('{{ addslashes($pillar->why_it_matters_id ?: $pillar->description_id) }}', '{{ addslashes($pillar->why_it_matters_en ?: $pillar->description_en ?: $pillar->description_id) }}')">
                            {{ $pillar->why_it_matters_id ?: $pillar->description_id }}
                        </span>
                    </p>
                </div>
            </div>

            {{-- KITA NGAPAIN? (AKSI NYATA & PROGRAM TERPADU) --}}
            <div class="bg-white rounded-3xl border border-slate-200 p-8 sm:p-10 shadow-sm relative overflow-hidden">
                <div class="relative">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-lg bg-slate-900 border border-slate-800 text-white text-xs font-bold font-mono uppercase tracking-wider mb-4">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        <span>Intervensi & Solusi Nyata</span>
                    </div>

                    <h2 class="text-2xl sm:text-3xl font-black text-gray-900 leading-tight">
                        <span x-text="$store.lang.t('Aksi Lapangan: Kita Ngapain?', 'Field Action: What We Do')">
                            Aksi Lapangan: Kita Ngapain?
                        </span>
                    </h2>

                    <p class="mt-4 text-sm sm:text-base text-gray-700 leading-relaxed font-normal">
                        <span x-text="$store.lang.t('{{ addslashes($pillar->what_we_do_id ?: $pillar->description_id) }}', '{{ addslashes($pillar->what_we_do_en ?: $pillar->description_en ?: $pillar->description_id) }}')">
                            {{ $pillar->what_we_do_id ?: $pillar->description_id }}
                        </span>
                    </p>
                </div>
            </div>

        </div>
    </section>

    {{-- ======================================================== --}}
    {{-- 3. KETERKAITAN SDGs, PROGRAM DUNIA & AGENDA NASIONAL     --}}
    {{-- ======================================================== --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16 sm:pb-20">
        <div class="bg-white rounded-3xl border border-gray-200 p-8 sm:p-12 shadow-xs space-y-10">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-[#005952]"></span>
                    <span class="text-xs font-mono font-bold tracking-widest text-[#005952] uppercase">KESELARASAN STRATEGIS & KEPATUHAN ESG</span>
                </div>
                <h3 class="text-2xl sm:text-3xl font-black text-gray-900">
                    Keterkaitan SDGs PBB & Agenda Prioritas Nasional
                </h3>
                <p class="text-sm text-gray-600 mt-1 max-w-2xl">
                    Seluruh program dan aksi lapangan pada pilar ini dirancang terhubung langsung dengan target Tujuan Pembangunan Berkelanjutan (SDGs) serta agenda pembangunan nasional Republik Indonesia.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                {{-- SDGs PBB --}}
                @php
                    $sdgs = $pillar->sdgs ?? [];
                @endphp
                <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 space-y-4">
                    <div class="flex items-center gap-2 font-black text-slate-900 text-sm uppercase tracking-wider">
                        <svg class="w-5 h-5 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"/></svg>
                        <span>SDGs PBB Terkait</span>
                    </div>

                    @if(!empty($sdgs))
                        <div class="space-y-2">
                            @foreach($sdgs as $sdg)
                                <div class="px-3 py-2 rounded-xl bg-white border border-slate-200 text-xs font-bold text-slate-900 shadow-2xs flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-slate-700"></span>
                                    <span>{{ $sdg }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-xs text-gray-500">Mendukung Tujuan Pembangunan Berkelanjutan PBB secara terpadu.</p>
                    @endif
                </div>

                {{-- Program Dunia & Konvensi Internasional --}}
                @php
                    $globals = $pillar->global_programs ?? [];
                @endphp
                <div class="p-6 rounded-2xl bg-blue-50/50 border border-blue-200 space-y-4">
                    <div class="flex items-center gap-2 font-black text-blue-950 text-sm uppercase tracking-wider">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>
                        <span>Program & Konvensi Dunia</span>
                    </div>

                    @if(!empty($globals))
                        <div class="space-y-2">
                            @foreach($globals as $gp)
                                <div class="px-3 py-2 rounded-xl bg-white border border-blue-200 text-xs font-bold text-blue-900 shadow-2xs flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                                    <span>{{ $gp }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-xs text-gray-500">Selaras dengan inisiatif dan kerangka kerja multilateral global.</p>
                    @endif
                </div>

                {{-- Agenda & Program Nasional RI --}}
                @php
                    $nationals = $pillar->national_programs ?? [];
                @endphp
                <div class="p-6 rounded-2xl bg-purple-50/50 border border-purple-200 space-y-4">
                    <div class="flex items-center gap-2 font-black text-purple-950 text-sm uppercase tracking-wider">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        <span>Agenda Nasional RI</span>
                    </div>

                    @if(!empty($nationals))
                        <div class="space-y-2">
                            @foreach($nationals as $np)
                                <div class="px-3 py-2 rounded-xl bg-white border border-purple-200 text-xs font-bold text-purple-900 shadow-2xs flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-purple-500"></span>
                                    <span>{{ $np }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-xs text-gray-500">Mendukung prioritas pembangunan nasional Republik Indonesia.</p>
                    @endif

                    @if($pillar->target_beneficiaries)
                        <div class="pt-2 border-t border-purple-200/80">
                            <span class="text-[10px] text-purple-700 font-bold uppercase tracking-wider block">Sasaran Penerima Manfaat:</span>
                            <span class="text-xs text-purple-950 font-medium">{{ $pillar->target_beneficiaries }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    {{-- ======================================================== --}}
    {{-- 3.5. DOKUMENTASI VIDEO YOUTUBE (JIKA TERSEDIA)           --}}
    {{-- ======================================================== --}}
    @if($pillar->youtube_embed_url)
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16 sm:pb-20">
            <div class="bg-gradient-to-br from-gray-950 via-gray-900 to-gray-950 rounded-3xl border border-gray-800 p-8 sm:p-12 shadow-xl text-white space-y-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-lg bg-red-950/80 border border-red-800/80 text-red-300 text-xs font-bold font-mono uppercase tracking-wider mb-2">
                            <svg class="w-4 h-4 text-red-400" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                            <span>DOKUMENTASI VIDEO LAPANGAN</span>
                        </div>
                        <h3 class="text-2xl sm:text-3xl font-black text-white">
                            Video Aksi & Liputan Lapangan
                        </h3>
                        <p class="text-xs sm:text-sm text-gray-400 mt-1">
                            Saksikan tayangan langsung rekam jejak, wawancara penerima manfaat, dan realisasi program pilar ini.
                        </p>
                    </div>
                    @if($pillar->youtube_url)
                        <a 
                            href="{{ $pillar->youtube_url }}" 
                            target="_blank" 
                            rel="noopener noreferrer" 
                            class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-red-600 hover:bg-red-700 text-white text-xs font-bold transition-colors shrink-0 shadow-sm"
                        >
                            <span>Tonton di YouTube</span>
                            <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        </a>
                    @endif
                </div>

                <div class="relative w-full aspect-video rounded-2xl overflow-hidden bg-black shadow-2xl border border-white/10">
                    <iframe 
                        src="{{ $pillar->youtube_embed_url }}" 
                        title="{{ $pillar->name }} Video Dokumentasi" 
                        class="w-full h-full" 
                        frameborder="0" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                        allowfullscreen
                    ></iframe>
                </div>
            </div>
        </section>
    @endif

    {{-- ======================================================== --}}
    {{-- 4. DOKUMEN GALERI AKSI LAPANGAN                          --}}
    {{-- ======================================================== --}}
    @php
        $gallery = $pillar->gallery ?? [];
    @endphp
    @if(!empty($gallery) && count($gallery) > 0)
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-20">
            <div class="bg-white rounded-3xl border border-gray-200 p-8 sm:p-12 shadow-xs space-y-8">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <div class="flex items-center gap-2 mb-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-purple-600"></span>
                            <span class="text-xs font-mono font-bold tracking-widest text-purple-700 uppercase">DOKUMENTASI VISUAL LAPANGAN</span>
                        </div>
                        <h3 class="text-2xl sm:text-3xl font-black text-gray-900">
                            Galeri Aksi Nyata & Jejak Lapangan
                        </h3>
                        <p class="text-sm text-gray-600 mt-1">
                            Foto dokumentasi langsung pelaksanaan aksi dan pendampingan bersama masyarakat di lapangan.
                        </p>
                    </div>
                    <span class="text-xs font-mono text-gray-400">Total {{ count($gallery) }} Dokumentasi</span>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach($gallery as $idx => $img)
                        <button 
                            type="button" 
                            @click="openLightbox('{{ $img }}', '{{ addslashes($pillar->name . ' - Dokumentasi #' . ($idx + 1)) }}')"
                            class="group/item relative aspect-4/3 rounded-2xl overflow-hidden bg-gray-900 border border-gray-200 hover:border-[#005952] transition-all cursor-pointer shadow-2xs hover:shadow-lg focus:outline-none"
                        >
                            <img src="{{ $img }}" alt="" class="w-full h-full object-cover group-hover/item:scale-105 transition-transform duration-300">
                            <div class="absolute inset-0 bg-black/0 group-hover/item:bg-black/30 transition-colors flex items-center justify-center">
                                <span class="px-3 py-1 rounded-lg bg-black/70 text-white text-[10px] font-mono opacity-0 group-hover/item:opacity-100 transition-opacity">Zoom Foto ↗</span>
                            </div>
                        </button>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- ======================================================== --}}
    {{-- 5. JELAJAHI 8 PILAR LAINNYA                              --}}
    {{-- ======================================================== --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-24">
        <div class="border-t border-gray-200 pt-12">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h3 class="text-xl sm:text-2xl font-black text-gray-900">Jelajahi Pilar Aksi Lainnya</h3>
                    <p class="text-xs sm:text-sm text-gray-500">Pelajari pilar gerakan terpadu lainnya di payung SIYOTA.</p>
                </div>
                <a href="{{ route('public.impact.index') }}#pillars" class="text-xs font-bold text-[#005952] hover:underline">
                    Semua 9 Pilar ↗
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach($otherPillars as $op)
                    <a 
                        href="{{ route('public.impact.pillar', $op->code) }}" 
                        class="p-4 rounded-2xl bg-white border border-gray-200 hover:border-[#005952] hover:shadow-md transition-all flex items-center gap-3.5 group"
                    >
                        <img src="{{ $op->photo_image }}" alt="" class="w-14 h-14 rounded-xl object-cover">
                        <div class="overflow-hidden">
                            <span class="text-[9px] font-mono font-bold text-teal-700 uppercase block tracking-wider">PILAR #0{{ $op->pillar_number }}</span>
                            <h4 class="text-xs font-black text-gray-900 group-hover:text-[#005952] transition-colors truncate">{{ $op->name }}</h4>
                            <p class="text-[11px] text-gray-500 truncate">{{ $op->title_id }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ======================================================== --}}
    {{-- LIGHTBOX MODAL FULLSCREEN ZOOM                           --}}
    {{-- ======================================================== --}}
    <div 
        x-show="lightboxOpen" 
        x-cloak 
        @keydown.escape.window="lightboxOpen = false"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/90 backdrop-blur-md"
    >
        <div @click.away="lightboxOpen = false" class="relative max-w-5xl w-full flex flex-col items-center">
            <button 
                @click="lightboxOpen = false" 
                class="absolute -top-12 right-0 text-white hover:text-slate-300 font-mono text-sm uppercase tracking-wider flex items-center gap-1.5 cursor-pointer"
            >
                <span>Tutup [ESC]</span>
                <span class="text-xl font-bold">&times;</span>
            </button>
            <div class="rounded-2xl overflow-hidden border border-white/20 shadow-2xl bg-black max-h-[80vh]">
                <img :src="activeImage" alt="Dokumentasi Zoom" class="w-full h-auto max-h-[80vh] object-contain">
            </div>
            <p x-text="activeCaption" class="text-xs sm:text-sm font-mono text-gray-300 mt-4 text-center max-w-2xl"></p>
        </div>
    </div>
</div>
@endsection
