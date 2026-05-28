{{-- Shared marketing footer + WhatsApp float. $setting is shared globally (AppServiceProvider). --}}
@php
    $reviewsCount = \App\Models\Review::where('is_approved', true)->count();
    $reviewsAvg = \App\Models\Review::where('is_approved', true)->avg('rating') ?? 0;
@endphp
<!--==============================
	Footer Area
==============================-->
<footer class="footer-wrapper bg-title footer-layout2 site-footer-enhanced">
    <div class="widget-area">
        <div class="container">
            <div class="row g-4 g-lg-5 align-items-start justify-content-between">
                <div class="col-12 col-lg-4">
                    <div class="widget footer-widget footer-widget--brand mb-0">
                        <div class="th-widget-about">
                            <div class="about-logo">
                                <a href="{{ route('home') }}"><img src="{{ asset('storage/images/' . ($setting->logo ?? '')) }}"
                                   width="120" alt="{{ $setting->company ?? 'StayNets' }}"></a>
                            </div>
                            <p class="about-text">The Best Hospitality Services Management in Rwanda</p>
                            <div class="th-social th-social--footer">
                                <a href="https://www.facebook.com/" rel="noopener noreferrer" target="_blank" aria-label="Facebook"><i class="fab fa-facebook-f" aria-hidden="true"></i></a>
                                <a href="https://instagram.com/" rel="noopener noreferrer" target="_blank" aria-label="Instagram"><i class="fab fa-instagram" aria-hidden="true"></i></a>
                                <a href="https://www.tiktok.com/" rel="noopener noreferrer" target="_blank" aria-label="TikTok"><i class="fab fa-tiktok" aria-hidden="true"></i></a>
                            </div>

                            <div class="footer-book-cta mt-4">
                                <a href="{{ route('hotelsSearch') }}" class="th-btn style3 th-icon footer-book-btn">Book With Us</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="widget widget_nav_menu footer-widget mb-0">
                        <h3 class="widget_title">Quick Links</h3>
                        <div class="menu-all-pages-container">
                            <ul class="menu footer-quick-links">
                                <li><a href="{{ route('hotelsSearch') }}">Accommodation Booking</a></li>
                                <li><a href="{{ route('tours') }}">Tour Experiences</a></li>
                                <li><a href="{{ route('showCars') }}">Car Rental</a></li>
                                <li><a href="{{ route('connect') }}">Travel Support</a></li>
                                <li><a href="{{ route('about') }}">About Stay Nets</a></li>
                                <li><a href="{{ route('terms') }}">Terms &amp; Conditions</a></li>
                            </ul>
                        </div>
                        <div class="footer-reviews-card mt-4 pt-3">
                            <div class="footer-reviews-card__head">
                                <span class="footer-reviews-card__icon" aria-hidden="true"><i class="fas fa-star"></i></span>
                                <span class="footer-reviews-card__label">Customer reviews</span>
                            </div>
                            <div class="footer-reviews-card__stats">
                                <span class="footer-reviews-card__rating">{{ number_format($reviewsAvg, 1) }}</span>
                                <span class="footer-reviews-card__outof">/ 5</span>
                                <span class="footer-reviews-card__dot" aria-hidden="true">·</span>
                                <span class="footer-reviews-card__count">{{ $reviewsCount }} {{ $reviewsCount === 1 ? 'review' : 'reviews' }}</span>
                            </div>
                            <a href="{{ route('reviews.index') }}" class="footer-reviews-card__link">See all reviews <i class="fas fa-arrow-right ms-1" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="widget footer-widget mb-0">
                        <h3 class="widget_title">Get In Touch</h3>
                        <div class="th-widget-contact">
                            <div class="info-box_text">
                                <div class="icon" aria-hidden="true">
                                    <img src="{{ asset('assets/img/icon/phone.svg') }}" alt="">
                                </div>
                                <div class="details">
                                    <p class="info-box_label mb-0">Phone</p>
                                    <p class="mb-0"><a href="tel:{{ $setting->phone ?? '' }}" class="info-box_link">{{ $setting->phone ?? '' }}</a></p>
                                </div>
                            </div>
                            <div class="info-box_text">
                                <div class="icon" aria-hidden="true">
                                    <img src="{{ asset('assets/img/icon/envelope.svg') }}" alt="">
                                </div>
                                <div class="details">
                                    <p class="info-box_label mb-0">Email</p>
                                    <p class="mb-0"><a href="mailto:{{ $setting->email ?? '' }}" class="info-box_link">{{ $setting->email ?? '' }}</a></p>
                                </div>
                            </div>
                            <div class="info-box_text">
                                <div class="icon" aria-hidden="true"><img src="{{ asset('assets/img/icon/location-dot.svg') }}" alt=""></div>
                                <div class="details">
                                    <p class="info-box_label mb-0">Location</p>
                                    <p class="mb-0">{{ $setting->address ?? '' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="copyright-wrap">
        <div class="container">
            <div class="row justify-content-between align-items-center">
                <div class="col-12 text-center">
                    <p class="copyright-text mb-0">&copy; {{ date('Y') }}, All rights reserved by <a href="{{ route('home') }}">{{ optional($setting)->company ?? 'Stay Nests' }}</a>. <span class="copyright-meta">Crafted by <a href="https://www.iremetech.com" target="_blank" rel="noopener noreferrer">Ireme Technologies</a></span></p>
                </div>
            </div>

        </div>
    </div>
    <div class="shape-mockup movingX d-none d-xxl-block" data-top="24%" data-left="5%">
        <img src="{{ asset('assets/img/shape/shape_8.png') }}" alt="">
    </div>
</footer>

@php
    $rawPhone = optional($setting)->phone ?: optional($setting)->phone1 ?: '250788316330';
    $whatsappNumber = preg_replace('/\D/', '', $rawPhone) ?: '250788316330';
@endphp
<a href="https://wa.me/{{ $whatsappNumber }}" target="_blank" class="whatsapp-float" rel="noopener noreferrer" aria-label="Contact us on WhatsApp">
    <i class="fab fa-whatsapp"></i>
</a>
