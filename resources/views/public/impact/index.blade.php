@extends('public.layouts.app')

@section('title', 'Dampak & Komitmen ESG - 9 Pilar Aksi Nyata | YOIN Inovasi Nusantara')

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
        },
        detailModalOpen: false,
        activePillar: null,
        openPillarDetail(pillar) {
            this.activePillar = pillar;
            this.detailModalOpen = true;
        }
    }" 
    class="bg-gray-50 text-gray-900 min-h-screen font-sans selection:bg-[#005952] selection:text-white"
>
    {{-- ======================================================== --}}
    {{-- 1. HERO BANNER & SIYOTA GATEWAY                          --}}
    {{-- ======================================================== --}}
    <section class="relative bg-gradient-to-b from-gray-950 via-gray-900 to-gray-950 text-white pt-32 sm:pt-40 pb-20 sm:pb-24 overflow-hidden">
        {{-- Ambient Glows & Grid Pattern --}}
        <div class="absolute inset-0 bg-[radial-gradient(#005952_1px,transparent_1px)] [background-size:28px_28px] opacity-20 pointer-events-none"></div>
        <div class="absolute top-1/4 left-1/2 -translate-x-1/2 w-[700px] h-[350px] bg-gradient-to-tr from-[#004741]/40 to-slate-800/40 blur-[130px] rounded-full pointer-events-none"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl">
                {{-- Category Pill --}}
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-white/15 text-xs font-semibold text-white mb-6 shadow-sm">
                    <span class="w-2 h-2 rounded-full bg-white animate-pulse"></span>
                    <span class="font-mono tracking-[0.2em] uppercase" x-text="$store.lang.t('DAMPAK SOSIAL & TATA KELOLA ESG', 'SOCIAL IMPACT & ESG GOVERNANCE')">
                        DAMPAK SOSIAL & TATA KELOLA ESG
                    </span>
                </div>

                <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black tracking-tight leading-tight text-white">
                    <span x-text="$store.lang.t('9 Pilar Aksi Nyata & Tata Kelola Berkelanjutan', '9 Pillars of Tangible Action & Sustainable Governance')">
                        9 Pilar Aksi Nyata & Tata Kelola Berkelanjutan
                    </span>
                </h1>

                <p class="mt-6 text-base sm:text-lg text-gray-300 leading-relaxed font-normal" x-text="$store.lang.t('Komitmen keberlanjutan dan filantropi terpadu kami diwujudkan melalui aksi langsung di lapangan. Seluruh program pemberdayaan, kemanusiaan, dan kepatuhan ESG didokumentasikan dan diorkestrasi secara transparan melalui payung gerakan SIYOTA.', 'Our commitment to sustainability and integrated social action is realized through frontline field execution. All community empowerment, humanitarian missions, and ESG compliance are transparently orchestrated and documented via SIYOTA.')">
                    Komitmen keberlanjutan dan filantropi terpadu kami diwujudkan melalui aksi langsung di lapangan. Seluruh program pemberdayaan, kemanusiaan, dan kepatuhan ESG didokumentasikan dan diorkestrasi secara transparan melalui payung gerakan SIYOTA.
                </p>

                {{-- Direct Gateway Button to SIYOTA --}}
                <div class="mt-8 flex flex-wrap items-center gap-4">
                    <a 
                        href="https://siyota.org" 
                        target="_blank" 
                        rel="noopener noreferrer"
                        class="inline-flex items-center justify-center gap-3 px-6 py-3.5 rounded-xl bg-[#004741] hover:bg-black text-white text-sm font-bold shadow-lg shadow-black/20 hover:shadow-xl transition-all duration-200 transform hover:-translate-y-0.5 border border-white/20"
                    >
                        <span x-text="$store.lang.t('Kunjungi Portal SIYOTA (siyota.org)', 'Visit SIYOTA Portal (siyota.org)')">
                            Kunjungi Portal SIYOTA (siyota.org)
                        </span>
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                    </a>

                    <a 
                        href="#dokumen-esg" 
                        class="inline-flex items-center justify-center gap-2 px-5 py-3.5 rounded-xl bg-white/10 hover:bg-white/15 text-white text-sm font-semibold border border-white/20 transition-all duration-200"
                    >
                        <span x-text="$store.lang.t('Unduh Laporan ESG', 'Download ESG Reports')">Unduh Laporan ESG</span>
                        <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- ======================================================== --}}
    {{-- 2. ANGKA STATISTIK DAMPAK (CONTROLLED VIA ADMIN)          --}}
    {{-- ======================================================== --}}
    @if(isset($metrics) && $metrics->isNotEmpty())
    <section class="relative -mt-10 z-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-3xl p-6 sm:p-8 md:p-10 shadow-xl border border-gray-200/80 backdrop-blur-xl">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-8 divide-y sm:divide-y-0 sm:divide-x divide-gray-100">
                @foreach($metrics as $metric)
                    <div class="pt-4 sm:pt-0 sm:px-4 first:pt-0 first:px-0 flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between gap-2 mb-2">
                                <span class="text-3xl sm:text-4xl lg:text-5xl font-black text-gray-950 tracking-tight font-mono">
                                    {{ $metric->metric_value }}
                                </span>
                                <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-900 border border-slate-200 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                </div>
                            </div>
                            <h3 class="text-sm sm:text-base font-bold text-gray-900 leading-snug">
                                <span x-text="$store.lang.t('{{ addslashes($metric->label_id) }}', '{{ addslashes($metric->label_en ?: $metric->label_id) }}')">
                                    {{ $metric->label_id }}
                                </span>
                            </h3>
                            @if($metric->description_id)
                                <p class="text-xs text-gray-500 mt-1 leading-relaxed">
                                    <span x-text="$store.lang.t('{{ addslashes($metric->description_id) }}', '{{ addslashes($metric->description_en ?: $metric->description_id) }}')">
                                        {{ $metric->description_id }}
                                    </span>
                                </p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ======================================================== --}}
    {{-- 3. 9 PILAR AKSI BERKELANJUTAN & GALERI FOTO              --}}
    {{-- ======================================================== --}}
    <section class="py-20 sm:py-28 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-12 sm:mb-16">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-[#005952]"></span>
                    <span class="text-xs font-bold tracking-[0.24em] text-[#005952] uppercase font-sans" x-text="$store.lang.t('PILAR GERAKAN TERPADU', 'INTEGRATED IMPACT PILLARS')">
                        PILAR GERAKAN TERPADU
                    </span>
                </div>
                <h2 class="text-2xl sm:text-4xl font-black text-gray-950 tracking-tight">
                    <span x-text="$store.lang.t('9 Pilar Fokus Aksi Lapangan', '9 Action Pillars in the Field')">
                        9 Pilar Fokus Aksi Lapangan
                    </span>
                </h2>
                <p class="text-sm text-gray-600 mt-1 max-w-2xl" x-text="$store.lang.t('Setiap pilar memiliki mandat fokus nyata, metrik capaian terukur, galeri dokumentasi visual, dan terhubung langsung ke siyota.org.', 'Each pillar features a focused mandate, measurable impact metrics, field visual documentation, and direct integration with siyota.org.')">
                    Setiap pilar memiliki mandat fokus nyata, metrik capaian terukur, galeri dokumentasi visual, dan terhubung langsung ke siyota.org.
                </p>
            </div>
            <span class="text-xs font-mono font-bold text-white bg-slate-900 px-4 py-1.5 rounded-full border border-slate-800 shrink-0 self-start sm:self-auto">
                9 PILAR LENGKAP
            </span>
        </div>

        {{-- 9 Pillars Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($pillars as $pillar)
                <div class="bg-white rounded-3xl border border-gray-200/90 overflow-hidden shadow-xs hover:shadow-2xl hover:border-[#005952]/40 transition-all duration-300 flex flex-col justify-between group">
                    <div>
                        {{-- Pillar Photo Container with Number Badge --}}
                        <div class="relative h-56 sm:h-60 w-full overflow-hidden bg-gray-900">
                            <img 
                                src="{{ $pillar->photo_image }}" 
                                alt="{{ $pillar->name }}" 
                                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105 filter brightness-90 group-hover:brightness-100"
                                loading="lazy"
                            >
                            <div class="absolute inset-0 bg-gradient-to-t from-gray-950 via-gray-900/40 to-transparent"></div>

                            {{-- Number & Metric Badge --}}
                            <div class="absolute top-4 left-4 right-4 flex items-center justify-between z-10">
                                <span class="px-3 py-1 rounded-xl bg-black/70 backdrop-blur-md text-xs font-mono font-bold text-white border border-white/20 tracking-wider">
                                    PILAR #0{{ $pillar->pillar_number }}
                                </span>
                                <div class="flex items-center gap-1.5">
                                    @if($pillar->youtube_url)
                                        <button 
                                            type="button" 
                                            @click.stop="openPillarDetail({{ json_encode($pillar) }})" 
                                            class="px-2.5 py-1 rounded-xl bg-red-600/90 backdrop-blur-md text-xs font-bold text-white border border-red-400/40 tracking-tight shadow-sm flex items-center gap-1 hover:bg-red-700 transition-colors cursor-pointer"
                                            title="Tonton Video Dokumentasi"
                                        >
                                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                                            <span>Video</span>
                                        </button>
                                    @endif
                                    @if($pillar->metric_value)
                                        <span class="px-3 py-1 rounded-xl bg-[#004741] backdrop-blur-md text-xs font-mono font-extrabold text-white border border-white/20 tracking-tight shadow-sm">
                                            {{ $pillar->metric_value }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            {{-- Pillar Code & Name --}}
                            <div class="absolute bottom-4 left-5 right-5 z-10">
                                <span class="text-xs font-mono font-extrabold uppercase tracking-[0.2em] text-slate-300 block drop-shadow-xs">
                                    {{ $pillar->name }}
                                </span>
                                <h3 class="text-lg sm:text-xl font-black text-white leading-snug mt-1 drop-shadow-sm">
                                    <span x-text="$store.lang.t('{{ addslashes($pillar->title_id) }}', '{{ addslashes($pillar->title_en ?: $pillar->title_id) }}')">
                                        {{ $pillar->title_id }}
                                    </span>
                                </h3>
                            </div>
                        </div>

                        {{-- Pillar Description Content --}}
                        <div class="p-6">
                            <p class="text-xs sm:text-sm text-gray-600 leading-relaxed font-normal">
                                <span x-text="$store.lang.t('{{ addslashes($pillar->description_id) }}', '{{ addslashes($pillar->description_en ?: $pillar->description_id) }}')">
                                    {{ $pillar->description_id }}
                                </span>
                            </p>

                            {{-- Pillar Metric Label (If Available) --}}
                            @if($pillar->metric_label_id)
                                <div class="mt-4 flex items-center gap-2 text-xs font-semibold text-gray-700 bg-gray-50 px-3 py-2 rounded-xl border border-gray-200/80">
                                    <span class="w-1.5 h-1.5 rounded-full bg-[#005952]"></span>
                                    <span x-text="$store.lang.t('Capaian: {{ addslashes($pillar->metric_label_id) }}', 'Metric: {{ addslashes($pillar->metric_label_en ?: $pillar->metric_label_id) }}')">
                                        Capaian: {{ $pillar->metric_label_id }}
                                    </span>
                                </div>
                            @endif

                            {{-- SDGs Mini Badges --}}
                            @php
                                $pSdgs = $pillar->sdgs ?? [];
                            @endphp
                            @if(!empty($pSdgs))
                                <div class="mt-3 flex flex-wrap gap-1">
                                    @foreach(array_slice($pSdgs, 0, 2) as $sdgItem)
                                        <span class="px-2 py-0.5 rounded-md bg-slate-100 border border-slate-200 text-slate-800 text-[10px] font-semibold truncate max-w-[180px]">
                                            {{ $sdgItem }}
                                        </span>
                                    @endforeach
                                    @if(count($pSdgs) > 2)
                                        <span class="px-1.5 py-0.5 rounded-md bg-gray-100 text-gray-600 text-[9px] font-mono font-bold">
                                            +{{ count($pSdgs) - 2 }} SDGs
                                        </span>
                                    @endif
                                </div>
                            @endif

                            {{-- Interaktif Button: Kenapa Ada Pilar Ini & Kita Ngapain --}}
                            <button 
                                type="button" 
                                @click="openPillarDetail({{ json_encode($pillar) }})" 
                                class="w-full mt-4 flex items-center justify-between px-3.5 py-2.5 rounded-xl bg-slate-900 hover:bg-black text-white border border-slate-800 text-xs font-bold transition-all shadow-xs group/btn cursor-pointer"
                            >
                                <span class="flex items-center gap-1.5 truncate">
                                    <svg class="w-4 h-4 text-slate-300 group-hover/btn:text-white shrink-0 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    <span x-text="$store.lang.t('Kenapa Ada Pilar Ini & Kita Ngapain?', 'Why This Pillar & What We Do')">Kenapa Ada Pilar Ini & Kita Ngapain?</span>
                                </span>
                                <span class="text-[11px] font-mono font-bold group-hover/btn:translate-x-0.5 transition-transform shrink-0">Detail ↗</span>
                            </button>

                            {{-- VISUAL GALLERY (Photos Documentation) --}}
                            @php
                                $gallery = $pillar->gallery;
                            @endphp
                            @if(!empty($gallery) && count($gallery) > 0)
                                <div class="mt-5 pt-4 border-t border-gray-100">
                                    <div class="flex items-center justify-between mb-2.5">
                                        <span class="text-[11px] font-bold text-gray-500 uppercase tracking-wider font-mono">
                                            Dokumentasi Aksi ({{ count($gallery) }})
                                        </span>
                                        <span class="text-[10px] text-teal-700 font-semibold">Klik untuk zoom</span>
                                    </div>
                                    <div class="grid grid-cols-3 gap-2">
                                        @foreach($gallery as $imgUrl)
                                            <button 
                                                type="button" 
                                                @click="openLightbox('{{ $imgUrl }}', '{{ addslashes($pillar->name . ' - ' . $pillar->title_id) }}')"
                                                class="relative h-16 sm:h-18 rounded-xl overflow-hidden group/thumb border border-gray-200 hover:border-[#005952] transition-all cursor-pointer focus:outline-none"
                                            >
                                                <img 
                                                    src="{{ $imgUrl }}" 
                                                    alt="{{ $pillar->name }} photo" 
                                                    class="w-full h-full object-cover group-hover/thumb:scale-110 transition-transform duration-300"
                                                    loading="lazy"
                                                >
                                                <div class="absolute inset-0 bg-black/0 group-hover/thumb:bg-black/30 transition-colors flex items-center justify-center">
                                                    <svg class="w-4 h-4 text-white opacity-0 group-hover/thumb:opacity-100 transition-opacity drop-shadow-md" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                                                    </svg>
                                                </div>
                                            </button>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Footer Action Link to SIYOTA and Dedicated Profile --}}
                    <div class="px-6 py-4 bg-gray-50/80 border-t border-gray-100 flex items-center justify-between gap-2">
                        <a 
                            href="{{ route('public.impact.pillar', $pillar->code) }}" 
                            class="text-[11px] font-bold text-gray-600 hover:text-gray-900 underline transition-colors truncate"
                        >
                            <span>Lihat Profil Lengkap</span>
                        </a>
                        <a 
                            href="{{ $pillar->target_url ?: 'https://siyota.org' }}" 
                            target="_blank" 
                            rel="noopener noreferrer"
                            class="inline-flex items-center gap-1.5 text-xs font-bold text-[#005952] hover:text-[#00746b] group-hover:underline transition-colors shrink-0"
                        >
                            <span x-text="$store.lang.t('Aksi di siyota.org', 'Action on siyota.org')">
                                Aksi di siyota.org
                            </span>
                            <svg class="w-3.5 h-3.5 transform group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- ======================================================== --}}
    {{-- 4. DOKUMEN & LAPORAN KEBERLANJUTAN (WAJIB ADA COVER)     --}}
    {{-- ======================================================== --}}
    <section id="dokumen-esg" class="py-20 sm:py-28 bg-white border-t border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-12 sm:mb-16 pb-8 border-b border-gray-100">
                <div>
                    <div class="flex items-center gap-2 mb-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-[#005952]"></span>
                        <span class="text-xs font-bold tracking-[0.24em] text-[#005952] uppercase font-sans" x-text="$store.lang.t('TRANSPARANSI & AKUNTABILITAS', 'TRANSPARENCY & ACCOUNTABILITY')">
                            TRANSPARANSI & AKUNTABILITAS
                        </span>
                    </div>
                    <h2 class="text-2xl sm:text-4xl font-black text-gray-950 tracking-tight">
                        <span x-text="$store.lang.t('Dokumen & Laporan Dampak ESG', 'ESG Impact Reports & Open Documents')">
                            Dokumen & Laporan Dampak ESG
                        </span>
                    </h2>
                    <p class="text-sm text-gray-600 mt-1 max-w-2xl" x-text="$store.lang.t('Unduh berkas resmi laporan keberlanjutan, whitepaper riset kebijakan, dan katalog program kemitraan terverifikasi.', 'Download official sustainability disclosure reports, applied research whitepapers, and verified partnership program catalogs.')">
                        Unduh berkas resmi laporan keberlanjutan, whitepaper riset kebijakan, dan katalog program kemitraan terverifikasi.
                    </p>
                </div>

                <div class="text-xs font-semibold text-gray-600 bg-gray-100 px-4 py-2 rounded-full border border-gray-200 shrink-0 self-start sm:self-auto">
                    {{ $documents->count() }} Dokumen Terpublikasi
                </div>
            </div>

            @if($documents->isEmpty())
                <div class="bg-gray-50 rounded-3xl p-12 text-center border border-dashed border-gray-300 text-gray-400 text-sm">
                    <span x-text="$store.lang.t('Dokumen dan laporan ESG sedang dalam proses verifikasi auditor independen.', 'ESG documents and reports are currently undergoing independent audit verification.')">
                        Dokumen dan laporan ESG sedang dalam proses verifikasi auditor independen.
                    </span>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($documents as $doc)
                        <div class="bg-gray-50 rounded-3xl border border-gray-200 overflow-hidden shadow-xs hover:shadow-xl hover:border-[#005952]/40 transition-all duration-300 flex flex-col justify-between group">
                            <div>
                                {{-- Mandatory Cover Photo --}}
                                <div class="relative h-64 sm:h-72 w-full overflow-hidden bg-gray-900">
                                    <img 
                                        src="{{ $doc->cover_image }}" 
                                        alt="{{ $doc->title }}" 
                                        class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                                        loading="lazy"
                                    >
                                    <div class="absolute inset-0 bg-gradient-to-t from-gray-950 via-gray-900/30 to-transparent"></div>                                     {{-- Format & Year Badges --}}
                                    <div class="absolute top-4 left-4 right-4 flex items-center justify-between z-10">
                                        <span class="px-3 py-1 rounded-xl bg-black/70 backdrop-blur-md text-[11px] font-mono font-bold text-white border border-white/20 uppercase tracking-wider">
                                            {{ $doc->file_type }}
                                        </span>
                                        @if($doc->year)
                                            <span class="px-3 py-1 rounded-xl bg-white/90 backdrop-blur-md text-[11px] font-mono font-bold text-gray-900 border border-gray-300">
                                                {{ $doc->year }}
                                            </span>
                                        @endif
                                    </div>

                                    {{-- Category Badge on Cover --}}
                                    <div class="absolute bottom-4 left-4 right-4 z-10">
                                        <span class="px-2.5 py-1 rounded-lg bg-[#004741] backdrop-blur-md text-[10px] font-mono font-extrabold text-white border border-white/20 uppercase tracking-wider">
                                            {{ $doc->category }}
                                        </span>
                                    </div>
                                </div>

                                {{-- Title & Description --}}
                                <div class="p-6">
                                    <h3 class="text-base sm:text-lg font-black text-gray-900 leading-snug group-hover:text-[#005952] transition-colors">
                                        <span x-text="$store.lang.t('{{ addslashes($doc->title_id) }}', '{{ addslashes($doc->title_en ?: $doc->title_id) }}')">
                                            {{ $doc->title_id }}
                                        </span>
                                    </h3>
                                    @if($doc->description_id)
                                        <p class="text-xs sm:text-sm text-gray-600 mt-2 leading-relaxed line-clamp-3">
                                            <span x-text="$store.lang.t('{{ addslashes($doc->description_id) }}', '{{ addslashes($doc->description_en ?: $doc->description_id) }}')">
                                                {{ $doc->description_id }}
                                            </span>
                                        </p>
                                    @endif
                                </div>
                            </div>

                            {{-- Download / Action Bar --}}
                            <div class="px-6 py-4 bg-white border-t border-gray-200/80 flex items-center justify-between">
                                <span class="text-xs font-mono text-gray-500">
                                    {{ $doc->file_size ?: 'Berkas Resmi' }}
                                </span>
                                <a 
                                    href="{{ $doc->download_url }}" 
                                    target="_blank" 
                                    rel="noopener noreferrer"
                                    class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-[#005952] hover:bg-[#00746b] text-white text-xs font-bold shadow-xs hover:shadow-md transition-all"
                                >
                                    <span>
                                        @if($doc->is_pdf)
                                            <span x-text="$store.lang.t('Unduh PDF', 'Download PDF')">Unduh PDF</span>
                                        @else
                                            <span x-text="$store.lang.t('Buka Tautan', 'Open Link')">Buka Tautan</span>
                                        @endif
                                    </span>
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        @if($doc->is_pdf)
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                        @else
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                        @endif
                                    </svg>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    {{-- ======================================================== --}}
    {{-- 5. INTERACTIVE IMAGE LIGHTBOX MODAL                      --}}
    {{-- ======================================================== --}}
    <div 
        x-show="lightboxOpen" 
        x-cloak 
        @keydown.escape.window="lightboxOpen = false"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6 bg-black/90 backdrop-blur-xl"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
    >
        <div class="relative max-w-5xl w-full flex flex-col items-center">
            {{-- Close Button --}}
            <button 
                type="button" 
                @click="lightboxOpen = false"
                class="absolute -top-12 right-0 text-white/80 hover:text-white p-2 rounded-full bg-white/10 hover:bg-white/20 transition-colors focus:outline-none cursor-pointer"
            >
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            {{-- Image Box --}}
            <div class="rounded-2xl overflow-hidden max-h-[80vh] bg-black shadow-2xl border border-white/10">
                <img :src="activeImage" :alt="activeCaption" class="w-auto max-h-[75vh] object-contain">
            </div>

            {{-- Caption --}}
            <p class="mt-4 text-xs sm:text-sm text-gray-300 text-center font-mono" x-text="activeCaption"></p>
        </div>
    </div>

    {{-- ======================================================== --}}
    {{-- DETAIL MODAL: KENAPA ADA PILAR INI, KITA NGAPAIN, SDGS   --}}
    {{-- ======================================================== --}}
    <div 
        x-show="detailModalOpen" 
        x-cloak 
        @keydown.escape.window="detailModalOpen = false"
        class="fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-6 bg-black/80 backdrop-blur-md overflow-y-auto"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
    >
        <template x-if="activePillar">
            <div 
                @click.away="detailModalOpen = false"
                class="bg-white rounded-3xl max-w-4xl w-full max-h-[92vh] overflow-y-auto shadow-2xl border border-gray-100 flex flex-col my-auto"
            >
                {{-- Modal Hero Header with Image --}}
                <div class="relative h-56 sm:h-72 w-full overflow-hidden bg-gray-950 shrink-0">
                    <img :src="activePillar.photo_image" :alt="activePillar.name" class="w-full h-full object-cover filter brightness-90">
                    <div class="absolute inset-0 bg-gradient-to-t from-gray-950 via-gray-950/60 to-transparent"></div>
                    
                    {{-- Top Actions --}}
                    <div class="absolute top-4 left-4 right-4 flex items-center justify-between z-10">
                        <span class="px-3 py-1 rounded-xl bg-black/70 backdrop-blur-md text-xs font-mono font-bold text-white border border-white/20" x-text="'PILAR #0' + activePillar.pillar_number"></span>
                        <button @click="detailModalOpen = false" class="w-8 h-8 rounded-full bg-black/70 hover:bg-black text-white flex items-center justify-center text-lg font-bold border border-white/20 transition-colors cursor-pointer">&times;</button>
                    </div>

                    {{-- Bottom Title & Metric --}}
                    <div class="absolute bottom-5 left-6 right-6 z-10 flex flex-col sm:flex-row sm:items-end justify-between gap-3">
                        <div>
                            <span class="text-xs font-mono font-extrabold uppercase tracking-[0.2em] text-slate-300 block" x-text="activePillar.name"></span>
                            <h2 class="text-xl sm:text-2xl font-black text-white leading-tight mt-1" x-text="activePillar.title_id"></h2>
                        </div>
                        <template x-if="activePillar.metric_value">
                            <div class="px-4 py-2 rounded-2xl bg-[#004741] text-white font-mono shrink-0 shadow-lg border border-white/20 text-right">
                                <span class="text-base sm:text-lg font-black block" x-text="activePillar.metric_value"></span>
                                <span class="text-[10px] text-slate-200 block truncate max-w-[160px]" x-text="activePillar.metric_label_id"></span>
                            </div>
                        </template>
                    </div>
                </div>

                {{-- Modal Body Content --}}
                <div class="p-6 sm:p-8 space-y-6 text-xs sm:text-sm">
                    {{-- Deskripsi Ringkas --}}
                    <p class="text-gray-700 leading-relaxed text-sm font-normal" x-text="activePillar.description_id"></p>

                    {{-- Dua Kolom: Kenapa Ada Pilar Ini & Kita Ngapain --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        {{-- Kenapa Ada Pilar Ini? --}}
                        <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 space-y-2">
                            <div class="flex items-center gap-1.5 font-black text-slate-900 text-xs uppercase tracking-wider">
                                <svg class="w-4 h-4 text-slate-700 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span>Kenapa Ada Pilar Ini? (Latar Belakang)</span>
                            </div>
                            <p class="text-xs text-gray-700 leading-relaxed" x-text="activePillar.why_it_matters_id || activePillar.description_id"></p>
                        </div>

                        {{-- Kita Ngapain? --}}
                        <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 space-y-2">
                            <div class="flex items-center gap-1.5 font-black text-[#004741] text-xs uppercase tracking-wider">
                                <svg class="w-4 h-4 text-[#004741] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                <span>Aksi Lapangan: Kita Ngapain?</span>
                            </div>
                            <p class="text-xs text-gray-700 leading-relaxed" x-text="activePillar.what_we_do_id || activePillar.description_id"></p>
                        </div>
                    </div>

                    {{-- Tiga Kolom: SDGs PBB, Program Dunia & Agenda Nasional --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 p-5 rounded-2xl bg-gray-50 border border-gray-200">
                        {{-- SDGs PBB --}}
                        <div class="space-y-2">
                            <span class="font-bold text-gray-900 text-xs uppercase tracking-wider block">SDGs PBB Terkait</span>
                            <template x-if="activePillar.sdgs && activePillar.sdgs.length > 0">
                                <div class="space-y-1">
                                    <template x-for="(sdg, sIdx) in activePillar.sdgs" :key="sIdx">
                                        <div class="px-2.5 py-1 rounded-lg bg-slate-900 border border-slate-800 text-white text-[11px] font-mono font-semibold truncate" x-text="sdg"></div>
                                    </template>
                                </div>
                            </template>
                            <template x-if="!activePillar.sdgs || activePillar.sdgs.length === 0">
                                <span class="text-gray-400 text-xs">Selaras dengan SDGs PBB</span>
                            </template>
                        </div>

                        {{-- Program & Konvensi Dunia --}}
                        <div class="space-y-2">
                            <span class="font-bold text-gray-900 text-xs uppercase tracking-wider block">Program Dunia</span>
                            <template x-if="activePillar.global_programs && activePillar.global_programs.length > 0">
                                <div class="space-y-1">
                                    <template x-for="(gp, gIdx) in activePillar.global_programs" :key="gIdx">
                                        <div class="px-2.5 py-1 rounded-lg bg-blue-100/70 border border-blue-300 text-blue-900 text-[11px] font-semibold truncate" x-text="gp"></div>
                                    </template>
                                </div>
                            </template>
                            <template x-if="!activePillar.global_programs || activePillar.global_programs.length === 0">
                                <span class="text-gray-400 text-xs">Kerangka kerja multilateral</span>
                            </template>
                        </div>

                        {{-- Agenda Nasional RI --}}
                        <div class="space-y-2">
                            <span class="font-bold text-gray-900 text-xs uppercase tracking-wider block">Agenda Nasional RI</span>
                            <template x-if="activePillar.national_programs && activePillar.national_programs.length > 0">
                                <div class="space-y-1">
                                    <template x-for="(np, nIdx) in activePillar.national_programs" :key="nIdx">
                                        <div class="px-2.5 py-1 rounded-lg bg-purple-100/70 border border-purple-300 text-purple-900 text-[11px] font-semibold truncate" x-text="np"></div>
                                    </template>
                                </div>
                            </template>
                            <template x-if="!activePillar.national_programs || activePillar.national_programs.length === 0">
                                <span class="text-gray-400 text-xs">Prioritas Pembangunan RI</span>
                            </template>
                        </div>
                    </div>

                    {{-- Sasaran Penerima Manfaat jika ada --}}
                    <template x-if="activePillar.target_beneficiaries">
                        <div class="p-3 bg-gray-50 rounded-xl border border-gray-200 text-xs text-gray-700 flex items-center gap-2">
                            <span class="font-bold text-gray-900">Sasaran Penerima Manfaat:</span>
                            <span x-text="activePillar.target_beneficiaries"></span>
                        </div>
                    </template>

                    {{-- Embed Video Dokumentasi YouTube --}}
                    <template x-if="activePillar.youtube_embed_url">
                        <div class="space-y-2 pt-2 border-t border-gray-100">
                            <div class="flex items-center justify-between text-xs">
                                <span class="font-bold text-gray-900 uppercase tracking-wider flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-red-600 shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                                    Dokumentasi Video Aksi Lapangan
                                </span>
                                <a :href="activePillar.youtube_url" target="_blank" rel="noopener noreferrer" class="text-[11px] font-bold text-red-600 hover:underline flex items-center gap-1">
                                    <span>Tonton di YouTube ↗</span>
                                </a>
                            </div>
                            <div class="relative w-full aspect-video rounded-2xl overflow-hidden bg-black shadow-lg border border-gray-200">
                                <iframe 
                                    :src="activePillar.youtube_embed_url" 
                                    title="YouTube video player" 
                                    class="w-full h-full" 
                                    frameborder="0" 
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                                    allowfullscreen
                                ></iframe>
                            </div>
                        </div>
                    </template>

                    {{-- Dokumentasi Galeri Aksi --}}
                    <template x-if="activePillar.gallery && activePillar.gallery.length > 0">
                        <div class="space-y-2 pt-2 border-t border-gray-100">
                            <div class="flex items-center justify-between text-xs">
                                <span class="font-bold text-gray-900 uppercase tracking-wider">Dokumentasi Aksi Nyata</span>
                                <span class="text-gray-500 font-mono" x-text="activePillar.gallery.length + ' Foto'"></span>
                            </div>
                            <div class="grid grid-cols-3 sm:grid-cols-4 gap-2">
                                <template x-for="(img, iIdx) in activePillar.gallery" :key="iIdx">
                                    <button 
                                        type="button" 
                                        @click="openLightbox(img, activePillar.name + ' - Dokumentasi #' + (iIdx + 1))"
                                        class="aspect-4/3 rounded-xl overflow-hidden bg-gray-900 border border-gray-200 hover:border-[#005952] transition-all cursor-pointer"
                                    >
                                        <img :src="img" alt="" class="w-full h-full object-cover">
                                    </button>
                                </template>
                            </div>
                        </div>
                    </template>
                </div>

                {{-- Modal Footer --}}
                <div class="p-6 bg-gray-50 border-t border-gray-100 flex flex-wrap items-center justify-between gap-3 shrink-0 rounded-b-3xl">
                    <div class="flex items-center gap-3">
                        <a 
                            :href="'{{ url('dampak/pilar') }}/' + activePillar.code" 
                            class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-white border border-gray-300 text-xs font-bold text-gray-800 hover:bg-gray-100 transition-colors shadow-2xs"
                        >
                            <span>Buka Halaman Lengkap Pilar ↗</span>
                        </a>
                        <a 
                            :href="activePillar.target_url || 'https://siyota.org'" 
                            target="_blank" 
                            rel="noopener noreferrer"
                            class="inline-flex items-center gap-2 px-5 py-2 rounded-xl bg-[#004741] hover:bg-black text-white text-xs font-bold transition-all shadow-sm"
                        >
                            <span>Kunjungi SIYOTA (siyota.org)</span>
                            <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        </a>
                    </div>
                    <button type="button" @click="detailModalOpen = false" class="px-4 py-2 rounded-xl text-xs font-bold text-gray-600 hover:text-gray-900 cursor-pointer">
                        Tutup
                    </button>
                </div>
            </div>
        </template>
    </div>
</div>
@endsection
