@extends('public.layouts.app')

@section('title', ($profile->invest_title ?: 'Membangun Perusahaan Dari Akar Masalah | Building Companies From the Ground Up').' - YOIN Inovasi Nusantara')

@section('content')
<div 
    class="bg-white text-gray-900 font-sans pt-28 sm:pt-36 pb-28 select-none min-h-screen"
    x-data="{
        deckModalOpen: false,
        dataroomModalOpen: false,
        activeIssueTab: 0,
        activeProductTab: 'all',
        deckForm: { name: '', organization: '', email: '', role: 'Venture Capital' },
        dataroomForm: { name: '', institution: '', email: '', intent: '' },
        submitDeckRequest() {
            const text = encodeURIComponent('Halo Tim YOIN Inovasi Nusantara,\nSaya mengajukan permohonan resmi Investor Deck.\n\nNama: ' + this.deckForm.name + '\nInstitusi/Entitas: ' + this.deckForm.organization + '\nEmail: ' + this.deckForm.email + '\nPeran: ' + this.deckForm.role);
            window.open('https://wa.me/6285862319524?text=' + text, '_blank');
            this.deckModalOpen = false;
        },
        submitDataRoomRequest() {
            const text = encodeURIComponent('Halo Tim YOIN Inovasi Nusantara,\nSaya mengajukan permohonan akses ke Virtual Data Room YOIN (Laporan Kinerja & Materi Institusi).\n\nNama: ' + this.dataroomForm.name + '\nInstitusi/Fund: ' + this.dataroomForm.institution + '\nEmail: ' + this.dataroomForm.email + '\nFokus Minat: ' + this.dataroomForm.intent);
            window.open('https://wa.me/6285862319524?text=' + text, '_blank');
            this.dataroomModalOpen = false;
        }
    }"
    @keydown.escape.window="deckModalOpen = false; dataroomModalOpen = false;"
>

    {{-- Breadcrumb & Sub-nav Tabs --}}
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 mb-6">
        <nav class="flex items-center gap-2 text-xs text-gray-500 mb-6">
            <a href="{{ url('/') }}" class="hover:text-[#005952] transition-colors" x-text="$store.lang.t('Beranda', 'Home')">Beranda</a>
            <span>/</span>
            <a href="{{ route('public.about.profile') }}" class="hover:text-[#005952] transition-colors" x-text="$store.lang.t('Tentang Kami', 'About Us')">Tentang Kami</a>
            <span>/</span>
            <span class="text-[#005952] font-semibold" x-text="$store.lang.t('Investasi & Sinergi', 'Investment & Capital')">Investasi & Sinergi</span>
        </nav>

        {{-- Sub-Navigation Pills (Profil, Invest, Story) --}}
        <div class="flex items-center gap-2 border-b border-gray-200 pb-3">
            <a 
                href="{{ route('public.about.profile') }}" 
                class="px-4 py-2 rounded-full text-xs font-bold transition-all bg-gray-100 text-gray-600 hover:bg-gray-200 flex items-center gap-2"
            >
                <span x-text="$store.lang.t('Profil Perusahaan', 'Company Profile')">Profil Perusahaan</span>
            </a>
            <a 
                href="{{ route('public.about.invest') }}" 
                class="px-4 py-2 rounded-full text-xs font-bold transition-all bg-[#004741] text-white shadow-xs flex items-center gap-2"
            >
                <span class="w-1.5 h-1.5 rounded-full bg-white"></span>
                <span x-text="$store.lang.t('Investasi & Sinergi', 'Investment & Capital')">Investasi & Sinergi</span>
            </a>
            <a 
                href="{{ route('public.about.achievements') }}" 
                class="px-4 py-2 rounded-full text-xs font-bold transition-all bg-gray-100 text-gray-600 hover:bg-gray-200 flex items-center gap-2"
            >
                <span x-text="$store.lang.t('Pencapaian & Momen', 'Achievements & Moments')">Pencapaian & Momen</span>
            </a>
        </div>
    </div>

    {{-- 1. HERO SECTION --}}
    <section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 my-8 sm:my-14 text-left">
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-slate-100 border border-slate-200 text-slate-800 text-xs font-bold tracking-wider uppercase mb-5">
            <span class="w-2 h-2 rounded-full bg-[#004741] animate-pulse"></span>
            <span x-text="$store.lang.t('EKOSISTEM PEMBANGUN VENTURA', 'VENTURE ECOSYSTEM BUILDER')">
                {{ $profile->invest_badge ?: 'VENTURE ECOSYSTEM BUILDER' }}
            </span>
        </div>

        <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black text-gray-950 tracking-tight leading-[1.15] max-w-4xl">
            <span x-text="$store.lang.t('Membangun Perusahaan Dari Akar Masalah', 'Building Companies From the Ground Up')">
                {{ $profile->invest_title ?: 'Building Companies From the Ground Up' }}
            </span>
        </h1>
        
        <p class="text-xl sm:text-2xl font-bold text-[#005952] mt-3">
            YOIN Inovasi Nusantara
        </p>

        <div class="mt-6 sm:mt-8 max-w-3xl space-y-4 text-base sm:text-lg text-gray-700 leading-relaxed">
            <p class="font-medium text-gray-900">
                <span x-text="$store.lang.t(
                    'Kami membangun ekosistem ventura dari Indonesia — menciptakan bisnis terfokus pada solusi nyata dalam bidang teknologi, pertanian, produk bernilai tambah, dan pengembangan komunitas.',
                    'We are building a venture ecosystem from Indonesia — creating focused businesses around real problems in technology, agriculture, products, and community development.'
                )">
                    We are building a venture ecosystem from Indonesia — creating focused businesses around real problems in technology, agriculture, products, and community development.
                </span>
            </p>
            <p class="text-gray-600">
                <span x-text="$store.lang.t(
                    'YOIN tidak dibangun di sekitar satu produk tunggal semata.',
                    'YOIN is not built around a single product.'
                )">
                    YOIN is not built around a single product.
                </span>
            </p>
            <p class="text-gray-600">
                <span x-text="$store.lang.t(
                    'Kami membangun sumber daya manusia, ide, produk, dan entitas ventura — kemudian memberikan ruang bagi masing-masing untuk menemukan pasar, tim, dan arah pertumbuhannya sendiri.',
                    'We build people, ideas, products, and ventures — then give each one the space to find its own market, team, and direction.'
                )">
                    We build people, ideas, products, and ventures — then give each one the space to find its own market, team, and direction.
                </span>
            </p>
        </div>

        {{-- Dual CTAs --}}
        <div class="mt-8 sm:mt-10 flex flex-wrap items-center gap-4">
            <a 
                href="#ecosystem-bets" 
                class="px-6 py-3.5 rounded-full bg-[#005952] hover:bg-[#004741] text-white text-xs sm:text-sm font-bold tracking-wider uppercase transition-all shadow-md flex items-center gap-2"
            >
                <span x-text="$store.lang.t('Jelajahi Ekosistem Kami', 'Explore Our Ecosystem')">Explore Our Ecosystem</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
            </a>

            <button 
                type="button" 
                @click="deckModalOpen = true"
                class="px-6 py-3.5 rounded-full bg-white hover:bg-gray-50 text-gray-900 text-xs sm:text-sm font-bold tracking-wider uppercase transition-all border border-gray-300 shadow-xs flex items-center gap-2 cursor-pointer"
            >
                <svg class="w-4 h-4 text-[#005952]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                <span x-text="$store.lang.t('Minta Investor Deck', 'Request Investor Deck')">Request Investor Deck</span>
            </button>
        </div>

        {{-- Explainer Box for Layman (Mudah Dipahami Orang Awam) --}}
        <div class="mt-10 p-5 rounded-2xl bg-[#F0F8F6] border border-teal-100 flex items-start gap-4">
            <div class="w-10 h-10 rounded-xl bg-teal-100/80 text-[#005952] flex items-center justify-center shrink-0 font-bold text-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div class="text-xs sm:text-sm text-teal-950 leading-relaxed">
                <span class="font-bold block text-gray-900 mb-0.5" x-text="$store.lang.t('Sekilas Model Bisnis YOIN:', 'In Simple Terms: What is YOIN?')">
                    Sekilas Model Bisnis YOIN:
                </span>
                <span x-text="$store.lang.t(
                    'Berbeda dari startup yang hanya punya 1 aplikasi dan bertaruh pada 1 nasib, YOIN bertindak sebagai «Pabrik & Rumah Ventura» yang meriset masalah nyata di masyarakat, merakit produknya, menyiapkan tim ahlinya, dan melahirkannya menjadi unit-unit bisnis mandiri yang saling menguntungkan.',
                    'Unlike a typical startup that relies on a single app and single risk, YOIN functions as a «Venture Builder & Platform» that discovers real problems in Indonesia, engineers products, equips dedicated teams, and spins them into resilient standalone companies.'
                )">
                    Unlike a single-product startup, YOIN acts as a Venture Builder that creates, tests, and scales multiple businesses from ground-level problems.
                </span>
            </div>
        </div>
    </section>

    {{-- Divider --}}
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <hr class="border-gray-200">
    </div>

    {{-- 2. WHY YOIN, WHY NOW (SYNCHRONIZED WITH DATABASE DOMAINS & ISSUES) --}}
    <section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 my-16 sm:my-24">
        <div class="text-left">
            <span class="text-xs font-mono font-bold tracking-widest text-[#005952] uppercase block mb-2" x-text="$store.lang.t('MENGAPA SAAT INI', 'MACRO & STRUCTURAL MOMENTUM')">
                MENGAPA SAAT INI
            </span>
            <h2 class="text-2xl sm:text-4xl font-black text-gray-950 tracking-tight uppercase">
                <span x-text="$store.lang.t('MENGAPA YOIN, MENGAPA SEKARANG', 'WHY YOIN, WHY NOW')">
                    WHY YOIN, WHY NOW
                </span>
            </h2>
            <p class="text-base sm:text-lg text-gray-700 mt-3 max-w-2xl font-medium">
                <span x-text="$store.lang.t(
                    'Indonesia berubah dengan sangat cepat. Kami ingin membangun tepat di mana transformasi tersebut sedang bergulir.',
                    'Indonesia is changing fast. We want to build where the change is happening.'
                )">
                    Indonesia is changing fast. We want to build where the change is happening.
                </span>
            </p>
        </div>

        {{-- 3 Macro Data Indicator Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-10">
            <div class="p-8 rounded-3xl bg-gray-50/80 border border-gray-200 hover:border-slate-400 transition-all">
                <span class="text-3xl sm:text-4xl font-black text-[#004741] block tracking-tight">
                    5.11%
                </span>
                <span class="text-xs font-bold uppercase tracking-wider text-gray-400 mt-1 block" x-text="$store.lang.t('PDB ~Rp23.821,1 Triliun (2025)', 'GDP ~Rp23,821.1 Trillion (2025)')">
                    PDB ~Rp23.821,1 Triliun (2025)
                </span>
                <p class="mt-4 text-xs sm:text-sm text-gray-600 leading-relaxed">
                    <span x-text="$store.lang.t(
                        'Perekonomian Indonesia tumbuh 5,11% pada tahun 2025, mencapai estimasi PDB sebesar Rp23.821,1 triliun dengan daya beli domestik yang terbukti sangat tahan krisis.',
                        'Indonesia’s economy grew 5.11% in 2025, reaching approximately Rp23,821.1 trillion in GDP with strong domestic resilience and consumer spending power.'
                    )">
                        Indonesia’s economy grew 5.11% in 2025, reaching approximately Rp23,821.1 trillion in GDP.
                    </span>
                </p>
            </div>

            <div class="p-8 rounded-3xl bg-gray-50/80 border border-gray-200 hover:border-slate-400 transition-all">
                <span class="text-3xl sm:text-4xl font-black text-[#004741] block tracking-tight" x-text="$store.lang.t('64Jt+ UMKM', '64M+ MSMEs')">
                    64M+ UMKM
                </span>
                <span class="text-xs font-bold uppercase tracking-wider text-gray-400 mt-1 block" x-text="$store.lang.t('>60% PDB & 97% Tenaga Kerja', '>60% GDP & 97% Employment')">
                    >60% PDB & 97% Tenaga Kerja
                </span>
                <p class="mt-4 text-xs sm:text-sm text-gray-600 leading-relaxed">
                    <span x-text="$store.lang.t(
                        'Lebih dari 64 juta UMKM merepresentasikan lebih dari 60% PDB nasional dan 97% penyerapan tenaga kerja. Digitalisasi dan efisiensi rantai pasok adalah peluang struktural masif.',
                        'More than 64 million MSMEs represent over 60% of national GDP and nearly 97% of employment, making business digitalization and productivity a massive structural opportunity.'
                    )">
                        More than 64 million MSMEs represent over 60% of national GDP and nearly 97% of employment, making business digitalization and productivity a massive structural opportunity.
                    </span>
                </p>
            </div>

            <div class="p-8 rounded-3xl bg-gray-50/80 border border-gray-200 hover:border-slate-400 transition-all">
                <span class="text-3xl sm:text-4xl font-black text-[#004741] block tracking-tight">
                    US$300B+ GMV
                </span>
                <span class="text-xs font-bold uppercase tracking-wider text-gray-400 mt-1 block" x-text="$store.lang.t('Ekonomi Digital Asia Tenggara', 'Southeast Asia Digital Economy')">
                    Ekonomi Digital Asia Tenggara
                </span>
                <p class="mt-4 text-xs sm:text-sm text-gray-600 leading-relaxed">
                    <span x-text="$store.lang.t(
                        'Ekonomi digital Asia Tenggara diproyeksikan melampaui GMV US$300 miliar pada 2025 dengan pendapatan US$135 miliar, serta menarik pendanaan swasta US$120 miliar sedekade terakhir.',
                        'Southeast Asia’s digital economy is projected to surpass US$300B in GMV in 2025, with digital revenue of US$135B and US$120B in private funding over the past decade.'
                    )">
                        Meanwhile, Southeast Asia’s digital economy is projected to surpass US$300 billion in GMV in 2025, with digital-economy revenue projected at US$135 billion.
                    </span>
                </p>
            </div>
        </div>

        {{-- 5 Intersection Pillars (Directly Synchronized with Database Domains) --}}
        <div class="mt-12 p-8 sm:p-10 rounded-3xl bg-[#F8FAFA] border border-gray-200">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-3">
                <h3 class="text-lg sm:text-xl font-black text-gray-950">
                    <span x-text="$store.lang.t('Peluang Ini Bukan Hanya di Satu Pasar Tunggal', 'The Opportunity Isn’t One Market')">
                        The Opportunity Isn’t One Market
                    </span>
                </h3>
                <span class="text-[11px] font-mono font-bold text-teal-800 uppercase px-2.5 py-1 rounded-full bg-teal-100">
                    <span x-text="$store.lang.t('Sinkronisasi Database Domain', 'Synchronized from Domain DB')">Database Synchronized</span>
                </span>
            </div>
            <p class="text-xs sm:text-sm text-gray-600 mb-6 font-medium">
                <span x-text="$store.lang.t(
                    'Peluang terbesar lahir di titik temu (intersection) sektor-sektor fokus yang aktif dikembangkan YOIN:',
                    'It is the strategic intersection of the core domains actively engineered by YOIN:'
                )">
                    It is the intersection of:
                </span>
            </p>

            {{-- Dynamic Loop from Database Domains --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
                @foreach($domains as $idx => $domain)
                    <div 
                        @click="activeIssueTab = {{ $idx }}"
                        :class="activeIssueTab === {{ $idx }} ? 'border-[#004741] bg-slate-100 shadow-xs' : 'border-gray-200 bg-white'"
                        class="p-4 rounded-2xl border text-left cursor-pointer transition-all flex flex-col justify-between"
                    >
                        <div>
                            <div class="flex items-center justify-between gap-1 mb-2">
                                <span class="text-[10px] font-mono font-black text-[#004741]">DOMAIN 0{{ $loop->iteration }}</span>
                                <span class="w-2 h-2 rounded-full {{ $domain->status === 'OPERATING' ? 'bg-emerald-500' : 'bg-amber-400' }}"></span>
                            </div>
                            <div class="font-bold text-xs text-gray-950 mb-1">
                                <span x-text="$store.lang.t('{{ addslashes($domain->name_id) }}', '{{ addslashes($domain->name_en) }}')">
                                    {{ $domain->name_id }}
                                </span>
                            </div>
                            <p class="text-[11px] text-gray-500 line-clamp-2 leading-relaxed font-normal">
                                <span x-text="$store.lang.t('{{ addslashes($domain->tagline_id ?: $domain->problem_statement_id) }}', '{{ addslashes($domain->tagline_en ?: $domain->problem_statement_en) }}')">
                                    {{ $domain->tagline_id ?: $domain->problem_statement_id }}
                                </span>
                            </p>
                        </div>
                        <div class="mt-3 pt-2 border-t border-gray-100 flex items-center justify-between text-[10px] font-bold text-[#005952]">
                            <span x-text="$store.lang.t('Telaah Isu & Solusi', 'View Issues & Solutions')">Telaah Isu</span>
                            <span>↓</span>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- DYNAMIC ISSUES & VERIFIED SOLUTIONS ACCORDION/DRAWER (FROM DATABASE DOMAIN ISSUES) --}}
            <div class="mt-8 pt-6 border-t border-gray-200">
                <span class="text-[11px] font-mono font-bold uppercase tracking-wider text-[#005952] block mb-3" x-text="$store.lang.t('ISU-ISU NYATA LAPANGAN & SOLUSI TERVERIFIKASI DARI DATABASE:', 'VERIFIED FIELD ISSUES & ENGINEERED SOLUTIONS:')">
                    ISU-ISU NYATA LAPANGAN & SOLUSI TERVERIFIKASI:
                </span>

                @foreach($domains as $idx => $domain)
                    <div x-show="activeIssueTab === {{ $idx }}" class="space-y-4" style="{{ $idx === 0 ? '' : 'display: none;' }}">
                        <div class="p-5 rounded-2xl bg-white border border-teal-200 shadow-xs">
                            <div class="flex items-center justify-between gap-2 mb-3">
                                <h4 class="text-sm font-black text-gray-950">
                                    <span x-text="$store.lang.t('{{ addslashes($domain->name_id) }}', '{{ addslashes($domain->name_en) }}')">{{ $domain->name_id }}</span>
                                </h4>
                                <span class="text-[10px] font-mono text-gray-500">
                                    {{ count($domain->issues ?? []) }} {{ __('Isu Lapangan Terdokumentasi') }}
                                </span>
                            </div>

                            {{-- Problem Statement from DB --}}
                            <div class="p-3.5 rounded-xl bg-gray-50 border border-gray-200 text-xs text-gray-700 mb-4 leading-relaxed">
                                <span class="font-bold text-gray-900 block mb-1" x-text="$store.lang.t('Akar Masalah Utama (Primary Problem Statement):', 'Primary Root Problem:')">
                                    Akar Masalah Utama:
                                </span>
                                <span x-text="$store.lang.t('{{ addslashes($domain->problem_statement_id) }}', '{{ addslashes($domain->problem_statement_en) }}')">
                                    {{ $domain->problem_statement_id }}
                                </span>
                            </div>

                            {{-- Issues Array from DB --}}
                            @if(!empty($domain->issues) && is_array($domain->issues))
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                    @foreach($domain->issues as $item)
                                        @php
                                            $issueText = is_array($item) ? ($item['issue'] ?? '') : (string)$item;
                                            $solutionText = is_array($item) ? ($item['solution'] ?? '') : '';
                                        @endphp
                                        <div class="p-3.5 rounded-xl bg-[#F0F8F6] border border-teal-100 flex flex-col justify-between">
                                            <div class="space-y-2">
                                                <div class="text-[11px] text-rose-950 font-semibold leading-relaxed flex items-start gap-2">
                                                    <span class="px-1.5 py-0.5 rounded-md bg-rose-100 text-rose-800 text-[9px] font-mono font-bold shrink-0">ISU</span>
                                                    <span>{{ $issueText }}</span>
                                                </div>
                                                @if(!empty($solutionText))
                                                    <div class="text-[11px] text-teal-950 font-normal leading-relaxed flex items-start gap-2 pt-2 border-t border-teal-200/60">
                                                        <span class="px-1.5 py-0.5 rounded-md bg-teal-100 text-teal-800 text-[9px] font-mono font-bold shrink-0">SOLUSI</span>
                                                        <span>{{ $solutionText }}</span>
                                                    </div>
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

            <div class="mt-6 pt-4 text-xs sm:text-sm text-gray-700 italic">
                <span x-text="$store.lang.t(
                    'Kami percaya beberapa perusahaan terpenting masa depan akan lahir dari penyelesaian masalah-masalah nyata yang saat ini masih diselesaikan secara tidak efisien.',
                    'We believe some of the next important companies will emerge from problems that are still being solved inefficiently today.'
                )">
                    We believe some of the next important companies will emerge from problems that are still being solved inefficiently today.
                </span>
            </div>
        </div>
    </section>

    {{-- Divider --}}
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <hr class="border-gray-200">
    </div>

    {{-- 3. OUR THESIS --}}
    <section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 my-16 sm:my-24">
        <div class="text-left">
            <span class="text-xs font-mono font-bold tracking-widest text-[#005952] uppercase block mb-2" x-text="$store.lang.t('TESIS PEMBANGUNAN BISNIS', 'VENTURE THESIS')">
                TESIS PEMBANGUNAN BISNIS
            </span>
            <h2 class="text-2xl sm:text-4xl font-black text-gray-950 tracking-tight">
                <span x-text="$store.lang.t('TESIS KAMI: Temukan. Bangun. Uji. Kembangkan.', 'OUR THESIS: Find. Build. Validate. Grow.')">
                    OUR THESIS: Find. Build. Validate. Grow.
                </span>
            </h2>
            <div class="mt-4 p-5 rounded-2xl bg-slate-50 border border-slate-200 max-w-2xl text-xs sm:text-sm text-slate-900 leading-relaxed">
                <span class="font-bold block mb-1" x-text="$store.lang.t('Kami tidak memulai dengan bertanya:', 'We don’t begin by asking:')">We don’t begin by asking:</span>
                <span class="italic text-gray-700 block mb-2" x-text="$store.lang.t('«Startup apa yang sebaiknya kita buat?»', '“What startup should we build?”')">“What startup should we build?”</span>
                <span class="font-bold block mb-1" x-text="$store.lang.t('Kami selalu memulai dengan:', 'We begin with:')">We begin with:</span>
                <span class="font-black text-[#004741] text-sm sm:text-base" x-text="$store.lang.t('«Masalah nyata apa di lapangan yang layak kita selesaikan?»', '“What problem is worth solving?”')">“What problem is worth solving?”</span>
            </div>
        </div>

        {{-- 5 Process Steps --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-4 mt-10">
            <div class="p-6 rounded-3xl bg-white border border-gray-200 flex flex-col justify-between hover:shadow-sm transition-all">
                <div>
                    <span class="text-xs font-black font-mono tracking-wider text-[#005952] block mb-2">01 — DISCOVER</span>
                    <h4 class="font-black text-gray-900 text-sm mb-2" x-text="$store.lang.t('Menemukan Masalah', 'Discovery')">Discovery</h4>
                    <p class="text-xs text-gray-600 leading-relaxed" x-text="$store.lang.t('Kami turun langsung ke tempat di mana masalah benar-benar terjadi.', 'We go where problems actually exist.')">
                        We go where problems actually exist.
                    </p>
                </div>
            </div>

            <div class="p-6 rounded-3xl bg-white border border-gray-200 flex flex-col justify-between hover:shadow-sm transition-all">
                <div>
                    <span class="text-xs font-black font-mono tracking-wider text-[#005952] block mb-2">02 — EXPLORE</span>
                    <h4 class="font-black text-gray-900 text-sm mb-2" x-text="$store.lang.t('Eksplorasi Lapangan', 'Exploration')">Exploration</h4>
                    <p class="text-xs text-gray-600 leading-relaxed" x-text="$store.lang.t('Bekerja bersama pengguna nyata, komunitas lokal, pelaku usaha, dan mitra strategis.', 'We work with users, communities, businesses, and partners.')">
                        We work with users, communities, businesses, and partners.
                    </p>
                </div>
            </div>

            <div class="p-6 rounded-3xl bg-white border border-gray-200 flex flex-col justify-between hover:shadow-sm transition-all">
                <div>
                    <span class="text-xs font-black font-mono tracking-wider text-[#005952] block mb-2">03 — BUILD</span>
                    <h4 class="font-black text-gray-900 text-sm mb-2" x-text="$store.lang.t('Rekayasa Produk', 'Product Build')">Product Build</h4>
                    <p class="text-xs text-gray-600 leading-relaxed" x-text="$store.lang.t('Mengubah peluang terverifikasi menjadi produk tangguh dan entitas ventura mandiri.', 'We turn validated opportunities into products and ventures.')">
                        We turn validated opportunities into products and ventures.
                    </p>
                </div>
            </div>

            <div class="p-6 rounded-3xl bg-white border border-gray-200 flex flex-col justify-between hover:shadow-sm transition-all">
                <div>
                    <span class="text-xs font-black font-mono tracking-wider text-[#005952] block mb-2">04 — VALIDATE</span>
                    <h4 class="font-black text-gray-900 text-sm mb-2" x-text="$store.lang.t('Validasi Nyata', 'Real Validation')">Real Validation</h4>
                    <p class="text-xs text-gray-600 leading-relaxed" x-text="$store.lang.t('Menguji secara ketat di dunia nyata bersama pengguna dan pasar sesungguhnya.', 'We test them in the real world.')">
                        We test them in the real world.
                    </p>
                </div>
            </div>

            <div class="p-6 rounded-3xl bg-white border border-gray-200 flex flex-col justify-between hover:shadow-sm transition-all col-span-1 sm:col-span-2 md:col-span-1">
                <div>
                    <span class="text-xs font-black font-mono tracking-wider text-[#005952] block mb-2">05 — SCALE</span>
                    <h4 class="font-black text-gray-900 text-sm mb-2" x-text="$store.lang.t('Investasi Skala', 'Scale & Expand')">Scale & Expand</h4>
                    <p class="text-xs text-gray-600 leading-relaxed" x-text="$store.lang.t('Ketika traksi terbukti kuat, kami mengalokasikan investasi dan sumber daya lebih dalam.', 'When a venture demonstrates traction, we invest deeper.')">
                        When a venture demonstrates traction, we invest deeper.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- Divider --}}
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <hr class="border-gray-200">
    </div>

    {{-- 4. ONE ECOSYSTEM. DIFFERENT BETS. (SYNCHRONIZED WITH INITIATIVES & PRODUCTS DB) --}}
    <section id="ecosystem-bets" class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 my-16 sm:my-24">
        <div class="text-left">
            <span class="text-xs font-mono font-bold tracking-widest text-[#005952] uppercase block mb-2" x-text="$store.lang.t('ARSITEKTUR PLATFORM & RAGAM BISNIS', 'PLATFORM ARCHITECTURE & VENTURES')">
                ARSITEKTUR PLATFORM & RAGAM BISNIS
            </span>
            <h2 class="text-2xl sm:text-4xl font-black text-gray-950 tracking-tight">
                <span x-text="$store.lang.t('SATU EKOSISTEM. BERBAGAI TARUHAN STRATEGIS.', 'ONE ECOSYSTEM. DIFFERENT BETS.')">
                    ONE ECOSYSTEM. DIFFERENT BETS.
                </span>
            </h2>
            <p class="text-base sm:text-lg text-gray-600 mt-2 font-medium">
                <span class="font-bold text-gray-900" x-text="$store.lang.t('YOIN adalah platform induknya.', 'YOIN is the platform.')">
                    YOIN is the platform.
                </span>
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-10">
            {{-- Left: Venture Independence --}}
            <div class="p-8 rounded-3xl bg-gray-50 border border-gray-200">
                <h3 class="text-lg font-black text-gray-900 mb-4 flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-teal-500"></span>
                    <span x-text="$store.lang.t('Setiap Unit Usaha Memiliki:', 'Each Venture Has Its Own:')">Each Venture Has Its Own:</span>
                </h3>
                <ul class="space-y-3 text-xs sm:text-sm text-gray-700">
                    <li class="flex items-center gap-3 font-semibold">
                        <svg class="w-4 h-4 text-[#005952]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span x-text="$store.lang.t('Tim & Pemimpin Khusus (Dedicated Team)', 'Dedicated Team & Leadership')">Dedicated Team & Leadership</span>
                    </li>
                    <li class="flex items-center gap-3 font-semibold">
                        <svg class="w-4 h-4 text-[#005952]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span x-text="$store.lang.t('Produk & Roadmap Solusi Mandiri', 'Independent Product & Roadmap')">Independent Product & Roadmap</span>
                    </li>
                    <li class="flex items-center gap-3 font-semibold">
                        <svg class="w-4 h-4 text-[#005952]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span x-text="$store.lang.t('Target Segmen Pasar Jelas', 'Target Addressable Market')">Target Addressable Market</span>
                    </li>
                    <li class="flex items-center gap-3 font-semibold">
                        <svg class="w-4 h-4 text-[#005952]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span x-text="$store.lang.t('Model Bisnis & Arus Kas Berkelanjutan', 'Sustainable Business Model')">Sustainable Business Model</span>
                    </li>
                    <li class="flex items-center gap-3 font-semibold">
                        <svg class="w-4 h-4 text-[#005952]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span x-text="$store.lang.t('Strategi Pertumbuhan Otonom', 'Autonomous Growth Strategy')">Autonomous Growth Strategy</span>
                    </li>
                </ul>
            </div>

            {{-- Right: YOIN Shared Foundation --}}
            <div class="p-8 rounded-3xl bg-[#F0F8F6] border border-teal-200">
                <h3 class="text-lg font-black text-[#005952] mb-4 flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-[#005952]"></span>
                    <span x-text="$store.lang.t('YOIN Menyediakan Fondasi Bersama:', 'YOIN Provides The Shared Foundation:')">YOIN Provides The Shared Foundation:</span>
                </h3>
                <div class="grid grid-cols-2 gap-3 text-xs sm:text-sm text-gray-800 font-semibold">
                    <div class="p-3 bg-white rounded-xl border border-teal-100 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-[#005952]"></span>
                        <span x-text="$store.lang.t('Permodalan (Capital)', 'Capital')">Capital (Modal)</span>
                    </div>
                    <div class="p-3 bg-white rounded-xl border border-teal-100 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-[#005952]"></span>
                        <span x-text="$store.lang.t('Talenta Ahli (Talent)', 'Specialized Talent')">Talent (Talenta)</span>
                    </div>
                    <div class="p-3 bg-white rounded-xl border border-teal-100 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-[#005952]"></span>
                        <span x-text="$store.lang.t('Teknologi & Hak Paten IP', 'Technology & IP')">Technology & IP</span>
                    </div>
                    <div class="p-3 bg-white rounded-xl border border-teal-100 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-[#005952]"></span>
                        <span x-text="$store.lang.t('Jejaring Mitra (Network)', 'Institutional Network')">Network & Relasi</span>
                    </div>
                    <div class="p-3 bg-white rounded-xl border border-teal-100 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-[#005952]"></span>
                        <span x-text="$store.lang.t('Pengetahuan Riset (Knowledge)', 'Accumulated Knowledge')">Knowledge Base</span>
                    </div>
                    <div class="p-3 bg-white rounded-xl border border-teal-100 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-[#005952]"></span>
                        <span x-text="$store.lang.t('Legal & Operasional Bersama', 'Operations & Legal')">Operations & Legal</span>
                    </div>
                    <div class="p-3 bg-white rounded-xl border border-teal-100 flex items-center gap-2 col-span-2">
                        <span class="w-2 h-2 rounded-full bg-[#005952]"></span>
                        <span x-text="$store.lang.t('Kredibilitas Brand & Reputasi Holding', 'Brand & Ecosystem Reputation')">Brand & Ecosystem Reputation</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Active Portfolio Cards (Directly Synchronized with Database Initiatives & Products) --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-10">
            @foreach($initiatives as $init)
                <div class="p-7 rounded-3xl bg-white border border-gray-200 flex flex-col justify-between hover:border-teal-400 transition-all shadow-2xs">
                    <div>
                        <div class="flex items-center justify-between gap-2 mb-3">
                            <span class="text-xs font-mono font-bold tracking-wider text-[#005952] uppercase">
                                <span x-text="$store.lang.t('{{ addslashes($init->domain->name_id ?? 'Unit Usaha') }}', '{{ addslashes($init->domain->name_en ?? 'Venture Unit') }}')">
                                    {{ $init->domain->name_id ?? 'Unit Usaha' }}
                                </span>
                            </span>
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold {{ $init->status === 'OPERATING' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                {{ $init->status === 'OPERATING' ? 'Operating' : ($init->stage ?: 'Building') }}
                            </span>
                        </div>
                        <h4 class="text-xl font-black text-gray-900 mb-2">{{ $init->name }}</h4>
                        <p class="text-xs sm:text-sm text-gray-600 leading-relaxed mb-4 font-normal">
                            <span x-text="$store.lang.t('{{ addslashes($init->tagline_id ?: $init->problem_statement_id) }}', '{{ addslashes($init->tagline_en ?: $init->problem_statement_en) }}')">
                                {{ $init->tagline_id ?: $init->problem_statement_id }}
                            </span>
                        </p>

                        {{-- Registered Products in Database --}}
                        @if($init->products && $init->products->count() > 0)
                            <div class="pt-3 border-t border-gray-100 space-y-1.5">
                                <span class="text-[10px] font-mono font-bold text-gray-400 uppercase tracking-wider block" x-text="$store.lang.t('Produk & Platform Terdaftar di DB:', 'Registered DB Products:')">
                                    Registered Products:
                                </span>
                                <div class="flex flex-wrap gap-1.5">
                                    @foreach($init->products as $p)
                                        <a 
                                            href="{{ $p->website_url ?: '#pipeline-produk' }}" 
                                            class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-slate-100 border border-slate-200 text-slate-800 text-[11px] font-bold hover:bg-slate-200 transition-colors"
                                        >
                                            <span class="w-1.5 h-1.5 rounded-full bg-[#004741]"></span>
                                            <span>{{ $p->name }}</span>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- Focus Areas Chips --}}
                        @if(!empty($init->focus_areas) && is_array($init->focus_areas))
                            <div class="mt-3 flex flex-wrap gap-1">
                                @foreach(array_slice($init->focus_areas, 0, 3) as $area)
                                    <span class="text-[10px] px-2 py-0.5 rounded-md bg-gray-100 text-gray-600 font-medium">
                                        {{ $area }}
                                    </span>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <div class="mt-6 pt-4 border-t border-gray-100 flex items-center justify-between text-xs">
                        <span class="text-gray-400 font-medium text-[11px]">
                            {{ $init->locus ?: 'Nasional' }}
                        </span>
                        <a 
                            href="{{ $init->external_website_url ?: url('/layanan') }}" 
                            target="_blank" 
                            rel="noopener" 
                            class="font-bold text-[#005952] hover:underline"
                            x-text="$store.lang.t('Buka Situs →', 'Visit Site →')"
                        >
                            {{ $init->external_url_label ?: 'Pelajari →' }}
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- 4B. PIPELINE PRODUK & REKAYASA MASALAH DARI DATABASE (ECOSYSTEM PRODUCTS SHOWCASE) --}}
    @if(isset($products) && $products->count() > 0)
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <hr class="border-gray-200">
        </div>

        <section id="pipeline-produk" class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 my-16 sm:my-24 text-left">
            <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-8">
                <div>
                    <span class="text-xs font-mono font-bold tracking-widest text-[#005952] uppercase block mb-1" x-text="$store.lang.t('KATALOG PRODUK & PLATFORM DATABASE', 'DATABASE PRODUCTS & PLATFORMS')">
                        KATALOG PRODUK & PLATFORM DATABASE
                    </span>
                    <h2 class="text-2xl sm:text-4xl font-black text-gray-950 tracking-tight">
                        <span x-text="$store.lang.t('PRODUK & INOVASI TERVALIDASI', 'VALIDATED PRODUCTS & DEEP TECH PIPELINE')">
                            PRODUK & INOVASI TERVALIDASI
                        </span>
                    </h2>
                    <p class="text-xs sm:text-sm text-gray-600 mt-1 max-w-2xl font-medium">
                        <span x-text="$store.lang.t(
                            'Setiap produk yang lahir di ekosistem YOIN memiliki dokumentasi akar masalah yang jelas, solusi rekayasa terverifikasi, dan status kesiapan pasar.',
                            'Every product born within the YOIN ecosystem has a documented root problem, engineered solution, and verified commercial readiness.'
                        )">
                            Setiap produk memiliki dokumentasi akar masalah dan solusi terverifikasi dari database.
                        </span>
                    </p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-xs font-mono font-bold text-gray-500">
                        {{ $products->count() }} {{ __('Produk Terdaftar') }}
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($products as $prod)
                    <div class="p-6 rounded-3xl bg-white border border-gray-200 hover:border-[#005952] transition-all flex flex-col justify-between shadow-2xs">
                        <div>
                            <div class="flex items-center justify-between gap-2 mb-2">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-teal-100 text-[#005952] uppercase font-mono">
                                    {{ $prod->type ?: 'Product' }}
                                </span>
                                <span class="text-[10px] font-bold text-gray-400">
                                    {{ $prod->initiative->name ?? 'YOIN' }}
                                </span>
                            </div>

                            <h3 class="text-base font-black text-gray-950 mb-2">
                                {{ $prod->name }}
                            </h3>

                            <p class="text-xs text-gray-600 mb-4 leading-relaxed font-normal">
                                <span x-text="$store.lang.t('{{ addslashes($prod->description_id) }}', '{{ addslashes($prod->description_en) }}')">
                                    {{ $prod->description_id }}
                                </span>
                            </p>

                            {{-- Problem Statement for this specific product --}}
                            @if(!empty($prod->problem_statement_id))
                                <div class="p-3 rounded-xl bg-slate-50 border-l-4 border-slate-700 border-y border-r border-slate-200 text-[11px] text-slate-700 mb-2 leading-relaxed">
                                    <span class="font-bold block text-slate-900 text-[10px] uppercase font-mono mb-0.5" x-text="$store.lang.t('Isu / Masalah Nyata:', 'Real Problem Solved:')">
                                        Isu / Masalah:
                                    </span>
                                    <span x-text="$store.lang.t('{{ addslashes($prod->problem_statement_id) }}', '{{ addslashes($prod->problem_statement_en) }}')">
                                        {{ $prod->problem_statement_id }}
                                    </span>
                                </div>
                            @endif

                            {{-- Solution for this specific product --}}
                            @if(!empty($prod->solution_statement_id))
                                <div class="p-3 rounded-xl bg-slate-50 border-l-4 border-[#004741] border-y border-r border-slate-200 text-[11px] text-slate-800 leading-relaxed">
                                    <span class="font-bold block text-[#004741] text-[10px] uppercase font-mono mb-0.5" x-text="$store.lang.t('Solusi Rekayasa YOIN:', 'Engineered Solution:')">
                                        Solusi Rekayasa:
                                    </span>
                                    <span x-text="$store.lang.t('{{ addslashes($prod->solution_statement_id) }}', '{{ addslashes($prod->solution_statement_en) }}')">
                                        {{ $prod->solution_statement_id }}
                                    </span>
                                </div>
                            @endif
                        </div>

                        <div class="mt-5 pt-3 border-t border-gray-100 flex items-center justify-between text-xs">
                            <span class="text-[10px] font-mono font-bold text-gray-400">
                                {{ $prod->status ?: 'OPERATING' }}
                            </span>
                            @if(!empty($prod->website_url))
                                <a 
                                    href="{{ $prod->website_url }}" 
                                    target="_blank" 
                                    rel="noopener" 
                                    class="text-xs font-bold text-[#005952] hover:underline flex items-center gap-1"
                                >
                                    <span x-text="$store.lang.t('Akses Produk', 'Launch Product')">Akses Produk</span>
                                    <span>↗</span>
                                </a>
                            @else
                                <span class="text-[11px] text-gray-400 font-medium" x-text="$store.lang.t('Riset In-House', 'In-House R&D')">Riset In-House</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    {{-- Divider --}}
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <hr class="border-gray-200">
    </div>

    {{-- 5. OUR TRACTION --}}
    <section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 my-16 sm:my-24">
        <div class="text-left max-w-3xl">
            <span class="text-xs font-mono font-bold tracking-widest text-[#005952] uppercase block mb-2" x-text="$store.lang.t('BUKTI & TRAKSI OPERASIONAL', 'INTERNAL OPERATIONAL EVIDENCE')">
                BUKTI & TRAKSI OPERASIONAL
            </span>
            <h2 class="text-2xl sm:text-4xl font-black text-gray-950 tracking-tight">
                <span x-text="$store.lang.t('BUKTI TRAKSI KAMI', 'OUR TRACTION')">
                    OUR TRACTION
                </span>
            </h2>
            <p class="text-base sm:text-lg text-gray-700 mt-2 font-medium">
                <span x-text="$store.lang.t(
                    'Kami tidak menjual visi kosong tanpa bukti. Seluruh angka di bawah ini berakar dari rekam jejak operasional internal yang terverifikasi dan dapat dipertanggungjawabkan.',
                    'We don’t want to sell a vision without evidence. Only include financial and operational metrics that can be documented.'
                )">
                    We don’t want to sell a vision without evidence.
                </span>
            </p>
        </div>

        {{-- Metrics Grid (Loaded dynamically from database invest_metrics) --}}
        @php
            $metricsList = $profile->invest_metrics ?: \App\Models\CompanyProfile::defaultInvestMetrics();
        @endphp

        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 sm:gap-6 mt-10">
            @foreach($metricsList as $metric)
                <div class="p-6 rounded-3xl bg-gray-50 border border-gray-200 text-center hover:bg-white hover:border-[#005952] transition-all">
                    <span class="text-2xl sm:text-4xl font-black text-[#005952] block tracking-tight">
                        {{ $metric['value'] ?? '—' }}
                    </span>
                    <span class="text-xs sm:text-sm font-semibold text-gray-700 mt-2 block">
                        {{ $metric['label'] ?? '' }}
                    </span>
                </div>
            @endforeach
        </div>

        <div class="mt-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 p-6 rounded-2xl bg-[#F8FAFA] border border-gray-200">
            <div class="text-xs text-gray-500 font-medium">
                <span x-text="$store.lang.t(
                    '* Angka dan indikator kinerja internal diperbarui secara berkala berdasarkan audit tata kelola ekosistem holding YOIN.',
                    '* Operational metrics and indicators are regularly documented and verified through internal governance.'
                )">
                    * Audited and verified figures.
                </span>
            </div>
            <div>
                <button 
                    type="button" 
                    @click="dataroomModalOpen = true"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-[#005952] hover:bg-[#004741] text-white text-xs font-bold tracking-wider uppercase transition-all shadow-xs cursor-pointer"
                >
                    <span x-text="$store.lang.t('Buka YOIN Data Room', 'View YOIN Data Room')">View YOIN Data Room</span>
                    <span>→</span>
                </button>
            </div>
        </div>
    </section>

    {{-- Divider --}}
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <hr class="border-gray-200">
    </div>

    {{-- 6. FROM A SMALL PLACE TO A BIGGER POSSIBILITY (FOUNDER ORIGIN STORY) --}}
    <section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 my-16 sm:my-24">
        <div class="p-8 sm:p-14 rounded-3xl bg-gradient-to-br from-gray-900 via-gray-950 to-gray-900 text-white shadow-xl relative overflow-hidden">
            {{-- Ambient Glow --}}
            <div class="absolute -right-20 -bottom-20 w-80 h-80 bg-slate-600/20 rounded-full blur-3xl pointer-events-none"></div>

            <div class="relative z-10 max-w-3xl">
                <span class="text-xs font-mono font-bold tracking-widest text-slate-300 uppercase block mb-3" x-text="$store.lang.t('KISAH ASAL-USUL FOUNDER', 'ORIGIN STORY')">
                    ORIGIN STORY
                </span>
                
                <h2 class="text-2xl sm:text-4xl font-black tracking-tight leading-tight mb-6">
                    <span x-text="$store.lang.t('DARI TEMPAT KECIL MENUJU KEMUNGKINAN LEBIH BESAR', 'FROM A SMALL PLACE TO A BIGGER POSSIBILITY')">
                        FROM A SMALL PLACE TO A BIGGER POSSIBILITY
                    </span>
                </h2>

                <div class="space-y-4 text-xs sm:text-sm sm:leading-relaxed text-gray-300 font-normal">
                    <p class="text-lg sm:text-xl font-bold text-white leading-snug">
                        <span x-text="$store.lang.t('Ini tidak dimulai dengan modal besar.', 'It didn’t start with capital.')">
                            It didn’t start with capital.
                        </span>
                    </p>
                    <p>
                        <span x-text="$store.lang.t(
                            'Kisah di balik lahirnya YOIN tidak berawal dari gedung perkantoran megah, kawasan bisnis elit, ataupun suntikan dana raksasa. Segalanya berakar jauh lebih dekat ke tanah kehidupan nyata.',
                            'The story behind YOIN didn’t begin in a big office, a major business district, or with a large amount of capital. It started much closer to the ground.'
                        )">
                            The story behind YOIN didn’t begin in a big office, a major business district, or with a large amount of capital. It started much closer to the ground.
                        </span>
                    </p>
                    <p>
                        <span x-text="$store.lang.t(
                            'Founder kami tumbuh dengan merasakan langsung arti keterbatasan — sumber daya yang minim, akses informasi yang sempit, dan keharusan mencari solusi atas apa yang ada di depan mata.',
                            'The founder grew up experiencing limitations firsthand — limited resources, limited access, and the reality of having to figure things out with what was available.'
                        )">
                            The founder grew up experiencing limitations firsthand — limited resources, limited access, and the reality of having to figure things out with what was available.
                        </span>
                    </p>
                    
                    <div class="py-2 pl-4 border-l-2 border-white my-4 text-white font-medium space-y-1">
                        <p x-text="$store.lang.t('Teknologi menjadi sarana untuk belajar mandiri.', 'Technology became a way to learn.')">Technology became a way to learn.</p>
                        <p x-text="$store.lang.t('Membangun karya menjadi cara untuk menyelesaikan persoalan.', 'Building became a way to solve problems.')">Building became a way to solve problems.</p>
                        <p x-text="$store.lang.t('Hingga perlahan, eksperimen-eksperimen kecil bertransformasi menjadi proyek.', 'And eventually, small experiments became projects.')">And eventually, small experiments became projects.</p>
                        <p x-text="$store.lang.t('Proyek melahirkan tim kerja yang solid.', 'Projects became teams.')">Projects became teams.</p>
                        <p x-text="$store.lang.t('Tim berkembang menjadi unit ventura mandiri.', 'Teams became ventures.')">Teams became ventures.</p>
                        <p x-text="$store.lang.t('Dan kumpulan ventura itulah yang menjadi awal mula lahirnya YOIN.', 'And those ventures became the beginning of YOIN.')">And those ventures became the beginning of YOIN.</p>
                    </div>

                    <p class="text-base sm:text-lg font-bold text-white">
                        <span x-text="$store.lang.t('Dari sumber daya terbatas menjadi rasa ingin tahu tanpa batas.', 'From limited resources to unlimited curiosity.')">
                            From limited resources to unlimited curiosity.
                        </span>
                    </p>
                    <p>
                        <span x-text="$store.lang.t(
                            'Ambisinya tidak pernah sekadar membangun satu startup sukses lalu selesai. Ambisinya adalah menciptakan ekosistem tempat orang-orang dapat mengubah masalah menjadi ide, ide menjadi produk, dan produk menjadi perusahaan yang berdaya tahan tinggi.',
                            'The ambition was never simply to build one successful startup. It was to build an environment where people could turn problems into ideas, ideas into products, and products into companies.'
                        )">
                            The ambition was never simply to build one successful startup. It was to build an environment where people could turn problems into ideas, ideas into products, and products into companies.
                        </span>
                    </p>
                    <p class="text-white font-bold">
                        <span x-text="$store.lang.t('Di situlah perjalanan YOIN bermula.', 'That’s where YOIN began.')">
                            That’s where YOIN began.
                        </span>
                    </p>
                </div>

                <div class="mt-8 pt-6 border-t border-gray-800 flex flex-wrap items-center gap-4">
                    <a 
                        href="{{ route('public.about.achievements') }}" 
                        class="inline-flex items-center gap-2 px-6 py-3 rounded-full bg-white hover:bg-slate-200 text-gray-950 text-xs font-bold tracking-wider uppercase transition-all shadow-md"
                    >
                        <span x-text="$store.lang.t('Lihat Penghargaan & Tonggak Cerita', 'Read the Founder Story & Milestones')">Read the Founder Story</span>
                        <span>→</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- Divider --}}
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <hr class="border-gray-200">
    </div>

    {{-- 7. THE PEOPLE BEHIND THE BETS --}}
    <section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 my-16 sm:my-24">
        <div class="text-left">
            <span class="text-xs font-mono font-bold tracking-widest text-[#005952] uppercase block mb-2" x-text="$store.lang.t('INSAN DI BALIK EKOSISTEM', 'TALENT & LEADERSHIP')">
                INSAN DI BALIK EKOSISTEM
            </span>
            <h2 class="text-2xl sm:text-4xl font-black text-gray-950 tracking-tight">
                <span x-text="$store.lang.t('ORANG-ORANG DI BALIK SETIAP TARUHAN', 'THE PEOPLE BEHIND THE BETS')">
                    THE PEOPLE BEHIND THE BETS
                </span>
            </h2>
            <p class="text-lg font-bold text-[#005952] mt-2">
                <span x-text="$store.lang.t('Kami berinvestasi pada manusianya sebelum memperbesar skala perusahaannya.', 'We invest in people before we scale companies.')">
                    We invest in people before we scale companies.
                </span>
            </p>
            <p class="text-xs sm:text-sm text-gray-600 mt-2 max-w-2xl leading-relaxed">
                <span x-text="$store.lang.t(
                    'YOIN dibangun oleh insan dengan beragam latar belakang, keahlian, dan rekam jejak — memadukan software engineer, agronomis, inovator produk, ahli hukum, dan pendamping komunitas lokal.',
                    'YOIN is built by people with different backgrounds, disciplines, and experiences — uniting engineers, agronomists, operators, and community leaders.'
                )">
                    YOIN is built by people with different backgrounds, disciplines, and experiences.
                </span>
            </p>
        </div>

        {{-- Talent Metrics Strip --}}
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mt-8">
            <div class="p-5 rounded-2xl bg-gray-50 border border-gray-200 text-center">
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block">Founder & CEO</span>
                <span class="text-lg sm:text-xl font-black text-gray-900 mt-1 block">Founder Team</span>
            </div>
            <div class="p-5 rounded-2xl bg-gray-50 border border-gray-200 text-center">
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block" x-text="$store.lang.t('Tim Inti', 'Core Team')">Core Team</span>
                <span class="text-lg sm:text-xl font-black text-[#005952] mt-1 block" x-text="$store.lang.t('18+ Orang', '18+ People')">18+ People</span>
            </div>
            <div class="p-5 rounded-2xl bg-gray-50 border border-gray-200 text-center">
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block" x-text="$store.lang.t('Pimpinan Ventura', 'Venture Leaders')">Venture Leaders</span>
                <span class="text-lg sm:text-xl font-black text-[#005952] mt-1 block" x-text="$store.lang.t('5 Domain Leads', '5 Domain Leads')">5 Domain Leads</span>
            </div>
            <div class="p-5 rounded-2xl bg-gray-50 border border-gray-200 text-center">
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block" x-text="$store.lang.t('Kolaborator Mitra', 'Collaborators')">Collaborators</span>
                <span class="text-lg sm:text-xl font-black text-[#005952] mt-1 block" x-text="$store.lang.t('45+ Lintas Wilayah', '45+ Across Regions')">45+ Across Regions</span>
            </div>
        </div>

        {{-- Team Representation Cards --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4 mt-8">
            <div class="p-5 rounded-2xl bg-white border border-gray-200 text-center flex flex-col items-center justify-between">
                <div class="w-14 h-14 rounded-full bg-slate-100 border border-slate-300 text-slate-900 flex items-center justify-center font-black text-lg mb-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
                <div class="text-xs font-bold text-gray-900">Founder & CEO</div>
                <div class="text-[10px] text-gray-500 mt-1" x-text="$store.lang.t('Arah Strategis', 'Strategic Direction')">Strategic Direction</div>
            </div>

            <div class="p-5 rounded-2xl bg-white border border-gray-200 text-center flex flex-col items-center justify-between">
                <div class="w-14 h-14 rounded-full bg-slate-100 border border-slate-300 text-slate-900 flex items-center justify-center font-black text-lg mb-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"/></svg>
                </div>
                <div class="text-xs font-bold text-gray-900">Venture Lead</div>
                <div class="text-[10px] text-gray-500 mt-1">AGRONEX / AgriTech</div>
            </div>

            <div class="p-5 rounded-2xl bg-white border border-gray-200 text-center flex flex-col items-center justify-between">
                <div class="w-14 h-14 rounded-full bg-slate-100 border border-slate-300 text-slate-900 flex items-center justify-center font-black text-lg mb-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                </div>
                <div class="text-xs font-bold text-gray-900">Product Lead</div>
                <div class="text-[10px] text-gray-500 mt-1">YOIN DIGITAL</div>
            </div>

            <div class="p-5 rounded-2xl bg-white border border-gray-200 text-center flex flex-col items-center justify-between">
                <div class="w-14 h-14 rounded-full bg-slate-100 border border-slate-300 text-slate-900 flex items-center justify-center font-black text-lg mb-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>
                </div>
                <div class="text-xs font-bold text-gray-900">Technology</div>
                <div class="text-[10px] text-gray-500 mt-1">Software & Cloud IP</div>
            </div>

            <div class="p-5 rounded-2xl bg-white border border-gray-200 text-center flex flex-col items-center justify-between">
                <div class="w-14 h-14 rounded-full bg-indigo-50 border border-indigo-200 text-indigo-700 flex items-center justify-center font-black text-lg mb-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
                <div class="text-xs font-bold text-gray-900">Operations</div>
                <div class="text-[10px] text-gray-500 mt-1" x-text="$store.lang.t('Legal & Finansial', 'Legal & Shared Ops')">Legal & Shared Ops</div>
            </div>

            <div class="p-5 rounded-2xl bg-white border border-gray-200 text-center flex flex-col items-center justify-between">
                <div class="w-14 h-14 rounded-full bg-slate-100 border border-slate-200 text-slate-800 flex items-center justify-center font-black text-lg mb-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
                <div class="text-xs font-bold text-gray-900">Community</div>
                <div class="text-[10px] text-gray-500 mt-1" x-text="$store.lang.t('Program Dampak & ESG', 'Impact & ESG Programs')">Impact & ESG Program</div>
            </div>
        </div>

        <div class="mt-8 text-left">
            <a 
                href="{{ route('public.about.profile') }}" 
                class="inline-flex items-center gap-2 text-xs font-bold text-[#005952] hover:underline"
            >
                <span x-text="$store.lang.t('Temui tim lengkap yang membangun YOIN', 'Meet the people building YOIN')">Meet the people building YOIN</span>
                <span>→</span>
            </a>
        </div>
    </section>

    {{-- Divider --}}
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <hr class="border-gray-200">
    </div>

    {{-- 8. WHY WE ARE DIFFERENT --}}
    <section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 my-16 sm:my-24">
        <div class="text-left">
            <span class="text-xs font-mono font-bold tracking-widest text-[#005952] uppercase block mb-2" x-text="$store.lang.t('DIFERENSIASI KAMI', 'STRATEGIC ADVANTAGES')">
                DIFERENSIASI KAMI
            </span>
            <h2 class="text-2xl sm:text-4xl font-black text-gray-950 tracking-tight">
                <span x-text="$store.lang.t('MENGAPA KAMI BERBEDA', 'WHY WE ARE DIFFERENT')">
                    WHY WE ARE DIFFERENT
                </span>
            </h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-10">
            <div class="p-7 rounded-3xl bg-gray-50 border border-gray-200 flex flex-col justify-between">
                <div>
                    <span class="text-xs font-mono font-bold text-[#005952] block mb-2">01</span>
                    <h3 class="text-base font-black text-gray-900 mb-2" x-text="$store.lang.t('Kami Membangun, Bukan Cuma Mendanai', 'We build, not just invest')">We build, not just invest.</h3>
                    <p class="text-xs sm:text-sm text-gray-600 leading-relaxed" x-text="$store.lang.t(
                        'Kami tidak hanya membagikan modal pada ide orang lain. Kami merakit ventura dari nol, merancang arsitektur produk, dan memimpin operasional secara langsung.',
                        'We don’t only allocate capital to existing ideas. We develop ventures from the ground up with hands-on product engineering and leadership.'
                    )">
                        We don’t only allocate capital to existing ideas. We develop ventures from the ground up.
                    </p>
                </div>
            </div>

            <div class="p-7 rounded-3xl bg-gray-50 border border-gray-200 flex flex-col justify-between">
                <div>
                    <span class="text-xs font-mono font-bold text-[#005952] block mb-2">02</span>
                    <h3 class="text-base font-black text-gray-900 mb-2" x-text="$store.lang.t('Kami Dekat dengan Akar Masalah', 'We stay close to the problem')">We stay close to the problem.</h3>
                    <p class="text-xs sm:text-sm text-gray-600 leading-relaxed" x-text="$store.lang.t(
                        'Bisnis kami dirancang berdasarkan dialog nyata dengan para pelaku usaha, petani, lembaga publik, dan masyarakat yang merasakan masalah itu sendiri setiap hari.',
                        'Our ventures are informed by businesses, farmers, communities, institutions, and people who experience these problems firsthand.'
                    )">
                        Our ventures are informed by businesses, farmers, communities, institutions, and people who experience these problems firsthand.
                    </p>
                </div>
            </div>

            <div class="p-7 rounded-3xl bg-gray-50 border border-gray-200 flex flex-col justify-between">
                <div>
                    <span class="text-xs font-mono font-bold text-[#005952] block mb-2">03</span>
                    <h3 class="text-base font-black text-gray-900 mb-2" x-text="$store.lang.t('Lintas Sektor, Namun Fokus di Setiap Unit', 'Multi-sector holding, focused ventures')">We build across sectors, but stay focused within each venture.</h3>
                    <p class="text-xs sm:text-sm text-gray-600 leading-relaxed" x-text="$store.lang.t(
                        'YOIN dapat menjelajahi multi-sektor strategis di tingkat holding. Namun masing-masing ventura tetap terfokus penuh pada target konsumen dan unit ekonominya.',
                        'YOIN may explore multiple high-conviction sectors at the ecosystem level. Each venture does not have to, maintaining disciplined focus.'
                    )">
                        YOIN may explore multiple sectors. Each venture does not have to.
                    </p>
                </div>
            </div>

            <div class="p-7 rounded-3xl bg-gray-50 border border-gray-200 flex flex-col justify-between">
                <div>
                    <span class="text-xs font-mono font-bold text-[#005952] block mb-2">04</span>
                    <h3 class="text-base font-black text-gray-900 mb-2" x-text="$store.lang.t('Ekosistem Bersama, Bukan Perusahaan Terisolasi', 'An ecosystem, not isolated companies')">We build an ecosystem, not isolated companies.</h3>
                    <p class="text-xs sm:text-sm text-gray-600 leading-relaxed" x-text="$store.lang.t(
                        'Talenta terbaik, teknologi paten, koneksi mitra, dan infrastruktur operasional bergerak bebas antar unit usaha, memangkas biaya duplikasi secara dramatis.',
                        'Talent, technology, knowledge, partnerships, and infrastructure move fluidly across the ecosystem, dramatically reducing overhead costs.'
                    )">
                        Talent, technology, knowledge, partnerships, and infrastructure can move across the ecosystem.
                    </p>
                </div>
            </div>

            <div class="p-7 rounded-3xl bg-gray-50 border border-gray-200 flex flex-col justify-between md:col-span-2 lg:col-span-2">
                <div>
                    <span class="text-xs font-mono font-bold text-[#005952] block mb-2">05</span>
                    <h3 class="text-base font-black text-gray-900 mb-2" x-text="$store.lang.t('Lahir dari Indonesia, Berdaya Saing Global', 'Built from Indonesia, broader ambition')">We are built from Indonesia, with a broader ambition.</h3>
                    <p class="text-xs sm:text-sm text-gray-600 leading-relaxed" x-text="$store.lang.t(
                        'Masalah lokal dapat bertransformasi menjadi peluang global. Menyelesaikan friksi rantai pasok dan produktivitas di Indonesia menghasilkan solusi yang siap diduplikasi ke negara berkembang lainnya di dunia.',
                        'Local problems can become global opportunities. Solving supply chain and productivity friction in Indonesia produces solutions scalable to emerging markets worldwide.'
                    )">
                        Local problems can become global opportunities.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- Divider --}}
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <hr class="border-gray-200">
    </div>

    {{-- 9. OUR IMPACT (YOIN ADIWIDYA CENTER & SYNCHRONIZED IMPACT METRICS) --}}
    <section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 my-16 sm:my-24">
        <div class="text-left max-w-3xl">
            <span class="text-xs font-mono font-bold tracking-widest text-[#005952] uppercase block mb-2" x-text="$store.lang.t('DAMPAK SOSIAL & LINGKUNGAN', 'SUSTAINABILITY & ESG')">
                DAMPAK SOSIAL & LINGKUNGAN
            </span>
            <h2 class="text-2xl sm:text-4xl font-black text-gray-950 tracking-tight">
                <span x-text="$store.lang.t('DAMPAK NYATA BAGI NEGERI', 'OUR IMPACT')">
                    OUR IMPACT
                </span>
            </h2>
            <p class="text-lg font-bold text-[#005952] mt-2">
                <span x-text="$store.lang.t('Pertumbuhan bisnis harus menciptakan lebih dari sekadar dividen finansial.', 'Growth should create more than financial value.')">
                    Growth should create more than financial value.
                </span>
            </p>
            <p class="text-xs sm:text-sm text-gray-600 mt-2 leading-relaxed">
                <span x-text="$store.lang.t(
                    'Melalui YOIN Adiwidya Center, organisasi dampak sosial resmi kami, kami mendedikasikan tenaga pada 7 pilar: Pengembangan Pemuda, Pertanian & Pangan, UMKM & Kewirausahaan, Digital & Teknologi, Pendidikan Inklusif, Lingkungan Hidup, dan Komunitas Desa.',
                    'Through YOIN Adiwidya Center, our dedicated social-impact organization, we work across Youth Development, Agriculture & Food, MSMEs, Digital Tech, Education, Environment, and Community Development.'
                )">
                    Through YOIN Adiwidya Center, our dedicated social-impact organization, we work across multiple crucial sectors.
                </span>
            </p>
            <p class="text-xs text-gray-500 mt-2 italic">
                <span x-text="$store.lang.t(
                    'YOIN menyajikan narasi tingkat ekosistem, sementara YAC mendokumentasikan metrik dampak, data lapangan, serta laporan audit ESG secara terperinci.',
                    'YOIN presents the ecosystem-level story, while YAC maintains detailed program data, documentation, and ESG impact reports.'
                )">
                    YOIN presents the ecosystem-level story. YAC maintains detailed program documentation and reports.
                </span>
            </p>
        </div>

        {{-- Impact Metric Counters (Blended with EcosystemImpactMetric from DB if available) --}}
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mt-8">
            @if(isset($metrics) && $metrics->count() >= 4)
                @foreach($metrics->take(4) as $m)
                    <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200 text-center">
                        <span class="text-2xl sm:text-3xl font-black text-[#004741] block">{{ $m->metric_value }}</span>
                        <span class="text-xs font-bold text-gray-700 mt-1 block">
                            <span x-text="$store.lang.t('{{ addslashes($m->label_id) }}', '{{ addslashes($m->label_en ?: $m->label_id) }}')">
                                {{ $m->label_id }}
                            </span>
                        </span>
                    </div>
                @endforeach
            @else
                <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200 text-center">
                    <span class="text-2xl sm:text-3xl font-black text-[#004741] block">12+</span>
                    <span class="text-xs font-bold text-gray-700 mt-1 block" x-text="$store.lang.t('Program Pemberdayaan', 'Programs')">Programs</span>
                </div>
                <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200 text-center">
                    <span class="text-2xl sm:text-3xl font-black text-[#004741] block">34+</span>
                    <span class="text-xs font-bold text-gray-700 mt-1 block" x-text="$store.lang.t('Komunitas Dampingan', 'Communities')">Communities</span>
                </div>
                <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200 text-center">
                    <span class="text-2xl sm:text-3xl font-black text-[#004741] block">3,500+</span>
                    <span class="text-xs font-bold text-gray-700 mt-1 block" x-text="$store.lang.t('Penerima Manfaat', 'Participants')">Participants</span>
                </div>
                <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200 text-center">
                    <span class="text-2xl sm:text-3xl font-black text-[#004741] block">18</span>
                    <span class="text-xs font-bold text-gray-700 mt-1 block" x-text="$store.lang.t('Mitra Desa & Komunitas', 'Village & Partners')">Village / Community Partners</span>
                </div>
            @endif
        </div>

        <div class="mt-8 text-left">
            <a 
                href="{{ url('/dampak') }}" 
                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-white hover:bg-gray-50 border border-gray-300 text-gray-900 text-xs font-bold tracking-wider uppercase transition-all shadow-2xs"
            >
                <span x-text="$store.lang.t('Jelajahi Laporan Dampak & ESG', 'Explore Impact & ESG')">Explore Impact & ESG</span>
                <span>→</span>
            </a>
        </div>
    </section>

    {{-- Divider --}}
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <hr class="border-gray-200">
    </div>

    {{-- 10. WHAT WE'RE LOOKING FOR & WHAT INVESTMENT CAN UNLOCK --}}
    <section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 my-16 sm:my-24">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
            {{-- Left: What We're Looking For --}}
            <div class="p-8 sm:p-10 rounded-3xl bg-gray-50 border border-gray-200 flex flex-col justify-between">
                <div>
                    <span class="text-xs font-mono font-bold tracking-widest text-[#005952] uppercase block mb-2" x-text="$store.lang.t('KEMITRAAN INVESTASI', 'STRATEGIC CAPITAL')">
                        KEMITRAAN INVESTASI
                    </span>
                    <h2 class="text-2xl sm:text-3xl font-black text-gray-950 tracking-tight">
                        <span x-text="$store.lang.t('SIAPA YANG KAMI CARI', 'WHAT WE’RE LOOKING FOR')">
                            WHAT WE’RE LOOKING FOR
                        </span>
                    </h2>
                    <p class="text-sm sm:text-base font-bold text-gray-800 mt-2">
                        <span x-text="$store.lang.t('Kami mencari mitra yang melihat lebih jauh dari sekadar satu perusahaan.', 'We’re looking for partners who see beyond one company.')">
                            We’re looking for partners who see beyond one company.
                        </span>
                    </p>
                    <p class="text-xs sm:text-sm text-gray-600 mt-3 leading-relaxed">
                        <span x-text="$store.lang.t(
                            'YOIN membuka dialog bersama penyedia modal strategis dan institusi yang percaya pada potensi jangka panjang pembangunan ventura dari pasar negara berkembang.',
                            'YOIN is looking for strategic capital and partners who believe in building long-term ventures from emerging-market opportunities.'
                        )">
                            YOIN is looking for strategic capital and partners who believe in building long-term ventures from emerging-market opportunities.
                        </span>
                    </p>

                    <div class="mt-6">
                        <span class="text-xs font-bold text-gray-900 uppercase tracking-wider block mb-3" x-text="$store.lang.t('Area Peluang Kemitraan:', 'Potential Partnership Areas:')">
                            Potential Partnership Areas:
                        </span>
                        <div class="grid grid-cols-2 gap-2 text-xs font-bold text-gray-700">
                            <div class="p-2.5 bg-white rounded-xl border border-gray-200 flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#005952]"></span>
                                <span>Venture Capital</span>
                            </div>
                            <div class="p-2.5 bg-white rounded-xl border border-gray-200 flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#005952]"></span>
                                <span>Strategic Investors</span>
                            </div>
                            <div class="p-2.5 bg-white rounded-xl border border-gray-200 flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#005952]"></span>
                                <span>Corporate Partners</span>
                            </div>
                            <div class="p-2.5 bg-white rounded-xl border border-gray-200 flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#005952]"></span>
                                <span>Technology Partners</span>
                            </div>
                            <div class="p-2.5 bg-white rounded-xl border border-gray-200 flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#005952]"></span>
                                <span>International Partners</span>
                            </div>
                            <div class="p-2.5 bg-white rounded-xl border border-gray-200 flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#005952]"></span>
                                <span>Impact Investors</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-6 pt-6 border-t border-gray-200 text-xs text-gray-600 leading-relaxed">
                    <span x-text="$store.lang.t(
                        'Kami sangat mengutamakan mitra yang dapat berkontribusi tidak hanya dalam bentuk modal, melainkan juga akses pasar, keahlian industri, teknologi, jejaring, serta peluang ekspansi regional.',
                        'We are particularly interested in partners who can contribute not only capital, but also market access, expertise, technology, networks, and opportunities for international expansion.'
                    )">
                        We are particularly interested in partners who can contribute not only capital, but also market access, expertise, technology, networks, and opportunities for international expansion.
                    </span>
                </div>
            </div>

            {{-- Right: What Investment Can Unlock --}}
            <div class="p-8 sm:p-10 rounded-3xl bg-[#F0F8F6] border border-teal-200 flex flex-col justify-between">
                <div>
                    <span class="text-xs font-mono font-bold tracking-widest text-[#005952] uppercase block mb-2" x-text="$store.lang.t('PENCIPTAAN NILAI NYATA', 'CAPITAL TO VALUE CREATION')">
                        PENCIPTAAN NILAI NYATA
                    </span>
                    <h2 class="text-2xl sm:text-3xl font-black text-gray-950 tracking-tight">
                        <span x-text="$store.lang.t('APA YANG DIAKSELERASI OLEH INVESTASI', 'WHAT INVESTMENT CAN UNLOCK')">
                            WHAT INVESTMENT CAN UNLOCK
                        </span>
                    </h2>
                    <p class="text-xs sm:text-sm text-teal-900 mt-2 font-medium">
                        <span x-text="$store.lang.t(
                            'Investasi difokuskan sepenuhnya pada akselerasi nilai jangka panjang (value creation), bukan pembakaran biaya operasional tanpa arah.',
                            'Capital is disciplined and oriented strictly toward value creation, scalable tech, and measurable growth.'
                        )">
                            Capital → Value Creation
                        </span>
                    </p>

                    <div class="space-y-2.5 mt-6">
                        <div class="p-3 bg-white rounded-2xl border border-teal-100 flex items-center gap-3">
                            <span class="text-xs font-mono font-black text-[#005952] w-6">01</span>
                            <span class="text-xs sm:text-sm font-bold text-gray-800" x-text="$store.lang.t('Membangun & mengakselerasi ventura-ventura potensial', 'Build & scale promising ventures')">Build & scale promising ventures</span>
                        </div>
                        <div class="p-3 bg-white rounded-2xl border border-teal-100 flex items-center gap-3">
                            <span class="text-xs font-mono font-black text-[#005952] w-6">02</span>
                            <span class="text-xs sm:text-sm font-bold text-gray-800" x-text="$store.lang.t('Mengembangkan teknologi berpemilik & hak paten (IP)', 'Develop proprietary technology & IP')">Develop proprietary technology & IP</span>
                        </div>
                        <div class="p-3 bg-white rounded-2xl border border-teal-100 flex items-center gap-3">
                            <span class="text-xs font-mono font-black text-[#005952] w-6">03</span>
                            <span class="text-xs sm:text-sm font-bold text-gray-800" x-text="$store.lang.t('Memperkuat tim pimpinan ventura & talenta ahli', 'Strengthen venture teams & operational talent')">Strengthen venture teams</span>
                        </div>
                        <div class="p-3 bg-white rounded-2xl border border-teal-100 flex items-center gap-3">
                            <span class="text-xs font-mono font-black text-[#005952] w-6">04</span>
                            <span class="text-xs sm:text-sm font-bold text-gray-800" x-text="$store.lang.t('Memperluas akses pasar & kontrak korporasi enterprise', 'Expand market access & enterprise contracts')">Expand market access</span>
                        </div>
                        <div class="p-3 bg-white rounded-2xl border border-teal-100 flex items-center gap-3">
                            <span class="text-xs font-mono font-black text-[#005952] w-6">05</span>
                            <span class="text-xs sm:text-sm font-bold text-gray-800" x-text="$store.lang.t('Membangun infrastruktur bersama & efisiensi biaya', 'Build shared infrastructure & operational efficiencies')">Build shared infrastructure</span>
                        </div>
                        <div class="p-3 bg-white rounded-2xl border border-teal-100 flex items-center gap-3">
                            <span class="text-xs font-mono font-black text-[#005952] w-6">06</span>
                            <span class="text-xs sm:text-sm font-bold text-gray-800" x-text="$store.lang.t('Mempersiapkan ekspansi ke pasar regional Asia Tenggara', 'Enter regional / international markets')">Enter regional / international markets</span>
                        </div>
                        <div class="p-3 bg-white rounded-2xl border border-teal-100 flex items-center gap-3">
                            <span class="text-xs font-mono font-black text-[#005952] w-6">07</span>
                            <span class="text-xs sm:text-sm font-bold text-gray-800" x-text="$store.lang.t('Melahirkan ventura baru dari masalah tervalidasi berikutnya', 'Develop new ventures from validated opportunities')">Develop new ventures from validated opportunities</span>
                        </div>
                    </div>
                </div>

                <div class="mt-6 pt-4 text-xs font-bold text-[#005952]" x-text="$store.lang.t('Efisiensi Modal Maksimal & Imbal Hasil Berkelanjutan', 'Disciplined Capital Allocation & Sustainable ROI')">
                    Efisiensi Modal Maksimal & Imbal Hasil Berkelanjutan
                </div>
            </div>
        </div>
    </section>

    {{-- Divider --}}
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <hr class="border-gray-200">
    </div>

    {{-- 11. THE LONG-TERM VISION --}}
    <section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 my-16 sm:my-24 text-center">
        <div class="max-w-3xl mx-auto">
            <span class="text-xs font-mono font-bold tracking-widest text-[#005952] uppercase block mb-3" x-text="$store.lang.t('VISI JANGKA PANJANG', 'THE LONG-TERM VISION')">
                VISI JANGKA PANJANG
            </span>
            <h2 class="text-2xl sm:text-4xl lg:text-5xl font-black text-gray-950 tracking-tight leading-tight">
                <span x-text="$store.lang.t('LEMBAGA PEMBANGUN BISNIS BERKELANJUTAN', 'THE LONG-TERM VISION')">
                    THE LONG-TERM VISION
                </span>
            </h2>
            <div class="mt-6 space-y-4 text-base sm:text-lg text-gray-700 leading-relaxed font-medium">
                <p>
                    <span x-text="$store.lang.t('Hari ini, kami membangun ventura-ventura masa depan.', 'Today, we are building ventures.')">Today, we are building ventures.</span><br>
                    <span class="text-gray-950 font-bold" x-text="$store.lang.t('Esok hari, kami ingin membangun institusi terpercaya yang tahu cara membangunnya berulang kali.', 'Tomorrow, we want to build an institution that knows how to build them repeatedly.')">
                        Tomorrow, we want to build an institution that knows how to build them repeatedly.
                    </span>
                </p>
                <p class="text-xs sm:text-base text-gray-600 font-normal">
                    <span x-text="$store.lang.t(
                        'Ambisi YOIN bukan dikenal sebagai pemilik jumlah perusahaan terbanyak. Ambisi kami adalah dikenal karena konsisten membangun perusahaan-perusahaan paling bermakna dari akar masalah sesungguhnya.',
                        'YOIN’s ambition is not to become known for having the most companies. It is to become known for building meaningful companies from the ground up.'
                    )">
                        YOIN’s ambition is not to become known for having the most companies. It is to become known for building meaningful companies from the ground up.
                    </span>
                </p>
                <div class="pt-2 text-lg sm:text-xl font-black text-[#005952]">
                    <span x-text="$store.lang.t('Dari Indonesia. Untuk Indonesia. Dan meluas ke pasar dunia.', 'From Indonesia. For Indonesia. And eventually, for markets beyond it.')">
                        From Indonesia. For Indonesia. And eventually, for markets beyond it.
                    </span>
                </div>
            </div>
        </div>
    </section>

    {{-- Divider --}}
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <hr class="border-gray-200">
    </div>

    {{-- 12. THE YOIN FLYWHEEL --}}
    <section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 my-16 sm:my-24">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <span class="text-xs font-mono font-bold tracking-widest text-[#005952] uppercase block mb-2" x-text="$store.lang.t('RODA PENGGERAK PERTUMBUHAN', 'RECURSIVE VENTURE FLYWHEEL')">
                RODA PENGGERAK PERTUMBUHAN
            </span>
            <h2 class="text-2xl sm:text-4xl font-black text-gray-950 tracking-tight">
                <span x-text="$store.lang.t('FLYWHEEL EKOSISTEM YOIN', 'THE YOIN FLYWHEEL')">
                    THE YOIN FLYWHEEL
                </span>
            </h2>
            <p class="text-xs sm:text-sm text-gray-600 mt-2 font-medium">
                <span x-text="$store.lang.t(
                    'Setiap ventura memberi kami pelajaran baru. Dan setiap pelajaran menyempurnakan ventura berikutnya.',
                    'Every venture teaches us something. Every lesson improves the next one.'
                )">
                    Every venture teaches us something. Every lesson improves the next one.
                </span>
            </p>
        </div>

        {{-- Flywheel Interactive Graphic Layout --}}
        <div class="p-8 sm:p-12 rounded-3xl bg-[#F8FAFA] border border-gray-200 relative overflow-hidden">
            {{-- Orbit Steps Flex/Grid Representation --}}
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3 max-w-4xl mx-auto relative z-10">
                <div class="p-4 rounded-2xl bg-white border border-gray-200 text-center shadow-2xs">
                    <span class="text-[10px] font-mono font-bold text-gray-400 block">01</span>
                    <span class="text-xs sm:text-sm font-black text-gray-900 mt-0.5 block" x-text="$store.lang.t('PROBLEMS (Masalah)', 'PROBLEMS')">PROBLEMS</span>
                    <span class="text-[10px] text-gray-500 mt-1 block" x-text="$store.lang.t('Kebutuhan nyata', 'Real pain points')">Real pain points</span>
                </div>
                <div class="p-4 rounded-2xl bg-white border border-gray-200 text-center shadow-2xs">
                    <span class="text-[10px] font-mono font-bold text-gray-400 block">02</span>
                    <span class="text-xs sm:text-sm font-black text-gray-900 mt-0.5 block" x-text="$store.lang.t('DISCOVERY (Riset)', 'DISCOVERY')">DISCOVERY</span>
                    <span class="text-[10px] text-gray-500 mt-1 block" x-text="$store.lang.t('Validasi akar masalah', 'Ground observation')">Ground observation</span>
                </div>
                <div class="p-4 rounded-2xl bg-white border border-gray-200 text-center shadow-2xs">
                    <span class="text-[10px] font-mono font-bold text-gray-400 block">03</span>
                    <span class="text-xs sm:text-sm font-black text-gray-900 mt-0.5 block" x-text="$store.lang.t('PEOPLE (Talenta)', 'PEOPLE')">PEOPLE</span>
                    <span class="text-[10px] text-gray-500 mt-1 block" x-text="$store.lang.t('Menyiapkan tim inti', 'Dedicated builders')">Dedicated builders</span>
                </div>
                <div class="p-4 rounded-2xl bg-white border border-gray-200 text-center shadow-2xs">
                    <span class="text-[10px] font-mono font-bold text-gray-400 block">04</span>
                    <span class="text-xs sm:text-sm font-black text-gray-900 mt-0.5 block" x-text="$store.lang.t('PRODUCTS (Solusi)', 'PRODUCTS')">PRODUCTS</span>
                    <span class="text-[10px] text-gray-500 mt-1 block" x-text="$store.lang.t('Rekayasa fungsional', 'Working software & tech')">Working software & tech</span>
                </div>
                <div class="p-4 rounded-2xl bg-white border border-gray-200 text-center shadow-2xs">
                    <span class="text-[10px] font-mono font-bold text-gray-400 block">05</span>
                    <span class="text-xs sm:text-sm font-black text-gray-900 mt-0.5 block" x-text="$store.lang.t('VENTURES (Unit Bisnis)', 'VENTURES')">VENTURES</span>
                    <span class="text-[10px] text-gray-500 mt-1 block" x-text="$store.lang.t('Entitas mandiri', 'Standalone company')">Standalone company</span>
                </div>
                <div class="p-4 rounded-2xl bg-white border border-gray-200 text-center shadow-2xs">
                    <span class="text-[10px] font-mono font-bold text-gray-400 block">06</span>
                    <span class="text-xs sm:text-sm font-black text-gray-900 mt-0.5 block" x-text="$store.lang.t('TRACTION (Traksi)', 'TRACTION')">TRACTION</span>
                    <span class="text-[10px] text-gray-500 mt-1 block" x-text="$store.lang.t('Pengguna & omset nyata', 'Revenue & retention')">Revenue & retention</span>
                </div>
                <div class="p-4 rounded-2xl bg-white border border-gray-200 text-center shadow-2xs">
                    <span class="text-[10px] font-mono font-bold text-gray-400 block">07</span>
                    <span class="text-xs sm:text-sm font-black text-gray-900 mt-0.5 block" x-text="$store.lang.t('CAPITAL (Modal)', 'CAPITAL')">CAPITAL</span>
                    <span class="text-[10px] text-gray-500 mt-1 block" x-text="$store.lang.t('Investasi terarah', 'Growth investment')">Growth investment</span>
                </div>
                <div class="p-4 rounded-2xl bg-white border border-gray-200 text-center shadow-2xs">
                    <span class="text-[10px] font-mono font-bold text-gray-400 block">08</span>
                    <span class="text-xs sm:text-sm font-black text-gray-900 mt-0.5 block" x-text="$store.lang.t('SCALE (Skala Pasar)', 'SCALE')">SCALE</span>
                    <span class="text-[10px] text-gray-500 mt-1 block" x-text="$store.lang.t('Ekspansi penetrasi', 'Market expansion')">Market expansion</span>
                </div>
                <div class="p-4 rounded-2xl bg-white border border-gray-200 text-center shadow-2xs">
                    <span class="text-[10px] font-mono font-bold text-gray-400 block">09</span>
                    <span class="text-xs sm:text-sm font-black text-gray-900 mt-0.5 block" x-text="$store.lang.t('NEW OPPORTUNITIES', 'NEW OPPORTUNITIES')">OPPORTUNITIES</span>
                    <span class="text-[10px] text-gray-500 mt-1 block" x-text="$store.lang.t('Peluang turunan', 'Adjacent markets')">Adjacent markets</span>
                </div>
                <div class="p-4 rounded-2xl bg-slate-100 border border-slate-200 text-center shadow-2xs">
                    <span class="text-[10px] font-mono font-bold text-[#004741] block">CYCLE LOOP</span>
                    <span class="text-xs sm:text-sm font-black text-[#004741] mt-0.5 block" x-text="$store.lang.t('KEMBALI KE RISET', 'BACK TO DISCOVERY')">DISCOVERY</span>
                    <span class="text-[10px] text-slate-600 mt-1 block" x-text="$store.lang.t('Siklus berkesinambungan', 'Recursive learning')">Recursive loop</span>
                </div>
            </div>

            {{-- Flywheel Center Core --}}
            <div class="mt-8 text-center">
                <div class="inline-flex flex-col items-center justify-center px-8 py-5 rounded-3xl bg-[#004741] text-white shadow-lg">
                    <span class="text-[11px] font-mono font-bold tracking-widest text-white uppercase">ECOSYSTEM CORE</span>
                    <span class="text-2xl sm:text-3xl font-black mt-1">YOIN</span>
                    <span class="text-xs text-slate-100/90 mt-1 max-w-sm" x-text="$store.lang.t(
                        'Platform orkestrasi, fondasi bersama, dan akselerator ventura mandiri berdaulat.',
                        'Orchestration platform, shared foundation, and sovereign venture accelerator.'
                    )">
                        Platform orkestrasi, fondasi bersama, dan akselerator ventura mandiri.
                    </span>
                </div>
            </div>
        </div>
    </section>

    {{-- Divider --}}
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <hr class="border-gray-200">
    </div>

    {{-- 13. INVESTOR RESOURCES (GATEWAY) --}}
    <section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 my-16 sm:my-24">
        <div class="text-left max-w-3xl">
            <span class="text-xs font-mono font-bold tracking-widest text-[#004741] uppercase block mb-2" x-text="$store.lang.t('GERBANG DOKUMEN & INFORMASI', 'INSTITUTIONAL GATEWAY')">
                GERBANG DOKUMEN & INFORMASI
            </span>
            <h2 class="text-2xl sm:text-4xl font-black text-gray-950 tracking-tight">
                <span x-text="$store.lang.t('SUMBER DAYA INVESTOR RESMI', 'INVESTOR RESOURCES')">
                    INVESTOR RESOURCES
                </span>
            </h2>
            <p class="text-xs sm:text-sm text-gray-600 mt-2 font-medium">
                <span x-text="$store.lang.t(
                    'Pusat materi resmi, keterbukaan laporan kinerja, dan dokumen tata kelola untuk calon mitra strategis dan penyedia modal ventura.',
                    'Comprehensive institutional materials, financial summaries, and governance reports for qualified investment partners.'
                )">
                    Pusat materi, keterbukaan laporan, dan dokumen tata kelola untuk calon mitra strategis dan penyedia modal.
                </span>
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4 mt-8">
            {{-- Card 1: Investor Deck --}}
            <div class="p-6 rounded-3xl bg-white border border-gray-200 flex flex-col justify-between hover:border-slate-400 transition-all">
                <div>
                    <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-800 flex items-center justify-center mb-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <h4 class="font-black text-gray-900 text-sm mb-2">Investor Deck</h4>
                    <p class="text-xs text-gray-600 leading-relaxed font-normal">
                        <span x-text="$store.lang.t(
                            'Paparan komprehensif mengenai ekosistem YOIN, strategi portofolio, metrik traksi, dan peluang investasi.',
                            'Overview of YOIN, ecosystem, ventures, traction, strategy, and investment opportunity.'
                        )">
                            Overview of YOIN, ecosystem, ventures, traction, strategy, and investment opportunity.
                        </span>
                    </p>
                </div>
                <div class="mt-6 pt-4 border-t border-gray-100">
                    <button 
                        type="button" 
                        @click="deckModalOpen = true"
                        class="text-xs font-bold text-[#005952] hover:underline flex items-center gap-1 cursor-pointer"
                    >
                        <span x-text="$store.lang.t('Unduh / Minta Deck', 'Download / Request Deck')">Download / Request Deck</span>
                        <span>→</span>
                    </button>
                </div>
            </div>

            {{-- Card 2: Company Profile --}}
            <div class="p-6 rounded-3xl bg-white border border-gray-200 flex flex-col justify-between hover:border-slate-400 transition-all">
                <div>
                    <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-800 flex items-center justify-center mb-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    </div>
                    <h4 class="font-black text-gray-900 text-sm mb-2">Company Profile</h4>
                    <p class="text-xs text-gray-600 leading-relaxed font-normal">
                        <span x-text="$store.lang.t(
                            'Profil korporasi resmi dan ringkasan struktur kelembagaan PT Yota Inovasi Nusantara.',
                            'Corporate profile and organizational overview of PT Yota Inovasi Nusantara.'
                        )">
                            Corporate profile and organizational overview of YOIN.
                        </span>
                    </p>
                </div>
                <div class="mt-6 pt-4 border-t border-gray-100">
                    <a 
                        href="{{ route('public.about.profile') }}" 
                        class="text-xs font-bold text-[#004741] hover:underline flex items-center gap-1"
                    >
                        <span x-text="$store.lang.t('Lihat Profil', 'View Profile')">View Profile</span>
                        <span>→</span>
                    </a>
                </div>
            </div>

            {{-- Card 3: Impact & ESG Report --}}
            <div class="p-6 rounded-3xl bg-white border border-gray-200 flex flex-col justify-between hover:border-slate-400 transition-all">
                <div>
                    <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-800 flex items-center justify-center mb-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    </div>
                    <h4 class="font-black text-gray-900 text-sm mb-2">Impact & ESG Report</h4>
                    <p class="text-xs text-gray-600 leading-relaxed font-normal">
                        <span x-text="$store.lang.t(
                            'Dokumentasi program, metrik kemanusiaan, dan inisiatif konservasi melalui YOIN Adiwidya Center.',
                            'Programs, impact metrics, and community initiatives through YOIN Adiwidya Center.'
                        )">
                            Programs, impact metrics, and community initiatives through YOIN Adiwidya Center.
                        </span>
                    </p>
                </div>
                <div class="mt-6 pt-4 border-t border-gray-100">
                    <a 
                        href="{{ url('/dampak') }}" 
                        class="text-xs font-bold text-[#004741] hover:underline flex items-center gap-1"
                    >
                        <span x-text="$store.lang.t('Buka Laporan', 'View Report')">View Report</span>
                        <span>→</span>
                    </a>
                </div>
            </div>

            {{-- Card 4: Financial Summary --}}
            <div class="p-6 rounded-3xl bg-white border border-gray-200 flex flex-col justify-between hover:border-slate-400 transition-all">
                <div>
                    <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-800 flex items-center justify-center mb-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h4 class="font-black text-gray-900 text-sm mb-2">Financial / Performance</h4>
                    <p class="text-xs text-gray-600 leading-relaxed font-normal">
                        <span x-text="$store.lang.t(
                            'Ringkasan indikator kinerja bisnis dan metrik operasional untuk evaluasi mitra institusi.',
                            'Selected business and performance indicators for qualified evaluation.'
                        )">
                            Selected business and performance indicators for qualified evaluation.
                        </span>
                    </p>
                </div>
                <div class="mt-6 pt-4 border-t border-gray-100">
                    <button 
                        type="button" 
                        @click="dataroomModalOpen = true"
                        class="text-xs font-bold text-[#004741] hover:underline flex items-center gap-1 cursor-pointer"
                    >
                        <span x-text="$store.lang.t('Minta Akses Ringkasan', 'Request Access')">Request Access</span>
                        <span>→</span>
                    </button>
                </div>
            </div>

            {{-- Card 5: Data Room --}}
            <div class="p-6 rounded-3xl bg-white border border-gray-200 flex flex-col justify-between hover:border-slate-400 transition-all">
                <div>
                    <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-800 flex items-center justify-center mb-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"/></svg>
                    </div>
                    <h4 class="font-black text-gray-900 text-sm mb-2">Virtual Data Room</h4>
                    <p class="text-xs text-gray-600 leading-relaxed font-normal">
                        <span x-text="$store.lang.t(
                            'Bilik dokumen komprehensif terlindungi (due diligence) untuk investor dan mitra strategis terdaftar.',
                            'Comprehensive diligence materials and governance files available for verified investors.'
                        )">
                            Detailed materials and institutional documents available for qualified partners.
                        </span>
                    </p>
                </div>
                <div class="mt-6 pt-4 border-t border-gray-100">
                    <button 
                        type="button" 
                        @click="dataroomModalOpen = true"
                        class="text-xs font-bold text-[#004741] hover:underline flex items-center gap-1 cursor-pointer"
                    >
                        <span x-text="$store.lang.t('Akses Data Room', 'Request Access')">Request Access</span>
                        <span>→</span>
                    </button>
                </div>
            </div>
        </div>
    </section>

    {{-- 14. EDITORIAL MANIFESTO FROM DATABASE (TEKS EDITOR INVEST) --}}
    @if(!empty($profile->invest_content_html))
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <hr class="border-gray-200">
        </div>

        <section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 my-16 sm:my-20">
            <div class="flex items-center gap-2 mb-6">
                <span class="w-2 h-2 rounded-full bg-[#005952]"></span>
                <span class="text-xs font-mono font-bold tracking-widest text-gray-400 uppercase" x-text="$store.lang.t('CATATAN & DETAIL MANIFESTO INVESTASI (EDITORIAL)', 'INVESTMENT MANIFESTO EDITORIAL NOTES')">
                    CATATAN & DETAIL MANIFESTO INVESTASI (EDITORIAL)
                </span>
            </div>

            <div class="prose prose-teal max-w-none text-gray-800 leading-relaxed text-sm sm:text-base">
                {!! $profile->invest_content_html !!}
            </div>
        </section>
    @endif

    {{-- Divider --}}
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <hr class="border-gray-200">
    </div>

    {{-- 15. FINAL CTA --}}
    <section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 my-16 sm:my-24">
        <div class="p-8 sm:p-14 rounded-3xl bg-gradient-to-br from-[#005952] to-[#012e2a] text-white text-left shadow-xl">
            <div class="max-w-3xl">
                <span class="text-xs font-mono font-bold tracking-widest text-teal-200 uppercase block mb-3" x-text="$store.lang.t('BERSAMA MEMBANGUN MASA DEPAN', 'BUILDING THE FUTURE TOGETHER')">
                    BERSAMA MEMBANGUN MASA DEPAN
                </span>
                
                <h2 class="text-2xl sm:text-4xl font-black tracking-tight mb-4">
                    <span x-text="$store.lang.t('Kami Masih dan Terus Membangun.', 'We are still building.')">
                        We are still building.
                    </span>
                </h2>

                <div class="space-y-3 text-xs sm:text-sm sm:leading-relaxed text-teal-100/90 font-normal">
                    <p x-text="$store.lang.t('YOIN dimulai dari langkah kecil. Kami terus belajar. Kami terus menguji dan memvalidasi.', 'YOIN started small. We are still learning. We are still testing.')">
                        YOIN started small. We are still learning. We are still testing.
                    </p>
                    <p x-text="$store.lang.t('Sebagian ide akan berhasil secara gemilang. Sebagian lainnya mungkin tidak.', 'Some ideas will work. Some won’t.')">
                        Some ideas will work. Some won’t.
                    </p>
                    <p x-text="$store.lang.t('Namun setiap eksperimen memberi kami pemahaman yang jauh lebih jernih tentang apa yang layak dan wajib dibangun berikutnya.', 'But every experiment gives us a better understanding of what should be built next.')">
                        But every experiment gives us a better understanding of what should be built next.
                    </p>
                    <p class="text-base sm:text-lg font-bold text-white pt-2" x-text="$store.lang.t('Kami mencari mitra dan insan yang ingin membangun masa depan itu bersama kami.', 'We’re looking for people who want to build that future with us.')">
                        We’re looking for people who want to build that future with us.
                    </p>
                </div>

                <div class="mt-8 flex flex-wrap items-center gap-4">
                    <button 
                        type="button" 
                        @click="deckModalOpen = true"
                        class="px-6 py-3.5 rounded-full bg-white hover:bg-slate-200 text-slate-950 text-xs font-bold tracking-wider uppercase transition-all shadow-md cursor-pointer"
                    >
                        <span x-text="$store.lang.t('Minta Investor Deck', 'Request Investor Deck')">Request Investor Deck</span>
                    </button>

                    <a 
                        href="https://wa.me/6285862319524?text=Halo%20Tim%20YOIN%2C%20saya%20tertarik%20berdialog%20mengenai%20peluang%20investasi%20dan%20kemitraan%20ekosistem." 
                        target="_blank"
                        rel="noopener"
                        class="px-6 py-3.5 rounded-full bg-[#004741] hover:bg-black text-white text-xs font-bold tracking-wider uppercase transition-all border border-white/20 cursor-pointer"
                    >
                        <span x-text="$store.lang.t('Berdialog dengan YOIN', 'Talk to YOIN')">Talk to YOIN</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- MODAL 1: REQUEST INVESTOR DECK --}}
    <div 
        x-show="deckModalOpen"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 overflow-y-auto bg-black/60 backdrop-blur-xs flex items-center justify-center p-4"
        style="display: none;"
    >
        <div 
            @click.away="deckModalOpen = false"
            class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 text-left shadow-2xl relative"
        >
            <div class="flex items-center justify-between mb-4">
                <div>
                    <span class="text-[10px] font-mono font-bold tracking-widest text-[#005952] uppercase" x-text="$store.lang.t('GERBANG INVESTOR INSTITUSI', 'INSTITUTIONAL GATEWAY')">INSTITUTIONAL GATEWAY</span>
                    <h3 class="text-xl font-black text-gray-900 mt-0.5" x-text="$store.lang.t('Permohonan Investor Pitch Deck', 'Request Investor Pitch Deck')">Request Investor Deck</h3>
                </div>
                <button 
                    type="button" 
                    @click="deckModalOpen = false"
                    class="p-2 rounded-full hover:bg-gray-100 text-gray-400 hover:text-gray-700"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <p class="text-xs text-gray-600 mb-5 leading-relaxed" x-text="$store.lang.t(
                'Silakan lengkapi data kontak Anda untuk menerima lembar paparan resmi YOIN Inovasi Nusantara mengenai portofolio, metrik traksi, dan peluang kemitraan.',
                'Please provide your details to receive the official YOIN Inovasi Nusantara Pitch Deck covering ecosystem thesis, ventures, and investment opportunity.'
            )">
                Silakan lengkapi identitas untuk menerima lembar paparan resmi YOIN Inovasi Nusantara mengenai portofolio, metrik traksi, dan peluang kemitraan.
            </p>

            <form @submit.prevent="submitDeckRequest()" class="space-y-3">
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1" x-text="$store.lang.t('Nama Lengkap *', 'Full Name *')">Nama Lengkap *</label>
                    <input 
                        type="text" 
                        x-model="deckForm.name" 
                        required 
                        placeholder="Contoh: Adrian Pratama" 
                        class="w-full px-3.5 py-2.5 rounded-xl border border-gray-300 text-xs focus:ring-2 focus:ring-[#005952] focus:border-transparent outline-hidden"
                    >
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1" x-text="$store.lang.t('Institusi / Entitas Perusahaan *', 'Company / Institution *')">Institusi / Perusahaan / Entity *</label>
                    <input 
                        type="text" 
                        x-model="deckForm.organization" 
                        required 
                        placeholder="Contoh: Nusantara Capital / PT Mitra Mandiri" 
                        class="w-full px-3.5 py-2.5 rounded-xl border border-gray-300 text-xs focus:ring-2 focus:ring-[#005952] focus:border-transparent outline-hidden"
                    >
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1" x-text="$store.lang.t('Email Profesional *', 'Professional Email *')">Email Profesional *</label>
                    <input 
                        type="email" 
                        x-model="deckForm.email" 
                        required 
                        placeholder="adrian@investment.com" 
                        class="w-full px-3.5 py-2.5 rounded-xl border border-gray-300 text-xs focus:ring-2 focus:ring-[#005952] focus:border-transparent outline-hidden"
                    >
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1" x-text="$store.lang.t('Kategori Profil Mitra', 'Partnership Category')">Kategori Kemitraan</label>
                    <select 
                        x-model="deckForm.role" 
                        class="w-full px-3.5 py-2.5 rounded-xl border border-gray-300 text-xs focus:ring-2 focus:ring-[#005952] focus:border-transparent outline-hidden bg-white"
                    >
                        <option value="Venture Capital">Venture Capital / Investment Fund</option>
                        <option value="Angel / Strategic Investor">Angel / Strategic Investor</option>
                        <option value="Corporate Partner">Corporate Partner / Enterprise</option>
                        <option value="Technology / University Partner">Technology / University Partner</option>
                        <option value="Impact / ESG Investor">Impact / ESG Investor</option>
                    </select>
                </div>

                <div class="pt-4 flex items-center justify-end gap-3">
                    <button 
                        type="button" 
                        @click="deckModalOpen = false" 
                        class="px-4 py-2 rounded-xl text-xs font-bold text-gray-600 hover:bg-gray-100"
                        x-text="$store.lang.t('Batal', 'Cancel')"
                    >
                        Batal
                    </button>
                    <button 
                        type="submit" 
                        class="px-5 py-2.5 rounded-xl bg-[#005952] hover:bg-[#004741] text-white text-xs font-bold tracking-wider uppercase transition-all shadow-xs"
                        x-text="$store.lang.t('Kirim Permohonan Deck', 'Request Pitch Deck')"
                    >
                        Kirim Permohonan Deck
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL 2: REQUEST DATA ROOM ACCESS --}}
    <div 
        x-show="dataroomModalOpen"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 overflow-y-auto bg-black/60 backdrop-blur-xs flex items-center justify-center p-4"
        style="display: none;"
    >
        <div 
            @click.away="dataroomModalOpen = false"
            class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 text-left shadow-2xl relative"
        >
            <div class="flex items-center justify-between mb-4">
                <div>
                    <span class="text-[10px] font-mono font-bold tracking-widest text-[#005952] uppercase">CONFIDENTIAL DATA ROOM</span>
                    <h3 class="text-xl font-black text-gray-900 mt-0.5" x-text="$store.lang.t('Permohonan Akses YOIN Data Room', 'Request Data Room Access')">Request Data Room Access</h3>
                </div>
                <button 
                    type="button" 
                    @click="dataroomModalOpen = false"
                    class="p-2 rounded-full hover:bg-gray-100 text-gray-400 hover:text-gray-700"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <p class="text-xs text-gray-600 mb-5 leading-relaxed" x-text="$store.lang.t(
                'Akses YOIN Virtual Data Room disediakan terbatas untuk mitra institusi dan investor terverifikasi. Tim kami akan mengonfirmasi identitas Anda sebelum membagikan dokumen keuangan dan kinerja.',
                'Access to YOIN Virtual Data Room is provided to qualified investors and partners. Our team will verify your credentials prior to granting diligence access.'
            )">
                Akses YOIN Data Room disediakan terbatas untuk mitra institusi terverifikasi. Tim kami akan mengonfirmasi identitas Anda sebelum membuka dokumen performa dan keuangan.
            </p>

            <form @submit.prevent="submitDataRoomRequest()" class="space-y-3">
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1" x-text="$store.lang.t('Nama Lengkap & Jabatan *', 'Full Name & Title *')">Nama Lengkap & Jabatan *</label>
                    <input 
                        type="text" 
                        x-model="dataroomForm.name" 
                        required 
                        placeholder="Contoh: Hendra Wijaya (Managing Partner)" 
                        class="w-full px-3.5 py-2.5 rounded-xl border border-gray-300 text-xs focus:ring-2 focus:ring-[#005952] focus:border-transparent outline-hidden"
                    >
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1" x-text="$store.lang.t('Nama Institusi / Fund *', 'Institution / Fund Name *')">Nama Institusi / Fund *</label>
                    <input 
                        type="text" 
                        x-model="dataroomForm.institution" 
                        required 
                        placeholder="Nama Fund / Perusahaan" 
                        class="w-full px-3.5 py-2.5 rounded-xl border border-gray-300 text-xs focus:ring-2 focus:ring-[#005952] focus:border-transparent outline-hidden"
                    >
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1" x-text="$store.lang.t('Email Resmi Institusi *', 'Official Email *')">Email Resmi Institusi *</label>
                    <input 
                        type="email" 
                        x-model="dataroomForm.email" 
                        required 
                        placeholder="hendra@fund.com" 
                        class="w-full px-3.5 py-2.5 rounded-xl border border-gray-300 text-xs focus:ring-2 focus:ring-[#005952] focus:border-transparent outline-hidden"
                    >
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1" x-text="$store.lang.t('Fokus Minat & Cakupan Diskusi', 'Area of Focus / Intent')">Fokus Minat & Cakupan Diskusi</label>
                    <textarea 
                        x-model="dataroomForm.intent" 
                        rows="2" 
                        placeholder="Misal: Evaluasi unit Agronex / eksplorasi sinergi ventura digital..." 
                        class="w-full px-3.5 py-2 rounded-xl border border-gray-300 text-xs focus:ring-2 focus:ring-[#005952] focus:border-transparent outline-hidden"
                    ></textarea>
                </div>

                <div class="pt-4 flex items-center justify-end gap-3">
                    <button 
                        type="button" 
                        @click="dataroomModalOpen = false" 
                        class="px-4 py-2 rounded-xl text-xs font-bold text-gray-600 hover:bg-gray-100"
                        x-text="$store.lang.t('Batal', 'Cancel')"
                    >
                        Batal
                    </button>
                    <button 
                        type="submit" 
                        class="px-5 py-2.5 rounded-xl bg-[#005952] hover:bg-[#004741] text-white text-xs font-bold tracking-wider uppercase transition-all shadow-xs"
                        x-text="$store.lang.t('Ajukan Akses Data Room', 'Request Data Room Access')"
                    >
                        Ajukan Akses Data Room
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
