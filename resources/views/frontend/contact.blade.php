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
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                                <i class="fa fa-check-circle me-2"></i>{{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                                <i class="fa fa-exclamation-circle me-2"></i>{{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                                <i class="fa fa-exclamation-circle me-2"></i>
                                <strong>Please fix the following errors:</strong>
                                <ul class="mb-0 mt-2">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                    <form class="contact-form2 ajax-contacts" action="{{ route('bookNow') }}" method="POST" enctype="multipart/form-data" id="contactForm">
                            @csrf
                
                        <h5 class="sec-title mb-30 text-capitalize">
                            Contact Us — We're here to help
                        </h5>

                        <p class="mb-20" style="margin-top:-10px;">
                            Select a service type below and we'll show you the relevant fields for your inquiry.
                        </p>

                        <div class="row">
                            <!-- Service Type Selector -->
                            <div class="form-group col-12 mb-3">
                                <label class="form-label mb-2" style="font-weight: 600;">Service Type <span class="text-danger">*</span></label>
                                <select name="service_type" id="service_type" class="form-select nice-select" required>
                                    <option value="">Select Service Type</option>
                                    <option value="enquiry" {{ old('service_type') == 'enquiry' ? 'selected' : '' }}>General Enquiry</option>
                                    <option value="hotel_booking" {{ old('service_type') == 'hotel_booking' ? 'selected' : '' }}>Hotel Booking</option>
                                    <option value="tour_booking" {{ old('service_type') == 'tour_booking' ? 'selected' : '' }}>Tour Booking</option>
                                    <option value="question" {{ old('service_type') == 'question' ? 'selected' : '' }}>Just a Question</option>
                                </select>
                            </div>

                            <!-- Hotel Booking Fields -->
                            <div id="hotel_booking_fields" class="d-none">
                                <div class="form-group col-12">
                                    <label class="form-label mb-2" style="font-weight: 600;">Select Room <span class="text-danger">*</span></label>
                                    <select name="room_id" id="room_id" class="form-select nice-select">
                                        <option value="" selected disabled>Select A Room</option>
                                        @foreach ($rooms as $room)
                                            <option value="{{ $room->id }}" {{ old('room_id') == $room->id ? 'selected' : '' }}>{{ $room->title }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Select Other Services -->
                                <div class="form-group col-12">
                                    <label class="form-label mb-2" style="font-weight: 600;">Other Services</label>
                                    <select name="facility_id" id="facility_id" class="form-select nice-select">
                                        <option value="" selected>Optional - Select Other Services</option>
                                        @foreach ($facilities as $facility)
                                            <option value="{{ $facility->id }}" {{ old('facility_id') == $facility->id ? 'selected' : '' }}>{{ $facility->title }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-lg-6 col-sm-12 form-group">
                                    <label class="form-label mb-2" style="font-weight: 600;">Number of Nights</label>
                                    <input type="number" class="form-control" name="nights" id="nights" placeholder="Nights" value="{{ old('nights') }}" min="1">
                                    <img src="assets/img/icon/night.svg" alt="">
                                </div>

                                <div class="col-lg-6 col-sm-12 form-group">
                                    <label class="form-label mb-2" style="font-weight: 600;">Number of Guests</label>
                                    <input type="number" class="form-control" name="guests" id="guests" placeholder="Guests" value="{{ old('guests') }}" min="1">
                                    <img src="assets/img/icon/user.svg" alt="">
                                </div>

                                <div class="col-lg-6 col-sm-12 form-group">
                                    <label class="form-label mb-2" style="font-weight: 600;">Check-in Date</label>
                                    <input type="date" class="form-control" name="checkin_date" id="checkin_date" value="{{ old('checkin_date') }}" min="{{ date('Y-m-d') }}">
                                </div>

                                <div class="col-lg-6 col-sm-12 form-group">
                                    <label class="form-label mb-2" style="font-weight: 600;">Check-out Date</label>
                                    <input type="date" class="form-control" name="checkout_date" id="checkout_date" value="{{ old('checkout_date') }}" min="{{ date('Y-m-d') }}">
                                </div>
                            </div>

                            <!-- Tour Booking Fields -->
                            <div id="tour_booking_fields" class="d-none">
                                <div class="form-group col-12">
                                    <label class="form-label mb-2" style="font-weight: 600;">Select Tour</label>
                                    <select name="tour_id" id="tour_id" class="form-select nice-select">
                                        <option value="" selected>Optional - Select a Tour</option>
                                        @php
                                            $allTours = \App\Models\Trip::where('status', 'active')->get();
                                        @endphp
                                        @foreach ($allTours as $tour)
                                            <option value="{{ $tour->id }}" {{ old('tour_id') == $tour->id ? 'selected' : '' }}>{{ $tour->title }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-lg-6 col-sm-12 form-group">
                                    <label class="form-label mb-2" style="font-weight: 600;">Preferred Date</label>
                                    <input type="date" class="form-control" name="tour_date" id="tour_date" value="{{ old('tour_date') }}" min="{{ date('Y-m-d') }}">
                                </div>

                                <div class="col-lg-6 col-sm-12 form-group">
                                    <label class="form-label mb-2" style="font-weight: 600;">Number of People</label>
                                    <input type="number" class="form-control" name="tour_people" id="tour_people" placeholder="Number of People" value="{{ old('tour_people') }}" min="1">
                                    <img src="assets/img/icon/user.svg" alt="">
                                </div>
                            </div>

                            <!-- Common Fields (Always Visible) -->
                            <!-- Full Name -->
                            <div class="col-12 form-group">
                                <label class="form-label mb-2" style="font-weight: 600;">Full Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="names" id="name3" placeholder="Your Full Name" value="{{ old('names') }}" required>
                                <img src="assets/img/icon/user.svg" alt="">
                            </div>

                            <!-- Email & Phone on same line -->
                            <div class="col-lg-6 col-sm-12 form-group">
                                <label class="form-label mb-2" style="font-weight: 600;">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" name="email" id="email3" placeholder="Your Email" value="{{ old('email') }}" required>
                                <img src="assets/img/icon/mail.svg" alt="">
                            </div>

                            <div class="col-lg-6 col-sm-12 form-group">
                                <label class="form-label mb-2" style="font-weight: 600;">Phone <span class="text-danger">*</span></label>
                                <input type="tel" class="form-control" name="phone" id="phone" placeholder="Your Phone" value="{{ old('phone') }}" required>
                                <img src="assets/img/icon/phone.svg" alt="">
                            </div>

                            <!-- Message Field (Different placeholders based on service type) -->
                            <div class="form-group col-12">
                                <label class="form-label mb-2" style="font-weight: 600;">Message <span class="text-danger">*</span></label>
                                <textarea name="message" id="message" cols="30" rows="4" class="form-control" placeholder="Your message..." required>{{ old('message') }}</textarea>
                                <img src="assets/img/icon/chat.svg" alt="">
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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const serviceType = document.getElementById('service_type');
    const hotelFields = document.getElementById('hotel_booking_fields');
    const tourFields = document.getElementById('tour_booking_fields');
    const messageField = document.getElementById('message');
    
    // Default placeholders for message field
    const messagePlaceholders = {
        'enquiry': 'Please describe your enquiry in detail...',
        'hotel_booking': 'Any special requests or additional information for your hotel booking?',
        'tour_booking': 'Any special requests or additional information for your tour booking?',
        'question': 'What would you like to know?',
        'default': 'Your message...'
    };

    function toggleFields() {
        if (!serviceType) return;
        
        const selectedType = serviceType.value;
        
        // Hide all service-specific fields
        if (hotelFields) {
            hotelFields.classList.add('d-none');
        }
        if (tourFields) {
            tourFields.classList.add('d-none');
        }
        
        // Remove required attributes from hotel fields
        const hotelRequiredFields = ['room_id', 'nights', 'guests'];
        hotelRequiredFields.forEach(fieldId => {
            const field = document.getElementById(fieldId);
            if (field) {
                field.removeAttribute('required');
            }
        });
        
        // Show relevant fields based on service type
        if (selectedType === 'hotel_booking') {
            if (hotelFields) {
                hotelFields.classList.remove('d-none');
                // Make room_id required
                const roomId = document.getElementById('room_id');
                if (roomId) {
                    roomId.setAttribute('required', 'required');
                }
            }
        } else if (selectedType === 'tour_booking') {
            if (tourFields) {
                tourFields.classList.remove('d-none');
            }
        }
        
        // Update message placeholder
        if (messageField) {
            const placeholder = messagePlaceholders[selectedType] || messagePlaceholders['default'];
            messageField.setAttribute('placeholder', placeholder);
        }
    }
    
    // Add event listener
    if (serviceType) {
        serviceType.addEventListener('change', toggleFields);
        
        // Set initial state based on old value if validation failed
        @if(old('service_type'))
            toggleFields();
        @endif
        
        // Initial call
        toggleFields();
    }
});
</script>
@endpush