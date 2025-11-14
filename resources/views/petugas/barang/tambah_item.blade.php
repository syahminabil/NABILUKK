<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Barang di {{ $lokasi->nama_lokasi }}</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    :root { --indigo:#4338ca; --blue:#2563eb; --gray:#f8fafc; --white:#ffffff; --text-dark:#1e293b; }
    body { background-color: var(--gray); font-family:'Segoe UI', sans-serif; }
    .container-custom { max-width: 800px; margin: 60px auto; background: var(--white); border-radius: 20px; padding: 35px 40px; box-shadow: 0 6px 20px rgba(0,0,0,0.08); border-top: 6px solid var(--blue); }
    h2 { font-weight: 700; color: var(--indigo); }
    label { font-weight: 600; color: var(--text-dark); }
    .form-control { border-radius: 10px; }
    .form-control:focus { border-color: var(--blue); box-shadow: 0 0 0 0.2rem rgba(37,99,235,.25); }
    .btn-success, .btn-secondary { border: none; border-radius: 10px; }
    .btn-success { background: linear-gradient(to right, var(--indigo), var(--blue)); font-weight: 600; }
    .btn-success:hover { opacity: 0.9; transform: translateY(-2px); }
    @media (max-width: 576px) {
      .container-custom { padding: 20px; }
      h2 { font-size: 1.25rem; }
    }
</style>
</head>
<body>
<div class="container-custom">
    <h2 class="mb-4">Tambah Barang di Ruang: {{ $lokasi->nama_lokasi }}</h2>

    {{-- 🔹 Notifikasi sukses --}}
    @if(session('success'))
        <div class="alert alert-success mt-2">{{ session('success') }}</div>
    @endif

    {{-- 🔹 Notifikasi error --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- 🔹 Form Tambah Barang --}}
    <form action="{{ route('petugas.item.store', $lokasi->id_lokasi) }}" method="POST" enctype="multipart/form-data" class="mt-3">
        @csrf
        {{-- enctype penting agar bisa upload file --}}

        <div class="mb-3">
            <label for="nama_item" class="form-label">Nama Barang</label>
            <input 
                type="text" 
                name="nama_item" 
                id="nama_item"
                class="form-control @error('nama_item') is-invalid @enderror" 
                value="{{ old('nama_item') }}" 
                required
            >
            @error('nama_item')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea 
                name="deskripsi" 
                id="deskripsi" 
                class="form-control @error('deskripsi') is-invalid @enderror"
                rows="3"
            >{{ old('deskripsi') }}</textarea>
            @error('deskripsi')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="foto" class="form-label">Foto Barang</label>
            <input 
                type="file" 
                name="foto" 
                id="foto"
                class="form-control @error('foto') is-invalid @enderror"
                accept="image/*"
            >
            @error('foto')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="text-muted">Opsional, maksimal ukuran 2MB (format: JPG, JPEG, PNG).</small>
        </div>

        <div class="mt-4 d-flex justify-content-between">
            <a href="{{ route('petugas.dashboard') }}" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Kembali ke Dashboard</a>
            <button type="submit" class="btn btn-success">💾 Simpan</button>
        </div>
    </form>
</div>
</body>
</html>
