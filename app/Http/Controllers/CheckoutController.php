<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Services\OrderService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function __construct(private OrderService $orderService) {}

    public function index(): View|RedirectResponse
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong. Silakan tambahkan produk terlebih dahulu.');
        }

        $products = Product::whereIn('id', array_keys($cart))->get()->keyBy('id');
        $items = collect();
        $grandTotal = 0;

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

        if ($items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Tidak ada produk valid di keranjang.');
        }

        return view('checkout.index', compact('items', 'grandTotal'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'note' => 'nullable|string|max:500',
        ]);

        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong.');
        }

        try {
            $order = $this->orderService->createFromCart(
                $request->user(),
                $cart,
                $request->note
            );
        } catch (\RuntimeException $e) {
            return redirect()->route('cart.index')->with('error', $e->getMessage());
        }

        session()->forget('cart');

        return redirect()->route('checkout.success', $order);
    }

    public function success(Order $order): View
    {
        abort_unless($order->user_id === auth()->id(), 403);

        $order->load('orderItems.product');

        return view('checkout.success', compact('order'));
    }
}
