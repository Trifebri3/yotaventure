@extends('public.layouts.app')

@section('title', 'Syarat & Ketentuan | PT Yota Inovasi Nusantara (YOIN)')

@section('content')
<div class="bg-white min-h-screen pt-28 sm:pt-36 pb-24 text-slate-900 font-sans select-none">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-2 text-xs text-slate-500 mb-6">
            <a href="{{ url('/') }}" class="hover:text-[#004741] transition-colors" x-text="$store.lang.t('Beranda', 'Home')">Beranda</a>
            <span>/</span>
            <span class="text-slate-500" x-text="$store.lang.t('Legalitas & Tata Kelola', 'Legal & Governance')">Legalitas & Tata Kelola</span>
            <span>/</span>
            <span class="text-slate-950 font-semibold" x-text="$store.lang.t('Syarat & Ketentuan', 'Terms & Conditions')">Syarat & Ketentuan</span>
        </nav>

        {{-- Header Section --}}
        <div class="border-b border-slate-200 pb-10">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div class="max-w-3xl">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-slate-100 border border-slate-200 text-[11px] font-mono font-bold text-slate-800 uppercase mb-4">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#004741]"></span>
                        <span x-text="$store.lang.t('DOKUMEN HUKUM RESMI', 'OFFICIAL LEGAL DOCUMENT')">DOKUMEN HUKUM RESMI</span>
                    </div>
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-slate-950 tracking-tight leading-tight">
                        <span x-text="$store.lang.t('Syarat & Ketentuan Penggunaan Layanan', 'Terms & Conditions of Service')">
                            Syarat & Ketentuan Penggunaan Layanan
                        </span>
                    </h1>
                    <p class="mt-3 text-sm sm:text-base text-slate-600 leading-relaxed font-normal">
                        <span x-text="$store.lang.t('Ketentuan hukum yang mengikat penggunaan situs web, platform teknologi, produk inovasi, dan layanan konsultasi di bawah naungan PT Yota Inovasi Nusantara.', 'Binding legal provisions governing the access and utilization of websites, technology platforms, innovation initiatives, and advisory services operated by PT Yota Inovasi Nusantara.')">
                            Ketentuan hukum yang mengikat penggunaan situs web, platform teknologi, produk inovasi, dan layanan konsultasi di bawah naungan PT Yota Inovasi Nusantara.
                        </span>
                    </p>
                </div>

                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3 shrink-0 text-xs text-slate-500">
                    <div class="px-4 py-2 rounded-xl bg-slate-50 border border-slate-200 font-mono">
                        <span class="text-slate-400 block text-[10px] uppercase font-bold" x-text="$store.lang.t('Berlaku Efektif', 'Effective Date')">Berlaku Efektif</span>
                        <span class="font-bold text-slate-900">01 Januari 2026</span>
                    </div>
                    <button 
                        type="button" 
                        onclick="window.print()"
                        class="px-4 py-2 rounded-xl bg-slate-900 hover:bg-black text-white font-bold transition-all shadow-xs inline-flex items-center gap-2 cursor-pointer"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                        <span x-text="$store.lang.t('Cetak Dokumen', 'Print Document')">Cetak Dokumen</span>
                    </button>
                </div>
            </div>
        </div>

        {{-- Main Body: Two-Column Layout (Sticky Quick Jump on Left, Legal Content on Right) --}}
        <div class="mt-12 grid grid-cols-1 lg:grid-cols-12 gap-10">
            
            {{-- Quick Jump Navigation (Desktop Sticky) --}}
            <aside class="hidden lg:block lg:col-span-4">
                <div class="sticky top-28 bg-slate-50 p-6 rounded-2xl border border-slate-200 space-y-4 text-left">
                    <div class="flex items-center justify-between pb-3 border-b border-slate-200">
                        <span class="text-xs font-mono font-bold tracking-wider text-slate-700 uppercase" x-text="$store.lang.t('DAFTAR PASAL', 'TABLE OF CLAUSES')">
                            DAFTAR PASAL
                        </span>
                        <span class="text-[10px] font-mono text-slate-400">8 Pasal</span>
                    </div>
                    
                    <nav class="space-y-1.5 text-xs">
                        <a href="#pasal-1" class="block py-1.5 px-2.5 rounded-lg text-slate-700 hover:bg-white hover:text-[#004741] font-medium transition-colors">
                            1. <span x-text="$store.lang.t('Definisi & Ruang Lingkup', 'Definitions & Scope')">Definisi & Ruang Lingkup</span>
                        </a>
                        <a href="#pasal-2" class="block py-1.5 px-2.5 rounded-lg text-slate-700 hover:bg-white hover:text-[#004741] font-medium transition-colors">
                            2. <span x-text="$store.lang.t('Hak Kekayaan Intelektual (HAKI)', 'Intellectual Property Rights')">Hak Kekayaan Intelektual (HAKI)</span>
                        </a>
                        <a href="#pasal-3" class="block py-1.5 px-2.5 rounded-lg text-slate-700 hover:bg-white hover:text-[#004741] font-medium transition-colors">
                            3. <span x-text="$store.lang.t('Kepatuhan Penggunaan Platform', 'Permissible Platform Use')">Kepatuhan Penggunaan Platform</span>
                        </a>
                        <a href="#pasal-4" class="block py-1.5 px-2.5 rounded-lg text-slate-700 hover:bg-white hover:text-[#004741] font-medium transition-colors">
                            4. <span x-text="$store.lang.t('Layanan Inovasi & Sinergi Modal', 'Innovation & Capital Services')">Layanan Inovasi & Sinergi Modal</span>
                        </a>
                        <a href="#pasal-5" class="block py-1.5 px-2.5 rounded-lg text-slate-700 hover:bg-white hover:text-[#004741] font-medium transition-colors">
                            5. <span x-text="$store.lang.t('Batasan Tanggung Jawab (Disclaimer)', 'Limitation of Liability')">Batasan Tanggung Jawab (Disclaimer)</span>
                        </a>
                        <a href="#pasal-6" class="block py-1.5 px-2.5 rounded-lg text-slate-700 hover:bg-white hover:text-[#004741] font-medium transition-colors">
                            6. <span x-text="$store.lang.t('Tautan Pihak Ketiga & Integrasi API', 'Third-Party Links & Integrations')">Tautan Pihak Ketiga & Integrasi API</span>
                        </a>
                        <a href="#pasal-7" class="block py-1.5 px-2.5 rounded-lg text-slate-700 hover:bg-white hover:text-[#004741] font-medium transition-colors">
                            7. <span x-text="$store.lang.t('Hukum yang Berlaku & Yurisdiksi', 'Governing Law & Jurisdiction')">Hukum yang Berlaku & Yurisdiksi</span>
                        </a>
                        <a href="#pasal-8" class="block py-1.5 px-2.5 rounded-lg text-slate-700 hover:bg-white hover:text-[#004741] font-medium transition-colors">
                            8. <span x-text="$store.lang.t('Kontak Legalitas Korporasi', 'Corporate Legal Inquiries')">Kontak Legalitas Korporasi</span>
                        </a>
                    </nav>

                    <div class="pt-4 border-t border-slate-200">
                        <span class="text-[11px] text-slate-500 block" x-text="$store.lang.t('Pertanyaan seputar legalitas?', 'Questions about legal terms?')">Pertanyaan seputar legalitas?</span>
                        <a href="mailto:legal@yotainovasi.id" class="text-xs font-bold text-[#004741] hover:underline">legal@yotainovasi.id</a>
                    </div>
                </div>
            </aside>

            {{-- Main Legal Text Content --}}
            <main class="lg:col-span-8 space-y-12 text-left leading-relaxed text-slate-700 text-sm sm:text-base">
                
                {{-- PASAL 1 --}}
                <section id="pasal-1" class="scroll-mt-36 p-6 sm:p-8 rounded-3xl bg-slate-50 border border-slate-200">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="px-2.5 py-0.5 rounded-md bg-[#004741] text-white font-mono text-xs font-bold">PASAL 1</span>
                        <h2 class="text-lg sm:text-xl font-black text-slate-950 tracking-tight" x-text="$store.lang.t('Definisi & Ruang Lingkup Keberlakuan', 'Definitions & Scope of Applicability')">
                            Definisi & Ruang Lingkup Keberlakuan
                        </h2>
                    </div>

                    <div x-show="$store.lang.isID()" class="space-y-3 font-normal">
                        <p>1.1. <strong>"YOIN"</strong> atau <strong>"Perusahaan"</strong> merujuk pada <strong>PT Yota Inovasi Nusantara</strong>, suatu perseroan terbatas yang didirikan dan tunduk secara sah di bawah hukum Negara Kesatuan Republik Indonesia.</p>
                        <p>1.2. <strong>"Layanan"</strong> mencakup seluruh portal web, infrastruktur aplikasi perangkat lunak, sistem komputasi awan berdaulat, data room kemitraan investasi, materi riset terpublikasi, serta inisiatif ekosistem teknologi yang disediakan secara langsung maupun melalui anak entitas holding YOIN.</p>
                        <p>1.3. <strong>"Pengguna"</strong> adalah setiap individu, korporasi, lembaga penelitian, atau mitra institusional yang mengakses, menjelajahi, atau memanfaatkan ekosistem digital YOIN.</p>
                        <p>1.4. Dengan mengakses situs ini, Pengguna menyatakan telah membaca, memahami, dan menyetujui untuk terikat secara penuh pada Syarat & Ketentuan ini.</p>
                    </div>

                    <div x-show="$store.lang.isEN()" x-cloak class="space-y-3 font-normal">
                        <p>1.1. <strong>"YOIN"</strong> or the <strong>"Company"</strong> refers to <strong>PT Yota Inovasi Nusantara</strong>, a limited liability company organized and lawfully existing under the laws of the Republic of Indonesia.</p>
                        <p>1.2. <strong>"Services"</strong> encompasses all web portals, software applications, sovereign cloud infrastructures, investment data rooms, published research papers, and technology initiatives operated directly or via subsidiaries under the YOIN holding umbrella.</p>
                        <p>1.3. <strong>"User"</strong> means any individual, enterprise, research institute, or public entity accessing, browsing, or utilizing the YOIN digital ecosystem.</p>
                        <p>1.4. By accessing or using this site, you acknowledge that you have read, understood, and agreed to be bound unreservedly by these Terms and Conditions.</p>
                    </div>
                </section>

                {{-- PASAL 2 --}}
                <section id="pasal-2" class="scroll-mt-36 p-6 sm:p-8 rounded-3xl bg-white border border-slate-200 shadow-xs">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="px-2.5 py-0.5 rounded-md bg-[#004741] text-white font-mono text-xs font-bold">PASAL 2</span>
                        <h2 class="text-lg sm:text-xl font-black text-slate-950 tracking-tight" x-text="$store.lang.t('Hak Kekayaan Intelektual & Kepemilikan Materi', 'Intellectual Property Rights & Proprietary Content')">
                            Hak Kekayaan Intelektual & Kepemilikan Materi
                        </h2>
                    </div>

                    <div x-show="$store.lang.isID()" class="space-y-3 font-normal">
                        <p>2.1. Seluruh rancang bangun, arsitektur kode sumber, basis data, logo, merek dagang "YOIN", tipografi visual, artikel riset, fotografi, dan materi multimedia yang tercantum pada situs web ini merupakan kekayaan intelektual eksklusif PT Yota Inovasi Nusantara atau para pemegang lisensi resminya.</p>
                        <p>2.2. Pengguna dilarang keras mereproduksi, mendistribusikan ulang, merekayasa balik (*reverse engineering*), mengikis (*scraping*), atau mengeksploitasi materi intelektual Perusahaan untuk kepentingan komersial pihak ketiga tanpa persetujuan tertulis resmi dari Direksi YOIN.</p>
                        <p>2.3. Sitasi kutipan untuk keperluan akademis atau pemberitaan jurnalistik diperkenankan sepanjang mencantumkan atribusi sumber yang jelas dan tautan resmi ke domain <em>yotainovasi.id</em>.</p>
                    </div>

                    <div x-show="$store.lang.isEN()" x-cloak class="space-y-3 font-normal">
                        <p>2.1. All system designs, source code architecture, proprietary databases, the "YOIN" trademark and logotype, visual typography, research journals, photography, and multimedia assets are the exclusive intellectual property of PT Yota Inovasi Nusantara or its licensors.</p>
                        <p>2.2. Users are expressly prohibited from copying, distributing, reverse-engineering, automated data scraping, or commercializing any intellectual assets without prior explicit written authorization from YOIN\'s Executive Board.</p>
                        <p>2.3. Academic and journalistic citations are permitted provided proper attribution and active hyperlinks to <em>yotainovasi.id</em> are conspicuously maintained.</p>
                    </div>
                </section>

                {{-- PASAL 3 --}}
                <section id="pasal-3" class="scroll-mt-36 p-6 sm:p-8 rounded-3xl bg-slate-50 border border-slate-200">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="px-2.5 py-0.5 rounded-md bg-[#004741] text-white font-mono text-xs font-bold">PASAL 3</span>
                        <h2 class="text-lg sm:text-xl font-black text-slate-950 tracking-tight" x-text="$store.lang.t('Kepatuhan & Larangan Penggunaan Platform', 'Permissible Use & Prohibited Conduct')">
                            Kepatuhan & Larangan Penggunaan Platform
                        </h2>
                    </div>

                    <div x-show="$store.lang.isID()" class="space-y-3 font-normal">
                        <p>3.1. Pengguna wajib mematuhi seluruh peraturan perundang-undangan Republik Indonesia yang berlaku, termasuk Undang-Undang Informasi dan Transaksi Elektronik (UU ITE) serta Undang-Undang Perlindungan Data Pribadi (UU PDP).</p>
                        <p>3.2. Larangan keras diberlakukan terhadap:</p>
                        <ul class="list-disc pl-5 space-y-1.5 text-slate-700">
                            <li>Percobaan peretasan, penetrasi keamanan, atau serangan penolakan layanan (DDoS) terhadap peladen YOIN.</li>
                            <li>Penyebaran perangkat lunak berbahaya, virus, trojan, atau skrip eksploitasi otomatis.</li>
                            <li>Pemberian data identitas palsu saat mengajukan formulir kolaborasi, kemitraan, maupun rekrutmen.</li>
                        </ul>
                    </div>

                    <div x-show="$store.lang.isEN()" x-cloak class="space-y-3 font-normal">
                        <p>3.1. Users must comply with all relevant legal frameworks of the Republic of Indonesia, including Electronic Information and Transactions regulations and the Personal Data Protection Act.</p>
                        <p>3.2. Prohibited activities strictly include:</p>
                        <ul class="list-disc pl-5 space-y-1.5 text-slate-700">
                            <li>Attempting unauthorized server access, penetration exploits, or denial-of-service (DDoS) attacks against YOIN networks.</li>
                            <li>Injecting malicious software, Trojans, worms, or automated extraction payloads.</li>
                            <li>Submitting false identities or fabricated records across collaboration, investor, or procurement intake forms.</li>
                        </ul>
                    </div>
                </section>

                {{-- PASAL 4 --}}
                <section id="pasal-4" class="scroll-mt-36 p-6 sm:p-8 rounded-3xl bg-white border border-slate-200 shadow-xs">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="px-2.5 py-0.5 rounded-md bg-[#004741] text-white font-mono text-xs font-bold">PASAL 4</span>
                        <h2 class="text-lg sm:text-xl font-black text-slate-950 tracking-tight" x-text="$store.lang.t('Layanan Inovasi, Kemitraan & Sinergi Modal', 'Innovation Initiatives & Capital Synergy')">
                            Layanan Inovasi, Kemitraan & Sinergi Modal
                        </h2>
                    </div>

                    <div x-show="$store.lang.isID()" class="space-y-3 font-normal">
                        <p>4.1. Informasi yang disajikan pada kanal Investasi dan Ekosistem Inovasi ditujukan semata-mata sebagai informasi korporasi umum dan tidak dapat ditafsirkan sebagai penawaran umum sekuritas, nasihat keuangan mengikat, atau jaminan imbal hasil investasi spekulatif.</p>
                        <p>4.2. Kemitraan strategis dan aliansi modal diatur secara terpisah melalui Perjanjian Kerahasiaan (*Non-Disclosure Agreement*) dan Perjanjian Kerjasama (*Definitive Legal Agreement*) yang ditandatangani oleh pihak yang berwenang.</p>
                    </div>

                    <div x-show="$store.lang.isEN()" x-cloak class="space-y-3 font-normal">
                        <p>4.1. Information presented within the Investment and Ecosystem channels is provided solely for corporate transparency and does not constitute an offer of public securities or binding financial advice.</p>
                        <p>4.2. Strategic partnerships, co-investments, and joint ventures are governed strictly under separate Non-Disclosure Agreements and Definitive Partnership Contracts executed by authorized corporate signatories.</p>
                    </div>
                </section>

                {{-- PASAL 5 --}}
                <section id="pasal-5" class="scroll-mt-36 p-6 sm:p-8 rounded-3xl bg-slate-50 border border-slate-200">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="px-2.5 py-0.5 rounded-md bg-[#004741] text-white font-mono text-xs font-bold">PASAL 5</span>
                        <h2 class="text-lg sm:text-xl font-black text-slate-950 tracking-tight" x-text="$store.lang.t('Batasan Tanggung Jawab (Limitation of Liability)', 'Limitation of Liability & Disclaimers')">
                            Batasan Tanggung Jawab (Limitation of Liability)
                        </h2>
                    </div>

                    <div x-show="$store.lang.isID()" class="space-y-3 font-normal">
                        <p>5.1. Situs web dan seluruh konten disajikan atas dasar <em>"sebagaimana adanya" (as is)</em> dan <em>"sebagaimana tersedia" (as available)</em>. Perusahaan berupaya maksimal memastikan akurasi data namun tidak memberikan jaminan mutlak tanpa cela atau ketiadaan gangguan teknis berkala.</p>
                        <p>5.2. Dalam batas yang diperkenankan oleh hukum, YOIN tidak bertanggung jawab atas kerugian tidak langsung, insidental, atau kerugian konsekuensial yang timbul dari ketidakmampuan Pengguna mengakses layanan.</p>
                    </div>

                    <div x-show="$store.lang.isEN()" x-cloak class="space-y-3 font-normal">
                        <p>5.1. The website and all published resources are provided on an <em>"as is"</em> and <em>"as available"</em> basis. While the Company adheres to stringent quality standards, no warranty is made that services will be uninterrupted or error-free at all times.</p>
                        <p>5.2. To the maximum extent permitted by applicable law, YOIN disclaims liability for indirect, punitive, or consequential damages resulting from platform downtime or third-party telecommunication failures.</p>
                    </div>
                </section>

                {{-- PASAL 6 --}}
                <section id="pasal-6" class="scroll-mt-36 p-6 sm:p-8 rounded-3xl bg-white border border-slate-200 shadow-xs">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="px-2.5 py-0.5 rounded-md bg-[#004741] text-white font-mono text-xs font-bold">PASAL 6</span>
                        <h2 class="text-lg sm:text-xl font-black text-slate-950 tracking-tight" x-text="$store.lang.t('Tautan Pihak Ketiga & Integrasi API', 'External Links & API Integrations')">
                            Tautan Pihak Ketiga & Integrasi API
                        </h2>
                    </div>

                    <div x-show="$store.lang.isID()" class="space-y-3 font-normal">
                        <p>6.1. Platform kami dapat memuat tautan menuju situs web atau layanan pihak ketiga (misalnya penyedia peta, jejaring mitra, repositori ilmiah). YOIN tidak mengendalikan dan tidak bertanggung jawab atas kebijakan privasi atau isi dari situs eksternal tersebut.</p>
                    </div>

                    <div x-show="$store.lang.isEN()" x-cloak class="space-y-3 font-normal">
                        <p>6.1. Our platform may contain outbound hyperlinks to third-party institutions (partner portals, satellite mapping, scholarly repositories). YOIN exercises no supervisory control over external platforms and assumes no responsibility for third-party practices.</p>
                    </div>
                </section>

                {{-- PASAL 7 --}}
                <section id="pasal-7" class="scroll-mt-36 p-6 sm:p-8 rounded-3xl bg-slate-50 border border-slate-200">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="px-2.5 py-0.5 rounded-md bg-[#004741] text-white font-mono text-xs font-bold">PASAL 7</span>
                        <h2 class="text-lg sm:text-xl font-black text-slate-950 tracking-tight" x-text="$store.lang.t('Hukum yang Berlaku & Penyelesaian Sengketa', 'Governing Law & Dispute Resolution')">
                            Hukum yang Berlaku & Penyelesaian Sengketa
                        </h2>
                    </div>

                    <div x-show="$store.lang.isID()" class="space-y-3 font-normal">
                        <p>7.1. Syarat & Ketentuan ini diatur dan ditafsirkan semata-mata berdasarkan hukum yang berlaku di Republik Indonesia.</p>
                        <p>7.2. Segala perselisihan yang timbul dari pelaksanaan ketentuan ini diselesaikan secara musyawarah untuk mufakat dalam waktu 30 (tiga puluh) hari kalender. Apabila mufakat tidak tercapai, sengketa akan diselesaikan melalui Badan Arbitrase Nasional Indonesia (BANI) atau Pengadilan Negeri yang memiliki yurisdiksi di wilayah domisili hukum Perusahaan.</p>
                    </div>

                    <div x-show="$store.lang.isEN()" x-cloak class="space-y-3 font-normal">
                        <p>7.1. These Terms and Conditions shall be governed by and construed in accordance with the laws of the Republic of Indonesia.</p>
                        <p>7.2. Any dispute arising in connection with these terms shall first be negotiated amicably within thirty (30) days. Failing amicable settlement, the dispute shall be resolved through final binding arbitration under the rules of the Indonesian National Board of Arbitration (BANI) or competent courts having jurisdiction over the Company\'s legal domicile.</p>
                    </div>
                </section>

                {{-- PASAL 8 --}}
                <section id="pasal-8" class="scroll-mt-36 p-6 sm:p-8 rounded-3xl bg-white border border-slate-200 shadow-xs">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="px-2.5 py-0.5 rounded-md bg-[#004741] text-white font-mono text-xs font-bold">PASAL 8</span>
                        <h2 class="text-lg sm:text-xl font-black text-slate-950 tracking-tight" x-text="$store.lang.t('Kontak Legalitas Korporasi', 'Corporate Legal Inquiries')">
                            Kontak Legalitas Korporasi
                        </h2>
                    </div>

                    <div class="space-y-3 font-normal">
                        <p x-text="$store.lang.t('Untuk pemberitahuan resmi atau pertanyaan terkait dokumen Syarat & Ketentuan ini, silakan hubungi tim legalitas korporat kami:', 'For official legal notices or inquiries concerning these Terms & Conditions, please contact our legal counsel:')">
                            Untuk pemberitahuan resmi atau pertanyaan terkait dokumen Syarat & Ketentuan ini, silakan hubungi tim legalitas korporat kami:
                        </p>
                        <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 font-mono text-xs text-slate-800 space-y-1">
                            <p class="font-bold text-slate-950">LEGAL & COMPLIANCE DIVISION - PT YOTA INOVASI NUSANTARA</p>
                            <p>Perumahan Jatimekar Residence, Blok C No. 26, Malakasari, Baleendah, Kabupaten Bandung, Jawa Barat 40375</p>
                            <p>Surel Resmi: <a href="mailto:legal@yotainovasi.id" class="text-[#004741] font-bold hover:underline">legal@yotainovasi.id</a> | Telepon: +62 858 6231 9524</p>
                        </div>
                    </div>
                </section>

            </main>

        </div>

    </div>
</div>
@endsection
