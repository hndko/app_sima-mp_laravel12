<?php

namespace App\Traits;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

trait LogsActivity
{
    protected function logActivity($aksi, $modul, $deskripsi, $dataLama = null, $dataBaru = null)
    {
        ActivityLog::create([
            'user_id' => Auth::id(),
            'aksi' => $aksi,
            'modul' => $modul,
            'deskripsi' => $deskripsi,
            'data_lama' => $dataLama,
            'data_baru' => $dataBaru,
            'ip_address' => request()->ip(),
        ]);
    }
}
