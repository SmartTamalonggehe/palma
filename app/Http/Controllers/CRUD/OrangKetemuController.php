<?php

namespace App\Http\Controllers\CRUD;

use App\Models\OrangKetemu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Perkembangan;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;

class OrangKetemuController extends Controller
{
    protected function spartaValidation($request, $id = "")
    {
        $required = "";
        if ($id == "") {
            $required = "required";
        }
        $rules = [
            'orang_hilang_id' => 'required',
        ];

        $messages = [
            'orang_hilang_id.required' => 'Orang hilang harus diisi.',
        ];
        $validator = Validator::make($request, $rules, $messages);

        if ($validator->fails()) {
            $pesan = [
                'judul' => 'Gagal',
                'type' => 'error',
                'pesan' => $validator->errors()->first(),
            ];
            return response()->json($pesan, 400);
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $limit = $request->limit;
        $search = $request->search;
        $data = OrangKetemu::with(['orangHilang' => function ($orangHilang) {
            $orangHilang->with('pelapor', 'laporan');
        }])
            ->whereHas('orangHilang', function (Builder $query) use ($search) {
                $query->where('nama', 'like', "%$search%");
            })
            ->paginate($limit);
        return response()->json($data, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data_req = $request->all();
        // return $data_req;
        $validate = $this->spartaValidation($data_req);
        if ($validate) {
            return $validate;
        }
        OrangKetemu::create($data_req);

        $data = OrangKetemu::with(['orangHilang' => function ($orangHilang) {
            $orangHilang->with('pelapor', 'laporan');
        }])->latest()->first();
        // isi panggil perkembangan
        Perkembangan::create([
            'laporan_id' => $data->orangHilang->laporan->id,
            'tgl' => $data->created_at,
            'detail' => "Ditemukan di daerah {$data_req['alamat_ketemu']} oleh {$data_req['nm_penemu']}",
        ]);

        $pesan = [
            'judul' => 'Berhasil',
            'type' => 'success',
            'pesan' => 'Data berhasil ditambahkan.',
            'data' => $data,
        ];
        return response()->json($pesan, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = OrangKetemu::findOrFail($id);
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data_req = $request->all();
        // return $data_req;
        $validate = $this->spartaValidation($data_req, $id);
        if ($validate) {
            return $validate;
        }
        // find data by id
        OrangKetemu::find($id)->update($data_req);

        $data = OrangKetemu::with(['orangHilang' => function ($orangHilang) {
            $orangHilang->with('distrik', 'pelapor');
        }])->find($id);
        $pesan = [
            'judul' => 'Berhasil',
            'type' => 'success',
            'pesan' => 'Data berhasil diperbaharui.',
            'data' => $data,
        ];
        return response()->json($pesan, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = OrangKetemu::findOrFail($id);
        // delete data
        $data->delete();
        $pesan = [
            'judul' => 'Berhasil',
            'type' => 'success',
            'pesan' => 'Data berhasil dihapus.',
            'data' => $data,
        ];
        return response()->json($pesan, 200);
    }
}
