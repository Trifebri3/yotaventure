<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\VisitorLog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardAnalyticsTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'name' => 'Super Administrator',
            'email' => 'superadmin@yoin.id',
        ]);
    }

    public function test_guests_are_redirected_from_dashboard_and_export(): void
    {
        $this->get('/dashboard')->assertRedirect('/login');
        $this->get('/admin/dashboard')->assertRedirect('/login');
        $this->get('/admin/dashboard/export-excel')->assertRedirect('/login');
    }

    public function test_admin_can_view_analytics_dashboard(): void
    {
        VisitorLog::create([
            'ip_address' => '180.252.164.21',
            'url' => 'http://127.0.0.1:8089/',
            'path' => '/',
            'method' => 'GET',
            'device' => 'Desktop',
            'browser' => 'Chrome',
            'os' => 'Windows 11/10',
            'country' => 'Indonesia',
            'city' => 'Jakarta',
            'country_code' => 'ID',
            'is_bot' => false,
        ]);

        $response = $this->actingAs($this->admin)->get('/admin/dashboard');

        $response->assertOk();
        $response->assertSee('Pusat Analitik Trafik');
        $response->assertSee('Total Kunjungan');
        $response->assertSee('Pengunjung Unik IP');
        $response->assertSee('Unduh Excel');
        $response->assertSee('180.252.164.21');
        $response->assertSee('Jakarta');
    }

    public function test_dashboard_supports_period_filters(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/dashboard?period=today');
        $response->assertOk();
        $response->assertSee('Pusat Analitik Trafik');
        $response->assertSee('Total Kunjungan');

        $response30d = $this->actingAs($this->admin)->get('/admin/dashboard?period=30d');
        $response30d->assertOk();
    }

    public function test_admin_can_export_visitor_logs_to_excel_csv(): void
    {
        VisitorLog::create([
            'ip_address' => '114.124.23.45',
            'url' => 'http://127.0.0.1:8089/people',
            'path' => '/people',
            'method' => 'GET',
            'referer' => 'https://www.google.com/',
            'device' => 'Mobile',
            'browser' => 'Safari',
            'os' => 'iOS',
            'country' => 'Indonesia',
            'city' => 'Surabaya',
            'country_code' => 'ID',
            'is_bot' => false,
        ]);

        $response = $this->actingAs($this->admin)->get('/admin/dashboard/export-excel?period=all');

        $response->assertOk();
        $this->assertStringContainsString('text/csv', $response->headers->get('Content-Type'));
        $this->assertStringContainsString('attachment;', $response->headers->get('Content-Disposition'));
        $this->assertStringContainsString('YOIN_Laporan_Trafik', $response->headers->get('Content-Disposition'));
    }

    public function test_visitor_traffic_middleware_logs_public_visits(): void
    {
        // Visit public homepage
        $response = $this->get('/');
        $response->assertOk();

        $this->assertTrue(
            VisitorLog::where('path', '/')->exists(),
            'VisitorLog should record visit to public homepage'
        );
    }

    public function test_visitor_traffic_middleware_does_not_log_admin_routes(): void
    {
        VisitorLog::truncate();

        // Visit admin dashboard
        $this->actingAs($this->admin)->get('/admin/dashboard');

        $adminLogsCount = VisitorLog::where('path', 'like', '/admin%')->count();
        $this->assertEquals(0, $adminLogsCount, 'Middleware should not record admin dashboard visits');
    }

    public function test_login_page_renders_with_yoin_branding(): void
    {
        $response = $this->get('/login');

        $response->assertOk();
        $response->assertSee('Masuk ke Super Admin');
        $response->assertSee('logo.png');
        $response->assertSee('Website Publik');
    }
}
