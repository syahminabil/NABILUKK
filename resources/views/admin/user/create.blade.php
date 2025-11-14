<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pengguna - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <style>
        :root {
            --indigo: #4338ca;
            --blue: #2563eb;
            --gray: #f8fafc;
            --white: #ffffff;
        }
        
        body {
            background: var(--gray);
            font-family: 'Segoe UI', sans-serif;
        }
        
        .form-container {
            max-width: 600px;
            margin: 60px auto;
            background: var(--white);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
            border-top: 6px solid var(--blue);
        }
        
        .btn-custom {
            border-radius: 10px;
            font-weight: 500;
            padding: 10px 20px;
        }

        .role-info {
            background-color: #f0f9ff;
            border: 1px solid #bae6fd;
            border-radius: 8px;
            padding: 12px 15px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="form-container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="text-primary"><i class="fa fa-user-plus me-2"></i> Tambah Pengguna Baru</h3>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-custom">
            <i class="fa fa-arrow-left"></i> Kembali
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Info role -->
    <div class="role-info">
        <i class="fa fa-info-circle text-primary me-2"></i>
        <strong>Informasi:</strong> Form ini hanya untuk menambahkan <span class="text-primary fw-bold">Pengguna Biasa</span>
    </div>

    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf
        
        <div class="mb-3">
            <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="name" name="name" 
                   value="{{ old('name') }}" required placeholder="Masukkan nama lengkap">
        </div>
        
        <div class="mb-3">
            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
            <input type="email" class="form-control" id="email" name="email" 
                   value="{{ old('email') }}" required placeholder="Masukkan alamat email">
        </div>
        
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                <input type="password" class="form-control" id="password" name="password" 
                       required placeholder="Minimal 8 karakter">
            </div>
            
            <div class="col-md-6 mb-3">
                <label for="password_confirmation" class="form-label">Konfirmasi Password <span class="text-danger">*</span></label>
                <input type="password" class="form-control" id="password_confirmation" 
                       name="password_confirmation" required placeholder="Ulangi password">
            </div>
        </div>
        
        <!-- Hidden input untuk role pengguna -->
        <input type="hidden" name="role" value="pengguna">
        
        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary btn-custom">
                <i class="fa fa-save"></i> Simpan Pengguna
            </button>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>