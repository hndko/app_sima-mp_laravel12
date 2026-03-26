<?php

namespace App\Http\Controllers;

use App\Models\Keuangan;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;

class KeuanganController extends Controller
{
    use LogsActivity;
    public function index(Request $request)
    {
        $query = Keuangan::query();

        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal', date('m', strtotime($request->bulan)))
                  ->whereYear('tanggal', date('Y', strtotime($request->bulan)));
        }

        $keuangans = $query->latest('tanggal')->get();

        $totalPemasukan = $query->sum('pemasukan');
        $totalPengeluaran = $query->sum('pengeluaran');

        return view('backend.keuangan.index', compact('keuangans', 'totalPemasukan', 'totalPengeluaran'));
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

        $keuangan = Keuangan::create($validated);
        $this->logActivity('create', 'keuangan', 'Menambahkan transaksi keuangan', null, $keuangan->toArray());

        return redirect()->route('keuangan.index')->with('success', 'Transaksi keuangan berhasil dicatat.');
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

        return redirect()->route('keuangan.index')->with('success', 'Transaksi keuangan berhasil diperbarui.');
    }

    public function destroy(Keuangan $keuangan)
    {
        $this->logActivity('delete', 'keuangan', 'Menghapus transaksi keuangan', $keuangan->toArray(), null);
        $keuangan->delete();
        return redirect()->route('keuangan.index')->with('success', 'Transaksi keuangan berhasil dihapus.');
    }
}
