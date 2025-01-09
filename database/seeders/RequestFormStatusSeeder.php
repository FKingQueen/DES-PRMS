<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RequestFormStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('request_form_statuses')->insert([
            'status' => 'Received',
        ]);
        DB::table('request_form_statuses')->insert([
            'status' => 'Processing',
        ]);
        DB::table('request_form_statuses')->insert([
            'status' => 'Released',
        ]);
    }
}
