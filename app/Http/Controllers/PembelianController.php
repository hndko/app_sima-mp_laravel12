<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\Stok;
use App\Models\RiwayatStok;
use App\Models\Keuangan;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;

class PembelianController extends Controller
{
    use LogsActivity;

    public function index()
    {
        $pembelians = Pembelian::with('stok')->latest()->get();
        return view('backend.pembelian.index', compact('pembelians'));
    }

    public function create()
    {
        $stoks = Stok::orderBy('nama_bahan')->get();
        return view('backend.pembelian.create', compact('stoks'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'stok_id' => 'required|exists:stoks,id',
            'tanggal' => 'required|date',
            'jumlah' => 'required|integer|min:1',
            'harga_satuan' => 'required|integer|min:0',
            'supplier' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        $validated['total'] = $validated['jumlah'] * $validated['harga_satuan'];

        // 1. Buat record pembelian
        $pembelian = Pembelian::create($validated);

        // 2. Tambah stok gudang
        $stok = Stok::find($validated['stok_id']);
        $stok->increment('stok', $validated['jumlah']);

        // 3. Catat riwayat stok (masuk)
        RiwayatStok::create([
            'stok_id' => $stok->id,
            'tipe' => 'masuk',
            'jumlah' => $validated['jumlah'],
            'keterangan' => 'Pembelian dari ' . ($validated['supplier'] ?? 'supplier'),
        ]);

        // 4. Catat pengeluaran di keuangan
        Keuangan::create([
            'tanggal' => $validated['tanggal'],
            'keterangan' => "Pembelian stok: {$stok->nama_bahan} ({$validated['jumlah']} {$stok->satuan})",
            'jenis' => 'keluar',
            'jumlah' => $validated['total'],
        ]);

        $this->logActivity('create', 'pembelian', "Pembelian {$stok->nama_bahan}: {$validated['jumlah']} {$stok->satuan}", null, $pembelian->toArray());

        return redirect()->route('pembelian.index')->with('success', 'Pembelian berhasil dicatat. Stok, riwayat, & keuangan otomatis terupdate.');
    }

    public function destroy(Pembelian $pembelian)
    {
        // Kembalikan stok
        $stok = $pembelian->stok;
        $stok->decrement('stok', $pembelian->jumlah);

        // Catat riwayat stok (keluar / reversal)
        RiwayatStok::create([
            'stok_id' => $stok->id,
            'tipe' => 'keluar',
            'jumlah' => $pembelian->jumlah,
            'keterangan' => 'Pembatalan pembelian dari ' . ($pembelian->supplier ?? 'supplier'),
        ]);

        $this->logActivity('delete', 'pembelian', "Membatalkan pembelian {$stok->nama_bahan}: {$pembelian->jumlah} {$stok->satuan}", $pembelian->toArray(), null);

        $pembelian->delete();

        return redirect()->route('pembelian.index')->with('success', 'Pembelian dibatalkan. Stok dikembalikan.');
    }
}
