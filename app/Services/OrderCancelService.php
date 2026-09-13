<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Support\Facades\DB;

class OrderCancelService
{
    /**
     * Cancel order. Returns stock if status is confirmed or ready.
     *
     * @throws \RuntimeException if order is picked_up (locked)
     */
    public function cancel(Order $order, int $adminId, ?string $note = null): void
    {
        if ($order->status === 'picked_up') {
            throw new \RuntimeException('Pesanan yang sudah diambil tidak dapat dibatalkan.');
        }

        if (in_array($order->status, ['confirmed', 'ready'])) {
            DB::transaction(function () use ($order, $adminId) {
                $order = Order::where('id', $order->id)->lockForUpdate()->firstOrFail();
                if (!in_array($order->status, ['confirmed', 'ready'])) {
                    throw new \RuntimeException('Status pesanan telah berubah.');
                }

                $items = $order->orderItems()->with('product')->get();
                $productIds = $items->pluck('product_id')->unique();
                $products = Product::whereIn('id', $productIds)->lockForUpdate()->get()->keyBy('id');

                foreach ($items as $item) {
                    $product = $products->get($item->product_id);
                    if (!$product) {
                        continue;
                    }
                    $product->increment('stock', $item->qty);

                    StockMovement::create([
                        'product_id'          => $item->product_id,
                        'type'                => 'return',
                        'qty'                 => $item->qty,
                        'note'                => "Pesanan {$order->order_code} dibatalkan",
                        'ref_order_id'        => $order->id,
                        'created_by_admin_id' => $adminId,
                    ]);
                }

                $order->update([
                    'status'      => 'cancelled',
                    'cancelled_at' => now(),
                    'note'         => $note,
                ]);
                // ✅ FIX: update status payment juga
                if ($order->payment) {
                    $order->payment->update(['status' => 'cancelled']);
                }
            });
        } else {
            $order->update([
                'status'      => 'cancelled',
                'cancelled_at' => now(),
                'note'         => $note,
            ]);
            // ✅ FIX: update status payment juga
            if ($order->payment) {
                $order->payment->update(['status' => 'cancelled']);
            }
        }
    }
}
