<?php

namespace App\Http\Controllers;

use App\Models\Keuangan;
use Illuminate\Http\Request;

class KeuanganController extends Controller
{
    public function index()
    {
        $keuangans = Keuangan::latest()->paginate(15);
        $totalPemasukan = Keuangan::sum('pemasukan');
        $totalPengeluaran = Keuangan::sum('pengeluaran');
        $saldo = $totalPemasukan - $totalPengeluaran;

        return view('backend.keuangan.index', compact('keuangans', 'totalPemasukan', 'totalPengeluaran', 'saldo'));
    }

    public function create()
    {
        return view('backend.keuangan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'kategori' => 'nullable|string|max:255',
            'sumber_dana' => 'nullable|string|max:255',
            'uraian' => 'nullable|string',
            'pemasukan' => 'required|numeric|min:0',
            'pengeluaran' => 'required|numeric|min:0',
        ]);

        Keuangan::create($validated);

        return redirect()->route('keuangan.index')->with('success', 'Data Keuangan berhasil ditambahkan.');
    }

    public function edit(Keuangan $keuangan)
    {
        return view('backend.keuangan.edit', compact('keuangan'));
    }

    public function update(Request $request, Keuangan $keuangan)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'kategori' => 'nullable|string|max:255',
            'sumber_dana' => 'nullable|string|max:255',
            'uraian' => 'nullable|string',
            'pemasukan' => 'required|numeric|min:0',
            'pengeluaran' => 'required|numeric|min:0',
        ]);

        $keuangan->update($validated);

        return redirect()->route('keuangan.index')->with('success', 'Data Keuangan berhasil diperbarui.');
    }

    public function destroy(Keuangan $keuangan)
    {
        $keuangan->delete();
        return redirect()->route('keuangan.index')->with('success', 'Data Keuangan berhasil dihapus.');
    }
}
