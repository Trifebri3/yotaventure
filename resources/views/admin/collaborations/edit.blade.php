<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <a href="{{ route('admin.collaborations.index') }}" class="text-xs text-gray-500 hover:text-[#005952] font-semibold flex items-center gap-1 mb-1">
                    ← Kembali ke Daftar Kolaborasi
                </a>
                <h2 class="font-black text-2xl text-gray-900 leading-tight">
                    Edit Program Kolaborasi: {{ $collaboration->title_id }}
                </h2>
            </div>
            <a 
                href="{{ route('public.collaboration.index', ['track' => $collaboration->slug]) }}" 
                target="_blank"
                class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 text-xs font-bold rounded-xl transition-all"
            >
                Lihat di Publik ↗
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <form action="{{ route('admin.collaborations.update', $collaboration) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                {{-- Basic Details --}}
                <div class="bg-white rounded-3xl p-6 sm:p-8 border border-gray-200 shadow-sm space-y-4">
                    <h3 class="text-base font-extrabold text-gray-900 border-b border-gray-100 pb-3">Informasi Utama Program</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Judul Program (ID)</label>
                            <input type="text" name="title_id" value="{{ old('title_id', $collaboration->title_id) }}" class="w-full text-xs rounded-xl border-gray-300 focus:border-[#005952] focus:ring-[#005952]" required>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Judul Program (EN)</label>
                            <input type="text" name="title_en" value="{{ old('title_en', $collaboration->title_en) }}" class="w-full text-xs rounded-xl border-gray-300 focus:border-[#005952] focus:ring-[#005952]" required>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Label Badge Kategori (ID)</label>
                            <input type="text" name="badge_id" value="{{ old('badge_id', $collaboration->badge_id) }}" class="w-full text-xs rounded-xl border-gray-300 focus:border-[#005952] focus:ring-[#005952]">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Label Badge Kategori (EN)</label>
                            <input type="text" name="badge_en" value="{{ old('badge_en', $collaboration->badge_en) }}" class="w-full text-xs rounded-xl border-gray-300 focus:border-[#005952] focus:ring-[#005952]">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Keterangan Subtitle (ID)</label>
                            <textarea name="subtitle_id" rows="2" class="w-full text-xs rounded-xl border-gray-300 focus:border-[#005952] focus:ring-[#005952]">{{ old('subtitle_id', $collaboration->subtitle_id) }}</textarea>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Keterangan Subtitle (EN)</label>
                            <textarea name="subtitle_en" rows="2" class="w-full text-xs rounded-xl border-gray-300 focus:border-[#005952] focus:ring-[#005952]">{{ old('subtitle_en', $collaboration->subtitle_en) }}</textarea>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Deskripsi Lengkap (ID)</label>
                        <textarea name="description_id" rows="3" class="w-full text-xs rounded-xl border-gray-300 focus:border-[#005952] focus:ring-[#005952]">{{ old('description_id', $collaboration->description_id) }}</textarea>
                    </div>
                </div>

                {{-- Syarat & Ketentuan (Terms) --}}
                <div class="bg-white rounded-3xl p-6 sm:p-8 border border-gray-200 shadow-sm space-y-4">
                    <div>
                        <h3 class="text-base font-extrabold text-gray-900">Syarat & Ketentuan (1 Poin Per Baris)</h3>
                        <p class="text-xs text-gray-400 mt-0.5">Tuliskan tiap poin kriteria kelayakan di baris baru.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Poin Syarat (ID)</label>
                            <textarea name="terms_id_raw" rows="6" class="w-full text-xs rounded-xl border-gray-300 focus:border-[#005952] focus:ring-[#005952] font-mono leading-relaxed">{{ old('terms_id_raw', implode("\n", $collaboration->terms_id ?? [])) }}</textarea>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Poin Syarat (EN)</label>
                            <textarea name="terms_en_raw" rows="6" class="w-full text-xs rounded-xl border-gray-300 focus:border-[#005952] focus:ring-[#005952] font-mono leading-relaxed">{{ old('terms_en_raw', implode("\n", $collaboration->terms_en ?? [])) }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- Apa Saja yang Perlu Disiapkan (Requirements / Documents) --}}
                <div class="bg-white rounded-3xl p-6 sm:p-8 border border-gray-200 shadow-sm space-y-4">
                    <div>
                        <h3 class="text-base font-extrabold text-gray-900">Apa Saja yang Perlu Disiapkan (1 Berkas Per Baris)</h3>
                        <p class="text-xs text-gray-400 mt-0.5">Tuliskan checklist dokumen, portofolio, surat pengantar, dll di baris baru.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Daftar Berkas Disiapkan (ID)</label>
                            <textarea name="requirements_id_raw" rows="6" class="w-full text-xs rounded-xl border-gray-300 focus:border-[#005952] focus:ring-[#005952] font-mono leading-relaxed">{{ old('requirements_id_raw', implode("\n", $collaboration->requirements_id ?? [])) }}</textarea>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Daftar Berkas Disiapkan (EN)</label>
                            <textarea name="requirements_en_raw" rows="6" class="w-full text-xs rounded-xl border-gray-300 focus:border-[#005952] focus:ring-[#005952] font-mono leading-relaxed">{{ old('requirements_en_raw', implode("\n", $collaboration->requirements_en ?? [])) }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- Email Workflow & Template --}}
                <div class="bg-white rounded-3xl p-6 sm:p-8 border border-gray-200 shadow-sm space-y-4">
                    <h3 class="text-base font-extrabold text-gray-900 border-b border-gray-100 pb-3">Konfigurasi Pengajuan Email</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Tujuan Email Penerima</label>
                            <input type="email" name="email_to" value="{{ old('email_to', $collaboration->email_to) }}" class="w-full text-xs rounded-xl border-gray-300 focus:border-[#005952] focus:ring-[#005952]" required>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Template Subjek Email</label>
                            <input type="text" name="email_subject" value="{{ old('email_subject', $collaboration->email_subject) }}" class="w-full text-xs rounded-xl border-gray-300 focus:border-[#005952] focus:ring-[#005952]">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Template Draft Isi Email (Body Text)</label>
                        <textarea name="email_template" rows="8" class="w-full text-xs rounded-xl border-gray-300 focus:border-[#005952] focus:ring-[#005952] font-mono leading-relaxed">{{ old('email_template', $collaboration->email_template) }}</textarea>
                    </div>
                </div>

                {{-- Action Submit --}}
                <div class="flex items-center justify-between pt-4">
                    <a href="{{ route('admin.collaborations.index') }}" class="text-xs text-gray-500 hover:text-gray-900 font-bold">
                        Batal
                    </a>
                    <button type="submit" class="px-8 py-3 bg-[#005952] hover:bg-[#004741] text-white text-xs font-bold tracking-widest uppercase rounded-xl transition-all shadow-md">
                        Simpan Perubahan Program
                    </button>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>
