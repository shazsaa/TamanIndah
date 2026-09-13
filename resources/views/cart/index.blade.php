<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Keranjang - {{ config('app.name', 'Taman Indah') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    @include('partials.theme-assets')
    @include('partials.storefront-styles')
    <style>
        .cart-thumb { width: 64px; height: 64px; object-fit: cover; border-radius: .375rem; }
        .cart-thumb-placeholder { width: 64px; height: 64px; border-radius: .375rem; }
    </style>
</head>
<body class="storefront-page">

    @include('partials.storefront-navbar', ['collapseId' => 'cartNav', 'active' => 'cart'])

    <div class="container py-4">
        {{-- Breadcrumb --}}
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-decoration-none">Beranda</a></li>
                <li class="breadcrumb-item active">Keranjang</li>
            </ol>
        </nav>

        <h2 class="fw-bold mb-4">Keranjang Belanja</h2>

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

        @if($items->isEmpty())
            <div style="background:#fff;border-radius:16px;border:0.5px solid #d8e8d8;padding:3rem 2.5rem;max-width:380px;margin:0 auto;display:flex;flex-direction:column;align-items:center;gap:1rem;">
                <div style="width:80px;height:80px;background:#EAF3DE;border-radius:50%;display:flex;align-items:center;justify-content:center;">
                    <svg width="48" height="48" viewBox="0 0 38 38" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path d="M19 32V18" stroke="#4A7C59" stroke-width="2" stroke-linecap="round"/>
                        <path d="M19 22C19 22 14 19 12 13C15.5 12 20 14 19 22Z" fill="#A7C4A0" stroke="#4A7C59" stroke-width="1.2"/>
                        <path d="M19 18C19 18 24 15 26 9C22.5 8 18 10 19 18Z" fill="#4A7C59" stroke="#4A7C59" stroke-width="1.2"/>
                        <path d="M10 32H28" stroke="#4A7C59" stroke-width="2" stroke-linecap="round"/>
                        <path d="M13 32C13 32 13.5 28 19 28C24.5 28 25 32 25 32" stroke="#4A7C59" stroke-width="1.5" stroke-linecap="round"/>
                    </svg>
                </div>
                <p style="font-size:15px;font-weight:600;color:#2d5033;margin:0;">Keranjangmu masih kosong</p>
                <p style="font-size:13px;color:#888;text-align:center;line-height:1.6;margin:0;">Yuk temukan tanaman favoritmu dan mulai berbelanja di Taman Indah!</p>
                <a href="{{ url('/') }}#catalog" style="display:inline-block;background:#4A7C59;color:#fff;border-radius:8px;padding:10px 24px;font-size:13px;margin-top:0.5rem;text-decoration:none;">Lihat Katalog</a>
            </div>
        @else
            <div class="card sf-card">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="sf-table-head">
                            <tr>
                                <th style="width:80px;">Foto</th>
                                <th>Produk</th>
                                <th class="text-end" style="width:130px;">Harga</th>
                                <th class="text-center" style="width:160px;">Jumlah</th>
                                <th class="text-end" style="width:140px;">Subtotal</th>
                                <th class="text-center" style="width:70px;">Hapus</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $item)
                                <tr>
                                    <td>
                                        @if($item->product->image_path)
                                            <img src="{{ asset('storage/' . $item->product->image_path) }}" class="cart-thumb" alt="{{ $item->product->name }}">
                                        @else
                                            <div class="cart-thumb-placeholder sf-placeholder d-flex align-items-center justify-content-center">
                                                <i class="bi bi-image text-sf-accent"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('products.show', $item->product) }}" class="text-decoration-none fw-bold" style="color:#2d5033;">
                                            {{ $item->product->name }}
                                        </a>
                                        <br>
                                        <small class="text-muted">Stok: {{ $item->product->stock }}</small>
                                    </td>
                                    <td class="text-end">Rp {{ number_format($item->product->price, 0, ',', '.') }}</td>
                                    <td>
                                        <form action="{{ route('cart.update') }}" method="POST" class="d-flex align-items-center justify-content-center gap-1">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="product_id" value="{{ $item->product->id }}">
                                            <input type="number" name="qty" value="{{ $item->qty }}" min="1" max="{{ $item->product->stock }}" class="form-control form-control-sm text-center" style="width:70px;">
                                            <button type="submit" class="btn btn-sm sf-btn-outline" title="Perbarui">
                                                <i class="bi bi-arrow-repeat"></i>
                                            </button>
                                        </form>
                                    </td>
                                    <td class="text-end fw-bold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                    <td class="text-center">
                                        <form action="{{ route('cart.remove', $item->product) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="sf-table-head">
                                <td colspan="4" class="text-end fw-bold fs-5">Total</td>
                                <td class="text-end fw-bold fs-5 text-sf-accent">Rp {{ number_format($grandTotal, 0, ',', '.') }}</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-4">
                <a href="{{ url('/') }}#catalog" class="btn sf-btn-outline">
                    <i class="bi bi-arrow-left me-1"></i> Lanjut Belanja
                </a>
                @auth
                    <a href="{{ url('/checkout') }}" class="btn sf-btn-primary btn-lg">
                        <i class="bi bi-bag-check me-1"></i> Checkout
                    </a>
                @else
                    <a href="{{ route('login', ['redirect' => url('/cart')]) }}" class="btn sf-btn-primary btn-lg">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Login untuk Checkout
                    </a>
                @endauth
            </div>
        @endif
    </div>

    @include('partials.storefront-footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
