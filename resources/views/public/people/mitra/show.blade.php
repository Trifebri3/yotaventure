@extends('public.layouts.app')

@section('title', $client->name . ' - Mitra Kolaborator Ekosistem YOIN')

@section('content')
<div class="bg-white text-gray-900 font-sans pt-28 sm:pt-36 pb-24 select-none min-h-screen">

    {{-- Breadcrumb --}}
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 mb-6">
        <nav class="flex items-center gap-2 text-xs text-gray-500">
            <a href="{{ url('/') }}" class="hover:text-[#005952] transition-colors" x-text="$store.lang.t('Beranda', 'Home')">Beranda</a>
            <span>/</span>
            <a href="{{ route('public.people.index') }}" class="hover:text-[#005952] transition-colors" x-text="$store.lang.t('Insan & Tim', 'People & Team')">Insan & Tim</a>
            <span>/</span>
            <a href="{{ route('public.people.mitra.index') }}" class="hover:text-[#005952] transition-colors" x-text="$store.lang.t('Mitra Kolaborator', 'Collaborators')">Mitra Kolaborator</a>
            <span>/</span>
            <span class="text-[#005952] font-semibold truncate">{{ $client->name }}</span>
        </nav>
    </div>

    {{-- Partner Spotlight Card --}}
    <article class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-3xl border border-gray-200/90 p-8 sm:p-12 shadow-xl text-center">
            
            <div class="w-32 h-32 mx-auto mb-6 p-4 rounded-3xl bg-gray-50 border border-gray-200 flex items-center justify-center">
                @if($client->logo)
                    <img src="{{ asset($client->logo) }}" alt="{{ $client->name }}" class="max-h-20 max-w-[100px] object-contain">
                @else
                    <span class="text-3xl font-black text-[#004741]">{{ substr($client->name, 0, 1) }}</span>
                @endif
            </div>

            @if($client->category)
                <span class="inline-block px-3 py-1 rounded-full bg-slate-900 text-white text-xs font-bold uppercase tracking-wider mb-3 shadow-xs">
                    {{ $client->category }}
                </span>
            @endif

            <h1 class="text-2xl sm:text-4xl font-black text-gray-950 tracking-tight mb-4">
                {{ $client->name }}
            </h1>

            @if($client->description)
                <p class="text-sm sm:text-base text-gray-600 max-w-xl mx-auto font-light leading-relaxed mb-6">
                    {{ $client->description }}
                </p>
            @endif

            @if($client->website)
                <a href="{{ $client->website }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-[#004741] text-white text-xs font-bold shadow-sm hover:bg-slate-900 transition-colors">
                    <span>Kunjungi Situs Resmi</span>
                    <span>↗</span>
                </a>
            @endif

            <div class="mt-12 pt-6 border-t border-gray-100 flex items-center justify-between text-xs font-bold text-[#004741]">
                <a href="{{ route('public.people.mitra.index') }}" class="hover:underline flex items-center gap-1">
                    <span>←</span>
                    <span>Semua Mitra Kolaborator</span>
                </a>
            </div>

        </div>
    </article>

</div>
@endsection
