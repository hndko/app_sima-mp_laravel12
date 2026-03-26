<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KasRekening extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal', 'keterangan', 'nominal_masuk', 'nominal_keluar'
    ];
}
