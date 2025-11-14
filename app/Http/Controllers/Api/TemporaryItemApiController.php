<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TemporaryItem;
use Illuminate\Http\Request;

class TemporaryItemApiController extends Controller
{
    /**
     * Get all temporary items (read-only for Flutter)
     * GET /api/temporary-items
     * Requires authentication
     */
    public function index(Request $request)
    {
        try {
            $temporaryItems = TemporaryItem::with(['user'])
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($item) {
                    return [
                        'id_temporary' => $item->id_temporary,
                        'nama_barang_baru' => $item->nama_barang_baru,
                        'lokasi_barang_baru' => $item->lokasi_barang_baru,
                        'foto' => $item->foto ? url('storage/' . $item->foto) : null,
                        'status' => $item->status,
                        'user' => $item->user ? [
                            'id' => $item->user->id,
                            'name' => $item->user->name,
                            'email' => $item->user->email,
                        ] : null,
                        'created_at' => $item->created_at ? $item->created_at->format('Y-m-d H:i:s') : null,
                        'updated_at' => $item->updated_at ? $item->updated_at->format('Y-m-d H:i:s') : null,
                    ];
                });

            return response()->json([
                'success' => true,
                'message' => 'Data temporary items berhasil diambil',
                'data' => $temporaryItems,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data temporary items',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get temporary item by ID (read-only for Flutter)
     * GET /api/temporary-items/{id}
     */
    public function show($id)
    {
        try {
            $item = TemporaryItem::with(['user'])->find($id);

            if (!$item) {
                return response()->json([
                    'success' => false,
                    'message' => 'Temporary item tidak ditemukan',
                ], 404);
            }

            $data = [
                'id_temporary' => $item->id_temporary,
                'nama_barang_baru' => $item->nama_barang_baru,
                'lokasi_barang_baru' => $item->lokasi_barang_baru,
                'foto' => $item->foto ? url('storage/' . $item->foto) : null,
                'status' => $item->status,
                'user' => $item->user ? [
                    'id' => $item->user->id,
                    'name' => $item->user->name,
                    'email' => $item->user->email,
                ] : null,
                'created_at' => $item->created_at ? $item->created_at->format('Y-m-d H:i:s') : null,
                'updated_at' => $item->updated_at ? $item->updated_at->format('Y-m-d H:i:s') : null,
            ];

            return response()->json([
                'success' => true,
                'message' => 'Data temporary item berhasil diambil',
                'data' => $data,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data temporary item',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}

