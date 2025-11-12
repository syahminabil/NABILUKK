<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pengaduan;
use App\Models\Lokasi;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $request->validate([
            'nama_pengaduan' => 'required|string|max:255',
            'isi_laporan' => 'required|string',
            'id_lokasi' => 'required|exists:lokasi,id_lokasi',
            'id_item' => 'required|exists:items,id_item',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $filePath = null;
        if ($request->hasFile('foto')) {
            $filePath = $request->file('foto')->store('pengaduan', 'public');
        }

        // Ambil nama lokasi
        $lokasi = Lokasi::find($request->id_lokasi);

        Pengaduan::create([
            'id_user' => Auth::id(),
            'nama_pengaduan' => $request->nama_pengaduan,
            'deskripsi' => $request->isi_laporan,
            'lokasi' => $lokasi->nama_lokasi ?? '',
            'id_item' => $request->id_item,
            'foto' => $filePath,
            'status' => 'Diajukan',
            'tgl_pengajuan' => now(),
            'id_petugas' => null,
            'saran_petugas' => null,
        ]);

        return redirect()->route('user.dashboard')->with('success', 'Pengaduan berhasil dikirim!');
    }
}
