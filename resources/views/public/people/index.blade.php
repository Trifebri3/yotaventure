@extends('public.layouts.app')

@section('title', 'Insan & Tim Ekosistem - PT Yota Inovasi Nusantara (YOIN)')

@section('content')
<div class="bg-[#F8FAFC] text-slate-900 font-sans pt-28 sm:pt-36 pb-24 select-none min-h-screen">

    {{-- Breadcrumb --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-6">
        <nav class="flex items-center gap-2 text-xs font-medium text-slate-500">
            <a href="{{ url('/') }}" class="hover:text-slate-950 transition-colors" x-text="$store.lang.t('Beranda', 'Home')">Beranda</a>
            <span class="text-slate-300">/</span>
            <span class="text-slate-950 font-bold" x-text="$store.lang.t('Insan & Tim', 'People & Team')">Insan & Tim</span>
        </nav>
    </div>

    {{-- Sub-Navigation Pills (Home + Compact Pills) --}}
    @include('public.people._nav')

    {{-- Hero Header --}}
    <header class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-16 sm:mb-20">
        <div class="max-w-4xl">
            <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-slate-950 text-white text-[11px] font-bold uppercase tracking-wider mb-4 shadow-2xs">
                <span class="w-1.5 h-1.5 rounded-full bg-white"></span>
                <span x-text="$store.lang.t('Direktori Kepemimpinan & Insan Inovator', 'Leadership & Innovators Directory')">Direktori Kepemimpinan & Insan Inovator</span>
            </div>
            <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black text-slate-950 tracking-tight leading-[1.12]">
                <span x-text="$store.lang.t('Insan Penggerak, Kisah Pendiri & Ekosistem Sinergi', 'The Minds Behind YOIN: Founders, Talent & Shared Synergy')">
                    Insan Penggerak, Kisah Pendiri & Ekosistem Sinergi
                </span>
            </h1>
            <p class="mt-5 text-base sm:text-xl text-slate-600 leading-relaxed font-normal">
                <span x-text="$store.lang.t('Dari visi awal para pendiri hingga dedikasi tim inti dan ratusan talenta kontributor di seluruh Indonesia. Kami membangun masa depan digital, agrikultur, dan manufaktur berkelanjutan.', 'From the visionary roots of our founders to the dedicated core team and hundreds of contributors nationwide. We build the future of sustainable digital, agricultural, and manufacturing ventures.')">
                    Dari visi awal para pendiri hingga dedikasi tim inti dan ratusan talenta kontributor di seluruh Indonesia. Kami membangun masa depan digital, agrikultur, dan manufaktur berkelanjutan.
                </span>
            </p>
        </div>
    </header>

    {{-- SECTION 1: FOUNDERS SPOTLIGHT --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-24">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-10 pb-4 border-b border-slate-200 gap-4">
            <div>
                <span class="text-xs font-bold tracking-widest text-[#004741] uppercase block mb-1" x-text="$store.lang.t('DEWAN PENDIRI', 'CO-FOUNDERS')">DEWAN PENDIRI</span>
                <h2 class="text-2xl sm:text-3xl font-black text-slate-950 tracking-tight" x-text="$store.lang.t('Visi & Kepemimpinan Utama', 'Core Vision & Leadership')">Visi & Kepemimpinan Utama</h2>
            </div>
            <a href="{{ route('public.people.founder.index') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-900 hover:text-[#004741] transition-colors group">
                <span x-text="$store.lang.t('Eksplor Profil Founder Lengkap', 'Explore All Founders')">Eksplor Profil Founder Lengkap</span>
                <span class="group-hover:translate-x-1 transition-transform">→</span>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($founders as $founder)
                <div class="group relative bg-white rounded-3xl border border-slate-200 p-6 sm:p-7 shadow-xs hover:shadow-xl hover:border-slate-400 transition-all duration-300 hover:-translate-y-1 flex flex-col justify-between">
                    <div>
                        {{-- Photo Container --}}
                        <div class="relative w-full aspect-4/5 rounded-2xl overflow-hidden mb-6 bg-slate-900 shadow-md">
                            @if($founder->photo)
                                <img 
                                    src="{{ asset($founder->photo) }}" 
                                    alt="{{ $founder->name }}" 
                                    class="w-full h-full object-cover object-top group-hover:scale-105 transition-transform duration-500"
                                >
                            @else
                                <div class="w-full h-full flex items-center justify-center text-white/30 font-black text-6xl">
                                    {{ substr($founder->name, 0, 1) }}
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/85 via-slate-950/20 to-transparent"></div>
                            
                            {{-- Role Badge on Image --}}
                            <div class="absolute bottom-4 left-4 right-4">
                                <span class="px-3 py-1 rounded-lg bg-slate-950/90 backdrop-blur-md text-white text-[11px] font-bold tracking-wide inline-block shadow-sm">
                                    {{ $founder->role_id }}
                                </span>
                            </div>
                        </div>

                        {{-- Name & Quote --}}
                        <div class="mb-4">
                            <h3 class="text-xl font-black text-slate-950 group-hover:text-[#004741] transition-colors flex items-center gap-1.5">
                                <span>{{ $founder->name }}</span>
                                <svg class="w-4 h-4 text-[#004741] shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                            </h3>
                            @if($founder->getMeta('quote'))
                                <p class="mt-2.5 text-xs italic text-slate-700 bg-slate-50 border-l-4 border-[#004741] p-3 rounded-r-xl leading-relaxed font-medium">
                                    "{{ $founder->getMeta('quote') }}"
                                </p>
                            @endif
                        </div>

                        {{-- Bio Short --}}
                        <p class="text-xs sm:text-sm text-slate-600 line-clamp-3 leading-relaxed mb-6 font-normal">
                            <span x-show="$store.lang.isID()">{{ $founder->bio_id }}</span>
                            <span x-show="$store.lang.isEN()" x-cloak>{{ $founder->bio_en ?: $founder->bio_id }}</span>
                        </p>
                    </div>

                    {{-- Footer Action & Socials --}}
                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                        <div class="flex items-center gap-2 text-slate-400">
                            @if($founder->getSocialLink('linkedin'))
                                <a href="{{ $founder->getSocialLink('linkedin') }}" target="_blank" rel="noopener" class="p-1.5 rounded-lg hover:bg-slate-100 hover:text-slate-900 transition-colors" title="LinkedIn">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                                </a>
                            @endif
                            @if($founder->getSocialLink('instagram'))
                                <a href="{{ $founder->getSocialLink('instagram') }}" target="_blank" rel="noopener" class="p-1.5 rounded-lg hover:bg-slate-100 hover:text-slate-900 transition-colors" title="Instagram">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                                </a>
                            @endif
                        </div>

                        <a href="{{ route('public.people.founder.show', $founder->slug) }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-slate-900 hover:bg-[#004741] text-white text-xs font-bold transition-all shadow-2xs">
                            <span x-text="$store.lang.t('Profil Lengkap', 'Full Profile')">Profil Lengkap</span>
                            <span>→</span>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- SECTION 2: EXECUTIVE FOUNDER ESSAYS & STRATEGIC MANIFESTOS (SOLID HIGH CONTRAST) --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-24">
        <div class="relative overflow-hidden rounded-3xl bg-[#0B1120] text-white p-8 sm:p-12 lg:p-16 shadow-2xl border border-slate-800">
            <div class="relative z-10 grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
                <div class="lg:col-span-7">
                    <span class="inline-block px-3.5 py-1 rounded-full bg-white/10 border border-white/20 text-white font-bold text-xs uppercase tracking-widest mb-4">
                        <span x-text="$store.lang.t('MANIFES STRATEGIS & KEPEMIMPINAN', 'STRATEGIC MANIFESTOS & LEADERSHIP')">MANIFES STRATEGIS & KEPEMIMPINAN</span>
                    </span>
                    <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black tracking-tight leading-tight mb-5">
                        <span x-text="$store.lang.t('Menempa Nilai Riil: Rekam Jejak, Tesis Inovasi, & Manifes Kepemimpinan', 'Forging Real Value: Strategic Trajectory, Innovation Theses, & Leadership Manifestos')">
                            Menempa Nilai Riil: Rekam Jejak, Tesis Inovasi, & Manifes Kepemimpinan
                        </span>
                    </h2>
                    <p class="text-sm sm:text-base text-slate-300 font-normal leading-relaxed max-w-2xl mb-8">
                        <span x-text="$store.lang.t('Bukan sekadar biografi ringkas. Kami merangkum dinamika ekosistem, validasi unit ekonomi mandiri, terobosan sains agrikultur, hingga konsolidasi holding multi-sektor dalam format monograf dan esai kepemimpinan mendalam.', 'More than just a standard bio. We chronicle ecosystem dynamics, independent unit economic validation, agricultural science breakthroughs, and multi-sector holding consolidation in deep executive monographs and leadership essays.')">
                            Bukan sekadar biografi ringkas. Kami merangkum dinamika ekosistem, validasi unit ekonomi mandiri, terobosan sains agrikultur, hingga konsolidasi holding multi-sektor dalam format monograf dan esai kepemimpinan mendalam.
                        </span>
                    </p>

                    <div class="flex flex-wrap items-center gap-4">
                        <a 
                            href="{{ route('public.people.storyfounder.index') }}" 
                            class="px-7 py-3.5 rounded-xl bg-white hover:bg-slate-200 text-slate-950 text-xs sm:text-sm font-black transition-all shadow-lg inline-flex items-center gap-2"
                        >
                            <span x-text="$store.lang.t('Jelajahi Seluruh Manifes', 'Explore All Manifestos')">Jelajahi Seluruh Manifes</span>
                            <span>→</span>
                        </a>
                        <span class="text-xs text-slate-400 font-bold">
                            {{ $featuredStories->count() }}+ <span x-text="$store.lang.t('Dokumen Terpublikasi', 'Manifestos Published')">Dokumen Terpublikasi</span>
                        </span>
                    </div>
                </div>

                {{-- Chapters Preview Cards --}}
                <div class="lg:col-span-5 space-y-3">
                    @foreach($featuredStories as $story)
                        <a 
                            href="{{ route('public.people.storyfounder.show', $story->slug) }}" 
                            class="block p-4 sm:p-5 rounded-2xl bg-white/5 hover:bg-white/10 border border-white/10 transition-all duration-200 group"
                        >
                            <div class="flex items-center justify-between text-[11px] text-slate-300 font-mono font-bold mb-1.5">
                                <span class="bg-white/15 px-2 py-0.5 rounded text-white">{{ $story->chapter_number ?: 'MANIFES' }}</span>
                                <span class="text-slate-400">{{ $story->reading_time ?: '7 min read' }}</span>
                            </div>
                            <h4 class="text-sm font-bold text-white group-hover:text-slate-200 transition-colors leading-snug">
                                {{ $story->title }}
                            </h4>
                            <p class="text-xs text-slate-400 line-clamp-1 mt-1 font-light">
                                {{ $story->excerpt }}
                            </p>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- SECTION 3: CORE TEAM PREVIEW --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-24">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-10 pb-4 border-b border-slate-200 gap-4">
            <div>
                <span class="text-xs font-bold tracking-widest text-[#004741] uppercase block mb-1" x-text="$store.lang.t('TALENTA & EKSEKUTOR', 'CORE TALENTS & EXECUTIVES')">TALENTA & EKSEKUTOR</span>
                <h2 class="text-2xl sm:text-3xl font-black text-slate-950 tracking-tight" x-text="$store.lang.t('Tim Inti Ekosistem Bisnis', 'Core Business Ecosystem Team')">Tim Inti Ekosistem Bisnis</h2>
            </div>
            <a href="{{ route('public.people.tim.index') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-900 hover:text-[#004741] transition-colors group">
                <span x-text="$store.lang.t('Lihat Seluruh Tim & Brand', 'View Full Team & Ventures')">Lihat Seluruh Tim & Brand</span>
                <span class="group-hover:translate-x-1 transition-transform">→</span>
            </a>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
            @foreach($coreTeam as $member)
                <div class="bg-white rounded-2xl border border-slate-200 p-4 sm:p-5 hover:shadow-lg hover:border-slate-400 transition-all duration-300 hover:-translate-y-1 flex flex-col justify-between">
                    <div>
                        <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl overflow-hidden mb-4 bg-slate-100 mx-auto border border-slate-200 shadow-2xs">
                            @if($member->photo)
                                <img src="{{ asset($member->photo) }}" alt="{{ $member->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center font-black text-slate-400 text-xl">
                                    {{ substr($member->name, 0, 1) }}
                                </div>
                            @endif
                        </div>
                        <div class="text-center">
                            <span class="inline-block px-2.5 py-0.5 rounded-md text-[10px] font-bold mb-1.5 {{ $member->is_active ? 'bg-slate-950 text-white' : 'bg-slate-100 text-slate-600' }}">
                                {{ $member->initiative ? $member->initiative->name : 'Holding YOIN' }}
                            </span>
                            <h4 class="text-sm font-black text-slate-950 line-clamp-1">{{ $member->name }}</h4>
                            <p class="text-xs text-slate-600 line-clamp-1 mt-0.5 font-medium">{{ $member->role_id }}</p>
                        </div>
                    </div>

                    <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-center gap-3">
                        @if($member->getSocialLink('linkedin'))
                            <a href="{{ $member->getSocialLink('linkedin') }}" target="_blank" rel="noopener" class="text-slate-400 hover:text-slate-900 transition-colors">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                            </a>
                        @endif
                        @if($member->getSocialLink('github'))
                            <a href="{{ $member->getSocialLink('github') }}" target="_blank" rel="noopener" class="text-slate-400 hover:text-slate-900 transition-colors">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- SECTION 4: CONTRIBUTORS & TALENTS TEASER (SOLID EXECUTIVE BOX) --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-24">
        <div class="bg-slate-900 text-white rounded-3xl border border-slate-800 p-8 sm:p-12 flex flex-col md:flex-row items-center justify-between gap-8 shadow-xl">
            <div class="max-w-xl">
                <span class="text-xs font-bold tracking-widest text-slate-400 uppercase block mb-1" x-text="$store.lang.t('GENERASI TALENTA & ALUMNI', 'TALENT PIPELINE & ALUMNI')">GENERASI TALENTA & ALUMNI</span>
                <h3 class="text-2xl sm:text-3xl font-black text-white tracking-tight" x-text="$store.lang.t('Kontributor Magang, Riset & Kolaborator Proyek', 'Interns, Academic Researchers & Project Collaborators')">
                    Kontributor Magang, Riset & Kolaborator Proyek
                </h3>
                <p class="mt-3 text-sm text-slate-300 leading-relaxed font-normal" x-text="$store.lang.t('Kami bangga menjadi laboratorium nyata bagi mahasiswa, peneliti, dan talenta muda berbakat dari berbagai institusi ternama di Indonesia.', 'We take pride in serving as a living lab for students, researchers, and young innovators from leading universities across the country.')">
                    Kami bangga menjadi laboratorium nyata bagi mahasiswa, peneliti, dan talenta muda berbakat dari berbagai institusi ternama di Indonesia.
                </p>
            </div>
            <div class="flex items-center gap-3 shrink-0">
                <a 
                    href="{{ route('public.people.kontributor.index') }}" 
                    class="px-7 py-3.5 rounded-xl bg-white hover:bg-slate-200 text-slate-950 text-xs sm:text-sm font-black transition-all shadow-md inline-flex items-center gap-2"
                >
                    <span x-text="$store.lang.t('Jelajahi Direktori Kontributor', 'Browse Contributor Directory')">Jelajahi Direktori Kontributor</span>
                    <span>→</span>
                </a>
            </div>
        </div>
    </section>

    {{-- SECTION 5: MITRA & LOGO KOLABORATOR --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <span class="text-xs font-bold tracking-widest text-[#004741] uppercase block mb-1" x-text="$store.lang.t('MITRA STRATEGIS TERVERIFIKASI', 'VERIFIED STRATEGIC PARTNERS')">MITRA STRATEGIS TERVERIFIKASI</span>
            <h2 class="text-2xl sm:text-3xl font-black text-slate-950 tracking-tight" x-text="$store.lang.t('Bersinergi Bersama Lembaga & Korporasi', 'Synergizing with Leading Institutions & Corporations')">
                Bersinergi Bersama Lembaga & Korporasi
            </h2>
            <p class="mt-2 text-xs sm:text-sm text-slate-500 font-normal" x-text="$store.lang.t('Data mitra tersinkronisasi langsung dengan pangkalan data ekosistem resmi YOIN.', 'Partner records directly synchronized with YOIN official ecosystem database.')">
                Data mitra tersinkronisasi langsung dengan pangkalan data ekosistem resmi YOIN.
            </p>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4 sm:gap-6">
            @foreach($clients as $client)
                <a 
                    href="{{ route('public.people.mitra.index', ['category' => $client->category]) }}" 
                    class="p-4 rounded-2xl bg-white border border-slate-200 hover:border-slate-400 hover:shadow-md transition-all flex flex-col items-center justify-center text-center group min-h-[110px]"
                >
                    @if($client->logo)
                        <img 
                            src="{{ asset($client->logo) }}" 
                            alt="{{ $client->name }}" 
                            class="max-h-10 max-w-[120px] object-contain filter grayscale group-hover:grayscale-0 transition-all duration-300 opacity-70 group-hover:opacity-100"
                        >
                    @else
                        <span class="text-xs font-black text-slate-900 group-hover:text-[#004741] transition-colors">{{ $client->name }}</span>
                    @endif
                    <span class="text-[10px] text-slate-500 mt-2 font-mono group-hover:text-slate-900 transition-colors">{{ $client->name }}</span>
                </a>
            @endforeach
        </div>

        <div class="text-center mt-10">
            <a href="{{ route('public.people.mitra.index') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl border border-slate-300 bg-white text-xs font-bold text-slate-900 hover:border-slate-900 hover:shadow-2xs transition-all">
                <span x-text="$store.lang.t('Lihat Katalog Lengkap Mitra Kolaborator', 'View Full Collaborator Catalog')">Lihat Katalog Lengkap Mitra Kolaborator</span>
                <span>→</span>
            </a>
        </div>
    </section>

</div>
@endsection
