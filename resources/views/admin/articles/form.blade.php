<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <a href="{{ route('admin.articles.index') }}" class="text-xs font-bold text-[#005952] hover:underline flex items-center gap-1 mb-1">
                    <span>← Kembali ke Daftar Publikasi</span>
                </a>
                <h2 class="font-black text-xl sm:text-2xl text-gray-900 leading-tight">
                    {{ $isEdit ? 'Sunting Publikasi: '.$article->title : 'Tulis Artikel, Publikasi atau Jurnal Baru' }}
                </h2>
            </div>
            @if($isEdit && $article->slug)
                <a 
                    href="{{ route('public.articles.show', $article->slug) }}" 
                    target="_blank" 
                    class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-white border border-gray-300 text-xs font-bold text-gray-700 hover:bg-gray-50 shadow-xs transition-colors"
                >
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    <span>Lihat di Web Publik</span>
                </a>
            @endif
        </div>
    </x-slot>

    {{-- Quill Rich Text Editor CDN CSS & Word Pro Styles --}}
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />
    <style>
        /* Word Pro Suite Editor Custom Styling (Bilingual ID & EN) */
        #quill-editor-wrapper {
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }
        #quill-toolbar,
        #quill-toolbar-en {
            border-top-left-radius: 0.75rem;
            border-top-right-radius: 0.75rem;
            background: linear-gradient(180deg, #f8fafc 0%, #f1f5f9 100%);
            border-color: #cbd5e1;
            padding: 8px 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.03);
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 4px;
        }
        #quill-toolbar .ql-formats,
        #quill-toolbar-en .ql-formats {
            margin-right: 4px;
            display: inline-flex;
            align-items: center;
            gap: 2px;
        }
        #quill-toolbar button, 
        #quill-toolbar .ql-custom-btn,
        #quill-toolbar-en button, 
        #quill-toolbar-en .ql-custom-btn {
            border-radius: 6px;
            transition: all 0.15s ease;
            height: 28px;
            width: 28px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 4px;
            border: 1px solid transparent;
            color: #334155;
            cursor: pointer;
            background: transparent;
        }
        #quill-toolbar button:hover, 
        #quill-toolbar .ql-custom-btn:hover,
        #quill-toolbar-en button:hover, 
        #quill-toolbar-en .ql-custom-btn:hover {
            background-color: #ffffff !important;
            border-color: #cbd5e1 !important;
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
            color: #005952 !important;
        }
        #quill-toolbar button.ql-active,
        #quill-toolbar .ql-picker-label.ql-active,
        #quill-toolbar-en button.ql-active,
        #quill-toolbar-en .ql-picker-label.ql-active {
            background-color: #e6f4f2 !important;
            border-color: #005952 !important;
            color: #005952 !important;
            font-weight: bold;
        }
        #quill-toolbar .ql-picker,
        #quill-toolbar-en .ql-picker {
            border-radius: 6px;
            height: 28px;
            font-size: 11px;
            font-weight: 600;
            color: #334155;
            transition: all 0.15s ease;
        }
        #quill-toolbar .ql-picker-label,
        #quill-toolbar-en .ql-picker-label {
            border-radius: 6px;
            padding: 3px 8px;
            border: 1px solid #cbd5e1;
            background-color: #ffffff;
            display: flex;
            align-items: center;
        }
        #quill-toolbar .ql-picker-label:hover,
        #quill-toolbar-en .ql-picker-label:hover {
            border-color: #005952;
            color: #005952;
        }
        #quill-toolbar .ql-picker-options,
        #quill-toolbar-en .ql-picker-options {
            border-radius: 8px;
            box-shadow: 0 10px 25px -5px rgba(0,0,0,0.15);
            border-color: #cbd5e1;
            padding: 6px;
            z-index: 50;
        }

        /* Custom Word-like picker text labels */
        .ql-snow .ql-picker.ql-font .ql-picker-label::before,
        .ql-snow .ql-picker.ql-font .ql-picker-item::before { content: 'Sans-Serif'; }
        .ql-snow .ql-picker.ql-font .ql-picker-label[data-value="serif"]::before,
        .ql-snow .ql-picker.ql-font .ql-picker-item[data-value="serif"]::before { content: 'Serif (Klasik)'; font-family: Georgia, serif; }
        .ql-snow .ql-picker.ql-font .ql-picker-label[data-value="monospace"]::before,
        .ql-snow .ql-picker.ql-font .ql-picker-item[data-value="monospace"]::before { content: 'Monospace'; font-family: monospace; }

        .ql-snow .ql-picker.ql-size .ql-picker-label::before,
        .ql-snow .ql-picker.ql-size .ql-picker-item::before { content: 'Normal (12pt)'; }
        .ql-snow .ql-picker.ql-size .ql-picker-label[data-value="small"]::before,
        .ql-snow .ql-picker.ql-size .ql-picker-item::before { content: 'Kecil (10pt)'; }
        .ql-snow .ql-picker.ql-size .ql-picker-label[data-value="large"]::before,
        .ql-snow .ql-picker.ql-size .ql-picker-item::before { content: 'Besar (16pt)'; }
        .ql-snow .ql-picker.ql-size .ql-picker-label[data-value="huge"]::before,
        .ql-snow .ql-picker.ql-size .ql-picker-item::before { content: 'Sangat Besar (24pt)'; }

        .ql-snow .ql-picker.ql-header .ql-picker-label::before,
        .ql-snow .ql-picker.ql-header .ql-picker-item::before { content: 'Paragraf'; }
        .ql-snow .ql-picker.ql-header .ql-picker-label[data-value="1"]::before,
        .ql-snow .ql-picker.ql-header .ql-picker-item[data-value="1"]::before { content: 'Judul 1 (H1)'; font-weight: bold; }
        .ql-snow .ql-picker.ql-header .ql-picker-label[data-value="2"]::before,
        .ql-snow .ql-picker.ql-header .ql-picker-item[data-value="2"]::before { content: 'Judul 2 (H2)'; font-weight: bold; }
        .ql-snow .ql-picker.ql-header .ql-picker-label[data-value="3"]::before,
        .ql-snow .ql-picker.ql-header .ql-picker-item[data-value="3"]::before { content: 'Subjudul (H3)'; }
        .ql-snow .ql-picker.ql-header .ql-picker-label[data-value="4"]::before,
        .ql-snow .ql-picker.ql-header .ql-picker-item[data-value="4"]::before { content: 'Sub-bab (H4)'; }

        /* Document Canvas Paper Effect */
        #quill-editor,
        #quill-editor-en {
            min-height: 480px;
            font-size: 15.5px;
            line-height: 1.8;
            color: #1e293b;
            background-color: #ffffff;
            padding: 2rem 2.5rem;
            border-bottom-left-radius: 0.75rem;
            border-bottom-right-radius: 0.75rem;
            border-color: #cbd5e1;
            font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        }
        #quill-editor.ql-blank::before {
            color: #94a3b8;
            font-style: italic;
            left: 2.5rem;
            right: 2.5rem;
        }
        #quill-editor-en.ql-blank::before {
            color: #94a3b8;
            font-style: italic;
            left: 2.5rem;
            right: 2.5rem;
        }

        /* Video Embed & Image inside Editor */
        #quill-editor iframe.ql-video,
        #quill-editor-en iframe.ql-video {
            width: 100%;
            aspect-ratio: 16 / 9;
            min-height: 320px;
            border-radius: 0.875rem;
            margin: 1.5rem 0;
            box-shadow: 0 10px 25px -5px rgba(0,0,0,0.12);
            border: 1px solid #cbd5e1;
            display: block;
        }
        #quill-editor img,
        #quill-editor-en img {
            max-width: 100%;
            height: auto;
            border-radius: 0.875rem;
            margin: 1.5rem auto;
            display: block;
            box-shadow: 0 8px 20px -4px rgba(0,0,0,0.1);
            border: 1px solid #e2e8f0;
            transition: all 0.2s;
        }
        #quill-editor img:hover,
        #quill-editor-en img:hover {
            outline: 3px solid #005952;
            cursor: pointer;
        }

        /* Image alignment inside editor */
        #quill-editor .ql-align-center img,
        #quill-editor-en .ql-align-center img { margin-left: auto; margin-right: auto; display: block; }
        #quill-editor .ql-align-right img,
        #quill-editor-en .ql-align-right img { margin-left: auto; margin-right: 0; display: block; }
        #quill-editor .ql-align-left img,
        #quill-editor-en .ql-align-left img { margin-left: 0; margin-right: auto; display: block; }

        /* Fullscreen Word Document Mode */
        .fullscreen-word-mode {
            position: fixed !important;
            inset: 0 !important;
            z-index: 99999 !important;
            background-color: #f1f5f9 !important;
            padding: 1rem !important;
            overflow-y: auto !important;
            display: flex !important;
            flex-direction: column !important;
            height: 100vh !important;
            width: 100vw !important;
        }
        .fullscreen-word-mode #quill-toolbar,
        .fullscreen-word-mode #quill-toolbar-en {
            position: sticky;
            top: 0;
            z-index: 50;
            border-radius: 0.75rem 0.75rem 0 0;
            max-width: 1100px;
            margin: 0 auto;
            width: 100%;
        }
        .fullscreen-word-mode #quill-editor,
        .fullscreen-word-mode #quill-editor-en {
            max-width: 1100px;
            margin: 0 auto;
            width: 100%;
            min-height: calc(100vh - 160px);
            box-shadow: 0 20px 40px -15px rgba(0,0,0,0.15);
        }
        .fullscreen-word-mode .editor-status-bar {
            max-width: 1100px;
            margin: 0 auto;
            width: 100%;
        }
    </style>

    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Validation Errors Notification --}}
            @if ($errors->any())
                <div class="mb-6 p-4 rounded-2xl bg-red-50 border border-red-200 text-red-800 text-xs">
                    <p class="font-bold mb-1">Terdapat kesalahan input formulir:</p>
                    <ul class="list-disc list-inside space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form 
                method="POST" 
                action="{{ $isEdit ? route('admin.articles.update', $article->id) : route('admin.articles.store') }}" 
                enctype="multipart/form-data"
                class="space-y-6"
                id="article-form"
            >
                @csrf
                @if($isEdit)
                    @method('PUT')
                @endif

                {{-- 1. MAIN CARD: TITLE, SLUG, CATEGORY, METRICS --}}
                <div class="bg-white p-6 sm:p-8 rounded-2xl border border-gray-200 shadow-xs space-y-6">
                    <div class="border-b border-gray-100 pb-4 flex items-center justify-between">
                        <span class="text-xs font-bold tracking-wider uppercase text-[#005952]">Informasi Pokok Publikasi</span>
                        <span class="text-[11px] text-gray-400">* Wajib diisi</span>
                    </div>

                    {{-- Title ID & EN --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="title" class="block text-xs font-bold text-gray-800 uppercase tracking-wider mb-1.5">
                                Judul Publikasi / Artikel (Bahasa Indonesia) *
                            </label>
                            <input 
                                type="text" 
                                id="title" 
                                name="title" 
                                value="{{ old('title', $article->title) }}" 
                                required 
                                placeholder="Contoh: Kedaulatan Energi Terbarukan di Kepulauan Nusantara" 
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50/50 focus:bg-white focus:border-[#005952] focus:ring-2 focus:ring-[#005952]/20 text-sm font-semibold text-gray-900 outline-none transition-all"
                            >
                        </div>
                        <div>
                            <label for="title_en" class="block text-xs font-bold text-gray-800 uppercase tracking-wider mb-1.5 flex items-center justify-between">
                                <span>Judul Bahasa Inggris (English Title)</span>
                                <span class="text-[10px] text-[#005952] font-mono font-bold">Bilingual EN</span>
                            </label>
                            <input 
                                type="text" 
                                id="title_en" 
                                name="title_en" 
                                value="{{ old('title_en', $article->title_en) }}" 
                                placeholder="Example: Renewable Energy Sovereignty Across Archipelago" 
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50/50 focus:bg-white focus:border-[#005952] focus:ring-2 focus:ring-[#005952]/20 text-sm font-semibold text-gray-900 outline-none transition-all"
                            >
                        </div>
                    </div>

                    {{-- Slug & Auto-generator --}}
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label for="slug" class="block text-xs font-bold text-gray-800 uppercase tracking-wider">
                                Slug URL (Permalink)
                            </label>
                            <span class="text-[10px] text-gray-400">Otomatis digenerasi dari judul bila dikosongkan</span>
                        </div>
                        <div class="flex items-center rounded-xl border border-gray-200 bg-gray-50/70 overflow-hidden">
                            <span class="px-3.5 py-3 text-xs text-gray-500 font-mono select-none bg-gray-100/80 border-r border-gray-200">
                                /publikasi/
                            </span>
                            <input 
                                type="text" 
                                id="slug" 
                                name="slug" 
                                value="{{ old('slug', $article->slug) }}" 
                                placeholder="kedaulatan-energi-terbarukan-nusantara" 
                                class="w-full px-3 py-3 text-xs text-gray-800 font-mono bg-transparent focus:bg-white outline-none"
                            >
                        </div>
                    </div>

                    {{-- Grid: Type, Tag, Badge, Author --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        {{-- Type / Category --}}
                        <div>
                            <label for="type" class="block text-xs font-bold text-gray-800 uppercase tracking-wider mb-1.5">
                                Kategori Terbitan *
                            </label>
                            <select 
                                id="type" 
                                name="type" 
                                required 
                                class="w-full px-3 py-2.5 rounded-xl border border-gray-200 bg-gray-50/50 focus:bg-white focus:border-[#005952] text-xs font-semibold text-gray-800 outline-none"
                            >
                                @if(isset($categories) && $categories->count() > 0)
                                    @foreach($categories as $category)
                                        <option value="{{ $category->slug }}" {{ old('type', $article->type) === $category->slug ? 'selected' : '' }}>
                                            {{ $category->name_id }} ({{ $category->name_en }})
                                        </option>
                                    @endforeach
                                @else
                                    <option value="artikel" {{ old('type', $article->type) === 'artikel' ? 'selected' : '' }}>Artikel</option>
                                    <option value="inisiatif" {{ old('type', $article->type) === 'inisiatif' ? 'selected' : '' }}>Inisiatif</option>
                                    <option value="publikasi" {{ old('type', $article->type) === 'publikasi' ? 'selected' : '' }}>Publikasi</option>
                                    <option value="jurnal" {{ old('type', $article->type) === 'jurnal' ? 'selected' : '' }}>Jurnal Riset</option>
                                @endif
                            </select>
                        </div>

                        {{-- Tag ID & EN --}}
                        <div>
                            <label for="tag" class="block text-xs font-bold text-gray-800 uppercase tracking-wider mb-1.5">
                                Label / Tag (ID & EN)
                            </label>
                            <input 
                                type="text" 
                                id="tag" 
                                name="tag" 
                                value="{{ old('tag', $article->tag) }}" 
                                placeholder="Tag ID: Energi Bersih" 
                                class="w-full px-3 py-2 rounded-xl border border-gray-200 bg-gray-50/50 focus:bg-white focus:border-[#005952] text-xs text-gray-800 outline-none"
                            >
                            <input 
                                type="text" 
                                id="tag_en" 
                                name="tag_en" 
                                value="{{ old('tag_en', $article->tag_en) }}" 
                                placeholder="Tag EN: Clean Energy" 
                                class="w-full mt-1.5 px-3 py-1.5 rounded-lg border border-gray-200 bg-gray-50/30 text-[11px] text-gray-800 outline-none"
                            >
                        </div>

                        {{-- Badge ID & EN --}}
                        <div>
                            <label for="badge" class="block text-xs font-bold text-gray-800 uppercase tracking-wider mb-1.5">
                                Badge Capaian (ID & EN)
                            </label>
                            <input 
                                type="text" 
                                id="badge" 
                                name="badge" 
                                value="{{ old('badge', $article->badge) }}" 
                                placeholder="Badge ID: Target 500 MW" 
                                class="w-full px-3 py-2 rounded-xl border border-gray-200 bg-gray-50/50 focus:bg-white focus:border-[#005952] text-xs text-gray-800 outline-none"
                            >
                            <input 
                                type="text" 
                                id="badge_en" 
                                name="badge_en" 
                                value="{{ old('badge_en', $article->badge_en) }}" 
                                placeholder="Badge EN: 500 MW Target" 
                                class="w-full mt-1.5 px-3 py-1.5 rounded-lg border border-gray-200 bg-gray-50/30 text-[11px] text-gray-800 outline-none"
                            >
                        </div>

                        {{-- Author Name --}}
                        <div>
                            <label for="author_name" class="block text-xs font-bold text-gray-800 uppercase tracking-wider mb-1.5">
                                Penulis / Tim Riset *
                            </label>
                            <input 
                                type="text" 
                                id="author_name" 
                                name="author_name" 
                                value="{{ old('author_name', $article->author_name ?? 'Tim Riset YOIN') }}" 
                                required 
                                class="w-full px-3 py-2.5 rounded-xl border border-gray-200 bg-gray-50/50 focus:bg-white focus:border-[#005952] text-xs text-gray-800 outline-none"
                            >
                        </div>
                    </div>

                    {{-- Cover Image (File Upload & URL with Instant Preview) --}}
                    <div 
                        x-data="{ 
                            coverUrl: '{{ old('cover_image', $article->cover_image) }}',
                            fileName: '',
                            previewSrc: '{{ old('cover_image', $article->cover_image) }}',
                            handleFileSelect(event) {
                                const file = event.target.files[0];
                                if (file) {
                                    this.fileName = file.name;
                                    this.previewSrc = URL.createObjectURL(file);
                                }
                            },
                            removeFile() {
                                this.fileName = '';
                                this.previewSrc = this.coverUrl;
                                const fileInput = document.getElementById('cover_image_file');
                                if (fileInput) fileInput.value = '';
                            }
                        }"
                        class="bg-gray-50/70 p-5 rounded-2xl border border-gray-200 space-y-4"
                    >
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-1">
                            <div>
                                <label class="block text-xs font-bold text-gray-800 uppercase tracking-wider">
                                    Gambar Sampul Publikasi (Cover Image)
                                </label>
                                <p class="text-[11px] text-gray-500">
                                    Unggah langsung berkas gambar dari perangkat Anda atau cantumkan tautan URL gambar.
                                </p>
                            </div>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-mono bg-teal-50 text-[#005952] border border-teal-200">
                                Rasio 16:9 (Min. 1200x630 px)
                            </span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            {{-- Option 1: File Upload --}}
                            <div class="space-y-1.5">
                                <label for="cover_image_file" class="block text-[11px] font-bold text-gray-700">
                                    📁 Unggah Berkas Gambar (JPG, PNG, WEBP)
                                </label>
                                <div class="relative flex items-center">
                                    <input 
                                        type="file" 
                                        id="cover_image_file" 
                                        name="cover_image_file" 
                                        accept="image/jpeg,image/png,image/jpg,image/webp,image/gif" 
                                        @change="handleFileSelect($event)"
                                        class="block w-full text-xs text-gray-600 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#005952] file:text-white hover:file:bg-[#004741] file:cursor-pointer border border-gray-300 rounded-xl p-1.5 bg-white cursor-pointer transition-colors"
                                    >
                                </div>
                                <template x-if="fileName">
                                    <div class="flex items-center justify-between text-[11px] text-emerald-700 bg-emerald-50 px-3 py-1.5 rounded-lg border border-emerald-200">
                                        <span class="truncate font-medium" x-text="'File terpilih: ' + fileName"></span>
                                        <button type="button" @click="removeFile()" class="text-rose-600 hover:text-rose-800 font-bold ml-2">Batal</button>
                                    </div>
                                </template>
                            </div>

                            {{-- Option 2: Image URL --}}
                            <div class="space-y-1.5">
                                <label for="cover_image" class="block text-[11px] font-bold text-gray-700">
                                    🔗 Atau Tautan URL Gambar (Opsional)
                                </label>
                                <input 
                                    type="text" 
                                    id="cover_image" 
                                    name="cover_image" 
                                    x-model="coverUrl" 
                                    @input="if(!fileName) previewSrc = coverUrl"
                                    placeholder="https://images.unsplash.com/... atau /foto/..." 
                                    class="w-full px-3.5 py-2.5 rounded-xl border border-gray-300 bg-white focus:border-[#005952] focus:ring-1 focus:ring-[#005952] text-xs text-gray-800 outline-none transition-colors"
                                >
                            </div>
                        </div>

                        {{-- Instant Visual Preview Card --}}
                        <div class="pt-3 border-t border-gray-200/80 flex flex-col sm:flex-row sm:items-center gap-4">
                            <template x-if="previewSrc">
                                <div class="relative w-48 h-28 rounded-xl overflow-hidden border border-gray-300 shadow-sm bg-gray-900 shrink-0 group">
                                    <img :src="previewSrc" alt="Preview Sampul" class="w-full h-full object-cover">
                                    <span class="absolute bottom-1.5 right-1.5 px-2 py-0.5 rounded bg-black/70 text-[9px] text-white font-mono tracking-wider">
                                        Social Preview
                                    </span>
                                </div>
                            </template>
                            <template x-if="!previewSrc">
                                <div class="w-48 h-28 rounded-xl border-2 border-dashed border-gray-300 flex flex-col items-center justify-center text-gray-400 shrink-0 bg-gray-100/50">
                                    <svg class="w-6 h-6 mb-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    <span class="text-[10px] font-semibold">Belum Ada Gambar</span>
                                </div>
                            </template>
                            <div class="text-[11px] text-gray-500 leading-relaxed">
                                <p class="font-bold text-gray-700 mb-0.5">Preview Tampilan Thumbnail Media Sosial & Google</p>
                                <p>Gambar ini akan muncul secara otomatis saat artikel dibagikan ke WhatsApp, LinkedIn, X/Twitter, Telegram, serta dioptimalkan untuk thumbnail pencarian Google.</p>
                            </div>
                        </div>
                    </div>

                    {{-- Excerpt Summary ID & EN --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <label for="excerpt" class="block text-xs font-bold text-gray-800 uppercase tracking-wider">
                                    Ringkasan Eksekutif (Bahasa Indonesia)
                                </label>
                            </div>
                            <textarea 
                                id="excerpt" 
                                name="excerpt" 
                                rows="2" 
                                placeholder="Tuliskan 1 - 2 kalimat intisari pembahasan artikel..." 
                                class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50/50 focus:bg-white focus:border-[#005952] text-xs sm:text-sm text-gray-800 outline-none resize-none"
                            >{{ old('excerpt', $article->excerpt) }}</textarea>
                        </div>
                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <label for="excerpt_en" class="block text-xs font-bold text-gray-800 uppercase tracking-wider">
                                    Executive Summary (English)
                                </label>
                                <span class="text-[10px] text-[#005952] font-mono font-bold">Bilingual EN</span>
                            </div>
                            <textarea 
                                id="excerpt_en" 
                                name="excerpt_en" 
                                rows="2" 
                                placeholder="Write 1 - 2 sentences summary in English..." 
                                class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50/50 focus:bg-white focus:border-[#005952] text-xs sm:text-sm text-gray-800 outline-none resize-none"
                            >{{ old('excerpt_en', $article->excerpt_en) }}</textarea>
                        </div>
                    </div>

                </div>

                {{-- 2. DUAL RICH TEXT QUILL EDITOR SUITE: MICROSOFT WORD WORD-PRO (ID & EN) --}}
                <div id="quill-editor-wrapper" class="bg-white p-5 sm:p-7 rounded-2xl border border-gray-200 shadow-xs space-y-5">
                    {{-- Header with Title & Overall Tools --}}
                    <div class="flex flex-col lg:flex-row lg:items-center justify-between border-b border-gray-100 pb-4 gap-4">
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-black tracking-wider uppercase text-[#005952] flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-[#005952]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    Isi Konten & Naskah Publikasi (Bilingual Word Pro Suite)
                                </span>
                                <span class="px-2 py-0.5 rounded-full bg-emerald-100 text-[#005952] text-[10px] font-extrabold uppercase tracking-wider">Word Pro Suite</span>
                                <span class="px-2 py-0.5 rounded-full bg-slate-100 border border-slate-200 text-slate-700 text-[10px] font-mono font-bold">Dua Bahasa (ID & EN)</span>
                            </div>
                            <span class="text-[11px] text-gray-500">Mendukung editor kaya untuk Bahasa Indonesia dan Bahasa Inggris secara terpisah dengan formatting Word lengkap, gambar, dan video.</span>
                        </div>
                        
                        {{-- Action Buttons (applies to active editor) --}}
                        <div class="flex items-center flex-wrap gap-2">
                            <button 
                                type="button" 
                                onclick="copyIdToEn()"
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-amber-50 hover:bg-amber-100 text-amber-900 border border-amber-200 text-xs font-bold transition-all shadow-xs cursor-pointer"
                                title="Salin seluruh isi & media dari editor Bahasa Indonesia ke editor Bahasa Inggris untuk diterjemahkan"
                            >
                                <svg class="w-3.5 h-3.5 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                <span>Salin ID ke EN</span>
                            </button>

                            <button 
                                type="button" 
                                onclick="openImageModal()"
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-teal-50 hover:bg-teal-100 text-[#005952] border border-teal-200 text-xs font-bold transition-all shadow-xs cursor-pointer"
                                title="Sisipkan Foto / Gambar ke Dokumen Aktif"
                            >
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <span>+ Gambar</span>
                            </button>

                            <button 
                                type="button" 
                                onclick="openVideoModal()"
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 text-xs font-bold transition-all shadow-xs cursor-pointer"
                                title="Sisipkan Video YouTube / Vimeo ke Dokumen Aktif"
                            >
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg>
                                <span>+ Video YouTube</span>
                            </button>

                            <button 
                                type="button" 
                                id="btn-fullscreen-toggle"
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 border border-gray-300 text-xs font-bold transition-all shadow-xs cursor-pointer"
                                title="Buka / Tutup Mode Layar Penuh Dokumen Word"
                            >
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/></svg>
                                <span id="fullscreen-text">Layar Penuh</span>
                            </button>
                        </div>
                    </div>

                    {{-- Language Tabs & View Mode Switcher --}}
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-gray-50/80 p-2 rounded-xl border border-gray-200">
                        {{-- Language Tabs --}}
                        <div class="flex items-center gap-2">
                            <button 
                                type="button" 
                                id="tab-editor-id-btn" 
                                onclick="switchContentTab('id')"
                                class="px-4 py-2 rounded-lg text-xs font-extrabold flex items-center gap-2 transition-all bg-white text-[#005952] border border-gray-200 shadow-xs cursor-pointer"
                            >
                                <span>🇮🇩 Bahasa Indonesia *</span>
                                <span id="badge-word-id" class="px-1.5 py-0.5 rounded bg-teal-50 text-[10px] font-mono text-[#005952]">0 kata</span>
                            </button>
                            <button 
                                type="button" 
                                id="tab-editor-en-btn" 
                                onclick="switchContentTab('en')"
                                class="px-4 py-2 rounded-lg text-xs font-bold flex items-center gap-2 transition-all text-gray-600 hover:text-gray-900 border border-transparent cursor-pointer"
                            >
                                <span>🇬🇧 English Manuscript (Bilingual EN)</span>
                                <span id="badge-word-en" class="px-1.5 py-0.5 rounded bg-gray-100 text-[10px] font-mono text-gray-600">0 words</span>
                            </button>
                        </div>

                        {{-- View Toggle (Tab Mode vs Berdampingan / Split) --}}
                        <div class="flex items-center gap-1.5 self-end sm:self-auto text-xs font-semibold text-gray-500">
                            <span class="text-[11px] text-gray-400 hidden md:inline">Mode Tampilan:</span>
                            <button 
                                type="button" 
                                id="btn-view-tab" 
                                onclick="setViewMode('tab')"
                                class="px-2.5 py-1 rounded-md text-[11px] font-bold bg-[#005952] text-white transition-all cursor-pointer"
                            >
                                Tab Tunggal
                            </button>
                            <button 
                                type="button" 
                                id="btn-view-split" 
                                onclick="setViewMode('split')"
                                class="px-2.5 py-1 rounded-md text-[11px] font-bold bg-white text-gray-600 hover:text-gray-900 border border-gray-200 transition-all cursor-pointer"
                            >
                                Berdampingan (Split)
                            </button>
                        </div>
                    </div>

                    {{-- Editors Container --}}
                    <div id="editors-container" class="grid grid-cols-1 gap-6">

                        {{-- PANE 1: BAHASA INDONESIA --}}
                        <div id="pane-editor-id" class="space-y-2">
                            <div class="flex items-center justify-between px-1">
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-[#005952]"></span>
                                    <span class="text-xs font-bold text-gray-800 uppercase tracking-wider">Naskah Versi Bahasa Indonesia *</span>
                                </div>
                                <span class="text-[11px] text-gray-400">Naskah primer publikasi</span>
                            </div>

                            <div class="rounded-xl border border-gray-300 overflow-hidden shadow-xs">
                                <div id="quill-toolbar">
                                    {{-- 1. Undo / Redo --}}
                                    <span class="ql-formats">
                                        <button type="button" id="btn-undo" title="Urungkan (Undo) [Ctrl+Z]">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a5 5 0 015 5v2m0 0l-4-4m4 4l4-4M3 10l4-4m-4 4l4 4"/></svg>
                                        </button>
                                        <button type="button" id="btn-redo" title="Ulangi (Redo) [Ctrl+Y]">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 10H11a5 5 0 00-5 5v2m0 0l4-4m-4 4l-4-4m15-3l-4-4m4 4l-4 4"/></svg>
                                        </button>
                                    </span>

                                    <span class="h-4 w-[1px] bg-gray-300 mx-1"></span>

                                    {{-- 2. Font, Size, Header --}}
                                    <span class="ql-formats">
                                        <select class="ql-font" title="Jenis Huruf / Font">
                                            <option selected>Sans-Serif</option>
                                            <option value="serif">Serif</option>
                                            <option value="monospace">Monospace</option>
                                        </select>
                                        <select class="ql-size" title="Ukuran Huruf">
                                            <option value="small">Kecil</option>
                                            <option selected>Normal</option>
                                            <option value="large">Besar</option>
                                            <option value="huge">Sangat Besar</option>
                                        </select>
                                        <select class="ql-header" title="Gaya Judul & Paragraf">
                                            <option value="1">Judul 1 (H1)</option>
                                            <option value="2">Judul 2 (H2)</option>
                                            <option value="3">Subjudul (H3)</option>
                                            <option value="4">Sub-bab (H4)</option>
                                            <option selected>Paragraf</option>
                                        </select>
                                    </span>

                                    <span class="h-4 w-[1px] bg-gray-300 mx-1"></span>

                                    {{-- 3. Text Styles --}}
                                    <span class="ql-formats">
                                        <button class="ql-bold" title="Tebal (Bold) [Ctrl+B]"></button>
                                        <button class="ql-italic" title="Miring (Italic) [Ctrl+I]"></button>
                                        <button class="ql-underline" title="Garis Bawah (Underline) [Ctrl+U]"></button>
                                        <button class="ql-strike" title="Coret Teks (Strikethrough)"></button>
                                        <button class="ql-script" value="sub" title="Subskrip (Bawah)"></button>
                                        <button class="ql-script" value="super" title="Superskrip (Pangkat)"></button>
                                    </span>

                                    <span class="h-4 w-[1px] bg-gray-300 mx-1"></span>

                                    {{-- 4. Colors --}}
                                    <span class="ql-formats">
                                        <select class="ql-color" title="Warna Huruf / Teks"></select>
                                        <select class="ql-background" title="Warna Stabilo (Highlight)"></select>
                                    </span>

                                    <span class="h-4 w-[1px] bg-gray-300 mx-1"></span>

                                    {{-- 5. Alignment --}}
                                    <span class="ql-formats">
                                        <select class="ql-align" title="Perataan Paragraf (Kiri, Tengah, Kanan, Justify)"></select>
                                    </span>

                                    <span class="h-4 w-[1px] bg-gray-300 mx-1"></span>

                                    {{-- 6. Lists & Indentation --}}
                                    <span class="ql-formats">
                                        <button class="ql-list" value="ordered" title="Penomoran Otomatis 1, 2, 3"></button>
                                        <button class="ql-list" value="bullet" title="Daftar Poin (Bullets)"></button>
                                        <button class="ql-list" value="check" title="Daftar Tugas (Checklist)"></button>
                                        <button class="ql-indent" value="-1" title="Kurangi Indentasi"></button>
                                        <button class="ql-indent" value="+1" title="Tambah Indentasi"></button>
                                    </span>

                                    <span class="h-4 w-[1px] bg-gray-300 mx-1"></span>

                                    {{-- 7. Blockquote & Code Block --}}
                                    <span class="ql-formats">
                                        <button class="ql-blockquote" title="Kutipan Khusus (Blockquote)"></button>
                                        <button class="ql-code-block" title="Kotak Kode Pemrograman"></button>
                                    </span>

                                    <span class="h-4 w-[1px] bg-gray-300 mx-1"></span>

                                    {{-- 8. Inserts: Link, Image, Video, Divider --}}
                                    <span class="ql-formats">
                                        <button class="ql-link" title="Sisipkan Tautan Web (Link) [Ctrl+K]"></button>
                                        <button type="button" onclick="openImageModal('id')" title="Sisipkan Foto / Gambar (Upload & URL)" class="ql-custom-btn">
                                            <svg class="w-3.5 h-3.5 text-teal-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        </button>
                                        <button type="button" onclick="openVideoModal('id')" title="Sisipkan Video (YouTube, Vimeo)" class="ql-custom-btn">
                                            <svg class="w-3.5 h-3.5 text-red-600" fill="currentColor" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg>
                                        </button>
                                        <button type="button" id="btn-insert-hr" title="Sisipkan Garis Pembatas (Horizontal Rule)" class="ql-custom-btn">
                                            <svg class="w-3.5 h-3.5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/></svg>
                                        </button>
                                    </span>

                                    <span class="h-4 w-[1px] bg-gray-300 mx-1"></span>

                                    {{-- 9. Clean Format --}}
                                    <span class="ql-formats">
                                        <button class="ql-clean" title="Hapus Semua Format"></button>
                                    </span>
                                </div>

                                {{-- Quill Canvas Paper ID --}}
                                <div id="quill-editor">
                                    {!! old('content', $article->content) !!}
                                </div>

                                {{-- Fallback content textarea ensuring submission always succeeds --}}
                                <textarea 
                                    name="content" 
                                    id="hidden-content" 
                                    style="display: none;" 
                                    rows="14" 
                                    placeholder="Tuliskan naskah lengkap artikel di sini..."
                                    class="w-full p-4 text-sm font-sans text-gray-800 border-none outline-none focus:ring-0 resize-y"
                                >{{ old('content', $article->content) }}</textarea>

                                {{-- Status Bar & Live Metrics ID --}}
                                <div class="editor-status-bar bg-slate-50 border-t border-gray-200 px-4 py-2 flex flex-wrap items-center justify-between text-xs text-gray-500 gap-2">
                                    <div class="flex items-center gap-3">
                                        <span class="font-semibold text-gray-700" id="stat-words">0 Kata</span>
                                        <span class="text-gray-300">•</span>
                                        <span id="stat-chars">0 Karakter</span>
                                        <span class="text-gray-300">•</span>
                                        <span id="stat-read-time">~1 Menit Baca</span>
                                    </div>
                                    <div class="flex items-center gap-2 text-[11px] text-gray-400 hidden sm:flex">
                                        <span class="inline-flex items-center gap-1 text-emerald-600 font-medium">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                            Tersinkronisasi ID
                                        </span>
                                        <span>•</span>
                                        <span>Tarik & lepas gambar atau Ctrl+V ke naskah</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- PANE 2: ENGLISH (BILINGUAL EN) --}}
                        <div id="pane-editor-en" class="space-y-2 hidden">
                            <div class="flex items-center justify-between px-1">
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                                    <span class="text-xs font-bold text-gray-800 uppercase tracking-wider">English Publication Content & Manuscript *</span>
                                </div>
                                <span class="text-[11px] text-[#005952] font-mono font-bold">Bilingual EN (Optional)</span>
                            </div>

                            <div class="rounded-xl border border-gray-300 overflow-hidden shadow-xs">
                                <div id="quill-toolbar-en">
                                    {{-- 1. Undo / Redo --}}
                                    <span class="ql-formats">
                                        <button type="button" id="btn-undo-en" title="Undo [Ctrl+Z]">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a5 5 0 015 5v2m0 0l-4-4m4 4l4-4M3 10l4-4m-4 4l4 4"/></svg>
                                        </button>
                                        <button type="button" id="btn-redo-en" title="Redo [Ctrl+Y]">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 10H11a5 5 0 00-5 5v2m0 0l4-4m-4 4l-4-4m15-3l-4-4m4 4l-4 4"/></svg>
                                        </button>
                                    </span>

                                    <span class="h-4 w-[1px] bg-gray-300 mx-1"></span>

                                    {{-- 2. Font, Size, Header --}}
                                    <span class="ql-formats">
                                        <select class="ql-font" title="Font Family">
                                            <option selected>Sans-Serif</option>
                                            <option value="serif">Serif</option>
                                            <option value="monospace">Monospace</option>
                                        </select>
                                        <select class="ql-size" title="Font Size">
                                            <option value="small">Small</option>
                                            <option selected>Normal</option>
                                            <option value="large">Large</option>
                                            <option value="huge">Huge</option>
                                        </select>
                                        <select class="ql-header" title="Headings & Paragraphs">
                                            <option value="1">Heading 1 (H1)</option>
                                            <option value="2">Heading 2 (H2)</option>
                                            <option value="3">Subheading (H3)</option>
                                            <option value="4">Sub-section (H4)</option>
                                            <option selected>Paragraph</option>
                                        </select>
                                    </span>

                                    <span class="h-4 w-[1px] bg-gray-300 mx-1"></span>

                                    {{-- 3. Text Styles --}}
                                    <span class="ql-formats">
                                        <button class="ql-bold" title="Bold [Ctrl+B]"></button>
                                        <button class="ql-italic" title="Italic [Ctrl+I]"></button>
                                        <button class="ql-underline" title="Underline [Ctrl+U]"></button>
                                        <button class="ql-strike" title="Strikethrough"></button>
                                        <button class="ql-script" value="sub" title="Subscript"></button>
                                        <button class="ql-script" value="super" title="Superscript"></button>
                                    </span>

                                    <span class="h-4 w-[1px] bg-gray-300 mx-1"></span>

                                    {{-- 4. Colors --}}
                                    <span class="ql-formats">
                                        <select class="ql-color" title="Font Color"></select>
                                        <select class="ql-background" title="Highlight Color"></select>
                                    </span>

                                    <span class="h-4 w-[1px] bg-gray-300 mx-1"></span>

                                    {{-- 5. Alignment --}}
                                    <span class="ql-formats">
                                        <select class="ql-align" title="Paragraph Alignment (Left, Center, Right, Justify)"></select>
                                    </span>

                                    <span class="h-4 w-[1px] bg-gray-300 mx-1"></span>

                                    {{-- 6. Lists & Indentation --}}
                                    <span class="ql-formats">
                                        <button class="ql-list" value="ordered" title="Ordered List (1, 2, 3)"></button>
                                        <button class="ql-list" value="bullet" title="Bullet List"></button>
                                        <button class="ql-list" value="check" title="Task Checklist"></button>
                                        <button class="ql-indent" value="-1" title="Decrease Indent"></button>
                                        <button class="ql-indent" value="+1" title="Increase Indent"></button>
                                    </span>

                                    <span class="h-4 w-[1px] bg-gray-300 mx-1"></span>

                                    {{-- 7. Blockquote & Code Block --}}
                                    <span class="ql-formats">
                                        <button class="ql-blockquote" title="Blockquote"></button>
                                        <button class="ql-code-block" title="Code Block"></button>
                                    </span>

                                    <span class="h-4 w-[1px] bg-gray-300 mx-1"></span>

                                    {{-- 8. Inserts: Link, Image, Video, Divider --}}
                                    <span class="ql-formats">
                                        <button class="ql-link" title="Insert Web Link [Ctrl+K]"></button>
                                        <button type="button" onclick="openImageModal('en')" title="Insert Image (Upload & URL)" class="ql-custom-btn">
                                            <svg class="w-3.5 h-3.5 text-teal-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        </button>
                                        <button type="button" onclick="openVideoModal('en')" title="Insert Video (YouTube, Vimeo)" class="ql-custom-btn">
                                            <svg class="w-3.5 h-3.5 text-red-600" fill="currentColor" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg>
                                        </button>
                                        <button type="button" id="btn-insert-hr-en" title="Insert Horizontal Rule" class="ql-custom-btn">
                                            <svg class="w-3.5 h-3.5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/></svg>
                                        </button>
                                    </span>

                                    <span class="h-4 w-[1px] bg-gray-300 mx-1"></span>

                                    {{-- 9. Clean Format --}}
                                    <span class="ql-formats">
                                        <button class="ql-clean" title="Clear Formatting"></button>
                                    </span>
                                </div>

                                {{-- Quill Canvas Paper EN --}}
                                <div id="quill-editor-en">
                                    {!! old('content_en', $article->content_en) !!}
                                </div>

                                {{-- Fallback content textarea ensuring submission always succeeds --}}
                                <textarea 
                                    name="content_en" 
                                    id="hidden-content-en" 
                                    style="display: none;" 
                                    rows="14" 
                                    placeholder="Write or paste the English translated article content here..."
                                    class="w-full p-4 text-sm font-sans text-gray-800 border-none outline-none focus:ring-0 resize-y"
                                >{{ old('content_en', $article->content_en) }}</textarea>

                                {{-- Status Bar & Live Metrics EN --}}
                                <div class="editor-status-bar bg-slate-50 border-t border-gray-200 px-4 py-2 flex flex-wrap items-center justify-between text-xs text-gray-500 gap-2">
                                    <div class="flex items-center gap-3">
                                        <span class="font-semibold text-gray-700" id="stat-words-en">0 Words</span>
                                        <span class="text-gray-300">•</span>
                                        <span id="stat-chars-en">0 Characters</span>
                                        <span class="text-gray-300">•</span>
                                        <span id="stat-read-time-en">~1 Min Read</span>
                                    </div>
                                    <div class="flex items-center gap-2 text-[11px] text-gray-400 hidden sm:flex">
                                        <span class="inline-flex items-center gap-1 text-emerald-600 font-medium">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                            Synced EN
                                        </span>
                                        <span>•</span>
                                        <span>Drag & drop image or Ctrl+V directly to canvas</span>
                                    </div>
                                </div>
                            </div>
                            <p class="text-[11px] text-gray-400 italic">Catatan: Jika naskah Inggris dikosongkan, web publik akan otomatis menampilkan naskah Bahasa Indonesia sebagai rujukan.</p>
                        </div>

                    </div>
                </div>

                {{-- MODAL SISIPKAN GAMBAR (UPLOAD & URL) --}}
                <div id="modal-insert-image" class="fixed inset-0 bg-gray-950/70 backdrop-blur-xs z-[999999] hidden items-center justify-center p-4">
                    <div class="bg-white rounded-3xl max-w-lg w-full shadow-2xl border border-gray-200 overflow-hidden transform transition-all">
                        {{-- Modal Header --}}
                        <div class="px-6 py-4 bg-gray-50 border-b border-gray-200 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 rounded-lg bg-teal-100 text-[#005952] flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                                <h3 class="font-extrabold text-sm text-gray-900">Sisipkan Gambar / Foto</h3>
                            </div>
                            <button type="button" onclick="closeImageModal()" class="text-gray-400 hover:text-gray-600 text-lg leading-none p-1 rounded-lg hover:bg-gray-200/50">✕</button>
                        </div>

                        {{-- Tabs --}}
                        <div class="flex border-b border-gray-200 bg-gray-50/50 px-6 pt-2 gap-2 text-xs font-bold">
                            <button type="button" id="tab-btn-upload" onclick="switchImageTab('upload')" class="py-2.5 px-4 border-b-2 border-[#005952] text-[#005952] transition-colors cursor-pointer">
                                Unggah File (Komputer / HP)
                            </button>
                            <button type="button" id="tab-btn-url" onclick="switchImageTab('url')" class="py-2.5 px-4 border-b-2 border-transparent text-gray-500 hover:text-gray-800 transition-colors cursor-pointer">
                                Tautan URL Gambar Web
                            </button>
                        </div>

                        {{-- Modal Body --}}
                        <div class="p-6 space-y-4">
                            {{-- Pane Upload --}}
                            <div id="pane-image-upload" class="space-y-4">
                                <div 
                                    id="dropzone-image" 
                                    onclick="document.getElementById('file-image-input').click()"
                                    class="border-2 border-dashed border-gray-300 hover:border-[#005952] bg-gray-50 hover:bg-teal-50/30 rounded-2xl p-6 text-center cursor-pointer transition-all flex flex-col items-center justify-center gap-2"
                                >
                                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                                    <div class="text-xs font-bold text-gray-700">Klik untuk memilih foto atau seret ke sini</div>
                                    <div class="text-[11px] text-gray-400">Mendukung JPG, PNG, WEBP, GIF, SVG (Maksimal 10 MB)</div>
                                </div>
                                <input type="file" id="file-image-input" accept="image/*" class="hidden" onchange="handleImageFileSelect(this)">

                                {{-- Image preview if selected --}}
                                <div id="upload-preview-wrapper" class="hidden border border-gray-200 rounded-xl p-3 bg-gray-50 flex items-center gap-3">
                                    <img id="upload-preview-img" src="" alt="Pratinjau" class="w-16 h-16 object-cover rounded-lg border border-gray-200">
                                    <div class="text-xs flex-1">
                                        <p id="upload-preview-name" class="font-bold text-gray-800 truncate max-w-[240px]">nama_foto.jpg</p>
                                        <p id="upload-preview-size" class="text-[11px] text-gray-500">120 KB</p>
                                    </div>
                                    <button type="button" onclick="clearSelectedImage()" class="text-xs font-bold text-red-500 hover:underline">Hapus</button>
                                </div>

                                {{-- Upload Progress --}}
                                <div id="upload-progress-bar" class="hidden space-y-1">
                                    <div class="flex items-center justify-between text-[11px] font-bold text-gray-600">
                                        <span>Mengunggah gambar...</span>
                                        <span id="upload-percentage">0%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                                        <div id="upload-progress-fill" class="bg-[#005952] h-full w-0 transition-all duration-300"></div>
                                    </div>
                                </div>
                            </div>

                            {{-- Pane URL --}}
                            <div id="pane-image-url" class="hidden space-y-4">
                                <div>
                                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">URL Gambar Web *</label>
                                    <input 
                                        type="url" 
                                        id="input-image-url" 
                                        placeholder="https://images.unsplash.com/... atau https://..." 
                                        class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-[#005952] outline-none"
                                        oninput="previewUrlImage(this.value)"
                                    >
                                </div>
                                <div id="url-preview-wrapper" class="hidden rounded-xl border border-gray-200 overflow-hidden bg-gray-100 max-h-44 flex items-center justify-center">
                                    <img id="url-preview-img" src="" alt="Pratinjau URL" class="max-h-44 w-full object-cover">
                                </div>
                            </div>

                            {{-- Caption / Alt text --}}
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Keterangan Foto / Alt Text (Opsional)</label>
                                <input 
                                    type="text" 
                                    id="input-image-caption" 
                                    placeholder="Contoh: Dokumentasi inisiatif riset energi terbarukan" 
                                    class="w-full px-3.5 py-2 text-xs rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-[#005952] outline-none"
                                >
                            </div>
                        </div>

                        {{-- Modal Footer --}}
                        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex items-center justify-between">
                            <button type="button" onclick="closeImageModal()" class="px-4 py-2 rounded-xl text-xs font-bold text-gray-600 hover:bg-gray-200/60 transition-colors">
                                Batal
                            </button>
                            <button 
                                type="button" 
                                id="btn-submit-insert-image" 
                                onclick="submitInsertImage()"
                                class="px-5 py-2.5 rounded-xl bg-[#005952] hover:bg-[#004741] text-white text-xs font-bold transition-all shadow-md shadow-[#005952]/20 cursor-pointer"
                            >
                                Sisipkan ke Naskah
                            </button>
                        </div>
                    </div>
                </div>

                {{-- MODAL SISIPKAN VIDEO (YOUTUBE / VIMEO) --}}
                <div id="modal-insert-video" class="fixed inset-0 bg-gray-950/70 backdrop-blur-xs z-[999999] hidden items-center justify-center p-4">
                    <div class="bg-white rounded-3xl max-w-lg w-full shadow-2xl border border-gray-200 overflow-hidden transform transition-all">
                        {{-- Modal Header --}}
                        <div class="px-6 py-4 bg-gray-50 border-b border-gray-200 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 rounded-lg bg-red-100 text-red-600 flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg>
                                </div>
                                <h3 class="font-extrabold text-sm text-gray-900">Sisipkan Video (YouTube / Vimeo)</h3>
                            </div>
                            <button type="button" onclick="closeVideoModal()" class="text-gray-400 hover:text-gray-600 text-lg leading-none p-1 rounded-lg hover:bg-gray-200/50">✕</button>
                        </div>

                        {{-- Modal Body --}}
                        <div class="p-6 space-y-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">
                                    Tautan / URL Video *
                                </label>
                                <input 
                                    type="text" 
                                    id="input-video-url" 
                                    placeholder="https://www.youtube.com/watch?v=... atau https://youtu.be/... atau Vimeo" 
                                    class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-[#005952] outline-none"
                                    oninput="handleVideoUrlInput(this.value)"
                                >
                                <span class="text-[11px] text-gray-400 mt-1 block">Mendukung tautan standar YouTube, tautan ringkas youtu.be, YouTube Shorts, atau Vimeo.</span>
                            </div>

                            {{-- Status Badge --}}
                            <div id="video-status-box" class="hidden p-3 rounded-xl text-xs font-semibold flex items-center gap-2">
                                <span id="video-status-icon"></span>
                                <span id="video-status-text"></span>
                            </div>

                            {{-- Live Video Player Preview --}}
                            <div id="video-preview-wrapper" class="hidden space-y-1.5">
                                <div class="text-[11px] font-bold text-gray-500 uppercase tracking-wider">Pratinjau Pemutar Video:</div>
                                <div class="relative aspect-[16/9] w-full rounded-2xl overflow-hidden border border-gray-300 bg-black shadow-inner">
                                    <iframe id="video-preview-iframe" class="w-full h-full" src="" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                </div>
                            </div>
                        </div>

                        {{-- Modal Footer --}}
                        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex items-center justify-between">
                            <button type="button" onclick="closeVideoModal()" class="px-4 py-2 rounded-xl text-xs font-bold text-gray-600 hover:bg-gray-200/60 transition-colors">
                                Batal
                            </button>
                            <button 
                                type="button" 
                                id="btn-submit-insert-video" 
                                onclick="submitInsertVideo()"
                                class="px-5 py-2.5 rounded-xl bg-red-600 hover:bg-red-700 text-white text-xs font-bold transition-all shadow-md shadow-red-600/20 cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed"
                            >
                                Sisipkan Video ke Naskah
                            </button>
                        </div>
                    </div>
                </div>

                {{-- 3. STATUS & VISIBILITY SETTINGS CARD --}}
                <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-xs">
                    <span class="text-xs font-bold tracking-wider uppercase text-[#005952] block mb-4">Pengaturan Penayangan & Kurasi</span>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        {{-- Status Radio --}}
                        <div>
                            <label class="block text-xs font-bold text-gray-800 uppercase tracking-wider mb-2">Status Terbitan</label>
                            <div class="flex items-center gap-4">
                                <label class="flex items-center gap-2 p-3 rounded-xl border border-gray-200 hover:border-[#005952] cursor-pointer text-xs font-semibold text-gray-800">
                                    <input type="radio" name="status" value="published" {{ old('status', $article->status) === 'published' ? 'checked' : '' }} class="text-[#005952] focus:ring-[#005952]">
                                    <span class="flex items-center gap-1.5">
                                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                        <span>Terbitkan Sekarang (Published)</span>
                                    </span>
                                </label>
                                <label class="flex items-center gap-2 p-3 rounded-xl border border-gray-200 hover:border-[#005952] cursor-pointer text-xs font-semibold text-gray-800">
                                    <input type="radio" name="status" value="draft" {{ old('status', $article->status) === 'draft' ? 'checked' : '' }} class="text-[#005952] focus:ring-[#005952]">
                                    <span class="flex items-center gap-1.5">
                                        <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                                        <span>Simpan sebagai Draf</span>
                                    </span>
                                </label>
                            </div>
                        </div>

                        {{-- Featured Toggle --}}
                        <div class="flex items-center">
                            <label class="relative flex items-center gap-3 p-3.5 rounded-xl border border-gray-200 hover:border-blue-500 cursor-pointer w-full">
                                <input 
                                    type="checkbox" 
                                    name="is_featured" 
                                    value="1" 
                                    {{ old('is_featured', $article->is_featured) ? 'checked' : '' }} 
                                    class="w-4 h-4 rounded text-blue-600 focus:ring-blue-500"
                                >
                                <div>
                                    <span class="text-xs font-bold text-gray-900 block">Jadikan Inisiatif Unggulan (Featured)</span>
                                    <span class="text-[11px] text-gray-500">Ditampilkan pada slide carousel utama halaman depan.</span>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                {{-- 4. COLLAPSIBLE SEO & METADATA ACCORDION --}}
                <div x-data="{ openSeo: false }" class="bg-white rounded-2xl border border-gray-200 shadow-xs overflow-hidden">
                    <button 
                        type="button" 
                        @click="openSeo = !openSeo" 
                        class="w-full px-6 py-4 flex items-center justify-between bg-white hover:bg-gray-50 text-left transition-colors cursor-pointer"
                    >
                        <div class="flex items-center gap-2.5">
                            <svg class="w-4 h-4 text-[#005952]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>
                            <span class="text-xs font-bold uppercase tracking-wider text-gray-800">Optimasi Mesin Pencari (SEO Suite & OpenGraph)</span>
                        </div>
                        <span class="text-xs font-bold text-gray-400" x-text="openSeo ? 'Tutup −' : 'Buka Pengaturan +'"></span>
                    </button>

                    <div x-show="openSeo" x-transition class="p-6 border-t border-gray-100 space-y-4 bg-gray-50/50">
                        <div>
                            <label for="meta_title" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                                Meta Title SEO
                            </label>
                            <input 
                                type="text" 
                                id="meta_title" 
                                name="meta_title" 
                                value="{{ old('meta_title', $article->meta_title) }}" 
                                placeholder="Judul khusus Google Search (Bila dikosongkan memakai judul artikel)" 
                                class="w-full px-3 py-2 text-xs rounded-xl border border-gray-200 bg-white focus:border-[#005952] outline-none"
                            >
                        </div>

                        <div>
                            <label for="meta_description" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                                Meta Description SEO
                            </label>
                            <textarea 
                                id="meta_description" 
                                name="meta_description" 
                                rows="2" 
                                placeholder="Deskripsi ringkas 150-160 karakter untuk cuplikan pencarian Google..." 
                                class="w-full px-3 py-2 text-xs rounded-xl border border-gray-200 bg-white focus:border-[#005952] outline-none resize-none"
                            >{{ old('meta_description', $article->meta_description) }}</textarea>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="meta_keywords" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                                    Meta Keywords
                                </label>
                                <input 
                                    type="text" 
                                    id="meta_keywords" 
                                    name="meta_keywords" 
                                    value="{{ old('meta_keywords', $article->meta_keywords) }}" 
                                    placeholder="inovasi, riset, energi surya, nusantara" 
                                    class="w-full px-3 py-2 text-xs rounded-xl border border-gray-200 bg-white focus:border-[#005952] outline-none"
                                >
                            </div>

                            <div>
                                <label for="canonical_url" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                                    Canonical URL
                                </label>
                                <input 
                                    type="url" 
                                    id="canonical_url" 
                                    name="canonical_url" 
                                    value="{{ old('canonical_url', $article->canonical_url) }}" 
                                    placeholder="https://... (Opsional jika diterbitkan ulang)" 
                                    class="w-full px-3 py-2 text-xs rounded-xl border border-gray-200 bg-white focus:border-[#005952] outline-none"
                                >
                            </div>
                        </div>
                    </div>
                </div>

                {{-- SUBMIT & CANCEL ACTIONS --}}
                <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                    <a 
                        href="{{ route('admin.articles.index') }}" 
                        class="px-5 py-2.5 rounded-xl border border-gray-300 text-xs font-bold text-gray-700 hover:bg-gray-100 transition-colors"
                    >
                        Batal
                    </a>

                    <button 
                        type="submit" 
                        class="px-8 py-3 rounded-xl bg-[#005952] hover:bg-[#004741] text-white text-xs sm:text-sm font-bold uppercase tracking-wider shadow-md shadow-[#005952]/20 transition-all hover:scale-105 active:scale-95 cursor-pointer"
                    >
                        {{ $isEdit ? 'Simpan Pembaruan Publikasi' : 'Terbitkan Publikasi Sekarang' }}
                    </button>
                </div>

            </form>
        </div>
    </div>

    {{-- Quill Script and Word Pro Suite Bilingual Form Handler --}}
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
    <script>
        // Global variables for Bilingual Quill Suite & Modals
        let quill = null; // Alias to quillID for compatibility
        let quillID = null;
        let quillEN = null;
        let activeEditor = 'id'; // 'id' or 'en'
        let currentContentTab = 'id';
        let currentViewMode = 'tab';
        let savedRange = null;
        let currentImageTab = 'upload';
        let selectedImageFile = null;

        // Video URL parser supporting standard YouTube, Shorts, youtu.be, Vimeo, and iframe tags
        function extractVideoEmbedUrl(input) {
            if (!input) return null;
            let url = input.trim();

            // Check if user pasted an iframe tag
            const iframeSrcMatch = url.match(/src=["']([^"']+)["']/i);
            if (iframeSrcMatch && iframeSrcMatch[1]) {
                url = iframeSrcMatch[1];
            }

            // YouTube: standard watch, short, shorts, embed
            const ytMatch = url.match(/(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=|shorts\/))([\w-]{11})/i);
            if (ytMatch && ytMatch[1]) {
                return 'https://www.youtube-nocookie.com/embed/' + ytMatch[1] + '?rel=0';
            }

            // Vimeo: vimeo.com/123456789 or player.vimeo.com/video/123456789
            const vimeoMatch = url.match(/(?:vimeo\.com\/|player\.vimeo\.com\/video\/)(\d+)/i);
            if (vimeoMatch && vimeoMatch[1]) {
                return 'https://player.vimeo.com/video/' + vimeoMatch[1];
            }

            // Direct embed or other web video if valid URL
            if (url.startsWith('https://') || url.startsWith('http://')) {
                return url;
            }

            return null;
        }

        // Helper to get active quill instance
        function getTargetQuill() {
            return (activeEditor === 'en' && quillEN) ? quillEN : quillID;
        }

        // --- IMAGE MODAL CONTROLLERS ---
        function openImageModal(targetLang = null) {
            if (targetLang) {
                activeEditor = targetLang;
            }
            const targetQuill = getTargetQuill();
            if (targetQuill) {
                savedRange = targetQuill.getSelection() || { index: targetQuill.getLength() - 1, length: 0 };
            }
            const modal = document.getElementById('modal-insert-image');
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }
            switchImageTab('upload');
        }

        function closeImageModal() {
            const modal = document.getElementById('modal-insert-image');
            if (modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
            clearSelectedImage();
            const inputUrl = document.getElementById('input-image-url');
            if (inputUrl) inputUrl.value = '';
            const caption = document.getElementById('input-image-caption');
            if (caption) caption.value = '';
            const urlWrapper = document.getElementById('url-preview-wrapper');
            if (urlWrapper) urlWrapper.classList.add('hidden');
        }

        function switchImageTab(tab) {
            currentImageTab = tab;
            const btnUpload = document.getElementById('tab-btn-upload');
            const btnUrl = document.getElementById('tab-btn-url');
            const paneUpload = document.getElementById('pane-image-upload');
            const paneUrl = document.getElementById('pane-image-url');

            if (tab === 'upload') {
                btnUpload.className = 'py-2.5 px-4 border-b-2 border-[#005952] text-[#005952] transition-colors cursor-pointer';
                btnUrl.className = 'py-2.5 px-4 border-b-2 border-transparent text-gray-500 hover:text-gray-800 transition-colors cursor-pointer';
                paneUpload.classList.remove('hidden');
                paneUrl.classList.add('hidden');
            } else {
                btnUrl.className = 'py-2.5 px-4 border-b-2 border-[#005952] text-[#005952] transition-colors cursor-pointer';
                btnUpload.className = 'py-2.5 px-4 border-b-2 border-transparent text-gray-500 hover:text-gray-800 transition-colors cursor-pointer';
                paneUrl.classList.remove('hidden');
                paneUpload.classList.add('hidden');
            }
        }

        function handleImageFileSelect(input) {
            if (input.files && input.files[0]) {
                const file = input.files[0];
                selectedImageFile = file;

                const wrapper = document.getElementById('upload-preview-wrapper');
                const img = document.getElementById('upload-preview-img');
                const name = document.getElementById('upload-preview-name');
                const size = document.getElementById('upload-preview-size');

                if (wrapper && img && name && size) {
                    name.textContent = file.name;
                    size.textContent = (file.size / 1024 > 1024) 
                        ? (file.size / (1024 * 1024)).toFixed(2) + ' MB' 
                        : (file.size / 1024).toFixed(1) + ' KB';
                    
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        img.src = e.target.result;
                        wrapper.classList.remove('hidden');
                    };
                    reader.readAsDataURL(file);
                }
            }
        }

        function clearSelectedImage() {
            selectedImageFile = null;
            const input = document.getElementById('file-image-input');
            if (input) input.value = '';
            const wrapper = document.getElementById('upload-preview-wrapper');
            if (wrapper) wrapper.classList.add('hidden');
            const progress = document.getElementById('upload-progress-bar');
            if (progress) progress.classList.add('hidden');
        }

        function previewUrlImage(url) {
            const wrapper = document.getElementById('url-preview-wrapper');
            const img = document.getElementById('url-preview-img');
            if (!url || !url.trim().startsWith('http')) {
                if (wrapper) wrapper.classList.add('hidden');
                return;
            }
            if (wrapper && img) {
                img.src = url.trim();
                wrapper.classList.remove('hidden');
            }
        }

        function uploadAndInsertFile(file, captionText) {
            const formData = new FormData();
            formData.append('image', file);
            formData.append('_token', '{{ csrf_token() }}');

            const progressBar = document.getElementById('upload-progress-bar');
            const progressFill = document.getElementById('upload-progress-fill');
            const percentage = document.getElementById('upload-percentage');
            const submitBtn = document.getElementById('btn-submit-insert-image');

            if (progressBar) progressBar.classList.remove('hidden');
            if (progressFill) progressFill.style.width = '45%';
            if (percentage) percentage.textContent = '45%';
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.textContent = 'Mengunggah...';
            }

            fetch('{{ route('admin.articles.upload-image') }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(res => {
                if (!res.ok) throw new Error('Gagal mengunggah foto ke server.');
                return res.json();
            })
            .then(data => {
                if (progressFill) progressFill.style.width = '100%';
                if (percentage) percentage.textContent = '100%';

                if (data.success && data.url) {
                    insertImageIntoQuill(data.url, captionText);
                    closeImageModal();
                } else {
                    throw new Error(data.message || 'Gagal menyimpan foto.');
                }
            })
            .catch(err => {
                console.warn('Server upload error, fallback to DataURL:', err);
                // Fallback local data URL
                const reader = new FileReader();
                reader.onload = function(e) {
                    insertImageIntoQuill(e.target.result, captionText);
                    closeImageModal();
                };
                reader.readAsDataURL(file);
            })
            .finally(() => {
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.textContent = 'Sisipkan ke Naskah';
                }
            });
        }

        function insertImageIntoQuill(imageUrl, caption) {
            const targetQuill = getTargetQuill();
            if (!targetQuill) return;
            const index = savedRange ? savedRange.index : (targetQuill.getSelection() ? targetQuill.getSelection().index : targetQuill.getLength() - 1);
            
            targetQuill.insertEmbed(index, 'image', imageUrl, Quill.sources.USER);
            
            if (caption && caption.trim()) {
                targetQuill.insertText(index + 1, '\n' + caption.trim() + '\n', { 'italic': true, 'align': 'center' }, Quill.sources.USER);
                targetQuill.setSelection(index + 3, Quill.sources.SILENT);
            } else {
                targetQuill.setSelection(index + 1, Quill.sources.SILENT);
            }
        }

        function submitInsertImage() {
            const captionInput = document.getElementById('input-image-caption');
            const caption = captionInput ? captionInput.value : '';

            if (currentImageTab === 'upload') {
                if (!selectedImageFile) {
                    alert('Silakan pilih file gambar dari komputer atau seret ke area unggah.');
                    return;
                }
                uploadAndInsertFile(selectedImageFile, caption);
            } else {
                const inputUrl = document.getElementById('input-image-url');
                const url = inputUrl ? inputUrl.value.trim() : '';
                if (!url) {
                    alert('Silakan masukkan tautan URL gambar web.');
                    return;
                }
                insertImageIntoQuill(url, caption);
                closeImageModal();
            }
        }

        // --- VIDEO MODAL CONTROLLERS ---
        function openVideoModal(targetLang = null) {
            if (targetLang) {
                activeEditor = targetLang;
            }
            const targetQuill = getTargetQuill();
            if (targetQuill) {
                savedRange = targetQuill.getSelection() || { index: targetQuill.getLength() - 1, length: 0 };
            }
            const modal = document.getElementById('modal-insert-video');
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }
            const input = document.getElementById('input-video-url');
            if (input) {
                input.value = '';
                handleVideoUrlInput('');
                setTimeout(() => input.focus(), 100);
            }
        }

        function closeVideoModal() {
            const modal = document.getElementById('modal-insert-video');
            if (modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
            const previewIframe = document.getElementById('video-preview-iframe');
            if (previewIframe) previewIframe.src = '';
        }

        let detectedEmbedUrl = null;

        function handleVideoUrlInput(val) {
            const statusBox = document.getElementById('video-status-box');
            const statusIcon = document.getElementById('video-status-icon');
            const statusText = document.getElementById('video-status-text');
            const previewWrapper = document.getElementById('video-preview-wrapper');
            const previewIframe = document.getElementById('video-preview-iframe');
            const submitBtn = document.getElementById('btn-submit-insert-video');

            detectedEmbedUrl = extractVideoEmbedUrl(val);

            if (detectedEmbedUrl) {
                if (statusBox) {
                    statusBox.className = 'p-3 rounded-xl text-xs font-semibold flex items-center gap-2 bg-emerald-50 text-emerald-800 border border-emerald-200';
                    statusBox.classList.remove('hidden');
                }
                if (statusIcon) statusIcon.innerHTML = '✓';
                if (statusText) statusText.textContent = 'Video Terdeteksi! Siap disematkan ke naskah publikasi.';

                if (previewWrapper && previewIframe) {
                    previewIframe.src = detectedEmbedUrl;
                    previewWrapper.classList.remove('hidden');
                }
                if (submitBtn) submitBtn.disabled = false;
            } else {
                if (val && val.trim().length > 0) {
                    if (statusBox) {
                        statusBox.className = 'p-3 rounded-xl text-xs font-semibold flex items-center gap-2 bg-amber-50 text-amber-800 border border-amber-200';
                        statusBox.classList.remove('hidden');
                    }
                    if (statusIcon) statusIcon.innerHTML = '⚠️';
                    if (statusText) statusText.textContent = 'Format URL belum dikenali. Masukkan URL YouTube atau Vimeo.';
                } else {
                    if (statusBox) statusBox.classList.add('hidden');
                }
                if (previewWrapper && previewIframe) {
                    previewIframe.src = '';
                    previewWrapper.classList.add('hidden');
                }
                if (submitBtn) submitBtn.disabled = true;
            }
        }

        function submitInsertVideo() {
            if (!detectedEmbedUrl) {
                alert('Silakan masukkan tautan video YouTube atau Vimeo yang valid.');
                return;
            }
            const targetQuill = getTargetQuill();
            if (!targetQuill) return;

            const index = savedRange ? savedRange.index : (targetQuill.getSelection() ? targetQuill.getSelection().index : targetQuill.getLength() - 1);
            
            targetQuill.insertEmbed(index, 'video', detectedEmbedUrl, Quill.sources.USER);
            targetQuill.setSelection(index + 1, Quill.sources.SILENT);
            closeVideoModal();
        }

        // --- BILINGUAL TAB & VIEW CONTROLLER ---
        function switchContentTab(tab) {
            currentContentTab = tab;
            activeEditor = tab;
            const btnId = document.getElementById('tab-editor-id-btn');
            const btnEn = document.getElementById('tab-editor-en-btn');
            const paneId = document.getElementById('pane-editor-id');
            const paneEn = document.getElementById('pane-editor-en');

            if (currentViewMode === 'tab') {
                if (tab === 'id') {
                    if (btnId) btnId.className = 'px-4 py-2 rounded-lg text-xs font-extrabold flex items-center gap-2 transition-all bg-white text-[#005952] border border-gray-200 shadow-xs cursor-pointer';
                    if (btnEn) btnEn.className = 'px-4 py-2 rounded-lg text-xs font-bold flex items-center gap-2 transition-all text-gray-600 hover:text-gray-900 border border-transparent cursor-pointer';
                    if (paneId) paneId.classList.remove('hidden');
                    if (paneEn) paneEn.classList.add('hidden');
                    if (quillID) quillID.update();
                } else {
                    if (btnEn) btnEn.className = 'px-4 py-2 rounded-lg text-xs font-extrabold flex items-center gap-2 transition-all bg-white text-[#005952] border border-gray-200 shadow-xs cursor-pointer';
                    if (btnId) btnId.className = 'px-4 py-2 rounded-lg text-xs font-bold flex items-center gap-2 transition-all text-gray-600 hover:text-gray-900 border border-transparent cursor-pointer';
                    if (paneEn) paneEn.classList.remove('hidden');
                    if (paneId) paneId.classList.add('hidden');
                    if (quillEN) quillEN.update();
                }
            } else {
                if (tab === 'id' && quillID) quillID.focus();
                if (tab === 'en' && quillEN) quillEN.focus();
            }
        }

        function setViewMode(mode) {
            currentViewMode = mode;
            const btnTab = document.getElementById('btn-view-tab');
            const btnSplit = document.getElementById('btn-view-split');
            const container = document.getElementById('editors-container');
            const paneId = document.getElementById('pane-editor-id');
            const paneEn = document.getElementById('pane-editor-en');

            if (mode === 'split') {
                if (btnSplit) btnSplit.className = 'px-2.5 py-1 rounded-md text-[11px] font-bold bg-[#005952] text-white transition-all cursor-pointer';
                if (btnTab) btnTab.className = 'px-2.5 py-1 rounded-md text-[11px] font-bold bg-white text-gray-600 hover:text-gray-900 border border-gray-200 transition-all cursor-pointer';
                if (container) {
                    container.className = 'grid grid-cols-1 xl:grid-cols-2 gap-6';
                }
                if (paneId) paneId.classList.remove('hidden');
                if (paneEn) paneEn.classList.remove('hidden');
                if (quillID) quillID.update();
                if (quillEN) quillEN.update();
            } else {
                if (btnTab) btnTab.className = 'px-2.5 py-1 rounded-md text-[11px] font-bold bg-[#005952] text-white transition-all cursor-pointer';
                if (btnSplit) btnSplit.className = 'px-2.5 py-1 rounded-md text-[11px] font-bold bg-white text-gray-600 hover:text-gray-900 border border-gray-200 transition-all cursor-pointer';
                if (container) {
                    container.className = 'grid grid-cols-1 gap-6';
                }
                switchContentTab(currentContentTab);
            }
        }

        // Copy entire Indonesian formatted content to English editor
        function copyIdToEn() {
            if (!quillID || !quillEN) return;
            const idHtml = quillID.root.innerHTML;
            if (!idHtml || idHtml === '<p><br></p>') {
                alert('Naskah Bahasa Indonesia masih kosong. Tulis atau isi naskah Indonesia terlebih dahulu.');
                return;
            }
            const currentEnText = quillEN.getText().trim();
            if (currentEnText.length > 0) {
                if (!confirm('Editor bahasa Inggris sudah memiliki teks. Anda yakin ingin menimpa dengan salinan naskah Bahasa Indonesia?')) {
                    return;
                }
            }
            quillEN.clipboard.dangerouslyPasteHTML(idHtml);
            updateStatsAndSyncEn();
            if (currentViewMode === 'tab') {
                switchContentTab('en');
            }
            alert('Naskah berhasil disalin ke editor bahasa Inggris! Struktur paragraf, gambar, dan media telah terpasang. Anda dapat langsung menerjemahkan teksnya.');
        }

        // --- DOCUMENT READY & QUILL INITIALIZATION ---
        document.addEventListener('DOMContentLoaded', function() {
            // Auto generate slug from title if slug is empty
            const titleInput = document.getElementById('title');
            const slugInput = document.getElementById('slug');

            if (titleInput && slugInput) {
                titleInput.addEventListener('blur', function() {
                    if (!slugInput.value.trim()) {
                        slugInput.value = titleInput.value
                            .toLowerCase()
                            .replace(/[^\w\s-]/g, '')
                            .trim()
                            .replace(/[\s_-]+/g, '-')
                            .replace(/^-+|-+$/g, '');
                    }
                });
            }

            // Elements
            const hiddenContent = document.getElementById('hidden-content');
            const hiddenContentEn = document.getElementById('hidden-content-en');
            const editorEl = document.getElementById('quill-editor');
            const editorEnEl = document.getElementById('quill-editor-en');
            const toolbarEl = document.getElementById('quill-toolbar');
            const toolbarEnEl = document.getElementById('quill-toolbar-en');
            const wrapper = document.getElementById('quill-editor-wrapper');
            const fsBtn = document.getElementById('btn-fullscreen-toggle');
            const fsText = document.getElementById('fullscreen-text');

            try {
                if (typeof Quill !== 'undefined' && editorEl && editorEnEl) {
                    // 1. Initialize Indonesian Quill
                    quillID = new Quill('#quill-editor', {
                        modules: {
                            toolbar: {
                                container: '#quill-toolbar',
                                handlers: {
                                    'image': function() { openImageModal('id'); },
                                    'video': function() { openVideoModal('id'); }
                                }
                            },
                            history: {
                                delay: 1000,
                                maxStack: 150,
                                userOnly: true
                            }
                        },
                        theme: 'snow',
                        placeholder: 'Tuliskan naskah lengkap artikel, metodologi riset, temuan inisiatif, atau wawasan ilmiah dalam Bahasa Indonesia di sini...'
                    });
                    quill = quillID; // Compatibility alias

                    // 2. Initialize English Quill
                    quillEN = new Quill('#quill-editor-en', {
                        modules: {
                            toolbar: {
                                container: '#quill-toolbar-en',
                                handlers: {
                                    'image': function() { openImageModal('en'); },
                                    'video': function() { openVideoModal('en'); }
                                }
                            },
                            history: {
                                delay: 1000,
                                maxStack: 150,
                                userOnly: true
                            }
                        },
                        theme: 'snow',
                        placeholder: 'Write or paste the English translated article manuscript, research findings, and executive notes here...'
                    });

                    // Live statistics and content synchronization (ID)
                    function updateStatsAndSyncId() {
                        if (hiddenContent && quillID && quillID.root) {
                            hiddenContent.value = quillID.root.innerHTML;
                        }
                        const text = quillID.getText().trim();
                        const words = text ? text.split(/\s+/).filter(Boolean).length : 0;
                        const chars = text.length;
                        const readTime = Math.max(1, Math.ceil(words / 180));

                        const statWords = document.getElementById('stat-words');
                        const statChars = document.getElementById('stat-chars');
                        const statReadTime = document.getElementById('stat-read-time');
                        const badgeWords = document.getElementById('badge-word-id');

                        if (statWords) statWords.textContent = words.toLocaleString('id-ID') + ' Kata';
                        if (statChars) statChars.textContent = chars.toLocaleString('id-ID') + ' Karakter';
                        if (statReadTime) statReadTime.textContent = '~' + readTime + ' Menit Baca';
                        if (badgeWords) badgeWords.textContent = words.toLocaleString('id-ID') + ' kata';
                    }

                    // Live statistics and content synchronization (EN)
                    window.updateStatsAndSyncEn = function() {
                        if (hiddenContentEn && quillEN && quillEN.root) {
                            hiddenContentEn.value = quillEN.root.innerHTML;
                        }
                        const text = quillEN.getText().trim();
                        const words = text ? text.split(/\s+/).filter(Boolean).length : 0;
                        const chars = text.length;
                        const readTime = Math.max(1, Math.ceil(words / 180));

                        const statWords = document.getElementById('stat-words-en');
                        const statChars = document.getElementById('stat-chars-en');
                        const statReadTime = document.getElementById('stat-read-time-en');
                        const badgeWords = document.getElementById('badge-word-en');

                        if (statWords) statWords.textContent = words.toLocaleString('en-US') + ' Words';
                        if (statChars) statChars.textContent = chars.toLocaleString('en-US') + ' Characters';
                        if (statReadTime) statReadTime.textContent = '~' + readTime + ' Min Read';
                        if (badgeWords) badgeWords.textContent = words.toLocaleString('en-US') + ' words';
                    };

                    quillID.on('text-change', updateStatsAndSyncId);
                    updateStatsAndSyncId();

                    quillEN.on('text-change', window.updateStatsAndSyncEn);
                    window.updateStatsAndSyncEn();

                    // Track active editor on focus
                    quillID.root.addEventListener('focus', function() {
                        activeEditor = 'id';
                    });
                    quillEN.root.addEventListener('focus', function() {
                        activeEditor = 'en';
                    });

                    // Undo / Redo buttons (ID)
                    document.getElementById('btn-undo')?.addEventListener('click', function(e) {
                        e.preventDefault();
                        quillID.history.undo();
                    });
                    document.getElementById('btn-redo')?.addEventListener('click', function(e) {
                        e.preventDefault();
                        quillID.history.redo();
                    });

                    // Undo / Redo buttons (EN)
                    document.getElementById('btn-undo-en')?.addEventListener('click', function(e) {
                        e.preventDefault();
                        quillEN.history.undo();
                    });
                    document.getElementById('btn-redo-en')?.addEventListener('click', function(e) {
                        e.preventDefault();
                        quillEN.history.redo();
                    });

                    // Insert Horizontal Rule / Divider (ID)
                    document.getElementById('btn-insert-hr')?.addEventListener('click', function(e) {
                        e.preventDefault();
                        const range = quillID.getSelection(true);
                        quillID.clipboard.dangerouslyPasteHTML(range.index, '<hr><p><br></p>');
                        quillID.setSelection(range.index + 2, Quill.sources.SILENT);
                    });

                    // Insert Horizontal Rule / Divider (EN)
                    document.getElementById('btn-insert-hr-en')?.addEventListener('click', function(e) {
                        e.preventDefault();
                        const range = quillEN.getSelection(true);
                        quillEN.clipboard.dangerouslyPasteHTML(range.index, '<hr><p><br></p>');
                        quillEN.setSelection(range.index + 2, Quill.sources.SILENT);
                    });

                    // Drag and Drop Image directly onto Editor canvas (ID)
                    quillID.root.addEventListener('drop', function(e) {
                        const files = e.dataTransfer ? e.dataTransfer.files : null;
                        if (files && files.length > 0 && files[0].type.indexOf('image') !== -1) {
                            e.preventDefault();
                            activeEditor = 'id';
                            savedRange = quillID.getSelection() || { index: quillID.getLength() - 1, length: 0 };
                            uploadAndInsertFile(files[0], '');
                        }
                    });

                    // Drag and Drop Image directly onto Editor canvas (EN)
                    quillEN.root.addEventListener('drop', function(e) {
                        const files = e.dataTransfer ? e.dataTransfer.files : null;
                        if (files && files.length > 0 && files[0].type.indexOf('image') !== -1) {
                            e.preventDefault();
                            activeEditor = 'en';
                            savedRange = quillEN.getSelection() || { index: quillEN.getLength() - 1, length: 0 };
                            uploadAndInsertFile(files[0], '');
                        }
                    });

                    // Direct Paste (Ctrl+V) Image from clipboard (ID)
                    quillID.root.addEventListener('paste', function(e) {
                        const clipboardData = e.clipboardData || window.clipboardData;
                        if (clipboardData && clipboardData.items) {
                            for (let i = 0; i < clipboardData.items.length; i++) {
                                const item = clipboardData.items[i];
                                if (item.type.indexOf('image') !== -1) {
                                    const file = item.getAsFile();
                                    if (file) {
                                        e.preventDefault();
                                        activeEditor = 'id';
                                        savedRange = quillID.getSelection() || { index: quillID.getLength() - 1, length: 0 };
                                        uploadAndInsertFile(file, '');
                                        return;
                                    }
                                }
                            }
                        }
                    });

                    // Direct Paste (Ctrl+V) Image from clipboard (EN)
                    quillEN.root.addEventListener('paste', function(e) {
                        const clipboardData = e.clipboardData || window.clipboardData;
                        if (clipboardData && clipboardData.items) {
                            for (let i = 0; i < clipboardData.items.length; i++) {
                                const item = clipboardData.items[i];
                                if (item.type.indexOf('image') !== -1) {
                                    const file = item.getAsFile();
                                    if (file) {
                                        e.preventDefault();
                                        activeEditor = 'en';
                                        savedRange = quillEN.getSelection() || { index: quillEN.getLength() - 1, length: 0 };
                                        uploadAndInsertFile(file, '');
                                        return;
                                    }
                                }
                            }
                        }
                    });

                    // Fullscreen Word Mode
                    let isFullscreen = false;
                    fsBtn?.addEventListener('click', function(e) {
                        e.preventDefault();
                        isFullscreen = !isFullscreen;
                        if (isFullscreen) {
                            wrapper.classList.add('fullscreen-word-mode');
                            document.body.classList.add('overflow-hidden');
                            if (fsText) fsText.textContent = 'Keluar Layar Penuh';
                        } else {
                            wrapper.classList.remove('fullscreen-word-mode');
                            document.body.classList.remove('overflow-hidden');
                            if (fsText) fsText.textContent = 'Layar Penuh';
                        }
                    });

                } else {
                    throw new Error('Quill is not available');
                }
            } catch (err) {
                console.warn('Quill editor fallback to standard textarea:', err);
                if (editorEl) editorEl.style.display = 'none';
                if (editorEnEl) editorEnEl.style.display = 'none';
                if (toolbarEl) toolbarEl.style.display = 'none';
                if (toolbarEnEl) toolbarEnEl.style.display = 'none';
                if (hiddenContent) hiddenContent.style.display = 'block';
                if (hiddenContentEn) hiddenContentEn.style.display = 'block';
            }

            // On submit, sync both Quill HTML inputs
            const form = document.getElementById('article-form');
            if (form) {
                form.addEventListener('submit', function() {
                    if (quillID && quillID.root && hiddenContent) {
                        hiddenContent.value = quillID.root.innerHTML;
                    }
                    if (quillEN && quillEN.root && hiddenContentEn) {
                        const text = quillEN.getText().trim();
                        const hasMedia = quillEN.root.querySelector('img, iframe');
                        if (!text && !hasMedia) {
                            hiddenContentEn.value = '';
                        } else {
                            hiddenContentEn.value = quillEN.root.innerHTML;
                        }
                    }
                });
            }
        });
    </script>
</x-app-layout>
