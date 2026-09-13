<x-admin-layout>
    <x-slot name="header">Dashboard</x-slot>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <div class="mb-4">
        <h4 class="fw-bold">Welcome back, {{ auth()->user()->name }}!</h4>
        <p class="text-muted mb-0">Here's what's happening at Taman Indah today.</p>
    </div>

    <div class="row g-3">
        {{-- Active Products --}}
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100 position-relative text-reset">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-3 bg-success bg-opacity-10 p-3">
                        <i class="bi bi-box-seam fs-3 text-success"></i>
                    </div>
                    <div>
                        <div class="fs-3 fw-bold">{{ $totalActiveProducts }}</div>
                        <div class="text-muted small">Active Products</div>
                    </div>
                    <a href="{{ route('admin.products.index') }}" class="stretched-link text-decoration-none" aria-label="Buka daftar produk"></a>
                </div>
            </div>
        </div>

        {{-- Pending Payment --}}
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100 position-relative text-reset">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-3 bg-warning bg-opacity-10 p-3">
                        <i class="bi bi-hourglass-split fs-3 text-warning"></i>
                    </div>
                    <div>
                        <div class="fs-3 fw-bold">{{ $ordersPendingPayment }}</div>
                        <div class="text-muted small">Pending Payment</div>
                    </div>
                    <a href="{{ route('admin.payments.index', ['status' => 'pending']) }}" class="stretched-link text-decoration-none" aria-label="Buka pembayaran menunggu review"></a>
                </div>
            </div>
        </div>

        {{-- Confirmed Orders --}}
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100 position-relative text-reset">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-3 bg-primary bg-opacity-10 p-3">
                        <i class="bi bi-check2-circle fs-3 text-primary"></i>
                    </div>
                    <div>
                        <div class="fs-3 fw-bold">{{ $ordersConfirmed }}</div>
                        <div class="text-muted small">Confirmed Orders</div>
                    </div>
                    <a href="{{ route('admin.orders.index', ['status' => 'confirmed']) }}" class="stretched-link text-decoration-none" aria-label="Buka pesanan dikonfirmasi"></a>
                </div>
            </div>
        </div>

        {{-- Picked Up This Month --}}
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100 position-relative text-reset">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-3 bg-info bg-opacity-10 p-3">
                        <i class="bi bi-bag-check fs-3 text-info"></i>
                    </div>
                    <div>
                        <div class="fs-3 fw-bold">{{ $ordersPickedUpThisMonth }}</div>
                        <div class="text-muted small">Picked Up (This Month)</div>
                    </div>
                    <a href="{{ route('admin.orders.index', ['status' => 'picked_up']) }}" class="stretched-link text-decoration-none" aria-label="Buka pesanan selesai diambil"></a>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mt-2">

        {{-- Grafik 1: Tren Penjualan --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h6 class="fw-bold mb-1">Tren Penjualan</h6>
                    <p class="text-muted small mb-3">Pendapatan 7 hari terakhir</p>
                    <div id="chartTrenPenjualan"></div>
                </div>
            </div>
        </div>

        {{-- Grafik 2: Proporsi Status Pesanan --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h6 class="fw-bold mb-1">Status Pesanan</h6>
                    <p class="text-muted small mb-3">Proporsi seluruh pesanan</p>
                    <div id="chartStatusPesanan"></div>
                </div>
            </div>
        </div>

        {{-- Grafik 3: Top 5 Produk Terlaris --}}
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h6 class="fw-bold mb-1">Top 5 Produk Terlaris</h6>
                    <p class="text-muted small mb-3">Berdasarkan total qty terjual</p>
                    <div id="chartTopProduk"></div>
                </div>
            </div>
        </div>

        {{-- Grafik 4: Pendapatan Bulanan --}}
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h6 class="fw-bold mb-1">Pendapatan Bulanan</h6>
                    <p class="text-muted small mb-3">Tren pendapatan 6 bulan terakhir</p>
                    <div id="chartPendapatanBulanan"></div>
                </div>
            </div>
        </div>

        {{-- Grafik 5: Review Pembayaran Harian --}}
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="fw-bold mb-1">Review Pembayaran Harian</h6>
                    <p class="text-muted small mb-3">Menunggu Review (5 hari terakhir)</p>
                    <div id="chartPembayaran"></div>
                </div>
            </div>
        </div>

    </div>
<script>
const hijau = '#4A7C59';
const hijauMuda = '#A7C4A0';
const kuning = '#F5A623';
const merah = '#E24B4A';
const biru = '#378ADD';

const trenLabels = @json($trenPenjualan->pluck('label'));
const trenValues = @json($trenPenjualan->pluck('value'));

const statusLabels = @json(array_keys($statusPesanan));
const statusValues = @json(array_values($statusPesanan));

const topProdukLabels = @json($topProduk->pluck('name'));
const topProdukValues = @json($topProduk->pluck('total_qty'));

const bulananLabels = @json($pendapatanBulanan->pluck('label'));
const bulananValues = @json($pendapatanBulanan->pluck('value'));

const pembayaranLabels = @json($pembayaranHarian->pluck('label'));
const pembayaranPending = @json($pembayaranHarian->pluck('pending'));

// Grafik 1: Tren Penjualan
new ApexCharts(document.getElementById('chartTrenPenjualan'), {
    series: [{ name: 'Pendapatan', data: trenValues }],
    chart: { type: 'line', height: 250, toolbar: { show: false } },
    stroke: { curve: 'smooth', width: 3 },
    colors: [hijau],
    xaxis: { categories: trenLabels },
    yaxis: { labels: { formatter: val => 'Rp ' + (val/1000).toFixed(0) + 'K' } },
    tooltip: { y: { formatter: val => 'Rp ' + val.toLocaleString('id-ID') } },
    markers: { size: 4 },
    grid: { borderColor: '#f0f0f0' },
}).render();

// Grafik 2: Status Pesanan
new ApexCharts(document.getElementById('chartStatusPesanan'), {
    series: statusValues,
    chart: { type: 'donut', height: 250 },
    labels: statusLabels,
    colors: [kuning, biru, hijau, merah],
    legend: { position: 'bottom', fontSize: '11px' },
    tooltip: { y: { formatter: val => val + ' pesanan' } },
    plotOptions: { pie: { donut: { size: '65%' } } },
}).render();

// Grafik 3: Top 5 Produk Terlaris
new ApexCharts(document.getElementById('chartTopProduk'), {
    series: [{ name: 'Terjual', data: topProdukValues }],
    chart: { type: 'bar', height: 250, toolbar: { show: false } },
    plotOptions: { bar: { horizontal: true, borderRadius: 4, dataLabels: { position: 'center' } } },
    colors: [hijau],
    dataLabels: { enabled: true, formatter: val => val + ' pcs', style: { fontSize: '11px', colors: ['#fff'] } },
    xaxis: { categories: topProdukLabels },
    tooltip: { y: { formatter: val => val + ' pcs terjual' } },
    grid: { borderColor: '#f0f0f0' },
}).render();

// Grafik 4: Pendapatan Bulanan
new ApexCharts(document.getElementById('chartPendapatanBulanan'), {
    series: [{ name: 'Pendapatan', data: bulananValues }],
    chart: { type: 'bar', height: 250, toolbar: { show: false } },
    plotOptions: { bar: { borderRadius: 4 } },
    colors: [hijauMuda],
    xaxis: { categories: bulananLabels },
    yaxis: { labels: { formatter: val => 'Rp ' + (val/1000000).toFixed(1) + 'Jt' } },
    tooltip: { y: { formatter: val => 'Rp ' + val.toLocaleString('id-ID') } },
    grid: { borderColor: '#f0f0f0' },
    dataLabels: { enabled: false },
}).render();

// Grafik 5: Review Pembayaran Harian
new ApexCharts(document.getElementById('chartPembayaran'), {
    series: [
        { name: 'Menunggu Review', data: pembayaranPending }
    ],
    chart: { type: 'bar', height: 250, toolbar: { show: false } },
    plotOptions: { bar: { borderRadius: 4 } },
    colors: [kuning],
    xaxis: { categories: pembayaranLabels },
    tooltip: { y: { formatter: val => val + ' transaksi' } },
    legend: { position: 'top' },
    grid: { borderColor: '#f0f0f0' },
    dataLabels: { enabled: false },
}).render();
</script>
</x-admin-layout>
