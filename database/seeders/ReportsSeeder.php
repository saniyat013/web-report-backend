<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('reports')->insert(array(
            array(
                'division_id' => '1',
                'district_id' => '2',
                'unit_id' => '5',
                'total_work' => '10',
                'total_id' => '15',
                'comment' => 'No Comments',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ),
            array(
                'division_id' => '1',
                'district_id' => '2',
                'unit_id' => '6',
                'total_work' => '10',
                'total_id' => '15',
                'comment' => 'No Comments',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ),
            array(
                'division_id' => '1',
                'district_id' => '1',
                'unit_id' => '1',
                'total_work' => '10',
                'total_id' => '15',
                'comment' => 'No Comments',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ),
        ));
    }
}
