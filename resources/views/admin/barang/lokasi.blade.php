<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Ruang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root { --indigo:#4338ca; --blue:#2563eb; --gray:#f8fafc; --white:#ffffff; --text-dark:#1e293b; }
        body { background-color: var(--gray); font-family:'Segoe UI', sans-serif; color: var(--text-dark); }
        .container-custom { max-width: 1000px; margin: 60px auto; background: var(--white); border-radius: 20px; padding: 30px 40px; box-shadow: 0 6px 20px rgba(0,0,0,0.08); border-top: 6px solid var(--blue); }
        h2 { font-weight: 700; color: var(--indigo); margin-bottom: 25px; text-align: center; }
        .table { border-radius: 12px; overflow: hidden; }
        .table thead { background: linear-gradient(to right, var(--indigo), var(--blue)); color: #fff; }
        .table tbody tr:hover { background-color: #eef2ff; color: inherit; transition: 0.2s; }
        .table td, .table th { vertical-align: middle; text-align: center; }
        .btn-back { background: linear-gradient(to right, var(--indigo), var(--blue)); color: #fff; border: none; border-radius: 10px; font-weight: 500; padding: 8px 16px; text-decoration: none; transition: 0.25s; }
        .btn-back:hover { opacity: 0.9; transform: translateY(-2px); }
        .btn-outline-dark { border-color: var(--blue); color: var(--blue); }
        .btn-outline-dark:hover { background: var(--blue); color: #fff; }
    </style>
</head>
<body>
    <div class="container-custom">
        <h2>🏢 Daftar Ruang</h2>

        @if($lokasi->isEmpty())
            <p class="text-center text-muted">Belum ada data ruang yang terdaftar.</p>
        @else
            <table class="table table-bordered align-middle">
                <thead>
                    <tr>
                        <th style="width: 10%;">No</th>
                        <th>Nama Ruang</th>
                        <th style="width: 25%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lokasi as $index => $l)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $l->nama_lokasi }}</td>
                            <td>
                                <a href="{{ route('item.byLokasi', $l->id_lokasi) }}" 
                                   class="btn btn-sm btn-outline-dark">
                                   Lihat
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        <div class="d-flex justify-content-end mt-3">
            <a href="{{ url()->previous() }}" class="btn-back">← Kembali</a>
        </div>
    </div>
</body>
</html>
