<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelapor extends Model
{
    use HasFactory;
    protected $table = 'pelapor';
    protected $guarded = [];

    public function distrik()
    {
        return $this->belongsTo(Distrik::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
