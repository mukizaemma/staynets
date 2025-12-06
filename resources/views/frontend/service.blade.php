@extends('layouts.frontbase')

@section('content')



    <!--==============================
    Breadcumb
============================== -->
    <div class="breadcumb-wrapper " data-bg-src="{{ asset('storage/images/services/' . $service->image) }}">
        <div class="container">
            <div class="breadcumb-content">
                <ul class="breadcumb-menu">
                      <h1 class="breadcumb-title">{{ $service->name }} Details</h1>
                </ul>
            </div>
        </div>
    </div>
    <!--==============================
Product Area
==============================-->



@endsection