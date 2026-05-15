<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8" />
    <link rel="icon" type="image/svg+xml" href="/vite.svg" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    {{-- ========== SEO META TAGS (Server-Rendered) ========== --}}
    <title>{{ $seo['title'] }}</title>
    <meta name="description" content="{{ $seo['description'] }}" />

    {{-- Open Graph --}}
    <meta property="og:title" content="{{ $seo['og_title'] }}" />
    <meta property="og:description" content="{{ $seo['og_description'] }}" />
    <meta property="og:image" content="{{ $seo['og_image'] }}" />
    <meta property="og:url" content="{{ $seo['canonical'] }}" />
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="{{ config('seo.site_name') }}" />
    <meta property="og:locale" content="en_US" />

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image" />
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

    @vite(['resources/css/app.css', 'resources/js/main.js'])
</head>
<body>
    <div id="app"></div>
</body>
</html>
