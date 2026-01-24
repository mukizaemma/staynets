@extends('layouts.frontbase')

@section('content')


    <div class="about-area position-relative overflow-hidden overflow-hidden space bg-smoke" id="about-sec">
        <div class="container space">
            <div class="row">
                <div class="col-xl-7">
                    <div class="img-box3">
                        <div class="img2">
                            <img src="{{ asset('storage/images/ticketing/' . ($data->image ?? '')) }}" alt="About">
                        </div>
                    </div>
                </div>
                <div class="col-xl-5">
                    <div class="ps-xl-4">
                        <div class="title-area mb-20">
                            <h2 class="sec-title mb-20 pe-xl-5 me-xl-5 heading">{{ $data->heading ?? '' }}</h2>
                        </div>
                        <p class="pe-xl-5">{!! $data->description ?? '' !!}</p>

                        <a href="{{ route('ticketing.request') }}" class="btn th-btn style3 th-icon">
                            Request for Air Ticketing Support
                        </a>

                    </div>
                </div>
            </div>
            <div class="shape-mockup movingX d-none d-xxl-block" data-top="0%" data-left="-18%">
                <img src="assets/img/shape/shape_2_1.png" alt="shape">
            </div>
            <div class="shape-mockup jump d-none d-xxl-block" data-top="28%" data-right="-15%">
                <img src="assets/img/shape/shape_2_2.png" alt="shape">
            </div>
            <div class="shape-mockup spin d-none d-xxl-block" data-bottom="18%" data-left="-112%">
                <img src="assets/img/shape/shape_2_3.png" alt="shape">
            </div>
            <div class="shape-mockup movixgX d-none d-xxl-block" data-bottom="18%" data-right="-12%">
                <img src="assets/img/shape/shape_2_4.png" alt="shape">
            </div>
        </div>
    </div>


@endsection