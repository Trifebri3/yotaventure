<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('YOIN');
        $response->assertSee('PT Yota Inovasi Nusantara');
        $response->assertSee('Ecosystem');
        $response->assertSee('Inovasi');
        $response->assertSee('Impact');
        $response->assertSee('Hubungi Kami');
        $response->assertSee('THE HOUSE');

        $content = $response->getContent();

        // Strip allowed legal company name, allowed emails/domains, and official initiative slugs
        $sanitizedContent = str_ireplace([
            'PT Yota Inovasi Nusantara',
            'PT YOTA Inovasi Nusantara',
            'hello@yotainovasi.id',
            'https://yotainovasi.id',
            'yotainovasi.id',
            'yota-adiwidya-center',
            'Yota Adiwidya Center',
            'https://siyota.org',
            'siyota.org',
            'SIYOTA',
            'siyota',
        ], '', $content);

        // Ensure no other occurrence of 'yota' exists in the rendered HTML
        $this->assertStringNotContainsStringIgnoringCase('yota', $sanitizedContent, 'Found unauthorized YOTA word in HTML output');
    }
}
