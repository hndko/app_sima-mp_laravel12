<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    protected $fillable = [
        'stok_id', 'tanggal', 'jumlah', 'harga_satuan', 'total', 'supplier', 'keterangan'
    ];

    public function stok()
    {
        return $this->belongsTo(Stok::class);
    }
}
