<?php

namespace App\Providers;

use App\Models\ArticleCategory;
use App\Models\Collaboration;
use App\Models\MenuHighlight;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // View Composer for Header, Navigation and Public layouts
        View::composer(['public.layouts.header', 'public.layouts.app', 'public.*'], function ($view): void {
            $menuHighlights = collect();
            $collaborationTracks = collect();
            $articleCategories = collect();

            try {
                if (Schema::hasTable('menu_highlights')) {
                    $menuHighlights = MenuHighlight::active()
                        ->ordered()
                        ->take(4)
                        ->get();
                }

                if (Schema::hasTable('collaborations')) {
                    $collaborationTracks = Collaboration::active()
                        ->ordered()
                        ->get();
                }

                if (Schema::hasTable('article_categories')) {
                    $articleCategories = ArticleCategory::active()
                        ->ordered()
                        ->get();
                }
            } catch (\Throwable) {
                // Graceful fallback
            }

            $view->with([
                'menuHighlights' => $menuHighlights,
                'collaborationTracks' => $collaborationTracks,
                'articleCategories' => $articleCategories,
            ]);
        });
    }
}
