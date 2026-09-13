<x-admin-layout>
    <x-slot name="header">Edit Product</x-slot>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title fw-bold mb-3">Edit: {{ $product->name }}</h5>

                    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <div class="col-md-8">
                                <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name"
                                       class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name', $product->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="category_id" class="form-label">Category <span class="text-danger">*</span></label>
                                <select name="category_id" id="category_id"
                                        class="form-select @error('category_id') is-invalid @enderror" required>
                                    <option value="">-- Select --</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="price" class="form-label">Price (Rp) <span class="text-danger">*</span></label>
                                <input type="number" name="price" id="price" step="0.01" min="0"
                                       class="form-control @error('price') is-invalid @enderror"
                                       value="{{ old('price', $product->price) }}" required>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="stock" class="form-label">Stock <span class="text-danger">*</span></label>
                                <input type="number" name="stock" id="stock" min="0"
                                       class="form-control @error('stock') is-invalid @enderror"
                                       value="{{ old('stock', $product->stock) }}" required>
                                @error('stock')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 d-flex align-items-end">
                                <div class="form-check">
                                    <input type="hidden" name="is_active" value="0">
                                    <input class="form-check-input" type="checkbox" name="is_active" id="is_active"
                                           value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">Active</label>
                                </div>
                            </div>

                            <div class="col-12">
                                <label for="description" class="form-label">Description</label>
                                <textarea name="description" id="description" rows="3"
                                          class="form-control @error('description') is-invalid @enderror">{{ old('description', $product->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="image" class="form-label">Product Image</label>
                                @if($product->image_path)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $product->image_path) }}"
                                             alt="{{ $product->name }}"
                                             class="rounded border" style="max-height: 120px;">
                                    </div>
                                @endif
                                <input type="file" name="image" id="image" accept="image/jpeg,image/png,image/webp"
                                       class="form-control @error('image') is-invalid @enderror">
                                <div class="form-text">Leave empty to keep current image. JPG, PNG, or WebP. Max 2 MB.</div>
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        <div class="col-12"><hr class="my-2"></div>

                        <div class="col-12">
                            <h6 class="fw-bold text-muted mb-3" style="font-size:13px;letter-spacing:0.5px;">INFO PERAWATAN</h6>
                        </div>

                        <div class="col-md-4">
                            <label for="water_frequency" class="form-label">Frekuensi Air</label>
                            <input type="text"
                                name="water_frequency"
                                id="water_frequency"
                                class="form-control @error('water_frequency') is-invalid @enderror"
                                placeholder="cth: 2-3x seminggu"
                                value="{{ old('water_frequency', $product->water_frequency ?? '') }}">
                            @error('water_frequency')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="light_requirement" class="form-label">Kebutuhan Cahaya</label>
                            <input type="text"
                                name="light_requirement"
                                id="light_requirement"
                                class="form-control @error('light_requirement') is-invalid @enderror"
                                placeholder="cth: Tidak langsung"
                                value="{{ old('light_requirement', $product->light_requirement ?? '') }}">
                            @error('light_requirement')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="temperature_range" class="form-label">Rentang Suhu</label>
                            <input type="text"
                                name="temperature_range"
                                id="temperature_range"
                                class="form-control @error('temperature_range') is-invalid @enderror"
                                placeholder="cth: 18-30°C"
                                value="{{ old('temperature_range', $product->temperature_range ?? '') }}">
                            @error('temperature_range')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="care_level" class="form-label">Kemudahan Perawatan</label>
                            <select name="care_level" id="care_level" class="form-select @error('care_level') is-invalid @enderror">
                                <option value="">-- Pilih --</option>
                                <option value="mudah" {{ old('care_level', $product->care_level ?? '') === 'mudah' ? 'selected' : '' }}>Mudah</option>
                                <option value="sedang" {{ old('care_level', $product->care_level ?? '') === 'sedang' ? 'selected' : '' }}>Perawatan Sedang</option>
                                <option value="perlu_perhatian" {{ old('care_level', $product->care_level ?? '') === 'perlu_perhatian' ? 'selected' : '' }}>Perlu Perhatian</option>
                            </select>
                            @error('care_level')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="placement_type" class="form-label">Penempatan</label>
                            <select name="placement_type" id="placement_type" class="form-select @error('placement_type') is-invalid @enderror">
                                <option value="">-- Pilih --</option>
                                <option value="dalam_ruangan" {{ old('placement_type', $product->placement_type ?? '') === 'dalam_ruangan' ? 'selected' : '' }}>Dalam Ruangan</option>
                                <option value="luar_ruangan" {{ old('placement_type', $product->placement_type ?? '') === 'luar_ruangan' ? 'selected' : '' }}>Luar Ruangan</option>
                                <option value="keduanya" {{ old('placement_type', $product->placement_type ?? '') === 'keduanya' ? 'selected' : '' }}>Keduanya</option>
                            </select>
                            @error('placement_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        </div>

                        <div class="d-flex gap-2 mt-4">
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-check-lg me-1"></i> Update
                            </button>
                            <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
