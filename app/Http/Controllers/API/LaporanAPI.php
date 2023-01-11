<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use Illuminate\Http\Request;

class LaporanAPI extends Controller
{
    public function index()
    {
        $data = Laporan::with('orangHilang')->get();
        return response()->json($data);
    }

    public function tahun(Request $request)
    {
        $tahun = $request->tahun;
        $data = Laporan::whereYear('tgl_laporan', $tahun)->get();
        return response()->json($data);
    }
}
