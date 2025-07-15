<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InventoryMovement extends Model
{
    protected $fillable = [
        'product_id', 'quantity', 'movement_type', 'user_id', 'notes'
    ];

    protected $casts = [
        'created_at' => 'datetime:d/m/Y H:i',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getFormattedQuantityAttribute(): string
    {
        return $this->movement_type === 'entrada' 
            ? "+{$this->quantity}" 
            : "-{$this->quantity}";
    }
}
