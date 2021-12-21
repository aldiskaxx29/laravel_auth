<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Redis;

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
    return view('welcome');
});

Route::get('/login', [App\Http\Controllers\AuthController::class, 'index']);
Route::post('/loginPost', [App\Http\Controllers\AuthController::class, 'loginPost']);
Route::get('/regist', [App\Http\Controllers\AuthController::class, 'regist']);
Route::post('registPost', [App\Http\Controllers\AuthController::class, 'registPost']);
Route::get('/lupapassword', [App\Http\Controllers\AuthController::class, 'lupaPassword']);
Route::get('passwordbaru', [App\Http\Controllers\AuthController::class, 'passwordBaru']);
Route::post('lupaPasswordPost', [App\Http\Controllers\AuthController::class, 'lupaPasswordPost']);
Route::get('/logout', [App\Http\Controllers\AuthController::class, 'logout']);

Route::get('/aktivasiAkun/{token}', [App\Http\Controllers\AuthController::class, 'aktivasiAkun']);
Route::get('/ubahPassword/{id}/{token}', [App\Http\Controllers\AuthController::class, 'ubahPassword']);

Route::post('ubah-password/{id}', [App\Http\Controllers\AuthController::class, 'updatePassword']);



Route::get('/redis', function () {
    $p = Redis::incr('p');
    return $p;
});