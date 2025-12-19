@extends('layouts.frontbase')

@section('content')


    <div class="about-area position-relative overflow-hidden overflow-hidden space bg-smoke" id="about-sec">
        <div class="container space">
            <div class="row">
                <div class="col-xl-7">
                    <div class="img-box3">
                        <div class="img2">
                            <img src="{{ asset('storage/images/ticketing/' . ($data->image ?? '')) }}" alt="About">
                        </div>
                    </div>
                </div>
                <div class="col-xl-5">
                    <div class="ps-xl-4">
                        <div class="title-area mb-20">
                            <h2 class="sec-title mb-20 pe-xl-5 me-xl-5 heading">{{ $data->heading ?? '' }}</h2>
                        </div>
                        <p class="pe-xl-5">{!! $data->description ?? '' !!}</p>

                        <button type="button" class="btn th-btn style3 th-icon" data-bs-toggle="modal" data-bs-target="#myModal">
                         Request for Air Ticketing Support
                        </button>

                    </div>
                </div>
            </div>
            <div class="shape-mockup movingX d-none d-xxl-block" data-top="0%" data-left="-18%">
                <img src="assets/img/shape/shape_2_1.png" alt="shape">
            </div>
            <div class="shape-mockup jump d-none d-xxl-block" data-top="28%" data-right="-15%">
                <img src="assets/img/shape/shape_2_2.png" alt="shape">
            </div>
            <div class="shape-mockup spin d-none d-xxl-block" data-bottom="18%" data-left="-112%">
                <img src="assets/img/shape/shape_2_3.png" alt="shape">
            </div>
            <div class="shape-mockup movixgX d-none d-xxl-block" data-bottom="18%" data-right="-12%">
                <img src="assets/img/shape/shape_2_4.png" alt="shape">
            </div>
        </div>
    </div>


        <!--==============================
Testimonial Area  
==============================-->
    <section class="testi-area overflow-hidden space-top" id="testi-sec">
        <div class="container-fluid p-0">
            <div class="title-area mb-20 text-center">
                <span class="sub-title">Testimonial</span>
                <h2 class="sec-title">What Client Say About us</h2>
            </div>
            <div class="slider-area">
                <div class="swiper th-slider testiSlider6 has-shadow" id="testiSlider1" data-slider-options='{"breakpoints":{"0":{"slidesPerView":1},"767":{"slidesPerView":"2","centeredSlides":"true"},"992":{"slidesPerView":"2","centeredSlides":"true"},"1200":{"slidesPerView":"2","centeredSlides":"true"},"1400":{"slidesPerView":"3","centeredSlides":"true"}}}'>
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="testi-card style2">
                                <div class="testi-card_wrapper">
                                    <div class="testi-card_profile" data-mask-src="assets/img/shape/testi-shape.png">
                                        <div class="testi-card_avater">
                                            <img src="assets/img/testimonial/testi_1_1.jpg" alt="testimonial">
                                        </div>
                                        <div class="media-body">
                                            <h3 class="box-title">Maria Doe</h3>
                                            <span class="testi-card_desig">Traveller</span>
                                        </div>
                                    </div>
                                    <div class="testi-card_review">
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                    </div>
                                </div>

                                <p class="testi-card_text">“A home that perfectly blends sustainability with luxury until I discovered Ecoland Residence. From the moment I stepped into this community, I knew it was where I wanted to live. The commitment to eco-friendly living”</p>
                                <div class="testi-card-quote">
                                    <img src="assets/img/icon/testi-quote.svg" alt="img">
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="testi-card style2">
                                <div class="testi-card_wrapper">
                                    <div class="testi-card_profile" data-mask-src="assets/img/shape/testi-shape.png">
                                        <div class="testi-card_avater">
                                            <img src="assets/img/testimonial/testi_1_2.jpg" alt="testimonial">
                                        </div>
                                        <div class="media-body">
                                            <h3 class="box-title">Andrew Simon</h3>
                                            <span class="testi-card_desig">Traveller</span>
                                        </div>
                                    </div>
                                    <div class="testi-card_review">
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                    </div>
                                </div>

                                <p class="testi-card_text">“The home boasts sleek, contemporary architecture with clean lines and expansive windows, allowing natural light to flood the interiors It incorporates passive design principles”</p>
                                <div class="testi-card-quote">
                                    <img src="assets/img/icon/testi-quote.svg" alt="img">
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="testi-card style2">
                                <div class="testi-card_wrapper">
                                    <div class="testi-card_profile" data-mask-src="assets/img/shape/testi-shape.png">
                                        <div class="testi-card_avater">
                                            <img src="assets/img/testimonial/testi_1_1.jpg" alt="testimonial">
                                        </div>
                                        <div class="media-body">
                                            <h3 class="box-title">Alex Jordan</h3>
                                            <span class="testi-card_desig">Traveller</span>
                                        </div>
                                    </div>
                                    <div class="testi-card_review">
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                    </div>
                                </div>

                                <p class="testi-card_text">“Solar panels adorn the roof, harnessing renewable energy to power the home and even feed excess electricity back into the grid. High-performance insulation and triple-glazed”</p>
                                <div class="testi-card-quote">
                                    <img src="assets/img/icon/testi-quote.svg" alt="img">
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="testi-card style2">
                                <div class="testi-card_wrapper">
                                    <div class="testi-card_profile" data-mask-src="assets/img/shape/testi-shape.png">
                                        <div class="testi-card_avater">
                                            <img src="assets/img/testimonial/testi_1_2.jpg" alt="testimonial">
                                        </div>
                                        <div class="media-body">
                                            <h3 class="box-title">Maria Doe</h3>
                                            <span class="testi-card_desig">Traveller</span>
                                        </div>
                                    </div>
                                    <div class="testi-card_review">
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                    </div>
                                </div>

                                <p class="testi-card_text">A sophisticated rainwater harvesting system collects and filters rainwater for irrigation and non-potable uses, reducing reliance on municipal water sources. Greywater systems</p>
                                <div class="testi-card-quote">
                                    <img src="assets/img/icon/testi-quote.svg" alt="img">
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="testi-card style2">
                                <div class="testi-card_wrapper">
                                    <div class="testi-card_profile" data-mask-src="assets/img/shape/testi-shape.png">
                                        <div class="testi-card_avater">
                                            <img src="assets/img/testimonial/testi_1_1.jpg" alt="testimonial">
                                        </div>
                                        <div class="media-body">
                                            <h3 class="box-title">Angelina Rose</h3>
                                            <span class="testi-card_desig">Traveller</span>
                                        </div>
                                    </div>
                                    <div class="testi-card_review">
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                    </div>
                                </div>

                                <p class="testi-card_text">Throughout the interior, eco-friendly materials like reclaimed wood, bamboo flooring, and recycled glass countertops create a luxurious yet sustainable ambiance.</p>
                                <div class="testi-card-quote">
                                    <img src="assets/img/icon/testi-quote.svg" alt="img">
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="testi-card style2">
                                <div class="testi-card_wrapper">
                                    <div class="testi-card_profile" data-mask-src="assets/img/shape/testi-shape.png">
                                        <div class="testi-card_avater">
                                            <img src="assets/img/testimonial/testi_1_1.jpg" alt="testimonial">
                                        </div>
                                        <div class="media-body">
                                            <h3 class="box-title">Maria Doe</h3>
                                            <span class="testi-card_desig">Traveller</span>
                                        </div>
                                    </div>
                                    <div class="testi-card_review">
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                    </div>
                                </div>

                                <p class="testi-card_text">“A home that perfectly blends sustainability with luxury until I discovered Ecoland Residence. From the moment I stepped into this community, I knew it was where I wanted to live. The commitment to eco-friendly living”</p>
                                <div class="testi-card-quote">
                                    <img src="assets/img/icon/testi-quote.svg" alt="img">
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="testi-card style2">
                                <div class="testi-card_wrapper">
                                    <div class="testi-card_profile" data-mask-src="assets/img/shape/testi-shape.png">
                                        <div class="testi-card_avater">
                                            <img src="assets/img/testimonial/testi_1_2.jpg" alt="testimonial">
                                        </div>
                                        <div class="media-body">
                                            <h3 class="box-title">Andrew Simon</h3>
                                            <span class="testi-card_desig">Traveller</span>
                                        </div>
                                    </div>
                                    <div class="testi-card_review">
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                    </div>
                                </div>

                                <p class="testi-card_text">A sophisticated rainwater harvesting system collects and filters rainwater for irrigation and non-potable uses, reducing reliance on municipal water sources. Greywater systems</p>
                                <div class="testi-card-quote">
                                    <img src="assets/img/icon/testi-quote.svg" alt="img">
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="testi-card style2">
                                <div class="testi-card_wrapper">
                                    <div class="testi-card_profile" data-mask-src="assets/img/shape/testi-shape.png">
                                        <div class="testi-card_avater">
                                            <img src="assets/img/testimonial/testi_1_1.jpg" alt="testimonial">
                                        </div>
                                        <div class="media-body">
                                            <h3 class="box-title">Alex Jordan</h3>
                                            <span class="testi-card_desig">Traveller</span>
                                        </div>
                                    </div>
                                    <div class="testi-card_review">
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                    </div>
                                </div>

                                <p class="testi-card_text">Throughout the interior, eco-friendly materials like reclaimed wood, bamboo flooring, and recycled glass countertops create a luxurious yet sustainable ambiance.</p>
                                <div class="testi-card-quote">
                                    <img src="assets/img/icon/testi-quote.svg" alt="img">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

        <!-- The Modal -->
    <div class="modal" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Left Bags Reservation Form</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal body -->

<div class="modal-body">
    <p class="mb-3 text-muted">
        Fill in the form below and our team will help you find, compare, and book the best flight options for your trip.
    </p>

    <form action="{{ route('connect') }}" method="POST">
        @csrf

        {{-- Full Name --}}
        <div class="mb-3">
            <label class="form-label">Full Name *</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        {{-- Phone --}}
        <div class="mb-3">
            <label class="form-label">Phone Number *</label>
            <input type="tel" name="phone" class="form-control" required>
        </div>

        {{-- Email --}}
        <div class="mb-3">
            <label class="form-label">Email Address</label>
            <input type="email" name="email" class="form-control">
        </div>

        {{-- Trip Type --}}
        <div class="mb-3">
            <label class="form-label">Trip Type *</label>
            <select name="trip_type" class="form-control" required>
                <option value="" disabled selected>Select trip type</option>
                <option value="one_way">One Way</option>
                <option value="round_trip">Round Trip</option>
                <option value="multi_city">Multi-city</option>
            </select>
        </div>

        {{-- Departure --}}
        <div class="mb-3">
            <label class="form-label">Departure City / Airport *</label>
            <input type="text" name="departure" class="form-control" placeholder="e.g. Kigali (KGL)" required>
        </div>

        {{-- Destination --}}
        <div class="mb-3">
            <label class="form-label">Destination City / Airport *</label>
            <input type="text" name="destination" class="form-control" placeholder="e.g. Nairobi (NBO)" required>
        </div>

        {{-- Travel Dates --}}
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Departure Date *</label>
                <input type="date" name="departure_date" class="form-control" required>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Return Date (if applicable)</label>
                <input type="date" name="return_date" class="form-control">
            </div>
        </div>

        {{-- Passengers --}}
        <div class="mb-3">
            <label class="form-label">Number of Passengers *</label>
            <input type="number" name="passengers" class="form-control" min="1" value="1" required>
        </div>

        {{-- Travel Class --}}
        <div class="mb-3">
            <label class="form-label">Preferred Travel Class</label>
            <select name="travel_class" class="form-control">
                <option value="">No preference</option>
                <option value="economy">Economy</option>
                <option value="premium_economy">Premium Economy</option>
                <option value="business">Business</option>
                <option value="first_class">First Class</option>
            </select>
        </div>

        {{-- Additional Notes --}}
        <div class="mb-3">
            <label class="form-label">Additional Requests or Notes</label>
            <textarea name="message" rows="3" class="form-control"
                placeholder="Flexible dates, preferred airline, budget range, special needs, etc."></textarea>
        </div>

        {{-- Actions --}}
        <div class="d-flex justify-content-end gap-2">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                Cancel
            </button>
            <button type="submit" class="btn btn-primary">
                Request Ticketing Support
            </button>
        </div>
    </form>
</div>



            </div>
        </div>
    </div>
@endsection