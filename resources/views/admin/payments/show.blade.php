<x-admin-layout>
    <x-slot name="header">Detail Pembayaran — {{ $payment->order->order_code }}</x-slot>

    <div class="row g-4">
        <div class="col-lg-8">
            {{-- Order Info --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0"><i class="bi bi-receipt me-1"></i> {{ $payment->order->order_code }}</h5>
                    @switch($payment->order->status)
                        @case('pending_payment')
                            <span class="badge bg-warning text-dark">Menunggu Pembayaran</span>
                            @break
                        @case('payment_submitted')
                            <span class="badge bg-info text-dark">Pembayaran Dikirim</span>
                            @break
                        @case('confirmed')
                            <span class="badge bg-success">Dikonfirmasi</span>
                            @break
                        @case('rejected')
                            <span class="badge bg-danger">Ditolak</span>
                            @break
                        @default
                            <span class="badge bg-secondary">{{ $payment->order->status }}</span>
                    @endswitch
                </div>
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-4 text-muted">Customer</div>
                        <div class="col-sm-8">{{ $payment->order->user->name }} ({{ $payment->order->user->email }})</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-4 text-muted">Tanggal Pesanan</div>
                        <div class="col-sm-8">{{ $payment->order->created_at->format('d M Y, H:i') }}</div>
                    </div>
                    @if($payment->order->note)
                        <div class="row">
                            <div class="col-sm-4 text-muted">Catatan</div>
                            <div class="col-sm-8">{{ $payment->order->note }}</div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Order Items --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white fw-bold">Item Pesanan</div>
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Produk</th>
                                <th class="text-end">Harga</th>
                                <th class="text-center">Qty</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($payment->order->orderItems as $item)
                                <tr>
                                    <td>{{ $item->product->name ?? 'Produk dihapus' }}</td>
                                    <td class="text-end">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                    <td class="text-center">{{ $item->qty }}</td>
                                    <td class="text-end">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="table-light">
                                <td colspan="3" class="text-end fw-bold">Total</td>
                                <td class="text-end fw-bold text-success">Rp {{ number_format($payment->order->total_amount, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            {{-- Payment Proof --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white fw-bold">
                    <i class="bi bi-credit-card me-1"></i> Bukti Pembayaran
                </div>
                <div class="card-body">
                    @if($payment->proof_image_path)
                        <img src="{{ asset('storage/' . $payment->proof_image_path) }}" class="w-100 rounded mb-3" alt="Bukti pembayaran">
                    @endif
                    <div class="mb-2">
                        <small class="text-muted">Jumlah Transfer</small><br>
                        <span class="fw-bold fs-5">Rp {{ number_format($payment->amount, 0, ',', '.') }}</span>
                    </div>
                    @if($payment->payer_name)
                        <div class="mb-2">
                            <small class="text-muted">Nama Pengirim</small><br>
                            <span>{{ $payment->payer_name }}</span>
                        </div>
                    @endif
                    @if($payment->bank_name)
                        <div class="mb-2">
                            <small class="text-muted">Bank</small><br>
                            <span>{{ $payment->bank_name }}</span>
                        </div>
                    @endif
                    <div class="mb-2">
                        <small class="text-muted">Status</small><br>
                        @switch($payment->status)
                            @case('submitted')
                                <span class="badge bg-warning text-dark">Menunggu Review</span>
                                @break
                            @case('approved')
                                <span class="badge bg-success">Disetujui</span>
                                @if($payment->reviewed_at)
                                    <br><small class="text-muted">Direview {{ $payment->reviewed_at->format('d M Y, H:i') }}</small>
                                @endif
                                @break
                            @case('rejected')
                                <span class="badge bg-danger">Ditolak</span>
                                @if($payment->reviewed_at)
                                    <br><small class="text-muted">Direview {{ $payment->reviewed_at->format('d M Y, H:i') }}</small>
                                @endif
                                @break
                            @default
                                <span class="badge bg-secondary">{{ $payment->status }}</span>
                        @endswitch
                    </div>
                    @if($payment->admin_note)
                        <div class="mt-2 p-2 bg-light rounded">
                            <small class="text-muted">Catatan Admin</small><br>
                            <span>{{ $payment->admin_note }}</span>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Approve / Reject (only if submitted) --}}
            @if($payment->status === 'submitted')
                <div class="card border-success border-2 shadow-sm">
                    <div class="card-header bg-success text-white fw-bold">
                        <i class="bi bi-check2-all me-1"></i> Review Pembayaran
                    </div>
                    <div class="card-body">
                        {{-- Sibling forms only — nested <form> breaks submit via form="..." in some browsers --}}
                        <form id="approveForm" action="{{ route('admin.payments.approve', $payment) }}" method="POST" class="d-none" onsubmit="return confirm('Setujui pembayaran ini? Stok akan dikurangi.');">
                            @csrf
                        </form>
                        <form id="rejectForm" action="{{ route('admin.payments.reject', $payment) }}" method="POST" onsubmit="return confirm('Tolak pembayaran ini?');">
                            @csrf
                            <div class="mb-3">
                                <label for="admin_note" class="form-label small">Catatan (untuk penolakan)</label>
                                <textarea name="admin_note" id="admin_note" rows="2" class="form-control form-control-sm"
                                          placeholder="Alasan penolakan (opsional)">{{ old('admin_note') }}</textarea>
                                @error('admin_note')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                        </form>
                        <div class="d-flex gap-2">
                            <button type="submit" form="approveForm" class="btn btn-success flex-grow-1">
                                <i class="bi bi-check-lg me-1"></i> Setujui
                            </button>
                            <button type="submit" form="rejectForm" class="btn btn-danger flex-grow-1">
                                <i class="bi bi-x-lg me-1"></i> Tolak
                            </button>
                        </div>
                        <p class="small text-muted mb-0 mt-3">
                            <i class="bi bi-info-circle me-1"></i> Setujui akan mengurangi stok produk sesuai pesanan.
                        </p>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('admin.payments.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar
        </a>
    </div>
</x-admin-layout>
