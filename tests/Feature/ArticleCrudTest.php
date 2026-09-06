<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ArticleCrudTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create();
    }

    public function test_can_view_articles_index_page(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.articles.index'));
        $response->assertStatus(200);
        $response->assertSeeText('Manajemen Artikel, Publikasi & Riset');
        $response->assertSee('Tulis Publikasi Baru');
    }

    public function test_can_view_create_article_form(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.articles.create'));
        $response->assertStatus(200);
        $response->assertSee('Tulis Artikel, Publikasi atau Jurnal Baru');
        $response->assertSee('quill-editor-en');
        $response->assertSee('quill-toolbar-en');
        $response->assertSee('English Publication Content & Manuscript', false);
    }

    public function test_can_store_new_article(): void
    {
        $category = ArticleCategory::create([
            'slug' => 'jurnal',
            'name_id' => 'Jurnal Riset',
            'name_en' => 'Research Journal',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->admin)->post(route('admin.articles.store'), [
            'title' => 'Judul Artikel Uji CRUD',
            'title_en' => 'CRUD Test Article English Title',
            'type' => 'jurnal',
            'author_name' => 'Tim Pengembang YOIN',
            'content' => '<p>Konten lengkap naskah publikasi uji coba.</p>',
            'content_en' => '<p>Complete publication manuscript in English.</p>',
            'status' => 'published',
            'is_featured' => 1,
            'tag' => 'Inovasi • 2026',
            'tag_en' => 'Innovation • 2026',
            'badge' => 'Terbitan',
            'badge_en' => 'Publication',
            'excerpt' => 'Ringkasan singkat artikel uji coba.',
            'excerpt_en' => 'Short executive summary in English.',
        ]);

        $response->assertRedirect(route('admin.articles.index'));
        $this->assertDatabaseHas('articles', [
            'title' => 'Judul Artikel Uji CRUD',
            'title_en' => 'CRUD Test Article English Title',
            'slug' => 'judul-artikel-uji-crud',
            'type' => 'jurnal',
            'content_en' => '<p>Complete publication manuscript in English.</p>',
            'status' => 'published',
        ]);
    }

    public function test_can_view_edit_article_form(): void
    {
        $article = Article::create([
            'title' => 'Artikel Sebelum Diedit',
            'slug' => 'artikel-sebelum-diedit',
            'type' => 'inisiatif',
            'author_name' => 'Penulis Asli',
            'content' => '<p>Konten lama</p>',
            'status' => 'draft',
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.articles.edit', $article->id));
        $response->assertStatus(200);
        $response->assertSee('Artikel Sebelum Diedit');
    }

    public function test_can_update_article(): void
    {
        $article = Article::create([
            'title' => 'Artikel Lama',
            'slug' => 'artikel-lama',
            'type' => 'artikel',
            'author_name' => 'Penulis',
            'content' => '<p>Konten lama</p>',
            'status' => 'draft',
        ]);

        $response = $this->actingAs($this->admin)->put(route('admin.articles.update', $article->id), [
            'title' => 'Artikel Telah Diperbarui',
            'title_en' => 'Updated Article English Title',
            'slug' => 'artikel-lama',
            'type' => 'artikel',
            'author_name' => 'Penulis Baru',
            'content' => '<p>Konten baru yang sudah diedit.</p>',
            'content_en' => '<p>Updated new English content from rich text editor.</p>',
            'status' => 'published',
        ]);

        $response->assertRedirect(route('admin.articles.index'));
        $this->assertDatabaseHas('articles', [
            'id' => $article->id,
            'title' => 'Artikel Telah Diperbarui',
            'title_en' => 'Updated Article English Title',
            'content_en' => '<p>Updated new English content from rich text editor.</p>',
            'status' => 'published',
        ]);
    }

    public function test_can_delete_article(): void
    {
        $article = Article::create([
            'title' => 'Artikel Mau Dihapus',
            'slug' => 'artikel-mau-dihapus',
            'type' => 'artikel',
            'author_name' => 'Penulis',
            'content' => '<p>Akan segera dihapus.</p>',
            'status' => 'draft',
        ]);

        $response = $this->actingAs($this->admin)->delete(route('admin.articles.destroy', $article->id));
        $response->assertRedirect(route('admin.articles.index'));
        $this->assertDatabaseMissing('articles', [
            'id' => $article->id,
        ]);
    }

    public function test_can_upload_image_for_article(): void
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->image('test_diagram.png', 800, 600);

        $response = $this->actingAs($this->admin)->post(route('admin.articles.upload-image'), [
            'image' => $file,
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);

        $this->assertStringContainsString('/storage/articles/', $response->json('url'));
        Storage::disk('public')->assertExists('articles/'.$file->hashName());
    }

    public function test_cannot_upload_invalid_file_for_article(): void
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->create('malicious.exe', 500);

        $response = $this->actingAs($this->admin)->post(route('admin.articles.upload-image'), [
            'image' => $file,
        ]);

        $response->assertSessionHasErrors('image');
    }

    public function test_unauthenticated_user_cannot_upload_image(): void
    {
        $file = UploadedFile::fake()->image('test.png');

        $response = $this->post(route('admin.articles.upload-image'), [
            'image' => $file,
        ]);

        $response->assertRedirect(route('login'));
    }
}
