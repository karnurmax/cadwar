<?php

use Illuminate\Database\Seeder;

class CitizenshipsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('citizenships')->insert([
            [
                'name' => "казах",
            ],
            [
                'name' => "руский",
            ],
            [
                'name' => "американец",
            ],
        ]
        );
    }
}
