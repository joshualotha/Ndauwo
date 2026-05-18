<?php

namespace App\Providers;

use App\Models\Setting;
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
        // Inject SEO meta and settings into the app.blade.php view for all SPA routes
        View::composer('app', function ($view) {
            /** @var SeoService $seoService */
            $seoService = app(SeoService::class);
            $path = request()->path();

            // Get base SEO meta
            $seo = $seoService->getMeta($path);

            // Add robots directive: noindex admin pages
            $seo['robots'] = str_starts_with($path, 'admin') ? 'noindex, nofollow' : 'index, follow';

            // Set OG type based on route
            if (str_starts_with($path, 'safaris') || str_starts_with($path, 'destinations')) {
                $seo['og_type'] = 'product';
            } elseif (str_starts_with($path, 'journal')) {
                $seo['og_type'] = 'article';
            } elseif ($path === '/') {
                $seo['og_type'] = 'website';
            } else {
                $seo['og_type'] = 'website';
            }

            // Twitter card type
            $seo['twitter_card'] = 'summary_large_image';

            // Inject analytics IDs from settings (load once, cache-friendly)
            static $ga4Id = null;
            static $gtmId = null;

            if ($ga4Id === null) {
                $ga4Setting = Setting::where('key', 'ga4_id')->first();
                $ga4Id = $ga4Setting ? $ga4Setting->value : null;
                // Fallback to legacy UA format key if new GA4 ID not set
                if (empty($ga4Id)) {
                    $legacySetting = Setting::where('key', 'seo_google_analytics')->first();
                    $legacyValue = $legacySetting ? $legacySetting->value : null;
                    // Only use if it looks like a G-XXXXXXX or UA-XXXXX format
                    if (!empty($legacyValue) && !str_contains($legacyValue, 'UA-XXXXX')) {
                        $ga4Id = $legacyValue;
                    }
                }
            }
            if ($gtmId === null) {
                $gtmSetting = Setting::where('key', 'gtm_id')->first();
                $gtmId = $gtmSetting ? $gtmSetting->value : null;
            }

            $view->with('seo', $seo);
            $view->with('ga4_id', $ga4Id);
            $view->with('gtm_id', $gtmId);
        });
    }
}
