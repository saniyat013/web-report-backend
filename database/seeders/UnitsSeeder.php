<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('units')->insert(array(
            array(
                'name' => 'Motijheel',
                'district_id' => 1
            ),
            array(
                'name' => 'Rampura',
                'district_id' => 1
            ),
            array(
                'name' => 'Uttara',
                'district_id' => 1
            ),
            array(
                'name' => 'Mirpur',
                'district_id' => 1
            ),
            array(
                'name' => 'Pirgacha',
                'district_id' => 2
            ),
            array(
                'name' => 'Tajhat',
                'district_id' => 2
            ),
            array(
                'name' => 'Shalbon',
                'district_id' => 2
            ),
        ));
    }
}
