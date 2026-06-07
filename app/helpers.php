<?php

if (!function_exists('getCurrencySymbol')) {
    /**
     * Get currency symbol based on currency code
     *
     * @param string $currency Currency code (USD, EUR, GBP, etc.)
     * @return string Currency symbol
     */
    function getCurrencySymbol($currency = 'USD')
    {
        $symbols = [
            'USD' => '$',
            'EUR' => '€',
            'GBP' => '£',
            'RWF' => 'Fr',
            'KES' => 'KSh',
            'UGX' => 'USh',
            'TZS' => 'TSh',
        ];
        
        return $symbols[$currency] ?? '$';
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
