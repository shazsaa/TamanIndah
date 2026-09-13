<x-admin-layout>
    <x-slot name="header">Products</x-slot>

    <style>
        .pagination-clean-wrap > nav {
            display: flex !important;
            align-items: center;
            justify-content: space-between;
            padding: 12px 0;
            width: 100%;
        }
        .pagination-clean-wrap nav p.small,
        .pagination-clean-wrap nav p.small.text-muted {
            font-size: 12px !important;
            color: #888 !important;
            margin-bottom: 0;
        }
        .pagination-clean-wrap nav p.small .fw-semibold {
            color: #888;
            font-weight: 600;
        }
        .pagination-clean-wrap .pagination {
            margin-bottom: 0;
            gap: 4px;
            flex-wrap: wrap;
        }
        .pagination-clean-wrap .page-item {
            margin: 0;
        }
        .pagination-clean-wrap .page-link {
            width: 30px;
            height: 30px;
            min-width: 30px;
            padding: 0 !important;
            border: 0.5px solid #d8e8d8 !important;
            border-radius: 6px !important;
            background: white !important;
            font-size: 12px;
            display: flex !important;
            align-items: center;
            justify-content: center;
            line-height: 1;
            box-sizing: border-box;
        }
        .pagination-clean-wrap ul.pagination .page-item:not(:first-child):not(:last-child):not(.active) .page-link {
            color: #444 !important;
        }
        .pagination-clean-wrap ul.pagination .page-item:first-child:not(.disabled) .page-link,
        .pagination-clean-wrap ul.pagination .page-item:last-child:not(.disabled) .page-link {
            color: #4A7C59 !important;
        }
        .pagination-clean-wrap .page-item.active .page-link {
            background: #4A7C59 !important;
            color: white !important;
            border-color: #4A7C59 !important;
        }
        .pagination-clean-wrap .page-item.disabled .page-link {
            color: #aaa !important;
            opacity: 1;
        }
        @media (max-width: 575.98px) {
            .pagination-clean-wrap .d-sm-none .page-link {
                width: auto;
                min-width: 30px;
                padding: 0 10px !important;
            }
        }
    </style>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold mb-0">All Products</h4>
        <a href="{{ route('admin.products.create') }}" class="btn btn-success">
            <i class="bi bi-plus-lg me-1"></i> Add Product
        </a>
    </div>

    {{-- Filters --}}
    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.products.index') }}" class="row g-2 align-items-end">
                <div class="col-md-5">
                    <label for="search" class="form-label small text-muted">Search</label>
                    <input type="text" name="search" id="search" class="form-control"
                           placeholder="Product name..." value="{{ request('search') }}">
                </div>
                <div class="col-md-4">
                    <label for="category_id" class="form-label small text-muted">Category</label>
                    <select name="category_id" id="category_id" class="form-select">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn flex-grow-1 text-white" style="background-color:#4A7C59;border-color:#4A7C59;">
                        <i class="bi bi-search me-1"></i> Filter
                    </button>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">Reset</a>
                </div>
            </form>
        </div>
    </div>

    @if($lowStockCount > 0)
        <div style="background:#fff8e6;border:0.5px solid #f5c842;border-radius:8px;margin-bottom:1rem;overflow:hidden;">
            <div style="padding:10px 16px;display:flex;align-items:center;gap:8px;font-size:12px;color:#92400e;cursor:pointer;" id="lowStockToggle" onclick="toggleLowStockFilter()">
                <svg width="14" height="14" viewBox="0 0 16 16" fill="none">
                    <circle cx="8" cy="8" r="6.5" stroke="#d97706" stroke-width="1.3"/>
                    <path d="M8 5v3.5M8 10.5v.5" stroke="#d97706" stroke-width="1.5" stroke-linecap="round"/>
                </svg>
                <span id="lowStockText"><strong>{{ $lowStockCount }} produk</strong> memiliki stok di bawah 5 unit. Klik untuk lihat.</span>
                <svg id="lowStockChevron" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#92400e" stroke-width="2" style="margin-left:auto;transition:transform 0.2s;">
                    <polyline points="6 9 12 15 18 9"/>
                </svg>
            </div>
        </div>
    @endif

    {{-- Products Table --}}
    <div id="normalProductTable"><div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 70px">Image</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th class="text-end">Price</th>
                        <th class="text-center">Stock</th>
                        <th class="text-center">Status</th>
                        <th class="text-center" style="width: 220px">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <tr data-lowstock="{{ $product->stock < 5 ? 'true' : 'false' }}">
                            <td>
                                @if($product->image_path)
                                    <img src="{{ asset('storage/' . $product->image_path) }}"
                                         alt="{{ $product->name }}"
                                         class="rounded" style="width: 50px; height: 50px; object-fit: cover;">
                                @else
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                         style="width: 50px; height: 50px;">
                                        <i class="bi bi-image text-muted"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="fw-semibold">{{ $product->name }}</td>
                            <td><span class="text-muted">{{ $product->category->name }}</span></td>
                            <td class="text-end">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                            <td class="text-center">
                                @if($product->stock < 5)
                                    <span class="badge d-inline-flex align-items-center gap-1 border-0" style="background: #fde8e8; color: #a32d2d;">
                                        <svg width="12" height="12" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                                            <circle cx="8" cy="8" r="6.5" stroke="currentColor" stroke-width="1.3"/>
                                            <path d="M8 5v3.5M8 10.5v.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                        </svg>
                                        {{ $product->stock }}
                                    </span>
                                @else
                                    <span class="badge bg-success-subtle text-success">{{ $product->stock }}</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <form action="{{ route('admin.products.toggle-active', $product) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm {{ $product->is_active ? 'btn-success' : 'btn-outline-secondary' }}">
                                        {{ $product->is_active ? 'Active' : 'Inactive' }}
                                    </button>
                                </form>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-outline-primary me-1">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Delete product &quot;{{ $product->name }}&quot;?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">No products found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    </div>

    <div id="lowStockTable" style="display:none;">
        <div class="card border-0 shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width:70px">Image</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th class="text-end">Price</th>
                            <th class="text-center">Stock</th>
                            <th class="text-center">Status</th>
                            <th class="text-center" style="width:220px">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($lowStockProducts as $product)
                            <tr>
                                <td>
                                    @if($product->image_path)
                                        <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="rounded" style="width:50px;height:50px;object-fit:cover;">
                                    @else
                                        <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width:50px;height:50px;">
                                            <i class="bi bi-image text-muted"></i>
                                        </div>
                                    @endif
                                </td>
                                <td class="fw-semibold">{{ $product->name }}</td>
                                <td><span class="text-muted">{{ $product->category->name ?? '-' }}</span></td>
                                <td class="text-end">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                <td class="text-center">
                                    <span class="badge d-inline-flex align-items-center gap-1 border-0" style="background:#fde8e8;color:#a32d2d;">
                                        <svg width="12" height="12" viewBox="0 0 16 16" fill="none"><circle cx="8" cy="8" r="6.5" stroke="currentColor" stroke-width="1.3"/><path d="M8 5v3.5M8 10.5v.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
                                        {{ $product->stock }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <form action="{{ route('admin.products.toggle-active', $product) }}" method="POST" class="d-inline">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="btn btn-sm {{ $product->is_active ? 'btn-success' : 'btn-outline-secondary' }}">
                                            {{ $product->is_active ? 'Active' : 'Inactive' }}
                                        </button>
                                    </form>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-outline-primary me-1"><i class="bi bi-pencil"></i></a>
                                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete product &quot;{{ $product->name }}&quot;?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="text-center text-muted py-4">Tidak ada produk low stock.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($lowStockProducts->count() > 50)
            <div class="mt-2 text-muted small text-end">Menampilkan {{ $lowStockProducts->count() }} produk low stock.</div>
        @endif
    </div>

    @if($products->hasPages())
        <div class="pagination-clean-wrap">
            {{ $products->links() }}
        </div>
    @endif
<script>
let isFiltered = false;
function toggleLowStockFilter() {
    isFiltered = !isFiltered;
    const chevron = document.getElementById('lowStockChevron');
    const text = document.getElementById('lowStockText');
    const normalTable = document.getElementById('normalProductTable');
    const lowStockTable = document.getElementById('lowStockTable');
    const paginationWrap = document.querySelector('.pagination-clean-wrap');

    if (isFiltered) {
        normalTable.style.display = 'none';
        lowStockTable.style.display = 'block';
        if (paginationWrap) paginationWrap.style.display = 'none';
        chevron.style.transform = 'rotate(180deg)';
        text.innerHTML = '<strong>{{ $lowStockCount }} produk</strong> stok rendah ditampilkan. Klik untuk kembali.';
    } else {
        normalTable.style.display = 'block';
        lowStockTable.style.display = 'none';
        if (paginationWrap) paginationWrap.style.display = '';
        chevron.style.transform = 'rotate(0deg)';
        text.innerHTML = '<strong>{{ $lowStockCount }} produk</strong> memiliki stok di bawah 5 unit. Klik untuk lihat.';
    }
}
</script>
</x-admin-layout>
