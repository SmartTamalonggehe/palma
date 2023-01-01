<?php

namespace App\Http\Controllers\CRUD;

use App\Models\OrangHilang;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\TOOLS\ImgController;

class OrangHilangController extends Controller
{
    public $imgController;

    public function __construct()
    {
        // memanggil controller image
        $this->imgController = new ImgController();
    }

    protected function spartaValidation($request, $id = "")
    {
        $required = "";
        if ($id == "") {
            $required = "required";
        }
        $rules = [
            'nama' => 'required',
            'foto' => $required . '|mimes:jpeg,jpg,png,gif|max:2048',
        ];

        $messages = [
            'nama.required' => 'Nama Orang hilang harus diisi.',
            'foto.required' => 'Gambar harus diisi.',
            'foto.mimes' => 'Format gambar harus jpg, png, gif atau jpeg.',
            'foto.max' => 'Ukuran gambar maksimal 2MB.',
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
        $data = OrangHilang::with('pelapor', 'lokasi')->where('nama', "like", "%$search%")
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
        // export foto
        if ($request->hasFile('foto')) {
            $foto = $this->imgController->addImage('foto', $data_req['foto']);
            $data_req['foto'] = "storage/$foto";
        } else {
            $data_req['foto'] = "storage/default.png";
        }
        $data_req['status'] = 'diproses';

        OrangHilang::create($data_req);

        $data = OrangHilang::with('pelapor', 'lokasi')->latest()->first();
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
        $data = OrangHilang::with('pelapor', 'lokasi')
            ->where('pelapor_id', $id)
            ->where('nama', "like", "%$search%")
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
        $data = OrangHilang::findOrFail($id);
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
        OrangHilang::find($id)->update($data_req);

        $data = OrangHilang::find($id);
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
        $data = OrangHilang::findOrFail($id);
        // find file foto
        $foto = $data->foto;
        // remove file foto
        if ($foto !== 'storage/default.png') {
            File::delete($foto);
        }
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
