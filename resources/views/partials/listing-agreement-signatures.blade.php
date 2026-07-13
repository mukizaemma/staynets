<div class="staynets-contract__signatures">
    <h3 class="staynets-contract__section-title">{{ $heading }}</h3>
    @if(!empty($items))
        @foreach($items as $line)
            <p class="staynets-contract__sig-note">{!! nl2br(e($resolveLine($line))) !!}</p>
        @endforeach
    @endif
    <div class="staynets-contract__sig-grid">
        <div class="staynets-contract__sig-block">
            <div class="staynets-contract__sig-label">Stay Nets Representative: {{ $displayRep }}</div>
            <div class="staynets-contract__sig-label small">Signature:</div>
            <div class="staynets-contract__sig-line">
                @if($platformSig && ($showSignatures ?? true))
                    <img src="{{ asset('storage/'.$platformSig) }}" alt="Platform signature">
                @endif
            </div>
        </div>
        <div class="staynets-contract__sig-block">
            <div class="staynets-contract__sig-label">Host: {{ $displayHost }}</div>
            <div class="staynets-contract__sig-label small">Signature:</div>
            <div class="staynets-contract__sig-line">
                @if($ownerSig && ($showSignatures ?? true))
                    <img src="{{ asset('storage/'.$ownerSig) }}" alt="Host signature">
                @endif
            </div>
            <div class="staynets-contract__sig-label small mt-3">
                Date: {{ optional($signature)->signed_at?->format('d/m/Y') ?? '…………………' }}
            </div>
        </div>
    </div>
</div>
