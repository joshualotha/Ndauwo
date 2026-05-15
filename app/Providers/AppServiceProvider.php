<?php

namespace App\Providers;

use App\Services\SeoService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(SeoService::class, function ($app) {
            return new SeoService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Inject SEO meta into the app.blade.php view for all SPA routes
        View::composer('app', function ($view) {
            $seoService = app(SeoService::class);
            $view->with('seo', $seoService->getMeta(request()->path()));
        });
    }
}
