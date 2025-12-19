<!doctype html>
<base href="/public">
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{ $setting->company ?? '' }}</title>
    <meta name="author" content="Tourm">
    <meta name="description" content="Best Accommodation Booking Engine in Rwanda">
    <meta name="keywords" content="{{ $setting->company ?? '' }} ">
    <meta name="robots" content="INDEX,FOLLOW">

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Favicons - Place favicon.ico in the root directory -->
    <link rel="apple-touch-icon" sizes="57x57" href="assets/img/favicons/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="assets/img/favicons/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="assets/img/favicons/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="assets/img/favicons/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="assets/img/favicons/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="assets/img/favicons/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="assets/img/favicons/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('storage/images') . $setting->logo }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('storage/images') . $setting->logo }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('storage/images') . $setting->logo }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('storage/images') . $setting->logo }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('storage/images') . $setting->logo }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('storage/images') . $setting->logo }}">
    <link rel="manifest" href="assets/img/favicons/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="assets/img/favicons/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

    <!--==============================
	  Google Fonts
	============================== -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Manrope:wght@200..800&family=Montez&display=swap" rel="stylesheet">

    <!--==============================
	    All CSS File
	============================== -->
    <!-- Bootstrap -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <!-- Fontawesome Icon -->
    <link rel="stylesheet" href="assets/css/fontawesome.min.css">
    <!-- Magnific Popup -->
    <link rel="stylesheet" href="assets/css/magnific-popup.min.css">

    <!-- Swiper css -->
    <link rel="stylesheet" href="assets/css/swiper-bundle.min.css">

    <!-- Theme Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    

</head>

<body>

    @if (session('success'))
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '{{ session('success') }}',
                    confirmButtonColor: '#25D366'
                });
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops!',
                    text: '{{ session('error') }}',
                    confirmButtonColor: '#d33'
                });
            });
        </script>
    @endif



    <div class="sidemenu-wrapper sidemenu-info ">
        <div class="sidemenu-content">
            <button class="closeButton sideMenuCls"><i class="far fa-times"></i></button>
            <div class="widget  ">
                <div class="th-widget-about">
                    <div class="about-logo">
                        <a href="{{ route('home') }}"><img src="{{ asset('storage/images') . $setting->logo }}" alt="Tourm"></a>
                    </div>
                    <p class="about-text">Discover Rwanda's charm with a peaceful stay through our booking engine.</p>
                    <div class="th-social">
                        <a href="https://www.facebook.com/"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://www.twitter.com/"><i class="fab fa-twitter"></i></a>
                        <a href="https://www.linkedin.com/"><i class="fab fa-linkedin-in"></i></a>
                        <a href="https://www.whatsapp.com/"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>
            </div>
            <div class="widget  ">
                <h3 class="widget_title">Recent Posts</h3>
                <div class="recent-post-wrap">
                    <div class="recent-post">
                        <div class="media-img">
                            <a href="blog-details.html"><img src="assets/img/blog/recent-post-1-1.jpg" alt="Blog Image"></a>
                        </div>
                        <div class="media-body">
                            <div class="recent-post-meta">
                                <a href="blog.html"><i class="far fa-calendar"></i>24 Jun , 2025</a>
                            </div>
                            <h4 class="post-title"><a class="text-inherit" href="blog-details.html">Where Vision Meets Concrete
                                    Reality</a></h4>
                        </div>
                    </div>
                    <div class="recent-post">
                        <div class="media-img">
                            <a href="blog-details.html"><img src="assets/img/blog/recent-post-1-2.jpg" alt="Blog Image"></a>
                        </div>
                        <div class="media-body">
                            <div class="recent-post-meta">
                                <a href="blog.html"><i class="far fa-calendar"></i>22 Jun , 2025</a>
                            </div>
                            <h4 class="post-title"><a class="text-inherit" href="blog-details.html">Raising the Bar in Construction.</a></h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="widget  ">
                <h3 class="widget_title">Get In Touch</h3>
                <div class="th-widget-contact">
                    <div class="info-box_text">
                        <div class="icon">
                            <img src="assets/img/icon/phone.svg" alt="img">
                        </div>
                        <div class="details">
                            <p><a href="tel:{{ $setting->phone ?? '' }}" class="info-box_link">{{ $setting->phone ?? '' }}</a></p>
                            <p><a href="tel:{{ $setting->phone1 ?? '' }}" class="info-box_link">{{ $setting->phone1 ?? '' }}</a></p>
                        </div>
                    </div>
                    <div class="info-box_text">
                        <div class="icon">
                            <img src="assets/img/icon/envelope.svg" alt="img">
                        </div>
                        <div class="details">
                            <p><a href="mailto:{{ $setting->email ?? '' }}" class="info-box_link">{{ $setting->email ?? '' }}</a></p>
                            {{-- <p><a href="mailto:support24@tourm.com" class="info-box_link">support24@tourm.com</a></p> --}}
                        </div>
                    </div>
                    <div class="info-box_text">
                        <div class="icon"><img src="assets/img/icon/location-dot.svg" alt="img"></div>
                        <div class="details">
                            <p>{{ $setting->address ?? '' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="popup-search-box">
        <button class="searchClose"><i class="fal fa-times"></i></button>
        <form action="#">
            <input type="text" placeholder="What are you looking for?">
            <button type="submit"><i class="fal fa-search"></i></button>
        </form>
    </div>
    <!--==============================
    Mobile Menu
  ============================== -->
    <div class="th-menu-wrapper onepage-nav">
        <div class="th-menu-area text-center">
            <button class="th-menu-toggle"><i class="fal fa-times"></i></button>
            <div class="mobile-logo">
                <a href="{{ route('home') }}"><img src="{{ asset('storage/images') . $setting->logo }}" alt="Tourm" width="120px"></a>
            </div>
            <div class="th-mobile-menu">
                <ul>

                    <li><a href="{{ route('home') }}">Home</a></li>

                    <li>
                        <a href="{{ route('hotels') }}">Hotels</a>
                    </li>
                    <li>
                        <a href="{{ route('apartments') }}">Apartments</a>
                    </li>
                    <li>
                        <a href="{{ route('accommodations') }}">Car Rental</a>
                    </li>

                    <li class="menu-item-has-children">
                        <a href="{{ route('destinations') }}">Trips</a>
                        <ul class="sub-menu">
                            @foreach ($destinations as $destination)
                                <li><a href="{{route('destination',['slug'=>$destination->slug])}}">{{ $destination->name }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                    
                    <li>
                        <a href="{{ route('ticketing') }}">Air Ticketing</a>
                    </li>
                    
                    <li>
                        <a href="{{ route('leftBags') }}">Left Bags</a>
                    </li>
                    <li>
                        <a href="{{ route('about') }}">About Us</a>
                    </li>

                    <li>
                        <a href="{{ route('connect') }}">Contact</a>
                    </li>

                    {{-- Mobile login/register or user dropdown --}}
                    @if(auth()->check())
                        <li class="menu-item-has-children">
                            <a href="javascript:void(0)">{{ auth()->user()->name }}</a>
                            <ul class="sub-menu">
                                <li><a href="">Profile</a></li>
                                <li><a href="{{ route('myProperties') }}">My Properties</a></li>
                                <li>
                                    <form id="logout-mobile-form" action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-link p-0">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li><a href="#login-form" class="popup-content">Sign In / Register<i class="fa-regular fa-user"></i></a></li>
                    @endif

                </ul>
            </div>
        </div>
    </div> <!--==============================
	Header Area
==============================-->
    <header class="th-header header-layout1 header-layout4 header-layout7">
        <div class="header-top">
            <div class="container th-container">
                <div class="row justify-content-center justify-content-xl-between align-items-center">
                    <div class="col-auto d-none d-md-block">
                        <div class="header-links">
                            <ul>
                                <li class="d-none d-xl-inline-block"><i class="fa-sharp fa-regular  fa-location-dot"></i>
                                    <span>{{ $setting->address ?? '' }}</span>
                                </li>
                                <li class="d-none d-xl-inline-block"><i class="fa-regular fa-clock"></i>
                                    <span>Monday to Saturday: 7.00 am - 8.00 pm</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="header-right">
                            <div class="header-links">
                                <ul>
                                    <li class="d-none d-md-inline-block"><a href="{{ route('home') }}">FAQ</a></li>
                                    <li class="d-none d-md-inline-block"><a href="{{ route('home') }}">Support</a></li>

                                    {{-- Desktop: show user name + dropdown when logged in, otherwise sign-in link --}}
                                    @if(auth()->check())
                                        <li class="menu-item-has-children">
                                            <a href="javascript:void(0)">{{ auth()->user()->name }} <i class="far fa-caret-down"></i></a>
                                            <ul class="sub-menu">
                                                <li><a href="{">Profile</a></li>
                                                <li><a href="{{ route('myProperties') }}">My Properties</a></li>
                                                <li>
                                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        <button type="submit" class="btn btn-link p-0">Logout</button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </li>
                                    @else
                                        <li><a href="#login-form" class="popup-content">Sign In / Register<i class="fa-regular fa-user"></i></a></li>
                                    @endif

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="sticky-wrapper">
            <!-- Main Menu Area -->
            <div class="menu-area">
                <div class="container th-container">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto">
                            <div class="header-logo">
                                <a href="{{ route('home') }}"><img src="{{ asset('storage/images') . $setting->logo }}" alt="Tourm" width="150px"></a>
                            </div>
                        </div>
                        <div class="col-auto me-xl-auto">
                            <nav class="main-menu d-none d-xl-inline-block">
                                <ul>

                                    <li><a href="{{ route('home') }}">Home</a></li>
                                
                                    {{-- <li class="menu-item-has-children">
                                        <a href="{{ route('services') }}">Services</a>
                                        <ul class="sub-menu">
                                            @foreach ($services as $service)
                                                <li><a href="{{route('service',['slug'=>$service->slug])}}">{{ $service->title }}</a></li>
                                            @endforeach
                                        </ul>
                                    </li> --}}

                                    <li>
                                        <a href="{{ route('hotels') }}">Hotels</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('apartments') }}">Apartments</a>
                                    </li>

                                    <li>
                                        <a href="{{ route('showCars') }}">Car Rental</a>
                                    </li>

                                    <li class="menu-item-has-children">
                                        <a href="{{ route('tours') }}">Trips</a>
                                        <ul class="sub-menu">
                                            @foreach ($destinations as $destination)
                                                <li><a href="{{route('destination',['slug'=>$destination->slug])}}">{{ $destination->name }}</a></li>
                                            @endforeach
                                        </ul>
                                    </li>

                                    <li>
                                        <a href="{{ route('leftBags') }}">Left Bags</a>
                                    </li>

                                    <li>
                                        <a href="{{ route('ticketing') }}">Air Ticketing</a>
                                    </li>
                                 
                                    <li>
                                        <a href="{{ route('about') }}">About Us</a>
                                    </li>
                                 
                                    <li>
                                        <a href="{{ route('connect') }}">Contact</a>
                                    </li>
                                </ul>
                            </nav>
                            <button type="button" class="th-menu-toggle d-block d-xl-none"><i class="far fa-bars"></i></button>
                        </div>
                        <div class="col-auto d-none d-xl-block">
                            <div class="header-button">
                                <a href="{{ route('myProperties') }}" class="th-btn style3 th-icon">List Your Property</a>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>


    <div class="container-fluid">

        @yield('content')
    </div>
    
    <!--==============================
	Footer Area
==============================-->
    <footer class="footer-wrapper bg-title footer-layout2">
        <div class="widget-area">
            <div class="container">
                <div class="row justify-content-between">
                    <div class="col-md-6 col-xl-3">
                        <div class="widget footer-widget">
                            <div class="th-widget-about">
                                <div class="about-logo">
                                    <a href="{{route('home')}}"><img src="{{ asset('storage/images') . ($setting->logo ?? '') }}" 
                                       width="120px" alt="Accoomodation Booking Engine" ></a>
                                </div>
                                <p class="about-text">Where Lake Kivu meets warm hospitality</p>
                                <div class="th-social">
                                    <a href="https://www.facebook.com/"><i class="fab fa-facebook-f"></i></a>
                                    <a href="https://instagram.com/"><i class="fab fa-instagram"></i></a>
                                    <a href="https://instagram.com/"><i class="fab fa-tiktok"></i></a>
                                </div>

                                <div class="destination-btn text-center mt-60">
                                    <a href="{{ route('connect') }}" class="th-btn style3 th-icon">Book Your Stay Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-auto">
                        <div class="widget widget_nav_menu footer-widget">
                            <h3 class="widget_title">Quick Links</h3>
                            <div class="menu-all-pages-container">
                                <ul class="menu">

                                    <li><a href="{{route('about')}}">About Us</a></li>
                                    <li><a href="{{ route('facilities') }}">Our Services</a></li>
                                    <li><a href="{{ route('destinations') }}">Destinations</a></li>
                                    <li><a href="{{ route('accommodations') }}">Accommodations</a></li>
                                    <li><a href="{{ route('promotions') }}">Things to Do in Rwanda</a></li>
                                    <li><a href="{{ route('terms') }}">Our Terms & Conditions</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-auto">
                        <div class="widget footer-widget">
                            <h3 class="widget_title">Get In Touch</h3>
                            <div class="th-widget-contact">
                                <div class="info-box_text">
                                    <div class="icon">
                                        <img src="assets/img/icon/phone.svg" alt="img">
                                    </div>
                                    <div class="details">
                                        <p><a href="tel:{{ $setting->phone ?? '' }}" class="info-box_link">{{ $setting->phone ?? '' }}</a></p>
                                        {{-- <p><a href="tel:+09876543210" class="info-box_link">+09 876 543 210</a></p> --}}
                                    </div>
                                </div>
                                <div class="info-box_text">
                                    <div class="icon">
                                        <img src="assets/img/icon/envelope.svg" alt="img">
                                    </div>
                                    <div class="details">
                                        <p><a href="mailto:{{ $setting->email ?? '' }}" class="info-box_link">{{ $setting->email ?? '' }}</a></p>
                                    </div>
                                </div>
                                <div class="info-box_text">
                                    <div class="icon"><img src="assets/img/icon/location-dot.svg" alt="img"></div>
                                    <div class="details">
                                        <p>{{ $setting->address ?? '' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="copyright-wrap">
            <div class="container">
                <div class="row justify-content-between align-items-center">
                    <div class="col-md-6">
                        <p class="copyright-text">&copy; {{ date('Y') }} <a href="{{route('home')}}">Booking Site</a>. All Rights Reserved. Delivered by <a href="https://www.iremetech.com" target="_blank">Ireme Technologies</a></p>
                    </div>
                    <div class="col-md-6 text-end d-none d-md-block">
                        <div class="footer-card">
                            <span class="title">We Accept</span>
                            <img src="{{ asset('storage/images') . $setting->donate }}" alt="">
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="shape-mockup movingX d-none d-xxl-block" data-top="24%" data-left="5%">
            <img src="assets/img/shape/shape_8.png" alt="shape">
        </div>
    </footer>

    <!--********************************
			Code End  Here 
	******************************** -->

    <!-- Scroll To Top -->
    <div class="scroll-top">
        <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" style="transition: stroke-dashoffset 10ms linear 0s; stroke-dasharray: 307.919, 307.919; stroke-dashoffset: 307.919;">
            </path>
        </svg>
    </div>
    <!--==============================
modal Area  
==============================-->
    <div id="login-form" class="popup-login-register mfp-hide">
        <ul class="nav" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-menu" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="false">Login</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-menu active" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="true">Register</button>
            </li>
        </ul>
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                <h3 class="box-title mb-30">Sign in to your account</h3>
                <div class="th-login-form">

                    @include('frontend.includes.login')

                </div>
            </div>
            <div class="tab-pane fade active show" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                <h3 class="th-form-title mb-30">Sign in to your account</h3>

            </div>    @include('frontend.includes.register')
        </div>
    </div>



    <!--==============================
    All Js File
============================== -->
    <!-- Jquery -->
    <!-- Jquery -->
    <script src="assets/js/vendor/jquery-3.6.0.min.js"></script>
    <!-- Swiper Js -->
    <script src="assets/js/swiper-bundle.min.js"></script>
    <!-- Bootstrap -->
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- Magnific Popup -->
    <script src="assets/js/jquery.magnific-popup.min.js"></script>
    <!-- Counter Up -->
    <script src="assets/js/jquery.counterup.min.js"></script>
    <!-- Range Slider -->
    <script src="assets/js/jquery-ui.min.js"></script>
    <!-- imagesloaded -->
    <script src="assets/js/imagesloaded.pkgd.min.js"></script>
    <!-- isotope -->
    <script src="assets/js/isotope.pkgd.min.js"></script>
    <!-- gsap -->
    <script src="assets/js/gsap.min.js"></script>

    <!-- circle-progress -->
    <script src="assets/js/circle-progress.js"></script>

    <script src="assets/js/matter.min.js"></script>
    <script src="assets/js/matterjs-custom.js"></script>


    <!-- nice select -->
    <script src="assets/js/nice-select.min.js"></script>

    <!-- Main Js File -->
    <script src="assets/js/main.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <a href="https://wa.me/250788316330" target="_blank" class="whatsapp-float">
        <i class="fab fa-whatsapp"></i>
    </a>
</body>

</html>
