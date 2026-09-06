<?php

namespace Tests\Feature;

use App\Models\CollaborationInquiry;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CollaborationInquiryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test public user can submit collaboration inquiry via JSON.
     */
    public function test_public_user_can_submit_collaboration_inquiry_json(): void
    {
        $payload = [
            'name' => 'Budi Santoso',
            'email' => 'budi.santoso@startupnusantara.id',
            'phone' => '+6281234567890',
            'category' => 'Inovasi & Akselerasi Inisiatif',
            'message' => 'Kami ingin berkolaborasi untuk proyek akselerasi inovasi agritech di Jawa Barat.',
        ];

        $response = $this->postJson(route('public.collaboration.inquiry'), $payload);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);

        $this->assertDatabaseHas('collaboration_inquiries', [
            'name' => 'Budi Santoso',
            'email' => 'budi.santoso@startupnusantara.id',
            'phone' => '+6281234567890',
            'category' => 'Inovasi & Akselerasi Inisiatif',
            'status' => 'baru',
        ]);
    }

    /**
     * Test public submission validation fails when required fields are missing.
     */
    public function test_public_submission_validation_fails_on_missing_fields(): void
    {
        $response = $this->postJson(route('public.collaboration.inquiry'), []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'email', 'category', 'message']);
    }

    /**
     * Test guest cannot access admin inquiry endpoints.
     */
    public function test_guest_cannot_access_admin_inquiries(): void
    {
        $inquiry = CollaborationInquiry::factory()->create();

        $this->get(route('admin.collaborations.index', ['tab' => 'inquiries']))
            ->assertRedirect(route('login'));

        $this->getJson(route('admin.collaborations.inquiries.show', $inquiry))
            ->assertStatus(401);

        $this->putJson(route('admin.collaborations.inquiries.update', $inquiry), [
            'status' => 'ditinjau',
        ])->assertStatus(401);

        $this->delete(route('admin.collaborations.inquiries.destroy', $inquiry))
            ->assertRedirect(route('login'));
    }

    /**
     * Test admin can view inquiries list and filter by status.
     */
    public function test_admin_can_view_inquiries_list_and_filter(): void
    {
        $admin = User::factory()->create();

        $inquiryBaru = CollaborationInquiry::factory()->create([
            'name' => 'Mitra Baru',
            'status' => 'baru',
        ]);

        $inquirySelesai = CollaborationInquiry::factory()->create([
            'name' => 'Mitra Selesai',
            'status' => 'selesai',
        ]);

        // Default tab shows inquiries
        $response = $this->actingAs($admin)->get(route('admin.collaborations.index', ['tab' => 'inquiries']));
        $response->assertStatus(200);
        $response->assertSee('Mitra Baru');
        $response->assertSee('Mitra Selesai');

        // Filter by status 'selesai'
        $filteredResponse = $this->actingAs($admin)->get(route('admin.collaborations.index', [
            'tab' => 'inquiries',
            'status' => 'selesai',
        ]));
        $filteredResponse->assertStatus(200);
        $filteredResponse->assertSee('Mitra Selesai');
        $filteredResponse->assertDontSee('Mitra Baru');
    }

    /**
     * Test admin can inspect inquiry detail via JSON and it automatically marks as read.
     */
    public function test_admin_show_inquiry_marks_as_read(): void
    {
        $admin = User::factory()->create();
        $inquiry = CollaborationInquiry::factory()->create([
            'read_at' => null,
        ]);

        $this->assertNull($inquiry->read_at);

        $response = $this->actingAs($admin)->getJson(route('admin.collaborations.inquiries.show', $inquiry));

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'inquiry' => [
                    'id' => $inquiry->id,
                ],
            ]);

        $inquiry->refresh();
        $this->assertNotNull($inquiry->read_at);
    }

    /**
     * Test admin can update status and admin notes.
     */
    public function test_admin_can_update_inquiry_status_and_notes(): void
    {
        $admin = User::factory()->create();
        $inquiry = CollaborationInquiry::factory()->create([
            'status' => 'baru',
            'admin_notes' => null,
        ]);

        $response = $this->actingAs($admin)->putJson(route('admin.collaborations.inquiries.update', $inquiry), [
            'status' => 'dihubungi',
            'admin_notes' => 'Sudah dihubungi melalui pesan WhatsApp untuk scheduling call.',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);

        $inquiry->refresh();
        $this->assertEquals('dihubungi', $inquiry->status);
        $this->assertEquals('Sudah dihubungi melalui pesan WhatsApp untuk scheduling call.', $inquiry->admin_notes);
    }

    /**
     * Test admin can toggle read/unread state.
     */
    public function test_admin_can_toggle_read_status(): void
    {
        $admin = User::factory()->create();
        $inquiry = CollaborationInquiry::factory()->create([
            'read_at' => null,
        ]);

        $response = $this->actingAs($admin)->post(route('admin.collaborations.inquiries.toggle-read', $inquiry));
        $response->assertRedirect(route('admin.collaborations.index', ['tab' => 'inquiries']));

        $inquiry->refresh();
        $this->assertNotNull($inquiry->read_at);

        // Toggle again to unread
        $this->actingAs($admin)->post(route('admin.collaborations.inquiries.toggle-read', $inquiry));
        $inquiry->refresh();
        $this->assertNull($inquiry->read_at);
    }

    /**
     * Test admin can delete an inquiry.
     */
    public function test_admin_can_delete_inquiry(): void
    {
        $admin = User::factory()->create();
        $inquiry = CollaborationInquiry::factory()->create();

        $response = $this->actingAs($admin)->delete(route('admin.collaborations.inquiries.destroy', $inquiry));
        $response->assertRedirect(route('admin.collaborations.index', ['tab' => 'inquiries']));

        $this->assertDatabaseMissing('collaboration_inquiries', [
            'id' => $inquiry->id,
        ]);
    }
}
