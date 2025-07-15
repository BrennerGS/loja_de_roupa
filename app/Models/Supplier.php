<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'contact_name', 'email', 'phone',
        'address', 'cnpj', 'products_provided'
    ];

    protected $casts = [
        'products_provided' => 'array',
        'deleted_at' => 'datetime',
    ];

    public function getFormattedCnpjAttribute(): string
    {
        return preg_replace(
            '/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/',
            '$1.$2.$3/$4-$5',
            $this->cnpj
        );
    }
}
