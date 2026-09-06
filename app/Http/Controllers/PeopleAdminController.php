<?php

namespace App\Http\Controllers;

use App\Models\EcosystemClient;
use App\Models\EcosystemInitiative;
use App\Models\FounderStory;
use App\Models\Person;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;
use ZipArchive;

class PeopleAdminController extends Controller
{
    /**
     * Display the unified People management dashboard.
     */
    public function index(Request $request): View
    {
        $activeTab = $request->query('tab', 'founders');

        $founders = Person::founders()->orderBy('sort_order')->orderBy('id')->get();
        $team = Person::team()->with('initiative')->orderBy('sort_order')->orderBy('id')->get();
        $contributors = Person::contributors()->with('initiative')->orderBy('sort_order')->orderBy('id')->get();
        $stories = FounderStory::with('person')->orderBy('sort_order')->orderBy('id')->get();
        $clients = EcosystemClient::orderBy('sort_order')->orderBy('name')->get();
        $initiatives = EcosystemInitiative::orderBy('sort_order')->get();

        $foundersCount = $founders->count();
        $teamCount = $team->count();
        $contributorsCount = $contributors->count();
        $storiesCount = $stories->count();
        $totalPeople = $foundersCount + $teamCount + $contributorsCount;

        $stats = [
            'total_founders' => $foundersCount,
            'total_team' => $teamCount,
            'active_team' => $team->where('is_active', true)->count(),
            'total_contributors' => $contributorsCount,
            'total_stories' => $storiesCount,
            'total_mitra' => $clients->count(),
            'total_people' => $totalPeople,
        ];

        return view('admin.people.index', compact(
            'activeTab',
            'founders',
            'team',
            'contributors',
            'stories',
            'clients',
            'initiatives',
            'stats',
            'totalPeople',
            'foundersCount',
            'teamCount',
            'contributorsCount',
            'storiesCount'
        ));
    }

    /**
     * Store a new person (Founder, Core Team, or Contributor).
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'category' => 'required|string|in:founder,tim,kontributor',
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:people,slug',
            'role_id' => 'required|string|max:255',
            'role_en' => 'nullable|string|max:255',
            'bio_id' => 'nullable|string',
            'bio_en' => 'nullable|string',
            'photo' => 'nullable',
            'photo_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:8192',
            'initiative_id' => 'nullable|exists:ecosystem_initiatives,id',
            'is_active' => 'nullable|boolean',
            'contribution_type' => 'nullable|string|max:100',
            'organization' => 'nullable|string|max:255',
            'period' => 'nullable|string|max:100',
            'story_html' => 'nullable|string',
            'sort_order' => 'nullable|integer',
            'visibility' => 'nullable|string|in:public,internal,draft,archived',

            // Social links
            'social_linkedin' => 'nullable|url|max:500',
            'social_instagram' => 'nullable|url|max:500',
            'social_github' => 'nullable|url|max:500',
            'social_twitter' => 'nullable|url|max:500',
            'social_website' => 'nullable|url|max:500',
            'social_email' => 'nullable|email|max:255',

            // JSON Meta inputs
            'quote' => 'nullable|string',
            'skills_raw' => 'nullable|string',
            'trajectory_raw' => 'nullable|string',
            'meta_quote' => 'nullable|string',
            'meta_philosophy' => 'nullable|string',
            'meta_skills_raw' => 'nullable|string',
            'meta_highlights_raw' => 'nullable|string',
            'meta_testimony' => 'nullable|string',
            'meta_project_name' => 'nullable|string',
            'meta_custom_json' => 'nullable|string',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        $validated['visibility'] = $validated['visibility'] ?? 'public';

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('people', 'public');
            $validated['photo'] = Storage::url($path);
        } elseif ($request->hasFile('photo_file')) {
            $path = $request->file('photo_file')->store('people', 'public');
            $validated['photo'] = Storage::url($path);
        } elseif (is_string($request->input('photo')) && ! empty($request->input('photo'))) {
            $validated['photo'] = $request->input('photo');
        } else {
            unset($validated['photo']);
        }
        unset($validated['photo_file']);

        // Build social links JSON
        $socialLinks = [];
        foreach (['linkedin', 'instagram', 'github', 'twitter', 'website', 'email'] as $platform) {
            $field = 'social_'.$platform;
            if (! empty($validated[$field])) {
                $socialLinks[$platform] = $validated[$field];
            }
            unset($validated[$field]);
        }
        $validated['social_links'] = $socialLinks;

        // Build meta JSON
        $meta = [];
        $quote = $request->input('quote', $request->input('meta_quote'));
        if (! empty($quote)) {
            $meta['quote'] = $quote;
        }
        if (! empty($validated['meta_philosophy'])) {
            $meta['philosophy'] = $validated['meta_philosophy'];
        }
        if (! empty($validated['meta_testimony'])) {
            $meta['testimony'] = $validated['meta_testimony'];
        }
        if (! empty($validated['meta_project_name'])) {
            $meta['project_name'] = $validated['meta_project_name'];
        }
        $skillsRaw = $request->input('skills_raw', $request->input('meta_skills_raw'));
        if (! empty($skillsRaw)) {
            $meta['skills'] = array_values(array_filter(array_map('trim', preg_split('/[,\n\r]+/', $skillsRaw))));
        }
        $trajectoryRaw = $request->input('trajectory_raw', $request->input('meta_highlights_raw'));
        if (! empty($trajectoryRaw)) {
            $meta['trajectory'] = array_values(array_filter(array_map('trim', preg_split('/[\n\r]+/', $trajectoryRaw))));
        }
        if (! empty($validated['meta_custom_json'])) {
            $custom = json_decode($validated['meta_custom_json'], true);
            if (is_array($custom)) {
                $meta = array_merge($meta, $custom);
            }
        }
        unset(
            $validated['quote'],
            $validated['skills_raw'],
            $validated['trajectory_raw'],
            $validated['meta_quote'],
            $validated['meta_philosophy'],
            $validated['meta_skills_raw'],
            $validated['meta_highlights_raw'],
            $validated['meta_testimony'],
            $validated['meta_project_name'],
            $validated['meta_custom_json']
        );
        $validated['meta'] = $meta;

        $person = Person::create($validated);

        $tab = match ($person->category) {
            'founder' => 'founders',
            'tim' => 'team',
            'kontributor' => 'contributors',
            default => 'founders',
        };

        return redirect()->route('admin.people.index', ['tab' => $tab])
            ->with('success', 'Data '.$person->name.' berhasil ditambahkan.');
    }

    /**
     * Update an existing person.
     */
    public function update(Request $request, Person $person): RedirectResponse
    {
        $validated = $request->validate([
            'category' => 'required|string|in:founder,tim,kontributor',
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:people,slug,'.$person->id,
            'role_id' => 'required|string|max:255',
            'role_en' => 'nullable|string|max:255',
            'bio_id' => 'nullable|string',
            'bio_en' => 'nullable|string',
            'photo' => 'nullable',
            'photo_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:8192',
            'initiative_id' => 'nullable|exists:ecosystem_initiatives,id',
            'is_active' => 'nullable|boolean',
            'contribution_type' => 'nullable|string|max:100',
            'organization' => 'nullable|string|max:255',
            'period' => 'nullable|string|max:100',
            'story_html' => 'nullable|string',
            'sort_order' => 'nullable|integer',
            'visibility' => 'nullable|string|in:public,internal,draft,archived',

            // Social links
            'social_linkedin' => 'nullable|url|max:500',
            'social_instagram' => 'nullable|url|max:500',
            'social_github' => 'nullable|url|max:500',
            'social_twitter' => 'nullable|url|max:500',
            'social_website' => 'nullable|url|max:500',
            'social_email' => 'nullable|email|max:255',

            // JSON Meta inputs
            'quote' => 'nullable|string',
            'skills_raw' => 'nullable|string',
            'trajectory_raw' => 'nullable|string',
            'meta_quote' => 'nullable|string',
            'meta_philosophy' => 'nullable|string',
            'meta_skills_raw' => 'nullable|string',
            'meta_highlights_raw' => 'nullable|string',
            'meta_testimony' => 'nullable|string',
            'meta_project_name' => 'nullable|string',
            'meta_custom_json' => 'nullable|string',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = $person->slug ?: Str::slug($validated['name']);
        }

        $validated['is_active'] = $request->boolean('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? $person->sort_order;
        $validated['visibility'] = $validated['visibility'] ?? $person->visibility ?? 'public';

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('people', 'public');
            $validated['photo'] = Storage::url($path);
        } elseif ($request->hasFile('photo_file')) {
            $path = $request->file('photo_file')->store('people', 'public');
            $validated['photo'] = Storage::url($path);
        } elseif (is_string($request->input('photo')) && ! empty($request->input('photo'))) {
            $validated['photo'] = $request->input('photo');
        } else {
            unset($validated['photo']);
        }
        unset($validated['photo_file']);

        // Build social links JSON
        $socialLinks = $person->social_links ?? [];
        foreach (['linkedin', 'instagram', 'github', 'twitter', 'website', 'email'] as $platform) {
            $field = 'social_'.$platform;
            if ($request->has($field)) {
                if (! empty($validated[$field])) {
                    $socialLinks[$platform] = $validated[$field];
                } else {
                    unset($socialLinks[$platform]);
                }
            }
            unset($validated[$field]);
        }
        $validated['social_links'] = $socialLinks;

        // Build meta JSON
        $meta = $person->meta ?? [];
        $quote = $request->input('quote', $request->input('meta_quote'));
        if ($quote !== null) {
            $meta['quote'] = $quote;
        }
        if ($request->filled('meta_philosophy')) {
            $meta['philosophy'] = $validated['meta_philosophy'];
        }
        if ($request->filled('meta_testimony')) {
            $meta['testimony'] = $validated['meta_testimony'];
        }
        if ($request->filled('meta_project_name')) {
            $meta['project_name'] = $validated['meta_project_name'];
        }
        $skillsRaw = $request->input('skills_raw', $request->input('meta_skills_raw'));
        if ($skillsRaw !== null) {
            $meta['skills'] = array_values(array_filter(array_map('trim', preg_split('/[,\n\r]+/', $skillsRaw))));
        }
        $trajectoryRaw = $request->input('trajectory_raw', $request->input('meta_highlights_raw'));
        if ($trajectoryRaw !== null) {
            $meta['trajectory'] = array_values(array_filter(array_map('trim', preg_split('/[\n\r]+/', $trajectoryRaw))));
        }
        if (! empty($validated['meta_custom_json'])) {
            $custom = json_decode($validated['meta_custom_json'], true);
            if (is_array($custom)) {
                $meta = array_merge($meta, $custom);
            }
        }
        unset(
            $validated['quote'],
            $validated['skills_raw'],
            $validated['trajectory_raw'],
            $validated['meta_quote'],
            $validated['meta_philosophy'],
            $validated['meta_skills_raw'],
            $validated['meta_highlights_raw'],
            $validated['meta_testimony'],
            $validated['meta_project_name'],
            $validated['meta_custom_json']
        );
        $validated['meta'] = $meta;

        $person->update($validated);

        $tab = match ($person->category) {
            'founder' => 'founders',
            'tim' => 'team',
            'kontributor' => 'contributors',
            default => 'founders',
        };

        return redirect()->route('admin.people.index', ['tab' => $tab])
            ->with('success', 'Data '.$person->name.' berhasil diperbarui.');
    }

    /**
     * Delete a person.
     */
    public function destroy(Person $person): RedirectResponse
    {
        $name = $person->name;
        $category = $person->category;
        $person->delete();

        $tab = match ($category) {
            'founder' => 'founders',
            'tim' => 'team',
            'kontributor' => 'contributors',
            default => 'founders',
        };

        return redirect()->route('admin.people.index', ['tab' => $tab])
            ->with('success', 'Data '.$name.' berhasil dihapus.');
    }

    // -------------------------------------------------------------
    // FOUNDER STORY (NOVEL / CERPEN) CRUD
    // -------------------------------------------------------------

    /**
     * Store a founder story novel chapter.
     */
    public function storeStory(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'person_id' => 'nullable|exists:people,id',
            'chapter_number' => 'nullable|string|max:50',
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:founder_stories,slug',
            'subtitle' => 'nullable|string|max:500',
            'cover_image' => 'nullable|string|max:1000',
            'cover_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:8192',
            'reading_time' => 'nullable|string|max:50',
            'excerpt' => 'nullable|string',
            'content_html' => 'required|string',
            'status' => 'required|string|in:published,draft',
            'published_at' => 'nullable|date',
            'sort_order' => 'nullable|integer',
        ]);

        if (empty($validated['slug'])) {
            $prefix = $validated['chapter_number'] ? Str::slug($validated['chapter_number']).'-' : '';
            $validated['slug'] = $prefix.Str::slug($validated['title']);
        }

        if ($request->hasFile('cover_file')) {
            $path = $request->file('cover_file')->store('stories', 'public');
            $validated['cover_image'] = Storage::url($path);
        }
        unset($validated['cover_file']);

        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        $validated['published_at'] = $validated['published_at'] ?? now();

        FounderStory::create($validated);

        return redirect()->route('admin.people.index', ['tab' => 'stories'])
            ->with('success', 'Bab cerita/novel berhasil diterbitkan.');
    }

    /**
     * Update a founder story novel chapter.
     */
    public function updateStory(Request $request, FounderStory $story): RedirectResponse
    {
        $validated = $request->validate([
            'person_id' => 'nullable|exists:people,id',
            'chapter_number' => 'nullable|string|max:50',
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:founder_stories,slug,'.$story->id,
            'subtitle' => 'nullable|string|max:500',
            'cover_image' => 'nullable|string|max:1000',
            'cover_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:8192',
            'reading_time' => 'nullable|string|max:50',
            'excerpt' => 'nullable|string',
            'content_html' => 'required|string',
            'status' => 'required|string|in:published,draft',
            'published_at' => 'nullable|date',
            'sort_order' => 'nullable|integer',
        ]);

        if (empty($validated['slug'])) {
            $prefix = ! empty($validated['chapter_number']) ? Str::slug($validated['chapter_number']).'-' : '';
            $validated['slug'] = $story->slug ?: ($prefix.Str::slug($validated['title']));
        }

        if ($request->hasFile('cover_file')) {
            $path = $request->file('cover_file')->store('stories', 'public');
            $validated['cover_image'] = Storage::url($path);
        }
        unset($validated['cover_file']);

        $validated['sort_order'] = $validated['sort_order'] ?? $story->sort_order;

        $story->update($validated);

        return redirect()->route('admin.people.index', ['tab' => 'stories'])
            ->with('success', 'Bab cerita "'.$story->title.'" berhasil diperbarui.');
    }

    /**
     * Delete a founder story chapter.
     */
    public function destroyStory(FounderStory $story): RedirectResponse
    {
        $title = $story->title;
        $story->delete();

        return redirect()->route('admin.people.index', ['tab' => 'stories'])
            ->with('success', 'Bab cerita "'.$title.'" berhasil dihapus.');
    }

    /**
     * Upload image from Quill Editor for novel stories.
     */
    public function uploadStoryImage(Request $request): JsonResponse
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
        ]);

        $path = $request->file('image')->store('stories/content', 'public');

        return response()->json([
            'success' => true,
            'url' => Storage::url($path),
        ]);
    }

    // -------------------------------------------------------------
    // EXCEL / CSV IMPORT & EXPORT
    // -------------------------------------------------------------

    /**
     * Export people data to Excel-compatible CSV with UTF-8 BOM.
     */
    public function exportExcel(Request $request): StreamedResponse
    {
        $category = $request->query('category'); // optional: founder, tim, kontributor

        $query = Person::with('initiative')->orderBy('category')->orderBy('sort_order');
        if ($category && in_array($category, ['founder', 'tim', 'kontributor'])) {
            $query->where('category', $category);
        }
        $records = $query->get();

        $filename = 'people_export_'.($category ?: 'all').'_'.date('Ymd_His').'.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        return response()->stream(function () use ($records): void {
            $output = fopen('php://output', 'w');

            // Write UTF-8 BOM for Microsoft Excel compatibility
            fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

            // CSV Header
            fputcsv($output, [
                'ID',
                'Kategori',
                'Nama',
                'Slug',
                'Peran (ID)',
                'Peran (EN)',
                'Inisiatif / Brand',
                'Status Aktif (1/0)',
                'Tipe Kontribusi',
                'Asal Lembaga / Kampus',
                'Periode',
                'Biografi (ID)',
                'Biografi (EN)',
                'Foto URL',
                'Social Links (JSON)',
                'Meta Data (JSON)',
                'Urutan Sort',
                'Visibilitas',
            ]);

            foreach ($records as $item) {
                fputcsv($output, [
                    $item->id,
                    $item->category,
                    $item->name,
                    $item->slug,
                    $item->role_id,
                    $item->role_en,
                    $item->initiative ? $item->initiative->name : '',
                    $item->is_active ? '1' : '0',
                    $item->contribution_type,
                    $item->organization,
                    $item->period,
                    $item->bio_id,
                    $item->bio_en,
                    $item->photo,
                    $item->social_links ? json_encode($item->social_links, JSON_UNESCAPED_UNICODE) : '',
                    $item->meta ? json_encode($item->meta, JSON_UNESCAPED_UNICODE) : '',
                    $item->sort_order,
                    $item->visibility,
                ]);
            }

            fclose($output);
        }, 200, $headers);
    }

    /**
     * Download Excel / CSV template for bulk importing people.
     */
    public function downloadTemplate(Request $request): StreamedResponse
    {
        $filename = 'template_import_insan_tim.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        return response()->stream(function (): void {
            $output = fopen('php://output', 'w');

            // Write UTF-8 BOM
            fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($output, [
                'Kategori (founder/tim/kontributor)',
                'Nama',
                'Slug (opsional)',
                'Peran (ID)',
                'Peran (EN)',
                'Slug Inisiatif / Brand (opsional, misal: yoin-digital)',
                'Status Aktif (1 atau 0)',
                'Tipe Kontribusi (khusus kontributor: magang/riset/kerjasama/fellowship)',
                'Asal Lembaga / Kampus',
                'Periode (misal: Batch 2025)',
                'Biografi (ID)',
                'LinkedIn URL',
                'Instagram URL',
                'GitHub URL',
                'Email',
                'Kutipan / Quote',
                'Keahlian (pisahkan koma)',
                'Urutan Sort',
            ]);

            // Sample row 1: Founder
            fputcsv($output, [
                'founder',
                'Contoh Nama Pendiri',
                'contoh-nama-pendiri',
                'Co-Founder & Chief Product Officer',
                'Co-Founder & Chief Product Officer',
                '',
                '1',
                '',
                'Institut Teknologi Bandung',
                '2021 - Sekarang',
                'Membangun inovasi produk berdaya tahan tinggi.',
                'https://linkedin.com/in/contoh',
                'https://instagram.com/contoh',
                'https://github.com/contoh',
                'contoh@yotainovasi.id',
                'Inovasi sejati lahir dari empati mendalam.',
                '',
                '1',
            ]);

            // Sample row 2: Core Team
            fputcsv($output, [
                'tim',
                'Contoh Anggota Tim',
                'contoh-anggota-tim',
                'Senior Fullstack Engineer',
                'Senior Fullstack Engineer',
                'yoin-digital',
                '1',
                '',
                'YOIN Digital',
                '2023 - Sekarang',
                'Pengembang backend dan arsitektur data.',
                'https://linkedin.com/in/contoh2',
                '',
                'https://github.com/contoh2',
                'dev@yotainovasi.id',
                '',
                'Laravel, Vue.js, Tailwind, MySQL',
                '2',
            ]);

            // Sample row 3: Contributor
            fputcsv($output, [
                'kontributor',
                'Contoh Mahasiswa Magang',
                'contoh-mahasiswa-magang',
                'Data Science Intern',
                'Data Science Intern',
                'agronex',
                '1',
                'magang',
                'Universitas Indonesia',
                'Magang Batch VI (2025)',
                'Menganalisis kalibrasi data cuaca dan sensor tanah.',
                'https://linkedin.com/in/contoh3',
                '',
                '',
                'intern@agronex.id',
                '',
                'Python, Pandas, IoT Telemetry',
                '3',
            ]);

            fclose($output);
        }, 200, $headers);
    }

    /**
     * Import people data from uploaded CSV or XLSX file.
     */
    public function importExcel(Request $request): RedirectResponse
    {
        $request->validate([
            'file' => 'nullable|file|mimes:csv,txt,xlsx,zip|max:10240',
            'excel_file' => 'nullable|file|mimes:csv,txt,xlsx,zip|max:10240',
        ]);

        $file = $request->file('excel_file') ?? $request->file('file');
        if (! $file) {
            return redirect()->route('admin.people.index', ['tab' => 'excel'])
                ->withErrors(['file' => 'Silakan pilih file Excel (.xlsx) atau CSV untuk diimpor.']);
        }
        $extension = strtolower($file->getClientOriginalExtension());
        $path = $file->getRealPath();

        $rows = [];

        if ($extension === 'xlsx') {
            $rows = $this->parseXlsx($path);
        } else {
            $rows = $this->parseCsv($path);
        }

        if (empty($rows)) {
            return redirect()->route('admin.people.index', ['tab' => 'excel'])
                ->withErrors(['file' => 'File kosong atau format baris tidak dapat dibaca. Pastikan menggunakan format template yang disediakan.']);
        }

        $imported = 0;
        $updated = 0;

        foreach ($rows as $row) {
            if (empty($row['name']) || empty($row['category'])) {
                continue;
            }

            $category = strtolower(trim($row['category']));
            if (! in_array($category, ['founder', 'tim', 'kontributor'])) {
                $category = 'tim';
            }

            $slug = ! empty($row['slug']) ? Str::slug($row['slug']) : Str::slug($row['name']);

            // Resolve initiative if specified
            $initiativeId = null;
            if (! empty($row['initiative'])) {
                $init = EcosystemInitiative::where('slug', trim($row['initiative']))
                    ->orWhere('name', 'like', '%'.trim($row['initiative']).'%')
                    ->first();
                $initiativeId = $init?->id;
            }

            $socialLinks = [];
            if (! empty($row['linkedin'])) {
                $socialLinks['linkedin'] = trim($row['linkedin']);
            }
            if (! empty($row['instagram'])) {
                $socialLinks['instagram'] = trim($row['instagram']);
            }
            if (! empty($row['github'])) {
                $socialLinks['github'] = trim($row['github']);
            }
            if (! empty($row['email'])) {
                $socialLinks['email'] = trim($row['email']);
            }
            if (! empty($row['social_json'])) {
                $parsed = json_decode($row['social_json'], true);
                if (is_array($parsed)) {
                    $socialLinks = array_merge($socialLinks, $parsed);
                }
            }

            $meta = [];
            if (! empty($row['quote'])) {
                $meta['quote'] = trim($row['quote']);
            }
            if (! empty($row['skills'])) {
                $meta['skills'] = array_values(array_filter(array_map('trim', explode(',', $row['skills']))));
            }
            if (! empty($row['meta_json'])) {
                $parsedMeta = json_decode($row['meta_json'], true);
                if (is_array($parsedMeta)) {
                    $meta = array_merge($meta, $parsedMeta);
                }
            }

            $data = [
                'category' => $category,
                'name' => trim($row['name']),
                'role_id' => ! empty($row['role_id']) ? trim($row['role_id']) : 'Anggota Tim',
                'role_en' => ! empty($row['role_en']) ? trim($row['role_en']) : null,
                'bio_id' => ! empty($row['bio_id']) ? trim($row['bio_id']) : null,
                'bio_en' => ! empty($row['bio_en']) ? trim($row['bio_en']) : null,
                'photo' => ! empty($row['photo']) ? trim($row['photo']) : null,
                'initiative_id' => $initiativeId,
                'is_active' => isset($row['is_active']) ? (bool) $row['is_active'] : true,
                'contribution_type' => ! empty($row['contribution_type']) ? strtolower(trim($row['contribution_type'])) : null,
                'organization' => ! empty($row['organization']) ? trim($row['organization']) : null,
                'period' => ! empty($row['period']) ? trim($row['period']) : null,
                'social_links' => $socialLinks,
                'meta' => $meta,
                'sort_order' => isset($row['sort_order']) && is_numeric($row['sort_order']) ? (int) $row['sort_order'] : 0,
                'visibility' => 'public',
            ];

            $person = Person::where('slug', $slug)->first();
            if ($person) {
                $person->update($data);
                $updated++;
            } else {
                $data['slug'] = $slug;
                Person::create($data);
                $imported++;
            }
        }

        return redirect()->route('admin.people.index', ['tab' => 'excel'])
            ->with('success', "Proses impor selesai: {$imported} data baru ditambahkan, {$updated} data diperbarui.");
    }

    /**
     * Parse CSV with auto-detection of delimiters (, or ;).
     *
     * @return list<array<string, mixed>>
     */
    private function parseCsv(string $filePath): array
    {
        $handle = fopen($filePath, 'r');
        if (! $handle) {
            return [];
        }

        // Read first line to detect delimiter
        $firstLine = fgets($handle);
        if (! $firstLine) {
            fclose($handle);

            return [];
        }

        $delimiter = str_contains($firstLine, ';') ? ';' : ',';
        rewind($handle);

        // Strip UTF-8 BOM if present
        $bom = fread($handle, 3);
        if ($bom !== chr(0xEF).chr(0xBB).chr(0xBF)) {
            rewind($handle);
        }

        $headers = fgetcsv($handle, 0, $delimiter);
        if (! $headers) {
            fclose($handle);

            return [];
        }

        $normalizedHeaders = array_map(function ($h): string {
            $h = strtolower(trim((string) $h));
            $h = preg_replace('/[^a-z0-9_]/', '', str_replace([' ', '-', '/'], '_', $h));

            return $h;
        }, $headers);

        $results = [];

        while (($row = fgetcsv($handle, 0, $delimiter)) !== false) {
            if (empty(array_filter($row))) {
                continue;
            }

            $mapped = [];
            foreach ($normalizedHeaders as $idx => $headerKey) {
                $val = $row[$idx] ?? '';
                $mapped[$headerKey] = $val;

                // Canonical keys
                if (str_contains($headerKey, 'kategori')) {
                    $mapped['category'] = $val;
                }
                if (str_contains($headerKey, 'nama') && ! str_contains($headerKey, 'proyek')) {
                    $mapped['name'] = $val;
                }
                if (str_contains($headerKey, 'peran_id') || $headerKey === 'peran') {
                    $mapped['role_id'] = $val;
                }
                if (str_contains($headerKey, 'peran_en')) {
                    $mapped['role_en'] = $val;
                }
                if (str_contains($headerKey, 'inisiatif') || str_contains($headerKey, 'brand')) {
                    $mapped['initiative'] = $val;
                }
                if (str_contains($headerKey, 'aktif')) {
                    $mapped['is_active'] = $val;
                }
                if (str_contains($headerKey, 'kontribusi')) {
                    $mapped['contribution_type'] = $val;
                }
                if (str_contains($headerKey, 'lembaga') || str_contains($headerKey, 'kampus') || str_contains($headerKey, 'organisasi')) {
                    $mapped['organization'] = $val;
                }
                if (str_contains($headerKey, 'periode') || str_contains($headerKey, 'batch')) {
                    $mapped['period'] = $val;
                }
                if (str_contains($headerKey, 'biografi_id') || $headerKey === 'biografi' || str_contains($headerKey, 'bio_id')) {
                    $mapped['bio_id'] = $val;
                }
                if (str_contains($headerKey, 'biografi_en') || str_contains($headerKey, 'bio_en')) {
                    $mapped['bio_en'] = $val;
                }
                if (str_contains($headerKey, 'linkedin')) {
                    $mapped['linkedin'] = $val;
                }
                if (str_contains($headerKey, 'instagram')) {
                    $mapped['instagram'] = $val;
                }
                if (str_contains($headerKey, 'github')) {
                    $mapped['github'] = $val;
                }
                if (str_contains($headerKey, 'email')) {
                    $mapped['email'] = $val;
                }
                if (str_contains($headerKey, 'kutipan') || str_contains($headerKey, 'quote')) {
                    $mapped['quote'] = $val;
                }
                if (str_contains($headerKey, 'keahlian') || str_contains($headerKey, 'skills')) {
                    $mapped['skills'] = $val;
                }
                if (str_contains($headerKey, 'urutan') || str_contains($headerKey, 'sort')) {
                    $mapped['sort_order'] = $val;
                }
            }

            $results[] = $mapped;
        }

        fclose($handle);

        return $results;
    }

    /**
     * Parse XLSX file using PHP native ZipArchive and SimpleXML without external dependencies.
     *
     * @return list<array<string, mixed>>
     */
    private function parseXlsx(string $filePath): array
    {
        $zip = new ZipArchive;
        if ($zip->open($filePath) !== true) {
            return [];
        }

        // 1. Read shared strings
        $sharedStrings = [];
        $sharedXml = $zip->getFromName('xl/sharedStrings.xml');
        if ($sharedXml) {
            $xml = simplexml_load_string($sharedXml);
            if ($xml) {
                foreach ($xml->si as $si) {
                    $sharedStrings[] = (string) ($si->t ?? $si->r->t ?? '');
                }
            }
        }

        // 2. Read sheet1
        $sheetXml = $zip->getFromName('xl/worksheets/sheet1.xml');
        if (! $sheetXml) {
            $zip->close();

            return [];
        }

        $xml = simplexml_load_string($sheetXml);
        $zip->close();

        if (! $xml || ! isset($xml->sheetData->row)) {
            return [];
        }

        $rawRows = [];
        foreach ($xml->sheetData->row as $row) {
            $cells = [];
            foreach ($row->c as $c) {
                $type = (string) ($c['t'] ?? '');
                $val = (string) $c->v;

                if ($type === 's' && isset($sharedStrings[(int) $val])) {
                    $val = $sharedStrings[(int) $val];
                }
                $cells[] = $val;
            }
            if (! empty(array_filter($cells))) {
                $rawRows[] = $cells;
            }
        }

        if (empty($rawRows)) {
            return [];
        }

        $headers = array_shift($rawRows);
        $normalizedHeaders = array_map(function ($h): string {
            $h = strtolower(trim((string) $h));
            $h = preg_replace('/[^a-z0-9_]/', '', str_replace([' ', '-', '/'], '_', $h));

            return $h;
        }, $headers);

        $results = [];
        foreach ($rawRows as $row) {
            $mapped = [];
            foreach ($normalizedHeaders as $idx => $headerKey) {
                $val = $row[$idx] ?? '';
                $mapped[$headerKey] = $val;

                if (str_contains($headerKey, 'kategori')) {
                    $mapped['category'] = $val;
                }
                if (str_contains($headerKey, 'nama') && ! str_contains($headerKey, 'proyek')) {
                    $mapped['name'] = $val;
                }
                if (str_contains($headerKey, 'peran_id') || $headerKey === 'peran') {
                    $mapped['role_id'] = $val;
                }
                if (str_contains($headerKey, 'peran_en')) {
                    $mapped['role_en'] = $val;
                }
                if (str_contains($headerKey, 'inisiatif') || str_contains($headerKey, 'brand')) {
                    $mapped['initiative'] = $val;
                }
                if (str_contains($headerKey, 'aktif')) {
                    $mapped['is_active'] = $val;
                }
                if (str_contains($headerKey, 'kontribusi')) {
                    $mapped['contribution_type'] = $val;
                }
                if (str_contains($headerKey, 'lembaga') || str_contains($headerKey, 'kampus') || str_contains($headerKey, 'organisasi')) {
                    $mapped['organization'] = $val;
                }
                if (str_contains($headerKey, 'periode') || str_contains($headerKey, 'batch')) {
                    $mapped['period'] = $val;
                }
                if (str_contains($headerKey, 'biografi_id') || $headerKey === 'biografi' || str_contains($headerKey, 'bio_id')) {
                    $mapped['bio_id'] = $val;
                }
                if (str_contains($headerKey, 'biografi_en') || str_contains($headerKey, 'bio_en')) {
                    $mapped['bio_en'] = $val;
                }
                if (str_contains($headerKey, 'linkedin')) {
                    $mapped['linkedin'] = $val;
                }
                if (str_contains($headerKey, 'instagram')) {
                    $mapped['instagram'] = $val;
                }
                if (str_contains($headerKey, 'github')) {
                    $mapped['github'] = $val;
                }
                if (str_contains($headerKey, 'email')) {
                    $mapped['email'] = $val;
                }
                if (str_contains($headerKey, 'kutipan') || str_contains($headerKey, 'quote')) {
                    $mapped['quote'] = $val;
                }
                if (str_contains($headerKey, 'keahlian') || str_contains($headerKey, 'skills')) {
                    $mapped['skills'] = $val;
                }
                if (str_contains($headerKey, 'urutan') || str_contains($headerKey, 'sort')) {
                    $mapped['sort_order'] = $val;
                }
            }
            $results[] = $mapped;
        }

        return $results;
    }
}
