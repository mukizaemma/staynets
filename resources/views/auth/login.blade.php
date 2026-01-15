<x-guest-layout>

    @php
        $data = App\Models\About::first();
        $setting = App\Models\Setting::first();
        $tripDestinations = App\Models\TripDestination::limit(10)->get();
    @endphp

    <!--==============================
    Mobile Menu
    ============================== -->
    <div class="th-menu-wrapper onepage-nav">
        <div class="th-menu-area text-center">
            <button class="th-menu-toggle"><i class="fal fa-times"></i></button>
            <div class="mobile-logo">
                <a href="{{ route('home') }}"><img src="{{ asset('storage/images') . ($setting->logo ?? '') }}" alt="StayNets" width="120px"></a>
            </div>
            <div class="th-mobile-menu">
                <ul>
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('hotels') }}">Hotels</a></li>
                    <li><a href="{{ route('apartments') }}">Apartments</a></li>
                    <li><a href="{{ route('showCars') }}">Car Rental</a></li>
                    <li class="menu-item-has-children">
                        <a href="{{ route('tours') }}">Trips</a>
                        <ul class="sub-menu">
                            @if(isset($tripDestinations) && $tripDestinations->isNotEmpty())
                                @foreach ($tripDestinations as $destination)
                                    <li><a href="{{route('tripDestination',['slug'=>$destination->slug])}}">{{ $destination->name }}</a></li>
                                @endforeach
                            @else
                                <li><a href="{{ route('tours') }}">View All Destinations</a></li>
                            @endif
                        </ul>
                    </li>
                    <li><a href="{{ route('ticketing') }}">Air Ticketing</a></li>
                    <li><a href="{{ route('leftBags') }}">Left Bags</a></li>
                    <li><a href="{{ route('connect') }}">Contact</a></li>
                    <li><a href="{{ route('myPropertyCreate') }}">Add Property</a></li>
                    @if(auth()->check())
                        <li><a href="{{ route('myProperties') }}">My Properties</a></li>
                        <li>
                            <form id="logout-mobile-form" action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-link p-0">Logout</button>
                            </form>
                        </li>
                    @else
                        <li><a href="{{ route('login') }}">Sign In</a></li>
                        <li><a href="{{ route('register') }}">Register</a></li>
                    @endif
                </ul>
            </div>
        </div>
    </div>

    <!--==============================
    Header Area
    ==============================-->
    <header class="th-header header-layout1 header-layout4 header-layout7">
        <div class="sticky-wrapper">
            <!-- Main Menu Area -->
            <div class="menu-area">
                <div class="container th-container">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto">
                            <div class="header-logo">
                                <a href="{{ route('home') }}"><img src="{{ asset('storage/images') . ($setting->logo ?? '') }}" alt="StayNets" width="150px"></a>
                            </div>
                        </div>
                        <div class="col-auto me-xl-auto">
                            <nav class="main-menu d-none d-xl-inline-block">
                                <ul>
                                    <li><a href="{{ route('home') }}">Home</a></li>
                                    <li><a href="{{ route('hotels') }}">Hotels</a></li>
                                    <li><a href="{{ route('apartments') }}">Apartments</a></li>
                                    <li><a href="{{ route('showCars') }}">Car Rental</a></li>
                                    <li class="menu-item-has-children">
                                        <a href="{{ route('tours') }}">Trips</a>
                                        <ul class="sub-menu">
                                            @if(isset($tripDestinations) && $tripDestinations->isNotEmpty())
                                                @foreach ($tripDestinations as $destination)
                                                    <li><a href="{{route('tripDestination',['slug'=>$destination->slug])}}">{{ $destination->name }}</a></li>
                                                @endforeach
                                            @else
                                                <li><a href="{{ route('tours') }}">View All Destinations</a></li>
                                            @endif
                                        </ul>
                                    </li>
                                    <li><a href="{{ route('leftBags') }}">Left Bags</a></li>
                                    <li><a href="{{ route('ticketing') }}">Air Ticketing</a></li>
                                    <li><a href="{{ route('connect') }}">Contact</a></li>
                                    <li class="d-none d-xl-inline-block">
                                        <a href="{{ route('myPropertyCreate') }}">Add Property</a>
                                    </li>
                                </ul>
                            </nav>
                            <button type="button" class="th-menu-toggle d-block d-xl-none"><i class="far fa-bars"></i></button>
                        </div>
                        <div class="col-auto d-none d-xl-block">
                            <div class="header-button">
                                <a href="{{ route('myPropertyCreate') }}" class="th-btn style3 th-icon">Add Property</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="min-h-screen grid grid-cols-1 md:grid-cols-2"
         style="width: 60%; max-width: 1200px; margin: 40px auto; padding-top: 40px;">

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
