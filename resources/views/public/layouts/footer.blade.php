{{-- 
    YOIN (PT Yota Inovasi Nusantara) Official Footer
    Data Resmi:
    - PT Yota Inovasi Nusantara adalah mitra strategis transformasi digital Anda.
      Kami menghadirkan solusi teknologi kelas dunia dengan seluruh keuntungan operasional dialokasikan untuk kemanusiaan.
    - Tautan Cepat: Beranda, Layanan, Portofolio, Produk, Tentang Kami
    - Hubungi Kami:
      Perumahan Jatimekar residence, Blk. C No.26, RT./RW/RW.002/011, Malakasari, Kec. Baleendah, Kabupaten Bandung, Jawa Barat 40375
      0858 6231 9524 | hello@yotainovasi.id | Senin - Jumat: 08:00 - 17:00
    Aturan: 100% Bilingual (ID & EN), Bebas Emotikon, Tanpa Kata Venture, Logo logotulisan.png.
--}}
<footer class="bg-gray-50 text-gray-600 border-t border-gray-200 font-sans pt-16 pb-12 select-none">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-10 pb-12 border-b border-gray-200">
            
            {{-- Brand & Tentang Column --}}
            <div class="lg:col-span-5 space-y-4 text-left">
                <div class="flex items-center">
                    <img src="{{ asset('logotulisan.png') }}" alt="PT Yota Inovasi Nusantara" class="h-11 sm:h-12 w-auto object-contain">
                </div>
                
                <h5 class="text-xs font-bold uppercase tracking-wider text-gray-900 pt-1" x-text="$store.lang.t('Tentang YOIN', 'About YOIN')">
                    Tentang YOIN
                </h5>
                <p class="text-xs sm:text-sm text-gray-600 leading-relaxed max-w-md font-normal" x-text="$store.lang.t('PT Yota Inovasi Nusantara adalah mitra strategis transformasi digital Anda. Kami menghadirkan solusi teknologi kelas dunia dengan seluruh keuntungan operasional dialokasikan untuk kemanusiaan.', 'PT Yota Inovasi Nusantara is your strategic digital transformation partner. We deliver world-class technology solutions with all operating profits dedicated to humanitarian causes.')">
                    PT Yota Inovasi Nusantara adalah mitra strategis transformasi digital Anda. Kami menghadirkan solusi teknologi kelas dunia dengan seluruh keuntungan operasional dialokasikan untuk kemanusiaan.
                </p>

                <div class="flex items-center space-x-3 pt-2">
                    <a href="https://wa.me/6285862319524" target="_blank" rel="noopener" class="w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center text-gray-600 hover:border-[#004741] hover:text-white hover:bg-[#004741] transition-all" title="WhatsApp">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.598 2.664-.698c.969.587 1.961.954 2.801.955l.005-.001c3.181 0 5.767-2.586 5.768-5.766 0-3.18-2.586-5.766-5.768-5.766zm9.969 5.766c0 5.514-4.486 10-10 10-1.823 0-3.539-.493-5.029-1.353l-6.971 1.823 1.854-6.782c-.933-1.529-1.472-3.32-1.472-5.234 0-5.514 4.486-10 10-10s10 4.486 10 10z"/></svg>
                    </a>
                    <a href="mailto:hello@yotainovasi.id" class="w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center text-gray-600 hover:border-[#004741] hover:text-white hover:bg-[#004741] transition-all" title="Email">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    </a>
                    <a href="https://yotainovasi.id" target="_blank" rel="noopener" class="w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center text-gray-600 hover:border-[#004741] hover:text-white hover:bg-[#004741] transition-all" title="Website">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>
                    </a>
                </div>
            </div>

            {{-- Tautan Cepat --}}
            <div class="lg:col-span-3 space-y-3 text-left">
                <h5 class="text-xs font-bold uppercase tracking-widest text-gray-900" x-text="$store.lang.t('Tautan Cepat', 'Quick Links')">
                    Tautan Cepat
                </h5>
                <ul class="space-y-2 text-xs sm:text-sm">
                    <li>
                        <a href="{{ url('/') }}" class="hover:text-[#004741] transition-colors flex items-center gap-1.5">
                            <span x-text="$store.lang.t('Beranda', 'Home')">Beranda</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('public.ecosystem.index') }}" class="hover:text-[#004741] transition-colors flex items-center gap-1.5">
                            <span x-text="$store.lang.t('Ekosistem Inisiatif', 'Ecosystem & Initiatives')">Ekosistem Inisiatif</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('public.portfolio.index') }}" class="hover:text-[#004741] transition-colors flex items-center gap-1.5">
                            <span x-text="$store.lang.t('Portofolio', 'Portfolio')">Portofolio</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('public.articles.index') }}" class="hover:text-[#004741] transition-colors flex items-center gap-1.5">
                            <span x-text="$store.lang.t('Jurnal & Publikasi', 'Publications & Insights')">Jurnal & Publikasi</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('public.about.profile') }}" class="hover:text-[#004741] transition-colors flex items-center gap-1.5">
                            <span x-text="$store.lang.t('Profil Perusahaan', 'Company Profile')">Profil Perusahaan</span>
                        </a>
                    </li>
                </ul>
            </div>

            {{-- Hubungi Kami (Alamat Lengkap, Kontak, Jam Layanan) --}}
            <div class="lg:col-span-4 space-y-3 text-left">
                <h5 class="text-xs font-bold uppercase tracking-widest text-gray-900" x-text="$store.lang.t('Hubungi Kami', 'Contact Us')">
                    Hubungi Kami
                </h5>
                <div class="space-y-2.5 text-xs text-gray-600 leading-relaxed font-normal">
                    {{-- Alamat --}}
                    <div>
                        <span class="font-bold text-gray-800 block text-[11px] uppercase tracking-wider mb-0.5" x-text="$store.lang.t('Alamat Kantor:', 'Office Address:')">Alamat Kantor:</span>
                        <p class="text-gray-700">
                            Perumahan Jatimekar residence, Blk. C No.26, RT./RW/RW.002/011, Malakasari, Kec. Baleendah, Kabupaten Bandung, Jawa Barat 40375
                        </p>
                    </div>
                    
                    {{-- Nomor Telepon / WA --}}
                    <div>
                        <span class="font-bold text-gray-800 block text-[11px] uppercase tracking-wider mb-0.5" x-text="$store.lang.t('Telepon / WhatsApp:', 'Phone / WhatsApp:')">Telepon / WhatsApp:</span>
                        <a href="https://wa.me/6285862319524" target="_blank" rel="noopener" class="text-[#004741] font-bold hover:underline">
                            0858 6231 9524
                        </a>
                    </div>

                    {{-- Email --}}
                    <div>
                        <span class="font-bold text-gray-800 block text-[11px] uppercase tracking-wider mb-0.5" x-text="$store.lang.t('Email Resmi:', 'Official Email:')">Email Resmi:</span>
                        <a href="mailto:hello@yotainovasi.id" class="text-[#004741] font-semibold hover:underline">
                            hello@yotainovasi.id
                        </a>
                    </div>

                    {{-- Jam Operasional --}}
                    <div>
                        <span class="font-bold text-gray-800 block text-[11px] uppercase tracking-wider mb-0.5" x-text="$store.lang.t('Jam Operasional:', 'Operating Hours:')">Jam Operasional:</span>
                        <p class="text-gray-700" x-text="$store.lang.t('Senin - Jumat: 08:00 - 17:00 WIB', 'Monday - Friday: 08:00 - 17:00 WIB')">
                            Senin - Jumat: 08:00 - 17:00 WIB
                        </p>
                    </div>
                </div>
            </div>

        </div>

        {{-- Bottom Copyright --}}
        <div class="pt-8 flex flex-col sm:flex-row items-center justify-between text-xs text-gray-500 gap-4">
            <p>&copy; {{ date('Y') }} PT Yota Inovasi Nusantara. <span x-text="$store.lang.t('Seluruh Hak Cipta Dilindungi Undang-Undang.', 'All Rights Reserved.')">Seluruh Hak Cipta Dilindungi Undang-Undang.</span></p>
            <div class="flex items-center space-x-6">
                <a href="{{ route('public.legal.terms') }}" class="hover:text-[#004741] transition-colors" x-text="$store.lang.t('Syarat & Ketentuan', 'Terms & Conditions')">Syarat & Ketentuan</a>
                <a href="{{ route('public.legal.privacy') }}" class="hover:text-[#004741] transition-colors" x-text="$store.lang.t('Kebijakan Privasi', 'Privacy Policy')">Kebijakan Privasi</a>
                <a href="{{ route('public.legal.security') }}" class="hover:text-[#004741] transition-colors" x-text="$store.lang.t('Keamanan Informasi', 'Information Security')">Keamanan Informasi</a>
            </div>
        </div>
    </div>
</footer>
