<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <nav class="flex items-center gap-2 text-xs text-gray-500 mb-1">
                    <a href="{{ route('dashboard') }}" class="hover:text-[#005952] transition-colors">Admin</a>
                    <span>/</span>
                    <span class="text-[#005952] font-semibold">Profil Perusahaan</span>
                </nav>
                <h2 class="font-black text-xl sm:text-2xl text-gray-900 leading-tight">
                    Kelola Profil Perusahaan & Identitas Ekosistem
                </h2>
            </div>
            <div class="flex items-center gap-3">
                <a 
                    href="{{ route('public.about.profile') }}" 
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
                    onclick="document.getElementById('profile-form').requestSubmit()"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-[#005952] hover:bg-[#004741] text-white text-xs font-bold shadow-md hover:shadow-lg transition-all"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span>Simpan Perubahan</span>
                </button>
            </div>
        </div>
    </x-slot>

    {{-- Quill Rich Text Editor CDN CSS & Word Pro Styles --}}
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />
    <style>
        #quill-editor-wrapper {
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }
        #quill-toolbar {
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
            border-color: #cbd5e1;
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
            min-height: 420px;
            font-size: 15px;
            line-height: 1.8;
            color: #1e293b;
            background: #ffffff;
            font-family: inherit;
        }
        #quill-editor .ql-editor {
            min-height: 420px;
            padding: 24px 28px;
        }
        #quill-editor .ql-editor h2 {
            font-size: 1.75rem;
            font-weight: 800;
            color: #0f172a;
            margin-top: 1.75rem;
            margin-bottom: 0.75rem;
            border-bottom: 2px solid #f1f5f9;
            padding-bottom: 0.5rem;
        }
        #quill-editor .ql-editor h3 {
            font-size: 1.35rem;
            font-weight: 700;
            color: #005952;
            margin-top: 1.5rem;
            margin-bottom: 0.5rem;
        }
        #quill-editor .ql-editor blockquote {
            border-left: 4px solid #005952;
            padding: 12px 20px;
            margin: 20px 0;
            background: #f0fdf4;
            color: #166534;
            font-style: italic;
            border-radius: 0 12px 12px 0;
        }
        #quill-editor .ql-editor img {
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            margin: 20px auto;
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
            max-width: none !important;
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

    <div class="py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Flash Notification --}}
        @if(session('success'))
            <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center justify-between shadow-xs">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-xl bg-emerald-500 text-white flex items-center justify-center font-bold">✓</div>
                    <div>
                        <h4 class="text-sm font-bold">Berhasil Disimpan</h4>
                        <p class="text-xs text-emerald-700">{{ session('success') }}</p>
                    </div>
                </div>
                <a href="{{ route('public.about.profile') }}" target="_blank" class="px-3 py-1.5 rounded-lg bg-emerald-600 text-white text-xs font-bold hover:bg-emerald-700 transition-colors">
                    Lihat Hasil ↗
                </a>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 shadow-xs">
                <h4 class="text-xs font-bold mb-2 uppercase tracking-wider">Periksa Kembali Isian Formulir:</h4>
                <ul class="list-disc list-inside text-xs space-y-1">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form 
            id="profile-form" 
            action="{{ route('admin.company-profile.update') }}" 
            method="POST" 
            enctype="multipart/form-data"
            class="space-y-8"
        >
            @csrf
            @method('PUT')

            {{-- 1. Hero & Ringkasan Identitas --}}
            <div class="bg-white rounded-3xl border border-gray-200 p-6 sm:p-8 shadow-xs">
                <div class="flex items-center gap-3 pb-4 mb-6 border-b border-gray-100">
                    <div class="w-9 h-9 rounded-xl bg-teal-50 text-[#005952] flex items-center justify-center font-black text-sm">
                        01
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-gray-900">Hero & Identitas Resmi Perusahaan</h3>
                        <p class="text-xs text-gray-500">Judul utama, tagline, lencana resmi, dan opening statement profil.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                            Lencana Hero (Badge Top)
                        </label>
                        <input 
                            type="text" 
                            name="hero_badge" 
                            value="{{ old('hero_badge', $profile->hero_badge) }}" 
                            placeholder="Contoh: IDENTITAS RESMI PT YOTA INOVASI NUSANTARA"
                            class="w-full text-xs sm:text-sm rounded-xl border-gray-300 focus:border-[#005952] focus:ring-[#005952]"
                        >
                        <p class="text-[11px] text-gray-400 mt-1">Teks lencana kecil di bagian paling atas hero header.</p>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                            Nama Resmi Perusahaan <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="company_name" 
                            required
                            value="{{ old('company_name', $profile->company_name) }}" 
                            placeholder="PT Yota Inovasi Nusantara"
                            class="w-full text-xs sm:text-sm rounded-xl border-gray-300 focus:border-[#005952] focus:ring-[#005952]"
                        >
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                            Tagline / Judul Besar Halaman (H1) <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="tagline" 
                            required
                            value="{{ old('tagline', $profile->tagline) }}" 
                            placeholder="Orkestrasi Inovasi Teknologi Berkelanjutan Nusantara"
                            class="w-full text-sm sm:text-base font-semibold rounded-xl border-gray-300 focus:border-[#005952] focus:ring-[#005952]"
                        >
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                            Ringkasan Eksekutif (Lead Description)
                        </label>
                        <textarea 
                            name="summary" 
                            rows="3" 
                            placeholder="Paragraf pembuka profil yang merefleksikan posisi, visi, dan filosofi ekosistem..."
                            class="w-full text-xs sm:text-sm rounded-xl border-gray-300 focus:border-[#005952] focus:ring-[#005952] leading-relaxed"
                        >{{ old('summary', $profile->summary) }}</textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                            URL Gambar Sampul / Hero Image
                        </label>
                        <input 
                            type="url" 
                            name="hero_image" 
                            id="hero_image_input"
                            value="{{ old('hero_image', $profile->hero_image) }}" 
                            placeholder="https://images.unsplash.com/..."
                            class="w-full text-xs rounded-xl border-gray-300 focus:border-[#005952] focus:ring-[#005952] font-mono"
                        >
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                            Atau Unggah Gambar Sampul Baru (Max 5MB)
                        </label>
                        <input 
                            type="file" 
                            name="hero_file" 
                            accept="image/jpeg,image/png,image/webp,image/svg+xml"
                            class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-teal-50 file:text-[#005952] hover:file:bg-teal-100"
                        >
                    </div>
                </div>
            </div>

            {{-- 2. Teks Editor Kaya (Quill WYSIWYG) --}}
            <div class="bg-white rounded-3xl border border-gray-200 p-6 sm:p-8 shadow-xs">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 pb-4 mb-6 border-b border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-teal-50 text-[#005952] flex items-center justify-center font-black text-sm">
                            02
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-gray-900">Naskah Lengkap Profil (Editor Teks Kaya & Gambar)</h3>
                            <p class="text-xs text-gray-500">Gunakan toolbar untuk format judul, kutipan manifesto, poin pilar, dan sisipkan gambar/foto bebas.</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 text-xs text-gray-500 bg-gray-50 px-3 py-1.5 rounded-xl border border-gray-200">
                        <span id="stat-words" class="font-bold text-gray-700">0 Kata</span>
                        <span>•</span>
                        <span id="stat-chars" class="font-bold text-gray-700">0 Karakter</span>
                    </div>
                </div>

                <div id="quill-editor-wrapper" class="relative">
                    {{-- Toolbar Quill Lengkap --}}
                    <div id="quill-toolbar">
                        <span class="ql-formats">
                            <select class="ql-header" title="Gaya Teks">
                                <option value="" selected>Normal</option>
                                <option value="2">Heading 2 (Sub-bab)</option>
                                <option value="3">Heading 3 (Poin Kunci)</option>
                                <option value="4">Heading 4 (Detail)</option>
                            </select>
                        </span>
                        <span class="ql-formats">
                            <button class="ql-bold" title="Tebal (Ctrl+B)"></button>
                            <button class="ql-italic" title="Miring (Ctrl+I)"></button>
                            <button class="ql-underline" title="Garis Bawah (Ctrl+U)"></button>
                            <button class="ql-strike" title="Coret"></button>
                        </span>
                        <span class="ql-formats">
                            <select class="ql-color" title="Warna Teks"></select>
                            <select class="ql-background" title="Warna Latar (Highlight)"></select>
                        </span>
                        <span class="ql-formats">
                            <select class="ql-align" title="Perataan Paragraf"></select>
                        </span>
                        <span class="ql-formats">
                            <button class="ql-list" value="ordered" title="Daftar Bernomor"></button>
                            <button class="ql-list" value="bullet" title="Daftar Poin"></button>
                        </span>
                        <span class="ql-formats">
                            <button class="ql-blockquote" title="Kutipan / Manifesto"></button>
                            <button class="ql-code-block" title="Blok Kode / Spesifikasi"></button>
                        </span>
                        <span class="ql-formats">
                            <button class="ql-link" title="Sisipkan Tautan Web"></button>
                            <button class="ql-image" type="button" title="Sisipkan / Unggah Gambar (Ctrl+Shift+I)"></button>
                            <button class="ql-video" type="button" title="Sematkan Video YouTube"></button>
                            <button id="btn-insert-hr" type="button" class="ql-custom-btn text-xs font-black text-gray-600" title="Garis Pembatas (Divider)">—</button>
                        </span>
                        <span class="ql-formats">
                            <button class="ql-clean" title="Bersihkan Format"></button>
                        </span>
                        <span class="ql-formats">
                            <button id="btn-undo" type="button" class="ql-custom-btn text-xs font-bold text-gray-600" title="Urungkan (Undo)">↶</button>
                            <button id="btn-redo" type="button" class="ql-custom-btn text-xs font-bold text-gray-600" title="Ulangi (Redo)">↷</button>
                        </span>
                        <span class="ql-formats ml-auto">
                            <button id="btn-fullscreen-toggle" type="button" class="ql-custom-btn !w-auto !px-2.5 text-xs font-bold text-[#005952] bg-teal-50 hover:bg-teal-100 rounded-lg flex items-center gap-1.5" title="Buka Layar Penuh">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/></svg>
                                <span id="fullscreen-text">Layar Penuh</span>
                            </button>
                        </span>
                    </div>

                    {{-- Kanvas Quill Editor --}}
                    <div id="quill-editor">{!! old('content_html', $profile->content_html) !!}</div>

                    {{-- Hidden Input untuk Simpan Konten HTML ke Form --}}
                    <textarea name="content_html" id="hidden-content" class="hidden">{!! old('content_html', $profile->content_html) !!}</textarea>
                </div>
            </div>

            {{-- 3. Tiga Pilar Sorotan (Highlights Banner) --}}
            <div class="bg-white rounded-3xl border border-gray-200 p-6 sm:p-8 shadow-xs">
                <div class="flex items-center gap-3 pb-4 mb-6 border-b border-gray-100">
                    <div class="w-9 h-9 rounded-xl bg-teal-50 text-[#005952] flex items-center justify-center font-black text-sm">
                        03
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-gray-900">Kartu Keunggulan Strategis (Corporate Highlights)</h3>
                        <p class="text-xs text-gray-500">Tiga kartu pilar yang muncul tepat di bawah hero profil (Kedaulatan, Riset, Dividen, dll).</p>
                    </div>
                </div>

                @php
                    $highlights = old('highlights', $profile->highlights ?: \App\Models\CompanyProfile::defaultHighlights());
                @endphp

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @for($i = 0; $i < 3; $i++)
                        @php
                            $hl = $highlights[$i] ?? ['number' => '0'.($i+1), 'title' => '', 'description' => ''];
                        @endphp
                        <div class="p-5 rounded-2xl bg-gray-50 border border-gray-200 space-y-3">
                            <div class="flex items-center justify-between">
                                <label class="text-xs font-bold text-[#005952] uppercase tracking-wider">Kartu #{{ $i + 1 }}</label>
                                <input 
                                    type="text" 
                                    name="highlights[{{ $i }}][number]" 
                                    value="{{ $hl['number'] ?? '0'.($i+1) }}" 
                                    class="w-14 text-xs font-mono font-bold text-center rounded-lg border-gray-300 py-1"
                                    placeholder="0{{ $i+1 }}"
                                >
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-gray-600 uppercase mb-1">Judul Pilar</label>
                                <input 
                                    type="text" 
                                    name="highlights[{{ $i }}][title]" 
                                    value="{{ $hl['title'] ?? '' }}" 
                                    placeholder="Contoh: Kedaulatan Digital"
                                    class="w-full text-xs font-bold rounded-xl border-gray-300 focus:border-[#005952] focus:ring-[#005952]"
                                >
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-gray-600 uppercase mb-1">Uraian Ringkas</label>
                                <textarea 
                                    name="highlights[{{ $i }}][description]" 
                                    rows="3" 
                                    placeholder="Penjelasan ringkas peran pilar ini..."
                                    class="w-full text-xs rounded-xl border-gray-300 focus:border-[#005952] focus:ring-[#005952]"
                                >{{ $hl['description'] ?? '' }}</textarea>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>

            {{-- 4. Legalitas Badan Hukum & Kantor Resmi --}}
            <div class="bg-white rounded-3xl border border-gray-200 p-6 sm:p-8 shadow-xs">
                <div class="flex items-center gap-3 pb-4 mb-6 border-b border-gray-100">
                    <div class="w-9 h-9 rounded-xl bg-teal-50 text-[#005952] flex items-center justify-center font-black text-sm">
                        04
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-gray-900">Legalitas Badan Hukum & Kontak Resmi</h3>
                        <p class="text-xs text-gray-500">Informasi pengesahan Kemenkumham, alamat kantor terdaftar, telepon, dan kontak surat elektronik.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                            Nama Entitas Badan Hukum <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="legal_entity_name" 
                            required
                            value="{{ old('legal_entity_name', $profile->legal_entity_name) }}" 
                            placeholder="PT Yota Inovasi Nusantara"
                            class="w-full text-xs sm:text-sm rounded-xl border-gray-300 focus:border-[#005952] focus:ring-[#005952]"
                        >
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                            Alamat Email Resmi (Hello / Inquiry)
                        </label>
                        <input 
                            type="email" 
                            name="contact_email" 
                            value="{{ old('contact_email', $profile->contact_email) }}" 
                            placeholder="hello@yotainovasi.id"
                            class="w-full text-xs sm:text-sm rounded-xl border-gray-300 focus:border-[#005952] focus:ring-[#005952]"
                        >
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                            Keterangan Registrasi & Kemenkumham
                        </label>
                        <textarea 
                            name="legal_registration_info" 
                            rows="2" 
                            placeholder="Terdaftar secara sah di Kementerian Hukum dan HAM Republik Indonesia..."
                            class="w-full text-xs sm:text-sm rounded-xl border-gray-300 focus:border-[#005952] focus:ring-[#005952]"
                        >{{ old('legal_registration_info', $profile->legal_registration_info) }}</textarea>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                            Alamat Kantor Resmi (Headquarters)
                        </label>
                        <textarea 
                            name="office_address" 
                            rows="2" 
                            placeholder="Perumahan Jatimekar residence, Blk. C No.26..."
                            class="w-full text-xs sm:text-sm rounded-xl border-gray-300 focus:border-[#005952] focus:ring-[#005952]"
                        >{{ old('office_address', $profile->office_address) }}</textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                            Nomor Telepon / WhatsApp Resmi
                        </label>
                        <input 
                            type="text" 
                            name="contact_phone" 
                            value="{{ old('contact_phone', $profile->contact_phone) }}" 
                            placeholder="0858 6231 9524"
                            class="w-full text-xs sm:text-sm rounded-xl border-gray-300 focus:border-[#005952] focus:ring-[#005952]"
                        >
                    </div>
                </div>
            </div>

            {{-- 5. Metadata SEO --}}
            <div class="bg-white rounded-3xl border border-gray-200 p-6 sm:p-8 shadow-xs">
                <div class="flex items-center gap-3 pb-4 mb-6 border-b border-gray-100">
                    <div class="w-9 h-9 rounded-xl bg-teal-50 text-[#005952] flex items-center justify-center font-black text-sm">
                        05
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-gray-900">Optimasi Mesin Pencari (SEO Metadata)</h3>
                        <p class="text-xs text-gray-500">Judul dan ringkasan cuplikan yang tampil di Google Search dan media sosial.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                            Meta Title
                        </label>
                        <input 
                            type="text" 
                            name="meta_title" 
                            value="{{ old('meta_title', $profile->meta_title) }}" 
                            placeholder="Profil Perusahaan & Ekosistem - PT Yota Inovasi Nusantara"
                            class="w-full text-xs sm:text-sm rounded-xl border-gray-300 focus:border-[#005952] focus:ring-[#005952]"
                        >
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                            Meta Description
                        </label>
                        <textarea 
                            name="meta_description" 
                            rows="2" 
                            placeholder="Profil resmi PT Yota Inovasi Nusantara..."
                            class="w-full text-xs sm:text-sm rounded-xl border-gray-300 focus:border-[#005952] focus:ring-[#005952]"
                        >{{ old('meta_description', $profile->meta_description) }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Sticky Save Action Bar --}}
            <div class="sticky bottom-6 z-20 bg-white/95 backdrop-blur-md p-4 rounded-2xl border border-gray-200 shadow-xl flex items-center justify-between">
                <div class="flex items-center gap-2 text-xs text-gray-600">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span>Pastikan data profil akurat sebelum publikasi ke publik.</span>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('public.about.profile') }}" target="_blank" class="px-4 py-2 rounded-xl text-xs font-bold text-gray-600 hover:bg-gray-100 transition-colors">
                        Pratinjau Web ↗
                    </a>
                    <button 
                        type="submit" 
                        class="px-6 py-2.5 rounded-xl bg-[#005952] hover:bg-[#004741] text-white text-xs font-bold shadow-md hover:shadow-lg transition-all"
                    >
                        Simpan Semua Perubahan
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- MODAL SISIPKAN GAMBAR DENGAN TABS (UPLOAD FILE & URL WEB) --}}
    <div id="modal-insert-image" class="fixed inset-0 z-50 hidden items-center justify-center bg-gray-950/60 backdrop-blur-xs p-4">
        <div class="bg-white rounded-3xl shadow-2xl max-w-lg w-full overflow-hidden border border-gray-200">
            <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-xl bg-teal-50 text-[#005952] flex items-center justify-center font-bold">📷</div>
                    <h3 class="font-bold text-gray-900 text-sm">Sisipkan Gambar ke Naskah Profil</h3>
                </div>
                <button type="button" onclick="closeImageModal()" class="text-gray-400 hover:text-gray-600 p-1 rounded-lg">✕</button>
            </div>

            <div class="px-6 pt-4 flex border-b border-gray-100 text-xs font-bold gap-6">
                <button type="button" id="tab-btn-upload" onclick="switchImageTab('upload')" class="pb-3 border-b-2 border-[#005952] text-[#005952]">
                    Unggah File Komputer
                </button>
                <button type="button" id="tab-btn-url" onclick="switchImageTab('url')" class="pb-3 border-b-2 border-transparent text-gray-400 hover:text-gray-600">
                    Tautan Gambar Web (URL)
                </button>
            </div>

            <div class="p-6 space-y-4">
                {{-- Tab Upload File --}}
                <div id="tab-content-upload">
                    <div 
                        id="drop-zone" 
                        class="border-2 border-dashed border-gray-300 hover:border-[#005952] bg-gray-50 rounded-2xl p-6 text-center cursor-pointer transition-colors"
                        onclick="document.getElementById('input-file-image').click()"
                    >
                        <svg class="w-10 h-10 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <p class="text-xs font-bold text-gray-700">Pilih file atau seret gambar ke sini</p>
                        <p class="text-[10px] text-gray-400 mt-1">Mendukung JPEG, PNG, WEBP, SVG (Maks. 10MB)</p>
                        <input type="file" id="input-file-image" accept="image/*" class="hidden" onchange="handleImageFileSelect(this)">
                    </div>

                    {{-- Upload Progress Bar --}}
                    <div id="upload-progress-bar" class="hidden mt-3">
                        <div class="flex justify-between text-[11px] text-gray-500 font-bold mb-1">
                            <span>Mengunggah foto...</span>
                            <span id="upload-percentage">0%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                            <div id="upload-progress-fill" class="bg-[#005952] h-2 rounded-full transition-all duration-200" style="width: 0%"></div>
                        </div>
                    </div>
                </div>

                {{-- Tab URL Web --}}
                <div id="tab-content-url" class="hidden space-y-3">
                    <div>
                        <label class="block text-[11px] font-bold text-gray-600 uppercase mb-1">URL Gambar Langsung</label>
                        <input 
                            type="url" 
                            id="input-image-url" 
                            placeholder="https://images.unsplash.com/photo-..." 
                            class="w-full text-xs rounded-xl border-gray-300 focus:border-[#005952] focus:ring-[#005952] font-mono"
                            oninput="previewImageUrl(this.value)"
                        >
                    </div>
                </div>

                {{-- Image Preview Thumbnail --}}
                <div id="image-preview-wrapper" class="hidden rounded-xl overflow-hidden border border-gray-200 bg-gray-100 max-h-48 flex items-center justify-center">
                    <img id="image-preview-element" src="" alt="Pratinjau" class="max-h-48 object-contain">
                </div>

                {{-- Keterangan / Caption Gambar --}}
                <div>
                    <label class="block text-[11px] font-bold text-gray-600 uppercase mb-1">Keterangan Gambar (Caption Opsional)</label>
                    <input 
                        type="text" 
                        id="input-image-caption" 
                        placeholder="Contoh: Gedung Inovasi Terpadu YOIN Bandung" 
                        class="w-full text-xs rounded-xl border-gray-300 focus:border-[#005952] focus:ring-[#005952]"
                    >
                </div>
            </div>

            <div class="p-4 bg-gray-50 border-t border-gray-100 flex items-center justify-end gap-2">
                <button type="button" onclick="closeImageModal()" class="px-4 py-2 rounded-xl text-xs font-bold text-gray-600 hover:bg-gray-200 transition-colors">
                    Batal
                </button>
                <button 
                    type="button" 
                    id="btn-submit-insert-image" 
                    onclick="submitInsertImage()" 
                    class="px-5 py-2 rounded-xl bg-[#005952] hover:bg-[#004741] text-white text-xs font-bold transition-all shadow-sm"
                >
                    Sisipkan ke Naskah
                </button>
            </div>
        </div>
    </div>

    {{-- MODAL SISIPKAN VIDEO YOUTUBE --}}
    <div id="modal-insert-video" class="fixed inset-0 z-50 hidden items-center justify-center bg-gray-950/60 backdrop-blur-xs p-4">
        <div class="bg-white rounded-3xl shadow-2xl max-w-md w-full overflow-hidden border border-gray-200">
            <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-xl bg-teal-50 text-[#005952] flex items-center justify-center font-bold">🎬</div>
                    <h3 class="font-bold text-gray-900 text-sm">Sematkan Video YouTube</h3>
                </div>
                <button type="button" onclick="closeVideoModal()" class="text-gray-400 hover:text-gray-600 p-1 rounded-lg">✕</button>
            </div>

            <div class="p-6 space-y-3">
                <div>
                    <label class="block text-[11px] font-bold text-gray-600 uppercase mb-1">Tautan URL Video YouTube</label>
                    <input 
                        type="url" 
                        id="input-video-url" 
                        placeholder="https://www.youtube.com/watch?v=..." 
                        class="w-full text-xs rounded-xl border-gray-300 focus:border-[#005952] focus:ring-[#005952]"
                        oninput="handleVideoUrlInput(this.value)"
                    >
                </div>
                <div id="video-preview-wrapper" class="hidden aspect-video rounded-xl overflow-hidden border border-gray-200">
                    <iframe id="video-preview-iframe" class="w-full h-full" src="" frameborder="0" allowfullscreen></iframe>
                </div>
            </div>

            <div class="p-4 bg-gray-50 border-t border-gray-100 flex items-center justify-end gap-2">
                <button type="button" onclick="closeVideoModal()" class="px-4 py-2 rounded-xl text-xs font-bold text-gray-600 hover:bg-gray-200 transition-colors">
                    Batal
                </button>
                <button 
                    type="button" 
                    id="btn-submit-insert-video" 
                    onclick="submitInsertVideo()" 
                    disabled 
                    class="px-5 py-2 rounded-xl bg-[#005952] hover:bg-[#004741] disabled:opacity-40 text-white text-xs font-bold transition-all shadow-sm"
                >
                    Sematkan Video
                </button>
            </div>
        </div>
    </div>

    {{-- Quill Script --}}
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>

    <script>
        let quill = null;
        let savedRange = null;
        let currentImageTab = 'upload';
        let selectedImageFile = null;

        // Image Modal Switcher
        function switchImageTab(tab) {
            currentImageTab = tab;
            const btnUpload = document.getElementById('tab-btn-upload');
            const btnUrl = document.getElementById('tab-btn-url');
            const contentUpload = document.getElementById('tab-content-upload');
            const contentUrl = document.getElementById('tab-content-url');

            if (tab === 'upload') {
                btnUpload.className = 'pb-3 border-b-2 border-[#005952] text-[#005952]';
                btnUrl.className = 'pb-3 border-b-2 border-transparent text-gray-400 hover:text-gray-600';
                contentUpload.classList.remove('hidden');
                contentUrl.classList.add('hidden');
            } else {
                btnUrl.className = 'pb-3 border-b-2 border-[#005952] text-[#005952]';
                btnUpload.className = 'pb-3 border-b-2 border-transparent text-gray-400 hover:text-gray-600';
                contentUrl.classList.remove('hidden');
                contentUpload.classList.add('hidden');
            }
        }

        function openImageModal() {
            if (quill) {
                savedRange = quill.getSelection() || { index: quill.getLength() - 1, length: 0 };
            }
            const modal = document.getElementById('modal-insert-image');
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }
            // Reset file and previews
            selectedImageFile = null;
            document.getElementById('input-file-image').value = '';
            document.getElementById('input-image-url').value = '';
            document.getElementById('input-image-caption').value = '';
            document.getElementById('image-preview-wrapper').classList.add('hidden');
            document.getElementById('upload-progress-bar').classList.add('hidden');
            switchImageTab('upload');
        }

        function closeImageModal() {
            const modal = document.getElementById('modal-insert-image');
            if (modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
        }

        function handleImageFileSelect(input) {
            if (input.files && input.files[0]) {
                selectedImageFile = input.files[0];
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.getElementById('image-preview-element');
                    const wrapper = document.getElementById('image-preview-wrapper');
                    img.src = e.target.result;
                    wrapper.classList.remove('hidden');
                };
                reader.readAsDataURL(selectedImageFile);
            }
        }

        function previewImageUrl(url) {
            const wrapper = document.getElementById('image-preview-wrapper');
            const img = document.getElementById('image-preview-element');
            if (url && url.trim().length > 5) {
                img.src = url.trim();
                wrapper.classList.remove('hidden');
            } else {
                wrapper.classList.add('hidden');
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

            fetch('{{ route('admin.company-profile.upload-image') }}', {
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
                console.warn('Server upload fallback to data URL:', err);
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
            if (!quill) return;
            const index = savedRange ? savedRange.index : (quill.getSelection() ? quill.getSelection().index : quill.getLength() - 1);
            quill.insertEmbed(index, 'image', imageUrl, Quill.sources.USER);
            if (caption && caption.trim()) {
                quill.insertText(index + 1, '\n' + caption.trim() + '\n', { 'italic': true, 'align': 'center' }, Quill.sources.USER);
                quill.setSelection(index + 3, Quill.sources.SILENT);
            } else {
                quill.setSelection(index + 1, Quill.sources.SILENT);
            }
        }

        function submitInsertImage() {
            const captionInput = document.getElementById('input-image-caption');
            const caption = captionInput ? captionInput.value : '';

            if (currentImageTab === 'upload') {
                if (!selectedImageFile) {
                    alert('Silakan pilih file gambar dari komputer.');
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

        // Video Modal Handling
        function openVideoModal() {
            if (quill) {
                savedRange = quill.getSelection() || { index: quill.getLength() - 1, length: 0 };
            }
            const modal = document.getElementById('modal-insert-video');
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }
        }

        function closeVideoModal() {
            const modal = document.getElementById('modal-insert-video');
            if (modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
        }

        let detectedEmbedUrl = null;
        function handleVideoUrlInput(val) {
            const submitBtn = document.getElementById('btn-submit-insert-video');
            const previewWrapper = document.getElementById('video-preview-wrapper');
            const previewIframe = document.getElementById('video-preview-iframe');

            let embed = null;
            if (val.includes('youtube.com/watch?v=')) {
                const id = val.split('v=')[1]?.split('&')[0];
                if (id) embed = 'https://www.youtube.com/embed/' + id;
            } else if (val.includes('youtu.be/')) {
                const id = val.split('youtu.be/')[1]?.split('?')[0];
                if (id) embed = 'https://www.youtube.com/embed/' + id;
            }

            detectedEmbedUrl = embed;
            if (embed) {
                if (previewIframe) previewIframe.src = embed;
                if (previewWrapper) previewWrapper.classList.remove('hidden');
                if (submitBtn) submitBtn.disabled = false;
            } else {
                if (previewWrapper) previewWrapper.classList.add('hidden');
                if (submitBtn) submitBtn.disabled = true;
            }
        }

        function submitInsertVideo() {
            if (!detectedEmbedUrl || !quill) return;
            const index = savedRange ? savedRange.index : (quill.getSelection() ? quill.getSelection().index : quill.getLength() - 1);
            quill.insertEmbed(index, 'video', detectedEmbedUrl, Quill.sources.USER);
            quill.setSelection(index + 1, Quill.sources.SILENT);
            closeVideoModal();
        }

        // Initialize Quill on DOM Ready
        document.addEventListener('DOMContentLoaded', function() {
            const hiddenContent = document.getElementById('hidden-content');
            const editorEl = document.getElementById('quill-editor');
            const wrapper = document.getElementById('quill-editor-wrapper');
            const fsBtn = document.getElementById('btn-fullscreen-toggle');
            const fsText = document.getElementById('fullscreen-text');

            try {
                if (typeof Quill !== 'undefined' && editorEl) {
                    quill = new Quill('#quill-editor', {
                        modules: {
                            toolbar: {
                                container: '#quill-toolbar',
                                handlers: {
                                    'image': openImageModal,
                                    'video': openVideoModal
                                }
                            },
                            history: {
                                delay: 1000,
                                maxStack: 150,
                                userOnly: true
                            }
                        },
                        theme: 'snow',
                        placeholder: 'Tuliskan naskah lengkap profil perusahaan, sejarah, pilar, dan dokumentasi foto di sini...'
                    });

                    function updateStatsAndSync() {
                        if (hiddenContent && quill && quill.root) {
                            hiddenContent.value = quill.root.innerHTML;
                        }
                        const text = quill.getText().trim();
                        const words = text ? text.split(/\s+/).filter(Boolean).length : 0;
                        const chars = text.length;

                        const statWords = document.getElementById('stat-words');
                        const statChars = document.getElementById('stat-chars');
                        if (statWords) statWords.textContent = words.toLocaleString('id-ID') + ' Kata';
                        if (statChars) statChars.textContent = chars.toLocaleString('id-ID') + ' Karakter';
                    }

                    quill.on('text-change', updateStatsAndSync);
                    updateStatsAndSync();

                    document.getElementById('btn-undo')?.addEventListener('click', function(e) {
                        e.preventDefault();
                        quill.history.undo();
                    });
                    document.getElementById('btn-redo')?.addEventListener('click', function(e) {
                        e.preventDefault();
                        quill.history.redo();
                    });

                    document.getElementById('btn-insert-hr')?.addEventListener('click', function(e) {
                        e.preventDefault();
                        const range = quill.getSelection(true);
                        quill.clipboard.dangerouslyPasteHTML(range.index, '<hr><p><br></p>');
                        quill.setSelection(range.index + 2, Quill.sources.SILENT);
                    });

                    // Drop image into editor
                    quill.root.addEventListener('drop', function(e) {
                        const files = e.dataTransfer ? e.dataTransfer.files : null;
                        if (files && files.length > 0 && files[0].type.indexOf('image') !== -1) {
                            e.preventDefault();
                            savedRange = quill.getSelection() || { index: quill.getLength() - 1, length: 0 };
                            uploadAndInsertFile(files[0], '');
                        }
                    });

                    // Paste image from clipboard
                    quill.root.addEventListener('paste', function(e) {
                        const clipboardData = e.clipboardData || window.clipboardData;
                        if (clipboardData && clipboardData.items) {
                            for (let i = 0; i < clipboardData.items.length; i++) {
                                const item = clipboardData.items[i];
                                if (item.type.indexOf('image') !== -1) {
                                    const file = item.getAsFile();
                                    if (file) {
                                        e.preventDefault();
                                        savedRange = quill.getSelection() || { index: quill.getLength() - 1, length: 0 };
                                        uploadAndInsertFile(file, '');
                                        return;
                                    }
                                }
                            }
                        }
                    });

                    // Fullscreen toggle
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
                }
            } catch (err) {
                console.warn('Quill editor init warning:', err);
            }

            // Sync on form submit
            const form = document.getElementById('profile-form');
            if (form && hiddenContent) {
                form.addEventListener('submit', function() {
                    if (quill && quill.root) {
                        hiddenContent.value = quill.root.innerHTML;
                    }
                });
            }
        });
    </script>
</x-app-layout>
