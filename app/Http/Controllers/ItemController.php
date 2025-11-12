<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Lokasi;
use App\Models\ListLokasi;
use App\Models\TemporaryItem; // ✅ pastikan kamu punya model ini
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    /**
     * Tampilkan daftar item berdasarkan lokasi
     * URL: GET admin/barang/{id_lokasi}
     */
    public function showByLokasi($id_lokasi)
    {
        $lokasi = Lokasi::findOrFail($id_lokasi);

        $items = ListLokasi::where('id_lokasi', $id_lokasi)
            ->with('item')
            ->get();

        return view('admin.barang.list_item', compact('lokasi', 'items'));
    }

    /**
     * Form tambah item
     * URL: GET admin/barang/{id_lokasi}/tambah
     */
    public function create($id_lokasi)
    {
        $lokasi = Lokasi::findOrFail($id_lokasi);
        return view('admin.barang.tambah_item', compact('lokasi'));
    }

    /**
     * Simpan item baru + histori ke temporary_item
     * URL: POST admin/barang/{id_lokasi}/store
     */
    public function store(Request $request, $id_lokasi)
    {
        $request->validate([
            'nama_item' => 'required|string|max:200',
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $lokasiModel = Lokasi::findOrFail($id_lokasi);

        DB::beginTransaction();
        try {
            // ✅ Simpan ke tabel items
            $item = new Item();
            $item->nama_item = $request->nama_item;
            $item->lokasi = $lokasiModel->nama_lokasi ?? '-';
            $item->deskripsi = $request->deskripsi;

            if ($request->hasFile('foto')) {
                $path = $request->file('foto')->store('foto', 'public');
                $item->foto = $path;
            }

            $item->save();

            // ✅ Simpan ke tabel list_lokasi (relasi antara lokasi dan item)
            ListLokasi::create([
                'id_lokasi' => $id_lokasi,
                'id_item' => $item->id_item,
            ]);

            // ✅ Simpan juga ke tabel temporary_item (histori)
            TemporaryItem::create([
                'id_item' => $item->id_item,
                'nama_barang_baru' => $item->nama_item,
                'lokasi_barang_baru' => $lokasiModel->nama_lokasi ?? '-',
            ]);

            DB::commit();

            return redirect()
                ->route('item.byLokasi', $id_lokasi)
                ->with('success', 'Item berhasil ditambahkan dan disimpan ke histori.');
        } catch (\Throwable $e) {
            DB::rollBack();

            if (isset($path) && Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }

            return back()->withInput()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    /**
     * Form edit item
     * URL: GET admin/barang/edit/{id_item}
     */
    public function edit($id_item)
    {
        $item = Item::findOrFail($id_item);
        return view('admin.barang.edit_item', compact('item'));
    }

    /**
     * Update item dan foto
     * URL: POST admin/barang/update/{id_item}
     */
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

            $listLokasi = ListLokasi::where('id_item', $item->id_item)->first();
            $id_lokasi = $listLokasi ? $listLokasi->id_lokasi : null;

            return redirect()
                ->route('item.byLokasi', $id_lokasi)
                ->with('success', 'Item berhasil diperbarui.');
        } catch (\Throwable $e) {
            DB::rollBack();

            if (isset($newPath) && Storage::disk('public')->exists($newPath)) {
                Storage::disk('public')->delete($newPath);
            }

            return back()->withInput()->withErrors(['error' => 'Gagal memperbarui item: ' . $e->getMessage()]);
        }
    }

    /**
     * Hapus item
     * URL: DELETE admin/barang/delete/{id_item}
     */
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

            return back()->with('success', 'Item berhasil dihapus.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal menghapus item: ' . $e->getMessage()]);
        }
    }
}
