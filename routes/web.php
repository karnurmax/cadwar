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

    if (filter_var(env('ALLOWED_TO_REGISTER'), FILTER_VALIDATE_BOOLEAN)) {
        Route::post('register', 'AuthController@register');
    }

    Route::get('code', 'AuthController@code');
    Route::post('login', 'AuthController@login');
    Route::post('reset', 'AuthController@reset');
});

Route::get('/artisan/migraterefresh', 'ArtisanController@MigrateRefresh');

// $allowedToRegister = filter_var(env('ALLOWED_TO_REGISTER'), FILTER_VALIDATE_BOOLEAN);
// if ($allowedToRegister) {
//     Auth::routes();
// } else {
//     Auth::routes(['register' => false]);
// }

Route::get('/home', 'HomeController@index')->name('home');

Route::prefix('test')->group(function () {
    Route::get('mail', function () {
        try {
            $headers = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
            mail('karnurmax@mail.ru', 'test subject', '<h1>EEE</H1>', $headers);
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
        return "OK";
    });
});
