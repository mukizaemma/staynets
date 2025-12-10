{{-- Register popup form (replace your old mail.php form) --}}
<form id="popup-register-form" method="POST" action="{{ route('register') }}" class="login-form">
    @csrf

    <div class="row">
        <div class="form-group col-12">
            <label for="name">Username</label>
            <input
                id="name"
                name="name"
                type="text"
                class="form-control @error('name') is-invalid @enderror"
                value="{{ old('name') }}"
                required
                autofocus
            >
            @error('name')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
            <div class="invalid-feedback d-none" id="name-error-ajax"></div>
        </div>

        <div class="form-group col-12">
            <label for="email">Your email</label>
            <input
                id="email"
                name="email"
                type="email"
                class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email') }}"
                required
            >
            @error('email')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
            <div class="invalid-feedback d-none" id="email-error-ajax"></div>
        </div>

        <div class="form-group col-12">
            <label for="password">Password</label>
            <input
                id="password"
                name="password"
                type="password"
                class="form-control @error('password') is-invalid @enderror"
                required
                autocomplete="new-password"
            >
            @error('password')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
            <div class="invalid-feedback d-none" id="password-error-ajax"></div>
        </div>

        <div class="form-group col-12">
            <label for="password_confirmation">Confirm Password</label>
            <input
                id="password_confirmation"
                name="password_confirmation"
                type="password"
                class="form-control"
                required
                autocomplete="new-password"
            >
        </div>

        <div class="form-btn mt-20 col-12">
            <button type="submit" id="register-submit" class="th-btn btn-fw th-radius2 w-100">Sign up</button>
        </div>

        <div class="col-12 mt-2">
            <p class="form-messages mb-0 mt-3" id="register-message"></p>
        </div>
    </div>
</form>

{{-- Optional AJAX submit (remove if you want normal non-AJAX submit) --}}
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    if (typeof jQuery === 'undefined') return;

    $('#popup-register-form').on('submit', function (e) {
        e.preventDefault();

        $('#register-message').text('').removeClass('text-danger text-success');
        $('#name-error-ajax, #email-error-ajax, #password-error-ajax').text('').addClass('d-none');
        $('.is-invalid').removeClass('is-invalid');

        var $btn = $('#register-submit');
        var origText = $btn.html();
        $btn.prop('disabled', true).html('Signing up...');

        $.ajax({
            url: @json(route('register')),
            method: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
        }).done(function (res, status, xhr) {
            // On success Laravel may return a redirect. If JSON, check for redirect.
            var redirect = (res && res.redirect) ? res.redirect : '{{ url('/') }}';
            // Show success message briefly then redirect
            $('#register-message').addClass('text-success').text('Registration successful. Redirecting…');
            setTimeout(function () {
                window.location.href = redirect;
            }, 600);
        }).fail(function (xhr) {
            $btn.prop('disabled', false).html(origText);

            if (xhr.status === 422 && xhr.responseJSON) {
                var errors = xhr.responseJSON.errors || {};
                if (errors.name) {
                    $('#name').addClass('is-invalid');
                    $('#name-error-ajax').removeClass('d-none').text(errors.name.join(' '));
                }
                if (errors.email) {
                    $('#email').addClass('is-invalid');
                    $('#email-error-ajax').removeClass('d-none').text(errors.email.join(' '));
                }
                if (errors.password) {
                    $('#password').addClass('is-invalid');
                    $('#password-error-ajax').removeClass('d-none').text(errors.password.join(' '));
                }
                if (xhr.responseJSON.message) {
                    $('#register-message').addClass('text-danger').text(xhr.responseJSON.message);
                }
            } else {
                var msg = 'Registration failed. Please try again.';
                try {
                    var json = JSON.parse(xhr.responseText);
                    if (json.message) msg = json.message;
                } catch (e) {}
                $('#register-message').addClass('text-danger').text(msg);
            }
        });

        return false;
    });
});
</script>
@endpush
