<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            // Masculino
            [
                'name' => 'Camiseta Básica Branca',
                'sku' => 'CAM-M-BRA-001',
                'category_id' => 1, // Camisetas Masculinas
                'size' => 'M',
                'color' => 'Branco',
                'price' => 49.90,
                'cost_price' => 25.00,
                'quantity' => 50,
                'min_quantity' => 10,
                'description' => 'Camiseta 100% algodão'
            ],
            [
                'name' => 'Calça Jeans Slim',
                'sku' => 'CAL-M-AZU-002',
                'category_id' => 3, // Calças Masculinas
                'size' => '42',
                'color' => 'Azul',
                'price' => 159.90,
                'cost_price' => 80.00,
                'quantity' => 30,
                'min_quantity' => 5,
                'description' => 'Calça jeans modelo slim'
            ],
            
            // Feminino
            [
                'name' => 'Vestido Floral',
                'sku' => 'VES-F-FLO-003',
                'category_id' => 10, // Vestidos Femininos
                'size' => 'P',
                'color' => 'Floral',
                'price' => 129.90,
                'cost_price' => 65.00,
                'quantity' => 25,
                'min_quantity' => 5,
                'description' => 'Vestido midi floral'
            ],
            
            // Infantil
            [
                'name' => 'Conjunto Infantil Dinossauro',
                'sku' => 'CON-I-DIN-004',
                'category_id' => 15, // Conjuntos Infantis
                'size' => '6',
                'color' => 'Verde',
                'price' => 89.90,
                'cost_price' => 45.00,
                'quantity' => 40,
                'min_quantity' => 8,
                'description' => 'Conjunto infantil com estampa de dinossauro'
            ]
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
