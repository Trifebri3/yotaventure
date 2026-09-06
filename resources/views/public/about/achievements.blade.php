@extends('public.layouts.app')

@section('title', ($profile->achievement_title ?: 'Tonggak Cerita, Penghargaan & Pitch Deck').' - PT Yota Inovasi Nusantara')

@section('content')
<div 
    class="bg-white text-gray-900 font-sans pt-28 sm:pt-36 pb-28 select-none min-h-screen"
    x-data="{ 
        activeCategory: 'all', 
        modalOpen: false,
        modalItem: {
            title: '',
            category: '',
            badge: '',
            issuer: '',
            year: '',
            image: '',
            photos: [],
            currentPhotoIndex: 0,
            description: '',
            url: ''
        },
        openItem(item, photoIdx = 0) {
            const photoList = (item.photos && item.photos.length > 0) ? item.photos : (item.image ? [item.image] : []);
            this.modalItem = {
                ...item,
                photos: photoList,
                currentPhotoIndex: photoIdx
            };
            this.modalOpen = true;
        },
        nextModalPhoto() {
            if (this.modalItem.photos && this.modalItem.photos.length > 1) {
                this.modalItem.currentPhotoIndex = (this.modalItem.currentPhotoIndex + 1) % this.modalItem.photos.length;
            }
        },
        prevModalPhoto() {
            if (this.modalItem.photos && this.modalItem.photos.length > 1) {
                this.modalItem.currentPhotoIndex = (this.modalItem.currentPhotoIndex - 1 + this.modalItem.photos.length) % this.modalItem.photos.length;
            }
        },
        closeModal() {
            this.modalOpen = false;
        }
    }"
    @keydown.escape.window="closeModal()"
    @keydown.arrow-right.window="if (modalOpen) nextModalPhoto()"
    @keydown.arrow-left.window="if (modalOpen) prevModalPhoto()"
>

    {{-- Top Breadcrumb & Sub-Navigation Tabs --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-6">
        <nav class="flex items-center gap-2 text-xs text-gray-400 mb-6">
            <a href="{{ url('/') }}" class="hover:text-[#005952] transition-colors" x-text="$store.lang.t('Beranda', 'Home')">Beranda</a>
            <span>/</span>
            <a href="{{ route('public.about.profile') }}" class="hover:text-[#005952] transition-colors" x-text="$store.lang.t('Tentang Kami', 'About Us')">Tentang Kami</a>
            <span>/</span>
            <span class="text-[#005952] font-semibold" x-text="$store.lang.t('Pencapaian & Momen', 'Achievements & Moments')">Pencapaian & Momen</span>
        </nav>

        {{-- Sub-Navigation Pills (Profil, Invest, Pencapaian) --}}
        <div class="flex items-center gap-2 border-b border-gray-100 pb-4">
            <a 
                href="{{ route('public.about.profile') }}" 
                class="px-4 py-2 rounded-full text-xs font-bold transition-all bg-gray-100 text-gray-600 hover:bg-gray-200 flex items-center gap-2"
            >
                <span x-text="$store.lang.t('Profil Perusahaan', 'Company Profile')">Profil Perusahaan</span>
            </a>
            <a 
                href="{{ route('public.about.invest') }}" 
                class="px-4 py-2 rounded-full text-xs font-bold transition-all bg-gray-100 text-gray-600 hover:bg-gray-200 flex items-center gap-2"
            >
                <span x-text="$store.lang.t('Investasi & Sinergi', 'Investment & Capital')">Investasi & Sinergi</span>
            </a>
            <a 
                href="{{ route('public.about.achievements') }}" 
                class="px-4 py-2 rounded-full text-xs font-bold transition-all bg-[#004741] text-white shadow-xs flex items-center gap-2"
            >
                <span class="w-1.5 h-1.5 rounded-full bg-white"></span>
                <span x-text="$store.lang.t('Pencapaian & Momen', 'Achievements & Moments')">Pencapaian & Momen</span>
            </a>
        </div>
    </div>

    {{-- Relaxed & Spacious Editorial Header --}}
    <header class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-left my-10 sm:my-16">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-7 h-7 rounded-full bg-[#005952] text-white flex items-center justify-center shrink-0">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                </svg>
            </div>
            <span class="text-xs sm:text-sm font-semibold tracking-wider text-gray-500 uppercase">
                {{ $profile->achievement_badge ?: 'MOMEN, PENGHARGAAN & PITCH DECK' }}
            </span>
        </div>

        <h1 class="text-3xl sm:text-5xl lg:text-6xl font-light tracking-tight sm:tracking-wide text-gray-900 uppercase leading-[1.15]">
            {{ $profile->achievement_title ?: 'CERITA DI BALIK SETIAP TONGGAK PERJALANAN' }}
        </h1>
        <p class="mt-4 sm:mt-6 text-base sm:text-lg text-gray-600 max-w-3xl leading-relaxed font-normal">
            {{ $profile->achievement_summary ?: 'Koleksi momen nyata, apresiasi penganugerahan founder, dokumen pitch deck resmi, dan sertifikasi yang menandai perjalanan kami membangun kedaulatan teknologi dan dampak kemanusiaan nusantara. Santai dan silakan telusuri.' }}
        </p>

        {{-- Category Filter Pills --}}
        @php
            $categories = $achievements->pluck('category')->unique()->filter()->values();
        @endphp
        @if($categories->count() > 0)
            <div class="flex flex-wrap items-center gap-2.5 mt-8 pt-6 border-t border-gray-100">
                <button 
                    type="button" 
                    @click="activeCategory = 'all'"
                    :class="activeCategory === 'all' ? 'bg-[#005952] text-white shadow-xs' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                    class="px-5 py-2 rounded-full text-xs font-bold transition-all cursor-pointer"
                >
                    <span x-text="$store.lang.t('Semua Momen', 'All Moments')">Semua Momen</span>
                    <span class="ml-1 opacity-75">({{ $achievements->count() }})</span>
                </button>
                @foreach($categories as $cat)
                    @php
                        $count = $achievements->where('category', $cat)->count();
                    @endphp
                    <button 
                        type="button" 
                        @click="activeCategory = '{{ $cat }}'"
                        :class="activeCategory === '{{ $cat }}' ? 'bg-[#005952] text-white shadow-xs' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                        class="px-5 py-2 rounded-full text-xs font-bold transition-all flex items-center gap-1.5 cursor-pointer"
                    >
                        <span>{{ $cat }}</span>
                        <span class="text-[11px] opacity-75">({{ $count }})</span>
                    </button>
                @endforeach
            </div>
        @endif
    </header>

    {{-- EDITORIAL SPLIT LAYOUT SECTIONS WITH MULTI-PHOTO GALLERY --}}
    <main class="w-full space-y-0">
        @if($achievements->isEmpty())
            <div class="max-w-4xl mx-auto px-4 py-20 text-center">
                <div class="w-16 h-16 rounded-full bg-slate-100 text-slate-700 flex items-center justify-center mx-auto mb-4 border border-slate-200">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-1" x-text="$store.lang.t('Belum Ada Dokumentasi Momen', 'No Moments Recorded Yet')">Belum Ada Dokumentasi Momen</h3>
                <p class="text-sm text-gray-500" x-text="$store.lang.t('Dokumentasi foto, sertifikasi, dan pitch deck sedang disiapkan.', 'Photos, certifications, and pitch decks are being prepared.')">Dokumentasi foto, sertifikasi, dan pitch deck sedang disiapkan.</p>
            </div>
        @else
            @foreach($achievements as $index => $item)
                @php
                    $allPhotos = $item->all_photos;
                    if (empty($allPhotos) && !empty($item->image)) {
                        $allPhotos = [$item->image];
                    }
                    $jsonItem = json_encode([
                        'title' => $item->title,
                        'category' => $item->category,
                        'badge' => $item->badge_label ?? '',
                        'issuer' => $item->issuer ?? '',
                        'year' => $item->year ?? '',
                        'image' => $item->image ?? ($allPhotos[0] ?? ''),
                        'photos' => $allPhotos,
                        'description' => $item->description ?? '',
                        'url' => $item->credential_url ?? '',
                    ]);
                    $isPitchDeck = str_contains(strtolower($item->category ?? ''), 'pitch') || str_contains(strtolower($item->badge_label ?? ''), 'pitch');
                    $isAward = str_contains(strtolower($item->category ?? ''), 'penghargaan') || str_contains(strtolower($item->badge_label ?? ''), 'pelopor') || str_contains(strtolower($item->category ?? ''), 'prestasi');
                    $isField = str_contains(strtolower($item->category ?? ''), 'momen') || str_contains(strtolower($item->category ?? ''), 'lapangan');
                    $isEven = ($index % 2 === 1);
                @endphp

                <section 
                    x-show="activeCategory === 'all' || activeCategory === '{{ $item->category }}'"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-data="{ 
                        activePhotoIdx: 0, 
                        photos: {{ json_encode($allPhotos) }},
                        itemData: {{ $jsonItem }}
                    }"
                    class="relative border-b border-gray-100 last:border-0 overflow-hidden py-12 lg:py-16"
                >
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div class="flex flex-col {{ $isEven ? 'lg:flex-row-reverse' : 'lg:flex-row' }} items-center gap-10 lg:gap-16">
                            
                            {{-- FOTO BESAR DENGAN MULTI-PHOTO SLIDER / GALLERY (SPLIT 50%) --}}
                            <div class="w-full lg:w-1/2">
                                <div class="relative">
                                    {{-- Main Photo Frame --}}
                                    <div 
                                        class="relative aspect-4/3 sm:aspect-16/10 rounded-2xl sm:rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-500 cursor-pointer bg-gray-100 group"
                                        @click="openItem(itemData, activePhotoIdx)"
                                    >
                                        <template x-if="photos.length > 0">
                                            <img 
                                                :src="photos[activePhotoIdx]" 
                                                :alt="itemData.title" 
                                                loading="lazy"
                                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
                                            >
                                        </template>
                                        <template x-if="photos.length === 0">
                                            <div class="w-full h-full flex items-center justify-center bg-slate-100 text-slate-400">
                                                <svg class="w-16 h-16 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        </template>

                                        {{-- Soft Hover Overlay --}}
                                        <div class="absolute inset-0 bg-gray-950/30 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center pointer-events-none">
                                            <span class="px-4 py-2 rounded-full bg-white/95 text-[#005952] text-xs font-bold shadow-md flex items-center gap-2 transform translate-y-2 group-hover:translate-y-0 transition-transform">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                                                </svg>
                                                <span x-text="$store.lang.t('Perbesar Foto', 'Enlarge Photo')">Perbesar Foto</span>
                                            </span>
                                        </div>

                                        {{-- Top Badges: Year & Photo Count --}}
                                        <div class="absolute top-4 right-4 z-10 flex items-center gap-2">
                                            <template x-if="photos.length > 1">
                                                <span class="px-2.5 py-1 rounded-full bg-black/70 backdrop-blur-md text-white text-[11px] font-mono font-bold shadow-xs flex items-center gap-1">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                    <span x-text="(activePhotoIdx + 1) + ' / ' + photos.length"></span>
                                                </span>
                                            </template>
                                            @if($item->year)
                                                <span class="px-3 py-1 rounded-full bg-gray-900/80 backdrop-blur-md text-white text-xs font-mono font-bold shadow-xs">
                                                    {{ $item->year }}
                                                </span>
                                            @endif
                                        </div>

                                        {{-- Previous / Next Slider Arrows (Muncul jika ada lebih dari 1 foto) --}}
                                        <template x-if="photos.length > 1">
                                            <div class="absolute inset-y-0 inset-x-2 flex items-center justify-between pointer-events-none">
                                                <button 
                                                    type="button" 
                                                    @click.stop="activePhotoIdx = (activePhotoIdx - 1 + photos.length) % photos.length"
                                                    class="w-9 h-9 rounded-full bg-black/50 hover:bg-black/80 text-white flex items-center justify-center font-bold text-sm pointer-events-auto backdrop-blur-xs transition-all shadow-sm"
                                                    aria-label="Foto Sebelumnya"
                                                >
                                                    ‹
                                                </button>
                                                <button 
                                                    type="button" 
                                                    @click.stop="activePhotoIdx = (activePhotoIdx + 1) % photos.length"
                                                    class="w-9 h-9 rounded-full bg-black/50 hover:bg-black/80 text-white flex items-center justify-center font-bold text-sm pointer-events-auto backdrop-blur-xs transition-all shadow-sm"
                                                    aria-label="Foto Berikutnya"
                                                >
                                                    ›
                                                </button>
                                            </div>
                                        </template>
                                    </div>

                                    {{-- Mini Thumbnails Row for Multiple Photos --}}
                                    <template x-if="photos.length > 1">
                                        <div class="flex items-center gap-2 mt-3 overflow-x-auto pb-1 pt-0.5 px-0.5">
                                            <template x-for="(p, idx) in photos" :key="idx">
                                                <button 
                                                    type="button" 
                                                    @click="activePhotoIdx = idx"
                                                    class="w-14 h-11 sm:w-16 sm:h-12 rounded-xl overflow-hidden border-2 transition-all shrink-0 cursor-pointer"
                                                    :class="activePhotoIdx === idx ? 'border-[#005952] scale-105 shadow-sm ring-2 ring-[#005952]/20' : 'border-transparent opacity-60 hover:opacity-100'"
                                                >
                                                    <img :src="p" class="w-full h-full object-cover">
                                                </button>
                                            </template>
                                        </div>
                                    </template>
                                </div>
                            </div>

                            {{-- KONTEN & CAPTION EDITORIAL (SPLIT 50% - GAYA PERSIS SEPERTI GAMBAR CONTOH) --}}
                            <div class="w-full lg:w-1/2 flex flex-col justify-center text-left relative lg:px-4">
                                
                                {{-- Faint watermark graphic background --}}
                                <div class="absolute -right-8 -top-8 w-64 h-64 text-gray-900/[0.02] pointer-events-none -z-10 hidden sm:block">
                                    <svg viewBox="0 0 200 200" fill="currentColor">
                                        <path d="M45,-75C58,-69,69,-58,76,-45C83,-32,86,-16,84,-1C82,14,75,28,67,41C59,54,50,66,38,73C26,80,11,82,-3,81C-18,79,-36,74,-49,65C-62,56,-70,43,-76,29C-82,15,-86,0,-83,-14C-80,-28,-70,-41,-58,-49C-46,-57,-32,-60,-19,-67C-6,-74,8,-85,23,-88C38,-91,54,-86,45,-75Z" transform="translate(100 100)" />
                                    </svg>
                                </div>

                                {{-- Icon Circle + Category (Mirip bulatan 'Accommodation' di contoh gambar) --}}
                                <div class="flex items-center gap-3.5 mb-5">
                                    <div class="w-10 h-10 rounded-full bg-[#005952] text-white flex items-center justify-center shrink-0 shadow-xs">
                                        @if($isPitchDeck)
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                                            </svg>
                                        @elseif($isAward)
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                            </svg>
                                        @elseif($isField)
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        @else
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                            </svg>
                                        @endif
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="text-sm font-semibold tracking-wide text-gray-500 uppercase">
                                            {{ $item->category }}
                                        </span>
                                        @if($item->badge_label)
                                            <span class="text-gray-300">•</span>
                                            <span class="px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-800 text-[11px] font-bold border border-slate-200">
                                                {{ $item->badge_label }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                {{-- Large Uppercase Title (Mirip 'COMFORT IN THE WILD') --}}
                                <h2 
                                    class="text-2xl sm:text-4xl lg:text-4xl font-normal tracking-[0.06em] text-gray-900 uppercase leading-[1.2] cursor-pointer hover:text-[#005952] transition-colors"
                                    @click="openItem(itemData, activePhotoIdx)"
                                >
                                    {{ $item->title }}
                                </h2>

                                {{-- Issuer note if exists --}}
                                @if($item->issuer)
                                    <div class="mt-2 text-xs font-bold text-[#005952] tracking-wider uppercase">
                                        {{ $item->issuer }}
                                    </div>
                                @endif

                                {{-- Relaxed Caption Paragraph --}}
                                <p class="mt-4 sm:mt-5 text-gray-600 text-sm sm:text-base leading-relaxed max-w-xl font-normal">
                                    {{ $item->description }}
                                </p>

                                {{-- Solid Action Button (Mirip tombol 'VIEW BUNGALOWS' di gambar) --}}
                                <div class="mt-8 flex flex-wrap items-center gap-4">
                                    @if($isPitchDeck && $item->credential_url)
                                        <a 
                                            href="{{ $item->credential_url }}" 
                                            target="_blank" 
                                            class="inline-flex items-center justify-center gap-2 px-7 py-3.5 rounded-md bg-[#005952] hover:bg-[#004741] text-white text-xs font-bold tracking-[0.15em] uppercase shadow-sm hover:shadow-md transition-all cursor-pointer"
                                        >
                                            <span x-text="$store.lang.t('BUKA PITCH DECK', 'VIEW PITCH DECK')">BUKA PITCH DECK</span>
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                            </svg>
                                        </a>
                                    @elseif($item->credential_url)
                                        <a 
                                            href="{{ $item->credential_url }}" 
                                            target="_blank" 
                                            class="inline-flex items-center justify-center gap-2 px-7 py-3.5 rounded-md bg-[#005952] hover:bg-[#004741] text-white text-xs font-bold tracking-[0.15em] uppercase shadow-sm hover:shadow-md transition-all cursor-pointer"
                                        >
                                            <span x-text="$store.lang.t('LIHAT DOKUMEN RESMI', 'VIEW OFFICIAL DOCUMENT')">LIHAT DOKUMEN RESMI</span>
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                            </svg>
                                        </a>
                                    @else
                                        <button 
                                            type="button" 
                                            @click="openItem(itemData, activePhotoIdx)"
                                            class="inline-flex items-center justify-center gap-2 px-7 py-3.5 rounded-md bg-[#005952] hover:bg-[#004741] text-white text-xs font-bold tracking-[0.15em] uppercase shadow-sm hover:shadow-md transition-all cursor-pointer"
                                        >
                                            <span x-text="$store.lang.t('LIHAT DOKUMENTASI', 'VIEW DETAILS')">LIHAT DOKUMENTASI</span>
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                            </svg>
                                        </button>
                                    @endif

                                    {{-- Secondary Button to View Photo if not pitch deck --}}
                                    <button 
                                        type="button" 
                                        @click="openItem(itemData, activePhotoIdx)"
                                        class="text-xs font-bold text-gray-500 hover:text-[#005952] tracking-wider uppercase transition-colors flex items-center gap-1.5 cursor-pointer py-2"
                                    >
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        <span x-text="photos.length > 1 ? $store.lang.t('LIHAT ' + photos.length + ' FOTO', 'VIEW ' + photos.length + ' PHOTOS') : $store.lang.t('DETAIL FOTO', 'PHOTO DETAILS')">
                                            DETAIL FOTO
                                        </span>
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>
                </section>
            @endforeach
        @endif
    </main>

    {{-- Rich Text Narrative Section (Quill Content from Admin) --}}
    @if(!empty($profile->achievement_content_html))
        <section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 my-20">
            <div class="bg-gray-50 rounded-3xl p-8 sm:p-14 border border-gray-100">
                <div class="achievement-narrative-content">
                    {!! $profile->achievement_content_html !!}
                </div>
            </div>
        </section>

        <style>
            .achievement-narrative-content {
                color: #334155;
                font-size: 1.0625rem;
                line-height: 1.85;
            }
            .achievement-narrative-content h2 {
                color: #091e1b;
                font-weight: 700;
                font-size: 1.75rem;
                letter-spacing: -0.01em;
                margin-top: 1.5rem;
                margin-bottom: 1rem;
                line-height: 1.3;
            }
            .achievement-narrative-content h3 {
                color: #005952;
                font-weight: 700;
                font-size: 1.25rem;
                margin-top: 1.5rem;
                margin-bottom: 0.5rem;
            }
            .achievement-narrative-content p {
                margin-bottom: 1.25rem;
            }
            .achievement-narrative-content blockquote {
                border-left: 4px solid #005952;
                background: #f0fdf4;
                color: #14532d;
                padding: 1.25rem 1.75rem;
                margin: 2rem 0;
                border-radius: 0 1rem 1rem 0;
                font-size: 1.125rem;
                font-style: italic;
                line-height: 1.7;
            }
            .achievement-narrative-content ul {
                list-style-type: disc;
                padding-left: 1.75rem;
                margin-bottom: 1.25rem;
            }
            .achievement-narrative-content li {
                margin-bottom: 0.5rem;
            }
            .achievement-narrative-content strong {
                color: #0f172a;
                font-weight: 700;
            }
            .achievement-narrative-content img {
                border-radius: 1.25rem;
                box-shadow: 0 8px 24px rgba(0,0,0,0.06);
                margin: 2rem auto;
                max-width: 100%;
                height: auto;
                display: block;
            }
        </style>
    @endif

    {{-- Bottom Synergy Invitation Strip --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-16">
        <div class="p-8 sm:p-14 rounded-3xl bg-[#004741] text-white shadow-xl flex flex-col md:flex-row items-center justify-between gap-8 text-left">
            <div class="max-w-xl">
                <span class="text-xs font-mono font-bold tracking-widest text-slate-200 uppercase" x-text="$store.lang.t('TERBUKA UNTUK SINERGI & DISKUSI', 'OPEN FOR SYNERGY & DISCUSSION')">
                    TERBUKA UNTUK SINERGI & DISKUSI
                </span>
                <h3 class="text-2xl sm:text-3xl font-light tracking-wide mt-2 uppercase" x-text="$store.lang.t('TERTARIK DENGAN PITCH DECK ATAU RISET KAMI?', 'INTERESTED IN OUR PITCH DECK OR RESEARCH?')">
                    TERTARIK DENGAN PITCH DECK ATAU RISET KAMI?
                </h3>
                <p class="text-xs sm:text-sm text-slate-100 mt-2 leading-relaxed" x-text="$store.lang.t('Kami menyambut hangat diskusi bersama mitra riset, universitas, kementerian, hingga investor yang memiliki kesamaan visi membangun inovasi berdaulat nusantara.', 'We warmly welcome discussions with research partners, universities, ministries, and investors who share the vision of sovereign technology.')">
                    Kami menyambut hangat diskusi bersama mitra riset, universitas, kementerian, hingga calon kolaborator yang memiliki kesamaan visi membangun inovasi berdaulat nusantara.
                </p>
            </div>
            <div class="flex items-center gap-3 shrink-0">
                <a 
                    href="{{ route('public.collaboration.index') }}" 
                    class="px-7 py-3.5 rounded-md bg-white text-slate-950 text-xs font-bold tracking-widest uppercase transition-all shadow-md hover:bg-slate-100"
                    x-text="$store.lang.t('MULAI SINERGI', 'START SYNERGY')"
                >
                    MULAI SINERGI
                </a>
                <a 
                    href="mailto:{{ $profile->contact_email ?: 'hello@yotainovasi.id' }}" 
                    class="px-7 py-3.5 rounded-md bg-black/40 hover:bg-black/70 text-white text-xs font-bold tracking-widest uppercase transition-all border border-white/20"
                    x-text="$store.lang.t('KIRIM EMAIL', 'SEND EMAIL')"
                >
                    KIRIM EMAIL
                </a>
            </div>
        </div>
    </div>

    {{-- LIGHTBOX MODAL PREVIEW DENGAN MULTI-PHOTO GALLERY FLIPPER --}}
    <div 
        x-show="modalOpen" 
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 flex items-center justify-center bg-gray-950/85 backdrop-blur-md p-4 sm:p-6"
        style="display: none;"
    >
        <div 
            class="bg-white rounded-3xl overflow-hidden shadow-2xl max-w-4xl w-full border border-gray-800 flex flex-col max-h-[94vh]"
            @click.outside="closeModal()"
        >
            {{-- Modal Header --}}
            <div class="p-4 sm:p-5 border-b border-gray-100 flex items-center justify-between bg-gray-50">
                <div class="flex items-center gap-3">
                    <span class="text-xs font-bold text-[#005952] uppercase tracking-wider" x-text="modalItem.category"></span>
                    <template x-if="modalItem.badge">
                        <span class="px-2.5 py-0.5 rounded-full bg-teal-100 text-[#005952] text-[10px] font-bold" x-text="modalItem.badge"></span>
                    </template>
                    <template x-if="modalItem.year">
                        <span class="text-xs font-mono font-bold text-gray-400" x-text="modalItem.year"></span>
                    </template>
                </div>
                <button 
                    type="button" 
                    @click="closeModal()" 
                    class="w-9 h-9 rounded-full bg-gray-200 hover:bg-gray-300 text-gray-700 flex items-center justify-center font-bold text-sm cursor-pointer transition-colors"
                    aria-label="Tutup"
                >
                    ✕
                </button>
            </div>

            {{-- Modal Body: Photo Flipper & Caption --}}
            <div class="p-4 sm:p-6 overflow-y-auto flex-1 space-y-4">
                {{-- High-Resolution Photo Container with Previous/Next Arrows --}}
                <div class="relative rounded-2xl overflow-hidden bg-gray-900 flex items-center justify-center min-h-[300px] max-h-[55vh]">
                    <template x-if="modalItem.photos && modalItem.photos.length > 0">
                        <img 
                            :src="modalItem.photos[modalItem.currentPhotoIndex]" 
                            :alt="modalItem.title" 
                            class="w-auto max-h-[55vh] object-contain rounded-xl"
                        >
                    </template>

                    {{-- Navigation Arrows on modal image --}}
                    <template x-if="modalItem.photos && modalItem.photos.length > 1">
                        <div class="absolute inset-y-0 inset-x-3 flex items-center justify-between pointer-events-none">
                            <button 
                                type="button" 
                                @click="prevModalPhoto()"
                                class="w-10 h-10 rounded-full bg-black/60 hover:bg-black/80 text-white flex items-center justify-center font-bold text-base pointer-events-auto backdrop-blur-xs transition-all shadow-md cursor-pointer"
                                aria-label="Foto Sebelumnya"
                            >
                                ‹
                            </button>
                            <button 
                                type="button" 
                                @click="nextModalPhoto()"
                                class="w-10 h-10 rounded-full bg-black/60 hover:bg-black/80 text-white flex items-center justify-center font-bold text-base pointer-events-auto backdrop-blur-xs transition-all shadow-md cursor-pointer"
                                aria-label="Foto Berikutnya"
                            >
                                ›
                            </button>
                        </div>
                    </template>

                    {{-- Photo Counter on Modal --}}
                    <template x-if="modalItem.photos && modalItem.photos.length > 1">
                        <div class="absolute bottom-3 right-3 bg-black/70 backdrop-blur-xs text-white text-xs font-mono px-3 py-1 rounded-full shadow-xs">
                            <span x-text="(modalItem.currentPhotoIndex + 1) + ' / ' + modalItem.photos.length"></span>
                        </div>
                    </template>
                </div>

                {{-- Modal Thumbnails Strip --}}
                <template x-if="modalItem.photos && modalItem.photos.length > 1">
                    <div class="flex items-center justify-center gap-2 overflow-x-auto py-1">
                        <template x-for="(photoUrl, pIdx) in modalItem.photos" :key="pIdx">
                            <button 
                                type="button" 
                                @click="modalItem.currentPhotoIndex = pIdx"
                                class="w-14 h-11 sm:w-16 sm:h-12 rounded-lg overflow-hidden border-2 transition-all shrink-0 cursor-pointer"
                                :class="modalItem.currentPhotoIndex === pIdx ? 'border-[#005952] scale-105 shadow-sm ring-2 ring-[#005952]/30' : 'border-gray-200 opacity-60 hover:opacity-100'"
                            >
                                <img :src="photoUrl" class="w-full h-full object-cover">
                            </button>
                        </template>
                    </div>
                </template>

                {{-- Full Caption & Details --}}
                <div class="bg-gray-50 rounded-2xl p-5 border border-gray-100">
                    <h3 class="text-base sm:text-lg font-bold text-gray-900 mb-1" x-text="modalItem.title"></h3>
                    <template x-if="modalItem.issuer">
                        <div class="text-xs font-bold text-[#005952] uppercase tracking-wider mb-2" x-text="modalItem.issuer"></div>
                    </template>
                    <p class="text-xs sm:text-sm text-gray-600 leading-relaxed font-normal" x-text="modalItem.description"></p>
                </div>
            </div>

            {{-- Modal Footer --}}
            <div class="p-4 sm:p-5 bg-gray-50 border-t border-gray-100 flex items-center justify-between">
                <span class="text-xs text-gray-400" x-text="$store.lang.t('Dokumentasi Ekosistem YOIN Nusantara', 'YOIN Ecosystem Documentation')">
                    Dokumentasi Ekosistem YOIN Nusantara
                </span>

                <div class="flex items-center gap-3">
                    <template x-if="modalItem.url">
                        <a 
                            :href="modalItem.url" 
                            target="_blank" 
                            class="px-5 py-2.5 rounded-md bg-[#005952] hover:bg-[#004741] text-white text-xs font-bold tracking-wider uppercase shadow-xs flex items-center gap-1.5 transition-all"
                        >
                            <span x-text="modalItem.category.toLowerCase().includes('pitch') ? $store.lang.t('BUKA PITCH DECK ↗', 'OPEN PITCH DECK ↗') : $store.lang.t('LIHAT TAUTAN ↗', 'VIEW LINK ↗')">
                                BUKA DOKUMEN ↗
                            </span>
                        </a>
                    </template>
                    <button 
                        type="button" 
                        @click="closeModal()" 
                        class="px-5 py-2.5 rounded-md bg-gray-200 hover:bg-gray-300 text-gray-700 text-xs font-bold tracking-wider uppercase transition-colors cursor-pointer"
                        x-text="$store.lang.t('TUTUP', 'CLOSE')"
                    >
                        TUTUP
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
