<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrangHilang extends Model
{
    use HasFactory;
    protected $table = 'orang_hilang';
    protected $guarded = [];

    public function distrik()
    {
        return $this->belongsTo(Distrik::class);
    }

    public function pelapor()
    {
        return $this->belongsTo(Pelapor::class);
    }
}
