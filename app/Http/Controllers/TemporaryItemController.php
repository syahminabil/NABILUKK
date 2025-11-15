<?php

namespace App\Http\Controllers;

use App\Models\TemporaryItem;
use App\Models\Item;
use App\Models\Lokasi;
use App\Models\ListLokasi;
use App\Models\Pengaduan;
use App\Models\Penolakan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TemporaryItemController extends Controller
{
    /**
     * Menampilkan daftar temporary items
     */
    public function index()
    {
        $temporaryItems = TemporaryItem::with(['item', 'user'])
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.temporary.index', compact('temporaryItems'));
    }

    /**
     * Form tambah temporary item
     */
    public function create()
    {
        $lokasiList = Lokasi::all();
        return view('admin.temporary.create', compact('lokasiList'));
    }

    /**
     * Simpan temporary item baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_barang_baru' => 'required|string|max:200',
            'lokasi_barang_baru' => 'required|string|max:200',
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        DB::beginTransaction();
        try {
            $fotoPath = null;
            if ($request->hasFile('foto')) {
                $fotoPath = $request->file('foto')->store('foto', 'public');
            }

            $lokasi = Lokasi::where('nama_lokasi', $request->lokasi_barang_baru)->first();
            if (!$lokasi && !empty($request->lokasi_barang_baru)) {
                $lokasi = Lokasi::create([
                    'nama_lokasi' => $request->lokasi_barang_baru,
                ]);
            }

            TemporaryItem::create([
                'id_item' => null, // Belum ada item karena masih temporary
                'nama_barang_baru' => $request->nama_barang_baru,
                'lokasi_barang_baru' => $request->lokasi_barang_baru,
                'id_lokasi' => $lokasi?->id_lokasi,
                'deskripsi_barang_baru' => $request->deskripsi,
                'foto' => $fotoPath,
                'id_pengaduan' => null,
                'id_user' => auth()->id(),
                'status' => 'pending',
            ]);

            DB::commit();

            return redirect()
                ->route('admin.temporary.index')
                ->with('success', 'Barang temporary berhasil ditambahkan. Menunggu persetujuan.');
        } catch (\Throwable $e) {
            DB::rollBack();

            if (isset($fotoPath) && Storage::disk('public')->exists($fotoPath)) {
                Storage::disk('public')->delete($fotoPath);
            }

            return back()->withInput()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    /**
     * Approve temporary item - pindahkan ke items
     */
    public function approve($id)
    {
        $temporaryItem = TemporaryItem::findOrFail($id);

        if ($temporaryItem->status !== 'pending') {
            return redirect()->back()->with('error', 'Item ini sudah diproses sebelumnya.');
        }

        DB::beginTransaction();
        try {
            // Prioritaskan menggunakan id_lokasi yang sudah ada di temporary_item
            if ($temporaryItem->id_lokasi) {
                $lokasi = Lokasi::find($temporaryItem->id_lokasi);
            }
            
            // Jika tidak ada id_lokasi, cari berdasarkan nama
            if (!$lokasi) {
                $lokasi = Lokasi::where('nama_lokasi', $temporaryItem->lokasi_barang_baru)->first();
            }
            
            // Jika lokasi masih tidak ada, buat baru
            if (!$lokasi) {
                $lokasi = Lokasi::create([
                    'nama_lokasi' => $temporaryItem->lokasi_barang_baru,
                ]);
            }

            // Buat item baru
            $item = Item::create([
                'nama_item' => $temporaryItem->nama_barang_baru,
                'lokasi' => $temporaryItem->lokasi_barang_baru,
                'deskripsi' => $temporaryItem->deskripsi_barang_baru,
                'foto' => $temporaryItem->foto,
            ]);

            // Simpan relasi ke list_lokasi
            ListLokasi::create([
                'id_lokasi' => $lokasi->id_lokasi,
                'id_item' => $item->id_item,
            ]);

            $pengaduanId = $temporaryItem->id_pengaduan;

            // Pastikan pengaduan dibuat saat approve
            // Jika belum ada pengaduan, buat baru
            if (!$pengaduanId) {
                // Pastikan id_user ada
                if (!$temporaryItem->id_user) {
                    throw new \Exception('ID User tidak ditemukan pada temporary item.');
                }

                // Buat pengaduan baru dengan data dari temporary_item
                // Gunakan foto_pengaduan jika ada, jika tidak gunakan foto barang
                $fotoPengaduan = $temporaryItem->foto_pengaduan ?? $temporaryItem->foto;
                
                // Jika foto berasal dari temporary (foto barang), salin ke folder pengaduan
                if ($fotoPengaduan && strpos($fotoPengaduan, 'temporary/') !== false) {
                    if (Storage::disk('public')->exists($fotoPengaduan)) {
                        $newFotoPath = 'pengaduan/' . basename($fotoPengaduan);
                        Storage::disk('public')->copy($fotoPengaduan, $newFotoPath);
                        $fotoPengaduan = $newFotoPath;
                    }
                }
                
                $pengaduan = Pengaduan::create([
                    'id_user'        => $temporaryItem->id_user,
                    'nama_pengaduan' => $temporaryItem->judul_pengaduan ?? 'Pengajuan Barang Baru: ' . $temporaryItem->nama_barang_baru,
                    'deskripsi'      => $temporaryItem->deskripsi_pengaduan ?? $temporaryItem->deskripsi_barang_baru ?? '',
                    'lokasi'         => $temporaryItem->lokasi_barang_baru ?? '',
                    'id_item'        => $item->id_item,
                    'foto'           => $fotoPengaduan,
                    'status'         => 'Diajukan',
                    'tgl_pengajuan'  => now(),
                    'id_petugas'     => null,
                    'saran_petugas'  => null,
                ]);

                $pengaduanId = $pengaduan->id_pengaduan;
            } else {
                // Update pengaduan yang sudah ada dengan item baru
                $pengaduan = Pengaduan::find($pengaduanId);
                if ($pengaduan) {
                    $pengaduan->update([
                        'id_item' => $item->id_item,
                    ]);
                } else {
                    // Jika pengaduan tidak ditemukan, buat baru
                    // Gunakan foto_pengaduan jika ada, jika tidak gunakan foto barang
                    $fotoPengaduan = $temporaryItem->foto_pengaduan ?? $temporaryItem->foto;
                    
                    // Jika foto berasal dari temporary (foto barang), salin ke folder pengaduan
                    if ($fotoPengaduan && strpos($fotoPengaduan, 'temporary/') !== false) {
                        if (Storage::disk('public')->exists($fotoPengaduan)) {
                            $newFotoPath = 'pengaduan/' . basename($fotoPengaduan);
                            Storage::disk('public')->copy($fotoPengaduan, $newFotoPath);
                            $fotoPengaduan = $newFotoPath;
                        }
                    }
                    
                    $pengaduan = Pengaduan::create([
                        'id_user'        => $temporaryItem->id_user,
                        'nama_pengaduan' => $temporaryItem->judul_pengaduan ?? 'Pengajuan Barang Baru: ' . $temporaryItem->nama_barang_baru,
                        'deskripsi'      => $temporaryItem->deskripsi_pengaduan ?? $temporaryItem->deskripsi_barang_baru ?? '',
                        'lokasi'         => $temporaryItem->lokasi_barang_baru ?? '',
                        'id_item'        => $item->id_item,
                        'foto'           => $fotoPengaduan,
                        'status'         => 'Diajukan',
                        'tgl_pengajuan'  => now(),
                        'id_petugas'     => null,
                        'saran_petugas'  => null,
                    ]);
                    $pengaduanId = $pengaduan->id_pengaduan;
                }
            }

            // Update temporary item
            $temporaryItem->update([
                'id_item' => $item->id_item,
                'id_pengaduan' => $pengaduanId,
                'status' => 'approved',
            ]);

            DB::commit();

            // Verifikasi bahwa pengaduan sudah dibuat
            $pengaduanCreated = Pengaduan::find($pengaduanId);
            if (!$pengaduanCreated) {
                throw new \Exception('Pengaduan gagal dibuat meskipun tidak ada error.');
            }

            return redirect()
                ->route('admin.temporary.index')
                ->with('success', 'Barang berhasil disetujui dan ditambahkan ke daftar items. Pengaduan juga telah dibuat.');
        } catch (\Throwable $e) {
            DB::rollBack();
            \Log::error('Error approving temporary item: ' . $e->getMessage(), [
                'temporary_item_id' => $id,
                'trace' => $e->getTraceAsString()
            ]);
            return back()->withErrors(['error' => 'Gagal menyetujui item: ' . $e->getMessage()]);
        }
    }

    /**
     * Reject temporary item - masuk ke penolakan
     */
    public function reject(Request $request, $id)
    {
        $request->validate([
            'alasan' => 'required|string|min:5|max:500',
        ]);

        $temporaryItem = TemporaryItem::findOrFail($id);

        if ($temporaryItem->status !== 'pending') {
            return redirect()->back()->with('error', 'Item ini sudah diproses sebelumnya.');
        }

        DB::beginTransaction();
        try {
            // Pastikan ada pengaduan untuk dihubungkan dengan penolakan
            $pengaduanId = $temporaryItem->id_pengaduan;

            // Jika belum ada pengaduan, buat pengaduan baru dengan status Ditolak
            if (!$pengaduanId) {
                if (!$temporaryItem->id_user) {
                    throw new \Exception('ID User tidak ditemukan pada temporary item.');
                }

                // Gunakan foto_pengaduan jika ada, jika tidak gunakan foto barang
                $fotoPengaduan = $temporaryItem->foto_pengaduan ?? $temporaryItem->foto;
                
                // Jika foto berasal dari temporary (foto barang), salin ke folder pengaduan
                if ($fotoPengaduan && strpos($fotoPengaduan, 'temporary/') !== false) {
                    if (Storage::disk('public')->exists($fotoPengaduan)) {
                        $newFotoPath = 'pengaduan/' . basename($fotoPengaduan);
                        Storage::disk('public')->copy($fotoPengaduan, $newFotoPath);
                        $fotoPengaduan = $newFotoPath;
                    }
                }

                $pengaduan = Pengaduan::create([
                    'id_user'        => $temporaryItem->id_user,
                    'nama_pengaduan' => $temporaryItem->judul_pengaduan ?? 'Pengajuan Barang Baru: ' . $temporaryItem->nama_barang_baru,
                    'deskripsi'      => $temporaryItem->deskripsi_pengaduan ?? $temporaryItem->deskripsi_barang_baru ?? '',
                    'lokasi'         => $temporaryItem->lokasi_barang_baru ?? '',
                    'id_item'        => null,
                    'foto'           => $fotoPengaduan,
                    'status'         => 'Ditolak',
                    'tgl_pengajuan'  => now(),
                    'id_petugas'     => null,
                    'saran_petugas'  => null,
                ]);

                $pengaduanId = $pengaduan->id_pengaduan;

                // Update temporary item dengan id_pengaduan
                $temporaryItem->update(['id_pengaduan' => $pengaduanId]);
            } else {
                // Jika sudah ada pengaduan, update status menjadi Ditolak
                $pengaduan = Pengaduan::find($pengaduanId);
                if ($pengaduan) {
                    $pengaduan->update(['status' => 'Ditolak']);
                }
            }

            // Buat record penolakan
            Penolakan::create([
                'id_pengaduan' => $pengaduanId,
                'id_petugas'   => null,
                'alasan'       => $request->alasan,
            ]);

            // Update status temporary item menjadi rejected
            $temporaryItem->update(['status' => 'rejected']);

            DB::commit();

            return redirect()
                ->route('admin.temporary.index')
                ->with('success', 'Barang temporary ditolak dan masuk ke daftar penolakan.');
        } catch (\Throwable $e) {
            DB::rollBack();
            \Log::error('Error rejecting temporary item: ' . $e->getMessage(), [
                'temporary_item_id' => $id,
                'trace' => $e->getTraceAsString()
            ]);
            return back()->withErrors(['error' => 'Gagal menolak item: ' . $e->getMessage()]);
        }
    }

    /**
     * Hapus temporary item
     */
    public function destroy($id)
    {
        $temporaryItem = TemporaryItem::findOrFail($id);

        DB::beginTransaction();
        try {
            // Hapus foto jika ada
            if ($temporaryItem->foto && Storage::disk('public')->exists($temporaryItem->foto)) {
                Storage::disk('public')->delete($temporaryItem->foto);
            }
            if ($temporaryItem->status !== 'approved' && $temporaryItem->foto_pengaduan && Storage::disk('public')->exists($temporaryItem->foto_pengaduan)) {
                Storage::disk('public')->delete($temporaryItem->foto_pengaduan);
            }

            $temporaryItem->delete();

            DB::commit();

            return redirect()
                ->route('admin.temporary.index')
                ->with('success', 'Barang temporary berhasil dihapus.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal menghapus item: ' . $e->getMessage()]);
        }
    }
}

