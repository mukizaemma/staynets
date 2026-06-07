@extends('layouts.adminBase')

@section('content')
@include('admin.includes.sidebar')

<div class="content">
    @include('admin.includes.navbar')
    @include('admin.includes.mobile-quick-nav')

    <div class="container-fluid pt-4 px-4">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="row g-4">
            <div class="col-lg-4">
                <div class="bg-light rounded p-4 h-100">
                    <h6 class="mb-3"><i class="fas fa-images me-2"></i>Hero Slides</h6>
                    <p class="text-muted small">Manage carousel images and captions on the homepage hero.</p>
                    <p class="mb-2"><strong>{{ $slidesCount }}</strong> slide(s) configured</p>
                    <a href="{{ route('slides') }}" class="btn btn-primary btn-sm">Manage Slides</a>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="bg-light rounded p-4 h-100">
                    <h6 class="mb-3"><i class="fas fa-star me-2"></i>Why Choose Us</h6>
                    <p class="text-muted small">Benefit cards shown on the homepage.</p>
                    <p class="mb-2"><strong>{{ $whyChooseUsCount }}</strong> active item(s)</p>
                    <a href="{{ route('admin.why-choose-us.index') }}" class="btn btn-primary btn-sm">Manage Items</a>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="bg-light rounded p-4 h-100">
                    <h6 class="mb-3"><i class="fas fa-file-image me-2"></i>Page Header Images</h6>
                    <p class="text-muted small">Header and background images for About, Contact, and other pages.</p>
                    <a href="{{ route('aboutPage') }}#site-images" class="btn btn-primary btn-sm">Manage in About Us</a>
                </div>
            </div>
        </div>

        <div class="bg-light rounded p-4 mt-4">
            <h6 class="mb-3">Homepage Fallback Background</h6>
            <p class="text-muted small mb-3">Used when no hero slides are configured.</p>
            <form action="{{ route('saveHome') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row align-items-end">
                    <div class="col-md-6">
                        @if($setting && $setting->home_background_image)
                            <img src="{{ asset('storage/images/site/' . $setting->home_background_image) }}" alt="Home background" class="img-fluid rounded mb-2" style="max-height: 160px;">
                        @endif
                        <input type="file" name="home_background_image" class="form-control" accept="image/*">
                    </div>
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-primary">Save Background</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @include('admin.includes.footer')
</div>
@endsection
