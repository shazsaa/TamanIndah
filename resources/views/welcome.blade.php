<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Taman Indah') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    @include('partials.theme-assets')
    @include('partials.storefront-styles')
    <style>
        html { scroll-behavior: smooth; }

        .btn-home-cta {
            background: #fff;
            color: #4A7C59 !important;
            font-weight: 600;
            border: none;
            border-radius: 8px;
        }
        .btn-home-cta:hover {
            background: #f0f4f0;
            color: #2d5033 !important;
        }

        .home-section-catalog {
            background: #FAFAF5;
        }
        .home-section-title {
            color: #2d5033;
            font-weight: 700;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #4A7C59;
            display: inline-block;
            width: 100%;
            max-width: 100%;
        }
        .home-filter-row {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            align-items: stretch;
        }
        .home-filter-search {
            flex: 2 1 200px;
        }
        .home-filter-search .input-group-text {
            border-color: #d8e8d8;
        }
        .home-filter-search .form-control {
            border-color: #d8e8d8;
        }
        .home-filter-cat {
            flex: 1 1 160px;
        }
        .home-filter-cat .form-select {
            border-color: #d8e8d8;
        }
        .home-filter-sort {
            flex: 1 1 160px;
        }
        .home-filter-actions {
            flex: 0 0 auto;
            display: flex;
            gap: 0.5rem;
            align-items: stretch;
        }
        .btn-home-filter {
            background: #4A7C59;
            color: #fff !important;
            border: none;
            font-weight: 600;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
        }
        .btn-home-filter:hover {
            background: #3d6b4a;
            color: #fff !important;
        }

        .home-product-card.card {
            border-radius: 12px;
            background: #fff;
            border: 0.5px solid #d8e8d8 !important;
            box-shadow: none;
            overflow: hidden;
            transition: transform .2s, box-shadow .2s;
        }
        .home-product-card.card:hover {
            transform: translateY(-4px);
            box-shadow: 0 0.35rem 1rem rgba(45, 80, 51, 0.1);
        }
        .home-product-media {
            position: relative;
            height: 120px;
            background: #A7C4A0;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }
        .product-label {
            position: absolute;
            top: 8px;
            left: 8px;
            font-size: 10px;
            font-weight: 600;
            padding: 2px 8px;
            border-radius: 4px;
            z-index: 1;
        }
        .label-bestseller {
            background: #e07b00;
            color: white;
        }
        .label-easycare {
            background: #4A7C59;
            color: white;
        }
        .label-premium {
            background: #F5A623;
            color: white;
        }
        .home-product-media img {
            width: 100%;
            height: 120px;
            object-fit: cover;
        }
        .home-product-media .bi-image {
            font-size: 2.5rem;
            color: rgba(45, 80, 51, 0.35);
        }
        .home-product-category {
            color: #4A7C59;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: none;
        }
        .home-product-name {
            color: #2d5033;
            font-weight: 700;
        }
        .home-product-price {
            color: #4A7C59;
            font-weight: 700;
        }
        .btn-home-add-cart {
            background: #4A7C59;
            color: #fff !important;
            border: none;
            font-weight: 600;
            border-radius: 8px;
        }
        .btn-home-add-cart:hover {
            background: #3d6b4a;
            color: #fff !important;
        }
        .btn-home-detail {
            color: #4A7C59 !important;
            border-color: #4A7C59 !important;
            border-radius: 8px;
        }
        .btn-home-detail:hover {
            background: #4A7C59;
            color: #fff !important;
        }

        .home-section-how {
            background: #FAFAF5;
        }
        .home-step-num {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: #4A7C59;
            color: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            font-weight: 700;
        }
        .home-section-how h6 {
            color: #2d5033;
            font-weight: 700;
        }

        .home-section-orders {
            background: #f0f4f0;
        }
        .btn-home-primary {
            background: #4A7C59;
            color: #fff !important;
            border: none;
            font-weight: 600;
            border-radius: 8px;
        }
        .btn-home-primary:hover {
            background: #3d6b4a;
            color: #fff !important;
        }

        .pagination-clean-wrap > nav {
            display: flex !important;
            align-items: center;
            justify-content: space-between;
            padding: 12px 0;
            width: 100%;
        }
        .pagination-clean-wrap nav p.small,
        .pagination-clean-wrap nav p.small.text-muted {
            font-size: 12px !important;
            color: #888 !important;
            margin-bottom: 0;
        }
        .pagination-clean-wrap nav p.small .fw-semibold {
            color: #888;
            font-weight: 600;
        }
        .pagination-clean-wrap .pagination {
            margin-bottom: 0;
            gap: 4px;
            flex-wrap: wrap;
        }
        .pagination-clean-wrap .page-item {
            margin: 0;
        }
        .pagination-clean-wrap .page-link {
            width: 30px;
            height: 30px;
            min-width: 30px;
            padding: 0 !important;
            border: 0.5px solid #d8e8d8 !important;
            border-radius: 6px !important;
            background: white !important;
            font-size: 12px;
            display: flex !important;
            align-items: center;
            justify-content: center;
            line-height: 1;
            box-sizing: border-box;
        }
        .pagination-clean-wrap ul.pagination .page-item:not(:first-child):not(:last-child):not(.active) .page-link {
            color: #444 !important;
        }
        .pagination-clean-wrap ul.pagination .page-item:first-child:not(.disabled) .page-link,
        .pagination-clean-wrap ul.pagination .page-item:last-child:not(.disabled) .page-link {
            color: #4A7C59 !important;
        }
        .pagination-clean-wrap .page-item.active .page-link {
            background: #4A7C59 !important;
            color: white !important;
            border-color: #4A7C59 !important;
        }
        .pagination-clean-wrap .page-item.disabled .page-link {
            color: #aaa !important;
            opacity: 1;
        }
        @media (max-width: 575.98px) {
            .pagination-clean-wrap .d-sm-none .page-link {
                width: auto;
                min-width: 30px;
                padding: 0 10px !important;
            }
        }

        .home-about {
            background: #fff;
            padding: 3rem 0;
        }
        .home-about__title {
            font-size: 18px;
            font-weight: 600;
            color: #2d5033;
            border-bottom: 2px solid #4A7C59;
            padding-bottom: 8px;
            display: inline-block;
            margin-bottom: 1.5rem;
        }
        .home-about__grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
        }
        @media (max-width: 991.98px) {
            .home-about__grid {
                grid-template-columns: 1fr;
            }
        }
        .home-about__intro {
            font-size: 13px;
            color: #444;
            line-height: 1.8;
            margin-bottom: 1rem;
        }
        .home-about__row {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 13px;
            color: #444;
            margin-bottom: 8px;
        }
        .home-about__icon {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: #EAF3DE;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            color: #4A7C59;
            font-size: 0.85rem;
        }
        .home-about__card {
            background: #FAFAF5;
            border: 0.5px solid #d8e8d8;
            border-radius: 10px;
            padding: 12px 16px;
            margin-bottom: 10px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }
        .home-about__card:last-child {
            margin-bottom: 0;
        }
        .home-about__card-icon {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: #EAF3DE;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            color: #4A7C59;
            font-size: 0.85rem;
        }
        .home-about__card-title {
            font-size: 13px;
            font-weight: 500;
            color: #2d5033;
        }
        .home-about__card-desc {
            font-size: 12px;
            color: #666;
            margin-top: 2px;
        }
        .home-product-card .card-hover-overlay {
            position: absolute;
            inset: 0;
            background: rgba(45, 80, 51, 0.45);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.2s ease;
            border-radius: 12px 12px 0 0;
            z-index: 3;
        }
        .home-product-card:hover .card-hover-overlay {
            opacity: 1;
        }
        .btn-overlay-detail {
            background: transparent;
            color: #fff;
            border: 1.5px solid #fff;
            border-radius: 8px;
            padding: 7px 20px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            transition: background 0.15s;
        }
        .btn-overlay-detail:hover {
            background: rgba(255,255,255,0.15);
            color: #fff;
        }
        .btn-wishlist-card {
            position: absolute;
            top: 8px;
            right: 8px;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #fff;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 4;
            padding: 0;
        }
        .btn-wishlist-card svg {
            width: 15px;
            height: 15px;
        }
        .btn-card-cart {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: #4A7C59;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            flex-shrink: 0;
            padding: 0;
        }
        .btn-card-cart svg {
            width: 16px;
            height: 16px;
        }
        .btn-card-cart:hover {
            background: #3d6b4a;
        }
        .catalog-filter-wrap { margin-bottom: 1.5rem; }
        .filter-top-bar { display: flex; gap: 12px; align-items: center; }
        .filter-search-wrap { flex: 1; display: flex; align-items: center; gap: 8px; background: #fff; border: 0.5px solid #d8e8d8; border-radius: 8px; padding: 0 14px; height: 42px; }
        .filter-search-input { border: none; outline: none; background: none; font-size: 13px; color: #333; width: 100%; font-family: 'Plus Jakarta Sans', sans-serif; }
        .filter-toggle-btn { display: inline-flex; align-items: center; gap: 6px; background: #4A7C59; color: #fff; border: none; border-radius: 8px; padding: 0 20px; height: 42px; font-size: 13px; font-weight: 600; cursor: pointer; font-family: 'Plus Jakarta Sans', sans-serif; white-space: nowrap; position: relative; }
        .filter-count-badge { background: #fff; color: #4A7C59; border-radius: 50%; width: 18px; height: 18px; font-size: 11px; font-weight: 700; display: inline-flex; align-items: center; justify-content: center; margin-left: 2px; }
        .filter-panel { background: #fff; border: 0.5px solid #d8e8d8; border-radius: 12px; padding: 20px 24px; margin-top: 12px; }
        .filter-panel-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; }
        .filter-panel-title { font-size: 15px; font-weight: 700; color: #2d5033; }
        .filter-close-btn { display: inline-flex; align-items: center; gap: 5px; background: none; border: none; color: #888; font-size: 13px; cursor: pointer; font-family: 'Plus Jakarta Sans', sans-serif; }
        .filter-section { padding: 14px 0; }
        .filter-section-label { font-size: 11px; font-weight: 700; color: #888; letter-spacing: 0.8px; margin-bottom: 10px; }
        .filter-chips { display: flex; flex-wrap: wrap; gap: 8px; }
        .filter-chip { display: inline-block; padding: 6px 14px; border-radius: 20px; font-size: 12.5px; font-weight: 500; border: 0.5px solid #d8e8d8; background: #fff; color: #555; cursor: pointer; transition: all 0.15s; user-select: none; }
        .filter-chip:hover { border-color: #4A7C59; color: #4A7C59; }
        .filter-chip.active { background: #4A7C59; color: #fff; border-color: #4A7C59; }
        .filter-divider { height: 0.5px; background: #eee; }
        .filter-price-row { display: flex; align-items: center; gap: 10px; }
        .filter-price-input { border: 0.5px solid #d8e8d8; border-radius: 8px; padding: 7px 12px; font-size: 13px; color: #333; width: 160px; background: #fafaf8; font-family: 'Plus Jakarta Sans', sans-serif; outline: none; }
        .filter-price-sep { color: #aaa; font-size: 13px; }
        .filter-actions { display: flex; gap: 10px; padding-top: 14px; }
        .filter-btn-reset { flex: 1; text-align: center; border: 0.5px solid #d8e8d8; background: #fff; color: #555; border-radius: 8px; padding: 10px 0; font-size: 13px; font-weight: 600; text-decoration: none; font-family: 'Plus Jakarta Sans', sans-serif; }
        .filter-btn-apply { flex: 2; background: #4A7C59; color: #fff; border: none; border-radius: 8px; padding: 10px 0; font-size: 13px; font-weight: 600; cursor: pointer; font-family: 'Plus Jakarta Sans', sans-serif; }
        .active-filter-tags { display: flex; flex-wrap: wrap; align-items: center; gap: 8px; }
        .active-tag { display: inline-flex; align-items: center; gap: 6px; background: #eaf3de; color: #2e6b11; border-radius: 20px; padding: 4px 12px; font-size: 12px; font-weight: 500; }
        .tag-remove { color: #2e6b11; text-decoration: none; font-weight: 700; opacity: 0.6; }
        .tag-remove:hover { opacity: 1; }
        .hapus-semua-tag { color: #c62828; font-size: 12px; font-weight: 600; text-decoration: none; margin-left: 4px; }
        .hapus-semua-tag:hover { text-decoration: underline; }

                /* Override navbar jadi cream */
        nav.navbar,
        .navbar {
            background-color: #F5F1E8 !important;
            box-shadow: none !important;
            border-bottom: none !important;
        }
        .navbar .navbar-brand,
        .navbar .nav-link,
        .navbar a {
            color: #1A3520 !important;
        }

        /* Matikan blob/animasi hero lama supaya tidak ganggu */
        .hero-blob, .hero-leaf {
            display: none !important;
        }
    </style>
</head>
<body class="home-page">

    @include('partials.storefront-navbar', ['collapseId' => 'homeNav', 'homeAnchors' => true])

    @if(session('success'))
        <span id="flash-success" data-msg="{{ session('success') }}" style="display:none"></span>
    @endif
    @if(session('error'))
        <span id="flash-error" data-msg="{{ session('error') }}" style="display:none"></span>
    @endif

        {{-- HERO --}}
    <section style="
        background: #F5F1E8;
        min-height: calc(100vh - 0px);
        display: flex;
        align-items: center;
        padding: 0 5rem;
        position: relative;
        overflow: hidden;
    ">
    <div style="
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: space-between;
        width: 100%;
        max-width: 1280px;
        margin: 0 auto;
        gap: 2rem;
    ">

        {{-- ===== LEFT COLUMN ===== --}}
        <div style="flex: 1; display: flex; flex-direction: column; align-items: flex-start; z-index: 10; position: relative;">

        <span style="
            border: 1.5px solid #1A3520;
            color: #1A3520;
            font-size: 0.85rem;
            border-radius: 9999px;
            padding: 7px 20px;
            margin-bottom: 1.5rem;
            display: inline-block;
            font-weight: 500;
        ">Toko Tanaman Hias — Kota Malang</span>

        <h1 style="
            font-size: clamp(2.5rem, 4vw, 3.8rem);
            font-weight: 800;
            line-height: 1.15;
            margin-bottom: 1.25rem;
            letter-spacing: -0.5px;
            white-space: nowrap;
        ">
            <span style="color:#1A3520;">Temukan </span><span style="color:#C8860A;">Tanaman</span><br>
            <span style="color:#C8860A;">Impianmu</span><span style="color:#1A3520;"> Disini</span>
        </h1>

        <p style="
            font-size: 1rem;
            color: #4A5C46;
            line-height: 1.7;
            max-width: 360px;
            margin-bottom: 2rem;
        ">Koleksi tanaman hias pilihan untuk mempercantik rumah dan ruangan Anda</p>

        <div style="display: flex; gap: 1rem; margin-bottom: 2.5rem;">
            <a href="#catalog" style="
                background: #C8860A;
                color: #fff;
                padding: 13px 30px;
                border-radius: 9999px;
                font-weight: 600;
                text-decoration: none;
                font-size: 0.95rem;
            ">Lihat Katalog</a>
            <a href="#how-to-order" style="
                border: 2px solid #C8860A;
                color: #C8860A;
                padding: 11px 28px;
                border-radius: 9999px;
                font-weight: 600;
                text-decoration: none;
                font-size: 0.95rem;
                background: transparent;
            ">Cara Pesan</a>
        </div>

        </div>

        {{-- ===== RIGHT COLUMN ===== --}}
        <div style="
            flex: 1.1;
            position: relative;
            height: 580px;
            display: flex;
            justify-content: center;
            align-items: flex-end;
            isolation: isolate;
        ">

        {{-- LAYER 1: Arch shape dengan amber glow --}}
        <div style="
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 370px;
            height: 500px;
            background: #FAF7F0;
            border-radius: 180px 180px 16px 16px;
            box-shadow:
                0 0 50px 25px rgba(200,134,10,0.22),
                0 0 100px 50px rgba(200,134,10,0.10);
            z-index: 1;
            overflow: hidden;
        ">
            {{-- LAYER 2: hero-plant.jpg di DALAM arch --}}
            <img
                src="{{ asset('images/hero-plant.jpg') }}"
                alt="ZZ Plant"
                style="
                    position: absolute;
                    bottom: 0;
                    left: 50%;
                    transform: translateX(-50%);
                    width: 100%;
                    height: 100%;
                    object-fit: cover;
                    object-position: center bottom;
                    mix-blend-mode: multiply;
                "
            >
        </div>

        {{-- LAYER 3: hero-plants.png di ATAS SEMUA LAYER --}}
        <img
            src="{{ asset('images/hero-plants.png') }}"
            alt="Tanaman Hias"
            style="
                position: absolute;
                bottom: -60px;
                left: 50%;
                transform: translateX(-50%);
                width: 780px;
                max-width: none;
                z-index: 99;
                object-fit: contain;
                mix-blend-mode: multiply;
            "
        >

        </div>

    </div>
    </section>

    {{-- CATALOG --}}
    <section id="catalog" class="home-section-catalog py-5">
        <div class="container">
            <h2 class="home-section-title mb-4 reveal">Katalog Produk</h2>

            @php
                $filterActiveCount = (request('category_id') ? 1 : 0) + (request('care_level') ? 1 : 0) + (request('placement_type') ? 1 : 0) + (request('label') ? 1 : 0) + (request('price_min') || request('price_max') ? 1 : 0) + (request('sort') ? 1 : 0);
            @endphp
            <div class="catalog-filter-wrap mb-4">
                <form method="GET" action="{{ url('/') }}#catalog" id="filterForm">
                    <div class="filter-top-bar">
                        <div class="filter-search-wrap">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#aaa" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                            <input type="text" name="search" placeholder="Cari tanaman..." value="{{ request('search') }}" class="filter-search-input">
                        </div>
                        <button type="button" class="filter-toggle-btn" id="filterToggleBtn">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="4" y1="6" x2="20" y2="6"/><line x1="8" y1="12" x2="16" y2="12"/><line x1="11" y1="18" x2="13" y2="18"/></svg>
                            Filter
                            @if($filterActiveCount > 0)
                                <span class="filter-count-badge">{{ $filterActiveCount }}</span>
                            @endif
                        </button>
                    </div>

                    <div class="filter-panel" id="filterPanel" style="display:none;">
                        <div class="filter-panel-header">
                            <span class="filter-panel-title">Filter Produk</span>
                            <button type="button" class="filter-close-btn" id="filterCloseBtn">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                                Tutup
                            </button>
                        </div>

                        <div class="filter-section">
                            <div class="filter-section-label">KATEGORI TANAMAN</div>
                            <div class="filter-chips">
                                <label class="filter-chip {{ !request('category_id') ? 'active' : '' }}">
                                    <input type="radio" name="category_id" value="" style="display:none;">
                                    Semua
                                </label>
                                @foreach($categories as $cat)
                                    <label class="filter-chip {{ request('category_id') == $cat->id ? 'active' : '' }}">
                                        <input type="radio" name="category_id" value="{{ $cat->id }}" style="display:none;" {{ request('category_id') == $cat->id ? 'checked' : '' }}>
                                        {{ $cat->name }}
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="filter-divider"></div>

                        <div class="filter-section">
                            <div class="filter-section-label">RENTANG HARGA</div>
                            <div class="filter-price-row">
                                <input type="text" name="price_min" placeholder="Rp Min" value="{{ request('price_min') }}" class="filter-price-input">
                                <span class="filter-price-sep">—</span>
                                <input type="text" name="price_max" placeholder="Rp Max" value="{{ request('price_max') }}" class="filter-price-input">
                            </div>
                        </div>

                        <div class="filter-divider"></div>

                        <div class="filter-section">
                            <div class="filter-section-label">URUTKAN HARGA</div>
                            <div class="filter-chips">
                                <label class="filter-chip {{ !request('sort') ? 'active' : '' }}">
                                    <input type="radio" name="sort" value="" style="display:none;">
                                    Default
                                </label>
                                <label class="filter-chip {{ request('sort') === 'price_asc' ? 'active' : '' }}">
                                    <input type="radio" name="sort" value="price_asc" style="display:none;" {{ request('sort') === 'price_asc' ? 'checked' : '' }}>
                                    Harga Terendah
                                </label>
                                <label class="filter-chip {{ request('sort') === 'price_desc' ? 'active' : '' }}">
                                    <input type="radio" name="sort" value="price_desc" style="display:none;" {{ request('sort') === 'price_desc' ? 'checked' : '' }}>
                                    Harga Tertinggi
                                </label>
                            </div>
                        </div>

                        <div class="filter-divider"></div>

                        <div class="filter-section">
                            <div class="filter-section-label">KEMUDAHAN PERAWATAN</div>
                            <div class="filter-chips">
                                <label class="filter-chip {{ !request('care_level') ? 'active' : '' }}">
                                    <input type="radio" name="care_level" value="" style="display:none;">
                                    Semua
                                </label>
                                <label class="filter-chip {{ request('care_level') === 'mudah' ? 'active' : '' }}">
                                    <input type="radio" name="care_level" value="mudah" style="display:none;" {{ request('care_level') === 'mudah' ? 'checked' : '' }}>
                                    Easy Care
                                </label>
                                <label class="filter-chip {{ request('care_level') === 'sedang' ? 'active' : '' }}">
                                    <input type="radio" name="care_level" value="sedang" style="display:none;" {{ request('care_level') === 'sedang' ? 'checked' : '' }}>
                                    Perawatan Sedang
                                </label>
                                <label class="filter-chip {{ request('care_level') === 'perlu_perhatian' ? 'active' : '' }}">
                                    <input type="radio" name="care_level" value="perlu_perhatian" style="display:none;" {{ request('care_level') === 'perlu_perhatian' ? 'checked' : '' }}>
                                    Perlu Perhatian
                                </label>
                            </div>
                        </div>

                        <div class="filter-divider"></div>

                        <div class="filter-section">
                            <div class="filter-section-label">PENEMPATAN</div>
                            <div class="filter-chips">
                                <label class="filter-chip {{ !request('placement_type') ? 'active' : '' }}">
                                    <input type="radio" name="placement_type" value="" style="display:none;">
                                    Semua
                                </label>
                                <label class="filter-chip {{ request('placement_type') === 'dalam_ruangan' ? 'active' : '' }}">
                                    <input type="radio" name="placement_type" value="dalam_ruangan" style="display:none;" {{ request('placement_type') === 'dalam_ruangan' ? 'checked' : '' }}>
                                    Dalam Ruangan
                                </label>
                                <label class="filter-chip {{ request('placement_type') === 'luar_ruangan' ? 'active' : '' }}">
                                    <input type="radio" name="placement_type" value="luar_ruangan" style="display:none;" {{ request('placement_type') === 'luar_ruangan' ? 'checked' : '' }}>
                                    Luar Ruangan
                                </label>
                                <label class="filter-chip {{ request('placement_type') === 'keduanya' ? 'active' : '' }}">
                                    <input type="radio" name="placement_type" value="keduanya" style="display:none;" {{ request('placement_type') === 'keduanya' ? 'checked' : '' }}>
                                    Keduanya
                                </label>
                            </div>
                        </div>

                        <div class="filter-divider"></div>

                        <div class="filter-section">
                            <div class="filter-section-label">LABEL PRODUK</div>
                            <div class="filter-chips">
                                <label class="filter-chip {{ !request('label') ? 'active' : '' }}">
                                    <input type="radio" name="label" value="" style="display:none;">
                                    Semua
                                </label>
                                <label class="filter-chip {{ request('label') === 'best_seller' ? 'active' : '' }}">
                                    <input type="radio" name="label" value="best_seller" style="display:none;" {{ request('label') === 'best_seller' ? 'checked' : '' }}>
                                    Best Seller
                                </label>
                                <label class="filter-chip {{ request('label') === 'premium' ? 'active' : '' }}">
                                    <input type="radio" name="label" value="premium" style="display:none;" {{ request('label') === 'premium' ? 'checked' : '' }}>
                                    Premium
                                </label>
                                <label class="filter-chip {{ request('label') === 'easy_care' ? 'active' : '' }}">
                                    <input type="radio" name="label" value="easy_care" style="display:none;" {{ request('label') === 'easy_care' ? 'checked' : '' }}>
                                    Easy Care
                                </label>
                            </div>
                        </div>

                        <div class="filter-divider"></div>

                        <div class="filter-actions">
                            <a href="{{ url('/') }}#catalog" class="filter-btn-reset">Reset</a>
                            <button type="submit" class="filter-btn-apply">Terapkan Filter</button>
                        </div>
                    </div>

                    @if(request('category_id') || request('care_level') || request('placement_type') || request('label') || request('price_min') || request('price_max') || request('sort'))
                        <div class="active-filter-tags mt-3">
                            @if(request('category_id'))
                                @php $activeCat = $categories->firstWhere('id', request('category_id')); @endphp
                                @if($activeCat)
                                    <span class="active-tag">{{ $activeCat->name }} <a href="{{ request()->fullUrlWithQuery(['category_id' => '']) }}" class="tag-remove">x</a></span>
                                @endif
                            @endif
                            @if(request('care_level'))
                                <span class="active-tag">{{ ['mudah'=>'Easy Care','sedang'=>'Perawatan Sedang','perlu_perhatian'=>'Perlu Perhatian'][request('care_level')] ?? request('care_level') }} <a href="{{ request()->fullUrlWithQuery(['care_level' => '']) }}" class="tag-remove">x</a></span>
                            @endif
                            @if(request('placement_type'))
                                <span class="active-tag">{{ ['dalam_ruangan'=>'Dalam Ruangan','luar_ruangan'=>'Luar Ruangan','keduanya'=>'Keduanya'][request('placement_type')] ?? request('placement_type') }} <a href="{{ request()->fullUrlWithQuery(['placement_type' => '']) }}" class="tag-remove">x</a></span>
                            @endif
                            @if(request('label'))
                                <span class="active-tag">{{ ['best_seller'=>'Best Seller','premium'=>'Premium','easy_care'=>'Easy Care'][request('label')] ?? request('label') }} <a href="{{ request()->fullUrlWithQuery(['label' => '']) }}" class="tag-remove">x</a></span>
                            @endif
                            @if(request('price_min') || request('price_max'))
                                <span class="active-tag">Rp {{ request('price_min', '0') }} — Rp {{ request('price_max', '...') }} <a href="{{ request()->fullUrlWithQuery(['price_min' => '', 'price_max' => '']) }}" class="tag-remove">x</a></span>
                            @endif
                            @if(request('sort'))
                                <span class="active-tag">{{ request('sort') === 'price_asc' ? 'Harga Terendah' : 'Harga Tertinggi' }} <a href="{{ request()->fullUrlWithQuery(['sort' => '']) }}" class="tag-remove">x</a></span>
                            @endif
                            <a href="{{ url('/') }}#catalog" class="hapus-semua-tag">Hapus semua</a>
                        </div>
                    @endif
                </form>
            </div>

            @if($products->isEmpty())
                <div class="text-center py-5">
                    <i class="bi bi-inbox display-1 text-muted"></i>
                    <p class="text-muted mt-3">Tidak ada produk ditemukan.</p>
                </div>
            @else
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                    @foreach($products as $product)
                        <div class="col">
                            <div @class([
                                'card home-product-card h-100 reveal',
                                'reveal-delay-1' => ($loop->iteration - 1) % 4 === 0,
                                'reveal-delay-2' => ($loop->iteration - 1) % 4 === 1,
                                'reveal-delay-3' => ($loop->iteration - 1) % 4 === 2,
                            ])>
                                <div class="home-product-media @if($product->image_path) p-0 @endif" style="position:relative;">
                                    {{-- Label --}}
                                    @foreach($product->labels as $lbl)
                                        <span class="product-label {{ $lbl['class'] }}">{{ $lbl['text'] }}</span>
                                    @endforeach

                                    {{-- Wishlist star button --}}
                                    <button type="button" class="btn-wishlist-card" data-product-id="{{ $product->id }}" onclick="toggleStar(this, {{ $product->id }})">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="#c8a800" stroke-width="1.8" class="star-svg">
                                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                                        </svg>
                                    </button>

                                    {{-- Image --}}
                                    @if($product->image_path)
                                        <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="card-img-top">
                                    @else
                                        <i class="bi bi-image"></i>
                                    @endif

                                    {{-- Hover overlay --}}
                                    <div class="card-hover-overlay">
                                        <a href="{{ route('products.show', $product) }}" class="btn-overlay-detail">Lihat Detail</a>
                                    </div>
                                </div>

                                <div class="card-body d-flex flex-column pt-3">
                                    <span class="home-product-category mb-1 d-inline-block">{{ $product->category->name ?? '-' }}</span>
                                    <h6 class="home-product-name card-title mb-1">{{ $product->name }}</h6>
                                    <p class="home-product-price mb-0">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                    <div class="mt-auto pt-2 d-flex justify-content-end">
                                        @if($product->stock > 0)
                                            <form action="{{ route('cart.add') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                <input type="hidden" name="qty" value="1">
                                                <button type="submit" class="btn-card-cart" title="Tambah ke Keranjang">
                                                    <svg viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2">
                                                        <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>
                                                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        @else
                                            <span style="font-size:11px;color:#aaa;">Stok Habis</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="pagination-clean-wrap mt-4">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </section>

    {{-- HOW TO ORDER --}}
    <section id="how-to-order" class="home-section-how py-5">
        <div class="container">
            <h2 class="home-section-title mb-4 reveal">Cara Pemesanan</h2>
            <div class="row g-4">
                <div class="col-md-3 text-center reveal reveal-delay-1">
                    <div class="home-step-num mx-auto mb-3">1</div>
                    <h6>Pilih Produk</h6>
                    <p class="text-muted small">Jelajahi katalog dan temukan tanaman favorit Anda</p>
                </div>
                <div class="col-md-3 text-center reveal reveal-delay-2">
                    <div class="home-step-num mx-auto mb-3">2</div>
                    <h6>Masukkan Keranjang</h6>
                    <p class="text-muted small">Tambahkan produk ke keranjang dan atur jumlah pesanan</p>
                </div>
                <div class="col-md-3 text-center reveal reveal-delay-3">
                    <div class="home-step-num mx-auto mb-3">3</div>
                    <h6>Checkout & Bayar</h6>
                    <p class="text-muted small">Selesaikan pemesanan dan unggah bukti pembayaran</p>
                </div>
                <div class="col-md-3 text-center reveal reveal-delay-4">
                    <div class="home-step-num mx-auto mb-3">4</div>
                    <h6>Ambil Pesanan</h6>
                    <p class="text-muted small">Setelah dikonfirmasi, ambil pesanan di toko kami</p>
                </div>
            </div>
        </div>
    </section>

    <section style="background:white;padding:2.5rem 0;border-top:0.5px solid #e8ede8;border-bottom:0.5px solid #e8ede8;">
        <div class="container">
            <p style="font-size:10px;font-weight:700;color:#4A7C59;letter-spacing:1.5px;text-transform:uppercase;margin-bottom:6px;">Keunggulan Kami</p>
            <h2 style="font-size:20px;font-weight:700;color:#1a3320;margin-bottom:6px;">Kenapa Memilih Taman Indah?</h2>
            <p style="font-size:12px;color:#888;margin-bottom:1.75rem;line-height:1.6;">Kami berkomitmen memberikan pengalaman belanja tanaman hias terbaik untuk Anda.</p>
            <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:14px;">
    <div style="background:white;border:0.5px solid #e8ede8;border-radius:12px;padding:1.25rem;display:flex;gap:14px;align-items:flex-start;">
        <div style="width:42px;height:42px;border-radius:10px;background:#EAF3DE;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M12 2C12 2 6 9 6 14a6 6 0 0012 0C18 9 12 2 12 2z" stroke="#4A7C59" stroke-width="1.5" stroke-linecap="round"/></svg>
        </div>
        <div><p style="font-size:13px;font-weight:700;color:#1a3320;margin-bottom:5px;">Tanaman Berkualitas</p><p style="font-size:11px;color:#666;line-height:1.6;">Dipilih dengan teliti dan dirawat sebelum sampai ke tangan Anda.</p></div>
    </div>
    <div style="background:white;border:0.5px solid #e8ede8;border-radius:12px;padding:1.25rem;display:flex;gap:14px;align-items:flex-start;">
        <div style="width:42px;height:42px;border-radius:10px;background:#EAF3DE;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" stroke="#4A7C59" stroke-width="1.5" stroke-linejoin="round"/></svg>
        </div>
        <div><p style="font-size:13px;font-weight:700;color:#1a3320;margin-bottom:5px;">Harga Terjangkau</p><p style="font-size:11px;color:#666;line-height:1.6;">Harga kompetitif tanpa mengorbankan kualitas tanaman.</p></div>
    </div>
    <div style="background:white;border:0.5px solid #e8ede8;border-radius:12px;padding:1.25rem;display:flex;gap:14px;align-items:flex-start;">
        <div style="width:42px;height:42px;border-radius:10px;background:#EAF3DE;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" stroke="#4A7C59" stroke-width="1.5" stroke-linejoin="round"/><path d="M9 22V12h6v10" stroke="#4A7C59" stroke-width="1.5" stroke-linejoin="round"/></svg>
        </div>
        <div><p style="font-size:13px;font-weight:700;color:#1a3320;margin-bottom:5px;">Pickup Mudah</p><p style="font-size:11px;color:#666;line-height:1.6;">Ambil langsung di toko kami yang nyaman di Kota Malang.</p></div>
    </div>
    <div style="background:white;border:0.5px solid #e8ede8;border-radius:12px;padding:1.25rem;display:flex;gap:14px;align-items:flex-start;">
        <div style="width:42px;height:42px;border-radius:10px;background:#EAF3DE;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2v10z" stroke="#4A7C59" stroke-width="1.5" stroke-linejoin="round"/></svg>
        </div>
        <div><p style="font-size:13px;font-weight:700;color:#1a3320;margin-bottom:5px;">Admin Responsif</p><p style="font-size:11px;color:#666;line-height:1.6;">Siap membantu via WhatsApp kapanpun Anda butuh.</p></div>
    </div>
    <div style="background:white;border:0.5px solid #e8ede8;border-radius:12px;padding:1.25rem;display:flex;gap:14px;align-items:flex-start;">
        <div style="width:42px;height:42px;border-radius:10px;background:#EAF3DE;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" stroke="#4A7C59" stroke-width="1.5"/></svg>
        </div>
        <div><p style="font-size:13px;font-weight:700;color:#1a3320;margin-bottom:5px;">Terpercaya</p><p style="font-size:11px;color:#666;line-height:1.6;">Ratusan pelanggan puas dengan kualitas tanaman kami.</p></div>
    </div>
    <div style="background:white;border:0.5px solid #e8ede8;border-radius:12px;padding:1.25rem;display:flex;gap:14px;align-items:flex-start;">
        <div style="width:42px;height:42px;border-radius:10px;background:#EAF3DE;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><rect x="3" y="3" width="18" height="18" rx="2" stroke="#4A7C59" stroke-width="1.5"/><path d="M9 12h6M12 9v6" stroke="#4A7C59" stroke-width="1.5" stroke-linecap="round"/></svg>
        </div>
        <div><p style="font-size:13px;font-weight:700;color:#1a3320;margin-bottom:5px;">Koleksi Lengkap</p><p style="font-size:11px;color:#666;line-height:1.6;">14+ jenis tanaman dalam 5 kategori berbeda tersedia.</p></div>
    </div>
</div>
        </div>
    </section>

    {{-- TENTANG KAMI --}}
    <section id="tentang-kami" class="home-about" style="background: white; padding: 4rem 0; border-top: 0.5px solid #e8ede8;">
        <div class="container">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 3rem; align-items: start;">

                {{-- LEFT: Brand + Paragraph --}}
                <div>
                    <p style="font-size: 10px; font-weight: 700; color: #4A7C59; letter-spacing: 1.5px; text-transform: uppercase; margin-bottom: 6px;">
                        Tentang Kami
                    </p>
                    <h2 style="font-size: 20px; font-weight: 700; color: #1a3320; margin-bottom: 14px;">
                        Taman Indah
                    </h2>
                    <p style="font-size: 13px; color: #555; line-height: 1.8; margin-bottom: 10px;">
                        Berawal dari kecintaan terhadap tanaman hias,
                        Taman Indah hadir sebagai toko tanaman lokal
                        yang melayani warga Kota Malang. Kami percaya
                        bahwa setiap rumah berhak dihiasi tanaman
                        yang indah — dan kami siap membantu Anda
                        mewujudkannya.
                    </p>
                    <p style="font-size: 13px; color: #555; line-height: 1.8;">
                        Dengan koleksi tanaman pilihan berkualitas,
                        harga terjangkau, dan pelayanan yang ramah,
                        Taman Indah hadir sebagai solusi terpercaya
                        untuk mempercantik setiap sudut rumah dan
                        ruangan Anda.
                    </p>
                </div>

                {{-- RIGHT: Contact Info --}}
                <div style="display: flex; flex-direction: column; gap: 14px; padding-top: 2rem;">

                    {{-- Alamat --}}
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <div style="width: 36px; height: 36px; border-radius: 50%; background: #EAF3DE; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z" stroke="#4A7C59" stroke-width="1.5"/>
                                <circle cx="12" cy="9" r="2.5" stroke="#4A7C59" stroke-width="1.5"/>
                            </svg>
                        </div>
                        <div>
                            <p style="font-size: 11px; color: #aaa; margin-bottom: 2px;">Alamat</p>
                            <p style="font-size: 13px; color: #1a3320; font-weight: 500;">
                                Jl. Taman Indah No. 1, Kota Malang
                            </p>
                        </div>
                    </div>

                    {{-- Jam Operasional --}}
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <div style="width: 36px; height: 36px; border-radius: 50%; background: #EAF3DE; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <circle cx="12" cy="12" r="9" stroke="#4A7C59" stroke-width="1.5"/>
                                <path d="M12 7v5l3 3" stroke="#4A7C59" stroke-width="1.5" stroke-linecap="round"/>
                            </svg>
                        </div>
                        <div>
                            <p style="font-size: 11px; color: #aaa; margin-bottom: 2px;">Jam Operasional</p>
                            <p style="font-size: 13px; color: #1a3320; font-weight: 500;">
                                Senin - Sabtu, 08.00 - 17.00 WIB
                            </p>
                        </div>
                    </div>

                    {{-- WhatsApp --}}
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <div style="width: 36px; height: 36px; border-radius: 50%; background: #EAF3DE; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z" fill="#4A7C59"/>
                                <path d="M12 2C6.477 2 2 6.477 2 12c0 1.89.525 3.66 1.438 5.168L2 22l4.978-1.38A9.953 9.953 0 0012 22c5.523 0 10-4.477 10-10S17.523 2 12 2z" stroke="#4A7C59" stroke-width="1.5"/>
                            </svg>
                        </div>
                        <div>
                            <p style="font-size: 11px; color: #aaa; margin-bottom: 2px;">WhatsApp</p>
                            <p style="font-size: 13px; color: #1a3320; font-weight: 500;">0812-3456-7890</p>
                        </div>
                    </div>

                    {{-- Email --}}
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <div style="width: 36px; height: 36px; border-radius: 50%; background: #EAF3DE; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <rect x="2" y="4" width="20" height="16" rx="2" stroke="#4A7C59" stroke-width="1.5"/>
                                <path d="M2 7l10 7 10-7" stroke="#4A7C59" stroke-width="1.5" stroke-linecap="round"/>
                            </svg>
                        </div>
                        <div>
                            <p style="font-size: 11px; color: #aaa; margin-bottom: 2px;">Email</p>
                            <p style="font-size: 13px; color: #1a3320; font-weight: 500;">tamanindah@gmail.com</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    {{-- TESTIMONIALS --}}
    <section class="home-section-testimonials" style="background: white; padding: 5rem 0; border-top: 0.5px solid #e8ede8;">
        <div class="container">
            <p style="font-size: 10px; font-weight: 700; color: #4A7C59; letter-spacing: 1.5px; text-transform: uppercase; margin-bottom: 4px;">
                Apa Kata Mereka
            </p>
            <h2 style="font-size: 18px; font-weight: 700; color: #1a3320; margin-bottom: 1.25rem;">
                Ulasan Pelanggan Kami
            </h2>
            <div class="row row-cols-1 row-cols-md-3" style="--bs-gutter-x: 14px; --bs-gutter-y: 14px;">
                <div class="col">
                    <div style="background: white; border: 0.5px solid #e8ede8; border-radius: 12px; padding: 16px;">
                        <div style="color: #F5A623; font-size: 13px; margin-bottom: 8px;">★★★★★</div>
                        <p style="font-size: 12px; color: #555; line-height: 1.65; font-style: italic; margin-bottom: 12px;">"Tanamannya sehat dan segar. Langsung ambil di toko dan pelayanannya ramah banget. Pasti balik lagi!"</p>
                        <div class="d-flex align-items-center gap-2">
                            <div style="width: 32px; height: 32px; border-radius: 50%; background: #A7C4A0; display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 700; color: #2d5033;">RA</div>
                            <div>
                                <div style="font-size: 12px; font-weight: 600; color: #1a3320;">Rina Agustina</div>
                                <div style="font-size: 10px; color: #888;">Malang</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div style="background: white; border: 0.5px solid #e8ede8; border-radius: 12px; padding: 16px;">
                        <div style="color: #F5A623; font-size: 13px; margin-bottom: 8px;">★★★★★</div>
                        <p style="font-size: 12px; color: #555; line-height: 1.65; font-style: italic; margin-bottom: 12px;">"Aglonema yang saya beli tumbuh subur. Harganya juga terjangkau, kualitasnya tidak perlu diragukan lagi!"</p>
                        <div class="d-flex align-items-center gap-2">
                            <div style="width: 32px; height: 32px; border-radius: 50%; background: #A7C4A0; display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 700; color: #2d5033;">DW</div>
                            <div>
                                <div style="font-size: 12px; font-weight: 600; color: #1a3320;">Dewi Wahyuni</div>
                                <div style="font-size: 10px; color: #888;">Malang</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div style="background: white; border: 0.5px solid #e8ede8; border-radius: 12px; padding: 16px;">
                        <div style="font-size: 13px; margin-bottom: 8px;"><span style="color: #F5A623;">★★★★</span><span style="color: #d0d0d0;">★</span></div>
                        <p style="font-size: 12px; color: #555; line-height: 1.65; font-style: italic; margin-bottom: 12px;">"Pesan lewat website mudah banget, konfirmasi adminnya cepat. Tanamannya bagus dan sesuai foto di katalog."</p>
                        <div class="d-flex align-items-center gap-2">
                            <div style="width: 32px; height: 32px; border-radius: 50%; background: #A7C4A0; display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 700; color: #2d5033;">BH</div>
                            <div>
                                <div style="font-size: 12px; font-weight: 600; color: #1a3320;">Budi Hartono</div>
                                <div style="font-size: 10px; color: #888;">Malang</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('partials.storefront-footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
function toggleStar(btn, productId) {
    @if(auth()->check())
    fetch("{{ route('wishlist.toggle') }}", {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        body: JSON.stringify({ product_id: productId })
    })
    .then(res => res.json())
    .then(data => {
        const svg = btn.querySelector('.star-svg');
        svg.setAttribute('fill', data.saved ? '#e8a000' : 'none');
        svg.setAttribute('stroke', data.saved ? '#e8a000' : '#c8a800');
    });
    @else
    window.location.href = "{{ route('login') }}";
    @endif
}

@auth
const savedIds = @json(auth()->user()->wishlists()->pluck('product_id'));
document.querySelectorAll('.btn-wishlist-card').forEach(btn => {
    const pid = parseInt(btn.getAttribute('data-product-id'));
    if (savedIds.includes(pid)) {
        const svg = btn.querySelector('.star-svg');
        svg.setAttribute('fill', '#e8a000');
        svg.setAttribute('stroke', '#e8a000');
    }
});
@endauth
    </script>
    <script>
const filterToggleBtn = document.getElementById('filterToggleBtn');
const filterPanel = document.getElementById('filterPanel');
const filterCloseBtn = document.getElementById('filterCloseBtn');

if (filterToggleBtn && filterPanel) {
    filterToggleBtn.addEventListener('click', function() {
        filterPanel.style.display = filterPanel.style.display === 'none' ? 'block' : 'none';
    });
}
if (filterCloseBtn && filterPanel) {
    filterCloseBtn.addEventListener('click', function() {
        filterPanel.style.display = 'none';
    });
}

document.querySelectorAll('.filter-chip').forEach(function(chip) {
    chip.addEventListener('click', function() {
        const input = this.querySelector('input[type="radio"]');
        if (!input) return;
        const name = input.name;
        document.querySelectorAll('input[name="' + name + '"]').forEach(function(r) {
            r.closest('.filter-chip').classList.remove('active');
        });
        this.classList.add('active');
        input.checked = true;
    });
});
    </script>
</body>
</html>
