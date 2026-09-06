<?php

namespace Tests\Feature;

use App\Models\ArticleCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArticleCategoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that publications page renders Dayan-style categories from database.
     */
    public function test_publications_page_displays_database_categories(): void
    {
        $cat = ArticleCategory::create([
            'slug' => 'inisiatif',
            'name_id' => 'INISIATIF UNGGULAN',
            'name_en' => 'FEATURED INITIATIVES',
            'subtitle_id' => 'Kedaulatan Energi & Teknologi',
            'subtitle_en' => 'Energy Sovereignty & Tech',
            'image_url' => 'https://example.com/cat-photo.jpg',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $response = $this->get('/publikasi');

        $response->assertStatus(200);
        $response->assertSee('INISIATIF UNGGULAN');
        $response->assertSee('Kedaulatan Energi &amp; Teknologi', false);
        $response->assertSee('https://example.com/cat-photo.jpg');
    }

    /**
     * Test that clicking a category filters the articles by type.
     */
    public function test_filtering_by_category_type(): void
    {
        ArticleCategory::create([
            'slug' => 'jurnal',
            'name_id' => 'JURNAL RISET',
            'name_en' => 'RESEARCH JOURNALS',
            'sort_order' => 2,
            'is_active' => true,
        ]);

        $response = $this->get('/publikasi?type=jurnal');

        $response->assertStatus(200);
        $response->assertSee('JURNAL RISET');
    }

    /**
     * Test that authenticated admin can update category photo and details.
     */
    public function test_authenticated_user_can_update_category_photo(): void
    {
        $user = User::factory()->create();

        $cat = ArticleCategory::create([
            'slug' => 'artikel',
            'name_id' => 'ARTIKEL LAMA',
            'name_en' => 'OLD ARTICLES',
            'subtitle_id' => 'Keterangan Lama',
            'subtitle_en' => 'Old Subtitle',
            'image_url' => 'https://example.com/old.jpg',
            'sort_order' => 4,
            'is_active' => true,
        ]);

        $response = $this->actingAs($user)->put(route('admin.article-categories.update', $cat), [
            'name_id' => 'ARTIKEL & BLOG BARU',
            'name_en' => 'NEW ARTICLES & BLOG',
            'subtitle_id' => 'Keterangan Baru Terpadu',
            'subtitle_en' => 'New Unified Subtitle',
            'image_url' => 'https://example.com/new-photo.jpg',
            'sort_order' => 4,
            'is_active' => 1,
        ]);

        $response->assertRedirect(route('admin.articles.index', ['tab' => 'categories']));

        $this->assertDatabaseHas('article_categories', [
            'id' => $cat->id,
            'name_id' => 'ARTIKEL & BLOG BARU',
            'image_url' => 'https://example.com/new-photo.jpg',
        ]);
    }

    /**
     * Test that authenticated admin can create a new category in database.
     */
    public function test_authenticated_admin_can_create_new_category(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('admin.article-categories.store'), [
            'name_id' => 'Studi Kasus',
            'name_en' => 'Case Studies',
            'slug' => 'studi-kasus',
            'subtitle_id' => 'Implementasi Solusi Industri',
            'subtitle_en' => 'Industry Solution Implementation',
            'image_url' => 'https://images.unsplash.com/photo-1507668077129-56e32842fceb',
            'sort_order' => 5,
        ]);

        $response->assertRedirect(route('admin.articles.index', ['tab' => 'categories']));
        $this->assertDatabaseHas('article_categories', [
            'slug' => 'studi-kasus',
            'name_id' => 'Studi Kasus',
            'name_en' => 'Case Studies',
        ]);
    }

    /**
     * Test that admin articles index dynamically renders database categories in the filter dropdown and Tab 2.
     */
    public function test_admin_articles_index_renders_dynamic_categories_and_tab(): void
    {
        $user = User::factory()->create();

        $cat = ArticleCategory::create([
            'slug' => 'inovasi-khusus',
            'name_id' => 'INOVASI KHUSUS',
            'name_en' => 'SPECIAL INNOVATION',
            'subtitle_id' => 'Kategori Baru',
            'subtitle_en' => 'New Category',
            'image_url' => 'https://example.com/inovasi.jpg',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $response = $this->actingAs($user)->get(route('admin.articles.index'));

        $response->assertStatus(200);
        // Verify category is in the filter select dropdown
        $response->assertSee('value="inovasi-khusus"', false);
        $response->assertSee('INOVASI KHUSUS');
        // Verify Tab 2 contains the category and the creation form
        $response->assertSee('Tambah Kategori Baru di Database');
        $response->assertSee('Slug: inovasi-khusus', false);
    }

    /**
     * Test that admin article create form dynamically contains database categories.
     */
    public function test_admin_article_create_form_contains_database_categories(): void
    {
        $user = User::factory()->create();

        ArticleCategory::create([
            'slug' => 'kategori-uji',
            'name_id' => 'KATEGORI UJI',
            'name_en' => 'TEST CATEGORY',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $response = $this->actingAs($user)->get(route('admin.articles.create'));

        $response->assertStatus(200);
        $response->assertSee('value="kategori-uji"', false);
        $response->assertSee('KATEGORI UJI');
    }

    /**
     * Test that authenticated admin can delete a category.
     */
    public function test_authenticated_admin_can_delete_category(): void
    {
        $user = User::factory()->create();

        $cat = ArticleCategory::create([
            'slug' => 'kategori-hapus',
            'name_id' => 'HAPUS SAYA',
            'name_en' => 'DELETE ME',
            'sort_order' => 99,
            'is_active' => true,
        ]);

        $response = $this->actingAs($user)->delete(route('admin.article-categories.destroy', $cat));

        $response->assertRedirect(route('admin.articles.index', ['tab' => 'categories']));
        $this->assertDatabaseMissing('article_categories', [
            'id' => $cat->id,
        ]);
    }
}
