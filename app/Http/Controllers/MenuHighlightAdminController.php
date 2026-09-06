<?php

namespace App\Http\Controllers;

use App\Models\MenuHighlight;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MenuHighlightAdminController extends Controller
{
    /**
     * Display a listing of the menu highlights.
     */
    public function index(): View
    {
        $highlights = MenuHighlight::ordered()->get();

        return view('admin.menu_highlights.index', compact('highlights'));
    }

    /**
     * Update the specified menu highlight in storage.
     */
    public function update(Request $request, MenuHighlight $menuHighlight): RedirectResponse
    {
        $validated = $request->validate([
            'title_id' => ['required', 'string', 'max:255'],
            'title_en' => ['required', 'string', 'max:255'],
            'badge_id' => ['nullable', 'string', 'max:100'],
            'badge_en' => ['nullable', 'string', 'max:100'],
            'subtitle_id' => ['nullable', 'string', 'max:255'],
            'subtitle_en' => ['nullable', 'string', 'max:255'],
            'link_url' => ['required', 'string', 'max:255'],
            'image_url' => ['nullable', 'string', 'max:1000'],
            'image_file' => ['nullable', 'image', 'max:4096'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('menu_highlights', 'public');
            $validated['image_url'] = '/storage/'.$path;
        }

        unset($validated['image_file']);
        $validated['is_active'] = $request->boolean('is_active', true);

        $menuHighlight->update($validated);

        return redirect()->route('admin.menu-highlights.index')
            ->with('success', 'Foto dan informasi kartu menu berhasil diperbarui di database!');
    }
}
