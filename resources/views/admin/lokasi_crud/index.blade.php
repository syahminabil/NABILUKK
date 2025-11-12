<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>ADMIN | Daftar Ruang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', sans-serif;
            color: #111;
        }
        .container-custom {
            max-width: 900px;
            margin: 50px auto;
            background: #fff;
            border-radius: 16px;
            padding: 25px 35px;
            box-shadow: 0 6px 18px rgba(0,0,0,0.08);
            border-top: 5px solid #dc3545;
        }
        h3 {
            font-weight: 700;
            color: #000;
        }
        .btn-primary {
            background-color: #dc3545;
            border-color: #dc3545;
            font-weight: 500;
            border-radius: 8px;
            transition: 0.2s;
        }
        .btn-primary:hover {
            background-color: #b02a37;
            border-color: #b02a37;
        }
        .btn-warning {
            background-color: #000;
            border: none;
            color: #fff;
            border-radius: 6px;
            font-size: 13px;
            transition: 0.2s;
        }
        .btn-warning:hover {
            background-color: #dc3545;
            color: #fff;
        }
        .btn-danger {
            border-radius: 6px;
            font-size: 13px;
        }
        .table-custom {
            font-size: 14px;
            border-radius: 8px;
            overflow: hidden;
        }
        .table-custom thead {
            background-color: #000;
            color: #fff;
        }
        .table-custom tbody tr:hover {
            background-color: #f1f1f1;
        }
        th, td {
            text-align: center;
            vertical-align: middle !important;
        }
        th:nth-child(1), td:nth-child(1) { width: 10%; }
        th:nth-child(2), td:nth-child(2) { width: 55%; text-align: left; padding-left: 20px; }
        th:nth-child(3), td:nth-child(3) { width: 35%; }
        .alert-success {
            border-left: 4px solid #198754;
        }
    </style>
</head>
<body>

    <div class="container-custom">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3>🏢 Daftar Ruang</h3>
            <a href="/dashboard" class="btn btn-dark btn-sm">← Kembali</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <a href="{{ route('admin.lokasi.crud.create') }}" class="btn btn-primary mb-3">
            <i class="fa fa-plus-square"></i> Tambah Ruang
        </a>

        <table class="table table-hover table-custom align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Ruang</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($lokasi as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->nama_lokasi }}</td>
                        <td>
                            <a href="{{ route('admin.lokasi.crud.edit', $item->id_lokasi) }}" class="btn btn-warning btn-sm">
                                <i class="fa fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('admin.lokasi.crud.destroy', $item->id_lokasi) }}" 
                                  method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" 
                                        onclick="return confirm('Yakin ingin menghapus ruang ini?')">
                                    <i class="fa fa-trash"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center text-muted py-4">Belum ada data ruang.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</body>
</html>
