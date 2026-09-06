{{-- 
    YOIN - We're Not Done Yet (Manifesto Tim & Formulir Kontak Kolaborasi)
    "We’re not done yet."
    "INI CTA BTW TAMBAHKAN JUGA FORMULIR UNTUK MENGHUBUNGI"
    "ini latar belakang nya pake gambar atau foto dari public/foto/tim.png"
    Aturan: 100% Bilingual (ID & EN), Bebas Emotikon, Tanpa Kata Venture, Foto public/foto/tim.png, Form Lengkap & Responsif.
--}}

<section 
    id="contact"
    x-data="{
        formSubmitted: false,
        isSubmitting: false,
        errorMessage: '',
        formData: {
            name: '',
            email: '',
            phone: '',
            category: 'Inovasi & Akselerasi Inisiatif',
            message: ''
        },
        submitForm() {
            if (!this.formData.name || !this.formData.email || !this.formData.message) {
                const msg = this.$store.lang.isEN() 
                    ? 'Please complete your Name, Email, and Message.' 
                    : 'Mohon lengkapi Nama, Email, dan Pesan Anda.';
                alert(msg);
                return;
            }
            this.isSubmitting = true;
            this.errorMessage = '';

            fetch('{{ route('public.collaboration.inquiry') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(this.formData)
            })
            .then(res => {
                if (!res.ok) {
                    return res.json().then(errData => {
                        throw new Error(errData.message || (this.$store.lang.isEN() ? 'Failed to submit form.' : 'Gagal mengirimkan formulir.'));
                    });
                }
                return res.json();
            })
            .then(data => {
                this.isSubmitting = false;
                this.formSubmitted = true;
            })
            .catch(err => {
                this.isSubmitting = false;
                this.errorMessage = err.message || (this.$store.lang.isEN() ? 'Error sending collaboration message. Please try again.' : 'Terjadi kesalahan saat mengirim pesan kolaborasi.');
                alert(this.errorMessage);
            });
        },
        resetForm() {
            this.formData = {
                name: '',
                email: '',
                phone: '',
                category: 'Inovasi & Akselerasi Inisiatif',
                message: ''
            };
            this.formSubmitted = false;
            this.errorMessage = '';
        }
    }"
    class="relative w-full bg-[#FBFDFD] border-t border-gray-200 overflow-hidden select-none"
>
    
    {{-- ======================================================== --}}
    {{-- 1. HERO MANIFESTO BANNER WITH public/foto/tim.png         --}}
    {{-- ======================================================== --}}
    <div class="relative w-full min-h-[640px] lg:min-h-[720px] flex items-center overflow-hidden">
        
        {{-- Background Photo: public/foto/tim.png --}}
        <div class="absolute inset-0 z-0">
            <img 
                src="{{ asset('foto/tim.png') }}" 
                alt="YOIN Team" 
                class="w-full h-full object-cover object-[70%_center] sm:object-[65%_center] lg:object-[82%_center] filter brightness-[0.98] contrast-[1.02]"
            />
            {{-- Smooth Left White Gradient Overlay ensuring 100% text readability --}}
            <div class="absolute inset-0 bg-gradient-to-r from-[#FBFDFD] via-[#FBFDFD]/90 sm:via-[#FBFDFD]/80 lg:via-[#FBFDFD]/40 to-transparent"></div>
        </div>

        {{-- Subtle Constellation Arc --}}
        <div class="absolute top-8 left-8 pointer-events-none opacity-40 hidden sm:block z-10">
            <svg class="w-48 h-48" viewBox="0 0 200 200" fill="none">
                <circle cx="100" cy="100" r="70" stroke="#005952" stroke-width="1.2" stroke-dasharray="4 4" />
                <circle cx="100" cy="100" r="40" stroke="#005952" stroke-width="1" />
                <circle cx="160" cy="80" r="3.5" fill="#005952" />
                <circle cx="50" cy="130" r="2.5" fill="#005952" />
            </svg>
        </div>

        {{-- Left Content: Editorial Manifesto --}}
        <div class="relative z-10 max-w-7xl mx-auto px-6 sm:px-10 lg:px-14 w-full py-16 lg:py-24">
            <div class="max-w-xl text-left">
                
                {{-- Big Title: We're not done yet. --}}
                <h2 class="text-4xl sm:text-5xl lg:text-6xl xl:text-7xl font-extrabold text-gray-950 tracking-tight leading-[1.05] font-sans">
                    <span x-text="$store.lang.isEN() ? 'We\'re' : 'Kami'">We’re</span><br>
                    <span class="text-[#005952]" x-text="$store.lang.isEN() ? 'not done' : 'belum selesai'">not done</span> <span x-text="$store.lang.isEN() ? 'yet.' : 'membangun.'">yet.</span>
                </h2>

                {{-- Minimalist Dot & Dash Accent Line (• ▬) --}}
                <div class="flex items-center gap-2 mt-5 mb-7">
                    <span class="w-2 h-2 rounded-full bg-[#005952]"></span>
                    <span class="w-10 h-[2.5px] rounded-full bg-[#005952]/60"></span>
                </div>

                {{-- Manifesto Statement Lines --}}
                <div class="space-y-2 text-sm sm:text-base lg:text-lg text-gray-700 font-medium leading-relaxed">
                    <p x-text="$store.lang.t('Sebagian ide telah menjadi bisnis mandiri.', 'Some ideas are already businesses.')">Some ideas are already businesses.</p>
                    <p x-text="$store.lang.t('Sebagian sedang bertumbuh menjadi produk.', 'Some are becoming products.')">Some are becoming products.</p>
                    <p x-text="$store.lang.t('Sebagian lainnya masih berupa gagasan murni.', 'Some are still just ideas.')">Some are still just ideas.</p>
                </div>

                {{-- "That's the point." --}}
                <p class="mt-5 sm:mt-6 text-sm sm:text-base lg:text-lg text-gray-900 font-bold" x-text="$store.lang.t('Itulah intinya.', 'That’s the point.')">
                    That’s the point.
                </p>

                {{-- "We're still building." --}}
                <p class="mt-2.5 text-2xl sm:text-3xl font-extrabold text-[#005952] tracking-tight font-sans" x-text="$store.lang.t('Kami masih terus membangun.', 'We’re still building.')">
                    We’re still building.
                </p>

                {{-- Wooden Trail Signpost Badges --}}
                <div class="mt-7 flex flex-wrap items-center gap-2.5">
                    <a 
                        href="{{ route('public.ecosystem.domain', 'products') }}"
                        class="px-4 py-2 rounded-lg bg-[#272B28]/90 hover:bg-[#005952] text-white text-[11px] sm:text-xs font-bold tracking-wider uppercase transition-all duration-200 shadow-md flex items-center gap-2"
                    >
                        <span x-text="$store.lang.t('PRODUK', 'PRODUCTS')">PRODUCTS</span>
                        <span>→</span>
                    </a>
                    <a 
                        href="{{ route('public.ecosystem.index') }}"
                        class="px-4 py-2 rounded-lg bg-[#272B28]/90 hover:bg-[#005952] text-white text-[11px] sm:text-xs font-bold tracking-wider uppercase transition-all duration-200 shadow-md flex items-center gap-2"
                    >
                        <span x-text="$store.lang.t('INISIATIF', 'INITIATIVES')">INISIATIF</span>
                        <span>→</span>
                    </a>
                    <a 
                        href="{{ route('public.ecosystem.domain', 'emerging') }}"
                        class="px-4 py-2 rounded-lg bg-[#272B28]/90 hover:bg-[#005952] text-white text-[11px] sm:text-xs font-bold tracking-wider uppercase transition-all duration-200 shadow-md flex items-center gap-2"
                    >
                        <span x-text="$store.lang.t('GAGASAN', 'IDEAS')">IDEAS</span>
                        <span>→</span>
                    </a>
                </div>

                {{-- Action button to jump to the contact form --}}
                <div class="mt-8 flex items-center gap-4">
                    <a 
                        href="#form-kolaborasi"
                        class="inline-flex items-center gap-2 px-6 py-3 rounded-full bg-[#005952] hover:bg-[#004741] text-white font-bold text-xs sm:text-sm tracking-wider uppercase transition-all duration-200 shadow-lg shadow-[#005952]/20 hover:scale-105 active:scale-95 cursor-pointer"
                    >
                        <span x-text="$store.lang.t('Tulis Pesan Kolaborasi', 'Write Collaboration Message')">Tulis Pesan Kolaborasi</span>
                        <svg class="w-4 h-4 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                        </svg>
                    </a>
                </div>

            </div>
        </div>
    </div>

    {{-- ======================================================== --}}
    {{-- 2. INTEGRATED COLLABORATION CONTACT FORM                  --}}
    {{-- ======================================================== --}}
    <div id="form-kolaborasi" class="relative z-10 w-full py-16 sm:py-20 bg-gradient-to-b from-[#FBFDFD] to-[#F3F7F7] border-t border-gray-200">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="bg-white rounded-3xl border border-gray-200 shadow-xl overflow-hidden relative">
                {{-- Decorative Top Colored Accent Strip --}}
                <div class="h-2 bg-gradient-to-r from-[#004741] via-[#003430] to-slate-900"></div>

                <div class="p-6 sm:p-10 lg:p-12">
                    
                    <div class="max-w-2xl mb-8 text-left">
                        <span class="text-[10px] sm:text-xs font-bold tracking-[0.24em] text-[#005952] uppercase font-sans" x-text="$store.lang.t('FORMULIR KEMITRAAN & KOLABORASI', 'PARTNERSHIP & COLLABORATION FORM')">
                            FORMULIR KEMITRAAN & INVESTASI
                        </span>
                        <h3 class="text-2xl sm:text-3xl font-extrabold text-gray-950 mt-1.5 tracking-tight font-sans" x-text="$store.lang.t('Mulai Kolaborasi Bersama YOIN', 'Start Collaborating with YOIN')">
                            Mulai Kolaborasi Bersama YOIN
                        </h3>
                        <p class="text-xs sm:text-sm text-gray-600 mt-2 leading-relaxed font-normal" x-text="$store.lang.t('Bagi pendiri startup, mitra korporasi, periset, investor strategis, maupun calon kontributor yang ingin bersama-sama mengakselerasi ekosistem Nusantara.', 'For startup founders, corporate partners, researchers, strategic investors, and contributors seeking to accelerate the Nusantara ecosystem.')">
                            Bagi pendiri startup, mitra korporasi, periset, investor strategis, maupun calon kontributor yang ingin bersama-sama mengakselerasi ekosistem Nusantara.
                        </p>
                    </div>

                    {{-- SUCCESS NOTIFICATION --}}
                    <div 
                        x-show="formSubmitted"
                        x-transition
                        class="p-8 rounded-2xl bg-slate-50 border border-slate-200 text-center space-y-4 my-6"
                    >
                        <div class="w-14 h-14 rounded-full bg-[#005952] text-white flex items-center justify-center mx-auto shadow-md">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <h4 class="text-lg sm:text-xl font-extrabold text-gray-950" x-text="$store.lang.t('Pesan Kolaborasi Anda Berhasil Diterima', 'Your Collaboration Message Has Been Received')">
                            Pesan Kolaborasi Anda Berhasil Diterima
                        </h4>
                        <p class="text-xs sm:text-sm text-gray-600 leading-relaxed max-w-md mx-auto" x-text="$store.lang.t('Terima kasih atas gagasan dan ketertarikan Anda. Tim Kemitraan Strategis YOIN akan meninjau dan merespons pesan Anda dalam 1x24 jam kerja.', 'Thank you for your interest and vision. The YOIN Strategic Partnerships team will review and respond within 1 business day.')">
                            Terima kasih atas gagasan dan ketertarikan Anda. Tim Kemitraan Strategis YOIN akan meninjau dan merespons pesan Anda dalam 1x24 jam kerja.
                        </p>
                        <div class="pt-2">
                            <button 
                                @click="resetForm()"
                                class="px-6 py-2.5 rounded-full bg-[#005952] hover:bg-[#004741] text-white text-xs font-bold uppercase tracking-wider transition-colors cursor-pointer shadow-sm"
                            >
                                <span x-text="$store.lang.t('Kirim Formulir Lainnya', 'Send Another Message')">Kirim Formulir Lainnya</span>
                            </button>
                        </div>
                    </div>

                    {{-- ACTIVE FORM --}}
                    <form 
                        x-show="!formSubmitted"
                        @submit.prevent="submitForm()" 
                        class="space-y-5 text-left"
                    >
                        {{-- Row 1: Name & Phone --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-xs font-bold text-gray-800 uppercase tracking-wider mb-1.5" x-text="$store.lang.t('Nama Lengkap *', 'Full Name *')">
                                    Nama Lengkap *
                                </label>
                                <input 
                                    type="text" 
                                    x-model="formData.name"
                                    :placeholder="$store.lang.t('Contoh: Budi Santoso', 'e.g. Johnathan Smith')"
                                    required
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50/70 focus:bg-white focus:border-[#005952] focus:ring-2 focus:ring-[#005952]/20 text-xs sm:text-sm text-gray-900 transition-all outline-none"
                                />
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-800 uppercase tracking-wider mb-1.5" x-text="$store.lang.t('Nomor Telepon / WhatsApp', 'Phone / WhatsApp')">
                                    Nomor Telepon / WhatsApp
                                </label>
                                <input 
                                    type="tel" 
                                    x-model="formData.phone"
                                    placeholder="+62 812 xxxx xxxx"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50/70 focus:bg-white focus:border-[#005952] focus:ring-2 focus:ring-[#005952]/20 text-xs sm:text-sm text-gray-900 transition-all outline-none"
                                />
                            </div>
                        </div>

                        {{-- Row 2: Email & Category --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-xs font-bold text-gray-800 uppercase tracking-wider mb-1.5" x-text="$store.lang.t('Alamat Email *', 'Email Address *')">
                                    Alamat Email *
                                </label>
                                <input 
                                    type="email" 
                                    x-model="formData.email"
                                    placeholder="name@organization.com"
                                    required
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50/70 focus:bg-white focus:border-[#005952] focus:ring-2 focus:ring-[#005952]/20 text-xs sm:text-sm text-gray-900 transition-all outline-none"
                                />
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-800 uppercase tracking-wider mb-1.5" x-text="$store.lang.t('Bidang Kolaborasi', 'Area of Collaboration')">
                                    Bidang Kolaborasi
                                </label>
                                <select 
                                    x-model="formData.category"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50/70 focus:bg-white focus:border-[#005952] focus:ring-2 focus:ring-[#005952]/20 text-xs sm:text-sm text-gray-900 transition-all outline-none"
                                >
                                    <option value="Inovasi & Akselerasi Inisiatif" x-text="$store.lang.t('Inovasi & Akselerasi Inisiatif', 'Innovation & Initiative Acceleration')">Inovasi & Akselerasi Inisiatif</option>
                                    <option value="Layanan Digital & IT Solutions">YOIN Digital (Web, Mobile, Cloud, IT)</option>
                                    <option value="Teknologi Pertanian & Maritim" x-text="$store.lang.t('AGRONEX Tech (Sensor, Irigasi, Logistik)', 'AGRONEX Tech (Sensors, Irrigation, Logistics)')">AGRONEX Tech (Sensor, Irigasi, Logistik)</option>
                                    <option value="Desain Produk & Material Sirkular" x-text="$store.lang.t('YOIMO Studio (Perabot & Kemasan Sirkular)', 'YOIMO Studio (Circular Living & Packaging)')">YOIMO Studio (Perabot & Kemasan Sirkular)</option>
                                    <option value="Inisiatif Masa Depan & IKN" x-text="$store.lang.t('BUATARA (Energi Bersih, Kota Cerdas, Sandbox)', 'BUATARA (Clean Energy, Smart Cities, Sandbox)')">BUATARA (Energi Bersih, Kota Cerdas, Sandbox)</option>
                                    <option value="Dampak Sosial & Program ESG" x-text="$store.lang.t('YAC (Konservasi, Komunitas, Audit ESG)', 'YAC (Conservation, Community, ESG Audit)')">YAC (Konservasi, Komunitas, Audit ESG)</option>
                                    <option value="Kemitraan Riset Akademisi" x-text="$store.lang.t('Kemitraan Riset & Kampus', 'Academic & Research Partnerships')">Kemitraan Riset & Kampus</option>
                                    <option value="Kontributor & Talenta Ekosistem" x-text="$store.lang.t('Bergabung sebagai Kontributor / Talenta', 'Join as a Contributor / Talent')">Bergabung sebagai Kontributor / Talenta</option>
                                </select>
                            </div>
                        </div>

                        {{-- Row 3: Message --}}
                        <div>
                            <label class="block text-xs font-bold text-gray-800 uppercase tracking-wider mb-1.5" x-text="$store.lang.t('Ringkasan Gagasan, Proyek, atau Kebutuhan Kolaborasi *', 'Summary of Idea, Project, or Collaboration Scope *')">
                                Ringkasan Gagasan, Proyek, atau Kebutuhan Kolaborasi *
                            </label>
                            <textarea 
                                rows="4"
                                x-model="formData.message"
                                :placeholder="$store.lang.t('Jelaskan secara ringkas latar belakang inisiatif, target capaian, atau bentuk dukungan yang diharapkan dari ekosistem YOIN...', 'Briefly describe your initiative background, target milestones, or expected synergies with the YOIN ecosystem...')"
                                required
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50/70 focus:bg-white focus:border-[#005952] focus:ring-2 focus:ring-[#005952]/20 text-xs sm:text-sm text-gray-900 transition-all outline-none resize-none"
                            ></textarea>
                        </div>

                        {{-- Submit Button --}}
                        <div class="pt-3 flex flex-col sm:flex-row items-center justify-between gap-4">
                            <button 
                                type="submit"
                                :disabled="isSubmitting"
                                class="w-full sm:w-auto px-8 py-3.5 rounded-full bg-[#005952] hover:bg-[#004741] active:scale-[0.99] text-white font-bold text-xs sm:text-sm tracking-wider uppercase transition-all duration-200 shadow-md shadow-[#005952]/25 flex items-center justify-center gap-2 cursor-pointer"
                            >
                                <span x-show="!isSubmitting" x-text="$store.lang.t('Kirim Formulir Kolaborasi', 'Send Collaboration Form')">Kirim Formulir Kolaborasi</span>
                                <span x-show="isSubmitting" x-text="$store.lang.t('Sedang Mengirimkan...', 'Submitting...')">Sedang Mengirimkan...</span>
                                <svg x-show="!isSubmitting" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </button>

                            <span class="text-[11px] text-gray-500 text-center sm:text-right">
                                Email: <a href="mailto:hello@yotainovasi.id" class="text-[#005952] font-semibold hover:underline">hello@yotainovasi.id</a> • WhatsApp: <a href="https://wa.me/6285862319524" target="_blank" class="text-[#005952] font-semibold hover:underline">0858 6231 9524</a>
                            </span>
                        </div>
                    </form>

                </div>
            </div>

            {{-- Footer Offices Info Strip --}}
            <div class="mt-8 text-center text-xs text-gray-500 flex flex-wrap items-center justify-center gap-3 sm:gap-4">
                <span x-text="$store.lang.t('Kantor: Perumahan Jatimekar residence, Blk. C No.26, Malakasari, Baleendah, Bandung, Jawa Barat 40375', 'Office: Jatimekar Residence, Blk. C No.26, Malakasari, Baleendah, Bandung, West Java 40375')">Kantor: Perumahan Jatimekar residence, Blk. C No.26, RT./RW.002/011, Malakasari, Kec. Baleendah, Kab. Bandung, Jawa Barat 40375</span>
                <span>•</span>
                <span x-text="$store.lang.t('Senin - Jumat: 08:00 - 17:00 WIB', 'Monday - Friday: 08:00 - 17:00 WIB')">Senin - Jumat: 08:00 - 17:00 WIB</span>
                <span>•</span>
                <span>&copy; {{ date('Y') }} PT Yota Inovasi Nusantara (YOIN)</span>
            </div>

        </div>
    </div>

</section>
