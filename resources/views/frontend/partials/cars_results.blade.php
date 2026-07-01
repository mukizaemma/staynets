<div class="tab-content" id="nav-tabContent">
    <div class="tab-pane fade show active" id="tab-grid" role="tabpanel" aria-labelledby="tab-destination-grid">
        <div class="row gy-4">
            @forelse($cars as $car)
                <div class="col-xxl-4 col-xl-6 col-md-6">
                    @include('frontend.partials.car-fleet-card', ['car' => $car, 'layout' => 'grid'])
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center py-5 text-muted">No vehicles match your search.</div>
                </div>
            @endforelse
        </div>
    </div>

    <div class="tab-pane fade" id="tab-list" role="tabpanel" aria-labelledby="tab-destination-list">
        <div class="row gy-4">
            @forelse($cars as $car)
                <div class="col-12">
                    @include('frontend.partials.car-fleet-card', ['car' => $car, 'layout' => 'list'])
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center py-5 text-muted">No vehicles match your search.</div>
                </div>
            @endforelse
        </div>
    </div>

    @if(method_exists($cars, 'links') && $cars->hasPages())
        <div class="th-pagination text-center mt-5 mb-0">
            {!! $cars->appends(request()->query())->links() !!}
        </div>
    @endif
</div>
