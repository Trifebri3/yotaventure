<?php

namespace App\Http\Controllers;

use App\Models\CompanyProfile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class CompanyProfileAdminController extends Controller
{
    /**
     * Show the company profile edit form with Quill editor.
     */
    public function edit(): View
    {
        $profile = CompanyProfile::getProfile();

        return view('admin.company_profile.edit', compact('profile'));
    }

    /**
     * Update the company profile attributes and content.
     */
    public function update(Request $request): RedirectResponse
    {
        $profile = CompanyProfile::getProfile();

        $validated = $request->validate([
            'hero_badge' => 'nullable|string|max:255',
            'company_name' => 'required|string|max:255',
            'tagline' => 'nullable|string|max:255',
            'summary' => 'nullable|string',
            'content_html' => 'nullable|string',
            'hero_image' => 'nullable|string|max:1000',
            'hero_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:5120',
            'legal_entity_name' => 'required|string|max:255',
            'legal_registration_info' => 'nullable|string',
            'office_address' => 'nullable|string',
            'contact_email' => 'nullable|email|max:255',
            'contact_phone' => 'nullable|string|max:100',
            'highlights' => 'nullable|array',
            'highlights.*.number' => 'nullable|string|max:50',
            'highlights.*.title' => 'nullable|string|max:255',
            'highlights.*.description' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
        ]);

        if ($request->hasFile('hero_file')) {
            $path = $request->file('hero_file')->store('company_profile/hero', 'public');
            $validated['hero_image'] = Storage::url($path);
        }
        unset($validated['hero_file']);

        // Filter empty highlights if provided
        if (isset($validated['highlights']) && is_array($validated['highlights'])) {
            $validated['highlights'] = array_values(array_filter($validated['highlights'], function ($item): bool {
                return ! empty($item['title']) || ! empty($item['description']);
            }));
        }

        $profile->update($validated);

        return redirect()->route('admin.company-profile.edit')
            ->with('success', 'Profil Perusahaan & Ekosistem berhasil diperbarui.');
    }

    /**
     * Handle Quill editor image uploads.
     */
    public function uploadImage(Request $request): JsonResponse
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp,svg|max:10240',
        ]);

        $path = $request->file('image')->store('company_profile/images', 'public');
        $url = asset('storage/'.$path);

        return response()->json([
            'success' => true,
            'url' => $url,
        ]);
    }
}
