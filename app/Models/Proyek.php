<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyek extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_proyek', 'klien_id', 'uraian', 'ukuran', 'satuan', 'tanggal_mulai', 'tanggal_selesai', 'dana_proyek', 'status', 'progres'
    ];

    public function klien()
    {
        return $this->belongsTo(Klien::class);
    }

    public function rincianProyeks()
    {
        return $this->hasMany(RincianProyek::class);
    }
}
