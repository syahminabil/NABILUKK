<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Barang: {{ $item->nama_item }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', sans-serif;
        }

        .container-custom {
            max-width: 750px;
            background: #fff;
            border-radius: 16px;
            padding: 30px 40px;
            margin: 60px auto;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
            border-top: 5px solid #dc3545;
        }

        h3 {
            font-weight: 700;
            color: #000;
            text-align: center;
            margin-bottom: 25px;
        }

        label {
            font-weight: 600;
            color: #111;
        }

        input.form-control, textarea.form-control {
            border-radius: 10px;
            border: 1px solid #ccc;
            transition: all 0.2s;
        }

        input.form-control:focus, textarea.form-control:focus {
            border-color: #dc3545;
            box-shadow: 0 0 0 0.2rem rgba(220,53,69,0.2);
        }

        .btn-save {
            background-color: #000;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            padding: 10px 20px;
            transition: 0.2s;
        }

        .btn-save:hover {
            background-color: #dc3545;
        }

        .btn-back {
            background-color: #6c757d;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-weight: 500;
            padding: 10px 20px;
            transition: 0.2s;
        }

        .btn-back:hover {
            background-color: #dc3545;
        }

        .alert {
            border-radius: 10px;
        }

        .preview-img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #ddd;
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
