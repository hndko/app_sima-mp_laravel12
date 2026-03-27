<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            'logo_perusahaan' => Setting::get('logo_perusahaan', ''),
        ];

        return view('backend.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'nama_cv' => 'nullable|string|max:100',
            'alamat' => 'nullable|string|max:500',
            'telepon' => 'nullable|string|max:50',
            'email_cv' => 'nullable|email|max:100',
            'kop_surat' => 'nullable|string|max:500',
            'logo_perusahaan' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'remove_logo' => 'nullable|boolean',
        ]);

        $keys = ['nama_cv', 'alamat', 'telepon', 'email_cv', 'kop_surat'];
        $payload = [];
        foreach ($keys as $key) {
            $payload[$key] = $validated[$key] ?? '';
        }

        $existingLogo = Setting::get('logo_perusahaan', '');
        $logoPath = $existingLogo;

        if ($request->boolean('remove_logo') && !empty($existingLogo)) {
            if (Storage::disk('public')->exists($existingLogo)) {
                Storage::disk('public')->delete($existingLogo);
            }
            $logoPath = '';
        }

        if ($request->hasFile('logo_perusahaan')) {
            if (!empty($existingLogo) && Storage::disk('public')->exists($existingLogo)) {
                Storage::disk('public')->delete($existingLogo);
            }

            $logoPath = $request->file('logo_perusahaan')->store('settings', 'public');
        }

        $payload['logo_perusahaan'] = $logoPath;

        Setting::setMany($payload);

        $this->logActivity('update', 'settings', 'Mengupdate pengaturan aplikasi');

        return redirect()->route('settings.index')->with('success', 'Pengaturan berhasil disimpan.');
    }
}
