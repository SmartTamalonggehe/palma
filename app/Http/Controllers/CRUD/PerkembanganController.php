<?php

namespace App\Http\Controllers\CRUD;

use App\Models\Perkembangan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PerkembanganController extends Controller
{
    protected function spartaValidation($request, $id = "")
    {
        // $required = "";
        // if ($id == "") {
        //     $required = "required";
        // }
        // $rules = [
        //     'nama' => 'required',
        //     'foto' => $required . '|mimes:jpeg,jpg,png,gif|max:2048',
        //     'tgl_hilang' => 'required',
        // ];

        // $messages = [
        //     'nama.required' => 'Nama Orang hilang harus diisi.',
        //     'foto.required' => 'Gambar harus diisi.',
        //     'foto.mimes' => 'Format gambar harus jpg, png, gif atau jpeg.',
        //     'foto.max' => 'Ukuran gambar maksimal 2MB.',
        //     'tgl_hilang.required' => 'Tanggal kejadian harus diisi.',
        // ];
        // $validator = Validator::make($request, $rules, $messages);

        // if ($validator->fails()) {
        //     $pesan = [
        //         'judul' => 'Gagal',
        //         'type' => 'error',
        //         'pesan' => $validator->errors()->first(),
        //     ];
        //     return response()->json($pesan, 400);
        // }
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
        $data = Perkembangan::with(['laporan' => function ($laporan) {
            $laporan->with('orangHilang');
        }])->paginate($limit);
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

        Perkembangan::create($data_req);

        $data = Perkembangan::with(['laporan' => function ($laporan) {
            $laporan->with('orangHilang');
        }])->latest()->first();
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
    public function show($id, Request $request)
    {
        $limit = $request->limit;
        $search = $request->search;
        $data = Perkembangan::with(['laporan' => function ($laporan) {
            $laporan->with('orangHilang');
        }])
            ->paginate($limit);
        return response()->json($data, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Perkembangan::findOrFail($id);
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
        Perkembangan::find($id)->update($data_req);

        $data = Perkembangan::find($id);
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
        $data = Perkembangan::findOrFail($id);
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
