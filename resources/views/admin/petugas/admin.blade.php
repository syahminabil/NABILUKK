<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --indigo: #4338ca;
            --blue: #2563eb;
            --gray: #f8fafc;
            --white: #ffffff;
            --text-dark: #1e293b;
        }
        body {
            background-color: var(--gray);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--text-dark);
        }
        .container-custom {
            max-width: 1000px;
            margin: 60px auto;
            background: var(--white);
            border-radius: 20px;
            padding: 30px 40px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.08);
            border-top: 6px solid var(--blue);
        }
        .header-title {
            font-weight: 700;
            color: var(--indigo);
        }
        .btn-back {
            background: linear-gradient(to right, var(--indigo), var(--blue));
            color: #fff;
            border-radius: 10px;
            font-weight: 500;
            padding: 8px 16px;
            text-decoration: none;
            transition: 0.25s ease;
        }
        .btn-back:hover { opacity: 0.9; transform: translateY(-2px); }
        table thead { background: linear-gradient(to right, var(--indigo), var(--blue)); color: #fff; }
        table tbody tr:hover { background-color: #eef2ff; }
    </style>
</head>
<body>
    <div class="container-custom">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="header-title mb-0">Daftar Admin</h4>
            <a href="{{ route('dashboard') }}" class="btn-back">← Kembali ke Dashboard</a>
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
</body>
</html>
