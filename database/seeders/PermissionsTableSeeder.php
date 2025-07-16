<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {

        // Desativar verificação de chaves estrangeiras temporariamente
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        
        // Limpar a tabela de permissões e a pivot
        DB::table('permission_user')->truncate();

        // Reativar verificação de chaves estrangeiras
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // Permission::truncate();

        $permissions = [
            [
                'name' => 'Gerenciar Produtos',
                'slug' => 'manage-products',
                'description' => 'Permite gerenciar produtos, estoque e categorias'
            ],
            [
                'name' => 'Gerenciar Vendas',
                'slug' => 'manage-sales',
                'description' => 'Permite registrar e gerenciar vendas'
            ],
            [
                'name' => 'Gerenciar Clientes',
                'slug' => 'manage-clients',
                'description' => 'Permite gerenciar cadastro de clientes'
            ],
            [
                'name' => 'Gerenciar Fornecedores',
                'slug' => 'manage-suppliers',
                'description' => 'Permite gerenciar cadastro de fornecedores'
            ],
            [
                'name' => 'Visualizar Relatórios',
                'slug' => 'view-reports',
                'description' => 'Permite visualizar relatórios de vendas e estoque'
            ],
            [
                'name' => 'Gerenciar Configurações',
                'slug' => 'manage-settings',
                'description' => 'Permite alterar configurações do sistema'
            ],
            [
                'name' => 'Gerenciar Redes Sociais',
                'slug' => 'manage-social',
                'description' => 'Permite gerenciar posts em redes sociais'
            ],
            [
                'name' => 'Visualizar Logs de Atividade',
                'slug' => 'view-activity-logs',
                'description' => 'Permite visualizar o histórico de alterações no sistema'
            ],
            [
                'name' => 'Acesso Total',
                'slug' => 'full-admin',
                'description' => 'Acesso completo a todas as funcionalidades'
            ]
        ];
        
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['slug' => $permission['slug']],
                $permission
            );
        }

        // Atribuir todas as permissões ao primeiro usuário admin
        $admin = User::first();
        if ($admin) {
            $admin->permissions()->sync(Permission::pluck('id'));
        }
    }
}
