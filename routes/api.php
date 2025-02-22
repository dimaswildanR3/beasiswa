<?php

use App\Http\Controllers\SiswaController;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/siswa', [SiswaController::class, 'getSiswa']);
Route::get('/getsiswa', [SiswaController::class, 'getSiswa1']);
Route::get('/getsiswaid', [SiswaController::class, 'getSiswaid']);
Route::get('/getkelas', [SiswaController::class, 'getKelas']);
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// routes/web.php
