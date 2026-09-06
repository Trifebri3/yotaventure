@extends('public.layouts.app')

@section('title', 'Keamanan Informasi & Kedaulatan Siber | PT Yota Inovasi Nusantara (YOIN)')

@section('content')
<div class="bg-white min-h-screen pt-28 sm:pt-36 pb-24 text-slate-900 font-sans select-none">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-2 text-xs text-slate-500 mb-6">
            <a href="{{ url('/') }}" class="hover:text-[#004741] transition-colors" x-text="$store.lang.t('Beranda', 'Home')">Beranda</a>
            <span>/</span>
            <span class="text-slate-500" x-text="$store.lang.t('Legalitas & Tata Kelola', 'Legal & Governance')">Legalitas & Tata Kelola</span>
            <span>/</span>
            <span class="text-slate-950 font-semibold" x-text="$store.lang.t('Keamanan Informasi', 'Information Security')">Keamanan Informasi</span>
        </nav>

        {{-- Header Section --}}
        <div class="border-b border-slate-200 pb-10">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div class="max-w-3xl">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-slate-100 border border-slate-200 text-[11px] font-mono font-bold text-slate-800 uppercase mb-4">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#004741]"></span>
                        <span x-text="$store.lang.t('STANDAR POSTUR KEAMANAN ISO/IEC 27001', 'ISO/IEC 27001 SECURITY POSTURE STANDARDS')">STANDAR POSTUR KEAMANAN ISO/IEC 27001</span>
                    </div>
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-slate-950 tracking-tight leading-tight">
                        <span x-text="$store.lang.t('Kebijakan Keamanan Informasi & Ketahanan Siber', 'Information Security & Cyber Resilience Policy')">
                            Kebijakan Keamanan Informasi & Ketahanan Siber
                        </span>
                    </h1>
                    <p class="mt-3 text-sm sm:text-base text-slate-600 leading-relaxed font-normal">
                        <span x-text="$store.lang.t('Fondasi ketahanan arsitektur komputasi, tata kelola data berdaulat, protokol enkripsi, serta komitmen pertahanan siber menyeluruh ekosistem PT Yota Inovasi Nusantara.', 'Foundational framework governing secure compute architecture, sovereign data custodianship, cryptographic standards, and institutional cyber defense across the PT Yota Inovasi Nusantara ecosystem.')">
                            Fondasi ketahanan arsitektur komputasi, tata kelola data berdaulat, protokol enkripsi, serta komitmen pertahanan siber menyeluruh ekosistem PT Yota Inovasi Nusantara.
                        </span>
                    </p>
                </div>

                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3 shrink-0 text-xs text-slate-500">
                    <div class="px-4 py-2 rounded-xl bg-slate-50 border border-slate-200 font-mono">
                        <span class="text-slate-400 block text-[10px] uppercase font-bold" x-text="$store.lang.t('Status Sistem', 'System Posture')">Status Sistem</span>
                        <span class="font-bold text-emerald-700 flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-emerald-600"></span>
                            <span>SOC-OPERATIONAL</span>
                        </span>
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
                        <span class="text-xs font-mono font-bold tracking-wider text-slate-700 uppercase" x-text="$store.lang.t('DAFTAR PROTOKOL', 'SECURITY SECTIONS')">
                            DAFTAR PROTOKOL
                        </span>
                        <span class="text-[10px] font-mono text-slate-400">7 Domain</span>
                    </div>
                    
                    <nav class="space-y-1.5 text-xs">
                        <a href="#sec-1" class="block py-1.5 px-2.5 rounded-lg text-slate-700 hover:bg-white hover:text-[#004741] font-medium transition-colors">
                            1. <span x-text="$store.lang.t('Prinsip Arsitektur Zero-Trust', 'Zero-Trust Architecture')">Prinsip Arsitektur Zero-Trust</span>
                        </a>
                        <a href="#sec-2" class="block py-1.5 px-2.5 rounded-lg text-slate-700 hover:bg-white hover:text-[#004741] font-medium transition-colors">
                            2. <span x-text="$store.lang.t('Standar Kriptografi & Enkripsi Data', 'Cryptographic Standards & Encryption')">Standar Kriptografi & Enkripsi Data</span>
                        </a>
                        <a href="#sec-3" class="block py-1.5 px-2.5 rounded-lg text-slate-700 hover:bg-white hover:text-[#004741] font-medium transition-colors">
                            3. <span x-text="$store.lang.t('Kontrol Akses & Tata Kelola Identitas', 'Identity & Access Management')">Kontrol Akses & Tata Kelola Identitas</span>
                        </a>
                        <a href="#sec-4" class="block py-1.5 px-2.5 rounded-lg text-slate-700 hover:bg-white hover:text-[#004741] font-medium transition-colors">
                            4. <span x-text="$store.lang.t('Kedaulatan Pusat Data Domestik', 'Domestic Sovereign Infrastructure')">Kedaulatan Pusat Data Domestik</span>
                        </a>
                        <a href="#sec-5" class="block py-1.5 px-2.5 rounded-lg text-slate-700 hover:bg-white hover:text-[#004741] font-medium transition-colors">
                            5. <span x-text="$store.lang.t('Kesiapan Tanggap Insiden Siber', 'Incident Response & BCP/DRP')">Kesiapan Tanggap Insiden Siber</span>
                        </a>
                        <a href="#sec-6" class="block py-1.5 px-2.5 rounded-lg text-slate-700 hover:bg-white hover:text-[#004741] font-medium transition-colors">
                            6. <span x-text="$store.lang.t('Pengungkapan Kerentanan Bertanggung Jawab', 'Responsible Vulnerability Disclosure')">Pengungkapan Kerentanan Bertanggung Jawab</span>
                        </a>
                        <a href="#sec-7" class="block py-1.5 px-2.5 rounded-lg text-slate-700 hover:bg-white hover:text-[#004741] font-medium transition-colors">
                            7. <span x-text="$store.lang.t('Kontak Tim Tanggap Keamanan (SIRT)', 'Security Incident Response Team Contact')">Kontak Tim Tanggap Keamanan (SIRT)</span>
                        </a>
                    </nav>

                    <div class="pt-4 border-t border-slate-200">
                        <span class="text-[11px] text-slate-500 block" x-text="$store.lang.t('Laporan kerentanan atau insiden?', 'Security incident or disclosure?')">Laporan kerentanan atau insiden?</span>
                        <a href="mailto:security@yotainovasi.id" class="text-xs font-bold text-[#004741] hover:underline">security@yotainovasi.id</a>
                    </div>
                </div>
            </aside>

            {{-- Main Security Content --}}
            <main class="lg:col-span-8 space-y-12 text-left leading-relaxed text-slate-700 text-sm sm:text-base">
                
                {{-- SECTION 1 --}}
                <section id="sec-1" class="scroll-mt-36 p-6 sm:p-8 rounded-3xl bg-slate-50 border border-slate-200">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="px-2.5 py-0.5 rounded-md bg-[#004741] text-white font-mono text-xs font-bold">DOMAIN 1</span>
                        <h2 class="text-lg sm:text-xl font-black text-slate-950 tracking-tight" x-text="$store.lang.t('Prinsip Arsitektur Zero-Trust', 'Zero-Trust Architectural Framework')">
                            Prinsip Arsitektur Zero-Trust
                        </h2>
                    </div>

                    <div x-show="$store.lang.isID()" class="space-y-3 font-normal">
                        <p>PT Yota Inovasi Nusantara mengadopsi paradigma keamanan <strong>Zero-Trust ("Never Trust, Always Verify")</strong> di seluruh lapisan ekosistem komputasi, perangkat lunak terkelola, dan platform digital holding.</p>
                        <p>Setiap permintaan akses komputasi, baik yang berasal dari dalam jaringan internal kantor maupun jaringan publik, diotentikasi dan diotorisasi secara ketat serta diperiksa integritasnya secara berkelanjutan sebelum akses diberikan.</p>
                    </div>

                    <div x-show="$store.lang.isEN()" x-cloak class="space-y-3 font-normal">
                        <p>PT Yota Inovasi Nusantara mandates an institutional <strong>Zero-Trust Architecture ("Never Trust, Always Verify")</strong> across all software systems, edge nodes, and managed enterprise workloads.</p>
                        <p>Every internal and external transaction request is continuously authenticated, authorized according to strict policy, and inspected for anomaly patterns before granting granular resource access.</p>
                    </div>
                </section>

                {{-- SECTION 2 --}}
                <section id="sec-2" class="scroll-mt-36 p-6 sm:p-8 rounded-3xl bg-white border border-slate-200 shadow-xs">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="px-2.5 py-0.5 rounded-md bg-[#004741] text-white font-mono text-xs font-bold">DOMAIN 2</span>
                        <h2 class="text-lg sm:text-xl font-black text-slate-950 tracking-tight" x-text="$store.lang.t('Standar Kriptografi & Enkripsi Data', 'Cryptographic Standards & Data Encryption')">
                            Standar Kriptografi & Enkripsi Data
                        </h2>
                    </div>

                    <div x-show="$store.lang.isID()" class="space-y-3 font-normal">
                        <p>Kami menerapkan mekanisme perlindungan kriptografi kelas militer dan perbankan:</p>
                        <ul class="list-disc pl-5 space-y-1.5 text-slate-700">
                            <li><strong>Enkripsi Saat Transit (*In-Transit*):</strong> Seluruh lalu lintas transmisi antara peramban Pengguna dan peladen YOIN dilindungi menggunakan protokol <strong>TLS 1.3</strong> dengan cipher suite berkeamanan tinggi dan HSTS (*HTTP Strict Transport Security*).</li>
                            <li><strong>Enkripsi Saat Istirahat (*At-Rest*):</strong> Seluruh basis data, cadangan data (*backup*), dan dokumen sensitif disimpan menggunakan enkripsi <strong>AES-256 bit</strong> dengan kunci enkripsi yang dirotasi secara otomatis melalui Hardware Security Module (HSM).</li>
                        </ul>
                    </div>

                    <div x-show="$store.lang.isEN()" x-cloak class="space-y-3 font-normal">
                        <p>Our infrastructure enforces banking-grade cryptographic controls:</p>
                        <ul class="list-disc pl-5 space-y-1.5 text-slate-700">
                            <li><strong>In-Transit Encryption:</strong> All public and private network payloads are encapsulated with <strong>TLS 1.3</strong>, modern forward-secrecy cipher suites, and enforced HTTP Strict Transport Security (HSTS).</li>
                            <li><strong>At-Rest Encryption:</strong> All underlying database volumes, archive snapshots, and institutional filings are encrypted with <strong>AES-256</strong> with automated cryptographic key rotation via Hardware Security Modules (HSM).</li>
                        </ul>
                    </div>
                </section>

                {{-- SECTION 3 --}}
                <section id="sec-3" class="scroll-mt-36 p-6 sm:p-8 rounded-3xl bg-slate-50 border border-slate-200">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="px-2.5 py-0.5 rounded-md bg-[#004741] text-white font-mono text-xs font-bold">DOMAIN 3</span>
                        <h2 class="text-lg sm:text-xl font-black text-slate-950 tracking-tight" x-text="$store.lang.t('Kontrol Akses & Tata Kelola Identitas', 'Identity & Access Management (IAM)')">
                            Kontrol Akses & Tata Kelola Identitas
                        </h2>
                    </div>

                    <div x-show="$store.lang.isID()" class="space-y-3 font-normal">
                        <p>3.1. Akses administratif ke sistem manajemen konten (CMS) dan infrastruktur komputasi dibatasi dengan prinsip hak istimewa paling sedikit (*Principle of Least Privilege - PoLP*).</p>
                        <p>3.2. Seluruh personil internal diwajibkan menggunakan Otentikasi Multi-Faktor (MFA) berbasis perangkat keras atau aplikasi TOTP aman. Tidak diperkenankan penggunaan kata sandi tunggal tanpa lapisan verifikasi kedua.</p>
                    </div>

                    <div x-show="$store.lang.isEN()" x-cloak class="space-y-3 font-normal">
                        <p>3.1. Privileged administrative access into content management and database layers is governed strictly by the Principle of Least Privilege (PoLP) and Role-Based Access Control (RBAC).</p>
                        <p>3.2. Mandatory Multi-Factor Authentication (MFA) utilizing hardware tokens or cryptographic TOTP applications is enforced for all staff accounts. Single-factor password authentication is categorically prohibited.</p>
                    </div>
                </section>

                {{-- SECTION 4 --}}
                <section id="sec-4" class="scroll-mt-36 p-6 sm:p-8 rounded-3xl bg-white border border-slate-200 shadow-xs">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="px-2.5 py-0.5 rounded-md bg-[#004741] text-white font-mono text-xs font-bold">DOMAIN 4</span>
                        <h2 class="text-lg sm:text-xl font-black text-slate-950 tracking-tight" x-text="$store.lang.t('Kedaulatan Pusat Data Domestik', 'Domestic Sovereign Infrastructure')">
                            Kedaulatan Pusat Data Domestik
                        </h2>
                    </div>

                    <div x-show="$store.lang.isID()" class="space-y-3 font-normal">
                        <p>4.1. Sejalan dengan visi kedaulatan digital Indonesia, peladen utama dan basis data YOIN berlokasi pada fasilitas data center Tier-3/Tier-4 di dalam negeri yang memenuhi sertifikasi internasional ISO/IEC 27001, SOC 2 Type II, dan kepatuhan regulasi PP No. 71/2019.</p>
                        <p>4.2. Pencadangan data (*backup*) dilakukan secara berkala dan terdistribusi secara geografis di pulau-pulau berbeda untuk menjamin kelangsungan operasional saat terjadi bencana alam atau kegagalan regional.</p>
                    </div>

                    <div x-show="$store.lang.isEN()" x-cloak class="space-y-3 font-normal">
                        <p>4.1. Reflecting our commitment to national technological sovereignty, primary database nodes are hosted in domestic Tier-3/Tier-4 enterprise data center facilities holding ISO/IEC 27001 and SOC 2 certifications.</p>
                        <p>4.2. Automated geo-replicated backups are maintained across distinct Indonesian geographic fault zones to provide high-availability failover and disaster resilience.</p>
                    </div>
                </section>

                {{-- SECTION 5 --}}
                <section id="sec-5" class="scroll-mt-36 p-6 sm:p-8 rounded-3xl bg-slate-50 border border-slate-200">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="px-2.5 py-0.5 rounded-md bg-[#004741] text-white font-mono text-xs font-bold">DOMAIN 5</span>
                        <h2 class="text-lg sm:text-xl font-black text-slate-950 tracking-tight" x-text="$store.lang.t('Kesiapan Tanggap Insiden Siber (SIRT & BCP)', 'Incident Response & Business Continuity')">
                            Kesiapan Tanggap Insiden Siber (SIRT & BCP)
                        </h2>
                    </div>

                    <div x-show="$store.lang.isID()" class="space-y-3 font-normal">
                        <p>5.1. Tim Tanggap Insiden Keamanan Siber (*Security Incident Response Team - SIRT*) siaga 24/7 untuk mendeteksi, mengisolasi, dan memitigasi potensi anomali jaringan maupun upaya intrusi.</p>
                        <p>5.2. Dalam skenario kegagalan sistem atau insiden siber yang berpotensi memengaruhi integritas data, Perusahaan memiliki Rencana Pemulihan Bencana (*Disaster Recovery Plan - DRP*) dengan target waktu pemulihan (RTO) di bawah 4 jam dan target titik kehilangan data (RPO) di bawah 15 menit.</p>
                    </div>

                    <div x-show="$store.lang.isEN()" x-cloak class="space-y-3 font-normal">
                        <p>5.1. A dedicated Security Incident Response Team (SIRT) maintains 24/7 telemetry monitoring to detect, isolate, and remediate intrusion anomalies or denial-of-service attempts.</p>
                        <p>5.2. Formal Disaster Recovery Plans (DRP) ensure rapid service restoration under strict Service Level Agreements (SLA), maintaining a Recovery Time Objective (RTO) under 4 hours and Recovery Point Objective (RPO) under 15 minutes.</p>
                    </div>
                </section>

                {{-- SECTION 6 --}}
                <section id="sec-6" class="scroll-mt-36 p-6 sm:p-8 rounded-3xl bg-white border border-slate-200 shadow-xs">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="px-2.5 py-0.5 rounded-md bg-[#004741] text-white font-mono text-xs font-bold">DOMAIN 6</span>
                        <h2 class="text-lg sm:text-xl font-black text-slate-950 tracking-tight" x-text="$store.lang.t('Program Pengungkapan Kerentanan Bertanggung Jawab', 'Coordinated Vulnerability Disclosure')">
                            Program Pengungkapan Kerentanan Bertanggung Jawab
                        </h2>
                    </div>

                    <div x-show="$store.lang.isID()" class="space-y-3 font-normal">
                        <p>YOIN sangat menghargai kontribusi para peneliti keamanan siber independen, akademisi, dan praktisi etis (*ethical hackers*). Apabila Anda menemukan potensi kerentanan keamanan pada sistem kami, kami memohon agar:</p>
                        <ul class="list-disc pl-5 space-y-1.5 text-slate-700">
                            <li>Melaporkan temuan secara rahasia melalui surel <strong>security@yotainovasi.id</strong> sebelum mempublikasikannya ke ranah umum.</li>
                            <li>Tidak melakukan tindakan yang merusak integritas data, mengganggu ketersediaan layanan, atau mengakses data milik pihak ketiga.</li>
                            <li>Memberikan waktu yang wajar bagi tim rekayasa kami untuk memverifikasi dan merilis perbaikan tambalan (*patch*).</li>
                        </ul>
                    </div>

                    <div x-show="$store.lang.isEN()" x-cloak class="space-y-3 font-normal">
                        <p>YOIN actively welcomes responsible contributions from independent security researchers and academic ethicists. If you discover potential security vulnerabilities across our digital assets, we request that you:</p>
                        <ul class="list-disc pl-5 space-y-1.5 text-slate-700">
                            <li>Disclose the findings confidentially to <strong>security@yotainovasi.id</strong> prior to public dissemination.</li>
                            <li>Avoid any destructive testing, service degradation, or unauthorized exfiltration of third-party user data.</li>
                            <li>Allow reasonable remediation timelines for our engineering teams to reproduce and deploy official security patches.</li>
                        </ul>
                    </div>
                </section>

                {{-- SECTION 7 --}}
                <section id="sec-7" class="scroll-mt-36 p-6 sm:p-8 rounded-3xl bg-slate-50 border border-slate-200">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="px-2.5 py-0.5 rounded-md bg-[#004741] text-white font-mono text-xs font-bold">DOMAIN 7</span>
                        <h2 class="text-lg sm:text-xl font-black text-slate-950 tracking-tight" x-text="$store.lang.t('Kontak Resmi Tim Tanggap Siber', 'Security Operations Response Team Contact')">
                            Kontak Resmi Tim Tanggap Siber
                        </h2>
                    </div>

                    <div class="space-y-3 font-normal">
                        <p x-text="$store.lang.t('Untuk pelaporan darurat insiden siber, permohonan audit sertifikasi mitra, atau koordinasi pengungkapan kerentanan:', 'For emergency incident reporting, partner security vetting, or coordinated disclosure communication:')">
                            Untuk pelaporan darurat insiden siber, permohonan audit sertifikasi mitra, atau koordinasi pengungkapan kerentanan:
                        </p>
                        <div class="p-5 rounded-2xl bg-white border border-slate-200 font-mono text-xs text-slate-800 space-y-1">
                            <p class="font-bold text-slate-950">CYBER RESILIENCE & SECURITY OPERATIONS CENTER (SOC)</p>
                            <p>PT YOTA INOVASI NUSANTARA</p>
                            <p>Surel Darurat Keamanan: <a href="mailto:security@yotainovasi.id" class="text-[#004741] font-bold hover:underline">security@yotainovasi.id</a></p>
                            <p>Kunci PGP / GPG: <span class="text-slate-500">[Tersedia atas permintaan verifikasi resmi]</span></p>
                            <p>Baleendah, Kabupaten Bandung, Jawa Barat 40375</p>
                        </div>
                    </div>
                </section>

            </main>

        </div>

    </div>
</div>
@endsection
