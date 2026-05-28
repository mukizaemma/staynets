@extends('layouts.frontbase')

@section('content')
    <section class="space bg-smoke">
        <div class="container">
            <div class="row justify-content-center mb-4">
                <div class="col-lg-8 text-center">
                    <h2 class="sec-title">Book Left Bags</h2>
                    <p class="sec-text">Fill in the form below and we’ll confirm your luggage storage quickly.</p>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <form action="{{ route('bookNow') }}" method="POST" id="leftBagsBookingForm">
                                @csrf
                                <input type="hidden" name="service_type" value="left_bags">
                                <input type="hidden" name="message" id="leftBagsMessage">

                                <div class="mb-3">
                                    <label class="form-label">Full Name *</label>
                                    <input type="text" name="names" class="form-control" required value="{{ old('names') }}">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Phone Number *</label>
                                    <input type="tel" name="phone" class="form-control" required value="{{ old('phone') }}">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Email Address *</label>
                                    <input type="email" name="email" class="form-control" required value="{{ old('email') }}">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Drop-off Date *</label>
                                    <input type="date" name="dropoff_date" id="dropoff_date" class="form-control" required value="{{ old('dropoff_date') }}" min="{{ date('Y-m-d') }}">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Pick-up Date *</label>
                                    <input type="date" name="pickup_date" id="pickup_date" class="form-control" required value="{{ old('pickup_date') }}" min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Number of Bags *</label>
                                    <input type="number" name="bags_count" id="bags_count" class="form-control" min="1" required value="{{ old('bags_count', 1) }}">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Additional Notes</label>
                                    <textarea name="notes" id="notes" rows="3" class="form-control" placeholder="Optional: bag size, arrival time, special instructions">{{ old('notes') }}</textarea>
                                    <div class="form-text">We’ll include your dates and number of bags automatically.</div>
                                </div>

                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('leftBags') }}" class="btn btn-outline-secondary">Back</a>
                                    <button type="submit" class="btn btn-primary">Submit Request</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
    <script>
        (function () {
            const form = document.getElementById('leftBagsBookingForm');
            if (!form) return;
            const msg = document.getElementById('leftBagsMessage');
            const drop = document.getElementById('dropoff_date');
            const pick = document.getElementById('pickup_date');
            const bags = document.getElementById('bags_count');
            const notes = document.getElementById('notes');

            function buildMessage() {
                const parts = [];
                parts.push('Left Bags request');
                if (drop && drop.value) parts.push('Drop-off: ' + drop.value);
                if (pick && pick.value) parts.push('Pick-up: ' + pick.value);
                if (bags && bags.value) parts.push('Bags: ' + bags.value);
                const n = (notes && notes.value || '').trim();
                if (n) parts.push('Notes: ' + n);
                msg.value = parts.join('\\n');
            }

            form.addEventListener('submit', function () {
                buildMessage();
            });

            [drop, pick, bags, notes].forEach(function (el) {
                if (!el) return;
                el.addEventListener('change', buildMessage);
                el.addEventListener('input', buildMessage);
            });

            buildMessage();
        })();
    </script>
    @endpush
@endsection
