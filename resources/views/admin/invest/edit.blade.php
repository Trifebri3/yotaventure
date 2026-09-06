<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <nav class="flex items-center gap-2 text-xs text-gray-500 mb-1">
                    <a href="{{ route('dashboard') }}" class="hover:text-[#005952] transition-colors">Admin</a>
                    <span>/</span>
                    <span class="text-[#005952] font-semibold">Investasi & Sinergi</span>
                </nav>
                <h2 class="font-black text-xl sm:text-2xl text-gray-900 leading-tight">
                    Kelola Konten & Naskah Investasi (Venture Builder)
                </h2>
            </div>
            <div class="flex items-center gap-3">
                <a 
                    href="{{ route('public.about.invest') }}" 
                    target="_blank" 
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white border border-gray-300 text-xs font-bold text-gray-700 hover:bg-gray-50 shadow-xs transition-all"
                >
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                    <span>Lihat di Web Publik ↗</span>
                </a>
            </div>
        </div>
    </x-slot>

    {{-- Quill Rich Text Editor CDN CSS & Pro Word Styles --}}
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
            min-height: 400px;
            font-size: 15px;
            line-height: 1.8;
            color: #1e293b;
            background: #ffffff;
        }
        #quill-editor .ql-editor {
            min-height: 400px;
            padding: 24px 28px;
        }
        #quill-editor .ql-editor h2 {
            font-size: 1.6rem;
            font-weight: 800;
            color: #091e1b;
            margin-top: 1.5rem;
            margin-bottom: 0.75rem;
        }
        #quill-editor .ql-editor h3 {
            font-size: 1.25rem;
            font-weight: 700;
            color: #005952;
            margin-top: 1.25rem;
            margin-bottom: 0.5rem;
        }
        #quill-editor .ql-editor blockquote {
            border-left: 4px solid #005952;
            padding: 12px 18px;
            background: #f0fdf4;
            color: #14532d;
            border-radius: 0 8px 8px 0;
            margin: 1rem 0;
            font-style: italic;
        }
        #quill-editor .ql-editor hr {
            border: 0;
            height: 1px;
            background: #cbd5e1;
            margin: 2rem 0;
        }
    </style>

    <div class="py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8" x-data="{ activeTab: 'manifesto' }">
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
                <a href="{{ route('public.about.invest') }}" target="_blank" class="px-3 py-1.5 rounded-lg bg-emerald-600 text-white text-xs font-bold hover:bg-emerald-700 transition-colors">
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

        {{-- Navigation Tabs --}}
        <div class="flex items-center gap-3 border-b border-gray-200 pb-2">
            <button 
                type="button" 
                @click="activeTab = 'manifesto'" 
                :class="activeTab === 'manifesto' ? 'bg-[#005952] text-white shadow-xs' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'"
                class="px-5 py-2.5 rounded-2xl text-xs font-bold transition-all flex items-center gap-2 cursor-pointer"
            >
                <span>📝 Naskah & Teks Editor Invest</span>
            </button>
            <button 
                type="button" 
                @click="activeTab = 'hero'" 
                :class="activeTab === 'hero' ? 'bg-[#005952] text-white shadow-xs' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'"
                class="px-5 py-2.5 rounded-2xl text-xs font-bold transition-all flex items-center gap-2 cursor-pointer"
            >
                <span>🏷️ Header & Tautan Investor</span>
            </button>
            <button 
                type="button" 
                @click="activeTab = 'metrics'" 
                :class="activeTab === 'metrics' ? 'bg-[#005952] text-white shadow-xs' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'"
                class="px-5 py-2.5 rounded-2xl text-xs font-bold transition-all flex items-center gap-2 cursor-pointer"
            >
                <span>📊 Angka Traksi (Our Traction)</span>
            </button>
        </div>

        <form action="{{ route('admin.invest.update') }}" method="POST" id="form-invest" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- TAB 1: TEKS EDITOR INVEST (QUILL PRO) --}}
            <div x-show="activeTab === 'manifesto'" class="space-y-6">
                <div class="bg-white rounded-3xl border border-gray-200 p-6 sm:p-8 shadow-xs space-y-5">
                    <div class="flex items-center justify-between pb-4 border-b border-gray-100">
                        <div>
                            <h3 class="text-base font-bold text-gray-900">Teks Editor Naskah & Manifesto Investasi</h3>
                            <p class="text-xs text-gray-500 mt-0.5">
                                Gunakan editor kaya ini untuk menyusun narasi, tesis permodalan, kutipan filosofis, dan penjelasan strategis bagi investor.
                            </p>
                        </div>
                        <span class="px-3 py-1 rounded-full bg-teal-50 text-[#005952] text-xs font-bold">
                            Quill Editor Pro
                        </span>
                    </div>

                    {{-- Quill Editor --}}
                    <div>
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

                            <div id="quill-editor">{!! old('invest_content_html', $profile->invest_content_html ?: \App\Models\CompanyProfile::defaultInvestContentHtml()) !!}</div>
                            <textarea name="invest_content_html" id="hidden-invest-content" class="hidden">{!! old('invest_content_html', $profile->invest_content_html ?: \App\Models\CompanyProfile::defaultInvestContentHtml()) !!}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            {{-- TAB 2: HEADER & TAUTAN INVESTOR --}}
            <div x-show="activeTab === 'hero'" class="space-y-6" style="display: none;">
                <div class="bg-white rounded-3xl border border-gray-200 p-6 sm:p-8 shadow-xs space-y-6">
                    <div class="border-b border-gray-100 pb-4">
                        <h3 class="text-base font-bold text-gray-900">Header & Kredensial Halaman Investasi</h3>
                        <p class="text-xs text-gray-500 mt-0.5">Kelola judul hero pembuka, deskripsi visi permodalan, serta tautan investor deck dan data room.</p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                                Lencana Atas (Top Badge)
                            </label>
                            <input 
                                type="text" 
                                name="invest_badge" 
                                value="{{ old('invest_badge', $profile->invest_badge ?: 'VENTURE ECOSYSTEM BUILDER') }}" 
                                placeholder="Contoh: VENTURE ECOSYSTEM BUILDER"
                                class="w-full text-xs sm:text-sm rounded-xl border-gray-300 focus:border-[#005952] focus:ring-[#005952]"
                            >
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                                Subtitle / Nama Holding
                            </label>
                            <input 
                                type="text" 
                                name="invest_subtitle" 
                                value="{{ old('invest_subtitle', $profile->invest_subtitle ?: 'YOIN Inovasi Nusantara') }}" 
                                placeholder="YOIN Inovasi Nusantara"
                                class="w-full text-xs sm:text-sm rounded-xl border-gray-300 focus:border-[#005952] focus:ring-[#005952]"
                            >
                        </div>

                        <div class="sm:col-span-2">
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                                Judul Utama (H1) <span class="text-rose-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                name="invest_title" 
                                required
                                value="{{ old('invest_title', $profile->invest_title ?: 'Building Companies From the Ground Up') }}" 
                                placeholder="Building Companies From the Ground Up"
                                class="w-full text-xs sm:text-sm rounded-xl border-gray-300 focus:border-[#005952] focus:ring-[#005952] font-bold"
                            >
                        </div>

                        <div class="sm:col-span-2">
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                                Ringkasan Visi Ekosistem (Lead Summary)
                            </label>
                            <textarea 
                                name="invest_summary" 
                                rows="3" 
                                placeholder="We are building a venture ecosystem from Indonesia — creating focused businesses around real problems in technology, agriculture, products, and community development..."
                                class="w-full text-xs sm:text-sm rounded-xl border-gray-300 focus:border-[#005952] focus:ring-[#005952] leading-relaxed"
                            >{{ old('invest_summary', $profile->invest_summary ?: 'We are building a venture ecosystem from Indonesia — creating focused businesses around real problems in technology, agriculture, products, and community development. YOIN is not built around a single product. We build people, ideas, products, and ventures — then give each one the space to find its own market, team, and direction.') }}</textarea>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                                Tautan Investor Deck (PDF / Online)
                            </label>
                            <input 
                                type="url" 
                                name="invest_deck_url" 
                                value="{{ old('invest_deck_url', $profile->invest_deck_url) }}" 
                                placeholder="https://... (tautan unduh deck PDF atau Google Drive)"
                                class="w-full text-xs sm:text-sm rounded-xl border-gray-300 focus:border-[#005952] focus:ring-[#005952]"
                            >
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                                Tautan Virtual Data Room (VDR)
                            </label>
                            <input 
                                type="url" 
                                name="invest_data_room_url" 
                                value="{{ old('invest_data_room_url', $profile->invest_data_room_url) }}" 
                                placeholder="https://... (tautan data room untuk qualified investors)"
                                class="w-full text-xs sm:text-sm rounded-xl border-gray-300 focus:border-[#005952] focus:ring-[#005952]"
                            >
                        </div>
                    </div>
                </div>
            </div>

            {{-- TAB 3: ANGKA TRAKSI (OUR TRACTION) --}}
            <div x-show="activeTab === 'metrics'" class="space-y-6" style="display: none;">
                <div class="bg-white rounded-3xl border border-gray-200 p-6 sm:p-8 shadow-xs space-y-6">
                    <div class="border-b border-gray-100 pb-4 flex items-center justify-between">
                        <div>
                            <h3 class="text-base font-bold text-gray-900">Indikator Traksi & Capaian Riil (Our Traction)</h3>
                            <p class="text-xs text-gray-500 mt-0.5">
                                Gunakan angka internal yang nyata. Metrik ini tampil di bagian pembuktian traksi investor.
                            </p>
                        </div>
                    </div>

                    @php
                        $metrics = old('invest_metrics', $profile->invest_metrics ?: \App\Models\CompanyProfile::defaultInvestMetrics());
                    @endphp

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        @foreach($metrics as $idx => $m)
                            <div class="p-4 rounded-2xl bg-gray-50 border border-gray-200 space-y-2">
                                <input type="hidden" name="invest_metrics[{{ $idx }}][key]" value="{{ $m['key'] ?? '' }}">
                                <div>
                                    <label class="block text-[11px] font-bold text-gray-600 uppercase">Label Metrik</label>
                                    <input 
                                        type="text" 
                                        name="invest_metrics[{{ $idx }}][label]" 
                                        value="{{ $m['label'] ?? '' }}" 
                                        class="w-full text-xs rounded-lg border-gray-300 focus:border-[#005952] focus:ring-[#005952] font-semibold mt-1"
                                    >
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold text-[#005952] uppercase">Nilai / Angka</label>
                                    <input 
                                        type="text" 
                                        name="invest_metrics[{{ $idx }}][value]" 
                                        value="{{ $m['value'] ?? '' }}" 
                                        class="w-full text-sm font-black text-gray-950 rounded-lg border-gray-300 focus:border-[#005952] focus:ring-[#005952] mt-1"
                                    >
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Submit Action Bar --}}
            <div class="bg-white rounded-3xl p-6 border border-gray-200 shadow-xs flex items-center justify-between">
                <span class="text-xs text-gray-500 font-medium">
                    Perubahan akan langsung tersimpan di database dan tampil di halaman publik Invest.
                </span>
                <button 
                    type="submit" 
                    class="px-7 py-3 rounded-xl bg-[#005952] hover:bg-[#004741] text-white text-xs font-bold shadow-md hover:shadow-lg transition-all cursor-pointer flex items-center gap-2"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span>Simpan Perubahan Investasi & Sinergi</span>
                </button>
            </div>
        </form>
    </div>

    {{-- Quill Script & Handlers --}}
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const editorEl = document.getElementById('quill-editor');
            const hiddenInput = document.getElementById('hidden-invest-content');

            if (typeof Quill !== 'undefined' && editorEl) {
                const quill = new Quill('#quill-editor', {
                    modules: {
                        toolbar: '#quill-toolbar'
                    },
                    theme: 'snow',
                    placeholder: 'Tuliskan naskah manifesto dan analisis investasi di sini...'
                });

                quill.on('text-change', function() {
                    if (hiddenInput && quill.root) {
                        hiddenInput.value = quill.root.innerHTML;
                    }
                });

                document.getElementById('form-invest')?.addEventListener('submit', function() {
                    if (hiddenInput && quill && quill.root) {
                        hiddenInput.value = quill.root.innerHTML;
                    }
                });

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
            }
        });
    </script>
</x-app-layout>
