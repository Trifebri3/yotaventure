<?php

namespace Database\Seeders;

use App\Models\EcosystemInitiative;
use App\Models\FounderStory;
use App\Models\Person;
use Illuminate\Database\Seeder;

class PeopleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $digitalInitiative = EcosystemInitiative::where('slug', 'yoin-digital')->first();
        $agronexInitiative = EcosystemInitiative::where('slug', 'agronex')->first();
        $yacInitiative = EcosystemInitiative::where('slug', 'yac')->first();
        $yoimoInitiative = EcosystemInitiative::where('slug', 'yoimo')->first();
        $buataraInitiative = EcosystemInitiative::where('slug', 'buatara')->first();

        // -------------------------------------------------------------
        // 1. FOUNDERS
        // -------------------------------------------------------------

        $founder1 = Person::updateOrCreate(
            ['slug' => 'adrian-kusuma'],
            [
                'category' => 'founder',
                'name' => 'Adrian Kusuma',
                'role_id' => 'Founder & Chief Executive Officer',
                'role_en' => 'Founder & Chief Executive Officer',
                'bio_id' => 'Pelopor inovasi teknologi dan pembangun ekosistem ventura terpadu dari akar rumput Indonesia.',
                'bio_en' => 'Pioneer of technological innovation and venture ecosystem builder from ground-up Indonesia.',
                'photo' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=800&q=80',
                'initiative_id' => null,
                'is_active' => true,
                'organization' => 'Institut Teknologi Bandung (Alumnus)',
                'period' => '2020 - Sekarang',
                'social_links' => [
                    'linkedin' => 'https://linkedin.com/in/adrian-kusuma',
                    'instagram' => 'https://instagram.com/adriankusuma.id',
                    'github' => 'https://github.com/adriankusuma',
                    'twitter' => 'https://x.com/adriankusuma',
                    'website' => 'https://yotainovasi.id',
                    'email' => 'adrian@yotainovasi.id',
                ],
                'meta' => [
                    'quote' => 'Perusahaan besar tidak lahir dari modal yang melimpah, melainkan dari kedalaman empati kita dalam menyelesaikan masalah nyata yang paling diabaikan.',
                    'philosophy' => 'Membangun orang terlebih dahulu, merawat ide menjadi produk tahan banting, lalu memberi ruang bagi ventura untuk menemukan takdir pasarnya.',
                    'highlights' => [
                        'Pemenang Pemuda Pelopor Tingkat Nasional Bidang Inovasi Teknologi (Kemenpora RI)',
                        'Inovator Terbaik Akselerasi Transformasi Digital Daerah Jawa Barat',
                        'Membangun 5 Brand Ventura Mandiri dari Nol Tanpa Pembakaran Modal Sia-sia',
                    ],
                    'trajectory' => [
                        ['year' => '2020', 'title' => 'Eksperimen Pertama di Garasi', 'description' => 'Memulai riset perangkat lunak modular mandiri dari keterbatasan sarana.'],
                        ['year' => '2022', 'title' => 'Penghargaan Pemuda Pelopor', 'description' => 'Diakui pemerintah pusat atas rekayasa teknologi berdaya guna bagi masyarakat.'],
                        ['year' => '2024', 'title' => 'Kelahiran Holding YOIN', 'description' => 'Menyatukan unit teknologi, agrikultur, manufaktur bambu, dan yayasan kemanusiaan dalam satu ekosistem.'],
                        ['year' => '2026', 'title' => 'Akselerasi Skala Regional', 'description' => 'Mempersiapkan portofolio ventura menuju panggung Asia Tenggara.'],
                    ],
                ],
                'story_html' => '<p>Bagi Adrian, membangun bisnis di Indonesia bukan tentang menyalin apa yang tren di Silicon Valley lalu menempelkannya di Jakarta. Segalanya selalu berakar dari tanah—tentang petani yang kehilangan sepertiga hasil panen karena ketiadaan data cuaca mikro, tentang UMKM yang terperangkap dalam sistem perangkat lunak warisan yang mencekik, dan tentang talenta muda daerah yang haus akan ruang berkarya berstandar dunia.</p><p>Dari ruang kecil di pinggiran Bandung dengan peralatan seadanya, Adrian memilih jalur yang jarang diambil: menolak pembakaran modal tanpa arah, dan memilih membangun ventura mandiri yang sehat secara unit ekonomi sejak hari pertama.</p>',
                'sort_order' => 1,
                'visibility' => 'public',
            ]
        );

        $founder2 = Person::updateOrCreate(
            ['slug' => 'dr-dewi-anindita'],
            [
                'category' => 'founder',
                'name' => 'Dr. Dewi Anindita',
                'role_id' => 'Co-Founder & Head of Biosystems / Agronex',
                'role_en' => 'Co-Founder & Head of Biosystems / Agronex',
                'bio_id' => 'Agronomis dan peneliti bioteknologi presisi yang mendedikasikan hidupnya untuk kedaulatan pangan dan tanah lestari.',
                'bio_en' => 'Agronomist and precision biotechnology researcher dedicated to food sovereignty and regenerative soils.',
                'photo' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=800&q=80',
                'initiative_id' => $agronexInitiative?->id,
                'is_active' => true,
                'organization' => 'Institut Pertanian Bogor (Doktoral)',
                'period' => '2021 - Sekarang',
                'social_links' => [
                    'linkedin' => 'https://linkedin.com/in/dewi-anindita',
                    'instagram' => 'https://instagram.com/dewianindita.agro',
                    'email' => 'dewi@agronex.id',
                ],
                'meta' => [
                    'quote' => 'Teknologi pertanian terhebat bukan yang paling rumit, tetapi yang paling dipahami dan dicintai oleh tangan-tangan petani di sawah.',
                    'philosophy' => 'Mengembalikan kesehatan mikroba tanah melalui data agronomis mikro dan transisi pertanian regeneratif.',
                    'highlights' => [
                        'Peneliti Utama Bio-fertilisasi Hayati Terakreditasi Nasional',
                        'Memimpin Implementasi Telemetri Tanah di 34 Kelompok Tani',
                    ],
                    'trajectory' => [
                        ['year' => '2021', 'title' => 'Riset Sensor Tanah', 'description' => 'Merakit prototipe telemetri NPK tanah berbiaya terjangkau.'],
                        ['year' => '2023', 'title' => 'Inisiasi Unit AGRONEX', 'description' => 'Mengembangkan platform advisory berbasis WhatsApp untuk petani kecil.'],
                    ],
                ],
                'story_html' => '<p>Dewi percaya bahwa masa depan kedaulatan pangan Indonesia ada di perpaduan sains modern dan kearifan lokal. Bersama Adrian, ia menerjemahkan data agronomis yang rumit menjadi notifikasi sederhana yang dapat dipahami petani di ponsel mereka setiap pagi.</p>',
                'sort_order' => 2,
                'visibility' => 'public',
            ]
        );

        $founder3 = Person::updateOrCreate(
            ['slug' => 'rian-hidayat'],
            [
                'category' => 'founder',
                'name' => 'Rian Hidayat',
                'role_id' => 'Co-Founder & Chief Technology Officer',
                'role_en' => 'Co-Founder & Chief Technology Officer',
                'bio_id' => 'Arsitek sistem komputasi awan dan praktisi keamanan data skala enterprise.',
                'bio_en' => 'Cloud systems architect and enterprise-scale data security practitioner.',
                'photo' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=800&q=80',
                'initiative_id' => $digitalInitiative?->id,
                'is_active' => true,
                'organization' => 'Universitas Indonesia',
                'period' => '2021 - Sekarang',
                'social_links' => [
                    'linkedin' => 'https://linkedin.com/in/rian-hidayat',
                    'github' => 'https://github.com/rianhidayat',
                    'twitter' => 'https://x.com/rianhidayat',
                    'email' => 'rian@yotainovasi.id',
                ],
                'meta' => [
                    'quote' => 'Kode yang andal adalah kode yang berjalan tanpa drama saat jutaan transaksi bergulir di tengah malam.',
                    'philosophy' => 'Arsitektur modular zero-trust yang menjamin independensi dan skalabilitas setiap lini bisnis holding.',
                    'highlights' => [
                        'Perancang Arsitektur YOIN Enterprise Core API',
                        'Spesialis Infrastruktur Cloud-Native Terdistribusi',
                    ],
                    'trajectory' => [
                        ['year' => '2021', 'title' => 'Pondasi Cloud Holding', 'description' => 'Membangun arsitektur microservices terpadu seluruh ventura.'],
                        ['year' => '2024', 'title' => 'Sertifikasi Keamanan Data', 'description' => 'Menerapkan enkripsi berlapis pada seluruh data sensitif klien enterprise.'],
                    ],
                ],
                'story_html' => '<p>Rian memastikan fondasi rekayasa perangkat lunak di seluruh unit YOIN dibangun dengan standar ketat. Baginya, setiap baris kode adalah wujud kedaulatan digital bangsa.</p>',
                'sort_order' => 3,
                'visibility' => 'public',
            ]
        );

        // -------------------------------------------------------------
        // 2. MANIFES & PERJALANAN PENDIRI (EXECUTIVE ESSAYS & MANIFESTOS)
        // -------------------------------------------------------------

        FounderStory::updateOrCreate(
            ['slug' => 'prolog-menghidupkan-api-di-tanah-berbatu'],
            [
                'person_id' => $founder1->id,
                'chapter_number' => 'MANIFES 00',
                'title' => 'Meletakkan Fondasi Ekosistem dari Akar Rumput',
                'subtitle' => 'Prinsip Kemandirian Unit Ekonomi dan Validasi Masalah Nyata Sejak Hari Pertama',
                'cover_image' => 'https://images.unsplash.com/photo-1519681393784-d120267933ba?auto=format&fit=crop&w=1200&q=80',
                'reading_time' => '7 Menit Baca',
                'excerpt' => 'Di sebuah sudut kecil Jawa Barat, sebelum gedung operasional dan kemitraan strategis holding terbentuk, fondasi ventura kami dibangun dengan kedalaman empati terhadap masalah paling nyata yang diabaikan pasar.',
                'content_html' => '
                    <p class="lead font-sans text-lg sm:text-xl text-gray-800 leading-relaxed font-light">
                        Banyak pihak beranggapan bahwa inovasi teknologi bernilai tinggi selalu berakar dari ruang berpendingin udara di kawasan perkantoran metropolitan. Namun bagi ekosistem YOIN, inovasi strategis selalu lahir dari interaksi langsung dengan realitas operasional di lapangan—tentang efisiensi unit ekonomi yang harus teruji sebelum ekspansi skala besar dimulai.
                    </p>
                    <p>
                        "Perusahaan yang berdaya tahan tinggi tidak pernah mengukur keberhasilan awal dari seberapa banyak modal yang dibakar," tutur Adrian Kusuma dalam catatan refleksinya. "Keberhasilan sejati ditentukan oleh kemampuan model bisnis menghasilkan nilai tambah riil bagi pengguna akhir, mempertahankan arus kas positif, dan membangun kedaulatan operasional yang mandiri."
                    </p>
                    <blockquote class="my-8 py-5 px-6 border-l-4 border-[#005952] bg-teal-50/70 rounded-r-2xl text-teal-950 font-serif italic text-base sm:text-lg leading-relaxed shadow-xs">
                        "Kemandirian ekonomi bukan sekadar target finansial, melainkan benteng pertahanan moral agar sebuah ventura tidak kehilangan kompas misinya ketika gelombang pasar berfluktuasi."
                    </blockquote>
                    <p>
                        Sejak peletakan batu pertama holding, kami menetapkan prinsip arsitektur modular. Setiap inisiatif bisnis—baik di bidang transformasi digital, agrikultur regeneratif, maupun manufaktur berkelanjutan—diwajibkan memiliki <em>unit economics</em> yang solid dan tidak bergantung pada subsidi silang yang tidak berkelanjutan.
                    </p>
                    <figure class="my-8 rounded-2xl overflow-hidden border border-gray-200 shadow-md">
                        <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&w=1200&q=80" alt="Sesi Perancangan Arsitektur Ekosistem YOIN" class="w-full h-auto object-cover">
                        <figcaption class="p-3 bg-gray-50 text-[11px] text-gray-500 font-mono text-center border-t border-gray-100">
                            Dokumentasi internal: Konsolidasi peta jalan teknologi terintegrasi holding YOIN bersama dewan pendiri.
                        </figcaption>
                    </figure>
                    <p>
                        Dari komitmen awal inilah, holding YOIN berkembang bukan sebagai entitas spekulatif, melainkan sebagai wadah institusional yang menaungi talenta-talenta terbaik bangsa dalam menyelesaikan masalah infrastruktur ekonomi riil.
                    </p>
                ',
                'status' => 'published',
                'published_at' => '2024-01-15 09:00:00',
                'sort_order' => 1,
            ]
        );

        FounderStory::updateOrCreate(
            ['slug' => 'bab-01-kode-pertama-dan-sepeda-motor-tua'],
            [
                'person_id' => $founder1->id,
                'chapter_number' => 'MANIFES 01',
                'title' => 'Rekayasa Lapangan & Validasi Masalah Pengguna Nyata',
                'subtitle' => 'Mengapa Solusi Perangkat Lunak Enterprise Harus Diuji di Titik Paling Kritis',
                'cover_image' => 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&w=1200&q=80',
                'reading_time' => '9 Menit Baca',
                'excerpt' => 'Menolak kenyamanan asumsi di balik meja kerja, kami membawa prototipe sistem langsung ke rantai pasok dan titik operasional riil untuk memastikan keandalan rekayasa di kondisi paling ekstrem.',
                'content_html' => '
                    <p class="lead font-sans text-lg sm:text-xl text-gray-800 leading-relaxed font-light">
                        Dalam rekayasa perangkat lunak modern, ada jurang pemisah yang berbahaya antara arsitektur teoritis di repositori kode dan perilaku sistem saat berhadapan dengan latensi jaringan nirkabel di pelosok, lonjakan beban tak terduga, atau kesalahan input manual dari operator lapangan.
                    </p>
                    <p>
                        Saat pertama kali mengimplementasikan sistem telemetri operasional, kami tidak mengandalkan simulator lab. Kami menempuh jalur darat menuju sentra-sentra produksi mitra untuk mengamati langsung bagaimana data dikonsumsi di bawah terik matahari dan kendala sinyal seluler terbatas.
                    </p>
                    <div class="my-8 rounded-2xl overflow-hidden aspect-video shadow-lg border border-gray-200 bg-gray-950">
                        <iframe class="w-full h-full" src="https://www.youtube-nocookie.com/embed/dQw4w9WgXcQ?rel=0" title="Dokumentasi Rekayasa Ekosistem YOIN" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <blockquote class="my-8 py-5 px-6 border-l-4 border-[#005952] bg-teal-50/70 rounded-r-2xl text-teal-950 font-serif italic text-base sm:text-lg leading-relaxed shadow-xs">
                        "Produk teknologi kelas dunia tidak diukur dari kerumitan algoritma internalnya, melainkan dari seberapa mulus sistem tersebut berjalan tanpa henti di tangan mereka yang menggunakannya setiap hari."
                    </blockquote>
                    <p>
                        Filosofi ini tertanam kuat dalam setiap modul YOIN Digital dan lini ventura lainnya. Setiap rekayasawan diwajibkan memahami siklus bisnis klien secara menyeluruh, sehingga arsitektur yang dibangun selalu berorientasi pada ketahanan (<em>resilience</em>), latensi minimal, dan efisiensi biaya komputasi yang terukur.
                    </p>
                ',
                'status' => 'published',
                'published_at' => '2024-04-10 10:30:00',
                'sort_order' => 2,
            ]
        );

        FounderStory::updateOrCreate(
            ['slug' => 'bab-02-menatap-tanah-menemukan-petani'],
            [
                'person_id' => $founder2->id,
                'chapter_number' => 'MANIFES 02',
                'title' => 'Tesis Biosistem Presisi & Kelahiran Inisiatif AGRONEX',
                'subtitle' => 'Demokratisasi Data Agronomis Mikro untuk Ketahanan Pangan Nasional',
                'cover_image' => 'https://images.unsplash.com/photo-1500937386664-56d1dfef3854?auto=format&fit=crop&w=1200&q=80',
                'reading_time' => '11 Menit Baca',
                'excerpt' => 'Menghubungkan bioteknologi terapan, sensor mikroba tanah, dan telemetri presisi agar rekomendasi budidaya pangan bernilai tinggi dapat diakses petani rakyat dengan mudah dan terukur.',
                'content_html' => '
                    <p class="lead font-sans text-lg sm:text-xl text-gray-800 leading-relaxed font-light">
                        Pertanian modern di negara berkembang kerap menghadapi anomali: teknologi pertanian presisi berbiaya sangat tinggi sehingga hanya dinikmati perkebunan konglomerasi, sementara produsen pangan pangan utama—yakni jutaan petani rakyat—harus mengandalkan perkiraan konvensional yang rentan terhadap volatilitas iklim.
                    </p>
                    <p>
                        Dari observasi komprehensif atas puluhan siklus panen komoditas hortikultura, Dr. Dewi Anindita merumuskan tesis biosistem yang melandasi berdirinya <strong>AGRONEX Biosystems</strong>: bahwa presisi agronomis tidak harus mahal apabila arsitektur sensor disederhanakan dan hasil analitik disajikan melalui kanal komunikasi yang sudah dipakai sehari-hari.
                    </p>
                    <figure class="my-8 rounded-2xl overflow-hidden border border-gray-200 shadow-md">
                        <img src="https://images.unsplash.com/photo-1574943320219-553eb213f72d?auto=format&fit=crop&w=1200&q=80" alt="Riset Telemetri Tanah dan Pemupukan Presisi AGRONEX" class="w-full h-auto object-cover">
                        <figcaption class="p-3 bg-gray-50 text-[11px] text-gray-500 font-mono text-center border-t border-gray-100">
                            Validasi laboratorium lapangan: Pengukuran densitas mikroba dan konduktivitas elektrik tanah di sentra riset Jawa Barat.
                        </figcaption>
                    </figure>
                    <blockquote class="my-8 py-5 px-6 border-l-4 border-[#005952] bg-teal-50/70 rounded-r-2xl text-teal-950 font-serif italic text-base sm:text-lg leading-relaxed shadow-xs">
                        "Kedaulatan pangan berkelanjutan tercapai ketika sains bioteknologi tidak lagi berjarak dari tanah garapan, melainkan hadir sebagai mitra pengambilan keputusan harian petani."
                    </blockquote>
                    <p>
                        Melalui perpaduan data cuaca mikro, sensor kelembapan sub-permukaan, dan formulasi bio-fertilisasi organik yang tepat dosis, AGRONEX berhasil menekan biaya pupuk sintetis hingga 35% sekaligus mendongkrak ketahanan tanaman terhadap cekaman cuaca ekstrem.
                    </p>
                ',
                'status' => 'published',
                'published_at' => '2024-08-20 14:00:00',
                'sort_order' => 3,
            ]
        );

        FounderStory::updateOrCreate(
            ['slug' => 'bab-03-dari-satu-menjadi-ekosistem'],
            [
                'person_id' => $founder1->id,
                'chapter_number' => 'MANIFES 03',
                'title' => 'Arsitektur Holding Ventura & Sinergi Ekosistem Lintas Sektor',
                'subtitle' => 'Membangun Daya Tahan Korporasi Melalui Integrasi Nilai Nyata Antar-Lini Bisnis',
                'cover_image' => 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=1200&q=80',
                'reading_time' => '10 Menit Baca',
                'excerpt' => 'Menolak dogma industri yang mengharuskan startup berfokus pada monolit software tunggal, holding YOIN memilih membangun ekosistem komprehensif yang mengkoneksikan teknologi, biomaterial, dan dampak sosial.',
                'content_html' => '
                    <p class="lead font-sans text-lg sm:text-xl text-gray-800 leading-relaxed font-light">
                        Dalam lanskap ventura global, pendekatan monolitik kerap menjadi standar konvensional: sebuah perusahaan diharapkan memusatkan seluruh sumber dayanya hanya pada satu platform perangkat lunak tunggal demi mengejar pertumbuhan eksponensial jangka pendek.
                    </p>
                    <p>
                        Namun, tantangan mendasar ekonomi Indonesia memiliki keterikatan yang kompleks. Masalah efisiensi logistik terhubung erat dengan kesejahteraan produsen komoditas; sementara pengembangan material ramah lingkungan seperti laminasi bambu di BUATARA membutuhkan dukungan sistem manufaktur terdigitalisasi dan pendampingan talenta muda melalui yayasan kemanusiaan YAC.
                    </p>
                    <blockquote class="my-8 py-5 px-6 border-l-4 border-[#005952] bg-teal-50/70 rounded-r-2xl text-teal-950 font-serif italic text-base sm:text-lg leading-relaxed shadow-xs">
                        "Holding ventura kami bukan sekadar portofolio kepemilikan saham, melainkan simfoni nilai terintegrasi di mana inovasi dari satu lini bisnis menjadi akselerator bagi lini bisnis lainnya."
                    </blockquote>
                    <p>
                        Struktur holding YOIN dirancang untuk memitigasi risiko siklus pasar (<em>market cycle hedged</em>). Ketika salah satu sektor mengalami penyesuaian makroekonomi, unit ventura lainnya tetap bertumbuh secara tangguh. Inilah fondasi tata kelola yang memungkinkan kami melangkah mantap menuju ekspansi skala regional di Asia Tenggara.
                    </p>
                ',
                'status' => 'published',
                'published_at' => '2025-01-10 11:00:00',
                'sort_order' => 4,
            ]
        );

        // -------------------------------------------------------------
        // 3. TIM INTI (CORE TEAM)
        // -------------------------------------------------------------

        $teamMembers = [
            [
                'name' => 'Fajar Nugraha',
                'slug' => 'fajar-nugraha',
                'role_id' => 'Head of Software Engineering',
                'role_en' => 'Head of Software Engineering',
                'bio_id' => 'Memimpin pengembangan arsitektur cloud modular dan kestabilan kode seluruh produk enterprise YOIN Digital.',
                'bio_en' => 'Leading modular cloud architecture and code stability across YOIN Digital enterprise products.',
                'photo' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=600&q=80',
                'initiative_id' => $digitalInitiative?->id,
                'is_active' => true,
                'organization' => 'YOIN Digital',
                'period' => '2022 - Sekarang',
                'social_links' => [
                    'linkedin' => 'https://linkedin.com/in/fajar-nugraha',
                    'github' => 'https://github.com/fajarnugraha',
                ],
                'meta' => [
                    'skills' => ['Distributed Systems', 'Laravel', 'Vue/React', 'Kubernetes', 'High-Availability'],
                    'badge' => 'Core Tech',
                ],
                'sort_order' => 1,
            ],
            [
                'name' => 'Siti Nurhaliza, S.P.',
                'slug' => 'siti-nurhaliza',
                'role_id' => 'Lead Agronomist & Field Operations',
                'role_en' => 'Lead Agronomist & Field Operations',
                'bio_id' => 'Mengkoordinasikan edukasi petani lapangan, kalibrasi sensor NPK tanah, dan formulasi pupuk hayati AGRONEX.',
                'bio_en' => 'Coordinating field farmer education, soil NPK calibration, and AGRONEX bio-fertilizer formulations.',
                'photo' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=600&q=80',
                'initiative_id' => $agronexInitiative?->id,
                'is_active' => true,
                'organization' => 'AGRONEX Biosystems',
                'period' => '2023 - Sekarang',
                'social_links' => [
                    'linkedin' => 'https://linkedin.com/in/siti-nurhaliza',
                    'instagram' => 'https://instagram.com/sitinurhaliza.agro',
                ],
                'meta' => [
                    'skills' => ['Regenerative Farming', 'Soil Micro-biology', 'Farmer Education', 'Field Ops'],
                    'badge' => 'AgriTech Lead',
                ],
                'sort_order' => 2,
            ],
            [
                'name' => 'Bima Arya Pratama',
                'slug' => 'bima-arya-pratama',
                'role_id' => 'Head of Industrial Design & Prototyping',
                'role_en' => 'Head of Industrial Design & Prototyping',
                'bio_id' => 'Desainer produk industri yang menghidupkan bambu laminasi terbarukan menjadi furniture ergonomis modern di BUATARA.',
                'bio_en' => 'Industrial product designer engineering renewable laminated bamboo into modern ergonomic workspaces at BUATARA.',
                'photo' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=crop&w=600&q=80',
                'initiative_id' => $buataraInitiative?->id,
                'is_active' => true,
                'organization' => 'BUATARA Living',
                'period' => '2023 - Sekarang',
                'social_links' => [
                    'linkedin' => 'https://linkedin.com/in/bima-arya',
                    'instagram' => 'https://instagram.com/bimaarya.design',
                ],
                'meta' => [
                    'skills' => ['Industrial Design', 'Bamboo Engineering', 'CAD/CAM', 'Sustainable Craft'],
                    'badge' => 'Design & Material',
                ],
                'sort_order' => 3,
            ],
            [
                'name' => 'Annisa Rahmawati',
                'slug' => 'annisa-rahmawati',
                'role_id' => 'Director of Youth Impact & Community Hub',
                'role_en' => 'Director of Youth Impact & Community Hub',
                'bio_id' => 'Mengorkestrasi kurikulum fellowship, riset sosial partisipatif, dan jejaring komunitas desa di YOIN Adiwidya Center.',
                'bio_en' => 'Orchestrating fellowship curriculum, participatory social research, and village community networks at YOIN Adiwidya Center.',
                'photo' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=600&q=80',
                'initiative_id' => $yacInitiative?->id,
                'is_active' => true,
                'organization' => 'YOIN Adiwidya Center (YAC)',
                'period' => '2022 - Sekarang',
                'social_links' => [
                    'linkedin' => 'https://linkedin.com/in/annisa-rahmawati',
                    'instagram' => 'https://instagram.com/annisa.yac',
                ],
                'meta' => [
                    'skills' => ['Community Development', 'Social Research', 'Youth Mentorship', 'ESG Reporting'],
                    'badge' => 'ESG & Social Lead',
                ],
                'sort_order' => 4,
            ],
            [
                'name' => 'Hendra Gunawan, S.H.',
                'slug' => 'hendra-gunawan',
                'role_id' => 'Head of Legal & Corporate Governance',
                'role_en' => 'Head of Legal & Corporate Governance',
                'bio_id' => 'Menjaga kepatuhan hukum korporasi, perlindungan hak kekayaan intelektual (IP/Paten), dan struktur kontrak kemitraan.',
                'bio_en' => 'Managing corporate compliance, intellectual property protection (IP/Patents), and partnership agreements.',
                'photo' => 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?auto=format&fit=crop&w=600&q=80',
                'initiative_id' => null,
                'is_active' => true,
                'organization' => 'Holding Executive Office',
                'period' => '2023 - Sekarang',
                'social_links' => [
                    'linkedin' => 'https://linkedin.com/in/hendra-gunawan',
                    'email' => 'legal@yotainovasi.id',
                ],
                'meta' => [
                    'skills' => ['Venture Legal', 'IP & Patent Rights', 'Corporate Governance', 'M&A Diligence'],
                    'badge' => 'Governance',
                ],
                'sort_order' => 5,
            ],
            [
                'name' => 'Dimas Wicaksono',
                'slug' => 'dimas-wicaksono',
                'role_id' => 'Former Lead Mobile Engineer (Alumni Advisor)',
                'role_en' => 'Former Lead Mobile Engineer (Alumni Advisor)',
                'bio_id' => 'Engineer perintis generasi awal YOIN yang kini berkarier di tingkat global dan aktif memberi mentoring bagi talenta muda.',
                'bio_en' => 'Founding mobile engineer from early generation, now thriving globally while actively mentoring young builders.',
                'photo' => 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&fit=crop&w=600&q=80',
                'initiative_id' => $digitalInitiative?->id,
                'is_active' => false,
                'organization' => 'Alumni Network / Tech Mentor',
                'period' => '2021 - 2024',
                'social_links' => [
                    'linkedin' => 'https://linkedin.com/in/dimas-wicaksono',
                    'github' => 'https://github.com/dimaswicaksono',
                ],
                'meta' => [
                    'skills' => ['Flutter', 'iOS/Android Native', 'System Optimization'],
                    'badge' => 'Alumni Star',
                ],
                'sort_order' => 6,
            ],
        ];

        foreach ($teamMembers as $tm) {
            Person::updateOrCreate(
                ['slug' => $tm['slug']],
                array_merge($tm, [
                    'category' => 'tim',
                    'visibility' => 'public',
                ])
            );
        }

        // -------------------------------------------------------------
        // 4. KONTRIBUTOR (MAGANG, RISET, KERJASAMA, FELLOWSHIP)
        // -------------------------------------------------------------

        $contributors = [
            [
                'name' => 'Rizky Ramadhan',
                'slug' => 'rizky-ramadhan',
                'role_id' => 'Cloud Infrastructure & API Intern',
                'role_en' => 'Cloud Infrastructure & API Intern',
                'bio_id' => 'Mengembangkan modul automasi pipeline deployment CI/CD untuk microservices holding.',
                'bio_en' => 'Developed automated CI/CD pipeline deployment modules for holding microservices.',
                'photo' => 'https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?auto=format&fit=crop&w=600&q=80',
                'initiative_id' => $digitalInitiative?->id,
                'contribution_type' => 'magang',
                'organization' => 'Institut Teknologi Bandung (Teknik Informatika)',
                'period' => 'Magang MBKM — Batch V (2025)',
                'social_links' => [
                    'linkedin' => 'https://linkedin.com/in/rizky-ramadhan',
                    'github' => 'https://github.com/rizkyramadhan',
                ],
                'meta' => [
                    'project_name' => 'Pipeline Automasi CI/CD YOIN Core',
                    'testimony' => 'Magang di YOIN memberikan pengalaman nyata memegang sistem produksi yang langsung melayani pengguna enterprise.',
                ],
                'sort_order' => 1,
            ],
            [
                'name' => 'Nadia Salsabila',
                'slug' => 'nadia-salsabila',
                'role_id' => 'Soil Carbon Research Fellow',
                'role_en' => 'Soil Carbon Research Fellow',
                'bio_id' => 'Melakukan analisis laboratorium mengenai penyerapan karbon tanah pada lahan percontohan regeneratif AGRONEX.',
                'bio_en' => 'Conducted laboratory analysis on soil carbon sequestration in AGRONEX regenerative demo plots.',
                'photo' => 'https://images.unsplash.com/photo-1517841905240-472988babdf9?auto=format&fit=crop&w=600&q=80',
                'initiative_id' => $agronexInitiative?->id,
                'contribution_type' => 'riset',
                'organization' => 'Universitas Padjadjaran (Fakultas Pertanian)',
                'period' => 'Riset Kolaboratif — 2024 / 2025',
                'social_links' => [
                    'linkedin' => 'https://linkedin.com/in/nadia-salsabila',
                ],
                'meta' => [
                    'project_name' => 'Kajian Kapasitas Serapan Karbon Tanah Merapi',
                    'testimony' => 'Akses langsung ke sensor lapangan membuat riset skripsi saya memiliki data riil yang sangat kaya.',
                ],
                'sort_order' => 2,
            ],
            [
                'name' => 'Galih Purnomo',
                'slug' => 'galih-purnomo',
                'role_id' => 'Local Bamboo Supply Coordinator',
                'role_en' => 'Local Bamboo Supply Coordinator',
                'bio_id' => 'Menghubungkan kelompok tani bambu di Tasikmalaya dengan standar pengeringan dan laminasi BUATARA.',
                'bio_en' => 'Connecting bamboo farmer collectives in Tasikmalaya with BUATARA drying and lamination standards.',
                'photo' => 'https://images.unsplash.com/photo-1501196354995-cbb51c65aaea?auto=format&fit=crop&w=600&q=80',
                'initiative_id' => $buataraInitiative?->id,
                'contribution_type' => 'kerjasama',
                'organization' => 'Kolektif Pengrajin Bambu Pasundan',
                'period' => 'Mitra Rantai Pasok — 2023 - Sekarang',
                'social_links' => [
                    'linkedin' => 'https://linkedin.com/in/galih-purnomo',
                ],
                'meta' => [
                    'project_name' => 'Standardisasi Pengawetan Bambu Ramah Lingkungan',
                    'testimony' => 'Kerjasama dengan BUATARA meningkatkan kepastian harga beli bambu petani hingga 35% lebih tinggi dari tengkulak.',
                ],
                'sort_order' => 3,
            ],
            [
                'name' => 'Farhan Maulana',
                'slug' => 'farhan-maulana',
                'role_id' => 'Youth Leadership Fellow',
                'role_en' => 'Youth Leadership Fellow',
                'bio_id' => 'Mendirikan pojok baca digital dan mentoring literasi komputer untuk anak-anak desa di Pangalengan.',
                'bio_en' => 'Founded a digital learning nook and computer literacy mentorship for rural children in Pangalengan.',
                'photo' => 'https://images.unsplash.com/photo-1522075469751-3a6694fb2f61?auto=format&fit=crop&w=600&q=80',
                'initiative_id' => $yacInitiative?->id,
                'contribution_type' => 'fellowship',
                'organization' => 'Nusantara Youth Innovation Fellowship',
                'period' => 'Fellow Angkatan 3 (2024)',
                'social_links' => [
                    'linkedin' => 'https://linkedin.com/in/farhan-maulana',
                    'instagram' => 'https://instagram.com/farhan.youth',
                ],
                'meta' => [
                    'project_name' => 'Pojok Belajar Digital Desa Sukamaju',
                    'testimony' => 'Fellowship dari YAC membekali saya dengan metodologi pemecahan masalah dan pendanaan benih untuk berdampak di kampung halaman.',
                ],
                'sort_order' => 4,
            ],
            [
                'name' => 'Aisyah Putri',
                'slug' => 'aisyah-putri',
                'role_id' => 'Nutritional Formulation Assistant',
                'role_en' => 'Nutritional Formulation Assistant',
                'bio_id' => 'Membantu uji proksimat dan standarisasi kadar indeks glikemik rendah pada tepung umbi YOIMO.',
                'bio_en' => 'Assisted proximate testing and low glycemic index standardization for YOIMO tuber flours.',
                'photo' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=600&q=80',
                'initiative_id' => $yoimoInitiative?->id,
                'contribution_type' => 'riset',
                'organization' => 'Institut Pertanian Bogor (Teknologi Pangan)',
                'period' => 'Riset Terapan — 2025',
                'social_links' => [
                    'linkedin' => 'https://linkedin.com/in/aisyah-putri',
                ],
                'meta' => [
                    'project_name' => 'Uji Karakteristik Fisikokimia Tepung Singkong Termodifikasi',
                    'testimony' => 'YOIMO memberi ruang bagi mahasiswa pangan untuk langsung menguji formulasi ke produk komersial nyata.',
                ],
                'sort_order' => 5,
            ],
        ];

        foreach ($contributors as $c) {
            Person::updateOrCreate(
                ['slug' => $c['slug']],
                array_merge($c, [
                    'category' => 'kontributor',
                    'is_active' => true,
                    'visibility' => 'public',
                ])
            );
        }
    }
}
