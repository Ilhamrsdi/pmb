<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\GrafikController;
use App\Http\Controllers\Pendaftar\KelengkapanDataController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('region/{id}', [KelengkapanDataController::class, 'region'])->name('region');
Route::get('grafik/setahun', [GrafikController::class, 'grafik_setahun'])->name('grafik-setahun');
Route::get('grafik/sebulan', [GrafikController::class, 'grafik_sebulan'])->name('grafik-sebulan');
