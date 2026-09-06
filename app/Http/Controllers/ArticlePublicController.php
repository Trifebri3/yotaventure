<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleCategory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ArticlePublicController extends Controller
{
    /**
     * Display a listing of publications, articles, and research journals.
     */
    public function index(Request $request): View
    {
        $selectedType = $request->query('type', 'all');
        $searchQuery = $request->query('q');

        $categories = ArticleCategory::active()->ordered()->get();

        $query = Article::published()->latest('published_at');

        if ($selectedType && $selectedType !== 'all') {
            $query->where('type', $selectedType);
        }

        if ($searchQuery) {
            $query->where(function ($q) use ($searchQuery) {
                $q->where('title', 'like', "%{$searchQuery}%")
                    ->orWhere('excerpt', 'like', "%{$searchQuery}%")
                    ->orWhere('tag', 'like', "%{$searchQuery}%")
                    ->orWhere('badge', 'like', "%{$searchQuery}%");
            });
        }

        $articles = $query->paginate(9)->withQueryString();

        // Top 3 featured articles for top carousel/highlight
        $featuredArticles = Article::published()
            ->featured()
            ->latest('published_at')
            ->take(3)
            ->get();

        // Statistics aggregates for header badge
        $totalPublications = Article::published()->count();
        $totalReads = Article::published()->sum('views_count');

        return view('public.articles.index', [
            'articles' => $articles,
            'categories' => $categories,
            'featuredArticles' => $featuredArticles,
            'selectedType' => $selectedType,
            'searchQuery' => $searchQuery,
            'totalPublications' => $totalPublications,
            'totalReads' => $totalReads,
        ]);
    }

    /**
     * Display the specified article/publication detail with modern reader view and SEO.
     */
    public function show(string $slug): View
    {
        $article = Article::published()
            ->where('slug', $slug)
            ->firstOrFail();

        // Safe Session-guarded views count increment (prevents F5 spam)
        $sessionKey = 'viewed_article_'.$article->id;
        if (! session()->has($sessionKey)) {
            $article->recordView();
            session()->put($sessionKey, true);
        }

        // Related articles from same or similar categories
        $relatedArticles = Article::published()
            ->where('id', '!=', $article->id)
            ->where(function ($q) use ($article) {
                $q->where('type', $article->type)
                    ->orWhere('tag', $article->tag);
            })
            ->latest('published_at')
            ->take(3)
            ->get();

        // Fallback if not enough related in same category
        if ($relatedArticles->count() < 3) {
            $moreArticles = Article::published()
                ->where('id', '!=', $article->id)
                ->whereNotIn('id', $relatedArticles->pluck('id'))
                ->latest('published_at')
                ->take(3 - $relatedArticles->count())
                ->get();

            $relatedArticles = $relatedArticles->merge($moreArticles);
        }

        return view('public.articles.show', [
            'article' => $article,
            'relatedArticles' => $relatedArticles,
        ]);
    }
}
