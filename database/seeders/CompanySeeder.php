<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Company;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Company::create([
            'name' => 'Moda Elegante Ltda',
            'address' => 'Rua das Flores, 123 - Centro, São Paulo/SP',
            'phone' => '11987654321',
            'email' => 'contato@modaelegante.com.br',
            'cnpj' => '12345678000199',
            'social_media' => [
                'instagram' => '@modaelegante',
                'facebook' => 'fb.com/moda.elegante',
                'tiktok' => '@modaelegante'
            ]
        ]);
    }
}
