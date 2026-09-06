<?php

namespace App\Http\Controllers;

use App\Models\CompanyAchievement;
use App\Models\CompanyProfile;
use App\Models\EcosystemClient;
use App\Models\EcosystemDomain;
use App\Models\EcosystemImpactMetric;
use App\Models\EcosystemInitiative;
use App\Models\EcosystemProduct;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AboutPublicController extends Controller
{
    /**
     * Display the main About Us hub.
     */
    public function index(Request $request): View
    {
        return $this->profile($request);
    }

    /**
     * Display the Company Profile page.
     */
    public function profile(Request $request): View
    {
        $profile = CompanyProfile::getProfile();

        $domains = EcosystemDomain::where('visibility', 'public')
            ->with(['initiatives' => function ($q) {
                $q->where('visibility', 'public')->orderBy('sort_order');
            }])
            ->orderBy('sort_order')
            ->get();

        $metrics = EcosystemImpactMetric::active()->orderBy('sort_order')->get();
        $clients = EcosystemClient::active()->orderBy('sort_order')->orderBy('name')->get();

        return view('public.about.profile', compact('profile', 'domains', 'metrics', 'clients'));
    }

    /**
     * Display the Investment & Capital Synergy page.
     */
    public function invest(Request $request): View
    {
        $profile = CompanyProfile::getProfile();

        $domains = EcosystemDomain::where('visibility', 'public')
            ->orderBy('sort_order')
            ->get();

        $initiatives = EcosystemInitiative::where('visibility', 'public')
            ->with(['domain', 'products' => function ($q): void {
                $q->where('visibility', 'public')->orderBy('sort_order');
            }])
            ->orderBy('sort_order')
            ->get();

        $products = EcosystemProduct::where('visibility', 'public')
            ->with('initiative')
            ->orderBy('sort_order')
            ->get();

        $metrics = EcosystemImpactMetric::active()->orderBy('sort_order')->get();

        return view('public.about.invest', compact('profile', 'domains', 'initiatives', 'products', 'metrics'));
    }

    /**
     * Display the Achievements, Awards & Certifications page.
     */
    public function achievements(Request $request): View
    {
        $profile = CompanyProfile::getProfile();
        $achievements = CompanyAchievement::active()->orderBy('sort_order')->latest('id')->get();
        $domains = EcosystemDomain::where('visibility', 'public')->orderBy('sort_order')->get();
        $metrics = EcosystemImpactMetric::active()->orderBy('sort_order')->get();

        return view('public.about.achievements', compact('profile', 'achievements', 'domains', 'metrics'));
    }

    /**
     * Display the legacy Story alias (redirects or renders achievements).
     */
    public function story(Request $request): View
    {
        return $this->achievements($request);
    }
}
