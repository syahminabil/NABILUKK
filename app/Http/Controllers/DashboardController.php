<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Item;
use App\Models\Pengaduan;
use App\Models\Penolakan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class DashboardController extends Controller
{
    /**
     * 🔹 Dashboard Admin - Menampilkan statistik
     */
    public function index(Request $request)
    {
        $totalUser = User::where('role', 'pengguna')->count();
        $totalPetugas = User::where('role', 'petugas')->count();
        $totalItem = Item::count();
        $totalPengaduan = Pengaduan::count();

        $pengaduanByStatus = Pengaduan::selectRaw('status, COUNT(*) as jumlah')
            ->groupBy('status')
            ->pluck('jumlah', 'status');

        $q = $request->get('q');

        $pengaduanQuery = Pengaduan::with(['user', 'petugas', 'item'])
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
            ->orderBy('tgl_pengajuan', 'desc');

        if ($q) {
            $pengaduanQuery->where(function($builder) use ($q) {
                $builder->where('nama_pengaduan', 'like', "%{$q}%")
                    ->orWhere('deskripsi', 'like', "%{$q}%")
                    ->orWhere('lokasi', 'like', "%{$q}%")
                    ->orWhereHas('user', function($u) use ($q) {
                        $u->where('name', 'like', "%{$q}%");
                    })
                    ->orWhereHas('petugas', function($p) use ($q) {
                        $p->where('nama', 'like', "%{$q}%");
                    });
            });
        }

        $pengaduan = $pengaduanQuery->get();

        return view('admin.dashboard', compact(
            'totalUser',
            'totalPetugas',
            'totalItem',
            'totalPengaduan',
            'pengaduanByStatus',
            'pengaduan'
        ));
    }

    // =============================================
    // 🔹 CRUD USER METHODS - Di DashboardController
    // =============================================

    /**
     * Menampilkan daftar user
     */
    public function userIndex()
    {
        $users = User::where('role', 'pengguna')
                    ->orderBy('created_at', 'desc')
                    ->get();
        
        return view('admin.user.index', compact('users'));
    }

    /**
     * Menampilkan form tambah user
     */
    public function userCreate()
    {
        return view('admin.user.create');
    }

    /**
     * Menyimpan user baru
     */
    public function userStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'pengguna',
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil ditambahkan!');
    }

    /**
     * Menampilkan form edit user
     */
    public function userEdit($id)
    {
        $user = User::where('role', 'pengguna')->findOrFail($id);
        return view('admin.user.edit', compact('user'));
    }

    /**
     * Update user
     */
    public function userUpdate(Request $request, $id)
    {
        $user = User::where('role', 'pengguna')->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil diupdate!');
    }

    /**
     * Hapus user
     */
    public function userDestroy($id)
    {
        // Cegah admin menghapus dirinya sendiri
        if ($id == auth()->id()) {
            return redirect()->back()
                ->with('error', 'Tidak dapat menghapus akun sendiri!');
        }

        $user = User::where('role', 'pengguna')->find($id);

        if (!$user) {
            return redirect()->route('admin.users.index')
                ->with('error', 'User tidak ditemukan!');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil dihapus!');
    }

    /**
     * ✅ Admin menyetujui pengaduan
     */
    public function setujui($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);

        // Hanya bisa disetujui jika masih menunggu
        if ($pengaduan->status !== 'Menunggu') {
            return redirect()->back()->with('error', 'Pengaduan sudah diproses sebelumnya.');
        }

        $pengaduan->update(['status' => 'Disetujui']);

        return redirect()->route('dashboard')->with('success', 'Pengaduan telah disetujui dan siap dikerjakan petugas.');
    }

    /**
     * ❌ Admin menolak pengaduan
     */
    public function tolak(Request $request, $id)
    {
        $request->validate([
            'alasan' => 'required|string|min:5',
        ]);

        $pengaduan = Pengaduan::findOrFail($id);

        if ($pengaduan->status !== 'Menunggu') {
            return redirect()->back()->with('error', 'Pengaduan sudah diproses sebelumnya.');
        }

        // Simpan ke tabel penolakan
        Penolakan::create([
            'id_pengaduan' => $pengaduan->id_pengaduan,
            'alasan' => $request->alasan,
        ]);

        // Update status di pengaduan
        $pengaduan->update(['status' => 'Ditolak']);

        return redirect()->route('dashboard')->with('success', 'Pengaduan berhasil ditolak dan dicatat ke tabel penolakan.');
    }
}