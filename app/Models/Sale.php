<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sale extends Model
{
    protected $fillable = [
        'invoice_number', 'client_id', 'user_id', 'total',
        'discount', 'tax', 'payment_method', 'notes'
    ];

    protected $casts = [
        'total' => 'decimal:2',
        'discount' => 'decimal:2',
        'tax' => 'decimal:2',
        'created_at' => 'datetime:d/m/Y H:i',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(SaleItem::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'sale_items')
                    ->using(SaleItem::class)
                    ->withPivot('unit_price', 'quantity', 'total_price');
    }

    public function getSubtotalAttribute(): float
    {
        return $this->total - $this->tax + $this->discount;
    }
}
