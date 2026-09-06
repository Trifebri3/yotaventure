@extends('public.layouts.app')

@section('title', 'Kebijakan Privasi & Perlindungan Data | PT Yota Inovasi Nusantara (YOIN)')

@section('content')
<div class="bg-white min-h-screen pt-28 sm:pt-36 pb-24 text-slate-900 font-sans select-none">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-2 text-xs text-slate-500 mb-6">
            <a href="{{ url('/') }}" class="hover:text-[#004741] transition-colors" x-text="$store.lang.t('Beranda', 'Home')">Beranda</a>
            <span>/</span>
            <span class="text-slate-500" x-text="$store.lang.t('Legalitas & Tata Kelola', 'Legal & Governance')">Legalitas & Tata Kelola</span>
            <span>/</span>
            <span class="text-slate-950 font-semibold" x-text="$store.lang.t('Kebijakan Privasi', 'Privacy Policy')">Kebijakan Privasi</span>
        </nav>

        {{-- Header Section --}}
        <div class="border-b border-slate-200 pb-10">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div class="max-w-3xl">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-slate-100 border border-slate-200 text-[11px] font-mono font-bold text-slate-800 uppercase mb-4">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#004741]"></span>
                        <span x-text="$store.lang.t('KEPATUHAN UU PDP NO. 27/2022', 'COMPLIANCE WITH INDONESIAN PDP ACT NO. 27/2022')">KEPATUHAN UU PDP NO. 27/2022</span>
                    </div>
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-slate-950 tracking-tight leading-tight">
                        <span x-text="$store.lang.t('Kebijakan Privasi & Tata Kelola Data Pribadi', 'Privacy Policy & Personal Data Governance')">
                            Kebijakan Privasi & Tata Kelola Data Pribadi
                        </span>
                    </h1>
                    <p class="mt-3 text-sm sm:text-base text-slate-600 leading-relaxed font-normal">
                        <span x-text="$store.lang.t('Komitmen transparansi PT Yota Inovasi Nusantara dalam mengumpulkan, mengelola, memproses, dan melindungi hak-hak data pribadi Pengguna sesuai standar hukum tertinggi.', 'PT Yota Inovasi Nusantara\'s commitment to transparency, security, and stewardship in collecting, processing, and safeguarding User personal data rights pursuant to statutory regulations.')">
                            Komitmen transparansi PT Yota Inovasi Nusantara dalam mengumpulkan, mengelola, memproses, dan melindungi hak-hak data pribadi Pengguna sesuai standar hukum tertinggi.
                        </span>
                    </p>
                </div>

                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3 shrink-0 text-xs text-slate-500">
                    <div class="px-4 py-2 rounded-xl bg-slate-50 border border-slate-200 font-mono">
                        <span class="text-slate-400 block text-[10px] uppercase font-bold" x-text="$store.lang.t('Versi Kepatuhan', 'Compliance Version')">Versi Kepatuhan</span>
                        <span class="font-bold text-slate-900">PDP-2026.V2</span>
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

        {{-- Main Body: Two-Column Layout --}}
        <div class="mt-12 grid grid-cols-1 lg:grid-cols-12 gap-10">
            
            {{-- Quick Jump Navigation --}}
            <aside class="hidden lg:block lg:col-span-4">
                <div class="sticky top-28 bg-slate-50 p-6 rounded-2xl border border-slate-200 space-y-4 text-left">
                    <div class="flex items-center justify-between pb-3 border-b border-slate-200">
                        <span class="text-xs font-mono font-bold tracking-wider text-slate-700 uppercase" x-text="$store.lang.t('DAFTAR BAB PRIVASI', 'PRIVACY SECTIONS')">
                            DAFTAR BAB PRIVASI
                        </span>
                        <span class="text-[10px] font-mono text-slate-400">8 Bagian</span>
                    </div>
                    
                    <nav class="space-y-1.5 text-xs">
                        <a href="#privasi-1" class="block py-1.5 px-2.5 rounded-lg text-slate-700 hover:bg-white hover:text-[#004741] font-medium transition-colors">
                            1. <span x-text="$store.lang.t('Identitas Pengendali Data', 'Data Controller Identity')">Identitas Pengendali Data</span>
                        </a>
                        <a href="#privasi-2" class="block py-1.5 px-2.5 rounded-lg text-slate-700 hover:bg-white hover:text-[#004741] font-medium transition-colors">
                            2. <span x-text="$store.lang.t('Kategori Data yang Dikumpulkan', 'Categories of Collected Data')">Kategori Data yang Dikumpulkan</span>
                        </a>
                        <a href="#privasi-3" class="block py-1.5 px-2.5 rounded-lg text-slate-700 hover:bg-white hover:text-[#004741] font-medium transition-colors">
                            3. <span x-text="$store.lang.t('Tujuan & Dasar Pemrosesan', 'Processing Purposes & Legal Basis')">Tujuan & Dasar Pemrosesan</span>
                        </a>
                        <a href="#privasi-4" class="block py-1.5 px-2.5 rounded-lg text-slate-700 hover:bg-white hover:text-[#004741] font-medium transition-colors">
                            4. <span x-text="$store.lang.t('Hak Subjek Data Pribadi', 'Data Subject Rights')">Hak Subjek Data Pribadi</span>
                        </a>
                        <a href="#privasi-5" class="block py-1.5 px-2.5 rounded-lg text-slate-700 hover:bg-white hover:text-[#004741] font-medium transition-colors">
                            5. <span x-text="$store.lang.t('Penyimpanan & Retensi Data', 'Data Storage & Retention')">Penyimpanan & Retensi Data</span>
                        </a>
                        <a href="#privasi-6" class="block py-1.5 px-2.5 rounded-lg text-slate-700 hover:bg-white hover:text-[#004741] font-medium transition-colors">
                            6. <span x-text="$store.lang.t('Cookies & Telemetri Analitik', 'Cookies & Telemetry')">Cookies & Telemetri Analitik</span>
                        </a>
                        <a href="#privasi-7" class="block py-1.5 px-2.5 rounded-lg text-slate-700 hover:bg-white hover:text-[#004741] font-medium transition-colors">
                            7. <span x-text="$store.lang.t('Keamanan & Transfer Data', 'Security & Cross-Border Transfers')">Keamanan & Transfer Data</span>
                        </a>
                        <a href="#privasi-8" class="block py-1.5 px-2.5 rounded-lg text-slate-700 hover:bg-white hover:text-[#004741] font-medium transition-colors">
                            8. <span x-text="$store.lang.t('Kontak DPO (Data Protection Officer)', 'DPO Contact Officer')">Kontak DPO (Data Protection Officer)</span>
                        </a>
                    </nav>

                    <div class="pt-4 border-t border-slate-200">
                        <span class="text-[11px] text-slate-500 block" x-text="$store.lang.t('Pertanyaan hak privasi data?', 'Questions regarding data rights?')">Pertanyaan hak privasi data?</span>
                        <a href="mailto:dpo@yotainovasi.id" class="text-xs font-bold text-[#004741] hover:underline">dpo@yotainovasi.id</a>
                    </div>
                </div>
            </aside>

            {{-- Main Privacy Content --}}
            <main class="lg:col-span-8 space-y-12 text-left leading-relaxed text-slate-700 text-sm sm:text-base">
                
                {{-- BAGIAN 1 --}}
                <section id="privasi-1" class="scroll-mt-36 p-6 sm:p-8 rounded-3xl bg-slate-50 border border-slate-200">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="px-2.5 py-0.5 rounded-md bg-[#004741] text-white font-mono text-xs font-bold">BAB 1</span>
                        <h2 class="text-lg sm:text-xl font-black text-slate-950 tracking-tight" x-text="$store.lang.t('Identitas Pengendali Data Pribadi', 'Data Controller Legal Identity')">
                            Identitas Pengendali Data Pribadi
                        </h2>
                    </div>

                    <div x-show="$store.lang.isID()" class="space-y-3 font-normal">
                        <p>Pengendali Data Pribadi untuk seluruh informasi yang diproses melalui portal dan ekosistem digital ini adalah <strong>PT Yota Inovasi Nusantara</strong>, beralamat kantor di Perumahan Jatimekar Residence, Blok C No. 26, Malakasari, Baleendah, Kabupaten Bandung, Jawa Barat 40375, Indonesia.</p>
                        <p>Perusahaan bertanggung jawab penuh atas pemrosesan data pribadi Pengguna dengan menerapkan prinsip-prinsip perlindungan data: legalitas, transparansi, pembatasan tujuan, minimalisasi data, akurasi, dan integritas kerahasiaan.</p>
                    </div>

                    <div x-show="$store.lang.isEN()" x-cloak class="space-y-3 font-normal">
                        <p>The designated Personal Data Controller for all operational processing across this portal and digital ecosystem is <strong>PT Yota Inovasi Nusantara</strong>, registered at Jatimekar Residence, Block C No. 26, Malakasari, Baleendah, Bandung Regency, West Java 40375, Indonesia.</p>
                        <p>The Company assumes full fiduciary responsibility as data controller, strictly enforcing the principles of lawfulness, fairness, transparency, purpose limitation, data minimization, accuracy, and storage integrity.</p>
                    </div>
                </section>

                {{-- BAGIAN 2 --}}
                <section id="privasi-2" class="scroll-mt-36 p-6 sm:p-8 rounded-3xl bg-white border border-slate-200 shadow-xs">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="px-2.5 py-0.5 rounded-md bg-[#004741] text-white font-mono text-xs font-bold">BAB 2</span>
                        <h2 class="text-lg sm:text-xl font-black text-slate-950 tracking-tight" x-text="$store.lang.t('Kategori Data Pribadi yang Dikumpulkan', 'Categories of Personal Data Collected')">
                            Kategori Data Pribadi yang Dikumpulkan
                        </h2>
                    </div>

                    <div x-show="$store.lang.isID()" class="space-y-3 font-normal">
                        <p>Kami mengumpulkan data pribadi yang diberikan secara sukarela maupun otomatis saat Anda berinteraksi dengan situs kami:</p>
                        <ul class="list-disc pl-5 space-y-1.5 text-slate-700">
                            <li><strong>Data Identitas & Kontak:</strong> Nama lengkap, alamat surat elektronik (email), nomor telepon/WhatsApp, institusi afiliasi, dan posisi jabatan (dikumpulkan melalui formulir inkuiri kolaborasi, unduh dokumen laporan ESG, atau kontak kantor).</li>
                            <li><strong>Data Teknis & Akses:</strong> Alamat IP, jenis peramban (browser), sistem operasi, resolusi perangkat, halaman rujukan (*referrer*), dan cap waktu kunjungan (dikumpulkan untuk analitik keamanan dan optimasi performa web).</li>
                            <li><strong>Data Komunikasi Resmi:</strong> Riwayat korespondensi, pesan kemitraan, serta materi proposal kerja sama yang Anda kirimkan.</li>
                        </ul>
                    </div>

                    <div x-show="$store.lang.isEN()" x-cloak class="space-y-3 font-normal">
                        <p>We process personal data provided voluntarily as well as automatically during platform interactions:</p>
                        <ul class="list-disc pl-5 space-y-1.5 text-slate-700">
                            <li><strong>Identification & Contact Data:</strong> Full legal name, official email address, phone/WhatsApp number, institutional affiliation, and job title (collected via collaboration inquiries, ESG document requests, and corporate contact forms).</li>
                            <li><strong>Technical & Telemetry Data:</strong> IP address, browser user-agent, operating system, screen dimensions, referring URL, and session timestamps (logged for intrusion defense and performance diagnostics).</li>
                            <li><strong>Official Correspondence Data:</strong> Message histories, collaboration dossiers, and partnership inquiries submitted to our team.</li>
                        </ul>
                    </div>
                </section>

                {{-- BAGIAN 3 --}}
                <section id="privasi-3" class="scroll-mt-36 p-6 sm:p-8 rounded-3xl bg-slate-50 border border-slate-200">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="px-2.5 py-0.5 rounded-md bg-[#004741] text-white font-mono text-xs font-bold">BAB 3</span>
                        <h2 class="text-lg sm:text-xl font-black text-slate-950 tracking-tight" x-text="$store.lang.t('Tujuan & Dasar Hukum Pemrosesan Data', 'Processing Purposes & Statutory Legal Basis')">
                            Tujuan & Dasar Hukum Pemrosesan Data
                        </h2>
                    </div>

                    <div x-show="$store.lang.isID()" class="space-y-3 font-normal">
                        <p>Berdasarkan Pasal 20 UU No. 27/2022 tentang Perlindungan Data Pribadi, pemrosesan data dilakukan atas dasar persetujuan eksplisit, pemenuhan kewajiban perjanjian kemitraan, atau kepentingan sah Perusahaan (*legitimate interest*):</p>
                        <ul class="list-disc pl-5 space-y-1.5 text-slate-700">
                            <li>Menanggapi dan menindaklanjuti inkuiri kerja sama, riset bersama, dan kemitraan ekosistem.</li>
                            <li>Menyediakan akses dokumen publikasi, laporan keberlanjutan ESG, dan data room investasi bagi mitra terverifikasi.</li>
                            <li>Memelihara keandalan infrastruktur, mencegah serangan siber, dan memenuhi kewajiban pelaporan hukum regulasi Indonesia.</li>
                        </ul>
                        <p class="font-bold text-slate-950 pt-2">YOIN tidak pernah dan tidak akan pernah menjual, menyewakan, atau memperdagangkan data pribadi Anda kepada pihak ketiga manapun untuk tujuan pemasaran komersial pihak ketiga.</p>
                    </div>

                    <div x-show="$store.lang.isEN()" x-cloak class="space-y-3 font-normal">
                        <p>Pursuant to Article 20 of Indonesian Law No. 27/2022 on Personal Data Protection, processing is executed strictly on lawful bases: explicit User consent, performance of contractual engagements, or corporate legitimate interest:</p>
                        <ul class="list-disc pl-5 space-y-1.5 text-slate-700">
                            <li>Evaluating and responding to partnership proposals, joint research tracks, and enterprise inquiries.</li>
                            <li>Delivering verified access to downloadable research publications, impact filings, and investor dossiers.</li>
                            <li>Securing infrastructure integrity, mitigating automated threats, and ensuring statutory compliance under Indonesian jurisdiction.</li>
                        </ul>
                        <p class="font-bold text-slate-950 pt-2">YOIN does not, and will never, sell, rent, or trade your personal records to third-party commercial marketing brokers.</p>
                    </div>
                </section>

                {{-- BAGIAN 4 --}}
                <section id="privasi-4" class="scroll-mt-36 p-6 sm:p-8 rounded-3xl bg-white border border-slate-200 shadow-xs">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="px-2.5 py-0.5 rounded-md bg-[#004741] text-white font-mono text-xs font-bold">BAB 4</span>
                        <h2 class="text-lg sm:text-xl font-black text-slate-950 tracking-tight" x-text="$store.lang.t('Hak-Hak Subjek Data Pribadi (Pengguna)', 'Data Subject Statutory Rights')">
                            Hak-Hak Subjek Data Pribadi (Pengguna)
                        </h2>
                    </div>

                    <div x-show="$store.lang.isID()" class="space-y-3 font-normal">
                        <p>Sesuai amanat UU PDP, Anda selaku Subjek Data memiliki hak-hak yang diakui hukum:</p>
                        <ul class="list-disc pl-5 space-y-1.5 text-slate-700">
                            <li><strong>Hak Akses & Informasi:</strong> Mengetahui identitas pengendali dan salinan data pribadi Anda yang kami simpan.</li>
                            <li><strong>Hak Perbaikan & Pembaruan:</strong> Memperbaiki data pribadi yang tidak akurat, tidak lengkap, atau usang.</li>
                            <li><strong>Hak Penghapusan & Pemusnahan (*Right to Erasure*):</strong> Meminta penghapusan data Anda dari peladen aktif kami apabila tujuan pemrosesan telah tercapai.</li>
                            <li><strong>Hak Penarikan Persetujuan:</strong> Menarik kembali persetujuan pemrosesan data kapan saja tanpa membatalkan keabsahan pemrosesan sebelumnya.</li>
                        </ul>
                        <p>Permintaan hak dapat diajukan secara resmi melalui surat elektronik ke <strong>dpo@yotainovasi.id</strong>.</p>
                    </div>

                    <div x-show="$store.lang.isEN()" x-cloak class="space-y-3 font-normal">
                        <p>Under the Indonesian Personal Data Protection Act, you possess clear statutory rights:</p>
                        <ul class="list-disc pl-5 space-y-1.5 text-slate-700">
                            <li><strong>Right of Access & Portability:</strong> Obtain confirmation and verified copies of your personal data stored within our records.</li>
                            <li><strong>Right to Rectification:</strong> Request prompt correction of incomplete, inaccurate, or outdated records.</li>
                            <li><strong>Right to Erasure:</strong> Demand permanent deletion of your data when retention is no longer justified by law or contract.</li>
                            <li><strong>Right to Withdraw Consent:</strong> Revoke consent at any time without invalidating prior lawful processing.</li>
                        </ul>
                        <p>To exercise your rights, submit a verified request directly to <strong>dpo@yotainovasi.id</strong>.</p>
                    </div>
                </section>

                {{-- BAGIAN 5 --}}
                <section id="privasi-5" class="scroll-mt-36 p-6 sm:p-8 rounded-3xl bg-slate-50 border border-slate-200">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="px-2.5 py-0.5 rounded-md bg-[#004741] text-white font-mono text-xs font-bold">BAB 5</span>
                        <h2 class="text-lg sm:text-xl font-black text-slate-950 tracking-tight" x-text="$store.lang.t('Penyimpanan, Retensi & Pemusnahan Data', 'Data Retention & Safe Disposal')">
                            Penyimpanan, Retensi & Pemusnahan Data
                        </h2>
                    </div>

                    <div x-show="$store.lang.isID()" class="space-y-3 font-normal">
                        <p>5.1. Data pribadi disimpan pada pusat data terakreditasi ISO/IEC 27001 yang berlokasi di wilayah hukum Republik Indonesia (kedaulatan data domestik).</p>
                        <p>5.2. Data inkuiri kolaborasi dan korespondensi disimpan maksimal selama 5 (lima) tahun sejak interaksi terakhir untuk kepentingan audit korporasi dan kepatuhan arsip hukum, setelah itu akan dimusnahkan secara aman dan permanen.</p>
                    </div>

                    <div x-show="$store.lang.isEN()" x-cloak class="space-y-3 font-normal">
                        <p>5.1. Personal records are hosted on ISO/IEC 27001-certified infrastructure physically situated within the sovereign territory of the Republic of Indonesia.</p>
                        <p>5.2. Inquiries and contractual records are retained for a maximum duration of five (5) years following final correspondence to satisfy audit and regulatory statutes, after which they are irreversibly destroyed.</p>
                    </div>
                </section>

                {{-- BAGIAN 6 --}}
                <section id="privasi-6" class="scroll-mt-36 p-6 sm:p-8 rounded-3xl bg-white border border-slate-200 shadow-xs">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="px-2.5 py-0.5 rounded-md bg-[#004741] text-white font-mono text-xs font-bold">BAB 6</span>
                        <h2 class="text-lg sm:text-xl font-black text-slate-950 tracking-tight" x-text="$store.lang.t('Cookies & Teknologi Penyimpanan Lokal', 'Cookies & Local Storage Technology')">
                            Cookies & Teknologi Penyimpanan Lokal
                        </h2>
                    </div>

                    <div x-show="$store.lang.isID()" class="space-y-3 font-normal">
                        <p>Situs kami menggunakan <em>Local Storage</em> dan <em>Cookies Esensial</em> untuk:</p>
                        <ul class="list-disc pl-5 space-y-1.5 text-slate-700">
                            <li>Menyimpan preferensi bahasa Pengguna (ID atau EN) agar tetap aktif saat membuka halaman berikutnya.</li>
                            <li>Mencegah duplikasi hitungan pembaca artikel (*view counter*) saat memuat ulang halaman.</li>
                            <li>Menjaga sesi autentikasi yang aman bagi staf pengelola konten.</li>
                        </ul>
                    </div>

                    <div x-show="$store.lang.isEN()" x-cloak class="space-y-3 font-normal">
                        <p>Our web portal employs <em>Local Storage</em> and strictly essential <em>Cookies</em> solely to:</p>
                        <ul class="list-disc pl-5 space-y-1.5 text-slate-700">
                            <li>Persist User bilingual preferences (ID or EN) across navigation journeys.</li>
                            <li>Prevent duplicated view counts on published research articles upon browser refreshes.</li>
                            <li>Maintain secure authenticated sessions for authorized administrative personnel.</li>
                        </ul>
                    </div>
                </section>

                {{-- BAGIAN 7 --}}
                <section id="privasi-7" class="scroll-mt-36 p-6 sm:p-8 rounded-3xl bg-slate-50 border border-slate-200">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="px-2.5 py-0.5 rounded-md bg-[#004741] text-white font-mono text-xs font-bold">BAB 7</span>
                        <h2 class="text-lg sm:text-xl font-black text-slate-950 tracking-tight" x-text="$store.lang.t('Keamanan Teknis & Perlindungan Data', 'Technical Safeguards & Incident Management')">
                            Keamanan Teknis & Perlindungan Data
                        </h2>
                    </div>

                    <div x-show="$store.lang.isID()" class="space-y-3 font-normal">
                        <p>Seluruh transmisi data dienkripsi menggunakan protokol Transport Layer Security (TLS 1.3). Kami menerapkan kontrol akses berbasis peran (RBAC), otentikasi multi-faktor, dan pemantauan anomali jaringan 24/7. Detail komprehensif mengenai postur keamanan dapat dibaca pada halaman <a href="{{ route('public.legal.security') }}" class="text-[#004741] font-bold hover:underline">Keamanan Informasi</a>.</p>
                    </div>

                    <div x-show="$store.lang.isEN()" x-cloak class="space-y-3 font-normal">
                        <p>All data in transit is protected using modern TLS 1.3 cipher suites. We enforce role-based access controls (RBAC), multi-factor authentication, and continuous anomaly telemetry. Comprehensive details regarding our security architecture are available on our <a href="{{ route('public.legal.security') }}" class="text-[#004741] font-bold hover:underline">Information Security</a> policy page.</p>
                    </div>
                </section>

                {{-- BAGIAN 8 --}}
                <section id="privasi-8" class="scroll-mt-36 p-6 sm:p-8 rounded-3xl bg-white border border-slate-200 shadow-xs">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="px-2.5 py-0.5 rounded-md bg-[#004741] text-white font-mono text-xs font-bold">BAB 8</span>
                        <h2 class="text-lg sm:text-xl font-black text-slate-950 tracking-tight" x-text="$store.lang.t('Kontak Pejabat Perlindungan Data (DPO)', 'Data Protection Officer (DPO) Contact')">
                            Kontak Pejabat Perlindungan Data (DPO)
                        </h2>
                    </div>

                    <div class="space-y-3 font-normal">
                        <p x-text="$store.lang.t('Untuk pertanyaan, keberatan, permohonan hak subjek data, atau pelaporan insiden data pribadi, silakan hubungi Pejabat Perlindungan Data kami:', 'For inquiries, objections, rights requests, or reporting personal data vulnerabilities, contact our Data Protection Office:')">
                            Untuk pertanyaan, keberatan, permohonan hak subjek data, atau pelaporan insiden data pribadi, silakan hubungi Pejabat Perlindungan Data kami:
                        </p>
                        <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 font-mono text-xs text-slate-800 space-y-1">
                            <p class="font-bold text-slate-950">OFFICE OF THE DATA PROTECTION OFFICER (DPO)</p>
                            <p>PT YOTA INOVASI NUSANTARA</p>
                            <p>Surel Resmi: <a href="mailto:dpo@yotainovasi.id" class="text-[#004741] font-bold hover:underline">dpo@yotainovasi.id</a></p>
                            <p>Surel Umum Legalitas: <a href="mailto:legal@yotainovasi.id" class="text-[#004741] font-bold hover:underline">legal@yotainovasi.id</a></p>
                            <p>Alamat Surat: Jatimekar Residence, Blok C No. 26, Malakasari, Baleendah, Bandung 40375</p>
                        </div>
                    </div>
                </section>

            </main>

        </div>

    </div>
</div>
@endsection
