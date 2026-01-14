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

        <!-- User Details Start -->
        <div class="container-fluid pt-4 px-4">
            <div class="bg-light rounded p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="mb-0">User Details</h6>
                    <a href="{{ route('users') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left me-2"></i>Back to Users
                    </a>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('info'))
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        {{ session('info') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- User Information Card -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0"><i class="fas fa-user me-2"></i>User Information</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Name:</strong> {{ $user->name }}</p>
                                        <p><strong>Email:</strong> {{ $user->email }}</p>
                                        <p><strong>Email Verified:</strong> 
                                            @if($user->hasVerifiedEmail())
                                                <span class="badge bg-success">
                                                    <i class="fas fa-check-circle me-1"></i>Verified
                                                </span>
                                            @else
                                                <span class="badge bg-warning">
                                                    <i class="fas fa-exclamation-circle me-1"></i>Not Verified
                                                </span>
                                                <a href="{{ route('admin.users.verify', $user->id) }}" class="btn btn-success btn-sm ms-2" 
                                                   onclick="return confirm('Are you sure you want to verify this user\'s email?')">
                                                    <i class="fas fa-check-circle me-1"></i>Verify Email
                                                </a>
                                            @endif
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Role:</strong> 
                                            @if($user->role == 1)
                                                <span class="badge bg-primary">Admin</span>
                                            @else
                                                <span class="badge bg-secondary">User</span>
                                            @endif
                                        </p>
                                        <p><strong>Registered:</strong> {{ $user->created_at->format('F d, Y h:i A') }}</p>
                                        <p><strong>Total Properties:</strong> <span class="badge bg-info">{{ $user->properties->count() }}</span></p>
                                        <p><strong>Total Bookings:</strong> <span class="badge bg-primary">{{ $user->hotelBookings->count() }}</span></p>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    @if($user->role != 1 && isset($isSuperAdmin) && $isSuperAdmin)
                                        <a href="{{ route('makeAdmin', ['id' => $user->id]) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-user-shield me-1"></i>Make Admin
                                        </a>
                                    @endif
                                    @if(isset($isSuperAdmin) && $isSuperAdmin)
                                        <a href="{{ route('deleteUser', ['id' => $user->id]) }}" class="btn btn-danger btn-sm" 
                                           onclick="return confirm('Are you sure you want to delete this user?')">
                                            <i class="fas fa-trash me-1"></i>Delete User
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Properties Section -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header bg-info text-white">
                                <h5 class="mb-0"><i class="fas fa-building me-2"></i>Properties ({{ $user->properties->count() }})</h5>
                            </div>
                            <div class="card-body">
                                @if($user->properties->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Type</th>
                                                    <th>Location</th>
                                                    <th>Status</th>
                                                    <th>Created</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($user->properties as $property)
                                                <tr>
                                                    <td>
                                                        @if($property->featured_image)
                                                            <img src="{{ asset('storage/images/properties/' . $property->featured_image) }}" 
                                                                 alt="{{ $property->name }}" 
                                                                 style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px; margin-right: 10px;">
                                                        @endif
                                                        {{ $property->name }}
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-secondary">{{ ucfirst($property->property_type) }}</span>
                                                    </td>
                                                    <td>{{ $property->location ?? $property->city ?? $property->address ?? 'N/A' }}</td>
                                                    <td>
                                                        @if($property->status == 'Active')
                                                            <span class="badge bg-success">{{ $property->status }}</span>
                                                        @elseif($property->status == 'Pending')
                                                            <span class="badge bg-warning">{{ $property->status }}</span>
                                                        @else
                                                            <span class="badge bg-danger">{{ $property->status }}</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $property->created_at->format('M d, Y') }}</td>
                                                    <td>
                                                        <a href="{{ route('admin.properties.edit', $property->id) }}" class="btn btn-primary btn-sm">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <p class="text-muted text-center py-4">No properties found for this user.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bookings Section -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0"><i class="fas fa-calendar-check me-2"></i>Bookings ({{ $user->hotelBookings->count() }})</h5>
                            </div>
                            <div class="card-body">
                                @if($user->hotelBookings->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Reference</th>
                                                    <th>Property</th>
                                                    <th>Unit/Room</th>
                                                    <th>Check-in</th>
                                                    <th>Check-out</th>
                                                    <th>Guests</th>
                                                    <th>Amount</th>
                                                    <th>Status</th>
                                                    <th>Payment</th>
                                                    <th>Created</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($user->hotelBookings as $booking)
                                                <tr>
                                                    <td><strong>{{ $booking->reference_number }}</strong></td>
                                                    <td>
                                                        @if($booking->property)
                                                            {{ $booking->property->name }}
                                                        @else
                                                            <span class="text-muted">N/A</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($booking->unit)
                                                            {{ $booking->unit->name }}
                                                        @else
                                                            <span class="text-muted">N/A</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ \Carbon\Carbon::parse($booking->check_in)->format('M d, Y') }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($booking->check_out)->format('M d, Y') }}</td>
                                                    <td>{{ $booking->guests_count }}</td>
                                                    <td>${{ number_format($booking->total_amount, 2) }}</td>
                                                    <td>
                                                        @if($booking->booking_status == 'confirmed')
                                                            <span class="badge bg-success">{{ ucfirst($booking->booking_status) }}</span>
                                                        @elseif($booking->booking_status == 'pending')
                                                            <span class="badge bg-warning">{{ ucfirst($booking->booking_status) }}</span>
                                                        @else
                                                            <span class="badge bg-danger">{{ ucfirst($booking->booking_status) }}</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($booking->payment_status == 'paid')
                                                            <span class="badge bg-success">{{ ucfirst($booking->payment_status) }}</span>
                                                        @elseif($booking->payment_status == 'pending')
                                                            <span class="badge bg-warning">{{ ucfirst($booking->payment_status) }}</span>
                                                        @else
                                                            <span class="badge bg-secondary">{{ ucfirst($booking->payment_status) }}</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $booking->created_at->format('M d, Y') }}</td>
                                                    <td>
                                                        <a href="{{ route('admin.bookings.show', $booking->id) ?? '#' }}" class="btn btn-primary btn-sm">
                                                            <i class="fas fa-eye"></i> View
                                                        </a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <p class="text-muted text-center py-4">No bookings found for this user.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- User Details End -->

        <!-- Footer Start -->
        <div class="container-fluid pt-4 px-4">
            <div class="bg-light rounded-top p-4">
                <div class="row">
                    <div class="col-12 col-sm-6 text-center text-sm-start">
                        &copy; <a href="#">Accommodation Booking Engine</a>, All Right Reserved. 
                    </div>
                    <div class="col-12 col-sm-6 text-center text-sm-end">
                        Designed By <a href="https://iremetech.com">Ireme Technologies</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer End -->
    </div>
    <!-- Content End -->

    @include('admin.includes.footer')
@endsection

