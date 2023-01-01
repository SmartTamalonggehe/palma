<?php

namespace App\Http\Controllers\PDF;

use App\Models\OrangHilang;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;


class LapOrangHilangController extends Controller
{
    public function show($id)
    {
        $data = OrangHilang::with('pelapor', 'lokasi')->findOrFail($id);
        // return $data;
        // return view('pdf.laporan.orang-hilang', compact('data'));
        $pdf = Pdf::loadView('pdf.laporan.orang-hilang', compact('data'));
        return $pdf->download('Laporan Orang Hilang.pdf');
    }
}
