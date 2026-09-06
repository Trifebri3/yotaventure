{{-- 
    YOIN - Built by People (The People Behind It)
    Pintu Gerbang Utama & Navigasi Ekosistem Insan YOIN
    Terkoneksi langsung ke direktori:
    - Card 1: Profil Pendiri & Buka Kisah Pendiri (route: public.people.founder / public.people.storyfounder)
    - Card 2: Tim Inti Ekosistem (route: public.people.tim)
    - Card 3: Inisiatif & Kontributor (route: public.people.kontributor)
    - Card 4: Mitra & Kolaborator (route: public.people.mitra)
    - Tombol CTA: Direktori Lengkap Insan Ekosistem (route: public.people.index)
    Aturan: 100% Bilingual (ID & EN), Bebas Emotikon, Tanpa Kata Venture, Responsif Mobile & Desktop.
--}}

<section 
    id="people" 
    class="relative w-full py-20 sm:py-28 bg-[#FAFAFA] border-t border-gray-200 overflow-hidden select-none"
>
    
    {{-- Subtle Constellation Background Accent --}}
    <div class="absolute inset-0 pointer-events-none opacity-25">
        <svg class="w-full h-full" viewBox="0 0 1440 800" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
            <path d="M 0 120 C 500 40, 950 200, 1440 100" stroke="#005952" stroke-opacity="0.12" stroke-width="1.5" stroke-dasharray="6 6" />
            <path d="M 0 700 C 450 620, 1000 760, 1440 650" stroke="#005952" stroke-opacity="0.12" stroke-width="1.5" stroke-dasharray="6 6" />
        </svg>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        
        {{-- ======================================================== --}}
        {{-- SECTION HEADER (Bilingual)                               --}}
        {{-- ======================================================== --}}
        <div class="max-w-3xl mx-auto mb-12 sm:mb-16">
            <span class="text-xs sm:text-sm font-bold tracking-[0.26em] text-[#005952] uppercase font-sans" x-text="$store.lang.t('ORANG-ORANG DI BALIKNYA', 'THE PEOPLE BEHIND IT')">
                THE PEOPLE BEHIND IT
            </span>
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-gray-950 mt-3 tracking-tight font-sans leading-tight">
                <span x-text="$store.lang.t('Dibangun oleh', 'Built by')">Built by</span> <span class="text-[#005952]" x-text="$store.lang.t('manusia.', 'people.')">people.</span>
            </h2>
            <div class="mt-4 sm:mt-5 text-xs sm:text-sm lg:text-base text-gray-600 leading-relaxed font-normal space-y-1">
                <p x-text="$store.lang.t('Satu orang memulai perjalanan.', 'One person started the journey.')">One person started the journey.</p>
                <p x-text="$store.lang.t('Kemudian sebuah tim bergabung bersama.', 'Then came a team.')">Then came a team.</p>
                <p x-text="$store.lang.t('Kini, berbagai insan bertalenta membangun karya beragam di bawah satu ekosistem terintegrasi.', 'Today, different people are building different things under one ecosystem.')">Today, different people are building different things under one ecosystem.</p>
            </div>

            {{-- Minimalist Accent Dot & Dash Divider --}}
            <div class="flex items-center justify-center gap-2 mt-5">
                <span class="w-1.5 h-1.5 rounded-full bg-[#004741]"></span>
                <span class="w-8 h-[2.5px] rounded-full bg-[#004741]"></span>
                <span class="w-1.5 h-1.5 rounded-full bg-[#004741]"></span>
            </div>
        </div>

        {{-- ======================================================== --}}
        {{-- 4 PILLAR CARDS (Founder, Core Team, Contributors, Collab)--}}
        {{-- ======================================================== --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 text-left">
            
            {{-- CARD 1: FOUNDER --}}
            <div class="flex flex-col justify-between bg-white rounded-2xl border border-gray-200 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 overflow-hidden group">
                <a href="{{ route('public.people.founder.index') }}" class="block">
                    {{-- Photo Container with Badge --}}
                    <div class="relative h-56 sm:h-64 w-full overflow-hidden bg-gray-100">
                        <img 
                            src="{{ ($primaryFounder && $primaryFounder->photo) ? asset($primaryFounder->photo) : 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?q=80&w=800&auto=format&fit=crop' }}" 
                            alt="YOIN Founder" 
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
                        />
                        <div class="absolute inset-0 bg-gradient-to-t from-gray-950/75 via-transparent to-transparent"></div>
                        
                        {{-- Top-Left Badge --}}
                        <div class="absolute top-4 left-4">
                            <span class="px-3 py-1 rounded-md bg-white/95 backdrop-blur-md text-[10px] font-bold text-gray-800 tracking-wider uppercase shadow-xs" x-text="$store.lang.t('Kisah Awal Berdiri', 'The origin story')">
                                The origin story
                            </span>
                        </div>

                        {{-- Shirt / Landscape text overlay --}}
                        <div class="absolute bottom-4 left-4 right-4 text-white">
                            <p class="text-[11px] font-medium text-white/95 italic tracking-wide">
                                "{{ ($primaryFounder && $primaryFounder->getMeta('quote')) ? $primaryFounder->getMeta('quote') : 'Start with a question. Build for impact.' }}"
                            </p>
                        </div>
                    </div>

                    {{-- Card Info --}}
                    <div class="p-6 pb-2">
                        <div class="flex items-center gap-2.5 text-[#004741] mb-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <h4 class="text-base sm:text-lg font-extrabold text-gray-950" x-text="$store.lang.t('Pendiri', 'Founder')">Founder</h4>
                        </div>
                        <p class="text-xs sm:text-sm text-gray-600 leading-relaxed font-normal" x-text="$store.lang.t('Dimulai dari satu orang yang melihat masalah nyata yang layak diperjuangkan solusinya.', 'It started with one person who saw a problem worth solving.')">
                            Dimulai dari satu orang yang melihat masalah nyata yang layak diperjuangkan solusinya.
                        </p>
                    </div>
                </a>

                {{-- Action Area: Clear Solid CTA --}}
                <div class="px-6 pb-5 pt-3 border-t border-gray-100 flex items-center justify-between">
                    <a 
                        href="{{ route('public.people.founder.index') }}" 
                        class="inline-flex items-center gap-1 text-xs font-extrabold text-[#004741] hover:text-slate-950 transition-colors"
                    >
                        <span x-text="$store.lang.t('Profil & Kisah Pendiri', 'Founder Profile & Story')">Profil & Kisah Pendiri</span>
                        <span class="transform group-hover:translate-x-1 transition-transform">→</span>
                    </a>
                </div>
            </div>

            {{-- CARD 2: CORE TEAM --}}
            <a 
                href="{{ route('public.people.tim.index') }}"
                class="flex flex-col justify-between bg-white rounded-2xl border border-gray-200 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 overflow-hidden group cursor-pointer"
            >
                <div>
                    {{-- Photo Container with Badge --}}
                    <div class="relative h-56 sm:h-64 w-full overflow-hidden bg-gray-100">
                        <img 
                            src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?q=80&w=800&auto=format&fit=crop" 
                            alt="YOIN Core Team" 
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
                        />
                        <div class="absolute inset-0 bg-gradient-to-t from-gray-950/70 via-transparent to-transparent"></div>

                        {{-- Top-Left Badge --}}
                        <div class="absolute top-4 left-4">
                            <span class="px-3 py-1 rounded-md bg-white/95 backdrop-blur-md text-[10px] font-bold text-gray-800 tracking-wider uppercase shadow-xs" x-text="$store.lang.t('Membangun Bersama', 'Building together')">
                                Building together
                            </span>
                        </div>
                    </div>

                    {{-- Card Info --}}
                    <div class="p-6">
                        <div class="flex items-center gap-2.5 text-[#005952] mb-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <h4 class="text-base sm:text-lg font-extrabold text-gray-950" x-text="$store.lang.t('Tim Inti', 'Core Team')">Core Team</h4>
                        </div>
                        <p class="text-xs sm:text-sm text-gray-600 leading-relaxed font-normal" x-text="$store.lang.t('Tim ramping dengan tanggung jawab besar, mengubah gagasan menjadi produk nyata.', 'A small team with big responsibilities, turning ideas into real products.')">
                            Tim ramping dengan tanggung jawab besar, mengubah gagasan menjadi produk nyata.
                        </p>
                    </div>
                </div>

                <div class="px-6 pb-5 pt-1">
                    <span class="inline-flex items-center gap-1.5 text-xs font-bold text-[#005952] group-hover:underline">
                        <span x-text="$store.lang.t('Lihat Profil Tim Inti', 'View Core Team')">Lihat Profil Tim Inti</span>
                        <span class="transform group-hover:translate-x-1 transition-transform">→</span>
                    </span>
                </div>
            </a>

            {{-- CARD 3: CONTRIBUTORS & TIM INISIATIF --}}
            <a 
                href="{{ route('public.people.kontributor.index') }}"
                class="flex flex-col justify-between bg-white rounded-2xl border border-gray-200 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 overflow-hidden group cursor-pointer"
            >
                <div>
                    {{-- Photo Container with Badge --}}
                    <div class="relative h-56 sm:h-64 w-full overflow-hidden bg-gray-100">
                        <img 
                            src="https://images.unsplash.com/photo-1531482615713-2afd69097998?q=80&w=800&auto=format&fit=crop" 
                            alt="YOIN Contributors" 
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
                        />
                        <div class="absolute inset-0 bg-gradient-to-t from-gray-950/70 via-transparent to-transparent"></div>

                        {{-- Top-Left Badge --}}
                        <div class="absolute top-4 left-4">
                            <span class="px-3 py-1 rounded-md bg-white/95 backdrop-blur-md text-[10px] font-bold text-gray-800 tracking-wider uppercase shadow-xs" x-text="$store.lang.t('Untuk Ekosistem', 'For the ecosystem')">
                                For the ecosystem
                            </span>
                        </div>
                    </div>

                    {{-- Card Info --}}
                    <div class="p-6">
                        <div class="flex items-center gap-2.5 text-[#005952] mb-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                            </svg>
                            <h4 class="text-base sm:text-lg font-extrabold text-gray-950" x-text="$store.lang.t('Kontributor', 'Contributors')">Contributors</h4>
                        </div>
                        <p class="text-xs sm:text-sm text-gray-600 leading-relaxed font-normal" x-text="$store.lang.t('Rekayasawan, penulis riset, dan kreator yang menyumbangkan keahlian serta dedikasi.', 'Developers, writers, and creators who contribute skills and passion.')">
                            Rekayasawan, penulis riset, dan kreator yang menyumbangkan keahlian serta dedikasi.
                        </p>
                    </div>
                </div>

                <div class="px-6 pb-5 pt-1">
                    <span class="inline-flex items-center gap-1.5 text-xs font-bold text-[#005952] group-hover:underline">
                        <span x-text="$store.lang.t('Tim Inisiatif & Kontributor', 'Initiative Teams & Contributors')">Tim Inisiatif & Kontributor</span>
                        <span class="transform group-hover:translate-x-1 transition-transform">→</span>
                    </span>
                </div>
            </a>

            {{-- CARD 4: COLLABORATORS --}}
            <a 
                href="{{ route('public.people.mitra.index') }}"
                class="flex flex-col justify-between bg-white rounded-2xl border border-gray-200 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 overflow-hidden group cursor-pointer"
            >
                <div>
                    {{-- Photo Container with Badge --}}
                    <div class="relative h-56 sm:h-64 w-full overflow-hidden bg-gray-100">
                        <img 
                            src="https://images.unsplash.com/photo-1521737604893-d14cc237f11d?q=80&w=800&auto=format&fit=crop" 
                            alt="YOIN Collaborators" 
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
                        />
                        <div class="absolute inset-0 bg-gradient-to-t from-gray-950/70 via-transparent to-transparent"></div>

                        {{-- Top-Left Badge --}}
                        <div class="absolute top-4 left-4">
                            <span class="px-3 py-1 rounded-md bg-white/95 backdrop-blur-md text-[10px] font-bold text-gray-800 tracking-wider uppercase shadow-xs" x-text="$store.lang.t('Lebih Kuat Bersama', 'Stronger together')">
                                Stronger together
                            </span>
                        </div>
                    </div>

                    {{-- Card Info --}}
                    <div class="p-6">
                        <div class="flex items-center gap-2.5 text-[#005952] mb-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                            </svg>
                            <h4 class="text-base sm:text-lg font-extrabold text-gray-950" x-text="$store.lang.t('Kolaborator', 'Collaborators')">Collaborators</h4>
                        </div>
                        <p class="text-xs sm:text-sm text-gray-600 leading-relaxed font-normal" x-text="$store.lang.t('Mitra universitas, lembaga pemerintah, dan aliansi industri yang bergerak bersama.', 'Partners and organizations working with us to create a wider impact.')">
                            Mitra universitas, lembaga pemerintah, dan aliansi industri yang bergerak bersama.
                        </p>
                    </div>
                </div>

                <div class="px-6 pb-5 pt-1">
                    <span class="inline-flex items-center gap-1.5 text-xs font-bold text-[#005952] group-hover:underline">
                        <span x-text="$store.lang.t('Logo & Mitra Kolaborator', 'Partners & Collaborators')">Logo & Mitra Kolaborator</span>
                        <span class="transform group-hover:translate-x-1 transition-transform">→</span>
                    </span>
                </div>
            </a>

        </div>

        {{-- ======================================================== --}}
        {{-- BOTTOM CTA BUTTON                                        --}}
        {{-- ======================================================== --}}
        <div class="mt-12 sm:mt-16 flex justify-center">
            <a 
                href="{{ route('public.people.index') }}" 
                class="inline-flex items-center gap-2.5 px-8 py-3.5 rounded-full bg-[#004741] hover:bg-slate-950 text-white font-extrabold text-xs sm:text-sm tracking-wider uppercase transition-all duration-300 shadow-md hover:shadow-xl cursor-pointer group"
            >
                <span x-text="$store.lang.t('Temui Seluruh Insan Ekosistem', 'Meet the Entire Ecosystem')">Temui Seluruh Insan Ekosistem</span>
                <span class="transform group-hover:translate-x-1 transition-transform">→</span>
            </a>
        </div>

    </div>

</section>
