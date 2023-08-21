<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('roles')->insert([
            'display_name' => 'Administrator',
            'description' => 'super user',
            'created_at' => now()
        ]);
        DB::table('roles')->insert([
            'display_name' => 'User',
            'description' => 'can add expenses',
            'created_at' => now()
        ]);
    }
}
