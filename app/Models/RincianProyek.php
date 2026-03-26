<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RincianProyek extends Model
{
    use HasFactory;

    protected $fillable = [
        'proyek_id', 'stok_id', 'bahan', 'jumlah', 'satuan', 'harga', 'total'
    ];

    public function proyek()
    {
        return $this->belongsTo(Proyek::class);
    }

    public function stok()
    {
        return $this->belongsTo(Stok::class);
    }
}
