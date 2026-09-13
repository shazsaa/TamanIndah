<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Penjualan - {{ config('app.name', 'Taman Indah') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    @include('partials.theme-assets')
    <style>
        @media print {
            body { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .no-print { display: none !important; }
            .card { border: 1px solid #dee2e6 !important; box-shadow: none !important; }
        }
    </style>
</head>
<body class="bg-white p-4">

    <div class="no-print mb-3">
        <a href="javascript:window.print()" class="btn btn-primary btn-sm">
            <i class="bi bi-printer"></i> Cetak
        </a>
        <a href="{{ route('admin.reports.sales', request()->only(['date_from', 'date_to'])) }}" class="btn btn-outline-secondary btn-sm">Kembali</a>
    </div>

    <div class="text-center mb-4">
        <h2 class="fw-bold mb-1">Laporan Penjualan</h2>
        <p class="text-muted mb-0">Taman Indah - Toko Tanaman Hias</p>
        @if(request('date_from') || request('date_to'))
            <p class="small text-muted mt-2">
                Periode: {{ request('date_from') ? \Illuminate\Support\Carbon::parse(request('date_from'))->translatedFormat('d M Y') : 'Awal' }}
                s/d {{ request('date_to') ? \Illuminate\Support\Carbon::parse(request('date_to'))->translatedFormat('d M Y') : 'Akhir' }}
            </p>
        @else
            <p class="small text-muted mt-2">Semua periode</p>
        @endif
    </div>

    <div class="row mb-4">
        <div class="col-6">
            <div class="border rounded p-3">
                <small class="text-muted">Total Transaksi</small>
                <div class="fw-bold fs-4">{{ number_format($totalTransactions) }}</div>
            </div>
        </div>
        <div class="col-6">
            <div class="border rounded p-3">
                <small class="text-muted">Total Pendapatan</small>
                <div class="fw-bold fs-4 text-success">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>

    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th class="text-end">No</th>
                <th>Kode Pesanan</th>
                <th>Customer</th>
                <th>Produk</th>
                <th class="text-end">Qty</th>
                <th class="text-end">Total</th>
                <th>Tanggal Diambil</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reportRows as $row)
                <tr>
                    <td class="text-end">{{ $row->no }}</td>
                    <td>{{ $row->order_code }}</td>
                    <td>{{ $row->customer_name }} ({{ $row->customer_email }})</td>
                    <td>{{ $row->product_name }}</td>
                    <td class="text-end">{{ $row->qty }}</td>
                    <td class="text-end">Rp {{ number_format($row->item_subtotal, 0, ',', '.') }}</td>
                    <td>{{ $row->picked_up_at?->format('d M Y, H:i') ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center py-4 text-muted">Tidak ada data.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="text-end mt-4 small text-muted">
        Dicetak pada {{ now()->format('d M Y, H:i') }}
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
