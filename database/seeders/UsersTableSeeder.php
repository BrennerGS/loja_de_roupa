<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // Desativa a proteção mass assignment para a seed
        User::unguard();
        
        // Limpa a tabela
        //User::truncate();
        
        // Cria usuários de exemplo
        $users = [
            [
                'name' => 'Admin Master',
                'email' => 'admin@loja.com',
                'password' => Hash::make('senha123'),
                'is_admin' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Gerente Vendas',
                'email' => 'vendas@loja.com',
                'password' => Hash::make('vendas123'),
                'is_admin' => false,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Estoquista',
                'email' => 'estoque@loja.com',
                'password' => Hash::make('estoque123'),
                'is_admin' => false,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Atendente',
                'email' => 'atendente@loja.com',
                'password' => Hash::make('atendente123'),
                'is_admin' => false,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];
        
        // Insere os usuários
        User::insert($users);
        
        // Atribui permissões (assumindo que o PermissionsTableSeeder já rodou)
        $this->assignPermissions();
        
        // Reativa a proteção mass assignment
        User::reguard();
    }

    protected function assignPermissions()
    {
        $admin = User::where('email', 'admin@loja.com')->first();
        $admin->permissions()->sync([1, 2, 3, 4, 5, 6, 7, 8]); // Todas as permissões
        
        $vendas = User::where('email', 'vendas@loja.com')->first();
        $vendas->permissions()->sync([2, 3, 5]); // Vendas, Clientes e Relatórios
        
        $estoque = User::where('email', 'estoque@loja.com')->first();
        $estoque->permissions()->sync([1, 4]); // Produtos e Fornecedores
        
        $atendente = User::where('email', 'atendente@loja.com')->first();
        $atendente->permissions()->sync([2, 3]); // Vendas e Clientes
    }


}
