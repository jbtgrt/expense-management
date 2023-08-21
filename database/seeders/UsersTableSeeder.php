<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('users')->insert([
            'role_id' => 1,
            'image' => 'images/avatars/admin-image.jpg',
            'name' => 'Ad Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('Admin123#'),
            'created_at' => now()
        ]);
        DB::table('users')->insert([
            'role_id' => 2,
            'image' => 'images/avatars/admin-image.jpg',
            'name' => 'Ue User',
            'email' => 'user@gmail.com',
            'password' => bcrypt('User123#'),
            'created_at' => now()
        ]);
    }
}
