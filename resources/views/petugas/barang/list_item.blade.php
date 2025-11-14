<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Barang di {{ $lokasi->nama_lokasi }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root { --indigo:#4338ca; --blue:#2563eb; --gray:#f8fafc; --white:#ffffff; --text-dark:#1e293b; }
        body { background-color: var(--gray); font-family:'Segoe UI', sans-serif; }
        .container-custom { max-width: 1000px; background: var(--white); border-radius: 20px; padding: 30px 40px; margin: 60px auto; box-shadow: 0 6px 20px rgba(0,0,0,0.08); border-top: 6px solid var(--blue); }
        h2 { font-weight: 700; color: var(--indigo); }
        .btn-secondary, .btn-success { border: none; border-radius: 10px; }
        .btn-secondary { background: linear-gradient(to right, var(--indigo), var(--blue)); color:#fff; }
        .btn-success { background: linear-gradient(to right, var(--indigo), var(--blue)); font-weight:600; }
        .btn-secondary:hover, .btn-success:hover { opacity:0.9; transform: translateY(-2px); }
        table { border-radius: 12px; overflow: hidden; }
        thead { background: linear-gradient(to right, var(--indigo), var(--blue)); color:#fff; }
        td img { border-radius: 8px; border:1px solid #cbd5e1; }
        .btn-warning, .btn-danger { border-radius: 8px; }
        .btn-warning { background: linear-gradient(to right, var(--indigo), var(--blue)); color:#fff; }
        .btn-warning:hover { opacity:0.9; }
        .btn-danger:hover { background-color:#ef4444; }
    </style>
</head>
<body>
<div class="container-custom">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h2 class="mb-0">Barang di Ruang: {{ $lokasi->nama_lokasi }}</h2>
      <a href="{{ route('petugas.dashboard') }}" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Kembali ke Dashboard</a>
    </div>
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
