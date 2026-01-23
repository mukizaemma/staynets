@extends('layouts.frontbase')

@section('content')

    <!--==============================
    Breadcumb
============================== -->
    <div class="breadcumb-wrapper" data-bg-src="{{ asset('assets/img/bg/breadcumb-bg-1.jpg') }}">
        <div class="container">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">Trip Destinations</h1>
                <ul class="breadcumb-menu">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li>Trip Destinations</li>
                </ul>
            </div>
        </div>
    </div>

    <!--==============================
    Destinations Area
==============================-->
    <section class="space">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-8">
                    <div class="title-area text-center">
                        <h2 class="sec-title">Explore Our Trip Destinations</h2>
                        <p class="sec-text">Discover amazing destinations and their exciting activities</p>
                    </div>
                </div>
            </div>

            <div class="row gy-30">
                @forelse($destinations as $destination)
                    <div class="col-lg-4 col-md-6">
                        <div class="tour-box th-ani" style="height: 100%;">
                            <div class="tour-box_img global-img" style="position: relative;">
                                @if($destination->image && file_exists(storage_path('app/public/images/trip-destinations/' . $destination->image)))
                                    <img src="{{ asset('storage/images/trip-destinations/' . $destination->image) }}" alt="{{ $destination->name }}" style="height: 250px; object-fit: cover;">
                                @else
                                    <img src="{{ asset('assets/img/tour/tour_3_1.jpg') }}" alt="{{ $destination->name }}" style="height: 250px; object-fit: cover;">
                                @endif
                                <div style="position: absolute; top: 15px; right: 15px; background: rgba(37, 211, 102, 0.95); color: white; padding: 8px 15px; border-radius: 8px; font-weight: 600; font-size: 14px;">
                                    {{ $destination->trips->count() }} Activities
                                </div>
                            </div>
                            <div class="tour-content">
                                <h3 class="box-title">
                                    <a href="{{ route('tripDestination', $destination->slug) }}">{{ $destination->name }}</a>
                                </h3>
                                <div class="tour-rating">
                                    @if($destination->location)
                                        <p style="margin: 5px 0;">
                                            <i class="fa-solid fa-location-dot text-primary me-2"></i>{{ $destination->location }}
                                        </p>
                                    @endif
                                    @if($destination->description)
                                        <p class="mt-2" style="font-size: 14px; color: #666;">
                                            {{ \Illuminate\Support\Str::limit(strip_tags($destination->description), 100) }}
                                        </p>
                                    @endif
                                </div>
                                <div class="tour-action">
                                    <a href="{{ route('tripDestination', $destination->slug) }}" class="th-btn style4 th-icon">View Activities</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="text-center py-5">
                            <p class="text-muted">No trip destinations available at the moment.</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

@endsection








