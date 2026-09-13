<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $product->name }} - {{ config('app.name', 'Taman Indah') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    @include('partials.theme-assets')
    @include('partials.storefront-styles')
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .product-detail-name {
            font-size: 20px;
            font-weight: 600;
            color: #2d5033;
        }
        .product-detail-price {
            font-size: 17px;
            font-weight: 500;
            color: #4A7C59;
        }
        .product-detail-category {
            display: inline-block;
            font-size: 11px;
            padding: 3px 10px;
            border-radius: 6px;
            background: #EAF3DE;
            color: #3B6D11;
        }
        .product-detail-stock {
            display: inline-block;
            font-size: 11px;
            padding: 4px 10px;
            border-radius: 6px;
            background: #4A7C59;
            color: #fff;
        }
        .product-detail-stock--out {
            background: #c62828;
            color: #fff;
        }
        .product-detail-qty-wrap {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .product-detail-qty.form-control {
            height: 36px;
            width: 64px;
            padding: 0 8px;
            box-sizing: border-box;
            min-height: 36px;
            border: 0.5px solid #d8e8d8;
            border-radius: 8px;
            text-align: center;
            font-size: 13px;
        }
        .product-detail-add-btn {
            height: 36px;
            line-height: 1;
            display: inline-flex;
            align-items: center;
            padding: 0 20px;
            font-size: 13px;
            border-radius: 8px;
            background: #4A7C59;
            color: #fff;
            border: none;
            font-weight: 500;
        }
        .product-detail-add-btn:hover {
            background: #3d6b4a;
            color: #fff;
        }
        .product-img {
            max-height: 420px;
            object-fit: cover;
            border-radius: 12px;
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
        .label-bestseller { background: #e07b00; color: white; }
        .label-easycare   { background: #4A7C59; color: white; }
        .label-premium    { background: #F5A623; color: white; }
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
        }
        .home-product-name  { color: #2d5033; font-weight: 700; }
        .home-product-price { color: #4A7C59; font-weight: 700; }
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
        .home-product-card:hover .card-hover-overlay { opacity: 1; }
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
        .btn-wishlist-card svg { width: 15px; height: 15px; }
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
        .btn-card-cart svg { width: 16px; height: 16px; }
        .btn-card-cart:hover { background: #3d6b4a; }
        .product-badge-overlay {
            position: absolute;
            left: 12px;
            font-size: 10px;
            font-weight: 600;
            padding: 2px 8px;
            border-radius: 4px;
            z-index: 2;
        }
        .product-img-wrapper {
            position: relative;
            display: inline-block;
            width: 100%;
        }
        .rating-row {
            display: flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 8px;
        }
        .rating-star {
            color: #e8a000;
            font-size: 15px;
            line-height: 1;
        }
        .rating-num {
            font-size: 13.5px;
            font-weight: 600;
            color: #333;
        }
        .rating-count {
            font-size: 12.5px;
            color: #aaa;
        }
        .care-card {
            background: #fff;
            border: 1px solid #e5eee0;
            border-radius: 10px;
            padding: 14px 10px;
            text-align: center;
        }
        .care-icon-wrap {
            width: 36px;
            height: 36px;
            background: #edf6e4;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 8px;
        }
        .care-lbl {
            font-size: 9.5px;
            color: #aaa;
            letter-spacing: 0.9px;
            text-transform: uppercase;
            margin-bottom: 3px;
            font-weight: 600;
        }
        .care-val {
            font-size: 12px;
            font-weight: 600;
            color: #2e4a2e;
        }
        .btn-wishlist-star {
            width: 46px;
            height: 36px;
            background: #fff;
            border: 1px solid #d5e5cc;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            flex-shrink: 0;
            padding: 0;
        }
        .btn-wishlist-star svg {
            width: 18px;
            height: 18px;
        }
    </style>
</head>
<body class="storefront-page">

    @include('partials.storefront-navbar', ['collapseId' => 'detailNav'])

    <div class="container py-4">
        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-1"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Breadcrumb --}}
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-decoration-none">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/') }}#catalog" class="text-decoration-none">Katalog</a></li>
                <li class="breadcrumb-item active">{{ $product->name }}</li>
            </ol>
        </nav>

        <div class="row g-4">
            {{-- Image --}}
            <div class="col-md-6">
                <div class="product-img-wrapper">
                    @if($product->image_path)
                        <img src="{{ asset('storage/' . $product->image_path) }}" class="w-100 product-img" alt="{{ $product->name }}">
                    @else
                        <div class="w-100 sf-placeholder d-flex align-items-center justify-content-center" style="min-height:320px;border-radius:12px;">
                            <i class="bi bi-image text-sf-accent" style="font-size:5rem;"></i>
                        </div>
                    @endif
                    @foreach($product->labels as $lbl)
                        <span class="product-badge-overlay {{ $lbl['class'] }}" style="top: {{ $loop->index * 32 + 12 }}px;">{{ $lbl['text'] }}</span>
                    @endforeach
                </div>
            </div>

            {{-- Details --}}
            <div class="col-md-6">
                <span class="product-detail-category mb-2">{{ $product->category->name ?? '-' }}</span>
                <h2 class="product-detail-name mb-2 mt-2">{{ $product->name }}</h2>

                {{-- Rating --}}
                <div class="rating-row mb-2">
                    <span class="rating-star">&#9733;</span>
                    <span class="rating-num">{{ number_format($product->average_rating ?? 4.8, 1) }}</span>
                    <span class="rating-count">({{ $product->reviews_count ?? 24 }} ulasan)</span>
                </div>

                <p class="product-detail-price mb-3">Rp {{ number_format($product->price, 0, ',', '.') }}</p>

                <div class="d-flex align-items-center gap-3 mb-3">
                    <span class="product-detail-stock {{ $product->stock > 0 ? '' : 'product-detail-stock--out' }}">
                        {{ $product->stock > 0 ? 'Stok: ' . $product->stock : 'Habis' }}
                    </span>
                </div>

                <h6 class="fw-bold">Deskripsi</h6>
                <p class="text-muted">{{ $product->description ?: 'Tidak ada deskripsi.' }}</p>

                <hr>

                {{-- Info Perawatan --}}
                <h6 class="fw-bold mb-3">Info Perawatan</h6>
                <div class="row g-2 mb-4">
                    <div class="col-4">
                        <div class="care-card">
                            <div class="care-icon-wrap mx-auto">
                                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#3b5740" stroke-width="2"><path d="M12 2C6 8 4 12 4 15a8 8 0 0 0 16 0c0-3-2-7-8-13z"/></svg>
                            </div>
                            <div class="care-lbl">AIR</div>
                            <div class="care-val">{{ $product->water_frequency ?? '2-3x seminggu' }}</div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="care-card">
                            <div class="care-icon-wrap mx-auto">
                                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#3b5740" stroke-width="2"><circle cx="12" cy="12" r="4"/><line x1="12" y1="2" x2="12" y2="4"/><line x1="12" y1="20" x2="12" y2="22"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="2" y1="12" x2="4" y2="12"/><line x1="20" y1="12" x2="22" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/></svg>
                            </div>
                            <div class="care-lbl">CAHAYA</div>
                            <div class="care-val">{{ $product->light_requirement ?? 'Tidak langsung' }}</div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="care-card">
                            <div class="care-icon-wrap mx-auto">
                                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#3b5740" stroke-width="2"><path d="M14 14.76V3.5a2.5 2.5 0 0 0-5 0v11.26a4.5 4.5 0 1 0 5 0z"/></svg>
                            </div>
                            <div class="care-lbl">SUHU</div>
                            <div class="care-val">{{ $product->temperature_range ?? '18-30°C' }}</div>
                        </div>
                    </div>
                </div>

                {{-- Action Buttons --}}
                @if($product->stock > 0)
                    <form action="{{ route('cart.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="qty" value="1">
                        <div class="d-flex align-items-center gap-2">
                            <button type="submit" class="product-detail-add-btn">
                                Tambah ke Keranjang
                            </button>
                            <button type="button" class="btn-wishlist-star" id="wishlistBtn" title="Simpan ke favorit">
                                <svg viewBox="0 0 24 24" fill="none" stroke="#c8a800" stroke-width="1.8" id="wishlistIcon">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                                </svg>
                            </button>
                        </div>
                    </form>
                @else
                    <button class="btn btn-secondary btn-lg" disabled>
                        <i class="bi bi-x-circle me-1"></i> Stok Habis
                    </button>
                @endif
            </div>
        </div>

        {{-- Related Products --}}
        @if($related->isNotEmpty())
            <hr class="my-5">
            <h4 class="fw-bold mb-4">Produk Terkait</h4>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-4">
                @foreach($related as $rel)
                    <div class="col">
                        <div class="card home-product-card h-100">
                            <div class="home-product-media @if($rel->image_path) p-0 @endif" style="position:relative;">
                                @if($rel->label)
                                    <span class="product-label {{ $rel->label_class }}">{{ $rel->label }}</span>
                                @endif
                                <button type="button" class="btn-wishlist-card">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="#c8a800" stroke-width="1.8" class="star-svg">
                                        <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                                    </svg>
                                </button>
                                @if($rel->image_path)
                                    <img src="{{ asset('storage/' . $rel->image_path) }}" alt="{{ $rel->name }}" class="card-img-top">
                                @else
                                    <i class="bi bi-image"></i>
                                @endif
                                <div class="card-hover-overlay">
                                    <a href="{{ route('products.show', $rel) }}" class="btn-overlay-detail">Lihat Detail</a>
                                </div>
                            </div>
                            <div class="card-body d-flex flex-column pt-3">
                                <span class="home-product-category mb-1 d-inline-block">{{ $rel->category->name ?? '-' }}</span>
                                <h6 class="home-product-name card-title mb-1">{{ $rel->name }}</h6>
                                <p class="home-product-price mb-0">Rp {{ number_format($rel->price, 0, ',', '.') }}</p>
                                <div class="mt-auto pt-2 d-flex justify-content-end">
                                    @if($rel->stock > 0)
                                        <form action="{{ route('cart.add') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $rel->id }}">
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
        @endif
    </div>

    @include('partials.storefront-footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
const wishlistBtn = document.getElementById('wishlistBtn');
const wishlistIcon = document.getElementById('wishlistIcon');
@auth
let isActive = {{ auth()->user()->wishlists()->where('product_id', $product->id)->exists() ? 'true' : 'false' }};
function updateStar(active) {
    wishlistIcon.setAttribute('fill', active ? '#e8a000' : 'none');
    wishlistIcon.setAttribute('stroke', active ? '#e8a000' : '#c8a800');
}
updateStar(isActive);
wishlistBtn.addEventListener('click', function() {
    fetch("{{ route('wishlist.toggle') }}", {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        body: JSON.stringify({ product_id: {{ $product->id }} })
    })
    .then(res => res.json())
    .then(data => { isActive = data.saved; updateStar(isActive); });
});
@else
wishlistBtn.addEventListener('click', function() {
    window.location.href = "{{ route('login') }}";
});
@endauth
    </script>
</body>
</html>
