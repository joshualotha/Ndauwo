<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PageImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $images = [
            // --- HOME VIEW ---
            ['page' => 'home', 'section' => 'hero_bg', 'image_path' => 'https://images.unsplash.com/photo-1546182990-dffeafbe841d?w=1920&q=80', 'description' => 'Home Hero Background (Lions)'],
            ['page' => 'home', 'section' => 'hero_overlay', 'image_path' => '/image-06.jpg', 'description' => 'Cheetah Hero Overlay'],
            ['page' => 'home', 'section' => 'about_primary', 'image_path' => '/image-01.jpg', 'description' => 'About Section Primary Image'],
            ['page' => 'home', 'section' => 'about_secondary', 'image_path' => '/image-09.jpg', 'description' => 'About Section Secondary Image (Zebra)'],
            ['page' => 'home', 'section' => 'promo_card_1', 'image_path' => '/image-03.jpg', 'description' => 'Promo Card 1 (Sunrise)'],
            ['page' => 'home', 'section' => 'promo_card_2', 'image_path' => '/image-18.jpg', 'description' => 'Promo Card 2 (Zanzibar)'],
            ['page' => 'home', 'section' => 'promo_card_3', 'image_path' => '/image-19.jpg', 'description' => 'Promo Card 3 (Maasai)'],
            
            // --- ABOUT VIEW ---
            ['page' => 'about', 'section' => 'hero_bg', 'image_path' => 'https://images.unsplash.com/photo-1516426122078-c23e76319801?w=1920&q=80', 'description' => 'About Hero Background'],
            ['page' => 'about', 'section' => 'vision_image', 'image_path' => 'https://images.unsplash.com/photo-1547471080-7cc2caa01a7e?w=800&q=80', 'description' => 'Vision Section Image'],
            ['page' => 'about', 'section' => 'founder_portrait', 'image_path' => '/image-13.jpg', 'description' => 'Founder Portrait'],
            
            // --- CONTACT VIEW ---
            ['page' => 'contact', 'section' => 'hero_bg', 'image_path' => 'https://images.unsplash.com/photo-1523805009345-7448845a9e53?w=1920&q=80', 'description' => 'Contact Hero Background'],
            ['page' => 'contact', 'section' => 'office_image', 'image_path' => 'https://images.unsplash.com/photo-1498307833015-e7b400441eb8?w=800&q=80', 'description' => 'Arusha Office Image'],
            
            // --- SAFARIS VIEW ---
            ['page' => 'safaris', 'section' => 'hero_bg', 'image_path' => 'https://images.unsplash.com/photo-1516426122078-c23e76319801?w=1920&q=80', 'description' => 'Safaris Hero Background'],
            
            // --- DESTINATIONS VIEW ---
            ['page' => 'destinations', 'section' => 'hero_bg', 'image_path' => 'https://images.unsplash.com/photo-1547471080-7cc2caa01a7e?w=1920&q=80', 'description' => 'Destinations Hero Background'],
            
            // --- REVIEWS VIEW ---
            ['page' => 'reviews', 'section' => 'hero_bg', 'image_path' => 'https://images.unsplash.com/photo-1547471080-7cc2caa01a7e?w=1920&q=80', 'description' => 'Reviews Hero Background'],
            
            // --- GALLERY VIEW ---
            ['page' => 'gallery', 'section' => 'hero_bg', 'image_path' => 'https://images.unsplash.com/photo-1516426122078-c23e76319801?w=1920&q=80', 'description' => 'Gallery Hero Background'],
            
            // --- CONSERVATION VIEW ---
            ['page' => 'conservation', 'section' => 'hero_bg', 'image_path' => 'https://images.unsplash.com/photo-1516426122078-c23e76319801?w=1920&q=80', 'description' => 'Conservation Hero Background'],
            ['page' => 'conservation', 'section' => 'initiative_1', 'image_path' => '/image-04.jpg', 'description' => 'Anti-Poaching Vanguard'],
            ['page' => 'conservation', 'section' => 'initiative_2', 'image_path' => '/image-08.jpg', 'description' => 'Maasai Scholarship'],
            ['page' => 'conservation', 'section' => 'initiative_3', 'image_path' => '/image-10.jpg', 'description' => 'Zero-Trace Camp'],
            
            // --- MEDIA KIT VIEW ---
            ['page' => 'media_kit', 'section' => 'hero_bg', 'image_path' => 'https://images.unsplash.com/photo-1504432842672-1a79f78e4084?w=1920&q=80', 'description' => 'Media Kit Hero Background'],
            ['page' => 'media_kit', 'section' => 'card_1', 'image_path' => '/image-06.jpg', 'description' => 'Media Kit Card 1'],
            ['page' => 'media_kit', 'section' => 'card_2', 'image_path' => '/image-03.jpg', 'description' => 'Media Kit Card 2'],
            ['page' => 'media_kit', 'section' => 'card_3', 'image_path' => 'https://images.unsplash.com/photo-1547471080-7cc2caa01a7e?w=800&q=80', 'description' => 'Media Kit Card 3'],

            // --- BLOG (JOURNAL) VIEW ---
            ['page' => 'blog', 'section' => 'hero_bg', 'image_path' => 'https://images.unsplash.com/photo-1498307833015-e7b400441eb8?w=1920&q=80', 'description' => 'Journal Hero Background'],

            // --- CAREERS VIEW ---
            ['page' => 'careers', 'section' => 'hero_bg', 'image_path' => 'https://images.unsplash.com/photo-1523805009345-7448845a9e53?w=1920&q=80', 'description' => 'Careers Hero Background'],
            ['page' => 'careers', 'section' => 'culture_image', 'image_path' => '/image-19.jpg', 'description' => 'Company Culture Image'],

            // --- SAFARI TYPES VIEWS ---
            ['page' => 'mountain_hiking', 'section' => 'hero_bg', 'image_path' => '/image-02.jpg', 'description' => 'Hero Background'],
            ['page' => 'mountain_hiking', 'section' => 'photo_break_1', 'image_path' => '/image-14.jpg', 'description' => 'First Photo Break'],
            ['page' => 'mountain_hiking', 'section' => 'photo_break_2', 'image_path' => '/image-04.jpg', 'description' => 'Second Photo Break'],
            ['page' => 'mountain_hiking', 'section' => 'cta_bg', 'image_path' => '/image-05.jpg', 'description' => 'Call to Action Background'],

            ['page' => 'cultural_tours', 'section' => 'hero_bg', 'image_path' => '/image-20.jpg', 'description' => 'Hero Background'],
            ['page' => 'cultural_tours', 'section' => 'split_photo_1', 'image_path' => '/image-19.jpg', 'description' => 'Split Feature Photo 1'],
            ['page' => 'cultural_tours', 'section' => 'split_photo_2', 'image_path' => '/image-11.jpg', 'description' => 'Split Feature Photo 2'],
            ['page' => 'cultural_tours', 'section' => 'quote_photo', 'image_path' => '/image-05.jpg', 'description' => 'Quote Section Background'],
            ['page' => 'cultural_tours', 'section' => 'photo_break', 'image_path' => '/image-04.jpg', 'description' => 'Photo Break Collage'],
            ['page' => 'cultural_tours', 'section' => 'cta_bg', 'image_path' => '/image-12.jpg', 'description' => 'Call to Action Background'],

            ['page' => 'group_safari', 'section' => 'hero_bg', 'image_path' => '/image-16.jpg', 'description' => 'Hero Background'],
            ['page' => 'group_safari', 'section' => 'photo_break', 'image_path' => '/image-03.jpg', 'description' => 'Center Photo Break'],
            ['page' => 'group_safari', 'section' => 'group_photo', 'image_path' => '/image-08.jpg', 'description' => 'Shared Experience Photo'],
            ['page' => 'group_safari', 'section' => 'cta_bg', 'image_path' => '/image-17.jpg', 'description' => 'Call to Action Background'],

            ['page' => 'luxury_safari', 'section' => 'hero_bg', 'image_path' => '/image-14.jpg', 'description' => 'Hero Background'],
            ['page' => 'luxury_safari', 'section' => 'photo_break_1', 'image_path' => '/image-15.jpg', 'description' => 'First Photo Break'],
            ['page' => 'luxury_safari', 'section' => 'photo_break_2', 'image_path' => '/image-13.jpg', 'description' => 'Second Photo Break'],
            ['page' => 'luxury_safari', 'section' => 'cta_bg', 'image_path' => '/image-12.jpg', 'description' => 'Call to Action Background'],

            ['page' => 'tailor_made_safari', 'section' => 'hero_bg', 'image_path' => '/image-01.jpg', 'description' => 'Hero Background'],
            ['page' => 'tailor_made_safari', 'section' => 'photo_break_1', 'image_path' => '/image-17.jpg', 'description' => 'First Photo Break'],
            ['page' => 'tailor_made_safari', 'section' => 'photo_break_2', 'image_path' => '/image-19.jpg', 'description' => 'Second Photo Break'],
            ['page' => 'tailor_made_safari', 'section' => 'cta_bg', 'image_path' => '/image-16.jpg', 'description' => 'Call to Action Background'],

            ['page' => 'zanzibar_beach', 'section' => 'hero_bg', 'image_path' => '/image-18.jpg', 'description' => 'Hero Background'],
            ['page' => 'zanzibar_beach', 'section' => 'photo_break', 'image_path' => '/image-08.jpg', 'description' => 'Center Photo Break'],
            ['page' => 'zanzibar_beach', 'section' => 'cta_bg', 'image_path' => '/image-10.jpg', 'description' => 'Call to Action Background'],

            // --- PLANNING VIEWS ---
            ['page' => 'accommodation_styles', 'section' => 'hero_bg', 'image_path' => '/image-10.jpg', 'description' => 'Hero Background'],
            ['page' => 'accommodation_styles', 'section' => 'tented_camps', 'image_path' => 'https://images.unsplash.com/photo-1493246507139-91e8bef99c02?w=1200&q=80', 'description' => 'Tented Camps Photo'],
            ['page' => 'accommodation_styles', 'section' => 'lodge_hero', 'image_path' => 'https://images.unsplash.com/photo-1571896349842-33c89424de2d?w=1200&q=80', 'description' => 'Safari Lodges Background'],
            ['page' => 'accommodation_styles', 'section' => 'fly_camping', 'image_path' => 'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=800&q=80', 'description' => 'Fly Camping Element'],
            ['page' => 'accommodation_styles', 'section' => 'bush_homes', 'image_path' => 'https://images.unsplash.com/photo-1544644181-1484b3fdfc62?w=800&q=80', 'description' => 'Bush Homes Element'],

            ['page' => 'cultural_etiquette', 'section' => 'hero_bg', 'image_path' => '/image-12.jpg', 'description' => 'Hero Background'],
            ['page' => 'cultural_etiquette', 'section' => 'spread_img', 'image_path' => 'https://images.unsplash.com/photo-1489440543286-a69330151c0b?w=1200&q=80', 'description' => 'Editorial Spread Image'],
            ['page' => 'cultural_etiquette', 'section' => 'chapter_img_1', 'image_path' => 'https://images.unsplash.com/photo-1547471080-7cc2caa01a7e?w=1000&q=80', 'description' => 'Chapter I Image'],
            ['page' => 'cultural_etiquette', 'section' => 'cinematic_bg', 'image_path' => 'https://images.unsplash.com/photo-1502476659129-ca01d9f8045a?w=1400&q=80', 'description' => 'Chapter II Background'],
            ['page' => 'cultural_etiquette', 'section' => 'chapter_img_2', 'image_path' => 'https://images.unsplash.com/photo-1516426122078-c23e76319801?w=1000&q=80', 'description' => 'Chapter III Image'],

            ['page' => 'health_safety', 'section' => 'hero_bg', 'image_path' => '/image-05.jpg', 'description' => 'Hero Background'],
            ['page' => 'health_safety', 'section' => 'wildlife_conduct', 'image_path' => '/image-19.jpg', 'description' => 'Wildlife Conduct Background'],
            ['page' => 'health_safety', 'section' => 'split_image_1', 'image_path' => '/image-08.jpg', 'description' => 'Fitness Split Photo'],
            ['page' => 'health_safety', 'section' => 'split_image_2', 'image_path' => '/image-20.jpg', 'description' => 'Food & Water Split Photo'],

            ['page' => 'packing_list', 'section' => 'hero_bg', 'image_path' => '/image-19.jpg', 'description' => 'Hero Background'],
            ['page' => 'packing_list', 'section' => 'spread_img', 'image_path' => 'https://images.unsplash.com/photo-1523906834658-6e24ef2386f9?w=1200&q=80', 'description' => 'Editorial Spread Image'],
            ['page' => 'packing_list', 'section' => 'chapter_img_1', 'image_path' => 'https://images.unsplash.com/photo-1544644181-1484b3fdfc62?w=1000&q=80', 'description' => 'Chapter I Image'],
            ['page' => 'packing_list', 'section' => 'cinematic_bg', 'image_path' => 'https://images.unsplash.com/photo-1516426122078-c23e76319801?w=1400&q=80', 'description' => 'Chapter II Background'],
            ['page' => 'packing_list', 'section' => 'chapter_img_2', 'image_path' => 'https://images.unsplash.com/photo-1530521954074-e64f6810b32d?w=1000&q=80', 'description' => 'Chapter III Image'],

            ['page' => 'visa_entry', 'section' => 'hero_bg', 'image_path' => '/image-08.jpg', 'description' => 'Hero Background'],
        ];

        foreach ($images as $img) {
            DB::table('page_images')->updateOrInsert(
                ['page' => $img['page'], 'section' => $img['section']],
                ['image_path' => $img['image_path'], 'description' => $img['description'], 'created_at' => now(), 'updated_at' => now()]
            );
        }
    }
}
