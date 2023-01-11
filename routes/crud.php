<?php

use App\Http\Controllers\CRUD\DistrikController;
use App\Http\Controllers\CRUD\LaporanController;
use App\Http\Controllers\CRUD\LokasiController;
use App\Http\Controllers\CRUD\OrangHilangController;
use App\Http\Controllers\CRUD\OrangKetemuController;
use App\Http\Controllers\CRUD\PelaporController;
use App\Http\Controllers\CRUD\PerkembanganController;
use Illuminate\Support\Facades\Route;

Route::resources([
    'distrik' => DistrikController::class,
    'pelapor' => PelaporController::class,
    'orang-hilang' => OrangHilangController::class,
    'lokasi' => LokasiController::class,
    'laporan' => LaporanController::class,
    'orang-ketemu' => OrangKetemuController::class,
    'perkembangan' => PerkembanganController::class,
]);

Route::post('pelapor/ubah-status/{id}', [PelaporController::class, 'ubahStatus']);
Route::post('orang-hilang/ubah-status/{id}', [OrangHilangController::class, 'ubahStatus']);
// Route::get('pelapor/ubah-status/{id}', [PelaporController::class, 'ubahStatus']);
