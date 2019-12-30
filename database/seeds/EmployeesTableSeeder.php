<?php

use Illuminate\Database\Seeder;

class EmployeesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('employees')->insert([
            [
                'name' => Str::random(10),
                'iin' => '123123123123',
                'evaluation' => 'отлично',
                'base_id' => 1,
            ],
            [
                'name' => Str::random(10),
                'iin' => '123123123121',
                'evaluation' => 'отлично',
                'base_id' => 1,
            ],
        ]
        );
    }
}
