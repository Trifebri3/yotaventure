<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <nav class="flex items-center gap-2 text-xs text-gray-500 mb-1">
                    <a href="{{ route('dashboard') }}" class="hover:text-[#005952] transition-colors">Admin</a>
                    <span>/</span>
                    <span class="text-[#005952] font-semibold">Pencapaian & Sertifikat</span>
                </nav>
                <h2 class="font-black text-xl sm:text-2xl text-gray-900 leading-tight">
                    Kelola Pencapaian, Penghargaan & Sertifikasi
                </h2>
            </div>
            <div class="flex items-center gap-3">
                <a 
                    href="{{ route('public.about.achievements') }}" 
                    target="_blank" 
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white border border-gray-300 text-xs font-bold text-gray-700 hover:bg-gray-50 shadow-xs transition-all"
                >
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                    <span>Lihat di Web Publik ↗</span>
                </a>
                <button 
                    type="button" 
                    onclick="openCreateModal()"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-[#005952] hover:bg-[#004741] text-white text-xs font-bold shadow-md hover:shadow-lg transition-all"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span>+ Tambah Sertifikat / Penghargaan</span>
                </button>
            </div>
        </div>
    </x-slot>

    {{-- Quill Rich Text Editor CDN CSS & Word Pro Styles --}}
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />
    <style>
        #quill-toolbar {
            border-top-left-radius: 0.75rem;
            border-top-right-radius: 0.75rem;
            background: linear-gradient(180deg, #f8fafc 0%, #f1f5f9 100%);
            border-color: #cbd5e1;
            padding: 8px 12px;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 4px;
        }
        #quill-toolbar .ql-formats {
            margin-right: 4px;
            display: inline-flex;
            align-items: center;
            gap: 2px;
        }
        #quill-toolbar button, 
        #quill-toolbar .ql-custom-btn {
            border-radius: 6px;
            transition: all 0.15s ease;
            height: 28px;
            width: 28px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 4px;
            border: 1px solid transparent;
        }
        #quill-toolbar button:hover, 
        #quill-toolbar .ql-custom-btn:hover {
            background-color: #e2e8f0;
            color: #005952;
        }
        #quill-toolbar button.ql-active {
            background-color: #005952 !important;
            color: #ffffff !important;
        }
        #quill-toolbar button.ql-active .ql-stroke {
            stroke: #ffffff !important;
        }
        #quill-toolbar button.ql-active .ql-fill {
            fill: #ffffff !important;
        }
        #quill-editor {
            border-bottom-left-radius: 0.75rem;
            border-bottom-right-radius: 0.75rem;
            border-color: #cbd5e1;
            min-height: 360px;
            font-size: 15px;
            line-height: 1.8;
            color: #1e293b;
            background: #ffffff;
        }
        #quill-editor .ql-editor {
            min-height: 360px;
            padding: 24px 28px;
        }
        #quill-editor .ql-editor h2 {
            font-size: 1.6rem;
            font-weight: 800;
            color: #0f172a;
            margin-top: 1.5rem;
            margin-bottom: 0.75rem;
            border-bottom: 2px solid #f1f5f9;
            padding-bottom: 0.5rem;
        }
        #quill-editor .ql-editor h3 {
            font-size: 1.3rem;
            font-weight: 700;
            color: #005952;
            margin-top: 1.25rem;
            margin-bottom: 0.5rem;
        }
        #quill-editor .ql-editor blockquote {
            border-left: 4px solid #005952;
            padding: 12px 20px;
            margin: 18px 0;
            background: #f0fdf4;
            color: #166534;
            font-style: italic;
            border-radius: 0 12px 12px 0;
        }
        #quill-editor .ql-editor img {
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            margin: 18px auto;
            max-width: 100%;
            height: auto;
            display: block;
        }
        .fullscreen-word-mode {
            position: fixed !important;
            inset: 0 !important;
            z-index: 99999 !important;
            background: #f8fafc !important;
            padding: 24px !important;
            overflow-y: auto !important;
            display: flex !important;
            flex-direction: column !important;
        }
        .fullscreen-word-mode #quill-toolbar {
            position: sticky;
            top: 0;
            z-index: 10;
        }
        .fullscreen-word-mode #quill-editor {
            flex: 1;
            min-height: calc(100vh - 180px);
        }
    </style>

    <div class="py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10" x-data="{ activeTab: 'items' }">
        {{-- Flash Notification --}}
        @if(session('success'))
            <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center justify-between shadow-xs">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-xl bg-emerald-500 text-white flex items-center justify-center font-bold">✓</div>
                    <div>
                        <h4 class="text-sm font-bold">Berhasil Disimpan</h4>
                        <p class="text-xs text-emerald-700">{{ session('success') }}</p>
                    </div>
                </div>
                <a href="{{ route('public.about.achievements') }}" target="_blank" class="px-3 py-1.5 rounded-lg bg-emerald-600 text-white text-xs font-bold hover:bg-emerald-700 transition-colors">
                    Lihat di Web ↗
                </a>
            </div>
        @endif

        @if($errors->any())
            <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 shadow-xs">
                <h4 class="text-xs font-bold mb-2 uppercase tracking-wider">Periksa Kembali Isian Formulir:</h4>
                <ul class="list-disc list-inside text-xs space-y-1">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Navigation Tabs: Items List vs Rich Narrative Editor --}}
        <div class="flex items-center gap-3 border-b border-gray-200 pb-2">
            <button 
                type="button" 
                @click="activeTab = 'items'" 
                :class="activeTab === 'items' ? 'bg-[#005952] text-white shadow-xs' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'"
                class="px-5 py-2.5 rounded-2xl text-xs font-bold transition-all flex items-center gap-2"
            >
                <span>🏆 Daftar Penghargaan & Sertifikat</span>
                <span class="px-2 py-0.5 rounded-full bg-white/20 text-[11px] font-mono">{{ $achievements->count() }}</span>
            </button>
            <button 
                type="button" 
                @click="activeTab = 'narrative'" 
                :class="activeTab === 'narrative' ? 'bg-[#005952] text-white shadow-xs' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'"
                class="px-5 py-2.5 rounded-2xl text-xs font-bold transition-all flex items-center gap-2"
            >
                <span>📝 Naskah Pengantar & Teks Bebas (Editor Kaya)</span>
            </button>
        </div>

        {{-- TAB 1: DAFTAR KARTU PENGHARGAAN & SERTIFIKAT --}}
        <div x-show="activeTab === 'items'" class="space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-3xl border border-gray-200 shadow-xs">
                <div>
                    <h3 class="text-base font-bold text-gray-900">Koleksi Piagam, Sertifikasi & Penghargaan</h3>
                    <p class="text-xs text-gray-500 mt-0.5">Kelola foto bukti, nama sertifikat, lembaga penerbit, tahun, dan tautan digital.</p>
                </div>
                <button 
                    type="button" 
                    onclick="openCreateModal()"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-[#005952] text-white text-xs font-bold hover:bg-[#004741] transition-colors shrink-0"
                >
                    <span>+ Tambah Baru</span>
                </button>
            </div>

            @if($achievements->isEmpty())
                <div class="bg-white rounded-3xl border border-dashed border-gray-300 p-12 text-center">
                    <div class="w-12 h-12 rounded-2xl bg-teal-50 text-[#005952] flex items-center justify-center font-bold text-xl mx-auto mb-3">
                        🏆
                    </div>
                    <h4 class="text-base font-bold text-gray-800">Belum Ada Data Penghargaan</h4>
                    <p class="text-xs text-gray-500 max-w-sm mx-auto mt-1 mb-4">Mulai tambahkan sertifikasi ISO, penghargaan inovasi, rekam jejak BRIN, atau HAKI resmi.</p>
                    <button 
                        type="button" 
                        onclick="openCreateModal()"
                        class="px-5 py-2.5 rounded-xl bg-[#005952] text-white text-xs font-bold shadow-xs hover:bg-[#004741]"
                    >
                        Tambah Sertifikat Sekarang
                    </button>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($achievements as $item)
                        <div class="bg-white rounded-3xl border border-gray-200 overflow-hidden shadow-xs hover:shadow-md transition-all flex flex-col">
                            {{-- Image Container --}}
                            <div class="relative h-48 bg-gray-100 overflow-hidden group">
                                @if($item->image)
                                    <img 
                                        src="{{ $item->image }}" 
                                        alt="{{ $item->title }}" 
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                    >
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-300 bg-gray-50 text-4xl">
                                        📜
                                    </div>
                                @endif

                                {{-- Category & Year Badges --}}
                                <div class="absolute top-3 left-3 flex flex-wrap items-center gap-1.5">
                                    <span class="px-2.5 py-1 rounded-lg bg-gray-950/75 backdrop-blur-xs text-white text-[10px] font-bold">
                                        {{ $item->category }}
                                    </span>
                                    @if($item->badge_label)
                                        <span class="px-2.5 py-1 rounded-lg bg-[#005952]/90 backdrop-blur-xs text-white text-[10px] font-bold">
                                            {{ $item->badge_label }}
                                        </span>
                                    @endif
                                </div>

                                <div class="absolute top-3 right-3">
                                    <span class="px-2.5 py-1 rounded-lg {{ $item->is_active ? 'bg-emerald-500 text-white' : 'bg-rose-500 text-white' }} text-[10px] font-bold">
                                        {{ $item->is_active ? 'Aktif' : 'Non-Aktif' }}
                                    </span>
                                </div>
                            </div>

                            {{-- Content --}}
                            <div class="p-5 flex-1 flex flex-col justify-between space-y-4">
                                <div>
                                    <div class="flex items-center justify-between text-xs text-gray-500 font-semibold mb-1">
                                        <span>{{ $item->issuer ?: 'Lembaga Resmi' }}</span>
                                        <span class="font-mono">{{ $item->year }}</span>
                                    </div>
                                    <h4 class="font-bold text-gray-950 text-sm leading-snug">
                                        {{ $item->title }}
                                    </h4>
                                    @if($item->description)
                                        <p class="text-xs text-gray-600 mt-2 line-clamp-3 leading-relaxed">
                                            {{ $item->description }}
                                        </p>
                                    @endif
                                </div>

                                <div class="pt-3 border-t border-gray-100 flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <span class="text-[11px] font-mono text-gray-400">
                                            #{{ $item->sort_order }}
                                        </span>
                                        <span class="px-2 py-0.5 rounded-md bg-teal-50 text-[#005952] text-[10px] font-bold border border-teal-200/60">
                                            {{ count($item->all_photos) }} Foto
                                        </span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <button 
                                            type="button" 
                                            onclick='openEditModal(@json($item))'
                                            class="px-3 py-1.5 rounded-lg bg-teal-50 hover:bg-teal-100 text-[#005952] text-xs font-bold transition-colors cursor-pointer"
                                        >
                                            Sunting
                                        </button>
                                        <form 
                                            action="{{ route('admin.achievements.destroy', $item->id) }}" 
                                            method="POST" 
                                            onsubmit="return confirm('Hapus pencapaian ini secara permanen?')"
                                        >
                                            @csrf
                                            @method('DELETE')
                                            <button 
                                                type="submit" 
                                                class="px-3 py-1.5 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-600 text-xs font-bold transition-colors"
                                            >
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- TAB 2: NASKAH PENGANTAR & EDITOR TEKS BEBAS (QUILL) --}}
        <div x-show="activeTab === 'narrative'" class="space-y-6" style="display: none;">
            <form action="{{ route('admin.achievements.narrative') }}" method="POST" id="form-narrative">
                @csrf
                @method('PUT')

                <div class="bg-white rounded-3xl border border-gray-200 p-6 sm:p-8 shadow-xs space-y-6">
                    <div class="flex items-center justify-between pb-4 border-b border-gray-100">
                        <div>
                            <h3 class="text-base font-bold text-gray-900">Pengantar Editorial & Narasi Tonggak Inovasi</h3>
                            <p class="text-xs text-gray-500">Tuliskan manifesto pencapaian, rekam jejak riset, atau metodologi audit secara bebas.</p>
                        </div>
                        <button 
                            type="submit" 
                            class="px-5 py-2.5 rounded-xl bg-[#005952] hover:bg-[#004741] text-white text-xs font-bold shadow-md transition-all"
                        >
                            Simpan Narasi Pencapaian
                        </button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                                Lencana Hero (Badge Top)
                            </label>
                            <input 
                                type="text" 
                                name="achievement_badge" 
                                value="{{ old('achievement_badge', $profile->achievement_badge) }}" 
                                placeholder="Contoh: REKOGNISI & REKAM JEJAK NUSANTARA"
                                class="w-full text-xs sm:text-sm rounded-xl border-gray-300 focus:border-[#005952] focus:ring-[#005952]"
                            >
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                                Judul Besar Halaman (H1)
                            </label>
                            <input 
                                type="text" 
                                name="achievement_title" 
                                value="{{ old('achievement_title', $profile->achievement_title) }}" 
                                placeholder="Pencapaian, Penghargaan & Sertifikasi Resmi"
                                class="w-full text-xs sm:text-sm rounded-xl border-gray-300 focus:border-[#005952] focus:ring-[#005952]"
                            >
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                                Ringkasan Pembuka (Lead Summary)
                            </label>
                            <textarea 
                                name="achievement_summary" 
                                rows="3" 
                                placeholder="Uraian pembuka tentang standar kualitas, akreditasi, dan apresiasi yang telah diraih..."
                                class="w-full text-xs sm:text-sm rounded-xl border-gray-300 focus:border-[#005952] focus:ring-[#005952] leading-relaxed"
                            >{{ old('achievement_summary', $profile->achievement_summary) }}</textarea>
                        </div>
                    </div>

                    {{-- Quill Editor for Narrative --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                            Naskah Narasi Lengkap (Editor Teks Kaya & Foto)
                        </label>
                        <div id="quill-editor-wrapper" class="relative">
                            <div id="quill-toolbar">
                                <span class="ql-formats">
                                    <select class="ql-header">
                                        <option value="" selected>Normal</option>
                                        <option value="2">Heading 2</option>
                                        <option value="3">Heading 3</option>
                                    </select>
                                </span>
                                <span class="ql-formats">
                                    <button class="ql-bold"></button>
                                    <button class="ql-italic"></button>
                                    <button class="ql-underline"></button>
                                    <button class="ql-strike"></button>
                                </span>
                                <span class="ql-formats">
                                    <select class="ql-color"></select>
                                    <select class="ql-background"></select>
                                </span>
                                <span class="ql-formats">
                                    <button class="ql-list" value="ordered"></button>
                                    <button class="ql-list" value="bullet"></button>
                                </span>
                                <span class="ql-formats">
                                    <button class="ql-blockquote"></button>
                                    <button class="ql-code-block"></button>
                                    <button class="ql-link"></button>
                                    <button class="ql-image" type="button"></button>
                                    <button id="btn-insert-hr" type="button" class="ql-custom-btn text-xs font-black">—</button>
                                </span>
                                <span class="ql-formats">
                                    <button class="ql-clean"></button>
                                </span>
                                <span class="ql-formats">
                                    <button id="btn-undo" type="button" class="ql-custom-btn text-xs font-bold">↶</button>
                                    <button id="btn-redo" type="button" class="ql-custom-btn text-xs font-bold">↷</button>
                                </span>
                            </div>

                            <div id="quill-editor">{!! old('achievement_content_html', $profile->achievement_content_html) !!}</div>
                            <textarea name="achievement_content_html" id="hidden-narrative-content" class="hidden">{!! old('achievement_content_html', $profile->achievement_content_html) !!}</textarea>
                        </div>
                    </div>

                    <div class="flex items-center justify-end pt-4 border-t border-gray-100">
                        <button 
                            type="submit" 
                            class="px-6 py-2.5 rounded-xl bg-[#005952] hover:bg-[#004741] text-white text-xs font-bold shadow-md transition-all"
                        >
                            Simpan Narasi Pencapaian
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL TAMBAH / EDIT PENGHARGAAN & SERTIFIKAT --}}
    <div id="modal-item" class="fixed inset-0 z-50 hidden items-center justify-center bg-gray-950/60 backdrop-blur-xs p-4 overflow-y-auto">
        <div class="bg-white rounded-3xl shadow-2xl max-w-2xl w-full overflow-hidden border border-gray-200 my-8">
            <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-xl bg-teal-50 text-[#005952] flex items-center justify-center font-bold">🏆</div>
                    <h3 id="modal-item-title" class="font-bold text-gray-900 text-sm">Tambah Sertifikat / Penghargaan</h3>
                </div>
                <button type="button" onclick="closeModalItem()" class="text-gray-400 hover:text-gray-600 p-1 rounded-lg">✕</button>
            </div>

            <form id="form-item" method="POST" action="{{ route('admin.achievements.store') }}" enctype="multipart/form-data" class="p-6 space-y-4">
                @csrf
                <div id="method-field"></div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">
                            Judul Penghargaan / Sertifikat <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="title" 
                            id="item-title" 
                            required 
                            placeholder="Contoh: Sertifikasi ISO/IEC 27001:2022 Sistem Manajemen Keamanan Informasi"
                            class="w-full text-xs rounded-xl border-gray-300 focus:border-[#005952] focus:ring-[#005952]"
                        >
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">
                            Kategori <span class="text-rose-500">*</span>
                        </label>
                        <select 
                            name="category" 
                            id="item-category" 
                            required 
                            class="w-full text-xs rounded-xl border-gray-300 focus:border-[#005952] focus:ring-[#005952]"
                        >
                            <option value="Penghargaan">Penghargaan (Pemuda Pelopor, Juara, dsb)</option>
                            <option value="Pitch Deck">Pitch Deck & Bahan Presentasi</option>
                            <option value="Momen Lapangan">Momen Lapangan & Riset Komunitas</option>
                            <option value="Sertifikasi">Sertifikasi Resmi (ISO / Akreditasi)</option>
                            <option value="Rekognisi Pemerintah">Rekognisi Pemerintah RI / Kementerian</option>
                            <option value="Paten & HAKI">Paten, HAKI & Hak Cipta</option>
                            <option value="Prestasi">Prestasi & Kompetisi Inovasi</option>
                            <option value="Kemitraan">Kemitraan Strategis & Konsorsium</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">
                            Label Lencana (Badge Khusus)
                        </label>
                        <input 
                            type="text" 
                            name="badge_label" 
                            id="item-badge_label" 
                            placeholder="Contoh: Standar Global, Nasional, dll"
                            class="w-full text-xs rounded-xl border-gray-300 focus:border-[#005952] focus:ring-[#005952]"
                        >
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">
                            Lembaga / Badan Penerbit (Issuer)
                        </label>
                        <input 
                            type="text" 
                            name="issuer" 
                            id="item-issuer" 
                            placeholder="Contoh: BRIN / Kemenkomdigi / TUV Rheinland"
                            class="w-full text-xs rounded-xl border-gray-300 focus:border-[#005952] focus:ring-[#005952]"
                        >
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">
                            Tahun / Periode
                        </label>
                        <input 
                            type="text" 
                            name="year" 
                            id="item-year" 
                            placeholder="Contoh: 2025 / Agustus 2025"
                            class="w-full text-xs rounded-xl border-gray-300 focus:border-[#005952] focus:ring-[#005952]"
                        >
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">
                            Uraian & Deskripsi Lengkap
                        </label>
                        <textarea 
                            name="description" 
                            id="item-description" 
                            rows="3" 
                            placeholder="Jelaskan signifikansi pencapaian, cakupan sertifikasi, atau dampak inovasi..."
                            class="w-full text-xs rounded-xl border-gray-300 focus:border-[#005952] focus:ring-[#005952]"
                        ></textarea>
                    </div>

                    {{-- Multi-Photo Upload & Primary Image Options --}}
                    <div class="sm:col-span-2 bg-gray-50/80 p-4 rounded-2xl border border-gray-200 space-y-3">
                        <div>
                            <label class="block text-xs font-bold text-gray-800 uppercase mb-1">
                                Unggah Banyak Foto Sekaligus (Galeri / Slide Momen)
                            </label>
                            <p class="text-[11px] text-gray-500 mb-2">
                                Anda dapat memilih banyak foto sekaligus (misal foto piala, piagam, founder di panggung, slide presentasi, atau kegiatan lapangan).
                            </p>
                            <input 
                                type="file" 
                                name="photos_files[]" 
                                id="item-photos_files"
                                multiple 
                                accept="image/*"
                                class="w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#005952] file:text-white hover:file:bg-[#004741] cursor-pointer"
                            >
                        </div>

                        <div id="existing-photos-wrapper" class="hidden pt-2 border-t border-gray-200">
                            <label class="block text-[11px] font-bold text-gray-700 uppercase mb-1.5">
                                Foto yang Tersimpan (Klik tombol ✕ untuk menghapus foto):
                            </label>
                            <div id="existing-photos-list" class="flex flex-wrap gap-2.5"></div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-2 border-t border-gray-200">
                            <div>
                                <label class="block text-[11px] font-bold text-gray-700 uppercase mb-1">
                                    Unggah Foto Sampul Tunggal (Opsional)
                                </label>
                                <input 
                                    type="file" 
                                    name="image_file" 
                                    accept="image/*"
                                    class="w-full text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-gray-200 file:text-gray-700 cursor-pointer"
                                >
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-gray-700 uppercase mb-1">
                                    Atau Tautan URL Gambar Sampul
                                </label>
                                <input 
                                    type="url" 
                                    name="image" 
                                    id="item-image" 
                                    placeholder="https://images.unsplash.com/..."
                                    class="w-full text-xs rounded-xl border-gray-300 focus:border-[#005952] focus:ring-[#005952] font-mono"
                                >
                            </div>
                        </div>
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">
                            Tautan Pitch Deck / Dokumen / Verifikasi Online
                        </label>
                        <input 
                            type="url" 
                            name="credential_url" 
                            id="item-credential_url" 
                            placeholder="Contoh: tautan Pitch Deck PDF, materi presentasi, atau verifikasi digital (https://...)"
                            class="w-full text-xs rounded-xl border-gray-300 focus:border-[#005952] focus:ring-[#005952]"
                        >
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">
                            Urutan Tampil (#)
                        </label>
                        <input 
                            type="number" 
                            name="sort_order" 
                            id="item-sort_order" 
                            value="0" 
                            class="w-full text-xs rounded-xl border-gray-300 focus:border-[#005952] focus:ring-[#005952]"
                        >
                    </div>

                    <div class="flex items-center gap-6 pt-5">
                        <label class="inline-flex items-center gap-2 text-xs font-bold text-gray-700 cursor-pointer">
                            <input type="checkbox" name="is_active" id="item-is_active" value="1" checked class="rounded-md text-[#005952] focus:ring-[#005952]">
                            <span>Tampilkan di Publik</span>
                        </label>
                        <label class="inline-flex items-center gap-2 text-xs font-bold text-gray-700 cursor-pointer">
                            <input type="checkbox" name="is_featured" id="item-is_featured" value="1" class="rounded-md text-[#005952] focus:ring-[#005952]">
                            <span>Sorotan Utama</span>
                        </label>
                    </div>
                </div>

                <div class="pt-4 border-t border-gray-100 flex items-center justify-end gap-2">
                    <button type="button" onclick="closeModalItem()" class="px-4 py-2 rounded-xl text-xs font-bold text-gray-600 hover:bg-gray-100 transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2 rounded-xl bg-[#005952] hover:bg-[#004741] text-white text-xs font-bold shadow-xs transition-all">
                        Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Quill Script & Handlers --}}
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
    <script>
        // Modal Handlers
        const modalItem = document.getElementById('modal-item');
        const formItem = document.getElementById('form-item');
        const modalTitle = document.getElementById('modal-item-title');
        const methodField = document.getElementById('method-field');

        function openCreateModal() {
            modalTitle.textContent = 'Tambah Sertifikat, Penghargaan & Momen Baru';
            formItem.action = "{{ route('admin.achievements.store') }}";
            methodField.innerHTML = '';
            formItem.reset();
            document.getElementById('item-is_active').checked = true;
            document.getElementById('item-sort_order').value = 0;

            // Reset photos
            const existingWrapper = document.getElementById('existing-photos-wrapper');
            const existingList = document.getElementById('existing-photos-list');
            if (existingWrapper) existingWrapper.classList.add('hidden');
            if (existingList) existingList.innerHTML = '';
            const photosInput = document.getElementById('item-photos_files');
            if (photosInput) photosInput.value = '';

            modalItem.classList.remove('hidden');
            modalItem.classList.add('flex');
        }

        function openEditModal(item) {
            modalTitle.textContent = 'Sunting Momen / Penghargaan: ' + item.title;
            formItem.action = `/admin/achievements/${item.id}`;
            methodField.innerHTML = '@method("PUT")';
            formItem.reset();
            
            document.getElementById('item-title').value = item.title || '';
            document.getElementById('item-category').value = item.category || 'Penghargaan';
            document.getElementById('item-badge_label').value = item.badge_label || '';
            document.getElementById('item-issuer').value = item.issuer || '';
            document.getElementById('item-year').value = item.year || '';
            document.getElementById('item-description').value = item.description || '';
            document.getElementById('item-image').value = item.image || '';
            document.getElementById('item-credential_url').value = item.credential_url || '';
            document.getElementById('item-sort_order').value = item.sort_order || 0;
            document.getElementById('item-is_active').checked = Boolean(item.is_active);
            document.getElementById('item-is_featured').checked = Boolean(item.is_featured);

            // Populate existing photos
            const existingWrapper = document.getElementById('existing-photos-wrapper');
            const existingList = document.getElementById('existing-photos-list');
            if (existingWrapper && existingList) {
                existingList.innerHTML = '';
                let photos = [];
                if (Array.isArray(item.photos)) {
                    photos = [...item.photos];
                }
                if (item.image && !photos.includes(item.image)) {
                    photos.unshift(item.image);
                }

                if (photos.length > 0) {
                    existingWrapper.classList.remove('hidden');
                    photos.forEach((photoUrl) => {
                        const div = document.createElement('div');
                        div.className = 'relative w-16 h-16 rounded-xl overflow-hidden border border-gray-300 shadow-xs group shrink-0';
                        div.innerHTML = `
                            <img src="${photoUrl}" class="w-full h-full object-cover">
                            <input type="hidden" name="existing_photos[]" value="${photoUrl}">
                            <button type="button" onclick="this.parentElement.remove()" class="absolute top-1 right-1 w-5 h-5 bg-rose-600 text-white rounded-full flex items-center justify-center text-[10px] font-bold shadow-xs hover:bg-rose-700 cursor-pointer" title="Hapus Foto">✕</button>
                        `;
                        existingList.appendChild(div);
                    });
                } else {
                    existingWrapper.classList.add('hidden');
                }
            }

            modalItem.classList.remove('hidden');
            modalItem.classList.add('flex');
        }

        function closeModalItem() {
            modalItem.classList.add('hidden');
            modalItem.classList.remove('flex');
        }

        // Quill Initialization for Narrative Tab
        document.addEventListener('DOMContentLoaded', function() {
            let quillNarrative = null;
            const editorEl = document.getElementById('quill-editor');
            const hiddenNarrative = document.getElementById('hidden-narrative-content');

            if (typeof Quill !== 'undefined' && editorEl) {
                quillNarrative = new Quill('#quill-editor', {
                    modules: {
                        toolbar: '#quill-toolbar'
                    },
                    theme: 'snow',
                    placeholder: 'Tuliskan pengantar, sejarah pencapaian, dan dokumentasi di sini...'
                });

                quillNarrative.on('text-change', function() {
                    if (hiddenNarrative && quillNarrative.root) {
                        hiddenNarrative.value = quillNarrative.root.innerHTML;
                    }
                });

                document.getElementById('form-narrative')?.addEventListener('submit', function() {
                    if (hiddenNarrative && quillNarrative && quillNarrative.root) {
                        hiddenNarrative.value = quillNarrative.root.innerHTML;
                    }
                });

                document.getElementById('btn-undo')?.addEventListener('click', function(e) {
                    e.preventDefault();
                    quillNarrative.history.undo();
                });
                document.getElementById('btn-redo')?.addEventListener('click', function(e) {
                    e.preventDefault();
                    quillNarrative.history.redo();
                });
                document.getElementById('btn-insert-hr')?.addEventListener('click', function(e) {
                    e.preventDefault();
                    const range = quillNarrative.getSelection(true);
                    quillNarrative.clipboard.dangerouslyPasteHTML(range.index, '<hr><p><br></p>');
                    quillNarrative.setSelection(range.index + 2, Quill.sources.SILENT);
                });
            }
        });
    </script>
</x-app-layout>
