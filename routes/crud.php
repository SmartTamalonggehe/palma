<?php

use App\Http\Controllers\CRUD\DistrikController;
use App\Http\Controllers\CRUD\LaporanController;
use App\Http\Controllers\CRUD\LokasiController;
use App\Http\Controllers\CRUD\OrangHilangController;
use App\Http\Controllers\CRUD\OrangKetemuController;
use App\Http\Controllers\CRUD\PelaporController;
use Illuminate\Support\Facades\Route;

Route::resources([
    'distrik' => DistrikController::class,
    'pelapor' => PelaporController::class,
    'orang-hilang' => OrangHilangController::class,
    'lokasi' => LokasiController::class,
    'laporan' => LaporanController::class,
    'orang-ketemu' => OrangKetemuController::class,
]);
