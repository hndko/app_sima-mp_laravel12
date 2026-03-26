<?php

namespace App\Http\Controllers;

use App\Models\Stok;
use Illuminate\Http\Request;

class StokController extends Controller
{
    public function index()
    {
        $stoks = Stok::latest()->get();
        return view('backend.stok.index', compact('stoks'));
    }

    public function create()
    {
        return view('backend.stok.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_barang' => 'required|unique:stoks',
            'nama_bahan' => 'required|string|max:255',
            'harga_perolehan' => 'required|numeric',
            'harga_penjualan' => 'required|numeric',
            'stok' => 'required|integer',
            'satuan' => 'nullable|string|max:50',
        ]);

        Stok::create($validated);

        return redirect()->route('stok.index')->with('success', 'Data Stok berhasil ditambahkan.');
    }

    public function edit(Stok $stok)
    {
        return view('backend.stok.edit', compact('stok'));
    }

    public function update(Request $request, Stok $stok)
    {
        $validated = $request->validate([
            'id_barang' => 'required|unique:stoks,id_barang,' . $stok->id,
            'nama_bahan' => 'required|string|max:255',
            'harga_perolehan' => 'required|numeric',
            'harga_penjualan' => 'required|numeric',
            'stok' => 'required|integer',
            'satuan' => 'nullable|string|max:50',
        ]);

        $stok->update($validated);

        return redirect()->route('stok.index')->with('success', 'Data Stok berhasil diperbarui.');
    }

    public function destroy(Stok $stok)
    {
        $stok->delete();
        return redirect()->route('stok.index')->with('success', 'Data Stok berhasil dihapus.');
    }
}
