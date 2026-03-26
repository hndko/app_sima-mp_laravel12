<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Klien extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nama_klien', 'alamat', 'no_hp', 'id_instagram', 'nama_facebook'
    ];

    public function proyeks()
    {
        return $this->hasMany(Proyek::class);
    }
}
