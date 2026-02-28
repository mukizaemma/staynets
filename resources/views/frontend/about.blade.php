@extends('layouts.frontbase')

@section('content')
@if(session('success'))
<div class="container mt-3">
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
</div>
@endif
@php
    $about = $about ?? null;
    $headerImage = (optional($setting)->home_header_image ?? null)
        ? asset('storage/images/site/' . optional($setting)->home_header_image)
        : ($about && $about->image1 ? asset('storage/images/about/' . $about->image1) : null);
    $title = optional($about)->title ?? 'Stay Nets - About Us';
    $tagline = optional($about)->subTitle ?? 'Your Trusted Partner for Travel, Stays, and Adventures in Rwanda & East Africa';
    $connectUrl = route('connect');
    $ctaServices = optional($about)->cta_services_url ?? route('services');
    $ctaBook = optional($about)->cta_book_url ?? $connectUrl;
    $ctaContact = optional($about)->cta_contact_url ?? $connectUrl;
@endphp

    {{-- Hero / Header --}}
    <section class="about-hero position-relative overflow-hidden">
        @if($headerImage)
        <div class="about-hero-bg" style="background-image: url('{{ $headerImage }}');"></div>
        @else
        <div class="about-hero-bg" style="background: linear-gradient(135deg, #1a365d 0%, #2c5282 100%);"></div>
        @endif
        <div class="about-hero-overlay"></div>
        <div class="container position-relative">
            <div class="row about-hero-row align-items-center py-5">
                <div class="col-lg-10 mx-auto text-center about-hero-text">
                    <h1 class="display-4 fw-bold mb-3 text-white">{{ $title }}</h1>
                    <p class="lead mb-0 text-white about-hero-tagline">{{ $tagline }}</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Intro --}}
    @if($about && ($about->welcomeMessage || $about->mission))
    <section class="py-5 bg-light">
        <div class="container py-4">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    @if($about->welcomeMessage)
                    <div class="about-intro mb-4">
                        {!! $about->welcomeMessage !!}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- Mission & Vision --}}
    @if($about && ($about->mission || $about->vision))
    <section class="py-5">
        <div class="container py-4">
            <div class="row g-4">
                @if($about->mission)
                <div class="col-md-6">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <h3 class="h5 text-primary mb-3">Our Mission</h3>
                            <div class="text-secondary">{!! nl2br(e($about->mission)) !!}</div>
                        </div>
                    </div>
                </div>
                @endif
                @if($about->vision)
                <div class="col-md-6">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <h3 class="h5 text-primary mb-3">Our Vision</h3>
                            <div class="text-secondary">{!! nl2br(e($about->vision)) !!}</div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </section>
    @endif

    {{-- What We Do --}}
    @if($about && $about->what_we_do)
    <section class="py-5 bg-light">
        <div class="container py-4">
            <h2 class="text-center mb-4">What We Do</h2>
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="about-what-we-do">
                        {!! $about->what_we_do !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- Why Choose Us --}}
    @if($about && $about->WhyChooseUs)
    <section class="py-5">
        <div class="container py-4">
            <h2 class="text-center mb-4">Why Choose Stay Nets</h2>
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="about-why-choose">
                        {!! $about->WhyChooseUs !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- Our Commitment --}}
    @if($about && $about->commitment)
    <section class="py-5 bg-light">
        <div class="container py-4">
            <h2 class="text-center mb-4">Our Commitment</h2>
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <div class="about-commitment lead text-secondary">
                        {!! nl2br(e($about->commitment)) !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- CTA Buttons --}}
    <section class="py-5 border-top">
        <div class="container py-4">
            <h2 class="text-center mb-4">Get Started</h2>
            <div class="row g-3 justify-content-center flex-wrap">
                <div class="col-auto">
                    <a href="{{ $ctaServices }}" class="btn btn-primary btn-lg px-4">
                        <i class="fa fa-concierge-bell me-2"></i>Explore Our Services
                    </a>
                </div>
                <div class="col-auto">
                    <a href="{{ $ctaBook }}" class="btn btn-outline-primary btn-lg px-4">
                        <i class="fa fa-calendar-check me-2"></i>Book Your Stay or Adventure
                    </a>
                </div>
                <div class="col-auto">
                    <a href="{{ $ctaContact }}" class="btn btn-outline-secondary btn-lg px-4">
                        <i class="fa fa-envelope me-2"></i>Contact Us
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- Reviews (same as reviews page section) --}}
    <section class="position-relative overflow-hidden space-top space-extra-bottom" id="reviews-sec" style="background: #f8f9fa;">
        <div class="container">
            <div class="row justify-content-center mb-4">
                <div class="col-lg-8">
                    <div class="title-area text-center">
                        <span class="sub-title">Testimonial</span>
                        <h2 class="sec-title">What Clients Say About Us</h2>
                        <p class="sec-text">Read what our customers have to say about their experiences</p>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-12 d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div></div>
                    @auth
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#aboutReviewModal" style="background: linear-gradient(135deg, #25D366, #128C7E); border: none; padding: 12px 30px; border-radius: 8px; font-weight: 600;">
                        <i class="fas fa-plus me-2"></i>Add Review & Rate Us (1-5)
                    </button>
                    @else
                    <a href="{{ route('login') }}?redirect={{ urlencode(route('about') . '#reviews-sec') }}" class="btn btn-primary" style="background: linear-gradient(135deg, #25D366, #128C7E); border: none; padding: 12px 30px; border-radius: 8px; font-weight: 600;">
                        <i class="fas fa-star me-2"></i>Login to Add Your Review & Rate
                    </a>
                    @endauth
                </div>
            </div>

            <div class="row gy-4">
                @php $reviews = $reviews ?? collect(); @endphp
                @forelse($reviews as $review)
                <div class="col-lg-4 col-md-6">
                    <a href="{{ route('reviews.show', $review->id) }}" style="text-decoration: none; color: inherit;">
                        <div class="review-card" style="background: #fff; border-radius: 16px; padding: 30px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); height: 100%; transition: transform 0.3s, box-shadow 0.3s; cursor: pointer;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 8px 25px rgba(0,0,0,0.12)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 20px rgba(0,0,0,0.08)'">
                            <div class="review-content mb-3">
                                <div class="quote-icon mb-3" style="font-size: 40px; color: #25D366; opacity: 0.3;">
                                    <i class="fas fa-quote-left"></i>
                                </div>
                                @if($review->rating)
                                <div class="mb-2">
                                    @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-muted' }}" style="font-size: 14px;"></i>
                                    @endfor
                                    <span class="ms-1 text-muted small">{{ $review->rating }}/5</span>
                                </div>
                                @endif
                                <p style="color: #666; font-size: 15px; line-height: 1.8; font-style: italic; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                                    {{ $review->testimony }}
                                </p>
                                @if($review->admin_response)
                                <div style="margin-top: 12px; padding: 12px 14px; background: #f8f9fa; border-left: 3px solid #25D366; border-radius: 6px;">
                                    <div style="font-size: 12px; font-weight: 600; color: #25D366; margin-bottom: 4px;">
                                        <i class="fas fa-reply me-1"></i>Admin Reply
                                    </div>
                                    <div style="color: #666; font-size: 13px; line-height: 1.6; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                        {{ $review->admin_response }}
                                    </div>
                                </div>
                                @endif
                                @if($review->images && $review->images->count() > 0)
                                <div class="mt-2">
                                    <small class="text-muted"><i class="fas fa-images"></i> {{ $review->images->count() }} image(s)</small>
                                </div>
                                @endif
                            </div>
                            <div class="review-author" style="border-top: 1px solid #f0f0f0; padding-top: 15px;">
                                <div class="d-flex align-items-center">
                                    @if($review->user && !empty(optional($review->user)->profile_photo_url))
                                    <img src="{{ $review->user->profile_photo_url }}" alt="{{ $review->names }}" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover; margin-right: 15px;">
                                    @else
                                    <div class="author-avatar" style="width: 50px; height: 50px; border-radius: 50%; background: linear-gradient(135deg, #25D366, #128C7E); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 20px; margin-right: 15px;">
                                        {{ strtoupper(substr($review->names ?? 'A', 0, 1)) }}
                                    </div>
                                    @endif
                                    <div>
                                        <h5 style="margin: 0; font-size: 16px; font-weight: 600; color: #333;">{{ $review->names ?? 'Anonymous' }}</h5>
                                        <p style="margin: 0; font-size: 13px; color: #999;">{{ $review->created_at->format('M d, Y') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                @empty
                <div class="col-12">
                    <div class="text-center py-5">
                        <p class="text-muted">No reviews yet. Be the first to share your experience!</p>
                        @auth
                        <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#aboutReviewModal" style="background: linear-gradient(135deg, #25D366, #128C7E); border: none;">Add Review & Rate Us (1-5)</button>
                        @else
                        <a href="{{ route('login') }}?redirect={{ urlencode(route('about') . '#reviews-sec') }}" class="btn btn-primary mt-3" style="background: linear-gradient(135deg, #25D366, #128C7E); border: none;">Login to Add Your Review</a>
                        @endauth
                    </div>
                </div>
                @endforelse
            </div>

            <div class="row mt-4">
                <div class="col-12 text-center">
                    <a href="{{ route('reviews.index') }}" class="btn btn-outline-primary">View All Reviews</a>
                </div>
            </div>
        </div>
    </section>

    @auth
    {{-- Review modal (same as reviews page) --}}
    <div class="modal fade" id="aboutReviewModal" tabindex="-1" aria-labelledby="aboutReviewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="aboutReviewModalLabel">Add Review & Rate Us (1-5 stars)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('reviews.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="about_names" class="form-label">Your Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="about_names" name="names" value="{{ auth()->user()->name ?? '' }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="about_email" class="form-label">Your Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="about_email" name="email" value="{{ auth()->user()->email ?? '' }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="about_rating" class="form-label">Rate the company (1-5 stars) <span class="text-danger">*</span></label>
                            <div class="rating-input">
                                @for($i = 5; $i >= 1; $i--)
                                <input type="radio" id="about_star{{ $i }}" name="rating" value="{{ $i }}" required>
                                <label for="about_star{{ $i }}" class="star-label"><i class="fas fa-star"></i></label>
                                @endfor
                            </div>
                            <small class="text-muted">Click a star to rate (1 = lowest, 5 = highest)</small>
                        </div>
                        <div class="mb-3">
                            <label for="about_testimony" class="form-label">Your Review <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="about_testimony" name="testimony" rows="5" required minlength="10"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="about_website" class="form-label">Website (Optional)</label>
                            <input type="text" class="form-control" id="about_website" name="website" placeholder="example.com">
                        </div>
                        <div class="mb-3">
                            <label for="about_images" class="form-label">Images (Optional)</label>
                            <input type="file" class="form-control" id="about_images" name="images[]" multiple accept="image/*">
                            <small class="text-muted">You can upload multiple images (max 5MB each)</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" style="background: linear-gradient(135deg, #25D366, #128C7E); border: none;">Submit Review</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endauth

<style>
.about-hero { min-height: 65vh; }
.about-hero-row { min-height: 65vh; }
.about-hero-text h1,
.about-hero-text .lead,
.about-hero-tagline { color: #fff !important; text-shadow: 0 1px 3px rgba(0,0,0,0.5); }
.about-hero-tagline { opacity: 0.95; }
.about-hero-bg {
    position: absolute;
    inset: 0;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
}
.about-hero-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to bottom, rgba(0,0,0,.4) 0%, rgba(0,0,0,.65) 100%);
}
.about-hero .container { z-index: 1; }
.about-intro, .about-what-we-do, .about-why-choose { font-size: 1.05rem; line-height: 1.7; }
.about-intro p, .about-what-we-do p, .about-why-choose p { margin-bottom: 1rem; }
.about-what-we-do ul, .about-why-choose ul { padding-left: 1.25rem; }
.about-what-we-do li, .about-why-choose li { margin-bottom: 0.5rem; }
/* Review modal rating stars (same as reviews page) */
.rating-input { display: flex; flex-direction: row-reverse; justify-content: flex-end; gap: 5px; }
.rating-input input[type="radio"] { display: none; }
.rating-input .star-label { cursor: pointer; font-size: 30px; color: #ddd; transition: color 0.2s; }
.rating-input input[type="radio"]:checked ~ .star-label,
.rating-input .star-label:hover,
.rating-input .star-label:hover ~ .star-label { color: #ffc107; }
</style>
@endsection
