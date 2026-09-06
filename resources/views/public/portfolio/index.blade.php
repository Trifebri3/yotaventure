@extends('public.layouts.app')

@section('title', 'Indeks Portofolio & Studi Kasus | YOTA Inovasi Nusantara')

@section('content')
<div class="bg-[#FAFCFC] min-h-screen pt-28 sm:pt-36 pb-24 text-gray-900 font-sans">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Breadcrumbs --}}
        <nav class="flex items-center gap-2 text-xs text-gray-500 mb-6">
            <a href="{{ url('/') }}" class="hover:text-[#005952] transition-colors" x-text="$store.lang.t('Beranda', 'Home')">Beranda</a>
            <span>/</span>
            <span class="text-gray-900 font-semibold" x-text="$store.lang.t('Indeks Portofolio', 'Portfolio Index')">Indeks Portofolio</span>
        </nav>

        {{-- Hero Header --}}
        <div class="pb-10 border-b border-gray-200">
            <div class="max-w-3xl">
                <div class="flex items-center gap-2 mb-3">
                    <span class="w-2.5 h-2.5 rounded-full bg-[#005952]"></span>
                    <span class="text-xs font-bold tracking-[0.25em] text-[#005952] uppercase" x-text="$store.lang.t('DOKUMENTASI KARYA & DAMPAK', 'DOCUMENTATION OF WORKS & IMPACT')">
                        DOKUMENTASI KARYA & DAMPAK
                    </span>
                </div>
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-gray-950 tracking-tight leading-tight" x-text="$store.lang.t('Indeks Portofolio & Studi Kasus Ekosistem.', 'Ecosystem Portfolio & Case Studies Index.')">
                    Indeks Portofolio & Studi Kasus Ekosistem.
                </h1>
                <p class="mt-3 text-base sm:text-lg text-gray-600 font-normal leading-relaxed" x-text="$store.lang.t('Kumpulan implementasi nyata, rekayasa teknologi, dan proyek kolaboratif yang dikerjakan oleh berbagai inisiatif di bawah payung YOTA.', 'A verified repository of real-world deployments, technological engineering, and collaborative projects delivered across YOTA initiatives.')">
                    Kumpulan implementasi nyata, rekayasa teknologi, dan proyek kolaboratif yang dikerjakan oleh berbagai inisiatif di bawah payung YOTA.
                </p>
            </div>
        </div>

        {{-- Filters Bar --}}
        <div class="py-6 flex flex-wrap items-center justify-between gap-4 border-b border-gray-100">
            {{-- Domain Filter Pills --}}
            <div class="flex flex-wrap items-center gap-2">
                <a 
                    href="{{ route('public.portfolio.index') }}" 
                    class="px-4 py-2 rounded-xl text-xs font-bold transition-all {{ empty($currentDomain) && empty($currentInitiative) ? 'bg-[#005952] text-white shadow-sm' : 'bg-white border border-gray-200 text-gray-700 hover:bg-gray-100' }}"
                >
                    <span x-text="$store.lang.t('Semua Portofolio', 'All Portfolio')">Semua Portofolio</span>
                </a>

                @foreach($domains as $domain)
                    <a 
                        href="{{ route('public.portfolio.index', ['domain' => $domain->slug]) }}" 
                        class="px-4 py-2 rounded-xl text-xs font-bold transition-all {{ $currentDomain === $domain->slug ? 'bg-[#005952] text-white shadow-sm' : 'bg-white border border-gray-200 text-gray-700 hover:bg-gray-100' }}"
                    >
                        <span x-text="$store.lang.t('{{ addslashes($domain->name_id) }}', '{{ addslashes($domain->name_en) }}')">
                            {{ $domain->name_id }}
                        </span>
                    </a>
                @endforeach
            </div>

            {{-- Initiative Filter Dropdown --}}
            <div class="flex items-center gap-2">
                <label for="filter-initiative" class="text-xs font-bold text-gray-500 uppercase tracking-wider">Inisiatif:</label>
                <select 
                    id="filter-initiative"
                    onchange="if (this.value) window.location.href = this.value;"
                    class="px-3 py-1.5 rounded-xl border border-gray-200 bg-white text-xs font-semibold text-gray-800 focus:outline-none focus:border-[#005952]"
                >
                    <option value="{{ route('public.portfolio.index') }}">Semua Inisiatif</option>
                    @foreach($initiatives as $initiative)
                        <option 
                            value="{{ route('public.portfolio.index', ['initiative' => $initiative->slug]) }}"
                            {{ $currentInitiative === $initiative->slug ? 'selected' : '' }}
                        >
                            {{ $initiative->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Projects Grid --}}
        <div class="py-10">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($projects as $project)
                    <div class="bg-white rounded-3xl border border-gray-200 p-6 sm:p-7 shadow-xs flex flex-col justify-between hover:shadow-lg hover:border-[#005952]/40 transition-all group">
                        <div>
                            {{-- Top Badges: Initiative & Category --}}
                            <div class="flex items-center justify-between gap-2 mb-4">
                                <span class="px-2.5 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider bg-slate-900 text-white font-mono border border-slate-800">
                                    {{ $project->initiative->name }}
                                </span>
                                <span class="text-[11px] font-semibold text-gray-400">
                                    {{ $project->client?->name ?? 'In-House' }}
                                </span>
                            </div>

                            {{-- Title --}}
                            <h3 class="text-xl font-black text-gray-950 tracking-tight group-hover:text-[#005952] transition-colors">
                                <a href="{{ route('public.portfolio.show', $project->slug) }}">
                                    {{ $project->name }}
                                </a>
                            </h3>

                            {{-- Problem Statement (Challenge) --}}
                            <div class="mt-4 p-3.5 bg-slate-50 border-l-4 border-slate-700 border-y border-r border-slate-200 rounded-xl text-xs">
                                <span class="font-bold text-slate-900 block mb-1 uppercase tracking-wider text-[10px]" x-text="$store.lang.t('Tantangan / Masalah:', 'Challenge / Problem:')">
                                    Tantangan / Masalah:
                                </span>
                                <p class="text-slate-700 line-clamp-3 leading-relaxed">
                                    <span x-text="$store.lang.t('{{ addslashes($project->problem_statement_id ?? '') }}', '{{ addslashes($project->problem_statement_en ?? '') }}')">
                                        {{ $project->problem_statement_id }}
                                    </span>
                                </p>
                            </div>

                            {{-- Result / Outcome --}}
                            <div class="mt-3 p-3.5 bg-slate-50 border-l-4 border-[#004741] border-y border-r border-slate-200 rounded-xl text-xs">
                                <span class="font-bold text-[#004741] block mb-1 uppercase tracking-wider text-[10px]" x-text="$store.lang.t('Hasil / Dampak Terukur:', 'Outcome / Measurable Impact:')">
                                    Hasil / Dampak Terukur:
                                </span>
                                <p class="text-slate-800 line-clamp-3 leading-relaxed">
                                    <span x-text="$store.lang.t('{{ addslashes($project->result_outcome_id ?? '') }}', '{{ addslashes($project->result_outcome_en ?? '') }}')">
                                        {{ $project->result_outcome_id }}
                                    </span>
                                </p>
                            </div>

                            {{-- Technologies --}}
                            @if(!empty($project->technologies))
                                <div class="mt-4 flex flex-wrap gap-1">
                                    @foreach(array_slice($project->technologies, 0, 4) as $tech)
                                        <span class="px-2 py-0.5 rounded text-[10px] bg-gray-100 text-gray-600 font-medium">
                                            {{ $tech }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        {{-- Footer CTA --}}
                        <div class="mt-6 pt-5 border-t border-gray-100 flex items-center justify-between">
                            <span class="text-xs font-mono font-bold text-gray-400">
                                {{ $project->status }}
                            </span>
                            <a 
                                href="{{ route('public.portfolio.show', $project->slug) }}" 
                                class="inline-flex items-center gap-1.5 text-xs font-bold text-[#005952] hover:text-[#004741] transition-colors"
                            >
                                <span x-text="$store.lang.t('Baca Studi Kasus', 'Read Case Study')">Baca Studi Kasus</span>
                                <span>→</span>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 bg-white rounded-3xl p-12 text-center border border-dashed border-gray-300 text-gray-500">
                        <p class="text-sm font-semibold">Belum ada karya atau studi kasus yang sesuai dengan filter ini.</p>
                        <a href="{{ route('public.portfolio.index') }}" class="mt-3 inline-block text-xs font-bold text-[#005952] hover:underline">
                            Reset Filter
                        </a>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            <div class="mt-12">
                {{ $projects->links() }}
            </div>
        </div>

    </div>
</div>
@endsection
