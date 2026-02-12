<!doctype html>
<html lang="en">
<head>
    @php
        $data = App\Models\Setting::first();
        $favicon = $data->logo
            ? asset('storage/images/' . $data->logo)
            : asset('assets/img/favicon.png');
    @endphp
    <base href="/public">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>{{ $data->company ?? '' }}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Use Minified Plugins Version For Fast Page Load -->
        <link rel="stylesheet" type="text/css" media="screen" href="css/plugins.css" />
        <link rel="stylesheet" type="text/css" media="screen" href="css/main.css" />
        <link rel="shortcut icon" type="image/x-icon" href="{{ $favicon }}">


        {{-- Gallery assests --}}
        <link href='assets/plugins/fontawesome-5.15.2/css/all.min.css' rel='stylesheet'>
        <link href='assets/plugins/fontawesome-5.15.2/css/fontawesome.min.css' rel='stylesheet'>
        <link href='assets/plugins/animate/animate.css' rel='stylesheet'>

        <link href='assets/plugins/fancybox/jquery.fancybox.min.css' rel='stylesheet'>
        <link href='assets/plugins/isotope/isotope.min.css' rel='stylesheet'>


        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Dosis:300,400,600,700|Open+Sans:300,400,600,700" rel="stylesheet">

        <!-- Custom css -->
        <link href="assets/css/kidz.css" id="option_style" rel="stylesheet">

        <!-- Favicon -->
        <link href="{{ $favicon }}" rel="shortcut icon">
        
        <!-- Enhanced Footer Styles -->
        <style>
            /* Modern Footer Styling */
            .site-footer {
                background: linear-gradient(135deg, #1a1f2e 0%, #2d3748 100%) !important;
                color: #ffffff;
                position: relative;
                overflow: hidden;
            }
            
            .site-footer::before {
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
            
            .site-footer .container {
                position: relative;
                z-index: 1;
            }
            
            .section-padding {
                padding: 60px 0;
            }
            
            .single-footer {
                margin-bottom: 30px;
            }
            
            .brand-footer img {
                transition: transform 0.3s ease;
                filter: brightness(1.1);
                border-radius: 10px;
            }
            
            .brand-footer:hover img {
                transform: scale(1.05);
            }
            
            .footer-title h3 {
                color: #ffffff;
                font-size: 22px;
                font-weight: 600;
                margin-bottom: 25px;
                position: relative;
                padding-bottom: 15px;
            }
            
            .footer-title h3::after {
                content: '';
                position: absolute;
                bottom: 0;
                left: 0;
                width: 50px;
                height: 3px;
                background: linear-gradient(90deg, #25D366, #128C7E);
                border-radius: 2px;
            }
            
            .footer-contact p {
                margin-bottom: 15px;
                font-size: 15px;
                line-height: 1.8;
            }
            
            .footer-contact .label {
                color: #25D366;
                font-weight: 600;
                display: inline-block;
                min-width: 80px;
            }
            
            .footer-contact .text {
                color: #E9F6F9;
            }
            
            .footer-contact .text a {
                color: #E9F6F9;
                text-decoration: none;
                transition: all 0.3s ease;
            }
            
            .footer-contact .text a:hover {
                color: #25D366;
                text-decoration: underline;
            }
            
            /* Working Hours Table Styling */
            .single-footer .container {
                background: rgba(255, 255, 255, 0.05);
                border-radius: 15px;
                padding: 30px !important;
                backdrop-filter: blur(10px);
                border: 1px solid rgba(255, 255, 255, 0.1);
            }
            
            .single-footer h1 {
                color: #ffffff;
                font-size: 22px;
                font-weight: 600;
                margin-bottom: 25px;
                text-align: center;
            }
            
            .single-footer table {
                width: 100%;
                border-collapse: separate;
                border-spacing: 0;
                border-radius: 10px;
                overflow: hidden;
            }
            
            .single-footer table thead {
                background: linear-gradient(135deg, #25D366, #128C7E);
            }
            
            .single-footer table th {
                padding: 15px;
                text-align: left;
                font-weight: 600;
                color: #ffffff;
                font-size: 14px;
            }
            
            .single-footer table tbody tr {
                background: rgba(255, 255, 255, 0.05);
                transition: all 0.3s ease;
            }
            
            .single-footer table tbody tr:nth-child(even) {
                background: rgba(255, 255, 255, 0.08);
            }
            
            .single-footer table tbody tr:hover {
                background: rgba(37, 211, 102, 0.2);
                transform: scale(1.02);
            }
            
            .single-footer table td {
                padding: 12px 15px;
                color: #E9F6F9;
                font-size: 14px;
            }
            
            /* Newsletter Form Styling */
            .newsletter-form {
                margin-bottom: 30px;
            }
            
            .newsletter-form .form-control {
                background: rgba(255, 255, 255, 0.1);
                border: 1px solid rgba(255, 255, 255, 0.2);
                border-radius: 50px;
                padding: 12px 20px;
                color: #ffffff;
                margin-bottom: 15px;
                transition: all 0.3s ease;
                backdrop-filter: blur(10px);
            }
            
            .newsletter-form .form-control::placeholder {
                color: rgba(255, 255, 255, 0.6);
            }
            
            .newsletter-form .form-control:focus {
                background: rgba(255, 255, 255, 0.15);
                border-color: #25D366;
                outline: none;
                box-shadow: 0 0 0 3px rgba(37, 211, 102, 0.2);
            }
            
            .newsletter-form .btn--primary {
                background: linear-gradient(135deg, #25D366, #128C7E);
                border: none;
                border-radius: 50px;
                padding: 12px 30px;
                color: #ffffff;
                font-weight: 600;
                transition: all 0.3s ease;
                box-shadow: 0 4px 15px rgba(37, 211, 102, 0.3);
            }
            
            .newsletter-form .btn--primary:hover {
                transform: translateY(-2px);
                box-shadow: 0 6px 20px rgba(37, 211, 102, 0.5);
            }
            
            /* Social Media Styling */
            .social-block {
                margin-top: 30px;
            }
            
            .social-block .title {
                color: #ffffff;
                font-size: 18px;
                font-weight: 600;
                margin-bottom: 20px;
            }
            
            .social-list {
                list-style: none;
                padding: 0;
                margin: 0;
                display: flex;
                gap: 15px;
            }
            
            .social-list .single-social {
                width: 45px;
                height: 45px;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 50%;
                background: rgba(255, 255, 255, 0.1);
                transition: all 0.3s ease;
                backdrop-filter: blur(10px);
            }
            
            .social-list .single-social a {
                color: #ffffff;
                font-size: 20px;
                display: flex;
                align-items: center;
                justify-content: center;
                width: 100%;
                height: 100%;
            }
            
            .social-list .single-social:hover {
                background: linear-gradient(135deg, #25D366, #128C7E);
                transform: translateY(-3px);
                box-shadow: 0 5px 15px rgba(37, 211, 102, 0.4);
            }
            
            /* Footer Bottom Styling */
            .footer-bottom {
                background: rgba(0, 0, 0, 0.3);
                border-top: 1px solid rgba(255, 255, 255, 0.1);
                padding: 25px 0;
                position: relative;
                z-index: 1;
            }
            
            .footer-bottom .copyright-text {
                color: #E9F6F9;
                font-size: 14px;
                text-align: center;
                margin: 0;
            }
            
            .footer-bottom .copyright-text a {
                color: #25D366;
                text-decoration: none;
                transition: all 0.3s ease;
            }
            
            .footer-bottom .copyright-text a:hover {
                color: #ffffff;
                text-decoration: underline;
            }
            
            @media (max-width: 991px) {
                .section-padding {
                    padding: 40px 0;
                }
                
                .single-footer {
                    margin-bottom: 40px;
                }
            }
        </style>


    </head>
    
    <body>



<div class="container-fluid">
    {{-- @show --}}
    @yield('content')
</div>


    <!--=================================
    Footer Area
    ===================================== -->
    <footer class="site-footer">
        <div class="container">
            <div class="row justify-content-between section-padding">
                <div class="col-xl-4 col-lg-4 col-sm-6">
                    <div class="single-footer pb-10">
                        <div class="brand-footer footer-title mt-3">
                            <img src="{{ asset('storage/images') . ($data->logo ?? '') }} " alt="Logo" height="200px">
                        </div>
                        <div class="footer-contact">
                            <p><span class="label">Address:</span><span class="text"><a href="https://maps.app.goo.gl/7Ysg5n8ZjhYsdkVN7" target="_blank">{{ $data->address ?? ''  }}</a></span></p>
                            <p><span class="label">Phone:</span><span class="text"><a href="tel:{{ $data->phone ?? '' }}">{{ $data->phone ?? '' }}</a></span></p>
                            <p><span class="label">Email:</span><span class="text"><a href="mailto:{{ $data->email ?? '' }}">{{ $data->email ?? '' }}</a></span></p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-sm-6">
                    <div class="single-footer pb--40">
                        <div class="container">
                            <h1>Weekly Working Hours</h1>
                            <table>
                                <thead>
                                    <tr>
                                        <th>Day</th>
                                        <th>Working Hours</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Monday</td>
                                        <td>9:00 AM - 5:00 PM</td>
                                    </tr>
                                    <tr>
                                        <td>Tuesday</td>
                                        <td>9:00 AM - 5:00 PM</td>
                                    </tr>
                                    <tr>
                                        <td>Wednesday</td>
                                        <td>9:00 AM - 5:00 PM</td>
                                    </tr>
                                    <tr>
                                        <td>Thursday</td>
                                        <td>9:00 AM - 5:00 PM</td>
                                    </tr>
                                    <tr>
                                        <td>Friday</td>
                                        <td>9:00 AM - 5:00 PM</td>
                                    </tr>
                                    <tr>
                                        <td>Saturday</td>
                                        <td>10:00 AM - 4:00 PM</td>
                                    </tr>
                                    <tr>
                                        <td>Sunday</td>
                                        <td style="color: #ff6b6b;">Closed</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-sm-6">
                    <div class="footer-title">
                        <h3>Newsletter Subscribe</h3>
                    </div>
                    <div class="newsletter-form mb--30">
                        <form action="{{ route('subscribe') }}" method="POST" enctype="multipart/form-data" class="contact-form">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="email" class="form-control" placeholder="Enter Your Email" name="email" required>
                                </div>
                                <div class="col-md-12">
                                    <input type="text" class="form-control" placeholder="Enter Your Names" name="names" required>
                                </div>
                            </div>
                            <button type="submit" class="btn btn--primary w-100">Subscribe</button>
                        </form>
                    </div>
                    <div class="social-block">
                        <h3 class="title">STAY CONNECTED</h3>
                        <ul class="social-list list-inline">
                            <li class="single-social facebook"><a href="{{ $data->facebook ?? '#' }}" target="_blank"><i class="ion ion-social-facebook"></i></a></li>
                            <li class="single-social twitter"><a href="{{ $data->twitter ?? '#' }}" target="_blank"><i class="ion ion-social-twitter"></i></a></li>
                            <li class="single-social youtube"><a href="{{ $data->youtube ?? '#' }}" target="_blank"><i class="ion ion-social-youtube"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">
                <p class="copyright-text">© <script>document.write(new Date().getFullYear())</script>, All Right Reserved. <a href="https://iremetech.com" class="author">Delivered By Iremetechnologies</a>.</p>
            </div>
        </div>
    </footer>
    <!-- Use Minified Plugins Version For Fast Page Load -->
    <script src="js/plugins.js"></script>
    <script src="js/ajax-mail.js"></script>
    <script src="js/custom.js"></script>

    {{-- Gallery Scripts --}}

    <script src='assets/plugins/jquery/jquery.min.js'></script>
    <script src='assets/plugins/bootstrap/js/bootstrap.bundle.min.js'></script>

    <script src='assets/plugins/fancybox/jquery.fancybox.min.js'></script>
    <script src='assets/plugins/isotope/isotope.min.js'></script>
    <script src='assets/plugins/images-loaded/js/imagesloaded.pkgd.min.js'></script>

    <script src='assets/plugins/lazyestload/lazyestload.js'></script>
    <script src='assets/plugins/velocity/velocity.min.js'></script>
    <script src='assets/plugins/smoothscroll/SmoothScroll.js'></script>

    <script type="text/javascript">
        (function () {
            var options = {
                whatsapp: "+250788300787", // WhatsApp number
                call_to_action: "Message us", // Call to action
                position: "right", // Position may be 'right' or 'left'
            };
            var proto = document.location.protocol, host = "getbutton.io", url = proto + "//static." + host;
            var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = url + '/widget-send-button/js/init.js';
            s.onload = function () { WhWidgetSendButton.init(host, proto, options); };
            var x = document.getElementsByTagName('script')[0]; x.parentNode.insertBefore(s, x);
        })();
    </script>
</body>

</html>