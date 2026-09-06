<?php

namespace Tests\Feature;

use App\Models\CompanyProfile;
use App\Models\EcosystemDomain;
use App\Models\EcosystemInitiative;
use App\Models\EcosystemProduct;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class InvestTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test public invest page loads successfully and displays manifesto sections.
     */
    public function test_public_invest_page_loads_successfully(): void
    {
        $response = $this->get(route('public.about.invest'));

        $response->assertStatus(200);
        $response->assertSee('Building Companies From the Ground Up');
        $response->assertSee('YOIN Inovasi Nusantara');
        $response->assertSee('WHY YOIN, WHY NOW');
        $response->assertSee('OUR THESIS');
        $response->assertSee('ONE ECOSYSTEM. DIFFERENT BETS.');
        $response->assertSee('OUR TRACTION');
        $response->assertSee('FROM A SMALL PLACE TO A BIGGER POSSIBILITY');
        $response->assertSee('THE PEOPLE BEHIND THE BETS');
        $response->assertSee('WHY WE ARE DIFFERENT');
        $response->assertSee('OUR IMPACT');
        $response->assertSee('THE YOIN FLYWHEEL');
        $response->assertSee('INVESTOR RESOURCES');
        $response->assertSee('We are still building.');
    }

    /**
     * Test admin invest edit page requires authentication.
     */
    public function test_admin_invest_requires_authentication(): void
    {
        $response = $this->get(route('admin.invest.edit'));

        $response->assertRedirect(route('login'));
    }

    /**
     * Test authenticated admin can view invest edit page with Quill editor.
     */
    public function test_authenticated_admin_can_view_invest_edit(): void
    {
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)->get(route('admin.invest.edit'));

        $response->assertStatus(200);
        $response->assertSee('Venture Builder');
        $response->assertSee('quill-editor');
    }

    /**
     * Test authenticated admin can update invest content and metrics.
     */
    public function test_authenticated_admin_can_update_invest_content(): void
    {
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)->put(route('admin.invest.update'), [
            'invest_badge' => 'CUSTOM INVESTOR ECOSYSTEM',
            'invest_title' => 'Venture Architecture for Nusantara',
            'invest_subtitle' => 'Building High-Conviction Startups',
            'invest_summary' => 'Updated summary manifesto text.',
            'invest_content_html' => '<h3>Custom Investment Thesis</h3><p>Detailed notes here.</p>',
            'invest_deck_url' => 'https://example.com/deck.pdf',
            'invest_data_room_url' => 'https://example.com/dataroom',
            'invest_metrics' => [
                ['key' => 'projects_delivered', 'label' => 'Total Projects Delivered', 'value' => '42+'],
                ['key' => 'active_ventures', 'label' => 'Active Ecosystem Ventures', 'value' => '8'],
            ],
            'invest_resources' => [
                [
                    'title' => 'Pitch Deck 2026',
                    'description' => 'Comprehensive pitch deck.',
                    'action_label' => 'Download Now',
                    'url' => '#deck',
                    'type' => 'deck',
                ],
            ],
        ]);

        $response->assertRedirect(route('admin.invest.edit'));
        $response->assertSessionHas('success');

        $profile = CompanyProfile::getProfile();
        $this->assertEquals('Venture Architecture for Nusantara', $profile->invest_title);
        $this->assertEquals('CUSTOM INVESTOR ECOSYSTEM', $profile->invest_badge);
        $this->assertStringContainsString('Custom Investment Thesis', $profile->invest_content_html);

        // Verify public page reflects updated data
        $publicResponse = $this->get(route('public.about.invest'));
        $publicResponse->assertStatus(200);
        $publicResponse->assertSee('Venture Architecture for Nusantara');
        $publicResponse->assertSee('42+');
        $publicResponse->assertSee('Total Projects Delivered');
    }

    /**
     * Test image upload endpoint for invest Quill rich text editor.
     */
    public function test_admin_can_upload_image_for_invest_editor(): void
    {
        Storage::fake('public');
        $admin = User::factory()->create();

        $file = UploadedFile::fake()->image('diagram.png', 800, 600);

        $response = $this->actingAs($admin)->postJson(route('admin.invest.upload-image'), [
            'image' => $file,
        ]);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
        $this->assertNotEmpty($response->json('url'));
    }

    /**
     * Test public invest page displays synchronized products and domain issues.
     */
    public function test_public_invest_displays_synchronized_products_and_domain_issues(): void
    {
        $domain = EcosystemDomain::create([
            'name_id' => 'Domain Uji Coba',
            'name_en' => 'Test Domain',
            'slug' => 'domain-uji-coba',
            'problem_statement_id' => 'Masalah riil yang dihadapi petani kecil.',
            'problem_statement_en' => 'Real problem faced by smallholder farmers.',
            'issues' => [
                ['issue' => 'Fluktuasi harga tinggi', 'solution' => 'Platform transparansi pasar'],
            ],
            'status' => 'OPERATING',
            'visibility' => 'public',
            'sort_order' => 1,
        ]);

        $initiative = EcosystemInitiative::create([
            'domain_id' => $domain->id,
            'name' => 'Ventura Tani Nusantara',
            'slug' => 'ventura-tani',
            'status' => 'OPERATING',
            'visibility' => 'public',
            'tagline_id' => 'Membangun masa depan agrikultur modern.',
            'problem_statement_id' => 'Rantai pasok panjang yang merugikan produsen hulu.',
            'sort_order' => 1,
        ]);

        $product = EcosystemProduct::create([
            'initiative_id' => $initiative->id,
            'name' => 'AgriSensor IoT Pro',
            'slug' => 'agrisensor-iot-pro',
            'type' => 'IoT Hardware & SaaS',
            'problem_statement_id' => 'Ketiadaan telemetri tanah waktu riil.',
            'problem_statement_en' => 'Lack of real-time soil telemetry.',
            'solution_statement_id' => 'Sensor hara tanah mikro berbiaya rendah.',
            'solution_statement_en' => 'Low-cost micro nutrient sensors.',
            'description_id' => 'Perangkat pemantau nutrisi tanah presisi.',
            'description_en' => 'Precision soil monitoring hardware.',
            'status' => 'OPERATING',
            'visibility' => 'public',
            'sort_order' => 1,
        ]);

        $response = $this->get(route('public.about.invest'));
        $response->assertStatus(200);
        $response->assertSee('Domain Uji Coba');
        $response->assertSee('Masalah riil yang dihadapi petani kecil.');
        $response->assertSee('Fluktuasi harga tinggi');
        $response->assertSee('Platform transparansi pasar');
        $response->assertSee('Ventura Tani Nusantara');
        $response->assertSee('AgriSensor IoT Pro');
        $response->assertSee('Ketiadaan telemetri tanah waktu riil.');
        $response->assertSee('Sensor hara tanah mikro berbiaya rendah.');
    }

    /**
     * Test authenticated admin can create, update, and delete ecosystem products.
     */
    public function test_authenticated_admin_can_crud_ecosystem_product(): void
    {
        $admin = User::factory()->create();

        $domain = EcosystemDomain::create([
            'name_id' => 'Domain Teknologi',
            'name_en' => 'Technology Domain',
            'slug' => 'domain-teknologi',
            'status' => 'OPERATING',
            'visibility' => 'public',
            'sort_order' => 1,
        ]);

        $initiative = EcosystemInitiative::create([
            'domain_id' => $domain->id,
            'name' => 'YOIN Tech Hub',
            'slug' => 'yoin-tech-hub',
            'status' => 'OPERATING',
            'visibility' => 'public',
            'sort_order' => 1,
        ]);

        // Create
        $response = $this->actingAs($admin)->post(route('admin.ecosystem.products.store'), [
            'initiative_id' => $initiative->id,
            'name' => 'DataFlow Engine',
            'type' => 'Data Platform',
            'problem_statement_id' => 'Silo data antar-kementerian yang menghambat koordinasi.',
            'solution_statement_id' => 'Integrasi API satu pintu dengan protokol terenkripsi.',
            'description_id' => 'Engine perpipaan data cepat untuk skala besar.',
            'status' => 'BUILDING',
            'visibility' => 'public',
            'sort_order' => 1,
        ]);

        $response->assertRedirect(route('admin.ecosystem.index', ['tab' => 'products']));
        $this->assertDatabaseHas('ecosystem_products', [
            'name' => 'DataFlow Engine',
            'type' => 'Data Platform',
            'problem_statement_id' => 'Silo data antar-kementerian yang menghambat koordinasi.',
        ]);

        $product = EcosystemProduct::where('name', 'DataFlow Engine')->first();

        // Update
        $updateResponse = $this->actingAs($admin)->put(route('admin.ecosystem.products.update', $product), [
            'initiative_id' => $initiative->id,
            'name' => 'DataFlow Engine Pro',
            'slug' => $product->slug,
            'type' => 'Enterprise Data Platform',
            'problem_statement_id' => 'Silo data yang telah diperbarui.',
            'solution_statement_id' => 'Solusi terpadu cloud-native.',
            'status' => 'OPERATING',
            'visibility' => 'public',
            'sort_order' => 2,
        ]);

        $updateResponse->assertRedirect(route('admin.ecosystem.index', ['tab' => 'products']));
        $this->assertDatabaseHas('ecosystem_products', [
            'id' => $product->id,
            'name' => 'DataFlow Engine Pro',
            'status' => 'OPERATING',
        ]);

        // Delete
        $deleteResponse = $this->actingAs($admin)->delete(route('admin.ecosystem.products.destroy', $product));
        $deleteResponse->assertRedirect(route('admin.ecosystem.index', ['tab' => 'products']));
        $this->assertDatabaseMissing('ecosystem_products', [
            'id' => $product->id,
        ]);
    }
}
