@extends('public.layouts.app')

@section('title', $domain->name_id . ' | Domain Ekosistem YOTA')

@section('content')
<div class="bg-[#FAFCFC] min-h-screen pt-28 sm:pt-36 pb-24 text-gray-900 font-sans">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Breadcrumbs --}}
        <nav class="flex items-center gap-2 text-xs text-gray-500 mb-6">
            <a href="{{ url('/') }}" class="hover:text-[#005952] transition-colors" x-text="$store.lang.t('Beranda', 'Home')">Beranda</a>
            <span>/</span>
            <a href="{{ route('public.ecosystem.index') }}" class="hover:text-[#005952] transition-colors" x-text="$store.lang.t('Ekosistem', 'Ecosystem')">Ekosistem</a>
            <span>/</span>
            <span class="text-gray-900 font-semibold">
                <span x-text="$store.lang.t('{{ addslashes($domain->name_id) }}', '{{ addslashes($domain->name_en) }}')">
                    {{ $domain->name_id }}
                </span>
            </span>
        </nav>

        {{-- Domain Hero --}}
        <div class="bg-white rounded-3xl border border-gray-200/90 shadow-sm overflow-hidden">
            @if($domain->cover_image)
                <div class="h-48 sm:h-64 lg:h-72 w-full relative overflow-hidden bg-gray-900">
                    <img src="{{ $domain->cover_image }}" alt="{{ $domain->name_id }}" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>
                    <div class="absolute top-4 right-4 sm:top-6 sm:right-6">
                        <span class="px-3 py-1 rounded-full text-xs font-mono font-bold text-white bg-black/50 backdrop-blur-xs border border-white/20 uppercase">
                            STATUS: {{ $domain->status }}
                        </span>
                    </div>
                </div>
            @endif

            <div class="p-8 sm:p-12 relative z-10 {{ $domain->cover_image ? '-mt-16 sm:-mt-20' : '' }}">
                <div class="flex flex-col sm:flex-row sm:items-end gap-5 mb-6">
                    @if($domain->icon_image)
                        <img src="{{ $domain->icon_image }}" alt="Icon" class="w-20 h-20 sm:w-24 sm:h-24 rounded-3xl object-cover border-4 border-white shadow-xl bg-white p-1.5 shrink-0">
                    @else
                        <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-3xl bg-teal-50 border-2 border-teal-200 text-[#005952] flex items-center justify-center shrink-0 shadow-md">
                            <svg class="w-8 h-8 sm:w-10 sm:h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                        </div>
                    @endif

                    <div class="min-w-0">
                        <div class="flex items-center gap-3 mb-2">
                            <span class="px-3 py-1 rounded-full text-xs font-extrabold uppercase tracking-wider bg-teal-50 text-[#005952] border border-teal-200">
                                DOMAIN EKOSISTEM
                            </span>
                            @if(!$domain->cover_image)
                                <span class="text-xs font-mono font-bold text-gray-400 uppercase">
                                    STATUS: {{ $domain->status }}
                                </span>
                            @endif
                        </div>

                        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-gray-950 tracking-tight leading-tight">
                            <span x-text="$store.lang.t('{{ addslashes($domain->name_id) }}', '{{ addslashes($domain->name_en) }}')">
                                {{ $domain->name_id }}
                            </span>
                        </h1>
                    </div>
                </div>

                <p class="text-lg text-gray-600 font-medium">
                    <span x-text="$store.lang.t('{{ addslashes($domain->tagline_id ?? '') }}', '{{ addslashes($domain->tagline_en ?? '') }}')">
                        {{ $domain->tagline_id }}
                    </span>
                </p>

                <p class="mt-3 text-sm sm:text-base text-gray-600 leading-relaxed font-normal max-w-4xl">
                    <span x-text="$store.lang.t('{{ addslashes($domain->short_description_id ?? '') }}', '{{ addslashes($domain->short_description_en ?? '') }}')">
                        {{ $domain->short_description_id }}
                    </span>
                </p>

                {{-- SDGs Alignment Badges --}}
                @if(!empty($domain->sdgs) && count($domain->sdgs) > 0)
                    <div class="mt-6 pt-6 border-t border-gray-100 flex flex-wrap items-center gap-2">
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider mr-1" x-text="$store.lang.t('Keterkaitan SDGs PBB:', 'UN SDGs Alignment:')">
                            Keterkaitan SDGs PBB:
                        </span>
                        @foreach($domain->sdgs as $sdg)
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-slate-900 text-white border border-slate-800 font-mono">
                                {{ $sdg }}
                            </span>
                        @endforeach
                    </div>
                @endif

                {{-- Crucial Problem & Solution Grid --}}
                <div class="mt-8 pt-8 border-t border-gray-100 grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Problem Statement --}}
                    <div class="bg-slate-50 rounded-2xl p-6 border-l-4 border-slate-700 border-y border-r border-slate-200">
                        <div class="flex items-center gap-2 text-xs font-bold text-slate-900 mb-2 uppercase tracking-wider">
                            <span class="w-2.5 h-2.5 rounded-full bg-slate-800"></span>
                            <span x-text="$store.lang.t('Tantangan Mendasar di Sektor Ini', 'The Core Sector Challenge')">
                                Tantangan Mendasar di Sektor Ini
                            </span>
                        </div>
                        <p class="text-sm text-slate-700 leading-relaxed font-normal">
                            <span x-text="$store.lang.t('{{ addslashes($domain->problem_statement_id ?? '') }}', '{{ addslashes($domain->problem_statement_en ?? '') }}')">
                                {{ $domain->problem_statement_id }}
                            </span>
                        </p>
                    </div>

                    {{-- Solution Statement --}}
                    <div class="bg-slate-50 rounded-2xl p-6 border-l-4 border-[#004741] border-y border-r border-slate-200">
                        <div class="flex items-center gap-2 text-xs font-bold text-[#004741] mb-2 uppercase tracking-wider">
                            <span class="w-2.5 h-2.5 rounded-full bg-[#004741]"></span>
                            <span x-text="$store.lang.t('Solusi Strategis Ekosistem Kita', 'Our Ecosystem Strategic Solution')">
                                Solusi Strategis Ekosistem Kita
                            </span>
                        </div>
                        <p class="text-sm text-slate-800 leading-relaxed font-normal">
                            <span x-text="$store.lang.t('{{ addslashes($domain->solution_statement_id ?? '') }}', '{{ addslashes($domain->solution_statement_en ?? '') }}')">
                                {{ $domain->solution_statement_id }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Section: Specific Issues & Solutions Mapping ("TUNJUKAN KAMI SOLUSI DARI ISU INI") --}}
        @if(!empty($domain->issues) && count($domain->issues) > 0)
            <div class="mt-14 space-y-6">
                <div class="pb-4 border-b border-gray-200">
                    <h2 class="text-2xl font-black text-gray-950 tracking-tight" x-text="$store.lang.t('Pemetaan Isu & Solusi Rekayasa Kami', 'Issue Mapping & Our Engineering Solutions')">
                        Pemetaan Isu & Solusi Rekayasa Kami
                    </h2>
                    <p class="text-xs text-gray-500 mt-1" x-text="$store.lang.t('Bagaimana ekosistem kami secara aktif menjawab tantangan lapangan dengan pendekatan solutif yang terukur.', 'How our ecosystem actively addresses real challenges with measurable solutions.')">
                        Bagaimana ekosistem kami secara aktif menjawab tantangan lapangan dengan pendekatan solutif yang terukur.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($domain->issues as $issueItem)
                        @php
                            $issText = is_array($issueItem) ? ($issueItem['issue'] ?? '') : $issueItem;
                            $solText = is_array($issueItem) ? ($issueItem['solution'] ?? $domain->solution_statement_id) : $domain->solution_statement_id;
                        @endphp
                        <div class="bg-white rounded-2xl p-5 border border-gray-200 shadow-xs flex flex-col justify-between space-y-3 hover:border-slate-400 transition-colors">
                            <div class="space-y-1.5">
                                <span class="text-[10px] font-bold uppercase tracking-wider text-white bg-slate-900 border border-slate-800 px-2 py-0.5 rounded-md inline-block">
                                    Isu Lapangan
                                </span>
                                <p class="text-xs text-gray-800 font-semibold leading-relaxed">
                                    {{ $issText }}
                                </p>
                            </div>
                            <div class="pt-3 border-t border-gray-100 space-y-1.5">
                                <span class="text-[10px] font-bold uppercase tracking-wider text-white bg-[#004741] border border-[#004741] px-2 py-0.5 rounded-md inline-block">
                                    Solusi Ekosistem Kita
                                </span>
                                <p class="text-xs text-slate-800 leading-relaxed">
                                    {{ $solText }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Section: Photo Gallery Documentation --}}
        @if(!empty($domain->gallery) && count($domain->gallery) > 0)
            <div class="mt-14 space-y-6">
                <div class="pb-4 border-b border-gray-200">
                    <h2 class="text-2xl font-black text-gray-950 tracking-tight" x-text="$store.lang.t('Dokumentasi & Galeri Visual', 'Visual Gallery & Documentation')">
                        Dokumentasi & Galeri Visual
                    </h2>
                    <p class="text-xs text-gray-500 mt-1" x-text="$store.lang.t('Rekaman visual implementasi teknologi dan kegiatan lapangan di domain ini.', 'Visual records of technology implementations and field activities in this domain.')">
                        Rekaman visual implementasi teknologi dan kegiatan lapangan di domain ini.
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($domain->gallery as $photo)
                        <div class="group relative rounded-2xl overflow-hidden border border-gray-200 bg-gray-100 aspect-video shadow-xs hover:shadow-md transition-all">
                            <img src="{{ $photo }}" alt="Dokumentasi Kegiatan" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Section: Program & Partner Logos --}}
        @if(!empty($domain->program_logos) && count($domain->program_logos) > 0)
            <div class="mt-14 space-y-6">
                <div class="pb-4 border-b border-gray-200">
                    <h2 class="text-2xl font-black text-gray-950 tracking-tight" x-text="$store.lang.t('Program & Mitra Strategis', 'Programs & Strategic Partners')">
                        Program & Mitra Strategis
                    </h2>
                    <p class="text-xs text-gray-500 mt-1" x-text="$store.lang.t('Kolaborasi lintas program dan mitra dalam mewujudkan solusi sektor ini.', 'Cross-program collaborations and partners realizing sector solutions.')">
                        Kolaborasi lintas program dan mitra dalam mewujudkan solusi sektor ini.
                    </p>
                </div>

                <div class="bg-white rounded-2xl p-6 border border-gray-200 shadow-xs flex flex-wrap items-center gap-6">
                    @foreach($domain->program_logos as $logo)
                        <div class="h-12 px-4 py-2 bg-gray-50 rounded-xl border border-gray-100 flex items-center justify-center">
                            <img src="{{ $logo }}" alt="Mitra" class="h-8 max-w-[120px] object-contain">
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Initiatives under this Domain --}}
        <div class="mt-14 space-y-8">
            <div class="flex items-center justify-between pb-4 border-b border-gray-200">
                <div>
                    <h2 class="text-2xl font-black text-gray-950 tracking-tight" x-text="$store.lang.t('Inisiatif & Brand dalam Domain Ini', 'Initiatives & Brands in this Domain')">
                        Inisiatif & Brand dalam Domain Ini
                    </h2>
                    <p class="text-xs text-gray-500 mt-1" x-text="$store.lang.t('Entitas mandiri yang beroperasi memecahkan tantangan spesifik pada pilar ini.', 'Independent entities operating to resolve specific challenges in this pillar.')">
                        Entitas mandiri yang beroperasi memecahkan tantangan spesifik pada pilar ini.
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($domain->initiatives as $initiative)
                    <div class="bg-white rounded-3xl border border-gray-200 p-6 shadow-xs flex flex-col justify-between hover:shadow-md hover:border-[#005952]/40 transition-all group">
                        <div>
                            <div class="flex items-center justify-between mb-3">
                                <span class="px-2.5 py-1 rounded-md text-[10px] font-extrabold uppercase tracking-wider bg-gray-100 text-gray-700">
                                    {{ $initiative->stage }}
                                </span>
                                <span class="text-xs font-bold text-emerald-700 flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    {{ $initiative->status }}
                                </span>
                            </div>

                            <h3 class="text-xl font-extrabold text-gray-950 group-hover:text-[#005952] transition-colors">
                                {{ $initiative->name }}
                            </h3>
                            <p class="text-xs text-gray-500 mt-1">
                                <span x-text="$store.lang.t('{{ addslashes($initiative->tagline_id ?? '') }}', '{{ addslashes($initiative->tagline_en ?? '') }}')">
                                    {{ $initiative->tagline_id }}
                                </span>
                            </p>

                            {{-- Clear Problem Solved --}}
                            <div class="mt-4 p-3.5 bg-slate-50 border-l-4 border-slate-700 border-y border-r border-slate-200 rounded-xl">
                                <span class="text-[10px] font-bold text-slate-900 uppercase tracking-wider block mb-1">
                                    <span x-text="$store.lang.t('Masalah yang Diselesaikan:', 'Problem Solved:')">Masalah yang Diselesaikan:</span>
                                </span>
                                <p class="text-xs text-slate-700 leading-relaxed line-clamp-3">
                                    <span x-text="$store.lang.t('{{ addslashes($initiative->problem_statement_id ?? '') }}', '{{ addslashes($initiative->problem_statement_en ?? '') }}')">
                                        {{ $initiative->problem_statement_id }}
                                    </span>
                                </p>
                            </div>

                            {{-- Focus areas --}}
                            @if(!empty($initiative->focus_areas))
                                <div class="mt-4 flex flex-wrap gap-1.5">
                                    @foreach($initiative->focus_areas as $focus)
                                        <span class="px-2 py-0.5 rounded-md text-[10px] font-medium bg-gray-50 text-gray-600 border border-gray-200">
                                            {{ $focus }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <div class="mt-6 pt-5 border-t border-gray-100 flex items-center justify-between gap-3">
                            <a 
                                href="{{ route('public.ecosystem.initiative', $initiative->slug) }}" 
                                class="text-xs font-bold text-gray-700 hover:text-[#005952] transition-colors"
                            >
                                <span x-text="$store.lang.t('Story & Portofolio', 'Story & Portfolio')">Story & Portofolio</span> →
                            </a>

                            @if($initiative->external_website_url)
                                <a 
                                    href="{{ $initiative->external_website_url }}" 
                                    target="_blank" 
                                    rel="noopener noreferrer" 
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-teal-50 hover:bg-[#005952] text-[#005952] hover:text-white border border-teal-200 text-xs font-bold transition-all"
                                >
                                    <span>{{ $initiative->external_url_label ?: 'Visit Website →' }}</span>
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                    </svg>
                                </a>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 bg-white p-8 rounded-2xl text-center border border-dashed border-gray-300 text-gray-400 text-xs">
                        Inisiatif dalam domain ini belum dipublikasikan.
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Sibling Domains Switcher --}}
        <div class="mt-16 pt-8 border-t border-gray-200">
            <h3 class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-4" x-text="$store.lang.t('Jelajahi Domain Lainnya', 'Explore Other Domains')">
                Jelajahi Domain Lainnya
            </h3>
            <div class="flex flex-wrap gap-2">
                @foreach($allDomains as $sibling)
                    <a 
                        href="{{ route('public.ecosystem.domain', $sibling->slug) }}" 
                        class="px-4 py-2 rounded-xl text-xs font-bold transition-all {{ $sibling->id === $domain->id ? 'bg-[#005952] text-white' : 'bg-white border border-gray-200 text-gray-700 hover:bg-gray-100' }}"
                    >
                        <span x-text="$store.lang.t('{{ addslashes($sibling->name_id) }}', '{{ addslashes($sibling->name_en) }}')">
                            {{ $sibling->name_id }}
                        </span>
                    </a>
                @endforeach
            </div>
        </div>

    </div>
</div>
@endsection
