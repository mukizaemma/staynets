
@extends('layouts.frontbase')

@section('content')
    <!--==============================
Hero Area
==============================-->
    <div class="th-hero-wrapper hero-7" id="hero" data-bg-src="{{ asset('storage/images/about') . $about->image1 }}" style="min-height: 500px; max-height: 600px; background-size: cover; background-position: center; position: relative; overflow: hidden;">
        <!-- Hero Overlay for better text readability - Lighter overlay -->
        <div style="position: absolute; inset: 0; background: linear-gradient(180deg, rgba(0,0,0,0.2) 0%, rgba(0,0,0,0.4) 100%); z-index: 1;"></div>
        
        <div class="container" style="position: relative; z-index: 2;">
            <div class="row">
                <div class="col-12">
                    <div class="hero-style7" style="padding: 100px 0 30px 0;">
                        <span class="sub-title style1 text-white mb-20">Welcome to <strong>{{ $setting->company }}</strong></span>
                        <h1 class="hero-title text-white">Your Travel Booking Partner</h1>
                        <div class="btn-group mb-4">
                            <a href="{{ route('hotels') }}" class="th-btn th-icon style3">Hotels</a>
                            <a href="{{ route('apartments') }}" class="th-btn style2 th-icon">Apartments</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Horizontal Search Form - Clean & Minimal -->
            <div class="row">
                <div class="col-12">
                    <form action="{{ route('hotelsSearch') }}" method="GET" class="hero-form" id="heroSearchForm" style="background: rgba(0, 0, 0, 0.25); backdrop-filter: blur(18px); -webkit-backdrop-filter: blur(18px); border-radius: 999px; padding: 12px 18px; margin-top: 20px;">
                        <div class="row g-2 align-items-center justify-content-center">
                            <!-- Destination/Location -->
                            <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6">
                                <div class="form-item position-relative">
                                    <i class="fas fa-map-marker-alt position-absolute" style="left: 10px; top: 50%; transform: translateY(-50%); color: rgba(255,255,255,0.85); z-index: 10; pointer-events: none; font-size: 14px;"></i>
                                    <select name="location" class="form-select form-select-sm"
                                            style="background: transparent; border: none; border-bottom: 1px solid rgba(255,255,255,0.6); border-radius: 0; padding-left: 30px; padding-right: 4px; color: #fff; height: 40px; font-size: 14px;"
                                            title="Destination"
                                            onchange="this.style.color='white'">
                                        <option value="" style="color: #333;">All Destinations</option>
                                        @foreach($locations as $location)
                                            <option value="{{ $location }}" {{ request('location') == $location ? 'selected' : '' }} style="color:#333;">
                                                {{ $location }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Check In Date -->
                            <div class="col-xl-2 col-lg-2 col-md-3 col-sm-6">
                                <div class="form-item position-relative">
                                    <i class="fas fa-calendar-check position-absolute" style="left: 10px; top: 50%; transform: translateY(-50%); color: rgba(255,255,255,0.85); z-index: 10; pointer-events: none; font-size: 14px;"></i>
                                    <input type="date"
                                           class="form-control form-control-sm"
                                           name="checkin"
                                           id="checkinDate"
                                           value="{{ request('checkin') }}"
                                           min="{{ date('Y-m-d') }}"
                                           
                                           style="background: transparent; border: none; border-bottom: 1px solid rgba(255,255,255,0.6); border-radius: 0; padding-left: 30px; color: #fff; height: 40px; font-size: 14px;"
                                           title="Check In Date">
                                </div>
                            </div>

                            <!-- Check Out Date -->
                            <div class="col-xl-2 col-lg-2 col-md-3 col-sm-6">
                                <div class="form-item position-relative">
                                    <i class="fas fa-calendar-times position-absolute" style="left: 10px; top: 50%; transform: translateY(-50%); color: rgba(255,255,255,0.85); z-index: 10; pointer-events: none; font-size: 14px;"></i>
                                    <input type="date"
                                           class="form-control form-control-sm"
                                           name="checkout"
                                           id="checkoutDate"
                                           value="{{ request('checkout') }}"
                                           min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                           
                                           style="background: transparent; border: none; border-bottom: 1px solid rgba(255,255,255,0.6); border-radius: 0; padding-left: 30px; color: #fff; height: 40px; font-size: 14px;"
                                           title="Check Out Date">
                                </div>
                            </div>

                            <!-- Optional Keyword Search -->
                            <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 d-none d-md-block">
                                <div class="form-item position-relative">
                                    <i class="fas fa-search position-absolute" style="left: 10px; top: 50%; transform: translateY(-50%); color: rgba(255,255,255,0.85); z-index: 10; pointer-events: none; font-size: 14px;"></i>
                                    <input type="text"
                                           class="form-control form-control-sm"
                                           name="q"
                                           placeholder="Property name (optional)"
                                           value="{{ request('q') }}"
                                           style="background: transparent; border: none; border-bottom: 1px solid rgba(255,255,255,0.6); border-radius: 0; padding-left: 30px; color: #fff; height: 40px; font-size: 14px;"
                                           title="Search by Name">
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="col-xl-2 col-lg-2 col-md-3 col-sm-6">
                                <button type="submit"
                                        class="th-btn btn-fw style3 w-100"
                                        id="searchBtn"
                                        style="height: 40px; padding: 8px 18px; font-size: 14px; font-weight: 600; background: linear-gradient(135deg, #25D366, #128C7E); border: none; box-shadow: 0 4px 12px rgba(37, 211, 102, 0.45);"
                                        title="Search Properties">
                                    <i class="fas fa-search me-2"></i>Search
                                </button>
                            </div>
                        </div>

                        <p class="form-messages mb-0 mt-3 text-white text-center" id="formMessages" style="font-size: 13px;"></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--======== / Hero Section ========-->
    
    <!--==============================
Destinations Area  
==============================-->
    <section class="tour-area3 position-relative bg-top-center overflow-hidden space" id="destinations-sec" data-bg-src="#">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="title-area text-center">
                        <h2 class="sec-title">Popular Destinations</h2>
                        <p class="sec-text">Explore amazing properties in our top destinations</p>
                    </div>
                </div>
            </div>

            <div class="row gy-4">
                @forelse($destinations as $destination)
                    <div class="col-lg-4 col-md-6">
                        <div class="destination-card th-ani" style="background: #fff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.08); transition: transform 0.3s ease, box-shadow 0.3s ease; height: 100%;">
                            <div class="destination-card-img" style="position: relative; height: 250px; overflow: hidden;">
                                @if($destination->image && file_exists(storage_path('app/public/images/destinations/' . $destination->image)))
                                    <img src="{{ asset('storage/images/destinations/' . $destination->image) }}" 
                                         alt="{{ $destination->name }}" 
                                         style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease;">
                                @else
                                    <img src="{{ asset('assets/img/tour/tour_3_1.jpg') }}" 
                                         alt="{{ $destination->name }}" 
                                         style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease;">
                                @endif
                                <div style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(to top, rgba(0,0,0,0.7), transparent); padding: 20px;">
                                    <h3 class="mb-2" style="font-size: 22px; font-weight: 700; color: #fff; margin: 0;">
                                        {{ $destination->name }}
                                    </h3>
                                </div>
                            </div>
                            
                            <div class="destination-card-content" style="padding: 25px;">
                                @if($destination->description)
                                    <p class="mb-3" style="color: #666; font-size: 14px; line-height: 1.6;">
                                        {{ \Illuminate\Support\Str::limit(strip_tags($destination->description), 100) }}
                                    </p>
                                @endif
                                
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div style="display: flex; align-items: center; gap: 8px;">
                                        <i class="fas fa-building text-primary" style="font-size: 18px;"></i>
                                        @php
                                            $hotelCount = ($destination->hotels_count ?? 0) + ($destination->properties_count ?? 0);
                                        @endphp
                                        <span style="font-size: 16px; font-weight: 600; color: #333;">
                                            {{ $hotelCount }} {{ $hotelCount == 1 ? 'Property' : 'Properties' }}
                                        </span>
                                    </div>
                                </div>
                                
                                <a href="{{ route('destination', ['slug' => $destination->slug]) }}" class="th-btn style3 w-100 text-center">
                                    View More <i class="fas fa-arrow-right ms-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="text-center py-5">
                            <p class="text-muted">No destinations available at the moment.</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!--==============================
Latest Properties Area  
==============================-->
    <section class="position-relative overflow-hidden space" id="latest-properties-sec">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="title-area text-center">
                        <h2 class="sec-title">Latest Properties</h2>
                        <p class="sec-text">Discover our newest accommodations</p>
                    </div>
                </div>
            </div>
            
            <div class="row gy-30">
                @forelse($latestProperties as $hotel)
                    <div class="col-lg-4 col-md-6">
                        <div class="tour-box th-ani" style="height: 100%;">
                            <div class="tour-box_img global-img" style="position: relative;">
                                @php
                                    $primaryImage = $hotel->featured_image ?? $hotel->image ?? null;
                                    $isPropertyModel = isset($hotel->property_type);
                                @endphp
                                @if($primaryImage)
                                    @php
                                        $imagePath = $isPropertyModel
                                            ? 'storage/images/properties/' . $primaryImage
                                            : 'storage/images/hotels/' . $primaryImage;
                                    @endphp
                                    <img src="{{ asset($imagePath) }}" alt="{{ $hotel->name }}">
                                @else
                                    <img src="{{ asset('assets/img/tour/tour_3_1.jpg') }}" alt="{{ $hotel->name }}">
                                @endif
                                @php
                                    $minPrice = null;
                                    $currency = 'USD'; // Default currency
                                    
                                    if (isset($hotel->property_type)) {
                                        // Property model - get from units
                                        $minPrice = $hotel->min_price ?? null;
                                        if ($hotel->units && $hotel->units->isNotEmpty()) {
                                            $cheapestUnit = $hotel->units->where('base_price_per_night', '>', 0)->sortBy('base_price_per_night')->first();
                                            if ($cheapestUnit) {
                                                if (!$minPrice) {
                                                    $minPrice = $cheapestUnit->base_price_per_night;
                                                }
                                                $currency = $cheapestUnit->currency ?? 'USD';
                                            }
                                        }
                                    } else {
                                        // Hotel model - get from rooms
                                        $minPrice = $hotel->min_price ?? ($hotel->rooms ? $hotel->rooms->where('price_per_night', '>', 0)->min('price_per_night') : null);
                                        if ($hotel->rooms && $hotel->rooms->isNotEmpty()) {
                                            $cheapestRoom = $hotel->rooms->where('price_per_night', '>', 0)->sortBy('price_per_night')->first();
                                            if ($cheapestRoom) {
                                                $currency = $cheapestRoom->currency ?? 'USD';
                                            }
                                        }
                                    }
                                    $currencySymbol = getCurrencySymbol($currency);
                                @endphp
                                @if($minPrice)
                                    <div style="position: absolute; top: 15px; right: 15px; background: rgba(37, 211, 102, 0.95); color: white; padding: 8px 15px; border-radius: 8px; font-weight: 600; font-size: 16px;">
                                        {{ $currencySymbol }}{{ number_format($minPrice, 0) }}/night
                                    </div>
                                @endif
                            </div>

                            <div class="tour-content">
                                <h3 class="box-title">
                                    @if(isset($hotel->property_type))
                                        <a href="{{ route('hotel', $hotel->slug ?? $hotel->id) }}">{{ $hotel->name }}</a>
                                    @else
                                        <a href="{{ route('hotelRooms', $hotel->slug ?? $hotel->id) }}">{{ $hotel->name }}</a>
                                    @endif
                                </h3>

                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div class="tour-rating">
                                        @php
                                            // Parse stars - handle different formats like "5", "5 Star", "5-Star", etc.
                                            $starsValue = $hotel->stars ?? 0;
                                            if (is_string($starsValue)) {
                                                // Extract number from string (e.g., "5 Star" -> 5)
                                                preg_match('/\d+/', $starsValue, $matches);
                                                $stars = !empty($matches) ? (int)$matches[0] : 0;
                                            } else {
                                                $stars = (int)$starsValue;
                                            }
                                            $stars = max(0, min(5, $stars)); // Ensure between 0 and 5
                                            $avgRating = $hotel->average_rating ?? 0;
                                            $totalReviews = $hotel->total_reviews ?? 0;
                                        @endphp

                                        <div class="star-rating" role="img" aria-label="Rated {{ $stars }} out of 5">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $stars)
                                                    <i class="fa-solid fa-star text-warning" aria-hidden="true"></i>
                                                @else
                                                    <i class="fa-regular fa-star text-warning" aria-hidden="true"></i>
                                                @endif
                                            @endfor
                                            @if($totalReviews > 0)
                                                <span class="ms-2" style="font-size: 14px; color: #666;">
                                                    {{ number_format($avgRating, 1) }} ({{ $totalReviews }} {{ $totalReviews == 1 ? 'review' : 'reviews' }})
                                                </span>
                                            @else
                                                <span class="ms-2" style="font-size: 14px; color: #666;">No reviews yet</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <p class="mb-3" style="margin:6px 0; color: #666;">
                                    <i class="fa-solid fa-location-dot text-primary me-2" aria-hidden="true"></i>
                                    <strong>{{ $hotel->location ?? $hotel->city ?? 'Location not specified' }}</strong>
                                </p>

                                <div class="tour-action">
                                    @if(isset($hotel->property_type))
                                        <a href="{{ route('hotel', $hotel->slug ?? $hotel->id) }}" class="th-btn style4 th-icon">View Rooms</a>
                                        <a href="{{ route('hotel', $hotel->slug ?? $hotel->id) }}" class="th-btn style3">Book Now</a>
                                    @else
                                        <a href="{{ route('hotelRooms', $hotel->slug ?? $hotel->id) }}" class="th-btn style4 th-icon">View Rooms</a>
                                        <a href="{{ route('hotelRooms', $hotel->slug ?? $hotel->id) }}" class="th-btn style3">Book Now</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="text-center py-5">
                            <p class="text-muted">No properties available at the moment.</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!--==============================
Popular Trip Activities Area  
==============================-->
    <section class="tour-area3 position-relative bg-top-center overflow-hidden space" id="trip-activities-sec" data-bg-src="#">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="title-area text-center">
                        <h2 class="sec-title">Latest Trip Activities</h2>
                        <p class="sec-text">Explore the newest adventures and experiences</p>
                    </div>
                </div>
            </div>

            <div class="slider-area tour-slider slider-drag-wrap">
                <div class="swiper th-slider has-shadow" data-slider-options='{"breakpoints":{"0":{"slidesPerView":1},"576":{"slidesPerView":"1"},"768":{"slidesPerView":"2"},"992":{"slidesPerView":"3"},"1200":{"slidesPerView":"3"},"1400":{"slidesPerView":"4"}}}'>
                    <div class="swiper-wrapper">
                        @forelse($popularTrips as $trip)
                            <div class="swiper-slide">
                                <div class="tour-box th-ani gsap-cursor">
                                    <div class="tour-box_img global-img">
                                        @if($trip->image && file_exists(storage_path('app/public/images/trips/' . $trip->image)))
                                            <img src="{{ asset('storage/images/trips/' . $trip->image) }}" alt="{{ $trip->title }}" style="height: 250px !important; object-fit: cover;">
                                        @else
                                            <img src="{{ asset('assets/img/tour/tour_3_1.jpg') }}" alt="{{ $trip->title }}" style="height: 250px !important; object-fit: cover;">
                                        @endif
                                        @if($trip->price)
                                            <div style="position: absolute; top: 15px; right: 15px; background: rgba(37, 211, 102, 0.95); color: white; padding: 8px 15px; border-radius: 8px; font-weight: 600; font-size: 14px;">
                                                ${{ number_format($trip->price, 0) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="tour-content">
                                        <h3 class="box-title">
                                            <a href="{{ route('tour', $trip->slug) }}">{{ $trip->title }}</a>
                                        </h3>
                                        <div class="tour-rating">
                                            @if($trip->location)
                                                <p style="margin: 5px 0;">
                                                    <i class="fa-solid fa-location-dot text-primary me-2"></i>{{ $trip->location }}
                                                </p>
                                            @endif
                                            @if($trip->duration)
                                                <p style="margin: 5px 0;">
                                                    <i class="fas fa-clock text-primary me-2"></i>{{ $trip->duration }}
                                                </p>
                                            @endif
                                            @php
                                                $avgRating = $trip->average_rating ?? 0;
                                                $totalReviews = $trip->total_reviews ?? 0;
                                            @endphp
                                            @if($totalReviews > 0)
                                                <div class="star-rating mt-2">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        @if($i <= round($avgRating))
                                                            <i class="fa-solid fa-star text-warning"></i>
                                                        @else
                                                            <i class="fa-regular fa-star text-warning"></i>
                                                        @endif
                                                    @endfor
                                                    <span class="ms-2" style="font-size: 13px; color: #666;">
                                                        {{ number_format($avgRating, 1) }} ({{ $totalReviews }})
                                                    </span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="tour-action">
                                            <a href="{{ route('tour', $trip->slug) }}" class="th-btn style4 th-icon">View Details</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="text-center py-5">
                                    <p class="text-muted">No trip activities available at the moment.</p>
                                </div>
                            </div>
                        @endforelse
                    </div>
                    <div class="slider-pagination"></div>
                </div>
            </div>
        </div>
    </section>

    <!--==============================
Business Reviews/Testimonials Area  
==============================-->
    <section class="position-relative overflow-hidden space" id="reviews-sec" style="background: #f8f9fa;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="title-area text-center">
                        <h2 class="sec-title">What Our Customers Say</h2>
                        <p class="sec-text">Read testimonials from our satisfied customers</p>
                    </div>
                </div>
            </div>

            <div class="row gy-4">
                @forelse($businessReviews as $review)
                    <div class="col-lg-3 col-md-6">
                        <a href="{{ route('reviews.show', $review->id) }}" style="text-decoration: none; color: inherit;">
                            <div class="review-card" style="background: #fff; border-radius: 16px; padding: 30px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); height: 100%; transition: transform 0.3s, box-shadow 0.3s; cursor: pointer;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 8px 25px rgba(0,0,0,0.12)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 20px rgba(0,0,0,0.08)'">
                                <div class="review-content mb-3">
                                    <div class="quote-icon mb-3" style="font-size: 40px; color: #25D366; opacity: 0.3;">
                                        <i class="fas fa-quote-left"></i>
                                    </div>
                                    <!-- Rating Stars -->
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
                                            @if($review->website)
                                                <p style="margin: 0; font-size: 13px; color: #999;">
                                                    <span style="color: #25D366;">
                                                        {{ parse_url($review->website, PHP_URL_HOST) }}
                                                    </span>
                                                </p>
                                            @endif
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
                        </div>
                    </div>
                @endforelse
            </div>
            
            <div class="row mt-4">
                <div class="col-12 text-center">
                    <a href="{{ route('reviews.index') }}" class="btn btn-primary" style="background: linear-gradient(135deg, #25D366, #128C7E); border: none; padding: 12px 30px; border-radius: 8px; font-weight: 600;">
                        <i class="fas fa-eye me-2"></i>View All Reviews
                    </a>
                    @auth
                        @if(auth()->user()->hasVerifiedEmail())
                            <a href="{{ route('reviews.index') }}" class="btn btn-outline-success ms-2" style="padding: 12px 30px; border-radius: 8px; font-weight: 600;">
                                <i class="fas fa-pen me-2"></i>Submit Review
                            </a>
                        @else
                            <a href="{{ route('verification.notice') }}" class="btn btn-outline-warning ms-2" style="padding: 12px 30px; border-radius: 8px; font-weight: 600;">
                                <i class="fas fa-envelope-open-text me-2"></i>Verify Email to Submit
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-success ms-2" style="padding: 12px 30px; border-radius: 8px; font-weight: 600;">
                            <i class="fas fa-sign-in-alt me-2"></i>Login to Submit Review
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </section>

    <!--==============================
Call to Action Form Area  
==============================-->
    <section class="position-relative overflow-hidden space" id="cta-sec" style="background: linear-gradient(135deg, #25D366 0%, #128C7E 100%);">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="cta-content text-center text-white mb-4">
                        <h2 class="sec-title text-white mb-3">Ready to Plan Your Perfect Trip?</h2>
                        <p class="sec-text text-white-50 mb-4">Get in touch with us and let us help you create an unforgettable experience</p>
                    </div>
                </div>
            </div>
            
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="cta-form-card" style="background: rgba(255,255,255,0.95); border-radius: 20px; padding: 40px; box-shadow: 0 10px 40px rgba(0,0,0,0.2);">
                        <form id="ctaForm" method="POST" action="{{ route('sendMessage') }}">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-item">
                                        <label class="form-label mb-2" style="font-weight: 600;">Full Name</label>
                                        <input type="text" name="names" class="form-control" placeholder="Your Name" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-item">
                                        <label class="form-label mb-2" style="font-weight: 600;">Email Address</label>
                                        <input type="email" name="email" class="form-control" placeholder="your@email.com" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-item">
                                        <label class="form-label mb-2" style="font-weight: 600;">Subject</label>
                                        <input type="text" name="subject" class="form-control" placeholder="How can we help?" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-item">
                                        <label class="form-label mb-2" style="font-weight: 600;">Message</label>
                                        <textarea name="message" class="form-control" rows="4" placeholder="Tell us about your travel plans..." required></textarea>
                                    </div>
                                </div>
                                <div class="col-12 text-center">
                                    <button type="submit" class="th-btn style3" style="padding: 15px 40px; font-size: 16px;">
                                        <i class="fas fa-paper-plane me-2"></i>Send Message
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!--==============================
About Area  
==============================-->
    {{-- <div class="about-area position-relative overflow-hidden space" id="about-sec" data-bg-src="assets/img/bg/about_bg_1.jpg">
        <div class="container">
            <div class="row">
                <div class="col-xl-6">
                    <div class="img-box6">
                        <div class="img1">
                            <img src="assets/img/normal/about_6_1.jpg" alt="About">
                        </div>
                        <div class="img2">
                            <img src="assets/img/normal/about_6_2.jpg" alt="About">
                        </div>
                        <div class="img3">
                            <img src="assets/img/normal/about_6_3.jpg" alt="About">
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="ps-xl-5 ms-xl-3">
                        <div class="title-area mb-20">
                            <span class="sub-title style1">Let’s Go Together</span>
                            <h2 class="sec-title mb-20">Begin Your Travel Story with Us</h2>

                            <p class="sec-text mb-30">There are many variations of passages of available but the majority have suffered alteration in some form, by injected hum randomised words which don't look even slightly. </p>
                        </div>
                        <div class="about-item-wrap">
                            <div class="about-item">
                                <div class="about-item_img"><img src="assets/img/icon/map3.svg" alt=""></div>
                                <div class="about-item_centent">
                                    <h5 class="box-title">Exclusive Trip</h5>
                                    <p class="about-item_text">There are many variations of passages of available but the
                                        majority.</p>
                                </div>
                            </div>
                            <div class="about-item">
                                <div class="about-item_img"><img src="assets/img/icon/guide.svg" alt=""></div>
                                <div class="about-item_centent">
                                    <h5 class="box-title">Professional Guide</h5>
                                    <p class="about-item_text">There are many variations of passages of available but the
                                        majority.</p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-35"><a href="{{ route('home') }}" class="th-btn style3 th-icon">Learn More</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
   
    <!--==============================


Service Area  
==============================-->


<style>
/* Hero Section Fixes */
#hero.th-hero-wrapper.hero-7 {
    min-height: 500px !important;
    max-height: 600px;
    background-size: cover !important;
    background-position: center center !important;
    background-repeat: no-repeat !important;
    display: flex;
    align-items: center;
    position: relative;
}

#hero .container {
    width: 100%;
    position: relative;
    z-index: 2;
}

.hero-style7 {
    padding: 100px 0 30px 0 !important;
}

/* Glass morphism effect for form - More transparent */
#heroSearchForm {
    transition: all 0.3s ease;
}

#heroSearchForm:hover {
    background: rgba(255, 255, 255, 0.1) !important;
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15) !important;
}

/* Form inputs styling - Transparent backgrounds */
#heroSearchForm .form-control,
#heroSearchForm .form-select {
    transition: all 0.3s ease;
    color: white !important;
}

#heroSearchForm .form-control:focus,
#heroSearchForm .form-select:focus {
    background: rgba(255, 255, 255, 0.2) !important;
    border-color: rgba(255, 255, 255, 0.4) !important;
    box-shadow: 0 0 0 0.2rem rgba(255, 255, 255, 0.1);
    outline: none;
}

#heroSearchForm .form-control::placeholder {
    color: rgba(255, 255, 255, 0.6) !important;
}

/* Select dropdown styling */
#heroSearchForm select option {
    background: white;
    color: #333;
}

/* Date input calendar icon */
#heroSearchForm input[type="date"]::-webkit-calendar-picker-indicator {
    filter: invert(1);
    opacity: 0.7;
    cursor: pointer;
}

/* Button hover effect */
#searchBtn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(37, 211, 102, 0.5) !important;
}

@media (max-width: 991px) {
    #hero.th-hero-wrapper.hero-7 {
        min-height: 450px;
        max-height: 550px;
    }
    
    .hero-style7 {
        padding: 80px 0 25px 0 !important;
    }
    
    #heroSearchForm {
        padding: 20px !important;
    }
    
    #heroSearchForm .row.g-2 > div {
        margin-bottom: 12px;
    }
}

@media (max-width: 767px) {
    #hero.th-hero-wrapper.hero-7 {
        min-height: 400px;
        max-height: 500px;
    }
    
    .hero-style7 {
        padding: 60px 0 20px 0 !important;
    }
    
    #heroSearchForm .form-control,
    #heroSearchForm .form-select {
        font-size: 13px;
        height: 42px !important;
    }
    
    #heroSearchForm .form-item .position-absolute i {
        font-size: 12px;
        left: 10px !important;
    }
    
    #heroSearchForm .form-control,
    #heroSearchForm .form-select {
        padding-left: 32px !important;
    }
    
    #searchBtn {
        height: 42px !important;
        font-size: 14px !important;
    }
    }

/* Destination Card Hover Effects */
.destination-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 30px rgba(0,0,0,0.12) !important;
}

.destination-card:hover .destination-card-img img {
    transform: scale(1.1);
}

/* Review Card Hover */
.review-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 25px rgba(0,0,0,0.12) !important;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const heroForm = document.getElementById('heroSearchForm');
    const checkinDate = document.getElementById('checkinDate');
    const checkoutDate = document.getElementById('checkoutDate');
    const formMessages = document.getElementById('formMessages');
    const searchBtn = document.getElementById('searchBtn');

    // Set minimum dates
    const today = new Date().toISOString().split('T')[0];
    const tomorrow = new Date();
    tomorrow.setDate(tomorrow.getDate() + 1);
    const tomorrowStr = tomorrow.toISOString().split('T')[0];

    if (checkinDate && !checkinDate.value) {
        checkinDate.min = today;
    }
    if (checkoutDate && !checkoutDate.value) {
        checkoutDate.min = tomorrowStr;
    }

    // Update checkout minimum date when checkin changes
    if (checkinDate) {
        checkinDate.addEventListener('change', function() {
            if (this.value) {
                const checkin = new Date(this.value);
                checkin.setDate(checkin.getDate() + 1);
                checkoutDate.min = checkin.toISOString().split('T')[0];
                
                // If checkout is before new minimum, update it
                if (checkoutDate.value && checkoutDate.value < checkoutDate.min) {
                    checkoutDate.value = checkoutDate.min;
                }
            }
        });
    }

    // Form validation
    if (heroForm) {
        heroForm.addEventListener('submit', function(e) {
            let isValid = true;
            let errorMessage = '';

            // Validate dates
            if (checkinDate && checkoutDate) {
                if (checkinDate.value && checkoutDate.value) {
                    const checkin = new Date(checkinDate.value);
                    const checkout = new Date(checkoutDate.value);
                    
                    if (checkout <= checkin) {
                        isValid = false;
                        errorMessage = 'Check-out date must be after check-in date.';
                    }
                } else if (checkinDate.value && !checkoutDate.value) {
                    isValid = false;
                    errorMessage = 'Please select a check-out date.';
                } else if (!checkinDate.value && checkoutDate.value) {
                    isValid = false;
                    errorMessage = 'Please select a check-in date.';
                }
            }

            if (!isValid) {
                e.preventDefault();
                formMessages.textContent = errorMessage;
                formMessages.style.color = '#ff6b6b';
                formMessages.style.display = 'block';
                
                // Hide message after 5 seconds
                setTimeout(function() {
                    formMessages.style.display = 'none';
                }, 5000);
                return false;
            }

            // Show loading state
            if (searchBtn) {
                searchBtn.disabled = true;
                searchBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Searching...';
            }
        });
    }

    // Clear form messages on input
    const formInputs = heroForm?.querySelectorAll('input, select');
    if (formInputs) {
        formInputs.forEach(input => {
            input.addEventListener('input', function() {
                if (formMessages) {
                    formMessages.style.display = 'none';
                }
            });
        });
    }
});
</script>
    
 @endsection