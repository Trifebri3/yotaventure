@extends('public.layouts.app')

@section('title', 'Direktori Kontributor & Talenta - PT Yota Inovasi Nusantara (YOIN)')

@section('content')
<div class="bg-white text-gray-900 font-sans pt-28 sm:pt-36 pb-24 select-none min-h-screen">

    {{-- Breadcrumb --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-6">
        <nav class="flex items-center gap-2 text-xs text-gray-500">
            <a href="{{ url('/') }}" class="hover:text-[#005952] transition-colors" x-text="$store.lang.t('Beranda', 'Home')">Beranda</a>
            <span>/</span>
            <a href="{{ route('public.people.index') }}" class="hover:text-[#005952] transition-colors" x-text="$store.lang.t('Insan & Tim', 'People & Team')">Insan & Tim</a>
            <span>/</span>
            <span class="text-[#005952] font-semibold" x-text="$store.lang.t('Kontributor', 'Contributors')">Kontributor</span>
        </nav>
    </div>

    {{-- Sub-Navigation Pills --}}
    @include('public.people._nav')

    {{-- Header --}}
    <header class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-12 sm:mb-16">
        <div class="max-w-4xl">
            <span class="text-xs font-bold tracking-[0.25em] text-[#005952] uppercase block mb-3" x-text="$store.lang.t('JARINGAN TALENTA & KOLABORATOR RISET', 'TALENT PIPELINE & RESEARCH COLLABORATORS')">
                JARINGAN TALENTA & KOLABORATOR RISET
            </span>
            <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black text-gray-950 tracking-tight leading-[1.12]">
                <span x-text="$store.lang.t('Insan yang Pernah & Sedang Berkontribusi', 'Individuals Who Have Contributed to the YOIN Ecosystem')">
                    Insan yang Pernah & Sedang Berkontribusi
                </span>
            </h1>
            <p class="mt-4 sm:mt-6 text-base sm:text-xl text-gray-600 font-light leading-relaxed">
                <span x-text="$store.lang.t('Pusat apresiasi bagi para peneliti akademik, peserta magang bertalenta, mitra riset inovatif, dan fellow independen yang mewarnai rekam jejak inovasi kami.', 'A dedicated hall of gratitude for academic researchers, interns, project collaborators, and fellows shaping our innovation milestones.')">
                    Pusat apresiasi bagi para peneliti akademik, peserta magang bertalenta, mitra riset inovatif, dan fellow independen yang mewarnai rekam jejak inovasi kami.
                </span>
            </p>
        </div>
    </header>

    {{-- Category Filters --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-12">
        <div class="bg-gray-50 rounded-2xl border border-gray-200/80 p-3 sm:p-4 flex items-center gap-2 overflow-x-auto no-scrollbar">
            <a 
                href="{{ route('public.people.kontributor.index') }}" 
                class="px-4 py-2 rounded-xl text-xs font-bold transition-all shrink-0 {{ !request('type') ? 'bg-[#005952] text-white shadow-xs' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200/60' }}"
            >
                <span x-text="$store.lang.t('Semua Kontribusi', 'All Contributions')">Semua Kontribusi</span>
            </a>

            <a 
                href="{{ route('public.people.kontributor.index', ['type' => 'magang']) }}" 
                class="px-4 py-2 rounded-xl text-xs font-bold transition-all shrink-0 flex items-center gap-1.5 {{ request('type') === 'magang' ? 'bg-[#005952] text-white shadow-xs' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200/60' }}"
            >
                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
                <span x-text="$store.lang.t('Magang (Internship)', 'Internship')">Magang (Internship)</span>
            </a>

            <a 
                href="{{ route('public.people.kontributor.index', ['type' => 'riset']) }}" 
                class="px-4 py-2 rounded-xl text-xs font-bold transition-all shrink-0 flex items-center gap-1.5 {{ request('type') === 'riset' ? 'bg-[#005952] text-white shadow-xs' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200/60' }}"
            >
                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                <span x-text="$store.lang.t('Riset & Akademik', 'Research & Academic')">Riset & Akademik</span>
            </a>

            <a 
                href="{{ route('public.people.kontributor.index', ['type' => 'kerjasama']) }}" 
                class="px-4 py-2 rounded-xl text-xs font-bold transition-all shrink-0 flex items-center gap-1.5 {{ request('type') === 'kerjasama' ? 'bg-[#005952] text-white shadow-xs' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200/60' }}"
            >
                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                <span x-text="$store.lang.t('Kerjasama Proyek', 'Project Collaboration')">Kerjasama Proyek</span>
            </a>

            <a 
                href="{{ route('public.people.kontributor.index', ['type' => 'fellowship']) }}" 
                class="px-4 py-2 rounded-xl text-xs font-bold transition-all shrink-0 flex items-center gap-1.5 {{ request('type') === 'fellowship' ? 'bg-[#004741] text-white shadow-xs' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200/60' }}"
            >
                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                <span x-text="$store.lang.t('Fellowship & Mitra Mandiri', 'Fellowship & Fellows')">Fellowship & Mitra Mandiri</span>
            </a>
        </div>
    </section>

    {{-- Contributors Directory Grid --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-24">
        @if($contributors->isEmpty())
            <div class="text-center py-20 bg-gray-50 rounded-3xl border border-dashed border-gray-300">
                <p class="text-gray-500 font-medium" x-text="$store.lang.t('Belum ada data kontributor pada kategori ini.', 'No contributors found in this category.')">
                    Belum ada data kontributor pada kategori ini.
                </p>
                <a href="{{ route('public.people.kontributor.index') }}" class="mt-3 inline-block text-xs font-bold text-[#005952] underline">
                    <span x-text="$store.lang.t('Lihat Semua Kontributor', 'Show All Contributors')">Lihat Semua Kontributor</span>
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
                @foreach($contributors as $c)
                    <div class="bg-white rounded-3xl border border-gray-200/80 p-6 sm:p-7 hover:shadow-xl hover:border-slate-400 transition-all duration-300 flex flex-col justify-between group">
                        <div>
                            {{-- Category Badge & Period --}}
                            <div class="flex items-center justify-between gap-2 mb-4">
                                <span class="px-2.5 py-1 rounded-full text-[11px] font-bold uppercase tracking-wider bg-slate-900 text-white shadow-xs">
                                    {{ ucfirst($c->contribution_type ?: 'Kontribusi') }}
                                </span>

                                @if($c->period)
                                    <span class="text-[11px] font-mono text-gray-500 bg-gray-50 px-2 py-0.5 rounded-md border border-gray-200/50">
                                        {{ $c->period }}
                                    </span>
                                @endif
                            </div>

                            {{-- Avatar & Identity --}}
                            <div class="flex items-center gap-4 mb-4">
                                <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl overflow-hidden bg-gray-100 shrink-0 border border-gray-200/60 shadow-xs">
                                    @if($c->photo)
                                        <img src="{{ asset($c->photo) }}" alt="{{ $c->name }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center font-bold text-gray-400 text-lg">
                                            {{ substr($c->name, 0, 1) }}
                                        </div>
                                    @endif
                                </div>
                                <div class="min-w-0">
                                    <h3 class="text-base font-bold text-gray-950 group-hover:text-[#004741] transition-colors truncate">
                                        {{ $c->name }}
                                    </h3>
                                    <p class="text-xs font-semibold text-[#004741] truncate">
                                        {{ $c->role_id }}
                                    </p>
                                    @if($c->organization)
                                        <p class="text-[11px] text-gray-500 truncate mt-0.5 flex items-center gap-1">
                                            <svg class="w-3 h-3 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                            <span class="truncate">{{ $c->organization }}</span>
                                        </p>
                                    @endif
                                </div>
                            </div>

                            {{-- Bio --}}
                            <p class="text-xs text-gray-600 line-clamp-3 leading-relaxed mb-4 font-light">
                                <span x-show="$store.lang.isID()">{{ $c->bio_id }}</span>
                                <span x-show="$store.lang.isEN()" x-cloak>{{ $c->bio_en ?: $c->bio_id }}</span>
                            </p>

                            {{-- Focus / Tags --}}
                            @if($c->getMeta('focus'))
                                <div class="flex flex-wrap gap-1 mb-4">
                                    @foreach((array)$c->getMeta('focus') as $f)
                                        <span class="px-2 py-0.5 rounded bg-gray-100 text-gray-600 text-[10px] font-mono">
                                            {{ $f }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        {{-- Footer Actions --}}
                        <div class="pt-4 border-t border-gray-100 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                @if($c->getSocialLink('linkedin'))
                                    <a href="{{ $c->getSocialLink('linkedin') }}" target="_blank" rel="noopener" class="text-gray-400 hover:text-[#005952] transition-colors p-1" title="LinkedIn">
                                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                                    </a>
                                @endif
                                @if($c->getSocialLink('github'))
                                    <a href="{{ $c->getSocialLink('github') }}" target="_blank" rel="noopener" class="text-gray-400 hover:text-[#005952] transition-colors p-1" title="GitHub">
                                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>
                                    </a>
                                @endif
                            </div>

                            <a href="{{ route('public.people.kontributor.show', $c->slug) }}" class="inline-flex items-center gap-1 text-xs font-bold text-[#005952] group-hover:underline">
                                <span x-text="$store.lang.t('Detail Dedikasi', 'View Details')">Detail Dedikasi</span>
                                <span>→</span>
                            </a>
                        </div>

                    </div>
                @endforeach
            </div>
        @endif
    </section>

</div>
@endsection
