<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Petugas;
use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PetugasController extends Controller
{
    /**
     * 🔹 Menampilkan daftar petugas (admin)
     */
    public function index()
    {
        $petugas = Petugas::with('user')
            ->whereHas('user', fn($q) => $q->where('role', 'petugas'))
            ->get();

        return view('admin.petugas.index', compact('petugas'));
    }

    /**
     * 🔹 Form tambah petugas
     */
    public function create()
    {
        return view('admin.petugas.create');
    }

    /**
     * 🔹 Simpan data petugas ke tabel users & petugas
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'gender'   => 'required|string',
            'telp'     => 'required|string|max:20',
        ]);

        // Buat akun user
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'petugas',
        ]);

        // Buat data petugas
        Petugas::create([
            'user_id' => $user->id,
            'nama'    => $request->name,
            'gender'  => $request->gender === 'Laki-laki' ? 'L' : 'P',
            'telp'    => $request->telp,
        ]);

        return redirect()->route('admin.petugas.index')
            ->with('success', 'Petugas berhasil ditambahkan ke dua tabel!');
    }

    /**
     * 🔹 Form edit role petugas
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.petugas.edit', compact('user'));
    }

    /**
     * 🔹 Update role user & sinkronisasi tabel petugas
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|in:admin,petugas',
        ]);

        $user = User::findOrFail($id);

        if ($request->role === 'admin') {
            // Jika ubah ke admin, hapus dari tabel petugas
            Petugas::where('user_id', $user->id)->delete();
        } else {
            // Jika ubah ke petugas, tambahkan jika belum ada
            Petugas::firstOrCreate(
                ['user_id' => $user->id],
                ['nama' => $user->name, 'gender' => 'L', 'telp' => '-']
            );
        }

        $user->update(['role' => $request->role]);

        return redirect()->route('admin.petugas.index')
            ->with('success', 'Role berhasil diperbarui dan data petugas disinkronkan!');
    }

    /**
     * 🔹 Hapus petugas dan akun user-nya
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user) {
            return redirect()->route('admin.petugas.index')->with('error', 'User tidak ditemukan.');
        }

        Petugas::where('user_id', $user->id)->delete();
        $user->delete();

        return redirect()->route('admin.petugas.index')
            ->with('success', 'Petugas dan akun user berhasil dihapus!');
    }

    /**
     * 🔹 Daftar admin
     */
    public function daftarAdmin()
    {
        $admins = User::where('role', 'admin')->get();
        return view('admin.petugas.admin', compact('admins'));
    }
}