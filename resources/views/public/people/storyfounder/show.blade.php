@extends('public.layouts.app')

@section('title', $story->title . ' - Manifes Kepemimpinan YOIN')

@section('content')
<div 
    x-data="{ 
        fontSize: 'base', // 'sm', 'base', 'lg'
        fontFamily: 'sans', // 'sans', 'serif'
        copied: false,
        copyShareLink() {
            navigator.clipboard.writeText(window.location.href);
            this.copied = true;
            setTimeout(() => this.copied = false, 2500);
        }
    }" 
    class="bg-[#fafaf9] text-gray-900 pt-28 sm:pt-36 pb-24 select-none min-h-screen transition-colors duration-200"
>

    {{-- Breadcrumb --}}
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 mb-6 font-sans">
        <nav class="flex items-center gap-2 text-xs text-gray-500">
            <a href="{{ url('/') }}" class="hover:text-[#005952] transition-colors" x-text="$store.lang.t('Beranda', 'Home')">Beranda</a>
            <span>/</span>
            <a href="{{ route('public.people.index') }}" class="hover:text-[#005952] transition-colors" x-text="$store.lang.t('Insan & Tim', 'People & Team')">Insan & Tim</a>
            <span>/</span>
            <a href="{{ route('public.people.storyfounder.index') }}" class="hover:text-[#005952] transition-colors" x-text="$store.lang.t('Manifes & Perjalanan', 'Executive Memoirs')">Manifes & Perjalanan</a>
            <span>/</span>
            <span class="text-[#005952] font-semibold truncate">{{ $story->chapter_number ?: 'Manifes' }}</span>
        </nav>
    </div>

    {{-- Reader Control Toolbar --}}
    <div class="sticky top-20 sm:top-24 z-30 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 mb-8 font-sans">
        <div class="bg-white/95 backdrop-blur-md rounded-2xl border border-gray-200/80 p-3 shadow-md flex items-center justify-between gap-4">
            <a 
                href="{{ route('public.people.storyfounder.index') }}" 
                class="inline-flex items-center gap-1.5 text-xs font-bold text-gray-600 hover:text-[#005952] transition-colors"
            >
                <span>←</span>
                <span x-text="$store.lang.t('Daftar Manifes & Esai', 'All Executive Manifestos')">Daftar Manifes & Esai</span>
            </a>

            {{-- Reader Customizers & Share --}}
            <div class="flex items-center gap-3">
                {{-- Font Family Toggle --}}
                <div class="hidden sm:flex items-center gap-1 bg-gray-100 p-0.5 rounded-lg text-[11px] font-medium">
                    <button 
                        @click="fontFamily = 'sans'" 
                        class="px-2 py-0.5 rounded-md transition-all font-sans"
                        :class="fontFamily === 'sans' ? 'bg-white shadow-xs text-gray-900 font-bold' : 'text-gray-500 hover:text-gray-900'"
                    >Sans</button>
                    <button 
                        @click="fontFamily = 'serif'" 
                        class="px-2 py-0.5 rounded-md transition-all font-serif"
                        :class="fontFamily === 'serif' ? 'bg-white shadow-xs text-gray-900 font-bold' : 'text-gray-500 hover:text-gray-900'"
                    >Serif</button>
                </div>

                {{-- Font Size Controls --}}
                <div class="flex items-center gap-1">
                    <button 
                        @click="fontSize = 'sm'" 
                        class="px-2 py-1 rounded-md text-xs font-bold transition-all"
                        :class="fontSize === 'sm' ? 'bg-[#004741] text-white shadow-xs' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'"
                        title="Teks Lebih Kecil"
                    >A-</button>
                    <button 
                        @click="fontSize = 'base'" 
                        class="px-2 py-1 rounded-md text-xs font-bold transition-all"
                        :class="fontSize === 'base' ? 'bg-[#004741] text-white shadow-xs' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'"
                        title="Teks Standar"
                    >A</button>
                    <button 
                        @click="fontSize = 'lg'" 
                        class="px-2 py-1 rounded-md text-xs font-bold transition-all"
                        :class="fontSize === 'lg' ? 'bg-[#004741] text-white shadow-xs' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'"
                        title="Teks Lebih Besar"
                    >A+</button>
                </div>

                {{-- Copy Share Link --}}
                <button 
                    @click="copyShareLink()" 
                    class="p-1.5 rounded-lg border border-gray-200 hover:border-[#004741] hover:text-[#004741] transition-colors relative"
                    title="Salin Tautan Monograf"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/></svg>
                    <span 
                        x-show="copied" 
                        x-cloak 
                        class="absolute -bottom-8 right-0 bg-gray-900 text-white text-[10px] font-mono px-2 py-0.5 rounded shadow-lg whitespace-nowrap"
                    >
                        Tautan Disalin!
                    </span>
                </button>
            </div>
        </div>
    </div>

    {{-- Executive Monograph Reading Stage --}}
    <article class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Monograph Header --}}
        <header class="text-center pb-10 mb-10 border-b border-gray-200/80 font-sans">
            <span class="inline-block px-3.5 py-1 rounded-full bg-slate-900 text-white text-xs font-mono font-bold uppercase tracking-widest mb-4">
                {{ $story->chapter_number ?: 'MANIFES KEPEMIMPINAN' }}
            </span>
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-gray-950 tracking-tight leading-[1.2] mb-4">
                {{ $story->title }}
            </h1>
            
            @if($story->subtitle)
                <p class="text-base sm:text-lg text-gray-600 font-normal max-w-xl mx-auto mb-6">
                    {{ $story->subtitle }}
                </p>
            @endif

            {{-- Author & Reading Time Bar --}}
            <div class="flex flex-wrap items-center justify-center gap-4 text-xs text-gray-500 pt-4 border-t border-gray-100">
                @if($story->author)
                    <div class="flex items-center gap-2">
                        <div class="w-7 h-7 rounded-full overflow-hidden bg-gray-200 shrink-0">
                            @if($story->author->photo)
                                <img src="{{ asset($story->author->photo) }}" alt="{{ $story->author->name }}" class="w-full h-full object-cover">
                            @endif
                        </div>
                        <span class="font-bold text-gray-800">{{ $story->author->name }}</span>
                    </div>
                @endif
                <span class="text-gray-300">•</span>
                <span class="font-mono text-gray-500">{{ $story->reading_time ?: '7 min read' }}</span>
                @if($story->published_at)
                    <span class="text-gray-300">•</span>
                    <span>{{ $story->published_at->format('d F Y') }}</span>
                @endif
                <span class="text-gray-300">•</span>
                <span class="px-2 py-0.5 rounded bg-gray-100 text-[10px] font-mono font-semibold uppercase text-gray-600">Dokumen Eksekutif</span>
            </div>
        </header>

        {{-- Excerpt / Executive Summary Highlight --}}
        @if($story->excerpt)
            <div class="p-6 sm:p-7 rounded-2xl bg-white border border-gray-200/90 shadow-sm border-l-4 border-l-[#004741] text-gray-700 text-sm sm:text-base mb-10 leading-relaxed font-sans">
                <span class="text-[10px] font-bold text-[#004741] uppercase tracking-wider block mb-1">Ringkasan Eksekutif (Executive Summary)</span>
                {{ $story->excerpt }}
            </div>
        @endif

        {{-- Main Reading Body with Rich Media Styling --}}
        <div 
            class="leading-relaxed text-gray-800 prose prose-slate max-w-none space-y-6 monograph-content"
            :class="{
                'text-sm sm:text-base leading-relaxed': fontSize === 'sm',
                'text-base sm:text-lg leading-[1.8]': fontSize === 'base',
                'text-lg sm:text-xl leading-[1.9]': fontSize === 'lg',
                'font-serif': fontFamily === 'serif',
                'font-sans font-light': fontFamily === 'sans'
            }"
        >
            {!! $story->content_html !!}
        </div>

        {{-- Executive Monograph Finisher Ornament --}}
        <div class="text-center my-16 select-none flex items-center justify-center gap-3">
            <span class="w-12 h-px bg-gray-300"></span>
            <span class="w-2 h-2 rounded-full bg-[#005952]"></span>
            <span class="w-12 h-px bg-gray-300"></span>
        </div>

        {{-- Author Signature Card --}}
        @if($story->author)
            <div class="bg-white rounded-3xl border border-gray-200/80 p-6 sm:p-8 mb-16 font-sans flex flex-col sm:flex-row items-center gap-6 shadow-sm">
                <div class="w-20 h-20 rounded-2xl overflow-hidden bg-gray-900 shrink-0 shadow-md">
                    @if($story->author->photo)
                        <img src="{{ asset($story->author->photo) }}" alt="{{ $story->author->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center font-bold text-white text-2xl">
                            {{ substr($story->author->name, 0, 1) }}
                        </div>
                    @endif
                </div>
                <div class="text-center sm:text-left min-w-0 flex-1">
                    <span class="text-[11px] font-bold tracking-wider text-[#005952] uppercase block" x-text="$store.lang.t('PENULIS / PENDIRI EKOSISTEM', 'MANIFESTO AUTHOR / FOUNDER')">
                        PENULIS / PENDIRI EKOSISTEM
                    </span>
                    <h4 class="text-lg font-bold text-gray-950">{{ $story->author->name }}</h4>
                    <p class="text-xs text-gray-500 mb-2">{{ $story->author->role_id }}</p>
                    <p class="text-xs text-gray-600 font-light line-clamp-2">{{ $story->author->bio_id }}</p>
                </div>
                <div class="shrink-0">
                    <a href="{{ route('public.people.founder.show', $story->author->slug) }}" class="px-4 py-2 rounded-full border border-gray-300 text-xs font-bold text-gray-700 hover:border-[#005952] hover:text-[#005952] transition-colors">
                        <span x-text="$store.lang.t('Lihat Profil Pendiri', 'View Founder Profile')">Lihat Profil Pendiri</span> →
                    </a>
                </div>
            </div>
        @endif

        {{-- Navigation Between Chapters (Previous / Next) --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 font-sans pt-8 border-t border-gray-200">
            @if($prevStory)
                <a 
                    href="{{ route('public.people.storyfounder.show', $prevStory->slug) }}" 
                    class="p-5 rounded-2xl bg-white border border-gray-200/80 hover:border-[#005952] hover:shadow-md transition-all group"
                >
                    <span class="text-[10px] font-mono uppercase tracking-wider text-gray-400 block mb-1">
                        ← <span x-text="$store.lang.t('MANIFES SEBELUMNYA', 'PREVIOUS MANIFESTO')">MANIFES SEBELUMNYA</span>
                    </span>
                    <h5 class="text-sm font-bold text-gray-900 group-hover:text-[#005952] transition-colors line-clamp-1">
                        {{ $prevStory->title }}
                    </h5>
                </a>
            @else
                <div></div>
            @endif

            @if($nextStory)
                <a 
                    href="{{ route('public.people.storyfounder.show', $nextStory->slug) }}" 
                    class="p-5 rounded-2xl bg-white border border-gray-200/80 hover:border-[#005952] hover:shadow-md transition-all text-right group"
                >
                    <span class="text-[10px] font-mono uppercase tracking-wider text-gray-400 block mb-1">
                        <span x-text="$store.lang.t('MANIFES BERIKUTNYA', 'NEXT MANIFESTO')">MANIFES BERIKUTNYA</span> →
                    </span>
                    <h5 class="text-sm font-bold text-gray-900 group-hover:text-[#005952] transition-colors line-clamp-1">
                        {{ $nextStory->title }}
                    </h5>
                </a>
            @endif
        </div>

    </article>

</div>
@endsection
