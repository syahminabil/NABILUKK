<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lokasi;
use Illuminate\Http\Request;

class LokasiApiController extends Controller
{
    /**
     * Get all lokasi
     * GET /api/lokasi
     */
    public function index()
    {
        try {
            $lokasi = Lokasi::orderBy('nama_lokasi', 'asc')
                ->get()
                ->map(function ($item) {
                    return [
                        'id_lokasi' => $item->id_lokasi,
                        'nama_lokasi' => $item->nama_lokasi,
                        'created_at' => $item->created_at ? $item->created_at->format('Y-m-d H:i:s') : null,
                    ];
                });

            return response()->json([
                'success' => true,
                'data' => $lokasi,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}

