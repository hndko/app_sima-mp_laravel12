<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    use LogsActivity;

    public function index()
    {
        $settings = [
            'nama_cv' => Setting::get('nama_cv', ''),
            'alamat' => Setting::get('alamat', ''),
            'telepon' => Setting::get('telepon', ''),
            'email_cv' => Setting::get('email_cv', ''),
            'kop_surat' => Setting::get('kop_surat', ''),
        ];

        return view('backend.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $keys = ['nama_cv', 'alamat', 'telepon', 'email_cv', 'kop_surat'];

        foreach ($keys as $key) {
            Setting::set($key, $request->input($key, ''));
        }

        $this->logActivity('update', 'settings', 'Mengupdate pengaturan aplikasi');

        return redirect()->route('settings.index')->with('success', 'Pengaturan berhasil disimpan.');
    }
}
