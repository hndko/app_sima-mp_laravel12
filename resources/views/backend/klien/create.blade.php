@extends('layouts.app-backend')

@section('title', 'Tambah Klien')

@section('content')
<div class="row mb-3">
    <div class="col-6">
        <h1 class="h3 mb-3"><strong>Tambah</strong> Klien</h1>
    </div>
    <div class="col-6 text-end">
        <a href="{{ route('klien.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('klien.store') }}" method="POST">
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

            <div class="mb-3">
                <label class="form-label">Nama Klien <span class="text-danger">*</span></label>
                <input type="text" name="nama_klien" class="form-control" value="{{ old('nama_klien') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Nomor Handphone</label>
                <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Alamat</label>
                <textarea name="alamat" class="form-control" rows="3">{{ old('alamat') }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">ID Instagram</label>
                <input type="text" name="id_instagram" class="form-control" value="{{ old('id_instagram') }}" placeholder="@username">
            </div>

            <div class="mb-3">
                <label class="form-label">Nama Facebook</label>
                <input type="text" name="nama_facebook" class="form-control" value="{{ old('nama_facebook') }}">
            </div>

            <button type="submit" class="btn btn-primary">Simpan Data</button>
        </form>
    </div>
</div>
@endsection
