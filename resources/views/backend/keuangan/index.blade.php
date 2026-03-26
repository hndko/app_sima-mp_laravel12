@extends('layouts.app-backend')

@section('title', 'Kas & Keuangan')

@section('content')
<div class="row mb-3">
    <div class="col-6">
        <h1 class="h3 mb-3"><strong>Kas &</strong> Keuangan</h1>
    </div>
    <div class="col-6 text-end">
        <a href="{{ route('laporan.keuangan.pdf', ['bulan' => request('bulan')]) }}" class="btn btn-danger"><i class="align-middle" data-feather="file-text"></i> Export PDF</a>
        <a href="{{ route('keuangan.create') }}" class="btn btn-primary">Catat Transaksi</a>
    </div>
</div>

@if (session('success'))
<div class="alert alert-success alert-dismissible" role="alert">
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    <div class="alert-message">{{ session('success') }}</div>
</div>
@endif

<!-- Filter Bulan -->
<div class="card mb-3">
    <div class="card-body py-2">
        <form action="{{ route('keuangan.index') }}" method="GET" class="row align-items-center">
            <div class="col-auto">
                <label class="form-label mb-0 fw-bold">Filter Bulan:</label>
            </div>
            <div class="col-auto">
                <input type="month" name="bulan" class="form-control form-control-sm" value="{{ request('bulan') }}">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-sm btn-outline-primary">Tampilkan</button>
                <a href="{{ route('keuangan.index') }}" class="btn btn-sm btn-outline-secondary">Reset</a>
            </div>
        </form>
    </div>
</div>

<!-- Ringkasan -->
<div class="row mb-3">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Total Pemasukan</h5>
                <h3 class="text-success">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Total Pengeluaran</h5>
                <h3 class="text-danger">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Selisih (Laba/Rugi)</h5>
                <h3 class="{{ ($totalPemasukan - $totalPengeluaran) >= 0 ? 'text-success' : 'text-danger' }}">
                    Rp {{ number_format($totalPemasukan - $totalPengeluaran, 0, ',', '.') }}
                </h3>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <table class="table table-hover my-0 datatable">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Kategori</th>
                <th>Sumber Dana</th>
                <th>Uraian</th>
                <th class="text-success">Pemasukan</th>
                <th class="text-danger">Pengeluaran</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($keuangans as $keuangan)
            <tr>
                <td>{{ \Carbon\Carbon::parse($keuangan->tanggal)->format('d/m/Y') }}</td>
                <td>{{ $keuangan->kategori ?? '-' }}</td>
                <td>{{ $keuangan->sumber_dana ?? '-' }}</td>
                <td>{{ \Illuminate\Support\Str::limit($keuangan->uraian, 30) }}</td>
                <td class="text-success">
                    @if($keuangan->pemasukan > 0)
                        Rp {{ number_format($keuangan->pemasukan, 0, ',', '.') }}
                    @else - @endif
                </td>
                <td class="text-danger">
                    @if($keuangan->pengeluaran > 0)
                        Rp {{ number_format($keuangan->pengeluaran, 0, ',', '.') }}
                    @else - @endif
                </td>
                <td>
                    <a href="{{ route('keuangan.edit', $keuangan->id) }}" class="btn btn-sm btn-info">Edit</a>
                    <form action="{{ route('keuangan.destroy', $keuangan->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus transaksi ini?');">
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
