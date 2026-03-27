<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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

            $logoPath = $this->processAndStoreLogo($request->file('logo_perusahaan'));
        }

        $payload['logo_perusahaan'] = $logoPath;

        Setting::setMany($payload);

        $this->logActivity('update', 'settings', 'Mengupdate pengaturan aplikasi');

        return redirect()->route('settings.index')->with('success', 'Pengaturan berhasil disimpan.');
    }

    public function reset()
    {
        $keys = ['nama_cv', 'alamat', 'telepon', 'email_cv', 'kop_surat', 'logo_perusahaan'];

        $existingLogo = Setting::get('logo_perusahaan', '');
        if (!empty($existingLogo) && Storage::disk('public')->exists($existingLogo)) {
            Storage::disk('public')->delete($existingLogo);
        }

        Setting::whereIn('key', $keys)->delete();
        Setting::clearAppSettingsCache();

        $this->logActivity('update', 'settings', 'Reset pengaturan aplikasi ke default');

        return redirect()->route('settings.index')->with('success', 'Pengaturan berhasil direset ke default.');
    }

    private function processAndStoreLogo(UploadedFile $file): string
    {
        $fallbackPath = $file->store('settings', 'public');

        if (!function_exists('imagecreatetruecolor')) {
            return $fallbackPath;
        }

        $realPath = $file->getRealPath();
        $imageInfo = @getimagesize($realPath);
        if (!$imageInfo || empty($imageInfo[0]) || empty($imageInfo[1])) {
            return $fallbackPath;
        }

        [$width, $height, $type] = $imageInfo;
        $source = match ($type) {
            IMAGETYPE_JPEG => @imagecreatefromjpeg($realPath),
            IMAGETYPE_PNG => @imagecreatefrompng($realPath),
            IMAGETYPE_WEBP => function_exists('imagecreatefromwebp') ? @imagecreatefromwebp($realPath) : null,
            default => null,
        };

        if (!$source) {
            return $fallbackPath;
        }

        $targetSize = 256;
        $cropSize = min($width, $height);
        $srcX = (int) floor(($width - $cropSize) / 2);
        $srcY = (int) floor(($height - $cropSize) / 2);

        $destination = imagecreatetruecolor($targetSize, $targetSize);
        imagealphablending($destination, false);
        imagesavealpha($destination, true);
        $transparent = imagecolorallocatealpha($destination, 255, 255, 255, 127);
        imagefill($destination, 0, 0, $transparent);

        imagecopyresampled(
            $destination,
            $source,
            0,
            0,
            $srcX,
            $srcY,
            $targetSize,
            $targetSize,
            $cropSize,
            $cropSize
        );

        $resizedFileName = 'settings/logo-' . now()->format('YmdHis') . '-' . Str::lower(Str::random(6)) . '.png';
        $absolutePath = storage_path('app/public/' . $resizedFileName);
        $directory = dirname($absolutePath);
        if (!is_dir($directory)) {
            @mkdir($directory, 0755, true);
        }

        $saved = @imagepng($destination, $absolutePath, 9);

        imagedestroy($source);
        imagedestroy($destination);

        if (!$saved) {
            return $fallbackPath;
        }

        if (Storage::disk('public')->exists($fallbackPath)) {
            Storage::disk('public')->delete($fallbackPath);
        }

        return $resizedFileName;
    }
}
