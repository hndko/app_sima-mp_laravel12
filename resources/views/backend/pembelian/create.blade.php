@extends('layouts.app-backend')

@section('title', 'Catat Pembelian')

@section('content')
<div class="row mb-3">
    <div class="col"><h1 class="h3 mb-0"><strong>Catat</strong> Pembelian Baru</h1></div>
    <div class="col-auto"><a href="{{ route('pembelian.index') }}" class="btn btn-secondary">Kembali</a></div>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('pembelian.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Pilih Bahan <span class="text-danger">*</span></label>
                    <select name="stok_id" class="form-select @error('stok_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Bahan --</option>
                        @foreach($stoks as $stok)
                            <option value="{{ $stok->id }}" {{ old('stok_id') == $stok->id ? 'selected' : '' }}>
                                {{ $stok->nama_bahan }} (Stok saat ini: {{ $stok->stok }} {{ $stok->satuan }})
                            </option>
                        @endforeach
                    </select>
                    @error('stok_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Tanggal <span class="text-danger">*</span></label>
                    <input type="date" name="tanggal" class="form-control @error('tanggal') is-invalid @enderror" value="{{ old('tanggal', date('Y-m-d')) }}" required>
                    @error('tanggal')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Supplier</label>
                    <input type="text" name="supplier" class="form-control" value="{{ old('supplier') }}" placeholder="Nama Toko/Supplier">
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label class="form-label">Jumlah <span class="text-danger">*</span></label>
                    <input type="number" name="jumlah" class="form-control @error('jumlah') is-invalid @enderror" value="{{ old('jumlah', 1) }}" min="1" required>
                    @error('jumlah')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Harga Satuan (Rp) <span class="text-danger">*</span></label>
                    <input type="number" name="harga_satuan" class="form-control @error('harga_satuan') is-invalid @enderror" value="{{ old('harga_satuan') }}" min="0" required>
                    @error('harga_satuan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Keterangan</label>
                    <input type="text" name="keterangan" class="form-control" value="{{ old('keterangan') }}" placeholder="Catatan pembelian (opsional)">
                </div>
            </div>
            <button type="submit" class="btn btn-primary"><i class="align-middle" data-feather="save"></i> Simpan Pembelian</button>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header"><h5 class="card-title mb-0">Catatan</h5></div>
    <div class="card-body">
        <ul class="mb-0">
            <li>Stok gudang akan <strong>otomatis bertambah</strong> sesuai jumlah pembelian.</li>
            <li>Riwayat stok akan otomatis dicatat sebagai stok <strong>masuk</strong>.</li>
            <li>Pengeluaran akan otomatis dicatat di modul <strong>Keuangan</strong>.</li>
        </ul>
    </div>
</div>
@endsection
