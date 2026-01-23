@extends('layouts.frontbase')

@section('content')
<section class="position-relative overflow-hidden space-top space-extra-bottom" style="background: #f8f9fa;">
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-lg-8">
                <div class="title-area text-center">
                    <h2 class="sec-title">Customer Reviews & Testimonials</h2>
                    <p class="sec-text">Read what our customers have to say about their experiences</p>
                </div>
            </div>
        </div>

        @auth
        <div class="row mb-4">
            <div class="col-12 text-end">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#reviewModal" style="background: linear-gradient(135deg, #25D366, #128C7E); border: none; padding: 12px 30px; border-radius: 8px; font-weight: 600;">
                    <i class="fas fa-plus me-2"></i>Share Your Review
                </button>
            </div>
        </div>
        @endauth

        <div class="row gy-4">
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
                                    </div>
                                @endif
                                <p style="color: #666; font-size: 15px; line-height: 1.8; font-style: italic; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                                    {{ $review->testimony }}
                                </p>
                                @if($review->images->count() > 0)
                                    <div class="mt-2">
                                        <small class="text-muted">
                                            <i class="fas fa-images"></i> {{ $review->images->count() }} image(s)
                                        </small>
                                    </div>
                                @endif
                            </div>
                            <div class="review-author" style="border-top: 1px solid #f0f0f0; padding-top: 15px;">
                                <div class="d-flex align-items-center">
                                    @if($review->user && $review->user->profile_photo_url)
                                        <img src="{{ $review->user->profile_photo_url }}" alt="{{ $review->names }}" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover; margin-right: 15px;">
                                    @else
                                        <div class="author-avatar" style="width: 50px; height: 50px; border-radius: 50%; background: linear-gradient(135deg, #25D366, #128C7E); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 20px; margin-right: 15px;">
                                            {{ strtoupper(substr($review->names ?? 'A', 0, 1)) }}
                                        </div>
                                    @endif
                                    <div>
                                        <h5 style="margin: 0; font-size: 16px; font-weight: 600; color: #333;">
                                            {{ $review->names ?? 'Anonymous' }}
                                        </h5>
                                        <p style="margin: 0; font-size: 13px; color: #999;">
                                            {{ $review->created_at->format('M d, Y') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center py-5">
                        <p class="text-muted">No reviews available at the moment.</p>
                        @auth
                            <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#reviewModal" style="background: linear-gradient(135deg, #25D366, #128C7E); border: none;">
                                Be the first to share your review!
                            </button>
                        @endauth
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($reviews->hasPages())
            <div class="row mt-5">
                <div class="col-12">
                    <div class="d-flex justify-content-center">
                        {{ $reviews->links() }}
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>

@auth
<!-- Review Submission Modal -->
<div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reviewModalLabel">Share Your Review</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="reviewForm" action="{{ route('reviews.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="names" class="form-label">Your Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="names" name="names" value="{{ auth()->user()->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Your Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ auth()->user()->email }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="rating" class="form-label">Rating <span class="text-danger">*</span></label>
                        <div class="rating-input">
                            @for($i = 5; $i >= 1; $i--)
                                <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" required>
                                <label for="star{{ $i }}" class="star-label">
                                    <i class="fas fa-star"></i>
                                </label>
                            @endfor
                        </div>
                        <small class="text-muted">Click a star to rate (1-5)</small>
                    </div>
                    <div class="mb-3">
                        <label for="testimony" class="form-label">Your Review <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="testimony" name="testimony" rows="5" required minlength="10"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="website" class="form-label">Website (Optional)</label>
                        <input type="url" class="form-control" id="website" name="website" placeholder="https://example.com">
                    </div>
                    <div class="mb-3">
                        <label for="images" class="form-label">Images (Optional)</label>
                        <input type="file" class="form-control" id="images" name="images[]" multiple accept="image/*">
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

<style>
.rating-input {
    display: flex;
    flex-direction: row-reverse;
    justify-content: flex-end;
    gap: 5px;
}
.rating-input input[type="radio"] {
    display: none;
}
.rating-input .star-label {
    cursor: pointer;
    font-size: 30px;
    color: #ddd;
    transition: color 0.2s;
}
.rating-input input[type="radio"]:checked ~ .star-label,
.rating-input .star-label:hover,
.rating-input .star-label:hover ~ .star-label {
    color: #ffc107;
}
</style>
@endauth
@endsection



