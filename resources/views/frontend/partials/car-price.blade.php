@if($car->formattedPriceLine())
    <p class="car-price-badge mb-2">
        <span class="text-success fw-semibold" style="font-size: 1.05rem;">{{ $car->formattedPriceLine() }}</span>
    </p>
@elseif($car->price_per_month)
    <p class="car-price-badge mb-2">
        <span class="text-success fw-semibold" style="font-size: 1.05rem;">{{ formatMoney($car->price_per_month, $car->currency_code) }}/month</span>
    </p>
@else
    <p class="text-muted small mb-2">Price on request</p>
@endif

@if($car->price_per_day && $car->price_per_month)
    <p class="text-muted small mb-2">Monthly: {{ formatMoney($car->price_per_month, $car->currency_code) }}</p>
@endif
