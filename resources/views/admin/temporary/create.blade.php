<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>ADMIN | Tambah Temporary Item</title>
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
            max-width: 800px;
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
            border: none;
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

        .form-label {
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 8px;
        }

        .form-control, .form-select {
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            padding: 10px 15px;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--blue);
            box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.25);
        }

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

        .preview-image {
            max-width: 200px;
            max-height: 200px;
            border-radius: 8px;
            margin-top: 10px;
            border: 2px solid #e2e8f0;
        }
    </style>
</head>
<body>

<div class="container-custom">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3><i class="fa fa-plus me-2"></i> Tambah Temporary Item</h3>
        <a href="{{ route('admin.temporary.index') }}" class="btn btn-back btn-custom">
            <i class="fa fa-arrow-left"></i> Kembali
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-error">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.temporary.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="mb-3">
            <label for="nama_barang_baru" class="form-label">
                <i class="fa fa-box me-1"></i> Nama Barang <span class="text-danger">*</span>
            </label>
            <input type="text" 
                   class="form-control" 
                   id="nama_barang_baru" 
                   name="nama_barang_baru" 
                   value="{{ old('nama_barang_baru') }}"
                   required
                   placeholder="Masukkan nama barang">
        </div>

        <div class="mb-3">
            <label for="lokasi_barang_baru" class="form-label">
                <i class="fa fa-map-marker-alt me-1"></i> Lokasi Barang <span class="text-danger">*</span>
            </label>
            <select class="form-select" id="lokasi_barang_baru" name="lokasi_barang_baru" required>
                <option value="">Pilih Lokasi</option>
                @foreach($lokasiList as $lokasi)
                    <option value="{{ $lokasi->nama_lokasi }}" {{ old('lokasi_barang_baru') == $lokasi->nama_lokasi ? 'selected' : '' }}>
                        {{ $lokasi->nama_lokasi }}
                    </option>
                @endforeach
            </select>
            <small class="text-muted">Atau ketik lokasi baru jika tidak ada di daftar</small>
            <input type="text" 
                   class="form-control mt-2" 
                   id="lokasi_custom" 
                   placeholder="Atau ketik lokasi baru"
                   onchange="document.getElementById('lokasi_barang_baru').value = this.value">
        </div>

        <div class="mb-3">
            <label for="deskripsi" class="form-label">
                <i class="fa fa-align-left me-1"></i> Deskripsi
            </label>
            <textarea class="form-control" 
                      id="deskripsi" 
                      name="deskripsi" 
                      rows="4"
                      placeholder="Masukkan deskripsi barang (opsional)">{{ old('deskripsi') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="foto" class="form-label">
                <i class="fa fa-image me-1"></i> Foto Barang
            </label>
            <input type="file" 
                   class="form-control" 
                   id="foto" 
                   name="foto" 
                   accept="image/*"
                   onchange="previewImage(this)">
            <small class="text-muted">Format: JPG, JPEG, PNG. Maksimal 2MB</small>
            <div id="imagePreview" class="mt-2"></div>
        </div>

        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <button type="submit" class="btn btn-primary-custom btn-custom">
                <i class="fa fa-save me-1"></i> Simpan Temporary Item
            </button>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function previewImage(input) {
        const preview = document.getElementById('imagePreview');
        preview.innerHTML = '';
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'preview-image';
                preview.appendChild(img);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
</body>
</html>

