@extends('layouts.app-backend')

@section('title', 'Buka Proyek Baru')

@section('content')
<div class="row mb-3">
    <div class="col-6">
        <h1 class="h3 mb-3"><strong>Buka</strong> Proyek Baru</h1>
    </div>
    <div class="col-6 text-end">
        <a href="{{ route('proyek.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('proyek.store') }}" method="POST">
            @csrf

            @if ($errors->any())
            <div class="alert alert-danger p-2 mb-3">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Kode Proyek <span class="text-danger">*</span></label>
                    <input type="text" name="kode_proyek" class="form-control" value="{{ old('kode_proyek') }}" placeholder="PRJ-001" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Pilih Klien <span class="text-danger">*</span></label>
                    <select name="klien_id" class="form-select" required>
                        <option value="">-- Pilih Klien --</option>
                        @foreach($kliens as $klien)
                            <option value="{{ $klien->id }}" {{ old('klien_id') == $klien->id ? 'selected' : '' }}>
                                {{ $klien->nama_klien }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Uraian / Pekerjaan <span class="text-danger">*</span></label>
                <textarea name="uraian" class="form-control" rows="3" required>{{ old('uraian') }}</textarea>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Ukuran Pengerjaan</label>
                    <input type="text" name="ukuran" class="form-control" value="{{ old('ukuran') }}" placeholder="Contoh: 10x20">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Satuan</label>
                    <input type="text" name="satuan" class="form-control" value="{{ old('satuan', 'Meter') }}">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tanggal Mulai <span class="text-danger">*</span></label>
                    <input type="date" name="tanggal_mulai" class="form-control" value="{{ old('tanggal_mulai', date('Y-m-d')) }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tanggal Selesai</label>
                    <input type="date" name="tanggal_selesai" class="form-control" value="{{ old('tanggal_selesai') }}">
                    <small class="text-muted">Isi nanti jika belum pasti selesainya.</small>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Dana Proyek (Rp) <span class="text-danger">*</span></label>
                    <input type="number" name="dana_proyek" class="form-control" value="{{ old('dana_proyek', 0) }}" min="0" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Status <span class="text-danger">*</span></label>
                    <select name="status" class="form-select" required>
                        <option value="berjalan" {{ old('status') == 'berjalan' ? 'selected' : '' }}>Berjalan</option>
                        <option value="selesai" {{ old('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                </div>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Simpan Data Proyek</button>
        </form>
    </div>
</div>
@endsection
