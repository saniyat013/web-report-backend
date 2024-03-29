<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            DivisionsSeeder::class,
            DistrictsSeeder::class,
            UnitsSeeder::class,
            ReportsSeeder::class,
            RolesSeeder::class,
            UsersSeeder::class
        ]);
    }
}
