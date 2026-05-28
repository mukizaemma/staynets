@extends('layouts.frontbase')

@section('content')
@php
    $title = $data->heading ?? 'Left Bags (Luggage Storage)';
    $desc = $data->description ?? 'Travel light in Kigali. Leave your bags with StayNets for a few hours or days and explore the city freely — we’ll keep them safe while you enjoy your time.';
    $image = !empty($data?->image)
        ? asset('storage/images/' . ltrim($data->image, '/'))
        : asset('assets/img/leftbags.webp');
@endphp

<style>
    .lb-hero {
        background: linear-gradient(135deg, rgba(56, 136, 64, 0.10), rgba(24, 72, 112, 0.08));
        border-radius: 16px;
        overflow: hidden;
    }
    .lb-card {
        border: 1px solid rgba(0,0,0,.06);
        border-radius: 14px;
        background: #fff;
        box-shadow: 0 6px 24px rgba(0,0,0,.06);
    }
    .lb-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 12px;
        border-radius: 999px;
        background: rgba(56, 136, 64, 0.14);
        color: #0b7a3a;
        font-weight: 700;
        font-size: 13px;
    }
    .lb-step {
        display: flex;
        gap: 12px;
        padding: 14px;
        border-radius: 12px;
        background: #f8f9fa;
    }
    .lb-step .num {
        width: 34px;
        height: 34px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        background: #e7f3ff;
        color: var(--brand-blue);
        flex: 0 0 auto;
    }
    .lb-faq .accordion-button:not(.collapsed) {
        background: rgba(24, 72, 112, 0.08);
        color: #0a3d62;
    }
</style>

<section class="space bg-smoke">
    <div class="container" style="max-width: 1200px;">
        <div class="lb-hero p-4 p-lg-5 mb-4">
            <div class="row align-items-center g-4">
                <div class="col-lg-6">
                    <span class="lb-badge mb-3">
                        <i class="fas fa-shield-alt"></i> Secure luggage storage
                    </span>
                    <h1 class="sec-title mb-2">{{ $title }}</h1>
                    <p class="text-muted mb-4" style="font-size: 16px; line-height: 1.7;">
                        {!! $desc !!}
                    </p>

                    <div class="d-flex flex-wrap gap-2 mb-4">
                        <span class="badge bg-light text-dark" style="padding:10px 12px;border-radius:12px;">
                            <i class="fas fa-clock me-1" style="color:var(--brand-blue);"></i> Flexible drop-off &amp; pick-up
                        </span>
                        <span class="badge bg-light text-dark" style="padding:10px 12px;border-radius:12px;">
                            <i class="fas fa-user-check me-1" style="color:var(--brand-blue);"></i> Trusted handling
                        </span>
                        <span class="badge bg-light text-dark" style="padding:10px 12px;border-radius:12px;">
                            <i class="fas fa-map-marker-alt me-1" style="color:var(--brand-blue);"></i> Ideal for transit days
                        </span>
                    </div>

                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ route('leftBags.request') }}" class="th-btn" style="border-radius: 999px; padding: 14px 22px; font-weight: 800;">
                            Book luggage storage <img src="{{ asset('assets/img/icon/plane2.svg') }}" alt="">
                        </a>
                        <a href="{{ route('connect') }}" class="btn btn-outline-secondary" style="border-radius: 999px; padding: 14px 22px; font-weight: 700;">
                            Ask a question
                        </a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="lb-card p-2">
                        <img src="{{ $image }}" alt="Left Bags" style="width:100%;height:360px;object-fit:cover;border-radius:12px;">
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3 g-lg-4 mb-4">
            <div class="col-lg-4">
                <div class="lb-card p-4 h-100">
                    <h4 class="mb-2" style="font-weight: 800;"><i class="fas fa-lock me-2" style="color:var(--brand-blue);"></i>Safe storage</h4>
                    <p class="text-muted mb-0">Your bags are handled by our team and stored safely so you can explore worry-free.</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="lb-card p-4 h-100">
                    <h4 class="mb-2" style="font-weight: 800;"><i class="fas fa-walking me-2" style="color:var(--brand-blue);"></i>Travel hands‑free</h4>
                    <p class="text-muted mb-0">Perfect between check‑out and late flights, city tours, meetings, or day trips.</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="lb-card p-4 h-100">
                    <h4 class="mb-2" style="font-weight: 800;"><i class="fas fa-bolt me-2" style="color:var(--brand-blue);"></i>Fast booking</h4>
                    <p class="text-muted mb-0">Submit your request in under a minute — we’ll confirm details by email/phone.</p>
                </div>
            </div>
        </div>

        <div class="row g-4 align-items-start">
            <div class="col-lg-6">
                <div class="lb-card p-4">
                    <h3 class="mb-3" style="font-weight: 900;">How it works</h3>
                    <div class="d-grid gap-2">
                        <div class="lb-step">
                            <div class="num">1</div>
                            <div>
                                <div style="font-weight: 800;">Choose your dates</div>
                                <div class="text-muted small">Tell us when you’ll drop-off and pick-up.</div>
                            </div>
                        </div>
                        <div class="lb-step">
                            <div class="num">2</div>
                            <div>
                                <div style="font-weight: 800;">Share number of bags</div>
                                <div class="text-muted small">So we prepare space and confirm logistics.</div>
                            </div>
                        </div>
                        <div class="lb-step">
                            <div class="num">3</div>
                            <div>
                                <div style="font-weight: 800;">We confirm quickly</div>
                                <div class="text-muted small">You’ll get a confirmation and next steps.</div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('leftBags.request') }}" class="th-btn w-100" style="border-radius: 12px; padding: 14px 18px; font-weight: 900;">
                            Request luggage storage now <img src="{{ asset('assets/img/icon/plane2.svg') }}" alt="">
                        </a>
                        <p class="text-muted small mt-2 mb-0 text-center">No account required. We’ll contact you to confirm.</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="lb-card p-4 lb-faq">
                    <h3 class="mb-3" style="font-weight: 900;">FAQ</h3>
                    <div class="accordion" id="leftbagsFaq">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="lbq1">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#lba1" aria-expanded="true" aria-controls="lba1">
                                    Is my luggage secure?
                                </button>
                            </h2>
                            <div id="lba1" class="accordion-collapse collapse show" aria-labelledby="lbq1" data-bs-parent="#leftbagsFaq">
                                <div class="accordion-body text-muted">
                                    Yes — your bags are stored securely and handled by our team. If you have special items, add a note in the request form.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="lbq2">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#lba2" aria-expanded="false" aria-controls="lba2">
                                    Can I store bags for multiple days?
                                </button>
                            </h2>
                            <div id="lba2" class="accordion-collapse collapse" aria-labelledby="lbq2" data-bs-parent="#leftbagsFaq">
                                <div class="accordion-body text-muted">
                                    Absolutely. Choose your drop‑off and pick‑up dates in the request form and we’ll confirm.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="lbq3">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#lba3" aria-expanded="false" aria-controls="lba3">
                                    How fast do you confirm?
                                </button>
                            </h2>
                            <div id="lba3" class="accordion-collapse collapse" aria-labelledby="lbq3" data-bs-parent="#leftbagsFaq">
                                <div class="accordion-body text-muted">
                                    Usually within a short time during business hours. If urgent, add a note and we’ll prioritize.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

