<?php

use App\Http\Controllers\PDF\LapOrangHilangController;
use Illuminate\Support\Facades\Route;

Route::prefix('pdf')->group(function () {
    Route::prefix('laporan')->group(function () {
        $nm = 'lap-pdf';
        Route::get('orang-hilang/{id}', [LapOrangHilangController::class, 'show'])->name("$nm-orang-hilang");
    });
});
