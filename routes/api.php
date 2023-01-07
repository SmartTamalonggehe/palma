<?php

use App\Http\Controllers\API\LaporanAPI;
use App\Http\Controllers\API\OrangHilangAPI;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::prefix('laporan')->group(function () {
    Route::get('/', [LaporanAPI::class, 'index'])->name('laporan.api.index');
    Route::get('tahun', [LaporanAPI::class, 'tahun'])->name('laporan.api.tahun');
});

Route::prefix('orang-hilang')->group(function () {
    $nm = 'orang-hilang';
    Route::get('/', [OrangHilangAPI::class, 'index'])->name("$nm.index");
    Route::get('/tahunan', [OrangHilangAPI::class, 'tahunan'])->name("$nm.tahunan");
});
