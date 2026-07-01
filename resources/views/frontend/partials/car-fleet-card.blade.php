@php
    $layout = $layout ?? 'grid';
    $slug = $car->slug ?? $car->id;
    $detailUrl = route('carDetails', $slug);
    $priceLabel = $car->formattedPriceLine()
        ?: ($car->price_per_month ? formatMoney($car->price_per_month, $car->currency_code) . '/month' : null);
    $typeLabel = $car->seats >= 15 ? 'Minibus' : ($car->seats >= 7 ? 'SUV' : 'Sedan');
@endphp

<article class="car-fleet-card car-fleet-card--{{ $layout }}">
    <a href="{{ $detailUrl }}" class="car-fleet-card__media d-block text-decoration-none">
        <img src="{{ carImageUrl($car->image) }}"
             alt="{{ $car->name }}"
             loading="lazy"
             decoding="async">
        <span class="car-fleet-card__type">{{ $typeLabel }}</span>
        @if($priceLabel)
            <span class="car-fleet-card__price">{{ $priceLabel }}</span>
        @else
            <span class="car-fleet-card__price" style="background:#64748b;">On request</span>
        @endif
    </a>
    <div class="car-fleet-card__body">
        <h3 class="car-fleet-card__title">
            <a href="{{ $detailUrl }}">{{ $car->name }}</a>
        </h3>
        <div class="car-fleet-card__chips">
            @if($car->model)
                <span class="car-fleet-chip"><i class="fa fa-car"></i> {{ $car->model }}</span>
            @endif
            @if($car->transmission)
                <span class="car-fleet-chip"><i class="fa fa-cogs"></i> {{ $car->transmission }}</span>
            @endif
            @if($car->fuel_type)
                <span class="car-fleet-chip"><i class="fa fa-gas-pump"></i> {{ $car->fuel_type }}</span>
            @endif
            @if($car->seats)
                <span class="car-fleet-chip"><i class="fa fa-users"></i> {{ $car->seats }} seats</span>
            @endif
        </div>
        <div class="car-fleet-card__actions">
            <a href="{{ $detailUrl }}" class="th-btn style4" title="View details" aria-label="View {{ $car->name }}">
                <i class="fa fa-eye"></i>
            </a>
            <a href="{{ $detailUrl }}" class="th-btn style3">Book Now</a>
        </div>
    </div>
</article>
