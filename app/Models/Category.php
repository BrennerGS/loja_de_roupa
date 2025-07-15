<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = ['name', 'type'];
    
    protected $casts = [
        'created_at' => 'datetime:d/m/Y H:i',
        'updated_at' => 'datetime:d/m/Y H:i',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function getFullNameAttribute(): string
    {
        return "{$this->name} ({$this->type})";
    }
}
