<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pengaduan;
use App\Models\Lokasi;
use App\Models\Item;
use App\Models\TemporaryItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        // Ambil hanya user dengan role 'pengguna'
        $users = User::where('role', 'pengguna')
                ->orderBy('created_at', 'desc')
                ->get();

        // Arahkan ke tampilan resources/views/admin/user/index.blade.php
        return view('admin.user.index', compact('users'));
    }

    /**
     * Formulir pengaduan
     */
    public function create()
    {
        $lokasiList = Lokasi::all();
        $itemList = Item::all(); // untuk default jika ingin menampilkan semua
        return view('user.create', compact('lokasiList', 'itemList'));
    }

    /**
     * Ambil barang berdasarkan lokasi (AJAX)
     */
    public function getBarangByLokasi($id_lokasi)
    {
        $items = Item::where('lokasi', function ($query) use ($id_lokasi) {
            $query->select('nama_lokasi')->from('lokasi')->where('id_lokasi', $id_lokasi)->limit(1);
        })->get(['id_item', 'nama_item']);

        return response()->json($items);
    }

    /**
     * Simpan pengaduan
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pengaduan'   => 'required|string|max:255',
            'isi_laporan'      => 'required_if:barang_mode,existing|nullable|string',
            'id_lokasi'        => 'required|exists:lokasi,id_lokasi',
            'barang_mode'      => 'required|in:existing,new',
            'id_item'          => 'required_if:barang_mode,existing|nullable|exists:items,id_item',
            'nama_barang_baru' => 'required_if:barang_mode,new|nullable|string|max:255',
            'deskripsi_barang' => 'nullable|string',
            'foto'             => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'foto_barang'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'id_item.required_if'          => 'Silakan pilih barang yang ada.',
            'nama_barang_baru.required_if' => 'Silakan isi nama barang baru.',
            'isi_laporan.required_if'      => 'Silakan isi deskripsi pengaduan.',
        ]);

        $fotoPengaduanPath = null;
        $fotoBarangBaruPath = null;

        DB::beginTransaction();
        try {
            $lokasi = Lokasi::findOrFail($validated['id_lokasi']);
            $mode   = $validated['barang_mode'];

            if ($mode === 'existing') {
            if ($request->hasFile('foto')) {
                $fotoPengaduanPath = $request->file('foto')->store('pengaduan', 'public');
            }

                Pengaduan::create([
                    'id_user'        => Auth::id(),
                    'nama_pengaduan' => $validated['nama_pengaduan'],
                    'deskripsi'      => $validated['isi_laporan'],
                    'lokasi'         => $lokasi->nama_lokasi ?? '',
                    'id_item'        => $validated['id_item'],
                    'foto'           => $fotoPengaduanPath,
                    'status'         => 'Diajukan',
                    'tgl_pengajuan'  => now(),
                    'id_petugas'     => null,
                    'saran_petugas'  => null,
                ]);
            } else {
            // Mode: Ajukan Barang Baru - gunakan foto_barang dan deskripsi_barang
            $fotoBarangBaruPath = null;
            $fotoPengaduanPath = null;

            if ($request->hasFile('foto_barang')) {
                $fotoBarangBaruPath = $request->file('foto_barang')->store('temporary', 'public');
                // Gunakan foto barang sebagai foto pengaduan jika tidak ada foto pengaduan
                $fotoPengaduanPath = $fotoBarangBaruPath;
            }

            // Jika ada foto pengaduan (dari form lama), simpan juga
            if ($request->hasFile('foto')) {
                $fotoPengaduanPath = $request->file('foto')->store('pengaduan', 'public');
            }

                TemporaryItem::create([
                    'id_item'               => null,
                    'id_lokasi'             => $lokasi->id_lokasi,
                    'nama_barang_baru'      => $validated['nama_barang_baru'],
                    'lokasi_barang_baru'    => $lokasi->nama_lokasi ?? '',
                    'deskripsi_barang_baru' => $validated['deskripsi_barang'] ?? '',
                    'foto'                  => $fotoBarangBaruPath,
                    'judul_pengaduan'       => $validated['nama_pengaduan'],
                    'deskripsi_pengaduan'   => $validated['isi_laporan'] ?? $validated['deskripsi_barang'] ?? '',
                    'foto_pengaduan'        => $fotoPengaduanPath,
                    'id_pengaduan'          => null,
                    'id_user'               => Auth::id(),
                    'status'                => 'pending',
                ]);
            }

            DB::commit();

            return redirect()
                ->route('user.dashboard')
                ->with('success', $mode === 'existing'
                    ? 'Pengaduan berhasil dikirim!'
                    : 'Pengajuan barang baru berhasil dikirim dan menunggu persetujuan admin.');
        } catch (\Throwable $th) {
            DB::rollBack();

            if ($fotoPengaduanPath && Storage::disk('public')->exists($fotoPengaduanPath)) {
                Storage::disk('public')->delete($fotoPengaduanPath);
            }

            if ($fotoBarangBaruPath && Storage::disk('public')->exists($fotoBarangBaruPath)) {
                Storage::disk('public')->delete($fotoBarangBaruPath);
            }

            return back()
                ->withInput()
                ->withErrors(['error' => 'Terjadi kesalahan: ' . $th->getMessage()]);
        }
    }
}
