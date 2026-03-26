@extends('layouts.app-backend')

@section('title', 'Manajemen User')

@section('content')
<div class="row mb-3 align-items-center">
    <div class="col">
        <h1 class="h3 mb-0"><strong>Manajemen</strong> User</h1>
    </div>
    <div class="col-auto">
        <a href="{{ route('users.create') }}" class="btn btn-primary"><i class="align-middle" data-feather="plus"></i> Tambah User</a>
    </div>
</div>

@if (session('success'))
<div class="alert alert-success alert-dismissible" role="alert">
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    <div class="alert-message">{{ session('success') }}</div>
</div>
@endif

@if (session('error'))
<div class="alert alert-danger alert-dismissible" role="alert">
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    <div class="alert-message">{{ session('error') }}</div>
</div>
@endif

<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Daftar Akun Pengguna</h5>
    </div>
    <table class="table table-hover my-0 datatable">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th>Terdaftar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td><strong>{{ $user->name }}</strong></td>
                <td>{{ $user->email }}</td>
                <td>
                    @if($user->role == 'admin')
                        <span class="badge bg-danger">Admin</span>
                    @elseif($user->role == 'manajer')
                        <span class="badge bg-primary">Manajer</span>
                    @else
                        <span class="badge bg-success">Keuangan</span>
                    @endif
                </td>
                <td>{{ $user->created_at->format('d M Y') }}</td>
                <td>
                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-info">Edit</a>
                    @if($user->id !== auth()->id())
                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus user ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
