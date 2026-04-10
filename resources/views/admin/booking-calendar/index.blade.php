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
                        <label class="form-label small mb-0">Property</label>
                        <select name="hotel_id" class="form-select form-select-sm" style="min-width: 220px;">
                            <option value="all" {{ ($hotelId === null || $hotelId === '' || $hotelId === 'all') ? 'selected' : '' }}>All hotels</option>
                            @foreach($hotelsList as $h)
                                <option value="{{ $h->id }}" {{ (string)$hotelId === (string)$h->id ? 'selected' : '' }}>{{ $h->name }}</option>
                            @endforeach
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
                        'hotel_id' => $hotelId,
                    ]));
                }
            @endphp

            @php $calFirst = true; @endphp
            @forelse($calendars as $payload)
                <div class="mb-5 pb-4 border-bottom">
                    <h5 class="fw-bold mb-3">{{ $payload['hotel_name'] ?? 'Property' }} <span class="text-muted small">#{{ $payload['hotel_id'] }}</span></h5>
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
