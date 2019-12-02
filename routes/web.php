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

Route::prefix('auth')->group(function () {
    Route::post('register', 'AuthController@register');
    Route::get('code', 'AuthController@code');
    Route::post('login', 'AuthController@login');
    Route::post('reset', 'AuthController@reset');
});

Route::get('/artisan/migraterefresh', 'ArtisanController@MigrateRefresh');

$allowedToRegister = true; //TODO: env (allowedToRegister)
if ($allowedToRegister) {
    Auth::routes();
} else {
    Auth::routes(['register' => false]);
}

Route::get('/home', 'HomeController@index')->name('home');

Route::prefix('test')->group(function () {
    Route::get('mail', function () {
        try {
            mail('karnurmax@mail.ru', 'test subject', 'test body');
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
        return "OK";
    });
});
