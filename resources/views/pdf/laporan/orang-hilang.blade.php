<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Orang Hilang</title>
    <link rel="stylesheet" href="{{ public_path('css/laporan.css') }}">
</head>

<body>
    <section class="container">
        <div class="kop">
            <h4 class="text-center">KEPOLISIAN NEGARA REPUBLIK INDONESIA</h4>
            <h4 class="text-center">KEPOLISAN RESOR (POLRES)</h4>
            <h4 class="text-center">KOTA JAYAPURA</h4>
            <p class="text-underline text-center">Jl. Ahmad Yani No. 11 Jayapura - Papua</p>
        </div>
        {{-- atas surat --}}
        <div class="head">
            <div class="text-center">
                <img src="{{ public_path('images/logo-polres.png') }}" alt="">
            </div>
            <h4 class="text-center">LAPORAN KETERANGAN ORANG HILANG</h4>
        </div>
        {{-- isi surat --}}
        <div class="isi-surat">
            {{-- foto --}}
            <div class="container-foto">
                <img class="img" src="{{ public_path($data->foto) }}">
            </div>
            {{-- ciri ciri --}}
            <div class="container-ciri">
                <span style="margin-left: -30px">Ciri-ciri:</span>
                <table>
                    <tr>
                        <td>
                            a.
                        </td>
                        <td>Tinggi badan</td>
                        <td>:</td>
                        <td>{{ $data->tinggi }}</td>
                    </tr>
                    <tr>
                        <td>
                            b.
                        </td>
                        <td>Berat badan</td>
                        <td>:</td>
                        <td>{{ $data->berat }}</td>
                    </tr>
                    <tr>
                        <td>
                            e.
                        </td>
                        <td>Warna Rambut</td>
                        <td>:</td>
                        <td>{{ $data->warna_rambut }}</td>
                    </tr>
                    <tr>
                        <td>
                            f.
                        </td>
                        <td>Jenis Rambut</td>
                        <td>:</td>
                        <td>{{ $data->jenis_rambut }}</td>
                    </tr>
                    <tr>
                        <td>
                            g.
                        </td>
                        <td>Warna Kulit</td>
                        <td>:</td>
                        <td>{{ $data->warna_kulit }}</td>
                    </tr>
                    <tr>
                        <td>
                            h.
                        </td>
                        <td>Pakaian Terakhir</td>
                        <td>:</td>
                        <td>{{ $data->pakaian_terakhir }}</td>
                    </tr>
                </table>
            </div>
            <div class="clearfix"></div>
            <div class="identitas">
                <ol>
                    <li>
                        <div>
                            <span class="label">Nama Lengkap</span>
                            <span>:</span>
                            <span>{{ $data->nama }}</span>
                        </div>
                    </li>
                    <li>
                        <div>
                            <span class="label">Umur</span>
                            <span>:</span>
                            <span>{{ $data->umur }}</span>
                        </div>
                    </li>
                    <li>
                        <div>
                            <span class="label">Suku</span>
                            <span>:</span>
                            <span>{{ $data->suku }}</span>
                        </div>
                    </li>
                    <li>
                        <div>
                            <span class="label">Alamat</span>
                            <span>:</span>
                            <span>{{ $data->alamat }}</span>
                        </div>
                    </li>
                </ol>
            </div>
            <div class="himbauan">
                <p>Apabila ditemukan harap menghubungi {{ $data->hubungan }}-nya di Nomor {{ $data->pelapor->no_hp }}
                    atas
                    nama {{ $data->pelapor->nama }} atau bisa menghubungi pihak kepolisian</p>
            </div>
        </div>
    </section>
</body>

</html>
