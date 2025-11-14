<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>ADMIN | Tambah Ruang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root { --indigo:#4338ca; --blue:#2563eb; --gray:#f8fafc; --white:#ffffff; --text-dark:#1e293b; }
        body { background-color: var(--gray); font-family:'Segoe UI', sans-serif; color: var(--text-dark); }
        .container-custom { max-width: 700px; margin: 60px auto; background: var(--white); border-radius: 20px; padding: 30px 40px; box-shadow: 0 6px 20px rgba(0,0,0,0.08); border-top: 6px solid var(--blue); }
        h3 { font-weight: 700; color: var(--indigo); margin-bottom: 25px; }
        label { font-weight: 600; color: var(--text-dark); }
        .form-control { border-radius: 10px; font-size: 14px; padding: 10px; }
        .form-control:focus { border-color: var(--blue); box-shadow: 0 0 0 0.2rem rgba(37,99,235,.25); }
        .btn-submit { background: linear-gradient(to right, var(--indigo), var(--blue)); border: none; color: #fff; border-radius: 10px; font-weight: 600; padding: 8px 16px; transition: 0.25s; }
        .btn-submit:hover { opacity: 0.9; transform: translateY(-2px); }
        .btn-back { background: linear-gradient(to right, var(--indigo), var(--blue)); color:#fff; border: none; border-radius: 10px; font-weight: 500; padding: 8px 16px; transition: 0.25s; text-decoration: none; }
        .btn-back:hover { opacity: 0.9; transform: translateY(-2px); }
        .alert-danger { border-left: 4px solid var(--blue); border-radius: 8px; }
        .alert-danger ul { margin: 0; padding-left: 20px; }
        .alert-danger li { font-size: 14px; }
    </style>
</head>
<body>

<div class="container-custom">
    <h3>➕ Tambah Ruang</h3>

    @if ($errors->any())
    <div class="alert alert-danger">
        <strong>Terjadi kesalahan:</strong>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('admin.lokasi.crud.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="nama_lokasi" class="form-label">Nama Ruang</label>
            <input 
                type="text" 
                name="nama_lokasi" 
                class="form-control" 
                id="nama_lokasi" 
                placeholder="Masukkan nama ruang..." 
                required>
        </div>

        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('admin.lokasi.crud.index') }}" class="btn-back">← Kembali</a>
            <button type="submit" class="btn-submit">💾 Simpan</button>
        </div>
    </form>
</div>

</body>
</html>
