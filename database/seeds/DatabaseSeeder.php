<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

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
            BasesTableSeeder::class,
            CitizenshipsTableSeeder::class,
            EmployeeStatusTableSeeder::class,
            PositionsTableSeeder::class,
            EmployeesTableSeeder::class,
        ]);
    }
}
