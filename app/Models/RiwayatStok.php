<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatStok extends Model
{
    use HasFactory;

    protected $fillable = [
        'stok_id', 'tanggal', 'tipe', 'jumlah', 'keterangan'
    ];

    public function stok()
    {
        return $this->belongsTo(Stok::class);
    }
}
