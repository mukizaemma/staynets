@extends('layouts.adminBase')


@section('content')


        <!-- Sidebar Start -->
@include('admin.includes.sidebar')
        <!-- Sidebar End -->


        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            @include('admin.includes.navbar')
            <!-- Navbar End -->


                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h2 class="btn btn-primary">About & Policies</h2>
                                </div>
                                <div class="card-body">
                                    @if (session()->has('success'))
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            {{ session()->get('success') }}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                        </div>
                                    @endif

                                    <ul class="nav nav-tabs" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="about-tab" data-bs-toggle="tab" data-bs-target="#about-tab-pane" type="button" role="tab">
                                                About Us
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="terms-tab" data-bs-toggle="tab" data-bs-target="#terms-tab-pane" type="button" role="tab">
                                                Terms & Policies
                                            </button>
                                        </li>
                                    </ul>

                                    <div class="tab-content pt-3">
                                        <div class="tab-pane fade show active" id="about-tab-pane" role="tabpanel">
                                            <form action="{{ route('saveAbout') }}"
                                                method="POST"
                                                enctype="multipart/form-data"
                                                style="padding:20px;background:#f9f9f9;border-radius:10px;box-shadow:0 0 10px rgba(0,0,0,0.1);">

                                                @csrf

                                                <div class="mb-4">
                                                    <label class="form-label fw-bold">About Heading</label>
                                                    <input type="text"
                                                        name="title"
                                                        class="form-control"
                                                        value="{{ old('title', $data->title) }}"
                                                        required>
                                                </div>

                                                <div class="mb-4">
                                                    <label class="form-label fw-bold">About Description</label>
                                                    <textarea name="welcomeMessage"
                                                            id="aboutDescription"
                                                            rows="6"
                                                            class="form-control summernote"
                                                            required>{{ old('welcomeMessage', $data->welcomeMessage) }}</textarea>
                                                </div>

                                                <div class="mb-4">
                                                    <label class="form-label fw-bold">About Image</label><br>

                                                    @if($data->image1)
                                                        <img src="{{ asset('storage/images/about/' . $data->image1) }}"
                                                            width="160"
                                                            class="mb-3 rounded shadow-sm">
                                                    @endif

                                                    <input type="file" name="image1" class="form-control">
                                                    <small class="text-muted">Leave empty to keep current image</small>
                                                </div>

                                                <div class="text-center mt-4">
                                                    <button type="submit" class="btn btn-primary px-4">
                                                        <i class="fa fa-save"></i> Update About Section
                                                    </button>
                                                </div>

                                            </form>
                                        </div>

                                        <div class="tab-pane fade" id="terms-tab-pane" role="tabpanel">
                                            <form class="form" action="{{ route('saveTerms', $terms->id) }}" method="POST"
                                                enctype="multipart/form-data"
                                                style="padding:20px;background:#f9f9f9;border-radius:10px;box-shadow:0 0 10px rgba(0,0,0,0.1);">
                                                @csrf
                                                <div class="form-body">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <label class="form-label">Privacy Policy</label>
                                                            <textarea id="privacyPolicy" rows="5" class="form-control summernote" name="privacy">{!! $terms->privacy !!}</textarea>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <label class="form-label">Privacy Details</label>
                                                            <textarea id="privacyDetails" rows="5" class="form-control summernote" name="privacy_details">{!! $terms->privacy_details ?? '' !!}</textarea>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <label class="form-label">Cookies Policy</label>
                                                            <textarea id="cookiesPolicy" rows="5" class="form-control summernote" name="cookies">{!! $terms->cookies ?? '' !!}</textarea>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <label class="form-label">Refunds Policy</label>
                                                            <textarea id="refundsPolicy" rows="5" class="form-control summernote" name="refunds">{!! $terms->refunds ?? '' !!}</textarea>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <label class="form-label">Booking Cancellation</label>
                                                            <textarea id="bookingCancellation" rows="5" class="form-control summernote" name="booking_cancellation">{!! $terms->booking_cancellation ?? '' !!}</textarea>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <label class="form-label">Listing Commission</label>
                                                            <textarea id="listingCommission" rows="5" class="form-control summernote" name="listing_commission">{!! $terms->listing_commission ?? '' !!}</textarea>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <label class="form-label">Payment Methods</label>
                                                            <textarea id="paymentMethods" rows="5" class="form-control summernote" name="payment_methods">{!! $terms->payment_methods ?? '' !!}</textarea>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <label class="form-label">Return Policy</label>
                                                            <textarea id="returnPolicy" rows="5" class="form-control summernote" name="return">{!! $terms->return ?? '' !!}</textarea>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <label class="form-label">Support Policy</label>
                                                            <textarea id="supportPolicy" rows="5" class="form-control summernote" name="support">{!! $terms->support ?? '' !!}</textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-actions mt-4">
                                                    <button type="submit" class="btn btn-primary text-black">
                                                        <i class="fa fa-save"></i> Save Policies
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.row -->
                </div><!-- /.container-fluid -->


        </div>
        <!-- Content End -->


        @include('admin.includes.footer')

 @endsection