<?php

namespace App\Http\Controllers;

use App\Models\CompanyAchievement;
use App\Models\CompanyProfile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class CompanyAchievementAdminController extends Controller
{
    /**
     * Display achievements list and narrative editor.
     */
    public function index(): View
    {
        $achievements = CompanyAchievement::orderBy('sort_order')->latest('id')->get();
        $profile = CompanyProfile::getProfile();

        return view('admin.achievements.index', compact('achievements', 'profile'));
    }

    /**
     * Store a new achievement/certificate item.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'issuer' => 'nullable|string|max:255',
            'year' => 'nullable|string|max:50',
            'image' => 'nullable|string|max:1000',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:5120',
            'photos_files' => 'nullable|array',
            'photos_files.*' => 'image|mimes:jpeg,png,jpg,webp,svg|max:5120',
            'photos' => 'nullable|array',
            'photos.*' => 'nullable|string|max:1000',
            'description' => 'nullable|string',
            'credential_url' => 'nullable|url|max:1000',
            'badge_label' => 'nullable|string|max:100',
            'sort_order' => 'nullable|integer',
            'is_featured' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['sort_order'] = $request->integer('sort_order', 0);

        $photos = [];
        if ($request->has('photos') && is_array($request->input('photos'))) {
            $photos = array_values(array_filter($request->input('photos')));
        }

        if ($request->hasFile('photos_files')) {
            foreach ($request->file('photos_files') as $file) {
                $path = $file->store('achievements', 'public');
                $photos[] = Storage::url($path);
            }
        }

        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('achievements', 'public');
            $validated['image'] = Storage::url($path);
        }
        unset($validated['image_file'], $validated['photos_files']);

        if (empty($validated['image']) && ! empty($photos)) {
            $validated['image'] = $photos[0];
        }

        if (! empty($validated['image']) && ! in_array($validated['image'], $photos, true)) {
            array_unshift($photos, $validated['image']);
        }

        $validated['photos'] = array_values(array_unique($photos));

        CompanyAchievement::create($validated);

        return redirect()->route('admin.achievements.index')
            ->with('success', 'Penghargaan / Momen baru beserta foto berhasil ditambahkan.');
    }

    /**
     * Update an achievement/certificate item.
     */
    public function update(Request $request, CompanyAchievement $achievement): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'issuer' => 'nullable|string|max:255',
            'year' => 'nullable|string|max:50',
            'image' => 'nullable|string|max:1000',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:5120',
            'photos_files' => 'nullable|array',
            'photos_files.*' => 'image|mimes:jpeg,png,jpg,webp,svg|max:5120',
            'existing_photos' => 'nullable|array',
            'existing_photos.*' => 'nullable|string|max:1000',
            'description' => 'nullable|string',
            'credential_url' => 'nullable|url|max:1000',
            'badge_label' => 'nullable|string|max:100',
            'sort_order' => 'nullable|integer',
            'is_featured' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_active'] = $request->boolean('is_active');
        $validated['sort_order'] = $request->integer('sort_order', 0);

        $photos = [];
        if ($request->has('existing_photos') && is_array($request->input('existing_photos'))) {
            $photos = array_values(array_filter($request->input('existing_photos')));
        } elseif (is_array($achievement->photos)) {
            $photos = $achievement->photos;
        }

        if ($request->hasFile('photos_files')) {
            foreach ($request->file('photos_files') as $file) {
                $path = $file->store('achievements', 'public');
                $photos[] = Storage::url($path);
            }
        }

        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('achievements', 'public');
            $validated['image'] = Storage::url($path);
        }
        unset($validated['image_file'], $validated['photos_files'], $validated['existing_photos']);

        if (empty($validated['image']) && ! empty($photos)) {
            $validated['image'] = $photos[0];
        }

        if (! empty($validated['image']) && ! in_array($validated['image'], $photos, true)) {
            array_unshift($photos, $validated['image']);
        }

        $validated['photos'] = array_values(array_unique($photos));

        $achievement->update($validated);

        return redirect()->route('admin.achievements.index')
            ->with('success', 'Penghargaan / Momen berhasil diperbarui.');
    }

    /**
     * Remove an achievement item.
     */
    public function destroy(CompanyAchievement $achievement): RedirectResponse
    {
        $achievement->delete();

        return redirect()->route('admin.achievements.index')
            ->with('success', 'Penghargaan / Sertifikat berhasil dihapus.');
    }

    /**
     * Update narrative overview and rich text editor content for achievements page.
     */
    public function updateNarrative(Request $request): RedirectResponse
    {
        $profile = CompanyProfile::getProfile();

        $validated = $request->validate([
            'achievement_badge' => 'nullable|string|max:255',
            'achievement_title' => 'nullable|string|max:255',
            'achievement_summary' => 'nullable|string',
            'achievement_content_html' => 'nullable|string',
        ]);

        $profile->update($validated);

        return redirect()->route('admin.achievements.index')
            ->with('success', 'Naskah narasi & editorial pencapaian berhasil diperbarui.');
    }

    /**
     * Handle image upload inside Quill editor for achievement narrative.
     */
    public function uploadImage(Request $request): JsonResponse
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp,svg|max:10240',
        ]);

        $path = $request->file('image')->store('achievements/editor', 'public');
        $url = asset('storage/'.$path);

        return response()->json([
            'success' => true,
            'url' => $url,
        ]);
    }
}
