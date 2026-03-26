@extends('layouts.app-backend')

@section('title', 'Edit Mutasi Rekening')

@section('content')
<div class="row mb-3">
    <div class="col-6">
        <h1 class="h3 mb-3"><strong>Edit</strong> Mutasi Rekening</h1>
    </div>
    <div class="col-6 text-end">
        <a href="{{ route('kas-rekening.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('kas-rekening.update', $kas_rekening->id) }}" method="POST">
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

            <div class="mb-3">
                <label class="form-label">Tanggal <span class="text-danger">*</span></label>
                <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal', $kas_rekening->tanggal) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Keterangan</label>
                <textarea name="keterangan" class="form-control" rows="2">{{ old('keterangan', $kas_rekening->keterangan) }}</textarea>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nominal Masuk (Rp) <span class="text-danger">*</span></label>
                    <input type="number" name="nominal_masuk" class="form-control" value="{{ old('nominal_masuk', $kas_rekening->nominal_masuk) }}" min="0" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nominal Keluar (Rp) <span class="text-danger">*</span></label>
                    <input type="number" name="nominal_keluar" class="form-control" value="{{ old('nominal_keluar', $kas_rekening->nominal_keluar) }}" min="0" required>
                </div>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Simpan Perubahan</button>
        </form>
    </div>
</div>
@endsection
