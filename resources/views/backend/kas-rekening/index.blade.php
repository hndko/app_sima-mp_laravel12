@extends('layouts.app-backend')

@section('title', 'Kas Rekening Bank')

@section('content')
<div class="row mb-3">
    <div class="col-6">
        <h1 class="h3 mb-3"><strong>Kas</strong> Rekening Bank</h1>
    </div>
    <div class="col-6 text-end">
        <a href="{{ route('kas-rekening.create') }}" class="btn btn-primary">Catat Mutasi</a>
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
        <form action="{{ route('kas-rekening.index') }}" method="GET" class="row align-items-center">
            <div class="col-auto">
                <label class="form-label mb-0 fw-bold">Filter Bulan:</label>
            </div>
            <div class="col-auto">
                <input type="month" name="bulan" class="form-control form-control-sm" value="{{ request('bulan') }}">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-sm btn-outline-primary">Tampilkan</button>
                <a href="{{ route('kas-rekening.index') }}" class="btn btn-sm btn-outline-secondary">Reset</a>
            </div>
        </form>
    </div>
</div>

<!-- Ringkasan Saldo -->
<div class="row mb-3">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Total Masuk</h5>
                <h3 class="text-success">Rp {{ number_format($totalMasuk, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Total Keluar</h5>
                <h3 class="text-danger">Rp {{ number_format($totalKeluar, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Saldo Rekening</h5>
                <h3 class="{{ $saldo >= 0 ? 'text-primary' : 'text-danger' }}">
                    Rp {{ number_format($saldo, 0, ',', '.') }}
                </h3>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <table class="table table-hover my-0">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Keterangan</th>
                <th class="text-success">Nominal Masuk</th>
                <th class="text-danger">Nominal Keluar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($kasRekenings as $kas)
            <tr>
                <td>{{ \Carbon\Carbon::parse($kas->tanggal)->format('d/m/Y') }}</td>
                <td>{{ \Illuminate\Support\Str::limit($kas->keterangan, 40) }}</td>
                <td class="text-success">
                    @if($kas->nominal_masuk > 0)
                        Rp {{ number_format($kas->nominal_masuk, 0, ',', '.') }}
                    @else - @endif
                </td>
                <td class="text-danger">
                    @if($kas->nominal_keluar > 0)
                        Rp {{ number_format($kas->nominal_keluar, 0, ',', '.') }}
                    @else - @endif
                </td>
                <td>
                    <a href="{{ route('kas-rekening.edit', $kas->id) }}" class="btn btn-sm btn-info">Edit</a>
                    <form action="{{ route('kas-rekening.destroy', $kas->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus mutasi ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">Belum ada mutasi rekening tercatat</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="card-footer">
        {{ $kasRekenings->appends(request()->query())->links() }}
    </div>
</div>
@endsection
