<?php

namespace App\Http\Controllers;

use App\Models\KasRekening;
use Illuminate\Http\Request;

class KasRekeningController extends Controller
{
    public function index()
    {
        $kasRekenings = KasRekening::latest()->paginate(15);
        $totalMasuk = KasRekening::sum('nominal_masuk');
        $totalKeluar = KasRekening::sum('nominal_keluar');
        $saldoBank = $totalMasuk - $totalKeluar;

        return view('backend.kas-rekening.index', compact('kasRekenings', 'totalMasuk', 'totalKeluar', 'saldoBank'));
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

        return redirect()->route('kas-rekening.index')->with('success', 'Data Kas Rekening berhasil ditambahkan.');
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

        return redirect()->route('kas-rekening.index')->with('success', 'Data Kas Rekening berhasil diperbarui.');
    }

    public function destroy(KasRekening $kas_rekening)
    {
        $kas_rekening->delete();
        return redirect()->route('kas-rekening.index')->with('success', 'Data Kas Rekening berhasil dihapus.');
    }
}
