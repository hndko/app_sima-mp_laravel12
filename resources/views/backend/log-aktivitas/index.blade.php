@extends('layouts.app-backend')

@section('title', 'Log Aktivitas')

@section('content')
<h1 class="h3 mb-3"><strong>Log</strong> Aktivitas Sistem</h1>

<div class="card mb-3">
    <div class="card-body">
        <form method="GET" class="row align-items-end">
            <div class="col-md-4 mb-2">
                <label class="form-label">Filter Modul</label>
                <select name="modul" class="form-select">
                    <option value="">-- Semua Modul --</option>
                    @foreach($moduls as $m)
                        <option value="{{ $m }}" {{ request('modul') == $m ? 'selected' : '' }}>{{ ucfirst($m) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 mb-2">
                <label class="form-label">Filter User</label>
                <select name="user_id" class="form-select">
                    <option value="">-- Semua User --</option>
                    @foreach($users as $u)
                        <option value="{{ $u->id }}" {{ request('user_id') == $u->id ? 'selected' : '' }}>{{ $u->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 mb-2">
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ route('log-aktivitas.index') }}" class="btn btn-secondary">Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Riwayat Aktivitas</h5>
    </div>
    <table class="table table-hover my-0 datatable">
        <thead>
            <tr>
                <th>Waktu</th>
                <th>User</th>
                <th>Aksi</th>
                <th>Modul</th>
                <th>Deskripsi</th>
                <th>IP</th>
            </tr>
        </thead>
        <tbody>
            @foreach($logs as $log)
            <tr>
                <td>{{ $log->created_at->format('d M Y H:i') }}</td>
                <td><strong>{{ $log->user->name ?? '-' }}</strong></td>
                <td>
                    @if($log->aksi == 'create')
                        <span class="badge bg-success">Create</span>
                    @elseif($log->aksi == 'update')
                        <span class="badge bg-warning text-dark">Update</span>
                    @else
                        <span class="badge bg-danger">Delete</span>
                    @endif
                </td>
                <td>{{ ucfirst($log->modul) }}</td>
                <td>{{ $log->deskripsi }}</td>
                <td><small class="text-muted">{{ $log->ip_address }}</small></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
