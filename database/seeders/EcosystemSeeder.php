<?php

namespace Database\Seeders;

use App\Models\EcosystemCategory;
use App\Models\EcosystemClient;
use App\Models\EcosystemDocument;
use App\Models\EcosystemDomain;
use App\Models\EcosystemImpactMetric;
use App\Models\EcosystemImpactPillar;
use App\Models\EcosystemInitiative;
use App\Models\EcosystemProduct;
use App\Models\EcosystemProject;
use App\Models\EcosystemType;
use Illuminate\Database\Seeder;

class EcosystemSeeder extends Seeder
{
    /**
     * Seed the ecosystem hierarchy: Domain -> Initiative -> Product/Movement -> Category -> Type -> Project/Client
     */
    public function run(): void
    {
        // -------------------------------------------------------------
        // 1. CLIENTS & PARTNERS DIRECTORY
        // -------------------------------------------------------------
        $clientDanantara = EcosystemClient::updateOrCreate(
            ['slug' => 'danantara-nusantara'],
            [
                'name' => 'PT Danantara Nusantara',
                'client_type' => 'Mitra Strategis',
                'industry' => 'Investment & Asset Management',
                'location' => 'Jakarta, Indonesia',
                'website_url' => 'https://danantara.id',
                'description_id' => 'Konglomerasi investasi strategis nasional yang mengelola aset lintas industri di Indonesia.',
                'description_en' => 'Strategic national investment group managing multi-sector assets across Indonesia.',
                'is_active' => true,
            ]
        );

        $clientAgro = EcosystemClient::updateOrCreate(
            ['slug' => 'kelompok-tani-makmur-merapi'],
            [
                'name' => 'Kelompok Tani Makmur Merapi',
                'client_type' => 'Komunitas & NGO',
                'industry' => 'Hortikultura & Pertanian Rakyat',
                'location' => 'Sleman, D.I. Yogyakarta',
                'website_url' => null,
                'description_id' => 'Kolektif petani hortikultura lereng selatan Gunung Merapi dengan 140 anggota aktif.',
                'description_en' => 'Horticultural farming collective on the southern slopes of Mount Merapi with 140 active members.',
                'is_active' => true,
            ]
        );

        $clientKemenkop = EcosystemClient::updateOrCreate(
            ['slug' => 'kementerian-koperasi-ukm'],
            [
                'name' => 'Kementerian Koperasi & UKM RI',
                'client_type' => 'Pemerintah & BUMN',
                'industry' => 'Public Sector & Cooperatives',
                'location' => 'Jakarta, Indonesia',
                'website_url' => 'https://kemenkopukm.go.id',
                'description_id' => 'Kementerian pembina ekosistem koperasi dan usaha mikro kecil menengah nasional.',
                'description_en' => 'Government ministry fostering national cooperative and SME ecosystem growth.',
                'is_active' => true,
            ]
        );

        $clientKomdigi = EcosystemClient::updateOrCreate(
            ['slug' => 'kementerian-komunikasi-digital'],
            [
                'name' => 'Kementerian Komunikasi dan Digital RI',
                'client_type' => 'Pemerintah & BUMN',
                'industry' => 'Digital Infrastructure & Governance',
                'location' => 'Jakarta, Indonesia',
                'website_url' => 'https://komdigi.go.id',
                'description_id' => 'Regulator dan pendorong transformasi kedaulatan digital terpadu nusantara.',
                'description_en' => 'Regulator and catalyst for Indonesia national digital sovereignty and transformation.',
                'is_active' => true,
            ]
        );

        $clientPLN = EcosystemClient::updateOrCreate(
            ['slug' => 'pln-nusantara-power'],
            [
                'name' => 'PLN Nusantara Power',
                'client_type' => 'Pemerintah & BUMN',
                'industry' => 'Clean Energy & Smart Grid',
                'location' => 'Surabaya, Jawa Timur',
                'website_url' => 'https://plnnusantarapower.co.id',
                'description_id' => 'Subholding pembangkitan terintegrasi pelopor transisi energi terbarukan Indonesia.',
                'description_en' => 'Integrated generation subholding pioneering renewable energy transition in Indonesia.',
                'is_active' => true,
            ]
        );

        $clientITB = EcosystemClient::updateOrCreate(
            ['slug' => 'itb-innovation-park'],
            [
                'name' => 'ITB Innovation Park',
                'client_type' => 'Akademisi & Riset',
                'industry' => 'Higher Education & Deep-Tech Lab',
                'location' => 'Bandung, Jawa Barat',
                'website_url' => 'https://itb.ac.id',
                'description_id' => 'Pusat riset terapan dan inkubasi hilirisasi teknologi kecerdasan buatan dan rekayasa cerdas.',
                'description_en' => 'Applied research hub and technology transfer incubator for smart engineering and AI.',
                'is_active' => true,
            ]
        );

        $clientKehati = EcosystemClient::updateOrCreate(
            ['slug' => 'yayasan-kehati'],
            [
                'name' => 'Yayasan KEHATI',
                'client_type' => 'Mitra Strategis',
                'industry' => 'Biodiversity & ESG Sustainability',
                'location' => 'Jakarta Selatan, Indonesia',
                'website_url' => 'https://kehati.or.id',
                'description_id' => 'Lembaga konservasi keanekaragaman hayati dan penggerak investasi hijau berkelanjutan.',
                'description_en' => 'Biodiversity conservation foundation and driver of sustainable green investment.',
                'is_active' => true,
            ]
        );

        $clientAsosiasiAgro = EcosystemClient::updateOrCreate(
            ['slug' => 'asosiasi-agroteknologi-nusantara'],
            [
                'name' => 'Asosiasi Agroteknologi Nusantara',
                'client_type' => 'Mitra Strategis',
                'industry' => 'Smart Agriculture Consortium',
                'location' => 'Bogor, Jawa Barat',
                'website_url' => null,
                'description_id' => 'Jejaring kolaboratif inovator agrikultur dan praktisi ketahanan pangan nusantara.',
                'description_en' => 'Collaborative network of agricultural innovators and food security practitioners.',
                'is_active' => true,
            ]
        );

        $clientGridConsortium = EcosystemClient::updateOrCreate(
            ['slug' => 'nusantara-renewable-grid'],
            [
                'name' => 'Nusantara Renewable Grid Consortium',
                'client_type' => 'Klien Komersial',
                'industry' => 'Solar Microgrid & Energy Storage',
                'location' => 'Balikpapan, Kalimantan Timur',
                'website_url' => null,
                'description_id' => 'Konsorsium pengembang microgrid desentralistik untuk kawasan industri hijau IKN.',
                'description_en' => 'Decentralized microgrid developer consortium for IKN green industrial estates.',
                'is_active' => true,
            ]
        );

        $clientLogistikMaritim = EcosystemClient::updateOrCreate(
            ['slug' => 'pt-sentra-logistik-maritim'],
            [
                'name' => 'PT Sentra Logistik Maritim',
                'client_type' => 'Klien Komersial',
                'industry' => 'Cold Chain & Maritime Supply Chain',
                'location' => 'Makassar, Sulawesi Selatan',
                'website_url' => null,
                'description_id' => 'Penyedia infrastruktur rantai pendingin maritim untuk nelayan dan hasil tangkapan laut timur.',
                'description_en' => 'Maritime cold chain infrastructure provider for eastern fisheries and sea catch.',
                'is_active' => true,
            ]
        );

        $clientUnpad = EcosystemClient::updateOrCreate(
            ['slug' => 'unpad-esg-center'],
            [
                'name' => 'Universitas Padjadjaran ESG Center',
                'client_type' => 'Akademisi & Riset',
                'industry' => 'Applied Economic & Circular Research',
                'location' => 'Jatinangor, Jawa Barat',
                'website_url' => 'https://unpad.ac.id',
                'description_id' => 'Pusat kajian ilmiah dampak lingkungan, tata kelola keberlanjutan, dan ekonomi sirkular.',
                'description_en' => 'Research center for environmental impact, sustainable governance, and circular economy.',
                'is_active' => true,
            ]
        );

        $clientPengrajinBambu = EcosystemClient::updateOrCreate(
            ['slug' => 'kolektif-pengrajin-bambu-pasundan'],
            [
                'name' => 'Kolektif Pengrajin Bambu Pasundan',
                'client_type' => 'Komunitas & NGO',
                'industry' => 'Sustainable Material & Artisan Guild',
                'location' => 'Sukabumi, Jawa Barat',
                'website_url' => null,
                'description_id' => 'Sentra pengrajin material terbarukan bambu untuk perabot dan kemasan ramah lingkungan.',
                'description_en' => 'Renewable bamboo artisan cooperative for eco-friendly furniture and packaging.',
                'is_active' => true,
            ]
        );

        // -------------------------------------------------------------
        // 2. DOMAINS
        // -------------------------------------------------------------

        // Domain 1: DIGITAL
        $domainDigital = EcosystemDomain::updateOrCreate(
            ['slug' => 'digital'],
            [
                'name_id' => 'Solusi & Rekayasa Digital',
                'name_en' => 'Digital Solutions & Engineering',
                'tagline_id' => 'Menghubungkan alur kerja enterprise dan ekosistem komunitas dengan rekayasa teknologi mutakhir.',
                'tagline_en' => 'Bridging enterprise workflows and community ecosystems with modern digital engineering.',
                'problem_statement_id' => 'Fragmentasi sistem digital di Indonesia sering membuat UMKM, korporasi, dan lembaga publik terperangkap dalam tumpukan solusi yang mahal, kaku, dan sulit diskalakan, sehingga inovasi tersendat di tingkat implementasi teknis.',
                'problem_statement_en' => 'Digital fragmentation often leaves enterprises, SMEs, and public institutions trapped in costly, rigid, and unscalable tech stacks, stalling innovation at the execution layer.',
                'solution_statement_id' => 'Membangun infrastruktur perangkat lunak kustom, platform komputasi awan, dan produk digital adaptif yang mengutamakan kecepatan implementasi, keandalan arsitektur, dan pengalaman pengguna berstandar tinggi.',
                'solution_statement_en' => 'Engineering robust custom software, cloud infrastructure, and adaptive digital products prioritizing rapid deployment, architectural reliability, and world-class UX.',
                'short_description_id' => 'Pilar rekayasa perangkat lunak, arsitektur data, otomasi kecerdasan buatan, dan transformasi sistem terintegrasi.',
                'short_description_en' => 'Software engineering pillar, data architecture, AI automation, and integrated systems transformation.',
                'long_description_id' => 'Domain Digital berfokus pada pembangunan solusi piranti lunak berdaya tahan tinggi untuk memecahkan kompleksitas operasional di sektor riil.',
                'long_description_en' => 'The Digital Domain focuses on engineering resilient software solutions that resolve operational complexity in the real economy.',
                'hero_image' => 'https://images.unsplash.com/photo-1550751827-4bd374c3f58b?auto=format&fit=crop&w=1200&q=80',
                'cover_image' => 'https://images.unsplash.com/photo-1451187580459-43490279c0fa?auto=format&fit=crop&w=1200&q=80',
                'icon' => 'code-bracket',
                'icon_image' => 'https://images.unsplash.com/photo-1550751827-4bd374c3f58b?auto=format&fit=crop&w=400&q=80',
                'gallery' => [
                    'https://images.unsplash.com/photo-1531482615713-2afd69097998?auto=format&fit=crop&w=800&q=80',
                    'https://images.unsplash.com/photo-1504384308090-c894fdcc538d?auto=format&fit=crop&w=800&q=80',
                    'https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&w=800&q=80',
                ],
                'sdgs' => [
                    'SDG 8: Pekerjaan Layak & Pertumbuhan Ekonomi',
                    'SDG 9: Industri, Inovasi & Infrastruktur',
                    'SDG 17: Kemitraan untuk Mencapai Tujuan',
                ],
                'issues' => [
                    [
                        'issue' => 'Fragmentasi tumpukan software warisan (legacy) yang mahal, kaku, dan lambat diintegrasikan.',
                        'solution' => 'Arsitektur modular cloud-native dan API terpadu yang memangkas biaya integrasi hingga 60% dan mempercepat deployment.',
                    ],
                    [
                        'issue' => 'Kesenjangan talenta rekayasa perangkat lunak berstandar global untuk sektor industri riil.',
                        'solution' => 'Inkubasi dan mentoring intensif tim engineer in-house dengan metodologi rekayasa modern dan audit kode otomatis.',
                    ],
                    [
                        'issue' => 'Rendahnya keamanan data dan kedaulatan komputasi pada institusi publik maupun swasta.',
                        'solution' => 'Infrastruktur zero-trust dengan enkripsi data berlapis dan kepatuhan penuh pada regulasi perlindungan data pribadi.',
                    ],
                ],
                'program_logos' => [
                    'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?auto=format&fit=crop&w=200&q=80',
                ],
                'status' => 'OPERATING',
                'visibility' => 'public',
                'sort_order' => 1,
                'is_featured' => true,
            ]
        );

        // Domain 2: AGRICULTURE
        $domainAgri = EcosystemDomain::updateOrCreate(
            ['slug' => 'agriculture'],
            [
                'name_id' => 'Agrikultur & Ketahanan Pangan',
                'name_en' => 'Agriculture & Food Security',
                'tagline_id' => 'Memberdayakan petani dan pertanian regeneratif melalui teknologi presisi dan akses pasar yang adil.',
                'tagline_en' => 'Empowering farmers and regenerative agriculture with smart technology and fair market access.',
                'problem_statement_id' => 'Rantai pasok pangan yang panjang dan minimnya adopsi teknologi presisi di kalangan petani kecil mengakibatkan volatilitas harga panen yang tinggi, penyusutan hasil panen hingga 30%, serta pendapatan petani yang rentan terpuruk.',
                'problem_statement_en' => 'Long agricultural supply chains and lack of precision tools cause severe crop yield volatility, post-harvest losses up to 30%, and chronic farmer economic vulnerability.',
                'solution_statement_id' => 'Menghadirkan ekosistem pertanian cerdas dari hulu ke hilir yang mengintegrasikan monitoring sensor mikro, transparansi harga pasar, dan program pendampingan lapangan berkelanjutan.',
                'solution_statement_en' => 'Delivering an end-to-end smart agriculture ecosystem combining micro-sensor monitoring, fair market transparency, and continuous on-ground farmer accompaniment.',
                'short_description_id' => 'Inovasi teknologi pertanian presisi, sensor IoT tanah, dan penguatan rantai nilai pangan lokal.',
                'short_description_en' => 'Precision agriculture innovation, IoT soil sensors, and local food value chain enhancement.',
                'long_description_id' => 'Mendampingi produsen pangan di tingkat tapak agar mampu memprediksi iklim mikro, menghemat air dan pupuk, serta terhubung langsung ke pasar premium.',
                'long_description_en' => 'Assisting grassroots food growers to anticipate microclimates, optimize resources, and access premium commercial markets.',
                'hero_image' => 'https://images.unsplash.com/photo-1500937386664-56d1dfef3854?auto=format&fit=crop&w=1200&q=80',
                'cover_image' => 'https://images.unsplash.com/photo-1625246333195-78d9c38ad449?auto=format&fit=crop&w=1200&q=80',
                'icon' => 'globe-alt',
                'icon_image' => 'https://images.unsplash.com/photo-1625246333195-78d9c38ad449?auto=format&fit=crop&w=400&q=80',
                'gallery' => [
                    'https://images.unsplash.com/photo-1592417817098-8f3d69109853?auto=format&fit=crop&w=800&q=80',
                    'https://images.unsplash.com/photo-1595974482597-4b8da8879bc5?auto=format&fit=crop&w=800&q=80',
                    'https://images.unsplash.com/photo-1586771107445-d3ca888129ff?auto=format&fit=crop&w=800&q=80',
                ],
                'sdgs' => [
                    'SDG 2: Tanpa Kelaparan',
                    'SDG 12: Konsumsi & Produksi Bertanggung Jawab',
                    'SDG 13: Penanganan Perubahan Iklim',
                    'SDG 15: Ekosistem Daratan',
                ],
                'issues' => [
                    [
                        'issue' => 'Rantai pasok komoditas pangan yang panjang dan manipulasi harga di tingkat tengkulak.',
                        'solution' => 'Platform marketplace terintegrasi yang menghubungkan langsung gabungan kelompok tani ke off-taker industri dan konsumen.',
                    ],
                    [
                        'issue' => 'Penyusutan hasil panen (food loss) hingga 30% akibat minimnya monitoring iklim mikro dan kelembaban tanah.',
                        'solution' => 'Pemasangan sensor IoT tanah dan stasiun cuaca mikro presisi berbiaya terjangkau dengan notifikasi waktu riil.',
                    ],
                    [
                        'issue' => 'Ketergantungan pupuk kimia sintetis berlebih yang merusak kesuburan tanah jangka panjang.',
                        'solution' => 'Transisi pertanian regeneratif dan formulasi pupuk hayati organik bersertifikasi dengan pendampingan agronomis.',
                    ],
                ],
                'program_logos' => [
                    'https://images.unsplash.com/photo-1560493676-04071c5f467b?auto=format&fit=crop&w=200&q=80',
                ],
                'status' => 'OPERATING',
                'visibility' => 'public',
                'sort_order' => 2,
                'is_featured' => true,
            ]
        );

        // Domain 3: IMPACT
        $domainImpact = EcosystemDomain::updateOrCreate(
            ['slug' => 'impact'],
            [
                'name_id' => 'Pemberdayaan & Dampak Sosial',
                'name_en' => 'Social Empowerment & Impact',
                'tagline_id' => 'Kepemimpinan akar rumput, pendidikan kontekstual, dan inkubasi kapasitas inklusif untuk perintis masa depan.',
                'tagline_en' => 'Grassroots leadership, contextual learning, and inclusive capacity incubation for future changemakers.',
                'problem_statement_id' => 'Kesenjangan keterampilan digital dan literasi kewirausahaan di kalangan pemuda pedesaan dan daerah terluar membatasi mobilitas sosial dan penciptaan lapangan kerja lokal yang bermartabat.',
                'problem_statement_en' => 'The widening digital skills gap and lack of entrepreneurial literacy among rural and peri-urban youth stifle social mobility and dignified local job creation.',
                'solution_statement_id' => 'Menginkubasi gerakan sosial dan pusat pembelajaran yang menyediakan kurikulum aplikatif, jejaring mentor nasional, dan akses modal awal untuk solusi berbasis komunitas.',
                'solution_statement_en' => 'Incubating social movements and knowledge hubs delivering experiential curricula, national mentorship networks, and seed catalytic funding for community-led initiatives.',
                'short_description_id' => 'Pendidikan kepemimpinan pemuda, riset aksi partisipatif, beasiswa inovasi, dan perberdayaan komunitas.',
                'short_description_en' => 'Youth leadership education, participatory action research, innovation fellowships, and community empowerment.',
                'long_description_id' => 'Melalui pilar Dampak Sosial, ekosistem mengalirkan pengetahuan, sumber daya, dan jaringan strategis ke simpul-simpul penggerak di seluruh nusantara.',
                'long_description_en' => 'Through the Impact pillar, the ecosystem channels knowledge, resources, and strategic networks to grassroots catalyst nodes across Indonesia.',
                'hero_image' => 'https://images.unsplash.com/photo-1517048676732-d65bc937f952?auto=format&fit=crop&w=1200&q=80',
                'cover_image' => 'https://images.unsplash.com/photo-1529156069898-49953e39b3ac?auto=format&fit=crop&w=1200&q=80',
                'icon' => 'user-group',
                'icon_image' => 'https://images.unsplash.com/photo-1529156069898-49953e39b3ac?auto=format&fit=crop&w=400&q=80',
                'gallery' => [
                    'https://images.unsplash.com/photo-1531206715517-5c0ba140b2b8?auto=format&fit=crop&w=800&q=80',
                    'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&w=800&q=80',
                ],
                'sdgs' => [
                    'SDG 4: Pendidikan Berkualitas',
                    'SDG 10: Berkurangnya Kesenjangan',
                    'SDG 11: Kota & Komunitas Berkelanjutan',
                ],
                'issues' => [
                    [
                        'issue' => 'Minimnya akses pemuda daerah terluar terhadap pendidikan keterampilan digital dan wirausaha kontekstual.',
                        'solution' => 'Pusat inkubasi pembelajaran hibrida dengan kurikulum terapan dan beasiswa penuh bagi perintis komunitas lokal.',
                    ],
                    [
                        'issue' => 'Rendahnya tingkat retensi dan keberlanjutan ekonomi inisiatif sosial berbasis kerelawanan.',
                        'solution' => 'Model bisnis sosial teruji dan akses jejaring filantropi katalitis untuk menjamin kemandirian operasional.',
                    ],
                ],
                'program_logos' => [],
                'status' => 'OPERATING',
                'visibility' => 'public',
                'sort_order' => 3,
                'is_featured' => true,
            ]
        );

        // Domain 4: PRODUCTS
        $domainProducts = EcosystemDomain::updateOrCreate(
            ['slug' => 'products'],
            [
                'name_id' => 'Produk Konsumen & Gaya Hidup',
                'name_en' => 'Consumer & Lifestyle Products',
                'tagline_id' => 'Menciptakan produk bernilai guna, berkelanjutan, dan berfilosofi nusantara untuk keseharian modern.',
                'tagline_en' => 'Crafting purposeful, sustainable, and culturally-rooted products for mindful everyday living.',
                'problem_statement_id' => 'Banjir produk konsumsi impor sekali pakai yang tidak ramah lingkungan dan minim nilai filosofis lokal menggerus apresiasi terhadap karya bernilai guna tinggi dari negeri sendiri.',
                'problem_statement_en' => 'The flood of single-use disposable imports displaces authentic local craftsmanship and compromises environmental sustainability.',
                'solution_statement_id' => 'Mengembangkan lini produk konsumsi dan gaya hidup yang mengedepankan bahan alami terbarukan, kemasan sirkular, dan fungsi tahan lama.',
                'solution_statement_en' => 'Developing functional consumer and lifestyle brands driven by renewable natural materials, circular packaging, and timeless industrial utility.',
                'short_description_id' => 'Merek konsumen mandiri, pangan sehat berbasis komoditas lokal, dan kerajinan berkelanjutan modern.',
                'short_description_en' => 'Independent consumer brands, nutritious local foods, and modern sustainable crafts.',
                'long_description_id' => 'Mengubah potensi bahan baku alam Indonesia menjadi produk konsumsi unggulan yang membanggakan.',
                'long_description_en' => 'Transforming native Indonesian bio-materials into superior everyday lifestyle staples.',
                'hero_image' => 'https://images.unsplash.com/photo-1556911220-e15b29be8c8f?auto=format&fit=crop&w=1200&q=80',
                'cover_image' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&w=1200&q=80',
                'icon' => 'sparkles',
                'icon_image' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&w=400&q=80',
                'gallery' => [
                    'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=800&q=80',
                ],
                'sdgs' => [
                    'SDG 12: Konsumsi & Produksi Bertanggung Jawab',
                ],
                'issues' => [
                    [
                        'issue' => 'Tingginya timbulan sampah kemasan sekali pakai dari produk konsumsi massal impor.',
                        'solution' => 'Desain kemasan sirkular bebas plastik berbasis bio-material lokal yang dapat terurai secara alami.',
                    ],
                ],
                'program_logos' => [],
                'status' => 'BUILDING',
                'visibility' => 'public',
                'sort_order' => 4,
                'is_featured' => false,
            ]
        );

        // Domain 5: EMERGING
        $domainEmerging = EcosystemDomain::updateOrCreate(
            ['slug' => 'emerging'],
            [
                'name_id' => 'Riset Masa Depan & Teknologi Baru',
                'name_en' => 'Future Research & Emerging Tech',
                'tagline_id' => 'Menjelajahi batas terdepan komputasi terdesentralisasi, kecerdasan buatan etis, dan transisi energi hijau.',
                'tagline_en' => 'Exploring quantum frontiers, ethical AI systems, and decentralized green transitions for tomorrow.',
                'problem_statement_id' => 'Indonesia rentan hanya menjadi pasar konsumen pasif dalam gelombang revolusi kecerdasan buatan, energi baru terbarukan, dan bioteknologi tanpa kedaulatan riset terapan mandiri.',
                'problem_statement_en' => 'Indonesia risks becoming merely a passive consumer market in the AI, energy, and biotech revolutions without indigenous applied research foundations.',
                'solution_statement_id' => 'Menjalankan lab eksperimentasi terbuka dan riset terapan terdesentralisasi untuk menguji kelayakan teknologi generasi baru sebelum diadopsi di skala luas.',
                'solution_statement_en' => 'Operating open experimentation labs and decentralized applied research sandbox environments testing frontier breakthroughs for civic utility.',
                'short_description_id' => 'Lab riset terapan, komputasi cerdas, material maju, dan sandbox teknologi generasi depan.',
                'short_description_en' => 'Applied research lab, intelligent systems, advanced bio-materials, and frontier sandboxes.',
                'long_description_id' => 'Eksplorasi eksperimental untuk menjawab pertanyaan-pertanyaan strategis masa depan bangsa.',
                'long_description_en' => 'Experimental exploration addressing key strategic questions for the next decade of technology.',
                'hero_image' => 'https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=1200&q=80',
                'cover_image' => 'https://images.unsplash.com/photo-1507413245164-6160d8298b31?auto=format&fit=crop&w=1200&q=80',
                'icon' => 'bolt',
                'icon_image' => 'https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=400&q=80',
                'gallery' => [
                    'https://images.unsplash.com/photo-1507413245164-6160d8298b31?auto=format&fit=crop&w=800&q=80',
                ],
                'sdgs' => [
                    'SDG 9: Industri, Inovasi & Infrastruktur',
                ],
                'issues' => [
                    [
                        'issue' => 'Ketergantungan riset frontier pada lisensi tertutup dari luar negeri tanpa transfer pengetahuan lokal.',
                        'solution' => 'Open sandbox lab kolaboratif yang melibatkan akademisi dan praktisi industri nasional.',
                    ],
                ],
                'program_logos' => [],
                'status' => 'PLANNING',
                'visibility' => 'public',
                'sort_order' => 5,
                'is_featured' => false,
            ]
        );

        // -------------------------------------------------------------
        // 3. INITIATIVES / BRANDS (Under Domains)
        // -------------------------------------------------------------

        // INITIATIVE 1: YOIN Digital (Under Digital Domain)
        $yoinDigital = EcosystemInitiative::updateOrCreate(
            ['slug' => 'yoin-digital'],
            [
                'domain_id' => $domainDigital->id,
                'name' => 'YOIN Digital',
                'stage' => 'Inisiatif YOIN',
                'tagline_id' => 'Mitra rekayasa teknologi dan solusi perangkat lunak skala enterprise.',
                'tagline_en' => 'High-velocity digital engineering and enterprise software innovation partner.',
                'problem_statement_id' => 'Banyak pelaku usaha dan institusi kesulitan menemukan mitra teknologi yang memadukan pemikiran strategis bisnis dengan keahlian rekayasa kode yang tangguh, sehingga kerap menghasilkan sistem yang lambat, rentan bug, atau tidak diadopsi pengguna.',
                'problem_statement_en' => 'Enterprises and institutions struggle to find tech partners who bridge rigorous business strategy with robust code engineering, leading to stalled releases, brittle systems, and poor user adoption.',
                'mission_id' => 'Menyediakan layanan rekayasa perangkat lunak enterprise, konsultasi arsitektur awan, dan transformasi digital menyeluruh dengan standar performa dan keamanan tertinggi.',
                'mission_en' => 'Delivering mission-critical enterprise engineering, cloud architecture, and end-to-end digital transformation upholding the highest benchmarks of speed and security.',
                'story_id' => 'Dimulai sebagai studio rekayasa perangkat lunak mandiri, YOIN Digital kini menjadi tulang punggung teknologi di seluruh inisiatif YOIN dan melayani klien institusi terkemuka di Asia Tenggara.',
                'story_en' => 'Starting as an independent software craft studio, YOIN Digital has evolved into the technological backbone across YOIN initiatives and trusted advisor to premier institutions.',
                'focus_areas' => ['Pengembangan Web', 'Pengembangan Aplikasi', 'Infrastruktur Cloud & Server', 'Konsultasi IT & Digital', 'Audit Keamanan Siber'],
                'sdgs' => ['SDG 8: Pekerjaan Layak & Pertumbuhan Ekonomi', 'SDG 9: Industri, Inovasi, & Infrastruktur', 'SDG 17: Kemitraan untuk Mencapai Tujuan'],
                'government_issues' => ['Transformasi Digital Nasional', 'Kedaulatan Sistem Data & Siber', 'Peningkatan Daya Saing UMKM & Enterprise'],
                'locus' => 'Nasional & Asia Tenggara (Sentra Komputasi: Bandung, Jawa Barat)',
                'logo_image' => null,
                'cover_image' => 'https://images.unsplash.com/photo-1518770660439-4636190af475?q=80&w=1600&auto=format&fit=crop',
                'gallery' => [
                    'https://images.unsplash.com/photo-1504384308090-c894fdcc538d?q=80&w=800&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1531482615713-2afd69097998?q=80&w=800&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1522071820081-009f0129c71c?q=80&w=800&auto=format&fit=crop',
                ],
                'external_website_url' => 'https://yoindigital.com',
                'external_url_label' => 'Visit YOIN Digital →',
                'social_links' => [
                    'linkedin' => 'https://linkedin.com/company/yoindigital',
                    'github' => 'https://github.com/yoin-digital',
                    'instagram' => 'https://instagram.com/yoindigital',
                ],
                'contact_email' => 'tech@yoindigital.com',
                'status' => 'OPERATING',
                'visibility' => 'public',
                'sort_order' => 1,
                'is_featured' => true,
            ]
        );

        // INITIATIVE 2: AGRONEX (Under Agriculture Domain)
        $agronex = EcosystemInitiative::updateOrCreate(
            ['slug' => 'agronex'],
            [
                'domain_id' => $domainAgri->id,
                'name' => 'AGRONEX',
                'stage' => 'Inisiatif YOIN',
                'tagline_id' => 'Teknologi presisi dan kepastian rantai pasok untuk masa depan kedaulatan pangan.',
                'tagline_en' => 'Precision agriculture technology and verified food supply chains for sovereign cultivation.',
                'problem_statement_id' => 'Petani lokal kekurangan akses ke data agronomis mikro mengenai kelembapan tanah, cuaca riil, dan rekomendasi hara presisi, membuat hasil panen tidak konsisten dan boros input pupuk kimia hingga 40%.',
                'problem_statement_en' => 'Smallholders lack access to actionable soil telemetry and localized crop weather guidance, causing volatile yields and up to 40% unnecessary chemical fertilizer expenses.',
                'mission_id' => 'Mewujudkan pertanian presisi yang berkelanjutan dan menyejahterakan petani melalui penyediaan sensor IoT terjangkau, aplikasi rekomendasi budidaya cerdas, dan integrasi pasar langsung.',
                'mission_en' => 'Democratizing sustainable precision agriculture through low-cost IoT soil probes, smart cultivation advisory, and fair direct market channels.',
                'story_id' => 'Lahir dari keprihatinan atas krisis regenerasi petani dan mahalnya biaya pupuk, AGRONEX merancang perangkat IoT hemat energi yang dapat dioperasikan oleh petani dari berbagai latar belakang pendidikan.',
                'story_en' => 'Born from concerns over farmer demographic aging and spiraling input costs, AGRONEX designs low-power IoT telemetry easily used by farmers across diverse literacy levels.',
                'focus_areas' => ['Sensor Tanah & Mikroklimat', 'Otomasi Irigasi Pintar', 'Rantai Pasok Maritim & Pendingin', 'Pusat Komunitas Petani'],
                'sdgs' => ['SDG 2: Tanpa Kelaparan', 'SDG 8: Pertumbuhan Ekonomi & Pekerjaan Layak', 'SDG 12: Konsumsi & Produksi Bertanggung Jawab', 'SDG 13: Penanganan Perubahan Iklim'],
                'government_issues' => ['Swasembada Pangan Nasional', 'Modernisasi Alsintan & IoT Pertanian Presisi', 'Regenerasi Petani Milenial'],
                'locus' => 'Jawa Barat (Baleendah, Pangalengan, Garut, Subang) & Jawa Tengah',
                'logo_image' => null,
                'cover_image' => 'https://images.unsplash.com/photo-1586771107445-d3ca888129ff?q=80&w=1600&auto=format&fit=crop',
                'gallery' => [
                    'https://images.unsplash.com/photo-1500937386664-56d1dfef3854?q=80&w=800&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1625246333195-78d9c38ad449?q=80&w=800&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1574943320219-553eb213f72d?q=80&w=800&auto=format&fit=crop',
                ],
                'external_website_url' => 'https://agronex.id',
                'external_url_label' => 'Explore AGRONEX Ecosystem →',
                'social_links' => [
                    'instagram' => 'https://instagram.com/agronex.id',
                    'linkedin' => 'https://linkedin.com/company/agronex-id',
                ],
                'contact_email' => 'halo@agronex.id',
                'status' => 'OPERATING',
                'visibility' => 'public',
                'sort_order' => 2,
                'is_featured' => true,
            ]
        );

        // INITIATIVE 3: YAC (Under Impact Domain)
        $yac = EcosystemInitiative::updateOrCreate(
            ['slug' => 'yota-adiwidya-center'],
            [
                'domain_id' => $domainImpact->id,
                'name' => 'YAC (YOIN Adiwidya Center)',
                'stage' => 'Inisiatif YOIN',
                'tagline_id' => 'Pusat inkubasi talenta muda, riset sosial partisipatif, dan kepemimpinan nusantara.',
                'tagline_en' => 'Center for youth changemaker incubation, participatory social research, and civic leadership.',
                'problem_statement_id' => 'Mahasiswa dan pemuda di pelosok sulit mengakses pelatihan kepemimpinan dan inovasi sosial terstruktur yang kontekstual dengan tantangan sosio-kultural riil di daerah mereka.',
                'problem_statement_en' => 'Talented regional youth face systemic barriers accessing structured social innovation programs that resonate with their lived local socio-cultural contexts.',
                'mission_id' => 'Mencetak 10.000 katalis perubahan muda melalui program akademi inovasi desa, beasiswa riset kepemimpinan, dan jejaring laboratorium dampak berbasis akar rumput.',
                'mission_en' => 'Nurturing 10,000 grassroots youth catalysts through rural innovation academies, leadership research fellowships, and community-embedded impact laboratories.',
                'story_id' => 'Berawal dari gerakan kelas belajar mandiri, YAC kini mengorganisasi beasiswa, ekspedisi riset lapangan, dan kemitraan strategis dengan puluhan universitas nasional.',
                'story_en' => 'Originating as an open community study circle, YAC now organizes competitive fellowships, field research expeditions, and university alliances nationwide.',
                'focus_areas' => ['Pusat Belajar Komunitas', 'Restorasi Terumbu Karang', 'Audit Keberlanjutan & ESG', 'Permodalan Usaha Mikro Wanita'],
                'sdgs' => ['SDG 4: Pendidikan Berkualitas', 'SDG 10: Berkurangnya Kesenjangan', 'SDG 17: Kemitraan untuk Mencapai Tujuan'],
                'government_issues' => ['Pemberdayaan Pemuda & Pendidikan Vokasi', 'Inovasi Desa & Daerah 3T', 'Akselerasi Kepemimpinan Transformatif'],
                'locus' => 'Jawa Barat, Banten, Nusa Tenggara Timur, dan Sentra Komunitas Desa',
                'logo_image' => null,
                'cover_image' => 'https://images.unsplash.com/photo-1529156069898-49953e39b3ac?q=80&w=1600&auto=format&fit=crop',
                'gallery' => [
                    'https://images.unsplash.com/photo-1517486808906-6ca8b3f04846?q=80&w=800&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1531545514256-b1400bc00f31?q=80&w=800&auto=format&fit=crop',
                ],
                'external_website_url' => 'https://adiwidya.yoin.id',
                'external_url_label' => 'Visit Adiwidya Center →',
                'social_links' => [
                    'instagram' => 'https://instagram.com/yoin.adiwidya',
                    'linkedin' => 'https://linkedin.com/company/adiwidya-center',
                ],
                'contact_email' => 'center@yoin.id',
                'status' => 'OPERATING',
                'visibility' => 'public',
                'sort_order' => 3,
                'is_featured' => true,
            ]
        );

        // INITIATIVE 4: YOIMO (Under Products Domain)
        $yoimo = EcosystemInitiative::updateOrCreate(
            ['slug' => 'yoimo'],
            [
                'domain_id' => $domainProducts->id,
                'name' => 'YOIMO',
                'stage' => 'Inisiatif YOIN',
                'tagline_id' => 'Pangan fungsional dan gaya hidup bernutrisi dari keanekaragaman umbi nusantara.',
                'tagline_en' => 'Functional nutrition and mindful snacks sourced from indigenous Indonesian roots and tubers.',
                'problem_statement_id' => 'Tingginya ketergantungan konsumsi gandum impor dan camilan manis ultra-proses yang memicu lonjakan penyakit metabolik dini pada generasi muda perkotaan.',
                'problem_statement_en' => 'Heavy national reliance on imported wheat and ultra-processed snacks fuels surging metabolic lifestyle diseases among urban youth.',
                'mission_id' => 'Mengolah komoditas ubi jalar, singkong, dan porang pilihan petani lokal menjadi makanan ringan fungsional bebas gluten dengan standar gizi seimbang.',
                'mission_en' => 'Processing ethically sourced native sweet potatoes, cassava, and konjac into premium gluten-free functional snacks and healthy everyday alternatives.',
                'story_id' => 'YOIMO memadukan riset formulasi pangan modern dengan kearifan rasa nusantara untuk membuktikan bahwa makanan sehat bisa nikmat dan terjangkau.',
                'story_en' => 'YOIMO blends modern food science formulation with authentic Indonesian flavor heritage to prove healthy snacking can be delicious and accessible.',
                'focus_areas' => ['Perabot Rumah Berkelanjutan', 'Kemasan Sirkular Alami', 'Kriya Keramik & Dekorasi', 'Riset Material Sirkular Baru'],
                'sdgs' => ['SDG 3: Kehidupan Sehat & Sejahtera', 'SDG 12: Konsumsi & Produksi Bertanggung Jawab'],
                'government_issues' => ['Penganekaragaman Pangan Lokal (Non-Beras/Gandum)', 'Penurunan Stunting & Penyakit Degeneratif', 'Hilirisasi Komoditas Umbi Nusantara'],
                'locus' => 'Sentra Petani Ubi & Porang Jawa Barat & DIY Yogyakarta',
                'logo_image' => null,
                'cover_image' => 'https://images.unsplash.com/photo-1540420773420-3366772f4999?q=80&w=1600&auto=format&fit=crop',
                'gallery' => [
                    'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?q=80&w=800&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1498837167922-ddd27525d352?q=80&w=800&auto=format&fit=crop',
                ],
                'external_website_url' => 'https://yoimo.id',
                'external_url_label' => 'Discover YOIMO Products →',
                'social_links' => [
                    'instagram' => 'https://instagram.com/yoimo.official',
                ],
                'contact_email' => 'halo@yoimo.id',
                'status' => 'BUILDING',
                'visibility' => 'public',
                'sort_order' => 4,
                'is_featured' => false,
            ]
        );

        // INITIATIVE 5: BUATARA (Under Emerging / Future Initiatives Domain)
        $buatara = EcosystemInitiative::updateOrCreate(
            ['slug' => 'buatara'],
            [
                'domain_id' => $domainEmerging->id,
                'name' => 'BUATARA',
                'stage' => 'Ekosistem YOIN',
                'tagline_id' => 'Desain industrial modern yang menghidupkan kembali material bambu dan kayu berkelanjutan nusantara.',
                'tagline_en' => 'Contemporary industrial design elevating Indonesian sustainable bamboo and circular timber.',
                'problem_statement_id' => 'Minimnya nilai tambah produk kriya lokal akibat desain yang monoton dan kalah pamor dibandingkan furnitur plastik atau laminasi sintetis berumur pendek.',
                'problem_statement_en' => 'Traditional Indonesian bamboo crafts suffer from low value addition, repetitive designs, and losing ground to short-lived plastic or synthetic laminate goods.',
                'mission_id' => 'Menghadirkan perabot dan perlengkapan ruang kerja bergaya minimalis fungsional dengan material bambu laminasi dan kayu bersertifikasi lestari.',
                'mission_en' => 'Crafting timeless ergonomic workspace and living essentials engineered from engineered bamboo and certified sustainable forestry.',
                'story_id' => 'BUATARA berkolaborasi dengan pengrajin desa di Kulon Progo untuk menerapkan teknik presisi pertukangan modern dengan material bambu lestari.',
                'story_en' => 'BUATARA partners with artisan clusters in Kulon Progo to merge precision joinery engineering with sustainable native bamboo.',
                'focus_areas' => ['Solar Microgrid Mandiri', 'Mobilitas Cerdas IKN', 'Deep-Tech Sandbox Lab', 'Sinergi Modal & Co-Funding'],
                'sdgs' => ['SDG 8: Pertumbuhan Ekonomi & Pekerjaan Layak', 'SDG 12: Konsumsi & Produksi Bertanggung Jawab', 'SDG 15: Ekosistem Daratan & Kehutanan Berkelanjutan'],
                'government_issues' => ['Gerakan Nasional Bangga Buatan Indonesia (BBI)', 'Hilirisasi Industri Kreatif Hijau', 'Pemberdayaan Pengrajin Lokal'],
                'locus' => 'Sentra Pengrajin Material Alami Nusantara (Jawa Barat & DI Yogyakarta)',
                'logo_image' => null,
                'cover_image' => 'https://images.unsplash.com/photo-1506703719100-a0f3a48c0f86?q=80&w=1600&auto=format&fit=crop',
                'gallery' => [
                    'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?q=80&w=800&auto=format&fit=crop',
                    'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?q=80&w=800&auto=format&fit=crop',
                ],
                'external_website_url' => 'https://buatara.com',
                'external_url_label' => 'Browse BUATARA Collections →',
                'social_links' => [
                    'instagram' => 'https://instagram.com/buatara.id',
                ],
                'contact_email' => 'studio@buatara.com',
                'status' => 'BUILDING',
                'visibility' => 'public',
                'sort_order' => 5,
                'is_featured' => false,
            ]
        );

        // -------------------------------------------------------------
        // 4. PRODUCTS / MOVEMENTS (Under Initiatives)
        // -------------------------------------------------------------

        // Product 1: YOIN Enterprise Suite (Under YOIN Digital)
        $prodYoinSuite = EcosystemProduct::updateOrCreate(
            ['slug' => 'yoin-enterprise-suite'],
            [
                'initiative_id' => $yoinDigital->id,
                'name' => 'YOIN Enterprise Suite',
                'type' => 'product',
                'problem_statement_id' => 'Perusahaan menengah ke atas sering terjebak dalam integrasi antar-aplikasi yang terpisah-pisah, lambat, dan memakan biaya lisensi berulang sangat besar.',
                'problem_statement_en' => 'Growing enterprises suffer from disparate, siloed legacy software incurring exorbitant license renewals with poor interoperability.',
                'solution_statement_id' => 'Rangkaian modul perangkat lunak enterprise berbasis arsitektur modular yang dapat disesuaikan 100% dengan alur otorisasi internal klien.',
                'solution_statement_en' => 'A unified modular software suite tailored 100% to client operational authorization workflows without per-seat licensing lock-in.',
                'description_id' => 'Platform enterprise modular untuk manajemen aset, intelijen operasional, dan otomatisasi alur kerja korporat.',
                'description_en' => 'Modular enterprise software platform for asset monitoring, operational intelligence, and automated corporate workflows.',
                'website_url' => 'https://yoindigital.com/suite',
                'status' => 'OPERATING',
                'visibility' => 'public',
                'sort_order' => 1,
                'is_featured' => true,
            ]
        );

        // Product 2: AGRONEX Telemetry & Advisory (Under AGRONEX)
        $prodAgroSense = EcosystemProduct::updateOrCreate(
            ['slug' => 'agronex-telemetry-advisory'],
            [
                'initiative_id' => $agronex->id,
                'name' => 'AGRONEX Telemetry & Advisory Platform',
                'type' => 'platform',
                'problem_statement_id' => 'Ketiadaan panduan presisi berbasis kondisi riil tanah menyebabkan pemupukan dilakukan berlebihan atau tidak tepat waktu, merusak keseimbangan unsur hara mikro tanah.',
                'problem_statement_en' => 'Absence of real-time soil telemetry causes arbitrary over-fertilization, degrading essential micronutrient balances over time.',
                'solution_statement_id' => 'Sistem pemantauan sensor multi-kedalaman yang dikombinasikan dengan kecerdasan kalender agronomis melalui notifikasi pesan instan untuk petani.',
                'solution_statement_en' => 'Multi-depth soil probe telemetry combined with algorithmic agronomic calendar guidance delivered straight to farmers via instant messaging.',
                'description_id' => 'Hardware IoT sensor tanah dan portal cerdas pendampingan budidaya bagi kelompok tani hortikultura.',
                'description_en' => 'Hardware IoT soil sensor network paired with an intelligent crop advisory portal for horticultural farming cooperatives.',
                'website_url' => 'https://agronex.id/platform',
                'status' => 'OPERATING',
                'visibility' => 'public',
                'sort_order' => 1,
                'is_featured' => true,
            ]
        );

        // Product 3: Nusantara Youth Fellowship (Under YAC)
        $prodFellowship = EcosystemProduct::updateOrCreate(
            ['slug' => 'nusantara-youth-fellowship'],
            [
                'initiative_id' => $yac->id,
                'name' => 'Nusantara Youth Innovation Fellowship',
                'type' => 'program',
                'problem_statement_id' => 'Pemuda daerah minim panggung dan tidak memperoleh pendanaan bibit untuk mewujudkan inisiatif sosial yang relevan di komunitas asalnya.',
                'problem_statement_en' => 'Grassroots youth lack institutional validation and catalytic seed grants to implement context-relevant community social initiatives.',
                'solution_statement_id' => 'Program fellowship intensif 6 bulan yang menyediakan hibah bibit dampak, pendampingan mentor senior, dan pameran karya nasional.',
                'solution_statement_en' => 'A competitive 6-month fellowship providing seed grants, dedicated senior mentors, and a national civic innovation showcase.',
                'description_id' => 'Inkubasi dan hibah proyek inovasi sosial pemuda di pelosok nusantara.',
                'description_en' => 'Incubation and seed grant program for grassroots youth social innovators across Indonesia.',
                'website_url' => 'https://adiwidya.yoin.id/fellowship',
                'status' => 'OPERATING',
                'visibility' => 'public',
                'sort_order' => 1,
                'is_featured' => true,
            ]
        );

        // Product 4: YOIMO NutriRoots (Under YOIMO)
        $prodYoimo = EcosystemProduct::updateOrCreate(
            ['slug' => 'yoimo-nutriroots'],
            [
                'initiative_id' => $yoimo->id,
                'name' => 'YOIMO NutriRoots & Healthy Flours',
                'type' => 'product',
                'problem_statement_id' => 'Ketergantungan tinggi pada impor gandum dan bahan pangan olahan berkadar gula tinggi yang mengancam kesehatan metabolik.',
                'problem_statement_en' => 'Excessive reliance on imported wheat and ultra-processed high-glycemic flours threatening long-term public health.',
                'solution_statement_id' => 'Pemanfaatan umbi lokal nusantara (ubi jalar, singkong, porang) menjadi tepung sehat bebas gluten dan makanan ringan bernutrisi tinggi.',
                'solution_statement_en' => 'Processing local indigenous roots and tubers into nutrient-dense, gluten-free pantry essentials and functional superfoods.',
                'description_id' => 'Lini produk pangan fungsional bebas gluten dan tepung olahan umbi lokal nusantara.',
                'description_en' => 'Gluten-free functional food line and nutrient-rich pantry essentials from indigenous tubers.',
                'website_url' => 'https://yoimo.id',
                'status' => 'BUILDING',
                'visibility' => 'public',
                'sort_order' => 1,
                'is_featured' => true,
            ]
        );

        // Product 5: BUATARA Bamboo Workspaces (Under BUATARA)
        $prodBuatara = EcosystemProduct::updateOrCreate(
            ['slug' => 'buatara-bamboo-workspaces'],
            [
                'initiative_id' => $buatara->id,
                'name' => 'BUATARA Ergonomic Bamboo Workspaces',
                'type' => 'product',
                'problem_statement_id' => 'Dominasi perabot sintetis dan plastik sekali pakai yang minim nilai estetika budaya lokal dan merusak lingkungan.',
                'problem_statement_en' => 'Market prevalence of synthetic plastic furnishings that neglect authentic cultural craftsmanship and harm the planet.',
                'solution_statement_id' => 'Perancangan furnitur kerja minimalis berpresisi tinggi menggunakan bambu laminasi terbarukan dan kayu bersertifikasi lestari.',
                'solution_statement_en' => 'Precision minimalist ergonomic workspace furniture crafted from renewable engineered bamboo and certified sustainable timber.',
                'description_id' => 'Koleksi perabot kerja ergonomis berbasis material bambu laminasi dan kayu lestari nusantara.',
                'description_en' => 'Ergonomic workspace furniture crafted with precision from engineered bamboo and circular timber.',
                'website_url' => 'https://buatara.com',
                'status' => 'BUILDING',
                'visibility' => 'public',
                'sort_order' => 1,
                'is_featured' => true,
            ]
        );

        // -------------------------------------------------------------
        // 5. CATEGORIES & TYPES
        // -------------------------------------------------------------

        // Categories under YOIN Enterprise Suite
        $catWebEnterprise = EcosystemCategory::updateOrCreate(
            ['slug' => 'web-enterprise-systems', 'product_id' => $prodYoinSuite->id],
            [
                'name_id' => 'Sistem Web Enterprise',
                'name_en' => 'Enterprise Web Systems',
                'description_id' => 'Aplikasi web skala besar dengan keamanan dan konkurensi tinggi.',
                'description_en' => 'High-concurrency, security-hardened enterprise web applications.',
                'sort_order' => 1,
            ]
        );

        $catCloudData = EcosystemCategory::updateOrCreate(
            ['slug' => 'cloud-data-architecture', 'product_id' => $prodYoinSuite->id],
            [
                'name_id' => 'Arsitektur Komputasi & Data Awan',
                'name_en' => 'Cloud & Data Architecture',
                'description_id' => 'Desain infrastruktur cloud, pipeline data besar, dan analitik real-time.',
                'description_en' => 'Cloud infrastructure design, big data pipelines, and real-time analytics.',
                'sort_order' => 2,
            ]
        );

        // Types under Web Enterprise Systems
        $typeDashboard = EcosystemType::updateOrCreate(
            ['slug' => 'executive-intelligence-portal', 'category_id' => $catWebEnterprise->id],
            [
                'name_id' => 'Portal Intelijen Eksekutif & Dasbor',
                'name_en' => 'Executive Intelligence & Dashboard Portal',
                'description_id' => 'Dasbor analitik visual performa bisnis untuk jajaran pengambil keputusan.',
                'description_en' => 'Visual business performance analytics dashboards for executive decision makers.',
                'sort_order' => 1,
            ]
        );

        $typeERP = EcosystemType::updateOrCreate(
            ['slug' => 'custom-operational-erp', 'category_id' => $catWebEnterprise->id],
            [
                'name_id' => 'Sistem Operasional & ERP Kustom',
                'name_en' => 'Custom Operational & ERP Systems',
                'description_id' => 'Perangkat lunak alur kerja rantai pasok dan inventaris terintegrasi.',
                'description_en' => 'Integrated inventory and supply chain enterprise workflow software.',
                'sort_order' => 2,
            ]
        );

        // Categories under AGRONEX Platform
        $catHardware = EcosystemCategory::updateOrCreate(
            ['slug' => 'smart-hardware-iot', 'product_id' => $prodAgroSense->id],
            [
                'name_id' => 'Perangkat Cerdas & Sensor IoT',
                'name_en' => 'Smart Hardware & IoT Sensors',
                'description_id' => 'Sensor lapangan berdaya tahan tinggi dengan transmisi nirkabel LoRaWAN dan seluler.',
                'description_en' => 'Durable field sensors with LoRaWAN and cellular telemetry transmission.',
                'sort_order' => 1,
            ]
        );

        $typeIrrigation = EcosystemType::updateOrCreate(
            ['slug' => 'automated-precision-irrigation', 'category_id' => $catHardware->id],
            [
                'name_id' => 'Irigasi Presisi Terotomasi',
                'name_en' => 'Automated Precision Irrigation',
                'description_id' => 'Kontrol pengairan otomatis berbasis nilai ambang kelembapan tanah.',
                'description_en' => 'Automated watering controls triggered by live soil moisture thresholds.',
                'sort_order' => 1,
            ]
        );

        // -------------------------------------------------------------
        // 6. PROJECTS / PORTFOLIO
        // -------------------------------------------------------------

        // Project 1: Danantara Intelligence Portal
        EcosystemProject::updateOrCreate(
            ['slug' => 'danantara-intelligence-portal'],
            [
                'initiative_id' => $yoinDigital->id,
                'category_id' => $catWebEnterprise->id,
                'type_id' => $typeDashboard->id,
                'client_id' => $clientDanantara->id,
                'name' => 'Danantara Strategic Asset Intelligence Portal',
                'problem_statement_id' => 'Ketiadaan visibilitas data terkonsolidasi antar-anak perusahaan menyebabkan proses audit portofolio investasi memakan waktu hingga 3 minggu dengan potensi selisih rekonsiliasi manual yang signifikan.',
                'problem_statement_en' => 'Fragmented cross-subsidiary reporting created extreme data lag, stretching portfolio audits to over 3 weeks with high exposure to manual reconciliation discrepancy.',
                'solution_statement_id' => 'Membangun arsitektur portal terpusat dengan integrasi API aman ke sistem perbankan dan ERP anak usaha, dilengkapi modul analisis tren otomatis dan dasbor eksekutif real-time.',
                'solution_statement_en' => 'Engineered a centralized data portal featuring secured API connectors to banking and subsidiary ERP layers, complete with predictive trends and live executive dashboards.',
                'purpose_id' => 'Memberikan kepastian data dan efisiensi pelaporan aset strategis secara transparan untuk jajaran komisaris dan direksi.',
                'purpose_en' => 'To empower board executives with verified real-time asset intelligence and seamless regulatory compliance.',
                'result_outcome_id' => 'Waktu siklus pelaporan berkurang 78% (dari 21 hari menjadi 4 hari kerja), dengan akurasi rekonsiliasi audit mencapai 99.98% di 12 anak perusahaan.',
                'result_outcome_en' => 'Reporting cycle shortened by 78% (from 21 days to 4 working days), with 99.98% reconciliation precision across 12 operational subsidiaries.',
                'description_id' => 'Portal intelijen portofolio investasi korporat dengan dasbor visual analitik interaktif dan otorisasi bertingkat.',
                'description_en' => 'Corporate asset intelligence portal with high-concurrency visual interactive dashboards and multi-tenant permissioning.',
                'story_id' => 'Proyek ini diselesaikan dalam waktu 16 pekan oleh tim rekayasa YOIN Digital dengan zero-downtime saat migrasi data dari sistem lama.',
                'story_en' => 'Delivered in 16 intensive sprints by YOIN Digital engineers, maintaining zero downtime throughout legacy migration.',
                'services_provided' => ['System Architecture Design', 'Frontend Engineering', 'RESTful API Integration', 'Data Security Hardening'],
                'technologies' => ['Laravel 12', 'Tailwind CSS', 'Alpine.js', 'PostgreSQL', 'Redis', 'Docker'],
                'external_url' => 'https://danantara.id',
                'launch_date' => '2025-11-15',
                'status' => 'COMPLETED',
                'visibility' => 'public',
                'sort_order' => 1,
                'is_featured' => true,
            ]
        );

        // Project 2: Sleman Precision Irrigation (AGRONEX)
        EcosystemProject::updateOrCreate(
            ['slug' => 'irigasi-cerdas-merapi-hortikultura'],
            [
                'initiative_id' => $agronex->id,
                'category_id' => $catHardware->id,
                'type_id' => $typeIrrigation->id,
                'client_id' => $clientAgro->id,
                'name' => 'Sistem Irigasi Presisi Cerdas Lahan Hortikultura Merapi',
                'problem_statement_id' => 'Petani hortikultura di lereng Merapi sering mengalami gagal panen cabai akibat kekurangan air di musim kemarau dan pembusukan akar saat curah hujan tinggi yang tak terpantau dengan baik.',
                'problem_statement_en' => 'Chili and tomato farmers on Mount Merapi foothills suffered recurrent losses due to seasonal drought water stress coupled with undetected root rot in high-humidity spells.',
                'solution_statement_id' => 'Memasang 28 simpul sensor kelembapan tanah multi-level bertenaga surya yang terhubung dengan katup irigasi tetes pintar terotomasi berbasis ambang evapotranspirasi tanah.',
                'solution_statement_en' => 'Deployed 28 solar-powered multi-strata soil probe nodes regulating automated smart drip solenoids based on real-time evapotranspiration modeling.',
                'purpose_id' => 'Memastikan tanaman hortikultura selalu menerima air dan nutrisi dalam takaran optimal tanpa membebani jadwal tenaga kerja petani.',
                'purpose_en' => 'To sustain optimal root moisture and nutrient uptake while drastically cutting manual farm labor hours.',
                'result_outcome_id' => 'Penghematan pemakaian air irigasi hingga 44%, peningkatan bobot panen cabai berkualitas grade-A sebesar 31%, dan peningkatan laba bersih petani sebesar 38%.',
                'result_outcome_en' => 'Saved 44% irrigation water consumption, increased Grade-A harvest volume by 31%, and elevated average net farmer profits by 38%.',
                'description_id' => 'Implementasi sistem sensor tanah presisi dan otomasi katup irigasi bertenaga surya di 35 hektar lahan hortikultura kelompok tani Sleman.',
                'description_en' => 'Precision soil telemetry and automated solar drip irrigation implementation across 35 hectares of horticultural plots in Sleman.',
                'story_id' => 'Program ini dikerjakan melalui kolaborasi erat dengan kelompok tani dan mahasiswa KKN tematik pertanian berkelanjutan.',
                'story_en' => 'Co-designed and installed side-by-side with local farmer elders and university agricultural researchers.',
                'services_provided' => ['IoT Firmware Development', 'Sensor Calibration', 'Solar Power Rig Design', 'Farmer Digital Training'],
                'technologies' => ['ESP32 Telemetry', 'MQTT Protocol', 'LoRaWAN', 'Python Micro-Analytics', 'Laravel Backend'],
                'external_url' => 'https://agronex.id/cases/merapi',
                'launch_date' => '2026-02-10',
                'status' => 'COMPLETED',
                'visibility' => 'public',
                'sort_order' => 2,
                'is_featured' => true,
            ]
        );

        // Project 3: Satu Data Koperasi (YOIN Digital x Kemenkop)
        EcosystemProject::updateOrCreate(
            ['slug' => 'kemenkop-satu-data-koperasi'],
            [
                'initiative_id' => $yoinDigital->id,
                'category_id' => $catWebEnterprise->id,
                'type_id' => $typeERP->id,
                'client_id' => $clientKemenkop->id,
                'name' => 'Platform Integrasi Satu Data Koperasi Nasional',
                'problem_statement_id' => 'Lebih dari 120.000 koperasi di Indonesia memiliki format pembukuan yang berbeda-beda, menyulitkan pemerintah memetakan kesehatan finansial koperasi secara riil dan menyalurkan program stimulus yang tepat sasaran.',
                'problem_statement_en' => 'Over 120,000 national cooperatives maintained non-standardized accounting formats, blinding policymaker visibility into true balance sheet health and misdirecting financial stimulus.',
                'solution_statement_id' => 'Mengembangkan standar interoperabilitas data koperasi berbasis XBRL ringan dengan antarmuka web yang sederhana bagi pengurus koperasi di berbagai pelosok daerah.',
                'solution_statement_en' => 'Engineered a lightweight XBRL-compliant data exchange protocol with intuitive web interfaces accessible to grassroots cooperative clerks on standard mobile browsers.',
                'purpose_id' => 'Mewujudkan transparansi kesehatan finansial gerakan koperasi nasional dan memudahkan penyaluran program pemberdayaan UMKM.',
                'purpose_en' => 'To champion financial governance transparency and streamline targeted economic relief for micro-producers nationwide.',
                'result_outcome_id' => 'Terkoneksi dengan 14.200 koperasi aktif dalam 6 bulan pertama, mempercepat verifikasi status kelayakan pinjaman modal bergulir dari 45 hari menjadi 3 hari.',
                'result_outcome_en' => 'Onboarded 14,200 active cooperatives within 6 months, reducing working-capital loan eligibility verification from 45 days down to 3 days.',
                'description_id' => 'Sistem agregasi data kepatuhan dan kesehatan finansial koperasi nasional berbasis cloud terenkripsi.',
                'description_en' => 'Cloud-native compliance and solvency scoring infrastructure for national cooperative registries.',
                'story_id' => 'Arsitektur sistem dirancang dengan ketahanan tinggi terhadap koneksi internet lambat di daerah kepulauan terpencil.',
                'story_en' => 'Designed with offline-first caching and high fault tolerance for unreliable island connectivity.',
                'services_provided' => ['Regulatory System Architecture', 'Secure Data Schema Modeling', 'High-Load Cloud Tuning'],
                'technologies' => ['Laravel', 'MySQL Enterprise', 'Tailwind CSS', 'Alpine.js', 'Redis Queue'],
                'external_url' => 'https://kemenkopukm.go.id',
                'launch_date' => '2025-08-20',
                'status' => 'COMPLETED',
                'visibility' => 'public',
                'sort_order' => 3,
                'is_featured' => true,
            ]
        );

        // -------------------------------------------------------------
        // 8. ANGKA STATISTIK DAMPAK (CONTROLLED VIA ADMIN)
        // -------------------------------------------------------------
        $metrics = [
            [
                'metric_value' => '50.000+',
                'label_id' => 'Pemuda & Komunitas Terdampak',
                'label_en' => 'Impacted Youth & Communities',
                'description_id' => 'Warga, pemuda, dan kelompok rentan yang terlayani melalui program aksi terpadu.',
                'description_en' => 'Citizens, youth, and vulnerable communities served across grassroots programs.',
                'icon' => 'users',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'metric_value' => '9',
                'label_id' => 'Pilar Gerakan Terpadu',
                'label_en' => 'Integrated Impact Pillars',
                'description_id' => 'Spektrum intervensi holistik yang diorkestrasikan bersama jejaring SIYOTA.',
                'description_en' => 'Holistic intervention spectrum orchestrated together with the SIYOTA network.',
                'icon' => 'shield-check',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'metric_value' => '34',
                'label_id' => 'Provinsi Jangkauan Aksi',
                'label_en' => 'Provinces Nationwide Reach',
                'description_id' => 'Jejaring kolaborasi masyarakat dan inisiatif lapangan dari barat hingga timur nusantara.',
                'description_en' => 'Collaborative community and field initiative network spanning from west to east.',
                'icon' => 'globe-alt',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'metric_value' => '100%',
                'label_id' => 'Surplus Untuk Kemanusiaan',
                'label_en' => 'Operating Surplus For Impact',
                'description_id' => 'Seluruh profit komersial rekayasa teknologi dialokasikan kembali untuk misi filantropi.',
                'description_en' => 'All commercial enterprise profit redirected back into sustainable social impact.',
                'icon' => 'sparkles',
                'sort_order' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($metrics as $m) {
            EcosystemImpactMetric::updateOrCreate(['label_id' => $m['label_id']], $m);
        }

        // -------------------------------------------------------------
        // 9. 9 PILAR DAMPAK BERKELANJUTAN (SIYOTA.ORG)
        // -------------------------------------------------------------
        $pillars = [
            [
                'pillar_number' => 1,
                'code' => 'youth-development',
                'name' => 'YOUTH DEVELOPMENT',
                'title_id' => 'Pengembangan Pemuda & Kepemimpinan Masa Depan',
                'title_en' => 'Youth Development & Future Leadership',
                'description_id' => 'Membangun kapasitas kepemimpinan etis, karakter tangguh, dan kesiapan wirausaha muda di seluruh pelosok nusantara.',
                'description_en' => 'Cultivating ethical leadership, character resilience, and entrepreneurial readiness among Indonesian youth.',
                'why_it_matters_id' => 'Lebih dari 65 juta pemuda di Indonesia menghadapi momentum bonus demografi namun kerap terhambat minimnya akses mentoring kepemimpinan, kesenjangan soft-skills, dan keterbatasan jejaring strategis di daerah pelosok.',
                'why_it_matters_en' => 'Over 65 million Indonesian youth navigate a historic demographic bonus, yet many lack access to ethical leadership coaching, critical soft skills, and strategic networks.',
                'what_we_do_id' => 'Menyelenggarakan inkubasi kepemimpinan berkesinambungan, pelatihan inovasi sosial lapangan, pendampingan wirausaha muda akar rumput, dan jejaring fellowship perintis kepemudaan antarprovinsi.',
                'what_we_do_en' => 'Conducting ongoing leadership incubations, grassroots social innovation fellowships, youth enterprise mentorship, and cross-provincial changemaker cohorts.',
                'sdgs' => [
                    'SDG 4: Pendidikan Berkualitas',
                    'SDG 8: Pekerjaan Layak & Pertumbuhan Ekonomi',
                    'SDG 10: Berkurangnya Kesenjangan',
                    'SDG 17: Kemitraan untuk Mencapai Tujuan',
                ],
                'global_programs' => [
                    'UN Youth 2030 Strategy',
                    'UNESCO Global Youth Community',
                    'ASEAN Youth Development Index Framework',
                ],
                'national_programs' => [
                    'Asta Cita: Pembangunan SDM Unggul & Sains',
                    'RPJMN 2025-2029: Peningkatan Kapasitas Kepemudaan',
                    'Visi Indonesia Emas 2045: Generasi Berdaya Saing Global',
                ],
                'target_beneficiaries' => 'Pemuda usia 16-30 tahun, aktivis mahasiswa, perintis komunitas lokal, dan wirausaha muda daerah.',
                'youtube_url' => 'https://www.youtube.com/watch?v=f7_S05eN39I',
                'photo_image' => 'https://images.unsplash.com/photo-1529156069898-49953e39b3ac?auto=format&fit=crop&w=800&q=80',
                'gallery' => [
                    'https://images.unsplash.com/photo-1529156069898-49953e39b3ac?auto=format&fit=crop&w=800&q=80',
                    'https://images.unsplash.com/photo-1517048676732-d65bc937f952?auto=format&fit=crop&w=800&q=80',
                    'https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&w=800&q=80',
                ],
                'metric_value' => '18.500+',
                'metric_label_id' => 'Pemuda Diberdayakan',
                'metric_label_en' => 'Youth Empowered',
                'target_url' => 'https://siyota.org',
                'action_label' => 'Lihat Aksi di siyota.org →',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'pillar_number' => 2,
                'code' => 'desa-rural',
                'name' => 'DESA RURAL',
                'title_id' => 'Pemberdayaan Desa & Kawasan Pedesaan Tertinggal',
                'title_en' => 'Rural Village & Frontier Development',
                'description_id' => 'Mendorong kemandirian ekonomi desa, penguatan BUMDes inovatif, dan tata kelola berbasis kearifan lokal berdaulat.',
                'description_en' => 'Fostering village economic self-reliance, innovative rural enterprises, and community-driven governance.',
                'why_it_matters_id' => 'Ketimpangan ekonomi desa-kota masih lebar. Lebih dari 74.000 desa di Indonesia kerap hanya menjadi penonton eksploitasi hasil bumi tanpa nilai tambah ekonomi dan kemandirian kelembagaan lokal.',
                'why_it_matters_en' => 'Rural-urban economic disparities remain significant. Over 74,000 villages across Indonesia often supply raw commodities without retaining local value addition or robust institutional governance.',
                'what_we_do_id' => 'Pendampingan tata kelola dan digitalisasi BUMDes, hilirisasi komoditas unggulan desa, pelatihan digital talent desa, serta inkubasi desa berdikari berbasis kearifan lokal.',
                'what_we_do_en' => 'Mentoring village enterprise (BUMDes) governance and digitization, local commodity downstreaming, rural digital talent acceleration, and community self-reliance incubations.',
                'sdgs' => [
                    'SDG 1: Tanpa Kemiskinan',
                    'SDG 8: Pekerjaan Layak & Pertumbuhan Ekonomi',
                    'SDG 9: Industri, Inovasi & Infrastruktur',
                    'SDG 11: Kota & Komunitas Berkelanjutan',
                ],
                'global_programs' => [
                    'OECD Rural Development Strategy',
                    'UN Decade of Family Farming',
                ],
                'national_programs' => [
                    'Asta Cita: Membangun dari Desa untuk Pemerataan',
                    'Program Desa Mandiri Kemendesa PDTT',
                    'Inpres Percepatan Penghapusan Kemiskinan Ekstrem',
                ],
                'target_beneficiaries' => 'Masyarakat pedesaan, pengelola BUMDes, aparatur desa, dan kelompok perintis desa mandiri.',
                'youtube_url' => 'https://www.youtube.com/watch?v=tgbNymZ7vqY',
                'photo_image' => 'https://images.unsplash.com/photo-1596405835955-385052009f0e?auto=format&fit=crop&w=800&q=80',
                'gallery' => [
                    'https://images.unsplash.com/photo-1596405835955-385052009f0e?auto=format&fit=crop&w=800&q=80',
                    'https://images.unsplash.com/photo-1500382017468-9049fed747ef?auto=format&fit=crop&w=800&q=80',
                    'https://images.unsplash.com/photo-1470246973918-29a93221c455?auto=format&fit=crop&w=800&q=80',
                ],
                'metric_value' => '48+ Desa',
                'metric_label_id' => 'Kawasan Binaan Mandiri',
                'metric_label_en' => 'Self-reliant Villages',
                'target_url' => 'https://siyota.org',
                'action_label' => 'Lihat Aksi di siyota.org →',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'pillar_number' => 3,
                'code' => 'agriculture-food',
                'name' => 'AGRICULTURE & FOOD',
                'title_id' => 'Pertanian Berkelanjutan & Kedaulatan Pangan',
                'title_en' => 'Sustainable Agriculture & Food Sovereignty',
                'description_id' => 'Mendampingi regenerasi petani muda, konservasi benih lokal, dan stabilisasi rantai pasok pangan mandiri.',
                'description_en' => 'Supporting next-generation farmers, indigenous seed preservation, and community-level food sovereignty.',
                'why_it_matters_id' => 'Krisis regenerasi petani nasional sangat genting dengan lebih dari 70% petani berusia di atas 45 tahun, disertai ancaman degradasi tanah akibat pupuk kimia sintetik dan volatilitas harga pasok pangan.',
                'why_it_matters_en' => 'An acute farmer aging crisis where over 70% of growers are above 45 years old, exacerbated by synthetic fertilizer land degradation and extreme supply chain volatility.',
                'what_we_do_id' => 'Inkubasi petani milenial muda, pengembangan demoplot pertanian regeneratif organik, pelestarian bank benih pusaka nusantara, serta pemotongan rantai pasok pangan dari ladang ke konsumen.',
                'what_we_do_en' => 'Incubating next-gen farmers, developing regenerative organic demoplots, preserving heirloom seed banks, and shortening farm-to-table food distribution chains.',
                'sdgs' => [
                    'SDG 2: Tanpa Kelaparan',
                    'SDG 12: Konsumsi & Produksi Bertanggung Jawab',
                    'SDG 13: Penanganan Perubahan Iklim',
                    'SDG 15: Ekosistem Daratan',
                ],
                'global_programs' => [
                    'UN Food Systems Summit Action Tracks',
                    'CGIAR Climate-Resilient Agriculture Network',
                ],
                'national_programs' => [
                    'Asta Cita: Swasembada Pangan & Kemandirian Bangsa',
                    'Program Regenerasi Petani Milenial Kementan RI',
                    'Ketahanan Pangan Desa & Lumbung Pangan Rakyat',
                ],
                'target_beneficiaries' => 'Petani kecil, petani muda milenial, kelompok wanita tani (KWT), dan koperasi pangan lokal.',
                'youtube_url' => 'https://www.youtube.com/watch?v=ScMzIvxBSi4',
                'photo_image' => 'https://images.unsplash.com/photo-1592417817098-8f3d69109853?auto=format&fit=crop&w=800&q=80',
                'gallery' => [
                    'https://images.unsplash.com/photo-1592417817098-8f3d69109853?auto=format&fit=crop&w=800&q=80',
                    'https://images.unsplash.com/photo-1586771107445-d3ca888129ff?auto=format&fit=crop&w=800&q=80',
                    'https://images.unsplash.com/photo-1625246333195-78d9c38ad449?auto=format&fit=crop&w=800&q=80',
                ],
                'metric_value' => '120+ Ha',
                'metric_label_id' => 'Lahan Pangan Berkelanjutan',
                'metric_label_en' => 'Sustainable Farmland',
                'target_url' => 'https://siyota.org',
                'action_label' => 'Lihat Aksi di siyota.org →',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'pillar_number' => 4,
                'code' => 'budaya',
                'name' => 'BUDAYA',
                'title_id' => 'Pelestarian Budaya, Seni & Warisan Tradisi',
                'title_en' => 'Cultural Preservation & Indigenous Heritage',
                'description_id' => 'Melindungi kearifan adat, kerajinan adiluhung nusantara, serta dokumentasi khazanah budaya takbenda bangsa.',
                'description_en' => 'Safeguarding ancestral wisdom, indigenous crafts, and documenting intangible cultural heritage.',
                'why_it_matters_id' => 'Arus modernisasi cepat dan komersialisasi dangkal mengancam kepunahan warisan adiluhung, seni tutur, kearifan adat, dan kerajinan tangan adiluhung nusantara tanpa proses pewarisan ke generasi muda.',
                'why_it_matters_en' => 'Rapid homogenization and shallow commercialization threaten indigenous crafts, oral traditions, and ancestral wisdom without adequate intergenerational transfer.',
                'what_we_do_id' => 'Digitalisasi khazanah budaya takbenda, pemberdayaan maestro seni tradisional pelosok, kurasi etis karya kriya pusaka, serta penyelenggaraan panggung apresiasi budaya lintas generasi.',
                'what_we_do_en' => 'Digitizing intangible cultural assets, supporting rural traditional master craftspeople, ethical heritage curation, and cross-generational cultural festivals.',
                'sdgs' => [
                    'SDG 11: Kota & Komunitas Berkelanjutan (Warisan Budaya)',
                    'SDG 8: Pertumbuhan Ekonomi Inklusif',
                    'SDG 16: Perdamaian, Keadilan & Kelembagaan Tangguh',
                ],
                'global_programs' => [
                    'UNESCO Intangible Cultural Heritage Safeguarding',
                    'UNESCO Creative Cities & Craft Network',
                ],
                'national_programs' => [
                    'UU Pemajuan Kebudayaan No. 5 Tahun 2017',
                    'Dana Abadi Kebudayaan (Indonesiana)',
                    'Gerakan Nasional Pekan Kebudayaan Indonesia',
                ],
                'target_beneficiaries' => 'Komunitas adat, sanggar seni rakyat, perajin kriya tradisional, dan budayawan muda.',
                'youtube_url' => 'https://www.youtube.com/watch?v=L_LUpnjgPso',
                'photo_image' => 'https://images.unsplash.com/photo-1544644181-1484b3fdfc62?auto=format&fit=crop&w=800&q=80',
                'gallery' => [
                    'https://images.unsplash.com/photo-1544644181-1484b3fdfc62?auto=format&fit=crop&w=800&q=80',
                    'https://images.unsplash.com/photo-1609137144813-7d9921338f24?auto=format&fit=crop&w=800&q=80',
                    'https://images.unsplash.com/photo-1518709268805-4e9042af9f23?auto=format&fit=crop&w=800&q=80',
                ],
                'metric_value' => '75+ Komunitas',
                'metric_label_id' => 'Pelestari Seni & Adat',
                'metric_label_en' => 'Heritage Communities',
                'target_url' => 'https://siyota.org',
                'action_label' => 'Lihat Aksi di siyota.org →',
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'pillar_number' => 5,
                'code' => 'umkm-sociopreneur',
                'name' => 'UMKM & SOCIOPRENEUR',
                'title_id' => 'Pemberdayaan UMKM & Wirausaha Sosial Berdampak',
                'title_en' => 'MSME Empowerment & Social Entrepreneurship',
                'description_id' => 'Meningkatkan skala usaha mikro sirkular, pendampingan bisnis berdampak sosial, dan akses pasar berkelanjutan.',
                'description_en' => 'Upskilling circular micro-enterprises, mentoring purpose-driven businesses, and securing fair market access.',
                'why_it_matters_id' => 'UMKM menyerap 97% tenaga kerja nasional namun sebagian besar masih terjebak skala subsisten informal dengan literasi finansial terbatas dan kesulitan memenuhi standar rantai pasok industri modern.',
                'why_it_matters_en' => 'MSMEs employ 97% of the Indonesian workforce but mostly remain trapped in informal subsistence with limited financial literacy and market compliance barriers.',
                'what_we_do_id' => 'Bootcamp bisnis sirkular berdampak, pendampingan standarisasi sertifikasi halal dan BPOM, kurasi produk ekspor, serta fasilitasi akses permodalan katalitis berdampak sosial.',
                'what_we_do_en' => 'Circular business acceleration, regulatory certification mentoring, export-grade curation, and catalytic social finance facilitation.',
                'sdgs' => [
                    'SDG 8: Pekerjaan Layak & Pertumbuhan Ekonomi',
                    'SDG 9: Industri, Inovasi & Infrastruktur',
                    'SDG 12: Konsumsi & Produksi Bertanggung Jawab',
                ],
                'global_programs' => [
                    'UNCTAD Inclusive Business & Social Enterprise Forum',
                    'Global Impact Investing Network (GIIN) Standards',
                ],
                'national_programs' => [
                    'Asta Cita: Penguatan Ekonomi Kerakyatan & Koperasi',
                    'Gerakan Nasional Bangga Buatan Indonesia (BBI)',
                    'Holding Integrasi Ultra Mikro (UMi) Nasional',
                ],
                'target_beneficiaries' => 'Pelaku usaha mikro ultra-mikro, wirausaha sosial perempuan, dan koperasi produsen rakyat.',
                'youtube_url' => 'https://www.youtube.com/watch?v=kJQP7kiw5Fk',
                'photo_image' => 'https://images.unsplash.com/photo-1556740758-90de374c12ad?auto=format&fit=crop&w=800&q=80',
                'gallery' => [
                    'https://images.unsplash.com/photo-1556740758-90de374c12ad?auto=format&fit=crop&w=800&q=80',
                    'https://images.unsplash.com/photo-1472851294608-062f824d29cc?auto=format&fit=crop&w=800&q=80',
                    'https://images.unsplash.com/photo-1559136555-9303baea8ebd?auto=format&fit=crop&w=800&q=80',
                ],
                'metric_value' => '320+ UMKM',
                'metric_label_id' => 'Usaha Rakyat Didampingi',
                'metric_label_en' => 'Enterprises Mentored',
                'target_url' => 'https://siyota.org',
                'action_label' => 'Lihat Aksi di siyota.org →',
                'sort_order' => 5,
                'is_active' => true,
            ],
            [
                'pillar_number' => 6,
                'code' => 'digital-teknologi',
                'name' => 'DIGITAL & TEKNOLOGI',
                'title_id' => 'Inklusi Digital & Rekayasa Teknologi Terapan',
                'title_en' => 'Digital Inclusion & Applied Technologies',
                'description_id' => 'Menyediakan akses komputasi terjangkau, edukasi literasi digital warga, dan platform teknologi untuk kebaikan publik.',
                'description_en' => 'Expanding affordable compute, digital literacy education, and open technology platforms for the public good.',
                'why_it_matters_id' => 'Kesenjangan digital yang nyata antara kota metropolitan dan wilayah suburban/rural menyebabkan kesenjangan peluang ekonomi, tingginya kerentanan terhadap kejahatan digital, dan ketimpangan akses informasi publik.',
                'why_it_matters_en' => 'A stark digital divide between metropolitan hubs and rural regions creates economic opportunity gaps, vulnerability to digital fraud, and unequal access to public digital goods.',
                'what_we_do_id' => 'Pengembangan platform open-source pelayanan publik, pelatihan rekayasa kecerdasan artifisial dan coding terapan gratis bagi pelajar daerah, serta instalasi teknologi jaringan tepat guna.',
                'what_we_do_en' => 'Developing civic open-source software, free AI and software engineering bootcamps for regional youth, and low-cost community internet deployments.',
                'sdgs' => [
                    'SDG 9: Industri, Inovasi & Infrastruktur',
                    'SDG 4: Pendidikan Berkualitas',
                    'SDG 10: Berkurangnya Kesenjangan',
                ],
                'global_programs' => [
                    'UN Global Digital Compact Framework',
                    'ITU Connect 2030 Inclusivity Agenda',
                ],
                'national_programs' => [
                    'Peta Jalan Indonesia Digital 2024-2045',
                    'Gerakan Nasional Literasi Digital Siberkreasi',
                    'Akselerasi Transformasi Digital Pelayanan Publik Kominfo',
                ],
                'target_beneficiaries' => 'Pelajar daerah, santri pondok pesantren, komunitas pegiat teknologi, dan aparatur publik desa.',
                'youtube_url' => 'https://www.youtube.com/watch?v=jNQXAC9IVRw',
                'photo_image' => 'https://images.unsplash.com/photo-1531482615713-2afd69097998?auto=format&fit=crop&w=800&q=80',
                'gallery' => [
                    'https://images.unsplash.com/photo-1531482615713-2afd69097998?auto=format&fit=crop&w=800&q=80',
                    'https://images.unsplash.com/photo-1504384308090-c894fdcc538d?auto=format&fit=crop&w=800&q=80',
                    'https://images.unsplash.com/photo-1573164713988-8665fc963095?auto=format&fit=crop&w=800&q=80',
                ],
                'metric_value' => '15.000+ Warga',
                'metric_label_id' => 'Teredukasi Literasi Digital',
                'metric_label_en' => 'Digitally Literate Citizens',
                'target_url' => 'https://siyota.org',
                'action_label' => 'Lihat Aksi di siyota.org →',
                'sort_order' => 6,
                'is_active' => true,
            ],
            [
                'pillar_number' => 7,
                'code' => 'environment',
                'name' => 'ENVIRONMENT',
                'title_id' => 'Konservasi Lingkungan, Bahari & Aksi Iklim',
                'title_en' => 'Environmental Conservation & Climate Action',
                'description_id' => 'Pemulihan keanekaragaman hayati darat dan maritim, reforestasi hulu sungai, serta mitigasi krisis iklim nyata.',
                'description_en' => 'Restoring terrestrial and marine biodiversity, watershed reforestation, and tangible climate crisis mitigation.',
                'why_it_matters_id' => 'Ancaman krisis iklim, deforestasi hulu sungai, kepunahan terumbu karang, dan pencemaran sampah plastik menuntut aksi pemulihan nyata di tingkat tapak yang melibatkan masyarakat lokal sebagai penjaga ekosistem.',
                'why_it_matters_en' => 'Escalating climate disruptions, watershed deforestation, coral reef degradation, and plastic pollution require urgent grassroots nature restoration with frontline community stewards.',
                'what_we_do_id' => 'Penanaman dan monitoring pohon agroforestri di hulu sungai, penanaman mangrove pelindung pesisir, pembersihan sampah sirkular pesisir, dan edukasi gaya hidup rendah karbon.',
                'what_we_do_en' => 'Agroforestry watershed reforestation, coastal mangrove propagation, community-led circular waste collection, and low-carbon lifestyle education.',
                'sdgs' => [
                    'SDG 13: Penanganan Perubahan Iklim',
                    'SDG 14: Ekosistem Lautan',
                    'SDG 15: Ekosistem Daratan',
                    'SDG 12: Konsumsi & Produksi Bertanggung Jawab',
                ],
                'global_programs' => [
                    'Paris Climate Agreement (Enhanced NDC Target)',
                    'UN Decade on Ecosystem Restoration (2021-2030)',
                    'Kunming-Montreal Global Biodiversity Framework',
                ],
                'national_programs' => [
                    'Target Indonesia Net Zero Emission 2060',
                    'Program Rehabilitasi Mangrove Nasional BRGM',
                    'Indonesia Forestry and Other Land Uses (FOLU) Net Sink 2030',
                ],
                'target_beneficiaries' => 'Masyarakat pesisir, nelayan tradisional, masyarakat adat penjaga rimba, dan relawan konservasi muda.',
                'youtube_url' => 'https://www.youtube.com/watch?v=fJ9rUzIMcZQ',
                'photo_image' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=800&q=80',
                'gallery' => [
                    'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=800&q=80',
                    'https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?auto=format&fit=crop&w=800&q=80',
                    'https://images.unsplash.com/photo-1448375240586-882707db888b?auto=format&fit=crop&w=800&q=80',
                ],
                'metric_value' => '25.000+ Pohon',
                'metric_label_id' => 'Bibit Ditanam & Terawat',
                'metric_label_en' => 'Trees Planted & Monitored',
                'target_url' => 'https://siyota.org',
                'action_label' => 'Lihat Aksi di siyota.org →',
                'sort_order' => 7,
                'is_active' => true,
            ],
            [
                'pillar_number' => 8,
                'code' => 'education',
                'name' => 'EDUCATION',
                'title_id' => 'Transformasi Pendidikan Inklusif & Literasi Vokasi',
                'title_en' => 'Inclusive Education & Vocational Literacy',
                'description_id' => 'Membuka akses pendidikan berkualitas, beasiswa pelatihan vokasi aplikatif, dan ruang belajar terbuka di akar rumput.',
                'description_en' => 'Opening access to quality education, applied vocational scholarships, and open community learning spaces.',
                'why_it_matters_id' => 'Tingginya disparitas mutu pembelajaran antarwilayah, keterbatasan fasilitas sekolah di pelosok terluar, serta kesenjangan antara kurikulum akademik dengan kompetensi riil yang dibutuhkan pasar kerja modern.',
                'why_it_matters_en' => 'Severe educational quality disparities, under-resourced schools in remote frontiers, and a chronic mismatch between formal school curricula and real workplace requirements.',
                'what_we_do_id' => 'Pengadaan pojok literasi digital pedesaan, beasiswa pelatihan vokasi siap kerja untuk pemuda prasejahtera, pelatihan guru honorer daerah 3T, dan modul pembelajaran kontekstual berbasis proyek.',
                'what_we_do_en' => 'Rural digital learning centers, vocational job-readiness scholarships for underprivileged youth, teacher upskilling in frontier regions, and project-based experiential curricula.',
                'sdgs' => [
                    'SDG 4: Pendidikan Berkualitas',
                    'SDG 5: Kesetaraan Gender',
                    'SDG 10: Berkurangnya Kesenjangan',
                ],
                'global_programs' => [
                    'UNESCO Education 2030 Incheon Framework',
                    'World Bank Skills for the Global Economy Initiative',
                ],
                'national_programs' => [
                    'Program Indonesia Pintar (PIP) Kemendikbudristek',
                    'Revitalisasi Pendidikan dan Pelatihan Vokasi (Perpres 68/2022)',
                    'Gerakan Merdeka Belajar & Kampus Berdampak Sosial',
                ],
                'target_beneficiaries' => 'Siswa prasejahtera, santri, pemuda putus sekolah, dan tenaga pendidik honorer daerah 3T.',
                'youtube_url' => 'https://www.youtube.com/watch?v=9bZkp7q19f0',
                'photo_image' => 'https://images.unsplash.com/photo-1509062522246-3755977927d7?auto=format&fit=crop&w=800&q=80',
                'gallery' => [
                    'https://images.unsplash.com/photo-1509062522246-3755977927d7?auto=format&fit=crop&w=800&q=80',
                    'https://images.unsplash.com/photo-1497633762265-9d179a990aa6?auto=format&fit=crop&w=800&q=80',
                    'https://images.unsplash.com/photo-1580582932707-520aed937b7b?auto=format&fit=crop&w=800&q=80',
                ],
                'metric_value' => '6.400+ Siswa',
                'metric_label_id' => 'Penerima Akses Edukasi',
                'metric_label_en' => 'Scholarship & Literacy Access',
                'target_url' => 'https://siyota.org',
                'action_label' => 'Lihat Aksi di siyota.org →',
                'sort_order' => 8,
                'is_active' => true,
            ],
            [
                'pillar_number' => 9,
                'code' => 'community-development',
                'name' => 'COMMUNITY DEVELOPMENT',
                'title_id' => 'Pengembangan & Ketahanan Solidaritas Komunitas',
                'title_en' => 'Community Resilience & Grassroots Solidarity',
                'description_id' => 'Memperkuat jaring gotong royong warga, ketahanan menghadapi bencana, dan kemandirian sosial masyarakat lokal.',
                'description_en' => 'Strengthening grassroots solidarity networks, disaster responsiveness, and localized social autonomy.',
                'why_it_matters_id' => 'Tingginya kerentanan masyarakat terhadap bencana alam dan krisis sosial-ekonomi tanpa kesiapan sistem lumbung gotong royong warga menyebabkan pemulihan pasca krisis berlangsung lambat dan memiskinkan.',
                'why_it_matters_en' => 'High vulnerability to natural hazards and socioeconomic shocks without structured community solidarity mechanisms causes sluggish and impoverishing post-crisis recovery.',
                'what_we_do_id' => 'Pembentukan satuan tanggap darurat warga berbasis komunitas, lumbung pangan dan logistik sosial mandiri, pendampingan inklusif kelompok rentan difabel dan lansia, serta penguatan kohesi sosial lintas warga.',
                'what_we_do_en' => 'Forming localized citizen first-responder units, community mutual-aid food pantries, inclusive support for disabled and elderly residents, and cross-cultural social cohesion forums.',
                'sdgs' => [
                    'SDG 11: Kota & Komunitas Berkelanjutan',
                    'SDG 16: Perdamaian, Keadilan & Kelembagaan Tangguh',
                    'SDG 17: Kemitraan untuk Mencapai Tujuan',
                ],
                'global_programs' => [
                    'Sendai Framework for Disaster Risk Reduction 2015-2030',
                    'UN Habitat New Urban Agenda Community Resilience',
                ],
                'national_programs' => [
                    'Program Desa Tangguh Bencana (Destana) BNPB',
                    'Asta Cita: Penguatan Harmoni, Solidaritas & Jaminan Sosial',
                    'Program Keluarga Harapan (PKH) Inklusif Kemensos',
                ],
                'target_beneficiaries' => 'Masyarakat kawasan rawan bencana, lansia prasejahtera, penyandang disabilitas, dan warga marjinal.',
                'youtube_url' => 'https://www.youtube.com/watch?v=3JZ_D3ELwOQ',
                'photo_image' => 'https://images.unsplash.com/photo-1511632765486-a01980e01a18?auto=format&fit=crop&w=800&q=80',
                'gallery' => [
                    'https://images.unsplash.com/photo-1511632765486-a01980e01a18?auto=format&fit=crop&w=800&q=80',
                    'https://images.unsplash.com/photo-1469571486292-0ba58a3f068b?auto=format&fit=crop&w=800&q=80',
                    'https://images.unsplash.com/photo-1582213782179-e0d53f98f2ca?auto=format&fit=crop&w=800&q=80',
                ],
                'metric_value' => '85+ Komunitas',
                'metric_label_id' => 'Jejaring Gotong Royong',
                'metric_label_en' => 'Solidarity Networks',
                'target_url' => 'https://siyota.org',
                'action_label' => 'Lihat Aksi di siyota.org →',
                'sort_order' => 9,
                'is_active' => true,
            ],
        ];

        foreach ($pillars as $p) {
            EcosystemImpactPillar::updateOrCreate(['pillar_number' => $p['pillar_number']], $p);
        }

        // -------------------------------------------------------------
        // 9. DOKUMEN & LAPORAN ESG TERBUKA (WAJIB ADA COVER)
        // -------------------------------------------------------------
        $documents = [
            [
                'slug' => 'laporan-keberlanjutan-dampak-esg-2025-2026',
                'title_id' => 'Laporan Keberlanjutan & Dampak ESG 2025/2026',
                'title_en' => 'Sustainability & ESG Impact Report 2025/2026',
                'category' => 'Laporan ESG',
                'cover_image' => 'https://images.unsplash.com/photo-1450133064473-71024230f91b?auto=format&fit=crop&w=800&q=80',
                'file_url' => 'https://siyota.org/reports/esg-sustainability-2025-2026.pdf',
                'file_type' => 'pdf',
                'file_size' => '4.6 MB',
                'year' => '2026',
                'description_id' => 'Laporan komprehensif audit Environmental, Social, and Governance (ESG) serta capaian riil 9 pilar aksi di seluruh nusantara.',
                'description_en' => 'Comprehensive ESG audit and sustainability disclosure measuring transparent outcomes across all 9 impact pillars.',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'slug' => 'whitepaper-transformasi-digital-desa-berdikari',
                'title_id' => 'Whitepaper: Transformasi Digital & Kemandirian Desa Berdikari',
                'title_en' => 'Whitepaper: Digital Transformation for Autonomous Villages',
                'category' => 'Whitepaper',
                'cover_image' => 'https://images.unsplash.com/photo-1451187580459-43490279c0fa?auto=format&fit=crop&w=800&q=80',
                'file_url' => 'https://siyota.org/whitepapers/desa-berdikari-digital-roadmap.pdf',
                'file_type' => 'pdf',
                'file_size' => '3.2 MB',
                'year' => '2026',
                'description_id' => 'Dokumen kerangka kerja integrasi tata kelola BUMDes, kedaulatan data desa, dan akselerasi ekonomi mikro pedesaan.',
                'description_en' => 'Applied policy framework on village enterprise digitization, grassroots data sovereignty, and rural economic resilience.',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'slug' => 'katalog-program-kemitraan-9-pilar-siyota',
                'title_id' => 'Katalog Program Kemitraan & Aksi 9 Pilar SIYOTA',
                'title_en' => 'SIYOTA 9 Pillars Strategic Partnership Directory',
                'category' => 'Katalog Program',
                'cover_image' => 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=800&q=80',
                'file_url' => 'https://siyota.org',
                'file_type' => 'link',
                'file_size' => 'Tautan Interaktif',
                'year' => '2026',
                'description_id' => 'Panduan kemitraan kolaboratif multi-pihak bagi korporasi, filantropi, dan institusi riset untuk aksi lapangan terukur.',
                'description_en' => 'Multi-stakeholder partnership roadmap for corporate CSR, philanthropic institutions, and civic researchers.',
                'is_active' => true,
                'sort_order' => 3,
            ],
        ];

        foreach ($documents as $doc) {
            EcosystemDocument::updateOrCreate(['slug' => $doc['slug']], $doc);
        }
    }
}
