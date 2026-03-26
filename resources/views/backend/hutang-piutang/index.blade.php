@extends('layouts.app-backend')

@section('title', 'Hutang Piutang Karyawan')

@section('content')
<div class="row mb-3">
    <div class="col-6">
        <h1 class="h3 mb-3"><strong>Hutang</strong> Piutang Karyawan</h1>
    </div>
    <div class="col-6 text-end">
        <a href="{{ route('hutang-piutang.create') }}" class="btn btn-primary">Catat Transaksi</a>
    </div>
</div>

@if (session('success'))
<div class="alert alert-success alert-dismissible" role="alert">
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    <div class="alert-message">{{ session('success') }}</div>
</div>
@endif

<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Rekap Saldo per Karyawan</h5>
    </div>
    <table class="table table-hover my-0 datatable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Karyawan</th>
                <th>Total Pengambilan (Kasbon)</th>
                <th>Total Upah Dibayar</th>
                <th>Saldo Hutang</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rekap as $karyawan)
            <tr>
                <td>{{ $karyawan->id_karyawan }}</td>
                <td><strong>{{ $karyawan->nama_karyawan }}</strong></td>
                <td class="text-danger">Rp {{ number_format($karyawan->total_pengambilan ?? 0, 0, ',', '.') }}</td>
                <td class="text-success">Rp {{ number_format($karyawan->total_upah ?? 0, 0, ',', '.') }}</td>
                <td>
                    @if($karyawan->saldo > 0)
                        <span class="badge bg-danger">Hutang: Rp {{ number_format($karyawan->saldo, 0, ',', '.') }}</span>
                    @elseif($karyawan->saldo < 0)
                        <span class="badge bg-success">Lebih bayar: Rp {{ number_format(abs($karyawan->saldo), 0, ',', '.') }}</span>
                    @else
                        <span class="badge bg-secondary">Lunas</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('hutang-piutang.show', $karyawan->id) }}" class="btn btn-sm btn-success">Lihat Rincian</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
