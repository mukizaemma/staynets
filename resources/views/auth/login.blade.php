<x-guest-layout>

    @php
        $data = App\Models\About::first();
    @endphp
    <div class="min-h-screen grid grid-cols-1 md:grid-cols-2">
        <!-- Left Column (Image / Banner) -->
        <div class="hidden md:flex items-center justify-center bg-indigo-600">
            <img src="{{ asset('storage/images/about') . ($data->image1 ?? '') }}" alt="Admin Banner" class="h-full w-full object-cover">
        </div>

        <!-- Right Column (Login Form) -->
        <div class="flex items-center justify-center bg-gray-100 p-6">
            <x-authentication-card class="w-full max-w-md shadow-xl rounded-2xl bg-white p-6">
                <x-slot name="logo">
                    <h1 class="text-2xl font-bold text-center">Booking Site Admin Panel</h1>
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
                        <x-label for="email" value="{{ __('Email') }}" />
                        <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    </div>

                    <div>
                        <x-label for="password" value="{{ __('Password') }}" />
                        <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                    </div>

                    <div class="flex items-center justify-between">
                        <label for="remember_me" class="flex items-center">
                            <x-checkbox id="remember_me" name="remember" />
                            <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a class="text-sm text-indigo-600 hover:text-indigo-800" href="{{ route('password.request') }}">
                                {{ __('Forgot your password?') }}
                            </a>
                        @endif
                    </div>

                    <div>
                        <x-button class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 rounded-lg">
                            {{ __('Log in') }}
                        </x-button>
                    </div>
                </form>
            </x-authentication-card>
        </div>
    </div>
</x-guest-layout>
