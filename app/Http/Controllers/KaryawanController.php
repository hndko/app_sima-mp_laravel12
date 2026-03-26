<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    public function index()
    {
        $karyawans = Karyawan::latest()->get();
        return view('backend.karyawan.index', compact('karyawans'));
    }

    public function create()
    {
        return view('backend.karyawan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_karyawan' => 'required|unique:karyawans',
            'nama_karyawan' => 'required|string|max:255',
            'bidang' => 'nullable|string|max:255',
            'alamat' => 'nullable|string',
            'no_hp' => 'nullable|string|max:20',
        ]);

        Karyawan::create($validated);

        return redirect()->route('karyawan.index')->with('success', 'Data Karyawan berhasil ditambahkan.');
    }

    public function edit(Karyawan $karyawan)
    {
        return view('backend.karyawan.edit', compact('karyawan'));
    }

    public function update(Request $request, Karyawan $karyawan)
    {
        $validated = $request->validate([
            'id_karyawan' => 'required|unique:karyawans,id_karyawan,' . $karyawan->id,
            'nama_karyawan' => 'required|string|max:255',
            'bidang' => 'nullable|string|max:255',
            'alamat' => 'nullable|string',
            'no_hp' => 'nullable|string|max:20',
        ]);

        $karyawan->update($validated);

        return redirect()->route('karyawan.index')->with('success', 'Data Karyawan berhasil diperbarui.');
    }

    public function destroy(Karyawan $karyawan)
    {
        $karyawan->delete();
        return redirect()->route('karyawan.index')->with('success', 'Data Karyawan berhasil dihapus.');
    }
}
