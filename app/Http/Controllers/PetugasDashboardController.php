<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengaduan;
use App\Models\Petugas;
use App\Models\Penolakan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PetugasDashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = Pengaduan::with(['user', 'petugas']);

        // 🔍 Pencarian
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_pengaduan', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $pengaduan = $query->get();
        $pengaduanTerbaru = $query->latest()->take(10)->get();

        $totalPengaduan   = Pengaduan::count();
        $pengaduanProses  = Pengaduan::where('status', 'Diproses')->count();
        $pengaduanSelesai = Pengaduan::where('status', 'Selesai')->count();
        $jumlahPenolakan  = Pengaduan::where('status', 'Ditolak')->count();

        return view('petugas.dashboard', compact(
            'pengaduan',
            'pengaduanTerbaru',
            'totalPengaduan',
            'pengaduanProses',
            'pengaduanSelesai',
            'jumlahPenolakan'
        ));
    }

    // ✅ TERIMA → ubah status ke Disetujui
    public function terima($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);
        $petugas = Petugas::where('user_id', Auth::id())->first();

        if (!$petugas) {
            return back()->with('error', 'Data petugas tidak ditemukan.');
        }

        $pengaduan->update([
            'status' => 'Disetujui',
            'id_petugas' => $petugas->id_petugas,
        ]);

        return back()->with('success', 'Pengaduan telah disetujui!');
    }

    // ✅ MULAI → ubah status ke Diproses
    public function mulai($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);

        // Cek agar hanya pengaduan dengan status Disetujui yang bisa dimulai
        // Petugas tidak bisa memulai jika admin belum menyetujui
        if ($pengaduan->status !== 'Disetujui') {
            return redirect()->back()->with('error', 'Pengaduan belum disetujui oleh admin. Harap tunggu persetujuan admin terlebih dahulu.');
        }

        // Pastikan id_petugas terisi
        $petugas = Petugas::where('user_id', Auth::id())->first();
        if (!$petugas) {
            return redirect()->back()->with('error', 'Data petugas tidak ditemukan.');
        }

        $pengaduan->update([
            'status' => 'Diproses', 
            'id_petugas' => $petugas->id_petugas
        ]);

        return redirect()->route('petugas.dashboard')->with('success', 'Pengaduan telah dimulai dan status diubah menjadi Diproses.');
    }

    public function selesai($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);

        if ($pengaduan->status !== 'Diproses') {
            return redirect()->back()->with('error', 'Hanya pengaduan yang sedang diproses yang bisa diselesaikan.');
        }

        // Pastikan id_petugas terisi
        if (!$pengaduan->id_petugas) {
            $petugas = Petugas::where('user_id', Auth::id())->first();
            if ($petugas) {
                $pengaduan->id_petugas = $petugas->id_petugas;
            }
        }

        $pengaduan->update([
            'status' => 'Selesai',
            'tgl_selesai' => now(),
            'id_petugas' => $pengaduan->id_petugas,
        ]);

        return redirect()->back()->with('success', 'Pengaduan selesai. Sekarang Anda bisa memberikan saran.');
    }

    // ✅ FORM PENOLAKAN
    public function formTolak($id)
    {
        $pengaduan = Pengaduan::with('user')->findOrFail($id);
        return view('petugas.form_penolakan', compact('pengaduan'));
    }

    // ✅ SIMPAN PENOLAKAN
    public function tolak(Request $request, $id)
    {
        $request->validate([
            'alasan' => 'required|string|min:10|max:500'
        ]);

        $pengaduan = Pengaduan::findOrFail($id);
        $petugas = Petugas::where('user_id', Auth::id())->first();

        if (!$petugas) {
            return back()->with('error', 'Data petugas tidak ditemukan.');
        }

        DB::transaction(function () use ($pengaduan, $petugas, $request) {
            $pengaduan->update([
                'status' => 'Ditolak',
                'id_petugas' => $petugas->id_petugas,
            ]);

            Penolakan::create([
                'id_pengaduan' => $pengaduan->id_pengaduan,
                'id_petugas' => $petugas->id_petugas,
                'alasan' => $request->alasan,
            ]);
        });

        return redirect()->route('petugas.dashboard')->with('success', 'Pengaduan ditolak dan dicatat!');
    }

    // ✅ FORM SARAN
    public function formSaran($id)
    {
        $pengaduan = Pengaduan::with('user')->findOrFail($id);
        
        // Pastikan hanya pengaduan selesai yang bisa diberi saran
        if ($pengaduan->status !== 'Selesai') {
            return redirect()->route('petugas.dashboard')->with('error', 'Saran hanya bisa diberikan untuk pengaduan yang sudah selesai.');
        }

        return view('petugas.form_saran', compact('pengaduan'));
    }

    // ✅ KIRIM SARAN
    public function kirimSaran(Request $request, $id)
    {
        $request->validate([
            'saran_petugas' => 'required|string|min:5|max:1000',
            'foto_saran' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $pengaduan = Pengaduan::findOrFail($id);
        
        // Pastikan id_petugas terisi
        if (!$pengaduan->id_petugas) {
            $petugas = Petugas::where('user_id', Auth::id())->first();
            if ($petugas) {
                $pengaduan->id_petugas = $petugas->id_petugas;
            }
        }

        // Update saran petugas
        $pengaduan->saran_petugas = $request->saran_petugas;

        // 📷 Simpan foto saran
        if ($request->hasFile('foto_saran')) {
            // Hapus foto saran lama jika ada
            if ($pengaduan->foto_saran && Storage::disk('public')->exists($pengaduan->foto_saran)) {
                Storage::disk('public')->delete($pengaduan->foto_saran);
            }

            $file = $request->file('foto_saran');
            $extension = strtolower($file->getClientOriginalExtension());
            $filename = uniqid() . '.' . $extension;
            $file->storeAs('public/foto_saran', $filename);
            $pengaduan->foto_saran = 'foto_saran/' . $filename;
        }

        $pengaduan->save();

        return redirect()->route('petugas.dashboard')->with('success', 'Saran petugas berhasil dikirim.');
    }

    // ✅ HAPUS
    public function destroy($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);

        if ($pengaduan->foto) {
            Storage::disk('public')->delete($pengaduan->foto);
        }

        if ($pengaduan->penolakan) {
            $pengaduan->penolakan->delete();
        }

        $pengaduan->delete();

        return redirect()->route('petugas.dashboard')
            ->with('success', 'Pengaduan berhasil dihapus!');
    }
}