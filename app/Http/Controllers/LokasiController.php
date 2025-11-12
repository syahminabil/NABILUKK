<?php

namespace App\Http\Controllers;

use App\Models\Lokasi;

class LokasiController extends Controller
{
    public function index()
    {
        $lokasi = Lokasi::all();
        return view('admin.barang.lokasi', compact('lokasi'));
    }
}
