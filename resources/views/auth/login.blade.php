<x-guest-layout>

    @php
        $data = App\Models\About::first();
    @endphp

    <div class="min-h-screen grid grid-cols-1 md:grid-cols-2"
         style="width: 60%; max-width: 1200px; margin: 40px auto;">

        <!-- LEFT COLUMN -->
        <div class="hidden md:flex items-center justify-center bg-indigo-600 rounded-l-2xl overflow-hidden">
            <img src="{{ asset('storage/images/about') . ($data->image1 ?? '') }}"
                 alt="Banner"
                 class="h-full w-full object-cover">
        </div>

        <!-- RIGHT COLUMN -->
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

                    <!-- REGISTER TRIGGER -->
                    <button type="button"
                            class="w-full mt-2 border border-indigo-600
                                   text-indigo-600 hover:bg-indigo-50
                                   font-medium py-2.5 rounded-lg"
                            data-bs-toggle="modal"
                            data-bs-target="#registerModal">
                        New here? Create an account
                    </button>

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

    <!-- ================= REGISTER MODAL ================= -->
    <div class="modal fade" id="registerModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-2xl">

                <div class="modal-header">
                    <h5 class="modal-title">Create an account</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <x-validation-errors class="mb-3" />

                    <form method="POST" action="{{ route('register') }}" class="space-y-4">
                        @csrf

                        <div>
                            <x-label for="name" value="Full Name" />
                            <x-input id="name"
                                     class="block mt-1 w-full"
                                     type="text"
                                     name="name"
                                     :value="old('name')"
                                     required />
                        </div>

                        <div>
                            <x-label for="email" value="Email Address" />
                            <x-input id="email"
                                     class="block mt-1 w-full"
                                     type="email"
                                     name="email"
                                     :value="old('email')"
                                     required />
                        </div>

                        <div>
                            <x-label for="password" value="Password" />
                            <x-input id="password"
                                     class="block mt-1 w-full"
                                     type="password"
                                     name="password"
                                     required />
                        </div>

                        <div>
                            <x-label for="password_confirmation" value="Confirm Password" />
                            <x-input id="password_confirmation"
                                     class="block mt-1 w-full"
                                     type="password"
                                     name="password_confirmation"
                                     required />
                        </div>

                        @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                            <div class="mt-3">
                                <label class="flex items-start">
                                    <x-checkbox name="terms" required />
                                    <span class="ml-2 text-sm text-gray-600">
                                        {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                            'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-indigo-600">Terms</a>',
                                            'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-indigo-600">Privacy Policy</a>',
                                        ]) !!}
                                    </span>
                                </label>
                            </div>
                        @endif

                        <div class="mt-4">
                            <x-button class="w-full bg-dark hover:bg-indigo-900 text-white style3">
                                Register
                            </x-button>
                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>

</x-guest-layout>
