@extends('layouts.app-backend')

@section('title', 'Riwayat Stok')

@section('content')
<div class="row mb-3">
    <div class="col-6">
        <h1 class="h3 mb-3"><strong>Riwayat</strong> Mutasi Stok</h1>
    </div>
</div>

<!-- Filter -->
<div class="card mb-3">
    <div class="card-body py-2">
        <form action="{{ route('riwayat-stok.index') }}" method="GET" class="row align-items-center">
            <div class="col-auto">
                <label class="form-label mb-0 fw-bold">Filter:</label>
            </div>
            <div class="col-auto">
                <select name="stok_id" class="form-select form-select-sm">
                    <option value="">-- Semua Bahan --</option>
                    @foreach($stoks as $stok)
                        <option value="{{ $stok->id }}" {{ request('stok_id') == $stok->id ? 'selected' : '' }}>
                            {{ $stok->nama_bahan }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-auto">
                <select name="tipe" class="form-select form-select-sm">
                    <option value="">-- Semua Tipe --</option>
                    <option value="masuk" {{ request('tipe') == 'masuk' ? 'selected' : '' }}>Masuk</option>
                    <option value="keluar" {{ request('tipe') == 'keluar' ? 'selected' : '' }}>Keluar</option>
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-sm btn-outline-primary">Tampilkan</button>
                <a href="{{ route('riwayat-stok.index') }}" class="btn btn-sm btn-outline-secondary">Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <table class="table table-hover my-0 datatable">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Nama Bahan</th>
                <th>Tipe</th>
                <th>Jumlah</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($riwayats as $r)
            <tr>
                <td>{{ \Carbon\Carbon::parse($r->tanggal)->format('d/m/Y') }}</td>
                <td>
                    <strong>{{ $r->stok->nama_bahan ?? 'N/A' }}</strong>
                    <br><small class="text-muted">{{ $r->stok->id_barang ?? '' }}</small>
                </td>
                <td>
                    @if($r->tipe == 'masuk')
                        <span class="badge bg-success">Masuk</span>
                    @else
                        <span class="badge bg-danger">Keluar</span>
                    @endif
                </td>
                <td>
                    <strong>{{ $r->jumlah }}</strong> {{ $r->stok->satuan ?? '' }}
                </td>
                <td>{{ $r->keterangan ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
