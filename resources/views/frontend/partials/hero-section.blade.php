@php
    $heroBg = (optional($setting)->home_background_image ?? null)
        ? asset('storage/images/site/' . optional($setting)->home_background_image)
        : (isset($about) && $about && $about->image1 ? asset('storage/images/about/' . $about->image1) : asset('assets/img/bg/breadcumb-bg-1.jpg'));
    $hasSlides = isset($slides) && $slides->isNotEmpty();
@endphp

<div class="th-hero-wrapper hero-7 hero-home" id="hero" @unless($hasSlides) data-bg-src="{{ $heroBg }}" @endunless style="position: relative; overflow: hidden; @unless($hasSlides) background-size: cover; background-position: center; @endunless">
    @if($hasSlides)
        <div id="homeHeroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="7000" style="position: absolute; inset: 0; z-index: 0;">
            <div class="carousel-inner h-100">
                @foreach($slides as $key => $slide)
                    @php
                        $slideUrl = asset('storage/images/slides/' . ltrim($slide->image ?? '', '/'));
                    @endphp
                    <div class="carousel-item {{ $key === 0 ? 'active' : '' }} h-100">
                        <div style="position: absolute; inset: 0; background: url('{{ $slideUrl }}') center center / cover no-repeat;"></div>
                    </div>
                @endforeach
            </div>
            @if($slides->count() > 1)
                <button class="carousel-control-prev" type="button" data-bs-target="#homeHeroCarousel" data-bs-slide="prev" style="z-index: 2;">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#homeHeroCarousel" data-bs-slide="next" style="z-index: 2;">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            @endif
        </div>
    @else
        <div style="position: absolute; inset: 0; background: url('{{ $heroBg }}') center center / cover no-repeat; z-index: 0;"></div>
    @endif

    <div class="hero-overlay" style="position: absolute; inset: 0; background: linear-gradient(180deg, rgba(0,0,0,0.25) 0%, rgba(0,0,0,0.45) 100%); z-index: 1;"></div>

    <div class="container h-100" style="position: relative; z-index: 2;">
        <div class="row align-items-center justify-content-center h-100" style="min-height: 60vh; min-height: 60dvh; padding-top: 56px;">
            <div class="col-12">
                <div class="hero-style7 text-center" style="padding: 40px 0 30px 0;">
                    @if($hasSlides)
                        <div id="heroSlideCaptions">
                            @foreach($slides as $key => $slide)
                                <div class="hero-slide-caption {{ $key === 0 ? '' : 'd-none' }}" data-slide-index="{{ $key }}">
                                    @if($slide->heading)
                                        <h1 class="hero-title text-white mb-2" style="font-size: clamp(1.75rem, 4vw, 2.75rem); font-weight: 700;">{{ $slide->heading }}</h1>
                                    @endif
                                    @if($slide->subheading)
                                        <p class="text-white mb-4" style="font-size: clamp(1rem, 2.5vw, 1.25rem); opacity: 0.95;">{{ $slide->subheading }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        @if($slides->every(fn($s) => empty($s->heading) && empty($s->subheading)))
                            <h1 class="hero-title hero-tagline text-white mb-4">Stay Nets helps travelers book hotels, apartments, tour activities and car rentals across Rwanda and East Africa</h1>
                        @endif
                    @else
                        <h1 class="hero-title hero-tagline text-white mb-4">Stay Nets helps travelers book hotels, apartments, tour activities and car rentals across Rwanda and East Africa</h1>
                    @endif
                    <div class="btn-group mb-4 flex-wrap justify-content-center">
                        <a href="{{ route('hotels') }}" class="th-btn th-icon style3">Hotels</a>
                        <a href="{{ route('apartments') }}" class="th-btn style2 th-icon">Apartments</a>
                    </div>
                </div>

                <div class="row justify-content-center mt-4">
                    <div class="col-12">
                        <form action="{{ route('hotelsSearch') }}" method="GET" id="heroSearchForm" class="hero-search-form bg-white rounded-3 p-3" style="max-width: 900px; margin: 0 auto; background: #ffffff !important; border: 1px solid rgba(0,0,0,0.08) !important; box-shadow: 0 10px 40px rgba(0,0,0,0.2), 0 2px 10px rgba(0,0,0,0.1) !important;">
                            <div class="row g-2 align-items-center">
                                <div class="col-12 col-md-4 col-xl-3">
                                    <div class="position-relative">
                                        <i class="fas fa-map-marker-alt position-absolute" style="left: 14px; top: 50%; transform: translateY(-50%); color: #888; font-size: 14px;"></i>
                                        <input type="text" name="location" list="hero-destinations" class="form-control form-control-sm" placeholder="Type destination, address or city — or choose All" value="{{ request('location') }}" autocomplete="off" style="padding-left: 38px; border-radius: 8px; height: 44px;">
                                        <datalist id="hero-destinations">
                                            <option value="All">All Destinations</option>
                                            @if(isset($searchLocations) && $searchLocations->isNotEmpty())
                                                @foreach($searchLocations as $loc)
                                                    <option value="{{ $loc }}">{{ $loc }}</option>
                                                @endforeach
                                            @elseif(isset($locations) && $locations->isNotEmpty())
                                                @foreach($locations as $loc)
                                                    <option value="{{ $loc }}">{{ $loc }}</option>
                                                @endforeach
                                            @endif
                                        </datalist>
                                    </div>
                                </div>
                                <div class="col-12 col-md-3 col-xl-2">
                                    <div class="position-relative">
                                        <i class="fas fa-calendar-check position-absolute" style="left: 14px; top: 50%; transform: translateY(-50%); color: #888; font-size: 14px;"></i>
                                        <input type="date" name="checkin" id="checkinDate" class="form-control form-control-sm" value="{{ request('checkin') }}" min="{{ date('Y-m-d') }}" style="padding-left: 38px; border-radius: 8px; height: 44px;">
                                    </div>
                                </div>
                                <div class="col-12 col-md-3 col-xl-2">
                                    <div class="position-relative">
                                        <i class="fas fa-calendar-times position-absolute" style="left: 14px; top: 50%; transform: translateY(-50%); color: #888; font-size: 14px;"></i>
                                        <input type="date" name="checkout" id="checkoutDate" class="form-control form-control-sm" value="{{ request('checkout') }}" min="{{ date('Y-m-d', strtotime('+1 day')) }}" style="padding-left: 38px; border-radius: 8px; height: 44px;">
                                    </div>
                                </div>
                                <div class="col-12 col-md-3 col-xl-2">
                                    @include('frontend.partials.guests_rooms_selector', ['selectorId' => 'hero-guests-rooms'])
                                </div>
                                <div class="col-12 col-md-4 col-xl-2">
                                    <button type="submit" class="btn btn-primary w-100" style="border-radius: 8px; height: 44px; font-weight: 600;">
                                        <i class="fas fa-search me-2"></i>Search
                                    </button>
                                </div>
                            </div>
                            <div id="formMessages" class="small mt-2" style="display: none;"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if($hasSlides && $slides->count() > 1)
<script>
document.addEventListener('DOMContentLoaded', function () {
    var carousel = document.getElementById('homeHeroCarousel');
    if (!carousel) return;
    carousel.addEventListener('slid.bs.carousel', function (e) {
        document.querySelectorAll('.hero-slide-caption').forEach(function (el) {
            el.classList.add('d-none');
        });
        var cap = document.querySelector('.hero-slide-caption[data-slide-index="' + e.to + '"]');
        if (cap) cap.classList.remove('d-none');
    });
});
</script>
@endif
