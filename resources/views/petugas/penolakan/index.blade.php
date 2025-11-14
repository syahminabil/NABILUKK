<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Riwayat Penolakan | Petugas</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <style>
    :root { --indigo:#4338ca; --blue:#2563eb; --gray:#f8fafc; --white:#ffffff; --text-dark:#1e293b; }
    body { background: var(--gray); font-family:'Segoe UI', sans-serif; color: var(--text-dark); }
    .container-custom { max-width: 1100px; margin-top: 60px; margin-left:auto; margin-right:auto; }
    .card { border-radius: 20px; box-shadow: 0 6px 20px rgba(0,0,0,0.08); border: none; }
    .card-header { background: linear-gradient(to right, var(--indigo), var(--blue)); color: #fff; border-top-left-radius: 20px; border-top-right-radius: 20px; }
    .btn-secondary { background: linear-gradient(to right, var(--indigo), var(--blue)); border: none; border-radius: 10px; }
    .btn-secondary:hover { opacity: 0.9; transform: translateY(-2px); }
    table { border-radius: 12px; overflow: hidden; }
    thead { background: linear-gradient(to right, var(--indigo), var(--blue)); color: #fff; }
    td { vertical-align: middle; }
    .text-wrap { white-space: normal !important; word-wrap: break-word; max-width: 350px; }
  </style>
</head>
<body>

<div class="container-custom">
  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <div><i class="fa fa-ban"></i> Riwayat Penolakan Pengaduan</div>
      <a href="{{ route('petugas.dashboard') }}" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Kembali ke Dashboard</a>
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
