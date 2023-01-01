<?php

namespace App\Http\Controllers\CRUD;

use App\Models\User;
use App\Models\Pelapor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\EMAIL\PelaporNotifController;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\TOOLS\ImgController;

class PelaporController extends Controller
{
    public $imgController;
    public $email;

    public function __construct()
    {
        // memanggil controller image
        $this->imgController = new ImgController();
        $this->email = new PelaporNotifController();
    }

    protected function spartaValidation($request, $id = "")
    {
        $required = "";
        if ($id == "") {
            $required = "required";
        }
        $rules = [
            'nama' => 'required',
            'email' => 'required|unique:users',
            'no_ktp' => 'required|unique:pelapor',
            'no_hp' => 'required|unique:pelapor',
            'foto_ktp' => $required . '|mimes:jpeg,jpg,png,gif|max:2048',
        ];

        $messages = [
            'nama.required' => 'Nama Pelapor harus diisi.',
            'email.unique' => 'Email sudah ada.',
            'no_ktp.unique' => 'No. KTP sudah ada.',
            'no_hp.unique' => 'No. HP sudah ada.',
            'foto_ktp.required' => 'Gambar harus diisi.',
            'foto_ktp.mimes' => 'Format gambar harus jpg, png, gif atau jpeg.',
            'foto_ktp.max' => 'Ukuran gambar maksimal 2MB.',
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
        $data = Pelapor::with('distrik', 'user')->where('nama', "like", "%$search%")
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
        $foto_ktp = $this->imgController->addImage('foto_ktp', $data_req['foto_ktp']);
        $data_req['foto_ktp'] = "storage/$foto_ktp";
        // export foto kk
        $foto_kk = $this->imgController->addImage('foto_kk', $data_req['foto_kk']);
        $data_req['foto_kk'] = "storage/$foto_kk";

        // create user
        $user = User::create([
            'name' => $data_req['nama'],
            'email' => $data_req['email'],
            'password' => Hash::make($data_req['password']),
            'show_password' => $data_req['password'],
        ]);
        unset($data_req['email']);
        unset($data_req['password']);

        $data_req['user_id'] = $user->id;
        $data_req['status'] = 'diproses';
        Pelapor::create($data_req);

        $data = Pelapor::with('distrik', 'user')->latest()->first();
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

    public function ubahStatus(Request $request, $id)
    {
        $data_req = $request->all();
        // find data by id
        Pelapor::find($id)->update($data_req);

        $data = Pelapor::with('distrik', 'user')->find($id);
        // ganti role
        $status = $data_req['status'];
        if ($status == 'diterima') {
            User::find($data->user->id)->update([
                'role' => 'pelapor'
            ]);
        } else {
            User::find($data->user->id)->update([
                'role' => null
            ]);
        }


        // return view('mail.pelapor-notif', compact('data'));

        $mail = $this->email->index($data);

        $pesan = [
            'judul' => 'Berhasil',
            'type' => 'success',
            'pesan' => "Status berhasil diubah dan $mail",
            'data' => $data,
        ];
        return response()->json($pesan, 200);
    }
}
