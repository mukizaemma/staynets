@php
    $sections = $template->sections ?: \App\Models\ListingAgreementTemplate::defaultSections();
    $pageOne = array_slice($sections, 0, 6);
    $pageTwo = array_slice($sections, 6);
    $listingName = $listing->name ?? '—';
    $listingLocation = $listing->location ?? $listing->city ?? $listing->address ?? '—';
    $listingType = $listing->property_type ?? $listing->type ?? class_basename($listing);
    $hostName = $signature->host_printed_name ?? ($owner->name ?? auth()->user()->name ?? '—');
    $startDate = $signature->start_date ?? ($signature->signed_at ?? now());
    $startDateFormatted = $startDate instanceof \Carbon\Carbon ? $startDate->format('d/m/Y') : now()->format('d/m/Y');
    $platformSig = $signature->admin_signature_path ?? $template->platform_signature_path ?? null;
    $ownerSig = $signature->owner_signature_path ?? ($owner->signature_path ?? auth()->user()->signature_path ?? null);
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
    $resolveLine = function ($line) use ($template, $listingName, $listingLocation, $listingType, $startDateFormatted) {
        return str_replace(
            ['[X]', '[30 days]', '[START DATE]', '[PROPERTY NAME]', '[LOCATION]', '[TYPE]', '[COMMISSION]', '[PAYMENT METHOD]', '[PAYMENT TIMELINE]'],
            [
                (string) ($template->damage_report_hours ?? 24),
                ($template->termination_notice_days ?? 30).' days',
                $startDateFormatted,
                $listingName,
                $listingLocation,
                ucfirst(str_replace('_', ' ', (string) $listingType)),
                $template->commission_rate ?? '5%',
                $template->payment_method ?? 'Bank transfer / Mobile Money / Card',
                $template->payment_timeline ?? 'Within 7–14 days after guest checkout',
            ],
            (string) $line
        );
    };
@endphp

@include('partials.listing-agreement-styles')

<div class="staynets-contract {{ $printClass ?? '' }}" id="staynets-contract-document">
    {{-- PAGE 1 --}}
    <div class="staynets-contract__page staynets-contract__page-break">
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

        @if($template->intro_text)
            <div class="staynets-contract__intro">{!! nl2br(e($template->intro_text)) !!}</div>
        @else
            <div class="staynets-contract__intro">
                This Agreement is made between:<br><br>
                <strong>1. Platform Owner:</strong> {{ $template->platform_name ?? 'Stay Nets' }}, operating an online booking platform (“Platform”)<br><br>
                <strong>AND</strong><br><br>
                <strong>2. Property Owner / Host</strong> (“Host”): <strong>{{ $hostName }}</strong>
            </div>
        @endif

        <div class="staynets-contract__property-box">
            <p><strong>Property Name:</strong> {{ $listingName }}</p>
            <p><strong>Location:</strong> {{ $listingLocation }}</p>
            <p><strong>Property Type:</strong> {{ ucfirst(str_replace('_', ' ', (string) $listingType)) }}</p>
            <p><strong>Agreement Start Date:</strong> {{ $startDateFormatted }}</p>
        </div>

        @foreach($pageOne as $block)
            <div class="staynets-contract__section">
                <h3 class="staynets-contract__section-title">{{ $block['heading'] ?? '' }}</h3>
                @if(!empty($block['items']))
                    <ul>
                        @foreach($block['items'] as $line)
                            <li>{!! nl2br(e($resolveLine($line))) !!}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
        @endforeach
    </div>

    {{-- PAGE 2 --}}
    <div class="staynets-contract__page">
        @foreach($pageTwo as $block)
            @php $heading = strtoupper(trim($block['heading'] ?? '')); @endphp
            @if(str_contains($heading, 'SIGNATURE'))
                <div class="staynets-contract__signatures">
                    <h3 class="staynets-contract__section-title">14. SIGNATURES</h3>
                    <div class="row">
                        <div class="col-md-6 staynets-contract__sig-block">
                            <div class="staynets-contract__sig-label">Stay Nets Representative: {{ $template->platform_representative_name ?? 'Joseph K' }}</div>
                            <div class="staynets-contract__sig-label small">Signature:</div>
                            <div class="staynets-contract__sig-line">
                                @if($platformSig && ($showSignatures ?? true))
                                    <img src="{{ asset('storage/'.$platformSig) }}" alt="Platform signature">
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6 staynets-contract__sig-block">
                            <div class="staynets-contract__sig-label">Host: {{ $hostName }}</div>
                            <div class="staynets-contract__sig-label small">Signature:</div>
                            <div class="staynets-contract__sig-line">
                                @if($ownerSig && ($showSignatures ?? true))
                                    <img src="{{ asset('storage/'.$ownerSig) }}" alt="Host signature">
                                @endif
                            </div>
                            <div class="staynets-contract__sig-label small mt-3">Date: {{ $signature->signed_at?->format('d/m/Y') ?? '…………………' }}</div>
                        </div>
                    </div>
                </div>
            @else
                <div class="staynets-contract__section">
                    <h3 class="staynets-contract__section-title">{{ $block['heading'] ?? '' }}</h3>
                    @if(!empty($block['items']))
                        <ul>
                            @foreach($block['items'] as $line)
                                <li>{!! nl2br(e($resolveLine($line))) !!}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            @endif
        @endforeach

        <div class="staynets-contract__footer-bar">
            {{ $template->footer_services_text ?? 'Booking Engine: Hotel, Apartment, Villa House, Tour Package and Car Rental.' }}
        </div>
        <div class="staynets-contract__footer-phone">
            Phone: {{ $template->platform_phone ?? '+250784251094/250788788633' }}
        </div>
    </div>
</div>
