<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'gulbanu',
                'email' => 'karnurmax@mail.ru',
                'password' => Hash::make('1'),
            ],
            [
                'name' => 'gulbanu',
                'email' => 'gulbanu.amandykova@kaspims.kz',
                'password' => Hash::make('aAwd3%dg6J3_8h'),
            ],
            [
                'name' => 'altynbek',
                'email' => 'k.altynbek@kaspims.kz',
                'password' => Hash::make('Frh5@#swvB'),
            ],
            [
                'name' => 'nurzhan',
                'email' => 'nurzhan.shabayev@kaspims.kz',
                'password' => Hash::make('#dcceG4drB_'),
            ],
        ]);
    }
}
