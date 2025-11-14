<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Barang: {{ $item->nama_item }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root { --indigo:#4338ca; --blue:#2563eb; --gray:#f8fafc; --white:#ffffff; --text-dark:#1e293b; }
        body { background-color: var(--gray); font-family:'Segoe UI', sans-serif; }
        .container-custom { max-width: 800px; background: var(--white); border-radius: 20px; padding: 30px 40px; margin: 60px auto; box-shadow: 0 6px 20px rgba(0,0,0,0.08); border-top: 6px solid var(--blue); }
        h3 { font-weight: 700; color: var(--indigo); text-align: center; margin-bottom: 25px; }
        label { font-weight: 600; color: var(--text-dark); }
        input.form-control, textarea.form-control { border-radius: 10px; border: 1px solid #cbd5e1; transition: all 0.2s; }
        input.form-control:focus, textarea.form-control:focus { border-color: var(--blue); box-shadow: 0 0 0 0.2rem rgba(37,99,235,0.2); }
        .btn-save { background: linear-gradient(to right, var(--indigo), var(--blue)); color: #fff; border: none; border-radius: 10px; font-weight: 600; padding: 10px 20px; transition: 0.25s; }
        .btn-save:hover { opacity: 0.9; transform: translateY(-2px); }
        .btn-back { background: linear-gradient(to right, var(--indigo), var(--blue)); color: #fff; border: none; border-radius: 10px; font-weight: 500; padding: 10px 20px; transition: 0.25s; }
        .btn-back:hover { opacity: 0.9; transform: translateY(-2px); }
        .alert { border-radius: 10px; }
        .preview-img { width: 150px; height: 150px; object-fit: cover; border-radius: 8px; border: 1px solid #cbd5e1; }
        @media (max-width: 576px) {
          .container-custom { padding: 20px; }
          h3 { font-size: 1.25rem; }
          .preview-img { width: 110px; height: 110px; }
        }
    </style>
</head>
<body>
<div class="container-custom">
    <h3>📝 Edit Barang: {{ $item->nama_item }}</h3>

    {{-- 🔹 Notifikasi sukses --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
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

    {{-- 🔹 Form Edit Barang --}}
    <form action="{{ route('item.update', $item->id_item) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nama_item" class="form-label">Nama Barang</label>
            <input 
                type="text" 
                name="nama_item" 
                id="nama_item"
                class="form-control" 
                value="{{ old('nama_item', $item->nama_item) }}" 
                required
            >
        </div>

        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea 
                name="deskripsi" 
                id="deskripsi" 
                class="form-control"
                rows="3"
            >{{ old('deskripsi', $item->deskripsi) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="foto" class="form-label">Foto Barang</label>
            @if($item->foto)
                <div class="mb-2 text-center">
                    <img src="{{ Storage::url($item->foto) }}" 
                         alt="Foto {{ $item->nama_item }}" 
                         class="preview-img">
                </div>
            @endif
            <input 
                type="file" 
                name="foto" 
                id="foto"
                class="form-control"
                accept="image/*"
            >
            <small class="text-muted">Kosongkan jika tidak ingin mengganti foto (maks. 2MB, JPG/PNG).</small>
        </div>

        <div class="mt-4 d-flex justify-content-between">
            <a href="{{ url()->previous() }}" class="btn-back">⬅️ Kembali</a>
            <button type="submit" class="btn-save">💾 Simpan Perubahan</button>
        </div>
    </form>
</div>
</body>
</html>
