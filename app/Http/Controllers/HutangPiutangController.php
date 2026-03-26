<?php

namespace App\Http\Controllers;

use App\Models\HutangPiutang;
use App\Models\Karyawan;
use Illuminate\Http\Request;

class HutangPiutangController extends Controller
{
    public function index()
    {
        $hutangPiutangs = HutangPiutang::with('karyawan')->latest()->paginate(15);
        $totalPengambilan = HutangPiutang::sum('pengambilan');
        $totalUpah = HutangPiutang::sum('upah');

        return view('backend.hutang-piutang.index', compact('hutangPiutangs', 'totalPengambilan', 'totalUpah'));
    }

    public function create()
    {
        $karyawans = Karyawan::all();
        return view('backend.hutang-piutang.create', compact('karyawans'));
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

        return redirect()->route('hutang-piutang.index')->with('success', 'Data Hutang/Piutang berhasil ditambahkan.');
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

        return redirect()->route('hutang-piutang.index')->with('success', 'Data Hutang/Piutang berhasil diperbarui.');
    }

    public function destroy(HutangPiutang $hutang_piutang)
    {
        $hutang_piutang->delete();
        return redirect()->route('hutang-piutang.index')->with('success', 'Data Hutang/Piutang berhasil dihapus.');
    }
}
