@extends('layouts.frontbase')

@section('content')

@php
$images = $images ?? collect();
if(! ($images instanceof \Illuminate\Support\Collection)) $images = collect($images);
if($images->isEmpty()){
    $fallback = asset('assets/img/tour/tour_inner_2_1.jpg');
    if(!empty($room->image)){
        $img = trim($room->image);
        if(preg_match('#^(https?:)?//#', $img) || \Illuminate\Support\Str::startsWith($img, ['assets/','storage/','public/'])) {
            $fallback = $img;
        } else {
            $roomPath = storage_path('app/public/images/rooms/' . $img);
            $hotelPath = storage_path('app/public/images/hotels/' . $img);
            if(file_exists($roomPath)) $fallback = asset('storage/images/rooms/' . $img);
            elseif(file_exists($hotelPath)) $fallback = asset('storage/images/hotels/' . $img);
        }
    } elseif(!empty($hotel->image)){
        $himg = trim($hotel->image);
        $hotelPath = storage_path('app/public/images/hotels/' . $himg);
        if(file_exists($hotelPath)) $fallback = asset('storage/images/hotels/' . $himg);
        elseif(preg_match('#^(https?:)?//#', $himg) || \Illuminate\Support\Str::startsWith($himg, ['assets/','storage/','public/'])) $fallback = $himg;
    }
    $images = collect([$fallback]);
}
$amenities = $amenities ?? collect();
$relatedRooms = $relatedRooms ?? ($rooms ?? collect());
$trips = $trips ?? collect();
@endphp

<section class="space">
    <div class="container">
        <div style="width:90%; margin:0 auto;">
            <div class="tour-page-single">

                <div class="slider-area tour-slider1">
                    <div class="swiper th-slider mb-4" id="tourSlider4" data-slider-options='{"effect":"fade","loop":true,"thumbs":{"swiper":".tour-thumb-slider"},"autoplayDisableOnInteraction":"true"}'>
                        <div class="swiper-wrapper">
                            @foreach($images as $img)
                                <div class="swiper-slide">
                                    <div class="tour-slider-img">
                                        <img src="{{ $img }}" alt="{{ $room->room_type }}" style="width:100%; height:560px; object-fit:cover;">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="swiper th-slider tour-thumb-slider mt-3" data-slider-options='{"effect":"slide","loop":true,"breakpoints":{"0":{"slidesPerView":2},"576":{"slidesPerView":"2"},"768":{"slidesPerView":"3"},"992":{"slidesPerView":"4"},"1200":{"slidesPerView":"5"}},"autoplayDisableOnInteraction":"true"}'>
                        <div class="swiper-wrapper">
                            @foreach($images as $img)
                                <div class="swiper-slide">
                                    <div class="tour-slider-img">
                                        <img src="{{ $img }}" alt="Image" style="width:100%; height:80px; object-fit:cover; border-radius:6px;">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <button data-slider-prev="#tourSlider4" class="slider-arrow style3 slider-prev"><img src="{{ asset('assets/img/icon/hero-arrow-left.svg') }}" alt=""></button>
                    <button data-slider-next="#tourSlider4" class="slider-arrow style3 slider-next"><img src="{{ asset('assets/img/icon/hero-arrow-right.svg') }}" alt=""></button>
                </div>

                <div class="page-content mt-4">
                    <div class="page-meta mb-30 d-flex align-items-center justify-content-between flex-wrap">
                        <div>
                            <a class="page-tag" href="#">{{ $hotel->name ?? '' }}</a>
                            <span class="ratting ms-3"><i class="fa-sharp fa-solid fa-star"></i><span>{{ number_format((float)($room->rating ?? 4.8), 1) }}</span></span>
                        </div>
                        <div class="text-end">
                            <div style="font-size:18px; font-weight:700;">{{ number_format($room->price_per_night ?? 0, 2) }} <small class="text-muted" style="font-weight:400;">/ night</small></div>
                            <div class="mt-1"><a href="{{ route('connect') }}" class="th-btn style4 th-icon">Book Now</a></div>
                        </div>
                    </div>

                    <h2 class="box-title">{{ $room->room_type }}</h2>

                    <p class="box-text mb-30">{!! nl2br(e($room->description ?? $hotel->description ?? 'No description available.')) !!}</p>

                    <div class="tour-snapshot mb-4">
                        <h4 class="box-title">Room Snapshot</h4>
                        <div class="tour-snap-wrapp d-flex flex-wrap gap-3">
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
                                    <span>{{ number_format($room->price_per_night ?? 0, 2) }}</span>
                                </div>
                            </div>

                            <div class="tour-snap">
                                <div class="icon"><img src="{{ asset('assets/img/icon/ship.svg') }}" alt=""></div>
                                <div class="content">
                                    <span class="title">Available Rooms:</span>
                                    <span>{{ $room->available_rooms ?? 0 }} / {{ $room->total_rooms ?? 0 }}</span>
                                </div>
                            </div>

                            <div class="tour-snap">
                                <div class="icon"><img src="{{ asset('assets/img/icon/01.svg') }}" alt=""></div>
                                <div class="content">
                                    <span class="title">Status</span>
                                    <span>
                                        @if(($room->status ?? '') === 'Available')
                                            <span class="badge" style="background:#e6f9ee;color:#0b7a3a;padding:4px 8px;border-radius:10px;">Available</span>
                                        @else
                                            <span class="badge" style="background:#fff1f0;color:#a30000;padding:4px 8px;border-radius:10px;">Unavailable</span>
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($amenities->isNotEmpty())
                        <div class="tour-snapshot mb-4">
                            <h4 class="box-title">Amenities</h4>
                            <div class="tour-snap-wrapp">
                                <div class="row gx-2 gy-2" style="margin:0;">
                                    @foreach($amenities as $amen)
                                        <div class="col-auto" style="padding:4px;">
                                            <span class="badge" style="display:inline-block;padding:8px 12px;border-radius:8px;background:#f5f6fb;color:#222;">{{ is_object($amen) ? ($amen->title ?? json_encode($amen)) : $amen }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="th-comment-form mt-4">
                        <div class="row gx-4">
                            <div class="col-lg-8">
                                <h3 class="blog-inner-title h4 mb-2">Make reservation</h3>
                                <p class="mb-25">Your email address will not be published. Required fields are marked</p>

                                <form action="{{ route('connect') }}" method="POST" class="row">
                                    @csrf
                                    <input type="hidden" name="room_id" value="{{ $room->id }}">
                                    <input type="hidden" name="hotel_id" value="{{ $hotel->id ?? null }}">

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

                            <div class="col-lg-4 mt-4 mt-lg-0">
                                <div class="card shadow-sm" style="border-radius:8px;">
                                    <div class="card-body">
                                        <h5 style="font-weight:700;margin-bottom:8px;">{{ $room->room_type }}</h5>
                                        <p class="mb-1 text-muted">{{ $hotel->name ?? '' }}</p>
                                        <p style="font-size:18px;font-weight:700;">{{ number_format($room->price_per_night ?? 0,2) }} <small class="text-muted" style="font-weight:400;">/ night</small></p>
                                        <ul class="list-unstyled small mb-3">
                                            <li>Max occupancy: <strong>{{ $room->max_occupancy ?? 0 }}</strong></li>
                                            <li>Available: <strong>{{ $room->available_rooms ?? 0 }}</strong></li>
                                            <li>Type: <strong>{{ $room->room_type ?? '' }}</strong></li>
                                        </ul>
                                        <a href="{{ route('connect') }}" class="btn btn-primary w-100">Contact / Book</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($relatedRooms->isNotEmpty())
                        <div class="related-rooms mt-5">
                            <h4 class="box-title mb-3">Related Rooms</h4>

                            <div class="row gy-4">
                                @foreach($relatedRooms as $r)
                                    <div class="col-xxl-4 col-xl-6 col-md-6">
                                        <div class="tour-box th-ani">
                                            <div class="tour-box_img global-img">
                                                @php
                                                    $imgSrc = asset('assets/img/tour/tour_3_1.jpg');
                                                    if(!empty($r->image)){
                                                        if(preg_match('#^(https?:)?//#', $r->image) || \Illuminate\Support\Str::startsWith($r->image, ['assets/','storage/','public/'])) $imgSrc = $r->image;
                                                        else {
                                                            $p = storage_path('app/public/images/rooms/' . $r->image);
                                                            if(file_exists($p)) $imgSrc = asset('storage/images/rooms/' . $r->image);
                                                        }
                                                    }
                                                @endphp

                                                <img src="{{ $imgSrc }}" alt="{{ $r->room_type }}">
                                            </div>

                                            <div class="tour-content">
                                                <h3 class="box-title">
                                                    @php
                                                        $hotelParam = $hotel->slug ?? $hotel->id ?? ($r->hotel->slug ?? $r->hotel->id ?? null);
                                                        $roomParam  = $r->slug  ?? $r->id ?? null;
                                                    @endphp

                                                    @if($hotelParam && $roomParam)
                                                        <a href="{{ route('roomDetails', ['hotel' => $hotelParam, 'room' => $roomParam]) }}">{{ $r->room_type }}</a>
                                                    @else
                                                        <a href="#">{{ $r->room_type }}</a>
                                                    @endif
                                                </h3>

                                                <p class="mb-2" style="margin:6px 0;">
                                                    <strong>Price / night:</strong> {{ number_format($r->price_per_night ?? 0, 2) }}
                                                </p>

                                                <p class="mb-2" style="margin:6px 0;">
                                                    <i class="fa-solid fa-users"></i> Max: {{ $r->max_occupancy ?? 0 }}
                                                    &nbsp;•&nbsp;
                                                    <i class="fa-solid fa-door-open"></i> Available: {{ $r->available_rooms ?? 0 }}
                                                </p>

                                                @if(!empty($r->description))
                                                    <p class="small" style="margin:6px 0;">{!! \Illuminate\Support\Str::limit($r->description, 120) !!}</p>
                                                @endif

                                                @if(!empty($r->amenities) && is_array($r->amenities))
                                                    <div class="room-amenities mt-2">
                                                        @foreach($r->amenities as $amen)
                                                            <span class="badge rounded-pill bg-light text-dark me-1 mb-1">{{ $amen }}</span>
                                                        @endforeach
                                                    </div>
                                                @endif

                                                <div class="tour-action mt-3">
                                                    @if($hotelParam && $roomParam)
                                                        <a href="{{ route('roomDetails', ['hotel' => $hotelParam, 'room' => $roomParam]) }}" class="th-btn style4 th-icon">View</a>
                                                    @elseif($hotelParam)
                                                        <a href="{{ route('hotel', $hotelParam) }}" class="th-btn style4 th-icon">View hotel</a>
                                                    @else
                                                        <button type="button" class="th-btn style4 th-icon" disabled>View</button>
                                                    @endif

                                                    <a href="{{ route('connect') }}" class="th-btn style3">Book Now</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                        </div>
                    @endif

                </div>
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
            breakpoints: { 0: { slidesPerView: 2 }, 576: { slidesPerView: 2 }, 768: { slidesPerView: 3 }, 992: { slidesPerView: 4 }, 1200: { slidesPerView: 5 } }
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
