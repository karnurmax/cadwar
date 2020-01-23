<?php

use Illuminate\Database\Seeder;

class EmployeeStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('employee_statuses')->insert([
            [
                'name' => "работает",
            ],
            [
                'name' => "не работает",
            ],
        ]);
    }
}
