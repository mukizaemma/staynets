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
                    @forelse($trips as $hotel)
                        <div class="col-md-6">
                            <div class="tour-box th-ani">
                                <div class="tour-box_img global-img">
                                    @if($hotel->image && file_exists(storage_path('app/public/images/trips/' . $hotel->image)))
                                        <img src="{{ asset('storage/images/trips/' . $hotel->image) }}" alt="{{ $hotel->title }}">
                                    @else
                                        {{-- fallback image (keeps style unchanged) --}}
                                        <img src="{{ asset('assets/img/tour/tour_5_1.jpg') }}" alt="{{ $hotel->title }}">
                                    @endif
                                </div>

                                <div class="tour-content">
                                    <h3 class="box-title">
                                        <a href="{{ route('hotelRooms', $hotel->slug) }}">{{ $hotel->title }}</a>
                                    </h3>


                                    {{-- Location --}}
                                    <p class="mb-2" style="margin:6px 0;">
                                        <i class="fa-solid fa-location-dot" aria-hidden="true"></i>
                                        {{ $hotel->location ?? $hotel->city ?? 'Location not specified' }}
                                    </p>

                                    {{-- View more button --}}
                                    <div class="tour-action">
                                        {{-- you can add other meta like duration or price here if you have them --}}
                                        <a href="{{ route('tour', $hotel->slug) }}" class="th-btn style4">View More</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <p class="text-center">No activities found for this destination yet.</p>
                        </div>
                    @endforelse
                </div>

                  {{-- pagination (if $hotels is a paginator) --}}
                  @if(method_exists($trips, 'links'))
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