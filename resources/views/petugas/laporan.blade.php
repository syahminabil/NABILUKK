<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Laporan Pengaduan Sarpras</title>
  <style>
    body { font-family: Arial, sans-serif; font-size: 12px; }
    h2 { text-align: center; margin-bottom: 10px; }
    table { width: 100%; border-collapse: collapse; margin-top: 15px; }
    th, td { border: 1px solid #000; padding: 6px; text-align: left; }
    th { background: #2a5298; color: white; }
  </style>
</head>
<body>
  <h2>Laporan Pengaduan Sarpras</h2>
  <table>
    <thead>
      <tr>
        <th>No</th>
        <th>Nama Pelapor</th>
        <th>Judul</th>
        <th>Deskripsi</th>
        <th>Lokasi</th>
        <th>Status</th>
        <th>Tanggal Pengajuan</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($pengaduan as $index => $p)
      <tr>
        <td>{{ $index + 1 }}</td>
        <td>{{ $p->user->name ?? '-' }}</td>
        <td>{{ $p->nama_pengaduan }}</td>
        <td>{{ $p->deskripsi }}</td>
        <td>{{ $p->lokasi }}</td>
        <td>{{ $p->status }}</td>
        <td>{{ \Carbon\Carbon::parse($p->tgl_pengajuan)->format('d M Y') }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
</body>
</html>
