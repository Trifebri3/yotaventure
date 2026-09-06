<?php

namespace App\Http\Controllers;

use App\Models\CompanyProfile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InvestAdminController extends Controller
{
    /**
     * Show the Invest page management form and rich text editor.
     */
    public function edit(): View
    {
        $profile = CompanyProfile::getProfile();

        return view('admin.invest.edit', compact('profile'));
    }

    /**
     * Update the Invest page content, metrics, resources, and narrative.
     */
    public function update(Request $request): RedirectResponse
    {
        $profile = CompanyProfile::getProfile();

        $validated = $request->validate([
            'invest_badge' => 'nullable|string|max:255',
            'invest_title' => 'required|string|max:255',
            'invest_subtitle' => 'nullable|string|max:255',
            'invest_summary' => 'nullable|string',
            'invest_content_html' => 'nullable|string',
            'invest_deck_url' => 'nullable|url|max:1000',
            'invest_data_room_url' => 'nullable|url|max:1000',
            'invest_metrics' => 'nullable|array',
            'invest_metrics.*.key' => 'nullable|string|max:100',
            'invest_metrics.*.label' => 'nullable|string|max:255',
            'invest_metrics.*.value' => 'nullable|string|max:100',
            'invest_resources' => 'nullable|array',
            'invest_resources.*.title' => 'nullable|string|max:255',
            'invest_resources.*.description' => 'nullable|string',
            'invest_resources.*.action_label' => 'nullable|string|max:255',
            'invest_resources.*.url' => 'nullable|string|max:1000',
            'invest_resources.*.type' => 'nullable|string|max:50',
        ]);

        if (isset($validated['invest_metrics']) && is_array($validated['invest_metrics'])) {
            $validated['invest_metrics'] = array_values(array_filter($validated['invest_metrics'], function ($item): bool {
                return ! empty($item['label']) || ! empty($item['value']);
            }));
        }

        if (isset($validated['invest_resources']) && is_array($validated['invest_resources'])) {
            $validated['invest_resources'] = array_values(array_filter($validated['invest_resources'], function ($item): bool {
                return ! empty($item['title']);
            }));
        }

        $profile->update($validated);

        return redirect()->route('admin.invest.edit')
            ->with('success', 'Konten & Naskah Investasi berhasil diperbarui.');
    }

    /**
     * Handle image upload inside Quill editor for Invest narrative.
     */
    public function uploadImage(Request $request): JsonResponse
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp,svg|max:10240',
        ]);

        $path = $request->file('image')->store('invest/editor', 'public');
        $url = asset('storage/'.$path);

        return response()->json([
            'success' => true,
            'url' => $url,
        ]);
    }
}
