<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Supplier;

class SuppliersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $suppliers = [
            [
                'name' => 'Confecções Brasil',
                'contact_name' => 'Carlos Silva',
                'email' => 'vendas@confeccoesbrasil.com.br',
                'phone' => '1123456789',
                'address' => 'Av. Industrial, 1000 - São Paulo/SP',
                'cnpj' => '11222333000144',
                'products_provided' => ['Camisetas', 'Calças', 'Bermudas']
            ],
            [
                'name' => 'Malhas Premium',
                'contact_name' => 'Fernanda Oliveira',
                'email' => 'compras@malhaspremium.com.br',
                'phone' => '1133334444',
                'address' => 'Rua Têxtil, 500 - Americana/SP',
                'cnpj' => '44555666000177',
                'products_provided' => ['Blusas', 'Vestidos', 'Moletons']
            ],
            [
                'name' => 'Jeans & Cia',
                'contact_name' => 'Roberto Santos',
                'email' => 'jeanscia@contato.com.br',
                'phone' => '1144445555',
                'address' => 'Rod. dos Jeans, KM 10 - Brusque/SC',
                'cnpj' => '77888999000122',
                'products_provided' => ['Calças Jeans', 'Jaquetas', 'Shorts']
            ]
        ];

        foreach ($suppliers as $supplier) {
            Supplier::create($supplier);
        }
    }
}
