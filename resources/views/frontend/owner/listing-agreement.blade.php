@extends('layouts.frontbase')

@section('content')
@php
    $listingName = $hotel->name ?? $propertyModel->name ?? 'Listing';
    $signUrl = $hotel
        ? route('my.properties.listing-agreement.sign', $hotel)
        : route('my.properties.property.listing-agreement.sign', $propertyModel);
    $backUrl = route('myProperties').'#properties';
    $sig = $signature ?? ($hotel ? $hotel->listingAgreementSignature : $propertyModel->listingAgreementSignature);
    $fullySigned = $sig && $sig->isFullySigned() && $sig->isCurrentForTemplate($template);
    $pending = $sig && $sig->isPendingApproval();
    $needsResign = $sig && $sig->owner_signature_path && ! $sig->isCurrentForTemplate($template) && ! $fullySigned;
@endphp
<div class="container py-4" style="max-width: 960px;">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3 no-print">
        <div>
            <h1 class="h3 mb-1">Property Listing Agreement</h1>
            <p class="text-muted small mb-0">{{ $listingName }}</p>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="window.print()"><i class="fas fa-print me-1"></i>Download / Print</button>
            <a href="{{ route('owner.signature.edit') }}" class="btn btn-outline-primary btn-sm"><i class="fas fa-signature me-1"></i>My signature</a>
            <a href="{{ route('profile.show') }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-user-cog me-1"></i>Account</a>
            <a href="{{ $backUrl }}" class="btn btn-outline-secondary btn-sm">Back</a>
        </div>
    </div>

    @if(session('success'))<div class="alert alert-success no-print">{{ session('success') }}</div>@endif
    @if(session('error'))<div class="alert alert-danger no-print">{{ session('error') }}</div>@endif

    @if($needsResign)
        <div class="alert alert-warning no-print">The agreement template was updated. Please review and sign again.</div>
    @elseif($pending)
        <div class="alert alert-info no-print"><i class="fas fa-clock me-2"></i>Your signature was submitted and is awaiting platform approval.</div>
    @elseif($fullySigned)
        <div class="alert alert-success no-print"><i class="fas fa-check-circle me-2"></i>This agreement is fully signed and on file.</div>
    @endif

    <div class="bg-white rounded shadow-sm p-3 p-md-4 mb-4 print-area">
        @include('partials.listing-agreement-document', [
            'template' => $template,
            'listing' => $listing,
            'owner' => $owner,
            'signature' => $sig ?? new \App\Models\ListingAgreementSignature(),
            'setting' => $setting ?? null,
            'showSignatures' => $fullySigned || $pending,
        ])
    </div>

    @if(! $fullySigned && ! $pending)
        <div class="card border-0 shadow-sm no-print">
            <div class="card-body p-4">
                <h2 class="h5 mb-3">Sign this agreement</h2>
                <p class="text-muted small">Fill in your details, upload your signature (or use your saved one), and submit for platform approval.</p>
                <form action="{{ $signUrl }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Your full name (printed on contract) <span class="text-danger">*</span></label>
                            <input type="text" name="host_printed_name" class="form-control" value="{{ old('host_printed_name', auth()->user()->name) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Agreement start date</label>
                            <input type="date" name="start_date" class="form-control" value="{{ old('start_date', date('Y-m-d')) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Upload signature image</label>
                            <input type="file" name="signature_image" class="form-control" accept="image/*">
                            @error('signature_image')<div class="text-danger small">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 d-flex align-items-end">
                            @if(auth()->user()->signature_path)
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="use_saved_signature" id="use_saved_signature" value="1" {{ old('use_saved_signature') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="use_saved_signature">Use my saved signature</label>
                                </div>
                            @else
                                <p class="small text-muted mb-2"><a href="{{ route('owner.signature.edit') }}">Save a signature</a> to reuse it on future agreements.</p>
                            @endif
                        </div>
                    </div>
                    <div class="form-check mt-3 mb-3">
                        <input class="form-check-input" type="checkbox" name="confirm_agreement" id="confirm_agreement" value="1" required>
                        <label class="form-check-label" for="confirm_agreement">
                            I have read and agree to the Property Listing Agreement above for <strong>{{ $listingName }}</strong>.
                        </label>
                    </div>
                    @error('confirm_agreement')<div class="text-danger small">{{ $message }}</div>@enderror
                    <button type="submit" class="btn btn-primary">Submit for approval</button>
                </form>
            </div>
        </div>
    @endif
</div>

<style>
@media print {
    .no-print, header, footer, .whatsapp-float { display: none !important; }
    .print-area { box-shadow: none !important; padding: 0 !important; }
}
</style>
@endsection
