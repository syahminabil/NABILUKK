<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8fafc;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .container {
            max-width: 900px;
            margin-top: 60px;
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 3px 8px rgba(0,0,0,0.1);
        }
        .btn-back {
            background-color: #64748b;
            color: white;
            border-radius: 10px;
        }
        .btn-back:hover {
            background-color: #475569;
        }
        table th {
            background-color: #f1f5f9;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-semibold text-primary">Daftar Admin</h4>
                <a href="{{ route('dashboard') }}" class="btn btn-back">← Kembali ke Dashboard</a>
            </div>

            @if($admins->isEmpty())
                <div class="alert alert-info text-center">Belum ada admin yang terdaftar.</div>
            @else
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($admins as $index => $admin)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $admin->name }}</td>
                                <td>{{ $admin->email }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</body>
</html>
