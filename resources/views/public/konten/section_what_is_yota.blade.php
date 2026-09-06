{{-- 
    YOIN Ecosystem Planetary Orbit Explorer - Database-Driven & Responsive
    "HARUS SAMA PERCIS KETERANGAN DLL NYA"
    "MAKSUDNYA DOMAIN YAUDAH DOMAIN TAMPILKAN YANG LAIN YANG NGGA ADA GAK USAH"
    "pas di klik muncul brand brand"
    Aturan: Bebas Emotikon, Tanpa Kata Venture, Layar Penuh Edge-to-Edge.
--}}
@php
    $domainsSource = (isset($ecosystemDomains) && $ecosystemDomains->isNotEmpty())
        ? $ecosystemDomains
        : \App\Models\EcosystemDomain::with(['initiatives' => function ($q) {
            $q->where('visibility', 'public')->orderBy('sort_order');
        }])->where('visibility', 'public')->orderBy('sort_order')->get();

    $domainIconMap = [
        'digital' => 'M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z',
        'agriculture' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253',
        'impact' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z',
        'products' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4',
        'emerging' => 'M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z',
    ];

    $mappedDomains = $domainsSource->map(function ($dom, $index) use ($domainIconMap) {
        $key = $dom->slug;
        $icon = $domainIconMap[$key] ?? 'M13 10V3L4 14h7v7l9-11h-7z';

        $brands = $dom->initiatives->map(function ($init) {
            return [
                'name' => $init->name,
                'tag' => [
                    'id' => $init->stage ?: 'Brand Ekosistem',
                    'en' => $init->stage ?: 'Ecosystem Brand',
                ],
                'desc' => [
                    'id' => str_ireplace('YOTA', 'YOIN', $init->tagline_id ?: $init->problem_statement_id),
                    'en' => str_ireplace('YOTA', 'YOIN', $init->tagline_en ?: $init->problem_statement_en),
                ],
                'url' => route('public.ecosystem.initiative', $init->slug),
            ];
        })->values()->toArray();

        if (empty($brands)) {
            $brands = [
                [
                    'name' => 'Tahap Riset & Eksplorasi',
                    'tag' => ['id' => 'Frontier Lab', 'en' => 'Frontier Lab'],
                    'desc' => [
                        'id' => 'Laboratorium riset dan sandbox inovasi masa depan yang sedang dalam tahap pengujian awal.',
                        'en' => 'Frontier research laboratory and innovation sandbox currently in early feasibility testing.'
                    ],
                    'url' => route('public.ecosystem.domain', $dom->slug),
                ]
            ];
        }

        $orderNum = $dom->sort_order ?: ($index + 1);

        return [
            'key' => $key,
            'num' => str_pad($orderNum, 2, '0', STR_PAD_LEFT),
            'order_badge' => 'URUTAN #' . $orderNum,
            'status' => strtoupper($dom->status ?: 'OPERATING'),
            'name_id' => $dom->name_id,
            'name_en' => $dom->name_en,
            // SAMA PERCIS DENGAN ADMIN:
            'tagline_id' => str_ireplace('YOTA', 'YOIN', $dom->tagline_id ?: $dom->short_description_id),
            'tagline_en' => str_ireplace('YOTA', 'YOIN', $dom->tagline_en ?: $dom->short_description_en),
            'problem_id' => str_ireplace('YOTA', 'YOIN', $dom->problem_statement_id),
            'problem_en' => str_ireplace('YOTA', 'YOIN', $dom->problem_statement_en),
            'solution_id' => str_ireplace('YOTA', 'YOIN', $dom->solution_statement_id),
            'solution_en' => str_ireplace('YOTA', 'YOIN', $dom->solution_statement_en),
            'initiatives_count' => $dom->initiatives->count(),
            'initiatives_label' => $dom->initiatives->count() . ' Inisiatif',
            'domainUrl' => route('public.ecosystem.domain', $dom->slug),
            'iconSvg' => $icon,
            'brands' => $brands,
        ];
    })->values()->toArray();
@endphp

<style>
    @keyframes yoinOrbitRotateClockwise {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    @keyframes yoinOrbitCounterRotate {
        from { transform: rotate(0deg); }
        to { transform: rotate(-360deg); }
    }
    @keyframes yoinCoreGlowPulse {
        0%, 100% { transform: scale(1); box-shadow: 0 0 45px -4px rgba(0, 208, 183, 0.45); }
        50% { transform: scale(1.04); box-shadow: 0 0 70px 0px rgba(0, 208, 183, 0.65); }
    }
    @keyframes yoinHaloExpand {
        0%, 100% { transform: scale(1); opacity: 0.22; }
        50% { transform: scale(1.2); opacity: 0.07; }
    }
    @keyframes yoinConstellationDash {
        from { stroke-dashoffset: 24; }
        to { stroke-dashoffset: 0; }
    }
    
    .orbit-rotation-slow {
        animation: yoinOrbitRotateClockwise 85s linear infinite;
    }
    .orbit-rotation-medium {
        animation: yoinOrbitRotateClockwise 60s linear infinite;
    }
    .orbit-counter-slow {
        animation: yoinOrbitCounterRotate 85s linear infinite;
    }
    .orbit-counter-medium {
        animation: yoinOrbitCounterRotate 60s linear infinite;
    }
    .orbit-paused {
        animation-play-state: paused !important;
    }
    .anim-core-glow {
        animation: yoinCoreGlowPulse 4s ease-in-out infinite;
    }
    .anim-halo {
        animation: yoinHaloExpand 4s ease-in-out infinite;
    }
    .anim-circuit-line {
        stroke-dasharray: 5 5;
        animation: yoinConstellationDash 1.8s linear infinite;
    }
</style>

<section 
    id="what-is-yoin"
    x-data="{
        currentLevel: 'main', // 'main' or 'subdomain'
        selectedIndex: 0,
        selectedDomainKey: '{{ $mappedDomains[0]['key'] ?? 'digital' }}',
        isOrbitRotating: true,
        hoveredNode: null,
        activeDetailNode: null,

        // Real Ecosystem Domains from Database
        mainDomains: @js($mappedDomains),

        get currentDomain() {
            return this.mainDomains.find(d => d.key === this.selectedDomainKey) || this.mainDomains[0] || { brands: [] };
        },

        selectDomainIndex(index) {
            if (!this.mainDomains.length) return;
            this.selectedIndex = (index + this.mainDomains.length) % this.mainDomains.length;
            this.selectedDomainKey = this.mainDomains[this.selectedIndex].key;
        },

        enterDomain(key) {
            this.selectedDomainKey = key;
            this.selectedIndex = this.mainDomains.findIndex(d => d.key === key);
            this.currentLevel = 'subdomain';
            this.activeDetailNode = this.currentDomain.brands?.[0] || null;
            this.isOrbitRotating = false;
        },

        backToMain() {
            this.currentLevel = 'main';
            this.activeDetailNode = null;
            this.isOrbitRotating = true;
        }
    }"
    @mouseenter="isOrbitRotating = false"
    @mouseleave="isOrbitRotating = true"
    class="relative w-full min-h-screen flex flex-col justify-between select-none overflow-hidden bg-[#FBFDFD] border-t border-gray-150 py-12 lg:py-16"
>
    
    {{-- ======================================================== --}}
    {{-- FULL-SCREEN BACKGROUND CONSTELLATION & ORBIT RINGS        --}}
    {{-- ======================================================== --}}
    <div class="absolute inset-0 pointer-events-none opacity-40 overflow-hidden">
        <svg class="w-full h-full" viewBox="0 0 1440 900" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
            <defs>
                <pattern id="yoinOrbitGridFull" width="60" height="60" patternUnits="userSpaceOnUse">
                    <circle cx="30" cy="30" r="1" fill="#005952" opacity="0.18" />
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#yoinOrbitGridFull)" />
            <path d="M -100 180 C 400 80, 900 220, 1600 100" stroke="#005952" stroke-opacity="0.08" stroke-width="1.5" stroke-dasharray="6 6" />
            <path d="M -50 780 C 450 680, 1050 820, 1600 700" stroke="#005952" stroke-opacity="0.08" stroke-width="1.5" stroke-dasharray="6 6" />
        </svg>
    </div>

    {{-- Concentric Orbit Rings in background --}}
    <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
        <div class="w-[280px] sm:w-[380px] lg:w-[460px] h-[280px] sm:h-[380px] lg:h-[460px] rounded-full border border-teal-500/20 border-dashed"></div>
        <div class="w-[480px] sm:w-[620px] lg:w-[740px] h-[480px] sm:h-[620px] lg:h-[740px] rounded-full border border-teal-600/15"></div>
        <div class="w-[680px] sm:w-[860px] lg:w-[1040px] h-[680px] sm:h-[860px] lg:h-[1040px] rounded-full border border-teal-700/10 border-dashed"></div>
    </div>

    {{-- ======================================================== --}}
    {{-- TOP BAR: SECTION HEADER & LEVEL CONTROLS                  --}}
    {{-- ======================================================== --}}
    <div class="relative z-30 w-full px-6 sm:px-12 lg:px-16 flex flex-col md:flex-row md:items-start md:justify-between gap-4">
        {{-- Section Title --}}
        <div class="max-w-md text-left pointer-events-auto">
            <div class="flex items-center gap-2.5 mb-2">
                <span class="w-6 sm:w-7 h-[2px] bg-[#005952]"></span>
                <span 
                    class="text-[10px] sm:text-xs font-bold tracking-[0.26em] text-[#005952] uppercase font-sans"
                    x-text="$store.lang.t('EKOSISTEM YOIN', 'THE YOIN ECOSYSTEM')"
                >
                    THE YOIN ECOSYSTEM
                </span>
            </div>
            <h2 class="text-2xl sm:text-3xl lg:text-4xl xl:text-5xl font-extrabold text-gray-950 tracking-tight leading-tight font-sans">
                Different paths.<br>
                <span class="text-[#005952]">One home.</span>
            </h2>
            <p 
                class="mt-2 sm:mt-3 text-xs sm:text-sm text-gray-600 leading-relaxed font-normal"
                x-text="$store.lang.t('YOIN sebagai pusat inovasi menaungi domain-domain strategis. Klik salah satu domain untuk melihat brand-brand di dalamnya.', 'YOIN is the innovation core connecting our domains. Click any domain to explore its brands.')"
            >
                YOIN sebagai pusat inovasi menaungi domain-domain strategis. Klik salah satu domain untuk melihat brand-brand di dalamnya.
            </p>
        </div>

        {{-- Level Controls (Status & Buttons) --}}
        <div class="flex items-center gap-2.5 sm:gap-3 pointer-events-auto self-start md:self-auto">
            {{-- Back Button (Appears when inside Sub-Domain) --}}
            <div x-show="currentLevel === 'subdomain'" x-transition class="flex items-center">
                <button 
                    @click="backToMain()"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white hover:bg-[#005952] text-[#005952] hover:text-white border border-[#005952] font-bold text-[11px] sm:text-xs tracking-wider uppercase transition-all duration-200 shadow-sm cursor-pointer group"
                >
                    <svg class="w-3.5 h-3.5 transform group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span x-text="$store.lang.t('Tata Surya Utama', 'Main Universe')">Tata Surya Utama</span>
                </button>
            </div>

            {{-- Orbit Pause / Rotate Toggle --}}
            <button 
                @click="isOrbitRotating = !isOrbitRotating"
                class="inline-flex items-center gap-2 px-3.5 py-1.5 sm:px-4 sm:py-2 rounded-full bg-white/95 hover:bg-white border border-gray-200 text-gray-700 text-[11px] sm:text-xs font-semibold tracking-wide shadow-sm transition-colors cursor-pointer"
            >
                <span class="w-2 h-2 rounded-full" :class="isOrbitRotating ? 'bg-emerald-500 animate-ping' : 'bg-amber-500'"></span>
                <span x-text="$store.lang.isEN() ? (isOrbitRotating ? 'Rotation Active' : 'Rotation Paused') : (isOrbitRotating ? 'Rotasi Aktif' : 'Rotasi Dijeda')"></span>
            </button>
        </div>
    </div>

    {{-- ======================================================== --}}
    {{-- A. DESKTOP VIEW (Screen >= lg, 1024px+): FULL-WIDTH ORBIT  --}}
    {{-- ======================================================== --}}
    <div class="hidden lg:flex relative w-full flex-1 items-center justify-center min-h-[620px] xl:min-h-[700px] my-4">
        
        {{-- ======================================== --}}
        {{-- LEVEL 1: DESKTOP MAIN UNIVERSE ORBIT     --}}
        {{-- ======================================== --}}
        <div 
            x-show="currentLevel === 'main'"
            x-transition:enter="transition-all duration-700 ease-out"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition-all duration-400 ease-in"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-105"
            class="absolute inset-0 w-full h-full flex items-center justify-center"
        >
            {{-- Central Sun / Core: YOIN --}}
            <a 
                href="{{ route('public.ecosystem.index') }}" 
                title="Buka Pusat Ekosistem YOIN"
                class="relative z-30 flex flex-col items-center justify-center cursor-pointer group/core"
            >
                <div class="absolute w-56 xl:w-64 h-56 xl:h-64 rounded-full bg-[#004741]/25 blur-3xl anim-halo pointer-events-none group-hover/core:bg-[#004741]/40 transition-all"></div>
                
                <div class="w-36 xl:w-44 h-36 xl:h-44 rounded-full bg-gradient-to-br from-[#005952] via-[#004741] to-[#012b26] p-1.5 shadow-2xl anim-core-glow flex items-center justify-center border-4 border-white select-none group-hover/core:scale-105 transition-transform">
                    <div class="w-full h-full rounded-full bg-[#004741]/95 backdrop-blur-md flex flex-col items-center justify-center text-center p-2 text-white">
                        <div class="w-9 xl:w-11 h-9 xl:h-11 mb-1 flex items-center justify-center">
                            <img src="{{ asset('logo.png') }}" alt="YOIN" class="w-full h-full object-contain filter brightness-0 invert" />
                        </div>
                        <span class="text-sm xl:text-base font-black tracking-[0.24em] font-sans">YOIN</span>
                        <span class="text-[8px] xl:text-[9px] font-semibold tracking-widest text-white/80 uppercase mt-0.5" x-text="$store.lang.t('PUSAT INOVASI', 'INNOVATION CORE')">PUSAT INOVASI</span>
                    </div>
                </div>
            </a>

            {{-- Revolving Main Planetary Orbits across Screen --}}
            <div 
                class="absolute w-[860px] xl:w-[960px] h-[860px] xl:h-[960px] rounded-full pointer-events-none"
                :class="isOrbitRotating ? 'orbit-rotation-slow' : 'orbit-paused'"
            >
                <template x-for="(d, idx) in mainDomains" :key="d.key">
                    <div 
                        class="absolute pointer-events-auto cursor-pointer group"
                        :class="isOrbitRotating ? 'orbit-counter-slow' : 'orbit-paused'"
                        :style="`
                            left: ${50 + 43 * Math.cos((idx * (360 / mainDomains.length) - 90) * Math.PI / 180)}%;
                            top: ${50 + 43 * Math.sin((idx * (360 / mainDomains.length) - 90) * Math.PI / 180)}%;
                            transform: translate(-50%, -50%);
                        `"
                        @click="enterDomain(d.key)"
                    >
                        <div class="p-3.5 xl:p-4 rounded-2xl bg-white/95 backdrop-blur-md border border-gray-200/90 shadow-md hover:shadow-2xl hover:border-[#005952] transition-all duration-300 hover:scale-105 w-[260px] xl:w-[285px] text-left">
                            {{-- Top Badge: URUTAN #1 | OPERATING (Matches Image 2) --}}
                            <div class="flex items-center justify-between gap-1 mb-1.5">
                                <span class="text-[9px] font-mono font-bold text-slate-800 bg-slate-100 px-2 py-0.5 rounded border border-slate-200 uppercase" x-text="d.order_badge"></span>
                                <span class="text-[9px] font-mono font-bold uppercase tracking-wider text-gray-400" x-text="d.status"></span>
                            </div>

                            {{-- Domain Name (ID) & English Subtitle --}}
                            <div class="flex items-start gap-2.5 my-1">
                                <div class="w-8 h-8 rounded-full bg-slate-100 border border-slate-200 text-slate-800 flex items-center justify-center shrink-0 mt-0.5 group-hover:bg-[#004741] group-hover:text-white transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="d.iconSvg" />
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-xs xl:text-sm font-black text-gray-900 group-hover:text-[#005952] tracking-tight leading-snug font-sans truncate" x-text="$store.lang.isEN() ? d.name_en : d.name_id"></h4>
                                    <p class="text-[9px] text-teal-700/85 font-medium italic truncate" x-text="$store.lang.isEN() ? d.name_id : d.name_en"></p>
                                </div>
                            </div>

                            {{-- Keterangan / Tagline (SAMA PERCIS DENGAN ADMIN!) --}}
                            <p class="text-[10px] xl:text-[11px] text-gray-600 leading-snug line-clamp-2 mt-1 font-normal" x-text="$store.lang.isEN() ? d.tagline_en : d.tagline_id"></p>

                            {{-- Footer: Inisiatif count & Action --}}
                            <div class="mt-2.5 pt-2 border-t border-gray-100 flex items-center justify-between text-[10px]">
                                <span class="font-bold text-[#005952]" x-text="d.initiatives_label"></span>
                                <span class="inline-flex items-center gap-1 font-bold text-teal-700 group-hover:text-[#005952]">
                                    <span x-text="$store.lang.t('Buka Brand', 'View Brands')">Buka Brand</span> →
                                </span>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        {{-- ======================================== --}}
        {{-- LEVEL 2: DESKTOP SUB-ORBIT DOMAIN ZOOM   --}}
        {{-- ======================================== --}}
        <div 
            x-show="currentLevel === 'subdomain'"
            x-transition:enter="transition-all duration-700 ease-out"
            x-transition:enter-start="opacity-0 scale-90"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition-all duration-400 ease-in"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-90"
            class="absolute inset-0 w-full h-full flex flex-col items-center justify-center"
        >
            {{-- Selected Domain Center Planet & Details (Ringkas & Simpel) --}}
            <div class="relative z-30 flex flex-col items-center justify-center text-center max-w-md px-4">
                <div class="absolute w-60 xl:w-72 h-60 xl:h-72 rounded-full bg-[#005952]/25 blur-3xl anim-halo pointer-events-none"></div>

                {{-- Domain Planet Sphere --}}
                <div class="w-36 xl:w-44 h-36 xl:h-44 rounded-full bg-gradient-to-br from-[#005952] via-[#004741] to-[#012623] p-1.5 shadow-2xl anim-core-glow flex items-center justify-center border-4 border-white select-none">
                    <div class="w-full h-full rounded-full bg-[#003d38] backdrop-blur-md flex flex-col items-center justify-center text-center p-3 text-white">
                        <span class="text-[9px] font-mono font-bold text-white uppercase tracking-wider" x-text="currentDomain.order_badge"></span>
                        <h3 class="text-sm xl:text-base font-black tracking-tight font-sans mt-0.5 line-clamp-2" x-text="$store.lang.isEN() ? currentDomain.name_en : currentDomain.name_id"></h3>
                        <span class="px-2.5 py-0.5 rounded-full bg-white/20 text-[8px] font-bold text-white uppercase mt-1 tracking-wider" x-text="currentDomain.status"></span>
                    </div>
                </div>

                {{-- Tagline Ringkas & Simpel (Tanpa Solusi / Tantangan) --}}
                <p class="mt-3 text-xs sm:text-sm text-gray-600 font-medium leading-relaxed" x-text="$store.lang.isEN() ? currentDomain.tagline_en : currentDomain.tagline_id"></p>

                {{-- Actions --}}
                <div class="mt-4 flex flex-wrap items-center justify-center gap-2">
                    <a 
                        :href="currentDomain.domainUrl"
                        class="px-4 py-1.5 rounded-full bg-[#005952] hover:bg-[#004741] text-white border border-[#005952] text-[11px] font-bold tracking-wider uppercase shadow-md hover:scale-105 transition-all flex items-center gap-1.5 cursor-pointer"
                    >
                        <span x-text="$store.lang.t('Halaman Domain & Portofolio →', 'Domain & Portfolio Page →')">Halaman Domain & Portofolio →</span>
                    </a>
                    <button 
                        @click="backToMain()"
                        class="px-4 py-1.5 rounded-full bg-white hover:bg-gray-100 text-gray-700 border border-gray-300 text-[11px] font-bold tracking-wider uppercase shadow-sm transition-all flex items-center gap-1.5 cursor-pointer"
                    >
                        <span x-text="$store.lang.t('← Kembali ke Orbit Utama', '← Back to Main Universe')">← Kembali ke Orbit Utama</span>
                    </button>
                </div>
            </div>

            {{-- Rotating Sub-Satellites Orbit across Desktop Screen --}}
            <div 
                class="absolute w-[780px] xl:w-[880px] h-[780px] xl:h-[880px] rounded-full pointer-events-none"
                :class="isOrbitRotating ? 'orbit-rotation-medium' : 'orbit-paused'"
            >
                <template x-for="(b, bIdx) in (currentDomain.brands || [])" :key="b.name">
                    <div 
                        class="absolute pointer-events-auto cursor-pointer group"
                        :class="isOrbitRotating ? 'orbit-counter-medium' : 'orbit-paused'"
                        :style="`
                            left: ${50 + ((currentDomain.brands || []).length === 1 ? 0 : 42 * Math.cos((bIdx * (360 / (currentDomain.brands || []).length) - ((currentDomain.brands || []).length === 2 ? 180 : 90)) * Math.PI / 180))}%;
                            top: ${50 + ((currentDomain.brands || []).length === 1 ? -42 : 42 * Math.sin((bIdx * (360 / (currentDomain.brands || []).length) - ((currentDomain.brands || []).length === 2 ? 180 : 90)) * Math.PI / 180))}%;
                            transform: translate(-50%, -50%);
                        `"
                        @click="activeDetailNode = b"
                    >
                        <div 
                            class="p-4 rounded-2xl bg-white/95 backdrop-blur-md border shadow-md hover:shadow-2xl transition-all duration-300 hover:scale-105 w-[250px] xl:w-[270px] text-left relative overflow-hidden"
                            :class="activeDetailNode === b ? 'border-[#005952] ring-2 ring-[#005952]/20' : 'border-gray-200'"
                        >
                            <div class="flex items-center justify-between gap-1 mb-1.5">
                                <span class="text-[9px] font-extrabold tracking-wider text-emerald-700 uppercase bg-emerald-50 px-2 py-0.5 rounded-md border border-emerald-200/60 truncate max-w-[170px]" x-text="$store.lang.isEN() ? b.tag.en : b.tag.id"></span>
                                <span class="text-[8px] font-mono font-bold text-gray-400 uppercase">BRAND</span>
                            </div>
                            <h5 class="text-sm xl:text-base font-black text-gray-900 group-hover:text-[#005952] transition-colors" x-text="b.name"></h5>
                            <p class="text-[10px] text-gray-600 mt-1 line-clamp-2 leading-relaxed font-normal" x-text="$store.lang.isEN() ? b.desc.en : b.desc.id"></p>
                            <div class="mt-3 pt-2 border-t border-gray-100 flex items-center justify-between">
                                <a 
                                    :href="b.url"
                                    @click.stop
                                    class="inline-flex items-center gap-1 text-[11px] font-bold text-[#005952] hover:text-[#003d38] hover:underline cursor-pointer"
                                >
                                    <span x-text="$store.lang.t('Kunjungi Brand', 'Visit Brand')">Kunjungi Brand</span> →
                                </a>
                                <span class="text-xs text-gray-400 group-hover:text-[#005952] transition-colors">↗</span>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>

    {{-- ======================================================== --}}
    {{-- B. MOBILE & TABLET VIEW (< lg): ADAPTIVE CELESTIAL RADAR  --}}
    {{-- ======================================================== --}}
    <div class="lg:hidden relative w-full flex flex-col items-center justify-center my-6 px-4">
        
        {{-- Interactive Planet Orbit Wheel (Compact, 290px diameter) --}}
        <div class="relative w-[280px] sm:w-[320px] h-[280px] sm:h-[320px] flex items-center justify-center my-2 select-none">
            {{-- Orbit guide circles --}}
            <div class="absolute inset-0 rounded-full border border-teal-500/25 border-dashed pointer-events-none"></div>
            <div class="absolute inset-4 rounded-full border border-teal-600/15 pointer-events-none"></div>

            {{-- Center YOIN Sun --}}
            <div 
                x-show="currentLevel === 'main'"
                class="relative z-20 w-20 h-20 rounded-full bg-gradient-to-br from-[#005952] via-[#004741] to-[#012b26] p-1 shadow-lg anim-core-glow flex items-center justify-center border-2 border-white"
            >
                <div class="w-full h-full rounded-full bg-[#004741] flex flex-col items-center justify-center text-white text-center">
                    <img src="{{ asset('logo.png') }}" alt="YOIN" class="w-6 h-6 object-contain filter brightness-0 invert mb-0.5" />
                    <span class="text-[10px] font-black tracking-widest">YOIN</span>
                </div>
            </div>

            {{-- Center Planet for Level 2 Sub-domain --}}
            <div 
                x-show="currentLevel === 'subdomain'"
                class="relative z-20 w-20 h-20 rounded-full bg-gradient-to-br from-[#005952] via-[#004741] to-[#012b26] p-1 shadow-lg anim-core-glow flex items-center justify-center border-2 border-white"
            >
                <div class="w-full h-full rounded-full bg-[#003d38] flex flex-col items-center justify-center text-white text-center p-1">
                    <span class="text-[8px] font-mono text-white" x-text="currentDomain.order_badge"></span>
                    <span class="text-[9px] font-bold uppercase truncate max-w-[70px]" x-text="$store.lang.isEN() ? currentDomain.name_en : currentDomain.name_id"></span>
                </div>
            </div>

            {{-- LEVEL 1: Circular Planet Badges in Orbit Ring --}}
            <div 
                x-show="currentLevel === 'main'"
                class="absolute inset-0 rounded-full pointer-events-none"
                :class="isOrbitRotating ? 'orbit-rotation-slow' : 'orbit-paused'"
            >
                <template x-for="(d, idx) in mainDomains" :key="d.key">
                    <div 
                        class="absolute pointer-events-auto cursor-pointer transform -translate-x-1/2 -translate-y-1/2 transition-transform duration-300"
                        :style="`
                            left: ${50 + 44 * Math.cos((idx * (360 / mainDomains.length) - 90) * Math.PI / 180)}%;
                            top: ${50 + 44 * Math.sin((idx * (360 / mainDomains.length) - 90) * Math.PI / 180)}%;
                        `"
                        @click="selectDomainIndex(idx)"
                    >
                        <div 
                            class="relative flex flex-col items-center group"
                            :class="isOrbitRotating ? 'orbit-counter-slow' : 'orbit-paused'"
                        >
                            <div 
                                class="w-11 h-11 rounded-full flex items-center justify-center border-2 transition-all duration-300 shadow-md bg-white"
                                :class="selectedDomainKey === d.key ? 'border-[#005952] scale-110 ring-4 ring-[#005952]/20 bg-teal-50 text-[#005952]' : 'border-gray-200 text-gray-600 hover:border-teal-400'"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="d.iconSvg" />
                                </svg>
                            </div>
                            <span 
                                class="mt-1 px-1.5 py-0.5 rounded-full text-[8px] font-bold tracking-wider uppercase transition-colors truncate max-w-[80px]"
                                :class="selectedDomainKey === d.key ? 'bg-[#005952] text-white shadow-xs' : 'bg-white/90 text-gray-700 border border-gray-200'"
                                x-text="d.name_id"
                            ></span>
                        </div>
                    </div>
                </template>
            </div>

            {{-- LEVEL 2: Brands in Orbit Ring --}}
            <div 
                x-show="currentLevel === 'subdomain'"
                class="absolute inset-0 rounded-full pointer-events-none"
                :class="isOrbitRotating ? 'orbit-rotation-medium' : 'orbit-paused'"
            >
                <template x-for="(b, bIdx) in (currentDomain.brands || [])" :key="b.name">
                    <div 
                        class="absolute pointer-events-auto cursor-pointer transform -translate-x-1/2 -translate-y-1/2 transition-transform duration-300"
                        :style="`
                            left: ${50 + ((currentDomain.brands || []).length === 1 ? 0 : 44 * Math.cos((bIdx * (360 / (currentDomain.brands || []).length) - ((currentDomain.brands || []).length === 2 ? 180 : 90)) * Math.PI / 180))}%;
                            top: ${50 + ((currentDomain.brands || []).length === 1 ? -44 : 44 * Math.sin((bIdx * (360 / (currentDomain.brands || []).length) - ((currentDomain.brands || []).length === 2 ? 180 : 90)) * Math.PI / 180))}%;
                        `"
                        @click="activeDetailNode = b"
                    >
                        <div 
                            class="relative flex flex-col items-center"
                            :class="isOrbitRotating ? 'orbit-counter-medium' : 'orbit-paused'"
                        >
                            <div 
                                class="w-10 h-10 rounded-full flex items-center justify-center border-2 transition-all duration-300 shadow-md bg-white"
                                :class="activeDetailNode === b ? 'border-[#005952] scale-110 ring-4 ring-[#005952]/20 bg-teal-50 text-[#005952]' : 'border-gray-200 text-gray-600'"
                            >
                                <span class="text-[9px] font-black" x-text="bIdx + 1"></span>
                            </div>
                            <span 
                                class="mt-1 px-1.5 py-0.5 rounded-full text-[7px] font-bold tracking-wider uppercase bg-white/95 text-gray-800 border border-gray-200 truncate max-w-[80px]"
                                x-text="b.name"
                            ></span>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        {{-- Mobile Active Planet Showcase Card (Docked cleanly below, NO OVERLAPPING) --}}
        <div class="w-full max-w-sm mt-4 bg-white/95 backdrop-blur-md rounded-2xl border border-gray-200 p-4 sm:p-5 shadow-lg text-left">
            
            {{-- LEVEL 1 CARD CONTENT --}}
            <div x-show="currentLevel === 'main'">
                <div class="flex items-center justify-between gap-2 mb-1.5">
                    <span class="text-[10px] font-mono font-bold tracking-wider text-[#005952] uppercase" x-text="currentDomain.order_badge"></span>
                    <span class="px-2 py-0.5 rounded-full bg-teal-50 text-[9px] font-bold text-[#005952] border border-teal-200" x-text="currentDomain.status"></span>
                </div>
                
                <h4 class="text-base sm:text-lg font-extrabold text-gray-900 tracking-tight" x-text="$store.lang.isEN() ? currentDomain.name_en : currentDomain.name_id"></h4>
                <p class="text-xs text-teal-800 font-semibold mt-0.5" x-text="$store.lang.isEN() ? currentDomain.name_id : currentDomain.name_en"></p>
                <p class="text-[11px] text-gray-600 leading-relaxed mt-2" x-text="$store.lang.isEN() ? currentDomain.tagline_en : currentDomain.tagline_id"></p>

                <div class="mt-4 flex items-center justify-between gap-3 pt-3 border-t border-gray-100">
                    {{-- Prev / Next Controls --}}
                    <div class="flex items-center gap-1.5">
                        <button 
                            @click="selectDomainIndex(selectedIndex - 1)" 
                            class="w-8 h-8 rounded-full border border-gray-200 bg-white hover:bg-gray-100 flex items-center justify-center text-gray-700 text-xs font-bold transition-colors"
                        >
                            ‹
                        </button>
                        <span class="text-[10px] font-mono font-semibold text-gray-500 px-1" x-text="`${selectedIndex + 1} / ${mainDomains.length}`"></span>
                        <button 
                            @click="selectDomainIndex(selectedIndex + 1)" 
                            class="w-8 h-8 rounded-full border border-gray-200 bg-white hover:bg-gray-100 flex items-center justify-center text-gray-700 text-xs font-bold transition-colors"
                        >
                            ›
                        </button>
                    </div>

                    {{-- Action buttons: View Domain & Explore Sub-orbit --}}
                    <div class="flex items-center gap-2">
                        <a 
                            :href="currentDomain.domainUrl"
                            class="inline-flex items-center gap-1 px-3 py-2 rounded-full border border-[#005952] text-[#005952] hover:bg-teal-50 text-[11px] font-bold tracking-wider uppercase transition-colors"
                        >
                            <span x-text="$store.lang.t('Domain', 'Domain')">Domain</span>
                        </a>
                        <button 
                            @click="enterDomain(currentDomain.key)"
                            class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-full bg-[#005952] hover:bg-[#004741] text-white text-[11px] font-bold tracking-wider uppercase transition-colors shadow-sm cursor-pointer"
                        >
                            <span x-text="$store.lang.t('Buka Brand', 'View Brands')">Buka Brand</span> →
                        </button>
                    </div>
                </div>
            </div>

            {{-- LEVEL 2 CARD CONTENT --}}
            <div x-show="currentLevel === 'subdomain'">
                <div class="flex items-center justify-between gap-2 mb-1.5">
                    <span class="text-[10px] font-mono font-bold tracking-wider text-[#005952] uppercase" x-text="`${currentDomain.name_id} • BRAND`"></span>
                    <button @click="backToMain()" class="text-[10px] font-bold text-[#005952] hover:underline cursor-pointer" x-text="$store.lang.t('← Kembali ke Orbit', '← Back to Orbit')">← Kembali ke Orbit</button>
                </div>

                <div x-show="activeDetailNode">
                    <div class="flex items-center justify-between gap-1 mb-1">
                        <span class="text-[9px] font-extrabold tracking-wider text-emerald-700 uppercase bg-emerald-50 px-2 py-0.5 rounded-md border border-emerald-200/60 truncate max-w-[155px]" x-text="$store.lang.isEN() ? activeDetailNode?.tag?.en : activeDetailNode?.tag?.id"></span>
                        <span class="text-[8px] font-mono font-bold text-gray-400 uppercase tracking-wider" x-text="$store.lang.t('Brand Ekosistem', 'Ecosystem Brand')">Brand Ekosistem</span>
                    </div>
                    <h4 class="text-base sm:text-lg font-extrabold text-gray-900 tracking-tight mt-0.5" x-text="activeDetailNode?.name"></h4>
                    <p class="text-xs text-gray-600 leading-relaxed mt-1 font-normal" x-text="$store.lang.isEN() ? activeDetailNode?.desc?.en : activeDetailNode?.desc?.id"></p>
                </div>

                <div class="mt-4 pt-3 border-t border-gray-100 flex flex-wrap items-center justify-between gap-2">
                    <a 
                        :href="activeDetailNode?.url || currentDomain.domainUrl"
                        class="px-3.5 py-2 rounded-full bg-[#005952] text-white hover:bg-[#004741] text-[11px] font-bold transition-colors shadow-xs inline-flex items-center gap-1.5 cursor-pointer"
                    >
                        <span x-text="$store.lang.t('Kunjungi Profil Brand', 'Visit Brand Profile')">Kunjungi Profil Brand</span> →
                    </a>
                    <a 
                        :href="currentDomain.domainUrl"
                        class="px-3 py-1.5 rounded-full border border-gray-300 hover:bg-gray-100 text-gray-700 text-[10px] font-bold transition-colors cursor-pointer"
                        x-text="$store.lang.t('Halaman Domain', 'Domain Page')"
                    >
                        Halaman Domain
                    </a>
                </div>
            </div>

        </div>

    </div>

    {{-- ======================================================== --}}
    {{-- BOTTOM BAR: GLOBE BADGE & "Enter the Ecosystem" CTA      --}}
    {{-- ======================================================== --}}
    <div class="relative z-30 w-full px-6 sm:px-12 lg:px-16 flex flex-col sm:flex-row items-center justify-between gap-4 mt-4 pointer-events-auto">
        
        {{-- Globe Impact Badge --}}
        <div class="hidden sm:flex items-center gap-3 p-3 sm:p-4 rounded-2xl bg-white/95 backdrop-blur-md border border-gray-200/90 shadow-md max-w-xs text-left">
            <div class="w-10 h-10 rounded-full bg-teal-50 border border-teal-200 flex items-center justify-center shrink-0 text-[#005952]">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064" />
                </svg>
            </div>
            <div>
                <h5 class="text-[11px] font-bold text-gray-900 leading-tight" x-text="$store.lang.t('Terhubung. Kolaboratif. Berdampak.', 'Connected. Collaborative. Impact.')">Connected. Collaborative. Impact.</h5>
                <p class="text-[10px] text-gray-500 leading-tight mt-0.5" x-text="$store.lang.t('Satu ekosistem. Beragam kemungkinan baru.', 'One ecosystem. Endless possibilities.')">One ecosystem. Endless possibilities.</p>
            </div>
        </div>


        {{-- Active Orbit Node Status Pill --}}
        <div class="hidden sm:flex items-center gap-2 px-4 py-2 rounded-full bg-white/95 backdrop-blur-md border border-gray-200 text-xs text-gray-700 shadow-sm">
            <span class="w-2 h-2 rounded-full bg-teal-500 animate-pulse"></span>
            <span class="font-mono text-[10px] text-gray-500" x-text="currentLevel === 'main' ? 'ORBIT: DOMAIN UTAMA' : `ORBIT: BRAND • ${currentDomain.order_badge}`"></span>
        </div>

    </div>

    {{-- Accessible & SEO crawlable links for all domains and initiatives --}}
    <div class="sr-only" aria-hidden="true">
        @foreach($domainsSource as $dom)
            <a href="{{ route('public.ecosystem.domain', $dom->slug) }}">{{ $dom->name_id }}</a>
            @foreach($dom->initiatives as $init)
                <a href="{{ route('public.ecosystem.initiative', $init->slug) }}">{{ $init->name }}</a>
            @endforeach
        @endforeach
    </div>

</section>

