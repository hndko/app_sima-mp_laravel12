<?php

namespace App\Http\Controllers;

use App\Models\Proyek;
use App\Models\Keuangan;
use App\Models\Karyawan;
use App\Models\HutangPiutang;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function proyekPDF(Proyek $proyek)
    {
        $proyek->load(['klien', 'rincianProyeks']);
        $grandTotal = $proyek->rincianProyeks->sum('total');

        $pdf = Pdf::loadView('backend.laporan.proyek-pdf', compact('proyek', 'grandTotal'));
        return $pdf->download("Laporan_Proyek_{$proyek->kode_proyek}.pdf");
    }

    public function keuanganPDF(Request $request)
    {
        $query = Keuangan::query();

        $bulanLabel = 'Semua Periode';
        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal', date('m', strtotime($request->bulan)))
                  ->whereYear('tanggal', date('Y', strtotime($request->bulan)));
            $bulanLabel = \Carbon\Carbon::parse($request->bulan)->translatedFormat('F Y');
        }

        $keuangans = $query->latest('tanggal')->get();
        $totalPemasukan = (clone $query)->sum('pemasukan');
        $totalPengeluaran = (clone $query)->sum('pengeluaran');

        $pdf = Pdf::loadView('backend.laporan.keuangan-pdf', compact('keuangans', 'totalPemasukan', 'totalPengeluaran', 'bulanLabel'));
        return $pdf->download("Laporan_Keuangan_{$bulanLabel}.pdf");
    }

    public function hutangPiutangPDF($karyawanId)
    {
        $karyawan = Karyawan::findOrFail($karyawanId);
        $rincians = HutangPiutang::where('karyawan_id', $karyawanId)->latest('tanggal')->get();
        $totalHutang = $rincians->where('tipe', 'hutang')->sum('jumlah');
        $totalBayar = $rincians->where('tipe', 'bayar')->sum('jumlah');
        $saldo = $totalHutang - $totalBayar;

        $pdf = Pdf::loadView('backend.laporan.hutang-piutang-pdf', compact('karyawan', 'rincians', 'totalHutang', 'totalBayar', 'saldo'));
        return $pdf->download("Laporan_HutangPiutang_{$karyawan->nama_karyawan}.pdf");
    }
}
