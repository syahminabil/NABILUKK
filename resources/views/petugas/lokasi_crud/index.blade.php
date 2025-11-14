<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Daftar Ruang - Petugas</title>
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
  table { border-radius: 12px; overflow: hidden; }
  thead { background: linear-gradient(to right, var(--indigo), var(--blue)); color: #fff; }
  tbody tr:hover { background-color: #eef2ff; }
  th, td { vertical-align: middle !important; }
</style>
</head>
<body>
<div class="container-custom">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h3 class="mb-0"><i class="fa fa-door-open"></i> Daftar Ruang</h3>
      <a href="{{ route('petugas.dashboard') }}" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Kembali ke Dashboard</a>
    </div>

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