<?php

namespace App\Http\Controllers;

use App\Models\RiwayatStok;
use App\Models\Stok;
use Illuminate\Http\Request;

class RiwayatStokController extends Controller
{
    public function index(Request $request)
    {
        $query = RiwayatStok::with('stok');

        if ($request->filled('stok_id')) {
            $query->where('stok_id', $request->stok_id);
        }

        if ($request->filled('tipe')) {
            $query->where('tipe', $request->tipe);
        }

        $riwayats = $query->latest('tanggal')->paginate(20);
        $stoks = Stok::all();

        return view('backend.riwayat-stok.index', compact('riwayats', 'stoks'));
    }
}
