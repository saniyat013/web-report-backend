<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert(array(
            array(
                'id' => '1',
                'role_name' => 'admin',
            ),
            array(
                'id' => '2',
                'role_name' => 'division_admin',
            ),
            array(
                'id' => '3',
                'role_name' => 'unit_admin',
            ),
        ));
    }
}
