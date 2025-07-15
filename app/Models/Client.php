<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'email', 'phone', 'address', 'cpf', 
        'birth_date', 'purchases_count', 'total_spent', 'last_purchase'
    ];

    protected $casts = [
        'birth_date' => 'date',
        'last_purchase' => 'date',
        'total_spent' => 'decimal:2',
        'deleted_at' => 'datetime',
    ];

    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class);
    }

    public function getFormattedPhoneAttribute(): string
    {
        return preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $this->phone);
    }
}
