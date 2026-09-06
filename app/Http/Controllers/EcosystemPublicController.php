<?php

namespace App\Http\Controllers;

use App\Models\EcosystemClient;
use App\Models\EcosystemDocument;
use App\Models\EcosystemDomain;
use App\Models\EcosystemImpactMetric;
use App\Models\EcosystemImpactPillar;
use App\Models\EcosystemInitiative;
use App\Models\EcosystemProject;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EcosystemPublicController extends Controller
{
    /**
     * Central Ecosystem Directory & Gateway
     */
    public function index(Request $request): View
    {
        $domains = EcosystemDomain::public()
            ->with(['initiatives' => function ($q) {
                $q->public()->with(['products' => function ($p) {
                    $p->public();
                }, 'projects' => function ($pr) {
                    $pr->public()->with('client');
                }]);
            }])
            ->get();

        $featuredInitiatives = EcosystemInitiative::public()
            ->where('is_featured', true)
            ->with(['domain', 'projects' => function ($q) {
                $q->public()->take(3);
            }])
            ->get();

        $stats = [
            'domains_count' => EcosystemDomain::public()->count(),
            'initiatives_count' => EcosystemInitiative::public()->count(),
            'projects_count' => EcosystemProject::public()->count(),
            'clients_count' => EcosystemClient::where('is_active', true)->count(),
        ];

        return view('public.ecosystem.index', [
            'domains' => $domains,
            'featuredInitiatives' => $featuredInitiatives,
            'stats' => $stats,
        ]);
    }

    /**
     * Domain Deep-dive Page
     */
    public function domain(string $slug): View
    {
        $domain = EcosystemDomain::where('slug', $slug)
            ->where('visibility', 'public')
            ->with(['initiatives' => function ($q) {
                $q->public()->with(['products' => function ($p) {
                    $p->public();
                }, 'projects' => function ($pr) {
                    $pr->public()->with('client');
                }]);
            }])
            ->firstOrFail();

        $allDomains = EcosystemDomain::public()->get();

        return view('public.ecosystem.domain', [
            'domain' => $domain,
            'allDomains' => $allDomains,
        ]);
    }

    /**
     * Initiative / Brand Gateway & Storytelling Page
     */
    public function initiative(string $slug): View
    {
        $initiative = EcosystemInitiative::where('slug', $slug)
            ->where('visibility', 'public')
            ->with(['domain', 'products' => function ($q) {
                $q->public()->with('categories.types');
            }, 'projects' => function ($q) {
                $q->public()->with(['client', 'category', 'type']);
            }])
            ->firstOrFail();

        $siblingInitiatives = EcosystemInitiative::public()
            ->where('domain_id', $initiative->domain_id)
            ->where('id', '!=', $initiative->id)
            ->get();

        return view('public.ecosystem.initiative', [
            'initiative' => $initiative,
            'siblingInitiatives' => $siblingInitiatives,
        ]);
    }

    /**
     * Dedicated Public Impact & ESG Showcase Page
     */
    public function impact(): View
    {
        $pillars = EcosystemImpactPillar::active()->get();
        $documents = EcosystemDocument::active()->orderBy('sort_order')->get();
        $metrics = EcosystemImpactMetric::active()->orderBy('sort_order')->get();

        return view('public.impact.index', [
            'pillars' => $pillars,
            'documents' => $documents,
            'metrics' => $metrics,
        ]);
    }

    /**
     * Dedicated Public Profile for a Specific Impact Pillar
     */
    public function pillarDetail(string $code): View
    {
        $pillar = EcosystemImpactPillar::active()->where('code', $code)->firstOrFail();
        $otherPillars = EcosystemImpactPillar::active()->where('id', '!=', $pillar->id)->orderBy('pillar_number')->get();

        return view('public.impact.pillar', [
            'pillar' => $pillar,
            'otherPillars' => $otherPillars,
        ]);
    }
}
