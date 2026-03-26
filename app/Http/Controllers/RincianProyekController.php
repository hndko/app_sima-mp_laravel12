<?php

namespace App\Http\Controllers;

use App\Models\Proyek;
use App\Models\RincianProyek;
use App\Models\Stok;
use App\Models\RiwayatStok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RincianProyekController extends Controller
{
    public function store(Request $request, Proyek $proyek)
    {
        $request->validate([
            'stok_id' => 'nullable|exists:stoks,id',
            'bahan' => 'required_without:stok_id|string|max:255|nullable',
            'jumlah' => 'required|integer|min:1',
            'satuan' => 'required_without:stok_id|string|max:50|nullable',
            'harga' => 'required_without:stok_id|numeric|min:0|nullable',
        ]);

        try {
            DB::beginTransaction();

            $harga = 0;
            $bahan = $request->bahan;
            $satuan = $request->satuan;
            $jumlah = $request->jumlah;

            // Jika milih dari Gudang Stok
            if ($request->filled('stok_id')) {
                $stok = Stok::findOrFail($request->stok_id);
                
                // Cek ketersediaan
                if ($stok->stok < $jumlah) {
                    return back()->with('error', "Oops! Stok '{$stok->nama_bahan}' di gudang tidak mencukupi. Sisa stok: {$stok->stok} {$stok->satuan}");
                }

                // Sesuai asumsi, pakai harga penjualan
                $harga = $stok->harga_penjualan;
                $bahan = $stok->nama_bahan;
                $satuan = $stok->satuan;

                // Potong Stok
                $stok->stok -= $jumlah;
                $stok->save();

                // Catat Riwayat
                RiwayatStok::create([
                    'stok_id' => $stok->id,
                    'tanggal' => now()->toDateString(),
                    'tipe' => 'keluar',
                    'jumlah' => $jumlah,
                    'keterangan' => "Penggunaan Material untuk Proyek: " . $proyek->kode_proyek,
                ]);
            } else {
                // Input manual (beli dari luar, non-gudang stok)
                $harga = $request->harga;
            }

            // Simpan ke Rincian Proyek
            RincianProyek::create([
                'proyek_id' => $proyek->id,
                'stok_id' => $request->stok_id, // Bisa null
                'bahan' => $bahan,
                'jumlah' => $jumlah,
                'satuan' => $satuan,
                'harga' => $harga,
                'total' => $jumlah * $harga,
            ]);

            DB::commit();
            
            return back()->with('success', 'Rincian bahan berhasil ditambahkan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    public function destroy(Proyek $proyek, RincianProyek $rincian)
    {
        try {
            DB::beginTransaction();

            // Jika rincian ini tadinya diambil dari gudang, kembalikan stoknya
            if ($rincian->stok_id) {
                $stok = Stok::find($rincian->stok_id);
                if ($stok) {
                    $stok->stok += $rincian->jumlah;
                    $stok->save();

                    RiwayatStok::create([
                        'stok_id' => $stok->id,
                        'tanggal' => now()->toDateString(),
                        'tipe' => 'masuk',
                        'jumlah' => $rincian->jumlah,
                        'keterangan' => "Pengembalian Material dari Batal Proyek: " . $proyek->kode_proyek,
                    ]);
                }
            }

            $rincian->delete();

            DB::commit();

            return back()->with('info', 'Rincian bahan berhasil dihapus dari Proyek.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }
}
