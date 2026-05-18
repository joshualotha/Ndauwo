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
     * Priority: model image > settings seo_og_image > route config > default.
     */
    protected function resolveOgImage(?array $routeConfig): string
    {
        if ($this->currentModel && !empty($this->currentModel->image)) {
            $image = $this->currentModel->image;
            if (!str_starts_with($image, 'http') && !str_starts_with($image, '/')) {
                return asset('storage/' . $image);
            }
            return asset($image);
        }

        // Check settings for custom OG image
        $ogImage = $this->getSetting('seo_og_image');
        if (!empty($ogImage)) {
            if (str_starts_with($ogImage, 'http')) {
                return $ogImage;
            }
            if (str_starts_with($ogImage, '/')) {
                return asset($ogImage);
            }
            return asset('storage/' . $ogImage);
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

        // FAQ schema on planning/pages
        if (str_contains($path, '/planning/')) {
            $faqs = $this->getFaqsForPath($path);
            if (!empty($faqs)) {
                $scripts[] = $this->faqSchema($faqs);
            }
        }

        // AggregateRating on reviews page
        if ($path === '/reviews') {
            $rating = (float) $this->getSetting('seo_aggregate_rating', '4.9');
            $reviewCount = (int) $this->getSetting('seo_review_count', '312');
            $scripts[] = $this->aggregateRatingSchema($rating, $reviewCount);
        }

        // AggregateRating on home page
        if ($path === '/') {
            $rating = (float) $this->getSetting('seo_aggregate_rating', '4.9');
            $reviewCount = (int) $this->getSetting('seo_review_count', '312');
            $scripts[] = $this->aggregateRatingSchema($rating, $reviewCount);
        }

        return implode("\n", $scripts);
    }

    /**
     * Generate combined TourOperator + LocalBusiness schema.
     * Dual-type for enhanced local SEO and Google Business Profile matching.
     */
    protected function organizationSchema(): string
    {
        $socialProfiles = $this->getSocialProfiles();
        $phone = $this->getSetting('contact_phone', '+255-XXX-XXX-XXX');
        $addressStreet = $this->getSetting('office_address', 'Arusha Safari Centre');
        $rating = (float) $this->getSetting('seo_aggregate_rating', '4.9');
        $reviewCount = (int) $this->getSetting('seo_review_count', '312');
        $priceRange = $this->getSetting('seo_price_range', '$$$');

        $data = [
            '@context' => 'https://schema.org',
            '@type' => ['TourOperator', 'LocalBusiness'],
            '@id' => URL::to('/') . '#organization',
            'name' => config('seo.site_name'),
            'alternateName' => 'Ndauwo Safaris',
            'url' => URL::to('/'),
            'logo' => [
                '@type' => 'ImageObject',
                'url' => asset(config('seo.default_og_image')),
            ],
            'image' => asset(config('seo.default_og_image')),
            'description' => config('seo.default_description'),
            'telephone' => $phone,
            'priceRange' => $priceRange,
            'email' => $this->getSetting('contact_email', 'info@ndauwo.com'),
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => $addressStreet,
                'addressLocality' => 'Arusha',
                'addressRegion' => 'Arusha Region',
                'postalCode' => $this->getSetting('seo_postal_code', '23000'),
                'addressCountry' => 'TZ',
            ],
            'geo' => [
                '@type' => 'GeoCoordinates',
                'latitude' => (float) $this->getSetting('gps_lat', '-3.3869'),
                'longitude' => (float) $this->getSetting('gps_lng', '36.6830'),
            ],
            'openingHoursSpecification' => [
                [
                    '@type' => 'OpeningHoursSpecification',
                    'dayOfWeek' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
                    'opens' => '08:00',
                    'closes' => '17:00',
                ],
                [
                    '@type' => 'OpeningHoursSpecification',
                    'dayOfWeek' => 'Saturday',
                    'opens' => '09:00',
                    'closes' => '14:00',
                ],
            ],
            'contactPoint' => [
                '@type' => 'ContactPoint',
                'contactType' => 'customer service',
                'telephone' => $phone,
                'email' => $this->getSetting('contact_email', 'info@ndauwo.com'),
                'availableLanguage' => ['English', 'Swahili', 'German', 'French'],
            ],
            'sameAs' => $socialProfiles,
            'aggregateRating' => [
                '@type' => 'AggregateRating',
                'ratingValue' => $rating,
                'bestRating' => 5,
                'worstRating' => 1,
                'ratingCount' => $reviewCount,
            ],
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
     * Get FAQ data for a specific planning path.
     * Returns array of ['question' => ..., 'answer' => ...] pairs.
     */
    protected function getFaqsForPath(string $path): array
    {
        $faqs = [
            '/planning/accommodation-styles' => [
                [
                    'question' => 'What types of accommodation are available on a Tanzania safari?',
                    'answer' => 'Tanzania safari accommodations range from luxury lodges and tented camps to mobile camps and budget-friendly options. Ndauwo offers all categories, from premium permanent lodges in Serengeti to intimate mobile camps that move with the Great Migration.',
                ],
                [
                    'question' => 'What is the difference between a tented camp and a lodge?',
                    'answer' => 'Tented camps offer a more immersive bush experience with canvas walls that bring you closer to nature, while lodges provide permanent stone-and-thatch structures with more amenities. Both offer en-suite bathrooms, comfortable beds, and excellent service.',
                ],
                [
                    'question' => 'Are luxury safari tents safe from wildlife?',
                    'answer' => 'Yes. Luxury tented camps are designed with safety as a priority. They are fenced or have natural barriers, and askaris (security guards) escort guests to their tents after dark. The tent fabric is heavy-duty, and all zippers secure from inside.',
                ],
                [
                    'question' => 'Can I combine different accommodation styles on one safari?',
                    'answer' => 'Absolutely. Many Ndauwo guests combine a few nights in a luxury lodge with mobile tented camping for varied experiences. This is a popular way to enjoy both comfort and wilderness immersion on the same trip.',
                ],
            ],
            '/planning/visa-entry' => [
                [
                    'question' => 'Do I need a visa for a Tanzania safari?',
                    'answer' => 'Most nationalities require a visa for Tanzania. Citizens of the USA, UK, Canada, Australia, and most European countries can obtain a visa on arrival at Kilimanjaro International Airport or apply online for an e-Visa before travel.',
                ],
                [
                    'question' => 'How long does a Tanzania tourist visa last?',
                    'answer' => 'A standard Tanzania tourist visa is valid for 90 days from the date of issue and allows a single entry. Multi-entry visas are available for specific circumstances.',
                ],
                [
                    'question' => 'Can I get a visa on arrival at Kilimanjaro Airport?',
                    'answer' => 'Yes. Visas on arrival are available at Kilimanjaro International Airport (JRO), Julius Nyerere International Airport (DAR), and all official border crossings. You\'ll need a valid passport (6+ months validity), a return ticket, and the visa fee in cash (USD).',
                ],
                [
                    'question' => 'Do I need a yellow fever vaccination for Tanzania?',
                    'answer' => 'A yellow fever vaccination certificate is required if you are arriving from a country with yellow fever risk. Otherwise, it is not mandatory but is highly recommended by health authorities.',
                ],
            ],
            '/planning/health-safety' => [
                [
                    'question' => 'Is Tanzania safe for safari travelers?',
                    'answer' => 'Yes. Tanzania is one of Africa\'s safest safari destinations. Wildlife areas are well-regulated by park authorities, and Ndauwo\'s expert guides prioritize guest safety at all times. Crime against tourists is rare in safari areas.',
                ],
                [
                    'question' => 'What vaccinations do I need for a Tanzania safari?',
                    'answer' => 'Recommended vaccinations include Hepatitis A, Typhoid, Tetanus, and Yellow Fever (if traveling from an endemic country). Malaria prophylaxis is strongly recommended. Consult your travel doctor 4-6 weeks before departure.',
                ],
                [
                    'question' => 'Do I need malaria medication for a Serengeti safari?',
                    'answer' => 'Yes. Malaria is present in Tanzania\'s low-lying areas including Serengeti and Ngorongoro. We strongly recommend antimalarial medication combined with mosquito repellent, long sleeves at dusk, and treated bed nets provided by all Ndauwo camps and lodges.',
                ],
                [
                    'question' => 'Is travel insurance mandatory for Tanzania safaris?',
                    'answer' => 'While not legally mandatory, comprehensive travel insurance is required for all Ndauwo safaris. It must cover medical evacuation, trip cancellation, and baggage loss. We recommend policies that specifically cover wildlife safari activities.',
                ],
            ],
            '/planning/packing-list' => [
                [
                    'question' => 'What should I pack for a Tanzania safari?',
                    'answer' => 'Essential safari packing includes lightweight neutral-colored clothing (khaki, olive, beige), a warm jacket for morning game drives, comfortable walking shoes, a wide-brimmed hat, sunglasses, sunscreen, insect repellent, binoculars, camera gear, and a reusable water bottle.',
                ],
                [
                    'question' => 'What colors should I avoid wearing on safari?',
                    'answer' => 'Avoid bright colors (red, yellow, white) and dark blue (attracts tsetse flies). Stick to neutral earth tones like khaki, olive, beige, and brown. These colors help you blend into the environment and improve wildlife viewing.',
                ],
                [
                    'question' => 'Do I need formal wear for safari lodges?',
                    'answer' => 'No. Safari lodges and camps are relaxed and casual. Smart-casual attire is fine for dinner. Some premium lodges may request long trousers for men at dinner, but jackets and ties are never required.',
                ],
                [
                    'question' => 'What camera equipment is best for safari photography?',
                    'answer' => 'A DSLR or mirrorless camera with a telephoto zoom lens (100-400mm or 200-500mm) is ideal. Bring extra memory cards (minimum 128GB total), a lens cleaning kit, and a beanbag or monopod for stability in vehicles. Smartphone cameras with 3x+ optical zoom can also capture excellent images.',
                ],
            ],
            '/planning/cultural-etiquette' => [
                [
                    'question' => 'How should I greet Maasai or local Tanzanians?',
                    'answer' => 'A simple handshake with a warm smile is the standard greeting. For elders or respected community members, using your right hand while touching your left forearm is a sign of respect. Learn "Jambo" (hello) and "Asante" (thank you) in Swahili.',
                ],
                [
                    'question' => 'Can I take photos of local people in Tanzania?',
                    'answer' => 'Always ask permission before photographing people. Some Maasai villages may charge a small fee for photography. Ndauwo guides will facilitate respectful interactions and help you understand local photography customs.',
                ],
                [
                    'question' => 'What is the tipping etiquette on a Tanzania safari?',
                    'answer' => 'Tipping is customary for safari guides, camp staff, and drivers. Recommended amounts: $15-20 per guest per day for your guide, $10-15 per guest per day for camp staff. Tips are appreciated but not mandatory. Ndauwo provides detailed tipping guidelines in your pre-departure materials.',
                ],
                [
                    'question' => 'What should I wear when visiting local villages?',
                    'answer' => 'Dress modestly when visiting villages. Both men and women should cover shoulders and knees. Revealing clothing is considered disrespectful. Lightweight, breathable fabrics are recommended for the climate.',
                ],
            ],
        ];

        return $faqs[$path] ?? [];
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
