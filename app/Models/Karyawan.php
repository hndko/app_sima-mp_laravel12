<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Karyawan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id_karyawan', 'nama_karyawan', 'bidang', 'alamat', 'no_hp'
    ];

    public function hutangPiutangs()
    {
        return $this->hasMany(HutangPiutang::class);
    }
}
