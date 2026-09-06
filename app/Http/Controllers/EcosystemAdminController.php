<?php

namespace App\Http\Controllers;

use App\Models\EcosystemCategory;
use App\Models\EcosystemClient;
use App\Models\EcosystemDocument;
use App\Models\EcosystemDomain;
use App\Models\EcosystemImpactMetric;
use App\Models\EcosystemImpactPillar;
use App\Models\EcosystemInitiative;
use App\Models\EcosystemProduct;
use App\Models\EcosystemProject;
use App\Models\EcosystemType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class EcosystemAdminController extends Controller
{
    /**
     * Unified Ecosystem Admin Dashboard
     */
    public function index(Request $request): View
    {
        $activeTab = $request->query('tab', 'initiatives');

        $domains = EcosystemDomain::orderBy('sort_order')->get();
        $initiatives = EcosystemInitiative::with('domain')->orderBy('sort_order')->get();
        $products = EcosystemProduct::with('initiative')->orderBy('sort_order')->get();
        $categories = EcosystemCategory::with('product')->orderBy('sort_order')->get();
        $types = EcosystemType::with('category')->orderBy('sort_order')->get();
        $projects = EcosystemProject::with(['initiative', 'category', 'client'])->orderByDesc('id')->paginate(15);
        $clients = EcosystemClient::withCount('projects')->orderBy('name')->get();
        $documents = EcosystemDocument::orderBy('sort_order')->orderByDesc('id')->get();
        $impactPillars = EcosystemImpactPillar::orderBy('pillar_number')->get();
        $metrics = EcosystemImpactMetric::orderBy('sort_order')->get();

        $stats = [
            'total_domains' => $domains->count(),
            'total_initiatives' => $initiatives->count(),
            'total_products' => $products->count(),
            'total_projects' => EcosystemProject::count(),
            'total_clients' => $clients->count(),
            'total_documents' => $documents->count(),
            'total_metrics' => $metrics->count(),
        ];

        return view('admin.ecosystem.index', [
            'activeTab' => $activeTab,
            'domains' => $domains,
            'initiatives' => $initiatives,
            'products' => $products,
            'categories' => $categories,
            'types' => $types,
            'projects' => $projects,
            'clients' => $clients,
            'documents' => $documents,
            'impactPillars' => $impactPillars,
            'metrics' => $metrics,
            'stats' => $stats,
        ]);
    }

    // -------------------------------------------------------------
    // DOMAIN CRUD
    // -------------------------------------------------------------

    public function storeDomain(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name_id' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:ecosystem_domains,slug',
            'tagline_id' => 'nullable|string|max:255',
            'tagline_en' => 'nullable|string|max:255',
            'problem_statement_id' => 'required|string',
            'problem_statement_en' => 'nullable|string',
            'solution_statement_id' => 'nullable|string',
            'solution_statement_en' => 'nullable|string',
            'short_description_id' => 'nullable|string',
            'short_description_en' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
            'icon_file' => 'nullable|image|max:10240',
            'icon_image' => 'nullable|string|max:1000',
            'cover_file' => 'nullable|image|max:10240',
            'cover_image' => 'nullable|string|max:1000',
            'gallery_files.*' => 'nullable|image|max:10240',
            'gallery_raw' => 'nullable|string',
            'program_logo_files.*' => 'nullable|image|max:10240',
            'program_logos_raw' => 'nullable|string',
            'sdgs_raw' => 'nullable|string',
            'issues_raw' => 'nullable|string',
            'status' => 'required|string|in:IDEA,PLANNING,BUILDING,DEVELOPING,OPERATING,COMPLETED,ARCHIVED',
            'visibility' => 'required|string|in:public,private,draft,archived',
            'sort_order' => 'nullable|integer',
            'is_featured' => 'nullable|boolean',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name_en'] ?: $validated['name_id']);
        }
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        // Upload Icon
        if ($request->hasFile('icon_file')) {
            $path = $request->file('icon_file')->store('ecosystem/domains/icons', 'public');
            $validated['icon_image'] = Storage::url($path);
            if (empty($validated['icon'])) {
                $validated['icon'] = $validated['icon_image'];
            }
        }
        unset($validated['icon_file']);

        // Upload Cover
        if ($request->hasFile('cover_file')) {
            $path = $request->file('cover_file')->store('ecosystem/domains/covers', 'public');
            $validated['cover_image'] = Storage::url($path);
        }
        unset($validated['cover_file']);

        // Gallery Photos
        $gallery = ! empty($validated['gallery_raw'])
            ? array_filter(array_map('trim', preg_split('/[\n\r,]+/', $validated['gallery_raw'])))
            : [];
        if ($request->hasFile('gallery_files')) {
            foreach ($request->file('gallery_files') as $file) {
                $path = $file->store('ecosystem/domains/gallery', 'public');
                $gallery[] = Storage::url($path);
            }
        }
        $validated['gallery'] = array_values(array_unique($gallery));
        unset($validated['gallery_raw'], $validated['gallery_files']);

        // Program / Partner Logos
        $programLogos = ! empty($validated['program_logos_raw'])
            ? array_filter(array_map('trim', preg_split('/[\n\r,]+/', $validated['program_logos_raw'])))
            : [];
        if ($request->hasFile('program_logo_files')) {
            foreach ($request->file('program_logo_files') as $file) {
                $path = $file->store('ecosystem/domains/logos', 'public');
                $programLogos[] = Storage::url($path);
            }
        }
        $validated['program_logos'] = array_values(array_unique($programLogos));
        unset($validated['program_logos_raw'], $validated['program_logo_files']);

        // SDGs
        $validated['sdgs'] = ! empty($validated['sdgs_raw'])
            ? array_values(array_filter(array_map('trim', preg_split('/[,\n\r]+/', $validated['sdgs_raw']))))
            : [];
        unset($validated['sdgs_raw']);

        // Specific Issues & Solutions
        if (! empty($validated['issues_raw'])) {
            $lines = array_filter(array_map('trim', explode("\n", $validated['issues_raw'])));
            $parsedIssues = [];
            foreach ($lines as $line) {
                if (str_contains($line, '::')) {
                    [$iss, $sol] = explode('::', $line, 2);
                    $parsedIssues[] = ['issue' => trim($iss), 'solution' => trim($sol)];
                } elseif (str_contains($line, '|')) {
                    [$iss, $sol] = explode('|', $line, 2);
                    $parsedIssues[] = ['issue' => trim($iss), 'solution' => trim($sol)];
                } else {
                    $parsedIssues[] = [
                        'issue' => trim($line),
                        'solution' => $validated['solution_statement_id'] ?? 'Solusi strategis terintegrasi ekosistem.',
                    ];
                }
            }
            $validated['issues'] = $parsedIssues;
        } else {
            $validated['issues'] = [];
        }
        unset($validated['issues_raw']);

        EcosystemDomain::create($validated);

        return redirect()->route('admin.ecosystem.index', ['tab' => 'domains'])
            ->with('success', 'Domain makro berhasil ditambahkan.');
    }

    public function updateDomain(Request $request, EcosystemDomain $domain): RedirectResponse
    {
        $validated = $request->validate([
            'name_id' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:ecosystem_domains,slug,'.$domain->id,
            'tagline_id' => 'nullable|string|max:255',
            'tagline_en' => 'nullable|string|max:255',
            'problem_statement_id' => 'required|string',
            'problem_statement_en' => 'nullable|string',
            'solution_statement_id' => 'nullable|string',
            'solution_statement_en' => 'nullable|string',
            'short_description_id' => 'nullable|string',
            'short_description_en' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
            'icon_file' => 'nullable|image|max:10240',
            'icon_image' => 'nullable|string|max:1000',
            'cover_file' => 'nullable|image|max:10240',
            'cover_image' => 'nullable|string|max:1000',
            'gallery_files.*' => 'nullable|image|max:10240',
            'gallery_raw' => 'nullable|string',
            'program_logo_files.*' => 'nullable|image|max:10240',
            'program_logos_raw' => 'nullable|string',
            'sdgs_raw' => 'nullable|string',
            'issues_raw' => 'nullable|string',
            'status' => 'required|string|in:IDEA,PLANNING,BUILDING,DEVELOPING,OPERATING,COMPLETED,ARCHIVED',
            'visibility' => 'required|string|in:public,private,draft,archived',
            'sort_order' => 'nullable|integer',
            'is_featured' => 'nullable|boolean',
        ]);

        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        // Upload Icon
        if ($request->hasFile('icon_file')) {
            $path = $request->file('icon_file')->store('ecosystem/domains/icons', 'public');
            $validated['icon_image'] = Storage::url($path);
            if (empty($validated['icon'])) {
                $validated['icon'] = $validated['icon_image'];
            }
        } elseif ($request->filled('icon_image')) {
            $validated['icon_image'] = $request->input('icon_image');
        }
        unset($validated['icon_file']);

        // Upload Cover
        if ($request->hasFile('cover_file')) {
            $path = $request->file('cover_file')->store('ecosystem/domains/covers', 'public');
            $validated['cover_image'] = Storage::url($path);
        } elseif ($request->filled('cover_image')) {
            $validated['cover_image'] = $request->input('cover_image');
        }
        unset($validated['cover_file']);

        // Gallery Photos
        $gallery = ! empty($validated['gallery_raw'])
            ? array_filter(array_map('trim', preg_split('/[\n\r,]+/', $validated['gallery_raw'])))
            : ($domain->gallery ?? []);
        if ($request->hasFile('gallery_files')) {
            foreach ($request->file('gallery_files') as $file) {
                $path = $file->store('ecosystem/domains/gallery', 'public');
                $gallery[] = Storage::url($path);
            }
        }
        $validated['gallery'] = array_values(array_unique($gallery));
        unset($validated['gallery_raw'], $validated['gallery_files']);

        // Program / Partner Logos
        $programLogos = ! empty($validated['program_logos_raw'])
            ? array_filter(array_map('trim', preg_split('/[\n\r,]+/', $validated['program_logos_raw'])))
            : ($domain->program_logos ?? []);
        if ($request->hasFile('program_logo_files')) {
            foreach ($request->file('program_logo_files') as $file) {
                $path = $file->store('ecosystem/domains/logos', 'public');
                $programLogos[] = Storage::url($path);
            }
        }
        $validated['program_logos'] = array_values(array_unique($programLogos));
        unset($validated['program_logos_raw'], $validated['program_logo_files']);

        // SDGs
        if ($request->has('sdgs_raw')) {
            $validated['sdgs'] = ! empty($validated['sdgs_raw'])
                ? array_values(array_filter(array_map('trim', preg_split('/[,\n\r]+/', $validated['sdgs_raw']))))
                : [];
        }
        unset($validated['sdgs_raw']);

        // Specific Issues & Solutions
        if ($request->has('issues_raw')) {
            if (! empty($validated['issues_raw'])) {
                $lines = array_filter(array_map('trim', explode("\n", $validated['issues_raw'])));
                $parsedIssues = [];
                foreach ($lines as $line) {
                    if (str_contains($line, '::')) {
                        [$iss, $sol] = explode('::', $line, 2);
                        $parsedIssues[] = ['issue' => trim($iss), 'solution' => trim($sol)];
                    } elseif (str_contains($line, '|')) {
                        [$iss, $sol] = explode('|', $line, 2);
                        $parsedIssues[] = ['issue' => trim($iss), 'solution' => trim($sol)];
                    } else {
                        $parsedIssues[] = [
                            'issue' => trim($line),
                            'solution' => $validated['solution_statement_id'] ?? $domain->solution_statement_id,
                        ];
                    }
                }
                $validated['issues'] = $parsedIssues;
            } else {
                $validated['issues'] = [];
            }
        }
        unset($validated['issues_raw']);

        $domain->update($validated);

        return redirect()->route('admin.ecosystem.index', ['tab' => 'domains'])
            ->with('success', 'Domain makro berhasil diperbarui.');
    }

    public function destroyDomain(EcosystemDomain $domain): RedirectResponse
    {
        $domain->delete();

        return redirect()->route('admin.ecosystem.index', ['tab' => 'domains'])
            ->with('success', 'Domain berhasil dihapus.');
    }

    // -------------------------------------------------------------
    // INITIATIVE / BRAND CRUD
    // -------------------------------------------------------------

    public function storeInitiative(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'domain_id' => 'required|exists:ecosystem_domains,id',
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:ecosystem_initiatives,slug',
            'stage' => 'required|string|max:100',
            'tagline_id' => 'nullable|string|max:255',
            'tagline_en' => 'nullable|string|max:255',
            'problem_statement_id' => 'required|string',
            'problem_statement_en' => 'nullable|string',
            'mission_id' => 'nullable|string',
            'mission_en' => 'nullable|string',
            'story_id' => 'nullable|string',
            'story_en' => 'nullable|string',
            'focus_areas_raw' => 'nullable|string',
            'sdgs_raw' => 'nullable|string',
            'government_issues_raw' => 'nullable|string',
            'locus' => 'nullable|string|max:255',
            'logo_image' => 'nullable|string|max:1000',
            'logo_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:4096',
            'cover_image' => 'nullable|string|max:1000',
            'cover_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:8192',
            'gallery_raw' => 'nullable|string',
            'gallery_files' => 'nullable|array',
            'gallery_files.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:8192',
            'external_website_url' => 'nullable|url|max:1000',
            'external_url_label' => 'nullable|string|max:255',
            'contact_email' => 'nullable|email|max:255',
            'social_instagram' => 'nullable|string|max:255',
            'social_linkedin' => 'nullable|string|max:255',
            'social_github' => 'nullable|string|max:255',
            'social_youtube' => 'nullable|string|max:255',
            'status' => 'required|string|in:IDEA,PLANNING,BUILDING,DEVELOPING,OPERATING,COMPLETED,ARCHIVED',
            'visibility' => 'required|string|in:public,private,draft,archived',
            'sort_order' => 'nullable|integer',
            'is_featured' => 'nullable|boolean',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        $validated['external_url_label'] = $validated['external_url_label'] ?: 'Visit Website →';

        // Handle uploaded logo & cover files
        if ($request->hasFile('logo_file')) {
            $path = $request->file('logo_file')->store('ecosystem/logos', 'public');
            $validated['logo_image'] = Storage::url($path);
        }
        unset($validated['logo_file']);

        if ($request->hasFile('cover_file')) {
            $path = $request->file('cover_file')->store('ecosystem/covers', 'public');
            $validated['cover_image'] = Storage::url($path);
        }
        unset($validated['cover_file']);

        $validated['focus_areas'] = ! empty($validated['focus_areas_raw'])
            ? array_filter(array_map('trim', preg_split('/[,\n\r]+/', $validated['focus_areas_raw'])))
            : [];
        unset($validated['focus_areas_raw']);

        $validated['sdgs'] = ! empty($validated['sdgs_raw'])
            ? array_filter(array_map('trim', preg_split('/[,\n\r]+/', $validated['sdgs_raw'])))
            : [];
        unset($validated['sdgs_raw']);

        $validated['government_issues'] = ! empty($validated['government_issues_raw'])
            ? array_filter(array_map('trim', preg_split('/[,\n\r]+/', $validated['government_issues_raw'])))
            : [];
        unset($validated['government_issues_raw']);

        $gallery = ! empty($validated['gallery_raw'])
            ? array_filter(array_map('trim', preg_split('/[\n\r,]+/', $validated['gallery_raw'])))
            : [];

        if ($request->hasFile('gallery_files')) {
            foreach ($request->file('gallery_files') as $file) {
                $path = $file->store('ecosystem/gallery', 'public');
                $gallery[] = Storage::url($path);
            }
        }
        $validated['gallery'] = array_values(array_unique($gallery));
        unset($validated['gallery_raw'], $validated['gallery_files']);

        $socialLinks = [];
        if (! empty($validated['social_instagram'])) {
            $socialLinks['instagram'] = $validated['social_instagram'];
        }
        if (! empty($validated['social_linkedin'])) {
            $socialLinks['linkedin'] = $validated['social_linkedin'];
        }
        if (! empty($validated['social_github'])) {
            $socialLinks['github'] = $validated['social_github'];
        }
        if (! empty($validated['social_youtube'])) {
            $socialLinks['youtube'] = $validated['social_youtube'];
        }
        $validated['social_links'] = $socialLinks;
        unset($validated['social_instagram'], $validated['social_linkedin'], $validated['social_github'], $validated['social_youtube']);

        EcosystemInitiative::create($validated);

        return redirect()->route('admin.ecosystem.index', ['tab' => 'initiatives'])
            ->with('success', 'Inisiatif / Brand berhasil ditambahkan.');
    }

    public function updateInitiative(Request $request, EcosystemInitiative $initiative): RedirectResponse
    {
        $validated = $request->validate([
            'domain_id' => 'required|exists:ecosystem_domains,id',
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:ecosystem_initiatives,slug,'.$initiative->id,
            'stage' => 'required|string|max:100',
            'tagline_id' => 'nullable|string|max:255',
            'tagline_en' => 'nullable|string|max:255',
            'problem_statement_id' => 'required|string',
            'problem_statement_en' => 'nullable|string',
            'mission_id' => 'nullable|string',
            'mission_en' => 'nullable|string',
            'story_id' => 'nullable|string',
            'story_en' => 'nullable|string',
            'focus_areas_raw' => 'nullable|string',
            'sdgs_raw' => 'nullable|string',
            'government_issues_raw' => 'nullable|string',
            'locus' => 'nullable|string|max:255',
            'logo_image' => 'nullable|string|max:1000',
            'logo_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:4096',
            'cover_image' => 'nullable|string|max:1000',
            'cover_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:8192',
            'gallery_raw' => 'nullable|string',
            'gallery_files' => 'nullable|array',
            'gallery_files.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:8192',
            'external_website_url' => 'nullable|url|max:1000',
            'external_url_label' => 'nullable|string|max:255',
            'contact_email' => 'nullable|email|max:255',
            'social_instagram' => 'nullable|string|max:255',
            'social_linkedin' => 'nullable|string|max:255',
            'social_github' => 'nullable|string|max:255',
            'social_youtube' => 'nullable|string|max:255',
            'status' => 'required|string|in:IDEA,PLANNING,BUILDING,DEVELOPING,OPERATING,COMPLETED,ARCHIVED',
            'visibility' => 'required|string|in:public,private,draft,archived',
            'sort_order' => 'nullable|integer',
            'is_featured' => 'nullable|boolean',
        ]);

        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        $validated['external_url_label'] = $validated['external_url_label'] ?: 'Visit Website →';

        // Handle uploaded logo & cover files
        if ($request->hasFile('logo_file')) {
            $path = $request->file('logo_file')->store('ecosystem/logos', 'public');
            $validated['logo_image'] = Storage::url($path);
        }
        unset($validated['logo_file']);

        if ($request->hasFile('cover_file')) {
            $path = $request->file('cover_file')->store('ecosystem/covers', 'public');
            $validated['cover_image'] = Storage::url($path);
        }
        unset($validated['cover_file']);

        $validated['focus_areas'] = ! empty($validated['focus_areas_raw'])
            ? array_filter(array_map('trim', preg_split('/[,\n\r]+/', $validated['focus_areas_raw'])))
            : [];
        unset($validated['focus_areas_raw']);

        $validated['sdgs'] = ! empty($validated['sdgs_raw'])
            ? array_filter(array_map('trim', preg_split('/[,\n\r]+/', $validated['sdgs_raw'])))
            : [];
        unset($validated['sdgs_raw']);

        $validated['government_issues'] = ! empty($validated['government_issues_raw'])
            ? array_filter(array_map('trim', preg_split('/[,\n\r]+/', $validated['government_issues_raw'])))
            : [];
        unset($validated['government_issues_raw']);

        $gallery = ! empty($validated['gallery_raw'])
            ? array_filter(array_map('trim', preg_split('/[\n\r,]+/', $validated['gallery_raw'])))
            : ($initiative->gallery ?: []);

        if ($request->hasFile('gallery_files')) {
            foreach ($request->file('gallery_files') as $file) {
                $path = $file->store('ecosystem/gallery', 'public');
                $gallery[] = Storage::url($path);
            }
        }
        $validated['gallery'] = array_values(array_unique($gallery));
        unset($validated['gallery_raw'], $validated['gallery_files']);

        $socialLinks = $initiative->social_links ?: [];
        if ($request->has('social_instagram')) {
            $socialLinks['instagram'] = $validated['social_instagram'];
        }
        if ($request->has('social_linkedin')) {
            $socialLinks['linkedin'] = $validated['social_linkedin'];
        }
        if ($request->has('social_github')) {
            $socialLinks['github'] = $validated['social_github'];
        }
        if ($request->has('social_youtube')) {
            $socialLinks['youtube'] = $validated['social_youtube'];
        }
        $validated['social_links'] = array_filter($socialLinks);
        unset($validated['social_instagram'], $validated['social_linkedin'], $validated['social_github'], $validated['social_youtube']);

        $initiative->update($validated);

        return redirect()->route('admin.ecosystem.index', ['tab' => 'initiatives'])
            ->with('success', 'Inisiatif / Brand berhasil diperbarui.');
    }

    public function destroyInitiative(EcosystemInitiative $initiative): RedirectResponse
    {
        $initiative->delete();

        return redirect()->route('admin.ecosystem.index', ['tab' => 'initiatives'])
            ->with('success', 'Inisiatif / Brand berhasil dihapus.');
    }

    // -------------------------------------------------------------
    // PROJECT / PORTFOLIO CRUD
    // -------------------------------------------------------------

    public function storeProject(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'initiative_id' => 'required|exists:ecosystem_initiatives,id',
            'category_id' => 'required|exists:ecosystem_categories,id',
            'type_id' => 'nullable|exists:ecosystem_types,id',
            'client_id' => 'nullable|exists:ecosystem_clients,id',
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:ecosystem_projects,slug',
            'problem_statement_id' => 'required|string',
            'problem_statement_en' => 'nullable|string',
            'solution_statement_id' => 'required|string',
            'solution_statement_en' => 'nullable|string',
            'purpose_id' => 'nullable|string',
            'purpose_en' => 'nullable|string',
            'result_outcome_id' => 'nullable|string',
            'result_outcome_en' => 'nullable|string',
            'description_id' => 'nullable|string',
            'description_en' => 'nullable|string',
            'services_raw' => 'nullable|string',
            'technologies_raw' => 'nullable|string',
            'hero_image' => 'nullable|string|max:1000',
            'hero_image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:8192',
            'cover_image' => 'nullable|string|max:1000',
            'cover_image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:8192',
            'external_url' => 'nullable|url|max:1000',
            'launch_date' => 'nullable|date',
            'status' => 'required|string|in:PLANNING,BUILDING,OPERATING,COMPLETED,ARCHIVED',
            'visibility' => 'required|string|in:public,private,draft,archived',
            'sort_order' => 'nullable|integer',
            'is_featured' => 'nullable|boolean',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        if ($request->hasFile('hero_image_file')) {
            $path = $request->file('hero_image_file')->store('ecosystem/projects', 'public');
            $validated['hero_image'] = Storage::url($path);
        }
        unset($validated['hero_image_file']);

        if ($request->hasFile('cover_image_file')) {
            $path = $request->file('cover_image_file')->store('ecosystem/projects', 'public');
            $validated['cover_image'] = Storage::url($path);
        }
        unset($validated['cover_image_file']);

        if (! empty($validated['services_raw'])) {
            $validated['services_provided'] = array_map('trim', explode(',', $validated['services_raw']));
        }
        if (! empty($validated['technologies_raw'])) {
            $validated['technologies'] = array_map('trim', explode(',', $validated['technologies_raw']));
        }
        unset($validated['services_raw'], $validated['technologies_raw']);

        EcosystemProject::create($validated);

        return redirect()->route('admin.ecosystem.index', ['tab' => 'projects'])
            ->with('success', 'Project / Portofolio berhasil ditambahkan.');
    }

    public function updateProject(Request $request, EcosystemProject $project): RedirectResponse
    {
        $validated = $request->validate([
            'initiative_id' => 'required|exists:ecosystem_initiatives,id',
            'category_id' => 'required|exists:ecosystem_categories,id',
            'type_id' => 'nullable|exists:ecosystem_types,id',
            'client_id' => 'nullable|exists:ecosystem_clients,id',
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:ecosystem_projects,slug,'.$project->id,
            'problem_statement_id' => 'required|string',
            'problem_statement_en' => 'nullable|string',
            'solution_statement_id' => 'required|string',
            'solution_statement_en' => 'nullable|string',
            'purpose_id' => 'nullable|string',
            'purpose_en' => 'nullable|string',
            'result_outcome_id' => 'nullable|string',
            'result_outcome_en' => 'nullable|string',
            'description_id' => 'nullable|string',
            'description_en' => 'nullable|string',
            'services_raw' => 'nullable|string',
            'technologies_raw' => 'nullable|string',
            'hero_image' => 'nullable|string|max:1000',
            'hero_image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:8192',
            'cover_image' => 'nullable|string|max:1000',
            'cover_image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:8192',
            'external_url' => 'nullable|url|max:1000',
            'launch_date' => 'nullable|date',
            'status' => 'required|string|in:PLANNING,BUILDING,OPERATING,COMPLETED,ARCHIVED',
            'visibility' => 'required|string|in:public,private,draft,archived',
            'sort_order' => 'nullable|integer',
            'is_featured' => 'nullable|boolean',
        ]);

        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        if ($request->hasFile('hero_image_file')) {
            $path = $request->file('hero_image_file')->store('ecosystem/projects', 'public');
            $validated['hero_image'] = Storage::url($path);
        }
        unset($validated['hero_image_file']);

        if ($request->hasFile('cover_image_file')) {
            $path = $request->file('cover_image_file')->store('ecosystem/projects', 'public');
            $validated['cover_image'] = Storage::url($path);
        }
        unset($validated['cover_image_file']);

        if (! empty($validated['services_raw'])) {
            $validated['services_provided'] = array_map('trim', explode(',', $validated['services_raw']));
        } else {
            $validated['services_provided'] = [];
        }
        if (! empty($validated['technologies_raw'])) {
            $validated['technologies'] = array_map('trim', explode(',', $validated['technologies_raw']));
        } else {
            $validated['technologies'] = [];
        }
        unset($validated['services_raw'], $validated['technologies_raw']);

        $project->update($validated);

        return redirect()->route('admin.ecosystem.index', ['tab' => 'projects'])
            ->with('success', 'Project / Portofolio berhasil diperbarui.');
    }

    public function destroyProject(EcosystemProject $project): RedirectResponse
    {
        $project->delete();

        return redirect()->route('admin.ecosystem.index', ['tab' => 'projects'])
            ->with('success', 'Project / Portofolio berhasil dihapus.');
    }

    // -------------------------------------------------------------
    // CLIENT CRUD
    // -------------------------------------------------------------

    public function storeClient(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:ecosystem_clients,slug',
            'client_type' => 'required|string|max:100',
            'industry' => 'nullable|string|max:100',
            'location' => 'nullable|string|max:255',
            'logo_image' => 'nullable|string|max:1000',
            'logo_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:4096',
            'website_url' => 'nullable|url|max:1000',
            'description_id' => 'nullable|string',
            'description_en' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }
        $validated['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('logo_file')) {
            $path = $request->file('logo_file')->store('ecosystem/clients', 'public');
            $validated['logo_image'] = Storage::url($path);
        }
        unset($validated['logo_file']);

        EcosystemClient::create($validated);

        return redirect()->route('admin.ecosystem.index', ['tab' => 'clients'])
            ->with('success', 'Klien / Mitra berhasil ditambahkan.');
    }

    public function updateClient(Request $request, EcosystemClient $client): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:ecosystem_clients,slug,'.$client->id,
            'client_type' => 'required|string|max:100',
            'industry' => 'nullable|string|max:100',
            'location' => 'nullable|string|max:255',
            'logo_image' => 'nullable|string|max:1000',
            'logo_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:4096',
            'website_url' => 'nullable|url|max:1000',
            'description_id' => 'nullable|string',
            'description_en' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('logo_file')) {
            $path = $request->file('logo_file')->store('ecosystem/clients', 'public');
            $validated['logo_image'] = Storage::url($path);
        }
        unset($validated['logo_file']);

        $client->update($validated);

        return redirect()->route('admin.ecosystem.index', ['tab' => 'clients'])
            ->with('success', 'Klien / Mitra berhasil diperbarui.');
    }

    public function destroyClient(EcosystemClient $client): RedirectResponse
    {
        $client->delete();

        return redirect()->route('admin.ecosystem.index', ['tab' => 'clients'])
            ->with('success', 'Klien / Mitra berhasil dihapus.');
    }

    // -------------------------------------------------------------
    // DOCUMENT / ESG REPORT CRUD
    // -------------------------------------------------------------

    public function storeDocument(Request $request): RedirectResponse
    {
        if (empty($request->title_id) && ! empty($request->title)) {
            $request->merge(['title_id' => $request->title]);
        }
        if (empty($request->file_type) && ! empty($request->file_format)) {
            $request->merge(['file_type' => strtolower($request->file_format)]);
        }
        if (empty($request->file_type)) {
            $request->merge(['file_type' => 'pdf']);
        }

        $validated = $request->validate([
            'title_id' => 'required|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'slug' => 'nullable|string|max:255|unique:ecosystem_documents,slug',
            'category' => 'required|string|max:100',
            'cover_file' => 'nullable|image|max:10240',
            'cover_image' => 'nullable|string|max:1000',
            'document_file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,zip|max:51200',
            'file_url' => 'nullable|string|max:1000',
            'file_type' => 'required|string|in:pdf,link,external',
            'file_size' => 'nullable|string|max:50',
            'year' => 'nullable|string|max:20',
            'description_id' => 'nullable|string',
            'description_en' => 'nullable|string',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title_id']).'-'.Str::random(4);
        }
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        // Upload Cover (Wajib ada cover)
        if ($request->hasFile('cover_file')) {
            $path = $request->file('cover_file')->store('ecosystem/documents/covers', 'public');
            $validated['cover_image'] = Storage::url($path);
        }

        if (empty($validated['cover_image'])) {
            return back()->withInput()->withErrors(['cover_file' => 'Sampul dokumen (cover image) wajib diunggah atau diisi URL-nya.']);
        }
        unset($validated['cover_file']);

        // Upload Document File (PDF)
        if ($request->hasFile('document_file')) {
            $file = $request->file('document_file');
            $path = $file->store('ecosystem/documents/files', 'public');
            $validated['file_path'] = Storage::url($path);
            if (empty($validated['file_size'])) {
                $bytes = $file->getSize();
                $validated['file_size'] = $bytes >= 1048576
                    ? number_format($bytes / 1048576, 1).' MB'
                    : number_format($bytes / 1024, 0).' KB';
            }
        }
        unset($validated['document_file']);

        EcosystemDocument::create($validated);

        return redirect()->route('admin.ecosystem.index', ['tab' => 'impact'])
            ->with('success', 'Dokumen / Laporan ESG "'.$validated['title_id'].'" berhasil ditambahkan.');
    }

    public function updateDocument(Request $request, EcosystemDocument $document): RedirectResponse
    {
        if (empty($request->title_id) && ! empty($request->title)) {
            $request->merge(['title_id' => $request->title]);
        }
        if (empty($request->file_type) && ! empty($request->file_format)) {
            $request->merge(['file_type' => strtolower($request->file_format)]);
        }
        if (empty($request->file_type)) {
            $request->merge(['file_type' => $document->file_type ?? 'pdf']);
        }

        $validated = $request->validate([
            'title_id' => 'required|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'slug' => 'nullable|string|max:255|unique:ecosystem_documents,slug,'.$document->id,
            'category' => 'required|string|max:100',
            'cover_file' => 'nullable|image|max:10240',
            'cover_image' => 'nullable|string|max:1000',
            'document_file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,zip|max:51200',
            'file_url' => 'nullable|string|max:1000',
            'file_type' => 'required|string|in:pdf,link,external',
            'file_size' => 'nullable|string|max:50',
            'year' => 'nullable|string|max:20',
            'description_id' => 'nullable|string',
            'description_en' => 'nullable|string',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title_id']);
        }
        $validated['is_active'] = $request->boolean('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? $document->sort_order;

        // Update Cover
        if ($request->hasFile('cover_file')) {
            $path = $request->file('cover_file')->store('ecosystem/documents/covers', 'public');
            $validated['cover_image'] = Storage::url($path);
        }
        unset($validated['cover_file']);

        if (empty($validated['cover_image']) && empty($document->cover_image)) {
            return back()->withInput()->withErrors(['cover_file' => 'Sampul dokumen (cover image) wajib ada.']);
        }

        // Update Document File
        if ($request->hasFile('document_file')) {
            $file = $request->file('document_file');
            $path = $file->store('ecosystem/documents/files', 'public');
            $validated['file_path'] = Storage::url($path);
            if (empty($validated['file_size'])) {
                $bytes = $file->getSize();
                $validated['file_size'] = $bytes >= 1048576
                    ? number_format($bytes / 1048576, 1).' MB'
                    : number_format($bytes / 1024, 0).' KB';
            }
        }
        unset($validated['document_file']);

        $document->update($validated);

        return redirect()->route('admin.ecosystem.index', ['tab' => 'impact'])
            ->with('success', 'Dokumen / Laporan ESG "'.$document->title_id.'" berhasil diperbarui.');
    }

    public function destroyDocument(EcosystemDocument $document): RedirectResponse
    {
        $name = $document->title_id;
        $document->delete();

        return redirect()->route('admin.ecosystem.index', ['tab' => 'impact'])
            ->with('success', 'Dokumen / Laporan ESG "'.$name.'" berhasil dihapus.');
    }

    // -------------------------------------------------------------
    // PILLAR UPDATE & GALLERY MANAGEMENT
    // -------------------------------------------------------------

    public function updatePillar(Request $request, EcosystemImpactPillar $pillar): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'title_id' => 'required|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'description_id' => 'required|string',
            'description_en' => 'nullable|string',
            'why_it_matters_id' => 'nullable|string',
            'why_it_matters_en' => 'nullable|string',
            'what_we_do_id' => 'nullable|string',
            'what_we_do_en' => 'nullable|string',
            'sdgs_raw' => 'nullable|string',
            'global_programs_raw' => 'nullable|string',
            'national_programs_raw' => 'nullable|string',
            'target_beneficiaries' => 'nullable|string|max:255',
            'youtube_url' => 'nullable|string|max:1000',
            'metric_value' => 'nullable|string|max:100',
            'metric_label_id' => 'nullable|string|max:255',
            'metric_label_en' => 'nullable|string|max:255',
            'target_url' => 'nullable|url|max:1000',
            'action_label' => 'nullable|string|max:255',
            'photo_file' => 'nullable|image|max:10240',
            'photo_image' => 'nullable|string|max:1000',
            'gallery_files.*' => 'nullable|image|max:10240',
            'gallery_raw' => 'nullable|string',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['sort_order'] = $validated['sort_order'] ?? $pillar->sort_order;

        // Parse array textareas
        if ($request->has('sdgs_raw')) {
            $validated['sdgs'] = ! empty($request->input('sdgs_raw'))
                ? array_values(array_filter(array_map('trim', preg_split('/[\n\r,]+/', $request->input('sdgs_raw')))))
                : [];
            unset($validated['sdgs_raw']);
        }

        if ($request->has('global_programs_raw')) {
            $validated['global_programs'] = ! empty($request->input('global_programs_raw'))
                ? array_values(array_filter(array_map('trim', preg_split('/[\n\r,]+/', $request->input('global_programs_raw')))))
                : [];
            unset($validated['global_programs_raw']);
        }

        if ($request->has('national_programs_raw')) {
            $validated['national_programs'] = ! empty($request->input('national_programs_raw'))
                ? array_values(array_filter(array_map('trim', preg_split('/[\n\r,]+/', $request->input('national_programs_raw')))))
                : [];
            unset($validated['national_programs_raw']);
        }

        if ($request->hasFile('photo_file')) {
            $path = $request->file('photo_file')->store('ecosystem/pillars', 'public');
            $validated['photo_image'] = Storage::url($path);
        }
        unset($validated['photo_file']);

        // Handle gallery
        $gallery = ! empty($validated['gallery_raw'])
            ? array_filter(array_map('trim', preg_split('/[\n\r,]+/', $validated['gallery_raw'])))
            : ($pillar->gallery ?? []);

        if ($request->hasFile('gallery_files')) {
            foreach ($request->file('gallery_files') as $file) {
                $path = $file->store('ecosystem/pillars/gallery', 'public');
                $gallery[] = Storage::url($path);
            }
        }
        $validated['gallery'] = array_values(array_unique($gallery));
        unset($validated['gallery_raw'], $validated['gallery_files']);

        $pillar->update($validated);

        return redirect()->route('admin.ecosystem.index', ['tab' => 'impact'])
            ->with('success', 'Pilar #'.$pillar->pillar_number.' ('.$pillar->name.') berhasil diperbarui.');
    }

    // -------------------------------------------------------------
    // IMPACT METRICS (STATISTIK DAMPAK) CRUD
    // -------------------------------------------------------------

    public function storeMetric(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'metric_value' => 'required|string|max:100',
            'label_id' => 'required|string|max:255',
            'label_en' => 'nullable|string|max:255',
            'description_id' => 'nullable|string',
            'description_en' => 'nullable|string',
            'icon' => 'nullable|string|max:100',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        EcosystemImpactMetric::create($validated);

        return redirect()->route('admin.ecosystem.index', ['tab' => 'impact'])
            ->with('success', 'Angka statistik dampak berhasil ditambahkan.');
    }

    public function updateMetric(Request $request, EcosystemImpactMetric $metric): RedirectResponse
    {
        $validated = $request->validate([
            'metric_value' => 'required|string|max:100',
            'label_id' => 'required|string|max:255',
            'label_en' => 'nullable|string|max:255',
            'description_id' => 'nullable|string',
            'description_en' => 'nullable|string',
            'icon' => 'nullable|string|max:100',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? $metric->sort_order;

        $metric->update($validated);

        return redirect()->route('admin.ecosystem.index', ['tab' => 'impact'])
            ->with('success', 'Angka statistik dampak berhasil diperbarui.');
    }

    public function destroyMetric(EcosystemImpactMetric $metric): RedirectResponse
    {
        $label = $metric->label_id;
        $metric->delete();

        return redirect()->route('admin.ecosystem.index', ['tab' => 'impact'])
            ->with('success', 'Angka statistik dampak "'.$label.'" berhasil dihapus.');
    }

    // -------------------------------------------------------------
    // PRODUCT CRUD
    // -------------------------------------------------------------

    public function storeProduct(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'initiative_id' => 'required|exists:ecosystem_initiatives,id',
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:ecosystem_products,slug',
            'type' => 'required|string|max:100',
            'problem_statement_id' => 'nullable|string',
            'problem_statement_en' => 'nullable|string',
            'solution_statement_id' => 'nullable|string',
            'solution_statement_en' => 'nullable|string',
            'description_id' => 'nullable|string',
            'description_en' => 'nullable|string',
            'website_url' => 'nullable|url|max:1000',
            'hero_image' => 'nullable|string|max:1000',
            'hero_image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:8192',
            'status' => 'required|string|in:PLANNING,BUILDING,OPERATING,COMPLETED,ARCHIVED',
            'visibility' => 'required|string|in:public,private,draft,archived',
            'sort_order' => 'nullable|integer',
            'is_featured' => 'nullable|boolean',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        if ($request->hasFile('hero_image_file')) {
            $path = $request->file('hero_image_file')->store('ecosystem/products', 'public');
            $validated['hero_image'] = Storage::url($path);
        }
        unset($validated['hero_image_file']);

        EcosystemProduct::create($validated);

        return redirect()->route('admin.ecosystem.index', ['tab' => 'products'])
            ->with('success', 'Produk & Solusi berhasil ditambahkan.');
    }

    public function updateProduct(Request $request, EcosystemProduct $product): RedirectResponse
    {
        $validated = $request->validate([
            'initiative_id' => 'required|exists:ecosystem_initiatives,id',
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:ecosystem_products,slug,'.$product->id,
            'type' => 'required|string|max:100',
            'problem_statement_id' => 'nullable|string',
            'problem_statement_en' => 'nullable|string',
            'solution_statement_id' => 'nullable|string',
            'solution_statement_en' => 'nullable|string',
            'description_id' => 'nullable|string',
            'description_en' => 'nullable|string',
            'website_url' => 'nullable|url|max:1000',
            'hero_image' => 'nullable|string|max:1000',
            'hero_image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:8192',
            'status' => 'required|string|in:PLANNING,BUILDING,OPERATING,COMPLETED,ARCHIVED',
            'visibility' => 'required|string|in:public,private,draft,archived',
            'sort_order' => 'nullable|integer',
            'is_featured' => 'nullable|boolean',
        ]);

        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['sort_order'] = $validated['sort_order'] ?? $product->sort_order;

        if ($request->hasFile('hero_image_file')) {
            $path = $request->file('hero_image_file')->store('ecosystem/products', 'public');
            $validated['hero_image'] = Storage::url($path);
        }
        unset($validated['hero_image_file']);

        $product->update($validated);

        return redirect()->route('admin.ecosystem.index', ['tab' => 'products'])
            ->with('success', 'Produk "'.$product->name.'" berhasil diperbarui.');
    }

    public function destroyProduct(EcosystemProduct $product): RedirectResponse
    {
        $name = $product->name;
        $product->delete();

        return redirect()->route('admin.ecosystem.index', ['tab' => 'products'])
            ->with('success', 'Produk "'.$name.'" berhasil dihapus.');
    }
}
