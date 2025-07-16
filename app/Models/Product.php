<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'sku', 'category_id', 'size', 'color', 'price', 
        'cost_price', 'quantity', 'min_quantity', 'description', 'image', 'active'
    ];
    
    protected $casts = [
        'price' => 'decimal:2',
        'cost_price' => 'decimal:2',
        'active' => 'boolean',
        'deleted_at' => 'datetime',
    ];
    
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
    public function saleItems()
    {
        return $this->hasMany(SaleItem::class);
    }
    
    public function sales()
    {
        return $this->belongsToMany(Sale::class, 'sale_items')
                ->using(SaleItem::class)
                ->withPivot('unit_price', 'quantity', 'total_price');
    }

    public function inventoryMovements()
    {
        return $this->hasMany(InventoryMovement::class);
    }
    
    public function getProfitAttribute()
    {
        return $this->price - $this->cost_price;
    }
    
    public function getProfitMarginAttribute()
    {
        if ($this->price == 0) return 0;
        return ($this->profit / $this->price) * 100;
    }
    
    public function scopeLowStock($query)
    {
        return $query->where('quantity', '<=', \DB::raw('min_quantity'));
    }
    
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }
}
