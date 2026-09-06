@extends('public.layouts.app')

@section('title', $founder->name . ' - Dewan Pendiri YOIN')

@section('content')
<div class="bg-white text-gray-900 font-sans pt-28 sm:pt-36 pb-24 select-none min-h-screen">

    {{-- Breadcrumb --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-6">
        <nav class="flex items-center gap-2 text-xs text-gray-500">
            <a href="{{ url('/') }}" class="hover:text-[#005952] transition-colors" x-text="$store.lang.t('Beranda', 'Home')">Beranda</a>
            <span>/</span>
            <a href="{{ route('public.people.index') }}" class="hover:text-[#005952] transition-colors" x-text="$store.lang.t('Insan & Tim', 'People & Team')">Insan & Tim</a>
            <span>/</span>
            <a href="{{ route('public.people.founder.index') }}" class="hover:text-[#005952] transition-colors" x-text="$store.lang.t('Pendiri', 'Founders')">Pendiri</a>
            <span>/</span>
            <span class="text-[#005952] font-semibold">{{ $founder->name }}</span>
        </nav>
    </div>

    {{-- Sub-Navigation Pills --}}
    @include('public.people._nav')

    {{-- Editorial Hero Section for Founder --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-16">
        <div class="bg-gradient-to-br from-gray-950 via-[#003430] to-gray-900 text-white rounded-3xl p-8 sm:p-12 lg:p-16 relative overflow-hidden shadow-2xl">
            <div class="absolute -right-20 -top-20 w-80 h-80 bg-teal-500/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center relative z-10">
                
                {{-- Portrait --}}
                <div class="lg:col-span-4 flex justify-center lg:justify-start">
                    <div class="w-64 sm:w-72 lg:w-full max-w-[320px] aspect-4/5 rounded-3xl overflow-hidden shadow-2xl bg-gray-900 ring-1 ring-white/20">
                        @if($founder->photo)
                            <img src="{{ asset($founder->photo) }}" alt="{{ $founder->name }}" class="w-full h-full object-cover object-top">
                        @else
                            <div class="w-full h-full flex items-center justify-center font-black text-6xl text-white/20">
                                {{ substr($founder->name, 0, 1) }}
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Hero Copy --}}
                <div class="lg:col-span-8">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/20 text-white text-xs font-bold uppercase tracking-wider mb-4">
                        <span class="w-2 h-2 rounded-full bg-white"></span>
                        <span>{{ $founder->role_id }}</span>
                    </div>

                    <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black tracking-tight text-white leading-tight">
                        {{ $founder->name }}
                    </h1>
                    <p class="text-white/80 text-sm sm:text-base font-mono mt-2 font-medium">
                        {{ $founder->role_en ?: $founder->role_id }}
                    </p>

                    @if($founder->getMeta('quote'))
                        <blockquote class="my-6 p-4 rounded-2xl bg-white/5 border-l-4 border-white text-white/95 text-base sm:text-lg italic font-serif leading-relaxed">
                            "{{ $founder->getMeta('quote') }}"
                        </blockquote>
                    @endif

                    {{-- Social Media Icons --}}
                    <div class="flex items-center gap-3 mt-6">
                        @if($founder->getSocialLink('linkedin'))
                            <a href="{{ $founder->getSocialLink('linkedin') }}" target="_blank" rel="noopener" class="p-3 rounded-xl bg-white/10 hover:bg-[#004741] hover:text-white transition-all text-gray-300" title="LinkedIn">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                            </a>
                        @endif
                        @if($founder->getSocialLink('instagram'))
                            <a href="{{ $founder->getSocialLink('instagram') }}" target="_blank" rel="noopener" class="p-3 rounded-xl bg-white/10 hover:bg-[#004741] hover:text-white transition-all text-gray-300" title="Instagram">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                            </a>
                        @endif
                        @if($founder->getSocialLink('twitter'))
                            <a href="{{ $founder->getSocialLink('twitter') }}" target="_blank" rel="noopener" class="p-3 rounded-xl bg-white/10 hover:bg-[#004741] hover:text-white transition-all text-gray-300" title="X (Twitter)">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                            </a>
                        @endif
                        @if($founder->getSocialLink('email'))
                            <a href="mailto:{{ $founder->getSocialLink('email') }}" class="p-3 rounded-xl bg-white/10 hover:bg-[#004741] hover:text-white transition-all text-gray-300" title="Email">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </a>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- Main Content Grid --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-24">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            
            {{-- Main Column --}}
            <div class="lg:col-span-8 space-y-12">
                
                {{-- Extended Biography & Philosophy --}}
                <div class="bg-white rounded-3xl border border-gray-100 p-8 sm:p-10 shadow-sm">
                    <h3 class="text-xl sm:text-2xl font-bold text-gray-950 mb-6 flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-[#005952]"></span>
                        <span x-text="$store.lang.t('Profil & Filosofi Kepemimpinan', 'Profile & Leadership Philosophy')">Profil & Filosofi Kepemimpinan</span>
                    </h3>

                    @if($founder->story_html)
                        <div class="prose prose-base max-w-none text-gray-700 leading-relaxed font-light">
                            {!! $founder->story_html !!}
                        </div>
                    @else
                        <div class="text-base text-gray-700 leading-relaxed font-light space-y-4">
                            <p x-show="$store.lang.isID()">{{ $founder->bio_id }}</p>
                            <p x-show="$store.lang.isEN()" x-cloak>{{ $founder->bio_en ?: $founder->bio_id }}</p>
                        </div>
                    @endif
                </div>

                {{-- Trajectory Timeline --}}
                @if($founder->getMeta('trajectory'))
                    <div class="bg-gray-50 rounded-3xl border border-gray-100 p-8 sm:p-10">
                        <h3 class="text-xl sm:text-2xl font-bold text-gray-950 mb-6 flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-[#005952]"></span>
                            <span x-text="$store.lang.t('Rekam Jejak & Tonggak Pencapaian', 'Trajectory & Milestones')">Rekam Jejak & Tonggak Pencapaian</span>
                        </h3>

                        <div class="space-y-4">
                            @foreach((array)$founder->getMeta('trajectory') as $i => $step)
                                <div class="flex items-start gap-4 p-4 rounded-2xl bg-white border border-gray-200/60 shadow-xs">
                                    <span class="w-8 h-8 rounded-full bg-slate-950 text-white font-black text-xs flex items-center justify-center shrink-0">
                                        0{{ $i + 1 }}
                                    </span>
                                    <div class="text-sm font-medium text-gray-800 leading-snug pt-1 w-full">
                                        @if(is_array($step))
                                            <div class="flex items-center gap-2 mb-1">
                                                @if(!empty($step['year']))
                                                    <span class="px-2 py-0.5 rounded bg-slate-100 text-slate-900 border border-slate-200 text-xs font-bold font-mono">{{ $step['year'] }}</span>
                                                @endif
                                                @if(!empty($step['title']))
                                                    <span class="font-bold text-gray-950">{{ $step['title'] }}</span>
                                                @endif
                                            </div>
                                            @if(!empty($step['description']))
                                                <p class="text-xs text-gray-600 font-light leading-relaxed">{{ $step['description'] }}</p>
                                            @elseif(empty($step['year']) && empty($step['title']))
                                                <span>{{ implode(' - ', array_filter($step)) }}</span>
                                            @endif
                                        @else
                                            {{ $step }}
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

            </div>

            {{-- Sidebar Column --}}
            <div class="lg:col-span-4 space-y-8">
                
                {{-- Authored Executive Manifestos --}}
                @if($stories->count() > 0)
                    <div class="bg-gradient-to-br from-gray-900 to-gray-950 text-white rounded-3xl p-6 sm:p-7 shadow-xl border border-slate-800">
                        <span class="text-[11px] font-mono uppercase tracking-widest text-slate-400 block mb-2" x-text="$store.lang.t('MANIFES & ESAI KEPEMIMPINAN', 'EXECUTIVE MANIFESTOS & ESSAYS')">
                            MANIFES & ESAI KEPEMIMPINAN
                        </span>
                        <h4 class="text-lg font-bold text-white mb-4">
                            {{ $stories->count() }} <span x-text="$store.lang.t('Dokumen Manifes Strategis', 'Documented Executive Essays')">Dokumen Manifes Strategis</span>
                        </h4>

                        <div class="space-y-3">
                            @foreach($stories as $story)
                                <a href="{{ route('public.people.storyfounder.show', $story->slug) }}" class="block p-3.5 rounded-xl bg-white/5 hover:bg-white/10 border border-white/10 transition-colors group">
                                    <span class="text-[10px] font-mono text-slate-400 block mb-1">{{ $story->chapter_number }}</span>
                                    <h5 class="text-xs font-bold text-white group-hover:text-white transition-colors">{{ $story->title }}</h5>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Other Founders Card --}}
                <div class="bg-white rounded-3xl border border-gray-100 p-6 sm:p-7 shadow-sm">
                    <h4 class="text-sm font-bold uppercase tracking-wider text-gray-500 mb-4" x-text="$store.lang.t('Pendiri Lainnya', 'Other Co-Founders')">
                        Pendiri Lainnya
                    </h4>

                    <div class="space-y-4">
                        @foreach($otherFounders as $other)
                            <a href="{{ route('public.people.founder.show', $other->slug) }}" class="flex items-center gap-3 p-3 rounded-2xl hover:bg-gray-50 transition-colors group">
                                <div class="w-12 h-12 rounded-xl overflow-hidden bg-gray-200 shrink-0">
                                    @if($other->photo)
                                        <img src="{{ asset($other->photo) }}" alt="{{ $other->name }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center font-bold text-gray-400">
                                            {{ substr($other->name, 0, 1) }}
                                        </div>
                                    @endif
                                </div>
                                <div class="min-w-0">
                                    <h5 class="text-xs font-bold text-gray-900 group-hover:text-[#005952] transition-colors truncate">
                                        {{ $other->name }}
                                    </h5>
                                    <p class="text-[11px] text-gray-500 truncate">{{ $other->role_id }}</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>

            </div>

        </div>
    </section>

</div>
@endsection
