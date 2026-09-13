<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Payment;
use App\Models\StockMovement;
use Illuminate\Support\Facades\DB;

class PaymentApprovalService
{
    /**
     * Approve payment: decrease stock, create stock_movements, update payment & order.
     *
     * @throws \RuntimeException if payment not submitted, or insufficient stock
     */
    public function approve(Payment $payment, int $adminId): void
    {
        if ($payment->status !== 'submitted') {
            throw new \RuntimeException('Pembayaran ini sudah direview sebelumnya.');
        }

        DB::transaction(function () use ($payment, $adminId) {
            $payment->lockForUpdate();
            if ($payment->status !== 'submitted') {
                throw new \RuntimeException('Pembayaran ini sudah direview sebelumnya.');
            }

            $order = $payment->order()->lockForUpdate()->first();
            $items = $order->orderItems()->with('product')->get();

            $productIds = $items->pluck('product_id')->unique();
            $products = \App\Models\Product::whereIn('id', $productIds)->lockForUpdate()->get()->keyBy('id');

            $qtyByProduct = $items->groupBy('product_id')->map(fn ($group) => $group->sum('qty'));

            foreach ($qtyByProduct as $productId => $totalQty) {
                $product = $products->get($productId);
                if (!$product || $product->stock < $totalQty) {
                    $name = $product ? $product->name : 'Produk';
                    throw new \RuntimeException(
                        "Stok tidak mencukupi untuk \"{$name}\". Tersedia: " . ($product->stock ?? 0) . ", dibutuhkan: {$totalQty}."
                    );
                }
            }

            foreach ($items as $item) {
                $product = $products->get($item->product_id);
                $product->decrement('stock', $item->qty);

                StockMovement::create([
                    'product_id'          => $item->product_id,
                    'type'                => 'approve_commit',
                    'qty'                 => $item->qty,
                    'note'                => "Pesanan {$order->order_code} disetujui",
                    'ref_order_id'        => $order->id,
                    'created_by_admin_id' => $adminId,
                ]);
            }

            $payment->update([
                'status'               => 'approved',
                'reviewed_at'          => now(),
                'reviewed_by_admin_id' => $adminId,
            ]);

            $order->update([
                'status'           => 'confirmed',
                'confirmed_at'   => now(),
                'pickup_deadline' => now()->addDays(3)->toDateString(),
            ]);
        });
    }

    /**
     * Reject payment: update payment & order status.
     *
     * @throws \RuntimeException if payment not submitted
     */
    public function reject(Payment $payment, ?string $adminNote, int $adminId): void
    {
        if ($payment->status !== 'submitted') {
            throw new \RuntimeException('Pembayaran ini sudah direview sebelumnya.');
        }

        DB::transaction(function () use ($payment, $adminNote, $adminId) {
            $payment->lockForUpdate();
            if ($payment->status !== 'submitted') {
                throw new \RuntimeException('Pembayaran ini sudah direview sebelumnya.');
            }

            $payment->update([
                'status'               => 'rejected',
                'admin_note'           => $adminNote,
                'reviewed_at'          => now(),
                'reviewed_by_admin_id' => $adminId,
            ]);

            $payment->order->update([
                'status'      => 'rejected',
                'rejected_at' => now(),
            ]);
        });
    }
}
