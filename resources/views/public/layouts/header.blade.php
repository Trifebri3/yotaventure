{{-- 
    YOIN (Inovasi Nusantara) Header
    Transisi Dinamis: Transparan di atas Hero Sinematik -> Putih Bersih saat di-scroll
    Inspirasi: Danantara Utility Bar + Papua Diving Resorts Luxury Aesthetic & 4-Card Mega Menu
    Bebas Emotikon & Tanpa Kata Venture
--}}
<header 
    x-data="{
        scrolled: false,
        megaMenuOpen: false,
        mobileMenuOpen: false,
        searchOpen: false,
        currentLang: 'ID',
        searchQuery: '',
        init() {
            const checkScroll = () => {
                this.scrolled = window.pageYOffset > 25;
            };
            window.addEventListener('scroll', checkScroll);
            checkScroll();
        }
    }"
    @keydown.escape.window="megaMenuOpen = false; mobileMenuOpen = false; searchOpen = false"
    class="fixed top-0 inset-x-0 z-50 transition-all duration-300 font-sans"
>
    {{-- ======================================================== --}}
    {{-- 1. TOP UTILITY BAR (Danantara Style)                     --}}
    {{-- ======================================================== --}}
    <div 
        class="transition-all duration-300 text-xs select-none border-b"
        :class="scrolled 
            ? 'h-0 opacity-0 overflow-hidden py-0 border-transparent' 
            : 'h-auto opacity-100 py-1.5 sm:py-2 bg-black/40 backdrop-blur-md border-white/10 text-white/80'"
    >
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between">
            {{-- Left: Inisiatif & Pilar Holding --}}
            <div class="hidden md:flex items-center space-x-6">
                <a href="{{ route('public.ecosystem.index') }}" class="flex items-center gap-1.5 font-semibold text-emerald-300 hover:text-white transition-colors">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                    YOIN Nusantara
                </a>
                <span class="text-white/30">|</span>
                <a href="{{ route('public.ecosystem.domain', 'digital') }}" class="hover:text-white transition-colors text-white/70">
                    <span x-text="$store.lang.t('Inovasi Digital', 'Digital Innovation')">Inovasi Digital</span>
                </a>
                <span class="text-white/30">|</span>
                <a href="{{ route('public.ecosystem.domain', 'products') }}" class="hover:text-white transition-colors text-white/70">
                    <span x-text="$store.lang.t('YOIN Inovasi', 'YOIN Innovation')">YOIN Inovasi</span>
                </a>
                <span class="text-white/30">|</span>
                <a href="{{ route('public.ecosystem.domain', 'impact') }}" class="hover:text-white transition-colors text-white/70">
                    <span x-text="$store.lang.t('Inisiatif Berkelanjutan', 'Sustainable Initiatives')">Inisiatif Berkelanjutan</span>
                </a>
            </div>

            {{-- Mobile Left Indicator --}}
            <div class="md:hidden flex items-center gap-2 text-[11px] text-emerald-300 font-semibold">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                <span>YOIN Inovasi Nusantara</span>
            </div>

            {{-- Right: Media Center, Bantuan & Language Switcher --}}
            <div class="flex items-center space-x-4 sm:space-x-6 text-[11px] sm:text-xs">
                <a href="{{ route('public.articles.index') }}" class="hidden sm:inline-block hover:text-white transition-colors text-white/70">
                    <span x-text="$store.lang.t('Media Center', 'Media Center')">Media Center</span>
                </a>
                <a href="#contact" class="hidden sm:inline-block hover:text-white transition-colors text-white/70">
                    <span x-text="$store.lang.t('Pusat Bantuan', 'Help Center')">Help Center</span>
                </a>

                {{-- Language Switcher (Connected to Alpine $store.lang) --}}
                <div class="flex items-center bg-white/10 hover:bg-white/15 rounded-full p-0.5 border border-white/20 text-[10px] font-bold tracking-wider select-none">
                    <button 
                        @click="$store.lang.set('ID')" 
                        type="button" 
                        class="px-2.5 py-0.5 rounded-full transition-all duration-200"
                        :class="$store.lang.isID() 
                            ? 'bg-[#005952] text-white shadow-xs' 
                            : 'text-white/70 hover:text-white'"
                    >
                        ID
                    </button>
                    <button 
                        @click="$store.lang.set('EN')" 
                        type="button" 
                        class="px-2.5 py-0.5 rounded-full transition-all duration-200"
                        :class="$store.lang.isEN() 
                            ? 'bg-[#005952] text-white shadow-xs' 
                            : 'text-white/70 hover:text-white'"
                    >
                        EN
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- ======================================================== --}}
    {{-- 2. MAIN NAVIGATION BAR                                   --}}
    {{-- ======================================================== --}}
    <nav 
        class="transition-all duration-300 border-b"
        :class="scrolled 
            ? 'bg-white/95 backdrop-blur-md shadow-xs border-gray-200/90 py-3 text-gray-900' 
            : 'bg-black/30 backdrop-blur-md border-white/10 py-4 sm:py-4.5 text-white'"
    >
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between">
            
            {{-- LOGO SECTION (YOIN) --}}
            <a href="{{ url('/') }}" class="flex items-center gap-3 group focus:outline-none select-none">
                <img 
                    src="{{ asset('logo.png') }}" 
                    alt="YOIN Inovasi Nusantara" 
                    class="h-9 sm:h-11 w-auto object-contain transition-transform duration-200 group-hover:scale-105"
                    :class="scrolled ? '' : 'brightness-0 invert'"
                >
            </a>

            {{-- DESKTOP MENU ITEMS --}}
            <div class="hidden lg:flex items-center space-x-6 xl:space-x-7">
                {{-- 0. BERANDA (HOME) --}}
                <a 
                    href="{{ url('/') }}" 
                    class="relative text-[13px] font-bold tracking-wide transition-colors py-1 group flex items-center gap-1.5"
                    :class="scrolled ? 'text-gray-900 hover:text-[#004741]' : 'text-white hover:text-white/90'"
                >
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span x-text="$store.lang.t('Beranda', 'Home')">Beranda</span>
                    <span 
                        class="absolute bottom-0 left-0 w-0 h-[2px] transition-all duration-200 group-hover:w-full"
                        :class="scrolled ? 'bg-[#004741]' : 'bg-white'"
                    ></span>
                </a>

                <a 
                    href="{{ route('public.ecosystem.index') }}" 
                    class="relative text-[13px] font-medium tracking-wide transition-colors py-1 group"
                    :class="scrolled ? 'text-gray-700 hover:text-[#004741]' : 'text-white/90 hover:text-white'"
                >
                    <span x-text="$store.lang.t('Ekosistem', 'Ecosystem')">Ekosistem</span>
                    <span 
                        class="absolute bottom-0 left-0 w-0 h-[2px] transition-all duration-200 group-hover:w-full"
                        :class="scrolled ? 'bg-[#004741]' : 'bg-white'"
                    ></span>
                </a>

                {{-- DROPDOWN: TENTANG KAMI (Profil, Invest, Story) --}}
                <div 
                    x-data="{ aboutDropdown: false }" 
                    @mouseenter="aboutDropdown = true" 
                    @mouseleave="aboutDropdown = false"
                    class="relative py-1"
                >
                    <button 
                        @click="aboutDropdown = !aboutDropdown"
                        type="button"
                        class="relative text-[13px] font-medium tracking-wide transition-colors group flex items-center gap-1 cursor-pointer focus:outline-none"
                        :class="scrolled ? 'text-gray-700 hover:text-[#005952]' : 'text-white/90 hover:text-white'"
                    >
                        <span x-text="$store.lang.t('Tentang Kami', 'About Us')">Tentang Kami</span>
                        <svg class="w-3.5 h-3.5 transition-transform duration-200 opacity-70 group-hover:opacity-100" :class="aboutDropdown ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                        </svg>
                        <span 
                            class="absolute bottom-0 left-0 w-0 h-[2px] transition-all duration-200 group-hover:w-full"
                            :class="scrolled ? 'bg-[#004741]' : 'bg-white'"
                        ></span>
                    </button>

                    {{-- Dropdown Panel --}}
                    <div 
                        x-show="aboutDropdown"
                        x-cloak
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                        x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                        @click.outside="aboutDropdown = false"
                        class="absolute left-1/2 -translate-x-1/2 top-full pt-2.5 w-64 z-50 select-none"
                    >
                        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-2 text-left ring-1 ring-black/5 overflow-hidden">
                            
                            {{-- 1. PROFIL --}}
                            <a 
                                href="{{ route('public.about.profile') }}" 
                                class="flex items-start gap-3 p-2.5 rounded-xl hover:bg-gray-50 transition-colors group/item"
                            >
                                <div class="w-8 h-8 rounded-lg bg-teal-50 text-[#005952] flex items-center justify-center shrink-0 group-hover/item:bg-[#005952] group-hover/item:text-white transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="text-xs font-bold text-gray-900 group-hover/item:text-[#005952] transition-colors flex items-center justify-between">
                                        <span x-text="$store.lang.t('Profil', 'Profile')">Profil</span>
                                        <span class="text-[10px] text-gray-400 group-hover/item:text-[#005952] group-hover/item:translate-x-0.5 transition-all">→</span>
                                    </div>
                                    <p class="text-[10px] text-gray-500 leading-snug mt-0.5" x-text="$store.lang.t('Profil Perusahaan & Ekosistem', 'Company Profile & Ecosystem')">
                                        Profil Perusahaan & Ekosistem
                                    </p>
                                </div>
                            </a>

                            {{-- 2. INVEST --}}
                            <a 
                                href="{{ route('public.about.invest') }}" 
                                class="flex items-start gap-3 p-2.5 rounded-xl hover:bg-gray-50 transition-colors group/item"
                            >
                                <div class="w-8 h-8 rounded-lg bg-teal-50 text-[#005952] flex items-center justify-center shrink-0 group-hover/item:bg-[#005952] group-hover/item:text-white transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="text-xs font-bold text-gray-900 group-hover/item:text-[#005952] transition-colors flex items-center justify-between">
                                        <span x-text="$store.lang.t('Invest', 'Invest')">Invest</span>
                                        <span class="text-[10px] text-gray-400 group-hover/item:text-[#005952] group-hover/item:translate-x-0.5 transition-all">→</span>
                                    </div>
                                    <p class="text-[10px] text-gray-500 leading-snug mt-0.5" x-text="$store.lang.t('Peluang Investasi & Sinergi Modal', 'Investment Opportunities & Capital')">
                                        Peluang Investasi & Sinergi Modal
                                    </p>
                                </div>
                            </a>

                            {{-- 3. PENCAPAIAN --}}
                            <a 
                                href="{{ route('public.about.achievements') }}" 
                                class="flex items-start gap-3 p-2.5 rounded-xl hover:bg-gray-50 transition-colors group/item"
                            >
                                <div class="w-8 h-8 rounded-lg bg-teal-50 text-[#005952] flex items-center justify-center shrink-0 group-hover/item:bg-[#005952] group-hover/item:text-white transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="text-xs font-bold text-gray-900 group-hover/item:text-[#005952] transition-colors flex items-center justify-between">
                                        <span x-text="$store.lang.t('Pencapaian', 'Achievements')">Pencapaian</span>
                                        <span class="text-[10px] text-gray-400 group-hover/item:text-[#005952] group-hover/item:translate-x-0.5 transition-all">→</span>
                                    </div>
                                    <p class="text-[10px] text-gray-500 leading-snug mt-0.5" x-text="$store.lang.t('Penghargaan, Sertifikasi & Rekam Jejak', 'Awards, Certifications & Milestones')">
                                        Penghargaan, Sertifikasi & Rekam Jejak
                                    </p>
                                </div>
                            </a>

                        </div>
                    </div>
                </div>

                {{-- DROPDOWN: INSAN & TIM (Founder, Kisah Novel, Tim Inti, Kontributor, Mitra) --}}
                <div 
                    x-data="{ peopleDropdown: false }" 
                    @mouseenter="peopleDropdown = true" 
                    @mouseleave="peopleDropdown = false"
                    class="relative py-1"
                >
                    <button 
                        @click="peopleDropdown = !peopleDropdown"
                        type="button"
                        class="relative text-[13px] font-medium tracking-wide transition-colors group flex items-center gap-1 cursor-pointer focus:outline-none"
                        :class="scrolled ? 'text-gray-700 hover:text-[#005952]' : 'text-white/90 hover:text-white'"
                    >
                        <span x-text="$store.lang.t('Insan & Tim', 'People & Team')">Insan & Tim</span>
                        <svg class="w-3.5 h-3.5 transition-transform duration-200 opacity-70 group-hover:opacity-100" :class="peopleDropdown ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                        </svg>
                        <span 
                            class="absolute bottom-0 left-0 w-0 h-[2px] transition-all duration-200 group-hover:w-full"
                            :class="scrolled ? 'bg-[#004741]' : 'bg-white'"
                        ></span>
                    </button>

                    <div 
                        x-show="peopleDropdown"
                        x-cloak
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                        x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                        @click.outside="peopleDropdown = false"
                        class="absolute left-1/2 -translate-x-1/2 top-full pt-2.5 w-72 z-50 select-none"
                    >
                        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-2 text-left ring-1 ring-black/5 overflow-hidden">
                            
                            {{-- 1. IKHTISAR INSAN --}}
                            <a 
                                href="{{ route('public.people.index') }}" 
                                class="flex items-start gap-3 p-2 rounded-xl hover:bg-gray-50 transition-colors group/item"
                            >
                                <div class="w-7 h-7 rounded-lg bg-teal-50 text-[#005952] flex items-center justify-center shrink-0 group-hover/item:bg-[#005952] group-hover/item:text-white transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="text-xs font-bold text-gray-900 group-hover/item:text-[#005952] transition-colors flex items-center justify-between">
                                        <span x-text="$store.lang.t('Ikhtisar Insan', 'People Overview')">Ikhtisar Insan</span>
                                        <span class="text-[10px] text-gray-400 group-hover/item:text-[#005952]">→</span>
                                    </div>
                                    <p class="text-[10px] text-gray-500 leading-snug" x-text="$store.lang.t('Pintu gerbang direktori kepemimpinan', 'Gateway to leadership directory')">Pintu gerbang direktori kepemimpinan</p>
                                </div>
                            </a>

                            {{-- 2. FOUNDER --}}
                            <a 
                                href="{{ route('public.people.founder.index') }}" 
                                class="flex items-start gap-3 p-2 rounded-xl hover:bg-gray-50 transition-colors group/item"
                            >
                                <div class="w-7 h-7 rounded-lg bg-teal-50 text-[#005952] flex items-center justify-center shrink-0 group-hover/item:bg-[#005952] group-hover/item:text-white transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="text-xs font-bold text-gray-900 group-hover/item:text-[#005952] transition-colors flex items-center justify-between">
                                        <span x-text="$store.lang.t('Pendiri (Founders)', 'Co-Founders')">Pendiri (Founders)</span>
                                        <span class="text-[10px] text-gray-400 group-hover/item:text-[#005952]">→</span>
                                    </div>
                                    <p class="text-[10px] text-gray-500 leading-snug" x-text="$store.lang.t('Profil estetika & kutipan filosofi', 'Aesthetic profile & philosophy')">Profil estetika & kutipan filosofi</p>
                                </div>
                            </a>

                            {{-- 3. MANIFES & KISAH PENDIRI (EXECUTIVE INSIGHTS) --}}
                            <a 
                                href="{{ route('public.people.storyfounder.index') }}" 
                                class="flex items-start gap-3 p-2 rounded-xl hover:bg-gray-50 transition-colors group/item"
                            >
                                <div class="w-7 h-7 rounded-lg bg-teal-50 text-[#005952] flex items-center justify-center shrink-0 group-hover/item:bg-[#005952] group-hover/item:text-white transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="text-xs font-bold text-gray-900 group-hover/item:text-[#005952] transition-colors flex items-center justify-between">
                                        <span x-text="$store.lang.t('Manifes & Kisah Pendiri', 'Executive Memoirs & Insights')">Manifes & Kisah Pendiri</span>
                                        <span class="text-[10px] text-gray-400 group-hover/item:text-[#005952]">→</span>
                                    </div>
                                    <p class="text-[10px] text-gray-500 leading-snug" x-text="$store.lang.t('Esai strategis & rekam jejak kepemimpinan', 'Strategic essays & leadership trajectory')">Esai strategis & rekam jejak kepemimpinan</p>
                                </div>
                            </a>

                            {{-- 4. TIM INTI --}}
                            <a 
                                href="{{ route('public.people.tim.index') }}" 
                                class="flex items-start gap-3 p-2 rounded-xl hover:bg-gray-50 transition-colors group/item"
                            >
                                <div class="w-7 h-7 rounded-lg bg-teal-50 text-[#005952] flex items-center justify-center shrink-0 group-hover/item:bg-[#005952] group-hover/item:text-white transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="text-xs font-bold text-gray-900 group-hover/item:text-[#005952] transition-colors flex items-center justify-between">
                                        <span x-text="$store.lang.t('Tim Inti Ekosistem', 'Core Team')">Tim Inti Ekosistem</span>
                                        <span class="text-[10px] text-gray-400 group-hover/item:text-[#005952]">→</span>
                                    </div>
                                    <p class="text-[10px] text-gray-500 leading-snug" x-text="$store.lang.t('Talenta aktif & terikat ke brand', 'Active talent bound to ventures')">Talenta aktif & terikat ke brand</p>
                                </div>
                            </a>

                            {{-- 5. KONTRIBUTOR --}}
                            <a 
                                href="{{ route('public.people.kontributor.index') }}" 
                                class="flex items-start gap-3 p-2 rounded-xl hover:bg-gray-50 transition-colors group/item"
                            >
                                <div class="w-7 h-7 rounded-lg bg-teal-50 text-[#005952] flex items-center justify-center shrink-0 group-hover/item:bg-[#005952] group-hover/item:text-white transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" /></svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="text-xs font-bold text-gray-900 group-hover/item:text-[#005952] transition-colors flex items-center justify-between">
                                        <span x-text="$store.lang.t('Kontributor & Talenta', 'Contributors & Talents')">Kontributor & Talenta</span>
                                        <span class="text-[10px] text-gray-400 group-hover/item:text-[#005952]">→</span>
                                    </div>
                                    <p class="text-[10px] text-gray-500 leading-snug" x-text="$store.lang.t('Magang, riset kampus & fellowship', 'Interns, academic researchers & fellows')">Magang, riset kampus & fellowship</p>
                                </div>
                            </a>

                            {{-- 6. MITRA KOLABORATOR --}}
                            <a 
                                href="{{ route('public.people.mitra.index') }}" 
                                class="flex items-start gap-3 p-2 rounded-xl hover:bg-gray-50 transition-colors group/item"
                            >
                                <div class="w-7 h-7 rounded-lg bg-teal-50 text-[#005952] flex items-center justify-center shrink-0 group-hover/item:bg-[#005952] group-hover/item:text-white transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" /></svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="text-xs font-bold text-gray-900 group-hover/item:text-[#005952] transition-colors flex items-center justify-between">
                                        <span x-text="$store.lang.t('Mitra Kolaborator', 'Collaborating Partners')">Mitra Kolaborator</span>
                                        <span class="text-[10px] text-gray-400 group-hover/item:text-[#005952]">→</span>
                                    </div>
                                    <p class="text-[10px] text-gray-500 leading-snug" x-text="$store.lang.t('Logo mitra sinkron ke ekosistem', 'Partner logos synced to ecosystem')">Logo mitra sinkron ke ekosistem</p>
                                </div>
                            </a>

                        </div>
                    </div>
                </div>

                <a 
                    href="{{ route('public.impact.index') }}" 
                    class="relative text-[13px] font-medium tracking-wide transition-colors py-1 group"
                    :class="scrolled ? 'text-gray-700 hover:text-[#005952]' : 'text-white/90 hover:text-white'"
                >
                    <span x-text="$store.lang.t('Dampak & ESG', 'Impact & ESG')">Dampak & ESG</span>
                    <span 
                        class="absolute bottom-0 left-0 w-0 h-[2px] transition-all duration-200 group-hover:w-full"
                        :class="scrolled ? 'bg-[#004741]' : 'bg-white'"
                    ></span>
                </a>

                <a 
                    href="{{ route('public.collaboration.index') }}" 
                    class="relative text-[13px] font-medium tracking-wide transition-colors py-1 group"
                    :class="scrolled ? 'text-gray-700 hover:text-[#004741]' : 'text-white/90 hover:text-white'"
                >
                    <span x-text="$store.lang.t('Kolaborasi', 'Collaboration')">Kolaborasi</span>
                    <span 
                        class="absolute bottom-0 left-0 w-0 h-[2px] transition-all duration-200 group-hover:w-full"
                        :class="scrolled ? 'bg-[#004741]' : 'bg-white'"
                    ></span>
                </a>

                <a 
                    href="{{ route('public.articles.index') }}" 
                    class="relative text-[13px] font-medium tracking-wide transition-colors py-1 group"
                    :class="scrolled ? 'text-gray-700 hover:text-[#004741]' : 'text-white/90 hover:text-white'"
                >
                    <span x-text="$store.lang.t('Jurnal & Publikasi', 'Journal & Publications')">Jurnal & Publikasi</span>
                    <span 
                        class="absolute bottom-0 left-0 w-0 h-[2px] transition-all duration-200 group-hover:w-full"
                        :class="scrolled ? 'bg-[#004741]' : 'bg-white'"
                    ></span>
                </a>
            </div>

            {{-- RIGHT CONTROLS: Language Switcher (Scrolled/Persistent) + Search + Outline CTA + Circular Hamburger --}}
            <div class="flex items-center space-x-2.5 sm:space-x-4">
                
                {{-- Language Switcher in Main Nav (Always accessible) --}}
                <div 
                    class="flex items-center rounded-full p-0.5 text-[10px] font-bold tracking-wider select-none transition-all duration-300"
                    :class="scrolled 
                        ? 'bg-gray-100 border border-gray-300' 
                        : 'bg-white/15 border border-white/25'"
                >
                    <button 
                        @click="$store.lang.set('ID')" 
                        type="button" 
                        class="px-2 sm:px-2.5 py-0.5 rounded-full transition-all duration-200 cursor-pointer"
                        :class="$store.lang.isID() 
                            ? (scrolled ? 'bg-[#005952] text-white shadow-xs' : 'bg-[#005952] text-white shadow-xs') 
                            : (scrolled ? 'text-gray-600 hover:text-gray-900' : 'text-white/70 hover:text-white')"
                    >
                        ID
                    </button>
                    <button 
                        @click="$store.lang.set('EN')" 
                        type="button" 
                        class="px-2 sm:px-2.5 py-0.5 rounded-full transition-all duration-200 cursor-pointer"
                        :class="$store.lang.isEN() 
                            ? (scrolled ? 'bg-[#005952] text-white shadow-xs' : 'bg-[#005952] text-white shadow-xs') 
                            : (scrolled ? 'text-gray-600 hover:text-gray-900' : 'text-white/70 hover:text-white')"
                    >
                        EN
                    </button>
                </div>

                {{-- Search Trigger --}}
                <button 
                    @click="searchOpen = true"
                    type="button" 
                    aria-label="Pencarian YOIN"
                    class="p-2 rounded-full transition-colors focus:outline-none cursor-pointer"
                    :class="scrolled ? 'text-gray-600 hover:text-[#005952] hover:bg-gray-100' : 'text-white/80 hover:text-white hover:bg-white/10'"
                    title="Pencarian"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>

                {{-- Papua Dive Clean Outline Button --}}
                <a 
                    href="#contact" 
                    class="hidden sm:inline-flex items-center justify-center px-4 py-2 text-xs font-semibold tracking-widest uppercase transition-all duration-200"
                    :class="scrolled 
                        ? 'border border-gray-800 text-gray-900 hover:bg-gray-900 hover:text-white' 
                        : 'border border-white/80 text-white hover:bg-white hover:text-gray-900 backdrop-blur-xs'"
                >
                    <span x-text="$store.lang.t('Hubungi Kami', 'Contact Us')">Hubungi Kami</span>
                </a>

                {{-- Signature Papua Dive + YOIN Circular Hamburger Button (Solid) --}}
                <button 
                    @click="megaMenuOpen = !megaMenuOpen" 
                    type="button" 
                    aria-label="Buka Menu"
                    class="group relative flex items-center justify-center w-10 h-10 rounded-full bg-[#004741] hover:bg-black text-white shadow-sm transition-transform duration-200 hover:scale-105 focus:outline-none border border-white/20 cursor-pointer"
                >
                    <div class="w-4 h-3.5 relative flex flex-col justify-between items-center">
                        <span 
                            class="w-full h-0.5 bg-white rounded-full transition-all duration-300"
                            :class="megaMenuOpen ? 'rotate-45 translate-y-1.5' : ''"
                        ></span>
                        <span 
                            class="w-full h-0.5 bg-white rounded-full transition-all duration-300"
                            :class="megaMenuOpen ? 'opacity-0 scale-x-0' : ''"
                        ></span>
                        <span 
                            class="w-full h-0.5 bg-white rounded-full transition-all duration-300"
                            :class="megaMenuOpen ? '-rotate-45 -translate-y-1.5' : ''"
                        ></span>
                    </div>
                </button>

            </div>
        </div>
    </nav>

    {{-- ======================================================== --}}
    {{-- 3. SIGNATURE MEGA MENU (DEEP OBSIDIAN LUXURY AESTHETIC)   --}}
    {{-- ======================================================== --}}
    {{-- 3. SIGNATURE MEGA MENU (PAPUA DIVING / DAYAN AESTHETIC)   --}}
    {{-- Clean White Background, 4 Square Cards, Database-Driven   --}}
    {{-- ======================================================== --}}
    <div 
        x-show="megaMenuOpen" 
        x-cloak 
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 -translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2"
        class="fixed inset-0 top-0 z-50 overflow-y-auto border-b border-gray-200 text-gray-900 shadow-2xl"
        style="background-color: #ffffff !important; color: #111827 !important;"
    >
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 min-h-screen flex flex-col justify-between">
            
            {{-- Top Modal Bar: Logo + Mega Menu Switcher + Close MENU Button --}}
            <div class="flex items-center justify-between border-b border-gray-200 pb-5">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('logo.png') }}" alt="YOIN" class="h-10 w-auto object-contain">
                    <span class="text-xs font-mono font-bold tracking-[0.25em] text-[#005952] uppercase hidden sm:inline-block">YOIN INOVASI NUSANTARA</span>
                </div>

                <div class="flex items-center gap-4">
                    {{-- Mega Menu Language Switcher --}}
                    <div class="flex items-center bg-gray-100 rounded-full p-0.5 border border-gray-300 text-xs font-bold tracking-wider select-none">
                        <button 
                            @click="$store.lang.set('ID')" 
                            type="button" 
                            class="px-3 py-1 rounded-full transition-all duration-200 cursor-pointer"
                            :class="$store.lang.isID() 
                                ? 'bg-[#005952] text-white shadow-xs' 
                                : 'text-gray-600 hover:text-gray-900'"
                        >
                            ID
                        </button>
                        <button 
                            @click="$store.lang.set('EN')" 
                            type="button" 
                            class="px-3 py-1 rounded-full transition-all duration-200 cursor-pointer"
                            :class="$store.lang.isEN() 
                                ? 'bg-[#005952] text-white shadow-xs' 
                                : 'text-gray-600 hover:text-gray-900'"
                        >
                            EN
                        </button>
                    </div>

                    {{-- Close Button (Dayan / Papua Dive Style) --}}
                    <button 
                        @click="megaMenuOpen = false" 
                        type="button" 
                        class="flex items-center gap-2 px-4 py-1.5 border border-gray-400 hover:border-gray-900 text-xs font-bold tracking-widest text-gray-900 uppercase transition-all duration-200 hover:bg-gray-100 cursor-pointer"
                    >
                        <span x-text="$store.lang.t('MENU', 'MENU')">MENU</span>
                        <svg class="w-4 h-4 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Main Mega Menu Body: Left Links & 4 Feature Showcase Cards --}}
            <div class="py-8 grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
                
                {{-- Left Navigation List --}}
                <div class="lg:col-span-4 flex flex-col space-y-5 text-left">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-[#005952]"></span>
                        <span class="text-xs font-mono font-bold tracking-[0.25em] text-[#005952] uppercase" x-text="$store.lang.t('NAVIGASI UTAMA', 'MAIN NAVIGATION')">NAVIGASI UTAMA</span>
                    </div>
                    
                    <nav class="flex flex-col space-y-1">
                        {{-- 0. BERANDA (HOME) --}}
                        <div class="py-2 border-b border-gray-100 space-y-1">
                            <div class="flex items-center justify-between">
                                <a 
                                    @click="megaMenuOpen = false" 
                                    href="{{ url('/') }}" 
                                    class="group inline-block"
                                >
                                    <span class="text-lg sm:text-xl font-black text-gray-950 group-hover:text-[#004741] group-hover:translate-x-1.5 transition-transform tracking-tight block flex items-center gap-2">
                                        <svg class="w-4 h-4 text-[#004741]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                        </svg>
                                        <span x-text="$store.lang.t('BERANDA', 'HOME')">BERANDA</span>
                                    </span>
                                    <span class="text-[11px] text-gray-400 group-hover:text-gray-600 block font-normal mt-0.5" x-text="$store.lang.t('Halaman Utama Ekosistem Holding', 'Holding Ecosystem Homepage')">
                                        Halaman Utama Ekosistem Holding
                                    </span>
                                </a>
                                <a 
                                    @click="megaMenuOpen = false" 
                                    href="{{ url('/') }}" 
                                    class="text-xs font-bold text-gray-400 hover:text-[#004741] transition-colors"
                                >
                                    <span x-text="$store.lang.t('Buka', 'Open')">Buka</span> →
                                </a>
                            </div>
                        </div>

                        {{-- 1. EKOSISTEM --}}
                        <div class="py-2 border-b border-gray-100 space-y-1.5">
                            <div class="flex items-center justify-between">
                                <a 
                                    @click="megaMenuOpen = false" 
                                    href="{{ route('public.ecosystem.index') }}" 
                                    class="group inline-block"
                                >
                                    <span class="text-lg sm:text-xl font-black text-gray-900 group-hover:text-[#005952] group-hover:translate-x-1.5 transition-transform tracking-tight block" x-text="$store.lang.t('EKOSISTEM', 'ECOSYSTEM')">
                                        EKOSISTEM
                                    </span>
                                    <span class="text-[11px] text-gray-400 group-hover:text-gray-600 block font-normal mt-0.5" x-text="$store.lang.t('Direktori Inisiatif, Brand & Portofolio', 'Initiatives, Brands & Portfolio Directory')">
                                        Direktori Inisiatif, Brand & Portofolio
                                    </span>
                                </a>
                                <a 
                                    @click="megaMenuOpen = false" 
                                    href="{{ route('public.ecosystem.index') }}" 
                                    class="text-xs text-gray-400 hover:text-[#005952] transition-colors"
                                >
                                    <span x-text="$store.lang.t('Lihat', 'View')">Lihat</span> →
                                </a>
                            </div>
                            <div class="flex flex-wrap items-center gap-2 pt-1">
                                <a 
                                    @click="megaMenuOpen = false" 
                                    href="{{ route('public.ecosystem.index') }}" 
                                    class="px-3 py-1 rounded-md bg-slate-100 hover:bg-[#004741] hover:text-white text-slate-700 text-[11px] font-bold transition-all border border-slate-200 shadow-xs"
                                >
                                    <span x-text="$store.lang.t('Direktori Domain', 'Domain Directory')">Direktori Domain</span>
                                </a>
                                <a 
                                    @click="megaMenuOpen = false" 
                                    href="{{ route('public.portfolio.index') }}" 
                                    class="px-3 py-1 rounded-md bg-slate-100 hover:bg-[#004741] hover:text-white text-slate-700 text-[11px] font-bold transition-all border border-slate-200 shadow-xs"
                                >
                                    <span x-text="$store.lang.t('Indeks Portofolio', 'Portfolio Index')">Indeks Portofolio</span>
                                </a>
                            </div>
                        </div>

                        {{-- 2. TENTANG KAMI (DENGAN 3 SUB-MENU: PROFIL, INVEST, PENCAPAIAN) --}}
                        <div class="py-2.5 border-b border-gray-100 space-y-2">
                            <div class="flex items-center justify-between">
                                <a 
                                    @click="megaMenuOpen = false" 
                                    href="{{ route('public.about.profile') }}" 
                                    class="group inline-block"
                                >
                                    <span class="text-lg sm:text-xl font-black text-gray-900 group-hover:text-[#004741] group-hover:translate-x-1.5 transition-transform tracking-tight block" x-text="$store.lang.t('TENTANG KAMI', 'ABOUT US')">
                                        TENTANG KAMI
                                    </span>
                                    <span class="text-[11px] text-gray-400 group-hover:text-gray-600 block font-normal mt-0.5" x-text="$store.lang.t('Profil Perusahaan, Investasi & Pencapaian', 'Company Profile, Investment & Achievements')">
                                        Profil Perusahaan, Investasi & Pencapaian
                                    </span>
                                </a>
                                <a 
                                    @click="megaMenuOpen = false" 
                                    href="{{ route('public.about.profile') }}" 
                                    class="text-xs text-gray-400 hover:text-[#004741] transition-colors"
                                >
                                    <span x-text="$store.lang.t('Lihat', 'View')">Lihat</span> →
                                </a>
                            </div>
                            <div class="flex flex-wrap items-center gap-2 pt-1">
                                <a 
                                    @click="megaMenuOpen = false" 
                                    href="{{ route('public.about.profile') }}" 
                                    class="px-3 py-1 rounded-md bg-slate-100 hover:bg-[#004741] hover:text-white text-slate-700 text-[11px] font-bold transition-all border border-slate-200 shadow-xs"
                                >
                                    <span x-text="$store.lang.t('Profil', 'Profile')">Profil</span>
                                </a>
                                <a 
                                    @click="megaMenuOpen = false" 
                                    href="{{ route('public.about.invest') }}" 
                                    class="px-3 py-1 rounded-md bg-slate-100 hover:bg-[#004741] hover:text-white text-slate-700 text-[11px] font-bold transition-all border border-slate-200 shadow-xs"
                                >
                                    <span x-text="$store.lang.t('Invest', 'Invest')">Invest</span>
                                </a>
                                <a 
                                    @click="megaMenuOpen = false" 
                                    href="{{ route('public.about.achievements') }}" 
                                    class="px-3 py-1 rounded-md bg-slate-100 hover:bg-[#004741] hover:text-white text-slate-700 text-[11px] font-bold transition-all border border-slate-200 shadow-xs"
                                >
                                    <span x-text="$store.lang.t('Pencapaian', 'Achievements')">Pencapaian</span>
                                </a>
                            </div>
                        </div>

                        {{-- INSAN & TIM (FOUNDER, STORY, TIM INTI, KONTRIBUTOR, MITRA) --}}
                        <div class="py-2 border-b border-gray-100 space-y-2">
                            <div class="flex items-center justify-between">
                                <a 
                                    @click="megaMenuOpen = false" 
                                    href="{{ route('public.people.index') }}" 
                                    class="group inline-block"
                                >
                                    <span class="text-lg sm:text-xl font-black text-gray-900 group-hover:text-[#004741] transition-colors tracking-tight block" x-text="$store.lang.t('INSAN & TIM', 'PEOPLE & TEAM')">
                                        INSAN & TIM
                                    </span>
                                    <span class="text-[11px] text-gray-400 group-hover:text-gray-600 block font-normal mt-0.5" x-text="$store.lang.t('Dewan Pendiri, Manifes & Esai, Tim Inti & Kontributor', 'Founders, Executive Memoirs, Core Team & Contributors')">
                                        Dewan Pendiri, Manifes & Esai, Tim Inti & Kontributor
                                    </span>
                                </a>
                                <a 
                                    @click="megaMenuOpen = false" 
                                    href="{{ route('public.people.index') }}" 
                                    class="text-xs text-gray-400 hover:text-[#004741] transition-colors"
                                >
                                    <span x-text="$store.lang.t('Lihat Direktori', 'View All')">Lihat Direktori</span> →
                                </a>
                            </div>

                            <div class="flex flex-wrap items-center gap-1.5 pt-1">
                                <a 
                                    @click="megaMenuOpen = false" 
                                    href="{{ route('public.people.founder.index') }}" 
                                    class="px-3 py-1 rounded-md bg-slate-100 hover:bg-[#004741] hover:text-white text-slate-700 text-[11px] font-bold transition-all border border-slate-200 shadow-xs"
                                >
                                    <span x-text="$store.lang.t('Pendiri', 'Founders')">Pendiri</span>
                                </a>
                                <a 
                                    @click="megaMenuOpen = false" 
                                    href="{{ route('public.people.storyfounder.index') }}" 
                                    class="px-3 py-1 rounded-md bg-slate-100 hover:bg-[#004741] hover:text-white text-slate-700 text-[11px] font-bold transition-all border border-slate-200 shadow-xs"
                                >
                                    <span x-text="$store.lang.t('Manifes & Kisah', 'Manifesto & Stories')">Manifes & Kisah</span>
                                </a>
                                <a 
                                    @click="megaMenuOpen = false" 
                                    href="{{ route('public.people.tim.index') }}" 
                                    class="px-3 py-1 rounded-md bg-slate-100 hover:bg-[#004741] hover:text-white text-slate-700 text-[11px] font-bold transition-all border border-slate-200 shadow-xs"
                                >
                                    <span x-text="$store.lang.t('Tim Inti', 'Core Team')">Tim Inti</span>
                                </a>
                                <a 
                                    @click="megaMenuOpen = false" 
                                    href="{{ route('public.people.kontributor.index') }}" 
                                    class="px-3 py-1 rounded-md bg-slate-100 hover:bg-[#004741] hover:text-white text-slate-700 text-[11px] font-bold transition-all border border-slate-200 shadow-xs"
                                >
                                    <span x-text="$store.lang.t('Kontributor', 'Contributors')">Kontributor</span>
                                </a>
                                <a 
                                    @click="megaMenuOpen = false" 
                                    href="{{ route('public.people.mitra.index') }}" 
                                    class="px-3 py-1 rounded-md bg-slate-100 hover:bg-[#004741] hover:text-white text-slate-700 text-[11px] font-bold transition-all border border-slate-200 shadow-xs"
                                >
                                    <span x-text="$store.lang.t('Mitra', 'Partners')">Mitra</span>
                                </a>
                            </div>
                        </div>

                        {{-- 3. DAMPAK & ESG --}}
                        <a 
                            @click="megaMenuOpen = false" 
                            href="{{ route('public.impact.index') }}" 
                            class="group flex items-center justify-between py-2 border-b border-gray-100 hover:border-[#004741] transition-all"
                        >
                            <div>
                                <span class="text-lg sm:text-xl font-black text-gray-900 group-hover:text-[#004741] group-hover:translate-x-1.5 transition-transform tracking-tight block" x-text="$store.lang.t('DAMPAK & ESG', 'IMPACT & ESG')">
                                    DAMPAK & ESG
                                </span>
                                <span class="text-[11px] text-gray-400 group-hover:text-gray-600 block font-normal mt-0.5" x-text="$store.lang.t('Keberlanjutan Lingkungan & Tata Kelola', 'Environmental Sustainability & Governance')">
                                    Keberlanjutan Lingkungan & Tata Kelola
                                </span>
                            </div>
                            <span class="text-xs text-gray-400 group-hover:text-[#004741] transition-colors shrink-0 ml-2">
                                <span x-text="$store.lang.t('Lihat', 'View')">Lihat</span> →
                            </span>
                        </a>

                        {{-- 4. KOLABORASI (DENGAN 6 SUB-MENU) --}}
                        <div class="py-2 border-b border-gray-100 space-y-2">
                            <div class="flex items-center justify-between">
                                <a 
                                    @click="megaMenuOpen = false" 
                                    href="{{ route('public.collaboration.index') }}" 
                                    class="group inline-block"
                                >
                                    <span class="text-lg sm:text-xl font-black text-gray-900 group-hover:text-[#004741] transition-colors tracking-tight block" x-text="$store.lang.t('KOLABORASI', 'COLLABORATION')">
                                        KOLABORASI
                                    </span>
                                    <span class="text-[11px] text-gray-400 group-hover:text-gray-600 block font-normal mt-0.5" x-text="$store.lang.t('Sinergi Multipihak & Inisiatif Terbuka', 'Multi-Stakeholder Synergy & Open Hub')">
                                        Sinergi Multipihak & Inisiatif Terbuka
                                    </span>
                                </a>
                                <a 
                                    @click="megaMenuOpen = false" 
                                    href="{{ route('public.collaboration.index') }}" 
                                    class="text-xs text-gray-400 hover:text-[#004741] transition-colors"
                                >
                                    <span x-text="$store.lang.t('Lihat Hub', 'View Hub')">Lihat Hub</span> →
                                </a>
                            </div>

                            {{-- 6 Sub-Menus for Kolaborasi (Pills) --}}
                            <div class="flex flex-wrap items-center gap-1.5 pt-1">
                                <a 
                                    @click="megaMenuOpen = false" 
                                    href="{{ route('public.collaboration.index') }}#kemitraan" 
                                    class="px-3 py-1 rounded-md bg-slate-100 hover:bg-[#004741] hover:text-white text-slate-700 text-[11px] font-bold transition-all border border-slate-200 shadow-xs"
                                >
                                    <span x-text="$store.lang.t('Kemitraan', 'Partnership')">Kemitraan</span>
                                </a>
                                <a 
                                    @click="megaMenuOpen = false" 
                                    href="{{ route('public.collaboration.index') }}#magang" 
                                    class="px-3 py-1 rounded-md bg-slate-100 hover:bg-[#004741] hover:text-white text-slate-700 text-[11px] font-bold transition-all border border-slate-200 shadow-xs"
                                >
                                    <span x-text="$store.lang.t('Magang', 'Internship')">Magang</span>
                                </a>
                                <a 
                                    @click="megaMenuOpen = false" 
                                    href="{{ route('public.collaboration.index') }}#riset" 
                                    class="px-3 py-1 rounded-md bg-slate-100 hover:bg-[#004741] hover:text-white text-slate-700 text-[11px] font-bold transition-all border border-slate-200 shadow-xs"
                                >
                                    <span x-text="$store.lang.t('Riset', 'Research')">Riset</span>
                                </a>
                                <a 
                                    @click="megaMenuOpen = false" 
                                    href="{{ route('public.collaboration.index') }}#kunjungan" 
                                    class="px-3 py-1 rounded-md bg-slate-100 hover:bg-[#004741] hover:text-white text-slate-700 text-[11px] font-bold transition-all border border-slate-200 shadow-xs"
                                >
                                    <span x-text="$store.lang.t('Kunjungan', 'Visit')">Kunjungan</span>
                                </a>
                                <a 
                                    @click="megaMenuOpen = false" 
                                    href="{{ route('public.collaboration.index') }}#kegiatan" 
                                    class="px-3 py-1 rounded-md bg-slate-100 hover:bg-[#004741] hover:text-white text-slate-700 text-[11px] font-bold transition-all border border-slate-200 shadow-xs"
                                >
                                    <span x-text="$store.lang.t('Kegiatan', 'Events')">Kegiatan</span>
                                </a>
                                <a 
                                    @click="megaMenuOpen = false" 
                                    href="{{ route('public.collaboration.index') }}#project" 
                                    class="px-3 py-1 rounded-md bg-slate-100 hover:bg-[#004741] hover:text-white text-slate-700 text-[11px] font-bold transition-all border border-slate-200 shadow-xs"
                                >
                                    <span x-text="$store.lang.t('Proyek Kolaborasi', 'Collaborative Projects')">Proyek Kolaborasi</span>
                                </a>
                            </div>
                        </div>

                        {{-- 5. JURNAL & PUBLIKASI --}}
                        <a 
                            @click="megaMenuOpen = false" 
                            href="{{ route('public.articles.index') }}" 
                            class="group flex items-center justify-between py-2 border-b border-gray-100 hover:border-[#004741] transition-all"
                        >
                            <div>
                                <span class="text-lg sm:text-xl font-black text-gray-900 group-hover:text-[#004741] group-hover:translate-x-1.5 transition-transform tracking-tight block" x-text="$store.lang.t('JURNAL & PUBLIKASI', 'JOURNAL & PUBLICATIONS')">
                                    JURNAL & PUBLIKASI
                                </span>
                                <span class="text-[11px] text-gray-400 group-hover:text-gray-600 block font-normal mt-0.5" x-text="$store.lang.t('Wawasan Riset & Dokumentasi Terbuka', 'Research Insights & Open Documentation')">
                                    Wawasan Riset & Dokumentasi Terbuka
                                </span>
                            </div>
                            <span class="text-xs text-gray-400 group-hover:text-[#004741] transition-colors shrink-0 ml-2">
                                <span x-text="$store.lang.t('Lihat', 'View')">Lihat</span> →
                            </span>
                        </a>

                        {{-- 6. HUBUNGI KAMI --}}
                        <a 
                            @click="megaMenuOpen = false" 
                            href="{{ url('/#contact') }}" 
                            class="group flex items-center justify-between py-2 border-b border-gray-100 hover:border-[#004741] transition-all"
                        >
                            <div>
                                <span class="text-lg sm:text-xl font-black text-gray-900 group-hover:text-[#004741] group-hover:translate-x-1.5 transition-transform tracking-tight block" x-text="$store.lang.t('HUBUNGI KAMI', 'CONTACT US')">
                                    HUBUNGI KAMI
                                </span>
                                <span class="text-[11px] text-gray-400 group-hover:text-gray-600 block font-normal mt-0.5" x-text="$store.lang.t('Kemitraan, Sinergi & Kantor Resmi', 'Partnerships, Synergy & Official Office')">
                                    Kemitraan, Sinergi & Kantor Resmi
                                </span>
                            </div>
                            <span class="text-xs text-gray-400 group-hover:text-[#004741] transition-colors shrink-0 ml-2">
                                <span x-text="$store.lang.t('Lihat', 'View')">Lihat</span> →
                            </span>
                        </a>
                    </nav>

                    {{-- Office & Corporate Info (High Contrast Dark Gray & Teal) --}}
                    <div class="pt-3 text-xs text-gray-500 space-y-1 border-t border-gray-100">
                        <p class="font-bold text-gray-800 tracking-wide uppercase font-mono" x-text="$store.lang.t('Kantor YOIN:', 'YOIN Office:')">Kantor YOIN:</p>
                        <p class="text-gray-600">Baleendah, Kabupaten Bandung, Jawa Barat 40375</p>
                        <p class="text-[#005952] font-semibold">hello@yotainovasi.id • 0858 6231 9524</p>
                    </div>
                </div>

                {{-- Right: THE 4 SIGNATURE DAYAN/PAPUA DIVING STYLE SQUARE PHOTO CARDS --}}
                <div class="lg:col-span-8">
                    <div class="mb-4 flex items-center justify-between">
                        <span class="text-xs font-bold tracking-widest text-gray-500 uppercase" x-text="$store.lang.t('SOROTAN EKOSISTEM YOIN', 'YOIN ECOSYSTEM HIGHLIGHTS')">
                            SOROTAN EKOSISTEM YOIN
                        </span>
                        <div class="flex items-center gap-3">
                            <span class="text-xs text-gray-400" x-text="$store.lang.t('4 Pilar Utama', '4 Core Pillars')">4 Pilar Utama</span>
                            @auth
                                <a href="{{ route('admin.menu-highlights.index') }}" class="text-[11px] font-bold text-[#005952] hover:underline" title="Kelola Foto di Database">
                                    [Ubah Foto via Database]
                                </a>
                            @endauth
                        </div>
                    </div>

                    {{-- Cards Grid (4 Square Photo Cards matching Dayan / Papua Diving reference image) --}}
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 sm:gap-4">
                        
                        @if(isset($menuHighlights) && $menuHighlights->count() > 0)
                            @foreach($menuHighlights as $card)
                                <a 
                                    @click="megaMenuOpen = false" 
                                    href="{{ str_starts_with($card->link_url, '#') ? url('/'.$card->link_url) : (str_starts_with($card->link_url, '/') ? url($card->link_url) : $card->link_url) }}" 
                                    class="group relative aspect-square sm:h-72 rounded-none overflow-hidden border border-gray-200 shadow-sm flex flex-col justify-end p-4 transition-all duration-300 hover:shadow-xl hover:border-gray-900 bg-gray-950 cursor-pointer"
                                >
                                    {{-- Photo directly from Database --}}
                                    <div 
                                        class="absolute inset-0 bg-cover bg-center transition-transform duration-700 group-hover:scale-105"
                                        style="background-image: url('{{ $card->image_url }}');"
                                    ></div>
                                    
                                    {{-- Elegant Dark Gradient for Text Contrast --}}
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/30 to-transparent group-hover:via-black/20 transition-colors"></div>
                                    
                                    {{-- Bottom Text: Subtitle / Tulisan & Title matching user screenshot --}}
                                    <div class="relative z-10 text-center">
                                        @if($card->subtitle_id)
                                            <span 
                                                class="block text-[10px] text-white/80 font-medium tracking-wider line-clamp-1 mb-1 opacity-90 group-hover:opacity-100 transition-opacity"
                                                x-text="$store.lang.isEN() ? '{{ $card->subtitle_en ?: $card->subtitle_id }}' : '{{ $card->subtitle_id }}'"
                                            >
                                                {{ $card->subtitle_id }}
                                            </span>
                                        @endif
                                        <h4 
                                            class="text-sm sm:text-base font-sans tracking-[0.18em] font-extrabold text-white uppercase group-hover:text-slate-200 transition-colors drop-shadow-md"
                                            x-text="$store.lang.isEN() ? '{{ $card->title_en }}' : '{{ $card->title_id }}'"
                                        >
                                            {{ $card->title_id }}
                                        </h4>
                                    </div>
                                </a>
                            @endforeach
                        @else
                            {{-- Static Fallback --}}
                            <div class="col-span-4 p-8 text-center text-gray-500">Memuat kartu dari database...</div>
                        @endif

                    </div>
                </div>

            </div>

            {{-- Bottom Clean Bar (Papua Dive Style) --}}
            <div class="pt-6 border-t border-gray-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="flex flex-wrap items-center gap-x-6 gap-y-2 text-xs text-gray-500">
                    <a href="{{ route('public.about.profile') }}" @click="megaMenuOpen = false" class="hover:text-[#004741] transition-colors" x-text="$store.lang.t('Tentang PT Yota Inovasi Nusantara', 'About PT Yota Inovasi Nusantara')">Tentang PT Yota Inovasi Nusantara</a>
                    <span class="text-gray-300">|</span>
                    <a href="{{ route('public.legal.terms') }}" @click="megaMenuOpen = false" class="hover:text-[#004741] transition-colors" x-text="$store.lang.t('Syarat & Ketentuan', 'Terms & Conditions')">Syarat & Ketentuan</a>
                    <span class="text-gray-300">|</span>
                    <a href="{{ route('public.legal.privacy') }}" @click="megaMenuOpen = false" class="hover:text-[#004741] transition-colors" x-text="$store.lang.t('Kebijakan Privasi', 'Privacy Policy')">Kebijakan Privasi</a>
                    <span class="text-gray-300">|</span>
                    <a href="{{ route('public.legal.security') }}" @click="megaMenuOpen = false" class="hover:text-[#004741] transition-colors" x-text="$store.lang.t('Keamanan Informasi', 'Information Security')">Keamanan Informasi</a>
                    <span class="text-gray-300">|</span>
                    <a href="{{ url('/#contact') }}" @click="megaMenuOpen = false" class="hover:text-[#004741] transition-colors" x-text="$store.lang.t('Hubungi Kami', 'Contact Us')">Hubungi Kami</a>
                </div>

                <a 
                    href="{{ route('public.ecosystem.index') }}" 
                    @click="megaMenuOpen = false"
                    class="w-full sm:w-auto px-6 py-2.5 bg-[#004741] hover:bg-slate-900 text-white text-xs font-bold tracking-widest uppercase transition-all text-center inline-flex items-center justify-center gap-2 rounded-md shadow-xs"
                >
                    <span x-text="$store.lang.t('Jelajahi Ekosistem YOIN', 'Explore YOIN Ecosystem')">Jelajahi Ekosistem YOIN</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
            </div>

        </div>
    </div>

    {{-- ======================================================== --}}
    {{-- 4. SEARCH OVERLAY POPUP                                  --}}
    {{-- ======================================================== --}}
    <div 
        x-show="searchOpen" 
        x-cloak 
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-4"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-4"
        class="bg-white border-b border-gray-200 shadow-xl py-6 px-4 select-none"
    >
        <div class="max-w-4xl mx-auto">
            <div class="flex items-center justify-between pb-3 mb-3 border-b border-gray-100">
                <span class="text-xs font-bold uppercase tracking-widest text-[#005952]" x-text="$store.lang.t('Pencarian Terpadu YOIN', 'YOIN Unified Search')">Pencarian Terpadu YOIN</span>
                <button 
                    @click="searchOpen = false" 
                    type="button" 
                    class="p-1 rounded text-gray-400 hover:text-gray-900 hover:bg-gray-100 transition-colors"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="mt-4 relative">
                <svg class="w-5 h-5 text-gray-400 absolute left-3.5 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <input 
                    type="text" 
                    x-model="searchQuery" 
                    :placeholder="$store.lang.t('Cari topik, inisiatif, atau riset nusantara...', 'Search topics, initiatives, or research...')" 
                    class="w-full bg-gray-50 border border-gray-200 rounded-lg pl-11 pr-4 py-3 text-gray-900 placeholder-gray-400 focus:outline-none focus:border-[#005952] focus:bg-white text-sm transition-colors"
                    autofocus
                >
            </div>

            {{-- Suggested Tags --}}
            <div class="mt-4 flex flex-wrap items-center gap-2 text-xs">
                <span class="text-gray-500 mr-1" x-text="$store.lang.t('Rekomendasi:', 'Recommended:')">Rekomendasi:</span>
                <button @click="searchQuery = 'Ekosistem IKN'" class="px-2.5 py-1 rounded-full bg-gray-100 border border-gray-200 hover:border-[#005952] text-gray-700 hover:text-[#005952] transition-colors">
                    #Ekosistem IKN
                </button>
                <button @click="searchQuery = 'Inovasi Digital'" class="px-2.5 py-1 rounded-full bg-gray-100 border border-gray-200 hover:border-[#005952] text-gray-700 hover:text-[#005952] transition-colors">
                    #Inovasi Digital
                </button>
                <button @click="searchQuery = 'Impact ESG'" class="px-2.5 py-1 rounded-full bg-gray-100 border border-gray-200 hover:border-[#005952] text-gray-700 hover:text-[#005952] transition-colors">
                    #Impact ESG
                </button>
                <button @click="searchQuery = 'Riset Maritim'" class="px-2.5 py-1 rounded-full bg-gray-100 border border-gray-200 hover:border-[#005952] text-gray-700 hover:text-[#005952] transition-colors">
                    #Riset Maritim
                </button>
            </div>
        </div>
    </div>
</header>
