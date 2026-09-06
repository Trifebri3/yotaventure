<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="font-black text-2xl text-gray-900 leading-tight">
                    Kelola Kategori Publikasi & Foto (Gaya Dayan)
                </h2>
                <p class="text-sm text-gray-500 mt-1">
                    Atur foto latar belakang, judul dwibahasa, dan keterangan kartu kategori yang tampil di halaman Publikasi & Jurnal (/publikasi).
                </p>
            </div>
            <a 
                href="{{ route('public.articles.index') }}" 
                target="_blank"
                class="inline-flex items-center gap-2 px-4 py-2 bg-[#005952] hover:bg-[#004741] text-white text-xs font-bold tracking-wider uppercase rounded-xl transition-all shadow-sm"
            >
                Lihat di Halaman Publikasi ↗
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            @if(session('status'))
                <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold rounded-2xl flex items-center gap-3">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($categories as $category)
                    <div class="bg-white rounded-3xl border border-gray-200 shadow-sm p-6 overflow-hidden flex flex-col justify-between">
                        <div>
                            {{-- Preview Header --}}
                            <div class="flex items-center justify-between mb-4 pb-3 border-b border-gray-100">
                                <span class="px-3 py-1 rounded-full bg-teal-50 text-[#005952] text-xs font-bold font-mono uppercase">
                                    Slug: {{ $category->slug }}
                                </span>
                                <span class="text-xs text-gray-400">Urutan: #{{ $category->sort_order }}</span>
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
                                        {{ $category->subtitle_id }}
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

                                <div>
                                    <label class="block text-xs font-bold text-gray-700 mb-1">URL Foto (Unsplash / Tautan Langsung)</label>
                                    <input type="url" name="image_url" value="{{ old('image_url', $category->image_url) }}" class="w-full text-xs rounded-xl border-gray-300 focus:border-[#005952] focus:ring-[#005952]">
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-gray-700 mb-1">Atau Unggah File Foto Baru</label>
                                    <input type="file" name="image_file" accept="image/*" class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-teal-50 file:text-[#005952] hover:file:bg-teal-100">
                                </div>

                                <div class="pt-2 flex justify-end">
                                    <button type="submit" class="px-5 py-2.5 bg-[#005952] hover:bg-[#004741] text-white text-xs font-bold tracking-wider uppercase rounded-xl transition-all shadow-sm">
                                        Simpan Perubahan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
</x-app-layout>
