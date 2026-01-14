<div class="tab-content" id="nav-tabContent">
    {{-- GRID VIEW --}}
    <div class="tab-pane fade active show" id="tab-grid" role="tabpanel" aria-labelledby="tab-destination-grid">
        <div class="row gy-30">
            @forelse($rooms as $hotel)
                <div class="col-lg-4 col-md-6">
                    <div class="tour-box th-ani" style="height: 100%;">
                        <div class="tour-box_img global-img" style="position: relative;">
                            @php
                                // Property model uses featured_image, stored in properties folder
                                $imagePath = $hotel->featured_image ? asset('storage/images/properties/' . $hotel->featured_image) : asset('assets/img/tour/tour_3_1.jpg');
                            @endphp
                            <img src="{{ $imagePath }}" alt="{{ $hotel->name }}">
                            @php
                                // Get min price from units relationship (Property model uses units, not rooms)
                                $minPrice = $hotel->min_price ?? null;
                                if (!$minPrice && $hotel->units && $hotel->units->isNotEmpty()) {
                                    $minPrice = $hotel->units->where('base_price_per_night', '>', 0)->min('base_price_per_night');
                                }
                            @endphp
                            @if($minPrice)
                                <div style="position: absolute; top: 15px; right: 15px; background: rgba(37, 211, 102, 0.95); color: white; padding: 8px 15px; border-radius: 8px; font-weight: 600; font-size: 16px;">
                                    ${{ number_format($minPrice, 0) }}/night
                                </div>
                            @endif
                        </div>

                        <div class="tour-content">
                            <h3 class="box-title">
                                <a href="{{ route('hotelRooms', $hotel->slug ?? $hotel->id) }}">{{ $hotel->name }}</a>
                            </h3>

                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div class="tour-rating">
                                    @php
                                        $stars = (int) filter_var($hotel->stars, FILTER_SANITIZE_NUMBER_INT);
                                        $stars = max(0, min(5, $stars));
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
                                <a href="{{ route('hotel', $hotel->slug ?? $hotel->id) }}" class="th-btn style4 th-icon">View Rooms</a>
                                <a href="{{ route('hotel', $hotel->slug ?? $hotel->id) }}" class="th-btn style3">Book Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center py-5">
                        <i class="fas fa-search fa-3x text-muted mb-3"></i>
                        <p class="text-muted">No hotels found matching your search criteria.</p>
                        <a href="{{ route('hotels') }}" class="th-btn style3">View All Hotels</a>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    {{-- LIST VIEW --}}
    <div class="tab-pane fade" id="tab-list" role="tabpanel" aria-labelledby="tab-destination-list">
        <div class="row gy-30">
            @forelse($rooms as $hotel)
                <div class="col-12">
                    <div class="tour-box style-flex th-ani">
                        <div class="tour-box_img global-img">
                            @php
                                // Property model uses featured_image, stored in properties folder
                                $imagePath = $hotel->featured_image ? asset('storage/images/properties/' . $hotel->featured_image) : asset('assets/img/tour/tour_3_1.jpg');
                            @endphp
                            <img src="{{ $imagePath }}" alt="{{ $hotel->name }}">
                        </div>

                        <div class="tour-content">
                            <h3 class="box-title">
                                <a href="{{ route('accommodations', $hotel->slug ?? $hotel->id) }}">{{ $hotel->name }}</a>
                            </h3>

                            <div class="tour-rating">
                                @php
                                    $stars = (int) filter_var($hotel->stars, FILTER_SANITIZE_NUMBER_INT);
                                    $stars = max(0, min(5, $stars));
                                @endphp
                                <div class="star-rating" role="img" aria-label="Rated {{ $stars }} out of 5">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $stars)
                                            <i class="fa-solid fa-star" aria-hidden="true"></i>
                                        @else
                                            <i class="fa-regular fa-star" aria-hidden="true"></i>
                                        @endif
                                    @endfor
                                    <a href="{{ route('accommodations', $hotel->slug ?? $hotel->id) }}" class="woocommerce-review-link">({{ $stars }} Rating)</a>
                                </div>
                            </div>

                            <p class="mb-2" style="margin:6px 0;">
                                <i class="fa-solid fa-location-dot" aria-hidden="true"></i>
                                {{ $hotel->location ?? $hotel->city ?? 'Location not specified' }}
                            </p>

                            <div class="tour-action">
                                <a href="{{ route('accommodations', $hotel->slug ?? $hotel->id) }}" class="th-btn style4">View Rooms</a>
                                <a href="{{ route('accommodations', $hotel->slug ?? $hotel->id) }}" class="th-btn style3">Book Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center py-5">
                        <i class="fas fa-search fa-3x text-muted mb-3"></i>
                        <p class="text-muted">No hotels found matching your search criteria.</p>
                        <a href="{{ route('hotels') }}" class="th-btn style3">View All Hotels</a>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    {{-- pagination --}}
    <div class="th-pagination text-center mt-60 mb-0">
        @if(method_exists($rooms, 'links'))
            <div class="row">
                <div class="col-12 d-flex justify-content-center">
                    {!! $rooms->appends(request()->query())->links() !!}
                </div>
            </div>
        @endif
    </div>
</div>

