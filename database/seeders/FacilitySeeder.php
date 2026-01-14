<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Amenity;
use App\Models\FacilityCategory;
use Illuminate\Support\Str;

class FacilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $basicCategory = FacilityCategory::where('slug', 'basic-amenities')->first();
        $roomCategory = FacilityCategory::where('slug', 'room-features')->first();
        $bathroomCategory = FacilityCategory::where('slug', 'bathroom')->first();
        $kitchenCategory = FacilityCategory::where('slug', 'kitchen')->first();
        $entertainmentCategory = FacilityCategory::where('slug', 'entertainment')->first();
        $internetCategory = FacilityCategory::where('slug', 'internet-technology')->first();
        $safetyCategory = FacilityCategory::where('slug', 'safety-security')->first();
        $accessibilityCategory = FacilityCategory::where('slug', 'accessibility')->first();
        $outdoorCategory = FacilityCategory::where('slug', 'outdoor-views')->first();
        $servicesCategory = FacilityCategory::where('slug', 'services')->first();

        $facilities = [
            // Basic Amenities
            ['title' => 'Air Conditioning', 'icon' => 'fa-snowflake', 'category' => $basicCategory],
            ['title' => 'Heating', 'icon' => 'fa-fire', 'category' => $basicCategory],
            ['title' => 'Parking', 'icon' => 'fa-parking', 'category' => $basicCategory],
            ['title' => 'Elevator', 'icon' => 'fa-arrow-up', 'category' => $basicCategory],
            
            // Room Features
            ['title' => 'King Size Bed', 'icon' => 'fa-bed', 'category' => $roomCategory],
            ['title' => 'Queen Size Bed', 'icon' => 'fa-bed', 'category' => $roomCategory],
            ['title' => 'Desk', 'icon' => 'fa-desk', 'category' => $roomCategory],
            ['title' => 'Balcony', 'icon' => 'fa-door-open', 'category' => $roomCategory],
            ['title' => 'Sofa', 'icon' => 'fa-couch', 'category' => $roomCategory],
            ['title' => 'Wardrobe', 'icon' => 'fa-tshirt', 'category' => $roomCategory],
            
            // Bathroom
            ['title' => 'Private Bathroom', 'icon' => 'fa-bath', 'category' => $bathroomCategory],
            ['title' => 'Bathtub', 'icon' => 'fa-bath', 'category' => $bathroomCategory],
            ['title' => 'Shower', 'icon' => 'fa-shower', 'category' => $bathroomCategory],
            ['title' => 'Hair Dryer', 'icon' => 'fa-wind', 'category' => $bathroomCategory],
            ['title' => 'Towels', 'icon' => 'fa-tshirt', 'category' => $bathroomCategory],
            
            // Kitchen
            ['title' => 'Fully Equipped Kitchen', 'icon' => 'fa-utensils', 'category' => $kitchenCategory],
            ['title' => 'Refrigerator', 'icon' => 'fa-snowflake', 'category' => $kitchenCategory],
            ['title' => 'Microwave', 'icon' => 'fa-microchip', 'category' => $kitchenCategory],
            ['title' => 'Coffee Maker', 'icon' => 'fa-coffee', 'category' => $kitchenCategory],
            ['title' => 'Dining Area', 'icon' => 'fa-utensils', 'category' => $kitchenCategory],
            
            // Entertainment
            ['title' => 'TV', 'icon' => 'fa-tv', 'category' => $entertainmentCategory],
            ['title' => 'Cable TV', 'icon' => 'fa-satellite-dish', 'category' => $entertainmentCategory],
            ['title' => 'Streaming Services', 'icon' => 'fa-play', 'category' => $entertainmentCategory],
            
            // Internet & Technology
            ['title' => 'Free WiFi', 'icon' => 'fa-wifi', 'category' => $internetCategory],
            ['title' => 'High Speed Internet', 'icon' => 'fa-wifi', 'category' => $internetCategory],
            ['title' => 'USB Charging Ports', 'icon' => 'fa-plug', 'category' => $internetCategory],
            
            // Safety & Security
            ['title' => 'Safe', 'icon' => 'fa-lock', 'category' => $safetyCategory],
            ['title' => 'Smoke Detector', 'icon' => 'fa-exclamation-triangle', 'category' => $safetyCategory],
            ['title' => 'Fire Extinguisher', 'icon' => 'fa-fire-extinguisher', 'category' => $safetyCategory],
            ['title' => 'Security System', 'icon' => 'fa-shield-alt', 'category' => $safetyCategory],
            
            // Accessibility
            ['title' => 'Wheelchair Accessible', 'icon' => 'fa-wheelchair', 'category' => $accessibilityCategory],
            ['title' => 'Accessible Bathroom', 'icon' => 'fa-bath', 'category' => $accessibilityCategory],
            
            // Outdoor & Views
            ['title' => 'Garden View', 'icon' => 'fa-tree', 'category' => $outdoorCategory],
            ['title' => 'City View', 'icon' => 'fa-city', 'category' => $outdoorCategory],
            ['title' => 'Ocean View', 'icon' => 'fa-water', 'category' => $outdoorCategory],
            ['title' => 'Mountain View', 'icon' => 'fa-mountain', 'category' => $outdoorCategory],
            
            // Services
            ['title' => 'Room Service', 'icon' => 'fa-concierge-bell', 'category' => $servicesCategory],
            ['title' => 'Housekeeping', 'icon' => 'fa-broom', 'category' => $servicesCategory],
            ['title' => 'Laundry Service', 'icon' => 'fa-tshirt', 'category' => $servicesCategory],
            ['title' => '24/7 Front Desk', 'icon' => 'fa-clock', 'category' => $servicesCategory],
        ];

        foreach ($facilities as $index => $facility) {
            Amenity::create([
                'title' => $facility['title'],
                'slug' => Str::slug($facility['title']),
                'icon' => $facility['icon'],
                'facility_category_id' => $facility['category']->id ?? null,
                'description' => null,
                'sort_order' => $index,
                'is_active' => true,
            ]);
        }
    }
}




