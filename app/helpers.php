<?php

if (!function_exists('getCurrencySymbol')) {
    /**
     * Get currency symbol based on currency code
     *
     * @param string $currency Currency code (USD, EUR, GBP, etc.)
     * @return string Currency symbol
     */
    function getCurrencySymbol($currency = 'RWF')
    {
        $symbols = [
            'USD' => '$',
            'EUR' => '€',
            'GBP' => '£',
            'RWF' => 'RWF',
            'KES' => 'KSh',
            'UGX' => 'USh',
            'TZS' => 'TSh',
        ];

        return $symbols[$currency] ?? $currency;
    }
}

if (! function_exists('formatMoney')) {
    /**
     * Format an amount with the correct currency label (never $ for RWF).
     */
    function formatMoney($amount, string $currency = 'RWF', int $decimals = 0): string
    {
        $amount = (float) $amount;
        $formatted = number_format($amount, $decimals);

        $currency = strtoupper(trim($currency ?: 'RWF'));

        if ($currency === 'RWF') {
            return "RWF {$formatted}";
        }

        if (in_array($currency, ['USD', 'EUR', 'GBP'], true)) {
            return getCurrencySymbol($currency) . $formatted;
        }

        return trim(getCurrencySymbol($currency) . ' ' . $formatted);
    }
}

if (! function_exists('carImageUrl')) {
    function carImageUrl(?string $image): string
    {
        if (! empty($image)) {
            $path = 'images/cars/' . ltrim($image, '/');

            try {
                if (\Illuminate\Support\Facades\Storage::disk('public')->exists($path)) {
                    return \Illuminate\Support\Facades\Storage::url($path);
                }
            } catch (\Throwable $e) {
                // fall through
            }

            if (file_exists(storage_path('app/public/images/cars/' . $image))) {
                return asset('storage/images/cars/' . $image);
            }
        }

        return asset('assets/img/tour/tour_3_1.jpg');
    }
}

if (! function_exists('whatsappUrl')) {
    function whatsappUrl(?string $phone): ?string
    {
        $digits = preg_replace('/\D/', '', (string) $phone);

        return $digits ? 'https://wa.me/' . $digits : null;
    }
}

if (! function_exists('primaryPhone')) {
    function primaryPhone($setting = null): string
    {
        $setting = $setting ?? \App\Models\Setting::first();

        return trim((string) (optional($setting)->phone ?: optional($setting)->phone1 ?: ''));
    }
}

if (! function_exists('compress_uploaded_image')) {
    /**
     * Compress a single uploaded image when it exceeds 700KB.
     */
    function compress_uploaded_image(\Illuminate\Http\UploadedFile $file): \Illuminate\Http\UploadedFile
    {
        return app(\App\Services\ImageCompressionService::class)->compressIfNeeded($file);
    }
}
