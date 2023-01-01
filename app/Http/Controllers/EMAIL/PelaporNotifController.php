<?php

namespace App\Http\Controllers\EMAIL;

use Throwable;
use Illuminate\Http\Request;
use App\Mail\VerifikasiPelapor;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class PelaporNotifController extends Controller
{
    public function index($mailData)
    {
        Mail::to($mailData->user->email)->send(new VerifikasiPelapor($mailData));
        return 'email berhasil dikirim';
    }
}
