@extends('layouts.app-backend')

@section('title', 'Detail Proyek & Rincian')

@section('content')
<div class="row mb-3">
    <div class="col-6">
        <h1 class="h3 mb-3"><strong>Detail</strong> Proyek</h1>
    </div>
    <div class="col-6 text-end">
        <a href="{{ route('proyek.index') }}" class="btn btn-secondary">Kembali</a>
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

@if (session('info'))
<div class="alert alert-info alert-dismissible" role="alert">
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    <div class="alert-message">{{ session('info') }}</div>
</div>
@endif

<div class="row">
    <div class="col-12 col-md-4">
        <div class="card">
            <div class="card-header pb-0">
                <h5 class="card-title mb-0">Informasi Proyek</h5>
            </div>
            <div class="card-body">
                <table class="table table-sm pb-0 mb-0">
                    <tr>
                        <th width="40%">Kode Proyek</th>
                        <td>: {{ $proyek->kode_proyek }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>: 
                            @if($proyek->status == 'berjalan')
                                <span class="badge bg-warning text-dark">Berjalan</span>
                            @else
                                <span class="badge bg-success">Selesai</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Klien</th>
                        <td>: <strong>{{ $proyek->klien->nama_klien }}</strong></td>
                    </tr>
                    <tr>
                        <th>Tanggal Mulai</th>
                        <td>: {{ \Carbon\Carbon::parse($proyek->tanggal_mulai)->format('d M Y') }}</td>
                    </tr>
                    <tr>
                        <th>Tgl Selesai</th>
                        <td>: {{ $proyek->tanggal_selesai ? \Carbon\Carbon::parse($proyek->tanggal_selesai)->format('d M Y') : '-' }}</td>
                    </tr>
                    <tr>
                        <th>Ukuran Pekerjaan</th>
                        <td>: {{ $proyek->ukuran }} {{ $proyek->satuan }}</td>
                    </tr>
                    <tr>
                        <th>Nilai Dana</th>
                        <td>: <strong class="text-success">Rp {{ number_format($proyek->dana_proyek, 0, ',', '.') }}</strong></td>
                    </tr>
                </table>
                <hr>
                <h6>Uraian Pekerjaan:</h6>
                <p class="text-muted">{{ $proyek->uraian }}</p>
            </div>
        </div>
    </div>

    <!-- Rincian Proyek -->
    <div class="col-12 col-md-8">
        <div class="card">
            <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Rincian Material / Bahan Proyek</h5>
            </div>
            <div class="card-body bg-light">
                <form action="{{ route('rincian.store', $proyek->id) }}" method="POST">
                    @csrf
                    <div class="row align-items-end">
                        <div class="col-md-5 mb-3">
                            <label class="form-label fw-bold">Ambil dari Stok Gudang</label>
                            <select name="stok_id" class="form-select" id="stok-select">
                                <option value="">-- Ketik Manual (Non-Gudang) --</option>
                                @foreach($stoks as $stok)
                                    <option value="{{ $stok->id }}" data-satuan="{{ $stok->satuan }}" data-harga="{{ $stok->harga_penjualan }}" data-sisa="{{ $stok->stok }}">
                                        {{ $stok->nama_bahan }} (Sisa: {{ $stok->stok }})
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-muted">*Memilih dari gudang akan memotong stok otomatis.</small>
                        </div>
                        <div class="col-md-7">
                            <!-- Field Manual jika tidak pilih dari tabel Stok -->
                            <div class="row" id="manual-fields">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nama Bahan <span class="text-danger">*</span></label>
                                    <input type="text" name="bahan" id="input-bahan" class="form-control form-control-sm" placeholder="Contoh: Paku Payung">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Harga Satuan (Rp) <span class="text-danger">*</span></label>
                                    <input type="number" name="harga" id="input-harga" class="form-control form-control-sm" placeholder="15000">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Jumlah Pemakaian <span class="text-danger">*</span></label>
                            <input type="number" name="jumlah" class="form-control" value="1" min="1" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Satuan</label>
                            <input type="text" name="satuan" id="input-satuan" class="form-control" placeholder="Contoh: Kg" required>
                        </div>
                        <div class="col-md-6 mb-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100">Tambah Material Rincian</button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Tabel Daftar Rincian -->
            <table class="table table-bordered table-striped mb-0 mt-3">
                <thead>
                    <tr>
                        <th>Material</th>
                        <th>Jumlah</th>
                        <th>Harga Satuan</th>
                        <th>Subtotal</th>
                        <th>Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    @php $grandTotal = 0; @endphp
                    @forelse($proyek->rincianProyeks as $rincian)
                        @php $grandTotal += $rincian->total; @endphp
                        <tr>
                            <td>
                                {{ $rincian->bahan }}
                                @if($rincian->stok_id)
                                    <span class="badge bg-success ms-1">Gudang</span>
                                @else
                                    <span class="badge bg-secondary ms-1">Bebas</span>
                                @endif
                            </td>
                            <td>{{ $rincian->jumlah }} {{ $rincian->satuan }}</td>
                            <td>Rp {{ number_format($rincian->harga, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($rincian->total, 0, ',', '.') }}</td>
                            <td>
                                <form action="{{ route('rincian.destroy', ['proyek' => $proyek->id, 'rincian' => $rincian->id]) }}" method="POST" onsubmit="return confirm('Hapus rincian ini? Stok gudang akan dikembalikan secara otomatis jika bersumber dari Gudang.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Retur / Batal</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center font-italic text-muted">Belum ada pemakaian material yang dicatat.</td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" class="text-end">Total Biaya Beban Pemakaian:</th>
                        <th colspan="2" class="text-danger">Rp {{ number_format($grandTotal, 0, ',', '.') }}</th>
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
                const selectedOption = this.options[this.selectedIndex];
                inputBahan.value = '';
                inputHarga.value = '';
                inputSatuan.value = selectedOption.getAttribute('data-satuan');
                
                inputBahan.disabled = true;
                inputHarga.disabled = true;
                inputSatuan.disabled = true;
            } else {
                inputBahan.disabled = false;
                inputHarga.disabled = false;
                inputSatuan.disabled = false;
                inputSatuan.value = '';
            }
        });
    });
</script>
@endsection
