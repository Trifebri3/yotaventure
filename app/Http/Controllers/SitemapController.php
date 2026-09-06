<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\EcosystemDomain;
use App\Models\EcosystemInitiative;
use App\Models\EcosystemProject;
use App\Models\FounderStory;
use App\Models\Person;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    /**
     * Generate dynamic XML sitemap with Google Image extension for search engines.
     */
    public function index(): Response
    {
        $staticUrls = [
            [
                'loc' => url('/'),
                'priority' => '1.0',
                'changefreq' => 'daily',
                'lastmod' => now()->toDateString(),
                'image' => [
                    'loc' => asset('foto/hero.png'),
                    'title' => 'PT Yota Inovasi Nusantara (YOIN) - Ekosistem Inovasi & Digital',
                    'caption' => 'Holding inovasi dan venture builder teknologi multisektoral terdepan di Indonesia',
                ],
            ],
            ['loc' => url('/ekosistem'), 'priority' => '0.9', 'changefreq' => 'weekly', 'lastmod' => now()->toDateString()],
            ['loc' => url('/portofolio'), 'priority' => '0.9', 'changefreq' => 'weekly', 'lastmod' => now()->toDateString()],
            ['loc' => url('/publikasi'), 'priority' => '0.9', 'changefreq' => 'daily', 'lastmod' => now()->toDateString()],
            ['loc' => url('/tentang-kami'), 'priority' => '0.8', 'changefreq' => 'monthly', 'lastmod' => now()->toDateString()],
            ['loc' => url('/tentang-kami/profil'), 'priority' => '0.8', 'changefreq' => 'monthly', 'lastmod' => now()->toDateString()],
            ['loc' => url('/tentang-kami/invest'), 'priority' => '0.8', 'changefreq' => 'monthly', 'lastmod' => now()->toDateString()],
            ['loc' => url('/tentang-kami/pencapaian'), 'priority' => '0.8', 'changefreq' => 'monthly', 'lastmod' => now()->toDateString()],
            ['loc' => url('/tentang-kami/story'), 'priority' => '0.8', 'changefreq' => 'monthly', 'lastmod' => now()->toDateString()],
            ['loc' => url('/people'), 'priority' => '0.8', 'changefreq' => 'weekly', 'lastmod' => now()->toDateString()],
            ['loc' => url('/people/founder'), 'priority' => '0.8', 'changefreq' => 'monthly', 'lastmod' => now()->toDateString()],
            ['loc' => url('/people/storyfounder'), 'priority' => '0.8', 'changefreq' => 'weekly', 'lastmod' => now()->toDateString()],
            ['loc' => url('/people/tim'), 'priority' => '0.8', 'changefreq' => 'monthly', 'lastmod' => now()->toDateString()],
            ['loc' => url('/people/kontributor'), 'priority' => '0.8', 'changefreq' => 'monthly', 'lastmod' => now()->toDateString()],
            ['loc' => url('/people/mitra'), 'priority' => '0.8', 'changefreq' => 'monthly', 'lastmod' => now()->toDateString()],
            ['loc' => url('/dampak'), 'priority' => '0.8', 'changefreq' => 'monthly', 'lastmod' => now()->toDateString()],
            ['loc' => url('/kolaborasi'), 'priority' => '0.8', 'changefreq' => 'monthly', 'lastmod' => now()->toDateString()],
            ['loc' => url('/syarat-ketentuan'), 'priority' => '0.5', 'changefreq' => 'yearly', 'lastmod' => now()->toDateString()],
            ['loc' => url('/kebijakan-privasi'), 'priority' => '0.5', 'changefreq' => 'yearly', 'lastmod' => now()->toDateString()],
            ['loc' => url('/keamanan-informasi'), 'priority' => '0.5', 'changefreq' => 'yearly', 'lastmod' => now()->toDateString()],
        ];

        $dynamicUrls = [];

        // Articles with Google Image Extension
        Article::published()->latest('published_at')->each(function ($article) use (&$dynamicUrls) {
            $item = [
                'loc' => url('/publikasi/'.$article->slug),
                'priority' => '0.8',
                'changefreq' => 'weekly',
                'lastmod' => optional($article->updated_at ?? $article->published_at)->toDateString() ?? now()->toDateString(),
            ];

            if ($shareImg = $article->share_image_url) {
                $item['image'] = [
                    'loc' => $shareImg,
                    'title' => $article->title,
                    'caption' => $article->excerpt ?: $article->title,
                ];
            }

            $dynamicUrls[] = $item;
        });

        // Ecosystem Domains
        EcosystemDomain::where('visibility', 'public')->each(function ($domain) use (&$dynamicUrls) {
            $dynamicUrls[] = [
                'loc' => url('/ekosistem/domain/'.$domain->slug),
                'priority' => '0.8',
                'changefreq' => 'monthly',
                'lastmod' => optional($domain->updated_at)->toDateString() ?? now()->toDateString(),
            ];
        });

        // Ecosystem Initiatives
        EcosystemInitiative::where('visibility', 'public')->each(function ($initiative) use (&$dynamicUrls) {
            $dynamicUrls[] = [
                'loc' => url('/ekosistem/inisiatif/'.$initiative->slug),
                'priority' => '0.8',
                'changefreq' => 'monthly',
                'lastmod' => optional($initiative->updated_at)->toDateString() ?? now()->toDateString(),
            ];
        });

        // Portfolio Projects
        EcosystemProject::all()->each(function ($project) use (&$dynamicUrls) {
            $item = [
                'loc' => url('/portofolio/'.$project->slug),
                'priority' => '0.8',
                'changefreq' => 'monthly',
                'lastmod' => optional($project->updated_at)->toDateString() ?? now()->toDateString(),
            ];

            if (! empty($project->cover_image)) {
                $item['image'] = [
                    'loc' => str_starts_with($project->cover_image, 'http') ? $project->cover_image : url($project->cover_image),
                    'title' => $project->title,
                    'caption' => $project->tagline ?? $project->title,
                ];
            }

            $dynamicUrls[] = $item;
        });

        // Founders
        Person::where('category', 'founder')->active()->each(function ($founder) use (&$dynamicUrls) {
            $item = [
                'loc' => url('/people/founder/'.$founder->slug),
                'priority' => '0.7',
                'changefreq' => 'monthly',
                'lastmod' => optional($founder->updated_at)->toDateString() ?? now()->toDateString(),
            ];

            if (! empty($founder->avatar)) {
                $item['image'] = [
                    'loc' => str_starts_with($founder->avatar, 'http') ? $founder->avatar : url($founder->avatar),
                    'title' => $founder->name,
                    'caption' => $founder->role ?? 'Founder YOIN',
                ];
            }

            $dynamicUrls[] = $item;
        });

        // Founder Stories
        FounderStory::published()->each(function ($story) use (&$dynamicUrls) {
            $dynamicUrls[] = [
                'loc' => url('/people/storyfounder/'.$story->slug),
                'priority' => '0.7',
                'changefreq' => 'monthly',
                'lastmod' => optional($story->updated_at)->toDateString() ?? now()->toDateString(),
            ];
        });

        $allUrls = array_merge($staticUrls, $dynamicUrls);

        $xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" xmlns:xhtml="http://www.w3.org/1999/xhtml">'."\n";

        foreach ($allUrls as $item) {
            $xml .= "  <url>\n";
            $xml .= '    <loc>'.htmlspecialchars($item['loc'], ENT_XML1, 'UTF-8')."</loc>\n";
            $xml .= '    <lastmod>'.$item['lastmod']."</lastmod>\n";
            $xml .= '    <changefreq>'.$item['changefreq']."</changefreq>\n";
            $xml .= '    <priority>'.$item['priority']."</priority>\n";

            if (! empty($item['image'])) {
                $xml .= "    <image:image>\n";
                $xml .= '      <image:loc>'.htmlspecialchars($item['image']['loc'], ENT_XML1, 'UTF-8')."</image:loc>\n";
                $xml .= '      <image:title>'.htmlspecialchars($item['image']['title'], ENT_XML1, 'UTF-8')."</image:title>\n";
                $xml .= '      <image:caption>'.htmlspecialchars($item['image']['caption'], ENT_XML1, 'UTF-8')."</image:caption>\n";
                $xml .= "    </image:image>\n";
            }

            $xml .= "  </url>\n";
        }

        $xml .= '</urlset>';

        return response($xml, 200, [
            'Content-Type' => 'application/xml; charset=UTF-8',
            'X-Robots-Tag' => 'noindex',
        ]);
    }
}
