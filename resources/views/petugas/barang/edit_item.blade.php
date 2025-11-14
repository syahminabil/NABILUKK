<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Item</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root { --indigo:#4338ca; --blue:#2563eb; --gray:#f8fafc; --white:#ffffff; --text-dark:#1e293b; }
        body { background-color: var(--gray); font-family:'Segoe UI', sans-serif; }
        .container-custom { max-width: 800px; background: var(--white); border-radius: 20px; padding: 30px 40px; margin: 60px auto; box-shadow: 0 6px 20px rgba(0,0,0,0.08); border-top: 6px solid var(--blue); }
        h3 { font-weight: 700; color: var(--indigo); }
        .form-control { border-radius: 10px; }
        .form-control:focus { border-color: var(--blue); box-shadow: 0 0 0 0.2rem rgba(37,99,235,.25); }
        .btn-primary, .btn-secondary { border-radius: 10px; border: none; }
        .btn-primary { background: linear-gradient(to right, var(--indigo), var(--blue)); font-weight: 600; }
        .btn-primary:hover { opacity: 0.9; transform: translateY(-2px); }
        @media (max-width: 576px) {
          .container-custom { padding: 20px; }
          h3 { font-size: 1.1rem; }
        }
    </style>
</head>
<body>
<div class="container-custom">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h3 class="mb-0">Edit Item: {{ $item->nama_item }}</h3>
      <a href="{{ route('petugas.dashboard') }}" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Kembali ke Dashboard</a>
    </div>

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

    {{-- 🔹 Form edit item --}}
    <form action="{{ route('petugas.item.update', $item->id_item) }}" method="POST" enctype="multipart/form-data" class="mt-3">
        @csrf
        {{-- penting: gunakan enctype untuk upload file --}}

        <div class="mb-3">
            <label for="nama_item" class="form-label">Nama Item</label>
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
            <label for="foto" class="form-label">Foto</label><br>

            {{-- 🔹 Tampilkan foto lama --}}
            @if($item->foto)
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $item->foto) }}" 
                         alt="Foto Lama {{ $item->nama_item }}" 
                         width="150" 
                         class="rounded border">
                </div>
            @endif

            {{-- 🔹 Input upload foto baru --}}
            <input 
                type="file" 
                name="foto" 
                id="foto" 
                class="form-control"
                accept="image/*"
            >
            <small class="text-muted">Kosongkan jika tidak ingin mengganti foto.</small>
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-primary">💾 Simpan Perubahan</button>
            <a href="{{ url()->previous() }}" class="btn btn-secondary">⬅️ Kembali</a>
        </div>
    </form>
</div>
</body>
</html>
