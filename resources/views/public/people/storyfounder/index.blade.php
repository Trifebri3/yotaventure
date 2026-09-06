@extends('public.layouts.app')

@section('title', 'Manifes & Rekam Jejak Kepemimpinan Pendiri - PT Yota Inovasi Nusantara (YOIN)')

@section('content')
<div class="bg-[#fafaf9] text-gray-900 font-serif pt-28 sm:pt-36 pb-24 select-none min-h-screen">

    {{-- Breadcrumb --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-6 font-sans">
        <nav class="flex items-center gap-2 text-xs text-gray-500">
            <a href="{{ url('/') }}" class="hover:text-[#005952] transition-colors" x-text="$store.lang.t('Beranda', 'Home')">Beranda</a>
            <span>/</span>
            <a href="{{ route('public.people.index') }}" class="hover:text-[#005952] transition-colors" x-text="$store.lang.t('Insan & Tim', 'People & Team')">Insan & Tim</a>
            <span>/</span>
            <span class="text-[#005952] font-semibold" x-text="$store.lang.t('Manifes & Perjalanan', 'Executive Memoirs')">Manifes & Perjalanan</span>
        </nav>
    </div>

    {{-- Sub-Navigation Pills --}}
    <div class="font-sans">
        @include('public.people._nav')
    </div>

    {{-- Executive Monograph Header --}}
    <header class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center my-12 sm:my-16">
        <span class="inline-block px-3.5 py-1 rounded-full bg-slate-900 text-white font-sans text-xs font-bold uppercase tracking-widest mb-4">
            <span x-text="$store.lang.t('MANIFES STRATEGIS & KEPEMIMPINAN EKOSISTEM', 'STRATEGIC MANIFESTOS & ECOSYSTEM LEADERSHIP')">
                MANIFES STRATEGIS & KEPEMIMPINAN EKOSISTEM
            </span>
        </span>
        <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black text-gray-950 tracking-tight leading-[1.18]">
            <span x-text="$store.lang.t('Tesis, Rekam Jejak, & Manifes Kepemimpinan Dewan Pendiri', 'Theses, Trajectory, & Leadership Monograph of YOIN Founders')">
                Tesis, Rekam Jejak, & Manifes Kepemimpinan Dewan Pendiri
            </span>
        </h1>
        <p class="mt-6 text-base sm:text-xl text-gray-600 font-light leading-relaxed max-w-2xl mx-auto">
            <span x-text="$store.lang.t('Dokumentasi mendalam mengenai pembelajaran strategis, validasi model bisnis riil di lapangan, kedaulatan sains-teknologi, dan visi jangka panjang membangun holding ventura berdaya tahan tinggi.', 'Comprehensive documentation on strategic learnings, real-world business model validation, science-technology sovereignty, and the long-term vision of building a resilient venture holding.')">
                Dokumentasi mendalam mengenai pembelajaran strategis, validasi model bisnis riil di lapangan, kedaulatan sains-teknologi, dan visi jangka panjang membangun holding ventura berdaya tahan tinggi.
            </span>
        </p>
    </header>

    {{-- Chapter Timeline / Reader List --}}
    <section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 mb-24">
        <div class="relative border-l-2 border-slate-300 ml-4 sm:ml-8 pl-6 sm:pl-10 space-y-12 sm:space-y-16">
            
            @foreach($stories as $index => $story)
                <div class="relative group">
                    {{-- Chapter Dot Indicator --}}
                    <div class="absolute -left-[31px] sm:-left-[47px] top-1.5 w-6 h-6 rounded-full bg-white border-4 border-[#004741] group-hover:scale-125 transition-transform duration-200"></div>

                    <article class="bg-white rounded-3xl border border-gray-200/80 p-6 sm:p-9 shadow-sm hover:shadow-xl hover:border-slate-400 transition-all duration-300">
                        
                        {{-- Meta Bar --}}
                        <div class="flex flex-wrap items-center justify-between gap-3 text-xs font-sans text-gray-500 mb-4">
                            <div class="flex items-center gap-2">
                                <span class="px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-900 font-bold font-mono text-[11px] border border-slate-300">
                                    {{ $story->chapter_number ?: 'MANIFES' }}
                                </span>
                                @if($story->author)
                                    <span class="text-gray-400">•</span>
                                    <span class="font-medium text-gray-700">Penutur: {{ $story->author->name }}</span>
                                @endif
                            </div>
                            <div class="flex items-center gap-3 font-mono text-[11px] text-gray-400">
                                <span>{{ $story->reading_time ?: '5 min read' }}</span>
                            </div>
                        </div>

                        {{-- Title & Subtitle --}}
                        <h2 class="text-2xl sm:text-3xl font-bold text-gray-950 group-hover:text-[#004741] transition-colors leading-tight mb-2">
                            <a href="{{ route('public.people.storyfounder.show', $story->slug) }}">
                                {{ $story->title }}
                            </a>
                        </h2>

                        @if($story->subtitle)
                            <p class="text-sm sm:text-base text-gray-500 italic font-light mb-4">
                                {{ $story->subtitle }}
                            </p>
                        @endif

                        {{-- Excerpt --}}
                        <p class="text-sm sm:text-base text-gray-700 font-light leading-relaxed line-clamp-3 mb-6">
                            {{ $story->excerpt }}
                        </p>

                        {{-- Read Action Button --}}
                        <div class="pt-4 border-t border-gray-100 flex items-center justify-between font-sans">
                            <a 
                                href="{{ route('public.people.storyfounder.show', $story->slug) }}" 
                                class="inline-flex items-center gap-2 text-xs font-bold text-[#004741] group-hover:translate-x-1 transition-transform"
                            >
                                <span x-text="$store.lang.t('Baca Dokumen Lengkap', 'Read Full Monograph')">Baca Dokumen Lengkap</span>
                                <span>→</span>
                            </a>
                            <span class="text-[11px] text-gray-400 font-mono">
                                #{{ $index + 1 }}
                            </span>
                        </div>

                    </article>
                </div>
            @endforeach

        </div>
    </section>

</div>
@endsection
