@extends('layouts.adminBase')

@section('content')
@include('admin.includes.sidebar')

<div class="content">
    @include('admin.includes.navbar')

    <div class="container-fluid pt-4 px-4">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
            <div>
                <h4 class="mb-1">Update listing agreement template</h4>
                <p class="text-muted small mb-0">Edit platform representative, signature image, and contract sections. Hosts sign per listing; updates may require re-signing.</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.listing-agreement.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-arrow-left me-1"></i>Signed agreements
                </a>
                <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-sm">Dashboard</a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif

        @php
            $sections = old('sections');
            if ($sections === null) {
                $sections = $template->sections ?: \App\Models\ListingAgreementTemplate::defaultSections();
            }
            if (! is_array($sections)) {
                $sections = [];
            }
            foreach ($sections as $i => $sec) {
                if (! is_array($sec)) {
                    continue;
                }
                $sections[$i]['items_text'] = $sec['items_text'] ?? (isset($sec['items']) && is_array($sec['items']) ? implode("\n", $sec['items']) : '');
                $sections[$i]['heading'] = $sec['heading'] ?? '';
            }
            if (count($sections) === 0) {
                $sections = [['heading' => '', 'items_text' => '']];
            }
        @endphp

        <form action="{{ route('admin.listing-agreement.update') }}" method="POST" enctype="multipart/form-data" class="bg-light rounded p-4">
            @csrf
            @method('PUT')

            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <label class="form-label">Platform name</label>
                    <input type="text" name="platform_name" class="form-control" value="{{ old('platform_name', $template->platform_name) }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Tagline</label>
                    <input type="text" name="platform_tagline" class="form-control" value="{{ old('platform_tagline', $template->platform_tagline) }}" placeholder="Stay Nets - One Platform, Endless Destinations.">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Representative name</label>
                    <input type="text" name="platform_representative_name" class="form-control" value="{{ old('platform_representative_name', $template->platform_representative_name) }}" placeholder="Joseph K">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Email</label>
                    <input type="text" name="platform_email" class="form-control" value="{{ old('platform_email', $template->platform_email) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Website</label>
                    <input type="text" name="platform_website" class="form-control" value="{{ old('platform_website', $template->platform_website) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Phone (footer)</label>
                    <input type="text" name="platform_phone" class="form-control" value="{{ old('platform_phone', $template->platform_phone) }}">
                </div>
                <div class="col-12">
                    <label class="form-label">Intro text</label>
                    <textarea name="intro_text" class="form-control" rows="4">{{ old('intro_text', $template->intro_text) }}</textarea>
                </div>
            </div>

            <h6 class="mb-3">Modifiable contract terms</h6>
            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <label class="form-label">Damage report window (hours)</label>
                    <input type="number" name="damage_report_hours" class="form-control" min="1" value="{{ old('damage_report_hours', $template->damage_report_hours ?? 24) }}">
                    <small class="text-muted">Replaces [X] in section 8</small>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Termination notice (days)</label>
                    <input type="number" name="termination_notice_days" class="form-control" min="1" value="{{ old('termination_notice_days', $template->termination_notice_days ?? 30) }}">
                    <small class="text-muted">Replaces [30 days] in section 10</small>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Commission rate</label>
                    <input type="text" name="commission_rate" class="form-control" value="{{ old('commission_rate', $template->commission_rate ?? '5%') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Payment method</label>
                    <input type="text" name="payment_method" class="form-control" value="{{ old('payment_method', $template->payment_method) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Payment timeline</label>
                    <input type="text" name="payment_timeline" class="form-control" value="{{ old('payment_timeline', $template->payment_timeline) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Footer services line</label>
                    <input type="text" name="footer_services_text" class="form-control" value="{{ old('footer_services_text', $template->footer_services_text) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Platform representative signature (image)</label>
                    <input type="file" name="platform_signature" class="form-control" accept="image/*">
                    @if($template->platform_signature_path)
                        <div class="mt-2">
                            <img src="{{ asset('storage/'.$template->platform_signature_path) }}" alt="" class="img-thumbnail" style="max-height: 100px;">
                        </div>
                    @endif
                    <small class="text-muted">Used when approving host agreements</small>
                </div>
            </div>

            <h5 class="mb-3">Sections (headings &amp; bullet lines)</h5>
            <p class="text-muted small">Each section has a heading and bullet lines (one per line in the box).</p>

            <div id="sections-wrap">
                @foreach($sections as $i => $sec)
                    <div class="card mb-3 ag-section">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start gap-2 mb-2">
                                <label class="form-label mb-0 flex-grow-1">Heading</label>
                                <button type="button" class="btn btn-sm btn-outline-danger ag-remove" title="Remove section">&times;</button>
                            </div>
                            <input type="text" name="sections[{{ $i }}][heading]" class="form-control mb-3" value="{{ $sec['heading'] ?? '' }}" placeholder="e.g. 1. PURPOSE">
                            <label class="form-label">Bullet lines (one per line)</label>
                            <textarea name="sections[{{ $i }}][items_text]" class="form-control" rows="5" placeholder="Line one&#10;Line two">{{ $sec['items_text'] ?? '' }}</textarea>
                        </div>
                    </div>
                @endforeach
            </div>

            <button type="button" class="btn btn-outline-primary btn-sm mb-4" id="ag-add-section">+ Add section</button>

            <div>
                <button type="submit" class="btn btn-primary">Save agreement template</button>
            </div>
        </form>
    </div>
</div>

@include('admin.includes.footer')

@push('scripts')
<script>
(function () {
    const wrap = document.getElementById('sections-wrap');
    const addBtn = document.getElementById('ag-add-section');
    function nextIndex() {
        return wrap.querySelectorAll('.ag-section').length;
    }
    addBtn.addEventListener('click', function () {
        const i = nextIndex();
        const div = document.createElement('div');
        div.className = 'card mb-3 ag-section';
        div.innerHTML = '<div class="card-body">' +
            '<div class="d-flex justify-content-between align-items-start gap-2 mb-2">' +
            '<label class="form-label mb-0 flex-grow-1">Heading</label>' +
            '<button type="button" class="btn btn-sm btn-outline-danger ag-remove" title="Remove section">&times;</button>' +
            '</div>' +
            '<input type="text" name="sections[' + i + '][heading]" class="form-control mb-3" placeholder="e.g. New section">' +
            '<label class="form-label">Bullet lines (one per line)</label>' +
            '<textarea name="sections[' + i + '][items_text]" class="form-control" rows="5" placeholder="Line one\\nLine two"></textarea>' +
            '</div>';
        wrap.appendChild(div);
    });
    wrap.addEventListener('click', function (e) {
        if (e.target.classList.contains('ag-remove')) {
            const card = e.target.closest('.ag-section');
            if (card && wrap.querySelectorAll('.ag-section').length > 1) {
                card.remove();
            }
        }
    });
})();
</script>
@endpush
@endsection
