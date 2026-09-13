<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pesanan Berhasil - {{ config('app.name', 'Taman Indah') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    @include('partials.theme-assets')
    @include('partials.storefront-styles')
</head>
<body class="storefront-page">

    @include('partials.storefront-navbar', ['collapseId' => 'successNav', 'requireAuth' => true])

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                {{-- Success Header --}}
                <div class="text-center mb-4">
                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3 sf-placeholder" style="width:80px;height:80px;">
                        <i class="bi bi-check-circle-fill text-sf-accent" style="font-size:2.5rem;"></i>
                    </div>
                    <h2 class="fw-bold">Pesanan Berhasil Dibuat!</h2>
                    <p class="text-muted">Terima kasih telah berbelanja di Taman Indah</p>
                </div>

                {{-- Order Info --}}
                <div class="card sf-card mb-4">
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-md-4 mb-3 mb-md-0">
                                <small class="text-muted d-block">Kode Pesanan</small>
                                <span class="fw-bold fs-5 text-sf-accent">{{ $order->order_code }}</span>
                            </div>
                            <div class="col-md-4 mb-3 mb-md-0">
                                <small class="text-muted d-block">Status</small>
                                <span class="badge bg-warning text-dark fs-6">Menunggu Pembayaran</span>
                            </div>
                            <div class="col-md-4">
                                <small class="text-muted d-block">Total</small>
                                <span class="fw-bold fs-5">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div style="background:#fff;border:0.5px solid #d8e8d8;border-radius:12px;padding:1.25rem 1.5rem;margin-bottom:1rem;">
                    <div style="font-size:14px;font-weight:600;color:#2d5033;margin-bottom:4px;">Informasi Pembayaran</div>
                    <div style="font-size:12px;color:#666;margin-bottom:12px;">Silakan transfer ke salah satu rekening berikut:</div>
                    <div style="display:flex;justify-content:space-between;align-items:center;padding:8px 12px;border-radius:8px;background:#f4f8f4;margin-bottom:6px;">
                        <span style="font-size:13px;font-weight:600;color:#2d5033;">BCA</span>
                        <span style="font-size:13px;color:#444;">1234567890 — a.n. Taman Indah</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;align-items:center;padding:8px 12px;border-radius:8px;background:#f4f8f4;margin-bottom:6px;">
                        <span style="font-size:13px;font-weight:600;color:#2d5033;">BNI</span>
                        <span style="font-size:13px;color:#444;">0987654321 — a.n. Taman Indah</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;align-items:center;padding:8px 12px;border-radius:8px;background:#f4f8f4;margin-bottom:6px;">
                        <span style="font-size:13px;font-weight:600;color:#2d5033;">Mandiri</span>
                        <span style="font-size:13px;color:#444;">1122334455 — a.n. Taman Indah</span>
                    </div>
                </div>

                {{-- Order Items --}}
                <div class="card sf-card mb-4">
                    <div class="card-header fw-bold">
                        <i class="bi bi-list-ul me-1"></i> Detail Pesanan
                    </div>
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="sf-table-head">
                                <tr>
                                    <th>Produk</th>
                                    <th class="text-end">Harga</th>
                                    <th class="text-center">Qty</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->orderItems as $item)
                                    <tr>
                                        <td>{{ $item->product->name ?? 'Produk dihapus' }}</td>
                                        <td class="text-end">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                        <td class="text-center">{{ $item->qty }}</td>
                                        <td class="text-end fw-bold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="sf-table-head">
                                    <td colspan="3" class="text-end fw-bold">Total</td>
                                    <td class="text-end fw-bold text-sf-accent">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                @if($order->note)
                    <div class="card sf-card mb-4">
                        <div class="card-body">
                            <h6 class="fw-bold"><i class="bi bi-chat-left-text me-1"></i> Catatan</h6>
                            <p class="text-muted mb-0">{{ $order->note }}</p>
                        </div>
                    </div>
                @endif

                {{-- Next Steps --}}
                <div class="card sf-card sf-card-highlight mb-4">
                    <div class="card-body">
                        <h5 class="fw-bold text-sf-accent"><i class="bi bi-info-circle me-1"></i> Langkah Selanjutnya</h5>
                        <ol class="mb-0">
                            <li class="mb-2">Lakukan pembayaran sebesar <strong>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong> melalui transfer bank.</li>
                            <li class="mb-2">Unggah bukti pembayaran melalui halaman <strong>Pesanan Saya</strong>.</li>
                            <li class="mb-2">Tunggu konfirmasi dari admin.</li>
                            <li>Ambil pesanan di toko setelah status berubah menjadi <strong>Siap Diambil</strong>.</li>
                        </ol>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ url('/') }}#catalog" class="btn sf-btn-outline">
                        <i class="bi bi-grid me-1"></i> Lanjut Belanja
                    </a>
                    <a href="{{ route('my-orders.show', $order) }}" class="btn sf-btn-primary btn-lg">
                        <i class="bi bi-upload me-1"></i> Upload Bukti Pembayaran
                    </a>
                </div>
            </div>
        </div>
    </div>

    @include('partials.storefront-footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
