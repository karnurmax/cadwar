<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/', function () {
    return view('home');
});

Route::get('/artisan/migraterefresh', 'ArtisanController@MigrateRefresh');

$allowedToRegister = true; //TODO: env (allowedToRegister)
if ($allowedToRegister) {
    Auth::routes();
} else {
    Auth::routes(['register' => false]);
}

Route::get('/home', 'HomeController@index')->name('home');
