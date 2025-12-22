
@extends('layouts.frontbase')

@section('content')
    <!--==============================
Hero Area
==============================-->
    <div class="th-hero-wrapper hero-7" id="hero" data-bg-src="{{ asset('storage/images/about') . $about->image1 }}">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-7 col-xl-8">
                    <div class="hero-style7">
                        <span class="sub-title style1 text-white">Welcome to Booking Engine</span>
                        <h1 class="hero-title text-white">Serene Countryside Retreat at Tourm Best Hotel</h1>
                        <div class="btn-group">
                            <a href="{{ route('connect') }}" class="th-btn th-icon">Book A Room</a>
                            <a href="{{ route('connect') }}" class="th-btn style2 th-icon">Things To Do</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 col-xl-4">
                <form action="{{ route('hotelsSearch') }}" method="GET" class="hero-form">
                    <div class="hero-wrap">
                        <div class="title-area mb-15 text-center">
                            <h2 class="sec-title text-white">Make Your Reservation</h2>
                        </div>

                        <div class="row gx-24 align-items-center">

                            <div class="form-group col-12">
                                <div class="form-item">
                                    <label>Destination</label>
                                    <select name="location" class="form-select nice-select">
                                        @foreach($locations as $location)
                                            <option value="{{ $location }}"
                                                {{ request('location') == $location ? 'selected' : '' }}>
                                                {{ $location }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group col-12">
                                <div class="form-item">
                                    <input type="text" class="form-control" name="address"
                                        placeholder="Address "
                                        value="{{ request('address') }}">
                                </div>
                            </div>

                            <div class="form-group col-12">
                                <div class="form-item">
                                    <input type="text" class="form-control" name="name"
                                        placeholder="Type Hotel Name"
                                        value="{{ request('q') }}">
                                </div>
                            </div>

                            <div class="form-group col-12">
                                <div class="form-item">
                                    <label>Check In</label>
                                    <input type="date" class="form-control" name="checkin"
                                        value="{{ request('checkin') }}">
                                </div>
                            </div>

                            <div class="form-group col-12">
                                <div class="form-item">
                                    <label>Check Out</label>
                                    <input type="date" class="form-control" name="checkout"
                                        value="{{ request('checkout') }}">
                                </div>
                            </div>

                            <div class="btn-form col-12">
                                <button type="submit" class="th-btn btn-fw style1">
                                    Confirm Availability
                                    <img src="assets/img/icon/plane2.svg" alt="">
                                </button>
                            </div>

                        </div>

                        <p class="form-messages mb-0 mt-3"></p>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
    <!--======== / Hero Section ========-->
    
    <!--==============================
Services Area  
==============================-->
    <section class="tour-area3 position-relative bg-top-center overflow-hidden space" id="service-sec" data-bg-src="#">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="title-area text-center">
                        <h2 class="sec-title">Our Services</h2>
                    </div>
                </div>
            </div>

            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade active show" id="nav-step1" role="tabpanel">
                    <div class="slider-area tour-slider slider-drag-wrap">
                        <div class="swiper th-slider has-shadow" data-slider-options='{"breakpoints":{"0":{"slidesPerView":1},"576":{"slidesPerView":"1"},"768":{"slidesPerView":"2"},"992":{"slidesPerView":"3"},"1200":{"slidesPerView":"3"},"1400":{"slidesPerView":"4"}}}'>
                            <div class="swiper-wrapper">
                                @foreach ($services as $service)
                                <div class="swiper-slide vh-100">
                                    <div class="tour-box th-ani gsap-cursor">
                                        <div class="tour-box_img global-img">
                                            <img src="{{ asset('storage/images/services/' .$service->image) }}" alt="image" style="height: 250px !important">
                                        </div>
                                        <div class="tour-content">
                                            <h3 class="box-title"><a href="{{route('service',['slug'=>$service->slug])}}">{{ $service->title }}</a></h3>
                                            <div class="tour-rating">
                                                <p>{{ \Illuminate\Support\Str::limit(strip_tags($service->description), 100) }}</p>
                                            </div>
                                            <div class="tour-action">
                                                <a href="{{route('service',['slug'=>$service->slug])}}" class="th-btn style4 th-icon">View More</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach

                            </div>

                            <div class="slider-pagination"></div>
                        </div>

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

    <section class="position-relative overflow-hidden spacess" id="service-sec">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 offset-lg-3">
                    <div class="title-area text-center">
                        <h2 class="sec-title">Accommodations</h2>
                        <p class="sec-text">Rwanda’s trusted partner for affordable stays</p>
                    </div>
                </div>
            </div>
            <div class="slider-area tour-slider ">
                <div class="swiper th-slider has-shadow slider-drag-wrap" data-slider-options='{"breakpoints":{"0":{"slidesPerView":1},"576":{"slidesPerView":"1"},"768":{"slidesPerView":"2"},"992":{"slidesPerView":"2"},"1200":{"slidesPerView":"3"},"1300":{"slidesPerView":"4"}}}'>
                    <div class="swiper-wrapper">

                        @forelse($hotels as $hotel)
                            <div class="col-xxl-4 col-xl-6">
                                <div class="tour-box th-ani">
                                    <div class="tour-box_img global-img">
                                        @if($hotel->image && file_exists(storage_path('app/public/images/hotels/' . $hotel->image)))
                                            <img src="{{ asset('storage/images/hotels/' . $hotel->image) }}" alt="{{ $hotel->name }}">
                                        @else
                                            <img src="{{ asset('assets/img/tour/tour_3_1.jpg') }}" alt="{{ $hotel->name }}">
                                        @endif
                                    </div>

                                    <div class="tour-content">
                                        <h3 class="box-title">
                                            <a href="{{ route('hotelRooms', $hotel->slug ?? $hotel->id) }}">{{ $hotel->name }}</a>
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
                                                <a href="{{ route('hotel', $hotel->slug ?? $hotel->id) }}" class="woocommerce-review-link">({{ $stars }} Rating)</a>
                                            </div>
                                        </div>

                                        <p class="mb-2" style="margin:6px 0;">
                                            <i class="fa-solid fa-location-dot" aria-hidden="true"></i>
                                            {{ $hotel->location ?? $hotel->city ?? 'Location not specified' }}
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
                                <p class="text-center">No hotels found.</p>
                            </div>
                        @endforelse



                    </div>
                </div>
            </div>
        </div>
    </section>

    
    

    <section class="tour-area3 position-relative bg-top-center overflow-hidden space" id="service-sec" data-bg-src="#">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="title-area text-center">
                        <h2 class="sec-title">Our Popular Destinations</h2>
                    </div>
                </div>
            </div>

            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade active show" id="nav-step1" role="tabpanel">
                    <div class="slider-area tour-slider slider-drag-wrap">
                        <div class="swiper th-slider has-shadow" data-slider-options='{"breakpoints":{"0":{"slidesPerView":1},"576":{"slidesPerView":"1"},"768":{"slidesPerView":"2"},"992":{"slidesPerView":"3"},"1200":{"slidesPerView":"3"},"1400":{"slidesPerView":"4"}}}'>
                            <div class="swiper-wrapper">
                                @foreach ($destinations as $trip)
                                <div class="swiper-slide vh-100">
                                    <div class="tour-box th-ani gsap-cursor">
                                        <div class="tour-box_img global-img">
                                            <img src="{{ asset('storage/images/destinations/' .$trip->image) }}" alt="image" style="height: 250px !important">
                                        </div>
                                        <div class="tour-content">
                                            <h3 class="box-title"><a href="{{route('destination',['slug'=>$trip->slug])}}">{{ $trip->title }}</a></h3>
                                            <div class="tour-rating">
                                                <p>{{ \Illuminate\Support\Str::limit(strip_tags($trip->description), 100) }}</p>
                                            </div>
                                            <div class="tour-action">
                                                <a href="{{route('destination',['slug'=>$trip->slug])}}" class="th-btn style4 th-icon">View More</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach

                            </div>

                            <div class="slider-pagination"></div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>



@include('frontend.includes.contactForm')

    
 @endsection