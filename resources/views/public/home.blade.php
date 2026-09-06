@extends('public.layouts.app')

@section('content')
    {{-- Hero Section & Brand Strip --}}
    @include('public.konten.secionhero')

    {{-- Featured Initiatives & Showcase Carousel (Foto dengan Judul, Keterangan, Tombol, Banyak Item) --}}
    @include('public.konten.section_featured_initiatives')

    {{-- Different worlds. One purpose. (Domain Showcase: Digital, Pendidikan, Dampak, dll) --}}
    @include('public.konten.section_domains')

    {{-- Interactive What is YOIN Planetary Explorer --}}
    @include('public.konten.section_what_is_yota')

    {{-- Some Are Already Building - Ecosystem Brands & Services Showcase --}}
    @include('public.konten.section_ecosystem_brands')

    {{-- The People Behind It - Built by People (Founder, Core Team, Contributors, Collaborators) --}}
    @include('public.konten.section_built_by_people')

    {{-- Trusted Partners & Commercial Clients Running Logo Marquee (100% Dynamic from Database, Controlled via Admin) --}}
    @include('public.konten.section_partners_clients')

    {{-- We're Not Done Yet - Grand CTA & Formulir Kontak Kolaborasi --}}
    @include('public.konten.section_were_not_done_yet')

@endsection
