{{-- 
    YOIN Hero Section
    Desain: Full-Bleed Background Foto (public/foto/hero.png) dengan Overlay Gradasi Sinematik
    Responsif: Posisi foto digeser ke kiri (Laptop, iPad & HP), tulisan di HP proporsional & lebih kecil.
    Transisi: Terhubung mulus ('nyambung') langsung ke Inisiatif Unggulan Full-Screen di bawahnya.
--}}
<section class="relative min-h-[92vh] sm:min-h-screen flex items-center justify-center overflow-hidden bg-[#030d0c] select-none">
    
    {{-- Full Background Image: Presenter di sisi kanan/tengah-kanan agar TIDAK TABRAKAN dengan teks di sisi kiri --}}
    <img 
        src="{{ asset('foto/hero.png') }}" 
        alt="YOIN Keynote Presenter" 
        class="absolute inset-0 w-full h-full object-cover object-[50%_15%] sm:object-[40%_center] md:object-[44%_center] lg:object-[34%_center] xl:object-[38%_center] opacity-95 transition-all duration-700"
    >

    {{-- Gradient Overlays: Dark fade for high contrast readability without drowning the presenter --}}
    <div class="absolute inset-0 bg-gradient-to-t from-[#021312] via-[#021312]/45 to-transparent sm:bg-none z-10"></div>
    <div class="absolute inset-0 bg-gradient-to-r from-[#021312]/92 via-[#021312]/65 sm:via-[#021312]/50 to-transparent z-10"></div>
    
    {{-- Top Vignette to protect Header readability --}}
    <div class="absolute inset-x-0 top-0 h-32 sm:h-40 bg-gradient-to-b from-[#021312]/80 via-[#021312]/35 to-transparent z-10"></div>

    {{-- Soft Ambient Glow Accent --}}
    <div class="absolute top-1/3 left-10 w-72 sm:w-96 h-72 sm:h-96 bg-[#005952]/20 rounded-full blur-3xl pointer-events-none z-10"></div>

    {{-- Delicate Curved Orbit Lines --}}
    <div class="absolute inset-0 pointer-events-none z-10 overflow-hidden opacity-20">
        <svg class="w-full h-full" viewBox="0 0 1440 900" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
            <path d="M 400 180 C 600 120, 850 160, 1100 240" stroke="white" stroke-opacity="0.3" stroke-width="1.2" stroke-dasharray="6 6" />
            <path d="M 350 480 C 650 380, 950 440, 1250 560" stroke="white" stroke-opacity="0.2" stroke-width="1.2" />
            <circle cx="850" cy="160" r="4" fill="white" opacity="0.6" />
        </svg>
    </div>

    {{-- Main Hero Content Container --}}
    <div class="relative z-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full pt-28 sm:pt-36 pb-16 sm:pb-24">
        <div class="max-w-xs sm:max-w-sm md:max-w-md lg:max-w-xl xl:max-w-2xl text-left">
            
            {{-- Main Headline: Ukuran teks proporsional & rapi di setiap layar tanpa tabrakan --}}
            <h1 class="text-2xl sm:text-3xl md:text-[34px] lg:text-[54px] xl:text-[64px] font-black text-white tracking-tight leading-[1.12] sm:leading-[1.05] font-sans">
                THE HOUSE<br>
                BEHIND<br>
                <span class="text-white drop-shadow-md">WHAT WE BUILD.</span>
            </h1>

            {{-- Subtitle Description --}}
            <p 
                class="mt-3 sm:mt-6 text-xs sm:text-sm md:text-base text-white/90 max-w-[290px] sm:max-w-lg font-normal leading-relaxed"
                x-text="$store.lang.t('YOIN adalah rumah bersama bagi ide, inovasi, dan talenta yang membangun masa depan Indonesia dan dunia.', 'YOIN is a home for ideas, innovations, and people building what comes next.')"
            >
                YOIN adalah rumah bersama bagi ide, inovasi, dan talenta yang membangun masa depan Indonesia dan dunia.
            </p>

            {{-- The Two Pill Buttons --}}
            <div class="mt-5 sm:mt-8 flex flex-wrap items-center gap-2.5 sm:gap-4">
                {{-- Primary Pill Button --}}
                <a 
                    href="#inisiatif-unggulan" 
                    class="inline-flex items-center gap-2 px-4 sm:px-7 py-2 sm:py-3.5 bg-[#004741] hover:bg-black text-white font-bold text-xs sm:text-sm tracking-wide rounded-full shadow-lg shadow-black/40 transition-all duration-300 hover:scale-[1.02] border border-white/20"
                >
                    <span x-text="$store.lang.t('Jelajahi Ekosistem', 'Explore the Ecosystem')">Explore the Ecosystem</span>
                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </a>

                {{-- Secondary Outline Pill Button --}}
                <a 
                    href="#inisiatif-unggulan" 
                    class="inline-flex items-center justify-center px-4 sm:px-7 py-2 sm:py-3.5 border border-white/60 hover:border-white text-white hover:bg-white/10 font-bold text-xs sm:text-sm tracking-wide rounded-full backdrop-blur-sm transition-all duration-300"
                >
                    <span x-text="$store.lang.t('Lihat Inovasi Unggulan', 'See What We\'re Building')">See What We're Building</span>
                </a>
            </div>

        </div>
    </div>

    {{-- Seamless Transition directly to Full-Screen Initiatives Slider Below (No White Gap) --}}
    <div class="absolute inset-x-0 bottom-0 h-24 bg-gradient-to-b from-transparent to-[#021312] pointer-events-none z-20"></div>

</section>
