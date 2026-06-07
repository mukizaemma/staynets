@extends('layouts.frontbase')

@section('content')
<div class="container py-4" style="max-width: 720px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">My signature</h1>
            <p class="text-muted small mb-0">Save your signature to use when signing listing agreements.</p>
        </div>
        <a href="{{ route('myProperties') }}" class="btn btn-outline-secondary btn-sm">Back to dashboard</a>
    </div>

    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            @if($user->signature_path)
                <p class="text-muted small">Current saved signature:</p>
                <div class="border rounded p-3 bg-light d-inline-block mb-3">
                    <img src="{{ asset('storage/'.$user->signature_path) }}" alt="Your signature" style="max-height: 100px;">
                </div>
            @else
                <p class="text-muted">You have not saved a signature yet.</p>
            @endif

            <form action="{{ route('owner.signature.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Upload signature (PNG or JPG) <span class="text-danger">*</span></label>
                    <input type="file" name="signature_image" class="form-control" accept="image/*" required>
                </div>
                <button type="submit" class="btn btn-primary">Save signature</button>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <h2 class="h6">Account credentials</h2>
            <p class="text-muted small mb-2">Update your name, email, or password from your account profile.</p>
            <a href="{{ route('profile.show') }}" class="btn btn-outline-primary btn-sm"><i class="fas fa-user-cog me-1"></i>Open account settings</a>
        </div>
    </div>
</div>
@endsection
