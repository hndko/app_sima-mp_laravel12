@extends('layouts.app-backend')

@section('title', 'Data Klien')

@section('content')
<div class="row mb-3">
    <div class="col-6">
        <h1 class="h3 mb-3"><strong>Data</strong> Klien</h1>
    </div>
    <div class="col-6 text-end">
        <a href="{{ route('klien.create') }}" class="btn btn-primary">Tambah Klien</a>
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
        <h5 class="card-title mb-0">Daftar Klien</h5>
    </div>
    <table class="table table-hover my-0 datatable">
        <thead>
            <tr>
                <th>Nama Klien</th>
                <th>No HP</th>
                <th>Instagram</th>
                <th>Facebook</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kliens as $klien)
            <tr>
                <td>{{ $klien->nama_klien }}</td>
                <td>{{ $klien->no_hp ?? '-' }}</td>
                <td>{{ $klien->id_instagram ?? '-' }}</td>
                <td>{{ $klien->nama_facebook ?? '-' }}</td>
                <td>
                    <a href="{{ route('klien.edit', $klien->id) }}" class="btn btn-sm btn-info">Edit</a>
                    <form action="{{ route('klien.destroy', $klien->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
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
