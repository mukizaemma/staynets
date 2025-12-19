@extends('layouts.frontbase')

@section('content')

<section class="space">
    <div class="container">
        <div style="width:90%; margin:0 auto;">
            <div class="tour-page-single">

                {{-- ================= IMAGE SLIDER ================= --}}
                <div class="slider-area tour-slider1">
                    <div class="swiper th-slider mb-4" id="tourSlider4" data-slider-options='{"effect":"fade","loop":true,"thumbs":{"swiper":".tour-thumb-slider"},"autoplayDisableOnInteraction":"true"}'>
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <div class="tour-slider-img">
                                    <img src="{{ asset('storage/images/cars/' . $car->image) }}" alt="{{ $car->name }}" style="width:100%; height:560px; object-fit:cover;">
                                </div>
                            </div>
       
                        </div>
                    </div>

                    {{-- <div class="swiper th-slider tour-thumb-slider mt-3" data-slider-options='{"effect":"slide","loop":true,"breakpoints":{"0":{"slidesPerView":2},"576":{"slidesPerView":"2"},"768":{"slidesPerView":"3"},"992":{"slidesPerView":"4"},"1200":{"slidesPerView":"5"}},"autoplayDisableOnInteraction":"true"}'>
                        <div class="swiper-wrapper">
                            @foreach($images as $img)
                                <div class="swiper-slide">
                                    <div class="tour-slider-img">
                                        <img src="{{ asset('storage/images/cars/' . $car->images) }}" alt="Image" style="width:100%; height:80px; object-fit:cover; border-radius:6px;">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div> --}}

                    <button data-slider-prev="#tourSlider4" class="slider-arrow style3 slider-prev"><img src="{{ asset('assets/img/icon/hero-arrow-left.svg') }}" alt=""></button>
                    <button data-slider-next="#tourSlider4" class="slider-arrow style3 slider-next"><img src="{{ asset('assets/img/icon/hero-arrow-right.svg') }}" alt=""></button>
                </div>

                {{-- ================= HEADER ================= --}}
                <div class="page-content mt-4">

                    <div class="page-meta mb-30 d-flex justify-content-between flex-wrap">
                        <div>
                            <h2 class="mb-1">{{ $car->name }}</h2>
                            <div class="small text-muted">
                                {{ $car->model }} • {{ $car->fuel_type }} • {{ $car->transmission }}
                            </div>
                        </div>

                        <div class="text-end">
                            @if($car->price_to_buy)
                                <div style="font-size:20px;font-weight:700;">
                                    {{ number_format($car->price_to_buy) }} RWF
                                    <small class="text-muted">For Sale</small>
                                </div>
                            @elseif($car->price_per_day)
                                <div style="font-size:20px;font-weight:700;">
                                    {{ number_format($car->price_per_day) }} RWF
                                    <small class="text-muted">/ day</small>
                                </div>
                            @endif
                            <a href="{{ route('connect') }}" class="th-btn style4 mt-2">Book Now</a>
                        </div>
                    </div>

                    {{-- ================= DESCRIPTION ================= --}}
                    <h4 class="box-title mb-2">Advert Description</h4>
                    <p class="box-text mb-30">
                        {!! nl2br(e($car->description ?? 'No description available.')) !!}
                    </p>

                    {{-- ================= CAR SPECIFICATIONS ================= --}}
                    <div class="tour-snapshot mb-4">
                        <h4 class="box-title">Car Specifications</h4>

                        <div class="tour-snap-wrapp d-flex flex-wrap gap-3">

                            <div class="tour-snap">
                                <div class="icon"><i class="fa-solid fa-car"></i></div>
                                <div class="content">
                                    <span class="title">Model</span>
                                    <span>{{ $car->model }}</span>
                                </div>
                            </div>

                            <div class="tour-snap">
                                <div class="icon"><i class="fa-solid fa-gas-pump"></i></div>
                                <div class="content">
                                    <span class="title">Fuel</span>
                                    <span>{{ $car->fuel_type }}</span>
                                </div>
                            </div>

                            <div class="tour-snap">
                                <div class="icon"><i class="fa-solid fa-cogs"></i></div>
                                <div class="content">
                                    <span class="title">Transmission</span>
                                    <span>{{ $car->transmission }}</span>
                                </div>
                            </div>

                            <div class="tour-snap">
                                <div class="icon"><i class="fa-solid fa-users"></i></div>
                                <div class="content">
                                    <span class="title">Seats</span>
                                    <span>{{ $car->seats }}</span>
                                </div>
                            </div>

                            <div class="tour-snap">
                                <div class="icon"><i class="fa-solid fa-check-circle"></i></div>
                                <div class="content">
                                    <span class="title">Status</span>
                                    <span class="badge"
                                          style="background:#e6f9ee;color:#0b7a3a;">
                                          {{ ucfirst($car->status) }}
                                    </span>
                                </div>
                            </div>

                        </div>
                    </div>

                    {{-- ================= BOOKING FORM ================= --}}
                    <div class="th-comment-form mt-4">
                        <div class="row gx-4">

                            <div class="col-lg-8">
                                <h3 class="h4 mb-2">Request Booking</h3>

                                <form action="{{ route('connect') }}" method="POST" class="row">
                                    @csrf
                                    <input type="hidden" name="car_id" value="{{ $car->id }}">

                                    <div class="col-md-6 form-group">
                                        <input type="text" name="name" placeholder="Full Name*" class="form-control" required>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <input type="email" name="email" placeholder="Email*" class="form-control" required>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <input type="tel" name="phone" placeholder="Phone*" class="form-control" required>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <input type="date" name="start_date" class="form-control">
                                    </div>

                                    <div class="col-12 form-group">
                                        <textarea name="message" placeholder="Additional requests" class="form-control"></textarea>
                                    </div>

                                    <div class="col-12">
                                        <button class="th-btn w-100">Send Booking Request</button>
                                    </div>
                                </form>
                            </div>

                            {{-- ================= SUMMARY CARD ================= --}}
                            <div class="col-lg-4 mt-4 mt-lg-0">
                                <div class="card shadow-sm">
                                    <div class="card-body">
                                        <h5>{{ $car->name }}</h5>
                                        <p class="text-muted mb-2">
                                            {{ $car->model }} • {{ $car->fuel_type }}
                                        </p>

                                        <p style="font-size:18px;font-weight:700;">
                                            @if($car->price_to_buy)
                                                {{ number_format($car->price_to_buy) }} RWF
                                                <small class="text-muted">For Sale</small>
                                            @else
                                                {{ number_format($car->price_per_day) }} RWF
                                                <small class="text-muted">/ day</small>
                                            @endif
                                        </p>

                                        <ul class="list-unstyled small">
                                            <li>Seats: <strong>{{ $car->seats }}</strong></li>
                                            <li>Status: <strong>{{ ucfirst($car->status) }}</strong></li>
                                        </ul>

                                        <a href="{{ route('connect') }}" class="btn btn-primary w-100">Contact / Book</a>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    {{-- ================= RELATED CARS ================= --}}
                    @if($allCars->isNotEmpty())
                        <div class="related-rooms mt-5">
                            <h4 class="box-title mb-3">Related Cars</h4>

                            <div class="row gy-4">
                                @foreach($allCars as $r)
                                    <div class="col-xxl-4 col-xl-6">
                                        <div class="tour-box th-ani">
                                        <div class="tour-box_img global-img"
                                            style="height:250px; overflow:hidden;">
                                            @if($car->images && file_exists(storage_path('app/public/images/cars/' . $car->images)))
                                                <img src="{{ asset('storage/images/cars/' . $car->images) }}"
                                                    alt="{{ $car->name }}"
                                                    style="width:100%; height:100%; object-fit:cover;">
                                            @else
                                                <img src="{{ asset('assets/img/tour/tour_3_1.jpg') }}"
                                                    alt="{{ $car->name }}"
                                                    style="width:100%; height:100%; object-fit:cover;">
                                            @endif
                                        </div>


                                            <div class="tour-content">
                                                <h3 class="box-title">
                                                    <a href="{{ route('carDetails', $car->slug ?? $car->id) }}">{{ $car->name }}</a>
                                                </h3>

                                                <ul class="list-unstyled mb-3 small text-muted row">
                                                    <li class="col-6 mb-1"><i class="fa fa-car me-1"></i> {{ $car->model }}</li>
                                                    <li class="col-6 mb-1"><i class="fa fa-gas-pump me-1"></i> {{ $car->fuel_type }}</li>
                                                    <li class="col-6 mb-1"><i class="fa fa-cogs me-1"></i> {{ $car->transmission }}</li>
                                                    <li class="col-6 mb-1"><i class="fa fa-users me-1"></i> {{ $car->seats }} seats</li>
                                                </ul>

                                                <div class="tour-action">
                                                    <div class="mt-auto">
                                                        @if($car->price_per_day !== null)
                                                            <p class="fw-bold mb-2">
                                                                {{ number_format($car->price_per_day) }} RWF
                                                                <span class="text-muted fw-normal">/ day</span>
                                                            </p>
                                                        @elseif($car->price_per_day || $car->price_per_month)
                                                            {{-- FOR RENT --}}
                                                            <p class="fw-bold mb-2">
                                                                {{ number_format($car->price_per_day ?? $car->price_per_month) }} RWF
                                                                <span class="fw-normal text-muted">
                                                                    / {{ $car->price_per_day ? 'day' : 'month' }}
                                                                </span>
                                                            </p>
                                                        @endif
                                                    </div>
                                                    <a href="{{ route('carDetails', $car->slug ?? $car->id) }}" class="th-btn style3">Book Now</a>
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
        const thumbs = new Swiper('.tour-thumb-slider', {
            slidesPerView: 4,
            spaceBetween: 10
        });

        new Swiper('#tourSlider4', {
            effect: 'fade',
            loop: true,
            autoplay: { delay: 5000 },
            thumbs: { swiper: thumbs }
        });
    }
});
</script>
@endpush

@endsection
