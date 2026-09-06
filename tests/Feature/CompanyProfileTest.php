<?php

namespace Tests\Feature;

use App\Models\CompanyProfile;
use App\Models\EcosystemClient;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CompanyProfileTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test public company profile page loads dynamic content and clients without error.
     */
    public function test_public_company_profile_page_loads_successfully(): void
    {
        EcosystemClient::create([
            'name' => 'Mitra Strategis Nusantara',
            'slug' => 'mitra-strategis-nusantara',
            'client_type' => 'Enterprise',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        $profile = CompanyProfile::getProfile();
        $profile->update([
            'tagline' => 'Inovasi Nyata Masa Depan Indonesia',
            'content_html' => '<h2>Misi Kedaulatan</h2><p>Kami terus bergerak membangun ekosistem digital nasional.</p>',
        ]);

        $response = $this->get(route('public.about.profile'));

        $response->assertStatus(200);
        $response->assertSee('PT Yota Inovasi Nusantara');
        $response->assertSee('Inovasi Nyata Masa Depan Indonesia');
        $response->assertSee('Misi Kedaulatan');
    }

    /**
     * Test admin company profile page requires authentication.
     */
    public function test_admin_company_profile_page_requires_auth(): void
    {
        $response = $this->get(route('admin.company-profile.edit'));

        $response->assertRedirect(route('login'));
    }

    /**
     * Test authenticated admin can view company profile edit form.
     */
    public function test_admin_can_view_company_profile_edit_form(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.company-profile.edit'));

        $response->assertStatus(200);
        $response->assertSee('Kelola Profil Perusahaan');
        $response->assertSee('PT Yota Inovasi Nusantara');
    }

    /**
     * Test authenticated admin can update company profile.
     */
    public function test_admin_can_update_company_profile(): void
    {
        $user = User::factory()->create();

        $payload = [
            'hero_badge' => 'PROFIL RESMI TERKINI',
            'company_name' => 'PT Yota Inovasi Nusantara',
            'tagline' => 'Membangun Kedaulatan Teknologi',
            'summary' => 'Ringkasan profil perusahaan baru untuk ekosistem.',
            'content_html' => '<h2>Sejarah Perusahaan</h2><p>Berdiri sejak tahun 2024 dengan komitmen kebangsaan.</p>',
            'legal_entity_name' => 'PT Yota Inovasi Nusantara',
            'legal_registration_info' => 'SK Kemenkumham Terdaftar No. AHU-001.',
            'office_address' => 'Bandung, Jawa Barat',
            'contact_email' => 'contact@yotainovasi.id',
            'contact_phone' => '08123456789',
            'highlights' => [
                [
                    'number' => '01',
                    'title' => 'Riset Berdaulat',
                    'description' => 'Fokus pengembangan teknologi lokal.',
                ],
            ],
            'meta_title' => 'Profil PT Yota Inovasi',
            'meta_description' => 'Ringkasan meta profil.',
        ];

        $response = $this->actingAs($user)->put(route('admin.company-profile.update'), $payload);

        $response->assertRedirect(route('admin.company-profile.edit'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('company_profiles', [
            'tagline' => 'Membangun Kedaulatan Teknologi',
            'contact_email' => 'contact@yotainovasi.id',
        ]);
    }

    /**
     * Test admin can upload image for Quill rich editor.
     */
    public function test_admin_can_upload_image_via_ajax(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();

        $image = UploadedFile::fake()->image('profile_diagram.png', 800, 600);

        $response = $this->actingAs($user)->postJson(route('admin.company-profile.upload-image'), [
            'image' => $image,
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'url',
        ]);

        $this->assertTrue($response->json('success'));
    }
}
