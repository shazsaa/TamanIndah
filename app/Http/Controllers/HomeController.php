<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(Request $request): View
    {
        $query = Product::with('category')->where('is_active', true);

        if ($search = $request->input('search')) {
            $query->where('name', 'like', "%{$search}%");
        }

        if ($categoryId = $request->input('category_id')) {
            $query->where('category_id', $categoryId);
        }

        if ($careLevel = $request->input('care_level')) {
            $query->where('care_level', $careLevel);
        }

        if ($placementType = $request->input('placement_type')) {
            $query->where('placement_type', $placementType);
        }

        if ($label = $request->input('label')) {
            if ($label === 'best_seller') {
                $bestSellerIds = \DB::table('order_items')
                    ->select('product_id')
                    ->groupBy('product_id')
                    ->havingRaw('SUM(qty) > 50')
                    ->pluck('product_id');
                $query->whereIn('id', $bestSellerIds);
            } elseif ($label === 'premium') {
                $query->where('price', '>', 500000);
            } elseif ($label === 'easy_care') {
                $query->where('care_level', 'mudah')
                    ->where('price', '<=', 500000);
            }
        }

        if ($priceMin = $request->input('price_min')) {
            $query->where('price', '>=', (int) str_replace('.', '', $priceMin));
        }

        if ($priceMax = $request->input('price_max')) {
            $query->where('price', '<=', (int) str_replace('.', '', $priceMax));
        }

        $sort = $request->input('sort');
        if ($sort === 'price_asc') {
            $query->orderBy('price', 'asc');
        } elseif ($sort === 'price_desc') {
            $query->orderBy('price', 'desc');
        } else {
            $query->orderBy('name');
        }

        $products = $query->paginate(12)->appends($request->only([
            'search', 'category_id', 'care_level', 'placement_type', 'label', 'price_min', 'price_max', 'sort',
        ]));

        $categories = Category::orderBy('name')->get();

        return view('welcome', compact('products', 'categories'));
    }
}
