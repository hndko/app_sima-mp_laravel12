@extends('layouts.app-backend')

@section('title', 'Pengaturan Aplikasi')

@section('content')
<h1 class="h3 mb-3"><strong>Pengaturan</strong> Aplikasi</h1>

@if (session('success'))
<div class="alert alert-success alert-dismissible" role="alert">
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    <div class="alert-message">{{ session('success') }}</div>
</div>
@endif

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0"><i class="align-middle" data-feather="settings"></i> Informasi Perusahaan</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('settings.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Nama CV / Perusahaan</label>
                        <input type="text" name="nama_cv" class="form-control" value="{{ $settings['nama_cv'] }}" placeholder="CV Maju Bersama">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <textarea name="alamat" class="form-control" rows="2" placeholder="Jl. Contoh No. 123">{{ $settings['alamat'] }}</textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">No. Telepon</label>
                            <input type="text" name="telepon" class="form-control" value="{{ $settings['telepon'] }}" placeholder="021-1234567">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email Perusahaan</label>
                            <input type="email" name="email_cv" class="form-control" value="{{ $settings['email_cv'] }}" placeholder="info@perusahaan.com">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kop Surat / Catatan</label>
                        <textarea name="kop_surat" class="form-control" rows="2" placeholder="Teks tambahan untuk header laporan PDF">{{ $settings['kop_surat'] }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="align-middle" data-feather="save"></i> Simpan Pengaturan</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header"><h5 class="card-title mb-0">Info Sistem</h5></div>
            <div class="card-body">
                <table class="table table-sm mb-0">
                    <tr><td>Versi Laravel</td><td><strong>{{ app()->version() }}</strong></td></tr>
                    <tr><td>PHP</td><td><strong>{{ phpversion() }}</strong></td></tr>
                    <tr><td>APP_NAME</td><td><strong>{{ config('app.name') }}</strong></td></tr>
                    <tr><td>Environment</td><td><span class="badge bg-warning text-dark">{{ config('app.env') }}</span></td></tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
