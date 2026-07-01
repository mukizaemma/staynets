<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $urls = [
            ['loc' => route('home'), 'priority' => '1.0'],
            ['loc' => route('showCars'), 'priority' => '0.9'],
            ['loc' => route('carLanding.airport'), 'priority' => '0.9'],
            ['loc' => route('carLanding.4x4'), 'priority' => '0.9'],
            ['loc' => route('carLanding.selfdrive'), 'priority' => '0.9'],
            ['loc' => route('about'), 'priority' => '0.6'],
            ['loc' => route('connect'), 'priority' => '0.6'],
        ];

        $cars = Car::where('status', 'available')->whereNotNull('slug')->get(['slug', 'updated_at']);
        foreach ($cars as $car) {
            $urls[] = [
                'loc' => route('carDetails', $car->slug),
                'lastmod' => optional($car->updated_at)->toAtomString(),
                'priority' => '0.8',
            ];
        }

        $xml = view('frontend.sitemap', compact('urls'))->render();

        return response($xml, 200)->header('Content-Type', 'application/xml');
    }
}
