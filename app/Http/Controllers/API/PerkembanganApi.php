<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Perkembangan;
use Illuminate\Http\Request;

class PerkembanganApi extends Controller
{
    public function index(Request $request)
    {
        $data = Perkembangan::with(['laporan' => function ($laporan) {
            $laporan->with('orangHilang');
        }])->orderBy('tgl', 'desc')->get();
        return response()->json($data, 200);
    }
}
