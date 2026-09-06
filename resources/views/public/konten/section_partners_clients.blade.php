{{-- 
    YOIN Ecosystem Partners & Clients Marquee Showcase
    "LOGO MITRA YANG BERJALAN YA POKOKNYA SEMUA MITRA, TERUS ADA KLIENT, DAN DI KONTROL VIA ADMIN YA"
    100% Dinamis dari Database (EcosystemClient)
    Dikontrol via Admin: /admin/ecosystem?tab=clients
    Bilingual (ID & EN), Bebas Emotikon, Tanpa Kata Venture.
--}}
@php
    $allClients = \App\Models\EcosystemClient::where('is_active', true)
        ->orderBy('name')
        ->get();

    // Grouping for dual-track continuous marquee
    $track1Types = ['Mitra Strategis', 'Pemerintah & BUMN', 'Akademisi & Riset', 'Government'];
    $track2Types = ['Klien Komersial', 'Komunitas & NGO', 'Enterprise', 'Community', 'NGO', 'Internal'];

    $track1Clients = $allClients->filter(function ($c) use ($track1Types) {
        return in_array($c->client_type, $track1Types);
    })->values();

    $track2Clients = $allClients->filter(function ($c) use ($track2Types) {
        return in_array($c->client_type, $track2Types);
    })->values();

    // Fallbacks if one track is sparse
    if ($track1Clients->isEmpty()) {
        $track1Clients = $allClients;
    }
    if ($track2Clients->isEmpty()) {
        $track2Clients = $allClients;
    }

    $clientsJson = $allClients->map(function ($c) {
        return [
            'id' => $c->id,
            'name' => $c->name,
            'slug' => $c->slug,
            'logo_image' => $c->logo_image,
            'client_type' => $c->client_type,
            'industry' => $c->industry ?: 'Ekosistem Sinergi',
            'location' => $c->location ?: 'Indonesia',
            'website_url' => $c->website_url,
            'description_id' => $c->description_id ?: $c->name,
            'description_en' => $c->description_en ?: ($c->description_id ?: $c->name),
        ];
    })->values()->toArray();
@endphp

<section 
    id="partners-clients" 
    x-data="{
        activeCategory: 'all',
        clients: @js($clientsJson),
        modalItem: null,

        get filteredList() {
            if (this.activeCategory === 'all') return this.clients;
            return this.clients.filter(c => c.client_type === this.activeCategory);
        }
    }"
    class="relative w-full py-16 sm:py-24 bg-[#FAFCFC] border-t border-gray-200/80 overflow-hidden select-none"
>
    
    {{-- Decorative Background Elements --}}
    <div class="absolute inset-0 pointer-events-none opacity-25">
        <svg class="w-full h-full" viewBox="0 0 1440 600" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
            <defs>
                <pattern id="partnerDots" width="36" height="36" patternUnits="userSpaceOnUse">
                    <circle cx="18" cy="18" r="1" fill="#005952" opacity="0.2" />
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#partnerDots)" />
        </svg>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center mb-10 sm:mb-12">
        
        {{-- Section Subtitle & Title (Bilingual) --}}
        <div class="flex items-center justify-center gap-2 mb-2.5">
            <span class="w-2 h-0.5 bg-[#005952]"></span>
            <span class="text-xs sm:text-sm font-bold tracking-[0.24em] text-[#005952] uppercase font-sans" x-text="$store.lang.t('MITRA STRATEGIS & KLIEN TERPERCAYA', 'STRATEGIC PARTNERS & CLIENTS')">
                STRATEGIC PARTNERS & CLIENTS
            </span>
            <span class="w-2 h-0.5 bg-[#005952]"></span>
        </div>

        <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-gray-950 tracking-tight font-sans">
            <span x-text="$store.lang.t('Tumbuh bersama', 'Growing alongside')">Growing alongside</span> 
            <span class="text-[#005952]" x-text="$store.lang.t('jejaring sinergi terpadu.', 'an integrated network.')">an integrated network.</span>
        </h2>
        
        <p class="text-gray-600 mt-2.5 text-xs sm:text-sm max-w-2xl mx-auto leading-relaxed font-normal" x-text="$store.lang.t('Menghubungkan kementerian, badan usaha, lembaga riset terapan, dan komunitas rakyat dalam mewujudkan kemandirian nasional.', 'Connecting ministries, enterprises, applied research institutions, and grassroots communities to foster national self-reliance.')">
            Connecting ministries, enterprises, applied research institutions, and grassroots communities to foster national self-reliance.
        </p>

        {{-- Interactive Category Filter Pills --}}
        <div class="flex items-center justify-center flex-wrap gap-2 mt-6">
            <button 
                @click="activeCategory = 'all'"
                class="px-3.5 py-1.5 rounded-full text-xs font-bold tracking-wider uppercase transition-all duration-200 cursor-pointer"
                :class="activeCategory === 'all' ? 'bg-[#005952] text-white shadow-xs' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200'"
                x-text="$store.lang.t('Semua (' + clients.length + ')', 'All (' + clients.length + ')')"
            >
                Semua (12)
            </button>
            <button 
                @click="activeCategory = 'Mitra Strategis'"
                class="px-3.5 py-1.5 rounded-full text-xs font-bold tracking-wider uppercase transition-all duration-200 cursor-pointer"
                :class="activeCategory === 'Mitra Strategis' ? 'bg-[#005952] text-white shadow-xs' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200'"
                x-text="$store.lang.t('Mitra Strategis', 'Strategic Partners')"
            >
                Mitra Strategis
            </button>
            <button 
                @click="activeCategory = 'Pemerintah & BUMN'"
                class="px-3.5 py-1.5 rounded-full text-xs font-bold tracking-wider uppercase transition-all duration-200 cursor-pointer"
                :class="activeCategory === 'Pemerintah & BUMN' ? 'bg-[#005952] text-white shadow-xs' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200'"
                x-text="$store.lang.t('Pemerintah & BUMN', 'Government & SOE')"
            >
                Pemerintah & BUMN
            </button>
            <button 
                @click="activeCategory = 'Akademisi & Riset'"
                class="px-3.5 py-1.5 rounded-full text-xs font-bold tracking-wider uppercase transition-all duration-200 cursor-pointer"
                :class="activeCategory === 'Akademisi & Riset' ? 'bg-[#005952] text-white shadow-xs' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200'"
                x-text="$store.lang.t('Akademisi & Riset', 'Academia & Research')"
            >
                Akademisi & Riset
            </button>
            <button 
                @click="activeCategory = 'Klien Komersial'"
                class="px-3.5 py-1.5 rounded-full text-xs font-bold tracking-wider uppercase transition-all duration-200 cursor-pointer"
                :class="activeCategory === 'Klien Komersial' ? 'bg-[#005952] text-white shadow-xs' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200'"
                x-text="$store.lang.t('Klien Komersial', 'Commercial Clients')"
            >
                Klien Komersial
            </button>
            <button 
                @click="activeCategory = 'Komunitas & NGO'"
                class="px-3.5 py-1.5 rounded-full text-xs font-bold tracking-wider uppercase transition-all duration-200 cursor-pointer"
                :class="activeCategory === 'Komunitas & NGO' ? 'bg-[#005952] text-white shadow-xs' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200'"
                x-text="$store.lang.t('Komunitas & NGO', 'Community & NGO')"
            >
                Komunitas & NGO
            </button>
        </div>

        {{-- Admin Quick Control Badge (Visible to Logged-in Admins) --}}
        @auth
            <div class="mt-4">
                <a 
                    href="{{ route('admin.ecosystem.index', ['tab' => 'clients']) }}" 
                    class="inline-flex items-center gap-1.5 px-3 py-1 rounded-md bg-amber-50 border border-amber-200 text-amber-800 text-[11px] font-bold hover:bg-amber-100 transition-colors"
                >
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    <span>Kelola Mitra & Klien via Admin Panel ↗</span>
                </a>
            </div>
        @endauth

    </div>

    {{-- ========================================================================= --}}
    {{-- RUNNING TICKER CONTAINER (INFINITE CONTINUOUS MARQUEE)                     --}}
    {{-- ========================================================================= --}}
    <div class="relative w-full overflow-hidden py-2 space-y-4">
        
        {{-- Side Bleed Gradient Masks --}}
        <div class="pointer-events-none absolute inset-y-0 left-0 w-16 sm:w-28 lg:w-40 bg-gradient-to-r from-[#FAFCFC] to-transparent z-20"></div>
        <div class="pointer-events-none absolute inset-y-0 right-0 w-16 sm:w-28 lg:w-40 bg-gradient-to-l from-[#FAFCFC] to-transparent z-20"></div>

        {{-- MODE 1: WHEN ALL IS SELECTED -> DUAL RUNNING TRACKS (LEFT & RIGHT) --}}
        <div x-show="activeCategory === 'all'" class="space-y-4">
            
            {{-- TRACK 1: RUNNING LEFT (MITRA & PEMERINTAH & RISET) --}}
            <div class="marquee-track-container overflow-hidden whitespace-nowrap">
                <div class="marquee-track-left flex gap-4 w-max hover:[animation-play-state:paused]">
                    {{-- Loop twice for seamless infinite scroll --}}
                    @for($loopIndex = 0; $loopIndex < 2; $loopIndex++)
                        @foreach($track1Clients as $client)
                            <div 
                                @click="modalItem = {{ json_encode($client) }}"
                                class="inline-flex items-center gap-3.5 px-4 py-3 rounded-2xl bg-white border border-gray-200/90 shadow-2xs hover:shadow-lg hover:border-[#005952] hover:-translate-y-0.5 transition-all duration-300 cursor-pointer min-w-[240px] max-w-[290px] shrink-0 group"
                            >
                                {{-- Logo / Monogram Insignia --}}
                                <div class="w-12 h-12 rounded-xl bg-gray-50 border border-gray-100 flex items-center justify-center p-2 shrink-0 group-hover:bg-[#005952]/5 transition-colors overflow-hidden">
                                    @if($client->logo_image)
                                        <img src="{{ $client->logo_image }}" alt="{{ $client->name }}" class="max-h-8 max-w-[42px] object-contain filter grayscale group-hover:grayscale-0 transition-all duration-300">
                                    @else
                                        <div class="w-8 h-8 rounded-lg bg-[#005952]/10 text-[#005952] flex items-center justify-center font-black text-xs group-hover:bg-[#005952] group-hover:text-white transition-colors">
                                            {{ strtoupper(substr($client->name, 0, 2)) }}
                                        </div>
                                    @endif
                                </div>

                                {{-- Partner Details --}}
                                <div class="text-left overflow-hidden">
                                    <div class="flex items-center gap-1.5">
                                        <span class="text-[9px] font-extrabold uppercase tracking-wider text-slate-800 bg-slate-100 px-1.5 py-0.5 rounded border border-slate-200">
                                            {{ $client->client_type }}
                                        </span>
                                    </div>
                                    <h4 class="text-xs sm:text-sm font-extrabold text-gray-900 mt-1 truncate group-hover:text-[#005952] transition-colors">
                                        {{ $client->name }}
                                    </h4>
                                    <p class="text-[10px] text-gray-500 truncate mt-0.5">
                                        {{ $client->industry ?: 'Sinergi Ekosistem' }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    @endfor
                </div>
            </div>

            {{-- TRACK 2: RUNNING RIGHT (KLIEN & INDUSTRI & KOMUNITAS) --}}
            <div class="marquee-track-container overflow-hidden whitespace-nowrap">
                <div class="marquee-track-right flex gap-4 w-max hover:[animation-play-state:paused]">
                    {{-- Loop twice for seamless infinite scroll --}}
                    @for($loopIndex = 0; $loopIndex < 2; $loopIndex++)
                        @foreach($track2Clients as $client)
                            <div 
                                @click="modalItem = {{ json_encode($client) }}"
                                class="inline-flex items-center gap-3.5 px-4 py-3 rounded-2xl bg-white border border-gray-200/90 shadow-2xs hover:shadow-lg hover:border-[#005952] hover:-translate-y-0.5 transition-all duration-300 cursor-pointer min-w-[240px] max-w-[290px] shrink-0 group"
                            >
                                {{-- Logo / Monogram Insignia --}}
                                <div class="w-12 h-12 rounded-xl bg-gray-50 border border-gray-100 flex items-center justify-center p-2 shrink-0 group-hover:bg-[#005952]/5 transition-colors overflow-hidden">
                                    @if($client->logo_image)
                                        <img src="{{ $client->logo_image }}" alt="{{ $client->name }}" class="max-h-8 max-w-[42px] object-contain filter grayscale group-hover:grayscale-0 transition-all duration-300">
                                    @else
                                        <div class="w-8 h-8 rounded-lg bg-[#005952]/10 text-[#005952] flex items-center justify-center font-black text-xs group-hover:bg-[#005952] group-hover:text-white transition-colors">
                                            {{ strtoupper(substr($client->name, 0, 2)) }}
                                        </div>
                                    @endif
                                </div>

                                {{-- Partner Details --}}
                                <div class="text-left overflow-hidden">
                                    <div class="flex items-center gap-1.5">
                                        <span class="text-[9px] font-extrabold uppercase tracking-wider text-amber-700 bg-amber-50 px-1.5 py-0.5 rounded">
                                            {{ $client->client_type }}
                                        </span>
                                    </div>
                                    <h4 class="text-xs sm:text-sm font-extrabold text-gray-900 mt-1 truncate group-hover:text-[#005952] transition-colors">
                                        {{ $client->name }}
                                    </h4>
                                    <p class="text-[10px] text-gray-500 truncate mt-0.5">
                                        {{ $client->industry ?: 'Sinergi Ekosistem' }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    @endfor
                </div>
            </div>

        </div>

        {{-- MODE 2: WHEN FILTERED -> SINGLE DYNAMIC RUNNING TRACK --}}
        <div x-show="activeCategory !== 'all'" class="overflow-hidden whitespace-nowrap">
            <div class="marquee-track-left flex gap-4 w-max hover:[animation-play-state:paused]">
                <template x-for="loop in [1, 2, 3]" :key="loop">
                    <div class="flex gap-4">
                        <template x-for="c in filteredList" :key="c.id + '-' + loop">
                            <div 
                                @click="modalItem = c"
                                class="inline-flex items-center gap-3.5 px-4 py-3 rounded-2xl bg-white border border-gray-200/90 shadow-2xs hover:shadow-lg hover:border-[#005952] hover:-translate-y-0.5 transition-all duration-300 cursor-pointer min-w-[240px] max-w-[290px] shrink-0 group"
                            >
                                <div class="w-12 h-12 rounded-xl bg-gray-50 border border-gray-100 flex items-center justify-center p-2 shrink-0 group-hover:bg-[#005952]/5 transition-colors overflow-hidden">
                                    <template x-if="c.logo_image">
                                        <img :src="c.logo_image" :alt="c.name" class="max-h-8 max-w-[42px] object-contain filter grayscale group-hover:grayscale-0 transition-all duration-300">
                                    </template>
                                    <template x-if="!c.logo_image">
                                        <div class="w-8 h-8 rounded-lg bg-[#005952]/10 text-[#005952] flex items-center justify-center font-black text-xs group-hover:bg-[#005952] group-hover:text-white transition-colors" x-text="c.name.substring(0, 2).toUpperCase()"></div>
                                    </template>
                                </div>
                                <div class="text-left overflow-hidden">
                                    <span class="text-[9px] font-extrabold uppercase tracking-wider text-slate-800 bg-slate-100 px-1.5 py-0.5 rounded border border-slate-200" x-text="c.client_type"></span>
                                    <h4 class="text-xs sm:text-sm font-extrabold text-gray-900 mt-1 truncate group-hover:text-[#004741] transition-colors" x-text="c.name"></h4>
                                    <p class="text-[10px] text-gray-500 truncate mt-0.5" x-text="c.industry"></p>
                                </div>
                            </div>
                        </template>
                    </div>
                </template>
            </div>
        </div>

    </div>

    {{-- ========================================================================= --}}
    {{-- PARTNER DETAIL MODAL                                                      --}}
    {{-- ========================================================================= --}}
    <div 
        x-show="modalItem"
        x-cloak
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="fixed inset-0 z-50 overflow-y-auto bg-black/60 backdrop-blur-xs flex items-center justify-center p-4"
        style="display: none;"
    >
        <div 
            @click.away="modalItem = null"
            class="relative w-full max-w-lg bg-white rounded-3xl shadow-2xl border border-gray-200 p-6 sm:p-8 text-left"
        >
            <div class="flex items-start justify-between gap-4 pb-4 border-b border-gray-100">
                <div class="flex items-center gap-3">
                    <div class="w-14 h-14 rounded-2xl bg-gray-50 border border-gray-200 flex items-center justify-center p-2">
                        <template x-if="modalItem?.logo_image">
                            <img :src="modalItem.logo_image" :alt="modalItem.name" class="max-h-10 max-w-[48px] object-contain">
                        </template>
                        <template x-if="!modalItem?.logo_image">
                            <div class="w-10 h-10 rounded-xl bg-[#005952] text-white flex items-center justify-center font-black text-sm" x-text="modalItem ? modalItem.name.substring(0, 2).toUpperCase() : ''"></div>
                        </template>
                    </div>
                    <div>
                        <span class="px-2.5 py-0.5 rounded text-[10px] font-extrabold uppercase bg-slate-100 text-slate-800 border border-slate-200" x-text="modalItem?.client_type"></span>
                        <h3 class="text-base sm:text-lg font-black text-gray-950 mt-1 leading-tight" x-text="modalItem?.name"></h3>
                    </div>
                </div>
                <button 
                    @click="modalItem = null" 
                    class="w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-600 flex items-center justify-center text-lg font-bold cursor-pointer"
                >
                    &times;
                </button>
            </div>

            <div class="py-4 space-y-3">
                <div>
                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block" x-text="$store.lang.t('Industri & Wilayah:', 'Industry & Location:')">Industri & Wilayah:</span>
                    <p class="text-xs font-bold text-gray-800" x-text="(modalItem?.industry || 'Sinergi') + ' • ' + (modalItem?.location || 'Indonesia')"></p>
                </div>
                <div>
                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block" x-text="$store.lang.t('Profil Kolaborasi:', 'Collaboration Profile:')">Profil Kolaborasi:</span>
                    <p class="text-xs text-gray-600 leading-relaxed mt-1" x-text="$store.lang.isEN() ? modalItem?.description_en : modalItem?.description_id"></p>
                </div>
            </div>

            <div class="pt-4 border-t border-gray-100 flex items-center justify-between gap-3">
                <template x-if="modalItem?.website_url">
                    <a 
                        :href="modalItem.website_url" 
                        target="_blank"
                        class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-[#005952] hover:bg-[#004741] text-white text-xs font-bold transition-colors cursor-pointer"
                    >
                        <span x-text="$store.lang.t('Kunjungi Website Resmi ↗', 'Visit Official Website ↗')">Kunjungi Website Resmi ↗</span>
                    </a>
                </template>
                <template x-if="!modalItem?.website_url">
                    <span class="text-xs text-gray-400 italic" x-text="$store.lang.t('Mitra internal ekosistem', 'Internal ecosystem partner')">Mitra internal ekosistem</span>
                </template>

                <button 
                    @click="modalItem = null"
                    class="px-4 py-2 rounded-xl border border-gray-200 hover:bg-gray-100 text-gray-700 text-xs font-bold transition-colors cursor-pointer"
                >
                    <span x-text="$store.lang.t('Tutup', 'Close')">Tutup</span>
                </button>
            </div>
        </div>
    </div>

</section>

{{-- Scoped CSS for Butter-Smooth Infinite Horizontal Marquee --}}
<style>
@keyframes marqueeScrollLeft {
    0% {
        transform: translate3d(0, 0, 0);
    }
    100% {
        transform: translate3d(-50%, 0, 0);
    }
}

@keyframes marqueeScrollRight {
    0% {
        transform: translate3d(-50%, 0, 0);
    }
    100% {
        transform: translate3d(0, 0, 0);
    }
}

.marquee-track-left {
    display: flex;
    width: max-content;
    animation: marqueeScrollLeft 38s linear infinite;
    will-change: transform;
}

.marquee-track-right {
    display: flex;
    width: max-content;
    animation: marqueeScrollRight 38s linear infinite;
    will-change: transform;
}

.marquee-track-left:hover,
.marquee-track-right:hover {
    animation-play-state: paused !important;
}
</style>
