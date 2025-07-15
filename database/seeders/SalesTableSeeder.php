<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Sale;
use App\Models\SaleItem;

class SalesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sales = [
            [
                'invoice_number' => 'INV-' . uniqid(),
                'client_id' => 1,
                'user_id' => 2, // Gerente Vendas
                'total' => 259.80,
                'discount' => 10.00,
                'tax' => 15.50,
                'payment_method' => 'credit',
                'created_at' => now()->subDays(5)
            ],
            [
                'invoice_number' => 'INV-' . uniqid(),
                'client_id' => 2,
                'user_id' => 4, // Atendente
                'total' => 349.70,
                'discount' => 0,
                'tax' => 20.90,
                'payment_method' => 'debit',
                'created_at' => now()->subDays(3)
            ]
        ];

        $items = [
            // Venda 1
            [
                'invoice_number' => 'INV-' . uniqid(),
                'sale_id' => 1,
                'product_id' => 1,
                'quantity' => 2,
                'unit_price' => 49.90,
                'total_price' => 99.80
            ],
            [
                'invoice_number' => 'INV-' . uniqid(),
                'sale_id' => 1,
                'product_id' => 3,
                'quantity' => 1,
                'unit_price' => 159.90,
                'total_price' => 159.90
            ],
            // Venda 2
            [
                'sale_id' => 2,
                'product_id' => 2,
                'quantity' => 1,
                'unit_price' => 129.90,
                'total_price' => 129.90
            ],
            [
                'sale_id' => 2,
                'product_id' => 4,
                'quantity' => 2,
                'unit_price' => 89.90,
                'total_price' => 179.80
            ]
        ];

        foreach ($sales as $sale) {
            Sale::create($sale);
        }

        foreach ($items as $item) {
            SaleItem::create($item);
        }
    }
}
