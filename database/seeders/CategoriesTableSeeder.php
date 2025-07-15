<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Desativa a proteção mass assignment
        Category::unguard();
        
        // Limpa a tabela
        //Category::truncate();
        
        // Categorias de roupas masculinas
        $maleCategories = [
            'Camisetas',
            'Camisas',
            'Calças',
            'Bermudas',
            'Blazers',
            'Jaquetas',
            'Moletons',
            'Roupas Íntimas'
        ];
        
        // Categorias de roupas femininas
        $femaleCategories = [
            'Blusas',
            'Vestidos',
            'Saias',
            'Calças',
            'Shorts',
            'Casacos',
            'Roupas Íntimas',
            'Roupas de Banho'
        ];
        
        // Categorias infantis
        $kidsCategories = [
            'Conjuntos',
            'Vestidos',
            'Camisetas',
            'Calças',
            'Bermudas',
            'Agasalhos',
            'Roupas de Bebê'
        ];
        
        // Unissex
        $unisexCategories = [
            'Acessórios',
            'Meias',
            'Bonés',
            'Lenços',
            'Pijamas'
        ];
        
        // Insere categorias masculinas
        foreach ($maleCategories as $category) {
            Category::create([
                'name' => $category,
                'type' => 'masculino'
            ]);
        }
        
        // Insere categorias femininas
        foreach ($femaleCategories as $category) {
            Category::create([
                'name' => $category,
                'type' => 'feminino'
            ]);
        }
        
        // Insere categorias infantis
        foreach ($kidsCategories as $category) {
            Category::create([
                'name' => $category,
                'type' => 'infantil'
            ]);
        }
        
        // Insere categorias unissex
        foreach ($unisexCategories as $category) {
            Category::create([
                'name' => $category,
                'type' => 'unissex'
            ]);
        }
        
        // Reativa a proteção mass assignment
        Category::reguard();
    }
}
