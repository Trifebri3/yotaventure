<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @hasSection('meta')
        @yield('meta')
    @else
        <title>{{ $title ?? 'PT Yota Inovasi Nusantara (YOIN) | Transformasi Digital, Jasa Website & Ekosistem Teknologi' }}</title>
        <meta name="description" content="{{ $metaDescription ?? 'PT Yota Inovasi Nusantara (YOIN) adalah holding inovasi, software house & venture builder. Melayani jasa website profesional, transformasi digital, sovereign cloud, dan ekosistem teknologi Indonesia.' }}">
        <meta name="keywords" content="{{ $metaKeywords ?? 'YOIN, PT Yota Inovasi Nusantara, digital, jasa website, jasa pembuatan website, software house, transformasi digital, konsultan IT, sistem informasi enterprise, sovereign cloud, AI lab, venture builder indonesia' }}">
        <meta name="author" content="PT Yota Inovasi Nusantara">
        <meta name="robots" content="{{ $metaRobots ?? 'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1' }}">
        <meta name="thumbnail" content="{{ $metaImage ?? asset('logo.png') }}">
        <meta name="image" content="{{ $metaImage ?? asset('logo.png') }}">
        <link rel="canonical" href="{{ $canonicalUrl ?? url()->current() }}">

        {{-- Hreflang Multi-Language --}}
        <link rel="alternate" hreflang="id" href="{{ url()->current() }}">
        <link rel="alternate" hreflang="en" href="{{ url()->current() }}">
        <link rel="alternate" hreflang="x-default" href="{{ url()->current() }}">

        {{-- Open Graph / Facebook / WhatsApp Preview --}}
        <meta property="og:site_name" content="PT Yota Inovasi Nusantara (YOIN)">
        <meta property="og:type" content="{{ $ogType ?? 'website' }}">
        <meta property="og:title" content="{{ $metaTitle ?? ($title ?? 'PT Yota Inovasi Nusantara (YOIN) | Transformasi Digital, Jasa Website & Ekosistem Teknologi') }}">
        <meta property="og:description" content="{{ $metaDescription ?? 'PT Yota Inovasi Nusantara (YOIN) adalah holding inovasi, software house & venture builder. Melayani jasa website profesional, transformasi digital, sovereign cloud, dan ekosistem teknologi Indonesia.' }}">
        <meta property="og:url" content="{{ $canonicalUrl ?? url()->current() }}">
        <meta property="og:image" content="{{ $metaImage ?? asset('logo.png') }}">
        <meta property="og:image:secure_url" content="{{ $metaImage ?? asset('logo.png') }}">
        <meta property="og:image:width" content="1200">
        <meta property="og:image:height" content="630">
        <meta property="og:image:type" content="image/png">
        <meta property="og:image:alt" content="{{ $metaTitle ?? 'PT Yota Inovasi Nusantara (YOIN) - Solusi Digital & Jasa Website' }}">
        <meta property="og:locale" content="id_ID">
        <meta property="og:locale:alternate" content="en_US">

        {{-- Twitter Card --}}
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="{{ $metaTitle ?? ($title ?? 'PT Yota Inovasi Nusantara (YOIN)') }}">
        <meta name="twitter:description" content="{{ $metaDescription ?? 'Holding inovasi, software house, jasa website & venture builder teknologi multisektoral terdepan di Indonesia.' }}">
        <meta name="twitter:image" content="{{ $metaImage ?? asset('logo.png') }}">

        {{-- Schema.org Global JSON-LD --}}
        <script type="application/ld+json">
        {!! json_encode([
            '@context' => 'https://schema.org',
            '@graph' => [
                [
                    '@type' => 'Organization',
                    '@id' => url('/#organization'),
                    'name' => 'PT Yota Inovasi Nusantara',
                    'alternateName' => 'YOIN',
                    'url' => url('/'),
                    'logo' => [
                        '@type' => 'ImageObject',
                        '@id' => url('/#logo'),
                        'url' => asset('logo.png'),
                        'caption' => 'PT Yota Inovasi Nusantara (YOIN)',
                    ],
                    'description' => 'Holding inovasi, software house, penyedia jasa website profesional, sovereign cloud, dan venture builder teknologi multisektoral di Indonesia.',
                    'slogan' => 'The House Behind What We Build',
                    'knowsAbout' => [
                        'Jasa Website & Aplikasi Web',
                        'Transformasi Digital',
                        'Software House & IT Consultant',
                        'Cloud Computing & Sovereign Infrastructure',
                        'Artificial Intelligence (AI)',
                        'Venture Building',
                    ],
                    'address' => [
                        '@type' => 'PostalAddress',
                        'addressCountry' => 'ID',
                    ],
                    'contactPoint' => [
                        [
                            '@type' => 'ContactPoint',
                            'email' => 'hello@yotainovasi.id',
                            'contactType' => 'customer support',
                        ],
                        [
                            '@type' => 'ContactPoint',
                            'email' => 'legal@yotainovasi.id',
                            'contactType' => 'legal',
                        ],
                        [
                            '@type' => 'ContactPoint',
                            'email' => 'dpo@yotainovasi.id',
                            'contactType' => 'data protection officer',
                        ],
                    ],
                ],
                [
                    '@type' => 'WebSite',
                    '@id' => url('/#website'),
                    'url' => url('/'),
                    'name' => 'YOIN - PT Yota Inovasi Nusantara',
                    'publisher' => [
                        '@id' => url('/#organization'),
                    ],
                    'potentialAction' => [
                        '@type' => 'SearchAction',
                        'target' => [
                            '@type' => 'EntryPoint',
                            'urlTemplate' => url('/publikasi') . '?q={search_term_string}',
                        ],
                        'query-input' => 'required name=search_term_string',
                    ],
                ],
            ],
        ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
        </script>
    @endif

    @stack('meta')

    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Styles & Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] { display: none !important; }
        body {
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
        }
    </style>
</head>
<body class="bg-white text-gray-900 antialiased selection:bg-[#005952] selection:text-white">
    
    {{-- Header --}}
    @include('public.layouts.header')

    {{-- Main Content --}}
    <main class="min-h-screen">
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('public.layouts.footer')

</body>
</html>
