<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class OrderService
{
    /**
     * @param array<int, int> $cart  [product_id => qty]
     * @throws \RuntimeException
     */
    public function createFromCart(User $user, array $cart, ?string $note): Order
    {
        if (empty($cart)) {
            throw new \RuntimeException('Keranjang kosong.');
        }

        return DB::transaction(function () use ($user, $cart, $note) {
            $products = Product::whereIn('id', array_keys($cart))
                ->where('is_active', true)
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            $totalAmount = 0;
            $itemsData = [];

            foreach ($cart as $productId => $qty) {
                $product = $products->get($productId);

                if (!$product) {
                    throw new \RuntimeException("Produk dengan ID {$productId} tidak tersedia.");
                }

                if ($qty > $product->stock) {
                    throw new \RuntimeException(
                        "Stok \"{$product->name}\" tidak mencukupi. Tersedia: {$product->stock}, diminta: {$qty}."
                    );
                }

                $price = $product->price;
                $subtotal = $price * $qty;
                $totalAmount += $subtotal;

                $itemsData[] = [
                    'product_id' => $product->id,
                    'qty'        => $qty,
                    'price'      => $price,
                    'subtotal'   => $subtotal,
                ];
            }

            $order = Order::create([
                'user_id'      => $user->id,
                'order_code'   => 'TEMP',
                'status'       => 'pending_payment',
                'total_amount' => $totalAmount,
                'note'         => $note,
            ]);

            foreach ($itemsData as $item) {
                $order->orderItems()->create($item);
            }

            $order->order_code = 'TI-' . date('Y') . '-' . str_pad($order->id, 5, '0', STR_PAD_LEFT);
            $order->save();

            return $order;
        });
    }
}
