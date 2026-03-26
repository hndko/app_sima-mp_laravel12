<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::get('/login', [AuthController::class, 'loginView'])->name('login');
Route::post('/login', [AuthController::class, 'loginAction']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function() {
    Route::get('/dashboard', function () {
        return view('backend.dashboard.index');
    })->name('dashboard');

    Route::resource('karyawan', \App\Http\Controllers\KaryawanController::class);
    Route::resource('klien', \App\Http\Controllers\KlienController::class);
    Route::resource('stok', \App\Http\Controllers\StokController::class);

    Route::resource('proyek', \App\Http\Controllers\ProyekController::class);
    Route::post('/proyek/{proyek}/rincian', [\App\Http\Controllers\RincianProyekController::class, 'store'])->name('rincian.store');
    Route::delete('/proyek/{proyek}/rincian/{rincian}', [\App\Http\Controllers\RincianProyekController::class, 'destroy'])->name('rincian.destroy');

    Route::resource('keuangan', \App\Http\Controllers\KeuanganController::class)->except(['show']);
    Route::resource('kas-rekening', \App\Http\Controllers\KasRekeningController::class)->except(['show']);
    Route::resource('hutang-piutang', \App\Http\Controllers\HutangPiutangController::class)->except(['show']);
});
