<?php

namespace App\Http\Controllers;

use App\Models\Stok;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;

class StokController extends Controller
{
    use LogsActivity;

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
            'stok_minimum' => 'required|integer|min:0',
            'satuan' => 'nullable|string|max:50',
        ]);

        $stok = Stok::create($validated);
        $this->logActivity('create', 'stok', "Menambahkan stok: {$stok->nama_bahan}", null, $stok->toArray());

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
            'stok_minimum' => 'required|integer|min:0',
            'satuan' => 'nullable|string|max:50',
        ]);

        $dataLama = $stok->toArray();
        $stok->update($validated);
        $this->logActivity('update', 'stok', "Mengupdate stok: {$stok->nama_bahan}", $dataLama, $stok->toArray());

        return redirect()->route('stok.index')->with('success', 'Data Stok berhasil diperbarui.');
    }

    public function destroy(Stok $stok)
    {
        $this->logActivity('delete', 'stok', "Menghapus stok: {$stok->nama_bahan}", $stok->toArray(), null);
        $stok->delete();
        return redirect()->route('stok.index')->with('success', 'Data Stok berhasil dihapus.');
    }
}
