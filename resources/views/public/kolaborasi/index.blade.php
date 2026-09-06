@extends('public.layouts.app')

@section('title', 'Pusat Kolaborasi & Sinergi Nusantara | YOIN Inovasi Nusantara')

@section('content')
<div 
    x-data="{
        activeTrack: window.location.hash ? window.location.hash.replace('#', '') : '{{ $selectedSlug ?? 'kemitraan' }}',
        copied: false,
        copyTemplate(text) {
            navigator.clipboard.writeText(text).then(() => {
                this.copied = true;
                setTimeout(() => this.copied = false, 2500);
            });
        },
        selectTrack(slug) {
            this.activeTrack = slug;
            window.location.hash = slug;
        }
    }"
    class="bg-[#FAFCFC] min-h-screen pt-28 sm:pt-36 pb-24 text-gray-900 font-sans select-none"
>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Breadcrumbs --}}
        <nav class="flex items-center gap-2 text-xs text-gray-500 mb-6">
            <a href="{{ url('/') }}" class="hover:text-[#005952] transition-colors" x-text="$store.lang.t('Beranda', 'Home')">Beranda</a>
            <span>/</span>
            <span class="text-gray-900 font-semibold" x-text="$store.lang.t('Pusat Kolaborasi', 'Collaboration Hub')">Pusat Kolaborasi</span>
        </nav>

        {{-- Hero Header --}}
        <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 pb-10 border-b border-gray-200">
            <div class="max-w-3xl">
                <div class="flex items-center gap-2 mb-3">
                    <span class="w-2.5 h-2.5 rounded-full bg-[#005952]"></span>
                    <span class="text-xs font-bold tracking-[0.25em] text-[#005952] uppercase" x-text="$store.lang.t('PUSAT KOLABORASI & SINERGI NUSANTARA', 'NUSANTARA COLLABORATION & SYNERGY HUB')">
                        PUSAT KOLABORASI & SINERGI NUSANTARA
                    </span>
                </div>
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-gray-950 tracking-tight leading-tight" x-text="$store.lang.t('Membangun Ekosistem Berkelanjutan Bersama.', 'Building a Sustainable Ecosystem Together.')">
                    Membangun Ekosistem Berkelanjutan Bersama.
                </h1>
                <p class="mt-3 text-sm sm:text-base text-gray-600 leading-relaxed max-w-2xl font-normal" x-text="$store.lang.t('YOIN membuka ruang sinergi multipihak bagi korporasi, akademisi, mahasiswa, peneliti, dan komunitas untuk mengakselerasi kedaulatan teknologi dan dampak kemanusiaan.', 'YOIN opens multi-stakeholder collaboration for corporations, academia, students, researchers, and communities to accelerate technological sovereignty and human impact.')">
                    YOIN membuka ruang sinergi multipihak bagi korporasi, akademisi, mahasiswa, peneliti, dan komunitas untuk mengakselerasi kedaulatan teknologi dan dampak kemanusiaan.
                </p>
            </div>

            {{-- Quick Submission Badge --}}
            <div class="flex flex-wrap items-center gap-3 shrink-0">
                <div class="px-5 py-3 rounded-2xl bg-white border border-gray-200 shadow-xs flex items-center gap-3.5">
                    <div class="w-9 h-9 rounded-xl bg-slate-100 text-slate-800 border border-slate-200 flex items-center justify-center font-bold text-xs">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <span class="text-[10px] text-gray-400 font-bold uppercase tracking-wider block" x-text="$store.lang.t('Pintu Pengajuan Resmi', 'Official Submission Channel')">Pintu Pengajuan Resmi</span>
                        <span class="text-sm font-extrabold text-[#005952]">hello@yotainovasi.id</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Interactive 6-Track Navigation Tabs --}}
        <div class="mt-8">
            <div class="flex items-center gap-2 overflow-x-auto pb-2 scrollbar-none select-none">
                @foreach($collaborations as $track)
                    <button 
                        type="button"
                        @click="selectTrack('{{ $track->slug }}')"
                        class="px-4 sm:px-5 py-2.5 rounded-full text-xs font-bold tracking-wider transition-all whitespace-nowrap cursor-pointer flex items-center gap-2"
                        :class="activeTrack === '{{ $track->slug }}' 
                            ? 'bg-[#004741] text-white shadow-md' 
                            : 'bg-white text-gray-700 border border-gray-200 hover:border-gray-400 hover:bg-gray-50'"
                    >
                        <span class="w-1.5 h-1.5 rounded-full" :class="activeTrack === '{{ $track->slug }}' ? 'bg-white' : 'bg-gray-400'"></span>
                        <span x-text="$store.lang.isEN() ? '{{ $track->title_en }}' : '{{ $track->title_id }}'">
                            {{ $track->title_id }}
                        </span>
                    </button>
                @endforeach
            </div>
        </div>

        {{-- Track Content Panels --}}
        <div class="mt-8">
            @foreach($collaborations as $track)
                <div 
                    x-show="activeTrack === '{{ $track->slug }}'" 
                    x-cloak
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    class="space-y-8"
                >
                    {{-- Track Header Banner --}}
                    <div class="bg-white rounded-3xl p-6 sm:p-10 border border-gray-200 shadow-xs">
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-gray-100 pb-6 mb-6">
                            <div>
                                <span class="px-3 py-1 rounded-md bg-slate-900 text-white font-mono text-[10px] font-bold tracking-wider uppercase inline-block mb-2" x-text="$store.lang.isEN() ? '{{ $track->badge_en ?: $track->badge_id }}' : '{{ $track->badge_id }}'">
                                    {{ $track->badge_id }}
                                </span>
                                <h2 class="text-2xl sm:text-3xl font-black text-gray-950 tracking-tight" x-text="$store.lang.isEN() ? '{{ $track->title_en }}' : '{{ $track->title_id }}'">
                                    {{ $track->title_id }}
                                </h2>
                                <p class="mt-1 text-sm text-gray-500 font-medium" x-text="$store.lang.isEN() ? '{{ $track->subtitle_en ?: $track->subtitle_id }}' : '{{ $track->subtitle_id }}'">
                                    {{ $track->subtitle_id }}
                                </p>
                            </div>
                            
                            <a 
                                href="mailto:{{ $track->email_to }}?subject={{ rawurlencode($track->email_subject) }}&body={{ rawurlencode($track->email_template) }}"
                                class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-[#005952] hover:bg-[#004741] text-white text-xs font-bold tracking-widest uppercase transition-all shadow-sm rounded-xl shrink-0"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                <span x-text="$store.lang.t('Ajukan via Email', 'Apply via Email')">Ajukan via Email</span>
                            </a>
                        </div>

                        <p class="text-sm sm:text-base text-gray-700 leading-relaxed max-w-4xl" x-text="$store.lang.isEN() ? '{{ $track->description_en ?: $track->description_id }}' : '{{ $track->description_id }}'">
                            {{ $track->description_id }}
                        </p>
                    </div>

                    {{-- 2 Columns: Syarat & Ketentuan + Apa Saja yang Perlu Disiapkan --}}
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        
                        {{-- 1. Syarat & Ketentuan --}}
                        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-gray-200 shadow-xs flex flex-col justify-between">
                            <div>
                                <div class="flex items-center gap-3 mb-5">
                                    <div class="w-8 h-8 rounded-xl bg-slate-100 text-slate-900 border border-slate-200 flex items-center justify-center font-bold">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    </div>
                                    <div>
                                        <h3 class="text-base sm:text-lg font-bold text-gray-950" x-text="$store.lang.t('Syarat & Ketentuan', 'Terms & Conditions')">
                                            Syarat & Ketentuan
                                        </h3>
                                        <p class="text-xs text-gray-400" x-text="$store.lang.t('Kriteria kelayakan mitra dan pemohon', 'Applicant eligibility criteria')">
                                            Kriteria kelayakan mitra dan pemohon
                                        </p>
                                    </div>
                                </div>

                                <ul class="space-y-3.5">
                                    @php
                                        $termsId = is_array($track->terms_id) ? $track->terms_id : [];
                                        $termsEn = is_array($track->terms_en) ? $track->terms_en : $termsId;
                                    @endphp
                                    @foreach($termsId as $idx => $termItem)
                                        <li class="flex items-start gap-3 text-xs sm:text-sm text-gray-700">
                                            <span class="w-5 h-5 rounded-full bg-slate-100 text-[#004741] font-bold text-[11px] flex items-center justify-center shrink-0 mt-0.5">✓</span>
                                            <span x-text="$store.lang.isEN() ? '{{ $termsEn[$idx] ?? $termItem }}' : '{{ $termItem }}'">
                                                {{ $termItem }}
                                            </span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                            <div class="mt-6 pt-4 border-t border-gray-100 flex items-center gap-2 text-xs text-gray-400">
                                <span class="font-semibold text-gray-500" x-text="$store.lang.t('Status:', 'Status:')">Status:</span>
                                <span class="text-emerald-700 font-bold" x-text="$store.lang.t('Terbuka Sepanjang Tahun', 'Open All Year')">Terbuka Sepanjang Tahun</span>
                            </div>
                        </div>

                        {{-- 2. Apa Saja yang Perlu Disiapkan --}}
                        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-gray-200 shadow-xs flex flex-col justify-between">
                            <div>
                                <div class="flex items-center gap-3 mb-5">
                                    <div class="w-8 h-8 rounded-xl bg-slate-100 text-slate-900 border border-slate-200 flex items-center justify-center font-bold">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                                    </div>
                                    <div>
                                        <h3 class="text-base sm:text-lg font-bold text-gray-950" x-text="$store.lang.t('Apa Saja yang Perlu Disiapkan', 'What to Prepare')">
                                            Apa Saja yang Perlu Disiapkan
                                        </h3>
                                        <p class="text-xs text-gray-400" x-text="$store.lang.t('Kelengkapan dokumen dan berkas pendukung', 'Required documents and portfolio checklist')">
                                            Kelengkapan dokumen dan berkas pendukung
                                        </p>
                                    </div>
                                </div>

                                <ul class="space-y-3.5">
                                    @php
                                        $reqsId = is_array($track->requirements_id) ? $track->requirements_id : [];
                                        $reqsEn = is_array($track->requirements_en) ? $track->requirements_en : $reqsId;
                                    @endphp
                                    @foreach($reqsId as $idx => $reqItem)
                                        <li class="flex items-start gap-3 text-xs sm:text-sm text-gray-700">
                                            <span class="w-5 h-5 rounded-md bg-gray-100 text-gray-700 font-mono font-bold text-[10px] flex items-center justify-center shrink-0 mt-0.5">{{ $loop->iteration }}</span>
                                            <span x-text="$store.lang.isEN() ? '{{ $reqsEn[$idx] ?? $reqItem }}' : '{{ $reqItem }}'">
                                                {{ $reqItem }}
                                            </span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                            <div class="mt-6 pt-4 border-t border-gray-100 flex items-center gap-2 text-xs text-gray-400">
                                <span class="font-semibold text-gray-500" x-text="$store.lang.t('Format Berkas:', 'File Format:')">Format Berkas:</span>
                                <span>PDF (Maks. 15MB) / Tautan Cloud</span>
                            </div>
                        </div>

                    </div>

                    {{-- 3. Alur Pengajuan (Flow Steps) --}}
                    <div class="bg-white rounded-3xl p-6 sm:p-10 border border-gray-200 shadow-xs">
                        <div class="mb-8">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="w-2 h-2 rounded-full bg-[#005952]"></span>
                                <span class="text-xs font-bold tracking-widest text-[#005952] uppercase" x-text="$store.lang.t('TAHAPAN PROSEDUR', 'PROCEDURE FLOW')">
                                    TAHAPAN PROSEDUR
                                </span>
                            </div>
                            <h3 class="text-xl sm:text-2xl font-black text-gray-950 tracking-tight" x-text="$store.lang.t('Alur Pengajuan Kolaborasi', 'Collaboration Application Process')">
                                Alur Pengajuan Kolaborasi
                            </h3>
                            <p class="text-xs sm:text-sm text-gray-500 mt-1" x-text="$store.lang.t('Semua pengajuan diproses melalui pintu email resmi untuk transparansi dan audit tata kelola.', 'All proposals are handled through our official email channel for transparency and governance.')">
                                Semua pengajuan diproses melalui pintu email resmi untuk transparansi dan audit tata kelola.
                            </p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-5 gap-4 relative">
                            @php
                                $stepsId = is_array($track->steps_id) ? $track->steps_id : [];
                                $stepsEn = is_array($track->steps_en) ? $track->steps_en : $stepsId;
                            @endphp
                            @foreach($stepsId as $idx => $step)
                                <div class="relative bg-gray-50 rounded-2xl p-5 border border-gray-200/80 flex flex-col justify-between">
                                    <div>
                                        <span class="text-2xl font-black text-[#005952] tracking-wider block mb-2 font-mono">
                                            {{ $step['step'] ?? sprintf('%02d', $loop->iteration) }}
                                        </span>
                                        <h4 class="text-xs sm:text-sm font-bold text-gray-900 mb-1.5 leading-snug" x-text="$store.lang.isEN() ? '{{ $stepsEn[$idx]['title'] ?? $step['title'] }}' : '{{ $step['title'] }}'">
                                            {{ $step['title'] }}
                                        </h4>
                                        <p class="text-[11px] text-gray-500 leading-relaxed" x-text="$store.lang.isEN() ? '{{ $stepsEn[$idx]['desc'] ?? $step['desc'] }}' : '{{ $step['desc'] }}'">
                                            {{ $step['desc'] }}
                                        </p>
                                    </div>
                                    <div class="mt-4 pt-3 border-t border-gray-200/60 text-[10px] text-gray-400 uppercase font-mono font-semibold">
                                        Tahap {{ $loop->iteration }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- 4. Kotak Aksi Pengajuan via Email (Email Submission Hub) --}}
                    <div class="bg-slate-950 rounded-3xl p-6 sm:p-10 text-white border border-slate-800 shadow-xl relative overflow-hidden">
                        <div class="relative z-10 max-w-3xl">
                            <span class="px-3 py-1 rounded-md bg-white/10 text-white border border-white/20 text-[10px] font-mono font-bold tracking-widest uppercase inline-block mb-3">
                                PENGIRIMAN VIA EMAIL RESMI
                            </span>
                            <h3 class="text-2xl sm:text-3xl font-black tracking-tight" x-text="$store.lang.t('Kirimkan Berkas & Proposal Anda', 'Submit Your Application & Proposal')">
                                Kirimkan Berkas & Proposal Anda
                            </h3>
                            <p class="mt-2 text-xs sm:text-sm text-slate-300 leading-relaxed">
                                Pengajuan dikirimkan langsung ke alamat email resmi <span class="font-bold text-white underline">{{ $track->email_to }}</span>. Gunakan format template dan subjek yang telah kami sediakan untuk mempercepat proses penelaahan oleh tim YOIN.
                            </p>

                            {{-- Target Email & Subject Pill --}}
                            <div class="mt-6 bg-black/50 backdrop-blur-md rounded-2xl p-4 sm:p-5 border border-white/15 space-y-3">
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 text-xs">
                                    <span class="text-slate-400 font-mono uppercase tracking-wider">Tujuan Email:</span>
                                    <span class="font-mono font-bold text-white select-all">{{ $track->email_to }}</span>
                                </div>
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 text-xs border-t border-white/10 pt-3">
                                    <span class="text-slate-400 font-mono uppercase tracking-wider">Format Subjek:</span>
                                    <span class="font-mono font-bold text-white select-all">{{ $track->email_subject }}</span>
                                </div>
                            </div>

                            {{-- Action Buttons --}}
                            <div class="mt-8 flex flex-wrap items-center gap-4">
                                {{-- Direct Mailto Link --}}
                                <a 
                                    href="mailto:{{ $track->email_to }}?subject={{ rawurlencode($track->email_subject) }}&body={{ rawurlencode($track->email_template) }}"
                                    class="px-6 py-3.5 bg-white text-gray-950 hover:bg-slate-200 font-bold text-xs tracking-widest uppercase rounded-xl transition-all shadow-md inline-flex items-center gap-2"
                                >
                                    <svg class="w-4 h-4 text-[#004741]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                    <span x-text="$store.lang.t('Buka Aplikasi Email', 'Open Email Client')">Buka Aplikasi Email</span>
                                </a>

                                {{-- Copy Template Button --}}
                                <button 
                                    type="button"
                                    @click="copyTemplate(`Subjek: {{ addslashes($track->email_subject) }}\n\n{{ addslashes($track->email_template) }}`)"
                                    class="px-5 py-3.5 bg-[#004741] hover:bg-black text-white border border-white/20 font-bold text-xs tracking-widest uppercase rounded-xl transition-all inline-flex items-center gap-2 cursor-pointer"
                                >
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                    <span x-show="!copied" x-text="$store.lang.t('Salin Format Draft Email', 'Copy Email Template')">Salin Format Draft Email</span>
                                    <span x-show="copied" x-cloak class="text-white font-bold">Format Berhasil Disalin!</span>
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            @endforeach
        </div>

    </div>
</div>
@endsection
