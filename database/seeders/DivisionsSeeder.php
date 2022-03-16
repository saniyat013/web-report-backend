<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DivisionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('divisions')->insert(array(
            array(
                // 'id' => 2,
                'name' => 'Dhaka'
            ),
            array(
                // 'id' => 3,
                'name' => 'Dhaka City'
            ),
            array(
                // 'id' => 1,
                'name' => 'Rajshahi'
            ),
            array(
                // 'id' => 4,
                'name' => 'Sylhet'
            ),
            array(
                // 'id' => 5,
                'name' => 'Khulna'
            ),
            array(
                // 'id' => 6,
                'name' => 'Rangpur'
            ),
            array(
                // 'id' => 7,
                'name' => 'Barisal'
            ),
            array(
                // 'id' => 8,
                'name' => 'Chattogram'
            ),
            array(
                // 'id' => 9,
                'name' => 'Mymensingh'
            )
        ));
    }
}
