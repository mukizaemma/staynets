<!doctype html>
<base href="/public">
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{ $setting->company ?? '' }}</title>
    <meta name="author" content="StayNets">
    <meta name="description" content="Best Accommodation Booking Engine in Rwanda">
    <meta name="keywords" content="{{ $setting->company ?? '' }} ">
    <meta name="robots" content="INDEX,FOLLOW">

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    @php
        $favicon = $setting->logo
            ? asset('storage/images/' . $setting->logo)
            : asset('assets/img/favicons/apple-icon-180x180.png');
    @endphp

    <!-- Favicons - Place favicon.ico in the root directory -->
    <link rel="apple-touch-icon" sizes="57x57" href="{{ $favicon }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ $favicon }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ $favicon }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ $favicon }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ $favicon }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ $favicon }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ $favicon }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ $favicon }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ $favicon }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ $favicon }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ $favicon }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ $favicon }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ $favicon }}">
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
    
    <!-- Custom Footer Styles -->
    <style>
        /* Enhanced Footer Styling */
        .footer-wrapper.bg-title {
            background: linear-gradient(135deg, #1a1f2e 0%, #2d3748 100%);
            position: relative;
            overflow: hidden;
        }
        
        .footer-wrapper.bg-title::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><defs><pattern id="grid" width="100" height="100" patternUnits="userSpaceOnUse"><path d="M 100 0 L 0 0 0 100" fill="none" stroke="rgba(255,255,255,0.03)" stroke-width="1"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
            opacity: 0.5;
            pointer-events: none;
        }
        
        .widget-area {
            position: relative;
            z-index: 1;
        }
        
        .footer-widget {
            margin-bottom: 30px;
        }
        
        .footer-widget .widget_title {
            font-size: 22px;
            font-weight: 600;
            margin-bottom: 25px;
            color: #ffffff;
            position: relative;
            padding-bottom: 15px;
        }
        
        .footer-widget .widget_title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 3px;
            background: linear-gradient(90deg, #25D366, #128C7E);
            border-radius: 2px;
        }
        
        /* Header User Dropdown Styles */
        .header-user-dropdown {
            position: relative;
        }
        
        .header-user-dropdown .menu-item-has-children {
            position: relative;
        }
        
        .header-user-dropdown .sub-menu {
            display: none;
            position: absolute;
            right: 0;
            top: 100%;
            background: #fff;
            min-width: 200px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border-radius: 5px;
            padding: 10px 0;
            margin-top: 10px;
            z-index: 999;
            list-style: none;
        }
        
        .header-user-dropdown .menu-item-has-children:hover .sub-menu {
            display: block;
        }
        
        .header-user-dropdown .sub-menu li {
            margin: 0;
        }
        
        .header-user-dropdown .sub-menu li a,
        .header-user-dropdown .sub-menu li button {
            display: block;
            width: 100%;
            text-align: left;
            padding: 10px 20px;
            color: #333;
            text-decoration: none;
            border: none;
            background: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        
        .header-user-dropdown .sub-menu li a:hover,
        .header-user-dropdown .sub-menu li button:hover {
            background-color: #f5f5f5;
        }
        
        .th-widget-about .about-logo img {
            transition: transform 0.3s ease;
            filter: brightness(1.1);
        }
        
        .th-widget-about .about-logo:hover img {
            transform: scale(1.05);
        }
        
        .th-widget-about .about-text {
            color: #E9F6F9;
            font-size: 15px;
            line-height: 1.8;
            margin-bottom: 25px;
        }
        
        .th-social a {
            width: 45px;
            height: 45px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            color: #ffffff;
            margin-right: 12px;
            margin-bottom: 10px;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }
        
        .th-social a:hover {
            background: linear-gradient(135deg, #25D366, #128C7E);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(37, 211, 102, 0.4);
        }
        
        .footer-widget.widget_nav_menu ul.menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .footer-widget.widget_nav_menu ul.menu li {
            margin-bottom: 12px;
        }
        
        .footer-widget.widget_nav_menu ul.menu li a {
            color: #E9F6F9;
            text-decoration: none;
            font-size: 15px;
            transition: all 0.3s ease;
            display: inline-block;
            position: relative;
            padding-left: 0;
        }
        
        .footer-widget.widget_nav_menu ul.menu li a::before {
            content: '→';
            position: absolute;
            left: -20px;
            opacity: 0;
            transition: all 0.3s ease;
            color: #25D366;
        }
        
        .footer-widget.widget_nav_menu ul.menu li a:hover {
            color: #25D366;
            padding-left: 20px;
        }
        
        .footer-widget.widget_nav_menu ul.menu li a:hover::before {
            opacity: 1;
            left: 0;
        }
        
        .footer-widget.widget_nav_menu ul.menu.menu-two-columns {
            column-count: 2;
            column-gap: 30px;
            column-rule: none;
        }
        
        .footer-widget.widget_nav_menu ul.menu.menu-two-columns li {
            break-inside: avoid;
            page-break-inside: avoid;
        }
        
        @media (max-width: 991px) {
            .footer-widget.widget_nav_menu ul.menu.menu-two-columns {
                column-count: 1;
            }
        }
        
        .info-box_text {
            background: rgba(255, 255, 255, 0.05);
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 15px;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }
        
        .info-box_text:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateX(5px);
        }
        
        .info-box_text .icon {
            background: rgba(37, 211, 102, 0.2);
            border: 1px solid rgba(37, 211, 102, 0.3);
        }
        
        .info-box_text:hover .icon {
            background: rgba(37, 211, 102, 0.3);
            border-color: #25D366;
        }
        
        .info-box_text .details p,
        .info-box_text .details a {
            color: #E9F6F9;
            font-size: 14px;
        }
        
        .info-box_text .details a:hover {
            color: #25D366;
        }
        
        .destination-btn .th-btn {
            border-radius: 50px;
            padding: 12px 30px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(37, 211, 102, 0.3);
        }
        
        .destination-btn .th-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(37, 211, 102, 0.5);
        }
        
        .copyright-wrap {
            background: rgba(0, 0, 0, 0.3);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding: 25px 0;
            position: relative;
            z-index: 1;
        }
        
        .copyright-text {
            color: #E9F6F9;
            font-size: 14px;
            margin: 0;
        }
        
        .copyright-text a {
            color: #25D366;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .copyright-text a:hover {
            color: #ffffff;
            text-decoration: underline;
        }
        
        .footer-card {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .footer-card .title {
            color: #E9F6F9;
            font-size: 14px;
            font-weight: 500;
        }
        
        .footer-card img {
            max-height: 35px;
            filter: brightness(1.2);
        }
        
        @media (max-width: 991px) {
            .footer-widget {
                margin-bottom: 40px;
            }
            
            .widget-area {
                padding-top: 60px;
                padding-bottom: 40px;
            }
        }
        
        /* WhatsApp Floating Button */
        .whatsapp-float {
            position: fixed;
            bottom: 30px;
            left: 30px;
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #25D366, #128C7E);
            color: #ffffff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            box-shadow: 0 4px 20px rgba(37, 211, 102, 0.4);
            z-index: 1000;
            transition: all 0.3s ease;
            text-decoration: none;
            animation: pulse 2s infinite;
        }
        
        .whatsapp-float:hover {
            transform: scale(1.1) translateY(-5px);
            box-shadow: 0 6px 25px rgba(37, 211, 102, 0.6);
            background: linear-gradient(135deg, #128C7E, #25D366);
        }
        
        .whatsapp-float i {
            color: #ffffff;
        }
        
        @keyframes pulse {
            0% {
                box-shadow: 0 4px 20px rgba(37, 211, 102, 0.4);
            }
            50% {
                box-shadow: 0 4px 30px rgba(37, 211, 102, 0.6);
            }
            100% {
                box-shadow: 0 4px 20px rgba(37, 211, 102, 0.4);
            }
        }
        
        @media (max-width: 767px) {
            .whatsapp-float {
                width: 55px;
                height: 55px;
                bottom: 20px;
                right: 20px;
                font-size: 24px;
            }
        }
    </style>

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
                        <a href="{{ route('home') }}"><img src="{{ asset('storage/images') . $setting->logo }}" alt="StayNets"></a>
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
                            {{-- <p><a href="mailto:support24@StayNets.com" class="info-box_link">support24@StayNets.com</a></p> --}}
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
                <a href="{{ route('home') }}"><img src="{{ asset('storage/images') . $setting->logo }}" alt="StayNets" width="120px"></a>
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
                    {{-- <li>
                        <a href="{{ route('accommodations') }}">Car Rental</a>
                    </li> --}}

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
                    
                    {{-- <li>
                        <a href="{{ route('ticketing') }}">Air Ticketing</a>
                    </li>
                    
                    <li>
                        <a href="{{ route('leftBags') }}">Left Bags</a>
                    </li> --}}
                    <li>
                        <a href="{{ route('about') }}">About Us</a>
                    </li>

                    <li>
                        <a href="{{ route('connect') }}">Contact</a>
                    </li>

                    {{-- Mobile login/register or user dropdown --}}
                    @if(auth()->check())
                        <li><a href="{{ route('myPropertyCreate') }}">Add Property</a></li>
                        <li class="menu-item-has-children">
                            <a href="javascript:void(0)">{{ auth()->user()->name }}</a>
                            <ul class="sub-menu">
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
                        <li><a href="{{ route('myPropertyCreate') }}">Add Property</a></li>
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
                                <li class="d-none d-xl-inline-block"><i class="fa-sharp fa-regular fa-location-dot"></i>
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
                                    {{-- Social Media Icons --}}
                                    @if($setting->facebook ?? null)
                                        <li class="d-none d-md-inline-block">
                                            <a href="{{ $setting->facebook }}" target="_blank" title="Facebook">
                                                <i class="fab fa-facebook-f"></i>
                                            </a>
                                        </li>
                                    @endif
                                    @if($setting->twitter ?? null)
                                        <li class="d-none d-md-inline-block">
                                            <a href="{{ $setting->twitter }}" target="_blank" title="Twitter">
                                                <i class="fab fa-twitter"></i>
                                            </a>
                                        </li>
                                    @endif
                                    @if($setting->instagram ?? null)
                                        <li class="d-none d-md-inline-block">
                                            <a href="{{ $setting->instagram }}" target="_blank" title="Instagram">
                                                <i class="fab fa-instagram"></i>
                                            </a>
                                        </li>
                                    @endif
                                    @if($setting->linkedin ?? null)
                                        <li class="d-none d-md-inline-block">
                                            <a href="{{ $setting->linkedin }}" target="_blank" title="LinkedIn">
                                                <i class="fab fa-linkedin-in"></i>
                                            </a>
                                        </li>
                                    @endif
                                    @if($setting->youtube ?? null)
                                        <li class="d-none d-md-inline-block">
                                            <a href="{{ $setting->youtube }}" target="_blank" title="YouTube">
                                                <i class="fab fa-youtube"></i>
                                            </a>
                                        </li>
                                    @endif

                                    {{-- User Menu --}}
                                    @if(auth()->check())
                                        <li><a href="{{ route('myProperties') }}">My Properties</a></li>
                                        <li class="menu-item-has-children">
                                            <a href="javascript:void(0)">{{ auth()->user()->name }} <i class="far fa-caret-down"></i></a>
                                            <ul class="sub-menu">
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
                                <a href="{{ route('home') }}"><img src="{{ asset('storage/images') . $setting->logo }}" alt="StayNets" width="150px"></a>
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

                                    {{-- <li>
                                        <a href="{{ route('showCars') }}">Car Rental</a>
                                    </li> --}}

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

                                    {{-- <li>
                                        <a href="{{ route('leftBags') }}">Left Bags</a>
                                    </li>

                                    <li>
                                        <a href="{{ route('ticketing') }}">Air Ticketing</a>
                                    </li> --}}
                                 
                                    {{-- <li>
                                        <a href="{{ route('about') }}">About Us</a>
                                    </li> --}}
                                 
                                    <li>
                                        <a href="{{ route('connect') }}">Contact</a>
                                    </li>
                                    
                                    {{-- Main-menu Add Property (visible on large screens, compact button) --}}
                                    <li class="d-none d-xl-inline-block">
                                        <a href="{{ route('myPropertyCreate') }}"
                                           class="btn btn-primary btn-sm"
                                           style="border-radius: 999px; padding: 8px 18px; font-weight: 600;">
                                            Add Property
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                            <button type="button" class="th-menu-toggle d-block d-xl-none"><i class="far fa-bars"></i></button>
                        </div>
                        {{-- Right-side header button removed; Add Property is now in main menu as a button --}}
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
                                       width="120px" alt="StayNets" ></a>
                                </div>
                                <p class="about-text">The Best Hospitality Services Management in Rwanda</p>
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
                                <ul class="menu menu-two-columns">
                                    <li><a href="{{route('about')}}">About Us</a></li>
                                    <li><a href="{{ route('destinations') }}">Destinations</a></li>
                                    <li><a href="{{ route('hotels') }}">Hotels</a></li>
                                    <li><a href="{{ route('apartments') }}">Apartments</a></li>
                                    {{-- <li><a href="{{ route('ticketing') }}">Air Ticketing</a></li>
                                    <li><a href="{{ route('showCars') }}">Car Rental</a></li>
                                    <li><a href="{{ route('leftBags') }}">Left Bags</a></li> --}}
                                    <li><a href="{{ route('connect') }}">About Us</a></li>
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
                        @php
                            $reviewsCount = \App\Models\Review::where('is_approved', true)->count();
                            $reviewsAvg = \App\Models\Review::where('is_approved', true)->avg('rating') ?? 0;
                        @endphp
                        <div class="footer-card" style="gap: 12px; justify-content: flex-end;">
                            <span class="title">Reviews</span>
                            <span class="title" style="font-weight: 600;">
                                {{ $reviewsCount }} Reviews | {{ number_format($reviewsAvg, 1) }}/5
                            </span>
                            <a href="{{ route('reviews.index') }}" class="th-btn style3" style="padding: 8px 16px; font-size: 12px;">
                                See Reviews
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="shape-mockup movingX d-none d-xxl-block" data-top="24%" data-left="5%">
            <img src="assets/img/shape/shape_8.png" alt="shape">
        </div>
    </footer>
    
    <!-- WhatsApp Floating Button -->
    <a href="https://wa.me/250788316330" target="_blank" class="whatsapp-float" aria-label="Contact us on WhatsApp">
        <i class="fab fa-whatsapp"></i>
    </a>

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
                <button class="nav-menu active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Login</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-menu" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Register</button>
            </li>
        </ul>
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade active show" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                <h3 class="box-title mb-30">Sign in to your account</h3>
                <div class="th-login-form">
                    @include('frontend.includes.login')
                </div>
                <div class="text-center mt-3">
                    <p class="mb-0">Don't have an account? <a href="javascript:void(0)" onclick="switchToRegister()" class="text-primary" style="text-decoration: none; font-weight: 600;">Register here</a></p>
                </div>
            </div>
            <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                <h3 class="th-form-title mb-30">Create your account</h3>
                <div class="th-register-form">
                    @include('frontend.includes.register')
                </div>
                <div class="text-center mt-3">
                    <p class="mb-0">Already have an account? <a href="javascript:void(0)" onclick="switchToLogin()" class="text-primary" style="text-decoration: none; font-weight: 600;">Login here</a></p>
                </div>
            </div>
        </div>
    </div>

    <script>
    function switchToRegister() {
        $('#pills-profile-tab').tab('show');
    }
    
    function switchToLogin() {
        $('#pills-home-tab').tab('show');
    }
    
    // Ensure login tab is active when modal opens
    $(document).on('click', '.popup-content', function() {
        setTimeout(function() {
            $('#pills-home-tab').tab('show');
        }, 100);
    });
    </script>

    <!--==============================
    Forgot Password Modal
==============================-->
    <div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-labelledby="forgotPasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 15px; border: none;">
                <div class="modal-header" style="border-bottom: 1px solid #e0e0e0; padding: 20px 25px;">
                    <h5 class="modal-title" id="forgotPasswordModalLabel" style="font-weight: 600; color: #333;">
                        <i class="fas fa-key me-2" style="color: #25D366;"></i>Reset Password
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="padding: 25px;">
                    <p class="text-muted mb-4">Enter your email address and we'll send you a link to reset your password.</p>
                    
                    <form id="forgot-password-form" method="POST" action="{{ route('password.email') }}">
                        @csrf
                        
                        <div class="form-group mb-4">
                            <label for="forgot_email" class="form-label" style="font-weight: 600;">
                                <i class="fas fa-envelope me-2"></i>Email Address
                            </label>
                            <input
                                type="email"
                                class="form-control form-control-lg"
                                id="forgot_email"
                                name="email"
                                placeholder="Enter your email"
                                required
                                style="border-radius: 8px; border: 2px solid #e0e0e0; padding: 12px 15px;"
                            >
                            <div class="invalid-feedback d-none" id="forgot-email-error"></div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg" id="forgot-submit-btn" style="background: linear-gradient(135deg, #25D366, #128C7E); border: none; border-radius: 8px; padding: 12px; font-weight: 600;">
                                <i class="fas fa-paper-plane me-2"></i>Send Reset Link
                            </button>
                        </div>

                        <div class="mt-3">
                            <p class="form-messages mb-0 text-center" id="forgot-message"></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
    #forgotPasswordModal .modal-content {
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
    }
    
    #forgotPasswordModal .form-control-lg:focus {
        border-color: #25D366;
        box-shadow: 0 0 0 0.2rem rgba(37, 211, 102, 0.25);
    }
    
    #forgotPasswordModal .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(37, 211, 102, 0.4);
    }
    </style>

    <script>
    $(document).ready(function() {
        $('#forgot-password-form').on('submit', function(e) {
            e.preventDefault();
            
            var $btn = $('#forgot-submit-btn');
            var origText = $btn.html();
            $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Sending...');
            $('#forgot-message').text('').removeClass('text-danger text-success');
            $('#forgot_email').removeClass('is-invalid');
            
            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: $(this).serialize(),
                dataType: 'json'
            }).done(function(res) {
                $('#forgot-message').addClass('text-success').html(
                    '<i class="fas fa-check-circle me-2"></i>Password reset link has been sent to your email address!'
                );
                $('#forgot-password-form')[0].reset();
                setTimeout(function() {
                    $('#forgotPasswordModal').modal('hide');
                }, 2000);
            }).fail(function(xhr) {
                $btn.prop('disabled', false).html(origText);
                
                if (xhr.status === 422 && xhr.responseJSON) {
                    var errors = xhr.responseJSON.errors || {};
                    if (errors.email) {
                        $('#forgot_email').addClass('is-invalid');
                        $('#forgot-email-error').removeClass('d-none').text(errors.email[0]);
                    }
                }
                
                var msg = xhr.responseJSON?.message || 'Unable to send reset link. Please try again.';
                $('#forgot-message').addClass('text-danger').text(msg);
            });
        });
    });
    </script>



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


</body>

</html>
