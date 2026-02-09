<x-guest-layout>

    @php
        $data = App\Models\About::first();
        $setting = App\Models\Setting::first();
        $tripDestinations = App\Models\TripDestination::limit(10)->get();
    @endphp

    <div style="max-width: 1100px; margin: 60px auto; display: flex; flex-wrap: wrap; gap: 32px; align-items: stretch;">

        <!-- LEFT COLUMN: IMAGE -->
        <div style="flex: 1 1 50%; border-radius: 18px; overflow: hidden; position: relative; background: #000;">
            <img src="{{ asset('storage/images/about') . ($data->image1 ?? '') }}"
                 alt="Stay Nets property"
                 style="width: 100%; height: 100%; object-fit: cover; opacity: 0.95;">
            <div style="position:absolute; inset:0; background:linear-gradient(135deg, rgba(0,0,0,0.6), rgba(0,0,0,0.25));"></div>
            <div style="position:absolute; left:24px; bottom:24px; right:24px; color:#fff;">
                <h2 style="margin:0 0 6px; font-size:22px; font-weight:700;">
                    Manage your property with confidence
                </h2>
                <p style="margin:0; font-size:14px; opacity:0.9;">
                    Secure owner dashboard for updating availability, rates, and bookings.
                </p>
            </div>
        </div>

        <!-- RIGHT COLUMN: LOGIN CARD -->
        <div style="flex: 1 1 40%; display:flex; align-items:center; justify-content:center;">
            <x-authentication-card class="w-full max-w-md shadow-xl rounded-2xl bg-white p-6">

                <x-slot name="logo">
                    <h4 class="text-2xl font-bold text-center text-gray-800" style="margin-bottom: 4px;">
                        Secure login for property owners
                    </h4>
                    <p class="text-sm text-gray-500 text-center">
                        Log in to access your listings, calendars, and bookings.
                    </p>
                </x-slot>

                <x-validation-errors class="mb-4" />

                @if (session('status'))
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- LOGIN FORM -->
                <form method="POST" action="{{ route('login') }}" class="space-y-4">
                    @csrf

                    <div>
                        <x-label for="email" value="Email Address" />
                        <x-input id="email"
                                 class="block mt-1 w-full"
                                 type="email"
                                 name="email"
                                 :value="old('email')"
                                 placeholder="example@mail.com"
                                 required autofocus />
                    </div>

                    <div>
                        <x-label for="password" value="Password" />
                        <x-input id="password"
                                 class="block mt-1 w-full"
                                 type="password"
                                 name="password"
                                 placeholder="Enter your password"
                                 required />
                    </div>

                    <div class="flex items-center justify-between text-sm">
                        <label class="flex items-center">
                            <x-checkbox name="remember" />
                            <span class="ml-2 text-gray-600">Remember me</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a class="text-indigo-600 hover:text-indigo-800"
                               href="{{ route('password.request') }}">
                                Forgot password?
                            </a>
                        @endif
                    </div>

                    <x-button class="w-full bg-dark hover:bg-indigo-900
                                    text-white font-semibold py-2.5 rounded-lg text-lg ">
                        Log in
                    </x-button>

                    <!-- REGISTER LINK -->
                    <a href="{{ route('register') }}"
                       class="block text-center w-full mt-2 border border-indigo-600
                              text-indigo-600 hover:bg-indigo-50
                              font-medium py-2.5 rounded-lg">
                        New here? Create an account
                    </a>

                    <!-- BACK -->
                    <a href="{{ route('home') }}"
                       class="block text-center mt-2 bg-gray-300 hover:bg-gray-400
                              text-gray-800 font-medium py-2.5 rounded-lg">
                        ← Back to Home
                    </a>

                    <p class="text-center text-gray-500 text-sm mt-4">
                        Not ready to log in? Feel free to browse accommodations and trips.
                    </p>
                </form>

            </x-authentication-card>
        </div>
    </div>

</x-guest-layout>
