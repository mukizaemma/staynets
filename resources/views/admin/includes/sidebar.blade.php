<div class="sidebar pe-4 pb-3">
    <nav class="navbar bg-light navbar-light">
        {{-- <a href="{{ route('home') }}" class="navbar-brand mx-4 mb-3">
            <h3 class="text-secondary"><i class="fa fa-hashtag me-2"></i>
            Site
            </h3>
        </a> --}}
        <div class="d-flex align-items-center ms-4 mb-4">
            <div class="position-relative">
                @php
                    $adminLogoUrl = asset('assets/img/logo.svg');
                    $raw = ltrim((string) (optional($setting)->logo ?? ''), '/');
                    if (!empty($raw)) {
                        $cands = array_values(array_unique(array_filter([$raw, 'images/'.$raw, 'images/site/'.$raw])));
                        foreach ($cands as $c) {
                            try {
                                if (\Illuminate\Support\Facades\Storage::disk('public')->exists($c)) { $adminLogoUrl = \Illuminate\Support\Facades\Storage::url($c); break; }
                            } catch (\Throwable $e) {}
                        }
                    }
                @endphp
                <img class="rounded-circle" src="{{ $adminLogoUrl }}" alt="{{ $setting->company ?? 'StayNets' }}" style="width: 40px; height: 40px; object-fit: contain; background: #fff;">
                <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
            </div>
            <div class="ms-3">
                <h6 class="mb-0">{{ $setting->company ?? '' }}</h6>
                {{-- <span>Admin</span> --}}
            </div>
        </div>
        <div class="navbar-nav w-100">
            <a href="{{ route('admin.guide') }}" class="nav-item nav-link"><i class="fas fa-book me-2"></i>User Guide</a>
            <a href="{{ route('dashboard') }}" class="nav-item nav-link active"><i class="fas fa-grip-horizontal me-2"></i>Dashboard</a>
            <a href="{{ route('homePage') }}" class="nav-item nav-link"><i class="fas fa-home me-2"></i>Homepage Content</a>
            <a href="{{ route('slides') }}" class="nav-item nav-link"><i class="fas fa-images me-2"></i>Hero Slides</a>
            {{-- <a href="{{ route('admin.properties.index', ['mine' => 1]) }}" class="nav-item nav-link"><i class="fas fa-user-check me-2"></i>My properties</a> --}}

            <a href="{{ route('getServices') }}" class="nav-item nav-link"> 
                <i class="fas fa-concierge-bell me-2"></i>Services
            </a>

            <a href="{{ route('admin.properties.index') }}" class="nav-item nav-link"> 
                <i class="fas fa-building me-2"></i>Properties
            </a>

            <a href="{{ route('admin.units.index') }}" class="nav-item nav-link"> 
                <i class="fas fa-door-open me-2"></i>Units/Rooms
            </a>

            <a href="{{ route('getTrips') }}" class="nav-item nav-link"> 
                <i class="fas fa-route me-2"></i>Trip Activities
            </a>
            <a href="{{ route('admin.tripRequests.index') }}" class="nav-item nav-link">
                <i class="fas fa-clipboard-list me-2"></i>Trip Requests
            </a>

            <a href="{{ route('admin.listing-agreement.index') }}" class="nav-item nav-link">
                <i class="fas fa-file-signature me-2"></i>Agreement
            </a>

            <a href="{{ route('admin.bookings.index') }}" class="nav-item nav-link">
                <i class="fas fa-calendar-check me-2"></i>Bookings
            </a>
            <a href="{{ route('admin.booking-calendar.index') }}" class="nav-item nav-link">
                <i class="fas fa-border-all me-2"></i>Booking calendar
            </a>
            <a href="{{ route('admin.reports.revenue') }}" class="nav-item nav-link"> 
                <i class="fas fa-chart-line me-2"></i>Revenue &amp; Commission Report
            </a>
            <a href="{{ route('admin.invoices.index') }}" class="nav-item nav-link"> 
                <i class="fas fa-file-invoice-dollar me-2"></i>Invoices
            </a>

            <a href="{{ route('getCars') }}" class="nav-item nav-link"> <i class="fas fa-car me-2"></i>Cars</a>
            <a href="{{ route('admin.carRentalRequests.index') }}" class="nav-item nav-link"> <i class="fas fa-car-side me-2"></i>Car Rental Requests</a>
            <a href="{{ route('getLeftBags') }}" class="nav-item nav-link"> <i class="fas fa-suitcase-rolling me-2"></i>Left Bags</a>
            <a href="{{ route('getTicketing') }}" class="nav-item nav-link"> <i class="fas fa-ticket-alt me-2"></i>Ticketing</a>
            <a href="{{ route('getCarRental') }}" class="nav-item nav-link"> <i class="fas fa-car-side me-2"></i>Car Rental Content</a>
            <a href="{{ route('getBlogs') }}" class="nav-item nav-link"><i class="fas fas fa-handshake me-2"></i>Articles</a> 
            <hr>

            <a href="{{ route('getDestinations') }}" class="nav-item nav-link"> 
                <i class="fas fa-handshake me-2"></i>Destinations
            </a>
            <a href="{{ route('admin.facility-categories.index') }}" class="nav-item nav-link"> 
                <i class="fas fa-folder me-2"></i>Facility Categories
            </a>
            <a href="{{ route('amenities.index') }}" class="nav-item nav-link"> 
                <i class="fas fa-list me-2"></i>Amenities
            </a>
            <a href="{{ route('aboutPage') }}" class="nav-item nav-link"> <i class="fas fa-home me-2"></i>About Us</a>
            {{-- <a href="{{ route('getMessages') }}" class="nav-item nav-link"> <i class="fas fa-briefcase me-2"></i>Requests</a> --}}
            <a href="{{ route('setting') }}" class="nav-item nav-link"> <i class="fas fa-hashtag me-2"></i>Contacts</a>
            <a href="{{ route('admin.reviews.index') }}" class="nav-item nav-link">
                <i class="fas fa-star me-2"></i>Reviews
            </a>

            <a href="{{ route('users') }}" class="nav-item nav-link"><i class="fa fa-users me-2"></i> Users</a>
        </div>
    </nav>
</div>