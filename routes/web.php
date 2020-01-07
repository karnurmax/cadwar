<?php
use \Illuminate\Http\Request;
use \Illuminate\Routing\Router;
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
    Route::prefix('crud/{tableName}')->group(function (Router $router) {

        Route::get('{id}', function ($id) {
            return ['id=>1', 'name' => 'name'];
        });
        Route::get('', function () {
            $r = Route::current();
            $table = $r->parameters["tableName"];
            return DB::table($table)->get();
        });
        Route::post('/', function (Request $request, $table) {
            $data = $request->all();
            $r = Route::current();
            $table = $r->parameters["tableName"];
            $insertedId = DB::table($table)->insertGetId(
                $data
            );
            $insertedItem = DB::table($table)->where('id', $insertedId)->first();
            return response()->json($insertedItem);
        });

        Route::put('/', function (Request $request, $table) {
            $data = $request->all();
            $r = Route::current();
            $id = $data["id"];
            $table = $r->parameters["tableName"];

            DB::table($table)
                ->where('id', $id)
                ->update($data);
            $updatedItem = DB::table($table)->where('id', $id)->first();
            return response()->json($updatedItem);
        });
        Route::delete('{id}', function (Request $request, $table, $id) {
            DB::table($table)->where('id', $id)->delete();
            return response($id, 200);
        });
    });
});

Route::prefix('employees')->group(function () {
    Route::get('get/with-files', 'EmployeesController@getWithFiles');
    Route::get('files/download/{id}', 'EmployeesController@downloadFile');
    Route::post('files/remove/{id}', 'EmployeesController@removeFile');
    Route::post('{id}/files/upload', 'EmployeesController@upload');
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
    Route::get('emp', 'EmployeesController@getWithFiles');
});
