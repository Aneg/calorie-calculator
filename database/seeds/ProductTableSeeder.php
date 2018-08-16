<?php

use Illuminate\Database\Seeder;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = DB::table('users')->select(['id'])->first();
        DB::table('products')->insert([
            'user_id' => $user->id,
            'name' => 'Гречка',
            'protein' => 'guest@gmail.com',
            'fat' => bcrypt('password'),
            'carbohydrate' => 'KOPxSTlopKbfJjpgjtj6dxcKyXzjSGCnXC4GfNHB3bi8f0RCqjrOJeuEBdHR',
            'calories' => 'KOPxSTlopKbfJjpgjtj6dxcKyXzjSGCnXC4GfNHB3bi8f0RCqjrOJeuEBdHR',
        ]);
    }
}

