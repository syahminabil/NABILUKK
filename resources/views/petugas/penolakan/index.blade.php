<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Riwayat Penolakan | Petugas</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <style>
    body {
      background: #f4f6f9;
      font-family: Arial, sans-serif;
    }
    .container {
      margin-top: 40px;
    }
    .card {
      border-radius: 10px;
      box-shadow: 0 3px 10px rgba(0,0,0,0.1);
    }
    table th {
      background-color: #0d6efd;
      color: white;
      vertical-align: middle;
    }
    td {
      vertical-align: middle;
    }
    .text-wrap {
      white-space: normal !important;
      word-wrap: break-word;
      max-width: 350px;
    }
  </style>
</head>
<body>

<div class="container">
  <div class="card">
    <div class="card-header bg-primary text-white">
      <i class="fa fa-ban"></i> Riwayat Penolakan Pengaduan
      <a href="/petugas/dashboard" class="btn btn-secondary">← Kembali ke Dashboard</a>
    </div>
    <div class="card-body table-responsive">
      @if ($penolakan->isEmpty())
        <p class="text-center text-muted my-3">Belum ada data penolakan.</p>
      @else
        <table class="table table-hover align-middle">
          <thead>
            <tr>
              <th>No</th>
              <th>Judul Pengaduan</th>
              <th>Deskripsi</th>
              <th>Alasan Penolakan</th>
              <th>Petugas Penolak</th>
              <th>Tanggal</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($penolakan as $index => $p)
              <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $p->pengaduan->nama_pengaduan ?? '-' }}</td>
                <td class="text-wrap">{{ $p->pengaduan->deskripsi ?? '-' }}</td>
                <td class="text-wrap">{{ $p->alasan ?? '-' }}</td>
                <td>{{ $p->petugas->nama ?? 'Tidak diketahui' }}</td>
                <td>{{ \Carbon\Carbon::parse($p->created_at)->format('d M Y H:i') }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      @endif
    </div>
  </div>
</div>

</body>
</html>
