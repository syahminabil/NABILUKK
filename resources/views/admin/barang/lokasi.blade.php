<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Ruang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', sans-serif;
            color: #111;
        }
        .container-custom {
            max-width: 800px;
            margin: 60px auto;
            background: #fff;
            border-radius: 16px;
            padding: 30px 40px;
            box-shadow: 0 6px 18px rgba(0,0,0,0.08);
            border-top: 5px solid #dc3545;
        }
        h2 {
            font-weight: 700;
            color: #000;
            margin-bottom: 25px;
            text-align: center;
        }
        .table {
            border-radius: 8px;
            overflow: hidden;
        }
        .table thead {
            background-color: #000;
            color: #fff;
        }
        .table tbody tr:hover {
            background-color: #dc3545;
            color: #fff;
            transition: 0.2s;
        }
        .table td, .table th {
            vertical-align: middle;
            text-align: center;
        }
        .btn-back {
            background-color: #000;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-weight: 500;
            padding: 8px 16px;
            text-decoration: none;
            transition: 0.2s;
        }
        .btn-back:hover {
            background-color: #dc3545;
        }
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
