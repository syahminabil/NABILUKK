<?php

namespace App\Http\Controllers;

use App\Models\Penolakan;
use Illuminate\Http\Request;

class PenolakanController extends Controller
{
    /**
     * Tampilkan semua data penolakan (hanya untuk petugas)
     */
    public function index()
    {
        // Ambil semua data penolakan, termasuk relasi pengaduan & petugas
        $penolakan = Penolakan::with(['pengaduan', 'petugas'])->orderBy('created_at', 'desc')->get();

        // Kirim ke tampilan
        return view('petugas.penolakan.index', compact('penolakan'));
    }
     public function show($id)
    {
        $penolakan = Penolakan::with(['pengaduan', 'petugas', 'pengaduan.user'])
            ->findOrFail($id);

        return view('admin.penolakan.detail', compact('penolakan'));
    }
}
