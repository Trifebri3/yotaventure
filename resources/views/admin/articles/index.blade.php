<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <span class="text-xs font-bold tracking-widest text-[#005952] uppercase block">YOIN CMS & Media Center</span>
                <h2 class="font-black text-xl sm:text-2xl text-gray-900 leading-tight">
                    Manajemen Artikel, Publikasi & Riset
                </h2>
            </div>
            <div class="flex items-center gap-3">
                <a 
                    href="{{ route('public.articles.index') }}" 
                    target="_blank" 
                    class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-white border border-gray-300 text-xs font-bold text-gray-700 hover:bg-gray-50 shadow-xs transition-colors"
                >
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    <span>Lihat Halaman Publik</span>
                </a>
                <a 
                    href="{{ route('admin.articles.create') }}" 
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-[#005952] hover:bg-[#004741] text-white text-xs font-bold uppercase tracking-wider shadow-sm transition-all hover:scale-105 active:scale-95"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                    <span>Tulis Publikasi Baru</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div 
        x-data="{ 
            activeTab: '{{ request()->query('tab') === 'categories' ? 'categories' : 'articles' }}' 
        }" 
        class="py-8 bg-gray-50 min-h-screen"
    >
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Flash Notification --}}
            @if(session('success'))
                <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-900 flex items-center justify-between shadow-xs">
                    <div class="flex items-center gap-3 text-xs sm:text-sm font-semibold">
                        <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            {{-- UNIFIED SUB-MENU TABS --}}
            <div class="flex items-center gap-3 border-b border-gray-200 pb-3 select-none">
                <a 
                    href="{{ route('admin.articles.index', ['tab' => 'articles']) }}" 
                    @click.prevent="activeTab = 'articles'"
                    class="px-5 py-2.5 rounded-xl text-xs font-bold tracking-wider uppercase transition-all cursor-pointer flex items-center gap-2"
                    :class="activeTab === 'articles' ? 'bg-[#005952] text-white shadow-xs' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200'"
                >
                    <span>Daftar Artikel & Publikasi</span>
                    <span class="px-2 py-0.5 rounded-full text-[10px]" :class="activeTab === 'articles' ? 'bg-white/20 text-white' : 'bg-gray-100 text-gray-600'">{{ number_format($totalArticles) }}</span>
                </a>

                <a 
                    href="{{ route('admin.articles.index', ['tab' => 'categories']) }}" 
                    @click.prevent="activeTab = 'categories'"
                    class="px-5 py-2.5 rounded-xl text-xs font-bold tracking-wider uppercase transition-all cursor-pointer flex items-center gap-2"
                    :class="activeTab === 'categories' ? 'bg-[#005952] text-white shadow-xs' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200'"
                >
                    <span>Kategori & Foto (Gaya Dayan)</span>
                    <span class="px-2 py-0.5 rounded-full text-[10px]" :class="activeTab === 'categories' ? 'bg-white/20 text-white' : 'bg-gray-100 text-gray-600'">{{ $categories->count() }}</span>
                </a>
            </div>

            {{-- TAB 1: DAFTAR ARTIKEL & PUBLIKASI --}}
            <div x-show="activeTab === 'articles'" class="space-y-6">
                {{-- 1. LIVE STATISTICS METRICS CARDS --}}
            <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                {{-- Total Articles --}}
                <div class="bg-white p-5 rounded-2xl border border-gray-200/90 shadow-xs">
                    <span class="text-[10px] font-bold tracking-wider text-gray-500 uppercase block">Total Publikasi</span>
                    <span class="text-2xl sm:text-3xl font-black text-gray-900 mt-1 block">{{ number_format($totalArticles) }}</span>
                    <span class="text-[11px] text-gray-400 mt-0.5 block">Artikel & Jurnal Riset</span>
                </div>

                {{-- Total Views --}}
                <div class="bg-white p-5 rounded-2xl border border-gray-200/90 shadow-xs">
                    <span class="text-[10px] font-bold tracking-wider text-[#005952] uppercase block">Total Dibaca</span>
                    <span class="text-2xl sm:text-3xl font-black text-[#005952] mt-1 block">{{ number_format($totalViews) }}</span>
                    <span class="text-[11px] text-teal-600 mt-0.5 block">Akumulasi Pembaca Publik</span>
                </div>

                {{-- Published Count --}}
                <div class="bg-white p-5 rounded-2xl border border-gray-200/90 shadow-xs">
                    <span class="text-[10px] font-bold tracking-wider text-emerald-600 uppercase block">Diterbitkan</span>
                    <span class="text-2xl sm:text-3xl font-black text-emerald-700 mt-1 block">{{ number_format($publishedCount) }}</span>
                    <span class="text-[11px] text-gray-400 mt-0.5 block">Tayang di Publik</span>
                </div>

                {{-- Draft Count --}}
                <div class="bg-white p-5 rounded-2xl border border-gray-200/90 shadow-xs">
                    <span class="text-[10px] font-bold tracking-wider text-amber-600 uppercase block">Draf / Menunggu</span>
                    <span class="text-2xl sm:text-3xl font-black text-amber-700 mt-1 block">{{ number_format($draftCount) }}</span>
                    <span class="text-[11px] text-gray-400 mt-0.5 block">Belum Ditayangkan</span>
                </div>

                {{-- Featured Count --}}
                <div class="bg-white p-5 rounded-2xl border border-gray-200/90 shadow-xs col-span-2 md:col-span-1">
                    <span class="text-[10px] font-bold tracking-wider text-blue-600 uppercase block">Inisiatif Unggulan</span>
                    <span class="text-2xl sm:text-3xl font-black text-blue-700 mt-1 block">{{ number_format($featuredCount) }}</span>
                    <span class="text-[11px] text-gray-400 mt-0.5 block">Slider Halaman Utama</span>
                </div>
            </div>

            {{-- 2. TOP PERFORMING ARTICLES WIDGET --}}
            @if($topArticles->isNotEmpty())
                <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-xs">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-[#00D0B7]"></span>
                            <h3 class="text-xs font-bold uppercase tracking-wider text-gray-800">5 Publikasi Teratas dengan Pembaca Tertinggi</h3>
                        </div>
                        <span class="text-[11px] text-gray-400">Statistik Pembaca Nyata</span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
                        @foreach($topArticles as $idx => $top)
                            <a 
                                href="{{ route('public.articles.show', $top->slug) }}" 
                                target="_blank"
                                class="p-3.5 rounded-xl border border-gray-100 bg-gray-50/70 hover:bg-white hover:border-[#005952] transition-all group flex flex-col justify-between"
                            >
                                <div>
                                    <div class="flex items-center justify-between text-[10px] font-mono text-gray-400 mb-1">
                                        <span>#{{ $idx + 1 }}</span>
                                        <span class="text-[#005952] font-bold">{{ number_format($top->views_count) }} views</span>
                                    </div>
                                    <h4 class="text-xs font-bold text-gray-900 group-hover:text-[#005952] line-clamp-2 leading-snug">
                                        {{ $top->title }}
                                    </h4>
                                </div>
                                <span class="text-[9px] uppercase tracking-wider text-gray-400 font-semibold mt-2 block">
                                    {{ $top->type }}
                                </span>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- 3. FILTER & SEARCH BAR --}}
            <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-xs">
                <form method="GET" action="{{ route('admin.articles.index') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-center">
                    {{-- Search Keyword --}}
                    <div class="sm:col-span-6 relative">
                        <svg class="w-4 h-4 text-gray-400 absolute left-3.5 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <input 
                            type="text" 
                            name="search" 
                            value="{{ $search }}" 
                            placeholder="Cari judul, tag, atau kata kunci..." 
                            class="w-full pl-10 pr-4 py-2.5 text-xs sm:text-sm rounded-xl border border-gray-200 bg-gray-50/70 focus:bg-white focus:border-[#005952] focus:ring-2 focus:ring-[#005952]/20 outline-none transition-all"
                        >
                    </div>

                    {{-- Category / Type Filter --}}
                    <div class="sm:col-span-3">
                        <select 
                            name="type" 
                            class="w-full px-3 py-2.5 text-xs sm:text-sm rounded-xl border border-gray-200 bg-gray-50/70 focus:bg-white focus:border-[#005952] outline-none transition-all"
                        >
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->slug }}" {{ $typeFilter === $cat->slug ? 'selected' : '' }}>
                                    {{ $cat->name_id }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Status Filter --}}
                    <div class="sm:col-span-2">
                        <select 
                            name="status" 
                            class="w-full px-3 py-2.5 text-xs sm:text-sm rounded-xl border border-gray-200 bg-gray-50/70 focus:bg-white focus:border-[#005952] outline-none transition-all"
                        >
                            <option value="">Semua Status</option>
                            <option value="published" {{ $statusFilter === 'published' ? 'selected' : '' }}>Diterbitkan</option>
                            <option value="draft" {{ $statusFilter === 'draft' ? 'selected' : '' }}>Draf</option>
                        </select>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="sm:col-span-1 flex items-center gap-2">
                        <button 
                            type="submit" 
                            class="w-full py-2.5 px-3 rounded-xl bg-[#005952] hover:bg-[#004741] text-white text-xs font-bold uppercase transition-colors"
                            title="Terapkan Filter"
                        >
                            Filter
                        </button>
                    </div>
                </form>
            </div>

            {{-- 4. ARTICLES TABLE --}}
            <div class="bg-white rounded-2xl border border-gray-200 shadow-xs overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-gray-50/50">
                    <div class="flex items-center gap-2">
                        <span class="font-bold text-sm text-gray-900">Daftar Publikasi Aktif</span>
                        <span class="px-2.5 py-0.5 rounded-full bg-[#005952]/10 text-[#005952] text-xs font-bold font-mono">{{ $articles->total() }}</span>
                    </div>
                    <div class="flex items-center gap-2.5">
                        <a 
                            href="{{ route('admin.articles.create') }}" 
                            class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-[#005952] hover:bg-[#004741] text-white text-xs font-bold uppercase tracking-wider shadow-xs transition-all hover:scale-105 active:scale-95 cursor-pointer"
                        >
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                            <span>+ Tulis Publikasi Baru</span>
                        </a>
                        <a 
                            href="{{ route('admin.articles.index', ['tab' => 'categories']) }}" 
                            @click.prevent="activeTab = 'categories'"
                            class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 text-xs font-bold tracking-wider transition-all cursor-pointer"
                        >
                            <span>+ Kelola Kategori ({{ $categories->count() }})</span>
                        </a>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs text-gray-700">
                        <thead class="bg-gray-50 border-b border-gray-200 text-[10px] font-bold text-gray-500 uppercase tracking-wider">
                            <tr>
                                <th class="py-3.5 px-5">Artikel & Publikasi</th>
                                <th class="py-3.5 px-4">Kategori</th>
                                <th class="py-3.5 px-4">Penulis</th>
                                <th class="py-3.5 px-4 text-center">Status</th>
                                <th class="py-3.5 px-4 text-center">Statistik Dibaca</th>
                                <th class="py-3.5 px-4">Tanggal Terbit</th>
                                <th class="py-3.5 px-5 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($articles as $art)
                                <tr class="hover:bg-gray-50/80 transition-colors">
                                    {{-- Title & Thumbnail --}}
                                    <td class="py-4 px-5">
                                        <div class="flex items-center gap-3.5 max-w-md">
                                            @if($art->cover_image)
                                                <img 
                                                    src="{{ $art->cover_image }}" 
                                                    alt="{{ $art->title }}" 
                                                    class="w-14 h-11 rounded-lg object-cover border border-gray-200 shrink-0"
                                                >
                                            @else
                                                <div class="w-14 h-11 rounded-lg bg-teal-50 border border-teal-200 flex items-center justify-center text-[#005952] font-black text-xs shrink-0">
                                                    YOIN
                                                </div>
                                            @endif
                                            <div>
                                                <a 
                                                    href="{{ route('admin.articles.edit', $art->id) }}" 
                                                    class="font-bold text-gray-900 hover:text-[#005952] text-xs sm:text-sm line-clamp-1 transition-colors"
                                                >
                                                    {{ $art->title }}
                                                </a>
                                                <div class="flex items-center gap-2 mt-1">
                                                    @if($art->is_featured)
                                                        <span class="px-2 py-0.5 rounded-full bg-blue-50 text-blue-700 text-[9px] font-bold uppercase border border-blue-200">
                                                            Unggulan Home
                                                        </span>
                                                    @endif
                                                    @if($art->badge)
                                                        <span class="text-[10px] text-gray-500">
                                                            {{ $art->badge }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Category / Type --}}
                                    <td class="py-4 px-4">
                                        <span class="px-2.5 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider 
                                            @if($art->type === 'jurnal') bg-purple-50 text-purple-700 border border-purple-200
                                            @elseif($art->type === 'inisiatif') bg-teal-50 text-teal-700 border border-teal-200
                                            @elseif($art->type === 'publikasi') bg-emerald-50 text-emerald-700 border border-emerald-200
                                            @else bg-gray-100 text-gray-700 border border-gray-200 @endif
                                        ">
                                            {{ $art->type }}
                                        </span>
                                    </td>

                                    {{-- Author --}}
                                    <td class="py-4 px-4 font-medium text-gray-800">
                                        {{ $art->author_name }}
                                    </td>

                                    {{-- Status --}}
                                    <td class="py-4 px-4 text-center">
                                        @if($art->status === 'published')
                                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-700 text-[10px] font-bold border border-emerald-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                                <span>Tayang</span>
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-amber-50 text-amber-700 text-[10px] font-bold border border-amber-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                                <span>Draf</span>
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Views Count --}}
                                    <td class="py-4 px-4 text-center">
                                        <div class="inline-flex items-center gap-1.5 font-bold text-gray-800 bg-gray-50 px-2.5 py-1 rounded-lg border border-gray-150 font-mono">
                                            <svg class="w-3.5 h-3.5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            <span>{{ number_format($art->views_count) }}</span>
                                        </div>
                                    </td>

                                    {{-- Date --}}
                                    <td class="py-4 px-4 text-gray-500 text-[11px]">
                                        {{ $art->published_at ? $art->published_at->format('d M Y') : 'Belum Ditentukan' }}
                                    </td>

                                    {{-- Actions --}}
                                    <td class="py-4 px-5 text-right whitespace-nowrap">
                                        <div class="flex items-center justify-end gap-1.5">
                                            {{-- Preview in Public Site --}}
                                            <a 
                                                href="{{ route('public.articles.show', $art->slug) }}" 
                                                target="_blank" 
                                                class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-[11px] font-semibold text-gray-600 hover:text-gray-900 bg-gray-100 hover:bg-gray-200 transition-colors"
                                                title="Lihat Halaman Publik"
                                            >
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                                <span>Lihat</span>
                                            </a>

                                            {{-- Edit --}}
                                            <a 
                                                href="{{ route('admin.articles.edit', $art->id) }}" 
                                                class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-[11px] font-bold text-[#005952] bg-teal-50 hover:bg-teal-100 border border-teal-200/60 transition-colors"
                                                title="Ubah Publikasi"
                                            >
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                                <span>Edit</span>
                                            </a>

                                            {{-- Delete Form --}}
                                            <form 
                                                action="{{ route('admin.articles.destroy', $art->id) }}" 
                                                method="POST" 
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus publikasi \'{{ addslashes($art->title) }}\'? Tindakan ini tidak dapat dibatalkan.');"
                                                class="inline"
                                            >
                                                @csrf
                                                @method('DELETE')
                                                <button 
                                                    type="submit" 
                                                    class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-[11px] font-bold text-rose-700 bg-rose-50 hover:bg-rose-100 border border-rose-200/60 transition-colors cursor-pointer"
                                                    title="Hapus Publikasi"
                                                >
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                    <span>Hapus</span>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-12 px-4 text-center text-gray-400 text-xs">
                                        Tidak ada artikel atau publikasi yang sesuai kriteria pencarian.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination Links --}}
                @if($articles->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100">
                        {{ $articles->links() }}
                    </div>
                @endif
            </div>
            </div>
            {{-- END TAB 1: ARTICLES --}}

            {{-- TAB 2: KATEGORI & FOTO TERBITAN (GAYA DAYAN) --}}
            <div x-show="activeTab === 'categories'" x-cloak class="space-y-6">
                {{-- Header & Info Card --}}
                <div class="bg-white rounded-3xl border border-gray-200 shadow-xs p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-teal-50 text-[#005952] text-xs font-bold uppercase tracking-wider mb-2">
                            <span>Manajemen Kategori & Foto Database</span>
                        </div>
                        <h3 class="text-xl font-black text-gray-900">Kategori Terbitan Gaya Dayan</h3>
                        <p class="text-xs text-gray-500 mt-1 max-w-2xl leading-relaxed">
                            Kategori dibuat di sini dan otomatis tersimpan di database. Foto dan teks sebelum diklik langsung tampil dengan tata letak visual gaya Dayan di halaman publik (<a href="{{ route('public.articles.index') }}" target="_blank" class="text-[#005952] font-semibold underline">/publikasi</a>) dan otomatis menjadi pilihan pada filter serta form penulisan publikasi.
                        </p>
                    </div>
                    <div class="flex items-center gap-2.5">
                        <a 
                            href="{{ route('admin.articles.index', ['tab' => 'articles']) }}" 
                            @click.prevent="activeTab = 'articles'"
                            class="inline-flex items-center gap-1.5 px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold tracking-wider uppercase rounded-xl transition-all shadow-xs cursor-pointer"
                        >
                            <span>← Kembali ke Artikel</span>
                        </a>
                        <a 
                            href="{{ route('public.articles.index') }}" 
                            target="_blank"
                            class="inline-flex items-center gap-2 px-4 py-2.5 bg-[#005952] hover:bg-[#004741] text-white text-xs font-bold tracking-wider uppercase rounded-xl transition-all shadow-xs"
                        >
                            <span>Lihat di Publikasi</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        </a>
                    </div>
                </div>

                {{-- FORM: TAMBAH KATEGORI BARU (DI BUAT DISINI) --}}
                <div class="bg-white rounded-3xl border-2 border-dashed border-teal-300/80 hover:border-[#005952] transition-all shadow-xs p-6 sm:p-8" x-data="{ openCreate: true }">
                    <div class="flex items-center justify-between cursor-pointer" @click="openCreate = !openCreate">
                        <div class="flex items-center gap-3.5">
                            <div class="w-10 h-10 rounded-2xl bg-[#005952] flex items-center justify-center text-white font-black text-lg shadow-xs">
                                +
                            </div>
                            <div>
                                <h4 class="text-base font-bold text-gray-900 flex items-center gap-2">
                                    <span>Tambah Kategori Baru di Database</span>
                                    <span class="px-2.5 py-0.5 rounded-full bg-teal-50 text-[#005952] text-[10px] font-bold uppercase">Form Pembuatan</span>
                                </h4>
                                <p class="text-xs text-gray-500 mt-0.5">Buat kategori baru di sini untuk langsung tersimpan di database dan otomatis muncul di seluruh filter dan form artikel.</p>
                            </div>
                        </div>
                        <button type="button" class="text-xs font-bold text-[#005952] hover:underline" x-text="openCreate ? 'Tutup Formulir' : 'Buka Formulir'">
                            Tutup Formulir
                        </button>
                    </div>

                    <div x-show="openCreate" class="mt-6 pt-6 border-t border-gray-100">
                        <form action="{{ route('admin.article-categories.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                            @csrf

                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                                        Nama Kategori (ID) *
                                    </label>
                                    <input 
                                        type="text" 
                                        name="name_id" 
                                        placeholder="Contoh: Studi Kasus" 
                                        required 
                                        class="w-full text-xs rounded-xl border-gray-300 focus:border-[#005952] focus:ring-[#005952] py-2.5 px-3"
                                    >
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                                        Nama Kategori (EN) *
                                    </label>
                                    <input 
                                        type="text" 
                                        name="name_en" 
                                        placeholder="Contoh: Case Studies" 
                                        required 
                                        class="w-full text-xs rounded-xl border-gray-300 focus:border-[#005952] focus:ring-[#005952] py-2.5 px-3"
                                    >
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                                        Slug (Otomatis jika kosong)
                                    </label>
                                    <input 
                                        type="text" 
                                        name="slug" 
                                        placeholder="studi-kasus" 
                                        class="w-full text-xs font-mono rounded-xl border-gray-300 focus:border-[#005952] focus:ring-[#005952] py-2.5 px-3"
                                    >
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                                        Keterangan Teks Kartu Sebelum Diklik (ID)
                                    </label>
                                    <input 
                                        type="text" 
                                        name="subtitle_id" 
                                        placeholder="Contoh: Analisis Mendalam Solusi Nyata" 
                                        class="w-full text-xs rounded-xl border-gray-300 focus:border-[#005952] focus:ring-[#005952] py-2.5 px-3"
                                    >
                                    <span class="text-[10px] text-gray-400 mt-0.5 block">Tulisan kecil di atas judul kartu gaya Dayan</span>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                                        Keterangan Teks Kartu Sebelum Diklik (EN)
                                    </label>
                                    <input 
                                        type="text" 
                                        name="subtitle_en" 
                                        placeholder="Contoh: In-depth Solution Analysis" 
                                        class="w-full text-xs rounded-xl border-gray-300 focus:border-[#005952] focus:ring-[#005952] py-2.5 px-3"
                                    >
                                    <span class="text-[10px] text-gray-400 mt-0.5 block">Versi bahasa Inggris untuk teks kartu</span>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                <div class="sm:col-span-2">
                                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                                        URL Foto Latar Belakang Kartu (Gaya Dayan)
                                    </label>
                                    <input 
                                        type="url" 
                                        name="image_url" 
                                        placeholder="https://images.unsplash.com/photo-..." 
                                        class="w-full text-xs rounded-xl border-gray-300 focus:border-[#005952] focus:ring-[#005952] py-2.5 px-3"
                                    >
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                                        Urutan Tampilan
                                    </label>
                                    <input 
                                        type="number" 
                                        name="sort_order" 
                                        value="{{ $categories->count() + 1 }}" 
                                        class="w-full text-xs rounded-xl border-gray-300 focus:border-[#005952] focus:ring-[#005952] py-2.5 px-3"
                                    >
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                                    Atau Unggah File Foto dari Komputer
                                </label>
                                <input 
                                    type="file" 
                                    name="image_file" 
                                    accept="image/*" 
                                    class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-teal-50 file:text-[#005952] hover:file:bg-teal-100"
                                >
                            </div>

                            <div class="pt-3 flex justify-end">
                                <button 
                                    type="submit" 
                                    class="inline-flex items-center gap-2 px-6 py-3 bg-[#005952] hover:bg-[#004741] text-white text-xs font-bold tracking-wider uppercase rounded-xl transition-all shadow-sm hover:scale-[1.02] active:scale-[0.98]"
                                >
                                    <span>+ Buat & Simpan Kategori Baru ke Database</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- DAFTAR KATEGORI YANG SUDAH TERSIMPAN DI DATABASE --}}
                <div class="flex items-center justify-between pt-2">
                    <h4 class="text-sm font-bold text-gray-800 uppercase tracking-wider">
                        Daftar Kategori Tersimpan di Database ({{ $categories->count() }})
                    </h4>
                    <span class="text-xs text-gray-400">Setiap perubahan foto langsung terbarui di website</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @forelse($categories as $category)
                        @php
                            $linkedArticlesCount = \App\Models\Article::where('type', $category->slug)->count();
                        @endphp
                        <div class="bg-white rounded-3xl border border-gray-200 shadow-sm p-6 overflow-hidden flex flex-col justify-between">
                            <div>
                                <div class="flex items-center justify-between mb-4 pb-3 border-b border-gray-100">
                                    <div class="flex items-center gap-2">
                                        <span class="px-3 py-1 rounded-full bg-teal-50 text-[#005952] text-xs font-bold font-mono uppercase">
                                            Slug: {{ $category->slug }}
                                        </span>
                                        <span class="px-2.5 py-0.5 rounded-full bg-gray-100 text-gray-600 text-[10px] font-semibold">
                                            {{ $linkedArticlesCount }} Publikasi
                                        </span>
                                    </div>
                                    <span class="text-xs text-gray-400 font-mono">#{{ $category->sort_order }}</span>
                                </div>

                                {{-- Live Dayan Photo Card Preview --}}
                                <div class="relative aspect-video sm:h-52 w-full rounded-2xl overflow-hidden mb-6 bg-gray-950 border border-gray-200 shadow-inner flex flex-col justify-end p-4">
                                    <div 
                                        class="absolute inset-0 bg-cover bg-center transition-transform duration-500 hover:scale-105"
                                        style="background-image: url('{{ $category->image_url }}');"
                                    ></div>
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/30 to-transparent"></div>
                                    <div class="relative z-10 text-center">
                                        <span class="block text-[10px] text-white/80 font-medium tracking-wide line-clamp-1 mb-1">
                                            {{ $category->subtitle_id ?: 'Teks Keterangan Terbitan' }}
                                        </span>
                                        <h4 class="text-base font-extrabold tracking-[0.18em] text-white uppercase drop-shadow-md">
                                            {{ $category->name_id }}
                                        </h4>
                                    </div>
                                </div>

                                {{-- Form Update --}}
                                <form action="{{ route('admin.article-categories.update', $category) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                                    @csrf
                                    @method('PUT')

                                    <div class="grid grid-cols-2 gap-3">
                                        <div>
                                            <label class="block text-xs font-bold text-gray-700 mb-1">Judul Kategori (ID)</label>
                                            <input type="text" name="name_id" value="{{ old('name_id', $category->name_id) }}" class="w-full text-xs rounded-xl border-gray-300 focus:border-[#005952] focus:ring-[#005952]" required>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-gray-700 mb-1">Judul Kategori (EN)</label>
                                            <input type="text" name="name_en" value="{{ old('name_en', $category->name_en) }}" class="w-full text-xs rounded-xl border-gray-300 focus:border-[#005952] focus:ring-[#005952]" required>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-2 gap-3">
                                        <div>
                                            <label class="block text-xs font-bold text-gray-700 mb-1">Keterangan / Tulisan (ID)</label>
                                            <input type="text" name="subtitle_id" value="{{ old('subtitle_id', $category->subtitle_id) }}" class="w-full text-xs rounded-xl border-gray-300 focus:border-[#005952] focus:ring-[#005952]">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-gray-700 mb-1">Keterangan / Tulisan (EN)</label>
                                            <input type="text" name="subtitle_en" value="{{ old('subtitle_en', $category->subtitle_en) }}" class="w-full text-xs rounded-xl border-gray-300 focus:border-[#005952] focus:ring-[#005952]">
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-3 gap-3">
                                        <div class="col-span-2">
                                            <label class="block text-xs font-bold text-gray-700 mb-1">URL Foto (Unsplash / Tautan)</label>
                                            <input type="url" name="image_url" value="{{ old('image_url', $category->image_url) }}" class="w-full text-xs rounded-xl border-gray-300 focus:border-[#005952] focus:ring-[#005952]">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-gray-700 mb-1">Urutan</label>
                                            <input type="number" name="sort_order" value="{{ old('sort_order', $category->sort_order) }}" class="w-full text-xs rounded-xl border-gray-300 focus:border-[#005952] focus:ring-[#005952]">
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-xs font-bold text-gray-700 mb-1">Atau Unggah File Foto Baru</label>
                                        <input type="file" name="image_file" accept="image/*" class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-teal-50 file:text-[#005952] hover:file:bg-teal-100">
                                    </div>

                                    <div class="pt-3 border-t border-gray-100 flex items-center justify-end">
                                        <button type="submit" class="px-5 py-2.5 bg-[#005952] hover:bg-[#004741] text-white text-xs font-bold tracking-wider uppercase rounded-xl transition-all shadow-sm cursor-pointer">
                                            Simpan Perubahan
                                        </button>
                                    </div>
                                </form>

                                {{-- Delete Button Form --}}
                                <div class="mt-3 pt-3 border-t border-gray-100 flex items-center justify-between">
                                    <span class="text-[11px] text-gray-400">Hapus dari Database:</span>
                                    <form 
                                        action="{{ route('admin.article-categories.destroy', $category) }}" 
                                        method="POST" 
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori {{ $category->name_id }} ini dari database? {{ $linkedArticlesCount > 0 ? '(' . $linkedArticlesCount . ' publikasi saat ini terhubung)' : '' }}');"
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <button 
                                            type="submit" 
                                            class="px-3.5 py-2 text-xs font-bold text-rose-600 hover:text-rose-800 hover:bg-rose-50 rounded-xl transition-colors cursor-pointer"
                                            title="Hapus Kategori dari Database"
                                        >
                                            Hapus Kategori
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-2 bg-white rounded-3xl p-12 text-center text-gray-400">
                            Belum ada kategori terdaftar di database. Silakan buat kategori baru di formulir atas.
                        </div>
                    @endforelse
                </div>
            </div>
            {{-- END TAB 2: CATEGORIES --}}

        </div>
    </div>
</x-app-layout>
