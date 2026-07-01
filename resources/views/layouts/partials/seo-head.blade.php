@php
    $company = $setting->company ?? config('app.name', 'Car Rental');
    $defaultTitle = $setting->title ?: "Car Rental in Kigali, Rwanda | {$company}";
    $defaultDescription = $setting->meta_description
        ?: $setting->quote
        ?: "Rent a car in Kigali, Rwanda. Self-drive, airport pickup, 4x4 safari vehicles, and transparent daily rates in RWF.";
    $defaultKeywords = $setting->keywords ?: 'car rental Kigali, rent a car Rwanda, Kigali airport car rental, 4x4 rental Rwanda, self drive Kigali';
    $pageTitle = trim($__env->yieldContent('meta_title')) ?: $defaultTitle;
    $pageDescription = trim($__env->yieldContent('meta_description')) ?: $defaultDescription;
    $pageKeywords = trim($__env->yieldContent('meta_keywords')) ?: $defaultKeywords;
    $canonical = trim($__env->yieldContent('canonical_url')) ?: url()->current();
    $ogImage = trim($__env->yieldContent('og_image')) ?: ($logoUrl ?? asset('assets/img/logo.svg'));
@endphp

<title>{{ $pageTitle }}</title>
<meta name="description" content="{{ $pageDescription }}">
<meta name="keywords" content="{{ $pageKeywords }}">
<meta name="author" content="{{ $company }}">
<link rel="canonical" href="{{ $canonical }}">

<meta property="og:type" content="website">
<meta property="og:title" content="{{ $pageTitle }}">
<meta property="og:description" content="{{ $pageDescription }}">
<meta property="og:url" content="{{ $canonical }}">
<meta property="og:image" content="{{ $ogImage }}">
<meta property="og:site_name" content="{{ $company }}">

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $pageTitle }}">
<meta name="twitter:description" content="{{ $pageDescription }}">

@php
    $phone = primaryPhone($setting);
    $wa = whatsappUrl($phone);
@endphp
@if($phone || $setting->email || $setting->address)
<script type="application/ld+json">
{!! json_encode(array_filter([
    '@context' => 'https://schema.org',
    '@type' => 'AutoRental',
    'name' => $company,
    'url' => url('/'),
    'telephone' => $phone ?: null,
    'email' => $setting->email ?? null,
    'address' => ! empty($setting->address) ? [
        '@type' => 'PostalAddress',
        'streetAddress' => $setting->address,
        'addressLocality' => 'Kigali',
        'addressCountry' => 'RW',
    ] : null,
    'sameAs' => array_values(array_filter([
        $setting->facebook ?? null,
        $setting->instagram ?? null,
        $setting->youtube ?? null,
        $setting->linkedin ?? null,
        $setting->tiktok ?? null,
    ])),
]), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>
@endif
