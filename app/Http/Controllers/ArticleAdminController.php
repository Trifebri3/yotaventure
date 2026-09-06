<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ArticleAdminController extends Controller
{
    /**
     * Display the admin management dashboard with statistics and article list.
     */
    public function index(Request $request): View
    {
        $search = $request->query('search');
        $typeFilter = $request->query('type');
        $statusFilter = $request->query('status');

        $query = Article::latest('id');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('tag', 'like', "%{$search}%")
                    ->orWhere('badge', 'like', "%{$search}%");
            });
        }

        if ($typeFilter) {
            $query->where('type', $typeFilter);
        }

        if ($statusFilter) {
            $query->where('status', $statusFilter);
        }

        $articles = $query->paginate(10)->withQueryString();

        // Statistics
        $totalArticles = Article::count();
        $totalViews = Article::sum('views_count');
        $publishedCount = Article::where('status', 'published')->count();
        $draftCount = Article::where('status', 'draft')->count();
        $featuredCount = Article::where('is_featured', true)->count();

        $topArticles = Article::orderByDesc('views_count')->take(5)->get();

        $categories = ArticleCategory::ordered()->get();

        return view('admin.articles.index', [
            'articles' => $articles,
            'categories' => $categories,
            'totalArticles' => $totalArticles,
            'totalViews' => $totalViews,
            'publishedCount' => $publishedCount,
            'draftCount' => $draftCount,
            'featuredCount' => $featuredCount,
            'topArticles' => $topArticles,
            'search' => $search,
            'typeFilter' => $typeFilter,
            'statusFilter' => $statusFilter,
        ]);
    }

    /**
     * Show the form for creating a new article/publication.
     */
    public function create(): View
    {
        $categories = ArticleCategory::ordered()->get();

        return view('admin.articles.form', [
            'article' => new Article([
                'status' => 'published',
                'type' => $categories->first()?->slug ?? 'artikel',
                'author_name' => 'Tim Riset YOIN',
                'is_featured' => false,
            ]),
            'categories' => $categories,
            'isEdit' => false,
        ]);
    }

    /**
     * Store a newly created article/publication in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'slug' => 'nullable|string|max:255|unique:articles,slug',
            'type' => 'required|string|max:100',
            'tag' => 'nullable|string|max:100',
            'tag_en' => 'nullable|string|max:100',
            'badge' => 'nullable|string|max:100',
            'badge_en' => 'nullable|string|max:100',
            'excerpt' => 'nullable|string|max:500',
            'excerpt_en' => 'nullable|string|max:500',
            'content' => 'required|string',
            'content_en' => 'nullable|string',
            'cover_image' => 'nullable',
            'cover_image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:10240',
            'author_name' => 'required|string|max:150',
            'status' => 'required|in:published,draft',
            'is_featured' => 'nullable|boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:255',
            'canonical_url' => 'nullable|string|max:500',
        ]);

        $validated['is_featured'] = $request->boolean('is_featured');

        if ($request->hasFile('cover_image_file')) {
            $path = $request->file('cover_image_file')->store('articles/covers', 'public');
            $validated['cover_image'] = Storage::url($path);
        } elseif ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('articles/covers', 'public');
            $validated['cover_image'] = Storage::url($path);
        } elseif (is_string($request->input('cover_image')) && ! empty($request->input('cover_image'))) {
            $validated['cover_image'] = $request->input('cover_image');
        } else {
            $validated['cover_image'] = null;
        }
        unset($validated['cover_image_file']);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
            $count = Article::where('slug', 'like', $validated['slug'].'%')->count();
            if ($count > 0) {
                $validated['slug'] .= '-'.($count + 1);
            }
        }

        if ($validated['status'] === 'published') {
            $validated['published_at'] = now();
        }

        $article = Article::create($validated);

        return redirect()->route('admin.articles.index')->with('success', 'Artikel atau publikasi berhasil diterbitkan.');
    }

    /**
     * Show the form for editing the specified article.
     */
    public function edit(Article $article): View
    {
        $categories = ArticleCategory::ordered()->get();

        return view('admin.articles.form', [
            'article' => $article,
            'categories' => $categories,
            'isEdit' => true,
        ]);
    }

    /**
     * Update the specified article in storage.
     */
    public function update(Request $request, Article $article): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'slug' => 'nullable|string|max:255|unique:articles,slug,'.$article->id,
            'type' => 'required|string|max:100',
            'tag' => 'nullable|string|max:100',
            'tag_en' => 'nullable|string|max:100',
            'badge' => 'nullable|string|max:100',
            'badge_en' => 'nullable|string|max:100',
            'excerpt' => 'nullable|string|max:500',
            'excerpt_en' => 'nullable|string|max:500',
            'content' => 'required|string',
            'content_en' => 'nullable|string',
            'cover_image' => 'nullable',
            'cover_image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:10240',
            'author_name' => 'required|string|max:150',
            'status' => 'required|in:published,draft',
            'is_featured' => 'nullable|boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:255',
            'canonical_url' => 'nullable|string|max:500',
        ]);

        $validated['is_featured'] = $request->boolean('is_featured');

        if ($request->hasFile('cover_image_file')) {
            $path = $request->file('cover_image_file')->store('articles/covers', 'public');
            $validated['cover_image'] = Storage::url($path);
        } elseif ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('articles/covers', 'public');
            $validated['cover_image'] = Storage::url($path);
        } elseif ($request->filled('cover_image') && is_string($request->input('cover_image'))) {
            $validated['cover_image'] = $request->input('cover_image');
        } else {
            $validated['cover_image'] = $article->cover_image;
        }
        unset($validated['cover_image_file']);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        if ($validated['status'] === 'published' && empty($article->published_at)) {
            $validated['published_at'] = now();
        }

        $article->update($validated);

        return redirect()->route('admin.articles.index')->with('success', 'Data publikasi berhasil diperbarui.');
    }

    /**
     * Remove the specified article from storage.
     */
    public function destroy(Article $article): RedirectResponse
    {
        $article->delete();

        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil dihapus dari basis data.');
    }

    /**
     * Upload an image file for rich-text embedding in publications.
     */
    public function uploadImage(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp,svg|max:10240',
        ]);

        $path = $request->file('image')->store('articles', 'public');
        $url = asset('storage/'.$path);

        return response()->json([
            'success' => true,
            'url' => $url,
        ]);
    }
}
