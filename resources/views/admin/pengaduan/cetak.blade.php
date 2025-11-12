<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Laporan Pengaduan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { font-family: 'Segoe UI', sans-serif; margin: 40px; }
    .table td { vertical-align: top; }
    .text-center { text-align: center; }
    .foto { max-width: 300px; border-radius: 10px; }
  </style>
</head>
<body>
  <h3 class="text-center mb-4">LAPORAN PENGADUAN</h3>
  <table class="table table-bordered">
    <tr><th width="30%">Nama Pengaduan</th><td>{{ $pengaduan->nama_pengaduan }}</td></tr>
    <tr><th>Lokasi</th><td>{{ $pengaduan->lokasi }}</td></tr>
    <tr><th>Status</th><td>{{ $pengaduan->status }}</td></tr>
    <tr><th>Tanggal Pengajuan</th><td>{{ \Carbon\Carbon::parse($pengaduan->tgl_pengajuan)->format('d-m-Y') }}</td></tr>
    <tr><th>Tanggal Selesai</th><td>{{ $pengaduan->tgl_selesai ? \Carbon\Carbon::parse($pengaduan->tgl_selesai)->format('d-m-Y') : '-' }}</td></tr>
    <tr><th>Deskripsi</th><td>{{ $pengaduan->deskripsi ?? '-' }}</td></tr>
    <tr><th>Nama User</th><td>{{ $pengaduan->user->name ?? '-' }}</td></tr>
    <tr><th>Nama Petugas</th><td>{{ $pengaduan->petugas->nama ?? '-' }}</td></tr>
    <tr><th>Barang</th><td>{{ $pengaduan->item->nama_item ?? '-' }}</td></tr>
    <tr>
      <th>Foto</th>
      <td>
        @if($pengaduan->foto)
          <img src="{{ asset('storage/' . $pengaduan->foto) }}" class="foto">
        @else
          Tidak ada foto
        @endif
      </td>
    </tr>
  </table>

  <div class="text-end mt-5">
    <p><strong>Tanggal Cetak:</strong> {{ now()->format('d-m-Y') }}</p>
    <p><strong>Admin:</strong> {{ Auth::user()->name }}</p>
  </div>

  <script>window.print();</script>
</body>
</html>
