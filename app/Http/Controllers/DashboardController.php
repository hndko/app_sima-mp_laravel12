<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Klien;
use App\Models\Proyek;
use App\Models\Stok;
use App\Models\Keuangan;
use App\Models\KasRekening;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Kartu Statistik
        $totalKaryawan = Karyawan::count();
        $proyekAktif = Proyek::where('status', 'berjalan')->count();
        $saldoBank = KasRekening::sum('nominal_masuk') - KasRekening::sum('nominal_keluar');
        $totalItemStok = Stok::count();

        // Proyek Terbaru (5 terakhir)
        $proyekTerbaru = Proyek::with('klien')->latest()->take(5)->get();

        // Stok Menipis (< 20)
        $stokMenipis = Stok::where('stok', '<', 20)->orderBy('stok', 'asc')->take(5)->get();

        // Data Chart: Pemasukan & Pengeluaran per bulan (tahun ini)
        $chartData = Keuangan::selectRaw("
                MONTH(tanggal) as bulan,
                SUM(pemasukan) as total_pemasukan,
                SUM(pengeluaran) as total_pengeluaran
            ")
            ->whereYear('tanggal', date('Y'))
            ->groupByRaw('MONTH(tanggal)')
            ->orderByRaw('MONTH(tanggal)')
            ->get();

        $chartLabels = [];
        $chartPemasukan = array_fill(0, 12, 0);
        $chartPengeluaran = array_fill(0, 12, 0);
        $bulanNama = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

        foreach ($chartData as $row) {
            $idx = $row->bulan - 1;
            $chartPemasukan[$idx] = round($row->total_pemasukan / 1000000, 1); // Dalam juta
            $chartPengeluaran[$idx] = round($row->total_pengeluaran / 1000000, 1);
        }

        return view('backend.dashboard.index', compact(
            'totalKaryawan', 'proyekAktif', 'saldoBank', 'totalItemStok',
            'proyekTerbaru', 'stokMenipis',
            'bulanNama', 'chartPemasukan', 'chartPengeluaran'
        ));
    }
}
