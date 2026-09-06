@extends('public.layouts.app')

@section('title', $contributor->name . ' - Kontributor Ekosistem YOIN')

@section('content')
<div class="bg-white text-gray-900 font-sans pt-28 sm:pt-36 pb-24 select-none min-h-screen">

    {{-- Breadcrumb --}}
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 mb-6">
        <nav class="flex items-center gap-2 text-xs text-gray-500">
            <a href="{{ url('/') }}" class="hover:text-[#005952] transition-colors" x-text="$store.lang.t('Beranda', 'Home')">Beranda</a>
            <span>/</span>
            <a href="{{ route('public.people.index') }}" class="hover:text-[#005952] transition-colors" x-text="$store.lang.t('Insan & Tim', 'People & Team')">Insan & Tim</a>
            <span>/</span>
            <a href="{{ route('public.people.kontributor.index') }}" class="hover:text-[#005952] transition-colors" x-text="$store.lang.t('Kontributor', 'Contributors')">Kontributor</a>
            <span>/</span>
            <span class="text-[#005952] font-semibold truncate">{{ $contributor->name }}</span>
        </nav>
    </div>

    {{-- Profile Card Detail --}}
    <article class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-3xl border border-gray-200/90 p-8 sm:p-12 shadow-xl">
            
            <div class="flex flex-col sm:flex-row items-center sm:items-start gap-8 pb-8 border-b border-gray-100">
                <div class="w-28 h-28 sm:w-36 sm:h-36 rounded-3xl overflow-hidden bg-gray-100 shadow-md shrink-0 border border-gray-200">
                    @if($contributor->photo)
                        <img src="{{ asset($contributor->photo) }}" alt="{{ $contributor->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-400 font-bold text-4xl">
                            {{ substr($contributor->name, 0, 1) }}
                        </div>
                    @endif
                </div>

                <div class="text-center sm:text-left flex-1 min-w-0">
                    <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2 mb-2">
                        <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-slate-900 text-white shadow-xs">
                            {{ ucfirst($contributor->contribution_type ?: 'Kontributor') }}
                        </span>
                        @if($contributor->period)
                            <span class="text-xs font-mono text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
                                {{ $contributor->period }}
                            </span>
                        @endif
                    </div>

                    <h1 class="text-2xl sm:text-4xl font-black text-gray-950 tracking-tight">
                        {{ $contributor->name }}
                    </h1>
                    <p class="text-sm sm:text-base font-bold text-[#004741] mt-1">
                        {{ $contributor->role_id }}
                    </p>
                    @if($contributor->organization)
                        <p class="text-xs sm:text-sm text-gray-500 mt-1 flex items-center justify-center sm:justify-start gap-1.5">
                            <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            <span>{{ $contributor->organization }}</span>
                        </p>
                    @endif

                    {{-- Social Channels --}}
                    <div class="flex items-center justify-center sm:justify-start gap-3 mt-4">
                        @if($contributor->getSocialLink('linkedin'))
                            <a href="{{ $contributor->getSocialLink('linkedin') }}" target="_blank" rel="noopener" class="p-2 rounded-xl bg-gray-100 text-gray-600 hover:bg-[#004741] hover:text-white transition-colors" title="LinkedIn">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                            </a>
                        @endif
                        @if($contributor->getSocialLink('github'))
                            <a href="{{ $contributor->getSocialLink('github') }}" target="_blank" rel="noopener" class="p-2 rounded-xl bg-gray-100 text-gray-600 hover:bg-[#004741] hover:text-white transition-colors" title="GitHub">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Dedication Narrative --}}
            <div class="py-8">
                <h3 class="text-lg font-bold text-gray-950 mb-4" x-text="$store.lang.t('Catatan Kontribusi & Dedikasi', 'Contribution & Dedication Notes')">
                    Catatan Kontribusi & Dedikasi
                </h3>
                <div class="text-sm sm:text-base text-gray-700 leading-relaxed font-light space-y-4">
                    <p x-show="$store.lang.isID()">{{ $contributor->bio_id }}</p>
                    <p x-show="$store.lang.isEN()" x-cloak>{{ $contributor->bio_en ?: $contributor->bio_id }}</p>
                </div>

                @if($contributor->story_html)
                    <div class="prose prose-sm max-w-none text-gray-700 mt-6 pt-6 border-t border-gray-100">
                        {!! $contributor->story_html !!}
                    </div>
                @endif
            </div>

            {{-- Back Button --}}
            <div class="pt-6 border-t border-gray-100 flex items-center justify-between">
                <a href="{{ route('public.people.kontributor.index') }}" class="text-xs font-bold text-[#004741] hover:underline flex items-center gap-1">
                    <span>←</span>
                    <span x-text="$store.lang.t('Kembali ke Direktori Kontributor', 'Back to Contributor Directory')">Kembali ke Direktori Kontributor</span>
                </a>
            </div>

        </div>
    </article>

</div>
@endsection
