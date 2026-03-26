@extends('layouts.app-backend')

@section('title', 'Catat Transaksi Keuangan')

@section('content')
<div class="row mb-3">
    <div class="col-6">
        <h1 class="h3 mb-3"><strong>Catat</strong> Transaksi Keuangan</h1>
    </div>
    <div class="col-6 text-end">
        <a href="{{ route('keuangan.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('keuangan.store') }}" method="POST">
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
                <div class="col-md-4 mb-3">
                    <label class="form-label">Tanggal <span class="text-danger">*</span></label>
                    <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal', date('Y-m-d')) }}" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Kategori</label>
                    <input type="text" name="kategori" class="form-control" value="{{ old('kategori') }}" placeholder="Contoh: Pendapatan Proyek, Biaya Operasional">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Sumber Dana</label>
                    <input type="text" name="sumber_dana" class="form-control" value="{{ old('sumber_dana') }}" placeholder="Contoh: Kas Kecil, Bank BCA">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Uraian Transaksi</label>
                <textarea name="uraian" class="form-control" rows="2">{{ old('uraian') }}</textarea>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Pemasukan (Rp) <span class="text-danger">*</span></label>
                    <input type="number" name="pemasukan" class="form-control" value="{{ old('pemasukan', 0) }}" min="0" required>
                    <small class="text-muted">Isi 0 jika bukan transaksi pemasukan.</small>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Pengeluaran (Rp) <span class="text-danger">*</span></label>
                    <input type="number" name="pengeluaran" class="form-control" value="{{ old('pengeluaran', 0) }}" min="0" required>
                    <small class="text-muted">Isi 0 jika bukan transaksi pengeluaran.</small>
                </div>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Simpan Transaksi</button>
        </form>
    </div>
</div>
@endsection
