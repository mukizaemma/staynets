{{-- Styles for layouts.includes.site-footer + WhatsApp float (also header tweaks used on frontbase). --}}
<style>
        /* Enhanced Footer Styling */
        .footer-wrapper.bg-title {
            background: var(--brand-blue);
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
        
        .site-footer-enhanced .widget-area {
            padding-top: 4.5rem;
            padding-bottom: 3.5rem;
        }
        
        .footer-widget .widget_title {
            font-size: 1rem;
            font-weight: 700;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            margin-bottom: 1.25rem;
            color: rgba(255, 255, 255, 0.95);
            position: relative;
            padding-bottom: 0.85rem;
        }
        
        .footer-widget .widget_title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 40px;
            height: 2px;
            background: linear-gradient(90deg, var(--brand-green), var(--brand-blue));
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
        
        /* Smaller logo on small screens so it fits the header without dominating */
        .header-logo img,
        .mobile-logo img,
        .about-logo img {
            height: auto;
            max-height: 52px;
            width: auto;
            object-fit: contain;
        }
        @media (max-width: 991px) {
            .header-logo img {
                width: auto !important;
                max-height: 44px;
            }
        }
        @media (max-width: 575px) {
            .header-logo img {
                width: auto !important;
                max-height: 38px;
            }
            .mobile-logo img {
                width: auto !important;
                max-height: 36px;
            }
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
            background: linear-gradient(135deg, var(--brand-green), var(--brand-blue));
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(75, 144, 67, 0.35);
        }
        
        .th-social--footer a:hover {
            background: linear-gradient(135deg, var(--brand-green), var(--brand-blue));
            box-shadow: 0 5px 16px rgba(75, 144, 67, 0.30);
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
            color: var(--brand-green);
        }
        
        .footer-widget.widget_nav_menu ul.menu li a:hover {
            color: var(--brand-green);
            padding-left: 20px;
        }
        
        .footer-widget.widget_nav_menu ul.menu li a:hover::before {
            opacity: 1;
            left: 0;
        }
        
        .footer-widget.widget_nav_menu ul.menu.footer-quick-links li a::before {
            display: none;
        }
        
        .footer-widget.widget_nav_menu ul.menu.footer-quick-links li a:hover {
            padding-left: 0;
            color: rgba(255, 255, 255, 0.95);
        }
        
        /* Quick links: grid for even spacing (replaces tight CSS columns) */
        .footer-widget.widget_nav_menu ul.menu.footer-quick-links {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.5rem 1.75rem;
            align-items: start;
        }
        
        .footer-widget.widget_nav_menu ul.menu.footer-quick-links li {
            margin-bottom: 0;
        }
        
        @media (max-width: 575px) {
            .footer-widget.widget_nav_menu ul.menu.footer-quick-links {
                grid-template-columns: 1fr;
                gap: 0.35rem;
            }
        }
        
        .footer-reviews-card {
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 12px;
            padding: 1rem 1.1rem;
            background: rgba(0, 0, 0, 0.2);
        }
        
        .footer-reviews-card__head {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.65rem;
        }
        
        .footer-reviews-card__icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.15);
            color: #fff;
            font-size: 0.85rem;
        }
        
        .footer-reviews-card__label {
            font-size: 0.8rem;
            font-weight: 600;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.75);
        }
        
        .footer-reviews-card__stats {
            font-size: 1.35rem;
            font-weight: 700;
            color: #fff;
            letter-spacing: -0.02em;
            line-height: 1.2;
            margin-bottom: 0.5rem;
        }
        
        .footer-reviews-card__outof {
            font-size: 0.95rem;
            font-weight: 500;
            color: rgba(255, 255, 255, 0.45);
        }
        
        .footer-reviews-card__dot {
            margin: 0 0.25rem;
            color: rgba(255, 255, 255, 0.35);
        }
        
        .footer-reviews-card__count {
            font-size: 0.9rem;
            font-weight: 500;
            color: rgba(233, 246, 249, 0.85);
        }
        
        .footer-reviews-card__link {
            display: inline-flex;
            align-items: center;
            font-size: 0.875rem;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            transition: color 0.2s ease, transform 0.2s ease;
        }
        
        .footer-reviews-card__link:hover {
            color: #fff;
        }
        
        .footer-reviews-card__link i {
            font-size: 0.7rem;
            transition: transform 0.2s ease;
        }
        
        .footer-reviews-card__link:hover i {
            transform: translateX(3px);
        }
        
        .footer-book-cta {
            max-width: 260px;
        }
        
        .footer-book-btn.th-btn {
            width: 100%;
            justify-content: center;
            border-radius: 12px;
            padding: 0.65rem 1.25rem;
            font-size: 0.95rem;
            font-weight: 600;
            box-shadow: 0 8px 24px rgba(13, 148, 136, 0.25);
            border: 1px solid rgba(255, 255, 255, 0.12);
        }
        
        .footer-book-btn.th-btn:hover {
            box-shadow: 0 10px 28px rgba(13, 148, 136, 0.35);
        }
        
        .info-box_label {
            font-size: 0.7rem;
            font-weight: 600;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.45);
            margin-bottom: 0.2rem !important;
        }
        
        .copyright-meta {
            opacity: 0.85;
        }
        
        .site-footer-enhanced .info-box_text {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            background: rgba(255, 255, 255, 0.04);
            padding: 14px 16px;
            border-radius: 12px;
            margin-bottom: 12px;
            border: 1px solid rgba(255, 255, 255, 0.06);
            transition: background 0.25s ease, border-color 0.25s ease, transform 0.25s ease;
            backdrop-filter: blur(10px);
        }
        
        .site-footer-enhanced .info-box_text:hover {
            background: rgba(255, 255, 255, 0.08);
            transform: translateY(-2px);
            border-color: rgba(255, 255, 255, 0.2);
        }
        
        .site-footer-enhanced .info-box_text .icon {
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }
        
        .site-footer-enhanced .info-box_text:hover .icon {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.35);
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
            background: rgba(75, 144, 67, 0.20);
            border: 1px solid rgba(75, 144, 67, 0.30);
        }
        
        .info-box_text:hover .icon {
            background: rgba(75, 144, 67, 0.28);
            border-color: var(--brand-green);
        }
        
        .info-box_text .details p,
        .info-box_text .details a {
            color: #E9F6F9;
            font-size: 14px;
        }
        
        .info-box_text .details a:hover {
            color: var(--brand-green);
        }
        
        .destination-btn .th-btn {
            border-radius: 50px;
            padding: 12px 30px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(75, 144, 67, 0.25);
        }
        
        .destination-btn .th-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(75, 144, 67, 0.35);
        }
        
        .copyright-wrap {
            background: rgba(0, 0, 0, 0.18);
            border-top: 1px solid rgba(255, 255, 255, 0.12);
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
            color: var(--brand-green);
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .copyright-text a:hover {
            color: #ffffff;
            text-decoration: underline;
        }
        
        /* Ensure Travel Services dropdown appears above search form */
        .th-header .menu-area {
            position: relative;
            z-index: 1050;
        }
        .th-header .main-menu .sub-menu {
            z-index: 1060;
        }
        
        .btn-add-property:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(75, 144, 67, 0.35) !important;
            color: #fff !important;
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
            background: linear-gradient(135deg, var(--brand-green), var(--brand-blue));
            color: #ffffff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            box-shadow: 0 4px 20px rgba(75, 144, 67, 0.35);
            z-index: 1000;
            transition: all 0.3s ease;
            text-decoration: none;
            animation: pulse 2s infinite;
        }
        
        .whatsapp-float:hover {
            transform: scale(1.1) translateY(-5px);
            box-shadow: 0 6px 25px rgba(75, 144, 67, 0.45);
            background: linear-gradient(135deg, var(--brand-blue), var(--brand-green));
        }
        
        .whatsapp-float i {
            color: #ffffff;
        }
        
        @keyframes pulse {
            0% {
                box-shadow: 0 4px 20px rgba(75, 144, 67, 0.35);
            }
            50% {
                box-shadow: 0 4px 30px rgba(75, 144, 67, 0.45);
            }
            100% {
                box-shadow: 0 4px 20px rgba(75, 144, 67, 0.35);
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
