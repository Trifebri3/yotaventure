@php
    $navUnreadCollabs = \App\Models\CollaborationInquiry::unread()->count();
@endphp

<nav x-data="{ open: false }" class="bg-white border-b border-gray-200/90 sticky top-0 z-40 select-none shadow-xs">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            
            <div class="flex items-center gap-6">
                <!-- YOIN Brand Logo -->
                <div class="shrink-0 flex items-center gap-3">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5 group">
                        <img 
                            src="{{ asset('logo.png') }}" 
                            alt="YOIN Super Admin" 
                            class="h-8 sm:h-9 w-auto object-contain transition-transform group-hover:scale-105"
                        >
                        <div class="hidden xl:flex flex-col text-left border-l border-gray-200 pl-2.5">
                            <span class="text-[11px] font-black tracking-wider text-gray-900 leading-none uppercase">Super Admin</span>
                            <span class="text-[9px] font-semibold text-[#005952] leading-tight">Ecosystem Intelligence</span>
                        </div>
                    </a>
                </div>

                <!-- Desktop Navigation Links (Grouped & Clean) -->
                <div class="hidden lg:flex items-center space-x-1 xl:space-x-2">
                    
                    {{-- 1. DASHBOARD & ANALITIK --}}
                    <a 
                        href="{{ route('dashboard') }}" 
                        class="px-3 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-2 {{ request()->routeIs('dashboard') || request()->routeIs('admin.dashboard') ? 'bg-[#005952] text-white shadow-xs' : 'text-gray-600 hover:text-gray-950 hover:bg-gray-100' }}"
                    >
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        <span>Dashboard</span>
                        <span class="w-1.5 h-1.5 rounded-full {{ request()->routeIs('dashboard') || request()->routeIs('admin.dashboard') ? 'bg-teal-300' : 'bg-emerald-500 animate-pulse' }}"></span>
                    </a>

                    {{-- 2. DROPDOWN: EKOSISTEM & DAMPAK --}}
                    <div 
                        x-data="{ dropEco: false }" 
                        @mouseenter="dropEco = true" 
                        @mouseleave="dropEco = false"
                        class="relative"
                    >
                        <button 
                            @click="dropEco = !dropEco"
                            type="button"
                            class="px-3 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-1.5 cursor-pointer focus:outline-none {{ request()->routeIs('admin.ecosystem.*') ? 'bg-teal-50 text-[#005952] border border-teal-200/80' : 'text-gray-600 hover:text-gray-950 hover:bg-gray-100' }}"
                        >
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                            <span>Ekosistem</span>
                            <svg class="w-3 h-3 transition-transform" :class="dropEco ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                        </button>

                        <div 
                            x-show="dropEco" 
                            x-cloak
                            x-transition:enter="transition ease-out duration-150"
                            x-transition:enter-start="opacity-0 translate-y-1 scale-95"
                            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                            x-transition:leave="transition ease-in duration-100"
                            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                            x-transition:leave-end="opacity-0 translate-y-1 scale-95"
                            @click.outside="dropEco = false"
                            class="absolute left-0 top-full pt-1.5 w-60 z-50"
                        >
                            <div class="bg-white rounded-2xl shadow-xl border border-gray-200/90 p-2 ring-1 ring-black/5 text-left">
                                <a 
                                    href="{{ route('admin.ecosystem.index') }}" 
                                    class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-bold text-gray-700 hover:bg-gray-50 hover:text-[#005952] transition-colors"
                                >
                                    <svg class="w-4 h-4 text-[#005952]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                                    <div>
                                        <div>Domain & Inisiatif</div>
                                        <div class="text-[10px] font-normal text-gray-400">Kelola brand portofolio</div>
                                    </div>
                                </a>
                                <a 
                                    href="{{ route('admin.ecosystem.index', ['tab' => 'impact']) }}" 
                                    class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-bold text-gray-700 hover:bg-gray-50 hover:text-[#005952] transition-colors"
                                >
                                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"/></svg>
                                    <div>
                                        <div>Pilar Dampak & ESG</div>
                                        <div class="text-[10px] font-normal text-gray-400">Metrik kemanusiaan</div>
                                    </div>
                                </a>
                                <a 
                                    href="{{ route('admin.ecosystem.index', ['tab' => 'clients']) }}" 
                                    class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-bold text-gray-700 hover:bg-gray-50 hover:text-[#005952] transition-colors"
                                >
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>
                                    <div>
                                        <div>Mitra & Klien</div>
                                        <div class="text-[10px] font-normal text-gray-400">Logo marquee & relasi</div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- 3. INSAN & TIM --}}
                    <a 
                        href="{{ route('admin.people.index') }}" 
                        class="px-3 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-1.5 {{ request()->routeIs('admin.people.*') ? 'bg-[#005952] text-white shadow-xs' : 'text-gray-600 hover:text-gray-950 hover:bg-gray-100' }}"
                    >
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <span>Insan & Tim</span>
                    </a>

                    {{-- 4. DROPDOWN: PUBLIKASI & RISET --}}
                    <div 
                        x-data="{ dropArticles: false }" 
                        @mouseenter="dropArticles = true" 
                        @mouseleave="dropArticles = false"
                        class="relative"
                    >
                        <button 
                            @click="dropArticles = !dropArticles"
                            type="button"
                            class="px-3 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-1.5 cursor-pointer focus:outline-none {{ request()->routeIs('admin.articles.*') || request()->routeIs('admin.article-categories.*') ? 'bg-teal-50 text-[#005952] border border-teal-200/80' : 'text-gray-600 hover:text-gray-950 hover:bg-gray-100' }}"
                        >
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                            </svg>
                            <span>Publikasi & Riset</span>
                            <svg class="w-3 h-3 transition-transform" :class="dropArticles ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                        </button>

                        <div 
                            x-show="dropArticles" 
                            x-cloak
                            x-transition:enter="transition ease-out duration-150"
                            x-transition:enter-start="opacity-0 translate-y-1 scale-95"
                            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                            x-transition:leave="transition ease-in duration-100"
                            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                            x-transition:leave-end="opacity-0 translate-y-1 scale-95"
                            @click.outside="dropArticles = false"
                            class="absolute left-0 top-full pt-1.5 w-60 z-50"
                        >
                            <div class="bg-white rounded-2xl shadow-xl border border-gray-200/90 p-2 ring-1 ring-black/5 text-left">
                                <a 
                                    href="{{ route('admin.articles.index') }}" 
                                    class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-bold text-gray-700 hover:bg-gray-50 hover:text-[#005952] transition-colors"
                                >
                                    <svg class="w-4 h-4 text-[#005952]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    <div>
                                        <div>Semua Publikasi</div>
                                        <div class="text-[10px] font-normal text-gray-400">Artikel & wawasan industri</div>
                                    </div>
                                </a>
                                <a 
                                    href="{{ route('admin.article-categories.index') }}" 
                                    class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-bold text-gray-700 hover:bg-gray-50 hover:text-[#005952] transition-colors"
                                >
                                    <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                                    <div>
                                        <div>Kategori & Galeri Dayan</div>
                                        <div class="text-[10px] font-normal text-gray-400">Taksonomi artikel</div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- 5. KELOLA KOLABORASI --}}
                    <a 
                        href="{{ route('admin.collaborations.index') }}" 
                        class="px-3 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-1.5 {{ request()->routeIs('admin.collaborations.*') ? 'bg-[#005952] text-white shadow-xs' : 'text-gray-600 hover:text-gray-950 hover:bg-gray-100' }}"
                    >
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
                        </svg>
                        <span>Kolaborasi</span>
                        @if($navUnreadCollabs > 0)
                            <span class="px-1.5 py-0.5 rounded-full bg-rose-500 text-white text-[10px] font-black">
                                {{ $navUnreadCollabs }}
                            </span>
                        @endif
                    </a>

                    {{-- 6. DROPDOWN: PENGATURAN & PROFIL --}}
                    <div 
                        x-data="{ dropSettings: false }" 
                        @mouseenter="dropSettings = true" 
                        @mouseleave="dropSettings = false"
                        class="relative"
                    >
                        <button 
                            @click="dropSettings = !dropSettings"
                            type="button"
                            class="px-3 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-1.5 cursor-pointer focus:outline-none {{ request()->routeIs('admin.company-profile.*') || request()->routeIs('admin.achievements.*') || request()->routeIs('admin.invest.*') || request()->routeIs('admin.menu-highlights.*') ? 'bg-teal-50 text-[#005952] border border-teal-200/80' : 'text-gray-600 hover:text-gray-950 hover:bg-gray-100' }}"
                        >
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            <span>Lembaga</span>
                            <svg class="w-3 h-3 transition-transform" :class="dropSettings ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                        </button>

                        <div 
                            x-show="dropSettings" 
                            x-cloak
                            x-transition:enter="transition ease-out duration-150"
                            x-transition:enter-start="opacity-0 translate-y-1 scale-95"
                            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                            x-transition:leave="transition ease-in duration-100"
                            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                            x-transition:leave-end="opacity-0 translate-y-1 scale-95"
                            @click.outside="dropSettings = false"
                            class="absolute right-0 top-full pt-1.5 w-64 z-50"
                        >
                            <div class="bg-white rounded-2xl shadow-xl border border-gray-200/90 p-2 ring-1 ring-black/5 text-left">
                                <a 
                                    href="{{ route('admin.company-profile.edit') }}" 
                                    class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-bold text-gray-700 hover:bg-gray-50 hover:text-[#005952] transition-colors"
                                >
                                    <svg class="w-4 h-4 text-[#005952]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                    <div>
                                        <div>Profil Perusahaan</div>
                                        <div class="text-[10px] font-normal text-gray-400">Visi, misi & legalitas holding</div>
                                    </div>
                                </a>
                                <a 
                                    href="{{ route('admin.achievements.index') }}" 
                                    class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-bold text-gray-700 hover:bg-gray-50 hover:text-[#005952] transition-colors"
                                >
                                    <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                                    <div>
                                        <div>Pencapaian & Sertifikasi</div>
                                        <div class="text-[10px] font-normal text-gray-400">Penghargaan & audit mutu</div>
                                    </div>
                                </a>
                                <a 
                                    href="{{ route('admin.invest.edit') }}" 
                                    class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-bold text-gray-700 hover:bg-gray-50 hover:text-[#005952] transition-colors"
                                >
                                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                                    <div>
                                        <div>Investasi & Sinergi</div>
                                        <div class="text-[10px] font-normal text-gray-400">Peluang modal & investor</div>
                                    </div>
                                </a>
                                <a 
                                    href="{{ route('admin.menu-highlights.index') }}" 
                                    class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-bold text-gray-700 hover:bg-gray-50 hover:text-[#005952] transition-colors"
                                >
                                    <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    <div>
                                        <div>Kartu Menu Header</div>
                                        <div class="text-[10px] font-normal text-gray-400">Visual navigasi publik</div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Right Actions: Web Link & User Profile -->
            <div class="hidden sm:flex sm:items-center sm:gap-3">
                
                {{-- Quick Link to Public Web --}}
                <a 
                    href="{{ url('/') }}" 
                    target="_blank" 
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl border border-gray-200 text-xs font-bold text-gray-700 hover:text-[#005952] hover:bg-gray-50 transition-colors shadow-2xs"
                    title="Buka Website Publik di Tab Baru"
                >
                    <span>Web Publik</span>
                    <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                </a>

                <!-- User Profile Dropdown -->
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center gap-2 px-3 py-1.5 border border-gray-200 text-xs font-bold rounded-xl text-gray-700 bg-white hover:bg-gray-50 focus:outline-none transition-colors cursor-pointer shadow-2xs">
                            <div class="w-6 h-6 rounded-full bg-teal-50 text-[#005952] flex items-center justify-center font-black text-xs">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <span>{{ Auth::user()->name }}</span>
                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Pengaturan Akun') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Keluar (Log Out)') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger (Mobile) -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-xl text-gray-500 hover:text-gray-700 hover:bg-gray-100 focus:outline-none transition-colors">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu (Mobile) -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden border-t border-gray-200 bg-white">
        <div class="pt-2 pb-3 space-y-1 px-3">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard') || request()->routeIs('admin.dashboard')">
                {{ __('Dashboard & Analitik') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.ecosystem.index')" :active="request()->routeIs('admin.ecosystem.*') && !request()->fullUrlIs('*tab=clients*') && !request()->fullUrlIs('*tab=impact*')">
                {{ __('Domain & Portofolio Ekosistem') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.ecosystem.index', ['tab' => 'impact'])" :active="request()->fullUrlIs('*tab=impact*')">
                {{ __('Pilar Dampak & ESG') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.ecosystem.index', ['tab' => 'clients'])" :active="request()->fullUrlIs('*tab=clients*')">
                {{ __('Mitra & Klien') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.people.index')" :active="request()->routeIs('admin.people.*')">
                {{ __('Insan & Tim Ekosistem') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.articles.index')" :active="request()->routeIs('admin.articles.*')">
                {{ __('Semua Publikasi & Riset') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.article-categories.index')" :active="request()->routeIs('admin.article-categories.*')">
                {{ __('Kategori & Foto Dayan') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.collaborations.index')" :active="request()->routeIs('admin.collaborations.*')">
                <span class="flex items-center justify-between">
                    <span>{{ __('Kelola Kolaborasi') }}</span>
                    @if($navUnreadCollabs > 0)
                        <span class="px-2 py-0.5 rounded-full bg-rose-500 text-white text-[10px] font-black">
                            {{ $navUnreadCollabs }} Baru
                        </span>
                    @endif
                </span>
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.company-profile.edit')" :active="request()->routeIs('admin.company-profile.*')">
                {{ __('Profil Perusahaan') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.achievements.index')" :active="request()->routeIs('admin.achievements.*')">
                {{ __('Pencapaian & Sertifikat') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.invest.edit')" :active="request()->routeIs('admin.invest.*')">
                {{ __('Investasi & Sinergi Modal') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.menu-highlights.index')" :active="request()->routeIs('admin.menu-highlights.*')">
                {{ __('Kartu Menu Header') }}
            </x-responsive-nav-link>
            <a href="{{ url('/') }}" target="_blank" class="block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-teal-700 hover:text-teal-900 hover:bg-teal-50">
                Lihat Web Publik ↗
            </a>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-3 border-t border-gray-200 px-4 bg-gray-50">
            <div class="font-bold text-sm text-gray-900">{{ Auth::user()->name }}</div>
            <div class="text-xs text-gray-500">{{ Auth::user()->email }}</div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Pengaturan Akun') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Keluar (Log Out)') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
