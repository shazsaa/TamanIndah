<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pesanan Saya - {{ config('app.name', 'Taman Indah') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    @include('partials.theme-assets')
    @include('partials.storefront-styles')
    <style>
        .my-orders-table-wrap {
            border-radius: 12px;
            border: 0.5px solid #d8e8d8;
            overflow: hidden;
            background: #fff;
        }
        .my-orders-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 0;
        }
        .my-orders-table thead tr {
            background: #f4f8f4;
        }
        .my-orders-table thead th {
            padding: 12px 16px;
            font-size: 13px;
            font-weight: 500;
            color: #2d5033;
            border-bottom: 0.5px solid #d8e8d8;
        }
        .my-orders-table tbody td {
            padding: 12px 16px;
            font-size: 13px;
            color: #444;
            border-bottom: 0.5px solid #f0f0f0;
            vertical-align: middle;
        }
        .my-orders-table tbody tr:last-child td {
            border-bottom: none;
        }
        .order-status-badge {
            display: inline-block;
            background: #EAF3DE;
            color: #3B6D11;
            font-size: 11px;
            padding: 4px 10px;
            border-radius: 6px;
            font-weight: 500;
        }
        .order-status-badge--cancelled {
            background: #fde8e8;
            color: #a32d2d;
            font-size: 11px;
            padding: 3px 10px;
            border-radius: 6px;
            font-weight: 500;
        }
    </style>
</head>
<body class="storefront-page">

    @include('partials.storefront-navbar', ['collapseId' => 'ordersNav', 'active' => 'my-orders', 'requireAuth' => true, 'myOrdersUseRoute' => true])

    <div class="container py-4">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-decoration-none">Beranda</a></li>
                <li class="breadcrumb-item active">Pesanan Saya</li>
            </ol>
        </nav>

        <h2 class="fw-bold mb-4">Pesanan Saya</h2>

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

        @if($orders->isEmpty())
            <div class="text-center py-5">
                <i class="bi bi-bag-x display-1 text-muted"></i>
                <p class="text-muted mt-3 mb-4">Anda belum memiliki pesanan.</p>
                <a href="{{ url('/') }}#catalog" class="btn sf-btn-primary">
                    <i class="bi bi-grid me-1"></i> Lihat Katalog
                </a>
            </div>
        @else
            <div class="my-orders-table-wrap">
                <div class="table-responsive">
                    <table class="my-orders-table">
                        <thead>
                            <tr>
                                <th>Kode Pesanan</th>
                                <th>Tanggal</th>
                                <th class="text-end">Total</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td class="fw-bold">{{ $order->order_code }}</td>
                                    <td>{{ $order->created_at->format('d M Y, H:i') }}</td>
                                    <td class="text-end">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                    <td class="text-center">
                                        @switch($order->status)
                                            @case('pending_payment')
                                                <span class="order-status-badge">Menunggu Pembayaran</span>
                                                @break
                                            @case('payment_submitted')
                                                <span class="order-status-badge">Pembayaran Dikirim</span>
                                                @break
                                            @case('confirmed')
                                                <span class="order-status-badge">Dikonfirmasi</span>
                                                @break
                                            @case('ready')
                                                <span class="order-status-badge">Siap Diambil</span>
                                                @break
                                            @case('picked_up')
                                                <span class="order-status-badge">Selesai</span>
                                                @break
                                            @case('cancelled')
                                                <span class="order-status-badge order-status-badge--cancelled">Dibatalkan</span>
                                                @break
                                            @case('rejected')
                                                <span class="order-status-badge">Ditolak</span>
                                                @break
                                            @default
                                                <span class="order-status-badge">{{ $order->status }}</span>
                                        @endswitch
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('my-orders.show', $order) }}" class="btn btn-sm sf-btn-outline">
                                            <i class="bi bi-eye me-1"></i>Detail
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-4 d-flex justify-content-center">
                {{ $orders->links() }}
            </div>
        @endif
    </div>

    @include('partials.storefront-footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
