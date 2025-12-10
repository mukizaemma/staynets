<x-guest-layout>

    @php
        $data = App\Models\About::first();
    @endphp

    <div class="min-h-screen grid grid-cols-1 md:grid-cols-2"
         style="width: 60%; max-width: 1200px; margin: 40px auto;">

        <!-- Left Column (Image / Banner) -->
        <div class="hidden md:flex items-center justify-center bg-indigo-600 rounded-l-2xl overflow-hidden">
            <img src="{{ asset('storage/images/about') . ($data->image1 ?? '') }}"
                 alt="Banner"
                 class="h-full w-full object-cover">
        </div>

        <!-- Right Column (Login Form) -->
        <div class="flex items-center justify-center bg-gray-100 p-6 rounded-r-2xl">
            <x-authentication-card class="w-full max-w-md shadow-xl rounded-2xl bg-white p-6">

                <x-slot name="logo">
                    <h4 class="text-2xl font-bold text-center text-gray-800">
                        Secure login for property owners
                    </h4>
                </x-slot>

                <x-validation-errors class="mb-4" />

                @if (session('status'))
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-4">
                    @csrf

                    <div>
                        <x-label for="email" value="Email Address" />
                        <x-input id="email" class="block mt-1 w-full"
                                 type="email" name="email" :value="old('email')"
                                 placeholder="example@mail.com"
                                 required autofocus autocomplete="username" />
                    </div>

                    <div>
                        <x-label for="password" value="Password" />
                        <x-input id="password" class="block mt-1 w-full"
                                 type="password" name="password"
                                 placeholder="Enter your password"
                                 required autocomplete="current-password" />
                    </div>

                    <div class="flex items-center justify-between text-sm">
                        <label for="remember_me" class="flex items-center">
                            <x-checkbox id="remember_me" name="remember" />
                            <span class="ml-2 text-gray-600">Remember me</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a class="text-indigo-600 hover:text-indigo-800"
                               href="{{ route('password.request') }}">
                                Forgot password?
                            </a>
                        @endif
                    </div>

                    <!-- Login Button -->
                    <div>
                        <x-button class="w-full bg-indigo-600 hover:bg-indigo-900
                                        text-white font-semibold py-2.5 rounded-lg text-lg">
                            Log in
                        </x-button>
                    </div>

                    <!-- Back Button -->
                    <div class="mt-3">
                        <a href="{{ route('home') }}"
                           class="w-full block text-center bg-gray-300 hover:bg-gray-400
                                  text-gray-800 font-medium py-2.5 rounded-lg">
                            ← Back to Home
                        </a>
                    </div>

                    <!-- Guidance Message -->
                    <p class="text-center text-gray-500 text-sm mt-4">
                        Not ready to log in? Feel free to browse accommodations and trips.
                    </p>

                </form>

            </x-authentication-card>
        </div>
    </div>
</x-guest-layout>
