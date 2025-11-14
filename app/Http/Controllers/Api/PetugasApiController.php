<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Petugas;
use Illuminate\Http\Request;

class PetugasApiController extends Controller
{
    /**
     * Get all petugas (admin only)
     * GET /api/petugas
     */
    public function index()
    {
        try {
            $petugas = Petugas::orderBy('created_at', 'desc')
                ->get()
                ->map(function ($item) {
                    return [
                        'id_petugas' => $item->id_petugas,
                        'nama' => $item->nama,
                        'gender' => $item->gender,
                        'telp' => $item->telp,
                        'created_at' => $item->created_at ? $item->created_at->format('Y-m-d H:i:s') : null,
                    ];
                });

            return response()->json([
                'success' => true,
                'data' => $petugas,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}

