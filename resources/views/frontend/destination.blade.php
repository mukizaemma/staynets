@extends('layouts.frontbase')

@section('content')



    <!--==============================
    Breadcumb
============================== -->
    <div class="breadcumb-wrapper " data-bg-src="{{ asset('storage/images/destinations/' . $category->image) }}">
        <div class="container">
            <div class="breadcumb-content">
                <ul class="breadcumb-menu">
                    {{-- <li><a href="{{ route('home') }}">Home</a></li> --}}
                      <h1 class="breadcumb-title">{{ $category->name }} Details</h1>
                </ul>
            </div>
        </div>
    </div>
    <!--==============================
Product Area
==============================-->
    <section class="space">
        <div class="container">
            <div class="row">
                <div class="col-xxl-8 col-lg-7">
                <div class="row gy-24 gx-24">
                    @forelse($hotels as $hotel)
                        <div class="col-md-6">
                            <div class="tour-box th-ani">
                                <div class="tour-box_img global-img">
                                    @if($hotel->image && file_exists(storage_path('app/public/images/hotels/' . $hotel->image)))
                                        <img src="{{ asset('storage/images/hotels/' . $hotel->image) }}" alt="{{ $hotel->name }}">
                                    @else
                                        {{-- fallback image (keeps style unchanged) --}}
                                        <img src="{{ asset('assets/img/tour/tour_5_1.jpg') }}" alt="{{ $hotel->name }}">
                                    @endif
                                </div>

                                <div class="tour-content">
                                    <h3 class="box-title">
                                        <a href="{{ route('hotelRooms', $hotel->slug) }}">{{ $hotel->name }}</a>
                                    </h3>

                                    {{-- Stars --}}
                                    <div class="tour-rating" aria-hidden="false">
                                        @php
                                            // try to convert stored stars to integer (defensive)
                                            $stars = (int) $hotel->stars;
                                            $stars = max(0, min(5, $stars)); // clamp 0..5
                                        @endphp

                                        <div class="star-rating" role="img" aria-label="{{ $stars }} out of 5 stars">
                                            {{-- visual star icons (keeps look, change icons if you use different fontawesome) --}}
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $stars)
                                                    <i class="fa-solid fa-star" aria-hidden="true"></i>
                                                @else
                                                    <i class="fa-regular fa-star" aria-hidden="true"></i>
                                                @endif
                                            @endfor
                                            <span class="sr-only">{{ $stars }} out of 5</span>
                                        </div>
                                    </div>

                                    {{-- Location --}}
                                    <p class="mb-2" style="margin:6px 0;">
                                        <i class="fa-solid fa-location-dot" aria-hidden="true"></i>
                                        {{ $hotel->location ?? $hotel->city ?? 'Location not specified' }}
                                    </p>

                                    {{-- View more button --}}
                                    <div class="tour-action">
                                        {{-- you can add other meta like duration or price here if you have them --}}
                                        <a href="{{ route('hotelRooms', $hotel->slug) }}" class="th-btn style4">View More</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <p class="text-center">No hotels found for this category yet.</p>
                        </div>
                    @endforelse
                </div>

                  {{-- pagination (if $hotels is a paginator) --}}
                  @if(method_exists($hotels, 'links'))
                      <div class="row mt-24">
                          <div class="col-12 d-flex justify-content-center">
                              {{ $hotels->links() }}
                          </div>
                      </div>
                  @endif

                </div>
                <div class="col-xxl-4 col-lg-5">
                    <aside class="sidebar-area">
                        <div class="widget widget_search  ">
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
                                        <a href="{{route('tour',['slug'=>$destination->slug])}}"><img src="{{ asset('storage/images/trips/' .$destination->image) }}" alt="Blog Image"></a>
                                    </div>
                                    <div class="media-body">
                                        <h4 class="post-title"><a class="text-inherit" href="{{route('tour',['slug'=>$destination->slug])}}">{{ $destination->title }}</a></h4>

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


@endsection