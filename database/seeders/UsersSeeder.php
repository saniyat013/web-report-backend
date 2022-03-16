<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(array(
            array(
                'name' => 'Saniyat Al Ahmed',
                'division' => '1',
                'district' => '1',
                'unit' => '1',
                'mobile' => '01685808426',
                'email' => 'saniyat013@gmail.com',
                'password' => '1234',
            ),
        ));
    }
}
