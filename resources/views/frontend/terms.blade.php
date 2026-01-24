@extends('layouts.frontbase')
<base href="/public">
@section('content')


<section class="page-header bg--cover" style="background-image: url({{ asset('assets/img/bg/breadcumb-bg-1.jpg') }});">
    <div class="container">
        <div class="page-header__content text-center">
            <h2>Terms & Policies</h2>
        </div>
    </div>
</section>

<section class="space bg-smoke">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h3 class="mb-3">Terms and Conditions</h3>
                        <div class="mb-4">
                            {!! $terms->terms ?? '' !!}
                        </div>

                        <h4 class="mt-4">Privacy Policy</h4>
                        <div class="mb-3">{!! $terms->privacy ?? '' !!}</div>

                        @if(!empty($terms->privacy_details))
                            <h4 class="mt-4">Privacy Details</h4>
                            <div class="mb-3">{!! $terms->privacy_details !!}</div>
                        @endif

                        @if(!empty($terms->cookies))
                            <h4 class="mt-4">Cookies</h4>
                            <div class="mb-3">{!! $terms->cookies !!}</div>
                        @endif

                        @if(!empty($terms->refunds))
                            <h4 class="mt-4">Refunds</h4>
                            <div class="mb-3">{!! $terms->refunds !!}</div>
                        @endif

                        @if(!empty($terms->booking_cancellation))
                            <h4 class="mt-4">Booking Cancellation</h4>
                            <div class="mb-3">{!! $terms->booking_cancellation !!}</div>
                        @endif

                        @if(!empty($terms->listing_commission))
                            <h4 class="mt-4">Listing Commission</h4>
                            <div class="mb-3">{!! $terms->listing_commission !!}</div>
                        @endif

                        @if(!empty($terms->payment_methods))
                            <h4 class="mt-4">Payment Methods</h4>
                            <div class="mb-3">{!! $terms->payment_methods !!}</div>
                        @endif

                        @if(!empty($terms->support))
                            <h4 class="mt-4">Support Policy</h4>
                            <div class="mb-3">{!! $terms->support !!}</div>
                        @endif

                        @if(!empty($terms->return))
                            <h4 class="mt-4">Returns Policy</h4>
                            <div class="mb-3">{!! $terms->return !!}</div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h4 class="mb-3">Latest Properties</h4>
                        <ul class="list-unstyled mb-0">
                            @forelse($properties as $property)
                                <li class="d-flex align-items-center mb-3">
                                    <div class="me-3">
                                        <a href="{{ route('hotel', $property->slug ?? $property->id) }}">
                                            @php
                                                $thumb = $property->featured_image
                                                    ? asset('storage/images/properties/' . $property->featured_image)
                                                    : asset('assets/img/tour/tour_3_1.jpg');
                                            @endphp
                                            <img src="{{ $thumb }}" alt="{{ $property->name }}" style="width: 70px; height: 55px; object-fit: cover; border-radius: 8px;">
                                        </a>
                                    </div>
                                    <div>
                                        <a href="{{ route('hotel', $property->slug ?? $property->id) }}" style="font-size: 15px; color: #333;">{{ $property->name }}</a>
                                    </div>
                                </li>
                            @empty
                                <li class="text-muted">No properties available.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection