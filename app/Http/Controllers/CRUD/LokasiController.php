<?php

namespace App\Http\Controllers\CRUD;

use App\Models\Lokasi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;

class LokasiController extends Controller
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
        $data = Lokasi::with(['orangHilang' => function ($orangHilang) {
            $orangHilang->with('pelapor');
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
        // cek apakah data sudah ada
        $orang_hilang = Lokasi::where('orang_hilang_id', $data_req['orang_hilang_id'])->first();

        if ($orang_hilang) {
            $orang_hilang->update($data_req);
        } else {
            Lokasi::create($data_req);
        }

        $data = Lokasi::with(['orangHilang' => function ($orangHilang) {
            $orangHilang->with('pelapor');
        }])->latest()->first();
        $pesan = [
            'judul' => 'Berhasil',
            'type' => 'success',
            'pesan' => 'Lokasi berhasil disimpan.',
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
        $data = Lokasi::findOrFail($id);
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
        Lokasi::find($id)->update($data_req);

        $data = Lokasi::with(['orangHilang' => function ($orangHilang) {
            $orangHilang->with('pelapor');
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
        $data = Lokasi::findOrFail($id);
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
