@extends('layouts.frontbase')
<base href="/public">
@section('content')


<section class="page-header bg--cover" style="background-image: url(images/slider-1.jpg)">
    <div class="container">
      <div class="page-header__content text-center">
        <h2>{{ $room->title ?? '' }}</h2>

      </div>
    </div>
  </section>

  <section class="room padding-top padding-bottom">
    <div class="container">
      <div class="room__wrapper">
        <div class="row g-5">
          <div class="col-lg-8">
            <div class="room__details">
              <div class="room__details-content">
                <h3>Our Terms and Conditions</h3>
                <div class="room__details-text">
                  <p>
                    {!! $about->storyDescription ?? '' !!}
                  </p>
                </div>
              </div>
            </div>
            
          </div>

          <div class="col-lg-4 col-md-8" style="padding: 20px; background-color: #f9f9f9; border-radius: 8px;">
            <h2 style="font-size: 24px; color: #333; margin-bottom: 20px;">Our Rooms</h2>
            <ul style="list-style-type: none; padding: 0;">
                @foreach ($rooms as $rs )
                <li style="display: flex; align-items: center; margin-bottom: 15px; background-color: #fff; padding: 10px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
                    <!-- Image on the left -->
                    <div style="flex-shrink: 0; margin-right: 15px;">
                        <a href="{{ route('room',['slug'=>$rs->slug]) }}">
                            <img src="{{ asset('storage/images/rooms/' .$rs->image) }}" alt="Single Room with Balcony" style="width: 80px; height: 60px; object-fit: cover; border-radius: 8px;">
                        </a>
                    </div>
                    <!-- Title and Price on the right -->
                    <div style="flex-grow: 1; display: flex; justify-content: space-between; align-items: left;">
                        <div>

                            <a href="{{ route('room',['slug'=>$rs->slug]) }}" style="font-size: 18px; color: #333;text-align: left;">{{ $rs->title }}</a>
                            {{-- <span style="font-size: 16px; font-weight: bold; color: #007bff;">$120/night</span> --}}
                        </div>

                    </div>
                </li>
                @endforeach

                <!-- Add more rooms here following the same structure -->
            </ul>
            {{-- <hr>
            <h2 style="font-size: 24px; color: #333; margin-bottom: 20px;">Our Trips</h2>
            <ul style="list-style-type: none; padding: 0;">
                @foreach ($trips as $tour )
                <li style="display: flex; align-items: center; margin-bottom: 15px; background-color: #fff; padding: 10px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">

                    <div style="flex-shrink: 0; margin-right: 15px;">
                        <a href="{{route('tour',['slug'=>$tour->slug])}}">
                            <img src="{{ asset('storage/images/trips/' .$tour->image) }}" alt="Single Room with Balcony" style="width: 80px; height: 60px; object-fit: cover; border-radius: 8px;">
                        </a>
                    </div>
          
                    <div style="flex-grow: 1; display: flex; justify-content: space-between; align-items: left;">
                        <div>

                            <a href="{{route('tour',['slug'=>$tour->slug])}}" style="font-size: 18px; color: #333;text-align: left;">{{ $tour->title }}</a>

                        </div>

                    </div>
                </li>
                @endforeach

                <!-- Add more rooms here following the same structure -->
            </ul> --}}
        </div>
        
        </div>
      </div>
    </div>
  </section>

</div>
@endsection