<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    public function run(): void
    {
        $packages = [
            [
                'title' => 'The Great Migration Safari',
                'slug' => 'the-great-migration-safari',
                'description' => 'Follow the thundering hooves of two million wildebeest and zebra as they traverse the endless plains of the Serengeti.',
                'duration_days' => 7,
                'price' => 3200.00,
                'type' => 'Signature Route',
                'difficulty' => 'Moderate',
                'best_time_to_visit' => 'July - Oct',
                'featured' => true,
                'active' => true,
                'image' => '/image-07.jpg',
                'gallery' => ['/image-11.jpg', '/image-10.jpg', '/image-16.jpg'],
                'highlights' => [
                    'The world-famous Great Migration',
                    'Wildebeest River Crossings',
                    'Apex Predator sightings',
                    'Sunrise Balloon Safari over the Serengeti',
                    'Ngorongoro Crater descent to find Black Rhino'
                ],
                'inclusions' => [
                    'All internal bush flights',
                    'Luxury wilderness accommodation',
                    'Gourmet meals & selected wines',
                    'Private 4x4 Land Cruiser',
                    'Expert naturalist guide',
                    'All park and conservation fees'
                ],
                'exclusions' => [
                    'International flights',
                    'Travel insurance',
                    'Premium imported champagnes',
                    'Guide gratuities'
                ],
                'daily_itinerary' => [
                    ['day' => 'Day 01', 'title' => 'Arrival in Arusha', 'content' => 'Touch down at Kilimanjaro International Airport. You will be whisked away to a boutique coffee lodge on the slopes of Mount Meru to recover from your flight in secluded luxury.', 'accommodation' => 'Arusha Coffee Lodge'],
                    ['day' => 'Day 02', 'title' => 'Descent into the Crater', 'content' => 'Transfer to the Ngorongoro Conservation Area. Descend 600 meters into the world\'s largest intact caldera for a spectacular afternoon game drive searching for the endangered black rhino.', 'accommodation' => 'Ngorongoro Crater Lodge'],
                    ['day' => 'Day 03-05', 'title' => 'Heart of the Serengeti', 'content' => 'Fly deep into the Serengeti. Spend three days tracking the migration herds, witnessing thrilling river crossings and experiencing sunrise hot air balloon safaris over the plains.', 'accommodation' => 'Singita Sasakwa'],
                    ['day' => 'Day 06', 'title' => 'Departure', 'content' => 'Enjoy a final sunrise game drive before boarding your bush flight back to Arusha for your onward connections.', 'accommodation' => null]
                ],
                'feature_icons' => ['Clock', 'MapPin', 'Activity']
            ],
            [
                'title' => 'Kilimanjaro Summit Climb',
                'slug' => 'kilimanjaro-summit-climb',
                'description' => 'The ultimate challenge: reaching Uhuru Peak, the roof of Africa, via the scenic Machame Route.',
                'duration_days' => 7,
                'price' => 2450.00,
                'type' => 'Mountain Trek',
                'difficulty' => 'Hard',
                'best_time_to_visit' => 'Jul-Oct, Jan-Feb',
                'featured' => false,
                'active' => true,
                'image' => '/image-14.jpg',
                'highlights' => [
                    'Scenic Machame Route ascent',
                    'Experience 5 distinct climate zones',
                    'Spectacular sunrise from Uhuru Peak',
                    'Professional guides and ethical porterage',
                    'Acclimatization focused itinerary'
                ],
                'inclusions' => [
                    'All climb permits and park fees',
                    'Tented accommodation on the mountain',
                    'All meals and refreshments during trek',
                    'Professional mountain guide team',
                    'Emergency medical evacuation coverage'
                ],
                'exclusions' => [
                    'Climbing gear (rentals available)',
                    'Guide/Porter gratuities',
                    'International flights',
                    'Pre/Post trek hotel nights'
                ],
                'daily_itinerary' => [
                    ['day' => 'Overview', 'title' => 'Machame Route Strategy', 'content' => 'Our 7-day Machame route itinerary is designed for maximum acclimatization. Starting through the rainforest, we traverse the stunning Shira Plateau and the Barranco Wall before the final push to the summit.', 'accommodation' => 'Alpine Tents']
                ],
                'feature_icons' => ['Clock', 'Mountain', 'Activity']
            ],
            [
                'title' => 'Zanzibar Beach Escape',
                'slug' => 'zanzibar-beach-escape',
                'description' => 'The perfect end to any safari: a place to decompress, drift, and encounter an entirely different dimension of Tanzania.',
                'duration_days' => 5,
                'price' => 1850.00,
                'type' => 'Beach Safari',
                'difficulty' => 'Easy',
                'best_time_to_visit' => 'Jun-Oct, Dec-Feb',
                'featured' => false,
                'active' => true,
                'image' => '/image-05.jpg',
                'highlights' => [
                    'Luxury beachfront boutique resort',
                    'Sunset Dhow cruise with drinks',
                    'Stone Town historical walking tour',
                    'Spice farm guided sensory experience',
                    'Private white sand beach access'
                ],
                'inclusions' => [
                    'Boutique beachfront accommodation',
                    'All internal transfers including boat',
                    'Half-board dining (Breakfast & Dinner)',
                    'Selected private cultural excursions'
                ],
                'daily_itinerary' => [
                    ['day' => 'Leisure', 'title' => 'Tropical Rhythm', 'content' => 'Enjoy 5 days of absolute leisure on the spice island. From historical walks in the UNESCO Stone Town to sunset sailing on a traditional wooden dhow, we curate every detail of your coastal retreat.', 'accommodation' => 'Zuri Zanzibar']
                ],
                'feature_icons' => ['Clock', 'Waves', 'Palmtree']
            ],
            [
                'title' => 'Cultural Heritage Tour',
                'slug' => 'cultural-heritage-tour',
                'description' => 'Go beyond the wildlife. Meet the people who have shaped this land for thousands of years in authentic, respectful dialogue.',
                'duration_days' => 6,
                'price' => 2100.00,
                'type' => 'Cultural Tour',
                'difficulty' => 'Moderate',
                'best_time_to_visit' => 'Year-Round',
                'featured' => false,
                'active' => true,
                'image' => '/image-15.jpg',
                'highlights' => [
                    'Authentic Maasai Boma immersion',
                    'Morning hunt with the Hadzabe tribe',
                    'Traditional click-language lesson',
                    'Swahili cooking class in a family home',
                    'Local community support initiatives'
                ],
                'daily_itinerary' => [
                    ['day' => 'Immersion', 'title' => 'Living History', 'content' => 'This 6-day journey places you in direct dialogue with Tanzanian communities. These are not staged performances, but genuine encounters based on long-standing relationships with tribal elders.', 'accommodation' => 'Heritage Lodges']
                ],
                'feature_icons' => ['Clock', 'Users', 'Heart']
            ],
            [
                'title' => 'Luxury Wildlife Safari',
                'slug' => 'luxury-wildlife-safari',
                'description' => 'Uncompromising comfort in the wild. Fly between remote parks and stay in the continent\'s most exclusive tented camps.',
                'duration_days' => 9,
                'price' => 8400.00,
                'type' => 'Luxury Fly-In',
                'difficulty' => 'Easy',
                'best_time_to_visit' => 'June - October',
                'featured' => true,
                'active' => true,
                'image' => '/image-09.jpg',
                'highlights' => [
                    'All bush flights (Fly-In Convenience)',
                    'Exclusive private game concession access',
                    'Dedicated butler service in camps',
                    'Bush breakfasts and starlit dinners',
                    'Luxury lodges with private plunge pools'
                ],
                'daily_itinerary' => [
                    ['day' => 'Curated', 'title' => 'Bush Elegance', 'content' => 'A luxury safari isn\'t just about premium accommodation, it\'s about seamless service and exclusive access. Arrive by light aircraft at remote airstrips where the wildlife is right on your doorstep.', 'accommodation' => 'Singita Mara River Tented Camp']
                ],
                'feature_icons' => ['Clock', 'Plane', 'Star']
            ],
            [
                'title' => 'Family Bush & Beach',
                'slug' => 'family-bush-and-beach',
                'description' => 'The ultimate family adventure: combining game drives in the Serengeti with the white sands of Zanzibar, scaled for young explorers.',
                'duration_days' => 10,
                'price' => 4600.00,
                'type' => 'Family Special',
                'difficulty' => 'Easy',
                'best_time_to_visit' => 'June - October',
                'featured' => false,
                'active' => true,
                'image' => '/image-06.jpg',
                'highlights' => [
                    'Family-sized private safari vehicles',
                    'Guided nature walks for children',
                    'Combined wildlife and beach discovery',
                    'Child-friendly luxury accommodations',
                    'Interactive tracking and bush skills'
                ],
                'daily_itinerary' => [
                    ['day' => 'Adventure', 'title' => 'Double Discovery', 'content' => 'Split your time between the northern safari grounds and the Indian Ocean. Every activity is scaled to young explorers, ensuring a pace that creates lifelong family memories without the fatigue.', 'accommodation' => 'Nomad Serengeti & Zawadi Hotel']
                ],
                'feature_icons' => ['Clock', 'Smile', 'Sun']
            ]
        ];

        foreach ($packages as $data) {
            Package::updateOrCreate(
                ['slug' => $data['slug']],
                $data
            );
        }
    }
}
