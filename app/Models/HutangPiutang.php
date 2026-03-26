<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HutangPiutang extends Model
{
    use HasFactory;

    protected $fillable = [
        'karyawan_id', 'tanggal', 'pengambilan', 'upah', 'keterangan'
    ];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }
}
