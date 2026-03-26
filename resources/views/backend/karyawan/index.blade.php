@extends('layouts.app-backend')

@section('title', 'Data Karyawan')

@section('content')
<div class="row mb-3">
    <div class="col-6">
        <h1 class="h3 mb-3"><strong>Data</strong> Karyawan</h1>
    </div>
    <div class="col-6 text-end">
        <a href="{{ route('karyawan.create') }}" class="btn btn-primary">Tambah Karyawan</a>
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
        <h5 class="card-title mb-0">Daftar Karyawan Aktif</h5>
    </div>
    <table class="table table-hover my-0 datatable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Bidang</th>
                <th>No HP</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($karyawans as $karyawan)
            <tr>
                <td>{{ $karyawan->id_karyawan }}</td>
                <td>{{ $karyawan->nama_karyawan }}</td>
                <td>{{ $karyawan->bidang ?? '-' }}</td>
                <td>{{ $karyawan->no_hp ?? '-' }}</td>
                <td>
                    <a href="{{ route('karyawan.edit', $karyawan->id) }}" class="btn btn-sm btn-info">Edit</a>
                    <form action="{{ route('karyawan.destroy', $karyawan->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
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
