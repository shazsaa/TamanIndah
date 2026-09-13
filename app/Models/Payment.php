<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = [
        'order_id',
        'payer_name',
        'bank_name',
        'account_number',
        'amount',
        'proof_image_path',
        'status',
        'admin_note',
        'submitted_at',
        'reviewed_at',
        'reviewed_by_admin_id',
    ];

    protected function casts(): array
    {
        return [
            'amount'       => 'decimal:2',
            'submitted_at' => 'datetime',
            'reviewed_at'  => 'datetime',
        ];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by_admin_id');
    }
}
