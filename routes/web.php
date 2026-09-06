<?php

use App\Http\Controllers\AboutPublicController;
use App\Http\Controllers\ArticleAdminController;
use App\Http\Controllers\ArticleCategoryAdminController;
use App\Http\Controllers\ArticlePublicController;
use App\Http\Controllers\CollaborationAdminController;
use App\Http\Controllers\CollaborationPublicController;
use App\Http\Controllers\CompanyAchievementAdminController;
use App\Http\Controllers\CompanyProfileAdminController;
use App\Http\Controllers\DashboardAdminController;
use App\Http\Controllers\EcosystemAdminController;
use App\Http\Controllers\EcosystemPublicController;
use App\Http\Controllers\InvestAdminController;
use App\Http\Controllers\LegalPublicController;
use App\Http\Controllers\MenuHighlightAdminController;
use App\Http\Controllers\PeopleAdminController;
use App\Http\Controllers\PeoplePublicController;
use App\Http\Controllers\PortfolioPublicController;
use App\Http\Controllers\ProfileController;
use App\Models\Article;
use App\Models\EcosystemClient;
use App\Models\EcosystemDocument;
use App\Models\EcosystemDomain;
use App\Models\EcosystemImpactPillar;
use App\Models\FounderStory;
use App\Models\Person;
use Illuminate\Support\Facades\Route;

// Public Homepage with Dynamic Featured Initiatives / Articles
Route::get('/', function () {
    $featuredArticles = Article::published()
        ->featured()
        ->latest('published_at')
        ->take(6)
        ->get();

    $ecosystemDomains = EcosystemDomain::with(['initiatives' => function ($q) {
        $q->where('visibility', 'public')->orderBy('sort_order');
    }])
        ->where('visibility', 'public')
        ->orderBy('sort_order')
        ->get();

    $impactPillars = EcosystemImpactPillar::active()->get();
    $impactDocuments = EcosystemDocument::active()->orderBy('sort_order')->get();

    $peopleStats = [
        'founders_count' => Person::where('category', 'founder')->active()->count(),
        'team_count' => Person::where('category', 'tim')->active()->count(),
        'contributors_count' => Person::where('category', 'kontributor')->active()->count(),
        'collaborators_count' => EcosystemClient::count(),
        'stories_count' => FounderStory::published()->count(),
    ];
    $primaryFounder = Person::where('category', 'founder')->active()->orderBy('sort_order')->first();

    return view('public.home', compact(
        'featuredArticles',
        'ecosystemDomains',
        'impactPillars',
        'impactDocuments',
        'peopleStats',
        'primaryFounder'
    ));
});

// Public Articles, Publications, Journals & Blog Routes
Route::get('/publikasi', [ArticlePublicController::class, 'index'])->name('public.articles.index');
Route::get('/publikasi/{slug}', [ArticlePublicController::class, 'show'])->name('public.articles.show');
Route::redirect('/jurnal', '/publikasi');
Route::redirect('/artikel', '/publikasi');
Route::redirect('/blog', '/publikasi');

// Public Collaboration Hub & Tracks
Route::get('/kolaborasi', [CollaborationPublicController::class, 'index'])->name('public.collaboration.index');
Route::post('/kolaborasi/inquiry', [CollaborationPublicController::class, 'storeInquiry'])->name('public.collaboration.inquiry');
Route::get('/kolaborasi/{slug}', [CollaborationPublicController::class, 'show'])->name('public.collaboration.show');
Route::redirect('/kemitraan', '/kolaborasi#kemitraan');
Route::redirect('/magang', '/kolaborasi#magang');
Route::redirect('/riset', '/kolaborasi#riset');
Route::redirect('/kunjungan', '/kolaborasi#kunjungan');
Route::redirect('/kegiatan', '/kolaborasi#kegiatan');
Route::redirect('/project', '/kolaborasi#project');

// Public About Us Routes (Profile, Invest, Pencapaian/Achievements)
Route::get('/tentang-kami', [AboutPublicController::class, 'index'])->name('public.about.index');
Route::get('/tentang-kami/profil', [AboutPublicController::class, 'profile'])->name('public.about.profile');
Route::get('/tentang-kami/invest', [AboutPublicController::class, 'invest'])->name('public.about.invest');
Route::get('/tentang-kami/pencapaian', [AboutPublicController::class, 'achievements'])->name('public.about.achievements');
Route::get('/tentang-kami/story', [AboutPublicController::class, 'story'])->name('public.about.story');
Route::redirect('/about', '/tentang-kami');
Route::redirect('/profil', '/tentang-kami/profil');
Route::redirect('/invest', '/tentang-kami/invest');
Route::redirect('/investor', '/tentang-kami/invest');
Route::redirect('/tentang-kami/investasi', '/tentang-kami/invest');
Route::redirect('/tentang-kami/perjalanan', '/tentang-kami/story');
Route::redirect('/story', '/tentang-kami/pencapaian');
Route::redirect('/pencapaian', '/tentang-kami/pencapaian');
Route::redirect('/prestasi', '/tentang-kami/pencapaian');
Route::redirect('/penghargaan', '/tentang-kami/pencapaian');
Route::redirect('/sertifikat', '/tentang-kami/pencapaian');

// Super Admin Analytics & SEO Dashboard
Route::get('/dashboard', [DashboardAdminController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

// Authenticated Admin Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Super Admin Analytics & Excel Export
    Route::get('admin/dashboard', [DashboardAdminController::class, 'index'])->name('admin.dashboard');
    Route::get('admin/dashboard/export-excel', [DashboardAdminController::class, 'exportExcel'])->name('admin.dashboard.export-excel');

    // Article & Publication CMS Resource & Media Upload
    Route::post('admin/articles/upload-image', [ArticleAdminController::class, 'uploadImage'])->name('admin.articles.upload-image');
    Route::resource('admin/articles', ArticleAdminController::class, ['as' => 'admin']);

    // Article Categories & Photos Manager (Dayan Style)
    Route::get('admin/article-categories', [ArticleCategoryAdminController::class, 'index'])->name('admin.article-categories.index');
    Route::post('admin/article-categories', [ArticleCategoryAdminController::class, 'store'])->name('admin.article-categories.store');
    Route::put('admin/article-categories/{category}', [ArticleCategoryAdminController::class, 'update'])->name('admin.article-categories.update');
    Route::delete('admin/article-categories/{category}', [ArticleCategoryAdminController::class, 'destroy'])->name('admin.article-categories.destroy');

    // Collaborations & Inquiries Manager
    Route::resource('admin/collaborations', CollaborationAdminController::class, ['as' => 'admin'])->only(['index', 'edit', 'update']);
    Route::get('admin/collaborations/inquiries/{inquiry}', [CollaborationAdminController::class, 'showInquiry'])->name('admin.collaborations.inquiries.show');
    Route::put('admin/collaborations/inquiries/{inquiry}', [CollaborationAdminController::class, 'updateInquiry'])->name('admin.collaborations.inquiries.update');
    Route::delete('admin/collaborations/inquiries/{inquiry}', [CollaborationAdminController::class, 'destroyInquiry'])->name('admin.collaborations.inquiries.destroy');
    Route::post('admin/collaborations/inquiries/{inquiry}/toggle-read', [CollaborationAdminController::class, 'toggleReadInquiry'])->name('admin.collaborations.inquiries.toggle-read');

    // Menu Highlights & Photos Manager
    Route::get('admin/menu-highlights', [MenuHighlightAdminController::class, 'index'])->name('admin.menu-highlights.index');
    Route::put('admin/menu-highlights/{menuHighlight}', [MenuHighlightAdminController::class, 'update'])->name('admin.menu-highlights.update');

    // Company Profile & Official Identity Manager (Quill Rich Text Editor)
    Route::get('admin/company-profile', [CompanyProfileAdminController::class, 'edit'])->name('admin.company-profile.edit');
    Route::put('admin/company-profile', [CompanyProfileAdminController::class, 'update'])->name('admin.company-profile.update');
    Route::post('admin/company-profile/upload-image', [CompanyProfileAdminController::class, 'uploadImage'])->name('admin.company-profile.upload-image');

    // Company Achievements, Awards & Recognition CMS (Quill Editor & Photo Cards)
    Route::get('admin/achievements', [CompanyAchievementAdminController::class, 'index'])->name('admin.achievements.index');
    Route::post('admin/achievements', [CompanyAchievementAdminController::class, 'store'])->name('admin.achievements.store');
    Route::put('admin/achievements/{achievement}', [CompanyAchievementAdminController::class, 'update'])->name('admin.achievements.update');
    Route::delete('admin/achievements/{achievement}', [CompanyAchievementAdminController::class, 'destroy'])->name('admin.achievements.destroy');
    Route::put('admin/achievements-narrative', [CompanyAchievementAdminController::class, 'updateNarrative'])->name('admin.achievements.narrative');
    Route::post('admin/achievements/upload-image', [CompanyAchievementAdminController::class, 'uploadImage'])->name('admin.achievements.upload-image');

    // Investment & Capital Synergy CMS (Quill Editor & Metrics)
    Route::get('admin/invest', [InvestAdminController::class, 'edit'])->name('admin.invest.edit');
    Route::put('admin/invest', [InvestAdminController::class, 'update'])->name('admin.invest.update');
    Route::post('admin/invest/upload-image', [InvestAdminController::class, 'uploadImage'])->name('admin.invest.upload-image');

    // Central Ecosystem & Portfolio Management
    Route::get('admin/ecosystem', [EcosystemAdminController::class, 'index'])->name('admin.ecosystem.index');
    Route::post('admin/ecosystem/domains', [EcosystemAdminController::class, 'storeDomain'])->name('admin.ecosystem.domains.store');
    Route::put('admin/ecosystem/domains/{domain}', [EcosystemAdminController::class, 'updateDomain'])->name('admin.ecosystem.domains.update');
    Route::delete('admin/ecosystem/domains/{domain}', [EcosystemAdminController::class, 'destroyDomain'])->name('admin.ecosystem.domains.destroy');

    Route::post('admin/ecosystem/initiatives', [EcosystemAdminController::class, 'storeInitiative'])->name('admin.ecosystem.initiatives.store');
    Route::put('admin/ecosystem/initiatives/{initiative}', [EcosystemAdminController::class, 'updateInitiative'])->name('admin.ecosystem.initiatives.update');
    Route::delete('admin/ecosystem/initiatives/{initiative}', [EcosystemAdminController::class, 'destroyInitiative'])->name('admin.ecosystem.initiatives.destroy');

    Route::post('admin/ecosystem/projects', [EcosystemAdminController::class, 'storeProject'])->name('admin.ecosystem.projects.store');
    Route::put('admin/ecosystem/projects/{project}', [EcosystemAdminController::class, 'updateProject'])->name('admin.ecosystem.projects.update');
    Route::delete('admin/ecosystem/projects/{project}', [EcosystemAdminController::class, 'destroyProject'])->name('admin.ecosystem.projects.destroy');

    Route::post('admin/ecosystem/clients', [EcosystemAdminController::class, 'storeClient'])->name('admin.ecosystem.clients.store');
    Route::put('admin/ecosystem/clients/{client}', [EcosystemAdminController::class, 'updateClient'])->name('admin.ecosystem.clients.update');
    Route::delete('admin/ecosystem/clients/{client}', [EcosystemAdminController::class, 'destroyClient'])->name('admin.ecosystem.clients.destroy');

    Route::post('admin/ecosystem/documents', [EcosystemAdminController::class, 'storeDocument'])->name('admin.ecosystem.documents.store');
    Route::put('admin/ecosystem/documents/{document}', [EcosystemAdminController::class, 'updateDocument'])->name('admin.ecosystem.documents.update');
    Route::delete('admin/ecosystem/documents/{document}', [EcosystemAdminController::class, 'destroyDocument'])->name('admin.ecosystem.documents.destroy');

    Route::post('admin/ecosystem/metrics', [EcosystemAdminController::class, 'storeMetric'])->name('admin.ecosystem.metrics.store');
    Route::put('admin/ecosystem/metrics/{metric}', [EcosystemAdminController::class, 'updateMetric'])->name('admin.ecosystem.metrics.update');
    Route::delete('admin/ecosystem/metrics/{metric}', [EcosystemAdminController::class, 'destroyMetric'])->name('admin.ecosystem.metrics.destroy');

    Route::post('admin/ecosystem/products', [EcosystemAdminController::class, 'storeProduct'])->name('admin.ecosystem.products.store');
    Route::put('admin/ecosystem/products/{product}', [EcosystemAdminController::class, 'updateProduct'])->name('admin.ecosystem.products.update');
    Route::delete('admin/ecosystem/products/{product}', [EcosystemAdminController::class, 'destroyProduct'])->name('admin.ecosystem.products.destroy');

    Route::put('admin/ecosystem/pillars/{pillar}', [EcosystemAdminController::class, 'updatePillar'])->name('admin.ecosystem.pillars.update');

    // People & Team Management (Founders, Novel Stories, Core Team, Contributors, Excel Import/Export)
    Route::get('admin/people/export-excel', [PeopleAdminController::class, 'exportExcel'])->name('admin.people.export-excel');
    Route::get('admin/people/download-template', [PeopleAdminController::class, 'downloadTemplate'])->name('admin.people.download-template');
    Route::post('admin/people/import-excel', [PeopleAdminController::class, 'importExcel'])->name('admin.people.import-excel');
    Route::post('admin/people/stories/upload-image', [PeopleAdminController::class, 'uploadStoryImage'])->name('admin.people.stories.upload-image');
    Route::post('admin/people/stories', [PeopleAdminController::class, 'storeStory'])->name('admin.people.stories.store');
    Route::put('admin/people/stories/{story}', [PeopleAdminController::class, 'updateStory'])->name('admin.people.stories.update');
    Route::delete('admin/people/stories/{story}', [PeopleAdminController::class, 'destroyStory'])->name('admin.people.stories.destroy');
    Route::resource('admin/people', PeopleAdminController::class, ['as' => 'admin'])->only(['index', 'store', 'update', 'destroy']);
});

// Public Ecosystem Gateway & Directory Routes
Route::get('/ekosistem', [EcosystemPublicController::class, 'index'])->name('public.ecosystem.index');
Route::get('/ekosistem/domain/{slug}', [EcosystemPublicController::class, 'domain'])->name('public.ecosystem.domain');
Route::get('/ekosistem/inisiatif/{slug}', [EcosystemPublicController::class, 'initiative'])->name('public.ecosystem.initiative');
Route::redirect('/ecosystem', '/ekosistem');

// Public Impact & ESG Dedicated Routes
Route::get('/dampak', [EcosystemPublicController::class, 'impact'])->name('public.impact.index');
Route::get('/dampak/pilar/{code}', [EcosystemPublicController::class, 'pillarDetail'])->name('public.impact.pillar');
Route::redirect('/impact', '/dampak');

// Public Portfolio & Case Studies Directory Routes
Route::get('/portofolio', [PortfolioPublicController::class, 'index'])->name('public.portfolio.index');
Route::get('/portofolio/{slug}', [PortfolioPublicController::class, 'show'])->name('public.portfolio.show');
Route::redirect('/portfolio', '/portofolio');

// Public People & Team Directory (Founders, Kisah Cerpen/Novel, Tim Inti, Kontributor, Mitra)
Route::get('/people', [PeoplePublicController::class, 'index'])->name('public.people.index');
Route::get('/people/founder', [PeoplePublicController::class, 'founders'])->name('public.people.founder.index');
Route::get('/people/founder/{slug}', [PeoplePublicController::class, 'founderDetail'])->name('public.people.founder.show');
Route::get('/people/storyfounder', [PeoplePublicController::class, 'storyfounder'])->name('public.people.storyfounder.index');
Route::get('/people/storyfounder/{slug}', [PeoplePublicController::class, 'storyfounderDetail'])->name('public.people.storyfounder.show');
Route::get('/people/tim', [PeoplePublicController::class, 'tim'])->name('public.people.tim.index');
Route::get('/people/kontributor', [PeoplePublicController::class, 'kontributor'])->name('public.people.kontributor.index');
Route::get('/people/kontributor/{slug}', [PeoplePublicController::class, 'kontributorDetail'])->name('public.people.kontributor.show');
Route::get('/people/mitra', [PeoplePublicController::class, 'mitra'])->name('public.people.mitra.index');
Route::get('/people/mitra/{slug}', [PeoplePublicController::class, 'mitraDetail'])->name('public.people.mitra.show');

// Helpful aliases / redirects
Route::redirect('/founder', '/people/founder');
Route::redirect('/storyfounder', '/people/storyfounder');
Route::redirect('/tim', '/people/tim');
Route::redirect('/kontributor', '/people/kontributor');
Route::redirect('/mitra', '/people/mitra');
Route::redirect('/insan', '/people');

// Public Legal, Compliance & Information Security Routes (100% Bilingual ID & EN)
Route::get('/syarat-ketentuan', [LegalPublicController::class, 'terms'])->name('public.legal.terms');
Route::get('/kebijakan-privasi', [LegalPublicController::class, 'privacy'])->name('public.legal.privacy');
Route::get('/keamanan-informasi', [LegalPublicController::class, 'security'])->name('public.legal.security');

Route::redirect('/terms', '/syarat-ketentuan');
Route::redirect('/terms-and-conditions', '/syarat-ketentuan');
Route::redirect('/privacy', '/kebijakan-privasi');
Route::redirect('/privacy-policy', '/kebijakan-privasi');
Route::redirect('/security', '/keamanan-informasi');
Route::redirect('/keamanan', '/keamanan-informasi');
Route::redirect('/information-security', '/keamanan-informasi');

require __DIR__.'/auth.php';
