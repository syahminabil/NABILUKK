<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use Illuminate\Http\Request;

class PengaduanApiController extends Controller
{
    /**
     * Get all pengaduan (admin/petugas)
     * GET /api/pengaduan
     */
    public function index(Request $request)
    {
        try {
            $pengaduan = Pengaduan::with(['user', 'petugas', 'item'])
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($item) {
                    return [
                        'id_pengaduan' => $item->id_pengaduan,
                        'nama_pengaduan' => $item->nama_pengaduan,
                        'deskripsi' => $item->deskripsi,
                        'lokasi' => $item->lokasi,
                        'foto' => $item->foto ? url('storage/' . $item->foto) : null,
                        'status' => $item->status,
                        'user' => $item->user ? [
                            'id' => $item->user->id,
                            'name' => $item->user->name,
                            'email' => $item->user->email,
                        ] : null,
                        'petugas' => $item->petugas ? [
                            'id_petugas' => $item->petugas->id_petugas,
                            'nama' => $item->petugas->nama,
                        ] : null,
                        'item' => $item->item ? [
                            'id_item' => $item->item->id_item,
                            'nama_item' => $item->item->nama_item,
                        ] : null,
                        'tgl_pengajuan' => $item->tgl_pengajuan ? $item->tgl_pengajuan->format('Y-m-d') : null,
                        'tgl_selesai' => $item->tgl_selesai ? $item->tgl_selesai->format('Y-m-d') : null,
                        'saran_petugas' => $item->saran_petugas,
                        'created_at' => $item->created_at ? $item->created_at->format('Y-m-d H:i:s') : null,
                    ];
                });

            return response()->json([
                'success' => true,
                'data' => $pengaduan,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get pengaduan by user (pengguna)
     * GET /api/pengaduan/my
     */
    public function myPengaduan(Request $request)
    {
        try {
            $user = $request->user();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User tidak ditemukan',
                ], 401);
            }

            $pengaduan = Pengaduan::where('id_user', $user->id)
                ->with(['petugas', 'item'])
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($item) {
                    try {
                        $tglPengajuan = null;
                        if ($item->tgl_pengajuan) {
                            if (is_string($item->tgl_pengajuan)) {
                                $tglPengajuan = $item->tgl_pengajuan;
                            } else {
                                $tglPengajuan = $item->tgl_pengajuan->format('Y-m-d');
                            }
                        } elseif ($item->created_at) {
                            $tglPengajuan = $item->created_at->format('Y-m-d');
                        }

                        $tglSelesai = null;
                        if ($item->tgl_selesai) {
                            if (is_string($item->tgl_selesai)) {
                                $tglSelesai = $item->tgl_selesai;
                            } else {
                                $tglSelesai = $item->tgl_selesai->format('Y-m-d');
                            }
                        }

                        return [
                            'id_pengaduan' => $item->id_pengaduan,
                            'nama_pengaduan' => $item->nama_pengaduan ?? '',
                            'deskripsi' => $item->deskripsi,
                            'lokasi' => $item->lokasi,
                            'foto' => $item->foto ? url('storage/' . $item->foto) : null,
                            'status' => $item->status ?? 'Diajukan',
                            'petugas' => $item->petugas ? [
                                'id_petugas' => $item->petugas->id_petugas,
                                'nama' => $item->petugas->nama ?? '-',
                            ] : null,
                            'item' => $item->item ? [
                                'id_item' => $item->item->id_item,
                                'nama_item' => $item->item->nama_item ?? '-',
                            ] : null,
                            'tgl_pengajuan' => $tglPengajuan,
                            'tgl_selesai' => $tglSelesai,
                            'saran_petugas' => $item->saran_petugas,
                            'created_at' => $item->created_at ? $item->created_at->format('Y-m-d H:i:s') : null,
                        ];
                    } catch (\Exception $e) {
                        \Log::error('Error mapping pengaduan: ' . $e->getMessage());
                        return null;
                    }
                })
                ->filter()
                ->values();

            return response()->json([
                'success' => true,
                'data' => $pengaduan,
                'count' => $pengaduan->count(),
            ], 200);
        } catch (\Exception $e) {
            \Log::error('Error in myPengaduan: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get pengaduan ditolak (petugas)
     * GET /api/pengaduan/ditolak
     */
    public function ditolak(Request $request)
    {
        try {
            $pengaduan = Pengaduan::where('status', 'Ditolak')
                ->with(['user', 'item'])
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($item) {
                    return [
                        'id_pengaduan' => $item->id_pengaduan,
                        'nama_pengaduan' => $item->nama_pengaduan,
                        'deskripsi' => $item->deskripsi,
                        'lokasi' => $item->lokasi,
                        'foto' => $item->foto ? url('storage/' . $item->foto) : null,
                        'status' => $item->status,
                        'user' => $item->user ? [
                            'id' => $item->user->id,
                            'name' => $item->user->name,
                            'email' => $item->user->email,
                        ] : null,
                        'item' => $item->item ? [
                            'id_item' => $item->item->id_item,
                            'nama_item' => $item->item->nama_item,
                        ] : null,
                        'tgl_pengajuan' => $item->tgl_pengajuan ? $item->tgl_pengajuan->format('Y-m-d') : null,
                        'saran_petugas' => $item->saran_petugas,
                        'created_at' => $item->created_at ? $item->created_at->format('Y-m-d H:i:s') : null,
                    ];
                });

            return response()->json([
                'success' => true,
                'data' => $pengaduan,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}

