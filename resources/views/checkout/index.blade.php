<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Checkout - {{ config('app.name', 'Taman Indah') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    @include('partials.theme-assets')
    @include('partials.storefront-styles')
</head>
<body class="storefront-page">

    @include('partials.storefront-navbar', ['collapseId' => 'checkoutNav', 'requireAuth' => true])

    <div class="container py-4">
        {{-- Breadcrumb --}}
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-decoration-none">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('cart.index') }}" class="text-decoration-none">Keranjang</a></li>
                <li class="breadcrumb-item active">Checkout</li>
            </ol>
        </nav>

        <h2 class="fw-bold mb-4">Checkout</h2>

        {{-- Order Summary --}}
        <div class="card sf-card mb-4">
            <div class="card-header fw-bold">
                <i class="bi bi-receipt me-1"></i> Ringkasan Pesanan
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="sf-table-head">
                        <tr>
                            <th>Produk</th>
                            <th class="text-end" style="width:130px;">Harga</th>
                            <th class="text-center" style="width:100px;">Jumlah</th>
                            <th class="text-end" style="width:140px;">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $item)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        @if($item->product->image_path)
                                            <img src="{{ asset('storage/' . $item->product->image_path) }}" style="width:48px;height:48px;object-fit:cover;border-radius:.375rem;" alt="{{ $item->product->name }}">
                                        @else
                                            <div class="sf-placeholder d-flex align-items-center justify-content-center" style="width:48px;height:48px;border-radius:.375rem;">
                                                <i class="bi bi-image text-sf-accent"></i>
                                            </div>
                                        @endif
                                        <span class="fw-bold">{{ $item->product->name }}</span>
                                    </div>
                                </td>
                                <td class="text-end">Rp {{ number_format($item->product->price, 0, ',', '.') }}</td>
                                <td class="text-center">{{ $item->qty }}</td>
                                <td class="text-end fw-bold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="sf-table-head">
                            <td colspan="3" class="text-end fw-bold fs-5">Total</td>
                            <td class="text-end fw-bold fs-5 text-sf-accent">Rp {{ number_format($grandTotal, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        {{-- Checkout Form --}}
        <form action="{{ route('checkout.store') }}" method="POST">
            @csrf

            <div class="card sf-card mb-4">
                <div class="card-body">
                    <label for="note" class="form-label fw-bold"><i class="bi bi-chat-left-text me-1"></i> Catatan (opsional)</label>
                    <textarea name="note" id="note" class="form-control" rows="3" maxlength="500" placeholder="Tambahkan catatan untuk pesanan Anda...">{{ old('note') }}</textarea>
                    @error('note')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <a href="{{ route('cart.index') }}" class="btn sf-btn-outline">
                    <i class="bi bi-arrow-left me-1"></i> Kembali ke Keranjang
                </a>
                <button type="submit" class="btn sf-btn-primary btn-lg">
                    <i class="bi bi-bag-check me-1"></i> Buat Pesanan
                </button>
            </div>
        </form>
    </div>

    @include('partials.storefront-footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
