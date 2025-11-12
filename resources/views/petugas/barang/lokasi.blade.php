<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Ruang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <div class="container">
        <h2 class="mb-3">Daftar Ruang</h2>
        <a href="/petugas/dashboard" class="btn btn-secondary">← Kembali ke Dashboard</a>
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
