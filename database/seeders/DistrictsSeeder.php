<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DistrictsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('districts')->insert(array(
            array(
                'id' => 2,
                'name' => 'Dhaka',
                'division_id' => 1
            ),
            array(
                'id' => 2,
                'name' => 'Gazipur',
                'division_id' => 1
            ),
            array(
                'id' => 2,
                'name' => 'Manikganj',
                'division_id' => 1
            ),
            array(
                'id' => 2,
                'name' => 'Shariatpur',
                'division_id' => 2
            ),
            array(
                'id' => 2,
                'name' => 'Faridpur',
                'division_id' => 2
            ),
            array(
                'id' => 2,
                'name' => 'Naraynganj',
                'division_id' => 2
            ),
        ));
    }
}
