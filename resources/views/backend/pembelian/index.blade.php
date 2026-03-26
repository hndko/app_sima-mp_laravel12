@extends('layouts.app-backend')

@section('title', 'Pembelian Stok')

@section('content')
<div class="row mb-3 align-items-center">
    <div class="col"><h1 class="h3 mb-0"><strong>Pembelian</strong> Stok Bahan</h1></div>
    <div class="col-auto"><a href="{{ route('pembelian.create') }}" class="btn btn-primary"><i class="align-middle" data-feather="plus"></i> Catat Pembelian</a></div>
</div>

@if (session('success'))
<div class="alert alert-success alert-dismissible" role="alert">
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    <div class="alert-message">{{ session('success') }}</div>
</div>
@endif

<div class="card">
    <div class="card-header"><h5 class="card-title mb-0">Riwayat Pembelian</h5></div>
    <table class="table table-hover my-0 datatable">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Bahan</th>
                <th>Supplier</th>
                <th class="text-center">Jumlah</th>
                <th class="text-end">Harga Satuan</th>
                <th class="text-end">Total</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pembelians as $pb)
            <tr>
                <td>{{ \Carbon\Carbon::parse($pb->tanggal)->format('d M Y') }}</td>
                <td><strong>{{ $pb->stok->nama_bahan }}</strong></td>
                <td>{{ $pb->supplier ?? '-' }}</td>
                <td class="text-center">{{ $pb->jumlah }} {{ $pb->stok->satuan }}</td>
                <td class="text-end">Rp {{ number_format($pb->harga_satuan, 0, ',', '.') }}</td>
                <td class="text-end fw-bold">Rp {{ number_format($pb->total, 0, ',', '.') }}</td>
                <td class="text-center">
                    <form action="{{ route('pembelian.destroy', $pb->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Batalkan pembelian ini? Stok akan dikurangi kembali.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger">Batalkan</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
