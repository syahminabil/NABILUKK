<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Barang di {{ $lokasi->nama_lokasi }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
<div class="container">
    <h2>Barang di Ruang: {{ $lokasi->nama_lokasi }}</h2>
    <a href="/petugas/dashboard" class="btn btn-secondary">← Kembali ke Dashboard</a>
    <a href="{{ route('petugas.item.create', $lokasi->id_lokasi) }}" class="btn btn-success my-3">+ Tambah Item</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped align-middle">
        <thead class="table-dark">
            <tr>
                <th>Foto</th>
                <th>Nama Barang</th>
                <th>Deskripsi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $list)
                @if($list->item)
                    <tr>
                        <td>
                            @if($list->item->foto)
                                {{-- 🔹 Gunakan Storage::url agar path selalu benar --}}
                                <img src="{{ Storage::url($list->item->foto) }}" 
                                     alt="Foto {{ $list->item->nama_item }}" 
                                     width="100" 
                                     class="rounded border">
                            @else
                                <span class="text-muted">Tidak ada</span>
                            @endif
                        </td>
                        <td>{{ $list->item->nama_item }}</td>
                        <td>{{ $list->item->deskripsi }}</td>
                        <td>
                            <a href="{{ route('petugas.item.edit', $list->item->id_item) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('petugas.item.delete', $list->item->id_item) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Yakin ingin menghapus item ini?')" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
</div>
</body>
</html>
