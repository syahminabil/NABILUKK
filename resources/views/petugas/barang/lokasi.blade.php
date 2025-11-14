<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Ruang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root { --indigo:#4338ca; --blue:#2563eb; --gray:#f8fafc; --white:#ffffff; --text-dark:#1e293b; }
        body { background-color: var(--gray); font-family:'Segoe UI', sans-serif; color: var(--text-dark); }
        .container-custom { max-width: 900px; margin: 60px auto; background: var(--white); border-radius: 20px; padding: 30px 40px; box-shadow: 0 6px 20px rgba(0,0,0,0.08); border-top: 6px solid var(--blue); }
        h2 { font-weight: 700; color: var(--indigo); }
        .btn-secondary { background: linear-gradient(to right, var(--indigo), var(--blue)); border: none; color: #fff; border-radius: 10px; font-weight: 500; }
        .btn-secondary:hover { opacity: 0.9; transform: translateY(-2px); }
        .list-group-item-action:hover { background-color: #eef2ff; }
    </style>
</head>
<body>
    <div class="container-custom">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h2 class="mb-0">Daftar Ruang</h2>
          <a href="{{ route('petugas.dashboard') }}" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Kembali ke Dashboard</a>
        </div>
        <div class="list-group">
            @foreach($lokasi as $l)
                <a href="{{ route('petugas.item.byLokasi', $l->id_lokasi) }}" class="list-group-item list-group-item-action">
                    {{ $l->nama_lokasi }}
                </a>
            @endforeach
        </div>
    </div>
</body>
</html>
