<x-admin-layout>
    <x-slot name="header">Orders</x-slot>

    <div class="d-flex flex-wrap gap-3 mb-4">
        <form action="{{ route('admin.orders.index') }}" method="GET" class="d-flex flex-wrap gap-2 align-items-center">
            <input type="text" name="search" class="form-control form-control-sm" style="width:180px"
                   placeholder="Kode pesanan / nama / email" value="{{ request('search') }}">
            <select name="status" class="form-select form-select-sm" style="width:160px">
                <option value="">Semua Status</option>
                <option value="pending_payment" {{ request('status') === 'pending_payment' ? 'selected' : '' }}>Menunggu Pembayaran</option>
                <option value="payment_submitted" {{ request('status') === 'payment_submitted' ? 'selected' : '' }}>Pembayaran Dikirim</option>
                <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Dikonfirmasi</option>
                <option value="ready" {{ request('status') === 'ready' ? 'selected' : '' }}>Siap Diambil</option>
                <option value="picked_up" {{ request('status') === 'picked_up' ? 'selected' : '' }}>Selesai</option>
                <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Ditolak</option>
            </select>
            <button type="submit" class="btn btn-outline-primary btn-sm">
                <i class="bi bi-search me-1"></i> Filter
            </button>
        </form>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Kode Pesanan</th>
                        <th>Customer</th>
                        <th class="text-end">Total</th>
                        <th class="text-center">Status</th>
                        <th>Tanggal</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td class="fw-bold">{{ $order->order_code }}</td>
                            <td>{{ $order->user->name }}<br><small class="text-muted">{{ $order->user->email }}</small></td>
                            <td class="text-end">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                            <td class="text-center">
                                @switch($order->status)
                                    @case('pending_payment')
                                        <span class="badge bg-warning text-dark">Menunggu Pembayaran</span>
                                        @break
                                    @case('payment_submitted')
                                        <span class="badge bg-info text-dark">Pembayaran Dikirim</span>
                                        @break
                                    @case('confirmed')
                                        <span class="badge bg-primary">Dikonfirmasi</span>
                                        @break
                                    @case('ready')
                                        <span class="badge bg-success">Siap Diambil</span>
                                        @break
                                    @case('picked_up')
                                        <span class="badge bg-secondary">Selesai</span>
                                        @break
                                    @case('cancelled')
                                        <span class="badge bg-danger">Dibatalkan</span>
                                        @break
                                    @case('rejected')
                                        <span class="badge bg-danger">Ditolak</span>
                                        @break
                                    @default
                                        <span class="badge bg-secondary">{{ $order->status }}</span>
                                @endswitch
                            </td>
                            <td>{{ $order->created_at->format('d M Y, H:i') }}</td>
                            <td class="text-center">
                                <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye me-1"></i> Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                <i class="bi bi-receipt display-6 d-block mb-2"></i>
                                Belum ada pesanan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($orders->hasPages())
        <div class="mt-3 d-flex justify-content-center">
            {{ $orders->links() }}
        </div>
    @endif
</x-admin-layout>
