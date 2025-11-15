<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PengaduanController extends Controller
{
    /**
     * 🔹 Simpan pengaduan baru dari user
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_pengaduan' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'lokasi' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $pengaduan = new Pengaduan();
        $pengaduan->id_user = auth()->id();
        $pengaduan->nama_pengaduan = $request->nama_pengaduan;
        $pengaduan->deskripsi = $request->deskripsi;
        $pengaduan->lokasi = $request->lokasi;
        $pengaduan->status = 'Diajukan';

        // 📸 Simpan foto utama sebagai PNG
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = uniqid() . '.png';
            $path = $file->storeAs('public/foto', $filename);
            $pengaduan->foto = 'foto/' . $filename;
        }

        $pengaduan->save();

        return redirect()->route('user.dashboard')->with('success', 'Pengaduan berhasil dikirim.');
    }

    /**
     * Cetak laporan pengaduan berdasarkan ID
     */
    public function cetak($id)
    {
        $pengaduan = Pengaduan::with(['user', 'petugas', 'item'])->findOrFail($id);
        return view('admin.pengaduan.cetak', compact('pengaduan'));
    }

    /**
     * Hapus pengaduan (admin)
     * Admin hanya bisa menghapus jika status: Selesai atau Ditolak
     * Tidak bisa menghapus jika status: Diajukan, Disetujui, atau Diproses
     */
    public function destroy($id)
    {
        $pengaduan = Pengaduan::with('penolakan')->findOrFail($id);

        // Cek status - admin tidak bisa menghapus jika status Diajukan, Disetujui, atau Diproses
        if (in_array($pengaduan->status, ['Diajukan', 'Disetujui', 'Diproses'])) {
            return redirect()->route('dashboard')
                ->with('error', 'Tidak dapat menghapus pengaduan yang statusnya "Diajukan", "Disetujui", atau "Diproses". Hanya bisa menghapus pengaduan dengan status "Selesai" atau "Ditolak".');
        }

        // Hapus file foto di storage/public jika ada
        if ($pengaduan->foto) {
            Storage::disk('public')->delete($pengaduan->foto);
        }

        // Hapus foto saran jika ada
        if ($pengaduan->foto_saran) {
            Storage::disk('public')->delete($pengaduan->foto_saran);
        }

        // Hapus relasi penolakan jika ada
        if ($pengaduan->penolakan) {
            $pengaduan->penolakan->delete();
        }

        $pengaduan->delete();

        return redirect()->route('dashboard')->with('success', 'Pengaduan berhasil dihapus.');
    }

    /**
     * Update pengaduan (admin) - menerima request dari modal edit
     */
    public function update(Request $request, $id)
    {
        $pengaduan = Pengaduan::findOrFail($id);

        $data = $request->validate([
            'nama_pengaduan' => 'required|string|max:255',
            'deskripsi'      => 'nullable|string',
            'lokasi'         => 'nullable|string|max:255',
            'status'         => 'nullable|string|max:50',
            'tgl_pengajuan'  => 'nullable|date',
            'tgl_selesai'    => 'nullable|date',
            'saran_petugas'  => 'nullable|string',
        ]);

        // Jika admin mengubah status menjadi Selesai dan tidak mengisi tanggal selesai,
        // set otomatis ke waktu saat ini supaya tampil di cetak dan dashboard.
        if (isset($data['status']) && $data['status'] === 'Selesai' && empty($data['tgl_selesai'])) {
            $data['tgl_selesai'] = now();
        }

        $pengaduan->update($data);

        if ($request->wantsJson() || $request->isJson()) {
            return response()->json(['success' => true, 'message' => 'Pengaduan berhasil diperbarui.']);
        }

        return redirect()->route('dashboard')->with('success', 'Pengaduan berhasil diperbarui.');
    }

    /**
     * 🔹 Admin menyetujui atau menolak pengaduan
     */
    public function updateStatus(Request $request, $id)
    {
        $pengaduan = Pengaduan::findOrFail($id);

        // Admin menyetujui
        if ($request->status === 'Disetujui') {
            $pengaduan->update([
                'status' => 'Disetujui',
            ]);

            return redirect()->back()->with('success', 'Pengaduan disetujui dan akan diteruskan ke petugas!');
        }

        // Admin menolak
        if ($request->status === 'Ditolak') {
            $request->validate([
                'alasan_penolakan' => 'required|string|max:500',
            ]);

            // Simpan ke tabel penolakan
            \App\Models\Penolakan::create([
                'id_pengaduan' => $pengaduan->id_pengaduan,
                'alasan' => $request->alasan_penolakan,
            ]);

            $pengaduan->update([
                'status' => 'Ditolak',
            ]);

            return redirect()->back()->with('success', 'Pengaduan ditolak dan masuk ke daftar penolakan!');
        }

        return redirect()->back()->with('error', 'Status tidak dikenali.');
    }

    /**
     * 🔹 Petugas memulai penanganan pengaduan (setelah disetujui admin)
     */
    public function mulaiPenanganan($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);

        // Hanya bisa dimulai jika sudah disetujui
        if ($pengaduan->status !== 'Disetujui') {
            return back()->with('error', 'Pengaduan belum disetujui oleh admin.');
        }

        $pengaduan->status = 'Diproses';
        $pengaduan->tgl_mulai = now();
        $pengaduan->save();

        return back()->with('success', 'Penanganan pengaduan telah dimulai.');
    }

    /**
     * 🔹 ADMIN: Menolak pengaduan dengan memberikan saran
     */
    public function tolakWithSaran(Request $request, $id)
    {
        $request->validate([
            'saran_petugas' => 'required|string|min:5|max:1000',
        ]);

        $pengaduan = Pengaduan::findOrFail($id);

        // Update status dan saran
        $pengaduan->update([
            'status' => 'Ditolak',
            'saran_petugas' => $request->saran_petugas,
            'tgl_selesai' => now(),
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'Pengaduan berhasil ditolak dengan saran!');
    }
}