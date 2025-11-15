<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pengaduan;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Ambil pengaduan beserta petugas dan penolakan
        $pengaduan = Pengaduan::where('id_user', $user->id)
            ->with(['petugas', 'penolakan'])
            ->orderByRaw("
                CASE 
                    WHEN status = 'Diajukan' THEN 1
                    WHEN status = 'Disetujui' THEN 2
                    WHEN status = 'Diproses' THEN 3
                    WHEN status = 'Selesai' THEN 4
                    WHEN status = 'Ditolak' THEN 5
                    ELSE 6
                END
            ")
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.dashboard', compact('user', 'pengaduan'));
    }
}
