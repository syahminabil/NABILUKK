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
        h2 { font-weight: 700; color: var(--indigo); text-align: center; margin-bottom: 25px; }
        .btn-add { background: linear-gradient(to right, var(--indigo), var(--blue)); color:#fff; border: none; border-radius: 10px; font-weight: 600; transition: 0.25s; }
        .btn-add:hover { opacity: 0.9; transform: translateY(-2px); }
        .table { border-radius: 12px; overflow: hidden; font-size: 15px; }
        thead { background: linear-gradient(to right, var(--indigo), var(--blue)); color: #fff; text-align: center; }
        tbody tr:hover { background-color: #eef2ff; }
        td img { width: 65px; height: 65px; object-fit: cover; border-radius: 8px; border: 1px solid #cbd5e1; }
        td, th { vertical-align: middle !important; text-align: center; }
        .btn-warning, .btn-danger { border: none; font-weight: 600; border-radius: 8px; padding: 6px 12px; }
        .btn-warning { background: linear-gradient(to right, var(--indigo), var(--blue)); color:#fff; }
        .btn-warning:hover { opacity: 0.9; }
        .btn-danger:hover { background-color: #ef4444; }
        .alert { border-radius: 10px; }
        .btn-back { background: linear-gradient(to right, var(--indigo), var(--blue)); color:#fff; border: none; border-radius: 10px; font-weight: 500; padding: 8px 16px; transition: 0.25s; }
        .btn-back:hover { opacity: 0.9; transform: translateY(-2px); }
        .table-container { overflow-x: auto; }
    </style>
</head>
<body>
<div class="container-custom">
    <h2>📦 Barang di Ruang: {{ $lokasi->nama_lokasi }}</h2>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ route('item.create', $lokasi->id_lokasi) }}" class="btn btn-add">+ Tambah Barang</a>
        <a href="{{ route('admin.lokasi.crud.index') }}" class="btn-back">⬅️ Kembali</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-container">
        <table class="table table-bordered align-middle shadow-sm">
            <thead>
                <tr>
                    <th style="width: 50px;">No</th>
                    <th style="width: 80px;">Foto</th>
                    <th style="width: 200px;">Nama Barang</th>
                    <th>Deskripsi</th>
                    <th style="width: 130px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php $no = 1; @endphp
                @forelse($items as $list)
                    @if($list->item)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>
                                @if($list->item->foto)
                                    <img src="{{ Storage::url($list->item->foto) }}" 
                                         alt="Foto {{ $list->item->nama_item }}">
                                @else
                                    <span class="text-muted small">Tidak ada</span>
                                @endif
                            </td>
                            <td>{{ $list->item->nama_item }}</td>
                            <td>{{ $list->item->deskripsi ?? '-' }}</td>
                            <td>
                                <a href="{{ route('item.edit', $list->item->id_item) }}" class="btn btn-warning btn-sm">✏️</a>
                                <form action="{{ route('item.delete', $list->item->id_item) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Yakin ingin menghapus item ini?')" class="btn btn-danger btn-sm">🗑️</button>
                                </form>
                            </td>
                        </tr>
                    @endif
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">Belum ada barang di ruang ini.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
