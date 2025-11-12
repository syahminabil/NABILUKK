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

        // Ambil pengaduan beserta petugas
        $pengaduan = Pengaduan::where('id_user', $user->id)
            ->with('petugas')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.dashboard', compact('user', 'pengaduan'));
    }
}
