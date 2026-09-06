@extends('public.layouts.app')

@section('title', $profile->meta_title ?: 'Profil Perusahaan & Ekosistem - PT Yota Inovasi Nusantara')

@section('content')
<div class="bg-white text-gray-900 font-sans pt-28 sm:pt-36 pb-20 select-none min-h-screen">

    {{-- Breadcrumb & Sub-nav Tabs --}}
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 mb-6">
        <nav class="flex items-center gap-2 text-xs text-gray-500 mb-6">
            <a href="{{ url('/') }}" class="hover:text-[#005952] transition-colors" x-text="$store.lang.t('Beranda', 'Home')">Beranda</a>
            <span>/</span>
            <span class="text-gray-800 font-semibold" x-text="$store.lang.t('Tentang Kami', 'About Us')">Tentang Kami</span>
            <span>/</span>
            <span class="text-[#004741] font-semibold" x-text="$store.lang.t('Profil', 'Profile')">Profil</span>
        </nav>

        {{-- Sub-Navigation Pills (Profil, Invest, Story) --}}
        <div class="flex items-center gap-2 border-b border-gray-200 pb-3">
            <a 
                href="{{ route('public.about.profile') }}" 
                class="px-4 py-2 rounded-full text-xs font-bold transition-all bg-[#004741] text-white shadow-xs flex items-center gap-2"
            >
                <span class="w-1.5 h-1.5 rounded-full bg-white"></span>
                <span x-text="$store.lang.t('Profil Perusahaan', 'Company Profile')">Profil Perusahaan</span>
            </a>
            <a 
                href="{{ route('public.about.invest') }}" 
                class="px-4 py-2 rounded-full text-xs font-bold transition-all bg-gray-100 text-gray-600 hover:bg-gray-200 flex items-center gap-2"
            >
                <span x-text="$store.lang.t('Investasi & Sinergi', 'Investment & Capital')">Investasi & Sinergi</span>
            </a>
            <a 
                href="{{ route('public.about.achievements') }}" 
                class="px-4 py-2 rounded-full text-xs font-bold transition-all bg-gray-100 text-gray-600 hover:bg-gray-200 flex items-center gap-2"
            >
                <span x-text="$store.lang.t('Pencapaian & Sertifikasi', 'Achievements & Accreditations')">Pencapaian & Sertifikasi</span>
            </a>
        </div>
    </div>

    {{-- Hero Editorial Header --}}
    <header class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 text-left my-8 sm:my-12">
        @if($profile->hero_badge)
            <span class="text-xs font-bold tracking-[0.2em] text-[#004741] uppercase block mb-3">
                {{ $profile->hero_badge }}
            </span>
        @endif
        <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black text-gray-950 tracking-tight leading-[1.15]">
            {{ $profile->tagline ?: $profile->company_name }}
        </h1>
        @if($profile->summary)
            <p class="mt-4 sm:mt-6 text-base sm:text-lg text-gray-600 max-w-3xl leading-relaxed">
                {{ $profile->summary }}
            </p>
        @endif
    </header>

    {{-- Hero Cover Image (Optional) --}}
    @if($profile->hero_image)
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 my-8">
            <div class="rounded-3xl overflow-hidden shadow-lg border border-gray-200/80 max-h-[480px]">
                <img 
                    src="{{ $profile->hero_image }}" 
                    alt="{{ $profile->company_name }}" 
                    class="w-full h-full object-cover max-h-[480px] hover:scale-105 transition-transform duration-700"
                >
            </div>
        </div>
    @endif

    {{-- Corporate Highlights Banner (Dynamic from Database) --}}
    @php
        $highlights = $profile->highlights ?: \App\Models\CompanyProfile::defaultHighlights();
    @endphp
    @if(!empty($highlights) && count($highlights) > 0)
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 my-10">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($highlights as $hl)
                    @if(!empty($hl['title']))
                        <div class="p-6 rounded-3xl bg-[#F8FAFA] border border-gray-200/90 hover:border-slate-400 transition-all shadow-2xs hover:shadow-md">
                            <div class="w-10 h-10 rounded-xl bg-slate-900 text-white flex items-center justify-center font-black font-mono text-sm mb-4">
                                {{ $hl['number'] ?? sprintf('%02d', $loop->iteration) }}
                            </div>
                            <h4 class="text-base font-bold text-gray-900 mb-2">
                                {{ $hl['title'] }}
                            </h4>
                            <p class="text-xs sm:text-sm text-gray-600 leading-relaxed">
                                {{ $hl['description'] ?? '' }}
                            </p>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    @endif

    {{-- Naskah Lengkap Profil (Editor Teks Kaya & Gambar WYSIWYG) --}}
    @if(!empty($profile->content_html))
        <section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 my-14">
            <div class="border-t border-b border-gray-100 py-10 sm:py-14">
                <div class="company-profile-content">
                    {!! $profile->content_html !!}
                </div>
            </div>
        </section>

        <style>
            /* Rich Text Prose Styling for Company Profile */
            .company-profile-content {
                color: #1e293b;
                font-size: 1.0625rem;
                line-height: 1.85;
            }
            .company-profile-content h1,
            .company-profile-content h2 {
                color: #091e1b;
                font-weight: 800;
                font-size: 1.875rem;
                letter-spacing: -0.02em;
                margin-top: 2.5rem;
                margin-bottom: 1rem;
                line-height: 1.25;
            }
            .company-profile-content h3 {
                color: #005952;
                font-weight: 700;
                font-size: 1.4rem;
                margin-top: 2rem;
                margin-bottom: 0.75rem;
                line-height: 1.3;
            }
            .company-profile-content h4 {
                color: #334155;
                font-weight: 700;
                font-size: 1.15rem;
                margin-top: 1.5rem;
                margin-bottom: 0.5rem;
            }
            .company-profile-content p {
                margin-bottom: 1.5rem;
                color: #334155;
            }
            .company-profile-content blockquote {
                border-left: 4px solid #005952;
                background: #f0fdf4;
                color: #14532d;
                padding: 1.25rem 1.75rem;
                margin: 2rem 0;
                border-radius: 0 1rem 1rem 0;
                font-size: 1.125rem;
                font-style: italic;
                line-height: 1.7;
            }
            .company-profile-content ul {
                list-style-type: disc;
                padding-left: 1.75rem;
                margin-bottom: 1.5rem;
                space-y: 0.5rem;
            }
            .company-profile-content ol {
                list-style-type: decimal;
                padding-left: 1.75rem;
                margin-bottom: 1.5rem;
            }
            .company-profile-content li {
                margin-bottom: 0.5rem;
                color: #334155;
            }
            .company-profile-content strong {
                color: #0f172a;
                font-weight: 700;
            }
            .company-profile-content a {
                color: #005952;
                font-weight: 600;
                text-decoration: underline;
                text-underline-offset: 3px;
                transition: color 0.2s;
            }
            .company-profile-content a:hover {
                color: #004741;
            }
            .company-profile-content img {
                border-radius: 1.25rem;
                box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.08), 0 8px 10px -6px rgba(0, 0, 0, 0.04);
                margin: 2.5rem auto;
                max-width: 100%;
                height: auto;
                display: block;
                border: 1px solid #e2e8f0;
            }
            .company-profile-content iframe {
                border-radius: 1rem;
                margin: 2rem auto;
                max-width: 100%;
                display: block;
            }
            .company-profile-content hr {
                border: 0;
                height: 1px;
                background: linear-gradient(90deg, transparent, #cbd5e1, transparent);
                margin: 3rem 0;
            }
            .company-profile-content em {
                color: #64748b;
            }
        </style>
    @endif

    {{-- Legal Identity & Office Information Strip --}}
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 my-14">
        <div class="p-8 sm:p-10 rounded-3xl bg-[#004741] text-white shadow-xl">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                <div>
                    <span class="text-xs font-mono font-bold tracking-widest text-slate-200 uppercase" x-text="$store.lang.t('ENTITAS BERBADAN HUKUM', 'LEGAL ENTITY')">
                        ENTITAS BERBADAN HUKUM
                    </span>
                    <h3 class="text-2xl sm:text-3xl font-black mt-2 tracking-tight">
                        {{ $profile->legal_entity_name ?: $profile->company_name }}
                    </h3>
                    @if($profile->legal_registration_info)
                        <p class="text-xs sm:text-sm text-slate-100/90 mt-3 leading-relaxed">
                            {{ $profile->legal_registration_info }}
                        </p>
                    @endif
                </div>
                <div class="space-y-3 text-xs sm:text-sm text-slate-100 border-t md:border-t-0 md:border-l md:border-white/20 pt-6 md:pt-0 md:pl-8">
                    @if($profile->office_address)
                        <div>
                            <span class="font-bold text-white block text-[11px] uppercase tracking-wider mb-1" x-text="$store.lang.t('Alamat Kantor Resmi:', 'Official Office Address:')">
                                Alamat Kantor Resmi:
                            </span>
                            <p class="text-slate-100 leading-relaxed">{{ $profile->office_address }}</p>
                        </div>
                    @endif
                    <div>
                        <span class="font-bold text-white block text-[11px] uppercase tracking-wider mb-1" x-text="$store.lang.t('Kontak Resmi:', 'Official Contact:')">
                            Kontak Resmi:
                        </span>
                        <p class="text-slate-100">
                            @if($profile->contact_email)
                                <span>Email: <a href="mailto:{{ $profile->contact_email }}" class="underline hover:text-white">{{ $profile->contact_email }}</a></span>
                            @endif
                            @if($profile->contact_phone)
                                <span class="mx-2">•</span>
                                <span>Telepon: {{ $profile->contact_phone }}</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- People Behind It Anchor Link --}}
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 text-center my-12">
        <h3 class="text-xl sm:text-2xl font-black text-gray-900 mb-3" x-text="$store.lang.t('Orang-Orang di Balik Ekosistem', 'The People Behind the Ecosystem')">
            Orang-Orang di Balik Ekosistem
        </h3>
        <p class="text-xs sm:text-sm text-gray-600 max-w-xl mx-auto mb-6" x-text="$store.lang.t('Pelajari profil pendiri, tim penggerak teknologi, kontributor riset, serta mitra kolaborasi strategis kami.', 'Discover our leadership, technology core team, research contributors, and strategic partners.')">
            Pelajari profil pendiri, tim penggerak teknologi, kontributor riset, serta mitra kolaborasi strategis kami.
        </p>
        <a 
            href="{{ url('/#people') }}" 
            class="inline-flex items-center gap-2 px-6 py-3 rounded-full bg-[#004741] hover:bg-slate-900 text-white text-xs font-bold tracking-wider uppercase transition-all shadow-md"
        >
            <span x-text="$store.lang.t('Lihat Tim & Kontributor', 'View Team & Contributors')">Lihat Tim & Kontributor</span>
            <span>→</span>
        </a>
    </div>

</div>
@endsection
