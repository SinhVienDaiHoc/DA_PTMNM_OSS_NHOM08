<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('products')->insert([
            [
                'name'  => 'Cupcake',
                'price' => 100000,
                'image_cover' => '/images/BanhNgot/3.jpg',
                'stock' => 10,
                'reward_point' => 50,
                'description' => 'Bánh ngọt ngon',
                'ADMIN_id_Admin' => 1,
                'CATEGORY_id_Category'=>2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'  => 'Croissant',
                'price' => 100000,
                'image_cover' => '/images/BanhNgot/4.jpg',
                'stock' => 10,
                'reward_point' => 60,
                'description' => 'Bánh ngọt Pháp',
                'ADMIN_id_Admin' => 1,
                'CATEGORY_id_Category'=>2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'  => 'Tiramisu',
                'price' => 100000,
                'image_cover' => '/images/BanhNgot/5.jpg',
                'stock'=>10,
                'description'=>'Bánh Ý',
                'reward_point'=>99,
                'ADMIN_id_Admin' => 1,
                'CATEGORY_id_Category'=>2,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // BÁNH KEM
            [
                'name'  => 'Bento cake',
                'price' => 100000,
                'stock'=>10,
                'description'=>'Bánh kem mini',
                'image_cover' => '/images/BanhKem/-1.jpg',
                'reward_point'=>100,
                'ADMIN_id_Admin' => 1,
                'CATEGORY_id_Category'=>2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'  => 'Strawberry cake',
                'price' => 100000,
                'stock'=>10,
                'description'=>'Bánh kem dâu',
                'image_cover' => '/images/BanhKem/-2.jpg',
                'reward_point'=>101,
                'ADMIN_id_Admin' => 1,
                'CATEGORY_id_Category'=>2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
