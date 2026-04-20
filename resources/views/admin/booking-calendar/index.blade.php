@extends('layouts.adminBase')

@section('content')
    @include('admin.includes.sidebar')

    <div class="content">
        @include('admin.includes.navbar')

    <div class="container-fluid pt-4 px-4">
        <div class="bg-light rounded p-4">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
                <h4 class="mb-0">Room booking dashboard</h4>
                <form method="get" action="{{ route('admin.booking-calendar.index') }}" class="d-flex flex-wrap gap-2 align-items-end">
                    <div>
                        <label class="form-label small mb-0">Listing</label>
                        <select name="listing" class="form-select form-select-sm" style="min-width: 260px;">
                            <option value="all" {{ ($listing ?? 'all') === 'all' ? 'selected' : '' }}>All listings</option>
                            @if(isset($hotelsList) && $hotelsList->isNotEmpty())
                                <optgroup label="Hotels">
                                    @foreach($hotelsList as $h)
                                        <option value="h-{{ $h->id }}" {{ ($listing ?? '') === 'h-'.$h->id ? 'selected' : '' }}>{{ $h->name }}</option>
                                    @endforeach
                                </optgroup>
                            @endif
                            @if(isset($propertiesList) && $propertiesList->isNotEmpty())
                                <optgroup label="Properties">
                                    @foreach($propertiesList as $p)
                                        <option value="p-{{ $p->id }}" {{ ($listing ?? '') === 'p-'.$p->id ? 'selected' : '' }}>{{ $p->name }}</option>
                                    @endforeach
                                </optgroup>
                            @endif
                        </select>
                    </div>
                    <div>
                        <label class="form-label small mb-0">Year</label>
                        <input type="number" name="year" class="form-control form-control-sm" value="{{ $year }}" min="2020" max="2035" style="width: 100px;">
                    </div>
                    <button type="submit" class="btn btn-sm btn-primary">Apply</button>
                </form>
            </div>

            @php
                $yearUrls = [];
                foreach ([$year - 1, $year, $year + 1] as $y) {
                    if ($y < 2020 || $y > 2035) continue;
                    $yearUrls[$y] = route('admin.booking-calendar.index', array_filter([
                        'year' => $y,
                        'listing' => ($listing ?? 'all') !== 'all' ? ($listing ?? 'all') : null,
                    ], static fn ($v) => $v !== null && $v !== ''));
                }
            @endphp

            @php $calFirst = true; @endphp
            @forelse($calendars as $payload)
                <div class="mb-5 pb-4 border-bottom">
                    <h5 class="fw-bold mb-3">{{ $payload['hotel_name'] ?? 'Property' }} <span class="text-muted small">#{{ $payload['hotel_id'] ?? $payload['property_id'] ?? '' }}</span></h5>
                    @include('partials.booking-calendar-grid', ['payload' => $payload, 'yearUrls' => $calFirst ? $yearUrls : []])
                    @php $calFirst = false; @endphp
                </div>
            @empty
                <p class="text-muted">No properties to show.</p>
            @endforelse
        </div>
    </div>
    </div>
@endsection
