@extends('layouts.adminBase')

@section('content')
    @include('admin.includes.sidebar') <!-- Sidebar Start -->

    <div class="content">
        @include('admin.includes.navbar') <!-- Navbar Start -->

        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="btn btn-primary">Contacts Setting</h2>
                            @if (session()->has('success'))
                                <div class="alert alert-success alert-dismissible">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                    {{ session()->get('success') }}
                                </div>
                            @endif
                        </div>

                        <div class="card-body">
                            <form action="{{ route('saveSetting', $data->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <!-- General Information Section -->
                                <h4 class="mb-3">General Information</h4>
                                <div class="row mb-4">
                                    <div class="col-lg-6">
                                        <label for="company" class="form-label">Website Title (browser tab)</label>
                                        <input type="text" class="form-control" value="{{ $data->company }}" name="company">
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="title" class="form-label">SEO Page Title</label>
                                        <input type="text" class="form-control" value="{{ $data->title }}" name="title" placeholder="Car Rental in Kigali, Rwanda | Your Company">
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-lg-12">
                                        <label for="quote" class="form-label">Tagline (footer &amp; fallback description)</label>
                                        <input type="text" class="form-control" value="{{ $data->quote }}" name="quote" placeholder="Affordable car rental in Kigali with transparent RWF rates.">
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-lg-12">
                                        <label for="meta_description" class="form-label">Meta Description (Google)</label>
                                        <textarea class="form-control" name="meta_description" rows="2" placeholder="Rent a car in Kigali, Rwanda. Airport pickup, 4x4 safari vehicles, and self-drive daily rentals.">{{ $data->meta_description ?? '' }}</textarea>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-lg-6">
                                        <label for="address" class="form-label">Address</label>
                                        <input type="text" class="form-control" value="{{ $data->address }}" name="address">
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="keywords" class="form-label">SEO Keywords</label>
                                        <input type="text" class="form-control" value="{{ $data->keywords }}" name="keywords" placeholder="car rental Kigali, rent a car Rwanda">
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-lg-6">
                                        <label for="phone" class="form-label">Primary Phone / WhatsApp</label>
                                        <input type="text" class="form-control" value="{{ $data->phone }}" name="phone" placeholder="+250 7XX XXX XXX">
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" value="{{ $data->email }}" name="email">
                                    </div>
                                </div>

                                <!-- Social Media Section -->
                                <h4 class="mb-3">Social Media</h4>
                                <div class="row mb-4">
                                    <div class="col-lg-6">
                                        <label for="facebook" class="form-label">Facebook</label>
                                        <input type="text" class="form-control" value="{{ $data->facebook }}" name="facebook">
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="instagram" class="form-label">Instagram</label>
                                        <input type="text" class="form-control" value="{{ $data->instagram }}" name="instagram">
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-lg-6">
                                        <label for="youtube" class="form-label">YouTube</label>
                                        <input type="text" class="form-control" value="{{ $data->youtube }}" name="youtube">
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="linkedin" class="form-label">LinkedIn</label>
                                        <input type="text" class="form-control" value="{{ $data->linkedin }}" name="linkedin">
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-lg-6">
                                        <label for="tiktok" class="form-label">TikTok</label>
                                        <input type="text" class="form-control" value="{{ $data->tiktok }}" name="tiktok" placeholder="https://www.tiktok.com/@yourpage">
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="phone1" class="form-label">Secondary Phone (optional, not shown on site)</label>
                                        <input type="text" class="form-control" value="{{ $data->phone1 }}" name="phone1">
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <label for="vision" class="form-label">Booking Link</label>
                                        <input type="text" class="form-control" value="{{ $data->linktree ?? '' }}" name="linktree">
                                    </div>
                                </div>

                                <!-- Logo Section -->
                                <h4 class="mb-3">Logo</h4>
                                <div class="row mb-4" style="display: flex; justify-content: space-between; align-items: center;">
                                    <!-- Header Logo -->
                                    <div class="col-lg-6 text-center" style="padding: 20px; border: 1px solid #ddd; border-radius: 10px;">
                                        <label for="currentLogo" class="form-label" style="font-weight: bold; font-size: 16px;">Header Logo</label>
                                        <div style="margin: 10px 0;">
                                            <img src="{{ asset('storage/images') . $data->logo }}" alt="Logo" style="width: 150px; border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">
                                        </div>
                                
                                        <label for="logo" class="form-label" style="margin-top: 10px;">Change the Header Logo</label>
                                        <input type="file" class="form-control mt-2" name="logo">
                                    </div>
                                
                                    <!-- Footer Logo -->
                                    <div class="col-lg-6 text-center" style="padding: 20px; border: 1px solid #ddd; border-radius: 10px;">
                                        <label for="currentFooter" class="form-label" style="font-weight: bold; font-size: 16px;">Footer Logo</label>
                                        <div style="margin: 10px 0;">
                                            <img src="{{ asset('storage/images') . $data->donate }}" alt="Logo" style="width: 150px; border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">
                                        </div>
                                
                                        <label for="donate" class="form-label" style="margin-top: 10px;">Change the Footer Logo</label>
                                        <input type="file" class="form-control mt-2" name="donate">
                                    </div>
                                </div>
                                

                                <!-- Additional Settings (Admin Only) -->
                                @if(Auth()->user()->email == "admin@iremetech.com")
                                    <h4 class="mb-3">Additional Settings</h4>
                                    <div class="row mb-4">
                                        <div class="col-lg-12">
                                            <label for="keywords" class="form-label">Keywords</label>
                                            <input type="text" class="form-control" value="{{ $data->keywords }}" name="keywords">
                                        </div>
                                    </div>

                                @endif

                                <!-- Submit Button -->
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-save"></i> Save Changes
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('admin.includes.footer')
@endsection
