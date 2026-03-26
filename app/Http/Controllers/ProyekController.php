<?php

namespace App\Http\Controllers;

use App\Models\Proyek;
use App\Models\Klien;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;

class ProyekController extends Controller
{
    use LogsActivity;

    public function index()
    {
        $proyeks = Proyek::with('klien')->latest()->get();
        return view('backend.proyek.index', compact('proyeks'));
    }

    public function create()
    {
        $kliens = Klien::all();
        return view('backend.proyek.create', compact('kliens'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_proyek' => 'required|unique:proyeks',
            'klien_id' => 'required|exists:kliens,id',
            'uraian' => 'required|string',
            'ukuran' => 'nullable|string|max:255',
            'satuan' => 'nullable|string|max:50',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'dana_proyek' => 'required|numeric|min:0',
            'status' => 'required|in:berjalan,selesai',
            'progres' => 'required|integer|min:0|max:100',
        ]);

        $proyek = Proyek::create($validated);
        $this->logActivity('create', 'proyek', "Menambahkan proyek: {$proyek->kode_proyek}", null, $proyek->toArray());

        return redirect()->route('proyek.index')->with('success', 'Data Proyek berhasil ditambahkan.');
    }

    public function show(Proyek $proyek)
    {
        $proyek->load(['klien', 'rincianProyeks.stok']);
        $stoks = \App\Models\Stok::all();
        return view('backend.proyek.show', compact('proyek', 'stoks'));
    }

    public function edit(Proyek $proyek)
    {
        $kliens = Klien::all();
        return view('backend.proyek.edit', compact('proyek', 'kliens'));
    }

    public function update(Request $request, Proyek $proyek)
    {
        $validated = $request->validate([
            'kode_proyek' => 'required|unique:proyeks,kode_proyek,' . $proyek->id,
            'klien_id' => 'required|exists:kliens,id',
            'uraian' => 'required|string',
            'ukuran' => 'nullable|string|max:255',
            'satuan' => 'nullable|string|max:50',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'dana_proyek' => 'required|numeric|min:0',
            'status' => 'required|in:berjalan,selesai',
            'progres' => 'required|integer|min:0|max:100',
        ]);

        $dataLama = $proyek->toArray();
        $proyek->update($validated);
        $this->logActivity('update', 'proyek', "Mengupdate proyek: {$proyek->kode_proyek}", $dataLama, $proyek->toArray());

        return redirect()->route('proyek.index')->with('success', 'Data Proyek berhasil diperbarui.');
    }

    public function destroy(Proyek $proyek)
    {
        $this->logActivity('delete', 'proyek', "Menghapus proyek: {$proyek->kode_proyek}", $proyek->toArray(), null);
        $proyek->delete();
        return redirect()->route('proyek.index')->with('success', 'Data Proyek beserta seluruh rinciannya berhasil dihapus.');
    }
}
