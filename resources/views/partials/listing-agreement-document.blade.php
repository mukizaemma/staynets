@php
    $sections = \App\Models\ListingAgreementTemplate::ensureCompleteSections(
        $template->sections ?: null
    );
    $breakAfter = max(1, (int) ($template->page_break_after ?? 6));
    $pageOne = array_slice($sections, 0, $breakAfter);
    $pageTwo = array_slice($sections, $breakAfter);
    $listingName = optional($listing)->name;
    $listingLocation = optional($listing)->location
        ?? optional($listing)->city
        ?? optional($listing)->address;
    $listingType = optional($listing)->property_type ?? optional($listing)->type;
    $hostName = optional($signature)->host_printed_name
        ?? optional($owner)->name
        ?? (auth()->user()->name ?? null);
    $startDate = optional($signature)->start_date ?? optional($signature)->signed_at;
    $startDateFormatted = $startDate instanceof \Carbon\Carbon
        ? $startDate->format('d/m/Y')
        : ($startDate ? \Carbon\Carbon::parse($startDate)->format('d/m/Y') : '...../...../.......');
    $platformSig = optional($signature)->admin_signature_path ?? $template->platform_signature_path ?? null;
    $ownerSig = optional($signature)->owner_signature_path
        ?? optional($owner)->signature_path
        ?? (auth()->user()->signature_path ?? null);
    $logoUrl = asset('assets/img/logo.svg');
    $rawLogo = ltrim((string) (optional($setting ?? null)->logo ?? ''), '/');
    if (!empty($rawLogo)) {
        foreach (array_unique(array_filter([$rawLogo, 'images/'.$rawLogo, 'images/site/'.$rawLogo])) as $c) {
            try {
                if (\Illuminate\Support\Facades\Storage::disk('public')->exists($c)) {
                    $logoUrl = \Illuminate\Support\Facades\Storage::url($c);
                    break;
                }
            } catch (\Throwable $e) {}
        }
    }

    $blankDots = '................';
    $displayPropertyName = $listingName ?: $blankDots;
    $displayLocation = $listingLocation ?: $blankDots;
    $displayType = $listingType
        ? ucfirst(str_replace('_', ' ', (string) $listingType))
        : $blankDots;
    $displayHost = $hostName ?: '[Full Name / Company Name]';
    $displayRep = $template->platform_representative_name ?: 'Joseph K';

    $resolveLine = function ($line) use (
        $template,
        $displayPropertyName,
        $displayLocation,
        $displayType,
        $startDateFormatted,
        $displayHost,
        $displayRep
    ) {
        return str_replace(
            [
                '[X]',
                '[30 days]',
                '[START DATE]',
                '[PROPERTY NAME]',
                '[LOCATION]',
                '[TYPE]',
                '[COMMISSION]',
                '[PAYMENT METHOD]',
                '[PAYMENT TIMELINE]',
                '[HOST NAME]',
                '[REPRESENTATIVE]',
            ],
            [
                (string) ($template->damage_report_hours ?? 24),
                ($template->termination_notice_days ?? 30).' days',
                $startDateFormatted,
                $displayPropertyName,
                $displayLocation,
                $displayType,
                $template->commission_rate ?? 'up to 10%',
                $template->payment_method ?? 'Bank transfer / Mobile Money / Card',
                $template->payment_timeline ?? 'Within 7–14 days after guest checkout',
                $displayHost,
                $displayRep,
            ],
            (string) $line
        );
    };

    $introRaw = $template->intro_text ?: \App\Models\ListingAgreementTemplate::defaultIntro();
    $introResolved = $resolveLine($introRaw);

    $renderSection = function ($block) use ($template, $resolveLine, $platformSig, $ownerSig, $displayHost, $displayRep, $signature) {
        $isSignatures = $template->isSignaturesSection($block);
        if ($isSignatures) {
            return [
                'signatures' => true,
                'heading' => $block['heading'] ?? 'SIGNATURES',
                'items' => $block['items'] ?? [],
            ];
        }

        return [
            'signatures' => false,
            'heading' => $block['heading'] ?? '',
            'lead_in' => $block['lead_in'] ?? '',
            'items' => $block['items'] ?? [],
            'closing' => $block['closing'] ?? '',
        ];
    };

    $footerBar = $template->footer_services_text
        ?? 'Booking Engine: Hotel, Apartment, Villa House, Tour Package and Car Rental.';
    $footerPhone = $template->platform_phone ?? '+250784251094/250788788633';
@endphp

@include('partials.listing-agreement-styles')

<div class="staynets-contract {{ $printClass ?? '' }}" id="staynets-contract-document">
    {{-- PAGE 1 --}}
    <div class="staynets-contract__page {{ count($pageTwo) ? 'staynets-contract__page-break' : '' }}">
        <header class="staynets-contract__header">
            <div class="staynets-contract__brand">
                <img src="{{ $logoUrl }}" alt="{{ $template->platform_name }}" class="staynets-contract__logo">
                <h2 class="staynets-contract__brand-name">{{ $template->platform_name ?? 'Stay Nets' }}</h2>
            </div>
            <div class="staynets-contract__meta">
                <strong>{{ $template->platform_tagline ?? 'Stay Nets - One Platform, Endless Destinations.' }}</strong>
                Email: {{ $template->platform_email ?? 'staynets2@gmail.com' }} |
                {{ $template->platform_website ?? 'www.staynets.com' }}
            </div>
        </header>

        <h1 class="staynets-contract__title">Property Listing Agreement</h1>

        <div class="staynets-contract__intro">{!! nl2br(e($introResolved)) !!}</div>

        @foreach($pageOne as $block)
            @php $section = $renderSection($block); @endphp
            @if($section['signatures'])
                @include('partials.listing-agreement-signatures', [
                    'heading' => $section['heading'],
                    'items' => $section['items'],
                    'resolveLine' => $resolveLine,
                    'platformSig' => $platformSig,
                    'ownerSig' => $ownerSig,
                    'displayHost' => $displayHost,
                    'displayRep' => $displayRep,
                    'signature' => $signature,
                    'showSignatures' => $showSignatures ?? true,
                ])
            @else
                <div class="staynets-contract__section">
                    <h3 class="staynets-contract__section-title">{{ $section['heading'] }}</h3>
                    @if(!empty($section['lead_in']))
                        <p class="staynets-contract__lead-in">{{ $resolveLine($section['lead_in']) }}</p>
                    @endif
                    @if(!empty($section['items']))
                        <ul>
                            @foreach($section['items'] as $line)
                                <li>{!! nl2br(e($resolveLine($line))) !!}</li>
                            @endforeach
                        </ul>
                    @endif
                    @if(!empty($section['closing']))
                        <p class="staynets-contract__closing">{{ $resolveLine($section['closing']) }}</p>
                    @endif
                </div>
            @endif
        @endforeach

        <div class="staynets-contract__footer-bar">{{ $footerBar }}</div>
        <div class="staynets-contract__footer-phone">Phone: {{ $footerPhone }}</div>
    </div>

    {{-- PAGE 2+ --}}
    @if(count($pageTwo))
        <div class="staynets-contract__page">
            @foreach($pageTwo as $block)
                @php $section = $renderSection($block); @endphp
                @if($section['signatures'])
                    @include('partials.listing-agreement-signatures', [
                        'heading' => $section['heading'],
                        'items' => $section['items'],
                        'resolveLine' => $resolveLine,
                        'platformSig' => $platformSig,
                        'ownerSig' => $ownerSig,
                        'displayHost' => $displayHost,
                        'displayRep' => $displayRep,
                        'signature' => $signature,
                        'showSignatures' => $showSignatures ?? true,
                    ])
                @else
                    <div class="staynets-contract__section">
                        <h3 class="staynets-contract__section-title">{{ $section['heading'] }}</h3>
                        @if(!empty($section['lead_in']))
                            <p class="staynets-contract__lead-in">{{ $resolveLine($section['lead_in']) }}</p>
                        @endif
                        @if(!empty($section['items']))
                            <ul>
                                @foreach($section['items'] as $line)
                                    <li>{!! nl2br(e($resolveLine($line))) !!}</li>
                                @endforeach
                            </ul>
                        @endif
                        @if(!empty($section['closing']))
                            <p class="staynets-contract__closing">{{ $resolveLine($section['closing']) }}</p>
                        @endif
                    </div>
                @endif
            @endforeach

            <div class="staynets-contract__footer-bar">{{ $footerBar }}</div>
            <div class="staynets-contract__footer-phone">Phone: {{ $footerPhone }}</div>
        </div>
    @endif
</div>
