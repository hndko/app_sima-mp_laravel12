@extends('layouts.app-backend')

@section('title', 'Edit Transaksi Hutang/Piutang')

@section('content')
<div class="row mb-3">
    <div class="col-6">
        <h1 class="h3 mb-3"><strong>Edit</strong> Transaksi Hutang/Piutang</h1>
    </div>
    <div class="col-6 text-end">
        <a href="{{ route('hutang-piutang.show', $hutang_piutang->karyawan_id) }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('hutang-piutang.update', $hutang_piutang->id) }}" method="POST">
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
                    <label class="form-label">Karyawan <span class="text-danger">*</span></label>
                    <select name="karyawan_id" class="form-select" required>
                        <option value="">-- Pilih Karyawan --</option>
                        @foreach($karyawans as $k)
                            <option value="{{ $k->id }}" {{ (old('karyawan_id', $hutang_piutang->karyawan_id) == $k->id) ? 'selected' : '' }}>
                                {{ $k->nama_karyawan }} ({{ $k->id_karyawan }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tanggal <span class="text-danger">*</span></label>
                    <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal', $hutang_piutang->tanggal) }}" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Pengambilan / Kasbon (Rp) <span class="text-danger">*</span></label>
                    <input type="number" name="pengambilan" class="form-control" value="{{ old('pengambilan', $hutang_piutang->pengambilan) }}" min="0" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Upah Dibayar (Rp) <span class="text-danger">*</span></label>
                    <input type="number" name="upah" class="form-control" value="{{ old('upah', $hutang_piutang->upah) }}" min="0" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Keterangan</label>
                <textarea name="keterangan" class="form-control" rows="2">{{ old('keterangan', $hutang_piutang->keterangan) }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Simpan Perubahan</button>
        </form>
    </div>
</div>
@endsection
