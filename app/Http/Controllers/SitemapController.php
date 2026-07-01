<?php

namespace App\Http\Controllers;

use App\Services\SitemapService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class SitemapController extends Controller
{
    public function index(SitemapService $sitemapService): Response
    {
        $xml = Cache::remember('site.sitemap.xml', now()->addHour(), function () use ($sitemapService) {
            return $sitemapService->toXml($sitemapService->entries());
        });

        return response($xml, 200, [
            'Content-Type' => 'application/xml; charset=UTF-8',
        ]);
    }

    public function robots(): Response
    {
        $sitemapUrl = url('/sitemap.xml');

        $lines = [
            'User-agent: *',
            'Allow: /',
            'Disallow: /dashboard',
            'Disallow: /admin/',
            'Disallow: /my-properties',
            'Disallow: /Users',
            'Disallow: /setting',
            'Disallow: /getCars',
            'Disallow: /editCar/',
            'Disallow: /storeCar',
            'Disallow: /logouts',
            'Disallow: /email/verify',
            '',
            'Sitemap: ' . $sitemapUrl,
        ];

        return response(implode("\n", $lines) . "\n", 200, [
            'Content-Type' => 'text/plain; charset=UTF-8',
        ]);
    }
}
