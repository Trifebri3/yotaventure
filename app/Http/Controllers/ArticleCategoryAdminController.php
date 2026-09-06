<?php

namespace App\Http\Controllers;

use App\Models\ArticleCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticleCategoryAdminController extends Controller
{
    /**
     * Display a listing of publication categories for photo and title management.
     */
    public function index(): RedirectResponse
    {
        return redirect()->route('admin.articles.index', ['tab' => 'categories']);
    }

    /**
     * Store a newly created publication category in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name_id' => ['required', 'string', 'max:255'],
            'name_en' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:100', 'unique:article_categories,slug'],
            'subtitle_id' => ['nullable', 'string', 'max:255'],
            'subtitle_en' => ['nullable', 'string', 'max:255'],
            'description_id' => ['nullable', 'string'],
            'description_en' => ['nullable', 'string'],
            'image_url' => ['nullable', 'string', 'max:1000'],
            'image_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:4096'],
            'sort_order' => ['nullable', 'integer'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if (empty($validated['slug'])) {
            $baseSlug = Str::slug($validated['name_id']);
            $slug = $baseSlug;
            $counter = 1;
            while (ArticleCategory::where('slug', $slug)->exists()) {
                $slug = $baseSlug.'-'.$counter++;
            }
            $validated['slug'] = $slug;
        }

        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('categories', 'public');
            $validated['image_url'] = Storage::url($path);
        }

        // Fallback default image if none provided
        if (empty($validated['image_url'])) {
            $validated['image_url'] = 'https://images.unsplash.com/photo-1507668077129-56e32842fceb?q=80&w=1000&auto=format&fit=crop';
        }

        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['sort_order'] = $request->filled('sort_order') ? (int) $request->sort_order : (ArticleCategory::max('sort_order') + 1);
        unset($validated['image_file']);

        $category = ArticleCategory::create($validated);

        return redirect()->route('admin.articles.index', ['tab' => 'categories'])
            ->with('success', "Kategori '{$category->name_id}' berhasil dibuat dan tersimpan di database!");
    }

    /**
     * Update the specified publication category photo and details.
     */
    public function update(Request $request, ArticleCategory $category): RedirectResponse
    {
        $validated = $request->validate([
            'name_id' => ['required', 'string', 'max:255'],
            'name_en' => ['required', 'string', 'max:255'],
            'subtitle_id' => ['nullable', 'string', 'max:255'],
            'subtitle_en' => ['nullable', 'string', 'max:255'],
            'description_id' => ['nullable', 'string'],
            'description_en' => ['nullable', 'string'],
            'image_url' => ['nullable', 'string', 'max:1000'],
            'image_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:4096'],
            'sort_order' => ['nullable', 'integer'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('categories', 'public');
            $validated['image_url'] = Storage::url($path);
        }

        $validated['is_active'] = $request->boolean('is_active', true);
        unset($validated['image_file']);

        $category->update($validated);

        return redirect()->route('admin.articles.index', ['tab' => 'categories'])
            ->with('success', "Kategori '{$category->name_id}' dan foto berhasil diperbarui!");
    }

    /**
     * Remove the specified category from storage.
     */
    public function destroy(ArticleCategory $category): RedirectResponse
    {
        $name = $category->name_id;
        $category->delete();

        return redirect()->route('admin.articles.index', ['tab' => 'categories'])
            ->with('success', "Kategori '{$name}' berhasil dihapus dari database!");
    }
}
