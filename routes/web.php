<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\KlienController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\ProyekController;
use App\Http\Controllers\RincianProyekController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\KasRekeningController;
use App\Http\Controllers\HutangPiutangController;
use App\Http\Controllers\RiwayatStokController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\SettingController;

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::get('/login', [AuthController::class, 'loginView'])->name('login');
Route::post('/login', [AuthController::class, 'loginAction']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profil (semua role)
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    // Master Data & Proyek: admin & manajer
    Route::middleware('role:admin,manajer')->group(function () {
        Route::resource('karyawan', KaryawanController::class);
        Route::resource('klien', KlienController::class);
        Route::resource('stok', StokController::class);
        Route::resource('proyek', ProyekController::class);
        Route::post('/proyek/{proyek}/rincian', [RincianProyekController::class, 'store'])->name('rincian.store');
        Route::delete('/proyek/{proyek}/rincian/{rincian}', [RincianProyekController::class, 'destroy'])->name('rincian.destroy');
        Route::get('/riwayat-stok', [RiwayatStokController::class, 'index'])->name('riwayat-stok.index');
        Route::resource('pembelian', PembelianController::class)->only(['index', 'create', 'store', 'destroy']);
    });

    // Keuangan: admin & keuangan
    Route::middleware('role:admin,keuangan')->group(function () {
        Route::resource('keuangan', KeuanganController::class)->except(['show']);
        Route::resource('kas-rekening', KasRekeningController::class)->except(['show']);
        Route::resource('hutang-piutang', HutangPiutangController::class)->except(['show']);
        Route::get('/hutang-piutang/{karyawan}', [HutangPiutangController::class, 'show'])->name('hutang-piutang.show');
    });

    // Laporan PDF (semua role yang punya akses ke data)
    Route::get('/laporan/proyek/{proyek}/pdf', [LaporanController::class, 'proyekPDF'])->name('laporan.proyek.pdf');
    Route::get('/laporan/keuangan/pdf', [LaporanController::class, 'keuanganPDF'])->name('laporan.keuangan.pdf');
    Route::get('/laporan/hutang-piutang/{karyawan}/pdf', [LaporanController::class, 'hutangPiutangPDF'])->name('laporan.hutang-piutang.pdf');

    // Admin only
    Route::middleware('role:admin')->group(function () {
        Route::resource('users', UserController::class)->except(['show']);
        Route::get('/log-aktivitas', [ActivityLogController::class, 'index'])->name('log-aktivitas.index');
        Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
        Route::put('/settings', [SettingController::class, 'update'])->name('settings.update');
    });
});
