@extends('layouts.app-backend')

@section('title', 'Pengaturan Aplikasi')

@section('content')
<h1 class="h3 mb-3"><strong>Pengaturan</strong> Aplikasi</h1>

<div class="alert alert-info" role="alert">
    Perubahan di halaman ini akan langsung dipakai pada nama aplikasi, identitas perusahaan di footer, serta header
    laporan PDF.
</div>

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
                <h5 class="card-title mb-0"><i class="align-middle" data-feather="settings"></i> Informasi Perusahaan
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Logo Perusahaan</label>
                        <input type="file" name="logo_perusahaan" id="logo_perusahaan"
                            class="form-control @error('logo_perusahaan') is-invalid @enderror"
                            accept="image/png,image/jpeg,image/webp">
                        @error('logo_perusahaan')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Format: JPG/PNG/WEBP, maksimal 2MB. Logo otomatis di-crop tengah dan
                            di-resize ke 256x256 agar konsisten di navbar dan laporan PDF.</small>

                        @if(!empty($settings['logo_perusahaan']))
                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" value="1" id="remove_logo"
                                name="remove_logo">
                            <label class="form-check-label" for="remove_logo">Hapus logo saat ini</label>
                        </div>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nama CV / Perusahaan</label>
                        <input type="text" id="nama_cv" name="nama_cv" class="form-control"
                            value="{{ $settings['nama_cv'] }}" placeholder="CV Maju Bersama">
                        <small class="text-muted">Dipakai sebagai nama aplikasi pada login, sidebar, dan judul
                            halaman.</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <textarea name="alamat" id="alamat" class="form-control" rows="2"
                            placeholder="Jl. Contoh No. 123">{{ $settings['alamat'] }}</textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">No. Telepon</label>
                            <input type="text" id="telepon" name="telepon" class="form-control"
                                value="{{ $settings['telepon'] }}" placeholder="021-1234567">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email Perusahaan</label>
                            <input type="email" id="email_cv" name="email_cv" class="form-control"
                                value="{{ $settings['email_cv'] }}" placeholder="info@perusahaan.com">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kop Surat / Catatan</label>
                        <textarea name="kop_surat" id="kop_surat" class="form-control" rows="2"
                            placeholder="Teks tambahan untuk header laporan PDF">{{ $settings['kop_surat'] }}</textarea>
                        <small class="text-muted">Ditampilkan pada laporan PDF sebagai catatan tambahan.</small>
                    </div>
                    <div class="d-flex flex-wrap gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="align-middle" data-feather="save"></i> Simpan Pengaturan
                        </button>
                    </div>
                </form>

                <hr class="my-4">

                <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                    <div>
                        <h6 class="mb-1 text-danger">Reset ke Default</h6>
                        <small class="text-muted">Menghapus seluruh pengaturan aplikasi termasuk logo yang
                            diunggah.</small>
                    </div>
                    <form action="{{ route('settings.reset') }}" method="POST"
                        onsubmit="return confirm('Reset semua pengaturan ke default? Tindakan ini tidak bisa dibatalkan.');">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger">
                            <i class="align-middle" data-feather="refresh-ccw"></i> Reset Default
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Preview Live</h5>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <img id="previewLogo"
                        src="{{ !empty($settings['logo_perusahaan']) ? asset('storage/' . $settings['logo_perusahaan']) : asset('assets/img/icons/icon-48x48.png') }}"
                        alt="Logo perusahaan"
                        style="width:56px;height:56px;object-fit:cover;border-radius:10px;border:1px solid #dbe4f0;background:#fff;">
                    <div>
                        <h6 class="mb-1" id="previewNama">{{ $settings['nama_cv'] ?: config('app.name') }}</h6>
                        <small class="text-muted" id="previewKontak">{{ ($settings['telepon'] ?: '-') . ' | ' .
                            ($settings['email_cv'] ?: '-') }}</small>
                    </div>
                </div>
                <p class="mb-1"><strong>Alamat:</strong></p>
                <p class="text-muted mb-2" id="previewAlamat">{{ $settings['alamat'] ?: 'Alamat belum diatur' }}</p>
                <p class="mb-1"><strong>Catatan PDF:</strong></p>
                <p class="text-muted mb-0" id="previewKop">{{ $settings['kop_surat'] ?: 'Dokumen ini dibuat otomatis
                    oleh sistem.' }}</p>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h5 class="card-title mb-0">Info Sistem</h5>
            </div>
            <div class="card-body">
                <table class="table table-sm mb-0">
                    <tr>
                        <td>Versi Laravel</td>
                        <td><strong>{{ app()->version() }}</strong></td>
                    </tr>
                    <tr>
                        <td>PHP</td>
                        <td><strong>{{ phpversion() }}</strong></td>
                    </tr>
                    <tr>
                        <td>Nama Aplikasi Aktif</td>
                        <td><strong>{{ config('app.name') }}</strong></td>
                    </tr>
                    <tr>
                        <td>Environment</td>
                        <td><span class="badge bg-warning text-dark">{{ config('app.env') }}</span></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const $ = (id) => document.getElementById(id);

        const defaultLogo = "{{ asset('assets/img/icons/icon-48x48.png') }}";
        const initialLogo = "{{ !empty($settings['logo_perusahaan']) ? asset('storage/' . $settings['logo_perusahaan']) : asset('assets/img/icons/icon-48x48.png') }}";

        const inputNama = $('nama_cv');
        const inputAlamat = $('alamat');
        const inputTelepon = $('telepon');
        const inputEmail = $('email_cv');
        const inputKop = $('kop_surat');
        const inputLogo = $('logo_perusahaan');
        const removeLogo = $('remove_logo');

        const previewNama = $('previewNama');
        const previewAlamat = $('previewAlamat');
        const previewKontak = $('previewKontak');
        const previewKop = $('previewKop');
        const previewLogo = $('previewLogo');

        function valueOrDefault(value, fallback) {
            return value && value.trim() ? value.trim() : fallback;
        }

        function syncPreview() {
            previewNama.textContent = valueOrDefault(inputNama.value, "{{ config('app.name') }}");
            previewAlamat.textContent = valueOrDefault(inputAlamat.value, 'Alamat belum diatur');

            const phone = valueOrDefault(inputTelepon.value, '-');
            const email = valueOrDefault(inputEmail.value, '-');
            previewKontak.textContent = phone + ' | ' + email;

            previewKop.textContent = valueOrDefault(inputKop.value, 'Dokumen ini dibuat otomatis oleh sistem.');

            if (removeLogo && removeLogo.checked) {
                previewLogo.src = defaultLogo;
                return;
            }

            if (inputLogo.files && inputLogo.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewLogo.src = e.target.result;
                };
                reader.readAsDataURL(inputLogo.files[0]);
                return;
            }

            previewLogo.src = initialLogo;
        }

        [inputNama, inputAlamat, inputTelepon, inputEmail, inputKop].forEach(function(el) {
            el.addEventListener('input', syncPreview);
        });

        inputLogo.addEventListener('change', syncPreview);
        if (removeLogo) {
            removeLogo.addEventListener('change', syncPreview);
        }

        syncPreview();
    });
</script>
@endpush