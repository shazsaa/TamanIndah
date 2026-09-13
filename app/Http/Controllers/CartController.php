<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(): View
    {
        $cart = session('cart', []);
        $items = collect();
        $grandTotal = 0;

        if (!empty($cart)) {
            $products = Product::whereIn('id', array_keys($cart))->get()->keyBy('id');

            foreach ($cart as $productId => $qty) {
                if (!$products->has($productId)) {
                    continue;
                }

                $product = $products[$productId];
                $cappedQty = min($qty, $product->stock);
                if ($cappedQty < 1) {
                    continue;
                }

                $subtotal = $product->price * $cappedQty;
                $grandTotal += $subtotal;

                $items->push((object) [
                    'product'  => $product,
                    'qty'      => $cappedQty,
                    'subtotal' => $subtotal,
                ]);
            }
        }

        return view('cart.index', compact('items', 'grandTotal'));
    }

    public function add(Request $request): RedirectResponse
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'qty'        => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        if (!$product->is_active) {
            return back()->with('error', 'Produk tidak tersedia.');
        }

        $cart = session('cart', []);
        $currentQty = $cart[$product->id] ?? 0;
        $newQty = $currentQty + $request->qty;

        if ($newQty > $product->stock) {
            return back()->with('error', "Stok tidak mencukupi. Tersedia: {$product->stock}, di keranjang: {$currentQty}.");
        }

        $cart[$product->id] = $newQty;
        session(['cart' => $cart]);

        return redirect()->route('cart.index')->with('success', "\"{$product->name}\" berhasil ditambahkan ke keranjang.");
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'qty'        => 'required|integer|min:0',
        ]);

        $cart = session('cart', []);
        $product = Product::findOrFail($request->product_id);

        if ($request->qty == 0) {
            unset($cart[$product->id]);
            session(['cart' => $cart]);
            return back()->with('success', "\"{$product->name}\" dihapus dari keranjang.");
        }

        if ($request->qty > $product->stock) {
            return back()->with('error', "Stok \"{$product->name}\" tidak mencukupi. Tersedia: {$product->stock}.");
        }

        $cart[$product->id] = $request->qty;
        session(['cart' => $cart]);

        return back()->with('success', 'Keranjang diperbarui.');
    }

    public function remove(Product $product): RedirectResponse
    {
        $cart = session('cart', []);
        unset($cart[$product->id]);
        session(['cart' => $cart]);

        return back()->with('success', "\"{$product->name}\" dihapus dari keranjang.");
    }
}
