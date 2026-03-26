<?php

namespace App\Http\Controllers;

use App\Models\HutangPiutang;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HutangPiutangController extends Controller
{
    /**
     * Rekap per karyawan: total pengambilan, total upah, saldo
     */
    public function index()
    {
        $rekap = Karyawan::withSum('hutangPiutangs as total_pengambilan', 'pengambilan')
            ->withSum('hutangPiutangs as total_upah', 'upah')
            ->get()
            ->map(function ($k) {
                $k->saldo = ($k->total_pengambilan ?? 0) - ($k->total_upah ?? 0);
                return $k;
            });

        return view('backend.hutang-piutang.index', compact('rekap'));
    }

    /**
     * Rincian hutang piutang per karyawan
     */
    public function show(Karyawan $karyawan)
    {
        $rincians = HutangPiutang::where('karyawan_id', $karyawan->id)
            ->latest('tanggal')
            ->paginate(15);

        $totalPengambilan = HutangPiutang::where('karyawan_id', $karyawan->id)->sum('pengambilan');
        $totalUpah = HutangPiutang::where('karyawan_id', $karyawan->id)->sum('upah');
        $saldo = $totalPengambilan - $totalUpah;

        return view('backend.hutang-piutang.show', compact('karyawan', 'rincians', 'totalPengambilan', 'totalUpah', 'saldo'));
    }

    /**
     * Form tambah transaksi hutang/piutang untuk karyawan tertentu
     */
    public function create(Request $request)
    {
        $karyawans = Karyawan::all();
        $selectedKaryawan = $request->karyawan_id;
        return view('backend.hutang-piutang.create', compact('karyawans', 'selectedKaryawan'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'karyawan_id' => 'required|exists:karyawans,id',
            'tanggal' => 'required|date',
            'pengambilan' => 'required|numeric|min:0',
            'upah' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
        ]);

        HutangPiutang::create($validated);

        return redirect()->route('hutang-piutang.show', $validated['karyawan_id'])
            ->with('success', 'Transaksi hutang/piutang berhasil dicatat.');
    }

    public function edit(HutangPiutang $hutang_piutang)
    {
        $karyawans = Karyawan::all();
        return view('backend.hutang-piutang.edit', compact('hutang_piutang', 'karyawans'));
    }

    public function update(Request $request, HutangPiutang $hutang_piutang)
    {
        $validated = $request->validate([
            'karyawan_id' => 'required|exists:karyawans,id',
            'tanggal' => 'required|date',
            'pengambilan' => 'required|numeric|min:0',
            'upah' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
        ]);

        $hutang_piutang->update($validated);

        return redirect()->route('hutang-piutang.show', $validated['karyawan_id'])
            ->with('success', 'Transaksi hutang/piutang berhasil diperbarui.');
    }

    public function destroy(HutangPiutang $hutang_piutang)
    {
        $karyawanId = $hutang_piutang->karyawan_id;
        $hutang_piutang->delete();

        return redirect()->route('hutang-piutang.show', $karyawanId)
            ->with('success', 'Transaksi hutang/piutang berhasil dihapus.');
    }
}
