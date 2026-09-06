<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $articles = [
            [
                'title' => 'YOIN AI Lab & Sovereign Cloud: Membangun Fondasi Komputasi dan Keamanan Data Nasional',
                'title_en' => 'YOIN AI Lab & Sovereign Cloud: Building National Computing Infrastructure and Data Sovereignty',
                'slug' => 'yoin-ai-lab-sovereign-cloud-keamanan-data-nasional',
                'type' => 'inisiatif',
                'tag' => 'Kedaulatan Digital • 2026',
                'tag_en' => 'Digital Sovereignty • 2026',
                'badge' => 'Riset AI & Siber Nasional',
                'badge_en' => 'National AI & Cyber Research',
                'excerpt' => 'Pusat riset akselerasi kecerdasan buatan berstandar audit industri tertinggi guna melindungi dan memajukan ekosistem ekonomi digital Indonesia.',
                'excerpt_en' => 'An enterprise-grade artificial intelligence acceleration and research facility designed to safeguard and empower Indonesia\'s domestic digital economic ecosystem.',
                'content' => '
                    <p class="lead">Di era transformasi komputasi cerdas, kedaulatan data bukan sekadar jargon regulasi, melainkan pilar pertahanan strategis dan motor pertumbuhan ekonomi sebuah bangsa.</p>
                    <h2>Latar Belakang & Urgensi Nasional</h2>
                    <p>Fragmentasi infrastruktur komputasi awan dan ketergantungan pada pusat data luar negeri menghadirkan risiko kebocoran data strategis dan kerentanan keamanan siber. Melalui inisiatif <strong>YOIN AI Lab & Sovereign Cloud</strong>, kami membangun fondasi arsitektur awan hibrida yang berakar pada kedaulatan domestik dengan standar enkripsi kuantum-resisten.</p>
                    <blockquote>"Kemandirian teknologi tidak dibangun dengan menutup diri, melainkan dengan melahirkan standar komputasi nasional yang berdaya saing global dan aman bagi rakyat."</blockquote>
                    <h2>Pilar Rekayasa & Fokus Teknis</h2>
                    <ul>
                        <li><strong>Infrastruktur Komputasi Mikro Berdaulat:</strong> Kluster komputasi terdistribusi yang tersebar di titik strategis pulau-pulau besar Indonesia.</li>
                        <li><strong>Model AI Berbasis Konteks Bahasa Nusantara:</strong> Pelatihan model bahasa dan visi komputer yang memahami keanekaragaman dialek lokal dan pola ekonomi kepulauan.</li>
                        <li><strong>Audit Keamanan Zero-Trust:</strong> Protokol pengujian integritas kode sumber terbuka secara berkala bersama institusi akademisi terkemuka.</li>
                    </ul>
                    <h2>Dampak untuk Ekosistem Industri</h2>
                    <p>Dengan hadirnya platform ini, ribuan pengembang lokal dan startup perintis dapat mengakses daya komputasi tinggi dengan biaya terjangkau tanpa mengorbankan privasi data pengguna.</p>
                ',
                'content_en' => '
                    <p class="lead">In an era of intelligent computing transformation, data sovereignty is no longer merely a regulatory buzzword, but a foundational pillar of national defense and the primary engine of sustainable economic growth.</p>
                    <h2>Background & National Urgency</h2>
                    <p>Infrastructural fragmentation in cloud computing and over-reliance on offshore data centers introduce critical vulnerabilities in cyber resilience and data privacy. Through the <strong>YOIN AI Lab & Sovereign Cloud</strong> initiative, we engineer a resilient hybrid cloud architecture anchored domestically with quantum-resistant encryption standards.</p>
                    <blockquote>"Technological independence is not built by closing borders, but by establishing sovereign computing benchmarks that compete globally while safeguarding our citizens."</blockquote>
                    <h2>Engineering Pillars & Technical Focus</h2>
                    <ul>
                        <li><strong>Sovereign Micro-Compute Infrastructure:</strong> Distributed edge clusters strategically deployed across Indonesia\'s major island corridors.</li>
                        <li><strong>Contextual Nusantara AI Models:</strong> Large-scale language and computer vision models trained specifically on indigenous cultural contexts, local dialects, and archipelagic logistics.</li>
                        <li><strong>Continuous Zero-Trust Security Auditing:</strong> Rigorous vulnerability and source-code integrity verifications conducted in partnership with premier academic institutions.</li>
                    </ul>
                    <h2>Impact on the Industrial Ecosystem</h2>
                    <p>By democratizing sovereign computing, local software engineers and pioneering startups gain reliable access to high-performance GPUs at competitive local pricing without compromising compliance or data privacy.</p>
                ',
                'cover_image' => 'https://images.unsplash.com/photo-1518770660439-4636190af475?q=80&w=2000&auto=format&fit=crop',
                'author_name' => 'Tim Riset YOIN Digital',
                'reading_time' => 5,
                'status' => 'published',
                'is_featured' => true,
                'views_count' => 1420,
                'meta_title' => 'YOIN AI Lab & Sovereign Cloud: Kedaulatan Data Nasional',
                'meta_description' => 'Membangun fondasi komputasi awan berdaulat dan laboratorium kecerdasan buatan nasional dengan standar audit industri tertinggi.',
                'meta_keywords' => 'yoin ai lab, sovereign cloud, kedaulatan data, komputasi awan nusantara, keamanan siber',
                'published_at' => now()->subDays(2),
            ],
            [
                'title' => 'Kedaulatan Energi Terbarukan: Akselerasi Microgrid Tenaga Surya di 34 Titik Kepulauan Nusantara',
                'title_en' => 'Renewable Energy Sovereignty: Accelerating Solar Microgrids Across 34 Archipelagic Coastal Locations',
                'slug' => 'kedaulatan-energi-terbarukan-akselerasi-microgrid-surya',
                'type' => 'inisiatif',
                'tag' => 'Inisiatif Strategis • 2026',
                'tag_en' => 'Strategic Initiative • 2026',
                'badge' => 'Target 500 MW Bersih',
                'badge_en' => '500 MW Clean Target',
                'excerpt' => 'Penyediaan sistem kelistrikan mandiri terintegrasi berbasis baterai penyimpanan energi untuk ribuan keluarga dan sentra nelayan pesisir.',
                'excerpt_en' => 'Delivering integrated autonomous clean energy microgrids with battery energy storage for thousands of coastal families and fishing hubs.',
                'content' => '
                    <p class="lead">Listrik yang andal dan bersih adalah hak dasar setiap masyarakat kepulauan untuk mengembangkan potensi ekonomi maritim secara mandiri.</p>
                    <h2>Tantangan Elektrifikasi Wilayah 3T</h2>
                    <p>Banyak pulau terluar nusantara masih bergantung pada generator diesel yang mahal dan rentan terhadap keterlambatan rantai pasok bahan bakar fosil. Microgrid surya mandiri yang dilengkapi penyimpanan baterai lithium besi fosfat (LFP) menjadi solusi konkret dan berkelanjutan.</p>
                    <h2>Teknologi Smart Inverter & Monitoring IoT</h2>
                    <p>Setiap instalasi panel surya terhubung dengan jaringan telemetri satelit berdaya rendah yang memantau performa baterai, beban harian nelayan, dan kesehatan sel fotovoltaik secara real-time dari ruang kendali pusat.</p>
                ',
                'content_en' => '
                    <p class="lead">Reliable and sustainable electricity is a fundamental right that enables archipelagic communities to independently unlock their maritime economic potential.</p>
                    <h2>Electrification Challenges in Frontier Regions</h2>
                    <p>Remote islands across the Indonesian archipelago have historically relied on expensive diesel generators vulnerable to fuel supply chain disruptions. Autonomous photovoltaic microgrids paired with lithium iron phosphate (LFP) energy storage provide a dependable, zero-carbon alternative.</p>
                    <h2>Smart Inverter Architecture & IoT Telemetry</h2>
                    <p>Every field installation is monitored via low-power satellite telemetry, tracking battery health, coastal load profiles, and solar cell degradation in real time from central command dashboards.</p>
                ',
                'cover_image' => 'https://images.unsplash.com/photo-1509391365360-2e959784a276?q=80&w=2000&auto=format&fit=crop',
                'author_name' => 'Tim Riset Energi BUATARA',
                'reading_time' => 4,
                'status' => 'published',
                'is_featured' => true,
                'views_count' => 980,
                'meta_title' => 'Kedaulatan Energi Terbarukan: Microgrid Tenaga Surya Nusantara',
                'meta_description' => 'Akselerasi sistem microgrid fotovoltaik mandiri di 34 titik kepulauan pesisir Indonesia.',
                'meta_keywords' => 'energi terbarukan, microgrid surya, pulau terluar, panel surya nusantara, solar energy',
                'published_at' => now()->subDays(5),
            ],
            [
                'title' => 'Mobilitas Cerdas Rendah Emisi: Penerapan Koridor Transportasi Listrik Komersial Terpadu',
                'title_en' => 'Low-Emission Smart Mobility: Deploying Integrated Commercial Electric Transportation Corridors',
                'slug' => 'mobilitas-cerdas-rendah-emisi-koridor-transportasi-listrik',
                'type' => 'inisiatif',
                'tag' => 'Smart City & IKN • 2026',
                'tag_en' => 'Smart City & IKN • 2026',
                'badge' => 'Transformasi Hijau IKN',
                'badge_en' => 'IKN Green Transformation',
                'excerpt' => 'Sistem armada logistik dan angkutan massal ramah lingkungan yang dirancang untuk mendukung visi net-zero Ibu Kota Nusantara.',
                'excerpt_en' => 'Clean commercial logistics fleets and public transit systems engineered to accelerate Nusantara New Capital\'s net-zero carbon vision.',
                'content' => '
                    <p class="lead">Integrasi armada transportasi listrik bukan hanya tentang mengganti mesin bahan bakar, melainkan merancang sistem logistik cerdas yang efisien energi.</p>
                    <h2>Uji Coba Sandbox IKN</h2>
                    <p>Melalui program sandbox di kawasan Ibu Kota Nusantara, kami menguji performa baterai pada kontur perbukitan tropis dan integrasi sistem pertukaran baterai kilat untuk kendaraan utilitas perkotaan.</p>
                ',
                'content_en' => '
                    <p class="lead">Electric vehicle fleet integration goes beyond swapping combustion engines; it demands intelligent routing algorithms and optimized energy management.</p>
                    <h2>IKN Regulatory Sandbox Trials</h2>
                    <p>Through dedicated pilot programs in Nusantara Capital, we rigorously test battery performance under tropical hilly conditions and validate rapid battery-swapping networks for municipal utility vehicles.</p>
                ',
                'cover_image' => 'https://images.unsplash.com/photo-1519641471654-76ce0107ad1b?q=80&w=2000&auto=format&fit=crop',
                'author_name' => 'Divisi Mobilitas Cerdas',
                'reading_time' => 3,
                'status' => 'published',
                'is_featured' => true,
                'views_count' => 740,
                'meta_title' => 'Mobilitas Cerdas Rendah Emisi untuk Ibu Kota Nusantara',
                'meta_description' => 'Sistem transportasi dan logistik komersial listrik terintegrasi untuk mendukung net-zero emission.',
                'meta_keywords' => 'mobilitas cerdas, transportasi listrik, smart city ikn, logistik hijau',
                'published_at' => now()->subDays(8),
            ],
            [
                'title' => 'Hilirisasi Sensor IoT & Agronomi Presisi: Mengoptimalkan Hasil Panen Petani Nusantara',
                'title_en' => 'IoT Sensor Downstreaming & Precision Agronomy: Maximizing Yields for Archipelagic Smallholders',
                'slug' => 'hilirisasi-sensor-iot-agronomi-presisi-hasil-panen',
                'type' => 'jurnal',
                'tag' => 'Jurnal Agroteknologi • 2026',
                'tag_en' => 'Agrotechnology Journal • 2026',
                'badge' => 'Publikasi Riset AGRONEX',
                'badge_en' => 'AGRONEX Research Publication',
                'excerpt' => 'Studi lapangan penerapan sensor kelembaban tanah nirkabel dan pemantauan hara otomatis pada 1.200 hektar lahan pertanian rakyat.',
                'excerpt_en' => 'Field research analyzing autonomous wireless soil moisture telemetry and automated nutrient monitoring across 1,200 hectares of community farmland.',
                'content' => '
                    <p class="lead">Pertanian presisi bukan kemewahan bagi korporasi besar, melainkan instrumen vital agar petani kecil dapat menghemat air, memangkas pupuk berlebih, dan melipatgandakan hasil panen.</p>
                    <h2>Metodologi & Data Lapangan</h2>
                    <p>Pengujian dilakukan selama tiga musim tanam di Jawa Barat dan Sulawesi Selatan dengan membandingkan petak kontrol konvensional versus petak yang dipandu sensor IoT berdaya surya mandiri.</p>
                    <h2>Hasil & Kesimpulan</h2>
                    <p>Hasil penelitian membuktikan pengurangan konsumsi air irigasi sebesar 32% dan kenaikan tonase gabah kering panen sebesar 24% per hektar.</p>
                ',
                'content_en' => '
                    <p class="lead">Precision agronomy is not a luxury reserved for industrial agro-conglomerates; it is a vital equalizer enabling smallholders to conserve irrigation water, eliminate chemical over-fertilization, and dramatically improve crop productivity.</p>
                    <h2>Field Methodology & Data Analysis</h2>
                    <p>Rigorous comparative studies conducted over three full harvest cycles across West Java and South Sulawesi evaluated traditional control plots against sensor-guided micro-dosing plots powered by solar IoT telemetry.</p>
                    <h2>Empirical Findings</h2>
                    <p>Field data validated a 32% net reduction in freshwater irrigation requirements alongside a 24% increase in dry grain harvest tonnage per hectare.</p>
                ',
                'cover_image' => 'https://images.unsplash.com/photo-1500651230702-0e2d8a49d4ad?q=80&w=2000&auto=format&fit=crop',
                'author_name' => 'Anisa Larasati, M.Sc. & Tim AGRONEX',
                'reading_time' => 6,
                'status' => 'published',
                'is_featured' => false,
                'views_count' => 1120,
                'meta_title' => 'Jurnal Riset: Sensor IoT dan Agronomi Presisi Petani Nusantara',
                'meta_description' => 'Studi empiris hilirisasi sensor IoT tanah dan efisiensi air pada lahan pertanian rakyat di Indonesia.',
                'meta_keywords' => 'agronomi presisi, sensor iot tanah, riset pertanian, agronex, hasil panen',
                'published_at' => now()->subDays(10),
            ],
            [
                'title' => 'Biomaterial Sirkular Berbasis Limbah Pertanian: Masa Depan Kriya & Kemasan Ramah Lingkungan',
                'title_en' => 'Circular Biomaterials from Agricultural Residue: The Future of Eco-Conscious Packaging and Craft',
                'slug' => 'biomaterial-sirkular-limbah-pertanian-kemasan-ramah-lingkungan',
                'type' => 'publikasi',
                'tag' => 'Desain Sirkular • 2026',
                'tag_en' => 'Circular Design • 2026',
                'badge' => 'Inovasi Material YOIMO',
                'badge_en' => 'YOIMO Material Innovation',
                'excerpt' => 'Pemanfaatan miselium jamur dan serat ampas tebu sebagai substitusi styrofoam dan plastik kemasan industri kreatif.',
                'excerpt_en' => 'Utilizing fungal mycelium and bagasse fibers as sustainable biodegradable alternatives to industrial polystyrene and single-use packaging.',
                'content' => '
                    <p class="lead">Menutup siklus limbah pertanian menjadi produk fungsional bernilai estetika tinggi adalah jawaban atas krisis sampah kemasan modern.</p>
                    <h2>Daur Hidup Material Alami</h2>
                    <p>Material komposit miselium dapat terurai secara alami dalam tanah dalam kurun waktu 45 hari tanpa meninggalkan residu mikroplastik beracun.</p>
                ',
                'content_en' => '
                    <p class="lead">Closing the loop on post-harvest biomass into aesthetic, high-strength industrial materials offers a definitive antidote to global single-use packaging waste.</p>
                    <h2>Life-Cycle Assessment & Biodegradability</h2>
                    <p>Bio-composite mycelium formulations demonstrate complete non-toxic decomposition within 45 days in home compost environments, leaving zero microplastic or fluorochemical residues.</p>
                ',
                'cover_image' => 'https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?q=80&w=2000&auto=format&fit=crop',
                'author_name' => 'Bima Satria Nugraha & Studio YOIMO',
                'reading_time' => 4,
                'status' => 'published',
                'is_featured' => false,
                'views_count' => 630,
                'meta_title' => 'Biomaterial Sirkular: Alternatif Kemasan Hijau Masa Depan',
                'meta_description' => 'Inovasi pemanfaatan biomaterial sirkular dari limbah pertanian untuk kemasan dan kriya berkelanjutan.',
                'meta_keywords' => 'biomaterial, desain sirkular, kemasan ramah lingkungan, yoimo, miselium',
                'published_at' => now()->subDays(14),
            ],
            [
                'title' => 'Restorasi Terumbu Karang Berbasis AI & Akuntansi Karbon Maritim Nusantara',
                'title_en' => 'AI-Assisted Coral Reef Restoration and Archipelagic Blue Carbon Accounting',
                'slug' => 'restorasi-terumbu-karang-ai-akuntansi-karbon-maritim',
                'type' => 'jurnal',
                'tag' => 'Konservasi Laut • 2026',
                'tag_en' => 'Marine Conservation • 2026',
                'badge' => 'Riset YAC Impact',
                'badge_en' => 'YAC Impact Research',
                'excerpt' => 'Penggunaan citra bawah air photogrammetry dan model visi komputer untuk memantau laju pertumbuhan terumbu karang hasil transplantasi.',
                'excerpt_en' => 'Deploying subsea photogrammetry and computer vision models to quantify growth metrics and blue carbon sequestration in transplanted coral ecosystems.',
                'content' => '
                    <p class="lead">Kekayaan maritim Indonesia menyimpan potensi karbon biru terbesar di dunia yang membutuhkan audit biologis presisi tinggi.</p>
                    <h2>Pemantauan Ekologi Otonom</h2>
                    <p>Kamera bawah air terkalibrasi mengambil ribuan foto gugusan karang yang dianalisis oleh algoritma visi komputer untuk mendeteksi kesehatan koloni karang secara otomatis.</p>
                ',
                'content_en' => '
                    <p class="lead">Indonesia\'s vast marine commons harbor the world\'s richest blue carbon ecosystems, necessitating rigorous, high-precision autonomous ecological auditing.</p>
                    <h2>Autonomous Oceanographic Telemetry</h2>
                    <p>Calibrated underwater camera systems capture volumetric stereo photogrammetry, automatically processed by convolutional neural networks to classify coral polyp vitality, species coverage, and calcification rates.</p>
                ',
                'cover_image' => 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?q=80&w=2000&auto=format&fit=crop',
                'author_name' => 'Clarissa Maharani & Tim YAC Impact',
                'reading_time' => 5,
                'status' => 'published',
                'is_featured' => false,
                'views_count' => 890,
                'meta_title' => 'Restorasi Terumbu Karang Berbasis AI & Karbon Biru',
                'meta_description' => 'Penerapan teknologi visi komputer dalam pemantauan ekologi karang dan verifikasi karbon biru maritim.',
                'meta_keywords' => 'restorasi karang, ai maritim, karbon biru, yac impact, konservasi laut',
                'published_at' => now()->subDays(20),
            ],
        ];

        foreach ($articles as $data) {
            Article::updateOrCreate(['slug' => $data['slug']], $data);
        }
    }
}
