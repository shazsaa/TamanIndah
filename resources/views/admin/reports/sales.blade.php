<x-admin-layout>
    <x-slot name="header">Laporan Penjualan</x-slot>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <h5 class="card-title fw-bold mb-3">Filter Periode</h5>
            <form action="{{ route('admin.reports.sales') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label for="date_from" class="form-label small">Dari Tanggal</label>
                    <input type="date" name="date_from" id="date_from" class="form-control form-control-sm"
                           value="{{ request('date_from') }}">
                </div>
                <div class="col-md-3">
                    <label for="date_to" class="form-label small">Sampai Tanggal</label>
                    <input type="date" name="date_to" id="date_to" class="form-control form-control-sm"
                           value="{{ request('date_to') }}">
                </div>
                <div class="col-md-4 d-flex gap-2">
                    <button type="submit" class="btn btn-sm text-white" style="background-color:#4A7C59;border-color:#4A7C59;">
                        <i class="bi bi-filter me-1"></i> Filter
                    </button>
                    <a href="{{ route('admin.reports.sales') }}" class="btn btn-outline-secondary btn-sm">Reset</a>
                    <a href="{{ route('admin.reports.sales.print', request()->only(['date_from', 'date_to'])) }}"
                       target="_blank" class="btn btn-sm text-white" style="background-color:#4A7C59;border-color:#4A7C59;">
                        <i class="bi bi-printer me-1"></i> Cetak
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted mb-1">Total Transaksi</h6>
                    <h3 class="fw-bold mb-0">{{ number_format($totalTransactions) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted mb-1">Total Pendapatan</h6>
                    <h3 class="fw-bold text-success mb-0">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white fw-bold">
            <i class="bi bi-receipt me-1"></i> Daftar Pesanan (Status: Diambil)
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
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
                            <td class="fw-bold">{{ $row->order_code }}</td>
                            <td>{{ $row->customer_name }}<br><small class="text-muted">{{ $row->customer_email }}</small></td>
                            <td>{{ $row->product_name }}</td>
                            <td class="text-end">{{ $row->qty }}</td>
                            <td class="text-end">Rp {{ number_format($row->item_subtotal, 0, ',', '.') }}</td>
                            <td>{{ $row->picked_up_at?->format('d M Y, H:i') ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">
                                <i class="bi bi-graph-up display-6 d-block mb-2"></i>
                                Tidak ada data penjualan untuk periode yang dipilih.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>
