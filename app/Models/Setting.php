<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    private const APP_SETTINGS_CACHE_KEY = 'app_settings_map';

    protected $fillable = ['key', 'value'];

    public static function get($key, $default = null)
    {
        $setting = static::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    public static function getMany(array $keys, array $defaults = []): array
    {
        $values = static::query()
            ->whereIn('key', $keys)
            ->pluck('value', 'key')
            ->toArray();

        $result = $defaults;
        foreach ($keys as $key) {
            if (array_key_exists($key, $values)) {
                $result[$key] = $values[$key];
            } elseif (!array_key_exists($key, $result)) {
                $result[$key] = null;
            }
        }

        return $result;
    }

    public static function appSettings(array $defaults = []): array
    {
        $baseDefaults = [
            'nama_cv' => config('app.name'),
            'alamat' => 'Alamat belum diatur',
            'telepon' => '-',
            'email_cv' => '-',
            'kop_surat' => 'Dokumen ini dibuat otomatis oleh sistem.',
            'logo_perusahaan' => '',
        ];

        return Cache::remember(
            self::APP_SETTINGS_CACHE_KEY,
            now()->addMinutes(10),
            fn() => static::getMany(array_keys($baseDefaults), array_merge($baseDefaults, $defaults))
        );
    }

    public static function set($key, $value)
    {
        $saved = static::updateOrCreate(['key' => $key], ['value' => $value]);
        static::clearAppSettingsCache();

        return $saved;
    }

    public static function setMany(array $pairs): void
    {
        foreach ($pairs as $key => $value) {
            static::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        static::clearAppSettingsCache();
    }

    public static function clearAppSettingsCache(): void
    {
        Cache::forget(self::APP_SETTINGS_CACHE_KEY);
    }
}
