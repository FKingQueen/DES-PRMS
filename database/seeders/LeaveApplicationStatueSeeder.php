<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LeaveApplicationStatueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('leave_application_statuses')->insert([
            'status' => 'Pending',
        ]);
        DB::table('leave_application_statuses')->insert([
            'status' => 'Accepted',
        ]);
        DB::table('leave_application_statuses')->insert([
            'status' => 'Rejected',
        ]);
    }
}
