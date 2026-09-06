{{-- ================================================================= --}}
{{-- SEKSI DAMPAK & ESG (9 PILAR SIYOTA & PUBLIKASI DOKUMEN TERBUKA)   --}}
{{-- Anchor: #impact                                                   --}}
{{-- ================================================================= --}}

@php
    $pillars = $impactPillars ?? \App\Models\EcosystemImpactPillar::active()->get();
    $documents = $impactDocuments ?? \App\Models\EcosystemDocument::active()->orderBy('sort_order')->get();
@endphp

<section 
    id="impact" 
    x-data="{
        activeCategory: 'all',
        selectedPillar: null
    }"
    class="relative w-full py-20 sm:py-28 bg-[#FAFCFC] border-t border-gray-200 overflow-hidden select-none"
>
    {{-- Subtle Background Geometric Pattern --}}
    <div class="absolute inset-0 pointer-events-none opacity-30">
        <svg class="w-full h-full" viewBox="0 0 1440 800" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
            <defs>
                <pattern id="impactGridPattern" width="48" height="48" patternUnits="userSpaceOnUse">
                    <circle cx="24" cy="24" r="1" fill="#005952" opacity="0.16" />
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#impactGridPattern)" />
        </svg>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- ======================================================== --}}
        {{-- 1. SECTION HEADER                                        --}}
        {{-- ======================================================== --}}
        <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-8 pb-12 border-b border-gray-200">
            <div class="max-w-3xl">
                <div class="flex items-center gap-2 mb-3">
                    <span class="w-2.5 h-2.5 rounded-full bg-[#005952]"></span>
                    <span class="text-xs font-bold tracking-[0.24em] text-[#005952] uppercase font-sans" x-text="$store.lang.t('DAMPAK SOSIAL & TATA KELOLA ESG', 'SOCIAL IMPACT & ESG GOVERNANCE')">
                        DAMPAK SOSIAL & TATA KELOLA ESG
                    </span>
                </div>
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black text-gray-950 tracking-tight leading-tight">
                    <span x-text="$store.lang.t('9 Pilar Aksi Nyata & Tata Kelola Berkelanjutan', '9 Pillars of Tangible Action & Sustainable Governance')">
                        9 Pilar Aksi Nyata & Tata Kelola Berkelanjutan
                    </span>
                </h2>
                <p class="mt-4 text-sm sm:text-base text-gray-600 leading-relaxed font-normal" x-text="$store.lang.t('Komitmen keberlanjutan dan filantropi terpadu kami diwujudkan melalui aksi langsung di lapangan. Seluruh program pemberdayaan, kemanusiaan, dan kepatuhan ESG didokumentasikan dan diorkestrasi secara transparan melalui payung gerakan SIYOTA.', 'Our commitment to sustainability and integrated social action is realized through frontline field execution. All community empowerment, humanitarian missions, and ESG compliance are transparently orchestrated and documented via SIYOTA.')">
                    Komitmen keberlanjutan dan filantropi terpadu kami diwujudkan melalui aksi langsung di lapangan. Seluruh program pemberdayaan, kemanusiaan, dan kepatuhan ESG didokumentasikan dan diorkestrasi secara transparan melalui payung gerakan SIYOTA.
                </p>
            </div>

            {{-- Direct Gateway Button to SIYOTA --}}
            <div class="shrink-0 flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                <a 
                    href="https://siyota.org" 
                    target="_blank" 
                    rel="noopener noreferrer" 
                    class="inline-flex items-center justify-center gap-2.5 px-6 py-3.5 rounded-2xl bg-[#005952] hover:bg-[#004741] text-white text-xs sm:text-sm font-bold shadow-md hover:shadow-lg transition-all cursor-pointer group"
                >
                    <span x-text="$store.lang.t('Kunjungi Portal SIYOTA (siyota.org)', 'Visit SIYOTA Portal (siyota.org)')">Kunjungi Portal SIYOTA (siyota.org)</span>
                    <svg class="w-4 h-4 transform group-hover:translate-x-0.5 group-hover:-translate-y-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                </a>
            </div>
        </div>

        {{-- ======================================================== --}}
        {{-- 2. 9 PILAR AKSI BERKELANJUTAN (SIYOTA.ORG)                --}}
        {{-- ======================================================== --}}
        <div class="pt-12 pb-6">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h3 class="text-xl sm:text-2xl font-black text-gray-950 tracking-tight flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-[#004741]"></span>
                        <span x-text="$store.lang.t('9 Pilar Fokus Aksi Lapangan', '9 Action Pillars in the Field')">9 Pilar Fokus Aksi Lapangan</span>
                    </h3>
                    <p class="text-xs sm:text-sm text-gray-500 mt-1" x-text="$store.lang.t('Setiap pilar memiliki mandat terarah dan terhubung langsung ke dokumentasi aksi di siyota.org.', 'Each pillar has a targeted mandate directly connected to field documentation on siyota.org.')">
                        Setiap pilar memiliki mandat terarah dan terhubung langsung ke dokumentasi aksi di siyota.org.
                    </p>
                </div>
                <span class="text-xs font-mono font-bold text-slate-800 bg-slate-100 px-3 py-1 rounded-full border border-slate-200">
                    9 PILAR LENGKAP
                </span>
            </div>

            {{-- 9 Pillars Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-7">
                @foreach($pillars as $pillar)
                    <div class="bg-white rounded-3xl border border-gray-200/90 overflow-hidden shadow-xs hover:shadow-xl hover:border-[#004741]/40 transition-all duration-300 flex flex-col justify-between group">
                        <div>
                            {{-- Pillar Photo Container with Number Badge --}}
                            <div class="relative h-48 sm:h-52 w-full overflow-hidden bg-gray-900">
                                <img 
                                    src="{{ $pillar->photo_image }}" 
                                    alt="{{ $pillar->name }}" 
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 filter brightness-95"
                                >
                                <div class="absolute inset-0 bg-gradient-to-t from-gray-950/80 via-gray-950/25 to-transparent"></div>
                                
                                {{-- Pillar Number Badge --}}
                                <div class="absolute top-3 left-3 z-10">
                                    <span class="px-2.5 py-1 rounded-lg bg-black/60 backdrop-blur-md text-[10px] font-mono font-bold text-white border border-white/20 tracking-wider">
                                        PILAR #0{{ $pillar->pillar_number }}
                                    </span>
                                </div>

                                {{-- Pillar Capitalized Code --}}
                                <div class="absolute bottom-3 left-4 right-4 z-10">
                                    <span class="text-[10px] font-mono font-extrabold uppercase tracking-[0.2em] text-slate-200 block drop-shadow-xs">
                                        {{ $pillar->name }}
                                    </span>
                                    <h4 class="text-base sm:text-lg font-black text-white leading-snug mt-0.5 drop-shadow-sm">
                                        <span x-text="$store.lang.t('{{ addslashes($pillar->title_id) }}', '{{ addslashes($pillar->title_en ?: $pillar->title_id) }}')">
                                            {{ $pillar->title_id }}
                                        </span>
                                    </h4>
                                </div>
                            </div>

                            {{-- Pillar Description Content --}}
                            <div class="p-5 sm:p-6">
                                <p class="text-xs sm:text-sm text-gray-600 leading-relaxed font-normal">
                                    <span x-text="$store.lang.t('{{ addslashes($pillar->description_id) }}', '{{ addslashes($pillar->description_en ?: $pillar->description_id) }}')">
                                        {{ $pillar->description_id }}
                                    </span>
                                </p>
                            </div>
                        </div>

                        {{-- Footer Action Link to SIYOTA --}}
                        <div class="px-5 sm:px-6 pb-5 pt-2 border-t border-gray-100 flex items-center justify-between">
                            <span class="text-[11px] font-medium text-gray-400">
                                Info di <span class="text-gray-700 font-semibold">siyota.org</span>
                            </span>
                            <a 
                                href="{{ $pillar->target_url ?: 'https://siyota.org' }}" 
                                target="_blank" 
                                rel="noopener noreferrer" 
                                class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-slate-100 hover:bg-[#004741] text-slate-800 hover:text-white border border-slate-200 text-xs font-bold transition-all shadow-2xs cursor-pointer group/btn"
                            >
                                <span x-text="$store.lang.t('Lihat Aksi di siyota.org', 'Explore on siyota.org')">Lihat Aksi di siyota.org</span>
                                <svg class="w-3.5 h-3.5 transform group-hover/btn:translate-x-0.5 group-hover/btn:-translate-y-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                </svg>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- ======================================================== --}}
        {{-- 3. DOKUMEN & LAPORAN ESG TERBUKA (WAJIB ADA COVER)       --}}
        {{-- ======================================================== --}}
        <div class="mt-16 pt-12 border-t border-gray-200">
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-8">
                <div>
                    <div class="flex items-center gap-2 mb-2">
                        <span class="w-2 h-2 rounded-full bg-[#005952]"></span>
                        <span class="text-xs font-bold tracking-[0.2em] text-[#005952] uppercase font-sans" x-text="$store.lang.t('TRANSPARANSI & PUBLIKASI AKUNTABEL', 'TRANSPARENCY & ACCOUNTABLE DISCLOSURE')">
                            TRANSPARANSI & PUBLIKASI AKUNTABEL
                        </span>
                    </div>
                    <h3 class="text-2xl sm:text-3xl font-black text-gray-950 tracking-tight">
                        <span x-text="$store.lang.t('Dokumen & Laporan Dampak ESG', 'ESG Impact Reports & Open Documents')">
                            Dokumen & Laporan Dampak ESG
                        </span>
                    </h3>
                    <p class="text-xs sm:text-sm text-gray-500 mt-1 max-w-2xl" x-text="$store.lang.t('Unduh berkas resmi laporan keberlanjutan, whitepaper riset kebijakan, dan katalog program kemitraan terverifikasi.', 'Download official sustainability disclosure reports, applied research whitepapers, and verified partnership program catalogs.')">
                        Unduh berkas resmi laporan keberlanjutan, whitepaper riset kebijakan, dan katalog program kemitraan terverifikasi.
                    </p>
                </div>

                <div class="text-xs font-medium text-gray-500 bg-white px-3.5 py-1.5 rounded-full border border-gray-200 shadow-2xs self-start sm:self-auto">
                    {{ $documents->count() }} Dokumen Terpublikasi
                </div>
            </div>

            @if($documents->isEmpty())
                <div class="bg-white rounded-3xl p-10 text-center border border-dashed border-gray-300 text-gray-400 text-xs">
                    <span x-text="$store.lang.t('Dokumen dan laporan ESG sedang dalam proses verifikasi auditor independen.', 'ESG documents and reports are currently undergoing independent audit verification.')">
                        Dokumen dan laporan ESG sedang dalam proses verifikasi auditor independen.
                    </span>
                </div>
            @else
                {{-- Documents Grid with Mandatory Cover Showcase --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
                    @foreach($documents as $doc)
                        <div class="bg-white rounded-3xl border border-gray-200/90 overflow-hidden shadow-xs hover:shadow-xl hover:border-[#005952]/40 transition-all duration-300 flex flex-col justify-between group">
                            <div>
                                {{-- Book / Report Cover Showcase (Aspect 16:9 or 3:4 Book Ratio) --}}
                                <div class="relative h-56 sm:h-60 w-full overflow-hidden bg-gray-950">
                                    <img 
                                        src="{{ $doc->cover_image }}" 
                                        alt="{{ $doc->title_id }}" 
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 filter brightness-95"
                                    >
                                    <div class="absolute inset-0 bg-gradient-to-t from-gray-950/85 via-gray-950/20 to-transparent"></div>

                                    {{-- Top Badges: Category & Year --}}
                                    <div class="absolute top-3 left-3 right-3 flex items-center justify-between z-10">
                                        <span class="px-2.5 py-1 rounded-md bg-white/95 backdrop-blur-md text-[10px] font-extrabold uppercase text-[#005952] tracking-wider shadow-xs">
                                            {{ $doc->category }}
                                        </span>
                                        @if($doc->year)
                                            <span class="px-2.5 py-1 rounded-md bg-black/60 backdrop-blur-md text-[10px] font-mono font-bold text-white border border-white/20">
                                                {{ $doc->year }}
                                            </span>
                                        @endif
                                    </div>

                                    {{-- Bottom Badge: File Type & Size on Cover --}}
                                    <div class="absolute bottom-3 left-3 right-3 flex items-center justify-between text-white z-10">
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md bg-black/60 backdrop-blur-md text-[10px] font-mono font-bold text-white border border-white/20">
                                            @if($doc->is_pdf)
                                                 <svg class="w-3 h-3 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                                     <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"/>
                                                 </svg>
                                                 <span>PDF {{ $doc->file_size ? '(' . $doc->file_size . ')' : '' }}</span>
                                            @else
                                                 <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                                 </svg>
                                                 <span>{{ $doc->file_size ?: 'Tautan Eksternal' }}</span>
                                            @endif
                                        </span>
                                    </div>
                                </div>

                                {{-- Document Details --}}
                                <div class="p-5 sm:p-6">
                                    <h4 class="text-base sm:text-lg font-extrabold text-gray-950 group-hover:text-[#004741] transition-colors leading-snug tracking-tight">
                                        <span x-text="$store.lang.t('{{ addslashes($doc->title_id) }}', '{{ addslashes($doc->title_en ?: $doc->title_id) }}')">
                                            {{ $doc->title_id }}
                                        </span>
                                    </h4>

                                    @if($doc->description_id)
                                        <p class="text-xs sm:text-sm text-gray-500 mt-2.5 leading-relaxed line-clamp-3">
                                            <span x-text="$store.lang.t('{{ addslashes($doc->description_id) }}', '{{ addslashes($doc->description_en ?: $doc->description_id) }}')">
                                                {{ $doc->description_id }}
                                            </span>
                                        </p>
                                    @endif
                                </div>
                            </div>

                            {{-- Download / Link Action Footer --}}
                            <div class="px-5 sm:px-6 pb-6 pt-2 border-t border-gray-100 flex items-center justify-between gap-3">
                                <span class="text-[11px] font-medium text-gray-400">
                                    Akses Publik Terbuka
                                </span>

                                <a 
                                    href="{{ $doc->download_url }}" 
                                    target="_blank" 
                                    rel="noopener noreferrer" 
                                    class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-[#004741] hover:bg-slate-900 text-white text-xs font-bold transition-all shadow-xs cursor-pointer group/dl"
                                >
                                    @if($doc->is_pdf)
                                        <span x-text="$store.lang.t('Unduh Dokumen (PDF)', 'Download Document (PDF)')">Unduh Dokumen (PDF)</span>
                                        <svg class="w-3.5 h-3.5 transform group-hover/dl:translate-y-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                        </svg>
                                    @else
                                        <span x-text="$store.lang.t('Buka Dokumen / Tautan', 'Open Document / Link')">Buka Dokumen / Tautan</span>
                                        <svg class="w-3.5 h-3.5 transform group-hover/dl:translate-x-0.5 group-hover/dl:-translate-y-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                        </svg>
                                    @endif
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    </div>
</section>
