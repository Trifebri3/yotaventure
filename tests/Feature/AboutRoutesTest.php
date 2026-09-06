<?php

namespace Tests\Feature;

use App\Models\CompanyAchievement;
use App\Models\EcosystemClient;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AboutRoutesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test about hub returns 200.
     */
    public function test_about_index_page_loads_successfully(): void
    {
        $response = $this->get(route('public.about.index'));

        $response->assertStatus(200);
        $response->assertSee('PT Yota Inovasi Nusantara');
    }

    /**
     * Test about profile page loads successfully.
     */
    public function test_about_profile_page_loads_successfully(): void
    {
        EcosystemClient::create([
            'name' => 'Mitra BUMN Rekayasa',
            'slug' => 'mitra-bumn-rekayasa',
            'client_type' => 'Pemerintah & BUMN',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        $response = $this->get(route('public.about.profile'));

        $response->assertStatus(200);
        $response->assertSee('PT Yota Inovasi Nusantara');
        $response->assertSee('Kedaulatan Digital');
    }

    /**
     * Test about invest page loads successfully.
     */
    public function test_about_invest_page_loads_successfully(): void
    {
        $response = $this->get(route('public.about.invest'));

        $response->assertStatus(200);
        $response->assertSee('Investasi');
        $response->assertSee('Sinergi');
    }

    /**
     * Test about achievements page loads successfully.
     */
    public function test_about_achievements_page_loads_successfully(): void
    {
        CompanyAchievement::create([
            'title' => 'Sertifikasi ISO/IEC 27001:2022',
            'category' => 'Sertifikasi',
            'is_active' => true,
        ]);

        $response = $this->get(route('public.about.achievements'));

        $response->assertStatus(200);
        $response->assertSee('Pencapaian');
        $response->assertSee('ISO/IEC 27001:2022');
        $response->assertSee('Sertifikasi');
    }

    /**
     * Test legacy about story route renders successfully as alias.
     */
    public function test_about_story_page_loads_successfully(): void
    {
        $response = $this->get(route('public.about.story'));

        $response->assertStatus(200);
        $response->assertSee('Pencapaian');
    }

    /**
     * Test about redirects.
     */
    public function test_about_shortcut_redirects(): void
    {
        $this->get('/about')->assertRedirect('/tentang-kami');
        $this->get('/profil')->assertRedirect('/tentang-kami/profil');
        $this->get('/invest')->assertRedirect('/tentang-kami/invest');
        $this->get('/story')->assertRedirect('/tentang-kami/pencapaian');
        $this->get('/pencapaian')->assertRedirect('/tentang-kami/pencapaian');
        $this->get('/prestasi')->assertRedirect('/tentang-kami/pencapaian');
        $this->get('/penghargaan')->assertRedirect('/tentang-kami/pencapaian');
        $this->get('/sertifikat')->assertRedirect('/tentang-kami/pencapaian');
    }

    /**
     * Test homepage header contains Tentang Kami dropdown & mega menu items and no stale Inovasi menu.
     */
    public function test_header_contains_tentang_kami_dropdown_and_mega_menu(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee(route('public.about.profile'));
        $response->assertSee(route('public.about.invest'));
        $response->assertSee(route('public.about.achievements'));
        $response->assertDontSee('Kedaulatan Teknologi &amp; Hilirisasi Riset');
        $response->assertDontSee('Kedaulatan Teknologi & Hilirisasi Riset');
    }
}
