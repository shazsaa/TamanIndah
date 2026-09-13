<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProductRequest;
use App\Http\Requests\Admin\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $query = Product::with('category');

        if ($search = $request->input('search')) {
            $query->where('name', 'like', "%{$search}%");
        }

        if ($categoryId = $request->input('category_id')) {
            $query->where('category_id', $categoryId);
        }

        $products = $query->orderBy('name')->paginate(10)->appends($request->only(['search', 'category_id']));
        $categories = Category::orderBy('name')->get();

        $lowStockCount = Product::where('stock', '<', 5)
            ->where('is_active', true)
            ->count();

        $lowStockProducts = Product::with('category')
            ->where('is_active', true)
            ->where('stock', '<', 5)
            ->orderBy('stock', 'asc')
            ->get();

        return view('admin.products.index', compact('products', 'categories', 'lowStockCount', 'lowStockProducts'));
    }

    public function create(): View
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.products.create', compact('categories'));
    }

    public function store(StoreProductRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('products', 'public');
        }

        $data['is_active'] = $request->boolean('is_active');

        $data['water_frequency'] = $request->water_frequency;
        $data['light_requirement'] = $request->light_requirement;
        $data['temperature_range'] = $request->temperature_range;

        $data['care_level'] = $request->care_level;
        $data['placement_type'] = $request->placement_type;

        Product::create($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    public function edit(Product $product): View
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(UpdateProductRequest $request, Product $product): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($product->image_path) {
                Storage::disk('public')->delete($product->image_path);
            }
            $data['image_path'] = $request->file('image')->store('products', 'public');
        }

        $data['is_active'] = $request->boolean('is_active');

        $data['water_frequency'] = $request->water_frequency;
        $data['light_requirement'] = $request->light_requirement;
        $data['temperature_range'] = $request->temperature_range;

        $data['care_level'] = $request->care_level;
        $data['placement_type'] = $request->placement_type;

        $product->update($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        if ($product->image_path) {
            Storage::disk('public')->delete($product->image_path);
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }

    public function toggleActive(Product $product): RedirectResponse
    {
        $product->update(['is_active' => !$product->is_active]);

        $status = $product->is_active ? 'activated' : 'deactivated';

        return redirect()->back()
            ->with('success', "Product \"{$product->name}\" {$status}.");
    }
}
