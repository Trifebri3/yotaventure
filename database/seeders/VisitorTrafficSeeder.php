<?php

namespace Database\Seeders;

use App\Models\VisitorLog;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class VisitorTrafficSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Avoid duplicating if logs already exist
        if (VisitorLog::count() > 50) {
            return;
        }

        $cities = [
            ['city' => 'Jakarta', 'country' => 'Indonesia', 'code' => 'ID', 'weight' => 35],
            ['city' => 'Surabaya', 'country' => 'Indonesia', 'code' => 'ID', 'weight' => 15],
            ['city' => 'Bandung', 'country' => 'Indonesia', 'code' => 'ID', 'weight' => 12],
            ['city' => 'Medan', 'country' => 'Indonesia', 'code' => 'ID', 'weight' => 8],
            ['city' => 'Denpasar', 'country' => 'Indonesia', 'code' => 'ID', 'weight' => 6],
            ['city' => 'Yogyakarta', 'country' => 'Indonesia', 'code' => 'ID', 'weight' => 6],
            ['city' => 'Semarang', 'country' => 'Indonesia', 'code' => 'ID', 'weight' => 4],
            ['city' => 'Makassar', 'country' => 'Indonesia', 'code' => 'ID', 'weight' => 4],
            ['city' => 'Singapore', 'country' => 'Singapore', 'code' => 'SG', 'weight' => 5],
            ['city' => 'Tokyo', 'country' => 'Japan', 'code' => 'JP', 'weight' => 2],
            ['city' => 'London', 'country' => 'United Kingdom', 'code' => 'GB', 'weight' => 2],
            ['city' => 'San Francisco', 'country' => 'United States', 'code' => 'US', 'weight' => 1],
        ];

        $paths = [
            ['path' => '/', 'url' => 'http://127.0.0.1:8089/'],
            ['path' => '/people', 'url' => 'http://127.0.0.1:8089/people'],
            ['path' => '/people/founder', 'url' => 'http://127.0.0.1:8089/people/founder'],
            ['path' => '/people/storyfounder', 'url' => 'http://127.0.0.1:8089/people/storyfounder'],
            ['path' => '/people/tim', 'url' => 'http://127.0.0.1:8089/people/tim'],
            ['path' => '/people/kontributor', 'url' => 'http://127.0.0.1:8089/people/kontributor'],
            ['path' => '/people/mitra', 'url' => 'http://127.0.0.1:8089/people/mitra'],
            ['path' => '/publikasi', 'url' => 'http://127.0.0.1:8089/publikasi'],
            ['path' => '/kolaborasi', 'url' => 'http://127.0.0.1:8089/kolaborasi'],
            ['path' => '/tentang-kami/profil', 'url' => 'http://127.0.0.1:8089/tentang-kami/profil'],
            ['path' => '/tentang-kami/invest', 'url' => 'http://127.0.0.1:8089/tentang-kami/invest'],
        ];

        $referrers = [
            'https://www.google.com/',
            'https://www.google.co.id/',
            'https://www.linkedin.com/',
            'https://www.instagram.com/',
            'https://t.co/',
            'https://www.bing.com/',
            null, // Direct
            null,
        ];

        $devices = [
            ['device' => 'Desktop', 'browser' => 'Chrome', 'os' => 'Windows 11/10', 'weight' => 45],
            ['device' => 'Mobile', 'browser' => 'Chrome', 'os' => 'Android', 'weight' => 30],
            ['device' => 'Mobile', 'browser' => 'Safari', 'os' => 'iOS', 'weight' => 15],
            ['device' => 'Desktop', 'browser' => 'Safari', 'os' => 'macOS', 'weight' => 6],
            ['device' => 'Tablet', 'browser' => 'Safari', 'os' => 'iOS', 'weight' => 4],
        ];

        $ipPool = [
            '180.252.164.21', '114.124.23.45', '103.111.82.10', '110.138.90.15',
            '36.85.120.98', '182.1.205.33', '125.160.18.77', '139.195.40.12',
            '103.28.14.99', '180.244.112.50', '202.158.45.19', '114.79.12.88',
            '203.190.241.11', '118.99.77.20', '103.10.150.32', '128.199.200.14',
            '159.65.132.89', '216.58.200.46', '157.240.199.35', '13.250.177.10',
        ];

        $now = Carbon::now();
        $records = [];

        // Generate realistic 30-day traffic curve (~240 records across 30 days)
        for ($day = 29; $day >= 0; $day--) {
            $date = (clone $now)->subDays($day);
            // More visits on recent days
            $dailyCount = rand(8, 22) + (int) ((30 - $day) * 0.4);

            for ($i = 0; $i < $dailyCount; $i++) {
                $cityChoice = $cities[array_rand($cities)];
                $pathChoice = $paths[array_rand($paths)];
                $deviceChoice = $devices[array_rand($devices)];
                $ip = $ipPool[array_rand($ipPool)];
                $referrer = $referrers[array_rand($referrers)];

                $timestamp = (clone $date)->setTime(rand(7, 23), rand(0, 59), rand(0, 59));

                $isBot = (rand(1, 15) === 1);
                $browser = $isBot ? 'Googlebot' : $deviceChoice['browser'];
                $device = $isBot ? 'Bot' : $deviceChoice['device'];
                $userAgent = $isBot
                    ? 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)'
                    : "Mozilla/5.0 ({$deviceChoice['os']}) AppleWebKit/537.36 (KHTML, like Gecko) {$deviceChoice['browser']}/128.0.0.0 Safari/537.36";

                $records[] = [
                    'ip_address' => $ip,
                    'session_id' => 'sess_'.md5($ip.$date->format('Y-m-d')),
                    'url' => $pathChoice['url'],
                    'path' => $pathChoice['path'],
                    'method' => 'GET',
                    'referer' => $referrer,
                    'user_agent' => $userAgent,
                    'device' => $device,
                    'browser' => $browser,
                    'os' => $isBot ? 'Bot' : $deviceChoice['os'],
                    'country' => $cityChoice['country'],
                    'city' => $cityChoice['city'],
                    'country_code' => $cityChoice['code'],
                    'is_bot' => $isBot,
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp,
                ];
            }
        }

        // Insert in batches
        foreach (array_chunk($records, 100) as $chunk) {
            VisitorLog::insert($chunk);
        }
    }
}
