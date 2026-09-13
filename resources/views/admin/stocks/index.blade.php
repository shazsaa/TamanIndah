<x-admin-layout>
    <x-slot name="header">Stock Management</x-slot>

    <div class="row g-4">
        {{-- Stock Movement Form --}}
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title fw-bold mb-3">Add Stock Movement</h5>

                    <form action="{{ route('admin.stocks.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="product_id" class="form-label">Product <span class="text-danger">*</span></label>
                            <select name="product_id" id="product_id"
                                    class="form-select @error('product_id') is-invalid @enderror" required>
                                <option value="">-- Select Product --</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                        {{ $product->name }} (stock: {{ $product->stock }})
                                    </option>
                                @endforeach
                            </select>
                            @error('product_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="type" class="form-label">Type <span class="text-danger">*</span></label>
                            <select name="type" id="type"
                                    class="form-select @error('type') is-invalid @enderror" required>
                                <option value="">-- Select Type --</option>
                                <option value="in" {{ old('type') == 'in' ? 'selected' : '' }}>In (add stock)</option>
                                <option value="out" {{ old('type') == 'out' ? 'selected' : '' }}>Out (remove stock)</option>
                                <option value="adjust" {{ old('type') == 'adjust' ? 'selected' : '' }}>Adjust (set to value)</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="qty" class="form-label">Quantity <span class="text-danger">*</span></label>
                            <input type="number" name="qty" id="qty" min="1"
                                   class="form-control @error('qty') is-invalid @enderror"
                                   value="{{ old('qty') }}" required>
                            @error('qty')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="note" class="form-label">Note</label>
                            <textarea name="note" id="note" rows="2"
                                      class="form-control @error('note') is-invalid @enderror"
                                      placeholder="Optional note...">{{ old('note') }}</textarea>
                            @error('note')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-success w-100">
                            <i class="bi bi-check-lg me-1"></i> Submit Movement
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Recent Movements --}}
        <div class="col-lg-7">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0">Recent Movements</h5>
                <a href="{{ route('admin.stocks.history') }}" class="btn btn-outline-primary btn-sm">
                    <i class="bi bi-clock-history me-1"></i> Full History
                </a>
            </div>

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
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentMovements as $movement)
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
                                    <td class="small text-muted text-truncate" style="max-width: 200px;">{{ $movement->note ?? '-' }}</td>
                                    <td class="small">{{ $movement->admin?->name ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">No stock movements yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
