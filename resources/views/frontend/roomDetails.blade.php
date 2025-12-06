@extends('layouts.frontbase')

@section('content')

<section class="space">
    <div class="container">
        <div class="row">
            <div class="col-xxl-8 col-lg-7">
                <div class="tour-page-single">
                    <div class="slider-area tour-slider1">
                        <div class="swiper th-slider mb-4" id="tourSlider4" data-slider-options='{"effect":"fade","loop":true,"thumbs":{"swiper":".tour-thumb-slider"},"autoplayDisableOnInteraction":"true"}'>
                            <div class="swiper-wrapper">
                                @foreach($images as $img)
                                    <div class="swiper-slide">
                                        <div class="tour-slider-img">
                                            <img src="{{ $img }}" alt="{{ $room->room_type }}">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="swiper th-slider tour-thumb-slider" data-slider-options='{"effect":"slide","loop":true,"breakpoints":{"0":{"slidesPerView":2},"576":{"slidesPerView":"2"},"768":{"slidesPerView":"3"},"992":{"slidesPerView":"3"},"1200":{"slidesPerView":"3"}},"autoplayDisableOnInteraction":"true"}'>
                            <div class="swiper-wrapper">
                                @foreach($images as $img)
                                    <div class="swiper-slide">
                                        <div class="tour-slider-img">
                                            <img src="{{ $img }}" alt="Image">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <button data-slider-prev="#tourSlider4" class="slider-arrow style3 slider-prev"><img src="{{ asset('assets/img/icon/hero-arrow-left.svg') }}" alt=""></button>
                        <button data-slider-next="#tourSlider4" class="slider-arrow style3 slider-next"><img src="{{ asset('assets/img/icon/hero-arrow-right.svg') }}" alt=""></button>
                    </div>

                    <div class="page-content">
                        <div class="page-meta mb-45">
                            <a class="page-tag" href="#">{{ $hotel->name }}</a>
                            <span class="ratting"><i class="fa-sharp fa-solid fa-star"></i><span>{{ number_format((float)($room->rating ?? 4.8), 1) }}</span></span>
                        </div>

                        <h2 class="box-title">{{ $room->room_type }}</h2>

                        <p class="box-text mb-30">{!! nl2br(e($room->description ?? $hotel->description ?? 'No description available.')) !!}</p>

                        <div class="tour-snapshot">
                            <h4 class="box-title">Room Snapshot</h4>
                            <div class="tour-snap-wrapp">

                                <div class="tour-snap">
                                    <div class="icon"><i class="fa-light fa-clock"></i></div>
                                    <div class="content">
                                        <span class="title">Max Occupancy:</span>
                                        <span>{{ $room->max_occupancy }}</span>
                                    </div>
                                </div>

                                <div class="tour-snap">
                                    <div class="icon"><img src="{{ asset('assets/img/icon/guide2.svg') }}" alt=""></div>
                                    <div class="content">
                                        <span class="title">Price Per Night:</span>
                                        <span>{{ number_format($room->price_per_night, 2) }}</span>
                                    </div>
                                </div>

                                <div class="tour-snap">
                                    <div class="icon"><img src="{{ asset('assets/img/icon/ship.svg') }}" alt=""></div>
                                    <div class="content">
                                        <span class="title">Available Rooms:</span>
                                        <span>{{ $room->available_rooms }} / {{ $room->total_rooms }}</span>
                                    </div>
                                </div>

                                <div class="tour-snap">
                                    <div class="icon"><img src="{{ asset('assets/img/icon/01.svg') }}" alt=""></div>
                                    <div class="content">
                                        <span class="title">Status</span>
                                        <span>
                                            @if($room->status === 'Available')
                                                <span class="badge" style="background:#e6f9ee;color:#0b7a3a;padding:4px 8px;border-radius:10px;">Available</span>
                                            @else
                                                <span class="badge" style="background:#fff1f0;color:#a30000;padding:4px 8px;border-radius:10px;">Unavailable</span>
                                            @endif
                                        </span>
                                    </div>
                                </div>

                            </div>
                        </div>

                        @if(!empty($amenities))
                            <div class="tour-snapshot mt-30">
                                <h4 class="box-title">Amenities</h4>
                                <div class="tour-snap-wrapp">
                                    <div class="row gx-2 gy-2" style="margin:0;">
                                        @foreach($amenities as $amen)
                                            <div class="col-auto" style="padding:4px;">
                                                <span class="badge" style="display:inline-block;padding:6px 10px;border-radius:6px;background:#f5f6fb;color:#222;">{{ $amen }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif

                    </div>

                    <div class="th-comment-form ">
                        <div class="row">
                            <h3 class="blog-inner-title h4 mb-2">Make reservation</h3>
                            <p class="mb-25">Your email address will not be published. Required fields are marked</p>

                            <form action="{{ route('bookRoom') }}" method="POST" class="row">
                                @csrf
                                <input type="hidden" name="room_id" value="{{ $room->id }}">
                                <input type="hidden" name="hotel_id" value="{{ $hotel->id }}">

                                <div class="col-md-6 form-group">
                                    <input type="text" name="name" placeholder="Full Name*" class="form-control" required>
                                    <i class="far fa-user"></i>
                                </div>

                                <div class="col-md-6 form-group">
                                    <input type="email" name="email" placeholder="Your Email*" class="form-control" required>
                                    <i class="far fa-envelope"></i>
                                </div>

                                <div class="col-md-6 form-group">
                                    <input type="tel" name="phone" placeholder="Phone*" class="form-control" required>
                                    <i class="far fa-phone"></i>
                                </div>

                                <div class="col-md-6 form-group">
                                    <input type="date" name="arrival_date" placeholder="Arrival date" class="form-control">
                                    <i class="far fa-calendar"></i>
                                </div>

                                <div class="col-12 form-group">
                                    <textarea name="message" placeholder="Additional requests" class="form-control"></textarea>
                                    <i class="far fa-pencil"></i>
                                </div>

                                <div class="col-12 form-group mb-0">
                                    <button class="th-btn" type="submit">Request Booking <img src="{{ asset('assets/img/icon/plane2.svg') }}" alt=""></button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-xxl-4 col-lg-5">
                <aside class="sidebar-area">
                    <div class="widget widget_search">
                        <form class="search-form">
                            <input type="text" placeholder="Search">
                            <button type="submit"><i class="far fa-search"></i></button>
                        </form>
                    </div>

                    <div class="widget">
                        <h3 class="widget_title">Our Top Upcoming Trips</h3>
                        <div class="recent-post-wrap">
                            @foreach ($trips as $destination)
                                <div class="recent-post">
                                    <div class="media-img">
                                        <a href="{{ route('tour', ['slug' => $destination->slug]) }}"><img src="{{ asset('storage/images/trips/' . $destination->image) }}" alt="Blog Image"></a>
                                    </div>
                                    <div class="media-body">
                                        <h4 class="post-title"><a class="text-inherit" href="{{ route('tour', ['slug' => $destination->slug]) }}">{{ $destination->title }}</a></h4>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </aside>
            </div>

        </div>
    </div>
</section>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    if (typeof Swiper !== 'undefined') {
        var thumb = new Swiper('.tour-thumb-slider', {
            loop: true,
            slidesPerView: 3,
            breakpoints: { 0: { slidesPerView: 2 }, 576: { slidesPerView: 2 }, 768: { slidesPerView: 3 }, 992: { slidesPerView: 3 }, 1200: { slidesPerView: 3 } }
        });

        var main = new Swiper('#tourSlider4', {
            effect: 'fade',
            loop: true,
            autoplay: { delay: 5000 },
            thumbs: { swiper: thumb }
        });
    }
});
</script>
@endpush

@endsection
