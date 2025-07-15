<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Client;

class ClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clients = [
            [
                'name' => 'Ana Carolina Silva',
                'email' => 'ana.silva@email.com',
                'phone' => '11999998888',
                'address' => 'Rua das Acácias, 100 - São Paulo/SP',
                'cpf' => '12345678901',
                'birth_date' => '1985-05-15',
                'purchases_count' => 5,
                'total_spent' => 1250.50,
                'last_purchase' => '2023-06-10'
            ],
            [
                'name' => 'Carlos Eduardo Oliveira',
                'email' => 'carlos.oliveira@email.com',
                'phone' => '11988887777',
                'address' => 'Av. Paulista, 2000 - São Paulo/SP',
                'cpf' => '98765432109',
                'birth_date' => '1990-08-22',
                'purchases_count' => 3,
                'total_spent' => 750.20,
                'last_purchase' => '2023-05-28'
            ],
            [
                'name' => 'Mariana Santos',
                'email' => 'mariana.santos@email.com',
                'phone' => '11977776666',
                'address' => 'Rua dos Pinheiros, 300 - São Paulo/SP',
                'cpf' => '45678912304',
                'birth_date' => '1992-11-30',
                'purchases_count' => 8,
                'total_spent' => 2100.75,
                'last_purchase' => '2023-06-15'
            ]
        ];

        foreach ($clients as $client) {
            Client::create($client);
        }
    }
}
