@extends('public.layouts.app')

@section('meta')
    @php
        $shareImage = $article->share_image_url;
        $cleanDesc = $article->meta_description ?: ($article->excerpt ?: Str::limit(strip_tags($article->content), 160));
        $canonical = $article->canonical_url ?: url()->current();
    @endphp
    {{-- Dynamic SEO Meta Tags --}}
    <title>{{ $article->meta_title ?: $article->title . ' | PT Yota Inovasi Nusantara (YOIN)' }}</title>
    <meta name="description" content="{{ $cleanDesc }}">
    <meta name="keywords" content="{{ $article->meta_keywords ?: 'YOIN, PT Yota Inovasi Nusantara, digital, jasa website, software house, transformasi digital, ' . ($article->tag ?? 'teknologi') }}">
    <meta name="author" content="{{ $article->author_name ?: 'PT Yota Inovasi Nusantara' }}">
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    <meta name="thumbnail" content="{{ $shareImage }}">
    <meta name="image" content="{{ $shareImage }}">
    <link rel="canonical" href="{{ $canonical }}">

    {{-- Hreflang Multi-Language --}}
    <link rel="alternate" hreflang="id" href="{{ url()->current() }}">
    <link rel="alternate" hreflang="en" href="{{ url()->current() }}">
    <link rel="alternate" hreflang="x-default" href="{{ url()->current() }}">

    {{-- Open Graph / WhatsApp / Facebook Preview --}}
    <meta property="og:site_name" content="PT Yota Inovasi Nusantara (YOIN)">
    <meta property="og:type" content="article">
    <meta property="og:url" content="{{ $canonical }}">
    <meta property="og:title" content="{{ $article->meta_title ?: $article->title }}">
    <meta property="og:description" content="{{ $cleanDesc }}">
    <meta property="og:image" content="{{ $shareImage }}">
    <meta property="og:image:secure_url" content="{{ $shareImage }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:type" content="image/jpeg">
    <meta property="og:image:alt" content="{{ $article->title }}">
    <meta property="og:locale" content="id_ID">
    <meta property="og:locale:alternate" content="en_US">
    <meta property="article:published_time" content="{{ $article->published_at ? $article->published_at->toIso8601String() : now()->toIso8601String() }}">
    <meta property="article:modified_time" content="{{ $article->updated_at->toIso8601String() }}">
    <meta property="article:section" content="{{ $article->type }}">
    <meta property="article:tag" content="{{ $article->tag }}">

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $article->meta_title ?: $article->title }}">
    <meta name="twitter:description" content="{{ $cleanDesc }}">
    <meta name="twitter:image" content="{{ $shareImage }}">
    <meta name="twitter:image:alt" content="{{ $article->title }}">

    {{-- Schema.org Article JSON-LD with ImageObject --}}
    <script type="application/ld+json">
    {!! json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'Article',
        'mainEntityOfPage' => [
            '@type' => 'WebPage',
            '@id' => $canonical,
        ],
        'headline' => $article->title,
        'image' => [
            '@type' => 'ImageObject',
            'url' => $shareImage,
            'width' => 1200,
            'height' => 630,
        ],
        'datePublished' => $article->published_at ? $article->published_at->toIso8601String() : now()->toIso8601String(),
        'dateModified' => $article->updated_at->toIso8601String(),
        'author' => [
            '@type' => 'Organization',
            'name' => $article->author_name ?: 'PT Yota Inovasi Nusantara',
            'url' => url('/'),
        ],
        'publisher' => [
            '@type' => 'Organization',
            'name' => 'PT Yota Inovasi Nusantara',
            'url' => url('/'),
            'logo' => [
                '@type' => 'ImageObject',
                'url' => asset('logo.png'),
            ],
        ],
        'description' => $cleanDesc,
        'keywords' => $article->meta_keywords ?: 'YOTA, YOIN, PT Yota Inovasi Nusantara, digital, jasa website, ' . ($article->tag ?? 'teknologi'),
    ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>

    {{-- Quill Public Render Styles --}}
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />
    <style>
        /* Editorial Typography & Quill Public Render */
        .article-prose-content.ql-editor {
            padding: 0 !important;
            overflow-y: visible !important;
            font-size: 1.0625rem;
            line-height: 1.85;
            color: #1e293b;
        }
        .article-prose-content p {
            margin-bottom: 1.5rem !important;
            line-height: 1.85 !important;
            color: #334155 !important;
            font-size: 1.0625rem !important;
        }
        .article-prose-content h1,
        .article-prose-content h2,
        .article-prose-content h3,
        .article-prose-content h4 {
            color: #0f172a !important;
            font-weight: 800 !important;
            letter-spacing: -0.025em !important;
            line-height: 1.25 !important;
        }
        .article-prose-content h1 { font-size: 2.25rem !important; margin-top: 2.75rem !important; margin-bottom: 1.25rem !important; }
        .article-prose-content h2 { font-size: 1.75rem !important; margin-top: 2.5rem !important; margin-bottom: 1rem !important; }
        .article-prose-content h3 { font-size: 1.35rem !important; margin-top: 2rem !important; margin-bottom: 0.75rem !important; }
        .article-prose-content h4 { font-size: 1.15rem !important; margin-top: 1.75rem !important; margin-bottom: 0.5rem !important; }

        .article-prose-content a {
            color: #005952 !important;
            font-weight: 600 !important;
            text-decoration: underline !important;
            text-underline-offset: 3px !important;
        }
        .article-prose-content a:hover {
            color: #004741 !important;
        }

        .article-prose-content blockquote {
            border-left: 4px solid #005952 !important;
            background: #f0fdfa !important;
            padding: 1.25rem 1.5rem !important;
            border-radius: 0 1rem 1rem 0 !important;
            margin: 2.25rem 0 !important;
            font-style: italic !important;
            color: #134e4a !important;
        }

        .article-prose-content ul:not([data-checked]) {
            list-style-type: disc !important;
            padding-left: 1.5rem !important;
            margin-bottom: 1.5rem !important;
        }
        .article-prose-content ol {
            list-style-type: decimal !important;
            padding-left: 1.5rem !important;
            margin-bottom: 1.5rem !important;
        }
        .article-prose-content li {
            margin-bottom: 0.5rem !important;
            line-height: 1.75 !important;
            color: #334155 !important;
        }

        .article-prose-content .ql-align-center { text-align: center; }
        .article-prose-content .ql-align-right { text-align: right; }
        .article-prose-content .ql-align-justify { text-align: justify; text-justify: inter-word; }
        .article-prose-content .ql-size-small { font-size: 0.85em; }
        .article-prose-content .ql-size-large { font-size: 1.35em; font-weight: 600; }
        .article-prose-content .ql-size-huge { font-size: 1.85em; font-weight: 700; line-height: 1.3; }
        .article-prose-content .ql-font-serif { font-family: Georgia, Cambria, "Times New Roman", Times, serif; }
        .article-prose-content .ql-font-monospace { font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace; }

        /* Responsive Video Embeds (YouTube / Vimeo) */
        .article-prose-content iframe.ql-video,
        .article-prose-content iframe[src*="youtube"],
        .article-prose-content iframe[src*="vimeo"] {
            width: 100% !important;
            aspect-ratio: 16 / 9 !important;
            min-height: 280px;
            border-radius: 1.25rem !important;
            margin: 2.25rem 0 !important;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1) !important;
            display: block !important;
        }
        @media (min-width: 640px) {
            .article-prose-content iframe.ql-video,
            .article-prose-content iframe[src*="youtube"],
            .article-prose-content iframe[src*="vimeo"] {
                min-height: 440px;
            }
        }

        /* Responsive Images */
        .article-prose-content img {
            border-radius: 1.25rem !important;
            box-shadow: 0 6px 20px -4px rgba(0, 0, 0, 0.08) !important;
            margin: 2.25rem auto !important;
            display: block !important;
            max-width: 100% !important;
            height: auto !important;
        }
        .article-prose-content .ql-align-center img { margin-left: auto !important; margin-right: auto !important; }
        .article-prose-content .ql-align-right img { margin-left: auto !important; margin-right: 0 !important; }
        .article-prose-content .ql-align-left img { margin-left: 0 !important; margin-right: auto !important; }

        /* Horizontal Divider */
        .article-prose-content hr {
            border: 0;
            border-top: 1.5px dashed #cbd5e1;
            margin: 3rem 0;
        }

        /* Checklists */
        .article-prose-content ul[data-checked=true],
        .article-prose-content ul[data-checked=false],
        .article-prose-content li[data-list=checked],
        .article-prose-content li[data-list=unchecked] {
            list-style-type: none !important;
            position: relative;
            padding-left: 1.75rem !important;
        }
        .article-prose-content li[data-list=checked]::before {
            content: "✓";
            position: absolute;
            left: 0;
            top: 0;
            color: #005952;
            font-weight: 900;
        }
        .article-prose-content li[data-list=unchecked]::before {
            content: "○";
            position: absolute;
            left: 0;
            top: 0;
            color: #94a3b8;
            font-weight: bold;
        }
    </style>
@endsection

@section('content')
<article class="bg-white pt-28 sm:pt-36 pb-20 select-none font-sans min-h-screen">
    
    {{-- 1. BREADCRUMBS & TOP NAV --}}
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 mb-6">
        <nav class="flex items-center gap-2 text-xs text-gray-500">
            <a href="{{ url('/') }}" class="hover:text-[#005952] transition-colors" x-text="$store.lang.t('Beranda', 'Home')">Beranda</a>
            <span>/</span>
            <a href="{{ route('public.articles.index') }}" class="hover:text-[#005952] transition-colors" x-text="$store.lang.t('Publikasi & Riset', 'Publications & Research')">Publikasi & Riset</a>
            <span>/</span>
            <span class="text-gray-800 font-semibold truncate max-w-xs" x-text="$store.lang.isEN() ? '{{ addslashes($article->title_en ?: $article->title) }}' : '{{ addslashes($article->title) }}'">{{ $article->title }}</span>
        </nav>
    </div>

    {{-- 2. ARTICLE HEADER (Editorial Style) --}}
    <header class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-left">
        
        {{-- Tags & Category --}}
        <div class="flex flex-wrap items-center gap-2.5 mb-4">
            <span class="px-3 py-1 rounded-full text-[10px] font-bold tracking-wider uppercase bg-[#004741] text-white">
                {{ $article->type }}
            </span>
            @if($article->tag || $article->tag_en)
                <span class="px-3 py-1 rounded-full text-[10px] font-bold tracking-wider uppercase bg-slate-100 border border-slate-300 text-slate-800">
                    <span x-text="$store.lang.isEN() ? '{{ addslashes($article->tag_en ?: $article->tag) }}' : '{{ addslashes($article->tag) }}'">{{ $article->tag }}</span>
                </span>
            @endif
            @if($article->badge || $article->badge_en)
                <span class="px-3 py-1 rounded-full text-[10px] font-semibold bg-slate-100 border border-slate-200 text-slate-700">
                    <span x-text="$store.lang.isEN() ? '{{ addslashes($article->badge_en ?: $article->badge) }}' : '{{ addslashes($article->badge) }}'">{{ $article->badge }}</span>
                </span>
            @endif
        </div>

        {{-- Main Article Title --}}
        <h1 class="text-2xl sm:text-4xl lg:text-5xl font-black text-gray-950 tracking-tight leading-[1.18] font-sans">
            <span x-text="$store.lang.isEN() ? '{{ addslashes($article->title_en ?: $article->title) }}' : '{{ addslashes($article->title) }}'">{{ $article->title }}</span>
        </h1>

        {{-- Excerpt Subtitle --}}
        @if($article->excerpt || $article->excerpt_en)
            <p class="mt-4 sm:mt-5 text-base sm:text-lg lg:text-xl text-gray-600 leading-relaxed font-normal">
                <span x-text="$store.lang.isEN() ? '{{ addslashes($article->excerpt_en ?: $article->excerpt) }}' : '{{ addslashes($article->excerpt) }}'">{{ $article->excerpt }}</span>
            </p>
        @endif

        {{-- Author, Date & Live View Counters Bar --}}
        <div class="mt-6 pt-5 pb-6 border-y border-gray-200 flex flex-wrap items-center justify-between gap-4 text-xs text-gray-600">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-[#004741] text-white flex items-center justify-center font-bold text-xs shrink-0 shadow-xs">
                    {{ strtoupper(substr($article->author_name, 0, 2)) }}
                </div>
                <div>
                    <span class="font-bold text-gray-900 block">{{ $article->author_name }}</span>
                    <span class="text-[11px] text-gray-500">
                        {{ $article->published_at ? $article->published_at->format('d F Y') : now()->format('d F Y') }}
                    </span>
                </div>
            </div>

            <div class="flex items-center gap-4 text-xs font-medium">
                {{-- Reading Time --}}
                <div class="flex items-center gap-1.5 text-gray-600">
                    <svg class="w-4 h-4 text-[#004741]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>{{ $article->reading_time }}</span>
                    <span x-text="$store.lang.t('menit baca', 'min read')">menit baca</span>
                </div>

                {{-- Views Counter --}}
                <div class="flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-100 border border-slate-200 text-slate-800 font-bold">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    <span>{{ number_format($article->views_count) }}</span>
                    <span class="font-normal" x-text="$store.lang.t('kali dibaca', 'reads')">kali dibaca</span>
                </div>
            </div>
        </div>

    </header>

    {{-- 3. COVER HERO IMAGE --}}
    @if($article->cover_image)
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 my-8 sm:my-10">
            <div class="relative w-full rounded-2xl sm:rounded-3xl overflow-hidden bg-gray-100 aspect-[16/9] max-h-[520px]">
                <img 
                    src="{{ $article->cover_image }}" 
                    alt="{{ $article->title }}" 
                    class="w-full h-full object-cover object-center"
                >
            </div>
        </div>
    @endif

    {{-- 4. ARTICLE BODY CONTENT (Seamless Editorial Flow with Instant Language Toggle) --}}
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-left">
        <div class="article-prose-content ql-editor max-w-none text-gray-800 leading-relaxed font-normal">
            <div x-show="$store.lang.isID()">
                {!! $article->content !!}
            </div>
            <div x-show="$store.lang.isEN()" x-cloak>
                {!! $article->content_en ?: $article->content !!}
            </div>
        </div>

        {{-- 5. SOCIAL SHARE BUTTONS BAR --}}
        <div 
            x-data="{ copied: false, shareUrl: '{{ url()->current() }}' }" 
            class="mt-14 pt-8 border-t border-gray-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4"
        >
            <div class="text-xs font-bold uppercase tracking-wider text-gray-700" x-text="$store.lang.t('Bagikan Publikasi Ini:', 'Share this publication:')">
                Bagikan Publikasi Ini:
            </div>

            <div class="flex items-center flex-wrap gap-2.5">
                {{-- WhatsApp --}}
                <a 
                    href="https://api.whatsapp.com/send?text={{ urlencode($article->title.' '.url()->current()) }}" 
                    target="_blank" 
                    rel="noopener"
                    class="px-3.5 py-2 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-800 text-xs font-semibold flex items-center gap-1.5 transition-colors border border-slate-300"
                    title="Bagikan ke WhatsApp"
                >
                    <span>WhatsApp</span>
                </a>

                {{-- LinkedIn --}}
                <a 
                    href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}" 
                    target="_blank" 
                    rel="noopener"
                    class="px-3.5 py-2 rounded-full bg-blue-50 hover:bg-blue-100 text-blue-700 text-xs font-semibold flex items-center gap-1.5 transition-colors border border-blue-200"
                    title="Bagikan ke LinkedIn"
                >
                    <span>LinkedIn</span>
                </a>

                {{-- X / Twitter --}}
                <a 
                    href="https://twitter.com/intent/tweet?text={{ urlencode($article->title) }}&url={{ urlencode(url()->current()) }}" 
                    target="_blank" 
                    rel="noopener"
                    class="px-3.5 py-2 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-800 text-xs font-semibold flex items-center gap-1.5 transition-colors border border-gray-300"
                    title="Bagikan ke X"
                >
                    <span>X (Twitter)</span>
                </a>

                {{-- Copy Link Button --}}
                <button 
                    @click="navigator.clipboard.writeText(shareUrl); copied = true; setTimeout(() => copied = false, 2500);" 
                    type="button" 
                    class="px-4 py-2 rounded-full bg-white hover:bg-gray-50 text-gray-800 text-xs font-semibold flex items-center gap-1.5 transition-colors border border-gray-300 shadow-xs cursor-pointer"
                >
                    <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/></svg>
                    <span x-text="copied ? $store.lang.t('Tautan Disalin!', 'Link Copied!') : $store.lang.t('Salin Tautan', 'Copy Link')">Salin Tautan</span>
                </button>
            </div>
        </div>
    </div>


    {{-- 6. RELATED PUBLICATIONS SECTION --}}
    @if($relatedArticles->isNotEmpty())
        <section class="w-full bg-[#F8FAFA] border-t border-gray-100 mt-20 py-16 sm:py-20 text-left">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between mb-8 border-b border-gray-200 pb-4">
                    <div>
                        <span class="text-xs font-bold tracking-widest text-[#005952] uppercase block" x-text="$store.lang.t('EKSPLORASI LANJUTAN', 'FURTHER EXPLORATION')">EKSPLORASI LANJUTAN</span>
                        <h3 class="text-xl sm:text-2xl font-extrabold text-gray-900 mt-1" x-text="$store.lang.t('Publikasi & Inisiatif Terkait', 'Related Publications & Initiatives')">
                            Publikasi & Inisiatif Terkait
                        </h3>
                    </div>
                    <a 
                        href="{{ route('public.articles.index') }}" 
                        class="text-xs font-bold text-[#005952] hover:underline flex items-center gap-1"
                    >
                        <span x-text="$store.lang.t('Lihat Semua Terbitan', 'View All Publications')">Lihat Semua Terbitan</span>
                        <span>→</span>
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($relatedArticles as $rel)
                        <article class="flex flex-col justify-between bg-white rounded-2xl border border-gray-200 shadow-xs hover:shadow-lg transition-all duration-300 hover:-translate-y-1 overflow-hidden group">
                            <div>
                                {{-- Image Cover --}}
                                <div class="relative h-44 w-full overflow-hidden bg-gray-900">
                                    @if($rel->cover_image)
                                        <img 
                                            src="{{ $rel->cover_image }}" 
                                            alt="{{ $rel->title }}" 
                                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 filter brightness-95"
                                        >
                                    @else
                                        <div class="w-full h-full bg-[#004741] flex items-center justify-center text-white font-black text-lg">
                                            YOIN
                                        </div>
                                    @endif
                                    <div class="absolute top-3 left-3">
                                        <span class="px-2.5 py-0.5 rounded-md bg-white/95 backdrop-blur-md text-[10px] font-bold text-gray-800 uppercase tracking-wider">
                                            {{ $rel->type }}
                                        </span>
                                    </div>
                                </div>

                                {{-- Card Body --}}
                                <div class="p-5">
                                    <span class="text-[10px] font-semibold text-[#004741] uppercase tracking-wider block mb-1">
                                        <span x-text="$store.lang.isEN() ? '{{ addslashes($rel->tag_en ?: ($rel->tag ?: 'YOIN Research')) }}' : '{{ addslashes($rel->tag ?: 'Riset YOIN') }}'">{{ $rel->tag ?: 'Riset YOIN' }}</span>
                                    </span>
                                    <h4 class="text-sm font-bold text-gray-900 group-hover:text-[#004741] line-clamp-2 leading-snug">
                                        <a href="{{ route('public.articles.show', $rel->slug) }}">
                                            <span x-text="$store.lang.isEN() ? '{{ addslashes($rel->title_en ?: $rel->title) }}' : '{{ addslashes($rel->title) }}'">{{ $rel->title }}</span>
                                        </a>
                                    </h4>
                                    <p class="text-xs text-gray-500 line-clamp-2 mt-2 leading-relaxed">
                                        <span x-text="$store.lang.isEN() ? '{{ addslashes($rel->excerpt_en ?: ($rel->excerpt ?: Str::limit(strip_tags($rel->content), 90))) }}' : '{{ addslashes($rel->excerpt ?: Str::limit(strip_tags($rel->content), 90)) }}'">{{ $rel->excerpt ?: Str::limit(strip_tags($rel->content), 90) }}</span>
                                    </p>
                                </div>
                            </div>

                            {{-- Footer --}}
                            <div class="px-5 pb-5 pt-1 border-t border-gray-50 flex items-center justify-between text-[11px] text-gray-400">
                                <span>{{ $rel->reading_time }} min</span>
                                <span class="font-bold text-[#005952] group-hover:underline flex items-center gap-1">
                                    <span x-text="$store.lang.t('Baca Selengkapnya', 'Read Full')">Baca</span> →
                                </span>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

</article>
@endsection
