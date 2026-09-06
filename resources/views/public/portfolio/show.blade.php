@extends('public.layouts.app')

@section('title', $project->name . ' | Studi Kasus Portofolio YOTA')

@section('content')
<div class="bg-[#FAFCFC] min-h-screen pt-28 sm:pt-36 pb-24 text-gray-900 font-sans">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Breadcrumbs --}}
        <nav class="flex items-center gap-2 text-xs text-gray-500 mb-6">
            <a href="{{ url('/') }}" class="hover:text-[#005952] transition-colors" x-text="$store.lang.t('Beranda', 'Home')">Beranda</a>
            <span>/</span>
            <a href="{{ route('public.portfolio.index') }}" class="hover:text-[#005952] transition-colors" x-text="$store.lang.t('Portofolio', 'Portfolio')">Portofolio</a>
            <span>/</span>
            <span class="text-gray-900 font-semibold truncate">{{ $project->name }}</span>
        </nav>

        {{-- Case Study Hero Header --}}
        <div class="bg-white rounded-3xl p-8 sm:p-12 border border-gray-200/90 shadow-sm relative overflow-hidden">
            <div class="flex flex-wrap items-center gap-3 mb-4">
                <a 
                    href="{{ route('public.ecosystem.initiative', $project->initiative->slug) }}" 
                    class="px-3 py-1 rounded-md text-xs font-bold uppercase tracking-wider bg-slate-900 text-white font-mono border border-slate-800 hover:bg-black transition-colors"
                >
                    {{ $project->initiative->name }}
                </a>
                <span class="text-xs text-gray-400 font-semibold">
                    {{ $project->category->name_id }}
                </span>
                <span class="text-gray-300">•</span>
                <span class="text-xs font-mono font-bold text-gray-400 uppercase">
                    STATUS: {{ $project->status }}
                </span>
            </div>

            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-gray-950 tracking-tight leading-tight">
                {{ $project->name }}
            </h1>

            {{-- Client & Meta summary --}}
            <div class="mt-6 pt-6 border-t border-gray-100 flex flex-wrap items-center gap-6 text-xs text-gray-600">
                @if($project->client)
                    <div>
                        <span class="font-bold text-gray-400 uppercase tracking-wider block text-[10px]">Mitra / Klien:</span>
                        <span class="font-extrabold text-gray-900 text-sm">{{ $project->client->name }}</span>
                        <span class="text-gray-500">({{ $project->client->industry }})</span>
                    </div>
                @endif
                @if($project->launch_date)
                    <div>
                        <span class="font-bold text-gray-400 uppercase tracking-wider block text-[10px]">Tanggal Rilis:</span>
                        <span class="font-semibold text-gray-900 text-sm">{{ $project->launch_date->format('F Y') }}</span>
                    </div>
                @endif
                @if($project->external_url)
                    <div class="ml-auto">
                        <a 
                            href="{{ $project->external_url }}" 
                            target="_blank" 
                            rel="noopener noreferrer" 
                            class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-gray-900 hover:bg-black text-white text-xs font-bold transition-colors"
                        >
                            <span>Kunjungi Website Proyek</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                            </svg>
                        </a>
                    </div>
                @endif
            </div>
        </div>

        {{-- 1. Tantangan & Solusi (The Problem & Solution Statements) --}}
        <div class="mt-10 grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Tantangan / Problem --}}
            <div class="bg-slate-50 rounded-3xl p-6 sm:p-8 border-l-4 border-slate-700 border-y border-r border-slate-200 shadow-sm">
                <div class="flex items-center gap-2 text-xs font-bold text-slate-900 mb-3 uppercase tracking-wider">
                    <span class="w-2.5 h-2.5 rounded-full bg-slate-800"></span>
                    <span x-text="$store.lang.t('Tantangan / Masalah Lapangan', 'Field Challenge / Problem Addressed')">
                        Tantangan / Masalah Lapangan
                    </span>
                </div>
                <p class="text-sm sm:text-base text-slate-800 leading-relaxed font-normal">
                    <span x-text="$store.lang.t('{{ addslashes($project->problem_statement_id ?? '') }}', '{{ addslashes($project->problem_statement_en ?? '') }}')">
                        {{ $project->problem_statement_id }}
                    </span>
                </p>
            </div>

            {{-- Solusi / Solution --}}
            <div class="bg-slate-50 rounded-3xl p-6 sm:p-8 border-l-4 border-[#004741] border-y border-r border-slate-200 shadow-sm">
                <div class="flex items-center gap-2 text-xs font-bold text-[#004741] mb-3 uppercase tracking-wider">
                    <span class="w-2.5 h-2.5 rounded-full bg-[#004741]"></span>
                    <span x-text="$store.lang.t('Pendekatan Solusi & Rekayasa', 'Engineering Solution Approach')">
                        Pendekatan Solusi & Rekayasa
                    </span>
                </div>
                <p class="text-sm sm:text-base text-slate-800 leading-relaxed font-normal">
                    <span x-text="$store.lang.t('{{ addslashes($project->solution_statement_id ?? '') }}', '{{ addslashes($project->solution_statement_en ?? '') }}')">
                        {{ $project->solution_statement_id }}
                    </span>
                </p>
            </div>
        </div>

        {{-- 2. Hasil Terukur & Dampak Nyata --}}
        @if($project->result_outcome_id)
            <div class="mt-8 bg-slate-950 rounded-3xl p-8 sm:p-10 text-white border border-slate-800 shadow-xl">
                <span class="text-xs font-mono font-bold tracking-[0.25em] text-white uppercase block mb-2" x-text="$store.lang.t('HASIL TERUKUR & DAMPAK NYATA', 'MEASURABLE OUTCOME & REAL IMPACT')">
                    HASIL TERUKUR & DAMPAK NYATA
                </span>
                <p class="text-xl sm:text-2xl font-bold leading-relaxed">
                    <span x-text="$store.lang.t('{{ addslashes($project->result_outcome_id) }}', '{{ addslashes($project->result_outcome_en ?: $project->result_outcome_id) }}')">
                        {{ $project->result_outcome_id }}
                    </span>
                </p>
            </div>
        @endif

        {{-- 3. Tujuan Strategis & Kisah Implementasi --}}
        <div class="mt-10 bg-white rounded-3xl p-8 sm:p-10 border border-gray-200 space-y-8">
            @if($project->purpose_id)
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-2" x-text="$store.lang.t('Tujuan Strategis Proyek', 'Strategic Project Purpose')">
                        Tujuan Strategis Proyek
                    </h3>
                    <p class="text-base text-gray-800 leading-relaxed font-normal">
                        <span x-text="$store.lang.t('{{ addslashes($project->purpose_id) }}', '{{ addslashes($project->purpose_en ?: $project->purpose_id) }}')">
                            {{ $project->purpose_id }}
                        </span>
                    </p>
                </div>
            @endif

            @if($project->story_id)
                <div class="pt-6 border-t border-gray-100">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-2" x-text="$store.lang.t('Catatan Eksekusi & Pembelajaran', 'Execution Notes & Learnings')">
                        Catatan Eksekusi & Pembelajaran
                    </h3>
                    <div class="prose prose-sm max-w-none text-gray-700 leading-relaxed font-normal">
                        <span x-text="$store.lang.t('{{ addslashes($project->story_id) }}', '{{ addslashes($project->story_en ?: $project->story_id) }}')">
                            {{ $project->story_id }}
                        </span>
                    </div>
                </div>
            @endif

            {{-- Stack & Layanan --}}
            <div class="pt-6 border-t border-gray-100 grid grid-cols-1 md:grid-cols-2 gap-6">
                @if(!empty($project->services_provided))
                    <div>
                        <h4 class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-3" x-text="$store.lang.t('Layanan yang Diberikan', 'Services Provided')">
                            Layanan yang Diberikan
                        </h4>
                        <ul class="space-y-1.5 text-xs font-medium text-gray-700">
                            @foreach($project->services_provided as $service)
                                <li class="flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 rounded-full bg-[#005952]"></span>
                                    <span>{{ $service }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if(!empty($project->technologies))
                    <div>
                        <h4 class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-3" x-text="$store.lang.t('Teknologi & Infrastruktur', 'Technologies & Infrastructure')">
                            Teknologi & Infrastruktur
                        </h4>
                        <div class="flex flex-wrap gap-1.5">
                            @foreach($project->technologies as $tech)
                                <span class="px-2.5 py-1 rounded-md text-xs font-medium bg-gray-100 text-gray-800 border border-gray-200">
                                    {{ $tech }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{-- Related Works --}}
        @if($relatedProjects->isNotEmpty())
            <div class="mt-14 space-y-6">
                <div class="flex items-center justify-between pb-3 border-b border-gray-200">
                    <h3 class="text-xl font-black text-gray-950 tracking-tight" x-text="$store.lang.t('Karya Terkait Lainnya', 'Other Related Works')">
                        Karya Terkait Lainnya
                    </h3>
                    <a href="{{ route('public.portfolio.index') }}" class="text-xs font-bold text-[#005952] hover:underline">
                        Lihat Semua Portofolio →
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($relatedProjects as $rel)
                        <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-xs flex flex-col justify-between">
                            <div>
                                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block mb-1">
                                    {{ $rel->client?->name ?? 'Internal' }}
                                </span>
                                <h4 class="text-base font-bold text-gray-900 line-clamp-2">
                                    <a href="{{ route('public.portfolio.show', $rel->slug) }}" class="hover:text-[#005952]">
                                        {{ $rel->name }}
                                    </a>
                                </h4>
                            </div>
                            <div class="mt-4 pt-3 border-t border-gray-100">
                                <a href="{{ route('public.portfolio.show', $rel->slug) }}" class="text-xs font-bold text-[#005952] hover:underline">
                                    Baca Kasus →
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</div>
@endsection
