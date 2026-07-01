@extends('layouts.frontbase')

@section('meta_title', $page['title'])
@section('meta_description', $page['meta_description'])
@section('canonical_url', $canonical)

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/car-rental.css') }}">
@endpush

@section('content')
<section class="space-top space-extra-bottom car-rental-page">
    <div class="container">
        <div class="car-rental-hero mb-4">
            <div class="car-rental-hero__inner">
                <span class="car-rental-hero__badge"><i class="fa fa-car"></i> Car Rental</span>
                <h1 class="car-rental-hero__title">{{ $page['heading'] }}</h1>
                <p class="car-rental-hero__subtitle">{{ $page['subheading'] }}</p>
                <p class="car-rental-hero__desc">{{ $page['intro'] }}</p>
                <div class="d-flex flex-wrap gap-2 mt-3">
                    <a href="{{ route('showCars') }}" class="th-btn style3">View Full Fleet</a>
                    @if(whatsappUrl(primaryPhone($setting)))
                        <a href="{{ whatsappUrl(primaryPhone($setting)) }}" class="th-btn style4" target="_blank" rel="noopener">WhatsApp Us</a>
                    @endif
                </div>
            </div>
        </div>

        @if($cars->count() > 0)
            <div class="car-fleet-section-head">
                <h3>Recommended vehicles <span class="car-fleet-count">{{ $cars->count() }} shown</span></h3>
            </div>
            <div id="accommodations-results">
                <div class="row gy-4">
                    @foreach($cars as $car)
                        <div class="col-xxl-4 col-xl-6 col-md-6">
                            @include('frontend.partials.car-fleet-card', ['car' => $car, 'layout' => 'grid'])
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <div class="alert alert-info text-center">
                No matching vehicles are listed right now. <a href="{{ route('showCars') }}">Browse our full fleet</a> or contact us for availability.
            </div>
        @endif
    </div>
</section>
@endsection