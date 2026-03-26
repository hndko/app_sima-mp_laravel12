<?php

namespace App\Http\Controllers;

use App\Models\Klien;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;

class KlienController extends Controller
{
    use LogsActivity;

    public function index()
    {
        $kliens = Klien::latest()->get();
        return view('backend.klien.index', compact('kliens'));
    }

    public function create()
    {
        return view('backend.klien.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_klien' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'no_hp' => 'nullable|string|max:20',
            'id_instagram' => 'nullable|string|max:255',
            'nama_facebook' => 'nullable|string|max:255',
        ]);

        $klien = Klien::create($validated);
        $this->logActivity('create', 'klien', "Menambahkan klien: {$klien->nama_klien}", null, $klien->toArray());

        return redirect()->route('klien.index')->with('success', 'Data Klien berhasil ditambahkan.');
    }

    public function edit(Klien $klien)
    {
        return view('backend.klien.edit', compact('klien'));
    }

    public function update(Request $request, Klien $klien)
    {
        $validated = $request->validate([
            'nama_klien' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'no_hp' => 'nullable|string|max:20',
            'id_instagram' => 'nullable|string|max:255',
            'nama_facebook' => 'nullable|string|max:255',
        ]);

        $dataLama = $klien->toArray();
        $klien->update($validated);
        $this->logActivity('update', 'klien', "Mengupdate klien: {$klien->nama_klien}", $dataLama, $klien->toArray());

        return redirect()->route('klien.index')->with('success', 'Data Klien berhasil diperbarui.');
    }

    public function destroy(Klien $klien)
    {
        $this->logActivity('delete', 'klien', "Menghapus klien: {$klien->nama_klien}", $klien->toArray(), null);
        $klien->delete();
        return redirect()->route('klien.index')->with('success', 'Data Klien berhasil dihapus.');
    }
}
