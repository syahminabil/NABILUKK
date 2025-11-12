<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Tambah Ruang - Petugas</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h3>Tambah Ruang</h3>

    <form action="{{ route('petugas.lokasi.crud.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Nama Ruang</label>
            <input type="text" name="nama_lokasi" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('petugas.lokasi.crud.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
</body>
</html>