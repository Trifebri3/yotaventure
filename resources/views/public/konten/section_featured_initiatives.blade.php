{{-- 
    YOIN Featured Strategic Initiatives - Full-Screen Danantara Style Cinematic Slider
    Desain: Full-Screen Bleed, Terhubung Dinamis dengan Basis Data Artikel & Publikasi,
    Bilingual (ID & EN), Bebas Emotikon, Tanpa Kata Venture.
--}}
@php
    $slidesData = [];
    if (isset($featuredArticles) && $featuredArticles->isNotEmpty()) {
        foreach ($featuredArticles as $art) {
            $slidesData[] = [
                'id' => $art->id,
                'tag' => $art->tag ?: 'Inisiatif Strategis • 2026',
                'title' => $art->title,
                'desc' => $art->excerpt ?: Str::limit(strip_tags($art->content), 150),
                'image' => $art->cover_image ?: 'https://images.unsplash.com/photo-1509391365360-2e959784a276?q=80&w=2000&auto=format&fit=crop',
                'link' => route('public.articles.show', $art->slug),
                'badge' => $art->badge ?: 'Inisiatif Unggulan'
            ];
        }
    } else {
        $slidesData = [
            [
                'id' => 1,
                'tag' => 'Inisiatif Strategis • 2026',
                'title' => 'Kedaulatan Energi Terbarukan: Akselerasi Microgrid Tenaga Surya di 34 Titik Kepulauan Nusantara',
                'desc' => 'Penyediaan sistem kelistrikan mandiri terintegrasi berbasis baterai penyimpanan energi untuk ribuan keluarga dan sentra nelayan pesisir.',
                'image' => 'https://images.unsplash.com/photo-1509391365360-2e959784a276?q=80&w=2000&auto=format&fit=crop',
                'link' => route('public.articles.index'),
                'badge' => 'Target 500 MW Bersih'
            ],
            [
                'id' => 2,
                'tag' => 'Kedaulatan Digital • 2026',
                'title' => 'YOIN AI Lab & Sovereign Cloud: Membangun Fondasi Komputasi dan Keamanan Data Nasional',
                'desc' => 'Pusat riset akselerasi kecerdasan buatan berstandar audit industri tertinggi guna melindungi dan memajukan ekosistem ekonomi digital Indonesia.',
                'image' => 'https://images.unsplash.com/photo-1518770660439-4636190af475?q=80&w=2000&auto=format&fit=crop',
                'link' => route('public.articles.index'),
                'badge' => 'Riset AI & Siber Nasional'
            ],
            [
                'id' => 3,
                'tag' => 'Smart City & IKN • 2026',
                'title' => 'Mobilitas Cerdas Rendah Emisi: Penerapan Koridor Transportasi Listrik Komersial Terpadu',
                'desc' => 'Sistem armada logistik dan angkutan massal ramah lingkungan yang dirancang untuk mendukung visi net-zero Ibu Kota Nusantara.',
                'image' => 'https://images.unsplash.com/photo-1519641471654-76ce0107ad1b?q=80&w=2000&auto=format&fit=crop',
                'link' => route('public.articles.index'),
                'badge' => 'Transformasi Hijau IKN'
            ],
            [
                'id' => 4,
                'tag' => 'Logistik Maritim • 2026',
                'title' => 'Konektivitas Pasokan Antar Pulau: Gudang Pendingin Bertenaga Surya & Jalur Logistik Pintar',
                'desc' => 'Digitalisasi rantai pasok maritim yang memangkas disparitas harga komoditas pangan pokok di seluruh penjuru kepulauan Indonesia.',
                'image' => 'https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?q=80&w=2000&auto=format&fit=crop',
                'link' => route('public.articles.index'),
                'badge' => '34 Provinsi Terkoneksi'
            ],
            [
                'id' => 5,
                'tag' => 'Hilirisasi Pangan • 2026',
                'title' => 'AgriTech Presisi Nusantara: Peningkatan Hasil Panen dengan Pemantauan Satelit & Sensor IoT',
                'desc' => 'Inovasi teknologi agrikultur tepat guna yang memberdayakan gabungan kelompok tani lokal untuk mencapai swasembada pangan berkelanjutan.',
                'image' => 'https://images.unsplash.com/photo-1586771107445-d3ca888129ff?q=80&w=2000&auto=format&fit=crop',
                'link' => route('public.articles.index'),
                'badge' => '10.000 Hektar Terkelola'
            ],
            [
                'id' => 6,
                'tag' => 'Ekonomi Biru & Konservasi • 2026',
                'title' => 'Restorasi Terumbu Karang Nusantara & Riset Bioteknologi Kelautan Indonesia Timur',
                'desc' => 'Kolaborasi riset konservasi keanekaragaman hayati bahari dan hilirisasi mikroalga untuk ketahanan ekologi laut jangka panjang.',
                'image' => 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?q=80&w=2000&auto=format&fit=crop',
                'link' => route('public.articles.index'),
                'badge' => 'Konservasi Bahari Nusantara'
            ]
        ];
    }
@endphp

<section 
    id="inisiatif-unggulan" 
    x-data="{
        currentSlide: 0,
        autoplayTimer: null,
        isPaused: false,
        touchStartX: 0,
        touchEndX: 0,
        slides: {{ json_encode($slidesData) }},
        init() {
            this.startAutoplay();
        },
        startAutoplay() {
            this.autoplayTimer = setInterval(() => {
                if (!this.isPaused) {
                    this.next();
                }
            }, 6500);
        },
        stopAutoplay() {
            if (this.autoplayTimer) {
                clearInterval(this.autoplayTimer);
            }
        },
        next() {
            this.currentSlide = (this.currentSlide + 1) % this.slides.length;
        },
        prev() {
            this.currentSlide = (this.currentSlide - 1 + this.slides.length) % this.slides.length;
        },
        goTo(index) {
            this.currentSlide = index;
        },
        handleTouchStart(e) {
            this.touchStartX = e.changedTouches[0].screenX;
        },
        handleTouchEnd(e) {
            this.touchEndX = e.changedTouches[0].screenX;
            if (this.touchStartX - this.touchEndX > 50) {
                this.next();
            } else if (this.touchEndX - this.touchStartX > 50) {
                this.prev();
            }
        }
    }"
    @mouseenter="isPaused = true"
    @mouseleave="isPaused = false"
    class="relative w-full min-h-screen flex items-end overflow-hidden bg-[#021312] select-none"
>
    {{-- ======================================================== --}}
    {{-- FULL-SCREEN BACKGROUND SLIDE IMAGES (Danantara Full-Bleed) --}}
    {{-- ======================================================== --}}
    <template x-for="(slide, index) in slides" :key="slide.id">
        <div 
            x-show="currentSlide === index"
            x-transition:enter="transition-opacity duration-1000 ease-out"
            x-transition:enter-start="opacity-0 scale-105"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition-opacity duration-700 ease-in"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="absolute inset-0 w-full h-full overflow-hidden"
        >
            <img 
                :src="slide.image" 
                :alt="slide.title"
                class="w-full h-full object-cover object-center"
            />
        </div>
    </template>

    {{-- Seamless Top Blend with Hero Section --}}
    <div class="absolute inset-x-0 top-0 h-36 bg-gradient-to-b from-[#021312] via-[#021312]/70 to-transparent pointer-events-none z-10"></div>

    {{-- Cinematic Vignette & Gradient Overlays (High Contrast Text Readability) --}}
    <div class="absolute inset-0 bg-gradient-to-t from-black/95 via-black/55 to-black/20 pointer-events-none z-10"></div>
    <div class="absolute inset-0 bg-gradient-to-r from-black/92 via-black/60 sm:via-black/35 to-transparent pointer-events-none z-10"></div>
    
    {{-- Top Left Watermark & Badge (Danantara Style) --}}
    <div class="absolute top-8 sm:top-12 left-6 sm:left-12 lg:left-16 z-20 flex items-center gap-3">
        <div class="flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-black/45 backdrop-blur-md border border-white/20 text-white text-[11px] font-semibold tracking-wider uppercase">
            <span class="w-2 h-2 rounded-full bg-white animate-pulse"></span>
            <span x-text="$store.lang.t('Inisiatif Unggulan', 'Featured Initiative')">Inisiatif Unggulan</span>
        </div>
        <template x-for="(slide, index) in slides" :key="'badge-' + slide.id">
            <div 
                x-show="currentSlide === index"
                x-transition:enter="transition-opacity duration-500"
                class="hidden sm:inline-block px-3.5 py-1.5 rounded-full bg-[#004741]/90 backdrop-blur-md border border-white/30 text-white text-[11px] font-medium tracking-wide"
            >
                <span x-text="slide.badge"></span>
            </div>
        </template>
    </div>

    {{-- Top Right Floating Arrow Navigation Buttons --}}
    <div class="absolute top-8 sm:top-12 right-6 sm:right-12 lg:right-16 z-20 flex items-center gap-2.5">
        {{-- Prev Arrow --}}
        <button 
            @click="prev()" 
            :aria-label="$store.lang.t('Slide Sebelumnya', 'Previous Slide')"
            class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-black/50 hover:bg-[#004741] border border-white/25 hover:border-white text-white flex items-center justify-center backdrop-blur-md shadow-xl transition-all duration-300 hover:scale-105 active:scale-95 cursor-pointer"
        >
            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </button>

        {{-- Next Arrow --}}
        <button 
            @click="next()" 
            :aria-label="$store.lang.t('Slide Berikutnya', 'Next Slide')"
            class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-black/50 hover:bg-[#004741] border border-white/25 hover:border-white text-white flex items-center justify-center backdrop-blur-md shadow-xl transition-all duration-300 hover:scale-105 active:scale-95 cursor-pointer"
        >
            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </button>
    </div>

    {{-- Main Slide Content Container (Full-Bleed width, bottom aligned) --}}
    <div 
        class="relative z-20 max-w-7xl mx-auto px-6 sm:px-10 lg:px-12 w-full pb-20 sm:pb-24 pt-24"
        @touchstart="handleTouchStart($event)"
        @touchend="handleTouchEnd($event)"
    >
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-8 sm:gap-12">
            
            {{-- Left Content: Category, Judul Besar, Keterangan, Tombol --}}
            <div class="max-w-3xl text-left">
                <template x-for="(slide, index) in slides" :key="'content-' + slide.id">
                    <div 
                        x-show="currentSlide === index"
                        x-transition:enter="transition-all duration-700 ease-out"
                        x-transition:enter-start="opacity-0 translate-y-6"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition-all duration-300 ease-in"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 -translate-y-4"
                    >
                        {{-- Category / Tag --}}
                        <p class="text-xs sm:text-sm font-semibold tracking-wider text-slate-200 uppercase font-sans mb-3 sm:mb-4 flex items-center gap-2">
                            <span x-text="slide.tag"></span>
                        </p>

                        {{-- Judul Besar Editorial --}}
                        <h2 
                            x-text="slide.title"
                            class="text-2xl sm:text-3xl md:text-4xl lg:text-[42px] font-bold text-white tracking-tight leading-[1.18] sm:leading-[1.12] font-sans drop-shadow-sm"
                        ></h2>

                        {{-- Keterangan / Deskripsi Ringkas --}}
                        <p 
                            x-text="slide.desc"
                            class="mt-3.5 sm:mt-5 text-xs sm:text-sm md:text-base text-gray-200/90 leading-relaxed max-w-2xl font-normal"
                        ></p>

                        {{-- Tombol / CTA Button (Danantara 'Learn More →') --}}
                        <div class="mt-6 sm:mt-8 flex flex-wrap items-center gap-4">
                            <a 
                                :href="slide.link" 
                                class="inline-flex items-center gap-3 px-6 sm:px-8 py-3 sm:py-3.5 rounded-full bg-white hover:bg-[#004741] text-gray-950 hover:text-white font-bold text-xs sm:text-sm tracking-wide transition-all duration-300 shadow-xl hover:shadow-black/50 hover:scale-105 group/btn cursor-pointer"
                            >
                                <span x-text="$store.lang.t('Pelajari Selengkapnya', 'Learn More')">Pelajari Selengkapnya</span>
                                <svg class="w-4 h-4 transform group-hover/btn:translate-x-1.5 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </a>

                            <a 
                                href="{{ route('public.ecosystem.index') }}" 
                                class="inline-flex items-center gap-2 px-5 py-3 rounded-full border border-white/35 hover:border-white text-white hover:bg-white/10 font-semibold text-xs sm:text-sm tracking-wide backdrop-blur-sm transition-all duration-200"
                            >
                                <span x-text="$store.lang.t('Lihat Seluruh Ekosistem', 'Explore Ecosystem')">Lihat Seluruh Ekosistem</span>
                            </a>
                        </div>

                    </div>
                </template>
            </div>

            {{-- Right Controls: Danantara Indicators (• ▬ •) & Counter --}}
            <div class="flex flex-col items-start md:items-end gap-3.5 shrink-0 self-start md:self-end">
                {{-- Slide Number Counter: 01 / 06 --}}
                <div class="text-xs font-mono tracking-widest text-white/60">
                    <span class="text-white font-bold text-base" x-text="String(currentSlide + 1).padStart(2, '0')"></span>
                    <span class="text-white/40 mx-1.5">/</span>
                    <span x-text="String(slides.length).padStart(2, '0')"></span>
                </div>

                {{-- Danantara Indicators: Inactive Dots (•) & Active Pill (▬) --}}
                <div class="flex items-center gap-2.5">
                    <template x-for="(slide, index) in slides" :key="'indicator-' + slide.id">
                        <button 
                            @click="goTo(index)"
                            :aria-label="$store.lang.t('Pindah ke slide ' + (index + 1), 'Go to slide ' + (index + 1))"
                            :class="currentSlide === index 
                                ? 'w-10 sm:w-14 bg-white shadow-lg shadow-white/40 h-2.5' 
                                : 'w-2.5 h-2.5 bg-white/40 hover:bg-white/80'"
                            class="rounded-full transition-all duration-500 cursor-pointer"
                        ></button>
                    </template>
                </div>
            </div>

        </div>
    </div>

    {{-- Seamless Bottom Gradient Transition into the Clean White Canvas Below --}}
    <div class="absolute inset-x-0 bottom-0 h-24 sm:h-32 bg-gradient-to-t from-white via-white/80 to-transparent pointer-events-none z-20"></div>

</section>
