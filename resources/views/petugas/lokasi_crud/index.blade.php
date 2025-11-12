<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Daftar Ruang - Petugas</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h3 class="mb-4"><i class="fa fa-door-open"></i> Daftar Ruang</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('petugas.lokasi.crud.create') }}" class="btn btn-primary mb-3">
        <i class="fa fa-plus-square"></i> Tambah Ruang
    </a>

    <table class="table table-bordered table-hover">
        <thead class="table-secondary">
            <tr>
                <th style="width: 60px;">No</th>
                <th>Nama Ruang</th>
                <th style="width: 200px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($lokasi as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->nama_lokasi }}</td>
                    <td>
                        <a href="{{ route('petugas.lokasi.crud.edit', $item->id_lokasi) }}" class="btn btn-warning btn-sm">
                            <i class="fa fa-edit"></i> Edit
                        </a>

                        <form action="{{ route('petugas.lokasi.crud.destroy', $item->id_lokasi) }}" 
                              method="POST" 
                              style="display:inline-block;"
                              onsubmit="return confirm('Yakin ingin menghapus ruang ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fa fa-trash"></i> Hapus
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center text-muted">Belum ada data ruang.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
</body>
</html>