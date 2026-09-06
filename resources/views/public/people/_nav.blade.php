{{-- Sleek, Compact & Solid Sub-Navigation for Public People Directory --}}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-8 sm:mb-12">
    <div class="flex items-center justify-between gap-3 overflow-x-auto no-scrollbar scroll-smooth pb-3 border-b border-slate-200">
        <div class="flex items-center gap-1.5 sm:gap-2 shrink-0">
            {{-- Home Button --}}
            <a 
                href="{{ url('/') }}" 
                class="px-3.5 py-2 rounded-xl text-xs font-bold transition-all shrink-0 flex items-center gap-1.5 border border-slate-300 bg-white text-slate-700 hover:text-slate-950 hover:border-slate-900 shadow-2xs hover:shadow-xs group"
                title="Kembali ke Beranda Utama"
            >
                <svg class="w-3.5 h-3.5 text-slate-500 group-hover:text-slate-900 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <span x-text="$store.lang.t('Beranda', 'Home')">Beranda</span>
            </a>

            <span class="w-px h-5 bg-slate-300 mx-0.5"></span>

            {{-- 1. Semua Insan --}}
            <a 
                href="{{ route('public.people.index') }}" 
                class="px-3.5 sm:px-4 py-2 rounded-xl text-xs transition-all shrink-0 font-bold {{ request()->routeIs('public.people.index') ? 'bg-slate-950 text-white shadow-sm' : 'border border-slate-200 bg-white text-slate-700 hover:text-slate-950 hover:border-slate-400' }}"
            >
                <span x-text="$store.lang.t('Semua Insan', 'Overview')">Semua Insan</span>
            </a>

            {{-- 2. Pendiri --}}
            <a 
                href="{{ route('public.people.founder.index') }}" 
                class="px-3.5 sm:px-4 py-2 rounded-xl text-xs transition-all shrink-0 font-bold {{ request()->routeIs('public.people.founder.*') ? 'bg-slate-950 text-white shadow-sm' : 'border border-slate-200 bg-white text-slate-700 hover:text-slate-950 hover:border-slate-400' }}"
            >
                <span x-text="$store.lang.t('Pendiri', 'Founders')">Pendiri</span>
            </a>

            {{-- 3. Manifes & Kisah --}}
            <a 
                href="{{ route('public.people.storyfounder.index') }}" 
                class="px-3.5 sm:px-4 py-2 rounded-xl text-xs transition-all shrink-0 font-bold {{ request()->routeIs('public.people.storyfounder.*') ? 'bg-slate-950 text-white shadow-sm' : 'border border-slate-200 bg-white text-slate-700 hover:text-slate-950 hover:border-slate-400' }}"
            >
                <span x-text="$store.lang.t('Manifes', 'Manifestos')">Manifes</span>
            </a>

            {{-- 4. Tim Inti --}}
            <a 
                href="{{ route('public.people.tim.index') }}" 
                class="px-3.5 sm:px-4 py-2 rounded-xl text-xs transition-all shrink-0 font-bold {{ request()->routeIs('public.people.tim.*') ? 'bg-slate-950 text-white shadow-sm' : 'border border-slate-200 bg-white text-slate-700 hover:text-slate-950 hover:border-slate-400' }}"
            >
                <span x-text="$store.lang.t('Tim Inti', 'Core Team')">Tim Inti</span>
            </a>

            {{-- 5. Kontributor --}}
            <a 
                href="{{ route('public.people.kontributor.index') }}" 
                class="px-3.5 sm:px-4 py-2 rounded-xl text-xs transition-all shrink-0 font-bold {{ request()->routeIs('public.people.kontributor.*') ? 'bg-slate-950 text-white shadow-sm' : 'border border-slate-200 bg-white text-slate-700 hover:text-slate-950 hover:border-slate-400' }}"
            >
                <span x-text="$store.lang.t('Kontributor', 'Contributors')">Kontributor</span>
            </a>

            {{-- 6. Mitra --}}
            <a 
                href="{{ route('public.people.mitra.index') }}" 
                class="px-3.5 sm:px-4 py-2 rounded-xl text-xs transition-all shrink-0 font-bold {{ request()->routeIs('public.people.mitra.*') ? 'bg-slate-950 text-white shadow-sm' : 'border border-slate-200 bg-white text-slate-700 hover:text-slate-950 hover:border-slate-400' }}"
            >
                <span x-text="$store.lang.t('Mitra', 'Partners')">Mitra</span>
            </a>
        </div>

        {{-- Subtle Brand Tag --}}
        <div class="hidden md:flex items-center text-xs font-bold text-slate-400 tracking-wider uppercase shrink-0">
            <span>Holding YOIN</span>
        </div>
    </div>
</div>
