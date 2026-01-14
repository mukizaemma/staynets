@extends('layouts.frontbase')

@section('content')



    <!--==============================
    Breadcumb
============================== -->
    <div class="breadcumb-wrapper " data-bg-src="{{ asset('storage/images/destinations/' . $category->image) }}">
        <div class="container">
            <div class="breadcumb-content">
                <ul class="breadcumb-menu">
                    {{-- <li><a href="{{ route('home') }}">Home</a></li> --}}
                      <h1 class="breadcumb-title">{{ $category->name }} Details</h1>
                </ul>
            </div>
        </div>
    </div>
    <!--==============================
Properties Area
==============================-->
    <section class="space">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-8">
                    <div class="title-area text-center">
                        <h2 class="sec-title">Properties in {{ $category->name }}</h2>
                        <p class="sec-text">Find the perfect accommodation for your stay</p>
                    </div>
                </div>
            </div>

            <div class="row gy-30">
                @forelse($hotels as $hotel)
                    <div class="col-lg-4 col-md-6">
                        <div class="tour-box th-ani" style="height: 100%;">
                            <div class="tour-box_img global-img" style="position: relative;">
                                @if($hotel->image && file_exists(storage_path('app/public/images/hotels/' . $hotel->image)))
                                    <img src="{{ asset('storage/images/hotels/' . $hotel->image) }}" alt="{{ $hotel->name }}">
                                @else
                                    <img src="{{ asset('assets/img/tour/tour_3_1.jpg') }}" alt="{{ $hotel->name }}">
                                @endif
                                @php
                                    $minPrice = $hotel->min_price ?? ($hotel->rooms->min('price_per_night') ?? null);
                                @endphp
                                @if($minPrice)
                                    <div style="position: absolute; top: 15px; right: 15px; background: rgba(37, 211, 102, 0.95); color: white; padding: 8px 15px; border-radius: 8px; font-weight: 600; font-size: 16px;">
                                        ${{ number_format($minPrice, 0) }}/night
                                    </div>
                                @endif
                            </div>

                            <div class="tour-content">
                                <h3 class="box-title">
                                    <a href="{{ route('hotel', $hotel->slug ?? $hotel->id) }}">{{ $hotel->name }}</a>
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
                            <p class="text-muted">No properties available in this destination yet.</p>
                        </div>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            @if(method_exists($hotels, 'links'))
                <div class="row mt-60">
                    <div class="col-12 d-flex justify-content-center">
                        {!! $hotels->appends(request()->query())->links() !!}
                    </div>
                </div>
            @endif
        </div>
    </section>

    <!--==============================
Tour Activities Area
==============================-->
    @if($trips && $trips->count() > 0)
    <section class="tour-area3 position-relative bg-top-center overflow-hidden space" id="trip-activities-sec" data-bg-src="#" style="background: #f8f9fa;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="title-area text-center">
                        <h2 class="sec-title">Tour Activities in {{ $category->name }}</h2>
                        <p class="sec-text">Discover exciting adventures and experiences</p>
                    </div>
                </div>
            </div>

            <div class="row gy-30">
                @foreach($trips as $trip)
                    <div class="col-lg-4 col-md-6">
                        <div class="tour-box th-ani" style="height: 100%;">
                            <div class="tour-box_img global-img" style="position: relative;">
                                @if($trip->image && file_exists(storage_path('app/public/images/trips/' . $trip->image)))
                                    <img src="{{ asset('storage/images/trips/' . $trip->image) }}" alt="{{ $trip->title }}" style="height: 250px; object-fit: cover;">
                                @else
                                    <img src="{{ asset('assets/img/tour/tour_3_1.jpg') }}" alt="{{ $trip->title }}" style="height: 250px; object-fit: cover;">
                                @endif
                                @if($trip->price)
                                    <div style="position: absolute; top: 15px; right: 15px; background: rgba(37, 211, 102, 0.95); color: white; padding: 8px 15px; border-radius: 8px; font-weight: 600; font-size: 16px;">
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
                                    @if($trip->description)
                                        <p class="mt-2" style="font-size: 14px; color: #666;">
                                            {{ \Illuminate\Support\Str::limit(strip_tags($trip->description), 100) }}
                                        </p>
                                    @endif
                                </div>
                                <div class="tour-action">
                                    <a href="{{ route('tour', $trip->slug) }}" class="th-btn style4 th-icon">View Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif


@endsection