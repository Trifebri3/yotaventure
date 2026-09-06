<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <span class="text-xs font-bold tracking-widest text-[#005952] uppercase block">YOIN CMS & Navigasi Menu</span>
                <h2 class="font-black text-xl sm:text-2xl text-gray-900 leading-tight">
                    Manajemen 4 Foto & Kartu Sorotan Mega Menu
                </h2>
            </div>
            <div class="flex items-center gap-3">
                <a 
                    href="{{ route('admin.articles.index') }}" 
                    class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-white border border-gray-300 text-xs font-bold text-gray-700 hover:bg-gray-50 shadow-xs transition-colors"
                >
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                    <span>Kelola Artikel & Riset</span>
                </a>
                <a 
                    href="{{ url('/') }}" 
                    target="_blank" 
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-[#005952] hover:bg-[#004741] text-white text-xs font-bold uppercase tracking-wider shadow-sm transition-all"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    <span>Buka Web Publik</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-gray-50 min-h-screen">
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

            {{-- Information Banner --}}
            <div class="p-5 rounded-2xl bg-white border border-gray-200/90 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="space-y-1">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-[#005952]"></span>
                        <h3 class="text-sm font-bold text-gray-900">4 Foto Pilar Utama yang Tampil di Mega Menu Navigasi</h3>
                    </div>
                    <p class="text-xs text-gray-500 max-w-3xl leading-relaxed">
                        Anda dapat mengubah foto setiap kartu dengan memasukkan tautan (URL) gambar atau mengunggah file foto dari komputer. Data ini tersimpan di tabel database <code class="px-1.5 py-0.5 rounded bg-gray-100 font-mono text-[11px] text-[#005952]">menu_highlights</code> dan langsung tampil secara real-time di antarmuka publik.
                    </p>
                </div>
                <div class="text-right shrink-0">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-teal-50 border border-teal-200 text-[11px] font-bold text-[#005952]">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        Tersinkron Database MySQL
                    </span>
                </div>
            </div>

            {{-- 4 Cards Form Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($highlights as $item)
                    <div class="bg-white rounded-3xl border border-gray-200/90 shadow-xs overflow-hidden flex flex-col justify-between">
                        
                        {{-- Card Header --}}
                        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <span class="w-8 h-8 rounded-xl bg-teal-50 text-[#005952] border border-teal-200 font-black text-xs flex items-center justify-center">
                                    0{{ $item->sort_order }}
                                </span>
                                <div>
                                    <h4 class="text-sm font-extrabold text-gray-900">{{ $item->title_id }}</h4>
                                    <span class="text-[11px] text-gray-400 font-mono">{{ $item->title_en }}</span>
                                </div>
                            </div>
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-mono font-bold uppercase {{ $item->is_active ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-gray-100 text-gray-600' }}">
                                {{ $item->is_active ? 'Aktif di Menu' : 'Non-Aktif' }}
                            </span>
                        </div>

                        {{-- Card Form Body --}}
                        <form action="{{ route('admin.menu-highlights.update', $item->id) }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                            @csrf
                            @method('PUT')

                            {{-- Live Photo Preview --}}
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Pratinjau Foto Saat Ini</label>
                                <div class="relative h-44 rounded-2xl overflow-hidden border border-gray-200 bg-gray-950 group">
                                    <img src="{{ $item->image_url }}" alt="{{ $item->title_id }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent flex flex-col justify-between p-3.5">
                                        <span class="self-start px-2 py-0.5 rounded-full bg-black/60 backdrop-blur-md border border-white/20 text-[9px] font-mono font-bold text-[#00D0B7] uppercase">
                                            {{ $item->badge_id }}
                                        </span>
                                        <div>
                                            <span class="block text-[10px] text-white/70">{{ $item->subtitle_id }}</span>
                                            <span class="text-xs font-black text-white uppercase">{{ $item->title_id }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Photo Input: URL or Upload --}}
                            <div class="space-y-2">
                                <label for="image_url_{{ $item->id }}" class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                    Ganti Foto via URL (Tautan Web / Unsplash / Eksternal)
                                </label>
                                <input 
                                    type="text" 
                                    name="image_url" 
                                    id="image_url_{{ $item->id }}"
                                    value="{{ old('image_url', $item->image_url) }}" 
                                    placeholder="https://..." 
                                    class="w-full px-3.5 py-2.5 rounded-xl border border-gray-300 text-xs text-gray-900 focus:outline-none focus:border-[#005952] focus:ring-1 focus:ring-[#005952]"
                                >
                            </div>

                            <div class="space-y-2">
                                <label for="image_file_{{ $item->id }}" class="block text-xs font-bold text-gray-700 uppercase tracking-wider">
                                    Atau Unggah File Foto Baru (JPG, PNG, WebP)
                                </label>
                                <input 
                                    type="file" 
                                    name="image_file" 
                                    id="image_file_{{ $item->id }}"
                                    accept="image/*"
                                    class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-teal-50 file:text-[#005952] hover:file:bg-teal-100 cursor-pointer"
                                >
                            </div>

                            {{-- Bilingual Titles --}}
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-2">
                                <div>
                                    <label class="block text-[11px] font-bold text-gray-700 mb-1">Judul (Bahasa Indonesia)</label>
                                    <input 
                                        type="text" 
                                        name="title_id" 
                                        value="{{ old('title_id', $item->title_id) }}" 
                                        required
                                        class="w-full px-3 py-2 rounded-xl border border-gray-300 text-xs text-gray-900 focus:outline-none focus:border-[#005952]"
                                    >
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold text-gray-700 mb-1">Judul (English)</label>
                                    <input 
                                        type="text" 
                                        name="title_en" 
                                        value="{{ old('title_en', $item->title_en) }}" 
                                        required
                                        class="w-full px-3 py-2 rounded-xl border border-gray-300 text-xs text-gray-900 focus:outline-none focus:border-[#005952]"
                                    >
                                </div>
                            </div>

                            {{-- Subtitles --}}
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-[11px] font-bold text-gray-700 mb-1">Sub-keterangan (ID)</label>
                                    <input 
                                        type="text" 
                                        name="subtitle_id" 
                                        value="{{ old('subtitle_id', $item->subtitle_id) }}" 
                                        class="w-full px-3 py-2 rounded-xl border border-gray-300 text-xs text-gray-900 focus:outline-none focus:border-[#005952]"
                                    >
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold text-gray-700 mb-1">Sub-keterangan (EN)</label>
                                    <input 
                                        type="text" 
                                        name="subtitle_en" 
                                        value="{{ old('subtitle_en', $item->subtitle_en) }}" 
                                        class="w-full px-3 py-2 rounded-xl border border-gray-300 text-xs text-gray-900 focus:outline-none focus:border-[#005952]"
                                    >
                                </div>
                            </div>

                            {{-- Badge & Link URL --}}
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-[11px] font-bold text-gray-700 mb-1">Badge / Tag (ID)</label>
                                    <input 
                                        type="text" 
                                        name="badge_id" 
                                        value="{{ old('badge_id', $item->badge_id) }}" 
                                        class="w-full px-3 py-2 rounded-xl border border-gray-300 text-xs text-gray-900 focus:outline-none focus:border-[#005952]"
                                    >
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold text-gray-700 mb-1">Tautan Tujuan (Link URL)</label>
                                    <input 
                                        type="text" 
                                        name="link_url" 
                                        value="{{ old('link_url', $item->link_url) }}" 
                                        required
                                        class="w-full px-3 py-2 rounded-xl border border-gray-300 text-xs text-gray-900 focus:outline-none focus:border-[#005952]"
                                    >
                                </div>
                            </div>

                            {{-- Active Toggle & Submit Button --}}
                            <div class="pt-4 border-t border-gray-100 flex items-center justify-between">
                                <label class="inline-flex items-center gap-2 cursor-pointer">
                                    <input 
                                        type="checkbox" 
                                        name="is_active" 
                                        value="1" 
                                        {{ $item->is_active ? 'checked' : '' }}
                                        class="rounded text-[#005952] focus:ring-[#005952] border-gray-300"
                                    >
                                    <span class="text-xs font-semibold text-gray-700">Tampilkan di Menu</span>
                                </label>

                                <button 
                                    type="submit" 
                                    class="inline-flex items-center gap-1.5 px-5 py-2.5 rounded-xl bg-[#005952] hover:bg-[#004741] text-white text-xs font-bold tracking-wider uppercase shadow-xs transition-all hover:scale-105"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    <span>Simpan Perubahan</span>
                                </button>
                            </div>

                        </form>

                    </div>
                @endforeach
            </div>

            {{-- Database Direct SQL Guidance Box --}}
            <div class="p-6 rounded-3xl bg-gray-900 text-white border border-gray-800 shadow-sm space-y-3">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-[#00D0B7]"></span>
                    <h4 class="text-xs font-mono font-bold tracking-widest text-[#00D0B7] uppercase">Akses & Modifikasi Langsung via Database</h4>
                </div>
                <p class="text-xs text-gray-300 leading-relaxed">
                    Semua data dan foto kartu menu di atas tersimpan pada tabel MySQL <code class="font-mono text-teal-300 bg-white/10 px-1.5 py-0.5 rounded">menu_highlights</code>. Jika Anda ingin mengubah foto langsung via phpMyAdmin atau konsol SQL, gunakan perintah:
                </p>
                <div class="p-3.5 rounded-xl bg-black/60 border border-white/10 font-mono text-xs text-emerald-300 select-all overflow-x-auto">
                    UPDATE menu_highlights SET image_url = 'https://link-foto-baru-anda.jpg' WHERE id = 1;
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
