@extends('layouts.app-backend')

@section('title', 'Edit Proyek')

@section('content')
<div class="row mb-3">
    <div class="col-6">
        <h1 class="h3 mb-3"><strong>Edit</strong> Proyek</h1>
    </div>
    <div class="col-6 text-end">
        <a href="{{ route('proyek.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('proyek.update', $proyek->id) }}" method="POST">
            @csrf
            @method('PUT')

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
                    <input type="text" name="kode_proyek" class="form-control" value="{{ old('kode_proyek', $proyek->kode_proyek) }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Update Klien <span class="text-danger">*</span></label>
                    <select name="klien_id" class="form-select" required>
                        <option value="">-- Pilih Klien --</option>
                        @foreach($kliens as $klien)
                            <option value="{{ $klien->id }}" {{ old('klien_id', $proyek->klien_id) == $klien->id ? 'selected' : '' }}>
                                {{ $klien->nama_klien }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Uraian / Pekerjaan <span class="text-danger">*</span></label>
                <textarea name="uraian" class="form-control" rows="3" required>{{ old('uraian', $proyek->uraian) }}</textarea>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Ukuran Pengerjaan</label>
                    <input type="text" name="ukuran" class="form-control" value="{{ old('ukuran', $proyek->ukuran) }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Satuan</label>
                    <input type="text" name="satuan" class="form-control" value="{{ old('satuan', $proyek->satuan) }}">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tanggal Mulai <span class="text-danger">*</span></label>
                    <input type="date" name="tanggal_mulai" class="form-control" value="{{ old('tanggal_mulai', $proyek->tanggal_mulai) }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tanggal Selesai</label>
                    <input type="date" name="tanggal_selesai" class="form-control" value="{{ old('tanggal_selesai', $proyek->tanggal_selesai) }}">
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Update Nilai Dana Proyek (Rp) <span class="text-danger">*</span></label>
                    <input type="number" name="dana_proyek" class="form-control" value="{{ old('dana_proyek', $proyek->dana_proyek) }}" min="0" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Status <span class="text-danger">*</span></label>
                    <select name="status" class="form-select" required>
                        <option value="berjalan" {{ old('status', $proyek->status) == 'berjalan' ? 'selected' : '' }}>Berjalan</option>
                        <option value="selesai" {{ old('status', $proyek->status) == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Progres (%) <span class="text-danger">*</span></label>
                    <input type="number" name="progres" class="form-control" value="{{ old('progres', $proyek->progres) }}" min="0" max="100" required>
                </div>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Simpan Perubahan</button>
        </form>
    </div>
</div>
@endsection
