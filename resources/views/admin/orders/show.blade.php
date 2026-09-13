<x-admin-layout>
    <x-slot name="header">Detail Pesanan — {{ $order->order_code }}</x-slot>

    <div class="row g-4">
        <div class="col-lg-8">
            {{-- Order Info --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0"><i class="bi bi-receipt me-1"></i> {{ $order->order_code }}</h5>
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
                </div>
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-4 text-muted">Customer</div>
                        <div class="col-sm-8">{{ $order->user->name }} ({{ $order->user->email }})</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-4 text-muted">Tanggal Pesanan</div>
                        <div class="col-sm-8">{{ $order->created_at->format('d M Y, H:i') }}</div>
                    </div>
                    @if($order->confirmed_at)
                        <div class="row mb-2">
                            <div class="col-sm-4 text-muted">Dikonfirmasi</div>
                            <div class="col-sm-8">{{ $order->confirmed_at->format('d M Y, H:i') }}</div>
                        </div>
                    @endif
                    @if($order->ready_at)
                        <div class="row mb-2">
                            <div class="col-sm-4 text-muted">Siap Diambil</div>
                            <div class="col-sm-8">{{ $order->ready_at->format('d M Y, H:i') }}</div>
                        </div>
                    @endif
                    @if($order->picked_up_at)
                        <div class="row mb-2">
                            <div class="col-sm-4 text-muted">Diambil</div>
                            <div class="col-sm-8">{{ $order->picked_up_at->format('d M Y, H:i') }}</div>
                        </div>
                    @endif
                    @if($order->cancelled_at)
                        <div class="row mb-2">
                            <div class="col-sm-4 text-muted">Dibatalkan</div>
                            <div class="col-sm-8">{{ $order->cancelled_at->format('d M Y, H:i') }}</div>
                        </div>
                    @endif
                    @if($order->note)
                        <div class="row">
                            <div class="col-sm-4 text-muted">Catatan</div>
                            <div class="col-sm-8">{{ $order->note }}</div>
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
                            @foreach($order->orderItems as $item)
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
                                <td class="text-end fw-bold text-success">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            {{-- Payment Info --}}
            @if($order->payment)
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white fw-bold">
                        <i class="bi bi-credit-card me-1"></i> Pembayaran
                    </div>
                    <div class="card-body">
                        <div class="mb-2">
                            <small class="text-muted">Jumlah</small><br>
                            <span class="fw-bold">Rp {{ number_format($order->payment->amount, 0, ',', '.') }}</span>
                        </div>
                        <div class="mb-2">
                            <small class="text-muted">Status</small><br>
                            @switch($order->payment->status)
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
                                    <span class="badge bg-secondary">{{ $order->payment->status }}</span>
                            @endswitch
                        </div>
                        @if($order->payment->proof_image_path)
                            <a href="{{ asset('storage/' . $order->payment->proof_image_path) }}" target="_blank" class="btn btn-sm btn-outline-primary mt-2">
                                <i class="bi bi-image me-1"></i> Lihat Bukti
                            </a>
                        @endif
                    </div>
                </div>
            @endif

            {{-- Status Actions (only if not picked_up, cancelled, rejected) --}}
            @if(!in_array($order->status, ['picked_up', 'cancelled', 'rejected']))
                <div class="card border-0 shadow-sm">
                    <div class="card-header text-white fw-bold" style="background-color: #4A7C59;">
                        <i class="bi bi-clipboard-check me-1"></i> Update Pesanan
                    </div>
                    <div class="card-body">

                        {{-- Textarea catatan --}}
                        <div class="mb-3">
                            <label class="form-label small text-muted">Catatan (untuk pembatalan)</label>
                            <textarea id="cancelNoteText" class="form-control form-control-sm" rows="3"
                                placeholder="Alasan pembatalan (opsional)"></textarea>
                        </div>

                        {{-- Tombol side by side --}}
                        <div class="d-flex gap-2">
                            @if($order->status === 'confirmed')
                                <form action="{{ route('admin.orders.ready', $order) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm">
                                        <i class="bi bi-check2 me-1"></i> Tandai Siap Diambil
                                    </button>
                                </form>
                            @elseif($order->status === 'ready')
                                <form action="{{ route('admin.orders.picked-up', $order) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm">
                                        <i class="bi bi-bag-check me-1"></i> Tandai Telah Diambil
                                    </button>
                                </form>
                            @endif

                            <form action="{{ route('admin.orders.cancel', $order) }}" method="POST">
                                @csrf
                                <input type="hidden" name="cancel_note" id="cancelNoteHidden">
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="document.getElementById('cancelNoteHidden').value = document.getElementById('cancelNoteText').value;">
                                    <i class="bi bi-x-lg me-1"></i> Batalkan
                                </button>
                            </form>
                        </div>

                        {{-- Info note --}}
                        @if(in_array($order->status, ['confirmed', 'ready']))
                            <p class="small text-muted mb-0 mt-2">
                                <i class="bi bi-info-circle me-1"></i> Stok akan dikembalikan ke produk.
                            </p>
                        @endif

                    </div>
                </div>
            @else
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center text-muted">
                        @if($order->status === 'picked_up')
                            <i class="bi bi-lock display-6 d-block mb-2"></i>
                            <p class="mb-0">Pesanan ini telah selesai dan tidak dapat diubah.</p>
                        @else
                            <p class="mb-0">Pesanan ini tidak dapat diubah.</p>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar
        </a>
    </div>
</x-admin-layout>
