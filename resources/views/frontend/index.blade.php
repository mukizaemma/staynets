
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
                    <form action="mail.php" method="POST" class="hero-form ajax-contact">
                        <div class="hero-wrap">
                            <div class="title-area mb-35 text-center">
                                <span class="sub-title2 text-white">Select a date to explore</span>
                                <h2 class="sec-title text-white">Make Your Reservation</h2>
                            </div>
                            <div class="row gx-24 align-items-center justify-content-between">
                                <div class="form-group col-12">
                                    <div class="form-item">
                                        <label for="name">Check In</label>
                                        <input type="date" class="form-control" name="date" id="date" value="2024-09-13" placeholder="select Date">
                                    </div>
                                </div>
                                <div class="form-group col-12">
                                    <div class="form-item">
                                        <label for="name">Check Out</label>
                                        <input type="date" class="form-control" name="date" id="date" value="2024-09-16" placeholder="select Date">
                                    </div>
                                </div>
                                <div class="form-group col-12">
                                    <div class="form-item">
                                        <label for="name">Rooms</label>
                                        <select name="subject" id="subject" class="form-select nice-select">
                                            <option value="1 Room" selected disabled>1 Room</option>
                                            <option value="2 Room">2 Room</option>
                                            <option value="3 Room">3 Room</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 form-group">
                                    <div class="form-item">
                                        <label for="name">Adults</label>
                                        <select name="subject" id="subject" class="form-select nice-select">
                                            <option value="Adults" selected disabled>1</option>
                                            <option value="2 Room">2</option>
                                            <option value="3 Room">3</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 form-group">
                                    <div class="form-item">
                                        <label for="name">Children</label>
                                        <select name="subject" id="subject" class="form-select nice-select">
                                            <option value="1" selected disabled>1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="btn-form">
                                    <button type="submit" class="th-btn btn-fw style1">Confirm Availability <img src="assets/img/icon/plane2.svg" alt=""></button>
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
                                            <h3 class="box-title"><a href="{{route('tour',['slug'=>$service->slug])}}">{{ $service->title }}</a></h3>
                                            <div class="tour-rating">
                                                <p>{{ \Illuminate\Support\Str::limit(strip_tags($service->description), 100) }}</p>
                                            </div>
                                            <div class="tour-action">
                                                <a href="{{route('tour',['slug'=>$service->slug])}}" class="th-btn style4 th-icon">View More</a>
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

                        @foreach ($rooms as $room)
                        <div class="swiper-slide">
                            <div class="tour-box style4 th-ani gsap-cursor">
                                <div class="tour-box_img global-img">
                                    <img src="{{ asset('storage/images/rooms/' . $room->image) }}" alt="image">
                                </div>
                                <div class="tour-content">
                                    <h3 class="box-title"><a href="tour-details.html">{{ $room->room_type }}</a></h3>
                                    <div class="tour-rating">
                                        <div class="star-rating" role="img" aria-label="Rated 5.00 out of 5"><span style="width:100%">Rated
                                                <strong class="rating">5.00</strong> out of 5 based on <span class="rating">4.8</span>(4.8
                                                Rating)</span></div>
                                        <a href="tour-details.html" class="woocommerce-review-link">(<span class="count">4.8</span>
                                            Rating)</a>
                                    </div>
                                    <h4 class="tour-box_price"><span class="currency">${{ $room->price_per_night }}</span>/Night</h4>
                                    <div class="tour-action">
                                        <span><i class="fa-light fa-clock"></i>7 Days</span>
                                        <a href="tour-guider-details.html" class="th-btn style4 th-icon">Book Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach



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
                                            <h3 class="box-title"><a href="{{route('tour',['slug'=>$trip->slug])}}">{{ $trip->title }}</a></h3>
                                            <div class="tour-rating">
                                                <p>{{ \Illuminate\Support\Str::limit(strip_tags($trip->description), 100) }}</p>
                                            </div>
                                            <div class="tour-action">
                                                <a href="{{route('tour',['slug'=>$trip->slug])}}" class="th-btn style4 th-icon">View More</a>
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