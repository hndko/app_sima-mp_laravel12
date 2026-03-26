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
                            <h1 class="mt-1 mb-3">14</h1>
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
                            <h1 class="mt-1 mb-3">5</h1>
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
                            <h1 class="mt-1 mb-3">Rp 21M</h1>
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
                            <h1 class="mt-1 mb-3">64</h1>
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
                <h5 class="card-title mb-0">Overview Arus Kas</h5>
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
                        <th>Nama Proyek</th>
                        <th class="d-none d-xl-table-cell">Mulai</th>
                        <th class="d-none d-xl-table-cell">Selesai</th>
                        <th>Status</th>
                        <th class="d-none d-md-table-cell">Klien</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Renovasi Gedung A</td>
                        <td class="d-none d-xl-table-cell">01/01/2026</td>
                        <td class="d-none d-xl-table-cell">31/06/2026</td>
                        <td><span class="badge bg-success">Selesai</span></td>
                        <td class="d-none d-md-table-cell">PT Alpha</td>
                    </tr>
                    <tr>
                        <td>Pembangunan Area P</td>
                        <td class="d-none d-xl-table-cell">15/02/2026</td>
                        <td class="d-none d-xl-table-cell">-</td>
                        <td><span class="badge bg-warning">Berjalan</span></td>
                        <td class="d-none d-md-table-cell">Bpk. Budi</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@push('js')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var ctx = document.getElementById("chartjs-dashboard-line").getContext("2d");
        var gradient = ctx.createLinearGradient(0, 0, 0, 225);
        gradient.addColorStop(0, "rgba(215, 227, 244, 1)");
        gradient.addColorStop(1, "rgba(215, 227, 244, 0)");
        // Line chart
        new Chart(document.getElementById("chartjs-dashboard-line"), {
            type: "line",
            data: {
                labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                datasets: [{
                    label: "Pemasukan (Juta)",
                    fill: true,
                    backgroundColor: gradient,
                    borderColor: window.theme.primary,
                    data: [
                        21,
                        15,
                        15,
                        18,
                        15,
                        19,
                        25,
                        24,
                        28,
                        34,
                        29,
                        33
                    ]
                }]
            },
            options: {
                maintainAspectRatio: false,
                legend: {
                    display: false
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
                            color: "rgba(0,0,0,0.0)"
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            stepSize: 10
                        },
                        display: true,
                        borderDash: [3, 3],
                        gridLines: {
                            color: "rgba(0,0,0,0.0)"
                        }
                    }]
                }
            }
        });
    });
</script>
@endpush
