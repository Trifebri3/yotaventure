<?php

namespace Tests\Feature;

use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LegalRoutesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test terms and conditions page loads successfully.
     */
    public function test_terms_page_loads_successfully(): void
    {
        $response = $this->get(route('public.legal.terms'));

        $response->assertStatus(200);
        $response->assertSee('Syarat & Ketentuan Penggunaan Layanan', false);
        $response->assertSee('Terms & Conditions of Service', false);
        $response->assertSee('PT Yota Inovasi Nusantara');
    }

    /**
     * Test privacy policy page loads successfully with UU PDP compliance.
     */
    public function test_privacy_page_loads_successfully(): void
    {
        $response = $this->get(route('public.legal.privacy'));

        $response->assertStatus(200);
        $response->assertSee('Kebijakan Privasi & Tata Kelola Data Pribadi', false);
        $response->assertSee('UU No. 27/2022');
        $response->assertSee('dpo@yotainovasi.id');
    }

    /**
     * Test information security page loads successfully.
     */
    public function test_security_page_loads_successfully(): void
    {
        $response = $this->get(route('public.legal.security'));

        $response->assertStatus(200);
        $response->assertSee('ISO/IEC 27001');
        $response->assertSee('SOC-OPERATIONAL');
        $response->assertSee('security@yotainovasi.id');
    }

    /**
     * Test alias redirects work as expected.
     */
    public function test_legal_route_redirects(): void
    {
        $this->get('/terms')->assertRedirect('/syarat-ketentuan');
        $this->get('/terms-and-conditions')->assertRedirect('/syarat-ketentuan');

        $this->get('/privacy')->assertRedirect('/kebijakan-privasi');
        $this->get('/privacy-policy')->assertRedirect('/kebijakan-privasi');

        $this->get('/security')->assertRedirect('/keamanan-informasi');
        $this->get('/keamanan')->assertRedirect('/keamanan-informasi');
        $this->get('/information-security')->assertRedirect('/keamanan-informasi');
    }

    /**
     * Test Article bilingual helper methods work.
     */
    public function test_article_bilingual_helper_methods(): void
    {
        $article = Article::create([
            'title' => 'Judul Bahasa Indonesia',
            'title_en' => 'English Article Title',
            'slug' => 'judul-bahasa-indonesia',
            'tag' => 'Riset',
            'tag_en' => 'Research',
            'badge' => 'Terbitan',
            'badge_en' => 'Publication',
            'excerpt' => 'Ringkasan artikel dalam bahasa Indonesia.',
            'excerpt_en' => 'English summary of the article.',
            'content' => '<p>Konten bahasa Indonesia.</p>',
            'content_en' => '<p>English article content.</p>',
            'status' => 'published',
            'published_at' => now(),
        ]);

        $this->assertSame('Judul Bahasa Indonesia', $article->getTitle('id'));
        $this->assertSame('English Article Title', $article->getTitle('en'));
        $this->assertSame('Riset', $article->getTag('id'));
        $this->assertSame('Research', $article->getTag('en'));
        $this->assertSame('Terbitan', $article->getBadge('id'));
        $this->assertSame('Publication', $article->getBadge('en'));
        $this->assertSame('Ringkasan artikel dalam bahasa Indonesia.', $article->getExcerpt('id'));
        $this->assertSame('English summary of the article.', $article->getExcerpt('en'));
        $this->assertSame('<p>Konten bahasa Indonesia.</p>', $article->getContent('id'));
        $this->assertSame('<p>English article content.</p>', $article->getContent('en'));
    }
}
