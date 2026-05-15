<?php

namespace App\Services;

use Illuminate\Support\Facades\URL;

class SeoService
{
    /**
     * Get the full SEO meta array for a given path.
     */
    public function getMeta(string $path): array
    {
        $path = $this->normalizePath($path);
        $routeConfig = $this->findRouteConfig($path);
        $meta = $this->buildMeta($path, $routeConfig);

        $meta['structured_data'] = $this->buildStructuredData($path, $meta);

        return $meta;
    }

    /**
     * Normalize path: strip leading/trailing slashes, default to '/' for root.
     */
    protected function normalizePath(string $path): string
    {
        $path = trim($path, '/');
        if ($path === '') {
            return '/';
        }
        return '/' . $path;
    }

    /**
     * Find matching route config from seo.php.
     * Checks exact match first, then falls back to defaults.
     */
    protected function findRouteConfig(string $path): ?array
    {
        $routes = config('seo.routes', []);

        // Exact match
        if (isset($routes[$path])) {
            return $routes[$path];
        }

        // Try without trailing slash variations
        $trimmed = rtrim($path, '/');
        if ($trimmed !== $path && isset($routes[$trimmed])) {
            return $routes[$trimmed];
        }

        return null;
    }

    /**
     * Build the complete meta array.
     */
    protected function buildMeta(string $path, ?array $routeConfig): array
    {
        $title = $routeConfig['title'] ?? config('seo.default_title');
        $description = $routeConfig['description'] ?? config('seo.default_description');
        $ogImage = asset(config('seo.default_og_image'));
        $canonical = URL::to($path === '/' ? '/' : $path);

        return [
            'title' => $title,
            'description' => $description,
            'og_title' => $title,
            'og_description' => $description,
            'og_image' => $ogImage,
            'canonical' => $canonical,
        ];
    }

    /**
     * Build JSON-LD structured data script tags.
     */
    protected function buildStructuredData(string $path, array $meta): string
    {
        $scripts = [];

        // Organization (all pages)
        $scripts[] = $this->organizationSchema();

        // BreadcrumbList (all pages except home)
        if ($path !== '/') {
            $scripts[] = $this->breadcrumbSchema($path, $meta);
        }

        return implode("\n", $scripts);
    }

    /**
     * Generate TourOperator / Organization schema.
     */
    protected function organizationSchema(): string
    {
        $data = [
            '@context' => 'https://schema.org',
            '@type' => 'TourOperator',
            'name' => config('seo.site_name'),
            'url' => URL::to('/'),
            'logo' => asset(config('seo.default_og_image')),
            'description' => config('seo.default_description'),
            'address' => [
                '@type' => 'PostalAddress',
                'addressLocality' => 'Arusha',
                'addressCountry' => 'TZ',
            ],
            'contactPoint' => [
                '@type' => 'ContactPoint',
                'contactType' => 'customer service',
                'availableLanguage' => ['English', 'Swahili'],
            ],
        ];

        $json = json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

        return '<script type="application/ld+json">' . $json . '</script>';
    }

    /**
     * Generate BreadcrumbList schema from the path.
     */
    protected function breadcrumbSchema(string $path, array $meta): string
    {
        $segments = explode('/', trim($path, '/'));
        $items = [];
        $position = 1;

        // Home
        $items[] = [
            '@type' => 'ListItem',
            'position' => $position++,
            'name' => 'Home',
            'item' => URL::to('/'),
        ];

        $accumulatedPath = '';
        $labels = $this->breadcrumbLabels();

        foreach ($segments as $segment) {
            $accumulatedPath .= '/' . $segment;

            // Skip numeric IDs in breadcrumbs — use friendly labels
            $label = $labels[$accumulatedPath]
                ?? $labels['/' . $segment]
                ?? $this->humanizeSegment($segment);

            $items[] = [
                '@type' => 'ListItem',
                'position' => $position++,
                'name' => $label,
                'item' => URL::to($accumulatedPath),
            ];
        }

        $data = [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => $items,
        ];

        $json = json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

        return '<script type="application/ld+json">' . $json . '</script>';
    }

    /**
     * Map URL path segments to human-readable breadcrumb labels.
     */
    protected function breadcrumbLabels(): array
    {
        return [
            '/safaris' => 'Safari Packages',
            '/safari-types' => 'Safari Experiences',
            '/safari-types/mountain-hiking' => 'Mountain Hiking',
            '/safari-types/cultural-tours' => 'Cultural Tours',
            '/safari-types/luxury-safari' => 'Luxury Safaris',
            '/safari-types/tailor-made-safari' => 'Tailor-Made Safaris',
            '/safari-types/zanzibar-beach-safari' => 'Zanzibar Beach Safaris',
            '/safari-types/group-safari' => 'Group Safaris',
            '/destinations' => 'Destinations',
            '/journal' => 'Travel Journal',
            '/about' => 'About Us',
            '/contact' => 'Contact',
            '/gallery' => 'Gallery',
            '/reviews' => 'Reviews',
            '/conservation' => 'Conservation',
            '/press' => 'Press & Media Kit',
            '/careers' => 'Careers',
            '/planning' => 'Planning Tips',
            '/planning/accommodation-styles' => 'Accommodation Styles',
            '/planning/visa-entry' => 'Visa & Entry',
            '/planning/health-safety' => 'Health & Safety',
            '/planning/packing-list' => 'Packing List',
            '/planning/cultural-etiquette' => 'Cultural Etiquette',
        ];
    }

    /**
     * Convert a URL segment to a human-readable label.
     */
    protected function humanizeSegment(string $segment): string
    {
        // Skip purely numeric segments (IDs)
        if (is_numeric($segment)) {
            return 'Detail';
        }

        return ucwords(str_replace(['-', '_'], ' ', $segment));
    }
}
