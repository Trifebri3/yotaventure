<?php

namespace App\Http\Controllers;

use App\Models\EcosystemClient;
use App\Models\EcosystemInitiative;
use App\Models\FounderStory;
use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PeoplePublicController extends Controller
{
    /**
     * Executive Overview Hub: Insan & Tim YOIN
     */
    public function index(): View
    {
        $founders = Person::founders()
            ->public()
            ->orderBy('sort_order')
            ->get();

        $featuredStories = FounderStory::published()
            ->with('author')
            ->orderBy('sort_order')
            ->take(3)
            ->get();

        $coreTeam = Person::team()
            ->public()
            ->with('initiative')
            ->orderBy('sort_order')
            ->take(8)
            ->get();

        $contributors = Person::contributors()
            ->public()
            ->orderBy('sort_order')
            ->take(8)
            ->get();

        $clients = EcosystemClient::where('is_active', true)
            ->orderBy('sort_order')
            ->take(12)
            ->get();

        return view('public.people.index', compact(
            'founders',
            'featuredStories',
            'coreTeam',
            'contributors',
            'clients'
        ));
    }

    /**
     * Founders Directory
     */
    public function founders(): View
    {
        $founders = Person::founders()
            ->public()
            ->orderBy('sort_order')
            ->get();

        $stories = FounderStory::published()
            ->with('author')
            ->orderBy('sort_order')
            ->take(4)
            ->get();

        return view('public.people.founder.index', compact('founders', 'stories'));
    }

    /**
     * Single Founder Profile & Trajectory
     */
    public function founderDetail(string $slug): View
    {
        $founder = Person::founders()
            ->public()
            ->where('slug', $slug)
            ->firstOrFail();

        $stories = FounderStory::published()
            ->where('person_id', $founder->id)
            ->orderBy('sort_order')
            ->get();

        $otherFounders = Person::founders()
            ->public()
            ->where('id', '!=', $founder->id)
            ->orderBy('sort_order')
            ->get();

        return view('public.people.founder.show', compact('founder', 'stories', 'otherFounders'));
    }

    /**
     * Long-Form Founder Novel/Cerpen Index
     */
    public function storyfounder(): View
    {
        $stories = FounderStory::published()
            ->with('author')
            ->orderBy('sort_order')
            ->get();

        $founders = Person::founders()
            ->public()
            ->orderBy('sort_order')
            ->get();

        return view('public.people.storyfounder.index', compact('stories', 'founders'));
    }

    /**
     * Long-Form Founder Chapter Detail / Reader Experience
     */
    public function storyfounderDetail(string $slug): View
    {
        $story = FounderStory::published()
            ->with('author')
            ->where('slug', $slug)
            ->firstOrFail();

        $allStories = FounderStory::published()
            ->orderBy('sort_order')
            ->get();

        $prevStory = FounderStory::published()
            ->where('sort_order', '<', $story->sort_order)
            ->orderByDesc('sort_order')
            ->first();

        $nextStory = FounderStory::published()
            ->where('sort_order', '>', $story->sort_order)
            ->orderBy('sort_order')
            ->first();

        return view('public.people.storyfounder.show', compact('story', 'allStories', 'prevStory', 'nextStory'));
    }

    /**
     * Core Team Directory
     */
    public function tim(Request $request): View
    {
        $query = Person::team()->public()->with('initiative');

        if ($request->filled('initiative')) {
            $query->where('initiative_id', $request->input('initiative'));
        }

        if ($request->filled('status')) {
            if ($request->input('status') === 'active') {
                $query->active();
            } elseif ($request->input('status') === 'alumni') {
                $query->where('is_active', false);
            }
        }

        $team = $query->orderBy('sort_order')->get();
        $initiatives = EcosystemInitiative::orderBy('sort_order')->get();

        return view('public.people.tim.index', compact('team', 'initiatives'));
    }

    /**
     * Contributors Directory (Internship, Research, Collaboration, Fellowship)
     */
    public function kontributor(Request $request): View
    {
        $query = Person::contributors()->public();

        if ($request->filled('type')) {
            $query->where('contribution_type', $request->input('type'));
        }

        $contributors = $query->orderBy('sort_order')->get();

        return view('public.people.kontributor.index', compact('contributors'));
    }

    /**
     * Contributor Detail
     */
    public function kontributorDetail(string $slug): View
    {
        $contributor = Person::contributors()
            ->public()
            ->where('slug', $slug)
            ->firstOrFail();

        $relatedContributors = Person::contributors()
            ->public()
            ->where('contribution_type', $contributor->contribution_type)
            ->where('id', '!=', $contributor->id)
            ->take(4)
            ->get();

        return view('public.people.kontributor.show', compact('contributor', 'relatedContributors'));
    }

    /**
     * Collaborators / Partners (Synchronized with EcosystemClient logo database)
     */
    public function mitra(Request $request): View
    {
        $query = EcosystemClient::where('is_active', true);

        if ($request->filled('category')) {
            $cat = $request->input('category');
            $query->where(function ($q) use ($cat) {
                $q->where('client_type', $cat);
            });
        }

        $clients = $query->orderBy('sort_order')->get();

        $categories = EcosystemClient::where('is_active', true)
            ->whereNotNull('client_type')
            ->pluck('client_type')
            ->filter()
            ->unique()
            ->values();

        return view('public.people.mitra.index', compact('clients', 'categories'));
    }

    /**
     * Partner Detail (Synchronized with EcosystemClient)
     */
    public function mitraDetail(string $slug): View
    {
        $client = EcosystemClient::where('slug', $slug)
            ->orWhere('id', $slug)
            ->firstOrFail();

        $otherClients = EcosystemClient::where('is_active', true)
            ->where('id', '!=', $client->id)
            ->orderBy('sort_order')
            ->take(6)
            ->get();

        return view('public.people.mitra.show', compact('client', 'otherClients'));
    }
}
