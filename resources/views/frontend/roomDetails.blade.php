@extends('layouts.frontbase')

@section('content')
<style>
    /* Gallery Styles - Same as property view */
    .image-gallery-main {
        position: relative;
        width: 100%;
        height: 500px;
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 10px;
        background: #f0f0f0;
        cursor: pointer;
    }
    .image-gallery-main img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .image-gallery-thumbs {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 10px;
    }
    .gallery-thumb {
        position: relative;
        height: 120px;
        border-radius: 8px;
        overflow: hidden;
        cursor: pointer;
        opacity: 0.8;
        transition: opacity 0.3s;
    }
    .gallery-thumb:hover {
        opacity: 1;
    }
    .gallery-thumb.active {
        opacity: 1;
        border: 3px solid #0071c2;
    }
    .gallery-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .gallery-overlay {
        position: absolute;
        bottom: 15px;
        right: 15px;
        background: rgba(0,0,0,0.7);
        color: white;
        padding: 8px 15px;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
    }
    .gallery-thumbnail.active {
        border: 2px solid #0071c2 !important;
    }
    .gallery-thumbnail:hover {
        opacity: 0.8;
    }
    @media (max-width: 991px) {
        .image-gallery-main {
            height: 300px;
        }
        .image-gallery-thumbs {
            grid-template-columns: repeat(3, 1fr);
        }
    }
    @media (max-width: 767px) {
        .image-gallery-thumbs {
            grid-template-columns: repeat(2, 1fr);
        }
    }
</style>

@php
$allImages = $images ?? collect();
if(! ($allImages instanceof \Illuminate\Support\Collection)) {
    $allImages = collect($allImages);
}
// Ensure images have url key
if($allImages->isNotEmpty() && !isset($allImages->first()['url'])) {
    $allImages = $allImages->map(function($img) {
        if(is_string($img)) {
            return ['url' => $img, 'type' => 'room', 'caption' => ''];
        }
        return $img;
    });
}
$mainImage = $allImages->isNotEmpty() ? $allImages->first()['url'] : asset('assets/img/tour/tour_inner_2_1.jpg');
$amenities = $amenities ?? collect();
$relatedRooms = $relatedRooms ?? ($rooms ?? collect());
$trips = $trips ?? collect();
@endphp

<section class="space">
    <div class="container">
        <div style="width:90%; margin:0 auto;">
            <div class="tour-page-single">

                <!-- Image Gallery - Same layout as property view -->
                <div class="mb-4">
                    <div class="image-gallery-main">
                        <img src="{{ $mainImage }}" alt="{{ $room->room_type }}" id="mainGalleryImage" onclick="openGalleryModal(0)">
                        @if($allImages->count() > 1)
                            <div class="gallery-overlay" onclick="openGalleryModal(0)">
                                <i class="fas fa-images"></i> View all {{ $allImages->count() }} photos
                            </div>
                        @endif
                    </div>
                    @if($allImages->count() > 1)
                        <div class="image-gallery-thumbs">
                            @foreach($allImages->take(4) as $index => $img)
                                <div class="gallery-thumb {{ $index == 0 ? 'active' : '' }}" onclick="changeMainImage('{{ $img['url'] }}', this, {{ $index }})">
                                    <img src="{{ $img['url'] }}" alt="Gallery thumbnail">
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="page-content mt-4">
                    <div class="page-meta mb-30 d-flex align-items-center justify-content-between flex-wrap">
                        <div>
                            <a class="page-tag" href="#">{{ $hotel->name ?? '' }}</a>
                            <span class="ratting ms-3"><i class="fa-sharp fa-solid fa-star"></i><span>{{ number_format((float)($room->rating ?? 4.8), 1) }}</span></span>
                        </div>
                        <div class="text-end">
                            @php
                                $roomCurrency = $room->currency ?? 'USD';
                                $roomCurrencySymbol = getCurrencySymbol($roomCurrency);
                            @endphp
                            <div style="font-size:18px; font-weight:700;">{{ $roomCurrencySymbol }}{{ number_format($room->price_per_night ?? 0, 2) }} <small class="text-muted" style="font-weight:400;">/ night</small></div>
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
                                    <span>{{ $roomCurrencySymbol }}{{ number_format($room->price_per_night ?? 0, 2) }}</span>
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
                                        <p style="font-size:18px;font-weight:700;">{{ $roomCurrencySymbol }}{{ number_format($room->price_per_night ?? 0,2) }} <small class="text-muted" style="font-weight:400;">/ night</small></p>
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
                                                    @php
                                                        $relatedRoomCurrency = $r->currency ?? 'USD';
                                                        $relatedRoomCurrencySymbol = getCurrencySymbol($relatedRoomCurrency);
                                                    @endphp
                                                    <strong>Price / night:</strong> {{ $relatedRoomCurrencySymbol }}{{ number_format($r->price_per_night ?? 0, 2) }}
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

<!-- Gallery Modal - Same as property view -->
<div class="modal fade" id="galleryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content bg-dark">
            <div class="modal-header border-0">
                <h5 class="modal-title text-white">Photo Gallery - {{ $room->room_type }}</h5>
                <span class="text-white me-3" id="galleryCounter">1 / {{ $allImages->count() }}</span>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0 position-relative" style="display: flex; align-items: center; justify-content: center; min-height: 80vh;">
                <button class="btn btn-light position-absolute" style="left: 20px; top: 50%; transform: translateY(-50%); z-index: 10;" onclick="previousImage()" id="prevBtn">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <img id="galleryMainImage" src="" alt="Gallery Image" style="max-width: 90%; max-height: 80vh; object-fit: contain;">
                <button class="btn btn-light position-absolute" style="right: 20px; top: 50%; transform: translateY(-50%); z-index: 10;" onclick="nextImage()" id="nextBtn">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
            <div class="modal-footer border-0 bg-dark">
                <div class="w-100">
                    <div class="d-flex gap-2 overflow-auto pb-2" style="max-height: 120px;">
                        @foreach($allImages as $index => $img)
                            <img src="{{ $img['url'] }}" 
                                 alt="Thumbnail" 
                                 class="gallery-thumbnail {{ $index == 0 ? 'active' : '' }}" 
                                 style="width: 100px; height: 80px; object-fit: cover; border-radius: 8px; cursor: pointer; border: 2px solid transparent;"
                                 onclick="showImage({{ $index }})"
                                 data-index="{{ $index }}">
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Gallery images array
    const galleryImages = @json($allImages->map(function($img) { return $img['url']; })->values());
    let currentImageIndex = 0;
    
    function changeMainImage(src, thumbElement, index = 0) {
        document.getElementById('mainGalleryImage').src = src;
        currentImageIndex = index;
        if (thumbElement) {
            document.querySelectorAll('.gallery-thumb').forEach(el => el.classList.remove('active'));
            thumbElement.classList.add('active');
        }
    }
    
    function openGalleryModal(startIndex = 0) {
        currentImageIndex = startIndex;
        showImage(startIndex);
        const modal = new bootstrap.Modal(document.getElementById('galleryModal'));
        modal.show();
    }
    
    function showImage(index) {
        if (index < 0 || index >= galleryImages.length) return;
        currentImageIndex = index;
        document.getElementById('galleryMainImage').src = galleryImages[index];
        document.getElementById('galleryCounter').textContent = (index + 1) + ' / ' + galleryImages.length;
        
        // Update thumbnails
        document.querySelectorAll('.gallery-thumbnail').forEach((thumb, i) => {
            if (i === index) {
                thumb.classList.add('active');
            } else {
                thumb.classList.remove('active');
            }
        });
    }
    
    function nextImage() {
        const next = (currentImageIndex + 1) % galleryImages.length;
        showImage(next);
    }
    
    function previousImage() {
        const prev = (currentImageIndex - 1 + galleryImages.length) % galleryImages.length;
        showImage(prev);
    }
    
    // Keyboard navigation
    document.addEventListener('keydown', function(e) {
        const modal = document.getElementById('galleryModal');
        if (modal && modal.classList.contains('show')) {
            if (e.key === 'ArrowRight') {
                nextImage();
            } else if (e.key === 'ArrowLeft') {
                previousImage();
            } else if (e.key === 'Escape') {
                bootstrap.Modal.getInstance(modal).hide();
            }
        }
    });
</script>

@endsection
