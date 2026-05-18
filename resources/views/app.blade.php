<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8" />
    <link rel="icon" type="image/svg+xml" href="/vite.svg" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    {{-- ========== DNS Prefetch / Preconnect for Performance ========== --}}
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link rel="dns-prefetch" href="https://fonts.googleapis.com" />
    <link rel="dns-prefetch" href="https://cdn.gtranslate.net" />

    {{-- ========== SEO META TAGS (Server-Rendered) ========== --}}
    <title>{{ $seo['title'] }}</title>
    <meta name="description" content="{{ $seo['description'] }}" />

    {{-- Robots meta --}}
    <meta name="robots" content="{{ $seo['robots'] ?? 'index, follow' }}" />

    {{-- Open Graph --}}
    <meta property="og:title" content="{{ $seo['og_title'] }}" />
    <meta property="og:description" content="{{ $seo['og_description'] }}" />
    <meta property="og:image" content="{{ $seo['og_image'] }}" />
    <meta property="og:image:width" content="1200" />
    <meta property="og:image:height" content="630" />
    <meta property="og:url" content="{{ $seo['canonical'] }}" />
    <meta property="og:type" content="{{ $seo['og_type'] ?? 'website' }}" />
    <meta property="og:site_name" content="{{ config('seo.site_name') }}" />
    <meta property="og:locale" content="en_US" />

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="{{ $seo['twitter_card'] ?? 'summary_large_image' }}" />
    <meta name="twitter:title" content="{{ $seo['title'] }}" />
    <meta name="twitter:description" content="{{ $seo['description'] }}" />
    <meta name="twitter:image" content="{{ $seo['og_image'] }}" />

    {{-- Canonical --}}
    <link rel="canonical" href="{{ $seo['canonical'] }}" />

    {{-- Hreflang Tags for GTranslate Languages --}}
    <link rel="alternate" hreflang="en" href="{{ $seo['canonical'] }}" />
    <link rel="alternate" hreflang="fr" href="{{ $seo['canonical'] }}" />
    <link rel="alternate" hreflang="it" href="{{ $seo['canonical'] }}" />
    <link rel="alternate" hreflang="es" href="{{ $seo['canonical'] }}" />
    <link rel="alternate" hreflang="sv" href="{{ $seo['canonical'] }}" />
    <link rel="alternate" hreflang="pl" href="{{ $seo['canonical'] }}" />
    <link rel="alternate" hreflang="zh-CN" href="{{ $seo['canonical'] }}" />
    <link rel="alternate" hreflang="de" href="{{ $seo['canonical'] }}" />
    <link rel="alternate" hreflang="x-default" href="{{ $seo['canonical'] }}" />

    {{-- JSON-LD Structured Data --}}
    {!! $seo['structured_data'] !!}

    {{-- Google Fonts — Asilia-Inspired Font Stack --}}
    <link
        href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=Dancing+Script:wght@400&family=Jost:wght@300;400;500;600&family=Playfair+Display:ital,wght@0,400;0,700;1,400&display=swap"
        rel="stylesheet" />

    {{-- Google Analytics 4 (from settings if configured) --}}
    @if(!empty($ga4_id))
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $ga4_id }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '{{ $ga4_id }}', {
            'send_page_view': true,
            'anonymize_ip': true,
        });
    </script>
    @endif

    {{-- Google Tag Manager (from settings if configured) --}}
    @if(!empty($gtm_id))
    <script>
        (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','{{ $gtm_id }}');
    </script>
    @endif

    @vite(['resources/css/app.css', 'resources/js/main.js'])
</head>
<body>
    {{-- Google Tag Manager (noscript) --}}
    @if(!empty($gtm_id))
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{ $gtm_id }}"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    @endif

    <div id="app"></div>
</body>
</html>
