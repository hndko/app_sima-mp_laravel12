@extends('layouts.app-backend')

@section('title', 'Detail Proyek - ' . $proyek->kode_proyek)

@section('content')
{{-- Header --}}
<div class="row mb-3 align-items-center">
    <div class="col">
        <h1 class="h3 mb-0"><strong>Detail Proyek</strong> {{ $proyek->kode_proyek }}</h1>
    </div>
    <div class="col-auto">
        <a href="{{ route('proyek.edit', $proyek->id) }}" class="btn btn-info"><i class="align-middle" data-feather="edit-2"></i> Edit Proyek</a>
        <a href="{{ route('proyek.index') }}" class="btn btn-secondary"><i class="align-middle" data-feather="arrow-left"></i> Kembali</a>
    </div>
</div>

{{-- Flash Messages --}}
@foreach(['success' => 'success', 'error' => 'danger', 'info' => 'info'] as $key => $type)
    @if(session($key))
    <div class="alert alert-{{ $type }} alert-dismissible" role="alert">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <div class="alert-message">{{ session($key) }}</div>
    </div>
    @endif
@endforeach

{{-- Ringkasan Proyek (4 kartu) --}}
@php $grandTotal = $proyek->rincianProyeks->sum('total'); @endphp
<div class="row mb-3">
    <div class="col-md-3 col-sm-6">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col mt-0"><h5 class="card-title">Nilai Dana</h5></div>
                    <div class="col-auto"><div class="stat text-primary"><i class="align-middle" data-feather="dollar-sign"></i></div></div>
                </div>
                <h1 class="mt-1 mb-3 text-success">Rp {{ number_format($proyek->dana_proyek, 0, ',', '.') }}</h1>
                <div class="mb-0"><span class="text-muted">Anggaran proyek</span></div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col mt-0"><h5 class="card-title">Biaya Material</h5></div>
                    <div class="col-auto"><div class="stat text-primary"><i class="align-middle" data-feather="shopping-cart"></i></div></div>
                </div>
                <h1 class="mt-1 mb-3 text-danger">Rp {{ number_format($grandTotal, 0, ',', '.') }}</h1>
                <div class="mb-0"><span class="text-muted">Total pemakaian bahan</span></div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col mt-0"><h5 class="card-title">Sisa Anggaran</h5></div>
                    <div class="col-auto"><div class="stat text-primary"><i class="align-middle" data-feather="trending-up"></i></div></div>
                </div>
                @php $sisa = $proyek->dana_proyek - $grandTotal; @endphp
                <h1 class="mt-1 mb-3 {{ $sisa >= 0 ? 'text-primary' : 'text-danger' }}">Rp {{ number_format($sisa, 0, ',', '.') }}</h1>
                <div class="mb-0"><span class="text-muted">{{ $sisa >= 0 ? 'Margin tersisa' : 'Over budget!' }}</span></div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col mt-0"><h5 class="card-title">Item Rincian</h5></div>
                    <div class="col-auto"><div class="stat text-primary"><i class="align-middle" data-feather="layers"></i></div></div>
                </div>
                <h1 class="mt-1 mb-3">{{ $proyek->rincianProyeks->count() }}</h1>
                <div class="mb-0"><span class="text-muted">Jenis material dipakai</span></div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    {{-- Panel Kiri: Info Proyek --}}
    <div class="col-12 col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Informasi Proyek</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label text-muted small mb-0">Kode Proyek</label>
                    <div class="fw-bold">{{ $proyek->kode_proyek }}</div>
                </div>
                <div class="mb-3">
                    <label class="form-label text-muted small mb-0">Status</label>
                    <div>
                        @if($proyek->status == 'berjalan')
                            <span class="badge bg-warning text-dark">Berjalan</span>
                        @else
                            <span class="badge bg-success">Selesai</span>
                        @endif
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label text-muted small mb-0">Klien</label>
                    <div class="fw-bold">{{ $proyek->klien->nama_klien }}</div>
                </div>
                <div class="row">
                    <div class="col-6 mb-3">
                        <label class="form-label text-muted small mb-0">Tanggal Mulai</label>
                        <div>{{ \Carbon\Carbon::parse($proyek->tanggal_mulai)->format('d M Y') }}</div>
                    </div>
                    <div class="col-6 mb-3">
                        <label class="form-label text-muted small mb-0">Tanggal Selesai</label>
                        <div>{{ $proyek->tanggal_selesai ? \Carbon\Carbon::parse($proyek->tanggal_selesai)->format('d M Y') : '-' }}</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 mb-3">
                        <label class="form-label text-muted small mb-0">Ukuran</label>
                        <div>{{ $proyek->ukuran ?? '-' }} {{ $proyek->satuan }}</div>
                    </div>
                    <div class="col-6 mb-3">
                        <label class="form-label text-muted small mb-0">Nilai Dana</label>
                        <div class="fw-bold text-success">Rp {{ number_format($proyek->dana_proyek, 0, ',', '.') }}</div>
                    </div>
                </div>
                <hr>
                <label class="form-label text-muted small mb-1">Uraian Pekerjaan</label>
                <p class="mb-0">{{ $proyek->uraian }}</p>
            </div>
        </div>
    </div>

    {{-- Panel Kanan: Form + Tabel Rincian --}}
    <div class="col-12 col-lg-8">
        {{-- Form Tambah Rincian --}}
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0"><i class="align-middle" data-feather="plus-circle"></i> Tambah Material / Bahan</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('rincian.store', $proyek->id) }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Pilih dari Stok Gudang</label>
                            <select name="stok_id" class="form-select" id="stok-select">
                                <option value="">-- Input Manual (Non-Gudang) --</option>
                                @foreach($stoks as $stok)
                                    <option value="{{ $stok->id }}" data-satuan="{{ $stok->satuan }}" data-harga="{{ $stok->harga_penjualan }}" data-sisa="{{ $stok->stok }}">
                                        {{ $stok->nama_bahan }} (Sisa: {{ $stok->stok }} {{ $stok->satuan }})
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-muted">Memilih dari gudang akan memotong stok otomatis.</small>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Nama Bahan <span class="text-danger">*</span></label>
                            <input type="text" name="bahan" id="input-bahan" class="form-control" placeholder="Paku Payung">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Harga Satuan (Rp) <span class="text-danger">*</span></label>
                            <input type="number" name="harga" id="input-harga" class="form-control" placeholder="15000">
                        </div>
                    </div>
                    <div class="row align-items-end">
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Jumlah <span class="text-danger">*</span></label>
                            <input type="number" name="jumlah" class="form-control" value="1" min="1" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Satuan <span class="text-danger">*</span></label>
                            <input type="text" name="satuan" id="input-satuan" class="form-control" placeholder="Kg, Sak, Btg" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="align-middle" data-feather="plus"></i> Tambah Material
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Tabel Rincian --}}
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Daftar Rincian Material</h5>
                <span class="badge bg-primary">{{ $proyek->rincianProyeks->count() }} Item</span>
            </div>
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Material</th>
                        <th class="text-center">Jumlah</th>
                        <th class="text-end">Harga Satuan</th>
                        <th class="text-end">Subtotal</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($proyek->rincianProyeks as $i => $rincian)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>
                            <strong>{{ $rincian->bahan }}</strong>
                            @if($rincian->stok_id)
                                <span class="badge bg-success ms-1">Gudang</span>
                            @else
                                <span class="badge bg-secondary ms-1">Bebas</span>
                            @endif
                        </td>
                        <td class="text-center">{{ $rincian->jumlah }} {{ $rincian->satuan }}</td>
                        <td class="text-end">Rp {{ number_format($rincian->harga, 0, ',', '.') }}</td>
                        <td class="text-end fw-bold">Rp {{ number_format($rincian->total, 0, ',', '.') }}</td>
                        <td class="text-center">
                            <form action="{{ route('rincian.destroy', ['proyek' => $proyek->id, 'rincian' => $rincian->id]) }}" method="POST" onsubmit="return confirm('Hapus rincian ini? Stok gudang akan dikembalikan jika bersumber dari Gudang.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="align-middle" data-feather="trash-2"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            <i class="align-middle mb-2" data-feather="inbox" style="width:32px;height:32px;"></i><br>
                            Belum ada pemakaian material yang dicatat.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
                <tfoot class="table-light">
                    <tr>
                        <th colspan="4" class="text-end">Total Biaya Material:</th>
                        <th class="text-end text-danger fs-5">Rp {{ number_format($grandTotal, 0, ',', '.') }}</th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const stokSelect = document.getElementById('stok-select');
        const inputBahan = document.getElementById('input-bahan');
        const inputHarga = document.getElementById('input-harga');
        const inputSatuan = document.getElementById('input-satuan');

        stokSelect.addEventListener('change', function() {
            if(this.value !== "") {
                const opt = this.options[this.selectedIndex];
                inputBahan.value = '';
                inputHarga.value = '';
                inputSatuan.value = opt.getAttribute('data-satuan');
                inputBahan.disabled = true;
                inputHarga.disabled = true;
                inputSatuan.disabled = true;

                inputBahan.classList.add('bg-light');
                inputHarga.classList.add('bg-light');
                inputSatuan.classList.add('bg-light');
            } else {
                inputBahan.disabled = false;
                inputHarga.disabled = false;
                inputSatuan.disabled = false;
                inputSatuan.value = '';

                inputBahan.classList.remove('bg-light');
                inputHarga.classList.remove('bg-light');
                inputSatuan.classList.remove('bg-light');
            }
        });
    });
</script>
@endsection
