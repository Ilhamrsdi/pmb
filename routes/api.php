<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\GrafikController;
use App\Http\Controllers\Pendaftar\KelengkapanDataController;
use App\Helpers\BniHelper;

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

// Route::get('region/{id}', [KelengkapanDataController::class, 'region'])->name('region');
Route::get('grafik/setahun', [GrafikController::class, 'grafik_setahun'])->name('grafik-setahun');
Route::get('grafik/sebulan', [GrafikController::class, 'grafik_sebulan'])->name('grafik-sebulan');
// Route::get('region/{id}', [KelengkapanDataController::class, 'region'])->name('region');
Route::get('get-provinsi', [KelengkapanDataController::class, 'region'])->name('get-provinsi');
// Route::get('/get-kabupaten/{provinsiId}', [KelengkapanDataController::class, 'getKabupaten']);
Route::get('/get-kabupaten/{provinsiId}', [KelengkapanDataController::class, 'getKabupaten']);
Route::post('/test-bni', function (Request $request) {
    try {
        $bniHelper = new BniHelper();

        // Ambil data dari body request
        $data = $request->validate([
            'type' => 'required|string',
            'trx_id' => 'required|string',
            'trx_amount' => 'required|numeric',
            'datetime_expired' => 'required|date',
            'virtual_account' => 'required|string',
            'detail_tagihan' => 'required|array',
            'detail_tagihan.*.description' => 'required|string',
            'detail_tagihan.*.amount' => 'required|numeric',
        ]);

        // Panggil fungsi getContent dari BniHelper
        $response = $bniHelper->getContent($data);

        // Return hasil ke Postman
        return response()->json([
            'success' => true,
            'response' => $response,
        ]);
    } catch (Exception $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage(),
        ], 500); // Status 500 untuk error server
    }
});

