<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FacilityCategory;
use Illuminate\Support\Str;

class FacilityCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Basic Amenities', 'icon' => 'fa-home', 'description' => 'Essential facilities and services'],
            ['name' => 'Room Features', 'icon' => 'fa-bed', 'description' => 'In-room amenities and features'],
            ['name' => 'Bathroom', 'icon' => 'fa-bath', 'description' => 'Bathroom facilities and features'],
            ['name' => 'Kitchen', 'icon' => 'fa-utensils', 'description' => 'Kitchen facilities and equipment'],
            ['name' => 'Entertainment', 'icon' => 'fa-tv', 'description' => 'Entertainment and media options'],
            ['name' => 'Internet & Technology', 'icon' => 'fa-wifi', 'description' => 'Internet and tech amenities'],
            ['name' => 'Safety & Security', 'icon' => 'fa-lock', 'description' => 'Safety and security features'],
            ['name' => 'Accessibility', 'icon' => 'fa-wheelchair', 'description' => 'Accessibility features'],
            ['name' => 'Outdoor & Views', 'icon' => 'fa-mountain', 'description' => 'Outdoor spaces and views'],
            ['name' => 'Services', 'icon' => 'fa-concierge-bell', 'description' => 'Property services'],
        ];

        foreach ($categories as $category) {
            FacilityCategory::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'icon' => $category['icon'],
                'description' => $category['description'],
                'sort_order' => array_search($category, $categories),
                'is_active' => true,
            ]);
        }
    }
}







