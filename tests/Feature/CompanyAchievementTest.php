<?php

namespace Tests\Feature;

use App\Models\CompanyAchievement;
use App\Models\CompanyProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CompanyAchievementTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test public achievements page loads successfully.
     */
    public function test_public_achievements_page_loads_successfully(): void
    {
        CompanyAchievement::create([
            'title' => 'Sertifikasi ISO 27001 Keamanan Data',
            'category' => 'Sertifikasi',
            'issuer' => 'Lembaga Sertifikasi Internasional',
            'year' => '2025',
            'is_active' => true,
        ]);

        $response = $this->get(route('public.about.achievements'));

        $response->assertStatus(200);
        $response->assertSee('Sertifikasi ISO 27001 Keamanan Data');
        $response->assertSee('Lembaga Sertifikasi Internasional');
    }

    /**
     * Test public story legacy alias loads successfully.
     */
    public function test_public_story_route_loads_successfully(): void
    {
        CompanyAchievement::create([
            'title' => 'Penghargaan Inovasi Nasional BRIN',
            'category' => 'Penghargaan',
            'issuer' => 'BRIN',
            'year' => '2025',
            'is_active' => true,
        ]);

        $response = $this->get(route('public.about.story'));

        $response->assertStatus(200);
        $response->assertSee('Penghargaan Inovasi Nasional BRIN');
    }

    /**
     * Test admin achievements index requires authentication.
     */
    public function test_admin_achievements_requires_authentication(): void
    {
        $response = $this->get(route('admin.achievements.index'));

        $response->assertRedirect(route('login'));
    }

    /**
     * Test authenticated admin can view achievements management index.
     */
    public function test_authenticated_admin_can_view_achievements_index(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.achievements.index'));

        $response->assertStatus(200);
        $response->assertSee('Kelola Pencapaian, Penghargaan & Sertifikasi', false);
    }

    /**
     * Test authenticated admin can store a new achievement.
     */
    public function test_admin_can_store_new_achievement(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();

        $file = UploadedFile::fake()->image('cert.png', 600, 400);

        $payload = [
            'title' => 'Penghargaan Kedaulatan Digital',
            'category' => 'Penghargaan',
            'issuer' => 'Kementerian Komunikasi dan Digital',
            'year' => '2025',
            'description' => 'Apresiasi atas arsitektur cloud mandiri.',
            'credential_url' => 'https://yotainovasi.id/verifikasi',
            'badge_label' => 'Nasional',
            'sort_order' => 1,
            'is_featured' => 1,
            'is_active' => 1,
            'image_file' => $file,
        ];

        $response = $this->actingAs($user)->post(route('admin.achievements.store'), $payload);

        $response->assertRedirect(route('admin.achievements.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('company_achievements', [
            'title' => 'Penghargaan Kedaulatan Digital',
            'issuer' => 'Kementerian Komunikasi dan Digital',
            'badge_label' => 'Nasional',
        ]);
    }

    /**
     * Test authenticated admin can update an existing achievement.
     */
    public function test_admin_can_update_existing_achievement(): void
    {
        $user = User::factory()->create();
        $achievement = CompanyAchievement::create([
            'title' => 'Judul Lama',
            'category' => 'Penghargaan',
            'is_active' => true,
        ]);

        $payload = [
            'title' => 'Judul Baru yang Diperbarui',
            'category' => 'Sertifikasi',
            'issuer' => 'Badan Standarisasi Nasional',
            'year' => '2026',
            'description' => 'Deskripsi sertifikasi yang diperbarui.',
            'sort_order' => 2,
            'is_active' => 1,
        ];

        $response = $this->actingAs($user)->put(route('admin.achievements.update', $achievement->id), $payload);

        $response->assertRedirect(route('admin.achievements.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('company_achievements', [
            'id' => $achievement->id,
            'title' => 'Judul Baru yang Diperbarui',
            'category' => 'Sertifikasi',
        ]);
    }

    /**
     * Test authenticated admin can delete an achievement.
     */
    public function test_admin_can_delete_achievement(): void
    {
        $user = User::factory()->create();
        $achievement = CompanyAchievement::create([
            'title' => 'Sertifikat Dihapus',
            'category' => 'Prestasi',
            'is_active' => true,
        ]);

        $response = $this->actingAs($user)->delete(route('admin.achievements.destroy', $achievement->id));

        $response->assertRedirect(route('admin.achievements.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('company_achievements', [
            'id' => $achievement->id,
        ]);
    }

    /**
     * Test authenticated admin can update narrative overview for achievements page.
     */
    public function test_admin_can_update_narrative_overview(): void
    {
        $user = User::factory()->create();
        CompanyProfile::getProfile();

        $payload = [
            'achievement_badge' => 'STANDAR & PENGAKUAN',
            'achievement_title' => 'Katalog Rekognisi Resmi',
            'achievement_summary' => 'Ringkasan narasi pencapaian baru.',
            'achievement_content_html' => '<h2>Tonggak Kedaulatan</h2><p>Rekam jejak inovasi yang terverifikasi.</p>',
        ];

        $response = $this->actingAs($user)->put(route('admin.achievements.narrative'), $payload);

        $response->assertRedirect(route('admin.achievements.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('company_profiles', [
            'achievement_title' => 'Katalog Rekognisi Resmi',
            'achievement_badge' => 'STANDAR & PENGAKUAN',
        ]);
    }

    /**
     * Test authenticated admin can upload image via AJAX for narrative editor.
     */
    public function test_admin_can_upload_quill_image(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();

        $image = UploadedFile::fake()->image('plaque.jpg', 640, 480);

        $response = $this->actingAs($user)->postJson(route('admin.achievements.upload-image'), [
            'image' => $image,
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['success', 'url']);
        $this->assertTrue($response->json('success'));
    }

    /**
     * Test authenticated admin can store achievement with multiple photos.
     */
    public function test_admin_can_store_achievement_with_multiple_photos(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();

        $photo1 = UploadedFile::fake()->image('photo1.jpg', 800, 600);
        $photo2 = UploadedFile::fake()->image('photo2.jpg', 800, 600);

        $payload = [
            'title' => 'Dokumentasi Pemuda Pelopor 3 Foto',
            'category' => 'Penghargaan',
            'photos_files' => [$photo1, $photo2],
            'description' => 'Momen foto banyak piala dan panggung.',
        ];

        $response = $this->actingAs($user)->post(route('admin.achievements.store'), $payload);

        $response->assertRedirect(route('admin.achievements.index'));
        $achievement = CompanyAchievement::where('title', 'Dokumentasi Pemuda Pelopor 3 Foto')->first();
        $this->assertNotNull($achievement);
        $this->assertCount(2, $achievement->photos);
        $this->assertCount(2, $achievement->all_photos);
    }
}
