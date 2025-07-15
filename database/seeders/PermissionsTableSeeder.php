<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\User;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $permissions = [
            ['name' => 'Gerenciar Produtos', 'slug' => 'manage-products'],
            ['name' => 'Gerenciar Vendas', 'slug' => 'manage-sales'],
            ['name' => 'Gerenciar Clientes', 'slug' => 'manage-clients'],
            ['name' => 'Gerenciar Fornecedores', 'slug' => 'manage-suppliers'],
            ['name' => 'Ver Relatórios', 'slug' => 'view-reports'],
            ['name' => 'Gerenciar Configurações', 'slug' => 'manage-settings'],
            ['name' => 'Gerenciar Redes Sociais', 'slug' => 'manage-social'],
            ['name' => 'Administrador Completo', 'slug' => 'full-admin'],
        ];
        
        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
        
        // Atribuir todas as permissões ao primeiro usuário admin
        $admin = User::first();
        if ($admin) {
            $admin->permissions()->sync(Permission::pluck('id'));
        }
    }
}
