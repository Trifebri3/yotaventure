<?php

namespace Tests\Feature;

use App\Models\EcosystemClient;
use App\Models\EcosystemDocument;
use App\Models\EcosystemDomain;
use App\Models\EcosystemImpactMetric;
use App\Models\EcosystemImpactPillar;
use App\Models\EcosystemInitiative;
use App\Models\User;
use Database\Seeders\EcosystemSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class EcosystemPlatformTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Seed the ecosystem data
        $this->seed(EcosystemSeeder::class);
    }

    public function test_public_ecosystem_gateway_is_accessible(): void
    {
        $response = $this->get('/ekosistem');

        $response->assertStatus(200);
        $response->assertSee('YOIN is the home behind what we build.');
        $response->assertSee('Solusi &amp; Rekayasa Digital', false);
        $response->assertSee('YOIN Digital');
        $response->assertSee('AGRONEX');
    }

    public function test_ecosystem_redirects_from_english_path(): void
    {
        $response = $this->get('/ecosystem');

        $response->assertRedirect('/ekosistem');
    }

    public function test_domain_deep_dive_page_displays_problem_and_solution(): void
    {
        $response = $this->get('/ekosistem/domain/digital');

        $response->assertStatus(200);
        $response->assertSee('Solusi &amp; Rekayasa Digital', false);
        $response->assertSee('YOIN Digital');
    }

    public function test_initiative_page_displays_problem_statement_and_external_gateway(): void
    {
        $response = $this->get('/ekosistem/inisiatif/yoin-digital');

        $response->assertStatus(200);
        $response->assertSee('YOIN Digital');
        $response->assertSee('https://yoindigital.com');
    }

    public function test_public_portfolio_index_is_accessible(): void
    {
        $response = $this->get('/portofolio');

        $response->assertStatus(200);
        $response->assertSee('Indeks Portofolio');
        $response->assertSee('Danantara Strategic Asset Intelligence Portal');
    }

    public function test_portfolio_case_study_detail_page_is_accessible(): void
    {
        $response = $this->get('/portofolio/danantara-intelligence-portal');

        $response->assertStatus(200);
        $response->assertSee('Danantara Strategic Asset Intelligence Portal');
        $response->assertSee('PT Danantara Nusantara');
    }

    public function test_admin_ecosystem_requires_authentication(): void
    {
        $response = $this->get('/admin/ecosystem');

        $response->assertRedirect('/login');
    }

    public function test_authenticated_admin_can_access_ecosystem_manager(): void
    {
        $user = User::first() ?? User::factory()->create();

        $response = $this->actingAs($user)->get('/admin/ecosystem');

        $response->assertStatus(200);
        $response->assertSee('Kelola Ekosistem');
        $response->assertSee('YOIN Digital');
    }

    public function test_homepage_orbit_and_domain_sections_link_to_ecosystem(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        // Constellation orbit links
        $response->assertSee(route('public.ecosystem.index'));
        $response->assertSee(route('public.ecosystem.domain', 'digital'));
        $response->assertSee(route('public.ecosystem.domain', 'agriculture'));
        $response->assertSee(route('public.ecosystem.domain', 'products'));
        $response->assertSee(route('public.ecosystem.domain', 'impact'));
        $response->assertSee(route('public.ecosystem.domain', 'emerging'));
        $response->assertSee(route('public.ecosystem.initiative', 'yoin-digital'));
        $response->assertSee(route('public.ecosystem.initiative', 'agronex'));
        $response->assertSee(route('public.ecosystem.initiative', 'yoimo'));
        $response->assertSee(route('public.ecosystem.initiative', 'buatara'));
        $response->assertSee(route('public.ecosystem.initiative', 'yota-adiwidya-center'));
    }

    public function test_initiative_public_profile_displays_sdgs_government_issues_locus_and_gallery(): void
    {
        $response = $this->get('/ekosistem/inisiatif/agronex');

        $response->assertStatus(200);
        $response->assertSee('AGRONEX');
        $response->assertSee('Kaitan SDGs PBB');
        $response->assertSee('SDG 2: Tanpa Kelaparan');
        $response->assertSee('Isu & Agenda Pemerintah', false);
        $response->assertSee('Swasembada Pangan Nasional');
        $response->assertSee('Fokus & Lokus Wilayah', false);
        $response->assertSee('Jawa Barat');
        $response->assertSee('Dokumentasi & Galeri Visual', false);
        $response->assertSee('Explore AGRONEX Ecosystem');
    }

    public function test_admin_can_update_initiative_with_sdgs_locus_and_government_issues(): void
    {
        $user = User::first() ?? User::factory()->create();
        $initiative = EcosystemInitiative::where('slug', 'agronex')->first();

        $response = $this->actingAs($user)->put("/admin/ecosystem/initiatives/{$initiative->id}", [
            'domain_id' => $initiative->domain_id,
            'name' => 'AGRONEX Smart Agriculture',
            'slug' => 'agronex',
            'stage' => 'AgriTech Initiative',
            'problem_statement_id' => 'Petani lokal kekurangan data agronomis mikro.',
            'locus' => 'Sumatera & Jawa',
            'sdgs_raw' => "SDG 2: Tanpa Kelaparan\nSDG 13: Penanganan Perubahan Iklim",
            'government_issues_raw' => "Regenerasi Petani Muda\nSwasembada Beras",
            'gallery_raw' => "https://images.unsplash.com/photo-test-1\nhttps://images.unsplash.com/photo-test-2",
            'external_website_url' => 'https://agronex.id',
            'external_url_label' => 'Explore AGRONEX Ecosystem →',
            'social_instagram' => 'https://instagram.com/agronex.id',
            'status' => 'OPERATING',
            'visibility' => 'public',
        ]);

        $response->assertRedirect('/admin/ecosystem?tab=initiatives');
        $this->assertDatabaseHas('ecosystem_initiatives', [
            'id' => $initiative->id,
            'name' => 'AGRONEX Smart Agriculture',
            'locus' => 'Sumatera & Jawa',
        ]);

        $updated = $initiative->fresh();
        $this->assertContains('SDG 2: Tanpa Kelaparan', $updated->sdgs);
        $this->assertContains('SDG 13: Penanganan Perubahan Iklim', $updated->sdgs);
        $this->assertContains('Regenerasi Petani Muda', $updated->government_issues);
        $this->assertCount(2, $updated->gallery);
        $this->assertEquals('https://instagram.com/agronex.id', $updated->social_links['instagram']);
    }

    public function test_domain_page_displays_sdgs_issues_solutions_and_gallery(): void
    {
        $response = $this->get('/ekosistem/domain/agriculture');

        $response->assertStatus(200);
        $response->assertSee('Agrikultur &amp; Ketahanan Pangan', false);
        $response->assertSee('Keterkaitan SDGs PBB');
        $response->assertSee('SDG 2: Tanpa Kelaparan');
        $response->assertSee('Tantangan Mendasar di Sektor Ini');
        $response->assertSee('Solusi Strategis Ekosistem Kita');
        $response->assertSee('Pemetaan Isu & Solusi Rekayasa Kami', false);
        $response->assertSee('Dokumentasi & Galeri Visual', false);
    }

    public function test_admin_can_create_domain_with_file_uploads_sdgs_and_issues(): void
    {
        Storage::fake('public');
        $user = User::first() ?? User::factory()->create();

        $iconFile = UploadedFile::fake()->image('domain-icon.png', 100, 100);
        $coverFile = UploadedFile::fake()->image('domain-cover.jpg', 800, 400);
        $galleryPhoto1 = UploadedFile::fake()->image('field-1.jpg', 600, 400);
        $galleryPhoto2 = UploadedFile::fake()->image('field-2.jpg', 600, 400);

        $response = $this->actingAs($user)->post('/admin/ecosystem/domains', [
            'name_id' => 'Energi Hijau & Transisi Sirkular',
            'name_en' => 'Green Energy & Circular Transition',
            'slug' => 'energi-hijau',
            'tagline_id' => 'Kemandirian energi terbarukan komunitas.',
            'problem_statement_id' => 'Ketergantungan tinggi pada bahan bakar fosil mahal.',
            'solution_statement_id' => 'Pembangkit mikrohidro dan panel surya berbasis kooperatif.',
            'icon_file' => $iconFile,
            'cover_file' => $coverFile,
            'gallery_files' => [$galleryPhoto1, $galleryPhoto2],
            'sdgs_raw' => "SDG 7: Energi Bersih & Terjangkau\nSDG 13: Penanganan Perubahan Iklim",
            'issues_raw' => "Biaya transmisi mahal :: Sistem microgrid mandiri\nLimbah baterai :: Daur ulang sel baterai terstandar",
            'status' => 'OPERATING',
            'visibility' => 'public',
            'sort_order' => 6,
        ]);

        $response->assertRedirect('/admin/ecosystem?tab=domains');
        $this->assertDatabaseHas('ecosystem_domains', [
            'slug' => 'energi-hijau',
            'name_id' => 'Energi Hijau & Transisi Sirkular',
        ]);

        $domain = EcosystemDomain::where('slug', 'energi-hijau')->firstOrFail();
        $this->assertNotNull($domain->icon_image);
        $this->assertNotNull($domain->cover_image);
        $this->assertCount(2, $domain->gallery);
        $this->assertCount(2, $domain->sdgs);
        $this->assertCount(2, $domain->issues);
        $this->assertEquals('Biaya transmisi mahal', $domain->issues[0]['issue']);
        $this->assertEquals('Sistem microgrid mandiri', $domain->issues[0]['solution']);
    }

    public function test_admin_can_update_and_delete_domain(): void
    {
        $user = User::first() ?? User::factory()->create();
        $domain = EcosystemDomain::where('slug', 'emerging')->firstOrFail();

        $response = $this->actingAs($user)->put("/admin/ecosystem/domains/{$domain->id}", [
            'name_id' => 'Riset Frontier & Kecerdasan Terapan',
            'name_en' => 'Frontier Research & Applied Intelligence',
            'slug' => 'emerging',
            'problem_statement_id' => 'Keterbatasan riset terapan domestik.',
            'solution_statement_id' => 'Sandbox inovasi terbuka kolaboratif.',
            'sdgs_raw' => 'SDG 9: Industri & Inovasi',
            'issues_raw' => 'Kesenjangan komputasi :: Klaster GPU terdesentralisasi',
            'status' => 'BUILDING',
            'visibility' => 'public',
            'sort_order' => 5,
        ]);

        $response->assertRedirect('/admin/ecosystem?tab=domains');
        $this->assertDatabaseHas('ecosystem_domains', [
            'id' => $domain->id,
            'name_id' => 'Riset Frontier & Kecerdasan Terapan',
            'status' => 'BUILDING',
        ]);

        // Test deletion
        $deleteResponse = $this->actingAs($user)->delete("/admin/ecosystem/domains/{$domain->id}");
        $deleteResponse->assertRedirect('/admin/ecosystem?tab=domains');
        $this->assertDatabaseMissing('ecosystem_domains', [
            'id' => $domain->id,
        ]);
    }

    public function test_homepage_domains_showcase_is_synchronized_with_database(): void
    {
        // 1. Verify standard homepage renders the seeded domains dynamically
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('id="domains"', false);
        $response->assertSee('Solusi &amp; Rekayasa Digital', false);
        $response->assertSee('Agrikultur &amp; Ketahanan Pangan', false);
        $response->assertSee('Pemberdayaan &amp; Dampak Sosial', false);
        $response->assertSee('KEDAULATAN DIGITAL NUSANTARA');
        $response->assertSee('HILIRISASI TEKNOLOGI PANGAN');
        $response->assertSee('ekosistem/domain/digital', false);

        // 2. Modify a domain in the database and ensure homepage updates dynamically
        $digitalDomain = EcosystemDomain::where('slug', 'digital')->firstOrFail();
        $digitalDomain->update([
            'name_id' => 'Teknologi Awan & Siber Berdaulat',
            'meta_title' => 'TRANSFORMASI SIBER INDONESIA',
        ]);

        $updatedResponse = $this->get('/');
        $updatedResponse->assertStatus(200);
        $updatedResponse->assertSee('Teknologi Awan &amp; Siber Berdaulat', false);
        $updatedResponse->assertSee('TRANSFORMASI SIBER INDONESIA');
    }

    public function test_homepage_ecosystem_brands_showcase_is_synchronized_with_database(): void
    {
        // 1. Verify standard homepage renders seeded ecosystem brands dynamically with services and carousel track
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('id="ecosystem"', false);
        $response->assertSee('YOIN Digital');
        $response->assertSee('AGRONEX');
        $response->assertSee('YOIMO');
        $response->assertSee('BUATARA');
        $response->assertSee('Pengembangan Web');
        $response->assertSee('Otomasi Irigasi Pintar');
        $response->assertSee('ekosistem/inisiatif/yoin-digital', false);
        $response->assertSee('x-ref="sliderTrack"', false);
        $response->assertSee('startAutoplay', false);

        // 2. Modify an existing initiative in the database and verify it immediately reflects on the homepage
        $yoinDigital = EcosystemInitiative::where('slug', 'yoin-digital')->firstOrFail();
        $yoinDigital->update([
            'name' => 'YOIN Digital Enterprise',
            'stage' => 'Core Tech Platform',
            'tagline_id' => 'Arsitektur piranti lunak berdaulat untuk kebutuhan industri masa depan.',
            'focus_areas' => ['Platform Cloud Kustom', 'Keamanan Siber Terpadu'],
        ]);

        $updatedInitResponse = $this->get('/');
        $updatedInitResponse->assertStatus(200);
        $updatedInitResponse->assertSee('YOIN Digital Enterprise');
        $updatedInitResponse->assertSee('Core Tech Platform');
        $updatedInitResponse->assertSee('Arsitektur piranti lunak berdaulat untuk kebutuhan industri masa depan.');
        $updatedInitResponse->assertSee('Platform Cloud Kustom');
        $updatedInitResponse->assertSee('Keamanan Siber Terpadu');

        // 3. Add a new brand into the database and verify it appears dynamically
        $domainAgri = EcosystemDomain::where('slug', 'agriculture')->firstOrFail();
        EcosystemInitiative::create([
            'domain_id' => $domainAgri->id,
            'name' => 'LUMINA BIOTECH',
            'slug' => 'lumina-biotech',
            'stage' => 'Brand Agrikultur',
            'tagline_id' => 'Bio-pestisida ramah lingkungan berbasis mikroba alam nusantara.',
            'tagline_en' => 'Eco-friendly bio-pesticides engineered from native microbes.',
            'focus_areas' => ['Microbial Fermentation', 'Soil Health Formulation'],
            'visibility' => 'public',
            'sort_order' => 10,
        ]);

        $updatedResponse = $this->get('/');
        $updatedResponse->assertStatus(200);
        $updatedResponse->assertSee('LUMINA BIOTECH');
        $updatedResponse->assertSee('Microbial Fermentation');
        $updatedResponse->assertSee('Soil Health Formulation');
        $updatedResponse->assertSee('ekosistem/inisiatif/lumina-biotech', false);
    }

    public function test_homepage_partners_and_clients_marquee_is_synchronized_with_database(): void
    {
        // 1. Verify partners-clients section exists and renders seeded partners & clients
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('id="partners-clients"', false);
        $response->assertSee('marquee-track-left', false);
        $response->assertSee('marquee-track-right', false);
        $response->assertSee('PT Danantara Nusantara');
        $response->assertSee('PLN Nusantara Power');
        $response->assertSee('ITB Innovation Park');
        $response->assertSee('Yayasan KEHATI');

        // 2. Modify an existing partner and check homepage sync
        $danantara = EcosystemClient::where('slug', 'danantara-nusantara')->firstOrFail();
        $danantara->update([
            'name' => 'Danantara Strategic Asset Management',
            'industry' => 'Sovereign Wealth & Infrastructure',
        ]);

        $updatedResponse = $this->get('/');
        $updatedResponse->assertStatus(200);
        $updatedResponse->assertSee('Danantara Strategic Asset Management');
        $updatedResponse->assertSee('Sovereign Wealth & Infrastructure');

        // 3. Add a new partner in database and verify it immediately displays
        EcosystemClient::create([
            'name' => 'PT Biofarma Global Nusantara',
            'slug' => 'biofarma-global',
            'client_type' => 'Mitra Strategis',
            'industry' => 'Biomedical & Vaccine Sovereign Supply',
            'is_active' => true,
        ]);

        $newResponse = $this->get('/');
        $newResponse->assertStatus(200);
        $newResponse->assertSee('PT Biofarma Global Nusantara');
        $newResponse->assertSee('Biomedical & Vaccine Sovereign Supply');
    }

    public function test_admin_can_manage_partners_and_clients_via_ecosystem_cms(): void
    {
        Storage::fake('public');
        $user = User::first() ?? User::factory()->create();

        // 1. Admin creates a new client with logo upload
        $logoFile = UploadedFile::fake()->image('partner-logo.png', 200, 200);
        $createResponse = $this->actingAs($user)->post('/admin/ecosystem/clients', [
            'name' => 'PT Barata Indonesia Rekayasa',
            'slug' => 'barata-indonesia-rekayasa',
            'client_type' => 'Pemerintah & BUMN',
            'industry' => 'Heavy Engineering & Foundry',
            'location' => 'Gresik, Jawa Timur',
            'website_url' => 'https://barata.id',
            'description_id' => 'BUMN pelopor manufaktur peralatan industri berat nasional.',
            'logo_file' => $logoFile,
            'is_active' => '1',
        ]);

        $createResponse->assertRedirect('/admin/ecosystem?tab=clients');
        $this->assertDatabaseHas('ecosystem_clients', [
            'slug' => 'barata-indonesia-rekayasa',
            'name' => 'PT Barata Indonesia Rekayasa',
            'client_type' => 'Pemerintah & BUMN',
            'is_active' => true,
        ]);

        $client = EcosystemClient::where('slug', 'barata-indonesia-rekayasa')->firstOrFail();
        $this->assertNotNull($client->logo_image);

        // 2. Admin updates the client
        $updateResponse = $this->actingAs($user)->put("/admin/ecosystem/clients/{$client->id}", [
            'name' => 'PT Barata Indonesia (Persero)',
            'slug' => 'barata-indonesia-rekayasa',
            'client_type' => 'Pemerintah & BUMN',
            'industry' => 'Heavy Engineering & Smart Infrastructure',
            'location' => 'Gresik & Jakarta',
            'website_url' => 'https://barata.id',
            'description_id' => 'BUMN industri manufaktur strategis.',
            'is_active' => '0',
        ]);

        $updateResponse->assertRedirect('/admin/ecosystem?tab=clients');
        $this->assertDatabaseHas('ecosystem_clients', [
            'id' => $client->id,
            'name' => 'PT Barata Indonesia (Persero)',
            'is_active' => false,
        ]);

        // 3. Admin deletes the client
        $deleteResponse = $this->actingAs($user)->delete("/admin/ecosystem/clients/{$client->id}");
        $deleteResponse->assertRedirect('/admin/ecosystem?tab=clients');
        $this->assertDatabaseMissing('ecosystem_clients', [
            'id' => $client->id,
        ]);
    }

    public function test_homepage_no_longer_contains_impact_section_directly(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        // The impact section has been moved to dedicated /dampak page
        $response->assertDontSee('id="impact"', false);
    }

    public function test_impact_legacy_route_redirects_to_dampak(): void
    {
        $response = $this->get('/impact');

        $response->assertRedirect('/dampak');
    }

    public function test_public_impact_page_displays_9_pillars_galleries_and_siyota_links(): void
    {
        $response = $this->get('/dampak');

        $response->assertStatus(200);
        $response->assertSee('DAMPAK SOSIAL & TATA KELOLA ESG', false);
        $response->assertSee('9 Pilar Aksi Nyata');
        $response->assertSee('https://siyota.org');

        // Verify each of the 9 required pillars is rendered with gallery
        $pillars = EcosystemImpactPillar::active()->orderBy('pillar_number')->get();
        $this->assertCount(9, $pillars);

        foreach ($pillars as $pillar) {
            $response->assertSee($pillar->name);
            $response->assertSee($pillar->title_id);
            $this->assertNotEmpty($pillar->photo_image);
            $response->assertSee($pillar->photo_image);

            // Verify gallery items exist and are rendered
            $gallery = $pillar->gallery;
            $this->assertIsArray($gallery);
            $this->assertNotEmpty($gallery);
            $response->assertSee($gallery[0]);
        }
    }

    public function test_public_impact_page_displays_metrics_and_esg_documents_with_covers(): void
    {
        $response = $this->get('/dampak');

        $response->assertStatus(200);
        $response->assertSee('50.000+');
        $response->assertSee('Pemuda & Komunitas Terdampak');
        $response->assertSee('Dokumen & Laporan Dampak ESG', false);

        $documents = EcosystemDocument::active()->get();
        $this->assertGreaterThanOrEqual(1, $documents->count());

        foreach ($documents as $doc) {
            $response->assertSee($doc->title_id);
            $this->assertNotEmpty($doc->cover_image);
            $response->assertSee($doc->cover_image);
        }
    }

    public function test_admin_can_manage_esg_documents_crud(): void
    {
        Storage::fake('public');
        $user = User::first() ?? User::factory()->create();

        // 1. Admin creates a document with cover file and PDF file
        $coverFile = UploadedFile::fake()->image('esg-report-cover.jpg', 600, 800);
        $docFile = UploadedFile::fake()->create('annual-esg-report.pdf', 1024, 'application/pdf');

        $createResponse = $this->actingAs($user)->post('/admin/ecosystem/documents', [
            'title_id' => 'Laporan Akuntabilitas & Jejak Karbon Ekosistem 2026',
            'slug' => 'laporan-akuntabilitas-karbon-2026',
            'category' => 'Laporan Keberlanjutan',
            'description_id' => 'Ringkasan komprehensif audit jejak emisi dan dampak ESG lintas inisiatif.',
            'year' => '2026',
            'file_format' => 'PDF',
            'file_size' => '3.8 MB',
            'cover_file' => $coverFile,
            'document_file' => $docFile,
            'is_active' => '1',
            'sort_order' => 1,
        ]);

        $createResponse->assertRedirect('/admin/ecosystem?tab=impact');
        $this->assertDatabaseHas('ecosystem_documents', [
            'slug' => 'laporan-akuntabilitas-karbon-2026',
            'title_id' => 'Laporan Akuntabilitas & Jejak Karbon Ekosistem 2026',
            'is_active' => true,
        ]);

        $doc = EcosystemDocument::where('slug', 'laporan-akuntabilitas-karbon-2026')->firstOrFail();
        $this->assertNotNull($doc->cover_image);
        $this->assertNotNull($doc->file_path);

        // 2. Admin updates the document
        $updateResponse = $this->actingAs($user)->put("/admin/ecosystem/documents/{$doc->id}", [
            'title_id' => 'Laporan Akuntabilitas & Jejak Karbon Ekosistem 2026 (Final Ed.)',
            'slug' => 'laporan-akuntabilitas-karbon-2026',
            'category' => 'Laporan Keberlanjutan',
            'description_id' => 'Edisi final laporan jejak karbon terverifikasi.',
            'year' => '2026',
            'file_format' => 'PDF',
            'is_active' => '1',
        ]);

        $updateResponse->assertRedirect('/admin/ecosystem?tab=impact');
        $this->assertDatabaseHas('ecosystem_documents', [
            'id' => $doc->id,
            'title_id' => 'Laporan Akuntabilitas & Jejak Karbon Ekosistem 2026 (Final Ed.)',
            'is_active' => true,
        ]);

        // 3. Admin deletes the document
        $deleteResponse = $this->actingAs($user)->delete("/admin/ecosystem/documents/{$doc->id}");
        $deleteResponse->assertRedirect('/admin/ecosystem?tab=impact');
        $this->assertDatabaseMissing('ecosystem_documents', [
            'id' => $doc->id,
        ]);
    }

    public function test_admin_can_manage_impact_metrics_crud(): void
    {
        $user = User::first() ?? User::factory()->create();

        // 1. Admin creates a new metric
        $createResponse = $this->actingAs($user)->post('/admin/ecosystem/metrics', [
            'metric_value' => '1.250+',
            'label_id' => 'Inkubasi Proyek Desa Mandiri',
            'label_en' => 'Independent Village Project Incubations',
            'description_id' => 'Pendampingan langsung desa percontohan se-Indonesia.',
            'description_en' => 'Direct coaching of pilot villages across Indonesia.',
            'icon' => 'home',
            'sort_order' => 5,
            'is_active' => 1,
        ]);

        $createResponse->assertRedirect('/admin/ecosystem?tab=impact');
        $this->assertDatabaseHas('ecosystem_impact_metrics', [
            'metric_value' => '1.250+',
            'label_id' => 'Inkubasi Proyek Desa Mandiri',
        ]);

        $metric = EcosystemImpactMetric::where('metric_value', '1.250+')->firstOrFail();

        // 2. Admin updates the metric
        $updateResponse = $this->actingAs($user)->put("/admin/ecosystem/metrics/{$metric->id}", [
            'metric_value' => '1.500+',
            'label_id' => 'Inkubasi Proyek Desa Mandiri (Revisi)',
            'label_en' => 'Independent Village Incubations (Revised)',
            'sort_order' => 6,
            'is_active' => 1,
        ]);

        $updateResponse->assertRedirect('/admin/ecosystem?tab=impact');
        $this->assertDatabaseHas('ecosystem_impact_metrics', [
            'id' => $metric->id,
            'metric_value' => '1.500+',
            'label_id' => 'Inkubasi Proyek Desa Mandiri (Revisi)',
        ]);

        // 3. Admin deletes the metric
        $deleteResponse = $this->actingAs($user)->delete("/admin/ecosystem/metrics/{$metric->id}");
        $deleteResponse->assertRedirect('/admin/ecosystem?tab=impact');
        $this->assertDatabaseMissing('ecosystem_impact_metrics', [
            'id' => $metric->id,
        ]);
    }

    public function test_admin_can_update_pillar_with_gallery_and_metrics(): void
    {
        Storage::fake('public');
        $user = User::first() ?? User::factory()->create();
        $pillar = EcosystemImpactPillar::where('pillar_number', 1)->firstOrFail();

        $newGalleryFile = UploadedFile::fake()->image('pillar-action-1.jpg', 800, 600);

        $response = $this->actingAs($user)->put("/admin/ecosystem/pillars/{$pillar->id}", [
            'name' => 'YOUTH EMPOWERMENT',
            'title_id' => 'Pemberdayaan Pemuda & Kepemimpinan Berdaya Saing',
            'title_en' => 'Youth Empowerment & Competitive Leadership',
            'description_id' => 'Pelatihan kepemimpinan dan inkubasi talenta pemuda.',
            'description_en' => 'Leadership training and youth talent incubation.',
            'why_it_matters_id' => 'Kesenjangan akses pengembangan kepemimpinan di pelosok tanah air.',
            'why_it_matters_en' => 'Leadership opportunity disparities across remote frontiers.',
            'what_we_do_id' => 'Pelatihan intensif dan pendampingan inkubasi proyek perintis.',
            'what_we_do_en' => 'Intensive field training and social venture acceleration.',
            'sdgs_raw' => "SDG 4: Pendidikan Berkualitas\nSDG 8: Pekerjaan Layak",
            'global_programs_raw' => 'UN Youth 2030 Strategy',
            'national_programs_raw' => "Asta Cita: Pembangunan SDM Unggul\nRPJMN 2025-2029",
            'target_beneficiaries' => 'Pemuda desa usia 17-28 tahun',
            'youtube_url' => 'https://www.youtube.com/watch?v=f7_S05eN39I',
            'metric_value' => '25.000+',
            'metric_label_id' => 'Alumni Terbina',
            'metric_label_en' => 'Coached Alumni',
            'target_url' => 'https://siyota.org/pillars/youth-development',
            'action_label' => 'Jelajahi di SIYOTA ↗',
            'gallery_raw' => "https://images.unsplash.com/photo-1\nhttps://images.unsplash.com/photo-2",
            'gallery_files' => [$newGalleryFile],
            'sort_order' => 1,
            'is_active' => 1,
        ]);

        $response->assertRedirect('/admin/ecosystem?tab=impact');

        $pillar->refresh();
        $this->assertEquals('YOUTH EMPOWERMENT', $pillar->name);
        $this->assertEquals('https://www.youtube.com/watch?v=f7_S05eN39I', $pillar->youtube_url);
        $this->assertEquals('https://www.youtube-nocookie.com/embed/f7_S05eN39I?rel=0', $pillar->youtube_embed_url);
        $this->assertEquals('25.000+', $pillar->metric_value);
        $this->assertEquals('Alumni Terbina', $pillar->metric_label_id);
        $this->assertEquals('Kesenjangan akses pengembangan kepemimpinan di pelosok tanah air.', $pillar->why_it_matters_id);
        $this->assertEquals('Pelatihan intensif dan pendampingan inkubasi proyek perintis.', $pillar->what_we_do_id);
        $this->assertCount(2, $pillar->sdgs);
        $this->assertCount(2, $pillar->national_programs);
        $this->assertCount(3, $pillar->gallery);
    }

    public function test_public_pillar_detail_page_is_accessible_and_displays_full_profile(): void
    {
        $response = $this->get('/dampak/pilar/youth-development');

        $response->assertStatus(200);
        $response->assertSee('YOUTH DEVELOPMENT');
        $response->assertSee('Pengembangan Pemuda & Kepemimpinan Masa Depan');
        $response->assertSee('Kenapa Ada Pilar Ini?');
        $response->assertSee('Aksi Lapangan: Kita Ngapain?');
        $response->assertSee('SDGs PBB Terkait');
        $response->assertSee('SDG 4: Pendidikan Berkualitas');
        $response->assertSee('Agenda Nasional RI');
        $response->assertSee('Asta Cita');
        $response->assertSee('https://siyota.org');
        $response->assertSee('youtube-nocookie.com/embed');
    }
}
