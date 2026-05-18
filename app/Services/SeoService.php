<?php

namespace App\Services;

use App\Models\Package;
use App\Models\Destination;
use App\Models\Post;
use App\Models\Setting;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Storage;

class SeoService
{
    /**
     * Cached model instance for the current request (if a dynamic route).
     */
    protected mixed $currentModel = null;

    /**
     * Cached dynamic route info: ['type' => 'package'|'destination'|'post', 'model' => Model|null]
     */
    protected ?array $dynamicRouteInfo = null;

    /**
     * Get the full SEO meta array for a given path.
     */
    public function getMeta(string $path): array
    {
        $path = $this->normalizePath($path);
        $this->resolveDynamicRoute($path);
        $routeConfig = $this->findRouteConfig($path);
        $meta = $this->buildMeta($path, $routeConfig);

        $meta['structured_data'] = $this->buildStructuredData($path, $meta);

        return $meta;
    }

    /**
     * Get the resolved model for the current dynamic route (if any).
     * Used by the view to access model data for structured data generation.
     */
    public function getCurrentModel(): mixed
    {
        return $this->currentModel;
    }

    /**
     * Get the dynamic route type if applicable.
     */
    public function getDynamicRouteType(): ?string
    {
        return $this->dynamicRouteInfo['type'] ?? null;
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
     * Resolve dynamic routes by attempting to load the matching model.
     * Detects patterns like /safaris/{slug}, /destinations/{slug}, /journal/{slug}.
     */
    protected function resolveDynamicRoute(string $path): void
    {
        $segments = explode('/', trim($path, '/'));

        // Need at least 2 segments for a dynamic route (e.g., safaris/something)
        if (count($segments) < 2) {
            return;
        }

        $prefix = $segments[0];
        $identifier = $segments[1] ?? null;

        if (!$identifier) {
            return;
        }

        $model = null;

        switch ($prefix) {
            case 'safaris':
                $model = Package::where('id', $identifier)
                    ->orWhere('slug', $identifier)
                    ->first();
                if ($model) {
                    $this->dynamicRouteInfo = ['type' => 'package', 'model' => $model];
                    $this->currentModel = $model;
                }
                break;

            case 'destinations':
                $model = Destination::where('id', $identifier)
                    ->orWhere('slug', $identifier)
                    ->first();
                if ($model) {
                    $this->dynamicRouteInfo = ['type' => 'destination', 'model' => $model];
                    $this->currentModel = $model;
                }
                break;

            case 'journal':
                $model = Post::where('id', $identifier)
                    ->orWhere('slug', $identifier)
                    ->first();
                if ($model) {
                    $this->dynamicRouteInfo = ['type' => 'post', 'model' => $model];
                    $this->currentModel = $model;
                }
                break;
        }
    }

    /**
     * Find matching route config from seo.php.
     * Checks exact match first, then parent routes, then defaults.
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

        // Dynamic route: match parent path (e.g., /safaris/anything → /safaris config)
        if ($this->dynamicRouteInfo) {
            $segments = explode('/', trim($path, '/'));
            if (count($segments) >= 2) {
                $parentPath = '/' . $segments[0];
                if (isset($routes[$parentPath])) {
                    return $routes[$parentPath];
                }
            }
        }

        return null;
    }

    /**
     * Build the complete meta array.
     */
    protected function buildMeta(string $path, ?array $routeConfig): array
    {
        $title = $this->resolveTitle($path, $routeConfig);
        $description = $this->resolveDescription($path, $routeConfig);
        $ogImage = $this->resolveOgImage($routeConfig);
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
     * Resolve the page title.
     * Priority: model seo_title > route config > default.
     */
    protected function resolveTitle(string $path, ?array $routeConfig): string
    {
        // Check model-based seo_title
        if ($this->currentModel && !empty($this->currentModel->seo_title)) {
            return $this->currentModel->seo_title;
        }

        // Check model title/name as fallback
        if ($this->currentModel) {
            $fallback = $this->currentModel->title ?? $this->currentModel->name ?? null;
            if ($fallback) {
                return $fallback . ' — Ndauwo Safari Co.';
            }
        }

        return $routeConfig['title'] ?? config('seo.default_title');
    }

    /**
     * Resolve the page description.
     * Priority: model seo_description > route config > default.
     */
    protected function resolveDescription(string $path, ?array $routeConfig): string
    {
        if ($this->currentModel && !empty($this->currentModel->seo_description)) {
            return $this->currentModel->seo_description;
        }

        if ($this->currentModel) {
            $fallback = $this->currentModel->description
                ?? $this->currentModel->summary
                ?? null;
            if ($fallback) {
                // Truncate to ~155 chars for meta description
                return mb_substr(strip_tags($fallback), 0, 160);
            }
        }

        return $routeConfig['description'] ?? config('seo.default_description');
    }

    /**
     * Resolve the OG image URL.
     * Priority: model image > route config > default.
     */
    protected function resolveOgImage(?array $routeConfig): string
    {
        if ($this->currentModel && !empty($this->currentModel->image)) {
            $image = $this->currentModel->image;
            // Handle storage paths
            if (!str_starts_with($image, 'http') && !str_starts_with($image, '/')) {
                return asset('storage/' . $image);
            }
            return asset($image);
        }

        return asset(config('seo.default_og_image'));
    }

    /**
     * Build JSON-LD structured data script tags.
     */
    protected function buildStructuredData(string $path, array $meta): string
    {
        $scripts = [];

        // Organization (all pages)
        $scripts[] = $this->organizationSchema();

        // WebSite schema (all pages — enables Sitelinks Search Box)
        $scripts[] = $this->websiteSchema();

        // BreadcrumbList (all pages except home)
        if ($path !== '/') {
            $scripts[] = $this->breadcrumbSchema($path, $meta);
        }

        // Dynamic model-specific schemas
        if ($this->dynamicRouteInfo) {
            switch ($this->dynamicRouteInfo['type']) {
                case 'package':
                    $scripts[] = $this->packageSchema();
                    break;
                case 'destination':
                    $scripts[] = $this->destinationSchema();
                    break;
                case 'post':
                    $scripts[] = $this->articleSchema();
                    break;
            }
        }

        return implode("\n", $scripts);
    }

    /**
     * Generate TourOperator / Organization schema.
     */
    protected function organizationSchema(): string
    {
        $socialProfiles = $this->getSocialProfiles();

        $data = [
            '@context' => 'https://schema.org',
            '@type' => 'TourOperator',
            '@id' => URL::to('/') . '#organization',
            'name' => config('seo.site_name'),
            'url' => URL::to('/'),
            'logo' => [
                '@type' => 'ImageObject',
                'url' => asset(config('seo.default_og_image')),
            ],
            'description' => config('seo.default_description'),
            'address' => [
                '@type' => 'PostalAddress',
                'addressLocality' => 'Arusha',
                'addressCountry' => 'TZ',
            ],
            'contactPoint' => [
                '@type' => 'ContactPoint',
                'contactType' => 'customer service',
                'telephone' => $this->getSetting('contact_phone', '+255-XXX-XXX-XXX'),
                'availableLanguage' => ['English', 'Swahili'],
            ],
            'sameAs' => $socialProfiles,
        ];

        return $this->toJsonLd($data);
    }

    /**
     * Get social profile URLs from settings, with fallbacks.
     */
    protected function getSocialProfiles(): array
    {
        $profiles = [];

        // Try stored JSON seo_social_profiles first
        $storedProfiles = $this->getSetting('seo_social_profiles');
        if ($storedProfiles && is_string($storedProfiles)) {
            $decoded = json_decode($storedProfiles, true);
            if (is_array($decoded) && !empty($decoded)) {
                return $decoded;
            }
        }

        // Build from individual social settings
        $socialKeys = [
            'social_tripadvisor' => 'https://www.tripadvisor.com/',
            'social_facebook' => 'https://www.facebook.com/',
            'social_instagram' => 'https://www.instagram.com/',
            'social_youtube' => null,
            'social_twitter' => null,
            'social_linkedin' => null,
        ];

        foreach ($socialKeys as $key => $default) {
            $value = $this->getSetting($key, $default);
            if (!empty($value)) {
                $profiles[] = $value;
            }
        }

        return !empty($profiles) ? $profiles : [
            'https://www.tripadvisor.com/',
            'https://www.facebook.com/',
            'https://www.instagram.com/',
        ];
    }

    /**
     * Get a setting value by key.
     */
    protected function getSetting(string $key, mixed $default = null): mixed
    {
        try {
            $setting = Setting::where('key', $key)->first();
            return $setting ? $setting->value : $default;
        } catch (\Exception $e) {
            return $default;
        }
    }

    /**
     * Generate WebSite schema with SearchAction (Sitelinks Search Box).
     */
    protected function websiteSchema(): string
    {
        $data = [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            '@id' => URL::to('/') . '#website',
            'url' => URL::to('/'),
            'name' => config('seo.site_name'),
            'description' => config('seo.default_description'),
            'potentialAction' => [
                '@type' => 'SearchAction',
                'target' => [
                    '@type' => 'EntryPoint',
                    'urlTemplate' => URL::to('/') . '/?s={search_term_string}',
                ],
                'query-input' => 'required name=search_term_string',
            ],
        ];

        return $this->toJsonLd($data);
    }

    /**
     * Generate Product / TouristTrip schema for a safari package.
     */
    protected function packageSchema(): string
    {
        $package = $this->currentModel;
        if (!$package) {
            return '';
        }

        $packageUrl = URL::to('/safaris/' . ($package->slug ?? $package->id));
        $imageUrl = $this->resolveModelImageUrl($package->image);
        $price = $package->price ?? 0;
        $currency = $package->currency ?? 'USD';

        $data = [
            '@context' => 'https://schema.org',
            '@type' => 'Product',
            '@id' => $packageUrl . '#product',
            'name' => $package->title ?? $package->name ?? 'Safari Package',
            'description' => mb_substr(strip_tags($package->description ?? $package->seo_description ?? ''), 0, 500),
            'image' => $imageUrl,
            'url' => $packageUrl,
            'brand' => [
                '@type' => 'Brand',
                'name' => config('seo.site_name'),
            ],
            'offers' => [
                '@type' => 'Offer',
                'price' => $price,
                'priceCurrency' => $currency,
                'availability' => 'https://schema.org/InStock',
                'url' => $packageUrl,
            ],
            'category' => $package->type ?? 'Safari',
        ];

        // Add TouristTrip data if available
        if (!empty($package->duration_days)) {
            $data['@type'] = ['Product', 'TouristTrip'];
            $data['touristType'] = $this->packageTouristTypes($package);
            if (!empty($package->daily_itinerary)) {
                $data['itinerary'] = $this->buildItineraryItemList($package->daily_itinerary);
            }
        }

        return $this->toJsonLd($data);
    }

    /**
     * Generate schema for a destination.
     */
    protected function destinationSchema(): string
    {
        $dest = $this->currentModel;
        if (!$dest) {
            return '';
        }

        $destUrl = URL::to('/destinations/' . ($dest->slug ?? $dest->id));
        $imageUrl = $this->resolveModelImageUrl($dest->image);

        $data = [
            '@context' => 'https://schema.org',
            '@type' => 'TouristDestination',
            '@id' => $destUrl . '#destination',
            'name' => $dest->name ?? 'Destination',
            'description' => mb_substr(strip_tags($dest->description ?? ''), 0, 500),
            'image' => $imageUrl,
            'url' => $destUrl,
            'touristType' => 'WildlifeEnthusiast',
        ];

        return $this->toJsonLd($data);
    }

    /**
     * Generate Article schema for a blog post.
     */
    protected function articleSchema(): string
    {
        $post = $this->currentModel;
        if (!$post) {
            return '';
        }

        $postUrl = URL::to('/journal/' . ($post->slug ?? $post->id));
        $imageUrl = $this->resolveModelImageUrl($post->image);
        $authorName = $post->author ?? config('seo.site_name');
        $publishedDate = $post->published_at?->toIso8601String()
            ?? $post->created_at?->toIso8601String()
            ?? date('c');

        $data = [
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            '@id' => $postUrl . '#article',
            'headline' => $post->title ?? 'Blog Post',
            'description' => mb_substr(strip_tags($post->summary ?? $post->seo_description ?? $post->content ?? ''), 0, 500),
            'image' => $imageUrl,
            'url' => $postUrl,
            'datePublished' => $publishedDate,
            'dateModified' => $post->updated_at?->toIso8601String() ?? $publishedDate,
            'author' => [
                '@type' => 'Person',
                'name' => $authorName,
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => config('seo.site_name'),
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => asset(config('seo.default_og_image')),
                ],
            ],
            'mainEntityOfPage' => [
                '@type' => 'WebPage',
                '@id' => $postUrl,
            ],
        ];

        if (!empty($post->category)) {
            $data['articleSection'] = $post->category;
        }

        if (!empty($post->tags) && is_array($post->tags)) {
            $data['keywords'] = implode(', ', $post->tags);
        }

        return $this->toJsonLd($data);
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

        foreach ($segments as $index => $segment) {
            $accumulatedPath .= '/' . $segment;

            // Check if this is the last segment (the dynamic item)
            $isLastSegment = ($index === count($segments) - 1);

            // For the last segment with a resolved model, use the model's name
            if ($isLastSegment && $this->currentModel) {
                $label = $this->currentModel->title
                    ?? $this->currentModel->name
                    ?? $this->humanizeSegment($segment);
            } else {
                $label = $labels[$accumulatedPath]
                    ?? $labels['/' . $segment]
                    ?? $this->humanizeSegment($segment);
            }

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

        return $this->toJsonLd($data);
    }

    /**
     * Generate FAQ schema for planning pages.
     * Add FAQ content to config/seo.php for planning pages.
     */
    public function faqSchema(array $faqs): string
    {
        if (empty($faqs)) {
            return '';
        }

        $data = [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => [],
        ];

        foreach ($faqs as $faq) {
            $data['mainEntity'][] = [
                '@type' => 'Question',
                'name' => $faq['question'] ?? '',
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => $faq['answer'] ?? '',
                ],
            ];
        }

        return $this->toJsonLd($data);
    }

    /**
     * Generate AggregateRating schema.
     */
    public function aggregateRatingSchema(float $rating, int $reviewCount): string
    {
        $data = [
            '@context' => 'https://schema.org',
            '@type' => 'AggregateRating',
            'itemReviewed' => [
                '@type' => 'TourOperator',
                'name' => config('seo.site_name'),
            ],
            'ratingValue' => $rating,
            'bestRating' => 5,
            'worstRating' => 1,
            'ratingCount' => $reviewCount,
        ];

        return $this->toJsonLd($data);
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

    /**
     * Resolve a model image path to a full URL.
     */
    protected function resolveModelImageUrl(?string $imagePath): string
    {
        if (empty($imagePath)) {
            return asset(config('seo.default_og_image'));
        }

        if (str_starts_with($imagePath, 'http')) {
            return $imagePath;
        }

        if (str_starts_with($imagePath, '/')) {
            return asset($imagePath);
        }

        return asset('storage/' . $imagePath);
    }

    /**
     * Build itinerary ItemList for TouristTrip schema.
     */
    protected function buildItineraryItemList(array $itinerary): array
    {
        $items = [];
        foreach ($itinerary as $index => $day) {
            $items[] = [
                '@type' => 'ListItem',
                'position' => $index + 1,
                'name' => $day['title'] ?? ($day['day'] ?? 'Day ' . ($index + 1)),
                'description' => mb_substr(strip_tags($day['content'] ?? ''), 0, 300),
            ];
        }

        return [
            '@type' => 'ItemList',
            'itemListElement' => $items,
        ];
    }

    /**
     * Get tourist types for a package based on its type/difficulty.
     */
    protected function packageTouristTypes($package): array
    {
        $types = ['WildlifeEnthusiast', 'NatureLover'];

        $type = strtolower($package->type ?? '');
        $difficulty = strtolower($package->difficulty ?? '');

        if (str_contains($type, 'luxury') || str_contains($type, 'premium')) {
            $types[] = 'LuxuryTraveler';
        }
        if (str_contains($type, 'hiking') || str_contains($type, 'trekking') || str_contains($type, 'mountain') || $difficulty === 'strenuous') {
            $types[] = 'AdventureTraveler';
        }
        if (str_contains($type, 'beach') || str_contains($type, 'zanzibar')) {
            $types[] = 'BeachGoer';
        }
        if (str_contains($type, 'cultural') || str_contains($type, 'tour')) {
            $types[] = 'CulturalTraveler';
        }
        if (str_contains($type, 'group') || str_contains($type, 'shared')) {
            $types[] = 'BudgetTraveler';
        }
        if (str_contains($type, 'photography') || str_contains($type, 'photo')) {
            $types[] = 'PhotographyEnthusiast';
        }

        return $types;
    }

    /**
     * Format data as JSON-LD script tag.
     */
    protected function toJsonLd(array $data): string
    {
        $json = json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

        return '<script type="application/ld+json">' . $json . '</script>';
    }
}
