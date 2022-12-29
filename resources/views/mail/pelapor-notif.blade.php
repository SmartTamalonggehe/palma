<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<style>
    .text-center {
        text-align: center
    }

    .container {
        display: flex;
        justify-content: center
    }
</style>

<body>
    <h4 class="text-center">Ini merupakan email pemberitahuan tentang data pelapor</h4>
    <div class="container">
        <div>
            <p>Berikut adalah data anda:</p>
            <table>
                <tr>
                    <td>Nama</td>
                    <td>:</td>
                    <td>{{ $data->nama }}</td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td>:</td>
                    <td>{{ $data->user->email }}</td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td>:</td>
                    <td>{{ $data->user->show_password }}</td>
                </tr>
            </table>
            @if ($data->status === 'diterima')
                <p>Selamat data anda diterima silahkan login pada aplikasi untuk melaporkan orang yang hilang</p>
            @elseif ($data->status === 'diproses')
                <p>Data anda dalam proses pemeriksaan, mohon menunggu.</p>
            @else
                <p>Data anda ditolak, kemungkinan ada beberapa data yang tidak relevan. Terimakasih.</p>
            @endif
            <h3 class="text-center">Terimakasih</h3>
        </div>
    </div>

</body>

</html>
