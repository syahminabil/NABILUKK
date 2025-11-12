<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Lokasi;
use App\Models\ListLokasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PetugasItemController extends Controller
{
    public function index()
    {
        $lokasi = Lokasi::all();
        return view('petugas.barang.lokasi', compact('lokasi'));
    }

    public function showByLokasi($id_lokasi)
    {
        $lokasi = Lokasi::findOrFail($id_lokasi);
        $items = ListLokasi::where('id_lokasi', $id_lokasi)->with('item')->get();
        return view('petugas.barang.list_item', compact('lokasi', 'items'));
    }

    public function create($id_lokasi)
    {
        $lokasi = Lokasi::findOrFail($id_lokasi);
        return view('petugas.barang.tambah_item', compact('lokasi'));
    }

    public function store(Request $request, $id_lokasi)
    {
        $request->validate([
            'nama_item' => 'required|string|max:200',
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        DB::beginTransaction();
        try {
            $lokasiModel = Lokasi::findOrFail($id_lokasi);

            $item = new Item();
            $item->nama_item = $request->nama_item;
            $item->lokasi = $lokasiModel->nama_lokasi ?? '-';
            $item->deskripsi = $request->deskripsi;

            if ($request->hasFile('foto')) {
                $path = $request->file('foto')->store('foto', 'public');
                $item->foto = $path;
            }

            $item->save();

            ListLokasi::create([
                'id_lokasi' => $id_lokasi,
                'id_item' => $item->id_item,
            ]);

            DB::commit();
            return redirect()->route('petugas.item.byLokasi', $id_lokasi)->with('success', 'Item berhasil ditambahkan.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal: ' . $e->getMessage()]);
        }
    }

    public function edit($id_item)
    {
        $item = Item::findOrFail($id_item);
        return view('petugas.barang.edit_item', compact('item'));
    }

    public function update(Request $request, $id_item)
    {
        $request->validate([
            'nama_item' => 'required|string|max:200',
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $item = Item::findOrFail($id_item);

        DB::beginTransaction();
        try {
            $item->nama_item = $request->nama_item;
            $item->deskripsi = $request->deskripsi;

            if ($request->hasFile('foto')) {
                if ($item->foto && Storage::disk('public')->exists($item->foto)) {
                    Storage::disk('public')->delete($item->foto);
                }
                $newPath = $request->file('foto')->store('foto', 'public');
                $item->foto = $newPath;
            }

            $item->save();

            DB::commit();
            $listLokasi = ListLokasi::where('id_item', $id_item)->first();
            return redirect()->route('petugas.item.byLokasi', $listLokasi->id_lokasi ?? 1)->with('success', 'Item diperbarui.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal update: ' . $e->getMessage()]);
        }
    }

    public function destroy($id_item)
    {
        $item = Item::findOrFail($id_item);

        DB::beginTransaction();
        try {
            if ($item->foto && Storage::disk('public')->exists($item->foto)) {
                Storage::disk('public')->delete($item->foto);
            }
            ListLokasi::where('id_item', $id_item)->delete();
            $item->delete();

            DB::commit();
            return back()->with('success', 'Item dihapus.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal hapus: ' . $e->getMessage()]);
        }
    }
}
