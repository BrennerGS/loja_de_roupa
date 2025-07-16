<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    // Adicione esta propriedade
    public $originalData = [];

    protected $fillable = [
        'name', 'logo', 'address', 'phone', 'email', 'cnpj', 'social_media'
    ];

    protected $casts = [
        'social_media' => 'array',
    ];

    // public function getFormattedPhoneAttribute(): string
    // {
    //     return preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $this->phone);
    // }

    // public function getFormattedCnpjAttribute(): string
    // {
    //     return preg_replace(
    //         '/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/',
    //         '$1.$2.$3/$4-$5',
    //         $this->cnpj
    //     );
    // }

    // Dados originais para comparação
    
    public function getOriginalData()
    {
        return $this->originalData;
    }
}
