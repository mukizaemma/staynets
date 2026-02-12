@extends('layouts.frontbase')

@section('content')

<section class="space">
    @php
        $carContent = \App\Models\CarRentalContent::first();
    @endphp
    <div class="container">
        <!-- Hero / Intro -->
        <div class="row mb-40 align-items-center">
            <div class="col-lg-7">
                <h2 class="sec-title mb-2">{{ $carContent->heading ?? 'Stay Nets Car Rental Services' }}</h2>
                <h4 class="mb-3" style="color:#128C7E;">{{ $carContent->subheading ?? 'Reliable, Comfortable, and Flexible Car Rental in Rwanda' }}</h4>
                <p class="mb-3" style="color:#555;">
                    {{ $carContent->description ?? 'Travel Rwanda and East Africa with ease and comfort through Stay Nets Car Rental Services.' }}
                </p>
            </div>
            <div class="col-lg-5 mb-3 mb-lg-0">
                @if($carContent && $carContent->hero_image)
                    <div class="mb-3">
                        <img src="{{ asset('storage/images/car-rental/' . $carContent->hero_image) }}"
                             alt="Stay Nets Car Rental"
                             class="img-fluid rounded-3 shadow-sm">
                    </div>
                @endif
                <div class="card border-0 shadow-sm" style="border-radius:16px;">
                    <div class="card-body">
                        <h5 class="mb-2">Book Your Vehicle</h5>
                        <p class="text-muted mb-3" style="font-size:14px;">
                            Select your dates and send us a quick request. Our team will respond with options and pricing.
                        </p>
                        <button type="button" class="th-btn style3 w-100 mb-2" data-bs-toggle="modal" data-bs-target="#carRentalRequestModal">
                            {{ $carContent->cta_book_label ?? 'Book Your Car' }}
                        </button>
                        <button type="button" class="th-btn style4 w-100" data-bs-toggle="modal" data-bs-target="#carRentalRequestModal">
                            {{ $carContent->cta_quote_label ?? 'Request a Quote' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Overview columns -->
        <div class="row gy-4 mb-40">
            <div class="col-md-4">
                <h4 class="box-title mb-2">Our Fleet</h4>
                <div style="color:#555; font-size:14px;">
                    {!! nl2br(e($carContent->fleet_content ?? '')) !!}
                </div>
            </div>
            <div class="col-md-4">
                <h4 class="box-title mb-2">Why Choose Stay Nets Car Rental</h4>
                <div style="color:#555; font-size:14px;">
                    {!! nl2br(e($carContent->why_content ?? '')) !!}
                </div>
            </div>
            <div class="col-md-4">
                <h4 class="box-title mb-2">Our Services</h4>
                <div style="color:#555; font-size:14px;">
                    {!! nl2br(e($carContent->services_content ?? '')) !!}
                </div>
            </div>
        </div>

        @if($cars->count() > 0)
            <!-- Existing search + results (only if cars exist) -->
            <div class="th-sort-bar">
                <div class="row justify-content-between align-items-center">
                    <div class="col-md-4">
                        <div class="search-form-area">
                            <form id="accommodationsSearchForm" class="search-form" method="get" action="{{ url()->current() }}" style="position: relative;">
                                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search" id="searchInput">

                                <!-- Clear button always present (hidden when input empty) -->
                                <button type="button" id="clearSearch" aria-label="Clear search"
                                    style="
                                        position:absolute;
                                        right:45px;
                                        top:50%;
                                        transform:translateY(-50%);
                                        border:none;
                                        background:none;
                                        font-size:18px;
                                        cursor:pointer;
                                        color:#999;
                                        display: {{ request('q') ? 'inline-block' : 'none' }};
                                    ">
                                    &times;
                                </button>

                                <button type="submit"><i class="fa-light fa-magnifying-glass"></i></button>
                            </form>
                        </div>
                    </div>

                    <div class="col-md-auto">
                        <div class="sorting-filter-wrap">
                            <div class="nav" role="tablist">
                                <a class="active" href="#" id="tab-destination-grid" data-bs-toggle="tab" data-bs-target="#tab-grid" role="tab" aria-controls="tab-grid" aria-selected="true"><i class="fa-light fa-grid-2"></i></a>

                                <a href="#" id="tab-destination-list" data-bs-toggle="tab" data-bs-target="#tab-list" role="tab" aria-controls="tab-list" aria-selected="false" class=""><i class="fa-solid fa-list"></i></a>
                            </div>
                            <form class="woocommerce-ordering" method="get">
                                <select name="orderby" class="orderby" aria-label="destination order">
                                    <option value="menu_order" {{ request('orderby') == 'menu_order' ? 'selected' : '' }}>Default Sorting</option>
                                    <option value="popularity" {{ request('orderby') == 'popularity' ? 'selected' : '' }}>Sort by popularity</option>
                                    <option value="rating" {{ request('orderby') == 'rating' ? 'selected' : '' }}>Sort by average rating</option>
                                    <option value="date" {{ request('orderby') == 'date' ? 'selected' : '' }}>Sort by latest</option>
                                    <option value="price" {{ request('orderby') == 'price' ? 'selected' : '' }}>Sort by price: low to high</option>
                                    <option value="price-desc" {{ request('orderby') == 'price-desc' ? 'selected' : '' }}>Sort by price: high to low</option>
                                </select>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row" id="car-rental-form">
                <div class="col-12">

                    {{-- RESULTS: this container is replaced by AJAX responses --}}
                    <div id="accommodations-results">
                        <div class="tab-content" id="nav-tabContent">

                        {{-- GRID VIEW --}}
                        <div class="tab-pane fade active show" id="tab-grid" role="tabpanel" aria-labelledby="tab-destination-grid">
                            <div class="row gy-30">
                                @forelse($cars as $car)
                                    <div class="col-xxl-4 col-xl-6">
                                        <div class="tour-box th-ani">
                                        <div class="tour-box_img global-img"
                                            style="height:250px; overflow:hidden;">
                                            @if($car->image && file_exists(storage_path('app/public/images/cars/' . $car->image)))
                                                <img src="{{ asset('storage/images/cars/' . $car->image) }}"
                                                    alt="{{ $car->name }}"
                                                    style="width:100%; height:100%; object-fit:cover;">
                                            @else
                                                <img src="{{ asset('assets/img/tour/tour_3_1.jpg') }}"
                                                    alt="{{ $car->name }}"
                                                    style="width:100%; height:100%; object-fit:cover;">
                                            @endif
                                        </div>


                                            <div class="tour-content">
                                                <h3 class="box-title">
                                                    <a href="{{ route('carDetails', $car->slug ?? $car->id) }}">{{ $car->name }}</a>
                                                </h3>

                                                <ul class="list-unstyled mb-3 small text-muted row">
                                                    <li class="col-6 mb-1"><i class="fa fa-car me-1"></i> {{ $car->model }}</li>
                                                    <li class="col-6 mb-1"><i class="fa fa-gas-pump me-1"></i> {{ $car->fuel_type }}</li>
                                                    <li class="col-6 mb-1"><i class="fa fa-cogs me-1"></i> {{ $car->transmission }}</li>
                                                    <li class="col-6 mb-1"><i class="fa fa-users me-1"></i> {{ $car->seats }} seats</li>
                                                </ul>

                                                <div class="tour-action">
                                                    <div class="mt-auto">
                                                        @if($car->price_per_day !== null)
                                                            <p class="fw-bold mb-2">
                                                                {{ number_format($car->price_per_day) }} RWF
                                                                <span class="text-muted fw-normal">/ day</span>
                                                            </p>
                                                        @elseif($car->price_per_day || $car->price_per_month)
                                                            {{-- FOR RENT --}}
                                                            <p class="fw-bold mb-2">
                                                                {{ number_format($car->price_per_day ?? $car->price_per_month) }} RWF
                                                                <span class="fw-normal text-muted">
                                                                    / {{ $car->price_per_day ? 'day' : 'month' }}
                                                                </span>
                                                            </p>
                                                        @endif
                                                    </div>
                                                    <a href="{{ route('carDetails', $car->slug ?? $car->id) }}" class="th-btn style3">Book Now</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-12">
                                        <p class="text-center">No Cars found.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        {{-- LIST VIEW --}}
                        <div class="tab-pane fade" id="tab-list" role="tabpanel" aria-labelledby="tab-destination-list">
                            <div class="row gy-30">
                                @forelse($cars as $car)
                                    <div class="col-12">
                                        <div class="tour-box style-flex th-ani">
                                            <div class="tour-box_img global-img">
                                                @if($car->image && file_exists(storage_path('app/public/images/cars/' . $car->image)))
                                                    <img src="{{ asset('storage/images/cars/' . $car->image) }}" alt="{{ $car->name }}">
                                                @else
                                                    <img src="{{ asset('assets/img/tour/tour_3_1.jpg') }}" alt="{{ $car->name }}">
                                                @endif
                                            </div>

                                            <div class="tour-content">
                                                <h3 class="box-title">
                                                    <a href="{{ route('carDetails', $car->slug ?? $car->id) }}">{{ $car->name }}</a>
                                                </h3>

                                                <ul class="list-unstyled mb-3 small text-muted row">
                                                    <li class="col-6 mb-1"><i class="fa fa-car me-1"></i> {{ $car->model }}</li>
                                                    <li class="col-6 mb-1"><i class="fa fa-gas-pump me-1"></i> {{ $car->fuel_type }}</li>
                                                    <li class="col-6 mb-1"><i class="fa fa-cogs me-1"></i> {{ $car->transmission }}</li>
                                                    <li class="col-6 mb-1"><i class="fa fa-users me-1"></i> {{ $car->seats }} seats</li>
                                                </ul>

                                                <div class="tour-action">
                                                    <div class="mt-auto">
                                                        @if($car->price_per_day !== null)
                                                            <p class="fw-bold mb-2">
                                                                {{ number_format($car->price_per_day) }} RWF
                                                                <span class="text-muted fw-normal">/ day</span>
                                                            </p>
                                                        @elseif($car->price_per_day || $car->price_per_month)
                                                            {{-- FOR RENT --}}
                                                            <p class="fw-bold mb-2">
                                                                {{ number_format($car->price_per_day ?? $car->price_per_month) }} RWF
                                                                <span class="fw-normal text-muted">
                                                                    / {{ $car->price_per_day ? 'day' : 'month' }}
                                                                </span>
                                                            </p>
                                                        @endif
                                                    </div>
                                                    <a href="{{ route('carDetails', $car->slug ?? $car->id) }}" class="th-btn style3">Book Now</a>
                                                </div>
                                            </div>

                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-12">
                                        <p class="text-center">No Cars found.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        {{-- pagination --}}
                        <div class="th-pagination text-center mt-60 mb-0">
                            @if(method_exists($cars, 'links'))
                                <div class="row">
                                    <div class="col-12 d-flex justify-content-center">
                                        {!! $cars->appends(request()->query())->links() !!}
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                {{-- end #accommodations-results --}}

            </div>
        </div>
        @else
            <div class="row mt-4">
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        No cars are currently available for rent. Please check back soon or contact our team for assistance.
                    </div>
                </div>
            </div>
        @endif
    </div>
<!-- Car Rental Request Modal -->
<div class="modal fade" id="carRentalRequestModal" tabindex="-1" aria-labelledby="carRentalRequestModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="carRentalRequestModalLabel">Request a Car Rental</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('carRentalRequest.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Full Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ auth()->check() ? auth()->user()->name : old('name') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" value="{{ auth()->check() ? auth()->user()->email : old('email') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone <span class="text-danger">*</span></label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" placeholder="+250 7XX XXX XXX" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Type of Car Needed <span class="text-danger">*</span></label>
                        <select name="car_type" class="form-select" required>
                            <option value="">Select type</option>
                            <option value="Sedan / Compact" {{ old('car_type') == 'Sedan / Compact' ? 'selected' : '' }}>Sedan / Compact</option>
                            <option value="SUV / 4x4" {{ old('car_type') == 'SUV / 4x4' ? 'selected' : '' }}>SUV / 4x4</option>
                            <option value="Minivan / Coach" {{ old('car_type') == 'Minivan / Coach' ? 'selected' : '' }}>Minivan / Coach</option>
                            <option value="Luxury Vehicle" {{ old('car_type') == 'Luxury Vehicle' ? 'selected' : '' }}>Luxury Vehicle</option>
                            <option value="Not sure yet" {{ old('car_type') == 'Not sure yet' ? 'selected' : '' }}>Not sure yet</option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Number of People</label>
                            <input type="number" name="people" class="form-control" value="{{ old('people') }}" min="1">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Preferred Date</label>
                            <input type="date" name="rental_date" class="form-control" value="{{ old('rental_date') }}" min="{{ date('Y-m-d') }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Additional Details</label>
                        <textarea name="message" class="form-control" rows="4" placeholder="Tell us about your route, pickup location, timings, or any special requests...">{{ old('message') }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit Request</button>
                </div>
            </form>
        </div>
    </div>
</div>

</section>

<script>
(function () {
    // Elements
    const resultsContainer = document.getElementById('accommodations-results');
    const searchInput = document.getElementById('searchInput');
    const orderSelect = document.querySelector('.woocommerce-ordering select[name="orderby"]');
    const clearBtn = document.getElementById('clearSearch');

    // Debounce utility
    function debounce(fn, wait = 300) {
        let t;
        return function(...args) {
            clearTimeout(t);
            t = setTimeout(() => fn.apply(this, args), wait);
        };
    }

    // AJAX fetch function (exposed globally so clear button or other scripts can call it)
    async function fetchResults(params = {}) {
        // ensure results container exists
        if (!resultsContainer) return;

        // build url with current querystring + params
        const url = new URL(window.location.href);
        Object.keys(params).forEach(k => {
            if (params[k] === null || params[k] === undefined || params[k] === '') {
                url.searchParams.delete(k);
            } else {
                url.searchParams.set(k, params[k]);
            }
        });

        // loading indication
        resultsContainer.style.opacity = '0.5';

        try {
            const res = await fetch(url.toString(), {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });

            // expect JSON: { html: '...' }
            const json = await res.json();

            if (json && json.html !== undefined) {
                resultsContainer.innerHTML = json.html;
                bindPaginationLinks(); // rebind links inside injected html
            } else if (typeof json === 'string') {
                resultsContainer.innerHTML = json;
                bindPaginationLinks();
            } else {
                console.warn('Unexpected AJAX response', json);
            }

            // update URL so user can bookmark/share and back works
            window.history.pushState({}, '', url.toString());
        } catch (err) {
            console.error('Search fetch error', err);
        } finally {
            resultsContainer.style.opacity = '1';
        }
    }

    // Expose for other scripts
    window.fetchAccommodationsResults = fetchResults;

    // Bind pagination links inside results to load via AJAX
    function bindPaginationLinks() {
        if (!resultsContainer) return;
        // find pagination anchors (support both your .th-pagination and Laravel .pagination)
        const pagerLinks = resultsContainer.querySelectorAll('.th-pagination a, .pagination a');
        pagerLinks.forEach(a => {
            // remove previous handlers by cloning (defensive)
            const newA = a.cloneNode(true);
            a.parentNode.replaceChild(newA, a);

            newA.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                if (!href) return;
                // parse page param from href
                const linkUrl = new URL(href, window.location.origin);
                const page = linkUrl.searchParams.get('page');
                if (page) {
                    e.preventDefault();
                    const q = searchInput ? searchInput.value : '';
                    const orderby = orderSelect ? orderSelect.value : '';
                    fetchResults({ q, orderby, page });
                }
            });
        });
    }

    // Hook search input (debounced)
    if (searchInput) {
        const onInput = debounce(function() {
            const q = this.value;
            const orderby = orderSelect ? orderSelect.value : '';
            fetchResults({ q, orderby, page: 1 });
        }, 350);
        searchInput.addEventListener('input', onInput);
    }

    // Hook order select (change)
    if (orderSelect) {
        orderSelect.addEventListener('change', function() {
            const q = searchInput ? searchInput.value : '';
            fetchResults({ q, orderby: this.value, page: 1 });
        });
    }

    // Clear button behavior: full reload and redirect to accommodations route
    if (clearBtn) {
        clearBtn.addEventListener('click', function(e) {
            e.preventDefault();
            // full-page redirect to accommodations route (server will show unfiltered list)
            window.location.href = {!! json_encode(route('accommodations')) !!};
        });
    }

    // Update clear button visibility as user types
    function toggleClearBtn() {
        if (!clearBtn || !searchInput) return;
        if (searchInput.value && searchInput.value.trim().length > 0) {
            clearBtn.style.display = 'inline-block';
        } else {
            clearBtn.style.display = 'none';
        }
    }
    if (searchInput) {
        searchInput.addEventListener('input', toggleClearBtn);
        toggleClearBtn();
    }

    // Handle browser back/forward
    window.addEventListener('popstate', function() {
        const url = new URL(window.location.href);
        const q = url.searchParams.get('q') || '';
        const orderby = url.searchParams.get('orderby') || '';
        const page = url.searchParams.get('page') || 1;

        if (searchInput) searchInput.value = q;
        if (orderSelect) orderSelect.value = orderby;

        fetchResults({ q, orderby, page });
    });

    // initial bindings
    bindPaginationLinks();

})();
</script>

@endsection
