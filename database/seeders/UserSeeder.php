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
            'employeeNumber' => '11111',
            'emailAddress' => 'admin@gmail.com',
            'password' => Hash::make('123456789'),
        ]);
        DB::table('users')->insert([
            'role_id' => '2',
            'name' => 'Personnel',
            'employeeNumber' => '22222',
            'emailAddress' => 'personnel@gmail.com',
            'password' => Hash::make('123456789'),
        ]);
    }
}
