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
            'members' => 5,
            ]
        );
    }
}
