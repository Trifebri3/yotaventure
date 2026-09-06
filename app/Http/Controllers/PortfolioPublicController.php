<?php

namespace App\Http\Controllers;

use App\Models\EcosystemClient;
use App\Models\EcosystemDomain;
use App\Models\EcosystemInitiative;
use App\Models\EcosystemProject;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PortfolioPublicController extends Controller
{
    /**
     * Central Portfolio & Case Study Index
     */
    public function index(Request $request): View
    {
        $domainSlug = $request->query('domain');
        $initiativeSlug = $request->query('initiative');
        $clientSlug = $request->query('client');

        $query = EcosystemProject::public()
            ->with(['initiative.domain', 'category', 'type', 'client']);

        if ($domainSlug) {
            $query->whereHas('initiative.domain', function ($q) use ($domainSlug) {
                $q->where('slug', $domainSlug);
            });
        }

        if ($initiativeSlug) {
            $query->whereHas('initiative', function ($q) use ($initiativeSlug) {
                $q->where('slug', $initiativeSlug);
            });
        }

        if ($clientSlug) {
            $query->whereHas('client', function ($q) use ($clientSlug) {
                $q->where('slug', $clientSlug);
            });
        }

        $projects = $query->paginate(9)->withQueryString();

        $domains = EcosystemDomain::public()->get();
        $initiatives = EcosystemInitiative::public()->get();
        $clients = EcosystemClient::where('is_active', true)->has('projects')->get();

        return view('public.portfolio.index', [
            'projects' => $projects,
            'domains' => $domains,
            'initiatives' => $initiatives,
            'clients' => $clients,
            'currentDomain' => $domainSlug,
            'currentInitiative' => $initiativeSlug,
            'currentClient' => $clientSlug,
        ]);
    }

    /**
     * Detailed Project Case Study
     */
    public function show(string $slug): View
    {
        $project = EcosystemProject::where('slug', $slug)
            ->where('visibility', 'public')
            ->with(['initiative.domain', 'category', 'type', 'client'])
            ->firstOrFail();

        $relatedProjects = EcosystemProject::public()
            ->where('initiative_id', $project->initiative_id)
            ->where('id', '!=', $project->id)
            ->take(3)
            ->get();

        return view('public.portfolio.show', [
            'project' => $project,
            'relatedProjects' => $relatedProjects,
        ]);
    }
}
