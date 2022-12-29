<?php

namespace App\Http\Controllers\EMAIL;

use Throwable;
use Illuminate\Http\Request;
use App\Mail\VerifikasiPelapor;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class PelaporNotifController extends Controller
{
    public function index($mailData = "")

    {
        $mail = Mail::to('smartspartacus@gmail.com')->send(new VerifikasiPelapor($mailData));
        return 'email berhasil dikirim';
    }
}
