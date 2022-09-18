<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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
                'role' => '1',
                'verified' => true,
                'name' => 'Saniyat Al Ahmed',
                'division' => '1',
                'district' => '1',
                'unit' => '1',
                'mobile' => '01685808426',
                'email' => 'saniyat@gmail.com',
                'password' => '1234',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ),
        ));
    }
}
