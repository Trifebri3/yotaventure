{{-- 
    YOIN Domains Showcase: "Different worlds. One purpose."
    Desain: Nuansa Putih Bersih, Luxury Typography, 50/50 Split Showcase,
    Bilingual (ID & EN), Bebas Emotikon, Tanpa Kata Venture.
    100% Dinamis & Tersinkronisasi dengan Database EcosystemDomain.
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
        'pendidikan' => 'M12 14l9-5-9-5-9 5 9 5z M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z',
        'education' => 'M12 14l9-5-9-5-9 5 9 5z M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z',
    ];

    $domainTabLabels = [
        'digital' => ['id' => 'Digital', 'en' => 'Digital'],
        'agriculture' => ['id' => 'Agrikultur', 'en' => 'Agriculture'],
        'impact' => ['id' => 'Dampak & Sosial', 'en' => 'Impact & ESG'],
        'products' => ['id' => 'Produk & Inovasi', 'en' => 'Products & Innovation'],
        'emerging' => ['id' => 'Riset & Teknologi', 'en' => 'Future & Tech'],
        'pendidikan' => ['id' => 'Pendidikan', 'en' => 'Education'],
        'education' => ['id' => 'Pendidikan', 'en' => 'Education'],
    ];

    $domainEditorialTitles = [
        'digital' => ['id' => 'KEDAULATAN DIGITAL NUSANTARA', 'en' => 'SOVEREIGN DIGITAL ECOSYSTEM'],
        'agriculture' => ['id' => 'HILIRISASI TEKNOLOGI PANGAN', 'en' => 'PRECISION AGRI-TECH CHAIN'],
        'impact' => ['id' => 'MEMBANGUN BERSAMA MASYARAKAT', 'en' => 'BUILDING WITH COMMUNITIES'],
        'products' => ['id' => 'KARYA NYATA BERNILAI TINGGI', 'en' => 'HIGH-VALUE CIRCULAR CRAFT'],
        'emerging' => ['id' => 'RISET MASA DEPAN NUSANTARA', 'en' => 'FRONTIER TECH FOR THE NATION'],
        'pendidikan' => ['id' => 'AKSELERASI GENERASI EMAS', 'en' => 'ACCELERATING NEXT GENERATION'],
        'education' => ['id' => 'AKSELERASI GENERASI EMAS', 'en' => 'ACCELERATING NEXT GENERATION'],
    ];

    $fallbackImages = [
        'digital' => 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=1400&auto=format&fit=crop',
        'agriculture' => 'https://images.unsplash.com/photo-1500651230702-0e2d8a49d4ad?q=80&w=1400&auto=format&fit=crop',
        'impact' => 'https://images.unsplash.com/photo-1511632765486-a01980e01a18?q=80&w=1400&auto=format&fit=crop',
        'products' => 'https://images.unsplash.com/photo-1616486338812-3dadae4b4ace?q=80&w=1400&auto=format&fit=crop',
        'emerging' => 'https://images.unsplash.com/photo-1518770660439-4636190af475?q=80&w=1400&auto=format&fit=crop',
        'pendidikan' => 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?q=80&w=1400&auto=format&fit=crop',
    ];

    $mappedDomains = $domainsSource->map(function ($dom, $index) use ($domainIconMap, $domainTabLabels, $domainEditorialTitles, $fallbackImages) {
        $key = $dom->slug;
        $orderNum = str_pad($dom->sort_order ?: ($index + 1), 2, '0', STR_PAD_LEFT);

        // Tab label
        $tabLabel = [
            'id' => $domainTabLabels[$key]['id'] ?? $dom->name_id,
            'en' => $domainTabLabels[$key]['en'] ?? ($dom->name_en ?: $dom->name_id),
        ];

        // Tag label (Category tag beside circular icon)
        $tag = [
            'id' => str_ireplace('YOTA', 'YOIN', $dom->name_id),
            'en' => str_ireplace('YOTA', 'YOIN', $dom->name_en ?: $dom->name_id),
        ];

        // Headline / Title
        $titleId = !empty($dom->meta_title)
            ? mb_strtoupper($dom->meta_title)
            : ($domainEditorialTitles[$key]['id'] ?? mb_strtoupper(str_ireplace('YOTA', 'YOIN', $dom->tagline_id ?: $dom->name_id)));

        $titleEn = !empty($dom->meta_title)
            ? mb_strtoupper($dom->meta_title)
            : ($domainEditorialTitles[$key]['en'] ?? mb_strtoupper(str_ireplace('YOTA', 'YOIN', $dom->tagline_en ?: ($dom->name_en ?: $dom->name_id))));

        $title = [
            'id' => $titleId,
            'en' => $titleEn,
        ];

        // Description
        $descRawId = $dom->solution_statement_id ?: ($dom->short_description_id ?: ($dom->tagline_id ?: $dom->long_description_id));
        $descRawEn = $dom->solution_statement_en ?: ($dom->short_description_en ?: ($dom->tagline_en ?: $dom->long_description_en));

        $desc = [
            'id' => str_ireplace('YOTA', 'YOIN', $descRawId),
            'en' => str_ireplace('YOTA', 'YOIN', $descRawEn),
        ];

        // Image
        $image = $dom->cover_image ?: ($dom->hero_image ?: (!empty($dom->gallery) ? $dom->gallery[0] : null));
        $image = $image ?: ($fallbackImages[$key] ?? 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=1400&auto=format&fit=crop');

        // Icon
        $iconSvg = $domainIconMap[$key] ?? 'M13 10V3L4 14h7v7l9-11h-7z';
        $iconImage = $dom->icon_image ?: null;

        // Button label and link
        $firstInit = $dom->initiatives->first();
        $brandName = $firstInit ? str_ireplace('YOTA', 'YOIN', $firstInit->name) : ($domainTabLabels[$key]['id'] ?? $dom->name_id);
        $btnText = [
            'id' => 'JELAJAHI ' . mb_strtoupper($brandName),
            'en' => 'EXPLORE ' . mb_strtoupper($brandName),
        ];
        $btnLink = route('public.ecosystem.domain', $dom->slug);

        // Highlight badge (top-left of photo)
        $highlight = $firstInit 
            ? str_ireplace('YOTA', 'YOIN', $firstInit->name) . ' Ecosystem'
            : ($domainTabLabels[$key]['id'] ?? $dom->name_id) . ' Ecosystem';

        return [
            'id' => $dom->slug,
            'num' => $orderNum,
            'tabLabel' => $tabLabel,
            'tag' => $tag,
            'title' => $title,
            'desc' => $desc,
            'image' => $image,
            'iconImage' => $iconImage,
            'iconSvg' => $iconSvg,
            'btnText' => $btnText,
            'btnLink' => $btnLink,
            'highlight' => $highlight,
        ];
    })->values()->toArray();
@endphp

<section 
    id="domains" 
    x-data="{
        activeDomain: 0,
        touchStartX: 0,
        touchEndX: 0,
        domains: @js($mappedDomains),
        get activeItem() {
            return (this.domains && this.domains.length > 0) ? this.domains[this.activeDomain] : {};
        },
        nextDomain() {
            if (!this.domains || this.domains.length === 0) return;
            this.activeDomain = (this.activeDomain + 1) % this.domains.length;
        },
        prevDomain() {
            if (!this.domains || this.domains.length === 0) return;
            this.activeDomain = (this.activeDomain - 1 + this.domains.length) % this.domains.length;
        },
        handleTouchStart(e) {
            this.touchStartX = e.changedTouches[0].screenX;
        },
        handleTouchEnd(e) {
            this.touchEndX = e.changedTouches[0].screenX;
            if (this.touchStartX - this.touchEndX > 50) {
                this.nextDomain();
            } else if (this.touchEndX - this.touchStartX > 50) {
                this.prevDomain();
            }
        }
    }"
    class="relative bg-white py-24 sm:py-32 select-none overflow-hidden border-t border-gray-100"
>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- ======================================================== --}}
        {{-- 1. SECTION HEADER (Different worlds. One purpose.)       --}}
        {{-- ======================================================== --}}
        <div class="text-center max-w-3xl mx-auto mb-12 sm:mb-16">
            
            {{-- Eyebrow with center divider --}}
            <div class="inline-flex items-center gap-3 justify-center mb-3">
                <span class="h-px bg-teal-600/30 w-8 sm:w-12"></span>
                <span 
                    class="text-[11px] sm:text-xs font-bold tracking-[0.24em] text-[#005952] uppercase font-sans"
                    x-text="$store.lang.t('MEMBANGUN LINTAS INDUSTRI NUSANTARA', 'WE\'RE BUILDING ACROSS DIFFERENT WORLDS')"
                >
                    MEMBANGUN LINTAS INDUSTRI NUSANTARA
                </span>
                <span class="h-px bg-teal-600/30 w-8 sm:w-12"></span>
            </div>

            {{-- Main Heading --}}
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black text-gray-900 tracking-tight leading-[1.12] font-sans">
                Different worlds.<br>
                <span class="text-[#005952]">One purpose.</span>
            </h2>

            {{-- Subtitle --}}
            <p 
                class="mt-4 sm:mt-5 text-sm sm:text-base text-gray-600 leading-relaxed font-normal max-w-xl mx-auto"
                x-text="$store.lang.t('Dari solusi digital hingga dampak nyata di tengah masyarakat, kami membangun di berbagai industri dan kemungkinan baru Nusantara.', 'From digital solutions to real community impact, we build across multiple industries and new possibilities.')"
            >
                Dari solusi digital hingga dampak nyata di tengah masyarakat, kami membangun di berbagai industri dan kemungkinan baru Nusantara.
            </p>

        </div>

        {{-- ======================================================== --}}
        {{-- 2. LUXURY DOMAIN SELECTOR TABS                            --}}
        {{-- ======================================================== --}}
        <div class="flex items-center justify-center gap-2 sm:gap-3 overflow-x-auto no-scrollbar pb-2 mb-10 sm:mb-12">
            <template x-for="(dom, idx) in domains" :key="dom.id">
                <button 
                    @click="activeDomain = idx"
                    :class="activeDomain === idx 
                        ? 'bg-[#005952] text-white shadow-md shadow-[#005952]/20 border-[#005952]' 
                        : 'bg-gray-50 hover:bg-gray-100 text-gray-600 hover:text-gray-900 border-gray-200'"
                    class="px-4 sm:px-5 py-2.5 rounded-full border text-xs sm:text-sm font-semibold tracking-wide transition-all duration-300 flex items-center gap-2 whitespace-nowrap cursor-pointer group"
                >
                    <span 
                        class="text-[10px] font-mono opacity-60 group-hover:opacity-100" 
                        x-text="dom.num"
                    ></span>
                    <span x-text="$store.lang.isEN() ? dom.tabLabel.en : dom.tabLabel.id"></span>
                </button>
            </template>
        </div>

        {{-- ======================================================== --}}
        {{-- 3. PAPUA DIVING 50/50 SPLIT SHOWCASE CARD                 --}}
        {{-- ======================================================== --}}
        <div 
            class="relative w-full rounded-2xl sm:rounded-3xl border border-gray-200/90 shadow-xl overflow-hidden bg-white grid grid-cols-1 lg:grid-cols-2 items-stretch min-h-[520px] lg:min-h-[560px]"
            @touchstart="handleTouchStart($event)"
            @touchend="handleTouchEnd($event)"
        >
            
            {{-- LEFT SIDE: Cinematic Full-Height Photography --}}
            <div class="relative w-full h-72 sm:h-96 lg:h-auto min-h-[280px] lg:min-h-full overflow-hidden bg-gray-950">
                <template x-for="(dom, idx) in domains" :key="'img-' + dom.id">
                    <div 
                        x-show="activeDomain === idx"
                        x-transition:enter="transition-opacity duration-700 ease-out"
                        x-transition:enter-start="opacity-0 scale-105"
                        x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition-opacity duration-400 ease-in"
                        x-transition:leave-start="opacity-100 scale-100"
                        x-transition:leave-end="opacity-0 scale-98"
                        class="absolute inset-0 w-full h-full"
                    >
                        <img 
                            :src="dom.image" 
                            :alt="$store.lang.isEN() ? dom.title.en : dom.title.id"
                            class="w-full h-full object-cover object-center"
                        />
                        <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent lg:hidden"></div>
                    </div>
                </template>

                {{-- Left Corner Badge on Image --}}
                <div class="absolute top-5 left-5 z-10">
                    <template x-for="(dom, idx) in domains" :key="'badge-' + dom.id">
                        <span 
                            x-show="activeDomain === idx"
                            x-text="dom.highlight"
                            class="px-3.5 py-1.5 rounded-full bg-black/50 backdrop-blur-md border border-white/20 text-white font-medium text-[11px] tracking-wider uppercase drop-shadow"
                        ></span>
                    </template>
                </div>

                {{-- Image Navigation Controls --}}
                <div class="absolute bottom-5 right-5 z-10 flex items-center gap-2">
                    <button 
                        @click="prevDomain()" 
                        :aria-label="$store.lang.t('Domain Sebelumnya', 'Previous Domain')"
                        class="w-9 h-9 rounded-full bg-black/60 hover:bg-[#005952] border border-white/20 text-white flex items-center justify-center backdrop-blur-md shadow-lg transition-all duration-200 hover:scale-105 active:scale-95 cursor-pointer"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    <button 
                        @click="nextDomain()" 
                        :aria-label="$store.lang.t('Domain Berikutnya', 'Next Domain')"
                        class="w-9 h-9 rounded-full bg-black/60 hover:bg-[#005952] border border-white/20 text-white flex items-center justify-center backdrop-blur-md shadow-lg transition-all duration-200 hover:scale-105 active:scale-95 cursor-pointer"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
            </div>

            {{-- RIGHT SIDE: Papua Diving Style (Watermark, Tag & Icon, Title, Description, Button) --}}
            <div class="relative p-8 sm:p-12 lg:p-16 flex flex-col justify-center bg-white overflow-hidden text-left">
                
                {{-- Watermark Background --}}
                <div class="absolute -right-16 -bottom-16 w-96 h-96 pointer-events-none opacity-[0.04] text-[#005952]">
                    <svg viewBox="0 0 200 200" fill="currentColor" class="w-full h-full">
                        <path d="M45,20 C55,40 70,60 85,80 C100,100 110,130 115,160 C100,140 80,120 60,105 C40,90 30,60 45,20 Z" />
                        <path d="M110,35 C125,55 145,75 160,100 C140,110 120,100 105,85 C95,70 95,50 110,35 Z" />
                        <circle cx="150" cy="40" r="14" />
                    </svg>
                </div>

                {{-- Domain Dynamic Content --}}
                <template x-for="(dom, idx) in domains" :key="'text-' + dom.id">
                    <div 
                        x-show="activeDomain === idx"
                        x-transition:enter="transition-all duration-500 ease-out"
                        x-transition:enter-start="opacity-0 translate-y-4"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition-all duration-200 ease-in"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 -translate-y-2"
                        class="relative z-10 flex flex-col justify-between h-full"
                    >
                        <div>
                            {{-- Circular Icon Badge & Category Tag --}}
                            <div class="flex items-center gap-3.5 mb-6">
                                <div class="w-10 h-10 rounded-full bg-[#005952] text-white flex items-center justify-center shadow-md shadow-[#005952]/20 shrink-0 overflow-hidden">
                                    <template x-if="dom.iconImage">
                                        <img :src="dom.iconImage" :alt="dom.tabLabel.id" class="w-full h-full object-cover p-1.5 rounded-full" />
                                    </template>
                                    <template x-if="!dom.iconImage">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="dom.iconSvg" />
                                        </svg>
                                    </template>
                                </div>
                                <span 
                                    x-text="$store.lang.isEN() ? dom.tag.en : dom.tag.id"
                                    class="text-xs sm:text-sm font-semibold tracking-wide text-gray-500 uppercase font-sans"
                                ></span>
                            </div>

                            {{-- Editorial Uppercase Headline --}}
                            <h3 
                                x-text="$store.lang.isEN() ? dom.title.en : dom.title.id"
                                class="text-2xl sm:text-3xl lg:text-[36px] font-extrabold text-gray-900 tracking-tight leading-[1.15] sm:leading-[1.12] font-sans"
                            ></h3>

                            {{-- Description --}}
                            <p 
                                x-text="$store.lang.isEN() ? dom.desc.en : dom.desc.id"
                                class="mt-4 sm:mt-6 text-sm sm:text-base text-gray-600 leading-relaxed font-normal max-w-lg"
                            ></p>
                        </div>

                        {{-- CTA Button --}}
                        <div class="mt-8 sm:mt-12 flex items-center gap-4">
                            <a 
                                :href="dom.btnLink" 
                                class="inline-flex items-center justify-center px-7 sm:px-8 py-3.5 sm:py-4 bg-[#005952] hover:bg-[#004741] text-white font-bold text-xs sm:text-sm tracking-[0.16em] uppercase rounded shadow-sm hover:shadow-lg hover:shadow-[#005952]/20 transition-all duration-300 hover:scale-[1.02] active:scale-98"
                            >
                                <span x-text="$store.lang.isEN() ? dom.btnText.en : dom.btnText.id"></span>
                            </a>

                            <span class="text-xs font-mono text-gray-400">
                                <span class="text-gray-900 font-bold" x-text="String(activeDomain + 1).padStart(2, '0')"></span> / <span x-text="String(domains.length).padStart(2, '0')"></span>
                            </span>
                        </div>

                    </div>
                </template>

            </div>

        </div>

    </div>
</section>
