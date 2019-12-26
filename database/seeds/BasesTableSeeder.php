<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;


class BasesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('bases')->insert(
            [
            'name' => Str::random(10),
            'address' => Str::random(15).' street 11',
            'members' => 5,
            'start_date' => Carbon::parse('2000-01-01'),
            'end_date' => Carbon::parse('2010-01-01')
            ]
        );
    }
}
