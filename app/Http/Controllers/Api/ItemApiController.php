<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Lokasi;
use Illuminate\Http\Request;

class ItemApiController extends Controller
{
    /**
     * Get all items by lokasi
     * GET /api/items?lokasi_id={id}
     */
    public function index(Request $request)
    {
        try {
            $query = Item::query();

            if ($request->has('lokasi_id')) {
                $lokasi = Lokasi::find($request->lokasi_id);
                if ($lokasi) {
                    $query->where('lokasi', $lokasi->nama_lokasi);
                }
            }

            $items = $query->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($item) {
                    return [
                        'id_item' => $item->id_item,
                        'nama_item' => $item->nama_item,
                        'lokasi' => $item->lokasi,
                        'deskripsi' => $item->deskripsi,
                        'foto' => $item->foto ? url('storage/' . $item->foto) : null,
                        'created_at' => $item->created_at ? $item->created_at->format('Y-m-d H:i:s') : null,
                    ];
                });

            return response()->json([
                'success' => true,
                'data' => $items,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}

