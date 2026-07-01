@extends('layouts.frontbase')

@section('meta_title', 'Car Rental Fleet | ' . ($setting->company ?? 'Rwanda'))
@section('meta_description', 'Browse our car rental fleet in Kigali, Rwanda. Transparent RWF daily rates, airport pickup, 4x4 safari vehicles, and self-drive options.')
@section('canonical_url', route('showCars'))

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/car-rental.css') }}">
@endpush

@section('content')
@php
    $carContent = \App\Models\CarRentalContent::first();
    $fleetCount = $cars->total() ?? $cars->count();
    $heroImage = ($carContent && $carContent->hero_image)
        ? asset('storage/images/car-rental/' . $carContent->hero_image)
        : carImageUrl(optional($cars->first())->image);

    $benefits = [
        [
            'icon' => 'fa-car-side',
            'title' => 'Our Fleet',
            'content' => $carContent->fleet_content ?? "Sedans, SUVs, 4x4s, and minibuses for city travel, airport transfers, safaris, and long-term hire across Rwanda.",
        ],
        [
            'icon' => 'fa-shield-halved',
            'title' => 'Why Choose Us',
            'content' => $carContent->why_content ?? "Well-maintained vehicles, professional drivers on request, flexible daily & monthly rentals, and reliable airport pickup in Kigali.",
        ],
        [
            'icon' => 'fa-route',
            'title' => 'Our Services',
            'content' => $carContent->services_content ?? "Self-drive and chauffeur options, KGL airport meet & greet, corporate travel, and upcountry trips to national parks.",
        ],
    ];
@endphp

<section class="space car-rental-page">
    <div class="container">

        {{-- Hero --}}
        <div class="car-rental-hero">
            <div class="car-rental-hero__inner">
                <div class="row align-items-center g-4">
                    <div class="col-lg-7">
                        <span class="car-rental-hero__badge">
                            <i class="fas fa-car-side"></i> Car Rental in Rwanda
                        </span>
                        <h1 class="car-rental-hero__title">{{ $carContent->heading ?? 'Premium Car Rental Services' }}</h1>
                        <p class="car-rental-hero__subtitle">{{ $carContent->subheading ?? 'Reliable, comfortable & flexible rentals in Kigali' }}</p>
                        <p class="car-rental-hero__desc">
                            {{ $carContent->description ?? 'Explore Rwanda with a trusted fleet — from airport pickups to safari-ready 4x4s. Transparent RWF pricing and quick booking.' }}
                        </p>
                        <div class="car-rental-hero__stats">
                            <div class="car-rental-hero__stat">
                                <strong>{{ $fleetCount }}+</strong>
                                <span>Vehicles</span>
                            </div>
                            <div class="car-rental-hero__stat">
                                <strong>24/7</strong>
                                <span>Support</span>
                            </div>
                            <div class="car-rental-hero__stat">
                                <strong>KGL</strong>
                                <span>Airport pickup</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="car-rental-hero__visual">
                            <div class="car-rental-hero__image">
                                <img src="{{ $heroImage }}" alt="Car rental fleet in Kigali">
                            </div>
                            <div class="car-rental-booking-card">
                                <h5><i class="fas fa-calendar-check me-2" style="color:var(--brand-blue);"></i>Book Your Vehicle</h5>
                                <p>Tell us your dates and route — we'll confirm availability and pricing quickly.</p>
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
            </div>
        </div>

        {{-- Trust strip --}}
        <div class="car-rental-trust">
            <span class="car-rental-trust__item"><i class="fa fa-plane-arrival"></i> Airport transfers</span>
            <span class="car-rental-trust__item"><i class="fa fa-tags"></i> Transparent RWF rates</span>
            <span class="car-rental-trust__item"><i class="fa fa-mountain-sun"></i> 4x4 safari ready</span>
            <span class="car-rental-trust__item"><i class="fa fa-headset"></i> Local support team</span>
        </div>

        {{-- Benefits --}}
        <div class="row gy-4 car-rental-benefits">
            @foreach($benefits as $benefit)
                <div class="col-md-4">
                    <div class="car-benefit-card">
                        <div class="car-benefit-card__icon"><i class="fas {{ $benefit['icon'] }}"></i></div>
                        <h4>{{ $benefit['title'] }}</h4>
                        <div class="car-benefit-card__body">{!! nl2br(e($benefit['content'])) !!}</div>
                    </div>
                </div>
            @endforeach
        </div>

        @if($cars->count() > 0)
            {{-- Fleet header + toolbar --}}
            <div class="car-fleet-section-head">
                <div>
                    <h3>Choose Your Vehicle
                        <span class="car-fleet-count">{{ $fleetCount }} available</span>
                    </h3>
                    <p class="text-muted mb-0 mt-1">Compare models, specs, and daily rates — then book in minutes.</p>
                </div>
            </div>

            <div class="car-fleet-toolbar">
                <div class="row justify-content-between align-items-center g-3">
                    <div class="col-md-5 col-lg-4">
                        <div class="search-form-area">
                            <form id="carsSearchForm" class="search-form" method="get" action="{{ url()->current() }}" style="position:relative;">
                                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search by name, model, type…" id="searchInput" autocomplete="off">
                                <button type="button" id="clearSearch" aria-label="Clear search"
                                    style="position:absolute;right:48px;top:50%;transform:translateY(-50%);border:none;background:none;font-size:18px;cursor:pointer;color:#94a3b8;display:{{ request('q') ? 'inline-block' : 'none' }};">&times;</button>
                                <button type="submit"><i class="fa-light fa-magnifying-glass"></i></button>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-auto">
                        <div class="sorting-filter-wrap d-flex align-items-center gap-2">
                            <div class="nav" role="tablist">
                                <a class="active" href="#" id="tab-destination-grid" data-bs-toggle="tab" data-bs-target="#tab-grid" role="tab"><i class="fa-light fa-grid-2"></i></a>
                                <a href="#" id="tab-destination-list" data-bs-toggle="tab" data-bs-target="#tab-list" role="tab"><i class="fa-solid fa-list"></i></a>
                            </div>
                            <form class="woocommerce-ordering mb-0" method="get">
                                @if(request('q'))
                                    <input type="hidden" name="q" value="{{ request('q') }}">
                                @endif
                                <select name="orderby" class="orderby form-select form-select-sm" aria-label="Sort vehicles" style="min-width:160px;border-radius:10px;">
                                    <option value="date" {{ request('orderby', 'date') == 'date' ? 'selected' : '' }}>Newest first</option>
                                    <option value="price" {{ request('orderby') == 'price' ? 'selected' : '' }}>Price: low to high</option>
                                    <option value="price-desc" {{ request('orderby') == 'price-desc' ? 'selected' : '' }}>Price: high to low</option>
                                </select>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div id="accommodations-results">
                @include('frontend.partials.cars_results', ['cars' => $cars])
            </div>
        @else
            <div class="text-center py-5">
                <div class="car-benefit-card d-inline-block text-start" style="max-width:480px;">
                    <div class="car-benefit-card__icon mx-auto"><i class="fas fa-car"></i></div>
                    <h4 class="text-center">Fleet coming soon</h4>
                    <p class="text-center text-muted mb-3">We're updating our vehicles. Send a request and we'll find the right car for your trip.</p>
                    <button type="button" class="th-btn style3 w-100" data-bs-toggle="modal" data-bs-target="#carRentalRequestModal">Request a Vehicle</button>
                </div>
            </div>
        @endif
    </div>

    {{-- Request modal --}}
    <div class="modal fade" id="carRentalRequestModal" tabindex="-1" aria-labelledby="carRentalRequestModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content" style="border-radius:16px;border:none;">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold" id="carRentalRequestModalLabel">Request a Car Rental</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('carRentalRequest.store') }}" method="POST">
                    @csrf
                    <div class="modal-body pt-2">
                        <div class="mb-3">
                            <label class="form-label">Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" value="{{ auth()->check() ? auth()->user()->name : old('name') }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" value="{{ auth()->check() ? auth()->user()->email : old('email') }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone / WhatsApp <span class="text-danger">*</span></label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" placeholder="+250 7XX XXX XXX" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Type of Car <span class="text-danger">*</span></label>
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
                                <label class="form-label">Passengers</label>
                                <input type="number" name="people" class="form-control" value="{{ old('people') }}" min="1">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Pickup date</label>
                                <input type="date" name="rental_date" class="form-control" value="{{ old('rental_date') }}" min="{{ date('Y-m-d') }}">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Trip details</label>
                            <textarea name="message" class="form-control" rows="3" placeholder="Pickup location, route, return date…">{{ old('message') }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="submit" class="th-btn style3 w-100">Send Request</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
(function () {
    const resultsContainer = document.getElementById('accommodations-results');
    const searchInput = document.getElementById('searchInput');
    const orderSelect = document.querySelector('.woocommerce-ordering select[name="orderby"]');
    const clearBtn = document.getElementById('clearSearch');
    const carsUrl = @json(route('showCars'));

    function debounce(fn, wait) {
        let t;
        return function (...args) {
            clearTimeout(t);
            t = setTimeout(() => fn.apply(this, args), wait);
        };
    }

    async function fetchResults(params) {
        if (!resultsContainer) return;
        const url = new URL(window.location.href);
        Object.keys(params).forEach(k => {
            if (params[k] === null || params[k] === undefined || params[k] === '') {
                url.searchParams.delete(k);
            } else {
                url.searchParams.set(k, params[k]);
            }
        });
        resultsContainer.style.opacity = '0.55';
        try {
            const res = await fetch(url.toString(), { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
            const json = await res.json();
            if (json && json.html !== undefined) {
                resultsContainer.innerHTML = json.html;
                bindPaginationLinks();
            }
            window.history.pushState({}, '', url.toString());
        } catch (err) {
            console.error(err);
        } finally {
            resultsContainer.style.opacity = '1';
        }
    }

    function bindPaginationLinks() {
        if (!resultsContainer) return;
        resultsContainer.querySelectorAll('.pagination a, .th-pagination a').forEach(a => {
            const clone = a.cloneNode(true);
            a.parentNode.replaceChild(clone, a);
            clone.addEventListener('click', function (e) {
                const href = this.getAttribute('href');
                if (!href) return;
                const linkUrl = new URL(href, window.location.origin);
                const page = linkUrl.searchParams.get('page');
                if (page) {
                    e.preventDefault();
                    fetchResults({
                        q: searchInput ? searchInput.value : '',
                        orderby: orderSelect ? orderSelect.value : '',
                        page,
                    });
                }
            });
        });
    }

    if (searchInput) {
        searchInput.addEventListener('input', debounce(function () {
            fetchResults({ q: this.value, orderby: orderSelect ? orderSelect.value : '', page: 1 });
        }, 350));
    }

    if (orderSelect) {
        orderSelect.addEventListener('change', function () {
            fetchResults({ q: searchInput ? searchInput.value : '', orderby: this.value, page: 1 });
        });
    }

    if (clearBtn) {
        clearBtn.addEventListener('click', function (e) {
            e.preventDefault();
            window.location.href = carsUrl;
        });
    }

    if (searchInput && clearBtn) {
        searchInput.addEventListener('input', function () {
            clearBtn.style.display = this.value.trim() ? 'inline-block' : 'none';
        });
    }

    window.addEventListener('popstate', function () {
        const url = new URL(window.location.href);
        if (searchInput) searchInput.value = url.searchParams.get('q') || '';
        if (orderSelect) orderSelect.value = url.searchParams.get('orderby') || 'date';
        fetchResults({
            q: url.searchParams.get('q') || '',
            orderby: url.searchParams.get('orderby') || 'date',
            page: url.searchParams.get('page') || 1,
        });
    });

    bindPaginationLinks();
})();
</script>
@endpush
@endsection
