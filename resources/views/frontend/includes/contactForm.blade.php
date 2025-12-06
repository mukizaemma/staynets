<div class="space-extra2-top space" data-bg-src="{{ asset('storage/images/about') . $about->image2 }}">
    <div class="container">
        <div class="row flex-row-reverse justify-content-center align-items-center">
            <div class="col-lg-6">
                <div class="video-box1">
                    <a href="https://youtube.com/shorts/ks01kSxAmi4" class="play-btn style2 popup-video" aria-label="Watch short video about our stay">
                        <i class="fa-sharp fa-solid fa-play"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-6">
                <div>
                    <form class="contact-form2 ajax-contacts" action="{{ route('bookNow') }}" method="POST" enctype="multipart/form-data" novalidate>
                        @csrf

                        <!-- Stronger CTA -->
                        <h5 class="sec-title mb-30 text-capitalize">
                            Request Your Stay — we'll confirm availability shortly
                        </h5>

                        <p class="mb-20" style="margin-top:-10px;">
                            Tell us how we can help and we'll reply within <strong>24 hours</strong>. Or call/WhatsApp us at
                            <a href="tel:+250xxxxxxxx">+250 xxx xxx xxx</a>.
                        </p>

                        <div class="row">
                            <!-- Honeypot to reduce spam (hidden from users by CSS inline here so no style files changed) -->
                            <div style="display:none;">
                                <label for="website">Leave this field empty</label>
                                <input type="text" name="_hp" id="website" autocomplete="off">
                            </div>

                            <div class="form-group col-12">
                                <textarea name="message" id="message" cols="30" rows="3" class="form-control" placeholder="How would you like us to serve you?" aria-label="Booking message" required></textarea>
                                <img src="assets/img/icon/chat.svg" alt="">
                            </div>

                            <!-- Full Name -->
                            <div class="col-12 form-group">
                                <input type="text" class="form-control" name="names" id="name3" placeholder="Full name (e.g., John Doe)" aria-label="Full name" required>
                                <img src="assets/img/icon/user.svg" alt="">
                            </div>

                            <!-- Email & Phone on same line -->
                            <div class="col-lg-6 col-sm-12 form-group">
                                <input type="email" class="form-control" name="email" id="email3" placeholder="Email (we'll send confirmation)" aria-label="Email" required>
                                <img src="assets/img/icon/mail.svg" alt="">
                            </div>

                            <div class="col-lg-6 col-sm-12 form-group">
                                <input
                                    type="tel"
                                    class="form-control"
                                    name="phone"
                                    id="phone"
                                    placeholder="Phone (WhatsApp number preferred)"
                                    aria-label="Phone"
                                    inputmode="tel"
                                    pattern="^\+?[0-9\s\-]{7,20}$"
                                    required
                                >
                                <img src="assets/img/icon/phone.svg" alt="">
                            </div>

                            <!-- Optional: quick selects (keeps layout simple) -->
                            <div class="col-lg-6 col-sm-12 form-group">
                                <input type="text" class="form-control" name="arrival_date" id="arrival" placeholder="Arrival date (optional)" aria-label="Arrival date">
                            </div>

                            <div class="col-lg-6 col-sm-12 form-group">
                                <input type="text" class="form-control" name="nights" id="nights" placeholder="Nights (optional)" aria-label="Number of nights">
                            </div>

                            <!-- Submit Button + microcopy -->
                            <div class="form-btn col-12 mt-24">
                                <button type="submit" class="th-btn style3" aria-label="Submit booking request">
                                    Request Booking <img src="assets/img/icon/plane.svg" alt="">
                                </button>
                                <small class="d-block mt-2">No payment required to request — we’ll confirm availability first.</small>
                            </div>
                        </div>

                        <!-- Accessible live region for success / error messages (JS can target .form-messages) -->
                        <p class="form-messages mb-0 mt-3" aria-live="polite" role="status"></p>

                        <!-- Privacy reassurance -->
                        <p class="mt-2 mb-0" style="font-size:0.9em; opacity:0.9;">
                            We respect your privacy. Your details are used only to process this request.
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
