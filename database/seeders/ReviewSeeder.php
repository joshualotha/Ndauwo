<?php

namespace Database\Seeders;

use App\Models\Review;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $reviews = [
            [
                'name' => 'The Harrison Family',
                'rating' => 5,
                'content' => '"We have traveled to Africa five times, but the level of access Ndauwo provided in the Serengeti was unprecedented. Our guide, Samwel, read the bush like a book. We spent three days completely alone with a pride of 14 lions, far from any other vehicles."',
                'safari_type' => '10-Day Migration Expedition',
                'source' => 'Website',
                'active' => true,
                'featured' => true,
            ],
            [
                'name' => 'M. & E. Chen',
                'rating' => 5,
                'content' => '"The logistics were flawless. To have a mobile camp of such extreme luxury deployed precisely where the herds were crossing the Mara River felt like magic. The culinary team somehow produced Michelin-level dinners over an open fire in the middle of nowhere."',
                'safari_type' => '7-Day Northern Circuit',
                'source' => 'Website',
                'active' => true,
                'featured' => true,
            ],
            [
                'name' => 'Dr. J. Arlington',
                'rating' => 5,
                'content' => '"What struck me most was their commitment to truly isolated experiences. We didn\'t feel like tourists; we felt like explorers with a front-row seat to the rawest corners of the earth. The silence at night, broken only by the roar of a distant leopard, was life-changing."',
                'safari_type' => 'Private Photographic Safari',
                'source' => 'Website',
                'active' => true,
                'featured' => true,
            ],
            [
                'name' => 'Sarah V.',
                'rating' => 5,
                'content' => '"As an avid photographer, patience and positioning are everything. Our guide understood the light and the angles perfectly. We never felt rushed. This wasn\'t a checklist safari; it was a deeply immersive masterclass in East African ecology."',
                'safari_type' => 'Ngorongoro & Tarangire Focus',
                'source' => 'Website',
                'active' => true,
                'featured' => true,
            ],
        ];

        foreach ($reviews as $review) {
            Review::create($review);
        }
    }
}
