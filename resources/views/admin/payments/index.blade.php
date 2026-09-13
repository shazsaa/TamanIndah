<x-admin-layout>
    <x-slot name="header">Payment Review</x-slot>

    <div class="d-flex flex-wrap gap-3 mb-4">
        <form action="{{ route('admin.payments.index') }}" method="GET" class="d-flex flex-wrap gap-2 align-items-center">
            <input type="text" name="search" class="form-control form-control-sm" style="width:180px"
                   placeholder="Kode pesanan / nama / email" value="{{ request('search') }}">
            <select name="status" class="form-select form-select-sm" style="width:140px">
                <option value="">Semua Status</option>
                <option value="submitted" {{ request('status') === 'submitted' ? 'selected' : '' }}>Menunggu Review</option>
                <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Disetujui</option>
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
                        <th class="text-end">Jumlah</th>
                        <th class="text-center">Status</th>
                        <th>Tanggal Submit</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $payment)
                        <tr>
                            <td class="fw-bold">{{ $payment->order->order_code ?? '-' }}</td>
                            <td>{{ $payment->order->user->name ?? '-' }}<br><small class="text-muted">{{ $payment->order->user->email ?? '' }}</small></td>
                            <td class="text-end">Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                            <td class="text-center">
                                @switch($payment->status)
                                    @case('submitted')
                                        <span class="badge bg-warning text-dark">Menunggu Review</span>
                                        @break
                                    @case('approved')
                                        <span class="badge bg-success">Disetujui</span>
                                        @break
                                    @case('rejected')
                                        <span class="badge bg-danger">Ditolak</span>
                                        @break
                                    @default
                                        <span class="badge bg-secondary">{{ $payment->status }}</span>
                                @endswitch
                            </td>
                            <td>{{ $payment->submitted_at?->format('d M Y, H:i') ?? '-' }}</td>
                            <td class="text-center">
                                <a href="{{ route('admin.payments.show', $payment) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye me-1"></i> Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                <i class="bi bi-credit-card-2-front display-6 d-block mb-2"></i>
                                Belum ada pembayaran yang perlu direview.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($payments->hasPages())
        <div class="mt-3 d-flex justify-content-center">
            {{ $payments->links() }}
        </div>
    @endif
</x-admin-layout>
