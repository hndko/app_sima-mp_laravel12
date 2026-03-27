<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Throwable;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Illuminate\Pagination\Paginator::useBootstrapFive();

        $appSettings = [
            'nama_cv' => config('app.name'),
            'alamat' => 'Alamat belum diatur',
            'telepon' => '-',
            'email_cv' => '-',
            'kop_surat' => 'Dokumen ini dibuat otomatis oleh sistem.',
            'logo_perusahaan' => '',
        ];

        try {
            if (Schema::hasTable('settings')) {
                $appSettings = Setting::appSettings($appSettings);
            }
        } catch (Throwable) {
            // Keep defaults when DB is not ready (e.g. during first migrate).
        }

        if (!empty(trim((string) ($appSettings['nama_cv'] ?? '')))) {
            config(['app.name' => $appSettings['nama_cv']]);
        }

        $appSettings['nama_cv'] = trim((string) ($appSettings['nama_cv'] ?? '')) ?: config('app.name');
        $appSettings['alamat'] = trim((string) ($appSettings['alamat'] ?? '')) ?: 'Alamat belum diatur';
        $appSettings['telepon'] = trim((string) ($appSettings['telepon'] ?? '')) ?: '-';
        $appSettings['email_cv'] = trim((string) ($appSettings['email_cv'] ?? '')) ?: '-';
        $appSettings['kop_surat'] = trim((string) ($appSettings['kop_surat'] ?? '')) ?: 'Dokumen ini dibuat otomatis oleh sistem.';
        $appSettings['logo_perusahaan'] = trim((string) ($appSettings['logo_perusahaan'] ?? ''));
        $appSettings['logo_url'] = !empty($appSettings['logo_perusahaan'])
            ? asset('storage/' . $appSettings['logo_perusahaan'])
            : asset('assets/img/icons/icon-48x48.png');

        View::share('appSettings', $appSettings);
    }
}
