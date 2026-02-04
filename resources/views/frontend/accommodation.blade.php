@extends('layouts.frontbase')

@section('content')
<style>
    /* Booking.com Style Layout */
    .property-header-section {
        margin-bottom: 30px;
    }
    .property-title {
        font-size: 28px;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 10px;
        line-height: 1.3;
    }
    .property-location {
        color: #0071c2;
        font-size: 14px;
        margin-bottom: 15px;
    }
    .property-location:hover {
        text-decoration: underline;
    }
    .property-rating-badge {
        display: inline-flex;
        align-items: center;
        background: #003580;
        color: white;
        padding: 8px 12px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 16px;
        margin-bottom: 20px;
    }
    .property-rating-badge .rating-score {
        font-size: 20px;
        margin-right: 8px;
    }
    
    /* Image Gallery */
    .image-gallery-main {
        position: relative;
        width: 100%;
        height: 500px;
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 10px;
        background: #f0f0f0;
    }
    .image-gallery-main img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .image-gallery-thumbs {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 10px;
    }
    .gallery-thumb {
        position: relative;
        height: 120px;
        border-radius: 8px;
        overflow: hidden;
        cursor: pointer;
        opacity: 0.8;
        transition: opacity 0.3s;
    }
    .gallery-thumb:hover {
        opacity: 1;
    }
    .gallery-thumb.active {
        opacity: 1;
        border: 3px solid #0071c2;
    }
    .gallery-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .gallery-overlay {
        position: absolute;
        bottom: 15px;
        right: 15px;
        background: rgba(0,0,0,0.7);
        color: white;
        padding: 8px 15px;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
    }
    
    /* Content Sections */
    .content-section {
        background: white;
        border-radius: 12px;
        padding: 30px;
        margin-bottom: 30px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }
    .section-title {
        font-size: 22px;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 2px solid #f0f0f0;
    }
    
    /* Facilities Grid */
    .facilities-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-top: 20px;
    }
    .facility-item {
        display: flex;
        align-items: center;
        padding: 12px;
        background: #f8f9fa;
        border-radius: 8px;
    }
    .facility-item i {
        color: #0071c2;
        margin-right: 12px;
        font-size: 18px;
        width: 24px;
    }
    
    /* Rooms Availability Table */
    .rooms-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }
    .rooms-table thead {
        background: #f8f9fa;
    }
    .rooms-table th {
        padding: 15px;
        text-align: left;
        font-weight: 600;
        color: #1a1a1a;
        border-bottom: 2px solid #e0e0e0;
    }
    .rooms-table td {
        padding: 20px 15px;
        border-bottom: 1px solid #f0f0f0;
        vertical-align: middle;
    }
    .rooms-table tr:hover {
        background: #f8f9fa;
    }
    .room-type-name {
        font-weight: 600;
        color: #1a1a1a;
        margin-bottom: 5px;
    }
    .room-type-details {
        font-size: 13px;
        color: #666;
    }
    .room-price {
        font-size: 20px;
        font-weight: 700;
        color: #1a1a1a;
    }
    .room-price-label {
        font-size: 12px;
        color: #666;
        margin-top: 3px;
    }
    .room-availability {
        font-size: 14px;
        color: #0b7a3a;
        font-weight: 600;
    }
    .room-availability.unavailable {
        color: #d32f2f;
    }
    .btn-book-room {
        background: #0071c2;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 6px;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.3s;
    }
    .btn-book-room:hover {
        background: #005a9e;
    }
    .btn-book-room:disabled {
        background: #ccc;
        cursor: not-allowed;
    }
    
    /* Right Sidebar */
    .sidebar-sticky {
        position: sticky;
        top: 20px;
    }
    .reserve-box {
        background: white;
        border: 2px solid #0071c2;
        border-radius: 12px;
        padding: 25px;
        margin-bottom: 30px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    .reserve-box-header {
        text-align: center;
        margin-bottom: 20px;
    }
    .reserve-box-price {
        font-size: 32px;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 5px;
    }
    .reserve-box-price-label {
        font-size: 14px;
        color: #666;
    }
    .reserve-form-group {
        margin-bottom: 20px;
    }
    .reserve-form-group label {
        display: block;
        font-weight: 600;
        color: #1a1a1a;
        margin-bottom: 8px;
        font-size: 14px;
    }
    .reserve-form-group input,
    .reserve-form-group select {
        width: 100%;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 14px;
    }
    .reserve-form-group input:focus,
    .reserve-form-group select:focus {
        outline: none;
        border-color: #0071c2;
    }
    .btn-reserve {
        width: 100%;
        background: #0071c2;
        color: white;
        border: none;
        padding: 15px;
        border-radius: 6px;
        font-size: 16px;
        font-weight: 700;
        cursor: pointer;
        transition: background 0.3s;
        margin-top: 10px;
    }
    .btn-reserve:hover {
        background: #005a9e;
    }
    .btn-reserve:disabled {
        background: #ccc;
        cursor: not-allowed;
    }
    
    /* Reviews Section */
    .reviews-summary {
        background: white;
        border-radius: 12px;
        padding: 25px;
        margin-bottom: 30px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }
    .reviews-score {
        text-align: center;
        margin-bottom: 20px;
    }
    .reviews-score-number {
        font-size: 48px;
        font-weight: 700;
        color: #1a1a1a;
        line-height: 1;
    }
    .reviews-score-label {
        font-size: 14px;
        color: #666;
        margin-top: 5px;
    }
    .review-item {
        padding: 15px 0;
        border-bottom: 1px solid #f0f0f0;
    }
    .review-item:last-child {
        border-bottom: none;
    }
    .review-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 8px;
    }
    .review-author {
        font-weight: 600;
        color: #1a1a1a;
    }
    .review-date {
        font-size: 12px;
        color: #666;
    }
    .review-text {
        font-size: 14px;
        color: #333;
        line-height: 1.6;
    }
    
    /* Map Section */
    .map-container {
        background: white;
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }
    .map-wrapper {
        height: 300px;
        border-radius: 8px;
        overflow: hidden;
        margin-top: 15px;
    }
    .map-wrapper iframe {
        width: 100%;
        height: 100%;
        border: none;
    }
    
    /* Mobile Responsive */
    @media (max-width: 991px) {
        .image-gallery-main {
            height: 300px;
        }
        .image-gallery-thumbs {
            grid-template-columns: repeat(3, 1fr);
        }
        .sidebar-sticky {
            position: relative;
            top: 0;
        }
        .rooms-table {
            font-size: 14px;
        }
        .rooms-table th,
        .rooms-table td {
            padding: 12px 8px;
        }
        .room-price {
            font-size: 18px;
        }
    }
    @media (max-width: 767px) {
        .property-title {
            font-size: 24px;
        }
        .image-gallery-thumbs {
            grid-template-columns: repeat(2, 1fr);
        }
        .facilities-grid {
            grid-template-columns: 1fr;
        }
        .rooms-table {
            display: block;
            overflow-x: auto;
        }
    }
</style>

<div class="container-fluid py-4" style="max-width: 1400px;">
    <!-- Property Header -->
    <div class="property-header-section">
        <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
            <div>
                <h1 class="property-title">{{ $hotel->name }}</h1>
                <div class="property-location">
                    <i class="fas fa-map-marker-alt"></i>
                    {{ $hotel->location ?? $hotel->city ?? $hotel->address }}
                    @if($hotel->category)
                        <span class="text-muted">• {{ $hotel->category->name }}</span>
                    @endif
                </div>
                @if($hotel->stars)
                    @php
                        $stars = (int) filter_var($hotel->stars, FILTER_SANITIZE_NUMBER_INT);
                        $stars = max(0, min(5, $stars));
                    @endphp
                    <div class="mb-2">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $stars)
                                <i class="fa-solid fa-star text-warning"></i>
                            @else
                                <i class="fa-regular fa-star text-warning"></i>
                            @endif
                        @endfor
                        <span class="ms-2">{{ $stars }} {{ $stars == 1 ? 'Star' : 'Stars' }}</span>
                    </div>
                @endif
            </div>
            @if($hotel->average_rating > 0)
                <div class="property-rating-badge">
                    <span class="rating-score">{{ number_format($hotel->average_rating, 1) }}</span>
                    <div>
                        <div class="star-rating">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= round($hotel->average_rating))
                                    <i class="fa-solid fa-star" style="font-size: 14px;"></i>
                                @else
                                    <i class="fa-regular fa-star" style="font-size: 14px;"></i>
                                @endif
                            @endfor
                        </div>
                        <div style="font-size: 12px; margin-top: 3px;">{{ $hotel->total_reviews }} {{ $hotel->total_reviews == 1 ? 'review' : 'reviews' }}</div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div class="row">
        <!-- Left Column -->
        <div class="col-lg-8">
            <!-- Image Gallery -->
            @php
                $allImages = collect();
                if($hotel->images->isNotEmpty()) {
                    $allImages = $hotel->images->map(function($img) {
                        return asset('storage/' . $img->image_path);
                    });
                } elseif($hotel->featured_image) {
                    $allImages = collect([asset('storage/images/properties/' . $hotel->featured_image)]);
                } else {
                    $allImages = collect([asset('assets/img/tour/tour_3_1.jpg')]);
                }
                $mainImage = $allImages->first();
            @endphp
            
            <div class="content-section">
                <div class="image-gallery-main">
                    <img src="{{ $mainImage }}" alt="{{ $hotel->name }}" id="mainGalleryImage">
                    @if($allImages->count() > 1)
                        <div class="gallery-overlay" onclick="openGalleryModal()">
                            <i class="fas fa-images"></i> View all {{ $allImages->count() }} photos
                        </div>
                    @endif
                </div>
                @if($allImages->count() > 1)
                    <div class="image-gallery-thumbs">
                        @foreach($allImages->take(4) as $index => $thumb)
                            <div class="gallery-thumb {{ $index == 0 ? 'active' : '' }}" onclick="changeMainImage('{{ $thumb }}', this)">
                                <img src="{{ $thumb }}" alt="Gallery thumbnail">
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Description -->
            <div class="content-section">
                <h2 class="section-title">About this property</h2>
                <div class="property-description">
                    {!! $hotel->description ?? '<p class="text-muted">No description available.</p>' !!}
                </div>
            </div>

            <!-- Facilities -->
            @if($hotel->facilities->isNotEmpty())
                <div class="content-section">
                    <h2 class="section-title">Most popular facilities</h2>
                    <div class="facilities-grid">
                        @foreach($hotel->facilities->take(12) as $facility)
                            <div class="facility-item">
                                <i class="{{ $facility->icon ?? 'fas fa-check-circle' }}"></i>
                                <span>{{ $facility->title }}</span>
                            </div>
                        @endforeach
                    </div>
                    @if($hotel->facilities->count() > 12)
                        <p class="text-muted mt-3">
                            <a href="#all-facilities" class="text-primary">View all {{ $hotel->facilities->count() }} facilities</a>
                        </p>
                    @endif
                </div>
            @endif

            <!-- Rooms Availability Table -->
            @if($rooms->isNotEmpty())
                <div class="content-section">
                    <h2 class="section-title">Available {{ $hotel->property_type == 'hotel' ? 'Rooms' : 'Units' }}</h2>
                    <div class="table-responsive">
                        <table class="rooms-table">
                            <thead>
                                <tr>
                                    <th>Room Type</th>
                                    <th>Price per night</th>
                                    <th>Availability</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($rooms as $unit)
                                    @php
                                        $unitImage = $unit->images->where('is_primary', true)->first() ?? $unit->images->first();
                                        $unitImagePath = $unitImage ? asset('storage/' . $unitImage->image_path) : 
                                                        ($unit->featured_image ? asset('storage/images/units/' . $unit->featured_image) : 
                                                        asset('assets/img/tour/tour_3_1.jpg'));
                                    @endphp
                                    <tr>
                                        <td>
                                            <div class="room-type-name">{{ $unit->name ?? 'Unit ' . $unit->id }}</div>
                                            <div class="room-type-details">
                                                @if($unit->max_occupancy)
                                                    <i class="fas fa-users"></i> {{ $unit->max_occupancy }} guests
                                                @endif
                                                @if($unit->bedrooms)
                                                    <span class="ms-2"><i class="fas fa-bed"></i> {{ $unit->bedrooms }} {{ $unit->bedrooms == 1 ? 'bedroom' : 'bedrooms' }}</span>
                                                @endif
                                                @if($unit->bathrooms)
                                                    <span class="ms-2"><i class="fas fa-bath"></i> {{ $unit->bathrooms }} {{ $unit->bathrooms == 1 ? 'bathroom' : 'bathrooms' }}</span>
                                                @endif
                                                @if($unit->size_sqm)
                                                    <span class="ms-2"><i class="fas fa-ruler-combined"></i> {{ $unit->size_sqm }} m²</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <div class="room-price">${{ number_format($unit->base_price_per_night ?? 0, 0) }}</div>
                                            <div class="room-price-label">per night</div>
                                        </td>
                                        <td>
                                            @if($unit->available_units > 0)
                                                <div class="room-availability">
                                                    <i class="fas fa-check-circle"></i> {{ $unit->available_units }} {{ $unit->available_units == 1 ? 'room' : 'rooms' }} available
                                                </div>
                                            @else
                                                <div class="room-availability unavailable">
                                                    <i class="fas fa-times-circle"></i> Not available
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            @if($unit->available_units > 0)
                                                <button class="btn-book-room" onclick="selectRoom({{ $unit->id }}, {{ $unit->base_price_per_night ?? 0 }}, '{{ $unit->name ?? 'Unit ' . $unit->id }}')">
                                                    Select room
                                                </button>
                                            @else
                                                <button class="btn-book-room" disabled>Unavailable</button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <div class="content-section">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>No {{ $hotel->property_type == 'hotel' ? 'rooms' : 'units' }} available at the moment.
                    </div>
                </div>
            @endif
        </div>

        <!-- Right Column -->
        <div class="col-lg-4">
            <div class="sidebar-sticky">
                <!-- Reserve Box -->
                <div class="reserve-box" id="reserveBox">
                    <div class="reserve-box-header">
                        <div class="reserve-box-price" id="reservePrice">
                            @if($hotel->min_price)
                                ${{ number_format($hotel->min_price, 0) }}
                            @elseif($rooms->isNotEmpty())
                                ${{ number_format($rooms->first()->base_price_per_night ?? 0, 0) }}
                            @else
                                $0
                            @endif
                        </div>
                        <div class="reserve-box-price-label">per night</div>
                    </div>
                    
                    <form action="{{ route('bookings.store') }}" method="POST" id="bookingForm">
                        @csrf
                        <input type="hidden" name="property_id" value="{{ $hotel->id }}" id="bookingPropertyId">
                        <input type="hidden" name="unit_id" value="" id="bookingUnitId">
                        
                        <div class="reserve-form-group">
                            <label for="check_in">Check-in date</label>
                            <input type="date" name="check_in" id="check_in" class="form-control" required min="{{ date('Y-m-d') }}" onchange="calculateTotal()">
                        </div>
                        
                        <div class="reserve-form-group">
                            <label for="check_out">Check-out date</label>
                            <input type="date" name="check_out" id="check_out" class="form-control" required min="{{ date('Y-m-d', strtotime('+1 day')) }}" onchange="calculateTotal()">
                        </div>
                        
                        <div class="reserve-form-group">
                            <label for="guests_count">Number of guests</label>
                            <select name="guests_count" id="guests_count" class="form-control" required>
                                @for($i = 1; $i <= 10; $i++)
                                    <option value="{{ $i }}">{{ $i }} {{ $i == 1 ? 'guest' : 'guests' }}</option>
                                @endfor
                            </select>
                        </div>

                        <div class="reserve-form-group">
                            <label for="guest_name">Guest full name</label>
                            <input type="text" name="guest_name" id="guest_name" class="form-control" required>
                        </div>

                        <div class="reserve-form-group">
                            <label for="guest_email">Guest email</label>
                            <input type="email" name="guest_email" id="guest_email" class="form-control" required>
                        </div>

                        <div class="reserve-form-group">
                            <label for="guest_country">Country</label>
                            <input type="text" name="guest_country" id="guest_country" class="form-control">
                        </div>

                        <div class="reserve-form-group">
                            <label for="guest_phone">Phone</label>
                            <input type="text" name="guest_phone" id="guest_phone" class="form-control">
                        </div>

                        <div class="reserve-form-group">
                            <label for="special_requests">Special requests (optional)</label>
                            <textarea name="special_requests" id="special_requests" rows="3" class="form-control" placeholder="E.g. late arrival, dietary needs, extra bed"></textarea>
                        </div>
                        
                        <div class="reserve-form-group">
                            <div style="background: #f8f9fa; padding: 15px; border-radius: 6px;">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Price per night:</span>
                                    <span id="pricePerNight">${{ number_format($hotel->min_price ?? ($rooms->first()->base_price_per_night ?? 0), 0) }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Number of nights:</span>
                                    <span id="numberOfNights">-</span>
                                </div>
                                <hr style="margin: 10px 0;">
                                <div class="d-flex justify-content-between" style="font-weight: 700; font-size: 18px;">
                                    <span>Total:</span>
                                    <span id="totalAmount">$0</span>
                                </div>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn-reserve" id="btnReserve" disabled>
                            <i class="fas fa-calendar-check me-2"></i>Request Availability
                        </button>

                        <p class="text-center mt-2" style="font-size: 12px; color: #666;">
                            We will check availability and get back to you by email. <br>
                            <a href="{{ route('login') }}">Login</a> or <a href="{{ route('register') }}">create an account</a> to manage your bookings.
                        </p>
                    </form>
                </div>

                <!-- Reviews & Ratings -->
                @if($hotel->reviews->isNotEmpty())
                    <div class="reviews-summary">
                        <h3 class="section-title" style="font-size: 20px; margin-bottom: 20px;">Guest reviews</h3>
                        <div class="reviews-score">
                            <div class="reviews-score-number">{{ number_format($hotel->average_rating, 1) }}</div>
                            <div class="star-rating mb-2">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= round($hotel->average_rating))
                                        <i class="fa-solid fa-star text-warning"></i>
                                    @else
                                        <i class="fa-regular fa-star text-warning"></i>
                                    @endif
                                @endfor
                            </div>
                            <div class="reviews-score-label">{{ $hotel->total_reviews }} {{ $hotel->total_reviews == 1 ? 'review' : 'reviews' }}</div>
                        </div>
                        
                        <div class="reviews-list">
                            @foreach($hotel->reviews->take(3) as $review)
                                <div class="review-item">
                                    <div class="review-header">
                                        <span class="review-author">{{ $review->user->name ?? 'Anonymous' }}</span>
                                        <div>
                                            <div class="star-rating" style="display: inline-block;">
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= $review->rating)
                                                        <i class="fa-solid fa-star text-warning" style="font-size: 12px;"></i>
                                                    @else
                                                        <i class="fa-regular fa-star text-warning" style="font-size: 12px;"></i>
                                                    @endif
                                                @endfor
                                            </div>
                                            <span class="review-date ms-2">{{ $review->created_at->format('M Y') }}</span>
                                        </div>
                                    </div>
                                    <div class="review-text">{{ Str::limit($review->comment, 150) }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Map -->
                @if($hotel->map_embed_code || ($hotel->latitude && $hotel->longitude) || ($hotel->address || $hotel->location || $hotel->city))
                    <div class="map-container">
                        <h3 class="section-title" style="font-size: 20px; margin-bottom: 15px;">Property surroundings</h3>
                        <div class="map-wrapper">
                            @if($hotel->map_embed_code)
                                @php
                                    // Process the embed code to ensure it fits our container
                                    $embedCode = trim($hotel->map_embed_code);
                                    
                                    // Extract iframe if it's wrapped in other tags
                                    if (preg_match('/<iframe[^>]*>.*?<\/iframe>/is', $embedCode, $matches)) {
                                        $embedCode = $matches[0];
                                    }
                                    
                                    // Remove width and height attributes to let CSS handle sizing
                                    $embedCode = preg_replace('/\s*width\s*=\s*["\'][^"\']*["\']/i', '', $embedCode);
                                    $embedCode = preg_replace('/\s*height\s*=\s*["\'][^"\']*["\']/i', '', $embedCode);
                                    
                                    // Update or add style attribute
                                    if (preg_match('/style\s*=\s*["\']([^"\']*)["\']/i', $embedCode, $styleMatches)) {
                                        $existingStyle = $styleMatches[1];
                                        // Remove width/height from existing style
                                        $existingStyle = preg_replace('/width\s*:\s*[^;]+;?/i', '', $existingStyle);
                                        $existingStyle = preg_replace('/height\s*:\s*[^;]+;?/i', '', $existingStyle);
                                        $newStyle = trim($existingStyle, '; ') . '; width:100%;height:100%;border:0;';
                                        $embedCode = preg_replace('/style\s*=\s*["\'][^"\']*["\']/i', 'style="' . $newStyle . '"', $embedCode);
                                    } else {
                                        // Add style attribute if it doesn't exist
                                        $embedCode = preg_replace('/(<iframe[^>]*)(>)/i', '$1 style="width:100%;height:100%;border:0;"$2', $embedCode);
                                    }
                                @endphp
                                {!! $embedCode !!}
                            @elseif($hotel->latitude && $hotel->longitude)
                                <iframe
                                    src="https://www.google.com/maps?q={{ $hotel->latitude }},{{ $hotel->longitude }}&hl=en&z=14&output=embed"
                                    width="100%"
                                    height="100%"
                                    style="border:0;"
                                    allowfullscreen>
                                </iframe>
                            @elseif($hotel->address || $hotel->location || $hotel->city)
                                @php
                                    $address = $hotel->address ?? $hotel->location ?? $hotel->city;
                                    $encodedAddress = urlencode($address);
                                @endphp
                                <iframe
                                    src="https://www.google.com/maps?q={{ $encodedAddress }}&hl=en&z=14&output=embed"
                                    width="100%"
                                    height="100%"
                                    style="border:0;"
                                    allowfullscreen>
                                </iframe>
                            @endif
                        </div>
                        @if($hotel->address || $hotel->location || $hotel->city)
                            <p class="text-muted mt-3" style="font-size: 13px;">
                                <i class="fas fa-map-marker-alt me-2"></i>{{ $hotel->address ?? $hotel->location ?? $hotel->city }}
                            </p>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Gallery Modal -->
<div class="modal fade" id="galleryModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Photo Gallery</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    @foreach($allImages as $img)
                        <div class="col-md-3">
                            <img src="{{ $img }}" alt="Gallery" class="img-fluid rounded" style="cursor: pointer;" onclick="changeMainImage('{{ $img }}', null)">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let selectedUnitId = null;
    let selectedUnitPrice = {{ $hotel->min_price ?? ($rooms->first()->base_price_per_night ?? 0) }};
    let selectedUnitName = '{{ $rooms->first()->name ?? "Unit" }}';
    
    function changeMainImage(src, thumbElement) {
        document.getElementById('mainGalleryImage').src = src;
        if (thumbElement) {
            document.querySelectorAll('.gallery-thumb').forEach(el => el.classList.remove('active'));
            thumbElement.classList.add('active');
        }
    }
    
    function openGalleryModal() {
        const modal = new bootstrap.Modal(document.getElementById('galleryModal'));
        modal.show();
    }
    
    function selectRoom(unitId, price, name) {
        selectedUnitId = unitId;
        selectedUnitPrice = price;
        selectedUnitName = name;
        
        document.getElementById('bookingUnitId').value = unitId;
        document.getElementById('reservePrice').textContent = '$' + price.toLocaleString();
        document.getElementById('pricePerNight').textContent = '$' + price.toLocaleString();
        document.getElementById('btnReserve').disabled = false;
        
        // Scroll to reserve box
        document.getElementById('reserveBox').scrollIntoView({ behavior: 'smooth', block: 'start' });
        
        // Highlight selected room in table
        document.querySelectorAll('.rooms-table tr').forEach(tr => {
            tr.style.background = '';
        });
        event.target.closest('tr').style.background = '#e3f2fd';
        
        calculateTotal();
    }
    
    function calculateTotal() {
        const checkIn = document.getElementById('check_in').value;
        const checkOut = document.getElementById('check_out').value;
        const pricePerNight = selectedUnitPrice;
        
        if (checkIn && checkOut && pricePerNight > 0) {
            const date1 = new Date(checkIn);
            const date2 = new Date(checkOut);
            
            if (date2 > date1) {
                const diffTime = Math.abs(date2 - date1);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                
                document.getElementById('numberOfNights').textContent = diffDays + ' ' + (diffDays == 1 ? 'night' : 'nights');
                document.getElementById('totalAmount').textContent = '$' + (pricePerNight * diffDays).toLocaleString();
                
                if (selectedUnitId) {
                    document.getElementById('btnReserve').disabled = false;
                }
            } else {
                document.getElementById('numberOfNights').textContent = '-';
                document.getElementById('totalAmount').textContent = '$0';
                document.getElementById('btnReserve').disabled = true;
            }
        } else {
            document.getElementById('numberOfNights').textContent = '-';
            document.getElementById('totalAmount').textContent = '$0';
            document.getElementById('btnReserve').disabled = true;
        }
    }
    
    // Auto-select first available room if none selected
    @if($rooms->isNotEmpty() && $rooms->first()->available_units > 0)
        document.addEventListener('DOMContentLoaded', function() {
            const firstAvailableRoom = document.querySelector('.btn-book-room:not(:disabled)');
            if (firstAvailableRoom) {
                const row = firstAvailableRoom.closest('tr');
                const unitId = {{ $rooms->first()->id }};
                const price = {{ $rooms->first()->base_price_per_night ?? 0 }};
                const name = '{{ addslashes($rooms->first()->name ?? "Unit") }}';
                selectRoom(unitId, price, name);
            }
        });
    @endif
    
    // Form validation: ensure a room/unit is selected before submit
    document.getElementById('bookingForm').addEventListener('submit', function(e) {
        if (!selectedUnitId) {
            e.preventDefault();
            alert('Please select a room first');
            return false;
        }
    });
</script>

<!-- Booking Login/Register Modal -->
<div class="modal fade" id="bookingLoginModal" tabindex="-1" aria-labelledby="bookingLoginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 12px; overflow: hidden;">
            <div class="modal-header" style="background: linear-gradient(135deg, #0071c2, #005a9e); color: white; border: none;">
                <h5 class="modal-title" id="bookingLoginModalLabel">
                    <i class="fas fa-lock me-2"></i>Login Required
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding: 30px;">
                <p class="text-center mb-4" style="color: #666;">
                    Please login or create an account to complete your booking
                </p>
                
                <!-- Tab Navigation -->
                <ul class="nav nav-tabs mb-4" id="bookingAuthTabs" role="tablist" style="border-bottom: 2px solid #e0e0e0;">
                    <li class="nav-item" role="presentation" style="flex: 1;">
                        <button class="nav-link active w-100" id="booking-login-tab" data-bs-toggle="tab" data-bs-target="#booking-login" type="button" role="tab" aria-controls="booking-login" aria-selected="true" style="border: none; border-bottom: 3px solid #0071c2; color: #0071c2; font-weight: 600; padding: 12px;">
                            <i class="fas fa-sign-in-alt me-2"></i>Login
                        </button>
                    </li>
                    <li class="nav-item" role="presentation" style="flex: 1;">
                        <button class="nav-link w-100" id="booking-register-tab" data-bs-toggle="tab" data-bs-target="#booking-register" type="button" role="tab" aria-controls="booking-register" aria-selected="false" style="border: none; color: #666; font-weight: 600; padding: 12px;">
                            <i class="fas fa-user-plus me-2"></i>Create Account
                        </button>
                    </li>
                </ul>

                <!-- Tab Content -->
                <div class="tab-content" id="bookingAuthTabContent">
                    <!-- Login Tab -->
                    <div class="tab-pane fade show active" id="booking-login" role="tabpanel" aria-labelledby="booking-login-tab">
                        <form id="booking-login-form" method="POST" action="{{ route('login') }}">
                            @csrf
                            <input type="hidden" name="redirect_after_login" value="{{ url()->current() }}">

                            <div class="mb-3">
                                <label for="booking-login-email" class="form-label">
                                    <i class="fas fa-envelope me-2"></i>Email Address
                                </label>
                                <input type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" 
                                       id="booking-login-email" name="email" value="{{ old('email') }}" 
                                       placeholder="Enter your email" required autofocus>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="booking-login-password" class="form-label">
                                    <i class="fas fa-lock me-2"></i>Password
                                </label>
                                <div class="position-relative">
                                    <input type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" 
                                           id="booking-login-password" name="password" 
                                           placeholder="Enter your password" required>
                                    <button type="button" class="btn btn-sm position-absolute end-0 top-50 translate-middle-y me-2" 
                                            onclick="toggleBookingPassword('booking-login-password')" style="border: none; background: none; color: #666;">
                                        <i class="fas fa-eye" id="booking-login-password-eye"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 d-flex justify-content-between align-items-center">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="booking-remember">
                                    <label class="form-check-label" for="booking-remember">
                                        Remember me
                                    </label>
                                </div>
                                <a href="{{ route('password.request') }}" class="text-decoration-none" style="color: #0071c2; font-size: 14px;">
                                    Forgot password?
                                </a>
                            </div>

                            <div id="booking-login-message" class="mb-3"></div>

                            <button type="submit" class="btn w-100" style="background: linear-gradient(135deg, #0071c2, #005a9e); color: white; padding: 12px; font-weight: 600; border-radius: 8px;">
                                <i class="fas fa-sign-in-alt me-2"></i>Sign In
                            </button>
                        </form>
                    </div>

                    <!-- Register Tab -->
                    <div class="tab-pane fade" id="booking-register" role="tabpanel" aria-labelledby="booking-register-tab">
                        <div class="alert alert-info mb-3" style="font-size: 13px; padding: 12px;">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Important:</strong> After creating your account, you must verify your email address before you can complete your booking. A verification link will be sent to your email.
                        </div>
                        <form id="booking-register-form" method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="booking-register-name" class="form-label">
                                    <i class="fas fa-user me-2"></i>Full Name
                                </label>
                                <input type="text" class="form-control form-control-lg @error('name') is-invalid @enderror" 
                                       id="booking-register-name" name="name" value="{{ old('name') }}" 
                                       placeholder="Enter your full name" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="booking-register-email" class="form-label">
                                    <i class="fas fa-envelope me-2"></i>Email Address
                                </label>
                                <input type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" 
                                       id="booking-register-email" name="email" value="{{ old('email') }}" 
                                       placeholder="Enter your email" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="booking-register-password" class="form-label">
                                    <i class="fas fa-lock me-2"></i>Password
                                </label>
                                <div class="position-relative">
                                    <input type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" 
                                           id="booking-register-password" name="password" 
                                           placeholder="Create a password (min. 8 characters)" required>
                                    <button type="button" class="btn btn-sm position-absolute end-0 top-50 translate-middle-y me-2" 
                                            onclick="toggleBookingPassword('booking-register-password')" style="border: none; background: none; color: #666;">
                                        <i class="fas fa-eye" id="booking-register-password-eye"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Must be at least 8 characters</small>
                            </div>

                            <div class="mb-3">
                                <label for="booking-register-password-confirm" class="form-label">
                                    <i class="fas fa-lock me-2"></i>Confirm Password
                                </label>
                                <div class="position-relative">
                                    <input type="password" class="form-control form-control-lg" 
                                           id="booking-register-password-confirm" name="password_confirmation" 
                                           placeholder="Confirm your password" required>
                                    <button type="button" class="btn btn-sm position-absolute end-0 top-50 translate-middle-y me-2" 
                                            onclick="toggleBookingPassword('booking-register-password-confirm')" style="border: none; background: none; color: #666;">
                                        <i class="fas fa-eye" id="booking-register-password-confirm-eye"></i>
                                    </button>
                                </div>
                            </div>

                            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="terms" id="booking-terms" required>
                                        <label class="form-check-label" for="booking-terms">
                                            I agree to the <a href="{{ route('terms.show') }}" target="_blank" style="color: #0071c2;">Terms of Service</a> and <a href="{{ route('policy.show') }}" target="_blank" style="color: #0071c2;">Privacy Policy</a>
                                        </label>
                                    </div>
                                </div>
                            @endif

                            <div id="booking-register-message" class="mb-3"></div>

                            <button type="submit" class="btn w-100" style="background: linear-gradient(135deg, #0071c2, #005a9e); color: white; padding: 12px; font-weight: 600; border-radius: 8px;">
                                <i class="fas fa-user-plus me-2"></i>Create Account
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
