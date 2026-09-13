<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'order_code',
        'status',
        'pickup_deadline',
        'total_amount',
        'note',
        'payment_submitted_at',
        'confirmed_at',
        'ready_at',
        'picked_up_at',
        'cancelled_at',
        'rejected_at',
    ];

    protected function casts(): array
    {
        return [
            'total_amount'         => 'decimal:2',
            'payment_submitted_at' => 'datetime',
            'confirmed_at'         => 'datetime',
            'ready_at'             => 'datetime',
            'picked_up_at'         => 'datetime',
            'cancelled_at'         => 'datetime',
            'rejected_at'          => 'datetime',
            'pickup_deadline'      => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    public function stockMovements(): HasMany
    {
        return $this->hasMany(StockMovement::class, 'ref_order_id');
    }
}
