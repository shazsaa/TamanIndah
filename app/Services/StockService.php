<?php

namespace App\Services;

use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Support\Facades\DB;

class StockService
{
    /**
     * @throws \InvalidArgumentException
     */
    public function processMovement(Product $product, string $type, int $qty, ?string $note, int $adminId): StockMovement
    {
        return DB::transaction(function () use ($product, $type, $qty, $note, $adminId) {
            $movementQty = $qty;

            switch ($type) {
                case 'in':
                    $product->increment('stock', $qty);
                    break;

                case 'out':
                    if ($product->stock < $qty) {
                        throw new \InvalidArgumentException(
                            "Cannot remove {$qty} units. Only {$product->stock} in stock for \"{$product->name}\"."
                        );
                    }
                    $product->decrement('stock', $qty);
                    break;

                case 'adjust':
                    $oldStock = $product->stock;
                    $delta = $qty - $oldStock;
                    $product->update(['stock' => $qty]);
                    $movementQty = $qty;
                    $deltaLabel = $delta >= 0 ? "+{$delta}" : (string) $delta;
                    $note = "Adjusted from {$oldStock} to {$qty} (delta: {$deltaLabel})" . ($note ? ". {$note}" : '');
                    break;

                default:
                    throw new \InvalidArgumentException("Unknown stock movement type: {$type}");
            }

            return StockMovement::create([
                'product_id'          => $product->id,
                'type'                => $type,
                'qty'                 => $movementQty,
                'note'                => $note,
                'created_by_admin_id' => $adminId,
            ]);
        });
    }
}
