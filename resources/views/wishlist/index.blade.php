<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Favorit Saya - {{ config('app.name', 'Taman Indah') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    @include('partials.theme-assets')
    @include('partials.storefront-styles')
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .wishlist-card {
            border: 0.5px solid #d8e8d8;
            border-radius: 12px;
            background: #fff;
            overflow: hidden;
            transition: transform .2s, box-shadow .2s;
        }
        .wishlist-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 0.35rem 1rem rgba(45,80,51,0.1);
        }
        .wishlist-card img {
            width: 100%;
            height: 160px;
            object-fit: cover;
        }
        .wishlist-card .placeholder-img {
            width: 100%;
            height: 160px;
            background: #A7C4A0;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .wishlist-card .card-body { padding: 14px 16px 16px; }
        .product-category { color: #4A7C59; font-size: 12px; font-weight: 600; }
        .product-name { color: #2d5033; font-weight: 700; font-size: 15px; margin: 4px 0; }
        .product-price { color: #4A7C59; font-weight: 700; font-size: 14px; }
        .btn-remove {
            background: none;
            border: 1px solid #e5e5e5;
            border-radius: 8px;
            color: #aaa;
            font-size: 12px;
            padding: 5px 12px;
            cursor: pointer;
        }
        .btn-remove:hover { border-color: #c62828; color: #c62828; }
        .btn-detail {
            background: #4A7C59;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 12px;
            padding: 5px 14px;
            text-decoration: none;
            font-weight: 600;
        }
        .btn-detail:hover { background: #3d6b4a; color: #fff; }
        .page-title {
            font-size: 22px;
            font-weight: 700;
            color: #2d5033;
            border-bottom: 2px solid #4A7C59;
            padding-bottom: 8px;
            display: inline-block;
        }
    </style>
</head>
<body class="storefront-page">
    @include('partials.storefront-navbar', ['collapseId' => 'wishlistNav'])

    <div class="container py-5">
        <h2 class="page-title mb-4">Favorit Saya</h2>

        @if($wishlists->isEmpty())
            <div class="text-center py-5">
                <i class="bi bi-star display-1 text-muted"></i>
                <p class="text-muted mt-3">Belum ada produk yang disimpan.</p>
                <a href="{{ url('/') }}#catalog" class="btn" style="background:#4A7C59;color:#fff;border-radius:8px;font-weight:600;">
                    Lihat Katalog
                </a>
            </div>
        @else
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                @foreach($wishlists as $wishlist)
                    <div class="col" id="wishlist-item-{{ $wishlist->id }}">
                        <div class="wishlist-card">
                            @if($wishlist->product->image_path)
                                <img src="{{ asset('storage/' . $wishlist->product->image_path) }}" alt="{{ $wishlist->product->name }}">
                            @else
                                <div class="placeholder-img">
                                    <i class="bi bi-image" style="font-size:2rem;color:rgba(45,80,51,0.35);"></i>
                                </div>
                            @endif
                            <div class="card-body">
                                <div class="product-category">{{ $wishlist->product->category->name ?? '-' }}</div>
                                <div class="product-name">{{ $wishlist->product->name }}</div>
                                <div class="product-price mb-3">Rp {{ number_format($wishlist->product->price, 0, ',', '.') }}</div>
                                <div class="d-flex gap-2 align-items-center">
                                    <a href="{{ route('products.show', $wishlist->product) }}" class="btn-detail">Lihat Detail</a>
                                    <button class="btn-remove" onclick="removeWishlist({{ $wishlist->id }}, {{ $wishlist->product_id }})">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
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
        function removeWishlist(wishlistId, productId) {
            fetch("{{ route('wishlist.toggle') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ product_id: productId })
            })
            .then(res => res.json())
            .then(data => {
                if (!data.saved) {
                    document.getElementById('wishlist-item-' + wishlistId).remove();
                }
            });
        }
    </script>
</body>
</html>
