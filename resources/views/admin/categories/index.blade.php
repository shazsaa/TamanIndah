<x-admin-layout>
    <x-slot name="header">Categories</x-slot>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold mb-0">All Categories</h4>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-success">
            <i class="bi bi-plus-lg me-1"></i> Add Category
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 60px">#</th>
                        <th>Name</th>
                        <th style="width: 140px" class="text-center">Products</th>
                        <th style="width: 160px" class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $i => $category)
                        <tr>
                            <td class="text-muted">{{ $i + 1 }}</td>
                            <td class="fw-semibold">{{ $category->name }}</td>
                            <td class="text-center">
                                <span class="badge bg-secondary-subtle text-secondary">{{ $category->products_count }}</span>
                            </td>
                            <td class="text-center">
                                <div style="display: flex; gap: 8px; justify-content: center; align-items: center;">
                                    <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST"
                                          onsubmit="return confirm('Delete category &quot;{{ $category->name }}&quot;? This cannot be undone.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">No categories found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>
