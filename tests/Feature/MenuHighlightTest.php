<?php

namespace Tests\Feature;

use App\Models\MenuHighlight;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MenuHighlightTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that homepage renders active menu highlights from the database.
     */
    public function test_homepage_displays_database_menu_highlights(): void
    {
        $highlight = MenuHighlight::create([
            'title_id' => 'KEDAULATAN NUSANTARA',
            'title_en' => 'NUSANTARA SOVEREIGNTY',
            'badge_id' => '01 • TEKNOLOGI',
            'badge_en' => '01 • TECH',
            'subtitle_id' => 'Riset & Hilirisasi',
            'subtitle_en' => 'Research & Production',
            'image_url' => 'https://example.com/test-photo.jpg',
            'link_url' => '#inisiatif-unggulan',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('KEDAULATAN NUSANTARA');
        $response->assertSee('https://example.com/test-photo.jpg');
    }

    /**
     * Test that guest is redirected away from admin menu highlights.
     */
    public function test_guest_cannot_access_menu_highlights_admin(): void
    {
        $response = $this->get(route('admin.menu-highlights.index'));

        $response->assertRedirect(route('login'));
    }

    /**
     * Test that authenticated user can update a menu highlight photo and details.
     */
    public function test_authenticated_user_can_update_menu_highlight(): void
    {
        $user = User::factory()->create();

        $highlight = MenuHighlight::create([
            'title_id' => 'JUDUL LAMA',
            'title_en' => 'OLD TITLE',
            'badge_id' => '01 • PILAR',
            'badge_en' => '01 • PILLAR',
            'subtitle_id' => 'Sub lama',
            'subtitle_en' => 'Old sub',
            'image_url' => 'https://example.com/old.jpg',
            'link_url' => '#ecosystem',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $response = $this->actingAs($user)->put(route('admin.menu-highlights.update', $highlight->id), [
            'title_id' => 'INOVASI TERBARU',
            'title_en' => 'LATEST INNOVATION',
            'badge_id' => '01 • UTAMA',
            'badge_en' => '01 • PRIMARY',
            'subtitle_id' => 'Sub baru',
            'subtitle_en' => 'New sub',
            'image_url' => 'https://example.com/new-database-photo.jpg',
            'link_url' => '#inisiatif-unggulan',
            'is_active' => '1',
        ]);

        $response->assertRedirect(route('admin.menu-highlights.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('menu_highlights', [
            'id' => $highlight->id,
            'title_id' => 'INOVASI TERBARU',
            'image_url' => 'https://example.com/new-database-photo.jpg',
        ]);
    }
}
