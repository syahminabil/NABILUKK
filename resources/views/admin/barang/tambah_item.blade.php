<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Barang di {{ $lokasi->nama_lokasi }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root { --indigo:#4338ca; --blue:#2563eb; --gray:#f8fafc; --white:#ffffff; --text-dark:#1e293b; }
        body { background-color: var(--gray); font-family:'Segoe UI', sans-serif; }
        .container-custom { max-width: 800px; margin: 60px auto; background: var(--white); border-radius: 20px; padding: 35px 40px; box-shadow: 0 6px 20px rgba(0,0,0,0.08); border-top: 6px solid var(--blue); }
        h2 { font-weight: 700; color: var(--indigo); text-align: center; margin-bottom: 25px; }
        label { font-weight: 600; color: var(--text-dark); }
        .form-control, textarea { border-radius: 10px; border: 1px solid #cbd5e1; font-size: 15px; }
        .form-control:focus { border-color: var(--blue); box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.2); }
        .btn-save { background: linear-gradient(to right, var(--indigo), var(--blue)); color: #fff; border: none; border-radius: 10px; padding: 8px 18px; font-weight: 600; transition: 0.25s; }
        .btn-save:hover { opacity: 0.9; transform: translateY(-2px); }
        .btn-back { background: linear-gradient(to right, var(--indigo), var(--blue)); color: #fff; border: none; border-radius: 10px; padding: 8px 18px; font-weight: 600; transition: 0.25s; }
        .btn-back:hover { opacity: 0.9; transform: translateY(-2px); }
        .alert { border-radius: 10px; }
        small.text-muted { font-size: 13px; }
    </style>
</head>
<body>
    <div class="container-custom">
        <h2>🧾 Tambah Barang di Ruang: {{ $lokasi->nama_lokasi }}</h2>

        {{-- ✅ Notifikasi sukses --}}
        @if(session('success'))
            <div class="alert alert-success mt-2">{{ session('success') }}</div>
        @endif

        {{-- ⚠️ Notifikasi error --}}
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- 📦 Form Tambah Barang --}}
        <form action="{{ route('item.store', $lokasi->id_lokasi) }}" method="POST" enctype="multipart/form-data" class="mt-3">
            @csrf

            <div class="mb-3">
                <label for="nama_item" class="form-label">Nama Barang</label>
                <input 
                    type="text" 
                    name="nama_item" 
                    id="nama_item"
                    class="form-control @error('nama_item') is-invalid @enderror" 
                    value="{{ old('nama_item') }}" 
                    placeholder="Masukkan nama barang"
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
                    placeholder="Tulis deskripsi barang (opsional)"
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
                <small class="text-muted">Opsional • Maksimal 2MB • Format: JPG, JPEG, PNG</small>
            </div>

            <div class="d-flex justify-content-end mt-4 gap-2">
                <a href="{{ route('item.byLokasi', $lokasi->id_lokasi) }}" class="btn-back">⬅️ Kembali</a>
                <button type="submit" class="btn-save">💾 Simpan Barang</button>
            </div>
        </form>
    </div>
</body>
</html>
