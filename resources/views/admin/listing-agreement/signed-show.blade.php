@extends('layouts.adminBase')

@section('content')
<style>
    @media print {
        .no-print, .sidebar, .navbar, .back-to-top, #spinner { display: none !important; }
        .content { margin-left: 0 !important; width: 100% !important; }
        .print-area { box-shadow: none !important; padding: 0 !important; }
    }
</style>

@include('admin.includes.sidebar')

<div class="content">
    @include('admin.includes.navbar')

    <div class="container-fluid pt-4 px-4">
        <div class="no-print d-flex flex-wrap gap-2 justify-content-between align-items-center mb-4">
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('admin.listing-agreement.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-arrow-left me-1"></i>Back
                </a>
                <button type="button" class="btn btn-primary btn-sm" onclick="window.print()">
                    <i class="fas fa-download me-1"></i>Download / Print PDF
                </button>
            </div>
        </div>

        @if(session('success'))<div class="alert alert-success no-print">{{ session('success') }}</div>@endif
        @if(session('error'))<div class="alert alert-danger no-print">{{ session('error') }}</div>@endif

        <div class="no-print alert alert-light border mb-4">
            <div class="row g-2 small">
                <div class="col-md-3"><strong>Record #</strong> {{ $signature->id }}</div>
                <div class="col-md-3"><strong>Status</strong> <span class="badge bg-{{ $signature->status === 'signed' ? 'success' : 'warning text-dark' }}">{{ $signature->statusLabel() }}</span></div>
                <div class="col-md-3"><strong>Listing</strong> {{ $listingName }}</div>
                <div class="col-md-3"><strong>Host</strong> {{ $owner->name ?? '—' }}</div>
            </div>
        </div>

        <div class="print-area bg-white rounded shadow-sm p-3 p-md-4 mx-auto mb-4" style="max-width: 900px;">
            @if($listing)
            @include('partials.listing-agreement-document', [
                'template' => $template,
                'listing' => $listing,
                'owner' => $owner,
                'signature' => $signature,
                'setting' => $setting,
                'showSignatures' => true,
            ])
            @else
                <p class="text-muted">The linked listing was removed. Signature record #{{ $signature->id }} is kept for audit.</p>
            @endif
        </div>

        @if($signature->isPendingApproval())
            <div class="no-print bg-light rounded p-4 mx-auto" style="max-width: 900px;">
                <h5 class="mb-3">Approve &amp; sign as platform</h5>
                <p class="text-muted small">Review the host signature below, then approve to mark this agreement as fully signed.</p>
                @if($signature->owner_signature_path)
                    <div class="mb-3">
                        <label class="form-label small text-muted">Host signature submitted</label>
                        <div><img src="{{ asset('storage/'.$signature->owner_signature_path) }}" alt="Host signature" style="max-height: 90px;" class="border rounded p-2 bg-white"></div>
                    </div>
                @endif
                <form action="{{ route('admin.listing-agreement.approve', $signature) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Platform signature (optional upload)</label>
                            <input type="file" name="admin_signature" class="form-control" accept="image/*">
                            @if($template->platform_signature_path)
                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="checkbox" name="use_template_signature" id="use_template_signature" value="1" checked>
                                    <label class="form-check-label" for="use_template_signature">Use template signature on file</label>
                                </div>
                                <img src="{{ asset('storage/'.$template->platform_signature_path) }}" alt="" class="img-thumbnail mt-2" style="max-height: 80px;">
                            @endif
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Admin notes (optional)</label>
                            <textarea name="admin_notes" class="form-control" rows="4">{{ old('admin_notes', $signature->admin_notes) }}</textarea>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success mt-3"><i class="fas fa-check me-1"></i>Approve &amp; mark as signed</button>
                </form>
            </div>
        @elseif($signature->isFullySigned())
            <div class="no-print alert alert-success mx-auto" style="max-width: 900px;">
                <i class="fas fa-check-circle me-2"></i>Approved on {{ $signature->admin_approved_at?->format('M j, Y g:i A') ?? '—' }}
            </div>
        @endif
    </div>
</div>

@include('admin.includes.footer')
@endsection
