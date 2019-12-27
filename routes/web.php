<?php
use App\Http\Middleware\CrudWhiteList;
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

    Route::get('code/{code}', 'AuthController@code');
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

Route::middleware(['CrudWhiteList'])->group(function () {
    Route::get('/', function () {
        // Uses first & second Middleware
    });

    Route::get('user/profile', function () {
        // Uses first & second Middleware
    });
});
Route::prefix('crud/{tableName}')->group(['middleware' => ['CrudWhiteList']],
    function ($tableName) {

        Route::get('{id}', function () {
            return ['id=>1', 'name' => 'name'];
        });
        Route::get('', function () {
            return [['id=>1', 'name' => 'name']];
        });
        Route::post('/', function () {
            return 123;
        });

        Route::put('/', function () {
            return 'put';
        });
        Route::delete('/', function () {
            return 'delete';
        });
    });

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
