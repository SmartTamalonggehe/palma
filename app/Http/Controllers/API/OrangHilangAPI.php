<?php

namespace App\Http\Controllers\API;

use App\Models\OrangHilang;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrangHilangAPI extends Controller
{
    public function index()
    {
        $data = OrangHilang::with(['pelapor' => function ($pelapor) {
            $pelapor->with('user');
        }])->with('lokasi')
            ->where('status', 'diterima')
            ->doesntHave('orangKetemu')
            ->get();
        return response()->json($data, 200);
    }
    public function tahunan(Request $request)
    {
        $tahun = $request->tahun;
        $data = OrangHilang::with(['pelapor' => function ($pelapor) {
            $pelapor->with('user');
        }])->with('lokasi')
            ->where('status', 'diterima')
            ->doesntHave('orangKetemu')
            ->whereYear('tgl_hilang', $tahun)
            ->get();
        return response()->json($data, 200);
    }
}
