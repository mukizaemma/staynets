{{-- Quick navigation for admin on phones / small screens --}}
<div class="admin-mobile-quick-nav d-xl-none mb-4">
    <div class="bg-light rounded p-3">
        <h6 class="mb-3 text-secondary"><i class="fas fa-th-large me-2"></i>Quick Menu</h6>
        <div class="row g-2">
            <div class="col-4 col-sm-3">
                <a href="{{ route('dashboard') }}" class="btn btn-outline-primary w-100 btn-sm py-2 d-flex flex-column align-items-center">
                    <i class="fas fa-grip-horizontal mb-1"></i><span style="font-size:11px;">Dashboard</span>
                </a>
            </div>
            <div class="col-4 col-sm-3">
                <a href="{{ route('admin.properties.index') }}" class="btn btn-outline-primary w-100 btn-sm py-2 d-flex flex-column align-items-center">
                    <i class="fas fa-building mb-1"></i><span style="font-size:11px;">Properties</span>
                </a>
            </div>
            <div class="col-4 col-sm-3">
                <a href="{{ route('admin.units.index') }}" class="btn btn-outline-primary w-100 btn-sm py-2 d-flex flex-column align-items-center">
                    <i class="fas fa-door-open mb-1"></i><span style="font-size:11px;">Rooms</span>
                </a>
            </div>
            <div class="col-4 col-sm-3">
                <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-primary w-100 btn-sm py-2 d-flex flex-column align-items-center">
                    <i class="fas fa-calendar-check mb-1"></i><span style="font-size:11px;">Bookings</span>
                </a>
            </div>
            <div class="col-4 col-sm-3">
                <a href="{{ route('getCars') }}" class="btn btn-outline-primary w-100 btn-sm py-2 d-flex flex-column align-items-center">
                    <i class="fas fa-car mb-1"></i><span style="font-size:11px;">Cars</span>
                </a>
            </div>
            <div class="col-4 col-sm-3">
                <a href="{{ route('getTrips') }}" class="btn btn-outline-primary w-100 btn-sm py-2 d-flex flex-column align-items-center">
                    <i class="fas fa-route mb-1"></i><span style="font-size:11px;">Tours</span>
                </a>
            </div>
            <div class="col-4 col-sm-3">
                <a href="{{ route('homePage') }}" class="btn btn-outline-primary w-100 btn-sm py-2 d-flex flex-column align-items-center">
                    <i class="fas fa-home mb-1"></i><span style="font-size:11px;">Homepage</span>
                </a>
            </div>
            <div class="col-4 col-sm-3">
                <a href="{{ route('slides') }}" class="btn btn-outline-primary w-100 btn-sm py-2 d-flex flex-column align-items-center">
                    <i class="fas fa-images mb-1"></i><span style="font-size:11px;">Hero Slides</span>
                </a>
            </div>
            <div class="col-4 col-sm-3">
                <a href="{{ route('aboutPage') }}" class="btn btn-outline-primary w-100 btn-sm py-2 d-flex flex-column align-items-center">
                    <i class="fas fa-info-circle mb-1"></i><span style="font-size:11px;">About</span>
                </a>
            </div>
            <div class="col-4 col-sm-3">
                <a href="{{ route('users') }}" class="btn btn-outline-primary w-100 btn-sm py-2 d-flex flex-column align-items-center">
                    <i class="fas fa-users mb-1"></i><span style="font-size:11px;">Users</span>
                </a>
            </div>
            <div class="col-4 col-sm-3">
                <a href="{{ route('admin.reviews.index') }}" class="btn btn-outline-primary w-100 btn-sm py-2 d-flex flex-column align-items-center">
                    <i class="fas fa-star mb-1"></i><span style="font-size:11px;">Reviews</span>
                </a>
            </div>
            <div class="col-4 col-sm-3">
                <a href="{{ route('setting') }}" class="btn btn-outline-primary w-100 btn-sm py-2 d-flex flex-column align-items-center">
                    <i class="fas fa-cog mb-1"></i><span style="font-size:11px;">Settings</span>
                </a>
            </div>
        </div>
    </div>
</div>
