@extends('public.layouts.app')

@section('title', 'Publikasi, Jurnal & Artikel Riset | YOIN Inovasi Nusantara')

@section('content')
<div class="bg-[#FAFCFC] min-h-screen pt-28 sm:pt-36 pb-24 text-gray-900 font-sans select-none">
    
    {{-- Header Banner Container --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-2 text-xs text-gray-500 mb-6">
            <a href="{{ url('/') }}" class="hover:text-[#005952] transition-colors" x-text="$store.lang.t('Beranda', 'Home')">Beranda</a>
            <span>/</span>
            <span class="text-gray-900 font-semibold" x-text="$store.lang.t('Publikasi & Jurnal', 'Publications & Journals')">Publikasi & Jurnal</span>
        </nav>

        {{-- Hero Header --}}
        <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 pb-10 border-b border-gray-200">
            <div class="max-w-3xl">
                <div class="flex items-center gap-2 mb-3">
                    <span class="w-2.5 h-2.5 rounded-full bg-[#005952]"></span>
                    <span class="text-xs font-bold tracking-[0.25em] text-[#005952] uppercase" x-text="$store.lang.t('PUSAT PENGETAHUAN & PUBLIKASI', 'KNOWLEDGE & PUBLICATIONS CENTER')">
                        PUSAT PENGETAHUAN & PUBLIKASI
                    </span>
                </div>
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-gray-950 tracking-tight leading-tight" x-text="$store.lang.t('Wawasan Riset & Narasi Kemandirian Nusantara.', 'Research Insights & Narratives of Nusantara Sovereignty.')">
                    Wawasan Riset & Narasi Kemandirian Nusantara.
                </h1>
                <p class="mt-3 text-sm sm:text-base text-gray-600 leading-relaxed max-w-2xl font-normal" x-text="$store.lang.t('Dokumentasi terbuka dari perjalanan membangun kedaulatan teknologi, riset lapangan agrikultur kepulauan, dan inisiatif kemanusiaan ekosistem YOIN.', 'Open documentation from the journey of building technological sovereignty, island agricultural research, and humanitarian initiatives across the YOIN ecosystem.')">
                    Dokumentasi terbuka dari perjalanan membangun kedaulatan teknologi, riset lapangan agrikultur kepulauan, dan inisiatif kemanusiaan ekosistem YOIN.
                </p>
            </div>

            {{-- Live Statistics Badges --}}
            <div class="flex flex-wrap items-center gap-3 shrink-0">
                <div class="px-4 py-2.5 rounded-2xl bg-white border border-gray-200 shadow-xs flex items-center gap-3">
                    <div class="w-8 h-8 rounded-xl bg-slate-100 text-slate-800 flex items-center justify-center font-bold text-xs">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                        </svg>
                    </div>
                    <div>
                        <span class="text-[10px] text-gray-400 font-bold uppercase tracking-wider block" x-text="$store.lang.t('Koleksi Terbitan', 'Published Collection')">Koleksi Terbitan</span>
                        <span class="text-sm font-extrabold text-gray-950">
                            {{ $totalPublications }} <span class="text-xs font-semibold text-gray-500" x-text="$store.lang.t('Dokumen', 'Documents')">Dokumen</span>
                        </span>
                    </div>
                </div>

                <div class="px-4 py-2.5 rounded-2xl bg-white border border-gray-200 shadow-xs flex items-center gap-3">
                    <div class="w-8 h-8 rounded-xl bg-slate-100 text-slate-800 flex items-center justify-center font-bold text-xs">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </div>
                    <div>
                        <span class="text-[10px] text-gray-400 font-bold uppercase tracking-wider block" x-text="$store.lang.t('Total Dibaca', 'Total Reads')">Total Dibaca</span>
                        <span class="text-sm font-extrabold text-gray-950">
                            {{ number_format($totalReads, 0, ',', '.') }} <span class="text-xs font-semibold text-gray-500" x-text="$store.lang.t('Kali', 'Reads')">Kali</span>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Dayan-Style Category Photo Cards (Driven from Database: article_categories) --}}
        <div class="mt-10">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-[#005952]"></span>
                    <span class="text-xs font-bold tracking-widest text-gray-500 uppercase" x-text="$store.lang.t('KATEGORI TERBITAN', 'PUBLICATION CATEGORIES')">
                        KATEGORI TERBITAN
                    </span>
                </div>
                <div class="flex items-center gap-3">
                    <a 
                        href="{{ route('public.articles.index', array_merge(request()->query(), ['type' => 'all', 'page' => 1])) }}"
                        class="text-xs font-bold px-3 py-1 rounded-full transition-all {{ $selectedType === 'all' ? 'bg-[#005952] text-white shadow-xs' : 'bg-gray-100 text-gray-600 hover:text-gray-900' }}"
                    >
                        <span x-text="$store.lang.t('Semua Terbitan', 'All Publications')">Semua Terbitan</span> ({{ $totalPublications }})
                    </a>
                    @auth
                        <a href="{{ route('admin.article-categories.index') }}" class="text-[11px] font-bold text-[#005952] hover:underline" title="Kelola Kategori & Foto di Database">
                            [Ubah Foto Kategori via Database]
                        </a>
                    @endauth
                </div>
            </div>

            {{-- 4 Dayan-Style Square Photo Cards Grid --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 sm:gap-5">
                @if(isset($categories) && $categories->count() > 0)
                    @foreach($categories as $cat)
                        @php
                            $isSelected = $selectedType === $cat->slug;
                            $catArticleCount = \App\Models\Article::published()->where('type', $cat->slug)->count();
                        @endphp
                        <a 
                            href="{{ route('public.articles.index', array_merge(request()->query(), ['type' => $cat->slug, 'page' => 1])) }}"
                            class="group relative aspect-square sm:h-72 overflow-hidden border transition-all duration-300 shadow-xs hover:shadow-xl bg-gray-950 flex flex-col justify-end p-4 sm:p-5 cursor-pointer {{ $isSelected ? 'border-[#005952] ring-4 ring-[#005952]/30 shadow-lg' : 'border-gray-200 hover:border-gray-800' }}"
                        >
                            {{-- Photo directly from Database --}}
                            <div 
                                class="absolute inset-0 bg-cover bg-center transition-transform duration-700 group-hover:scale-105"
                                style="background-image: url('{{ $cat->image_url }}');"
                            ></div>
                            
                            {{-- High Contrast Dark Gradient for crystal-clear readability --}}
                            <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/35 to-transparent group-hover:via-black/25 transition-colors"></div>

                            {{-- Selected Badge Indicator --}}
                            @if($isSelected)
                                <div class="absolute top-3 right-3 z-10">
                                    <span class="px-2.5 py-1 rounded-full bg-[#004741] text-white text-[10px] font-extrabold tracking-wider uppercase shadow-md flex items-center gap-1">
                                        <span class="w-1.5 h-1.5 rounded-full bg-white"></span>
                                        <span x-text="$store.lang.t('Dipilih', 'Active')">Dipilih</span>
                                    </span>
                                </div>
                            @endif

                            {{-- Card Count Badge Top Left --}}
                            <div class="absolute top-3 left-3 z-10">
                                <span class="px-2 py-0.5 rounded-md bg-black/50 backdrop-blur-xs text-white/90 text-[10px] font-mono font-semibold">
                                    {{ $catArticleCount }} <span x-text="$store.lang.t('Dokumen', 'Docs')">Dokumen</span>
                                </span>
                            </div>
                            
                            {{-- Bottom Text: Subtitle / Tulisan & Title matching Dayan reference screenshot --}}
                            <div class="relative z-10 text-center">
                                @if($cat->subtitle_id)
                                    <span 
                                        class="block text-[10px] sm:text-[11px] text-white/85 font-medium tracking-wide line-clamp-1 mb-1 opacity-90 group-hover:opacity-100 transition-opacity drop-shadow-xs"
                                        x-text="$store.lang.isEN() ? '{{ $cat->subtitle_en ?: $cat->subtitle_id }}' : '{{ $cat->subtitle_id }}'"
                                    >
                                        {{ $cat->subtitle_id }}
                                    </span>
                                @endif
                                <h3 
                                    class="text-sm sm:text-base font-sans tracking-[0.18em] font-extrabold text-white uppercase group-hover:text-teal-200 transition-colors drop-shadow-md"
                                    x-text="$store.lang.isEN() ? '{{ $cat->name_en }}' : '{{ $cat->name_id }}'"
                                >
                                    {{ $cat->name_id }}
                                </h3>
                            </div>
                        </a>
                    @endforeach
                @endif
            </div>
        </div>

        {{-- Search Input and Active Filter Status Bar --}}
        <div class="mt-8 flex flex-col md:flex-row items-center justify-between gap-4 bg-white p-4 rounded-2xl border border-gray-200 shadow-xs">
            <div class="flex items-center gap-2 text-xs text-gray-600">
                <span class="font-semibold text-gray-400" x-text="$store.lang.t('Menampilkan Filter:', 'Showing Filter:')">Menampilkan Filter:</span>
                <span class="font-bold text-[#005952] uppercase font-mono">
                    {{ $selectedType === 'all' ? 'Semua Terbitan' : ($categories->firstWhere('slug', $selectedType)?->name_id ?? $selectedType) }}
                </span>
                @if($selectedType !== 'all')
                    <a 
                        href="{{ route('public.articles.index', array_merge(request()->query(), ['type' => 'all', 'page' => 1])) }}" 
                        class="text-gray-400 hover:text-red-500 font-bold ml-1 text-xs"
                        title="Hapus filter"
                    >
                        ✕
                    </a>
                @endif
            </div>

            {{-- Search Input --}}
            <form action="{{ route('public.articles.index') }}" method="GET" class="w-full md:w-80 relative">
                @if($selectedType !== 'all')
                    <input type="hidden" name="type" value="{{ $selectedType }}">
                @endif
                <input 
                    type="text" 
                    name="q" 
                    value="{{ $searchQuery }}" 
                    :placeholder="$store.lang.t('Cari topik, jurnal, riset...', 'Search topics, journals, research...')" 
                    class="w-full pl-10 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-full text-xs text-gray-900 placeholder-gray-400 focus:outline-none focus:border-[#005952] focus:bg-white transition-colors"
                >
                <svg class="w-4 h-4 text-gray-400 absolute left-3.5 top-2.5 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </form>
        </div>

        {{-- Articles Grid --}}
        @if($articles->count() > 0)
            <div class="mt-10 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($articles as $art)
                    <article class="flex flex-col justify-between bg-white rounded-3xl border border-gray-200 shadow-xs hover:shadow-xl hover:border-teal-500/50 transition-all duration-300 overflow-hidden group">
                        <div>
                            {{-- Cover Image --}}
                            <a href="{{ route('public.articles.show', $art->slug) }}" class="block relative h-52 sm:h-56 w-full overflow-hidden bg-gray-900">
                                @if($art->cover_image)
                                    <img 
                                        src="{{ $art->cover_image }}" 
                                        alt="{{ $art->title }}" 
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 filter brightness-95"
                                        loading="lazy"
                                    >
                                @else
                                    <div class="w-full h-full bg-gradient-to-tr from-[#021d1b] to-[#005952] flex items-center justify-center text-teal-200/50">
                                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                                    </div>
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-gray-950/70 via-transparent to-transparent"></div>

                                {{-- Category Badge Top-Left --}}
                                <div class="absolute top-4 left-4 z-10">
                                    <span class="px-3 py-1 rounded-md bg-white/95 backdrop-blur-md text-[10px] font-extrabold tracking-wider uppercase text-gray-900 shadow-xs">
                                        {{ $art->type }}
                                    </span>
                                </div>

                                {{-- Reading Time Top-Right --}}
                                <div class="absolute top-4 right-4 z-10">
                                    <span class="px-2.5 py-1 rounded-md bg-black/60 backdrop-blur-md text-[10px] font-semibold text-white">
                                        {{ $art->reading_time }} <span x-text="$store.lang.t('min baca', 'min read')">min baca</span>
                                    </span>
                                </div>

                                {{-- Badge Pill Bottom-Left --}}
                                @if($art->badge)
                                    <div class="absolute bottom-3 left-4 right-4 text-white">
                                        <span class="text-[10px] font-bold text-white font-mono tracking-wide uppercase bg-black/60 px-2 py-0.5 rounded-sm backdrop-blur-xs">
                                            <span x-text="$store.lang.isEN() ? '{{ addslashes($art->badge_en ?: $art->badge) }}' : '{{ addslashes($art->badge) }}'">{{ $art->badge }}</span>
                                        </span>
                                    </div>
                                @endif
                            </a>

                            {{-- Card Body --}}
                            <div class="p-6">
                                @if($art->tag)
                                    <span class="text-[10px] font-bold text-[#004741] tracking-wider uppercase block mb-1.5">
                                        <span x-text="$store.lang.isEN() ? '{{ addslashes($art->tag_en ?: $art->tag) }}' : '{{ addslashes($art->tag) }}'">{{ $art->tag }}</span>
                                    </span>
                                @endif

                                <h2 class="text-base sm:text-lg font-black text-gray-950 leading-snug tracking-tight group-hover:text-[#004741] transition-colors">
                                    <a href="{{ route('public.articles.show', $art->slug) }}">
                                        <span x-text="$store.lang.isEN() ? '{{ addslashes($art->title_en ?: $art->title) }}' : '{{ addslashes($art->title) }}'">{{ $art->title }}</span>
                                    </a>
                                </h2>

                                <p class="text-xs text-gray-600 leading-relaxed mt-2.5 line-clamp-3 font-normal">
                                    <span x-text="$store.lang.isEN() ? '{{ addslashes($art->excerpt_en ?: $art->excerpt) }}' : '{{ addslashes($art->excerpt) }}'">{{ $art->excerpt }}</span>
                                </p>
                            </div>
                        </div>

                        {{-- Card Footer --}}
                        <div class="px-6 pb-6 pt-3 border-t border-gray-100 flex items-center justify-between text-[11px] text-gray-500">
                            <div class="flex items-center gap-2">
                                <span>{{ $art->published_at ? $art->published_at->format('d M Y') : $art->created_at->format('d M Y') }}</span>
                                <span>•</span>
                                <span class="flex items-center gap-1 font-semibold text-gray-700">
                                    <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    {{ number_format($art->views_count, 0, ',', '.') }}
                                </span>
                            </div>

                            <a href="{{ route('public.articles.show', $art->slug) }}" class="inline-flex items-center gap-1 font-bold text-[#005952] group-hover:underline">
                                <span x-text="$store.lang.t('Baca', 'Read')">Baca</span>
                                <span class="transform group-hover:translate-x-1 transition-transform">→</span>
                            </a>
                        </div>

                    </article>
                @endforeach
            </div>

            {{-- Pagination Links --}}
            <div class="mt-12 flex justify-center">
                {{ $articles->links() }}
            </div>
        @else
            <div class="mt-16 text-center py-16 bg-white rounded-3xl border border-gray-200">
                <div class="w-12 h-12 rounded-full bg-gray-100 text-gray-400 mx-auto flex items-center justify-center mb-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h3 class="text-base font-bold text-gray-900" x-text="$store.lang.t('Tidak ada terbitan ditemukan', 'No publications found')">Tidak ada terbitan ditemukan</h3>
                <p class="text-xs text-gray-500 mt-1 max-w-sm mx-auto" x-text="$store.lang.t('Coba cari dengan kata kunci lain atau pilih kategori yang berbeda.', 'Try searching with different keywords or select a different category.')">Coba cari dengan kata kunci lain atau pilih kategori yang berbeda.</p>
                <a href="{{ route('public.articles.index') }}" class="inline-block mt-4 px-4 py-2 bg-[#005952] text-white rounded-full text-xs font-bold" x-text="$store.lang.t('Lihat Semua Terbitan', 'View All Publications')">
                    Lihat Semua Terbitan
                </a>
            </div>
        @endif

    </div>

</div>
@endsection
