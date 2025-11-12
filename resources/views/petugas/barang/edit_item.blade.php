<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Item</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4 bg-light">
<div class="container">
    <h3 class="mb-4">Edit Item: {{ $item->nama_item }}</h3>

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
