<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>ADMIN | Data Pengguna</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <style>
        :root {
            --indigo: #4338ca;
            --blue: #2563eb;
            --gray: #f8fafc;
            --white: #ffffff;
            --text-dark: #1e293b;
        }

        body {
            background: var(--gray);
            font-family: 'Segoe UI', sans-serif;
            color: var(--text-dark);
        }

        .container-custom {
            max-width: 1100px;
            margin: 60px auto;
            background: var(--white);
            border-radius: 20px;
            padding: 30px 40px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
            border-top: 6px solid var(--blue);
        }

        h3 {
            font-weight: 700;
            color: var(--indigo);
        }

        .btn-custom {
            border-radius: 10px;
            font-weight: 500;
            padding: 8px 16px;
            font-size: 14px;
            text-decoration: none;
            transition: 0.25s ease;
        }

        .btn-primary-custom {
            background: linear-gradient(to right, var(--indigo), var(--blue));
            color: #fff;
        }

        .btn-primary-custom:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }

        .btn-back {
            background: #6b7280;
            color: #fff;
        }

        .btn-back:hover {
            background: #4b5563;
            color: #fff;
        }

        .table-custom {
            font-size: 14px;
            border-radius: 10px;
            overflow: hidden;
        }

        .table-custom thead {
            background: linear-gradient(to right, var(--indigo), var(--blue));
            color: #fff;
            text-transform: uppercase;
            font-size: 13px;
        }

        .table-custom tbody tr:hover {
            background-color: #eef2ff;
        }

        .badge-role {
            font-size: 12px;
            border-radius: 8px;
            padding: 6px 10px;
        }

        .badge-pengguna { background: #10b981; }
        .badge-petugas { background: #f59e0b; }
        .badge-admin { background: #ef4444; }

        .alert-success {
            border-left: 4px solid var(--blue);
            background-color: #e0f2fe;
            color: var(--text-dark);
        }

        .alert-error {
            border-left: 4px solid #ef4444;
            background-color: #fee2e2;
            color: var(--text-dark);
        }

        th, td {
            text-align: center;
            vertical-align: middle !important;
        }

        .actions {
            white-space: nowrap;
        }
    </style>
</head>
<body>

<div class="container-custom">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3><i class="fa fa-users me-2"></i> Daftar Pengguna</h3>
        <div>
            <a href="{{ route('dashboard') }}" class="btn btn-back btn-custom me-2">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary-custom btn-custom">
                <i class="fa fa-plus"></i> Tambah User
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
    @endif

    <!-- Debug: Cek apakah data users ada -->
    @php
        // Uncomment baris berikut untuk debug
        // dd($users);
    @endphp

    <table class="table table-hover table-custom align-middle shadow-sm">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th>Tanggal Dibuat</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @if(isset($users) && $users->count() > 0)
                @foreach($users as $index => $user)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $user->name ?? '-' }}</td>
                        <td>{{ $user->email ?? '-' }}</td>
                        <td>
                            <span class="badge-role badge-{{ $user->role ?? 'pengguna' }}">
                                {{ ucfirst($user->role ?? 'pengguna') }}
                            </span>
                        </td>
                        <td>
                            @if(isset($user->created_at) && !is_null($user->created_at))
                                {{ $user->created_at->format('d M Y') }}
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td class="actions">
                            <a href="{{ route('admin.users.edit', $user->id) }}" 
                               class="btn btn-warning btn-sm" title="Edit">
                                <i class="fa fa-edit"></i>
                            </a>
                            
                            <form action="{{ route('admin.users.destroy', $user->id) }}" 
                                  method="POST" class="d-inline"
                                  onsubmit="return confirm('Yakin ingin menghapus user {{ $user->name }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" 
                                        {{ $user->id == auth()->id() ? 'disabled' : '' }} 
                                        title="{{ $user->id == auth()->id() ? 'Tidak bisa hapus akun sendiri' : 'Hapus' }}">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">
                        <i class="fa fa-users fa-2x mb-2"></i><br>
                        Belum ada pengguna terdaftar.
                    </td>
                </tr>
            @endif
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>