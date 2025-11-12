<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lokasi;

class LokasiCrudController extends Controller
{
    public function index()
    {
        $lokasi = Lokasi::all();
        return view('admin.lokasi_crud.index', compact('lokasi'));
    }

    public function create()
    {
        return view('admin.lokasi_crud.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lokasi' => 'required|string|max:255',
        ]);

        Lokasi::create(['nama_lokasi' => $request->nama_lokasi]);

        // ✅ Perbaikan: gunakan nama route lengkap sesuai prefix admin
        return redirect()->route('admin.lokasi.crud.index')->with('success','Ruang berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $lokasi = Lokasi::findOrFail($id);
        return view('admin.lokasi_crud.edit', compact('lokasi'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_lokasi' => 'required|string|max:255',
        ]);

        $lokasi = Lokasi::findOrFail($id);
        $lokasi->update(['nama_lokasi' => $request->nama_lokasi]);

        // ✅ Perbaikan: gunakan nama route lengkap sesuai prefix admin
        return redirect()->route('admin.lokasi.crud.index')->with('success','Ruang berhasil diupdate!');
    }

    public function destroy($id)
    {
        $lokasi = Lokasi::findOrFail($id);
        $lokasi->delete();

        // ✅ Perbaikan: gunakan nama route lengkap sesuai prefix admin
        return redirect()->route('admin.lokasi.crud.index')->with('success','Ruang berhasil dihapus!');
    }
}
