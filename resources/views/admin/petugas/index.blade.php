<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>ADMINISTRATOR | Data Petugas</title>
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
            font-family: 'Segoe UI', sans-serif;
            color: var(--text-dark);
        }

        .container-custom {
            max-width: 1000px;
            margin: 60px auto;
            background: var(--white);
            border-radius: 20px;
            padding: 30px 40px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
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
            font-size: 14px;
            text-decoration: none;
            transition: 0.25s ease;
        }

        .btn-back:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }

        .btn-danger {
            background: linear-gradient(to right, var(--indigo), var(--blue));
            border: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 13px;
        }

        .btn-danger:hover {
            opacity: 0.9;
        }

        .table thead {
            background: linear-gradient(to right, var(--indigo), var(--blue));
            color: #fff;
            text-transform: uppercase;
            font-size: 13px;
        }

        .table tbody tr:hover {
            background-color: #eef2ff;
        }

        .btn-outline-primary {
            border-radius: 8px;
            font-size: 12px;
            border-color: var(--blue);
            color: var(--blue);
            padding: 5px 12px;
            transition: 0.25s;
        }

        .btn-outline-primary:hover {
            background: var(--blue);
            color: #fff;
        }

        .btn-outline-danger {
            border-radius: 8px;
            font-size: 12px;
            padding: 5px 12px;
            transition: 0.25s;
        }

        .badge {
            font-size: 12px;
            border-radius: 8px;
            padding: 6px 10px;
            background: var(--blue);
        }

        .search-box input {
            border-radius: 10px;
            border: 1px solid #cbd5e1;
            padding: 6px 12px;
            font-size: 13px;
            transition: 0.2s;
        }

        .search-box input:focus {
            border-color: var(--blue);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.2);
        }
    </style>
</head>
<body>

    <div class="container-custom">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="header-title mb-0"><i class="fa fa-user-tie me-2"></i>Kelola Data Petugas</h4>
        </div>

        @if(session('success'))
            <div class="alert alert-success border-start border-4 border-primary">
                {{ session('success') }}
            </div>
        @endif

        <div class="d-flex justify-content-between mb-3 align-items-center">
            <h6 class="fw-semibold mb-0 text-dark">Daftar Petugas</h6>
            <div class="d-flex gap-2">
                <div class="search-box">
                    <input type="text" id="searchInput" placeholder="🔍 Cari petugas..." class="form-control form-control-sm">
                </div>
                <a href="{{ route('admin.petugas.create') }}" class="btn btn-danger btn-sm px-3">+ Tambah</a>
            </div>
        </div>

        <table class="table table-hover align-middle" id="petugasTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Petugas</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Tindakan</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($petugas as $index => $p)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $p->user->name ?? '-' }}</td>
                    <td>{{ $p->user->email ?? '-' }}</td>
                    <td><span class="badge">{{ ucfirst($p->user->role ?? '-') }}</span></td>
                    <td>
                        @if ($p->user)
                            <a href="{{ route('admin.petugas.edit', $p->user->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                            <form action="{{ route('admin.petugas.destroy', $p->user->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                    onclick="return confirm('Yakin ingin menghapus petugas ini?')">Hapus</button>
                            </form>
                        @else
                            <span class="text-muted">Data user tidak ditemukan</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">Belum ada data petugas.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Tombol Kembali -->
        <div class="text-end mt-3">
            <a href="/dashboard" class="btn-back">⬅️ Kembali ke Dashboard</a>
        </div>
    </div>

    <script>
        // 🔍 Pencarian tabel petugas
        document.getElementById('searchInput').addEventListener('keyup', function() {
            const searchValue = this.value.toLowerCase();
            const rows = document.querySelectorAll('#petugasTable tbody tr');
            rows.forEach(row => {
                const text = row.innerText.toLowerCase();
                row.style.display = text.includes(searchValue) ? '' : 'none';
            });
        });
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
</body>
</html>
