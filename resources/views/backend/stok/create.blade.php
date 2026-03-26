@extends('layouts.app-backend')

@section('title', 'Tambah Stok')

@section('content')
<div class="row mb-3">
    <div class="col-6">
        <h1 class="h3 mb-3"><strong>Tambah</strong> Bahan</h1>
    </div>
    <div class="col-6 text-end">
        <a href="{{ route('stok.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('stok.store') }}" method="POST">
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
                    <label class="form-label">Kode Barang <span class="text-danger">*</span></label>
                    <input type="text" name="id_barang" class="form-control" value="{{ old('id_barang') }}" placeholder="Contoh: BRG-001" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama Bahan <span class="text-danger">*</span></label>
                    <input type="text" name="nama_bahan" class="form-control" value="{{ old('nama_bahan') }}" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Harga Beli/Perolehan (Rp) <span class="text-danger">*</span></label>
                    <input type="number" name="harga_perolehan" class="form-control" value="{{ old('harga_perolehan', 0) }}" min="0" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Harga Jual (Rp) <span class="text-danger">*</span></label>
                    <input type="number" name="harga_penjualan" class="form-control" value="{{ old('harga_penjualan', 0) }}" min="0" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Jumlah Stok Awal <span class="text-danger">*</span></label>
                    <input type="number" name="stok" class="form-control" value="{{ old('stok', 0) }}" min="0" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Satuan</label>
                    <input type="text" name="satuan" class="form-control" value="{{ old('satuan') }}" placeholder="Contoh: Sak, Batang, Biji">
                </div>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Simpan Data</button>
        </form>
    </div>
</div>
@endsection
