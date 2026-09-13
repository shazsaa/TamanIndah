<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $order->order_code }} - {{ config('app.name', 'Taman Indah') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    @include('partials.theme-assets')
    @include('partials.storefront-styles')
    <style>
        .mos-order-card {
            background: #fff;
            border: 0.5px solid #d8e8d8;
            border-radius: 12px;
            overflow: hidden;
            margin-bottom: 1rem;
        }
        .mos-order-card__head {
            padding: 12px 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 0.5px solid #d8e8d8;
            font-size: 14px;
            font-weight: 500;
            color: #2d5033;
        }
        .mos-order-card__badge {
            font-size: 11px;
            padding: 3px 10px;
            border-radius: 6px;
            background: #EAF3DE;
            color: #3B6D11;
            font-weight: 500;
        }
        .mos-order-card__badge--cancelled {
            background: #fde8e8;
            color: #a32d2d;
        }
        .mos-order-card__row {
            padding: 10px 16px;
            font-size: 12px;
            color: #2d5033;
            display: flex;
            align-items: flex-start;
            gap: 0;
        }
        .mos-order-card__label {
            width: 140px;
            flex-shrink: 0;
            color: #888;
        }

        .mos-pickup-banner {
            margin: 0 16px 12px;
            border-radius: 8px;
            padding: 8px 12px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .mos-pickup-banner--normal {
            background: #fff8e6;
            border: 0.5px solid #f5c842;
        }
        .mos-pickup-banner--urgent {
            background: #fde8e8;
            border: 0.5px solid #f09595;
        }
        .mos-pickup-banner__icon {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 14px;
        }
        .mos-pickup-banner--normal .mos-pickup-banner__icon {
            background: #fef3c7;
            color: #d97706;
        }
        .mos-pickup-banner--urgent .mos-pickup-banner__icon {
            background: #fde8e8;
            color: #a32d2d;
        }
        .mos-pickup-banner__text {
            font-size: 12px;
            line-height: 1.5;
        }
        .mos-pickup-banner--normal .mos-pickup-banner__text {
            color: #92400e;
        }
        .mos-pickup-banner--urgent .mos-pickup-banner__text {
            color: #a32d2d;
        }
        .mos-pickup-banner__title {
            font-weight: 500;
            font-size: 12px;
        }
        .mos-pickup-banner__date {
            font-weight: 600;
            font-size: 12px;
        }
        .mos-pickup-banner__note {
            font-size: 10px;
            color: #aaa;
            font-style: italic;
            padding: 0 16px 10px;
            margin: 0;
        }

        .mos-items-card {
            background: #fff;
            border: 0.5px solid #d8e8d8;
            border-radius: 12px;
            overflow: hidden;
            margin-bottom: 1rem;
        }
        .mos-items-card__head {
            padding: 10px 16px;
            background: #f9fbf9;
            border-bottom: 0.5px solid #d8e8d8;
            font-size: 13px;
            font-weight: 500;
            color: #2d5033;
        }
        .mos-items-table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
        }
        .mos-items-table thead {
            background: #f4f8f4;
            border-bottom: 0.5px solid #d8e8d8;
        }
        .mos-items-table thead th {
            padding: 8px 16px;
            font-size: 11px;
            font-weight: 500;
            color: #2d5033;
        }
        .mos-items-table thead th.text-end {
            text-align: right;
        }
        .mos-items-table tbody td {
            padding: 10px 16px;
            font-size: 12px;
            color: #444;
            border-bottom: 0.5px solid #f4f4f4;
            vertical-align: middle;
        }
        .mos-items-table tbody td.text-end {
            text-align: right;
        }
        .mos-items-table tbody tr:last-child td {
            border-bottom: none;
        }
        .mos-items-table .mos-product-cell {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .mos-items-table .mos-product-cell img,
        .mos-items-table .mos-product-cell .mos-product-ph {
            width: 32px;
            height: 32px;
            border-radius: 6px;
            object-fit: cover;
            flex-shrink: 0;
        }
        .mos-items-table .mos-product-cell .mos-product-ph {
            display: flex;
            align-items: center;
            justify-content: center;
            background: #A7C4A0;
        }
        .mos-items-table tfoot tr {
            background: #f9fbf9;
            border-top: 0.5px solid #d8e8d8;
            font-size: 12px;
            font-weight: 500;
        }
        .mos-items-table tfoot td {
            padding: 10px 16px;
            border-bottom: none;
        }
        .mos-items-table tfoot .mos-total-amt {
            color: #4A7C59;
        }

        .mos-payment-proof-card {
            display: inline-block;
            width: auto;
            max-width: 100%;
            vertical-align: top;
            background: #fff;
            border: 0.5px solid #d8e8d8;
            border-radius: 12px;
            overflow: hidden;
            margin-bottom: 1rem;
        }
        .mos-payment-proof-card__head {
            padding: 10px 16px;
            font-size: 13px;
            font-weight: 500;
            color: #2d5033;
            border-bottom: 0.5px solid #d8e8d8;
            background: #f9fbf9;
        }
        .mos-payment-proof-card__body {
            padding: 1rem;
        }

        .mos-pay-grid {
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 1rem;
            align-items: start;
            margin-bottom: 1rem;
        }
        @media (max-width: 991.98px) {
            .mos-pay-grid {
                grid-template-columns: 1fr;
            }
        }

        .mos-upload-card {
            background: #fff;
            border: 0.5px solid #d8e8d8;
            border-radius: 12px;
            overflow: hidden;
            padding: 1rem;
        }
        .mos-upload-card__title {
            font-size: 13px;
            font-weight: 500;
            color: #2d5033;
            margin-bottom: 12px;
        }
        .mos-form-label {
            font-size: 11px;
            font-weight: 500;
            color: #2d5033;
            display: block;
            margin-bottom: 4px;
        }
        .mos-form-input {
            width: 100%;
            height: 34px;
            border: 0.5px solid #d8e8d8;
            border-radius: 8px;
            font-size: 12px;
            padding: 0 10px;
            background: #fafaf9;
            box-sizing: border-box;
        }
        .mos-form-input[type="file"] {
            height: auto;
            min-height: 34px;
            padding: 6px 10px;
        }
        .mos-amount-wrap {
            display: flex;
            border: 0.5px solid #d8e8d8;
            border-radius: 8px;
            overflow: hidden;
            height: 34px;
            box-sizing: border-box;
            background: #fafaf9;
        }
        .mos-amount-wrap__prefix {
            display: flex;
            align-items: center;
            background: #f4f8f4;
            border-right: 0.5px solid #d8e8d8;
            padding: 0 10px;
            font-size: 12px;
            color: #2d5033;
            flex-shrink: 0;
        }
        .mos-amount-wrap__value {
            display: flex;
            align-items: center;
            padding: 0 10px;
            font-size: 12px;
            color: #2d5033;
            flex: 1;
        }
        .mos-file-hint {
            font-size: 10px;
            color: #aaa;
            margin-top: 3px;
        }
        .mos-submit-btn {
            width: 100%;
            height: 36px;
            background: #4A7C59;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 13px;
            margin-top: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .mos-submit-btn:hover {
            background: #3d6b4a;
            color: #fff;
        }

        .mos-bank-card {
            background: #fff;
            border: 0.5px solid #d8e8d8;
            border-radius: 12px;
            overflow: hidden;
        }
        .mos-bank-card__head {
            padding: 12px 16px;
            border-bottom: 0.5px solid #d8e8d8;
        }
        .mos-bank-card__title {
            font-size: 13px;
            font-weight: 500;
            color: #2d5033;
        }
        .mos-bank-card__sub {
            font-size: 11px;
            color: #888;
            margin-top: 2px;
        }
        .mos-bank-row {
            padding: 8px 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 0.5px solid #f4f4f4;
        }
        .mos-bank-row:last-child {
            border-bottom: none;
        }
        .mos-bank-name {
            font-size: 12px;
            font-weight: 500;
            color: #2d5033;
        }
        .mos-bank-acct {
            font-size: 12px;
            color: #555;
        }

        .mos-back-btn {
            height: 36px;
            display: inline-flex;
            align-items: center;
            padding: 0 16px;
            font-size: 12px;
            border-radius: 8px;
            gap: 6px;
            color: #4A7C59;
            border: 0.5px solid #d8e8d8;
            background: #fff;
            text-decoration: none;
        }
        .mos-back-btn:hover {
            color: #3d6b4a;
            background: #fafaf9;
        }
        .mos-cancel-btn {
            height: 36px;
            display: inline-flex;
            align-items: center;
            padding: 0 16px;
            font-size: 12px;
            border-radius: 8px;
            gap: 6px;
            color: #fff;
            background: #dc3545;
            border: none;
            cursor: pointer;
        }
        .mos-cancel-btn:hover {
            background: #c82333;
            color: #fff;
        }
        .mos-order-detail-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 0.75rem;
        }
    </style>
</head>
<body class="storefront-page">

    @include('partials.storefront-navbar', ['collapseId' => 'orderDetailNav', 'active' => 'my-orders', 'requireAuth' => true, 'myOrdersUseRoute' => true])

    <div class="container py-4">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-decoration-none">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('my-orders.index') }}" class="text-decoration-none">Pesanan Saya</a></li>
                <li class="breadcrumb-item active">{{ $order->order_code }}</li>
            </ol>
        </nav>

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

        {{-- 1. Order info --}}
        <div class="mos-order-card">
            <div class="mos-order-card__head">
                <span>{{ $order->order_code }}</span>
                @switch($order->status)
                    @case('pending_payment')
                        <span class="mos-order-card__badge">Menunggu Pembayaran</span>
                        @break
                    @case('payment_submitted')
                        <span class="mos-order-card__badge">Pembayaran Dikirim</span>
                        @break
                    @case('confirmed')
                        <span class="mos-order-card__badge">Dikonfirmasi</span>
                        @break
                    @case('ready')
                        <span class="mos-order-card__badge">Siap Diambil</span>
                        @break
                    @case('picked_up')
                        <span class="mos-order-card__badge">Selesai</span>
                        @break
                    @case('cancelled')
                        <span class="mos-order-card__badge mos-order-card__badge--cancelled">Dibatalkan</span>
                        @break
                    @case('rejected')
                        <span class="mos-order-card__badge">Ditolak</span>
                        @break
                    @default
                        <span class="mos-order-card__badge">{{ $order->status }}</span>
                @endswitch
            </div>
            <div class="mos-order-card__row">
                <span class="mos-order-card__label">Tanggal Pesanan</span>
                <span>{{ $order->created_at->format('d M Y, H:i') }}</span>
            </div>
            @if($order->note)
                <div class="mos-order-card__row">
                    <span class="mos-order-card__label">Catatan</span>
                    <span>{{ $order->note }}</span>
                </div>
            @endif
            @php
                $pickupDeadline = $order->pickup_deadline ?? null;
            @endphp
            @if(in_array($order->status, ['confirmed', 'ready', 'picked_up'], true) && $pickupDeadline)
                @php
                    $deadlineDay = \Carbon\Carbon::parse($pickupDeadline)->startOfDay();
                    $today = now()->startOfDay();
                    $tomorrow = $today->copy()->addDay();
                    $pickupUrgent = $deadlineDay->equalTo($today) || $deadlineDay->equalTo($tomorrow);
                    $pickupDeadlineFormatted = $deadlineDay->format('d M Y');
                @endphp
                <div class="mos-pickup-banner mos-pickup-banner--{{ $pickupUrgent ? 'urgent' : 'normal' }}">
                    <div class="mos-pickup-banner__icon" aria-hidden="true">
                        <i class="bi bi-calendar-event"></i>
                    </div>
                    <div class="mos-pickup-banner__text">
                        @if($pickupUrgent)
                            <div class="mos-pickup-banner__title">Segera ambil pesananmu!</div>
                            <div class="mos-pickup-banner__date">Batas akhir pengambilan: {{ $pickupDeadlineFormatted }}</div>
                        @else
                            <div class="mos-pickup-banner__title">Batas waktu pengambilan pesanan</div>
                            <div class="mos-pickup-banner__date">Ambil sebelum: {{ $pickupDeadlineFormatted }}</div>
                        @endif
                    </div>
                </div>
                <p class="mos-pickup-banner__note">* Pesanan yang tidak diambil dalam 3 hari setelah konfirmasi dianggap hangus.</p>
            @endif
        </div>

        {{-- 2. Item Pesanan --}}
        <div class="mos-items-card">
            <div class="mos-items-card__head">
                <i class="bi bi-list-ul me-1"></i> Item Pesanan
            </div>
            <div class="table-responsive">
                <table class="mos-items-table">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th class="text-end">Harga</th>
                            <th class="text-end">Qty</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->orderItems as $item)
                            <tr>
                                <td>
                                    <div class="mos-product-cell">
                                        @if($item->product && $item->product->image_path)
                                            <img src="{{ asset('storage/' . $item->product->image_path) }}" alt="{{ $item->product->name }}">
                                        @else
                                            <div class="mos-product-ph">
                                                <i class="bi bi-image text-white" style="font-size:0.75rem;"></i>
                                            </div>
                                        @endif
                                        <span>{{ $item->product->name ?? 'Produk dihapus' }}</span>
                                    </div>
                                </td>
                                <td class="text-end">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                <td class="text-end">{{ $item->qty }}</td>
                                <td class="text-end">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-end">Total</td>
                            <td class="text-end mos-total-amt">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        {{-- Existing Payment Info --}}
        @if($order->payment)
            <div class="mos-payment-proof-card">
                <div class="mos-payment-proof-card__head">
                    <i class="bi bi-credit-card me-1"></i> Bukti Pembayaran
                </div>
                <div class="mos-payment-proof-card__body">
                    @if($order->payment->proof_image_path)
                        <div style="display: inline-block;">
                            <a href="{{ asset('storage/' . $order->payment->proof_image_path) }}" target="_blank" rel="noopener noreferrer" style="display: inline-block; border: 0.5px solid #d8e8d8; border-radius: 8px; overflow: hidden;">
                                <img src="{{ asset('storage/' . $order->payment->proof_image_path) }}"
                                     alt="Bukti pembayaran"
                                     style="max-width: 220px; width: 100%; height: auto; display: block;">
                            </a>
                            <p style="font-size: 11px; color: #aaa; margin-top: 6px;">
                                Klik gambar untuk memperbesar
                            </p>
                        </div>
                    @endif
                    <div class="mb-2">
                        <small class="text-muted">Jumlah</small><br>
                        <span class="fw-bold">Rp {{ number_format($order->payment->amount, 0, ',', '.') }}</span>
                    </div>
                    @if($order->payment->payer_name)
                        <div class="mb-2">
                            <small class="text-muted">Nama Pengirim</small><br>
                            <span>{{ $order->payment->payer_name }}</span>
                        </div>
                    @endif
                    @if($order->payment->bank_name)
                        <div class="mb-2">
                            <small class="text-muted">Bank</small><br>
                            <span>{{ $order->payment->bank_name }}</span>
                        </div>
                    @endif
                    <div class="mb-2">
                        <small class="text-muted">Status</small><br>
                        @if($order->payment->status === 'submitted')
                            <span class="badge bg-info text-dark">Menunggu Verifikasi</span>
                        @elseif($order->payment->status === 'approved')
                            <span class="badge bg-success">Disetujui</span>
                        @elseif($order->payment->status === 'rejected')
                            <span class="badge bg-danger">Ditolak</span>
                        @endif
                    </div>
                    @if($order->payment->submitted_at)
                        <div>
                            <small class="text-muted">Dikirim pada</small><br>
                            <span>{{ $order->payment->submitted_at->format('d M Y, H:i') }}</span>
                        </div>
                    @endif
                    @if($order->payment->admin_note)
                        <div class="mt-2">
                            <small class="text-muted">Catatan Admin</small><br>
                            <span class="text-danger">{{ $order->payment->admin_note }}</span>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        {{-- Upload Form + bank info grid --}}
        @if(in_array($order->status, ['pending_payment', 'payment_submitted']))
            <div class="mos-pay-grid">
                <div class="mos-upload-card">
                    <div class="mos-upload-card__title">{{ $order->payment ? 'Upload Ulang Bukti' : 'Upload Bukti Pembayaran' }}</div>
                    <form action="{{ route('my-orders.pay', $order) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="amount" class="mos-form-label">Jumlah Transfer <span class="text-danger">*</span></label>
                            <input type="hidden" name="amount" id="amount" value="{{ old('amount', $order->total_amount) }}" required>
                            <div class="mos-amount-wrap">
                                <span class="mos-amount-wrap__prefix">Rp</span>
                                <span class="mos-amount-wrap__value">{{ number_format(old('amount', $order->total_amount), 0, ',', '.') }}</span>
                            </div>
                            @error('amount')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="payer_name" class="mos-form-label">Nama Pengirim</label>
                            <input type="text" name="payer_name" id="payer_name" class="mos-form-input @error('payer_name') is-invalid @enderror" value="{{ old('payer_name') }}" placeholder="Nama pada rekening">
                            @error('payer_name')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="bank_name" class="mos-form-label">Nama Bank</label>
                            <input type="text" name="bank_name" id="bank_name" class="mos-form-input @error('bank_name') is-invalid @enderror" value="{{ old('bank_name') }}" placeholder="BCA, BNI, Mandiri, dll">
                            @error('bank_name')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="proof_image" class="mos-form-label">Bukti Transfer <span class="text-danger">*</span></label>
                            <input type="file" name="proof_image" id="proof_image" class="mos-form-input @error('proof_image') is-invalid @enderror" accept="image/jpeg,image/png,image/jpg" required>
                            <div class="mos-file-hint">Format: JPG, JPEG, PNG. Maks 2MB.</div>
                            @error('proof_image')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="mos-submit-btn">
                            <i class="bi bi-upload me-1"></i> Kirim Bukti Pembayaran
                        </button>
                    </form>
                </div>

                <div class="mos-bank-card">
                    <div class="mos-bank-card__head">
                        <div class="mos-bank-card__title">Informasi Pembayaran</div>
                        <div class="mos-bank-card__sub">Transfer ke salah satu rekening berikut:</div>
                    </div>
                    <div class="mos-bank-row">
                        <span class="mos-bank-name">BCA</span>
                        <span class="mos-bank-acct">1234567890 — a.n. Taman Indah</span>
                    </div>
                    <div class="mos-bank-row">
                        <span class="mos-bank-name">BNI</span>
                        <span class="mos-bank-acct">0987654321 — a.n. Taman Indah</span>
                    </div>
                    <div class="mos-bank-row">
                        <span class="mos-bank-name">Mandiri</span>
                        <span class="mos-bank-acct">1122334455 — a.n. Taman Indah</span>
                    </div>
                </div>
            </div>
        @endif

        <div class="mos-order-detail-actions">
            <a href="{{ route('my-orders.index') }}" class="mos-back-btn">
                <i class="bi bi-arrow-left"></i> Kembali ke Daftar Pesanan
            </a>
            @if(in_array($order->status, ['pending_payment', 'payment_submitted']))
                <form method="POST" action="{{ route('my-orders.cancel', $order) }}" class="m-0">
                    @csrf
                    <button type="submit" class="mos-cancel-btn"
                        onclick="return confirm('Apakah kamu yakin ingin membatalkan pesanan ini? Tindakan ini tidak dapat diurungkan.')">
                        Batalkan Pesanan
                    </button>
                </form>
            @endif
        </div>
    </div>

    @include('partials.storefront-footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
