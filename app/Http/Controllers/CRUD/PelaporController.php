<?php

namespace App\Http\Controllers\CRUD;

use App\Models\Pelapor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class PelaporController extends Controller
{
    protected function spartaValidation($request, $id = "")
    {
        $required = "";
        if ($id == "") {
            $required = "required";
        }
        $rules = [
            'nama' => 'required',
        ];

        $messages = [
            'nama.required' => 'Nama Pelapor harus diisi.',
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
        $data = Pelapor::with('distrik')->where('nama', "like", "%$search%")
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
        // export foto ktp
        $foto_ktp = $data_req['foto_ktp'];
        // set name image and get extension
        $foto_ktp_name = time() . '.' . $foto_ktp->getClientOriginalExtension();
        // destination path
        $destinationPath = Storage::putFileAs('foto_ktp', $foto_ktp, $foto_ktp_name);
        $data_req['foto_ktp'] = "storage/$destinationPath";

        // export foto kk
        $foto_kk = $data_req['foto_kk'];
        // set name image and get extension
        $foto_kk_name = time() . '.' . $foto_kk->getClientOriginalExtension();
        // destination path
        $destinationPath = Storage::putFileAs('foto_kk', $foto_kk, $foto_kk_name);
        $data_req['foto_kk'] = "storage/$destinationPath";

        Pelapor::create($data_req);

        $data = Pelapor::with('distrik')->latest()->first();
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
        $data = Pelapor::findOrFail($id);
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
        Pelapor::find($id)->update($data_req);

        $data = Pelapor::find($id);
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
        $data = Pelapor::findOrFail($id);
        // delete file foto_ktp
        $foto_ktp = $data->foto_ktp;
        // remove file foto_ktp
        if ($foto_ktp !== 'storage/default.png') {
            File::delete($foto_ktp);
        }
        // delete file foto_kk
        $foto_kk = $data->foto_kk;
        // remove file foto_kk
        if ($foto_kk !== 'storage/default.png') {
            File::delete($foto_kk);
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
