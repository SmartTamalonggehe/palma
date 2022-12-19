<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrangKetemu extends Model
{
    use HasFactory;

    protected $table = 'orang_ketemu';
    protected $guarded = [];

    public function orangHilang()
    {
        return $this->belongsTo(OrangHilang::class);
    }
}
