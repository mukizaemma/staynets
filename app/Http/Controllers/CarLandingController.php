<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CarLandingController extends Controller
{
    public static function pages(): array
    {
        return [
            'kigali-airport-car-rental' => [
                'title' => 'Kigali Airport Car Rental | KGL Pickup & Drop-off',
                'meta_description' => 'Book airport car rental in Kigali (KGL). Meet-and-greet pickup, self-drive, and chauffeur options with clear RWF daily rates.',
                'heading' => 'Kigali Airport Car Rental',
                'subheading' => 'Pickup and drop-off at Kigali International Airport (KGL)',
                'intro' => 'Arriving at KGL? Reserve your vehicle in advance for a smooth pickup at the airport. We offer sedans, SUVs, and 4x4 options for business trips, safaris, and city travel.',
                'search_terms' => ['airport', 'KGL', 'pickup', 'sedan', 'SUV'],
            ],
            '4x4-rental-rwanda' => [
                'title' => '4x4 Rental Rwanda | Safari & Off-Road Vehicles',
                'meta_description' => 'Rent a 4x4 in Rwanda for Akagera, Nyungwe, Volcanoes National Park, and upcountry travel. Land Cruiser, Prado, and SUV options.',
                'heading' => '4x4 Rental in Rwanda',
                'subheading' => 'Safari-ready SUVs and off-road vehicles',
                'intro' => 'Explore Rwanda with a reliable 4x4. Ideal for national parks, lake trips, and rural roads. Compare daily rates and book online.',
                'search_terms' => ['4x4', '4x4', 'cruiser', 'Prado', 'TXL', 'SUV', 'safari'],
            ],
            'self-drive-kigali' => [
                'title' => 'Self Drive Kigali | Daily Car Hire in Rwanda',
                'meta_description' => 'Self-drive car hire in Kigali with transparent RWF pricing. Flexible daily and monthly rentals for residents and visitors.',
                'heading' => 'Self Drive in Kigali',
                'subheading' => 'Flexible daily and monthly self-drive rentals',
                'intro' => 'Drive Kigali and beyond on your schedule. Choose from economy, SUV, and premium vehicles with clear pricing in Rwandan Francs.',
                'search_terms' => ['self', 'drive', 'hire', 'rental', 'daily'],
            ],
        ];
    }

    public function show(Request $request, string $slug): View
    {
        $pages = self::pages();
        abort_unless(isset($pages[$slug]), 404);

        $page = $pages[$slug];

        $query = Car::query()
            ->where('status', 'available')
            ->select([
                'id', 'name', 'slug', 'model', 'image', 'price_per_day', 'price_per_month',
                'price_to_buy', 'currency', 'fuel_type', 'transmission', 'seats', 'description', 'created_at',
            ]);

        $terms = $page['search_terms'] ?? [];
        if (! empty($terms)) {
            $query->where(function ($qb) use ($terms) {
                foreach ($terms as $term) {
                    $qb->orWhere('name', 'like', "%{$term}%")
                        ->orWhere('model', 'like', "%{$term}%")
                        ->orWhere('description', 'like', "%{$term}%")
                        ->orWhere('fuel_type', 'like', "%{$term}%");
                }
            });
        }

        $cars = $query->latest()->paginate(12)->appends($request->query());

        if ($cars->isEmpty()) {
            $cars = Car::query()
                ->where('status', 'available')
                ->select([
                    'id', 'name', 'slug', 'model', 'image', 'price_per_day', 'price_per_month',
                    'price_to_buy', 'currency', 'fuel_type', 'transmission', 'seats', 'description', 'created_at',
                ])
                ->latest()
                ->paginate(12)
                ->appends($request->query());
        }

        $canonical = match ($slug) {
            'kigali-airport-car-rental' => route('carLanding.airport'),
            '4x4-rental-rwanda' => route('carLanding.4x4'),
            'self-drive-kigali' => route('carLanding.selfdrive'),
            default => url('/' . $slug),
        };

        return view('frontend.car-landing', compact('page', 'cars', 'slug', 'canonical'));
    }
}
