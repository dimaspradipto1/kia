<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="KIA Care - Layanan Kesehatan Ibu dan Anak Terpercaya">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>@yield('title', 'KIA Care - Kesehatan Ibu & Anak')</title>

    <link rel="icon" href="{{ asset('homepage/img/core-img/logo.png') }}">
    <link rel="stylesheet" href="{{ asset('homepage/style.css') }}">
    <link rel="stylesheet" href="{{ asset('homepage/css/custom-override.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Sora:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --brand-p: #EC1E88;
            --brand-s: #16B3AC;
            --brand-dark: #0F172A;
            --brand-light: #F8FAFC;
            --magenta-soft: rgba(236, 30, 136, 0.05);
            --border-color: rgba(15, 23, 42, 0.08);
            --transition-smooth: all 0.5s cubic-bezier(0.23, 1, 0.32, 1);
        }

        body {
            font-family: 'Inter', sans-serif;
            color: #334155;
            background: #FFFFFF;
            overflow-x: hidden;
        }

        .sora { font-family: 'Sora', sans-serif; }

        /* Modern Container */
        .container-tight { max-width: 1200px; margin: 0 auto; padding: 0 32px; }
        .section-gap { padding: 140px 0; }

        /* Homepage Hero Layout */
        .ve-hero {
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 90px 0 60px;
            overflow: hidden;
            background: #fff;
        }
        .ve-hero-inner {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 40px;
            width: 100%;
            max-width: 1320px;
        }
        .ve-hero-left {
            flex: 1 1 620px;
            min-width: 320px;
            max-width: 740px;
            z-index: 2;
        }
        .ve-hero-right {
            flex: 1 1 520px;
            min-width: 320px;
            max-width: 640px;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            z-index: 1;
        }
        .ve-hero-media {
            position: relative;
            width: 100%;
            max-width: 640px;
        }
        .ve-hero-img-main {
            width: 100%;
            height: auto;
            display: block;
            border-radius: 42px;
            object-fit: cover;
            box-shadow: 0 40px 100px rgba(15, 23, 42, 0.16);
            position: relative;
            z-index: 1;
        }
        .ve-hero-img-accent {
            position: absolute;
            top: -20px;
            right: -20px;
            width: 180px;
            height: 220px;
            border-radius: 30px;
            background-size: cover;
            background-position: center;
            box-shadow: 0 30px 60px rgba(15, 23, 42, 0.12);
            z-index: 2;
        }
        .ve-hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 12px 18px;
            border-radius: 999px;
            background: rgba(236, 30, 136, 0.08);
            border: 1px solid rgba(236, 30, 136, 0.18);
            color: var(--brand-p);
            font-weight: 600;
            font-size: 0.9rem;
            letter-spacing: 0.01em;
            margin-bottom: 28px;
        }
        .ve-hero h1 {
            font-size: clamp(2.8rem, 4.5vw, 4.2rem);
            line-height: 1.02;
            letter-spacing: -0.04em;
            margin-bottom: 24px;
            color: var(--brand-dark);
            max-width: 100%;
        }
        .ve-hero p {
            font-size: clamp(1rem, 1.05vw, 1.18rem);
            line-height: 1.85;
            max-width: 100%;
            margin-bottom: 30px;
            color: #64748B;
        }
        .ve-hero-btns {
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
            margin-bottom: 32px;
        }
        .ve-hero-btns a {
            min-width: 170px;
            padding: 16px 34px;
        }
        @media (min-width: 992px) {
            .ve-hero-btns { flex-wrap: nowrap; }
            .ve-hero-btns a { width: auto; }
        }
        .ve-hero-stats {
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
            margin-top: 28px;
        }
        .ve-stat {
            flex: 1 1 150px;
            min-width: 150px;
            background: #fff;
            border-radius: 26px;
            padding: 22px 24px;
            box-shadow: 0 24px 50px rgba(15, 23, 42, 0.07);
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        .ve-stat strong { font-size: 1.45rem; }
        .ve-float-card {
            position: absolute;
            bottom: 18px;
            left: 22px;
            display: inline-flex;
            align-items: center;
            gap: 14px;
            padding: 18px 24px;
            border-radius: 40px;
            background: #fff;
            box-shadow: 0 30px 60px rgba(15, 23, 42, 0.14);
            min-width: 250px;
            z-index: 3;
        }
        .ve-float-card i {
            color: var(--brand-p);
            font-size: 1.3rem;
            background: rgba(236, 30, 136, 0.08);
            width: 44px;
            height: 44px;
            display: grid;
            place-items: center;
            border-radius: 18px;
        }

        .btn-p, .btn-s, .btn-s-white {
            padding: 18px 36px;
            font-size: 0.98rem;
        }

        .ve-cta-banner .ve-cta-content { padding: 80px 0; }

        .ve-nav-wrap {
            align-items: center;
            gap: 24px;
        }
        .ve-header { padding: 24px 0; }

        .ve-section-header h2 { line-height: 1.12; }

        .ve-newsletter-section .ve-newsletter-wrap {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 24px;
            padding: 30px;
            border-radius: 30px;
            background: #fff;
            box-shadow: 0 30px 70px rgba(15, 23, 42, 0.08);
        }
        .ve-newsletter-right input {
            min-width: 300px;
        }

        /* Infinite Trust Bar Loop */
        .ve-trust-bar {
            background: var(--brand-dark); color: #fff;
            padding: 25px 0; overflow: hidden;
            border-top: 1px solid rgba(255,255,255,0.1);
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .ve-trust-inner {
            display: flex; gap: 80px; width: max-content;
            animation: trustLoop 30s linear infinite;
        }
        .ve-trust-bar:hover .ve-trust-inner { animation-play-state: paused; }
        .ve-trust-inner span {
            font-family: 'Sora', sans-serif; font-weight: 600; font-size: 1.1rem;
            display: flex; align-items: center; gap: 15px; white-space: nowrap;
            opacity: 0.8; transition: opacity 0.3s;
        }
        .ve-trust-inner span:hover { opacity: 1; color: var(--brand-p); }
        .ve-trust-inner i { color: var(--brand-p); font-size: 1.4rem; }

        @keyframes trustLoop {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }

        /* FAQ Marquee */
        .faq-marquee-container {
            width: 100%; overflow: hidden; padding: 40px 0;
            position: relative;
        }
        .faq-marquee-inner {
            display: flex; gap: 30px; width: max-content;
            animation: faqLoop 40s linear infinite;
        }
        .faq-marquee-container:hover .faq-marquee-inner { animation-play-state: paused; }
        .faq-marquee-card {
            width: 400px; background: #fff; border-radius: 40px;
            padding: 40px; border: 1px solid var(--border-color);
            transition: var(--transition-smooth);
            display: flex; flex-direction: column;
        }
        .faq-marquee-card:hover { border-color: var(--brand-p); transform: translateY(-10px); box-shadow: 0 30px 60px rgba(0,0,0,0.05); }
        .border-magenta { border-color: var(--brand-p) !important; }
        .x-small { font-size: 0.8rem; }

        @keyframes faqLoop {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }

        /* Maternity Preloader */
        .preloader {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            z-index: 999999;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: opacity 0.8s cubic-bezier(0.25, 1, 0.5, 1), visibility 0.8s;
            background: linear-gradient(-45deg, #FF80AB, #FF9A9E, #F06292, #FECFEF) !important;
            background-size: 400% 400% !important;
            animation: gradientBG 6s ease infinite !important;
        }
        .preloader.fade-out { opacity: 0; visibility: hidden; }

        .maternity-loader {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            border: 1px solid rgba(255, 255, 255, 0.6);
            padding: 50px 70px;
            border-radius: 40px;
            box-shadow: 0 20px 50px rgba(236, 30, 136, 0.15);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            animation: floatLoader 4s ease-in-out infinite;
        }

        .heart-pulse {
            width: 90px; height: 90px;
            background: linear-gradient(135deg, #EC1E88, #FF80AB);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.8rem;
            color: #fff;
            animation: heartbeat 1.2s cubic-bezier(0.215, 0.61, 0.355, 1) infinite;
            position: relative;
            box-shadow: 0 10px 25px rgba(236, 30, 136, 0.35);
        }
        .heart-pulse i { filter: drop-shadow(0 2px 5px rgba(236, 30, 136, 0.3)); }
        .heart-pulse::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            border: 2px solid rgba(236, 30, 136, 0.6);
            border-radius: 50%;
            animation: pulse-ring 1.8s cubic-bezier(0.215, 0.61, 0.355, 1) infinite;
        }

        .loader-text {
            color: #EC1E88 !important;
            font-size: 1.15rem;
            letter-spacing: 2px;
            font-weight: 800;
            margin-top: 25px;
            text-shadow: 0 1px 2px rgba(255, 255, 255, 0.8);
            animation: textPulse 2s ease-in-out infinite;
        }

        @keyframes heartbeat {
            0% { transform: scale(0.95); }
            5% { transform: scale(1.1); }
            39% { transform: scale(0.85); }
            45% { transform: scale(1); }
            60% { transform: scale(0.95); }
            100% { transform: scale(0.9); }
        }
        @keyframes pulse-ring {
            0% { transform: scale(1); opacity: 0.8; }
            100% { transform: scale(1.8); opacity: 0; }
        }
        @keyframes floatLoader {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        @keyframes textPulse {
            0%, 100% { opacity: 0.8; }
            50% { opacity: 1; }
        }
        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Tech-Savvy Typography */
        .badge-pill {
            display: inline-flex; align-items: center;
            padding: 8px 20px; border-radius: 100px;
            background: var(--magenta-soft); color: var(--brand-p);
            font-weight: 700; font-size: 0.8rem; text-transform: uppercase;
            letter-spacing: 2px; margin-bottom: 30px;
            border: 1px solid rgba(236, 30, 136, 0.1);
        }
        .hero-title-main {
            font-size: 4.5rem; font-weight: 800; line-height: 1.05;
            color: var(--brand-dark); letter-spacing: -0.05em;
            margin-bottom: 35px;
        }
        .hero-subtitle {
            font-size: 1.4rem; line-height: 1.8; color: #64748B;
            max-width: 700px; margin-bottom: 50px; font-weight: 400;
        }

        /* Bento Grid Layout */
        .bento-grid {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            grid-gap: 30px;
            margin-top: 80px;
        }
        .bento-card {
            background: #FFFFFF;
            border: 1px solid var(--border-color);
            border-radius: 40px;
            padding: 50px;
            transition: var(--transition-smooth);
            position: relative;
            overflow: hidden;
            display: flex; flex-direction: column;
            justify-content: space-between;
        }
        .bento-card:hover {
            border-color: var(--brand-p);
            box-shadow: 0 40px 80px -20px rgba(15, 23, 42, 0.08);
            transform: translateY(-10px);
        }
        .bento-card.tall { grid-column: span 4; grid-row: span 2; }
        .bento-card.wide { grid-column: span 8; }
        .bento-card.normal { grid-column: span 4; }

        .icon-circle {
            width: 70px; height: 70px;
            background: var(--brand-light);
            border-radius: 22px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.8rem; color: var(--brand-dark);
            margin-bottom: 40px; transition: var(--transition-smooth);
        }
        .bento-card:hover .icon-circle { background: var(--brand-p); color: #fff; }

        /* App Showcase Mockup Style */
        .mockup-wrap {
            background: linear-gradient(135deg, #F1F5F9 0%, #FFFFFF 100%);
            border-radius: 80px; padding: 120px 80px;
            border: 1px solid var(--border-color);
            position: relative;
        }
        .mockup-screen {
            background: #fff; border-radius: 30px;
            box-shadow: 0 50px 100px -20px rgba(15, 23, 42, 0.15);
            border: 8px solid #0F172A; position: relative;
            z-index: 2;
        }

        /* Unified Premium Buttons */
        .btn-p {
            background: var(--brand-p); color: #fff !important;
            padding: 22px 48px; border-radius: 100px;
            font-weight: 700; border: none;
            transition: var(--transition-smooth);
            display: inline-flex; align-items: center; justify-content: center;
            white-space: nowrap;
            box-shadow: 0 15px 35px rgba(236, 30, 136, 0.25);
            text-decoration: none;
            cursor: pointer;
        }
        .btn-p:hover { transform: scale(1.05); background: #C2186D; box-shadow: 0 20px 45px rgba(236, 30, 136, 0.35); }

        .btn-s {
            background: transparent; color: var(--brand-dark) !important;
            padding: 22px 48px; border-radius: 100px;
            font-weight: 700; border: 1px solid var(--border-color);
            transition: var(--transition-smooth);
            display: inline-flex; align-items: center; justify-content: center;
            white-space: nowrap;
            text-decoration: none;
            cursor: pointer;
        }
        .btn-s:hover { background: #0F172A; color: #fff !important; border-color: #0F172A; }

        .btn-s-white {
            background: transparent; color: #fff !important;
            padding: 22px 48px; border-radius: 100px;
            font-weight: 700; border: 1px solid rgba(255,255,255,0.2);
            transition: var(--transition-smooth);
            display: inline-flex; align-items: center; justify-content: center;
            white-space: nowrap;
            text-decoration: none;
        }
        .btn-s-white:hover { background: #fff; color: var(--brand-dark) !important; }

        /* Faskes Section - Light Mode */
        .faskes-card-light {
            background: #FFFFFF; border-radius: 40px;
            padding: 50px; border: 1px solid var(--border-color);
            transition: var(--transition-smooth);
            height: 100%; display: flex; flex-direction: column;
        }
        .faskes-card-light:hover { border-color: var(--brand-s); box-shadow: 0 30px 60px rgba(22, 179, 172, 0.1); }
        .icon-circle-s {
            width: 60px; height: 60px; background: #E6FFFA; color: var(--brand-s);
            border-radius: 20px; display: flex; align-items: center; justify-content: center;
            font-size: 1.5rem; margin-bottom: 30px;
        }

        /* Modern FAQ Dropdown */
        .faq-v2-item {
            background: #F8FAFC; border-radius: 30px;
            margin-bottom: 15px; border: 1px solid transparent;
            transition: var(--transition-smooth);
            overflow: hidden;
        }
        .faq-v2-item:hover { border-color: rgba(236, 30, 136, 0.2); background: #fff; }
        .faq-v2-trigger {
            padding: 35px 45px; display: flex; justify-content: space-between;
            align-items: center; cursor: pointer;
            width: 100%; background: none; border: none; text-align: left;
        }
        .faq-v2-trigger h4 { font-size: 1.4rem; font-weight: 700; margin: 0; color: var(--brand-dark); }
        .faq-v2-body { padding: 0 45px 35px 45px; color: #64748B; font-size: 1.1rem; line-height: 1.8; }
        .faq-v2-item .arrow { transition: transform 0.4s; color: var(--brand-p); font-size: 1.2rem; }
        .faq-v2-item.active .arrow { transform: rotate(45deg); }

        /* Service Cards Refinement */
        .service-mini-card {
            padding: 45px; border-radius: 40px; background: #fff;
            border: 1px solid var(--border-color); transition: var(--transition-smooth);
            height: 100%; display: flex; flex-direction: column;
        }
        .service-mini-card:hover { border-color: var(--brand-p); box-shadow: 0 30px 60px rgba(236, 30, 136, 0.05); transform: translateY(-5px); }
        .service-mini-card .icon-box {
            width: 65px; height: 65px; background: var(--magenta-soft);
            color: var(--brand-p); border-radius: 20px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.8rem; margin-bottom: 30px; transition: var(--transition-smooth);
        }
        .service-mini-card:hover .icon-box { background: var(--brand-p); color: #fff; }
        .service-mini-card h4 { font-size: 1.4rem; color: var(--brand-dark); }
        .service-btn {
            display: inline-flex; align-items: center; gap: 10px;
            margin-top: auto; color: var(--brand-p); font-weight: 700;
            text-decoration: none; padding: 12px 24px; border-radius: 12px;
            background: var(--magenta-soft); transition: var(--transition-smooth);
            width: fit-content; font-size: 0.95rem;
        }
        .service-btn:hover { background: var(--brand-p); color: #fff !important; }

        /* Responsive Fixes */
        @media (max-width: 1200px) {
            .container-tight { padding: 0 32px; }
            .ve-hero { padding: 100px 0 60px; gap: 32px; }
        }

        @media (max-width: 1024px) {
            .container-tight { padding: 0 28px; }
            .ve-hero { flex-direction: column; align-items: flex-start; padding: 90px 0 50px; }
            .ve-hero-right { width: 100%; min-width: auto; order: -1; margin-bottom: 30px; }
            .ve-hero-left { width: 100%; }
            .ve-hero h1 { font-size: 3rem; max-width: 100%; }
            .ve-hero p { font-size: 1.1rem; margin-bottom: 26px; }
            .ve-hero-btns { gap: 14px; }
            .ve-hero-stats { gap: 14px; }
            .bento-card { padding: 40px; border-radius: 32px; }
            .mockup-wrap { padding: 70px 32px; border-radius: 50px; }
            .section-gap { padding: 100px 0; }
            .ve-cta-banner .ve-cta-content { padding: 60px 0; }
        }

        @media (max-width: 768px) {
            .container-tight { padding: 0 18px; }
            .ve-header { padding: 18px 0; }
            .ve-logo-text span { font-size: 1rem; }
            .ve-hero { padding: 60px 0 40px; gap: 24px; }
            .ve-hero h1 { font-size: 2.5rem; margin-bottom: 18px; }
            .ve-hero p { font-size: 1rem; margin-bottom: 24px; }
            .ve-hero-btns { flex-direction: column; width: 100%; }
            .ve-hero-btns a { width: 100%; }
            .ve-hero-stats { flex-direction: column; gap: 16px; }
            .ve-stat { min-width: auto; }
            .ve-hero-right { order: -1; margin-bottom: 24px; }
            .ve-float-card { position: static; transform: none; margin-top: 24px; width: auto; }
            .bento-grid { grid-template-columns: 1fr; margin-top: 30px; }
            .bento-card { padding: 28px; border-radius: 30px; }
            .mockup-wrap { padding: 48px 24px; border-radius: 32px; }
            .btn-p, .btn-s, .btn-s-white { width: 100%; padding: 16px 18px; font-size: 1rem; }
            .faskes-card-light { padding: 28px; border-radius: 30px; }
            .faq-v2-trigger { padding: 22px 24px; }
            .faq-v2-body { padding: 0 24px 24px 24px; font-size: 0.95rem; }
            .icon-circle { width: 55px; height: 55px; font-size: 1.4rem; margin-bottom: 22px; }
            .hero-title-main { font-size: 2.2rem; }
            .mockup-wrap h2 { font-size: 2rem !important; }
            .mockup-wrap .badge-pill { margin: 0 auto 15px auto; }
            .mockup-wrap .d-flex.mb-4, .mockup-wrap .d-flex.mb-5 { justify-content: center; text-align: left; max-width: 100%; margin: 0 auto; }
            .mockup-wrap .d-flex.gap-4 { flex-direction: column; align-items: stretch; gap: 20px !important; margin-top: 30px; }
            .konsultasi-online { border-radius: 36px !important; padding: 36px 20px !important; text-align: center; }
            .konsultasi-online h2 { font-size: 2.4rem !important; }
            .konsultasi-online p { font-size: 1rem !important; }
            .konsultasi-online .d-flex.gap-4 { flex-direction: column; align-items: center; gap: 16px !important; }
            .konsultasi-online .col-lg-5 { margin-top: 40px; }
            .ve-cta-banner .ve-cta-content { padding: 40px 0; }
            .ve-newsletter-wrap { flex-direction: column; align-items: stretch; gap: 20px; padding: 24px; }
            .ve-newsletter-right input { width: 100%; }
            .section-gap { padding: 60px 0; }
            .ve-nav-cta { display: none !important; }
            .ve-hero-badge { display: none !important; }
            .badge-pill { margin-bottom: 24px; font-size: 0.82rem; }
        }
    </style>
</head>
<body>
    <!-- Preloader -->
    <div class="preloader d-flex align-items-center justify-content-center">
        <div class="maternity-loader">
            <div class="heart-pulse">
                <i class="fa fa-heart"></i>
            </div>
            <div class="loader-text mt-4">
                <span class="sora fw-bold">Memuat Kebahagiaan...</span>
            </div>
        </div>
    </div>

    <!-- ===== NAVBAR (single dark bar, logo left, nav center, CTA right) ===== -->
    <header class="ve-header" id="ve-sticky">
        <div class="container-fluid ve-nav-wrap">
            <!-- Logo -->
            <div class="ve-logo">
                <a href="{{ route('homepage') }}" class="d-flex align-items-center">
                    <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" style="height: 45px;" class="me-2">
                    <div class="ve-logo-text">
                        <span style="font-size: 1.2rem; font-weight: 700; color: #EC1E88;"><strong style="color: var(--primary-color);">KIA</strong></span>
                    </div>
                </a>
            </div>

            <!-- Nav Links -->
            <nav class="ve-nav">
                <ul>
                    <li><a href="{{ route('homepage') }}" class="{{ request()->routeIs('homepage') ? 'active' : '' }}">Beranda</a></li>
                    <li class="has-drop">
                        <a href="{{ route('homepage.about') }}" class="{{ request()->routeIs('homepage.about') ? 'active' : '' }}">Tentang <i class="fa fa-angle-down"></i></a>
                        <ul class="ve-dropdown">
                            <li><a href="{{ route('homepage.about') }}">Tentang Kami</a></li>
                            <li><a href="{{ route('homepage.layanan') }}">Layanan</a></li>
                        </ul>
                    </li>
                    <li><a href="{{ route('homepage.layanan') }}" class="{{ request()->routeIs('homepage.layanan') ? 'active' : '' }}">Layanan</a></li>
                    <li class="has-drop">
                        <a href="#">Program <i class="fa fa-angle-down"></i></a>
                        <ul class="ve-dropdown">
                            <li><a href="{{ route('homepage') }}#program-kehamilan">Kehamilan Sehat</a></li>
                            <li><a href="{{ route('homepage') }}#program-imunisasi">Imunisasi Rutin</a></li>
                            <li><a href="{{ route('homepage') }}#program-gizi">Nutrisi & Gizi</a></li>
                            <li><a href="{{ route('homepage') }}#program-tumbuh">Tumbuh Kembang</a></li>
                        </ul>
                    </li>
                    <li><a href="{{ route('homepage.artikel') }}" class="{{ request()->routeIs('homepage.artikel') ? 'active' : '' }}">Artikel</a></li>
                    <li><a href="{{ route('homepage.contact') }}" class="{{ request()->routeIs('homepage.contact') ? 'active' : '' }}">Kontak</a></li>
                </ul>
            </nav>

            <!-- CTA -->
            <div class="ve-nav-cta">
                @auth
                    <a href="{{ route('dashboard') }}" class="ve-cta-btn">Dashboard <i class="fa fa-th-large"></i></a>
                @else
                    <a href="{{ route('login') }}" class="ve-cta-btn">Masuk <i class="fa fa-sign-in"></i></a>
                @endauth
            </div>

            <!-- Mobile Toggle -->
            <button class="ve-toggler" id="ve-toggle">
                <span></span><span></span><span></span>
            </button>
        </div>

        <!-- Mobile Menu -->
        <div class="ve-mobile-menu" id="ve-mobile-menu">
            <ul>
                <li><a href="{{ route('homepage') }}">Beranda</a></li>
                <li><a href="{{ route('homepage.about') }}">Tentang Kami</a></li>
                <li><a href="{{ route('homepage.layanan') }}">Layanan</a></li>
                <li><a href="{{ route('homepage.artikel') }}">Artikel</a></li>
                <li><a href="{{ route('homepage.contact') }}">Kontak</a></li>
            </ul>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <!-- Scripts -->
    <script src="{{ asset('homepage/js/jquery/jquery-2.2.4.min.js') }}"></script>
    <script src="{{ asset('homepage/js/bootstrap/popper.min.js') }}"></script>
    <script src="{{ asset('homepage/js/bootstrap/bootstrap.min.js') }}"></script>
    <script src="{{ asset('homepage/js/plugins/plugins.js') }}"></script>
    <script src="{{ asset('homepage/js/active.js') }}"></script>
    <script src="{{ asset('homepage/js/vaultedge.js') }}"></script>
    <script>
        $(window).on('load', function() {
            $('.preloader').addClass('fade-out');
            setTimeout(function() {
                $('.preloader').hide();
            }, 800);
        });
    </script>

    @stack('scripts')
</body>
</html>
