<?php

namespace App\Services;

use App\Models\Blog;
use App\Models\Car;
use App\Models\Category;
use App\Models\Hotel;
use App\Models\Program;
use App\Models\Property;
use App\Models\Trip;
use App\Models\TripDestination;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;

class SitemapService
{
    /**
     * @return array<int, array{loc: string, lastmod: ?string, changefreq: string, priority: string}>
     */
    public function entries(): array
    {
        $entries = [];

        foreach ($this->staticPages() as $page) {
            $entries[] = $page;
        }

        foreach ($this->propertyEntries() as $entry) {
            $entries[] = $entry;
        }

        foreach ($this->carEntries() as $entry) {
            $entries[] = $entry;
        }

        foreach ($this->tripEntries() as $entry) {
            $entries[] = $entry;
        }

        foreach ($this->tripDestinationEntries() as $entry) {
            $entries[] = $entry;
        }

        foreach ($this->destinationEntries() as $entry) {
            $entries[] = $entry;
        }

        foreach ($this->serviceEntries() as $entry) {
            $entries[] = $entry;
        }

        foreach ($this->blogEntries() as $entry) {
            $entries[] = $entry;
        }

        foreach ($this->legacyHotelEntries() as $entry) {
            $entries[] = $entry;
        }

        return $this->deduplicate($entries);
    }

    public function toXml(array $entries): string
    {
        $lines = [
            '<?xml version="1.0" encoding="UTF-8"?>',
            '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">',
        ];

        foreach ($entries as $entry) {
            $lines[] = '  <url>';
            $lines[] = '    <loc>' . htmlspecialchars($entry['loc'], ENT_XML1 | ENT_QUOTES, 'UTF-8') . '</loc>';

            if (!empty($entry['lastmod'])) {
                $lines[] = '    <lastmod>' . $entry['lastmod'] . '</lastmod>';
            }

            $lines[] = '    <changefreq>' . $entry['changefreq'] . '</changefreq>';
            $lines[] = '    <priority>' . $entry['priority'] . '</priority>';
            $lines[] = '  </url>';
        }

        $lines[] = '</urlset>';

        return implode("\n", $lines) . "\n";
    }

    /**
     * @return array<int, array{loc: string, lastmod: ?string, changefreq: string, priority: string}>
     */
    private function staticPages(): array
    {
        $pages = [
            ['route' => 'home', 'changefreq' => 'daily', 'priority' => '1.0'],
            ['route' => 'hotelsSearch', 'changefreq' => 'daily', 'priority' => '0.9'],
            ['route' => 'hotels', 'params' => ['type' => 'hotel'], 'changefreq' => 'daily', 'priority' => '0.9'],
            ['route' => 'apartments', 'changefreq' => 'daily', 'priority' => '0.9'],
            ['route' => 'showCars', 'changefreq' => 'daily', 'priority' => '0.9'],
            ['route' => 'tours', 'changefreq' => 'weekly', 'priority' => '0.9'],
            ['route' => 'accommodations', 'changefreq' => 'daily', 'priority' => '0.8'],
            ['route' => 'destinations', 'changefreq' => 'weekly', 'priority' => '0.8'],
            ['route' => 'services', 'changefreq' => 'weekly', 'priority' => '0.8'],
            ['route' => 'about', 'changefreq' => 'monthly', 'priority' => '0.7'],
            ['route' => 'connect', 'changefreq' => 'monthly', 'priority' => '0.7'],
            ['route' => 'contact', 'changefreq' => 'monthly', 'priority' => '0.7'],
            ['route' => 'ticketing', 'changefreq' => 'monthly', 'priority' => '0.6'],
            ['route' => 'leftBags', 'changefreq' => 'monthly', 'priority' => '0.6'],
            ['route' => 'gallery', 'changefreq' => 'monthly', 'priority' => '0.5'],
            ['route' => 'events', 'changefreq' => 'monthly', 'priority' => '0.5'],
            ['route' => 'promotions', 'changefreq' => 'weekly', 'priority' => '0.6'],
            ['route' => 'facilities', 'changefreq' => 'monthly', 'priority' => '0.5'],
            ['route' => 'blogs', 'changefreq' => 'weekly', 'priority' => '0.6'],
            ['route' => 'reviews.index', 'changefreq' => 'weekly', 'priority' => '0.5'],
            ['route' => 'terms', 'changefreq' => 'yearly', 'priority' => '0.3'],
        ];

        $entries = [];

        foreach ($pages as $page) {
            if (!\Route::has($page['route'])) {
                continue;
            }

            $entries[] = $this->entry(
                route($page['route'], $page['params'] ?? []),
                null,
                $page['changefreq'],
                $page['priority']
            );
        }

        return $entries;
    }

    private function propertyEntries(): array
    {
        if (!Schema::hasTable('properties')) {
            return [];
        }

        return Property::query()
            ->publishedForGuests()
            ->whereNotNull('slug')
            ->where('slug', '!=', '')
            ->get(['slug', 'updated_at'])
            ->map(fn (Property $property) => $this->entry(
                route('hotel', $property->slug),
                $property->updated_at,
                'weekly',
                '0.8'
            ))
            ->all();
    }

    private function carEntries(): array
    {
        if (!Schema::hasTable('cars')) {
            return [];
        }

        return Car::query()
            ->where('status', 'available')
            ->whereNotNull('slug')
            ->where('slug', '!=', '')
            ->get(['slug', 'updated_at'])
            ->map(fn (Car $car) => $this->entry(
                route('carDetails', $car->slug),
                $car->updated_at,
                'weekly',
                '0.8'
            ))
            ->all();
    }

    private function tripEntries(): array
    {
        if (!Schema::hasTable('trips')) {
            return [];
        }

        return Trip::query()
            ->where('status', 'Active')
            ->whereNotNull('slug')
            ->where('slug', '!=', '')
            ->get(['slug', 'updated_at'])
            ->map(fn (Trip $trip) => $this->entry(
                route('tour', $trip->slug),
                $trip->updated_at,
                'weekly',
                '0.7'
            ))
            ->all();
    }

    private function tripDestinationEntries(): array
    {
        if (!Schema::hasTable('trip_destinations')) {
            return [];
        }

        return TripDestination::query()
            ->where('status', 'Active')
            ->whereNotNull('slug')
            ->where('slug', '!=', '')
            ->get(['slug', 'updated_at'])
            ->map(fn (TripDestination $destination) => $this->entry(
                route('tripDestination', $destination->slug),
                $destination->updated_at,
                'weekly',
                '0.7'
            ))
            ->all();
    }

    private function destinationEntries(): array
    {
        if (!Schema::hasTable('categories')) {
            return [];
        }

        return Category::query()
            ->whereNotNull('slug')
            ->where('slug', '!=', '')
            ->get(['slug', 'updated_at'])
            ->map(fn (Category $category) => $this->entry(
                route('destination', $category->slug),
                $category->updated_at,
                'weekly',
                '0.7'
            ))
            ->all();
    }

    private function serviceEntries(): array
    {
        if (!Schema::hasTable('programs')) {
            return [];
        }

        return Program::query()
            ->whereNotNull('slug')
            ->where('slug', '!=', '')
            ->get(['slug', 'updated_at'])
            ->map(fn (Program $program) => $this->entry(
                route('service', $program->slug),
                $program->updated_at,
                'monthly',
                '0.6'
            ))
            ->all();
    }

    private function blogEntries(): array
    {
        if (!Schema::hasTable('blogs')) {
            return [];
        }

        return Blog::query()
            ->where('status', 'Published')
            ->whereNotNull('slug')
            ->where('slug', '!=', '')
            ->get(['slug', 'updated_at', 'published_at'])
            ->map(fn (Blog $blog) => $this->entry(
                route('singleBlog', $blog->slug),
                $blog->published_at ?? $blog->updated_at,
                'monthly',
                '0.6'
            ))
            ->all();
    }

    private function legacyHotelEntries(): array
    {
        if (!Schema::hasTable('hotels')) {
            return [];
        }

        return Hotel::query()
            ->publishedForGuests()
            ->whereNotNull('slug')
            ->where('slug', '!=', '')
            ->get(['slug', 'updated_at'])
            ->map(fn (Hotel $hotel) => $this->entry(
                route('hotelRooms', $hotel->slug),
                $hotel->updated_at,
                'weekly',
                '0.7'
            ))
            ->all();
    }

    /**
     * @param  mixed  $lastModified
     * @return array{loc: string, lastmod: ?string, changefreq: string, priority: string}
     */
    private function entry(string $loc, $lastModified, string $changefreq, string $priority): array
    {
        return [
            'loc' => $loc,
            'lastmod' => $this->formatLastMod($lastModified),
            'changefreq' => $changefreq,
            'priority' => $priority,
        ];
    }

    private function formatLastMod($value): ?string
    {
        if (empty($value)) {
            return null;
        }

        if ($value instanceof Carbon) {
            return $value->copy()->utc()->toAtomString();
        }

        try {
            return Carbon::parse($value)->utc()->toAtomString();
        } catch (\Throwable $e) {
            return null;
        }
    }

    /**
     * @param  array<int, array{loc: string, lastmod: ?string, changefreq: string, priority: string}>  $entries
     * @return array<int, array{loc: string, lastmod: ?string, changefreq: string, priority: string}>
     */
    private function deduplicate(array $entries): array
    {
        $unique = [];

        foreach ($entries as $entry) {
            $unique[$entry['loc']] = $entry;
        }

        return array_values($unique);
    }
}
