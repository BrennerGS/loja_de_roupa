<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SocialMediaPost;

class SocialMediaPostsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts = [
            [
                'platform' => 'instagram',
                'post_type' => 'post',
                'status' => 'published',
                'publish_at' => now()->subDays(2),
                'caption' => 'Novas camisetas chegando na coleção verão! #moda #verão2023',
                'user_id' => 1
            ],
            [
                'platform' => 'facebook',
                'post_type' => 'post',
                'status' => 'scheduled',
                'publish_at' => now()->addDays(3),
                'caption' => 'Promoção especial deste fim de semana! Descontos de até 30%',
                'user_id' => 2
            ],
            [
                'platform' => 'instagram',
                'post_type' => 'reel',
                'status' => 'draft',
                'publish_at' => null,
                'caption' => 'Veja como nossos clientes estão usando nossas peças #estilopróprio',
                'user_id' => 3
            ]
        ];

        foreach ($posts as $post) {
            SocialMediaPost::create($post);
        }
    }
}
