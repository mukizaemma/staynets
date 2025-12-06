@extends('layouts.frontbase')

@section('content')


    <div class="space bg-smoke">
        <div class="container">
            <div class="title-area text-center">
                <h2 class="sec-title">Directly call us and let us know how we can serve you.</h2>
            </div>
            <div class="row gy-4 justify-content-center">

                <div class="col-xl-4 col-lg-6">
                    <div class="about-contact-grid">
                        <div class="about-contact-icon">
                            <img src="assets/img/icon/call.svg" alt="">
                        </div>
                        <div class="about-contact-details">
                            <h6 class="box-title">Phone Number</h6>
                            <p class="about-contact-details-text"><a href="tel:{{ $setting->phone }}">{{ $setting->phone }}</a></p>
                            <p class="about-contact-details-text"><a href="tel:{{ $setting->phone1 }}">{{ $setting->phone1 }}</a></p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6">
                    <div class="about-contact-grid">
                        <div class="about-contact-icon">
                            <img src="assets/img/icon/mail.svg" alt="">
                        </div>
                        <div class="about-contact-details">
                            <h6 class="box-title">Email Address</h6>
                            <p class="about-contact-details-text"><a href="mailto:{{ $setting->email }}">{{ $setting->email }}</a></p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6">
                    <div class="about-contact-grid style2">
                        <div class="about-contact-icon">
                            <img src="assets/img/icon/location-dot2.svg" alt="">
                        </div>
                        <div class="about-contact-details">
                            <h6 class="box-title">Our Address</h6>
                            <p class="about-contact-details-text">{{ $setting->address }}</p>
                            {{-- <p class="about-contact-details-text">Rwanda</p> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

        <div class="space-extra2-top space-extra2-bottom" data-bg-src="assets/img/bg/contact.jpg">
        <div class="container">
            <div class="row flex-row-reverse justify-content-center align-items-center">
                <div class="col-lg-6">
                    <div class="video-box1">
                        <a href="https://youtube.com/shorts/ks01kSxAmi4" class="play-btn style2 popup-video"><i class="fa-sharp fa-solid fa-play"></i></a>
                    </div>

                </div>
                <div class="col-lg-6">
                    <div>
                    <form class="contact-form2 ajax-contacts" action="{{ route('bookNow') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                
                        <h5 class="sec-title mb-30 text-capitalize">
                            If it's easier for you, kindly complete the form below to request your stay. 
                            Your booking will be confirmed after we review availability.
                        </h5>

                        <div class="row">

                            <!-- Select Room -->
                            <div class="form-group col-12">
                                <select name="room_id" id="room_id" class="form-select nice-select">
                                    <option value="" selected disabled>Select A Room</option>
                                    @foreach ($rooms as $room)
                                        <option value="{{ $room->id }}">{{ $room->title }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Select Other Services -->
                            <div class="form-group col-12">
                                <select name="facility_id" id="facility_id" class="form-select nice-select">
                                    <option value="" selected disabled>Other Services</option>
                                    @foreach ($facilities as $facility)
                                        <option value="{{ $facility->id }}">{{ $facility->title }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-lg-6 col-sm-12 form-group">
                                <input type="number" class="form-control" name="nights" id="email3" placeholder="Nights">
                                <img src="assets/img/icon/night.svg" alt="">
                            </div>

                            <div class="col-lg-6 col-sm-12 form-group">
                                <input type="number" class="form-control" name="guests" id="phone" placeholder="Guests">
                                <img src="assets/img/icon/user.svg" alt="">
                            </div>
                            <!-- Additional Request -->
                            <div class="form-group col-12">
                                <textarea name="message" id="message" cols="30" rows="3" class="form-control" placeholder="Any Additional Request?"></textarea>
                                <img src="assets/img/icon/chat.svg" alt="">
                            </div>

                            <!-- Full Name -->
                            <div class="col-12 form-group">
                                <input type="text" class="form-control" name="names" id="name3" placeholder="Your Full Name">
                                <img src="assets/img/icon/user.svg" alt="">
                            </div>

                            <!-- Email & Phone on same line -->
                            <div class="col-lg-6 col-sm-12 form-group">
                                <input type="email" class="form-control" name="email" id="email3" placeholder="Your Email">
                                <img src="assets/img/icon/mail.svg" alt="">
                            </div>

                            <div class="col-lg-6 col-sm-12 form-group">
                                <input type="number" class="form-control" name="phone" id="phone" placeholder="Your Phone">
                                <img src="assets/img/icon/phone.svg" alt="">
                            </div>
                            <!-- Submit Button -->
                            <div class="form-btn col-12 mt-24">
                                <button type="submit" class="th-btn style3">
                                    Submit Now <img src="assets/img/icon/plane.svg" alt="">
                                </button>
                            </div>
                        </div>

                        <p class="form-messages mb-0 mt-3"></p>
                    </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection