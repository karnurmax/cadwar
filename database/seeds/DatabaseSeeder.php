<?php

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
        // $this->call(UsersTableSeeder::class);
        $this->call([
            UsersTableSeeder::class,
            // BasesTableSeeder::class,
            // CitizenshipsTableSeeder::class,
            EmployeeStatusTableSeeder::class,
            // PositionsTableSeeder::class,
            // EmployeesTableSeeder::class,
        ]);
    }
}
