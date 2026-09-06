<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\ArticleCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SeoAuditTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_has_comprehensive_seo_meta_tags_and_structured_data(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('<title>', false);
        $response->assertSee('PT Yota Inovasi Nusantara (YOIN)', false);
        $response->assertSee('name="description"', false);
        $response->assertSee('name="keywords"', false);
        $response->assertSee('rel="canonical"', false);
        $response->assertSee('hreflang="id"', false);
        $response->assertSee('hreflang="en"', false);
        $response->assertSee('property="og:site_name"', false);
        $response->assertSee('property="og:title"', false);
        $response->assertSee('name="twitter:card"', false);
        $response->assertSee('application/ld+json', false);
        $response->assertSee('"@type": "Organization"', false);
        $response->assertSee('"@type": "WebSite"', false);
    }

    public function test_sitemap_xml_returns_valid_xml_with_urls(): void
    {
        $category = ArticleCategory::create([
            'slug' => 'teknologi',
            'name_id' => 'Teknologi',
            'name_en' => 'Technology',
            'is_active' => true,
        ]);

        Article::create([
            'title' => 'Uji Validasi Sitemap',
            'slug' => 'uji-validasi-sitemap',
            'content' => '<p>Konten pengujian</p>',
            'category_id' => $category->id,
            'type' => 'Op-Ed',
            'status' => 'published',
            'published_at' => now(),
        ]);

        $response = $this->get('/sitemap.xml');

        $response->assertStatus(200);
        $this->assertStringContainsString('application/xml', $response->headers->get('Content-Type'));
        $response->assertSee('<urlset', false);
        $response->assertSee('/publikasi/uji-validasi-sitemap', false);
        $response->assertSee('/ekosistem', false);
        $response->assertSee('/portofolio', false);
    }

    public function test_robots_txt_disallows_admin_and_contains_sitemap(): void
    {
        $robotsContent = file_get_contents(public_path('robots.txt'));

        $this->assertStringContainsString('Disallow: /admin/', $robotsContent);
        $this->assertStringContainsString('Disallow: /dashboard/', $robotsContent);
        $this->assertStringContainsString('Sitemap: https://yotainovasi.id/sitemap.xml', $robotsContent);
    }

    public function test_article_detail_page_has_article_schema_and_canonical(): void
    {
        $category = ArticleCategory::create([
            'slug' => 'riset',
            'name_id' => 'Riset',
            'name_en' => 'Research',
            'is_active' => true,
        ]);

        $article = Article::create([
            'title' => 'Pilar Kedaulatan AI Indonesia',
            'slug' => 'pilar-kedaulatan-ai-indonesia',
            'content' => '<p>Analisis mendalam</p>',
            'excerpt' => 'Ringkasan artikel riset kedaulatan AI',
            'category_id' => $category->id,
            'type' => 'Jurnal',
            'status' => 'published',
            'published_at' => now(),
        ]);

        $response = $this->get('/publikasi/'.$article->slug);

        $response->assertStatus(200);
        $response->assertSee('<title>'.$article->title, false);
        $response->assertSee('rel="canonical"', false);
        $response->assertSee('"@type": "Article"', false);
        $response->assertSee($article->title, false);
    }
}
