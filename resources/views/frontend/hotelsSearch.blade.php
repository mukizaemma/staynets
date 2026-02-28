@extends('layouts.frontbase')

@section('content')
<section class="pt-3 pb-4">
    <div class="container">
        {{-- Search summary --}}
        <div class="mb-4">
            <h2 class="sec-title mb-2">Property Search Results</h2>
            <p class="text-muted mb-0">
                @if(request('location'))
                    Showing results for <strong>{{ request('location') }}</strong>
                @elseif(request('q'))
                    Showing results for <strong>"{{ request('q') }}"</strong>
                @else
                    Browse all available properties
                @endif
            </p>
        </div>

        <div class="row">
            {{-- FILTERS SIDEBAR (StayNets Wireframe) --}}
            <div class="col-lg-3 col-md-4 mb-4 mb-lg-0">
                <div class="card border-0 shadow-sm" style="border-radius: 12px; position: sticky; top: 100px;">
                    <div class="card-header bg-white border-0 py-3" style="border-radius: 12px 12px 0 0;">
                        <h5 class="mb-0 fw-bold"><i class="fas fa-filter me-2"></i>Filters</h5>
                    </div>
                    <div class="card-body">
                        <form id="searchFiltersForm" method="GET" action="{{ route('hotelsSearch') }}">
                            @foreach(request()->except('page', 'amenities', 'price_min', 'price_max', 'star_rating', 'property_type', 'location') as $key => $val)
                                @if($val !== null && $val !== '')
                                    @if(is_array($val))
                                        @foreach($val as $v)
                                            <input type="hidden" name="{{ $key }}[]" value="{{ $v }}">
                                        @endforeach
                                    @else
                                        <input type="hidden" name="{{ $key }}" value="{{ $val }}">
                                    @endif
                                @endif
                            @endforeach

                            {{-- Location --}}
                            @if(isset($locations) && $locations->isNotEmpty())
                            <div class="mb-4">
                                <h6 class="fw-bold mb-2">Location</h6>
                                <select name="location" class="form-select form-select-sm" id="filterLocation">
                                    <option value="">All Locations</option>
                                    @foreach($locations as $loc)
                                        <option value="{{ $loc }}" {{ request('location') == $loc ? 'selected' : '' }}>{{ $loc }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @endif

                            {{-- Price --}}
                            <div class="mb-4">
                                <h6 class="fw-bold mb-2">Price</h6>
                                <div class="row g-2">
                                    <div class="col-6">
                                        <input type="number" name="price_min" class="form-control form-control-sm" placeholder="Min" value="{{ request('price_min') }}" min="0" step="1">
                                    </div>
                                    <div class="col-6">
                                        <input type="number" name="price_max" class="form-control form-control-sm" placeholder="Max" value="{{ request('price_max') }}" min="0" step="1">
                                    </div>
                                </div>
                            </div>

                            {{-- Star Rating --}}
                            <div class="mb-4">
                                <h6 class="fw-bold mb-2">Star Rating</h6>
                                <div class="form-check">
                                    @foreach([5, 4, 3, 2, 1] as $star)
                                    <div class="form-check mb-1">
                                        <input class="form-check-input" type="radio" name="star_rating" id="star{{ $star }}" value="{{ $star }}" {{ request('star_rating') == $star ? 'checked' : '' }}>
                                        <label class="form-check-label" for="star{{ $star }}">
                                            @for($i = 0; $i < $star; $i++)<i class="fa-solid fa-star text-warning" style="font-size: 12px;"></i>@endfor
                                            {{ $star }} Star{{ $star > 1 ? 's' : '' }}
                                        </label>
                                    </div>
                                    @endforeach
                                    <div class="form-check mb-1">
                                        <input class="form-check-input" type="radio" name="star_rating" id="starAny" value="" {{ !request('star_rating') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="starAny">Any</label>
                                    </div>
                                </div>
                            </div>

                            {{-- Property Type --}}
                            <div class="mb-4">
                                <h6 class="fw-bold mb-2">Property Type</h6>
                                @foreach($propertyTypes ?? [] as $typeKey => $typeLabel)
                                <div class="form-check mb-1">
                                    <input class="form-check-input" type="radio" name="property_type" id="pt{{ $typeKey }}" value="{{ $typeKey }}" {{ request('property_type') == $typeKey ? 'checked' : '' }}>
                                    <label class="form-check-label" for="pt{{ $typeKey }}">{{ $typeLabel }}</label>
                                </div>
                                @endforeach
                                <div class="form-check mb-1">
                                    <input class="form-check-input" type="radio" name="property_type" id="ptAny" value="" {{ !request('property_type') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="ptAny">All Types</label>
                                </div>
                            </div>

                            {{-- Amenities --}}
                            @if(isset($amenities) && $amenities->isNotEmpty())
                            <div class="mb-4">
                                <h6 class="fw-bold mb-2">Amenities</h6>
                                @foreach($amenities->take(8) as $amenity)
                                <div class="form-check mb-1">
                                    <input class="form-check-input" type="checkbox" name="amenities[]" id="am{{ $amenity->id }}" value="{{ $amenity->id }}" {{ in_array($amenity->id, (array)request('amenities', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="am{{ $amenity->id }}">{{ $amenity->title }}</label>
                                </div>
                                @endforeach
                            </div>
                            @endif

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search me-2"></i>Apply Filters
                                </button>
                                <a href="{{ route('hotelsSearch') }}" class="btn btn-outline-secondary btn-sm">Clear All</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- PROPERTY LISTINGS (Right Column) --}}
            <div class="col-lg-9 col-md-8">
                {{-- Sort Bar --}}
                <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
                    <div class="mb-2 mb-md-0">
                        <span class="text-muted me-2">Sort:</span>
                        <a href="{{ url()->current() }}?{{ http_build_query(array_merge(request()->except('orderby', 'page'), ['orderby' => 'best_value'])) }}" class="sort-link text-decoration-none me-3 {{ (request('orderby') == 'best_value' || !request('orderby')) ? 'fw-bold text-primary' : 'text-dark' }}" data-orderby="best_value">Best Value</a>
                        <span class="text-muted">|</span>
                        <a href="{{ url()->current() }}?{{ http_build_query(array_merge(request()->except('orderby', 'page'), ['orderby' => 'price'])) }}" class="sort-link text-decoration-none ms-3 {{ request('orderby') == 'price' ? 'fw-bold text-primary' : 'text-dark' }}" data-orderby="price">Lowest Price</a>
                    </div>
                    <div class="search-form-area" style="max-width: 280px;">
                        <form method="GET" action="{{ route('hotelsSearch') }}" class="d-flex" id="searchFormTop">
                            @foreach(request()->except('q', 'page') as $key => $val)
                                @if($val !== null && $val !== '')
                                    @if(is_array($val))
                                        @foreach($val as $v)
                                            <input type="hidden" name="{{ $key }}[]" value="{{ $v }}">
                                        @endforeach
                                    @else
                                        <input type="hidden" name="{{ $key }}" value="{{ $val }}">
                                    @endif
                                @endif
                            @endforeach
                            <input type="text" name="q" id="searchPropertiesInput" value="{{ request('q') }}" placeholder="Search properties..." class="form-control form-control-sm" style="border-radius: 8px 0 0 8px;" autocomplete="off">
                            <button type="submit" class="btn btn-primary btn-sm" style="border-radius: 0 8px 8px 0;"><i class="fas fa-search"></i></button>
                        </form>
                    </div>
                </div>

                {{-- Results --}}
                <div id="accommodations-results">
                    @include('frontend.partials.accommodations_results')
                </div>
            </div>
        </div>
    </div>
</section>

<script>
(function () {
    const resultsContainer = document.getElementById('accommodations-results');
    const filtersForm = document.getElementById('searchFiltersForm');
    const searchInput = document.getElementById('searchPropertiesInput');
    const searchFormTop = document.getElementById('searchFormTop');
    const baseUrl = '{{ route("hotelsSearch") }}';

    function getCurrentParams() {
        const url = new URL(window.location.href);
        const params = {};
        url.searchParams.forEach((val, key) => {
            if (key.endsWith('[]')) {
                const k = key.slice(0, -2);
                if (!params[k]) params[k] = [];
                params[k].push(val);
            } else {
                params[key] = val;
            }
        });
        return params;
    }

    function buildQueryString(params) {
        const usp = new URLSearchParams();
        Object.keys(params).forEach(k => {
            const v = params[k];
            if (v === null || v === undefined || v === '') return;
            if (Array.isArray(v)) {
                v.forEach(vv => usp.append(k + '[]', vv));
            } else {
                usp.set(k, v);
            }
        });
        return usp.toString();
    }

    async function fetchResults(params = {}) {
        if (!resultsContainer) return;
        const current = getCurrentParams();
        const merged = { ...current, ...params };
        if (Object.prototype.hasOwnProperty.call(params, 'page') === false) {
            delete merged.page;
        }
        const qs = buildQueryString(merged);
        const url = qs ? baseUrl + '?' + qs : baseUrl;
        resultsContainer.style.opacity = '0.5';
        try {
            const res = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
            const json = await res.json();
            if (json && json.html !== undefined) {
                resultsContainer.innerHTML = json.html;
                bindPaginationLinks();
            }
            window.history.pushState({}, '', url);
        } catch (err) {
            console.error('Search fetch error', err);
        } finally {
            resultsContainer.style.opacity = '1';
        }
    }

    function bindPaginationLinks() {
        if (!resultsContainer) return;
        resultsContainer.querySelectorAll('.th-pagination a, .pagination a').forEach(a => {
            const href = a.getAttribute('href');
            if (!href) return;
            const linkUrl = new URL(href, window.location.origin);
            const page = linkUrl.searchParams.get('page');
            if (page) {
                a.addEventListener('click', function(e) {
                    e.preventDefault();
                    fetchResults({ page: page });
                });
            }
        });
    }

    if (filtersForm) {
        filtersForm.addEventListener('submit', function(e) {
            e.preventDefault();
            applyFilters();
        });

        function applyFilters() {
            const params = getCurrentParams();
            const formData = new FormData(filtersForm);
            formData.forEach((val, key) => {
                if (key === 'page') return;
                if (key.endsWith('[]')) {
                    const k = key.slice(0, -2);
                    if (!params[k]) params[k] = [];
                    params[k].push(val);
                } else {
                    params[key] = val;
                }
            });
            delete params.page;
            fetchResults(params);
        }

        var filterDebounce;
        filtersForm.querySelectorAll('input, select').forEach(function(el) {
            if (el.type === 'radio' || el.type === 'checkbox') {
                el.addEventListener('change', function() { applyFilters(); });
            } else if (el.name === 'price_min' || el.name === 'price_max') {
                el.addEventListener('input', function() {
                    clearTimeout(filterDebounce);
                    filterDebounce = setTimeout(applyFilters, 400);
                });
            } else if (el.name === 'location') {
                el.addEventListener('change', function() { applyFilters(); });
            }
        });
    }

    let searchDebounce;
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            clearTimeout(searchDebounce);
            searchDebounce = setTimeout(function() {
                const q = searchInput.value.trim();
                const params = getCurrentParams();
                params.q = q || '';
                delete params.page;
                fetchResults(params);
            }, 400);
        });
    }

    if (searchFormTop) {
        searchFormTop.addEventListener('submit', function(e) {
            e.preventDefault();
            const q = (document.getElementById('searchPropertiesInput') && document.getElementById('searchPropertiesInput').value) || '';
            const params = getCurrentParams();
            params.q = q.trim();
            delete params.page;
            fetchResults(params);
        });
    }

    document.addEventListener('click', function(e) {
        const sortLink = e.target.closest('a.sort-link');
        if (!sortLink) return;
        e.preventDefault();
        const orderby = sortLink.getAttribute('data-orderby');
        if (orderby) {
            fetchResults({ orderby: orderby });
            document.querySelectorAll('a.sort-link').forEach(a => {
                a.classList.remove('fw-bold', 'text-primary');
                a.classList.add('text-dark');
            });
            sortLink.classList.add('fw-bold', 'text-primary');
            sortLink.classList.remove('text-dark');
        }
    });

    bindPaginationLinks();
})();
</script>
@endsection
