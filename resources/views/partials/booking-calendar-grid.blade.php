@props(['payload', 'yearUrls' => []])
@php
    $payload = $payload ?? null;
    $yearUrls = is_array($yearUrls ?? null) ? $yearUrls : [];
@endphp
@if(empty($payload) || empty($payload['months']))
    <p class="text-muted mb-0">No room inventory to display. Add rooms to see the booking grid.</p>
@else
    <div class="booking-cal-wrap" style="overflow-x: auto;">
        @if(count($yearUrls) > 0)
            <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
                <span class="fw-bold text-secondary small">YEAR</span>
                @foreach($yearUrls as $y => $url)
                    <a href="{{ $url }}"
                       class="btn btn-sm {{ ($y == $payload['year']) ? 'btn-primary' : 'btn-outline-secondary' }}"
                       style="border-radius: 999px;">{{ $y }}</a>
                @endforeach
            </div>
        @endif

        @foreach($payload['months'] as $monthNum => $month)
            <div class="mb-5">
                <h6 class="fw-bold mb-2" style="letter-spacing: .02em;">{{ strtoupper($month['name']) }} {{ $payload['year'] }}</h6>
                <table class="table table-bordered table-sm mb-0 booking-cal-table" style="font-size: 12px; min-width: 720px;">
                    <thead>
                        <tr>
                            <th class="text-start text-nowrap bg-light" style="min-width: 140px;">Room / Date</th>
                            @for($d = 1; $d <= $month['days_in_month']; $d++)
                                <th class="text-center p-1">{{ $d }}</th>
                            @endfor
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($month['rooms'] as $row)
                            <tr>
                                <td class="text-nowrap fw-semibold bg-light">{{ $row['label'] }}</td>
                                @for($d = 1; $d <= $month['days_in_month']; $d++)
                                    @php $c = (int) ($row['days'][$d] ?? 0); @endphp
                                    <td class="text-center p-1 {{ $c > 0 ? 'table-warning' : '' }}">{{ $c > 0 ? $c : '' }}</td>
                                @endfor
                            </tr>
                        @endforeach
                        <tr class="table-secondary">
                            <td class="fw-bold">Occupancy %</td>
                            @for($d = 1; $d <= $month['days_in_month']; $d++)
                                <td class="text-center p-1 small fw-semibold">{{ number_format($month['occupancy'][$d] ?? 0, 2) }}%</td>
                            @endfor
                        </tr>
                    </tbody>
                </table>
            </div>
        @endforeach
    </div>
@endif
