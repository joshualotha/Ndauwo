<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default SEO Values
    |--------------------------------------------------------------------------
    */
    'default_title' => "Ndauwo, Tanzania's Luxury Safari Experience",
    'default_description' => 'Discover bespoke Tanzania safaris with Ndauwo. Expert-guided luxury expeditions to Serengeti, Ngorongoro, Kilimanjaro & Zanzibar since 2010.',
    'default_og_image' => '/ndauwologo.png',
    'site_name' => 'Ndauwo Safari Co.',
    'twitter_handle' => '@ndauwo',

    /*
    |--------------------------------------------------------------------------
    | Route-to-SEO Meta Mapping
    |--------------------------------------------------------------------------
    | Patterns are matched in order. First match wins.
    | Supports {package}, {destination}, {post} placeholders for dynamic routes.
    */
    'routes' => [
        '/' => [
            'title' => 'Ndauwo — Tanzania\'s Premier Luxury Safari Experience',
            'description' => 'Discover bespoke Tanzania safaris with Ndauwo. Expert-guided luxury expeditions to Serengeti, Ngorongoro, Kilimanjaro & Zanzibar since 2010.',
        ],
        '/safaris' => [
            'title' => 'Luxury Tanzania Safari Packages & Tours — Ndauwo',
            'description' => 'Browse our curated collection of Tanzania safari packages. Tailor-made luxury expeditions, Kilimanjaro climbs, and Zanzibar beach retreats.',
        ],
        '/safari-types' => [
            'title' => 'Safari Experiences & Styles — Ndauwo',
            'description' => 'Explore Tanzania through our diverse safari experiences: luxury expeditions, cultural tours, mountain hiking, group departures, and Zanzibar retreats.',
        ],
        '/safari-types/mountain-hiking' => [
            'title' => 'Mountain Hiking & Kilimanjaro Climbs — Ndauwo',
            'description' => 'Conquer Africa\'s highest peak with Ndauwo. Expert-guided Kilimanjaro climbs, Mount Meru treks, and Tanzania mountain hiking adventures.',
        ],
        '/safari-types/cultural-tours' => [
            'title' => 'Cultural Tours & Expeditions — Ndauwo',
            'description' => 'Experience authentic Tanzania through cultural expeditions. Visit Maasai villages, Hadzabe bushmen, and explore Tanzania\'s rich heritage with Ndauwo.',
        ],
        '/safari-types/luxury-safari' => [
            'title' => 'Luxury Safari Expeditions — Ndauwo',
            'description' => 'Indulge in Tanzania\'s finest luxury safaris. Private guides, premium lodges, and bespoke itineraries across Serengeti, Ngorongoro, and beyond.',
        ],
        '/safari-types/tailor-made-safari' => [
            'title' => 'Tailor-Made Tanzania Safaris — Ndauwo',
            'description' => 'Design your perfect Tanzania safari. Our experts craft bespoke itineraries tailored to your interests, schedule, and style of travel.',
        ],
        '/safari-types/zanzibar-beach-safari' => [
            'title' => 'Zanzibar Beach Retreats & Safaris — Ndauwo',
            'description' => 'Combine world-class safari with Zanzibar\'s pristine beaches. Luxury beach retreats, spice tours, and Indian Ocean adventures with Ndauwo.',
        ],
        '/safari-types/group-safari' => [
            'title' => 'Group Safari Departures — Ndauwo',
            'description' => 'Join our expertly guided group safari departures. Experience Tanzania\'s wildlife with like-minded adventurers at exceptional value.',
        ],
        '/destinations' => [
            'title' => 'Tanzania Safari Destinations — Ndauwo',
            'description' => 'Explore Tanzania\'s iconic safari destinations: Serengeti, Ngorongoro Crater, Kilimanjaro, Zanzibar, Selous, Ruaha, Tarangire, and more.',
        ],
        '/journal' => [
            'title' => 'Safari Stories & Tanzania Travel Journal — Ndauwo',
            'description' => 'Read expert Tanzania travel guides, safari stories, conservation updates, and insider tips from Ndauwo\'s field team in Arusha.',
        ],
        '/about' => [
            'title' => 'About Ndauwo — Tanzania\'s Luxury Safari Company',
            'description' => 'Ndauwo has been crafting bespoke Tanzania safaris since 2010. Learn about our heritage, conservation commitment, and expert team based in Arusha.',
        ],
        '/contact' => [
            'title' => 'Contact Ndauwo — Plan Your Tanzania Safari',
            'description' => 'Get in touch with Ndauwo\'s safari experts. We\'ll help you plan the perfect Tanzania luxury expedition tailored to your dreams.',
        ],
        '/gallery' => [
            'title' => 'Safari Photo Gallery — Ndauwo',
            'description' => 'Browse stunning photography from Ndauwo\'s Tanzania safaris. Wildlife, landscapes, lodges, and unforgettable moments captured across East Africa.',
        ],
        '/reviews' => [
            'title' => 'Client Reviews & Testimonials — Ndauwo',
            'description' => 'Read what our guests say about their Ndauwo Tanzania safari experiences. Real reviews from discerning travelers worldwide.',
        ],
        '/conservation' => [
            'title' => 'Conservation Commitment — Ndauwo',
            'description' => 'Ndauwo is committed to preserving Tanzania\'s wildlife and empowering local communities. Learn about our conservation initiatives.',
        ],
        '/press' => [
            'title' => 'Press & Media Kit — Ndauwo',
            'description' => 'Download Ndauwo\'s media kit, press releases, high-resolution images, and brand assets for editorial use.',
        ],
        '/careers' => [
            'title' => 'Careers at Ndauwo — Join Our Safari Team',
            'description' => 'Explore career opportunities with Ndauwo Safari Co. Join our team of passionate safari guides, conservationists, and hospitality professionals.',
        ],
        '/planning/accommodation-styles' => [
            'title' => 'Tanzania Safari Accommodation Guide — Ndauwo',
            'description' => 'Compare Tanzania safari accommodation styles: luxury lodges, tented camps, mobile camps, and boutique hotels. Find your perfect safari stay.',
        ],
        '/planning/visa-entry' => [
            'title' => 'Tanzania Visa & Entry Requirements — Ndauwo',
            'description' => 'Complete guide to Tanzania visa requirements, entry regulations, passport validity, and border crossing information for safari travelers.',
        ],
        '/planning/health-safety' => [
            'title' => 'Health & Safety Guide for Tanzania Safaris — Ndauwo',
            'description' => 'Essential health and safety information for Tanzania safari travel: vaccinations, malaria prevention, travel insurance, and emergency protocols.',
        ],
        '/planning/packing-list' => [
            'title' => 'Tanzania Safari Packing List — Ndauwo',
            'description' => 'Comprehensive Tanzania safari packing guide: clothing, gear, photography equipment, and essentials for your East African adventure.',
        ],
        '/planning/cultural-etiquette' => [
            'title' => 'Tanzania Cultural Etiquette Guide — Ndauwo',
            'description' => 'Learn Tanzania cultural etiquette: greetings, dress codes, photography etiquette, tipping customs, and respectful travel practices.',
        ],

        // Missing route configs
        '/booking' => [
            'title' => 'Book Your Tanzania Safari — Ndauwo',
            'description' => 'Ready to book your dream Tanzania safari? Contact Ndauwo\'s expert team to reserve your luxury expedition, Kilimanjaro climb, or Zanzibar retreat.',
        ],
        '/privacy' => [
            'title' => 'Privacy Policy — Ndauwo Safari Co.',
            'description' => 'Ndauwo Safari Co. privacy policy. Learn how we collect, use, and protect your personal information when you book a Tanzania safari with us.',
        ],
        '/terms' => [
            'title' => 'Terms & Conditions — Ndauwo Safari Co.',
            'description' => 'Ndauwo Safari Co. terms and conditions for Tanzania safari bookings, payments, cancellations, and traveler responsibilities.',
        ],
    ],
];
