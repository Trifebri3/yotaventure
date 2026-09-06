@extends('public.layouts.app')

@section('title', 'Mitra Kolaborator & Ekosistem Sinergi - PT Yota Inovasi Nusantara (YOIN)')

@section('content')
<div class="bg-white text-gray-900 font-sans pt-28 sm:pt-36 pb-24 select-none min-h-screen">

    {{-- Breadcrumb --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-6">
        <nav class="flex items-center gap-2 text-xs text-gray-500">
            <a href="{{ url('/') }}" class="hover:text-[#005952] transition-colors" x-text="$store.lang.t('Beranda', 'Home')">Beranda</a>
            <span>/</span>
            <a href="{{ route('public.people.index') }}" class="hover:text-[#005952] transition-colors" x-text="$store.lang.t('Insan & Tim', 'People & Team')">Insan & Tim</a>
            <span>/</span>
            <span class="text-[#005952] font-semibold" x-text="$store.lang.t('Mitra Kolaborator', 'Collaborators')">Mitra Kolaborator</span>
        </nav>
    </div>

    {{-- Sub-Navigation Pills --}}
    @include('public.people._nav')

    {{-- Header --}}
    <header class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-12 sm:mb-16">
        <div class="max-w-4xl">
            <span class="text-xs font-bold tracking-[0.25em] text-[#005952] uppercase block mb-3" x-text="$store.lang.t('SINERGI MULTI-PIHAK & JARINGAN RESMI', 'STRATEGIC SYNERGY & OFFICIAL ALLIANCES')">
                SINERGI MULTI-PIHAK & JARINGAN RESMI
            </span>
            <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black text-gray-950 tracking-tight leading-[1.12]">
                <span x-text="$store.lang.t('Mitra, Klien & Institusi Kolaborator', 'Partners, Clients & Collaborating Institutions')">
                    Mitra, Klien & Institusi Kolaborator
                </span>
            </h1>
            <p class="mt-4 sm:mt-6 text-base sm:text-xl text-gray-600 font-light leading-relaxed">
                <span x-text="$store.lang.t('Kemitraan strategis lintas sektor: kementerian, badan riset, korporasi swasta, hingga koperasi masyarakat yang bersama-sama mengakselerasi dampak nyata.', 'Strategic cross-sector alliances: government bodies, research institutes, enterprise partners, and community cooperatives accelerating scalable impact.')">
                    Kemitraan strategis lintas sektor: kementerian, badan riset, korporasi swasta, hingga koperasi masyarakat yang bersama-sama mengakselerasi dampak nyata.
                </span>
            </p>
        </div>
    </header>

    {{-- Category Filters --}}
    @if($categories->count() > 0)
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-12">
            <div class="bg-gray-50 rounded-2xl border border-gray-200/80 p-3 sm:p-4 flex items-center gap-2 overflow-x-auto no-scrollbar">
                <a 
                    href="{{ route('public.people.mitra.index') }}" 
                    class="px-4 py-2 rounded-xl text-xs font-bold transition-all shrink-0 {{ !request('category') ? 'bg-[#004741] text-white shadow-xs' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200/60' }}"
                >
                    <span x-text="$store.lang.t('Semua Kategori', 'All Categories')">Semua Kategori</span>
                </a>

                @foreach($categories as $cat)
                    <a 
                        href="{{ route('public.people.mitra.index', ['category' => $cat]) }}" 
                        class="px-4 py-2 rounded-xl text-xs font-bold transition-all shrink-0 {{ request('category') === $cat ? 'bg-[#004741] text-white shadow-xs' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200/60' }}"
                    >
                        {{ $cat }}
                    </a>
                @endforeach
            </div>
        </section>
    @endif

    {{-- Partner Logos Grid --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-24">
        @if($clients->isEmpty())
            <div class="text-center py-20 bg-gray-50 rounded-3xl border border-dashed border-gray-300">
                <p class="text-gray-500 font-medium" x-text="$store.lang.t('Belum ada mitra pada kategori ini.', 'No partners found in this category.')">
                    Belum ada mitra pada kategori ini.
                </p>
                <a href="{{ route('public.people.mitra.index') }}" class="mt-3 inline-block text-xs font-bold text-[#004741] underline">
                    <span x-text="$store.lang.t('Tampilkan Semua Mitra', 'Show All Partners')">Tampilkan Semua Mitra</span>
                </a>
            </div>
        @else
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6 sm:gap-8">
                @foreach($clients as $client)
                    <div class="bg-white rounded-3xl border border-gray-200/80 p-5 hover:shadow-xl hover:border-slate-400 transition-all duration-300 flex flex-col items-center justify-between text-center group min-h-[160px]">
                        
                        {{-- Logo Box --}}
                        <div class="w-full flex-1 flex items-center justify-center p-2">
                            @if($client->logo)
                                <img 
                                    src="{{ asset($client->logo) }}" 
                                    alt="{{ $client->name }}" 
                                    class="max-h-14 max-w-[130px] object-contain filter grayscale group-hover:grayscale-0 transition-all duration-300 opacity-80 group-hover:opacity-100"
                                >
                            @else
                                <div class="w-12 h-12 rounded-xl bg-slate-100 text-slate-900 font-black text-xl flex items-center justify-center border border-slate-300">
                                    {{ substr($client->name, 0, 1) }}
                                </div>
                            @endif
                        </div>

                        {{-- Identity --}}
                        <div class="w-full pt-3 border-t border-gray-100 mt-2">
                            <h4 class="text-xs font-bold text-gray-900 group-hover:text-[#004741] transition-colors truncate">
                                {{ $client->name }}
                            </h4>
                            @if($client->category)
                                <span class="text-[10px] text-gray-400 font-mono block truncate mt-0.5">
                                    {{ $client->category }}
                                </span>
                            @endif

                            @if($client->website)
                                <a href="{{ $client->website }}" target="_blank" rel="noopener" class="inline-flex items-center gap-1 text-[10px] font-bold text-[#004741] hover:underline mt-1">
                                    <span>Kunjungi</span>
                                    <span>↗</span>
                                </a>
                            @endif
                        </div>

                    </div>
                @endforeach
            </div>
        @endif
    </section>

</div>
@endsection
