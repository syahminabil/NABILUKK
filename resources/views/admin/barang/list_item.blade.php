<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Barang di {{ $lokasi->nama_lokasi }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', sans-serif;
        }

        .container-custom {
            max-width: 900px;
            background: #fff;
            border-radius: 16px;
            padding: 25px 30px;
            margin: 50px auto;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
            border-top: 5px solid #dc3545;
        }

        h2 {
            font-weight: 700;
            color: #000;
            text-align: center;
            margin-bottom: 25px;
        }

        .btn-add {
            background-color: #000;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            transition: 0.2s;
        }

        .btn-add:hover {
            background-color: #dc3545;
        }

        .table {
            border-radius: 10px;
            overflow: hidden;
            font-size: 15px;
        }

        thead {
            background-color: #000;
            color: #fff;
            text-align: center;
        }

        tbody tr:hover {
            background-color: #f2f2f2;
        }

        td img {
            width: 65px;
            height: 65px;
            object-fit: cover;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        td, th {
            vertical-align: middle !important;
            text-align: center;
        }

        .btn-warning, .btn-danger {
            border: none;
            font-weight: 600;
            border-radius: 6px;
            padding: 4px 10px;
        }

        .btn-warning:hover {
            background-color: #ffc107;
        }

        .btn-danger:hover {
            background-color: #dc3545;
        }

        .alert {
            border-radius: 8px;
        }

        .btn-back {
            background-color: #6c757d;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-weight: 500;
            padding: 7px 14px;
            transition: 0.2s;
        }

        .btn-back:hover {
            background-color: #dc3545;
        }

        .table-container {
            overflow-x: auto;
        }
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
