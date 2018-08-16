<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'test user',
            'email' => 'guest@gmail.com',
            'password' => bcrypt('password'),
            'api_token' => 'KOPxSTlopKbfJjpgjtj6dxcKyXzjSGCnXC4GfNHB3bi8f0RCqjrOJeuEBdHR',
        ]);
    }
}
