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

        <div class="container-fluid pt-4 px-4">
            <div class="bg-light text-center rounded p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="mb-0">Booking Details: {{ $booking->reference_number ?? 'Booking #' . $booking->id }}</h6>
                    <div>
                        <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left me-2"></i>Back to List
                        </a>
                    </div>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fa fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="row">
                    <div class="col-md-8 mx-auto">
                        <!-- Booking Information -->
                        <div class="card mb-3">
                            <div class="card-header bg-primary text-white">
                                <h6 class="mb-0">Booking Information</h6>
                            </div>
                            <div class="card-body">
                                <div class="row mb-2">
                                    <div class="col-md-4"><strong>Reference Number:</strong></div>
                                    <div class="col-md-8"><code>{{ $booking->reference_number ?? 'N/A' }}</code></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-4"><strong>Status:</strong></div>
                                    <div class="col-md-8">
                                        @if($booking->booking_status == 'confirmed')
                                            <span class="badge bg-success">Confirmed</span>
                                        @elseif($booking->booking_status == 'cancelled')
                                            <span class="badge bg-danger">Cancelled</span>
                                        @else
                                            <span class="badge bg-warning">Pending</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-4"><strong>Payment Status:</strong></div>
                                    <div class="col-md-8">
                                        @if($booking->payment_status == 'paid')
                                            <span class="badge bg-success">Paid</span>
                                        @elseif($booking->payment_status == 'refunded')
                                            <span class="badge bg-info">Refunded</span>
                                        @else
                                            <span class="badge bg-warning">Pending</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-4"><strong>Check-in Date:</strong></div>
                                    <div class="col-md-8">
                                        {{ $booking->check_in_date ? \Carbon\Carbon::parse($booking->check_in_date)->format('F d, Y') : 'N/A' }}
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-4"><strong>Check-out Date:</strong></div>
                                    <div class="col-md-8">
                                        {{ $booking->check_out_date ? \Carbon\Carbon::parse($booking->check_out_date)->format('F d, Y') : 'N/A' }}
                                    </div>
                                </div>
                                @if($booking->check_in_date && $booking->check_out_date)
                                    <div class="row mb-2">
                                        <div class="col-md-4"><strong>Duration:</strong></div>
                                        <div class="col-md-8">
                                            {{ \Carbon\Carbon::parse($booking->check_in_date)->diffInDays(\Carbon\Carbon::parse($booking->check_out_date)) }} nights
                                        </div>
                                    </div>
                                @endif
                                <div class="row mb-2">
                                    <div class="col-md-4"><strong>Number of Guests:</strong></div>
                                    <div class="col-md-8">{{ $booking->number_of_guests ?? 'N/A' }}</div>
                                </div>
                            </div>
                        </div>

                        <!-- Customer Information -->
                        <div class="card mb-3">
                            <div class="card-header bg-info text-white">
                                <h6 class="mb-0">Customer Information</h6>
                            </div>
                            <div class="card-body">
                                <div class="row mb-2">
                                    <div class="col-md-4"><strong>Name:</strong></div>
                                    <div class="col-md-8">{{ $booking->user->name ?? 'N/A' }}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-4"><strong>Email:</strong></div>
                                    <div class="col-md-8">{{ $booking->user->email ?? 'N/A' }}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-4"><strong>Phone:</strong></div>
                                    <div class="col-md-8">{{ $booking->user->phone ?? 'N/A' }}</div>
                                </div>
                            </div>
                        </div>

                        <!-- Property & Unit Information -->
                        <div class="card mb-3">
                            <div class="card-header bg-success text-white">
                                <h6 class="mb-0">Property & Unit Information</h6>
                            </div>
                            <div class="card-body">
                                <div class="row mb-2">
                                    <div class="col-md-4"><strong>Property:</strong></div>
                                    <div class="col-md-8">
                                        @if($booking->property)
                                            <a href="{{ route('admin.properties.show', $booking->property_id) }}">
                                                {{ $booking->property->name }}
                                            </a>
                                            <br><small class="text-muted">{{ ucfirst($booking->property->property_type) }}</small>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-4"><strong>Unit:</strong></div>
                                    <div class="col-md-8">
                                        @if($booking->unit)
                                            <a href="{{ route('admin.units.edit', $booking->unit_id) }}">
                                                {{ $booking->unit->name ?? 'Unit #' . $booking->unit_id }}
                                            </a>
                                            @if($booking->unit->unitType)
                                                <br><small class="text-muted">{{ $booking->unit->unitType->name }}</small>
                                            @endif
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pricing Information -->
                        <div class="card mb-3">
                            <div class="card-header bg-warning text-dark">
                                <h6 class="mb-0">Pricing Information</h6>
                            </div>
                            <div class="card-body">
                                <div class="row mb-2">
                                    <div class="col-md-4"><strong>Total Amount:</strong></div>
                                    <div class="col-md-8">
                                        @if($booking->total_amount)
                                            <strong class="h5">${{ number_format($booking->total_amount, 2) }}</strong>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </div>
                                </div>
                                @if($booking->tax_amount)
                                    <div class="row mb-2">
                                        <div class="col-md-4"><strong>Tax Amount:</strong></div>
                                        <div class="col-md-8">${{ number_format($booking->tax_amount, 2) }}</div>
                                    </div>
                                @endif
                                @if($booking->discount_amount)
                                    <div class="row mb-2">
                                        <div class="col-md-4"><strong>Discount:</strong></div>
                                        <div class="col-md-8">-${{ number_format($booking->discount_amount, 2) }}</div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Additional Information -->
                        @if($booking->special_requests || $booking->notes)
                            <div class="card mb-3">
                                <div class="card-header bg-secondary text-white">
                                    <h6 class="mb-0">Additional Information</h6>
                                </div>
                                <div class="card-body">
                                    @if($booking->special_requests)
                                        <div class="mb-3">
                                            <strong>Special Requests:</strong>
                                            <p class="mt-2">{{ $booking->special_requests }}</p>
                                        </div>
                                    @endif
                                    @if($booking->notes)
                                        <div>
                                            <strong>Notes:</strong>
                                            <p class="mt-2">{{ $booking->notes }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <!-- Status Update Form -->
                        <div class="card mb-3">
                            <div class="card-header bg-dark text-white">
                                <h6 class="mb-0">Update Status</h6>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.bookings.updateStatus', $booking->id) }}" method="POST">
                                    @csrf
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="booking_status" class="form-label">Booking Status <span class="text-danger">*</span></label>
                                            <select name="booking_status" class="form-select" id="booking_status" required>
                                                <option value="pending" {{ $booking->booking_status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="confirmed" {{ $booking->booking_status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                                <option value="cancelled" {{ $booking->booking_status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="payment_status" class="form-label">Payment Status</label>
                                            <select name="payment_status" class="form-select" id="payment_status">
                                                <option value="pending" {{ $booking->payment_status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="paid" {{ $booking->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
                                                <option value="refunded" {{ $booking->payment_status == 'refunded' ? 'selected' : '' }}>Refunded</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-save me-2"></i>Update Status
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Timestamps -->
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <small class="text-muted">
                                            <strong>Created:</strong> {{ $booking->created_at->format('F d, Y h:i A') }}
                                        </small>
                                    </div>
                                    <div class="col-md-6">
                                        <small class="text-muted">
                                            <strong>Last Updated:</strong> {{ $booking->updated_at->format('F d, Y h:i A') }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Content End -->

    @include('admin.includes.footer')
@endsection




