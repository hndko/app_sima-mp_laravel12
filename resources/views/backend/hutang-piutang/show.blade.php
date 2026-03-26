@extends('layouts.app-backend')

@section('title', 'Rincian Hutang Piutang - ' . $karyawan->nama_karyawan)

@section('content')
<div class="row mb-3">
    <div class="col-6">
        <h1 class="h3 mb-3"><strong>Rincian</strong> Hutang Piutang</h1>
    </div>
    <div class="col-6 text-end">
        <a href="{{ route('laporan.hutang-piutang.pdf', $karyawan->id) }}" class="btn btn-danger"><i class="align-middle" data-feather="file-text"></i> Export PDF</a>
        <a href="{{ route('hutang-piutang.index') }}" class="btn btn-secondary">Kembali ke Rekap</a>
        <a href="{{ route('hutang-piutang.create', ['karyawan_id' => $karyawan->id]) }}" class="btn btn-primary">Catat Transaksi</a>
    </div>
</div>

@if (session('success'))
<div class="alert alert-success alert-dismissible" role="alert">
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    <div class="alert-message">{{ session('success') }}</div>
</div>
@endif

<!-- Info Karyawan & Saldo -->
<div class="row mb-3">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h6 class="text-muted">Karyawan</h6>
                <h4>{{ $karyawan->nama_karyawan }}</h4>
                <small class="text-muted">{{ $karyawan->id_karyawan }} &middot; {{ $karyawan->bidang }}</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h6 class="text-muted">Total Pengambilan</h6>
                <h4 class="text-danger">Rp {{ number_format($totalPengambilan, 0, ',', '.') }}</h4>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h6 class="text-muted">Total Upah Dibayar</h6>
                <h4 class="text-success">Rp {{ number_format($totalUpah, 0, ',', '.') }}</h4>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card">
            <div class="card-body">
                <h6 class="text-muted">Saldo</h6>
                <h4 class="{{ $saldo > 0 ? 'text-danger' : ($saldo < 0 ? 'text-success' : 'text-secondary') }}">
                    Rp {{ number_format(abs($saldo), 0, ',', '.') }}
                </h4>
                @if($saldo > 0)
                    <span class="badge bg-danger">Masih Hutang</span>
                @elseif($saldo < 0)
                    <span class="badge bg-success">Lebih Bayar</span>
                @else
                    <span class="badge bg-secondary">Lunas</span>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Tabel Rincian -->
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Riwayat Transaksi</h5>
    </div>
    <table class="table table-hover my-0 datatable">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Pengambilan (Kasbon)</th>
                <th>Upah Dibayar</th>
                <th>Keterangan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rincians as $r)
            <tr>
                <td>{{ \Carbon\Carbon::parse($r->tanggal)->format('d/m/Y') }}</td>
                <td class="text-danger">
                    @if($r->pengambilan > 0)
                        Rp {{ number_format($r->pengambilan, 0, ',', '.') }}
                    @else - @endif
                </td>
                <td class="text-success">
                    @if($r->upah > 0)
                        Rp {{ number_format($r->upah, 0, ',', '.') }}
                    @else - @endif
                </td>
                <td>{{ $r->keterangan ?? '-' }}</td>
                <td>
                    <a href="{{ route('hutang-piutang.edit', $r->id) }}" class="btn btn-sm btn-info">Edit</a>
                    <form action="{{ route('hutang-piutang.destroy', $r->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus transaksi ini?');">
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
