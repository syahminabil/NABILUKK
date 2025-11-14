<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>ADMIN | Daftar Ruang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root { --indigo:#4338ca; --blue:#2563eb; --gray:#f8fafc; --white:#ffffff; --text-dark:#1e293b; }
        body { background-color: var(--gray); font-family:'Segoe UI', sans-serif; color: var(--text-dark); }
        .container-custom { max-width: 1000px; margin: 60px auto; background: var(--white); border-radius: 20px; padding: 30px 40px; box-shadow: 0 6px 20px rgba(0,0,0,0.08); border-top: 6px solid var(--blue); }
        h3 { font-weight: 700; color: var(--indigo); }
        .btn-primary { background: linear-gradient(to right, var(--indigo), var(--blue)); border: none; font-weight: 600; border-radius: 10px; transition: 0.25s; }
        .btn-primary:hover { opacity: 0.9; transform: translateY(-2px); }
        .btn-warning { background: linear-gradient(to right, var(--indigo), var(--blue)); border: none; color: #fff; border-radius: 8px; font-size: 13px; transition: 0.25s; }
        .btn-warning:hover { opacity: 0.9; }
        .btn-danger { border-radius: 8px; font-size: 13px; }
        .table-custom { font-size: 14px; border-radius: 12px; overflow: hidden; }
        .table-custom thead { background: linear-gradient(to right, var(--indigo), var(--blue)); color: #fff; }
        .table-custom tbody tr:hover { background-color: #eef2ff; }
        th, td { text-align: center; vertical-align: middle !important; }
        th:nth-child(1), td:nth-child(1) { width: 10%; }
        th:nth-child(2), td:nth-child(2) { width: 55%; text-align: left; padding-left: 20px; }
        th:nth-child(3), td:nth-child(3) { width: 35%; }
        .btn-back { background: linear-gradient(to right, var(--indigo), var(--blue)); color:#fff; border-radius:10px; font-weight:500; padding:6px 12px; text-decoration:none; transition:0.25s; }
        .btn-back:hover { opacity:0.9; transform: translateY(-2px); }
        .alert-success { border-left: 4px solid var(--blue); }
    </style>
</head>
<body>

    <div class="container-custom">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3>🏢 Daftar Ruang</h3>
            <a href="/dashboard" class="btn-back">← Kembali</a>
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
