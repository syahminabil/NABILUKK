<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Barang di {{ $lokasi->nama_lokasi }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4 bg-light">
<div class="container">
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

        <div class="mt-4">
            <button type="submit" class="btn btn-success">💾 Simpan</button>
            <a href="{{ route('petugas.item.byLokasi', $lokasi->id_lokasi) }}" class="btn btn-secondary">⬅️ Kembali</a>
        </div>
    </form>
</div>
</body>
</html>
