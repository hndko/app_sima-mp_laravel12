@extends('layouts.app-backend')

@section('title', 'Manajemen Proyek')

@section('content')
<div class="row mb-3">
    <div class="col-6">
        <h1 class="h3 mb-3"><strong>Manajemen</strong> Proyek</h1>
    </div>
    <div class="col-6 text-end">
        <a href="{{ route('proyek.create') }}" class="btn btn-primary">Buka Proyek Baru</a>
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
        <h5 class="card-title mb-0">Daftar Proyek</h5>
    </div>
    <table class="table table-hover my-0">
        <thead>
            <tr>
                <th>Kode</th>
                <th>Klien</th>
                <th>Uraian</th>
                <th>Nilai Dana</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($proyeks as $proyek)
            <tr>
                <td>{{ $proyek->kode_proyek }}</td>
                <td>{{ $proyek->klien->nama_klien }}</td>
                <td>{{ \Illuminate\Support\Str::limit($proyek->uraian, 30) }}</td>
                <td>Rp {{ number_format($proyek->dana_proyek, 0, ',', '.') }}</td>
                <td>
                    @if($proyek->status == 'berjalan')
                        <span class="badge bg-warning text-dark">Berjalan</span>
                    @else
                        <span class="badge bg-success">Selesai</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('proyek.show', $proyek->id) }}" class="btn btn-sm btn-success">MateriRincian & Detail</a>
                    <a href="{{ route('proyek.edit', $proyek->id) }}" class="btn btn-sm btn-info">Edit</a>
                    <form action="{{ route('proyek.destroy', $proyek->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Menghapus proyek akan MENGHAPUS SEMUA RINCIAN BAHAN di dalamnya. Lanjutkan?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">Belum ada Proyek tercatat</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="card-footer">
        {{ $proyeks->links() }}
    </div>
</div>
@endsection
