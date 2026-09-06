<?php

namespace Tests\Feature;

use App\Models\Collaboration;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CollaborationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that public collaboration hub renders tracks and email information.
     */
    public function test_collaboration_hub_renders_tracks(): void
    {
        $collab = Collaboration::create([
            'slug' => 'kemitraan',
            'title_id' => 'Kemitraan Strategis',
            'title_en' => 'Strategic Partnership',
            'badge_id' => 'KORPORASI & PEMERINTAH',
            'badge_en' => 'CORPORATE & GOVERNMENT',
            'subtitle_id' => 'Sinergi multipihak untuk hilirisasi teknologi.',
            'subtitle_en' => 'Multi-stakeholder synergy.',
            'description_id' => 'Deskripsi kemitraan terpadu.',
            'terms_id' => ['Entitas berbadan hukum resmi PT/Yayasan.'],
            'requirements_id' => ['Company Profile terbaru.'],
            'steps_id' => [['step' => '01', 'title' => 'Tahap Berkas', 'desc' => 'Kirim email']],
            'email_to' => 'hello@yotainovasi.id',
            'email_subject' => '[PENGAJUAN KEMITRAAN] - PT Maju',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $response = $this->get('/kolaborasi');

        $response->assertStatus(200);
        $response->assertSee('Kemitraan Strategis');
        $response->assertSee('hello@yotainovasi.id');
        $response->assertSee('Company Profile terbaru.');
    }

    /**
     * Test that guest cannot access admin collaboration manager.
     */
    public function test_guest_cannot_access_admin_collaborations(): void
    {
        $response = $this->get(route('admin.collaborations.index'));

        $response->assertRedirect(route('login'));
    }

    /**
     * Test that authenticated user can update collaboration track requirements.
     */
    public function test_authenticated_user_can_update_collaboration_track(): void
    {
        $user = User::factory()->create();

        $collab = Collaboration::create([
            'slug' => 'magang',
            'title_id' => 'Magang Awal',
            'title_en' => 'Old Internship',
            'badge_id' => 'MAHASISWA',
            'badge_en' => 'STUDENTS',
            'email_to' => 'hello@yotainovasi.id',
            'sort_order' => 2,
            'is_active' => true,
        ]);

        $response = $this->actingAs($user)->put(route('admin.collaborations.update', $collab), [
            'title_id' => 'Program Magang Riset Nusantara',
            'title_en' => 'Nusantara Research Internship',
            'badge_id' => 'TALENTA MUDA',
            'badge_en' => 'YOUNG TALENT',
            'subtitle_id' => 'Keterangan baru magang.',
            'subtitle_en' => 'New internship subtitle.',
            'description_id' => 'Deskripsi baru.',
            'description_en' => 'New description.',
            'terms_id_raw' => "Syarat 1\nSyarat 2",
            'terms_en_raw' => "Term 1\nTerm 2",
            'requirements_id_raw' => "CV Terbaru\nPortofolio",
            'requirements_en_raw' => "Latest CV\nPortfolio",
            'email_to' => 'hello@yotainovasi.id',
            'email_subject' => '[PENGAJUAN MAGANG] - Nama',
            'email_template' => 'Isi draf email baru.',
            'sort_order' => 2,
            'is_active' => 1,
        ]);

        $response->assertRedirect(route('admin.collaborations.index', ['tab' => 'tracks']));

        $this->assertDatabaseHas('collaborations', [
            'id' => $collab->id,
            'title_id' => 'Program Magang Riset Nusantara',
        ]);

        $collab->refresh();
        $this->assertEquals(['Syarat 1', 'Syarat 2'], $collab->terms_id);
        $this->assertEquals(['CV Terbaru', 'Portofolio'], $collab->requirements_id);
    }
}
