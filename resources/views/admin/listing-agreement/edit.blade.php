@extends('layouts.adminBase')

@section('content')
@include('admin.includes.sidebar')

<div class="content">
    @include('admin.includes.navbar')

    <div class="container-fluid pt-4 px-4">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
            <div>
                <h4 class="mb-1">Update listing agreement template</h4>
                <p class="text-muted small mb-0">
                    Match the Stay Nets Property Listing Agreement format. Add, reorder, or edit numbered sections.
                    Hosts sign per listing; template updates may require re-signing.
                </p>
            </div>
            <div class="d-flex gap-2 flex-wrap">
                <form action="{{ route('admin.listing-agreement.reset') }}" method="POST" onsubmit="return confirm('Replace all sections and intro with the official Stay Nets defaults?');">
                    @csrf
                    <button type="submit" class="btn btn-outline-warning btn-sm">
                        <i class="fas fa-undo me-1"></i>Restore defaults
                    </button>
                </form>
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
                $sections = \App\Models\ListingAgreementTemplate::ensureCompleteSections(
                    $template->sections ?: null
                );
            }
            if (! is_array($sections)) {
                $sections = [];
            }
            foreach ($sections as $i => $sec) {
                if (! is_array($sec)) {
                    continue;
                }
                $sections[$i]['items_text'] = $sec['items_text']
                    ?? (isset($sec['items']) && is_array($sec['items']) ? implode("\n", $sec['items']) : '');
                $sections[$i]['heading'] = $sec['heading'] ?? '';
                $sections[$i]['lead_in'] = $sec['lead_in'] ?? '';
                $sections[$i]['closing'] = $sec['closing'] ?? '';
                $sections[$i]['type'] = $sec['type'] ?? (
                    \App\Models\ListingAgreementTemplate::normalizeHeadingKey($sec['heading'] ?? '') === 'SIGNATURES'
                        ? 'signatures'
                        : 'list'
                );
            }
            if (count($sections) === 0) {
                $sections = [['heading' => 'PURPOSE', 'lead_in' => '', 'items_text' => '', 'closing' => '', 'type' => 'list']];
            }
        @endphp

        <form action="{{ route('admin.listing-agreement.update') }}" method="POST" enctype="multipart/form-data" class="bg-light rounded p-4" id="agreement-template-form">
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
                    <label class="form-label">Intro / parties text</label>
                    <textarea name="intro_text" class="form-control" rows="7">{{ old('intro_text', $template->intro_text) }}</textarea>
                    <small class="text-muted">Placeholders: [REPRESENTATIVE], [HOST NAME]</small>
                </div>
            </div>

            <h6 class="mb-3">Modifiable contract terms</h6>
            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <label class="form-label">Damage report window (hours)</label>
                    <input type="number" name="damage_report_hours" class="form-control" min="1" value="{{ old('damage_report_hours', $template->damage_report_hours ?? 24) }}">
                    <small class="text-muted">Replaces [X]</small>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Termination notice (days)</label>
                    <input type="number" name="termination_notice_days" class="form-control" min="1" value="{{ old('termination_notice_days', $template->termination_notice_days ?? 30) }}">
                    <small class="text-muted">Replaces [30 days]</small>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Commission rate</label>
                    <input type="text" name="commission_rate" class="form-control" value="{{ old('commission_rate', $template->commission_rate ?? 'up to 10%') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Page break after section #</label>
                    <input type="number" name="page_break_after" class="form-control" min="1" max="50" value="{{ old('page_break_after', $template->page_break_after ?? 6) }}">
                    <small class="text-muted">PDF layout uses 6 (page 1 = sections 1–6)</small>
                </div>
                <div class="col-md-6">
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

            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                <div>
                    <h5 class="mb-1">Contract sections</h5>
                    <p class="text-muted small mb-0">
                        Headings are auto-numbered on save. Use lead-in / closing for lines like “Stay Nets will:”.
                        Placeholders: [PROPERTY NAME], [LOCATION], [TYPE], [COMMISSION], [PAYMENT METHOD], [PAYMENT TIMELINE], [START DATE], [X], [30 days].
                    </p>
                </div>
                <button type="button" class="btn btn-outline-primary btn-sm" id="ag-add-section">+ Add section</button>
            </div>

            <div id="sections-wrap">
                @foreach($sections as $i => $sec)
                    <div class="card mb-3 ag-section" data-index="{{ $i }}">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start gap-2 mb-3">
                                <div class="d-flex gap-1">
                                    <button type="button" class="btn btn-sm btn-outline-secondary ag-up" title="Move up">↑</button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary ag-down" title="Move down">↓</button>
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-danger ag-remove" title="Remove section">&times;</button>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-8">
                                    <label class="form-label">Heading (without number)</label>
                                    <input type="text" name="sections[{{ $i }}][heading]" class="form-control ag-heading" value="{{ preg_replace('/^\d+\.\s*/', '', $sec['heading'] ?? '') }}" placeholder="e.g. PURPOSE" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Section type</label>
                                    <select name="sections[{{ $i }}][type]" class="form-select">
                                        <option value="list" @selected(($sec['type'] ?? 'list') !== 'signatures')>List / clauses</option>
                                        <option value="signatures" @selected(($sec['type'] ?? '') === 'signatures')>Signatures block</option>
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Lead-in (optional)</label>
                                    <input type="text" name="sections[{{ $i }}][lead_in]" class="form-control" value="{{ $sec['lead_in'] ?? '' }}" placeholder="e.g. Stay Nets will:">
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Bullet / clause lines (one per line)</label>
                                    <textarea name="sections[{{ $i }}][items_text]" class="form-control" rows="5" placeholder="Line one&#10;Line two">{{ $sec['items_text'] ?? '' }}</textarea>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Closing line (optional)</label>
                                    <input type="text" name="sections[{{ $i }}][closing]" class="form-control" value="{{ $sec['closing'] ?? '' }}" placeholder="e.g. Commission is a standard part of such agreements">
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <button type="button" class="btn btn-outline-primary btn-sm mb-4" id="ag-add-section-bottom">+ Add section</button>

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

    function reindex() {
        wrap.querySelectorAll('.ag-section').forEach(function (card, i) {
            card.dataset.index = String(i);
            card.querySelectorAll('[name^="sections["]').forEach(function (el) {
                el.name = el.name.replace(/sections\[\d+]/, 'sections[' + i + ']');
            });
        });
    }

    function sectionHtml(i) {
        return '<div class="card mb-3 ag-section" data-index="' + i + '">' +
            '<div class="card-body">' +
            '<div class="d-flex justify-content-between align-items-start gap-2 mb-3">' +
            '<div class="d-flex gap-1">' +
            '<button type="button" class="btn btn-sm btn-outline-secondary ag-up" title="Move up">↑</button>' +
            '<button type="button" class="btn btn-sm btn-outline-secondary ag-down" title="Move down">↓</button>' +
            '</div>' +
            '<button type="button" class="btn btn-sm btn-outline-danger ag-remove" title="Remove section">&times;</button>' +
            '</div>' +
            '<div class="row g-3">' +
            '<div class="col-md-8"><label class="form-label">Heading (without number)</label>' +
            '<input type="text" name="sections[' + i + '][heading]" class="form-control ag-heading" placeholder="e.g. NEW SECTION" required></div>' +
            '<div class="col-md-4"><label class="form-label">Section type</label>' +
            '<select name="sections[' + i + '][type]" class="form-select">' +
            '<option value="list">List / clauses</option>' +
            '<option value="signatures">Signatures block</option>' +
            '</select></div>' +
            '<div class="col-md-12"><label class="form-label">Lead-in (optional)</label>' +
            '<input type="text" name="sections[' + i + '][lead_in]" class="form-control" placeholder="e.g. The Host agrees to:"></div>' +
            '<div class="col-md-12"><label class="form-label">Bullet / clause lines (one per line)</label>' +
            '<textarea name="sections[' + i + '][items_text]" class="form-control" rows="5" placeholder="Line one\\nLine two"></textarea></div>' +
            '<div class="col-md-12"><label class="form-label">Closing line (optional)</label>' +
            '<input type="text" name="sections[' + i + '][closing]" class="form-control"></div>' +
            '</div></div></div>';
    }

    function addSection() {
        const i = wrap.querySelectorAll('.ag-section').length;
        wrap.insertAdjacentHTML('beforeend', sectionHtml(i));
        reindex();
    }

    document.getElementById('ag-add-section').addEventListener('click', addSection);
    document.getElementById('ag-add-section-bottom').addEventListener('click', addSection);

    wrap.addEventListener('click', function (e) {
        const card = e.target.closest('.ag-section');
        if (!card) return;

        if (e.target.classList.contains('ag-remove')) {
            if (wrap.querySelectorAll('.ag-section').length > 1) {
                card.remove();
                reindex();
            }
            return;
        }
        if (e.target.classList.contains('ag-up')) {
            const prev = card.previousElementSibling;
            if (prev) {
                wrap.insertBefore(card, prev);
                reindex();
            }
            return;
        }
        if (e.target.classList.contains('ag-down')) {
            const next = card.nextElementSibling;
            if (next) {
                wrap.insertBefore(next, card);
                reindex();
            }
        }
    });
})();
</script>
@endpush
@endsection
