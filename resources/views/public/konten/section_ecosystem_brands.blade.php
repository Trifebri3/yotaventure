{{-- 
    YOIN Ecosystem Brands & Services Showcase
    "SOME ARE ALREADY BUILDING"
    "From ideas to real impact."
    "DISINI MENAMPILKAN SEMUA BRAND DARI KATEGORI, MISAL DI DIGITAL SERVICE ini ada web dev, app dev, server, konsultan dll Gitu yaaa JADI ITU DITAMPILKANNYA"
    100% Dinamis & Tersinkronisasi dengan Database EcosystemInitiative & EcosystemDomain.
    Dilengkapi Auto-Slider / Bergeser Otomatis saat item banyak.
    Aturan: 100% Bilingual (ID & EN), Bebas Emotikon, Tanpa Kata Venture, Responsif Mobile & Desktop.
--}}
@php
    $initiativesSource = \App\Models\EcosystemInitiative::with(['domain', 'products' => function ($q) {
        $q->where('visibility', 'public')->orderBy('sort_order');
    }])
        ->where('visibility', 'public')
        ->orderBy('sort_order')
        ->get();

    // Query distinct domains that have active initiatives from the database
    $filterDomains = \App\Models\EcosystemDomain::withCount(['initiatives' => function ($q) {
        $q->where('visibility', 'public');
    }])
        ->where('visibility', 'public')
        ->whereHas('initiatives', function ($q) {
            $q->where('visibility', 'public');
        })
        ->orderBy('sort_order')
        ->get();

    $domainFilterShortLabels = [
        'digital' => ['id' => 'Digital Services', 'en' => 'Digital Services'],
        'agriculture' => ['id' => 'Agrikultur', 'en' => 'Agriculture'],
        'products' => ['id' => 'Produk', 'en' => 'Products'],
        'emerging' => ['id' => 'Inisiatif Masa Depan', 'en' => 'Future Initiatives'],
        'impact' => ['id' => 'Dampak Sosial', 'en' => 'Social Impact'],
    ];

    $categoriesData = $filterDomains->map(function ($dom) use ($domainFilterShortLabels) {
        $short = $domainFilterShortLabels[$dom->slug] ?? null;
        return [
            'key' => $dom->slug,
            'name' => [
                'id' => $short['id'] ?? $dom->name_id,
                'en' => $short['en'] ?? ($dom->name_en ?: $dom->name_id),
            ],
            'count' => $dom->initiatives_count,
        ];
    })->values()->toArray();

    $mappedBrands = $initiativesSource->map(function ($init) {
        $name = str_ireplace('YOTA', 'YOIN', $init->name);
        $words = explode(' ', $name);
        $logoText = strtoupper($words[0] ?? $name);
        $logoSub = strtoupper($words[1] ?? ($init->stage ?: 'BRAND'));

        $category = [
            'id' => $init->domain ? str_ireplace('YOTA', 'YOIN', $init->domain->name_id) : 'Brand Ekosistem',
            'en' => $init->domain ? str_ireplace('YOTA', 'YOIN', $init->domain->name_en ?: $init->domain->name_id) : 'Ecosystem Brand',
        ];
        $categoryKey = $init->domain?->slug ?: 'general';
        $tagColor = 'text-[#005952]';
        $bgGradient = 'from-slate-900/60 via-transparent to-transparent';
        
        $badge = [
            'id' => $init->stage ?: 'Inisiatif YOIN',
            'en' => $init->stage ?: 'YOIN Initiative',
        ];

        $image = $init->cover_image ?: ($init->hero_image ?: 'https://images.unsplash.com/photo-1551836022-d5d88e9218df?q=80&w=800&auto=format&fit=crop');

        $desc = [
            'id' => str_ireplace('YOTA', 'YOIN', $init->tagline_id ?: ($init->problem_statement_id ?: 'Membangun produk dan layanan berdaulat untuk kebutuhan masa depan.')),
            'en' => str_ireplace('YOTA', 'YOIN', $init->tagline_en ?: ($init->problem_statement_en ?: 'Building digital products and services for a changing world.')),
        ];

        $longDesc = [
            'id' => str_ireplace('YOTA', 'YOIN', $init->mission_id ?: ($init->story_id ?: $desc['id'])),
            'en' => str_ireplace('YOTA', 'YOIN', $init->mission_en ?: ($init->story_en ?: $desc['en'])),
        ];

        // 100% Dynamic Services from Database (focus_areas or products)
        $services = [];
        if (!empty($init->focus_areas) && is_array($init->focus_areas)) {
            foreach ($init->focus_areas as $area) {
                $areaStr = is_string($area) ? $area : (is_array($area) ? ($area['name'] ?? json_encode($area)) : (string) $area);
                $services[] = [
                    'name' => ['id' => $areaStr, 'en' => $areaStr],
                    'tag' => ['id' => 'Layanan & Unit', 'en' => 'Service Unit'],
                    'desc' => ['id' => $areaStr, 'en' => $areaStr],
                ];
            }
        }
        if (empty($services) && $init->products->isNotEmpty()) {
            foreach ($init->products as $prod) {
                $services[] = [
                    'name' => ['id' => $prod->name, 'en' => $prod->name],
                    'tag' => ['id' => 'Produk', 'en' => 'Product'],
                    'desc' => ['id' => $prod->description_id ?: $prod->name, 'en' => $prod->description_en ?: $prod->name],
                ];
            }
        }

        $stats = [
            ['label' => ['id' => 'Status', 'en' => 'Status'], 'val' => strtoupper($init->status ?: 'OPERATING')],
            ['label' => ['id' => 'Unit Terpadu', 'en' => 'Integrated Units'], 'val' => count($services) . ' Unit'],
            ['label' => ['id' => 'Ekosistem', 'en' => 'Ecosystem'], 'val' => 'YOIN'],
        ];

        return [
            'id' => $init->slug,
            'slug' => $init->slug,
            'name' => $name,
            'logoText' => $logoText,
            'logoSub' => $logoSub,
            'logoImage' => $init->logo_image,
            'category' => $category,
            'categoryKey' => $categoryKey,
            'badge' => $badge,
            'tagColor' => $tagColor,
            'bgGradient' => $bgGradient,
            'image' => $image,
            'desc' => $desc,
            'longDesc' => $longDesc,
            'services' => $services,
            'stats' => $stats,
            'url' => route('public.ecosystem.initiative', $init->slug),
            'externalUrl' => $init->external_website_url,
            'externalLabel' => $init->external_url_label ?: 'Visit Website →',
        ];
    })->values()->toArray();
@endphp

<section 
    id="ecosystem" 
    x-data="{
        activeFilter: 'all',
        activeModalBrand: null,
        brands: @js($mappedBrands),
        categories: @js($categoriesData),
        currentIndex: 0,
        autoplayTimer: null,
        isHovered: false,

        get filteredBrands() {
            if (this.activeFilter === 'all') return this.brands;
            return this.brands.filter(b => b.categoryKey === this.activeFilter);
        },

        get perView() {
            if (window.innerWidth >= 1536) return 4;
            if (window.innerWidth >= 1280) return 3;
            if (window.innerWidth >= 1024) return 2.5;
            if (window.innerWidth >= 640) return 2;
            return 1;
        },

        get maxIndex() {
            const count = this.filteredBrands.length;
            const pv = Math.floor(this.perView);
            return Math.max(0, count - pv);
        },

        setFilter(key) {
            this.activeFilter = key;
            this.currentIndex = 0;
            this.$nextTick(() => {
                this.scrollToIndex();
            });
        },

        next() {
            if (this.maxIndex <= 0) return;
            if (this.currentIndex >= this.maxIndex) {
                this.currentIndex = 0;
            } else {
                this.currentIndex++;
            }
            this.scrollToIndex();
        },

        prev() {
            if (this.maxIndex <= 0) return;
            if (this.currentIndex <= 0) {
                this.currentIndex = this.maxIndex;
            } else {
                this.currentIndex--;
            }
            this.scrollToIndex();
        },

        goTo(idx) {
            this.currentIndex = Math.min(Math.max(0, idx), this.maxIndex);
            this.scrollToIndex();
        },

        scrollToIndex() {
            const track = this.$refs.sliderTrack;
            if (!track) return;
            const cards = track.querySelectorAll('.brand-card');
            const card = cards[this.currentIndex];
            if (card) {
                track.scrollTo({
                    left: card.offsetLeft - track.offsetLeft,
                    behavior: 'smooth'
                });
            }
        },

        startAutoplay() {
            this.stopAutoplay();
            this.autoplayTimer = setInterval(() => {
                if (!this.isHovered && this.maxIndex > 0) {
                    this.next();
                }
            }, 4500);
        },

        stopAutoplay() {
            if (this.autoplayTimer) {
                clearInterval(this.autoplayTimer);
                this.autoplayTimer = null;
            }
        },

        init() {
            this.startAutoplay();
            window.addEventListener('resize', () => {
                if (this.currentIndex > this.maxIndex) {
                    this.currentIndex = this.maxIndex;
                    this.scrollToIndex();
                }
            });
        }
    }"
    @mouseenter="isHovered = true"
    @mouseleave="isHovered = false"
    class="relative w-full py-20 sm:py-28 bg-[#FAFCFC] border-t border-gray-200 overflow-hidden select-none"
>
    
    {{-- Subtle Background Mesh --}}
    <div class="absolute inset-0 pointer-events-none opacity-30">
        <svg class="w-full h-full" viewBox="0 0 1440 800" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
            <defs>
                <pattern id="brandGridDots" width="48" height="48" patternUnits="userSpaceOnUse">
                    <circle cx="24" cy="24" r="1" fill="#005952" opacity="0.15" />
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#brandGridDots)" />
        </svg>
    </div>

    <div class="relative max-w-[1560px] mx-auto px-4 sm:px-6 lg:px-10 xl:px-12">
        
        {{-- ======================================================== --}}
        {{-- SECTION HEADER (Bilingual)                               --}}
        {{-- ======================================================== --}}
        <div class="text-center max-w-3xl mx-auto mb-10 sm:mb-14">
            <span class="text-xs sm:text-sm font-bold tracking-[0.24em] text-[#005952] uppercase font-sans" x-text="$store.lang.t('SEBAGIAN SUDAH MULAI MEMBANGUN', 'SOME ARE ALREADY BUILDING')">
                SOME ARE ALREADY BUILDING
            </span>
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-gray-950 mt-3 tracking-tight font-sans leading-tight">
                <span x-text="$store.lang.t('Dari gagasan menjadi', 'From ideas to')">From ideas to</span> <span class="text-[#005952]" x-text="$store.lang.t('dampak nyata.', 'real impact.')">real impact.</span>
            </h2>
            <p class="text-gray-600 mt-3 sm:mt-4 text-xs sm:text-sm lg:text-base leading-relaxed max-w-xl mx-auto font-normal" x-text="$store.lang.t('Temui berbagai inisiatif yang aktif bertumbuh dan memberi dampak di seluruh ekosistem YOIN.', 'Meet some of the initiatives already building across the YOIN ecosystem.')">
                Meet some of the initiatives already building across the YOIN ecosystem.
            </p>

            {{-- Aesthetic Pagination Accent Line (• ▬ •) --}}
            <div class="flex items-center justify-center gap-2 mt-5">
                <span class="w-1.5 h-1.5 rounded-full bg-slate-300"></span>
                <span class="w-8 h-[2.5px] rounded-full bg-[#004741]"></span>
                <span class="w-1.5 h-1.5 rounded-full bg-slate-300"></span>
            </div>
        </div>

        {{-- ======================================================== --}}
        {{-- DYNAMIC CATEGORY FILTER PILLS (100% From Database)       --}}
        {{-- ======================================================== --}}
        <div class="flex items-center justify-center flex-wrap gap-2 mb-10">
            <button 
                @click="setFilter('all')"
                class="px-4 py-1.5 rounded-full text-xs font-bold tracking-wider uppercase transition-all duration-200 cursor-pointer"
                :class="activeFilter === 'all' ? 'bg-[#005952] text-white shadow-sm' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200'"
                x-text="$store.lang.t('Semua Inisiatif (' + brands.length + ')', 'All Initiatives (' + brands.length + ')')"
            >
                Semua Inisiatif (5)
            </button>
            <template x-for="cat in categories" :key="cat.key">
                <button 
                    @click="setFilter(cat.key)"
                    class="px-4 py-1.5 rounded-full text-xs font-bold tracking-wider uppercase transition-all duration-200 cursor-pointer"
                    :class="activeFilter === cat.key ? 'bg-[#005952] text-white shadow-sm' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200'"
                    x-text="$store.lang.isEN() ? cat.name.en : cat.name.id"
                ></button>
            </template>
        </div>

        {{-- ======================================================== --}}
        {{-- BRAND CARDS CAROUSEL (Dinamis, Auto-Slide saat banyak)    --}}
        {{-- ======================================================== --}}
        <div class="relative group/carousel">
            
            {{-- Navigation Arrows (Visible when overflowable) --}}
            <button 
                x-show="maxIndex > 0"
                @click="prev()"
                aria-label="Previous Brand"
                class="absolute -left-3 sm:-left-5 top-1/2 -translate-y-1/2 z-20 w-10 h-10 rounded-full bg-white/95 border border-gray-200 shadow-lg text-gray-800 hover:text-[#005952] hover:scale-105 active:scale-95 flex items-center justify-center transition-all cursor-pointer"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
                </svg>
            </button>

            <button 
                x-show="maxIndex > 0"
                @click="next()"
                aria-label="Next Brand"
                class="absolute -right-3 sm:-right-5 top-1/2 -translate-y-1/2 z-20 w-10 h-10 rounded-full bg-white/95 border border-gray-200 shadow-lg text-gray-800 hover:text-[#005952] hover:scale-105 active:scale-95 flex items-center justify-center transition-all cursor-pointer"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                </svg>
            </button>

            {{-- Slider Track Container --}}
            <div 
                x-ref="sliderTrack"
                class="flex gap-6 overflow-x-auto scroll-smooth no-scrollbar py-2 px-1 snap-x snap-mandatory"
                style="scrollbar-width: none; -ms-overflow-style: none;"
            >
                <template x-for="b in filteredBrands" :key="b.id">
                    <div 
                        class="brand-card shrink-0 snap-start flex flex-col justify-between bg-white rounded-2xl border border-gray-200 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 overflow-hidden group
                               w-[88vw] sm:w-[320px] md:w-[340px] lg:w-[360px] xl:w-[380px]"
                    >
                        {{-- TOP CARD IMAGE & BRAND EMBLEM --}}
                        <div>
                            <div class="relative h-60 sm:h-64 w-full overflow-hidden bg-gray-100">
                                {{-- Background Photo --}}
                                <img 
                                    :src="b.image" 
                                    :alt="b.name" 
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 filter brightness-95"
                                />
                                {{-- Soft Gradient Overlay --}}
                                <div class="absolute inset-0 bg-gradient-to-b" :class="b.bgGradient"></div>

                                {{-- Top-Left Badge Pill --}}
                                <div class="absolute top-4 left-4 z-10">
                                    <span class="px-3 py-1 rounded-md bg-white/95 backdrop-blur-md text-[10px] font-bold text-gray-700 tracking-wider uppercase shadow-xs">
                                        <span x-text="$store.lang.isEN() ? b.badge.en : b.badge.id"></span>
                                    </span>
                                </div>

                                {{-- Brand Logo in Center of Image (No floating photo boxes!) --}}
                                <div class="absolute inset-0 flex flex-col items-center justify-center p-4 text-center select-none pointer-events-none z-10">
                                    
                                    {{-- 1. If valid graphic logo file uploaded in storage or svg --}}
                                    <template x-if="b.logoImage && (b.logoImage.includes('/storage/') || b.logoImage.endsWith('.svg') || b.logoImage.includes('logo'))">
                                        <img :src="b.logoImage" :alt="b.name" class="max-h-12 max-w-[160px] object-contain drop-shadow-md brightness-110" />
                                    </template>

                                    {{-- 2. Clean Typographic & SVG Vector Brand Emblems --}}
                                    <template x-if="!b.logoImage || (!b.logoImage.includes('/storage/') && !b.logoImage.endsWith('.svg') && !b.logoImage.includes('logo'))">
                                        <div>
                                            {{-- YOIN DIGITAL --}}
                                            <template x-if="b.slug === 'yoin-digital'">
                                                <div class="flex flex-col items-center drop-shadow-sm">
                                                    <h3 class="text-3xl font-black tracking-tight text-[#005952]">YOIN</h3>
                                                    <span class="text-[9px] font-bold tracking-[0.3em] text-[#005952] uppercase -mt-1">DIGITAL</span>
                                                </div>
                                            </template>

                                            {{-- AGRONEX --}}
                                            <template x-if="b.slug === 'agronex'">
                                                <div class="flex flex-col items-center drop-shadow-sm">
                                                    <div class="w-8 h-8 mb-1 text-[#005952] flex items-center justify-center">
                                                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                                        </svg>
                                                    </div>
                                                    <h3 class="text-2xl font-black tracking-wide text-gray-900">AGRONEX</h3>
                                                </div>
                                            </template>

                                            {{-- YOIMO --}}
                                            <template x-if="b.slug === 'yoimo'">
                                                <div class="flex flex-col items-center drop-shadow-sm">
                                                    <h3 class="text-2xl font-black tracking-wider text-gray-900">YOIMO</h3>
                                                </div>
                                            </template>

                                            {{-- BUATARA --}}
                                            <template x-if="b.slug === 'buatara'">
                                                <div class="flex items-center gap-1.5 drop-shadow-md">
                                                    <h3 class="text-2xl font-black tracking-widest text-white">BUATARA</h3>
                                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                                        <path d="M12 2l2.4 7.2h7.6l-6 4.8 2.4 7.2-6.4-4.8-6.4 4.8 2.4-7.2-6-4.8h7.6z"/>
                                                    </svg>
                                                </div>
                                            </template>

                                            {{-- YAC --}}
                                            <template x-if="b.slug === 'yota-adiwidya-center' || b.slug === 'yac'">
                                                <div class="flex flex-col items-center drop-shadow-sm">
                                                    <h3 class="text-2xl font-black tracking-wider text-[#005952]">YAC</h3>
                                                    <span class="text-[7.5px] font-bold tracking-[0.24em] text-gray-700 uppercase -mt-0.5">YOIN ADIWIDYA CENTER</span>
                                                </div>
                                            </template>

                                            {{-- Generic / Other Admin-created Brands --}}
                                            <template x-if="!['yoin-digital', 'agronex', 'yoimo', 'buatara', 'yota-adiwidya-center', 'yac'].includes(b.slug)">
                                                <div class="flex flex-col items-center drop-shadow-sm">
                                                    <h3 class="text-2xl font-black tracking-wider text-white drop-shadow-md" x-text="b.logoText"></h3>
                                                    <span x-show="b.logoSub" class="text-[8px] font-bold tracking-[0.2em] text-slate-200 uppercase -mt-0.5 drop-shadow" x-text="b.logoSub"></span>
                                                </div>
                                            </template>
                                        </div>
                                    </template>

                                </div>
                            </div>

                            {{-- CARD BODY CONTENT --}}
                            <div class="p-5 sm:p-6 text-left">
                                <h4 class="text-base sm:text-lg font-extrabold text-gray-950 tracking-tight" x-text="b.name"></h4>
                                <span class="text-xs font-bold mt-0.5 block" :class="b.tagColor" x-text="$store.lang.isEN() ? b.category.en : b.category.id"></span>
                                
                                <p class="text-xs text-gray-600 leading-relaxed mt-2.5 line-clamp-3 font-normal" x-text="$store.lang.isEN() ? b.desc.en : b.desc.id"></p>

                                {{-- Sub-services showcase (from database focus_areas) --}}
                                <div class="mt-4 pt-4 border-t border-gray-100">
                                    <span class="text-[10px] font-bold tracking-wider text-gray-400 uppercase block mb-2" x-text="$store.lang.t('Layanan & Unit Terpadu:', 'Integrated Units & Services:')">
                                        Layanan & Unit Terpadu:
                                    </span>
                                    <div class="flex flex-wrap gap-1.5">
                                        <template x-for="s in b.services" :key="s.name.id">
                                            <span class="px-2 py-0.5 rounded bg-gray-50 border border-gray-200 text-[10px] font-semibold text-gray-700 hover:border-[#005952] hover:text-[#005952] transition-colors">
                                                <span x-text="$store.lang.isEN() ? s.name.en : s.name.id"></span>
                                            </span>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- CARD FOOTER (Explore Button) --}}
                        <div class="px-5 sm:px-6 pb-5 pt-1 text-left border-t border-gray-50 mt-2">
                            <button 
                                @click="activeModalBrand = b"
                                class="inline-flex items-center gap-1.5 text-xs font-bold text-[#005952] hover:text-[#004741] transition-colors group-hover:underline cursor-pointer"
                            >
                                <span x-text="$store.lang.t('Pelajari Lebih Lanjut', 'Explore')">Explore</span>
                                <span class="transform group-hover:translate-x-1 transition-transform">→</span>
                            </button>
                        </div>

                    </div>
                </template>
            </div>

            {{-- Pagination Indicator Dots (When overflowable) --}}
            <div x-show="maxIndex > 0" class="flex items-center justify-center gap-1.5 mt-8">
                <template x-for="idx in Array.from({ length: maxIndex + 1 }, (_, i) => i)" :key="idx">
                    <button 
                        @click="goTo(idx)"
                        :aria-label="'Go to brand slide ' + (idx + 1)"
                        class="h-2 rounded-full transition-all duration-300 cursor-pointer"
                        :class="currentIndex === idx ? 'w-8 bg-[#005952]' : 'w-2 bg-gray-300 hover:bg-gray-400'"
                    ></button>
                </template>
            </div>

        </div>

    </div>

    {{-- ======================================================== --}}
    {{-- DETAIL MODAL (When user clicks 'Explore →' on any brand)  --}}
    {{-- ======================================================== --}}
    <div 
        x-show="activeModalBrand" 
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 overflow-y-auto bg-black/60 backdrop-blur-sm flex items-center justify-center p-4 sm:p-6"
        style="display: none;"
    >
        <div 
            @click.away="activeModalBrand = null"
            class="relative w-full max-w-2xl bg-white rounded-3xl shadow-2xl border border-gray-200 overflow-hidden text-left"
        >
            {{-- Modal Header with Brand Banner --}}
            <div class="relative h-44 sm:h-52 w-full overflow-hidden bg-gray-900">
                <img :src="activeModalBrand?.image" :alt="activeModalBrand?.name" class="w-full h-full object-cover opacity-60">
                <div class="absolute inset-0 bg-gradient-to-t from-gray-950 via-gray-950/40 to-transparent"></div>

                {{-- Close Button --}}
                <button 
                    @click="activeModalBrand = null"
                    :aria-label="$store.lang.t('Tutup Dialog', 'Close Dialog')"
                    class="absolute top-4 right-4 w-9 h-9 rounded-full bg-black/50 hover:bg-black text-white flex items-center justify-center transition-colors cursor-pointer z-20"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <div class="absolute bottom-5 left-6 right-6 text-white">
                    <span class="px-2.5 py-0.5 rounded-full bg-[#004741] text-[10px] font-bold uppercase tracking-wider text-white" x-text="activeModalBrand ? ($store.lang.isEN() ? activeModalBrand.badge.en : activeModalBrand.badge.id) : ''"></span>
                    <h3 class="text-2xl sm:text-3xl font-black mt-1.5 tracking-tight font-sans" x-text="activeModalBrand?.name"></h3>
                    <p class="text-xs text-slate-200 font-medium" x-text="activeModalBrand ? ($store.lang.isEN() ? activeModalBrand.category.en : activeModalBrand.category.id) : ''"></p>
                </div>
            </div>

            {{-- Modal Body --}}
            <div class="p-6 sm:p-8 max-h-[70vh] overflow-y-auto">
                <p class="text-sm text-gray-700 leading-relaxed font-normal" x-text="activeModalBrand ? ($store.lang.isEN() ? activeModalBrand.longDesc.en : activeModalBrand.longDesc.id) : ''"></p>

                {{-- Stats Ribbon --}}
                <div class="grid grid-cols-3 gap-3 my-6 p-4 rounded-2xl bg-gray-50 border border-gray-200/80 text-center">
                    <template x-for="st in activeModalBrand?.stats" :key="st.label.id">
                        <div>
                            <span class="text-base sm:text-lg font-black text-[#005952] block" x-text="st.val"></span>
                            <span class="text-[10px] text-gray-500 font-medium uppercase tracking-wider" x-text="$store.lang.isEN() ? st.label.en : st.label.id"></span>
                        </div>
                    </template>
                </div>

                {{-- Detailed Services & Business Units --}}
                <h5 class="text-xs font-bold tracking-wider text-gray-900 uppercase mb-3" x-text="$store.lang.t('Daftar Unit & Layanan Terintegrasi:', 'List of Integrated Units & Services:')">
                    Daftar Unit & Layanan Terintegrasi:
                </h5>
                <div class="space-y-3">
                    <template x-for="srv in activeModalBrand?.services" :key="srv.name.id">
                        <div class="p-3.5 rounded-xl border border-gray-200 bg-white hover:border-[#005952] transition-colors">
                            <div class="flex items-center justify-between gap-2">
                                <h6 class="text-sm font-bold text-gray-950" x-text="$store.lang.isEN() ? srv.name.en : srv.name.id"></h6>
                                <span class="px-2 py-0.5 rounded bg-slate-100 text-[9px] font-bold text-slate-800" x-text="$store.lang.isEN() ? srv.tag.en : srv.tag.id"></span>
                            </div>
                            <p class="text-xs text-gray-600 mt-1 leading-relaxed" x-text="$store.lang.isEN() ? srv.desc.en : srv.desc.id"></p>
                        </div>
                    </template>
                </div>

                {{-- Contact / Action inside Modal --}}
                <div class="mt-8 pt-6 border-t border-gray-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <a 
                        :href="activeModalBrand?.url"
                        class="w-full sm:w-auto px-6 py-2.5 rounded-full border border-[#004741] text-[#004741] hover:bg-[#004741] hover:text-white font-bold text-xs tracking-wider uppercase text-center transition-colors shadow-sm"
                    >
                        <span x-text="$store.lang.t('Lihat Profil Lengkap Brand →', 'View Full Brand Profile →')">Lihat Profil Lengkap Brand →</span>
                    </a>
                    <a 
                        href="#contact" 
                        @click="activeModalBrand = null"
                        class="w-full sm:w-auto px-6 py-2.5 rounded-full bg-[#005952] hover:bg-[#004741] text-white font-bold text-xs tracking-wider uppercase text-center transition-colors shadow-sm"
                    >
                        <span x-text="$store.lang.t('Hubungi Tim Inisiatif →', 'Contact Initiative Team →')">Hubungi Tim Inisiatif →</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

</section>
