<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\Destination;
use App\Models\Post;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    /**
     * Sitemap index referencing all sub-sitemaps.
     */
    public function index()
    {
        $baseUrl = rtrim(config('app.url'), '/');

        $content = '<?xml version="1.0" encoding="UTF-8"?>';
        $content .= '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        $content .= '<sitemap><loc>' . $baseUrl . '/api/sitemap-static.xml</loc></sitemap>';
        $content .= '<sitemap><loc>' . $baseUrl . '/api/sitemap-packages.xml</loc></sitemap>';
        $content .= '<sitemap><loc>' . $baseUrl . '/api/sitemap-destinations.xml</loc></sitemap>';
        $content .= '<sitemap><loc>' . $baseUrl . '/api/sitemap-posts.xml</loc></sitemap>';

        $content .= '</sitemapindex>';

        return response($content, 200, ['Content-Type' => 'application/xml']);
    }

    /**
     * Static pages sitemap (home, about, contact, etc.).
     */
    public function static()
    {
        $baseUrl = rtrim(config('app.url'), '/');

        $pages = [
            ['loc' => '/', 'priority' => '1.0', 'changefreq' => 'daily'],
            ['loc' => '/safaris', 'priority' => '0.9', 'changefreq' => 'weekly'],
            ['loc' => '/destinations', 'priority' => '0.9', 'changefreq' => 'weekly'],
            ['loc' => '/journal', 'priority' => '0.8', 'changefreq' => 'weekly'],
            ['loc' => '/about', 'priority' => '0.7', 'changefreq' => 'monthly'],
            ['loc' => '/contact', 'priority' => '0.7', 'changefreq' => 'monthly'],
            ['loc' => '/gallery', 'priority' => '0.6', 'changefreq' => 'monthly'],
            ['loc' => '/reviews', 'priority' => '0.6', 'changefreq' => 'monthly'],
            ['loc' => '/conservation', 'priority' => '0.6', 'changefreq' => 'monthly'],
            ['loc' => '/press', 'priority' => '0.5', 'changefreq' => 'monthly'],
            ['loc' => '/careers', 'priority' => '0.5', 'changefreq' => 'monthly'],
            ['loc' => '/safari-types', 'priority' => '0.8', 'changefreq' => 'weekly'],
            ['loc' => '/safari-types/luxury-safari', 'priority' => '0.8', 'changefreq' => 'monthly'],
            ['loc' => '/safari-types/tailor-made-safari', 'priority' => '0.8', 'changefreq' => 'monthly'],
            ['loc' => '/safari-types/mountain-hiking', 'priority' => '0.8', 'changefreq' => 'monthly'],
            ['loc' => '/safari-types/cultural-tours', 'priority' => '0.8', 'changefreq' => 'monthly'],
            ['loc' => '/safari-types/group-safari', 'priority' => '0.8', 'changefreq' => 'monthly'],
            ['loc' => '/safari-types/zanzibar-beach-safari', 'priority' => '0.8', 'changefreq' => 'monthly'],
            ['loc' => '/planning/accommodation-styles', 'priority' => '0.7', 'changefreq' => 'monthly'],
            ['loc' => '/planning/visa-entry', 'priority' => '0.7', 'changefreq' => 'monthly'],
            ['loc' => '/planning/health-safety', 'priority' => '0.7', 'changefreq' => 'monthly'],
            ['loc' => '/planning/packing-list', 'priority' => '0.7', 'changefreq' => 'monthly'],
            ['loc' => '/planning/cultural-etiquette', 'priority' => '0.7', 'changefreq' => 'monthly'],
        ];

        $content = '<?xml version="1.0" encoding="UTF-8"?>';
        $content .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        foreach ($pages as $page) {
            $content .= '<url>';
            $content .= '<loc>' . $baseUrl . $page['loc'] . '</loc>';
            $content .= '<changefreq>' . $page['changefreq'] . '</changefreq>';
            $content .= '<priority>' . $page['priority'] . '</priority>';
            $content .= '</url>';
        }

        $content .= '</urlset>';

        return response($content, 200, ['Content-Type' => 'application/xml']);
    }

    public function packages()
    {
        $packages = Package::all();
        return $this->generateSitemap($packages, 'safaris', '0.8');
    }

    public function destinations()
    {
        $destinations = Destination::all();
        return $this->generateSitemap($destinations, 'destinations', '0.8');
    }

    public function posts()
    {
        $posts = Post::where('status', 'published')->get();
        return $this->generateSitemap($posts, 'journal', '0.7');
    }

    private function generateSitemap($items, $prefix, $priority)
    {
        $baseUrl = rtrim(config('app.url'), '/');

        $content = '<?xml version="1.0" encoding="UTF-8"?>';
        $content .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        foreach ($items as $item) {
            $content .= '<url>';
            $content .= '<loc>' . $baseUrl . '/' . $prefix . '/' . $item->slug . '</loc>';
            $content .= '<lastmod>' . $item->updated_at->toIso8601String() . '</lastmod>';
            $content .= '<changefreq>weekly</changefreq>';
            $content .= '<priority>' . $priority . '</priority>';
            $content .= '</url>';
        }

        $content .= '</urlset>';

        return response($content, 200, ['Content-Type' => 'application/xml']);
    }
}
