<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'price',
        'stock',
        'description',
        'image_path',
        'is_active',
        'water_frequency',
        'light_requirement',
        'temperature_range',
        'care_level',
        'placement_type',
    ];

    protected function casts(): array
    {
        return [
            'price'     => 'decimal:2',
            'stock'     => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function stockMovements(): HasMany
    {
        return $this->hasMany(StockMovement::class);
    }

    public function getLabelsAttribute(): array
    {
        $labels = [];

        if ($this->price > 500000) {
            $labels[] = ['text' => 'Premium', 'class' => 'label-premium'];
        }

        $sold = \DB::table('order_items')
            ->where('product_id', $this->id)
            ->sum('qty');
        if ($sold > 50) {
            $labels[] = ['text' => 'Best Seller', 'class' => 'label-bestseller'];
        }

        if ($this->care_level === 'mudah') {
            $labels[] = ['text' => 'Easy Care', 'class' => 'label-easycare'];
        }

        return $labels;
    }

    public function getLabelAttribute(): ?string
    {
        return $this->labels[0]['text'] ?? null;
    }

    public function getLabelClassAttribute(): string
    {
        return $this->labels[0]['class'] ?? '';
    }
}
