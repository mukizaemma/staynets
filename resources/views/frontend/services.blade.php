@extends('layouts.frontbase')

@section('content')

    <!--==============================
Product Area
==============================-->
    <section class="space">
        <div class="container">
            <div class="row">
                <div class="col-xxl-8 col-lg-7">
                <div class="row gy-24 gx-24">
                    @forelse($services as $service)
                        <div class="col-md-6">
                            <div class="tour-box th-ani">
                                <div class="tour-box_img global-img">
                                    @if($service->image && file_exists(storage_path('app/public/images/services/' . $service->image)))
                                        <img src="{{ asset('storage/images/services/' . $service->image) }}" alt="{{ $service->title }}">
                                    @else
                                        {{-- fallback image (keeps style unchanged) --}}
                                        <img src="{{ asset('assets/img/tour/tour_5_1.jpg') }}" alt="{{ $service->title }}">
                                    @endif
                                </div>

                                <div class="tour-content">
                                    <h3 class="box-title">
                                        <a href="{{ route('service', $service->slug) }}">{{ $service->title }}</a>
                                    </h3>


                                    {{-- Location --}}
                                    <p class="mb-2" style="margin:6px 0;">
                                        <p>{{ \Illuminate\Support\Str::limit(strip_tags($service->description), 100) }}</p>
                                    </p>

                                    {{-- View more button --}}
                                    <div class="tour-action">
                                        {{-- you can add other meta like duration or price here if you have them --}}
                                        <a href="{{ route('service', $service->slug) }}" class="th-btn style4">View More</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <p class="text-center">No Service found yet.</p>
                        </div>
                    @endforelse
                </div>

                  {{-- pagination (if $services is a paginator) --}}
                  @if(method_exists($services, 'links'))
                      <div class="row mt-24">
                          <div class="col-12 d-flex justify-content-center">
                              {{ $services->links() }}
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
                                @foreach ($trips as $service)
                                <div class="recent-post">
                                    <div class="media-img">
                                        <a href="{{route('tour',['slug'=>$service->slug])}}"><img src="{{ asset('storage/images/trips/' .$service->image) }}" alt="Blog Image"></a>
                                    </div>
                                    <div class="media-body">
                                        <h4 class="post-title"><a class="text-inherit" href="{{route('tour',['slug'=>$service->slug])}}">{{ $service->title }}</a></h4>

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