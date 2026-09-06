@extends('public.layouts.app')

@section('title', 'Tim Inti Ekosistem Bisnis - PT Yota Inovasi Nusantara (YOIN)')

@section('content')
<div class="bg-white text-gray-900 font-sans pt-28 sm:pt-36 pb-24 select-none min-h-screen">

    {{-- Breadcrumb --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-6">
        <nav class="flex items-center gap-2 text-xs text-gray-500">
            <a href="{{ url('/') }}" class="hover:text-[#005952] transition-colors" x-text="$store.lang.t('Beranda', 'Home')">Beranda</a>
            <span>/</span>
            <a href="{{ route('public.people.index') }}" class="hover:text-[#005952] transition-colors" x-text="$store.lang.t('Insan & Tim', 'People & Team')">Insan & Tim</a>
            <span>/</span>
            <span class="text-[#005952] font-semibold" x-text="$store.lang.t('Tim Inti', 'Core Team')">Tim Inti</span>
        </nav>
    </div>

    {{-- Sub-Navigation Pills --}}
    @include('public.people._nav')

    {{-- Header --}}
    <header class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-12 sm:mb-16">
        <div class="max-w-4xl">
            <span class="text-xs font-bold tracking-[0.25em] text-[#005952] uppercase block mb-3" x-text="$store.lang.t('STRUKTUR EKSEKUTIF & TALENTA INTI', 'CORE EXECUTIVES & DOMAIN LEADS')">
                STRUKTUR EKSEKUTIF & TALENTA INTI
            </span>
            <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black text-gray-950 tracking-tight leading-[1.12]">
                <span x-text="$store.lang.t('Talenta Eksekutor Lintas Pilar & Unit Bisnis', 'Cross-Venture Execution Leads & Talent')">
                    Talenta Eksekutor Lintas Pilar & Unit Bisnis
                </span>
            </h1>
            <p class="mt-4 sm:mt-6 text-base sm:text-xl text-gray-600 font-light leading-relaxed">
                <span x-text="$store.lang.t('Pakar teknik, agronomis modern, analis produk, dan pengembang teknologi yang menggerakkan setiap inisiatif dan unit bisnis di bawah bendera holding YOIN.', 'Engineers, modern agronomists, product strategists, and technologists powering each initiative and brand under the YOIN holding umbrella.')">
                    Pakar teknik, agronomis modern, analis produk, dan pengembang teknologi yang menggerakkan setiap inisiatif dan unit bisnis di bawah bendera holding YOIN.
                </span>
            </p>
        </div>
    </header>

    {{-- Filter Bar: Brands & Status --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-12">
        <div class="bg-gray-50 rounded-2xl border border-gray-200/80 p-4 sm:p-5 flex flex-col md:flex-row items-stretch md:items-center justify-between gap-4">
            
            {{-- Brand Filter Tabs --}}
            <div class="flex items-center gap-2 overflow-x-auto no-scrollbar pb-1">
                <a 
                    href="{{ route('public.people.tim.index', array_filter(['status' => request('status')])) }}" 
                    class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all shrink-0 {{ !request('initiative') ? 'bg-[#004741] text-white shadow-xs' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200/60' }}"
                >
                    <span x-text="$store.lang.t('Semua Brand', 'All Brands')">Semua Brand</span>
                </a>

                @foreach($initiatives as $initiative)
                    <a 
                        href="{{ route('public.people.tim.index', array_filter(['initiative' => $initiative->id, 'status' => request('status')])) }}" 
                        class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all shrink-0 {{ request('initiative') == $initiative->id ? 'bg-[#004741] text-white shadow-xs' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200/60' }}"
                    >
                        {{ $initiative->name }}
                    </a>
                @endforeach
            </div>

            {{-- Status Filter --}}
            <div class="flex items-center gap-2 shrink-0 border-t md:border-t-0 pt-3 md:pt-0 border-gray-200">
                <span class="text-xs text-gray-400 font-mono" x-text="$store.lang.t('Status:', 'Status:')">Status:</span>
                <a 
                    href="{{ route('public.people.tim.index', array_filter(['initiative' => request('initiative'), 'status' => 'active'])) }}" 
                    class="px-3 py-1 rounded-lg text-xs font-semibold transition-all {{ request('status') === 'active' ? 'bg-[#004741] text-white' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200' }}"
                >
                    <span x-text="$store.lang.t('Aktif', 'Active')">Aktif</span>
                </a>
                <a 
                    href="{{ route('public.people.tim.index', array_filter(['initiative' => request('initiative'), 'status' => 'alumni'])) }}" 
                    class="px-3 py-1 rounded-lg text-xs font-semibold transition-all {{ request('status') === 'alumni' ? 'bg-slate-900 text-white' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200' }}"
                >
                    <span x-text="$store.lang.t('Alumni', 'Alumni')">Alumni</span>
                </a>
                @if(request('status') || request('initiative'))
                    <a 
                        href="{{ route('public.people.tim.index') }}" 
                        class="text-xs text-slate-600 font-bold hover:text-slate-900 underline ml-1"
                        title="Reset Filter"
                    >
                        Reset
                    </a>
                @endif
            </div>

        </div>
    </section>

    {{-- Team Grid --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-24">
        @if($team->isEmpty())
            <div class="text-center py-20 bg-gray-50 rounded-3xl border border-dashed border-gray-300">
                <p class="text-gray-500 font-medium" x-text="$store.lang.t('Tidak ada anggota tim yang cocok dengan filter yang dipilih.', 'No team members match the selected criteria.')">
                    Tidak ada anggota tim yang cocok dengan filter yang dipilih.
                </p>
                <a href="{{ route('public.people.tim.index') }}" class="mt-3 inline-block text-xs font-bold text-[#005952] underline">
                    <span x-text="$store.lang.t('Tampilkan Semua Anggota', 'Show All Members')">Tampilkan Semua Anggota</span>
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
                @foreach($team as $member)
                    <div class="bg-white rounded-3xl border border-gray-200/80 p-6 sm:p-7 hover:shadow-xl hover:border-slate-400 transition-all duration-300 flex flex-col justify-between group">
                        <div>
                            {{-- Top Header: Brand Connection Badge & Active Status --}}
                            <div class="flex items-center justify-between gap-2 mb-6">
                                <span class="px-2.5 py-1 rounded-lg text-[11px] font-bold tracking-wide {{ $member->initiative ? 'bg-slate-900 text-white font-bold' : 'bg-gray-100 text-gray-800 border border-gray-200 font-semibold' }}">
                                    {{ $member->initiative ? $member->initiative->name : 'Holding YOIN' }}
                                </span>

                                @if($member->is_active)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-800 border border-slate-300 text-[10px] font-bold">
                                        <span class="w-1.5 h-1.5 rounded-full bg-[#004741]"></span>
                                        <span x-text="$store.lang.t('Aktif', 'Active')">Aktif</span>
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-gray-100 text-gray-600 text-[10px] font-semibold">
                                        <span x-text="$store.lang.t('Alumni', 'Alumni')">Alumni</span>
                                    </span>
                                @endif
                            </div>

                            {{-- Avatar & Identity --}}
                            <div class="flex items-center gap-4 mb-5">
                                <div class="w-16 h-16 sm:w-18 sm:h-18 rounded-2xl overflow-hidden bg-gray-100 shrink-0 shadow-sm border border-gray-200/60">
                                    @if($member->photo)
                                        <img src="{{ asset($member->photo) }}" alt="{{ $member->name }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center font-bold text-gray-400 text-xl">
                                            {{ substr($member->name, 0, 1) }}
                                        </div>
                                    @endif
                                </div>
                                <div class="min-w-0">
                                    <h3 class="text-base sm:text-lg font-bold text-gray-950 group-hover:text-[#004741] transition-colors truncate">
                                        {{ $member->name }}
                                    </h3>
                                    <p class="text-xs font-semibold text-[#004741] truncate mt-0.5">
                                        {{ $member->role_id }}
                                    </p>
                                    @if($member->role_en)
                                        <p class="text-[11px] text-gray-400 font-mono truncate">
                                            {{ $member->role_en }}
                                        </p>
                                    @endif
                                </div>
                            </div>

                            {{-- Bio Snippet --}}
                            <p class="text-xs text-gray-600 line-clamp-3 leading-relaxed mb-4 font-light">
                                <span x-show="$store.lang.isID()">{{ $member->bio_id }}</span>
                                <span x-show="$store.lang.isEN()" x-cloak>{{ $member->bio_en ?: $member->bio_id }}</span>
                            </p>

                            {{-- Skills / Domain Tags (from meta JSON) --}}
                            @if($member->getMeta('skills'))
                                <div class="flex flex-wrap gap-1.5 mb-6">
                                    @foreach((array)$member->getMeta('skills') as $skill)
                                        <span class="px-2 py-0.5 rounded-md bg-gray-100 text-gray-600 text-[10px] font-mono">
                                            {{ $skill }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        {{-- Social Links Footer --}}
                        <div class="pt-4 border-t border-gray-100 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                @if($member->getSocialLink('linkedin'))
                                    <a href="{{ $member->getSocialLink('linkedin') }}" target="_blank" rel="noopener" class="p-1.5 rounded-lg text-gray-400 hover:text-[#005952] hover:bg-gray-100 transition-colors" title="LinkedIn">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                                    </a>
                                @endif
                                @if($member->getSocialLink('github'))
                                    <a href="{{ $member->getSocialLink('github') }}" target="_blank" rel="noopener" class="p-1.5 rounded-lg text-gray-400 hover:text-[#005952] hover:bg-gray-100 transition-colors" title="GitHub">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>
                                    </a>
                                @endif
                                @if($member->getSocialLink('instagram'))
                                    <a href="{{ $member->getSocialLink('instagram') }}" target="_blank" rel="noopener" class="p-1.5 rounded-lg text-gray-400 hover:text-[#005952] hover:bg-gray-100 transition-colors" title="Instagram">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                                    </a>
                                @endif
                                @if($member->getSocialLink('email'))
                                    <a href="mailto:{{ $member->getSocialLink('email') }}" class="p-1.5 rounded-lg text-gray-400 hover:text-[#005952] hover:bg-gray-100 transition-colors" title="Email">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                    </a>
                                @endif
                            </div>

                            <span class="text-[11px] text-gray-400 font-mono">
                                #{{ $loop->iteration }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </section>

</div>
@endsection
