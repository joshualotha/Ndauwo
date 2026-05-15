<?php

namespace Database\Seeders;

use App\Models\GalleryItem;
use Illuminate\Database\Seeder;

class GallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            [
                'title' => 'Serengeti Sunrise',
                'type' => 'image',
                'category' => 'Landscapes',
                'file_path' => 'gallery/sunrise.jpg', // Placeholder logically, ideally we'd copy real files
                'description' => 'A breathtaking sunrise over the Serengeti plains.',
                'active' => true,
            ],
            [
                'title' => 'The Great Migration',
                'type' => 'image',
                'category' => 'Wildlife',
                'file_path' => 'gallery/migration.jpg',
                'description' => 'Thousands of wildebeest crossing the Mara River.',
                'active' => true,
            ],
            [
                'title' => 'Luxury Tented Camp',
                'type' => 'image',
                'category' => 'Accommodation',
                'file_path' => 'gallery/camp.jpg',
                'description' => 'Experience the wild in absolute comfort.',
                'active' => true,
            ],
            [
                'title' => 'Maasai Warrior Dance',
                'type' => 'image',
                'category' => 'Culture',
                'file_path' => 'gallery/culture.jpg',
                'description' => 'Traditional Maasai ceremonies and cultural heritage.',
                'active' => true,
            ],
            [
                'title' => 'Expedition Documentary',
                'type' => 'video',
                'category' => 'Expeditions',
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', // Placeholder video
                'description' => 'A deep dive into our conservation efforts and safari operations.',
                'active' => true,
            ],
        ];

        foreach ($items as $item) {
            GalleryItem::create($item);
        }
    }
}
