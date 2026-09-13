<x-admin-layout>
    <x-slot name="header">Stock History</x-slot>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold mb-0">Stock Movement History</h4>
        <a href="{{ route('admin.stocks.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Back to Stock
        </a>
    </div>

    {{-- Filters --}}
    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.stocks.history') }}" class="row g-2 align-items-end">
                <div class="col-md-4">
                    <label for="product_id" class="form-label small text-muted">Product</label>
                    <select name="product_id" id="product_id" class="form-select">
                        <option value="">All Products</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" {{ request('product_id') == $product->id ? 'selected' : '' }}>
                                {{ $product->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="date_from" class="form-label small text-muted">From</label>
                    <input type="date" name="date_from" id="date_from" class="form-control"
                           value="{{ request('date_from') }}">
                </div>
                <div class="col-md-3">
                    <label for="date_to" class="form-label small text-muted">To</label>
                    <input type="date" name="date_to" id="date_to" class="form-control"
                           value="{{ request('date_to') }}">
                </div>
                <div class="col-md-2 d-flex gap-2">
                    <button type="submit" class="btn flex-grow-1 text-white" style="background-color:#4A7C59;border-color:#4A7C59;">
                        <i class="bi bi-funnel me-1"></i> Filter
                    </button>
                    <a href="{{ route('admin.stocks.history') }}" class="btn btn-outline-secondary">Reset</a>
                </div>
            </form>
        </div>
    </div>

    {{-- History Table --}}
    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Date</th>
                        <th>Product</th>
                        <th class="text-center">Type</th>
                        <th class="text-center">Qty</th>
                        <th>Note</th>
                        <th>Admin</th>
                        <th>Ref Order</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($movements as $movement)
                        <tr>
                            <td class="small text-muted">{{ $movement->created_at->format('d M Y H:i') }}</td>
                            <td class="fw-semibold">{{ $movement->product->name }}</td>
                            <td class="text-center">
                                @if($movement->type === 'in')
                                    <span class="badge bg-success">IN</span>
                                @elseif($movement->type === 'out')
                                    <span class="badge bg-danger">OUT</span>
                                @else
                                    <span class="badge bg-warning text-dark">ADJUST</span>
                                @endif
                            </td>
                            <td class="text-center fw-semibold">{{ $movement->qty }}</td>
                            <td class="small text-muted" style="max-width: 250px;">{{ $movement->note ?? '-' }}</td>
                            <td class="small">{{ $movement->admin?->name ?? '-' }}</td>
                            <td class="small">{{ $movement->order?->order_code ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">No stock movements found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($movements->hasPages())
        <div class="mt-3 d-flex justify-content-center">
            {{ $movements->links() }}
        </div>
    @endif
</x-admin-layout>
