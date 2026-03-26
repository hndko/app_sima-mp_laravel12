<?php

namespace App\Http\Controllers;

use App\Models\Klien;
use Illuminate\Http\Request;

class KlienController extends Controller
{
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

        Klien::create($validated);

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

        $klien->update($validated);

        return redirect()->route('klien.index')->with('success', 'Data Klien berhasil diperbarui.');
    }

    public function destroy(Klien $klien)
    {
        $klien->delete();
        return redirect()->route('klien.index')->with('success', 'Data Klien berhasil dihapus.');
    }
}
