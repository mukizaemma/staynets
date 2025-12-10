@extends('layouts.frontbase')

@section('content')
<div class="container">
    <div class="row gy-4">
        <div class="col-lg-12">
            <div class="tour-page-single" style="margin: 0 auto;">
                <div class="row">
                    <div class="col-md-5">
                        <div class="global-img">
                            @if($hotel->image && file_exists(storage_path('app/public/images/hotels/' . $hotel->image)))
                                <img src="{{ asset('storage/images/hotels/' . $hotel->image) }}" alt="{{ $hotel->name }}">
                            @else
                                <img src="{{ asset('assets/img/tour/tour_3_1.jpg') }}" alt="{{ $hotel->name }}">
                            @endif
                        </div>
                        <div class="mt-3">
                            <p class="mb-1"><strong>Location:</strong> {{ $hotel->location ?? $hotel->city ?? 'Location not specified' }}</p>
                            <p class="mb-1"><strong>Phone:</strong> {{ $hotel->phone ?? 'N/A' }}</p>
                            <p class="mb-1"><strong>Email:</strong> {{ $hotel->email ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <div class="col-md-7">
                        <h2 class="box-title">{{ $hotel->name }}</h2>

                        @php
                            $stars = (int) filter_var($hotel->stars, FILTER_SANITIZE_NUMBER_INT);
                            $stars = max(0, min(5, $stars));
                        @endphp
                        <div class="tour-rating mb-2">
                            <div class="star-rating" role="img" aria-label="Rated {{ $stars }} out of 5">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $stars)
                                        <i class="fa-solid fa-star" aria-hidden="true"></i>
                                    @else
                                        <i class="fa-regular fa-star" aria-hidden="true"></i>
                                    @endif
                                @endfor
                                <span class="ms-2">({{ $stars }} Rating)</span>
                            </div>
                        </div>

                        <div class="page-content" style="padding-top: 1px !important;">
                            <p class="box-text mb-30">{!! $hotel->description ?? 'No description available.' !!}</p>
                        </div>

                        <div class="tour-action">
                            <a href="{{ route('connect') }}" class="th-btn style4 th-icon">Contact / Book</a>
                            <a href="{{ route('accommodations') }}" class="th-btn style3">Back to Listings</a>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <h3 class="page-title mb-4">Available Rooms</h3>

                @if($rooms->isEmpty())
                    <p>No rooms available for this hotel.</p>
                @else
                    <div class="row gy-4">
                        @foreach($rooms as $room)
                            <div class="col-xxl-4 col-xl-6 col-md-6">
                                <div class="tour-box th-ani">
                                    <div class="tour-box_img global-img">
                                        @if($room->image && file_exists(storage_path('app/public/images/rooms/' . $room->image)))
                                            <img src="{{ asset('storage/images/rooms/' . $room->image) }}" alt="{{ $room->room_type }}">
                                        @else
                                            <img src="{{ asset('assets/img/tour/tour_3_1.jpg') }}" alt="{{ $room->room_type }}">
                                        @endif
                                    </div>

                                    <div class="tour-content">
                                        <h3 class="box-title">
                                            <a href="{{ route('room', $room->slug ?? $room->id) }}">{{ $room->room_type }}</a>
                                        </h3>

                                        <p class="mb-2" style="margin:6px 0;">
                                            <strong>Price / night:</strong> {{ number_format($room->price_per_night, 2) }}
                                        </p>

                                        <p class="mb-2" style="margin:6px 0;">
                                            <i class="fa-solid fa-users"></i> Max: {{ $room->max_occupancy }}
                                            &nbsp;•&nbsp;
                                            <i class="fa-solid fa-door-open"></i> Available: {{ $room->available_rooms ?? 0 }}
                                        </p>

                                        @if(!empty($room->description))
                                            <p class="small" style="margin:6px 0;">{!! \Illuminate\Support\Str::limit($room->description, 120) !!}</p>
                                        @endif

                                        @if(!empty($room->amenities) && is_array($room->amenities))
                                            <div class="room-amenities mt-2">
                                                @foreach($room->amenities as $amen)
                                                    <span class="badge rounded-pill bg-light text-dark me-1 mb-1">{{ $amen }}</span>
                                                @endforeach
                                            </div>
                                        @endif

                                        <div class="tour-action mt-3">
                                        @php
                                            $hotelParam = $hotel->slug ?? $hotel->id ?? ($room->hotel->slug ?? $room->hotel->id ?? null);
                                            $roomParam  = $room->slug  ?? $room->id ?? null;
                                        @endphp

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

                    @if(method_exists($rooms, 'links'))
                        <div class="d-flex justify-content-center mt-4">
                            {{ $rooms->links() }}
                        </div>
                    @endif
                @endif

                <hr class="my-4">

                <h3 class="page-title mb-3">Hotel Map</h3>
                @if($hotel->latitude && $hotel->longitude)
                    <div class="map-wrapper mb-4" style="height:350px;">
                        <iframe
                            width="100%"
                            height="100%"
                            frameborder="0"
                            style="border:0"
                            src="https://www.google.com/maps?q={{ $hotel->latitude }},{{ $hotel->longitude }}&hl=es;z=14&output=embed"
                            allowfullscreen>
                        </iframe>
                    </div>
                @else
                    <p>Map not available for this hotel.</p>
                @endif

            </div>
        </div>
    </div>
</div>
@endsection
