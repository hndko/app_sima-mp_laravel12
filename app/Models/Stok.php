<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stok extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_barang', 'nama_bahan', 'harga_perolehan', 'harga_penjualan', 'stok', 'stok_minimum', 'satuan'
    ];

    public function riwayatStoks()
    {
        return $this->hasMany(RiwayatStok::class);
    }

    public function rincianProyeks()
    {
        return $this->hasMany(RincianProyek::class);
    }

    public function pembelians()
    {
        return $this->hasMany(Pembelian::class);
    }

    public function isMenipis(): bool
    {
        return $this->stok <= $this->stok_minimum;
    }
}
