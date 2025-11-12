<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Edit Ruang - Petugas</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h3><i class="fa fa-edit"></i> Edit Ruang</h3>

    <form action="{{ route('petugas.lokasi.crud.update', $lokasi->id_lokasi) }}" method="POST" class="mt-3">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nama_lokasi" class="form-label">Nama Ruang</label>
            <input type="text" id="nama_lokasi" name="nama_lokasi" 
                   value="{{ old('nama_lokasi', $lokasi->nama_lokasi) }}" 
                   class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">
            <i class="fa fa-save"></i> Update
        </button>
        <a href="{{ route('petugas.lokasi.crud.index') }}" class="btn btn-secondary">
            <i class="fa fa-arrow-left"></i> Kembali
        </a>
    </form>
</div>
</body>
</html>