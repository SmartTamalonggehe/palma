<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perkembangan extends Model
{
    use HasFactory;
    protected $table = 'perkembangan';
    protected $guarded = [];

    public function laporan()
    {
        return $this->belongsTo(Laporan::class);
    }
}
