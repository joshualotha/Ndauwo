<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\Destination;
use App\Models\Post;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

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

        $content .= '<sitemap><loc>' . $baseUrl . '/api/sitemap-static.xml</loc><lastmod>' . now()->toIso8601String() . '</lastmod></sitemap>';
        $content .= '<sitemap><loc>' . $baseUrl . '/api/sitemap-packages.xml</loc><lastmod>' . now()->toIso8601String() . '</lastmod></sitemap>';
        $content .= '<sitemap><loc>' . $baseUrl . '/api/sitemap-destinations.xml</loc><lastmod>' . now()->toIso8601String() . '</lastmod></sitemap>';
        $content .= '<sitemap><loc>' . $baseUrl . '/api/sitemap-posts.xml</loc><lastmod>' . now()->toIso8601String() . '</lastmod></sitemap>';

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
            ['loc' => '/', 'priority' => '1.0', 'changefreq' => 'daily', 'lastmod' => now()],
            ['loc' => '/safaris', 'priority' => '0.9', 'changefreq' => 'weekly'],
            ['loc' => '/safari-types', 'priority' => '0.8', 'changefreq' => 'weekly'],
            ['loc' => '/safari-types/luxury-safari', 'priority' => '0.8', 'changefreq' => 'monthly'],
            ['loc' => '/safari-types/tailor-made-safari', 'priority' => '0.8', 'changefreq' => 'monthly'],
            ['loc' => '/safari-types/mountain-hiking', 'priority' => '0.8', 'changefreq' => 'monthly'],
            ['loc' => '/safari-types/cultural-tours', 'priority' => '0.8', 'changefreq' => 'monthly'],
            ['loc' => '/safari-types/group-safari', 'priority' => '0.8', 'changefreq' => 'monthly'],
            ['loc' => '/safari-types/zanzibar-beach-safari', 'priority' => '0.8', 'changefreq' => 'monthly'],
            ['loc' => '/destinations', 'priority' => '0.9', 'changefreq' => 'weekly'],
            ['loc' => '/journal', 'priority' => '0.8', 'changefreq' => 'weekly'],
            ['loc' => '/about', 'priority' => '0.7', 'changefreq' => 'monthly'],
            ['loc' => '/contact', 'priority' => '0.8', 'changefreq' => 'monthly'],
            ['loc' => '/booking', 'priority' => '0.9', 'changefreq' => 'monthly'],
            ['loc' => '/gallery', 'priority' => '0.6', 'changefreq' => 'monthly'],
            ['loc' => '/reviews', 'priority' => '0.7', 'changefreq' => 'weekly'],
            ['loc' => '/conservation', 'priority' => '0.6', 'changefreq' => 'monthly'],
            ['loc' => '/press', 'priority' => '0.5', 'changefreq' => 'monthly'],
            ['loc' => '/careers', 'priority' => '0.5', 'changefreq' => 'monthly'],
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
            if (!empty($page['lastmod'])) {
                $content .= '<lastmod>' . $page['lastmod']->toIso8601String() . '</lastmod>';
            } else {
                $content .= '<lastmod>' . now()->subDays(30)->toIso8601String() . '</lastmod>';
            }
            $content .= '<changefreq>' . $page['changefreq'] . '</changefreq>';
            $content .= '<priority>' . $page['priority'] . '</priority>';
            $content .= '</url>';
        }

        $content .= '</urlset>';

        return response($content, 200, ['Content-Type' => 'application/xml']);
    }

    /**
     * Generate packages sitemap with images.
     */
    public function packages()
    {
        $packages = Package::all();
        return $this->generateSitemapWithImages($packages, 'safaris', '0.8', 'package');
    }

    /**
     * Generate destinations sitemap with images.
     */
    public function destinations()
    {
        $destinations = Destination::all();
        return $this->generateSitemapWithImages($destinations, 'destinations', '0.8', 'destination');
    }

    /**
     * Generate blog posts sitemap with images.
     */
    public function posts()
    {
        $posts = Post::where('published', true)
            ->where(function ($query) {
                $query->whereNull('published_at')
                      ->orWhere('published_at', '<=', now());
            })
            ->orWhere('status', 'published')
            ->orderBy('published_at', 'desc')
            ->get();
        return $this->generateSitemapWithImages($posts, 'journal', '0.7', 'post');
    }

    /**
     * Generate sitemap with image tags for dynamic content.
     */
    private function generateSitemapWithImages($items, $prefix, $priority, $type)
    {
        $baseUrl = rtrim(config('app.url'), '/');

        $content = '<?xml version="1.0" encoding="UTF-8"?>';
        $content .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">';

        foreach ($items as $item) {
            $itemSlug = $item->slug ?? $item->id;
            $itemUrl = $baseUrl . '/' . $prefix . '/' . $itemSlug;
            $lastmod = $item->updated_at ?? $item->created_at ?? now();

            $content .= '<url>';
            $content .= '<loc>' . $itemUrl . '</loc>';
            $content .= '<lastmod>' . $lastmod->toIso8601String() . '</lastmod>';
            $content .= '<changefreq>weekly</changefreq>';
            $content .= '<priority>' . $priority . '</priority>';

            // Add image tag if model has an image
            $imagePath = $item->image ?? null;
            if ($imagePath) {
                $imageUrl = $this->resolveImageUrl($imagePath, $baseUrl);
                if ($imageUrl) {
                    $imageTitle = $item->title ?? $item->name ?? $type;
                    $content .= '<image:image>';
                    $content .= '<image:loc>' . $imageUrl . '</image:loc>';
                    $content .= '<image:title>' . $this->escapeXml($imageTitle) . '</image:title>';
                    $content .= '<image:caption>' . $this->escapeXml(mb_substr(strip_tags($item->description ?? $item->summary ?? ''), 0, 200)) . '</image:caption>';
                    $content .= '</image:image>';
                }
            }

            $content .= '</url>';
        }

        $content .= '</urlset>';

        return response($content, 200, ['Content-Type' => 'application/xml']);
    }

    /**
     * Resolve image path to full URL.
     */
    private function resolveImageUrl(?string $path, string $baseUrl): ?string
    {
        if (empty($path)) {
            return null;
        }

        if (str_starts_with($path, 'http')) {
            return $path;
        }

        if (str_starts_with($path, '/')) {
            return $baseUrl . $path;
        }

        // Storage path
        return $baseUrl . '/storage/' . $path;
    }

    /**
     * Escape XML special characters.
     */
    private function escapeXml(string $string): string
    {
        return htmlspecialchars($string, ENT_XML1 | ENT_QUOTES, 'UTF-8');
    }

    /**
     * Legacy method for simple sitemap generation (kept for reference).
     */
    private function generateSitemap($items, $prefix, $priority)
    {
        $baseUrl = rtrim(config('app.url'), '/');

        $content = '<?xml version="1.0" encoding="UTF-8"?>';
        $content .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        foreach ($items as $item) {
            $itemSlug = $item->slug ?? $item->id;
            $lastmod = $item->updated_at ?? $item->created_at ?? now();

            $content .= '<url>';
            $content .= '<loc>' . $baseUrl . '/' . $prefix . '/' . $itemSlug . '</loc>';
            $content .= '<lastmod>' . $lastmod->toIso8601String() . '</lastmod>';
            $content .= '<changefreq>weekly</changefreq>';
            $content .= '<priority>' . $priority . '</priority>';
            $content .= '</url>';
        }

        $content .= '</urlset>';

        return response($content, 200, ['Content-Type' => 'application/xml']);
    }
}
