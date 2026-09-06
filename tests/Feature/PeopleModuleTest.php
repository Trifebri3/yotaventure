<?php

namespace Tests\Feature;

use App\Models\EcosystemClient;
use App\Models\EcosystemDomain;
use App\Models\EcosystemInitiative;
use App\Models\FounderStory;
use App\Models\Person;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class PeopleModuleTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    private EcosystemInitiative $initiative;

    private Person $founder;

    private Person $teamMember;

    private Person $contributor;

    private FounderStory $story;

    private EcosystemClient $client;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create();

        $domain = EcosystemDomain::create([
            'name_id' => 'Teknologi Digital & AI',
            'name_en' => 'Digital Tech & AI',
            'slug' => 'teknologi-digital-ai',
            'code' => 'DIGITAL',
            'color' => '#005952',
            'sort_order' => 1,
            'visibility' => 'public',
        ]);

        $this->initiative = EcosystemInitiative::create([
            'domain_id' => $domain->id,
            'name' => 'YOIN Digital Lab',
            'slug' => 'yoin-digital-lab',
            'brand_type' => 'venture',
            'status' => 'operational',
            'visibility' => 'public',
        ]);

        $this->founder = Person::create([
            'category' => 'founder',
            'name' => 'Dr. Rian Ardiansyah',
            'slug' => 'dr-rian-ardiansyah',
            'role_id' => 'Chief Executive Officer & Co-Founder',
            'role_en' => 'Chief Executive Officer',
            'bio_id' => 'Inovator sistem kecerdasan buatan terapan.',
            'bio_en' => 'Applied artificial intelligence innovator.',
            'is_active' => true,
            'visibility' => 'public',
            'social_links' => ['linkedin' => 'https://linkedin.com/in/rian'],
            'meta' => [
                'quote' => 'Membangun kedaulatan riset nasional.',
                'trajectory' => ['2021: Inisiasi Lab Riset', '2024: Skalasi Holding'],
            ],
        ]);

        $this->teamMember = Person::create([
            'category' => 'tim',
            'name' => 'Siti Nurhaliza',
            'slug' => 'siti-nurhaliza',
            'role_id' => 'Head of Agronomy & Precision Biosystems',
            'initiative_id' => $this->initiative->id,
            'is_active' => true,
            'visibility' => 'public',
            'meta' => ['skills' => ['Agronomy', 'IoT']],
        ]);

        $this->contributor = Person::create([
            'category' => 'kontributor',
            'name' => 'Dimas Prasetyo',
            'slug' => 'dimas-prasetyo',
            'role_id' => 'Junior AI Engineer Intern',
            'contribution_type' => 'magang',
            'organization' => 'Institut Teknologi Bandung',
            'period' => 'Batch VI - 2026',
            'is_active' => true,
            'visibility' => 'public',
        ]);

        $this->story = FounderStory::create([
            'person_id' => $this->founder->id,
            'chapter_number' => 'BAB 01',
            'title' => 'Malam-Malam di Laboratorium Kecil',
            'slug' => 'malam-malam-di-laboratorium-kecil',
            'reading_time' => '7 min read',
            'excerpt' => 'Semua bermula dari satu server rakitan di sudut ruangan.',
            'content_html' => '<p>Semua bermula dari satu server rakitan...</p>',
            'status' => 'published',
            'sort_order' => 1,
        ]);

        $this->client = EcosystemClient::create([
            'name' => 'Kementerian Koordinator Pangan',
            'slug' => 'kemenko-pangan',
            'client_type' => 'Pemerintahan',
            'is_active' => true,
            'sort_order' => 1,
        ]);
    }

    /**
     * Test public overview index loads successfully.
     */
    public function test_public_people_overview_loads(): void
    {
        $response = $this->get(route('public.people.index'));

        $response->assertStatus(200);
        $response->assertSee('Dr. Rian Ardiansyah');
        $response->assertSee('Siti Nurhaliza');
        $response->assertSee('Kementerian Koordinator Pangan');
    }

    /**
     * Test public founders directory and detail view.
     */
    public function test_public_founders_directory_and_detail_load(): void
    {
        $indexResponse = $this->get(route('public.people.founder.index'));
        $indexResponse->assertStatus(200);
        $indexResponse->assertSee('Dr. Rian Ardiansyah');
        $indexResponse->assertSee('Chief Executive Officer');

        $showResponse = $this->get(route('public.people.founder.show', $this->founder->slug));
        $showResponse->assertStatus(200);
        $showResponse->assertSee('Membangun kedaulatan riset nasional');
        $showResponse->assertSee('2021: Inisiasi Lab Riset');
    }

    /**
     * Test public novel founder story index and reader view.
     */
    public function test_public_storyfounder_index_and_detail_load(): void
    {
        $indexResponse = $this->get(route('public.people.storyfounder.index'));
        $indexResponse->assertStatus(200);
        $indexResponse->assertSee('Malam-Malam di Laboratorium Kecil');

        $showResponse = $this->get(route('public.people.storyfounder.show', $this->story->slug));
        $showResponse->assertStatus(200);
        $showResponse->assertSee('Semua bermula dari satu server rakitan');
    }

    /**
     * Test public core team directory with filter support.
     */
    public function test_public_team_directory_and_filter(): void
    {
        $response = $this->get(route('public.people.tim.index'));
        $response->assertStatus(200);
        $response->assertSee('Siti Nurhaliza');
        $response->assertSee('YOIN Digital Lab');

        $filteredResponse = $this->get(route('public.people.tim.index', ['status' => 'active']));
        $filteredResponse->assertStatus(200);
        $filteredResponse->assertSee('Siti Nurhaliza');
    }

    /**
     * Test public contributors directory and detail view.
     */
    public function test_public_contributors_directory_and_detail_load(): void
    {
        $response = $this->get(route('public.people.kontributor.index'));
        $response->assertStatus(200);
        $response->assertSee('Dimas Prasetyo');
        $response->assertSee('Institut Teknologi Bandung');

        $detailResponse = $this->get(route('public.people.kontributor.show', $this->contributor->slug));
        $detailResponse->assertStatus(200);
        $detailResponse->assertSee('Dimas Prasetyo');
    }

    /**
     * Test public partners/mitra directory synchronized with EcosystemClient.
     */
    public function test_public_mitra_directory_synchronized(): void
    {
        $response = $this->get(route('public.people.mitra.index'));
        $response->assertStatus(200);
        $response->assertSee('Kementerian Koordinator Pangan');
        $response->assertSee('Pemerintahan');
    }

    /**
     * Test admin authentication guard on people routes.
     */
    public function test_admin_people_requires_auth(): void
    {
        $response = $this->get(route('admin.people.index'));
        $response->assertRedirect('/login');
    }

    /**
     * Test authenticated admin can access people CMS.
     */
    public function test_authenticated_admin_can_view_people_cms(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.people.index'));

        $response->assertStatus(200);
        $response->assertSee('Dr. Rian Ardiansyah');
        $response->assertSee('Siti Nurhaliza');
        $response->assertSee('Dimas Prasetyo');
    }

    /**
     * Test admin can store person with JSON metadata.
     */
    public function test_admin_can_store_person_with_json_meta(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.people.store'), [
            'category' => 'tim',
            'name' => 'Budi Santoso',
            'role_id' => 'Lead Hardware Engineer',
            'role_en' => 'Lead Hardware Engineer',
            'bio_id' => 'Ahli perancangan sensor IoT.',
            'initiative_id' => $this->initiative->id,
            'is_active' => '1',
            'skills_raw' => 'PCB Design, LoRaWAN, STM32',
            'social_linkedin' => 'https://linkedin.com/in/budisantoso',
        ]);

        $response->assertRedirect(route('admin.people.index', ['tab' => 'team']));
        $this->assertDatabaseHas('people', [
            'name' => 'Budi Santoso',
            'category' => 'tim',
        ]);

        $person = Person::where('name', 'Budi Santoso')->first();
        $this->assertNotNull($person);
        $this->assertContains('PCB Design', $person->getMeta('skills', []));
        $this->assertEquals('https://linkedin.com/in/budisantoso', $person->getSocialLink('linkedin'));
    }

    /**
     * Test admin can store founder novel story.
     */
    public function test_admin_can_store_novel_story(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.people.stories.store'), [
            'person_id' => $this->founder->id,
            'chapter_number' => 'BAB 02',
            'title' => 'Menghadapi Krisis Pertama',
            'subtitle' => 'Ketika investor mundur mendadak',
            'reading_time' => '8 min read',
            'content_html' => '<p>Ujian terberat selalu datang di tahun kedua...</p>',
            'status' => 'published',
        ]);

        $response->assertRedirect(route('admin.people.index', ['tab' => 'stories']));
        $this->assertDatabaseHas('founder_stories', [
            'title' => 'Menghadapi Krisis Pertama',
            'chapter_number' => 'BAB 02',
        ]);
    }

    /**
     * Test admin can export excel/csv.
     */
    public function test_admin_can_export_excel_csv(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.people.export-excel'));

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'text/csv; charset=UTF-8');
        $this->assertStringContainsString('Dr. Rian Ardiansyah', $response->streamedContent());
    }

    /**
     * Test admin can download template.
     */
    public function test_admin_can_download_template(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.people.download-template'));

        $response->assertStatus(200);
        $this->assertStringContainsString('Kategori', $response->streamedContent());
        $this->assertStringContainsString('Contoh Nama Pendiri', $response->streamedContent());
    }

    /**
     * Test admin can import CSV into database.
     */
    public function test_admin_can_import_csv(): void
    {
        $csvContent = "category,name,role_id,role_en,bio_id,bio_en,is_active,contribution_type,organization,period,skills,quote,linkedin,instagram,github,email\n";
        $csvContent .= "tim,Ahmad Fauzi,Fullstack Engineer,Fullstack Engineer,Pengembang sistem web skala besar.,,1,,,,\"Vue, Laravel, Docker\",,https://linkedin.com/in/ahmadfauzi,,,ahmad@yoin.id\n";

        $file = UploadedFile::fake()->createWithContent('import_test.csv', $csvContent);

        $response = $this->actingAs($this->admin)->post(route('admin.people.import-excel'), [
            'excel_file' => $file,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('people', [
            'name' => 'Ahmad Fauzi',
            'category' => 'tim',
        ]);
    }

    /**
     * Test admin can update a person without slug input and with photo upload.
     */
    public function test_admin_can_update_person(): void
    {
        $response = $this->actingAs($this->admin)->put(route('admin.people.update', $this->founder->id), [
            'category' => 'founder',
            'name' => 'Dr. Rian Ardiansyah Updated',
            'role_id' => 'Chief Technology Officer & Co-Founder',
            'role_en' => 'Chief Technology Officer',
            'bio_id' => 'Bio terbarukan.',
            'visibility' => 'public',
            'quote' => 'Kutipan baru untuk pendiri.',
            'skills_raw' => 'Deep Learning, Robotics',
            'trajectory_raw' => "2020: Garasi Pertama\n2026: Skalasi Global",
        ]);

        $response->assertRedirect(route('admin.people.index', ['tab' => 'founders']));
        $this->assertDatabaseHas('people', [
            'id' => $this->founder->id,
            'name' => 'Dr. Rian Ardiansyah Updated',
            'role_id' => 'Chief Technology Officer & Co-Founder',
        ]);

        $updated = Person::find($this->founder->id);
        $this->assertEquals('Kutipan baru untuk pendiri.', $updated->getMeta('quote'));
        $this->assertContains('Deep Learning', $updated->getMeta('skills', []));
        $this->assertContains('2020: Garasi Pertama', $updated->getMeta('trajectory', []));
    }

    /**
     * Test admin can upload photo when updating person.
     */
    public function test_admin_can_upload_photo_on_update(): void
    {
        $photo = UploadedFile::fake()->image('profile.jpg');

        $response = $this->actingAs($this->admin)->put(route('admin.people.update', $this->teamMember->id), [
            'category' => 'tim',
            'name' => 'Siti Nurhaliza',
            'role_id' => 'Head of Agronomy',
            'photo' => $photo,
            'visibility' => 'public',
        ]);

        $response->assertRedirect(route('admin.people.index', ['tab' => 'team']));
        $updated = Person::find($this->teamMember->id);
        $this->assertNotNull($updated->photo);
        $this->assertStringContainsString('people/', $updated->photo);
    }

    /**
     * Test admin can delete a person.
     */
    public function test_admin_can_delete_person(): void
    {
        $id = $this->contributor->id;

        $response = $this->actingAs($this->admin)->delete(route('admin.people.destroy', $id));

        $response->assertRedirect(route('admin.people.index', ['tab' => 'contributors']));
        $this->assertDatabaseMissing('people', ['id' => $id]);
    }

    /**
     * Test admin can update founder story.
     */
    public function test_admin_can_update_founder_story(): void
    {
        $response = $this->actingAs($this->admin)->put(route('admin.people.stories.update', $this->story->id), [
            'person_id' => $this->founder->id,
            'chapter_number' => 'BAB 01-REV',
            'title' => 'Malam-Malam di Laboratorium Kecil (Revisi)',
            'content_html' => '<p>Konten revisi lengkap.</p>',
            'status' => 'published',
        ]);

        $response->assertRedirect(route('admin.people.index', ['tab' => 'stories']));
        $this->assertDatabaseHas('founder_stories', [
            'id' => $this->story->id,
            'title' => 'Malam-Malam di Laboratorium Kecil (Revisi)',
            'chapter_number' => 'BAB 01-REV',
        ]);
    }

    /**
     * Test admin can delete founder story.
     */
    public function test_admin_can_delete_founder_story(): void
    {
        $id = $this->story->id;

        $response = $this->actingAs($this->admin)->delete(route('admin.people.stories.destroy', $id));

        $response->assertRedirect(route('admin.people.index', ['tab' => 'stories']));
        $this->assertDatabaseMissing('founder_stories', ['id' => $id]);
    }
}
