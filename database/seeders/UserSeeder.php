<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'role_id' => '1',
            'name' => 'Super Admin',
            'username' => 'SuperAdmin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123456789'),
        ]);
        DB::table('users')->insert([
            'role_id' => '2',
            'name' => 'Editor',
            'username' => 'Editor',
            'email' => 'personnel@gmail.com',
            'password' => Hash::make('123456789'),
        ]);
    }
}
