@extends('layouts.app-backend')

@section('title', 'Dashboard')

@section('content')
<h1 class="h3 mb-3"><strong>Dashboard</strong> APLIKASI CV</h1>

<div class="row">
    <div class="col-xl-6 col-xxl-5 d-flex">
        <div class="w-100">
            <div class="row">
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col mt-0">
                                    <h5 class="card-title">Total Karyawan</h5>
                                </div>
                                <div class="col-auto">
                                    <div class="stat text-primary">
                                        <i class="align-middle" data-feather="users"></i>
                                    </div>
                                </div>
                            </div>
                            <h1 class="mt-1 mb-3">{{ $totalKaryawan }}</h1>
                            <div class="mb-0">
                                <span class="text-muted">Orang terdaftar</span>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col mt-0">
                                    <h5 class="card-title">Proyek Aktif</h5>
                                </div>
                                <div class="col-auto">
                                    <div class="stat text-primary">
                                        <i class="align-middle" data-feather="briefcase"></i>
                                    </div>
                                </div>
                            </div>
                            <h1 class="mt-1 mb-3">{{ $proyekAktif }}</h1>
                            <div class="mb-0">
                                <span class="text-muted">Sedang berjalan</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col mt-0">
                                    <h5 class="card-title">Saldo Bank</h5>
                                </div>
                                <div class="col-auto">
                                    <div class="stat text-primary">
                                        <i class="align-middle" data-feather="dollar-sign"></i>
                                    </div>
                                </div>
                            </div>
                            <h1 class="mt-1 mb-3">Rp {{ number_format($saldoBank / 1000000, 0, ',', '.') }}M</h1>
                            <div class="mb-0">
                                <span class="text-muted">Kas Rekening</span>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col mt-0">
                                    <h5 class="card-title">Stok Barang</h5>
                                </div>
                                <div class="col-auto">
                                    <div class="stat text-primary">
                                        <i class="align-middle" data-feather="package"></i>
                                    </div>
                                </div>
                            </div>
                            <h1 class="mt-1 mb-3">{{ $totalItemStok }}</h1>
                            <div class="mb-0">
                                <span class="text-muted">Item bahan baku</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-6 col-xxl-7">
        <div class="card flex-fill w-100">
            <div class="card-header">
                <h5 class="card-title mb-0">Overview Arus Kas {{ date('Y') }}</h5>
            </div>
            <div class="card-body py-3">
                <div class="chart chart-sm">
                    <canvas id="chartjs-dashboard-line"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 col-lg-8 col-xxl-9 d-flex">
        <div class="card flex-fill">
            <div class="card-header">
                <h5 class="card-title mb-0">Proyek Terbaru</h5>
            </div>
            <table class="table table-hover my-0">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Uraian Proyek</th>
                        <th class="d-none d-xl-table-cell">Mulai</th>
                        <th>Status</th>
                        <th class="d-none d-md-table-cell">Klien</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($proyekTerbaru as $proyek)
                    <tr>
                        <td><a href="{{ route('proyek.show', $proyek->id) }}">{{ $proyek->kode_proyek }}</a></td>
                        <td>{{ \Illuminate\Support\Str::limit($proyek->uraian, 25) }}</td>
                        <td class="d-none d-xl-table-cell">{{ \Carbon\Carbon::parse($proyek->tanggal_mulai)->format('d/m/Y') }}</td>
                        <td>
                            @if($proyek->status == 'berjalan')
                                <span class="badge bg-warning text-dark">Berjalan</span>
                            @else
                                <span class="badge bg-success">Selesai</span>
                            @endif
                        </td>
                        <td class="d-none d-md-table-cell">{{ $proyek->klien->nama_klien }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">Belum ada proyek</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-12 col-lg-4 col-xxl-3 d-flex">
        <div class="card flex-fill w-100">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="align-middle" data-feather="alert-triangle"></i>
                    Stok Menipis
                </h5>
            </div>
            <div class="card-body d-flex flex-column">
                @forelse($stokMenipis as $stok)
                <div class="d-flex align-items-center mb-3">
                    <div class="flex-grow-1">
                        <strong>{{ $stok->nama_bahan }}</strong>
                        <br>
                        <small class="text-muted">{{ $stok->id_barang }}</small>
                    </div>
                    <div>
                        <span class="badge bg-danger fs-6">{{ $stok->stok }} {{ $stok->satuan }}</span>
                    </div>
                </div>
                @empty
                <p class="text-success mb-0"><i class="align-middle" data-feather="check-circle"></i> Semua stok aman!</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

@endsection

@push('js')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var ctx = document.getElementById("chartjs-dashboard-line").getContext("2d");
        var gradientIn = ctx.createLinearGradient(0, 0, 0, 225);
        gradientIn.addColorStop(0, "rgba(75, 192, 192, 0.3)");
        gradientIn.addColorStop(1, "rgba(75, 192, 192, 0)");

        new Chart(document.getElementById("chartjs-dashboard-line"), {
            type: "line",
            data: {
                labels: {!! json_encode($bulanNama) !!},
                datasets: [{
                    label: "Pemasukan (Juta)",
                    fill: true,
                    backgroundColor: gradientIn,
                    borderColor: "rgb(75, 192, 192)",
                    data: {!! json_encode($chartPemasukan) !!}
                }, {
                    label: "Pengeluaran (Juta)",
                    fill: false,
                    borderColor: "rgb(255, 99, 132)",
                    borderDash: [5, 5],
                    data: {!! json_encode($chartPengeluaran) !!}
                }]
            },
            options: {
                maintainAspectRatio: false,
                legend: {
                    display: true
                },
                tooltips: {
                    intersect: false
                },
                hover: {
                    intersect: true
                },
                plugins: {
                    filler: {
                        propagate: false
                    }
                },
                scales: {
                    xAxes: [{
                        reverse: true,
                        gridLines: {
                            color: "rgba(0,0,0,0.05)"
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            stepSize: 5
                        },
                        display: true,
                        gridLines: {
                            color: "rgba(0,0,0,0.05)"
                        }
                    }]
                }
            }
        });
    });
</script>
@endpush
