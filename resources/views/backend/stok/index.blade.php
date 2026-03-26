@extends('layouts.app-backend')

@section('title', 'Data Stok')

@section('content')
<div class="row mb-3">
    <div class="col-6">
        <h1 class="h3 mb-3"><strong>Data</strong> Stok Bahan</h1>
    </div>
    <div class="col-6 text-end">
        <a href="{{ route('stok.create') }}" class="btn btn-primary">Tambah Bahan</a>
    </div>
</div>

@if (session('success'))
<div class="alert alert-success alert-dismissible" role="alert">
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    <div class="alert-message">
        {{ session('success') }}
    </div>
</div>
@endif

<div class="card flex-fill">
    <div class="card-header">
        <h5 class="card-title mb-0">Daftar Stok Inventori</h5>
    </div>
    <table class="table table-hover my-0 datatable">
        <thead>
            <tr>
                <th>Kode</th>
                <th>Nama Bahan</th>
                <th>Stok</th>
                <th>Min</th>
                <th>Harga Jual</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($stoks as $stok)
            <tr class="{{ $stok->isMenipis() ? 'table-danger' : '' }}">
                <td>{{ $stok->id_barang }}</td>
                <td>
                    {{ $stok->nama_bahan }}
                    @if($stok->isMenipis())
                        <span class="badge bg-danger ms-1">Menipis!</span>
                    @endif
                </td>
                <td>
                    <strong>{{ number_format($stok->stok, 0, ',', '.') }}</strong> {{ $stok->satuan }}
                </td>
                <td>{{ $stok->stok_minimum }}</td>
                <td>Rp {{ number_format($stok->harga_penjualan, 0, ',', '.') }}</td>
                <td>
                    <a href="{{ route('stok.edit', $stok->id) }}" class="btn btn-sm btn-info">Edit</a>
                    <form action="{{ route('stok.destroy', $stok->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data bahan ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
