<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            PermissionsTableSeeder::class,
            CompanySeeder::class,
            CategoriesTableSeeder::class,
            SuppliersTableSeeder::class,
            ProductsTableSeeder::class,
            ClientsTableSeeder::class,
            UsersTableSeeder::class,
            SalesTableSeeder::class,
            SocialMediaPostsSeeder::class,
        ]);


        // // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
