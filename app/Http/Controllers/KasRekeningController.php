<?php

namespace App\Http\Controllers;

use App\Models\KasRekening;
use Illuminate\Http\Request;

class KasRekeningController extends Controller
{
    public function index(Request $request)
    {
        $query = KasRekening::query();

        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal', date('m', strtotime($request->bulan)))
                  ->whereYear('tanggal', date('Y', strtotime($request->bulan)));
        }

        $kasRekenings = $query->latest('tanggal')->paginate(15);

        $totalMasuk = $query->sum('nominal_masuk');
        $totalKeluar = $query->sum('nominal_keluar');
        $saldo = $totalMasuk - $totalKeluar;

        return view('backend.kas-rekening.index', compact('kasRekenings', 'totalMasuk', 'totalKeluar', 'saldo'));
    }

    public function create()
    {
        return view('backend.kas-rekening.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string',
            'nominal_masuk' => 'required|numeric|min:0',
            'nominal_keluar' => 'required|numeric|min:0',
        ]);

        KasRekening::create($validated);

        return redirect()->route('kas-rekening.index')->with('success', 'Mutasi kas rekening berhasil dicatat.');
    }

    public function edit(KasRekening $kas_rekening)
    {
        return view('backend.kas-rekening.edit', compact('kas_rekening'));
    }

    public function update(Request $request, KasRekening $kas_rekening)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string',
            'nominal_masuk' => 'required|numeric|min:0',
            'nominal_keluar' => 'required|numeric|min:0',
        ]);

        $kas_rekening->update($validated);

        return redirect()->route('kas-rekening.index')->with('success', 'Mutasi kas rekening berhasil diperbarui.');
    }

    public function destroy(KasRekening $kas_rekening)
    {
        $kas_rekening->delete();
        return redirect()->route('kas-rekening.index')->with('success', 'Mutasi kas rekening berhasil dihapus.');
    }
}
