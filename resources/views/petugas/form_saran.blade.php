<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Saran Petugas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        body { 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .form-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            overflow: hidden;
            max-width: 600px;
            width: 100%;
        }
        .form-header {
            background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%);
            color: white;
            padding: 25px;
            text-align: center;
        }
        .form-body {
            padding: 30px;
        }
        .pengaduan-info {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 25px;
            border-left: 4px solid #0d6efd;
        }
        .btn-submit {
            background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%);
            border: none;
            padding: 12px 30px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(13, 110, 253, 0.4);
        }
    </style>
</head>
<body>
    <div class="form-container">
        <div class="form-header">
            <h3><i class="fas fa-comment-dots me-2"></i>Form Saran Petugas</h3>
            <p class="mb-0">Berikan saran untuk pengaduan yang telah diselesaikan</p>
        </div>
        
        <div class="form-body">
            <!-- Informasi Pengaduan -->
            <div class="pengaduan-info">
                <h5 class="text-primary mb-3"><i class="fas fa-info-circle me-2"></i>Informasi Pengaduan</h5>
                <div class="row">
                    <div class="col-md-6">
                        <strong>Judul Pengaduan:</strong><br>
                        {{ $pengaduan->nama_pengaduan }}
                    </div>
                    <div class="col-md-6">
                        <strong>Lokasi:</strong><br>
                        {{ $pengaduan->lokasi }}
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-6">
                        <strong>Status:</strong><br>
                        <span class="badge bg-success">Selesai</span>
                    </div>
                    <div class="col-md-6">
                        <strong>Tanggal Pengajuan:</strong><br>
                        {{ \Carbon\Carbon::parse($pengaduan->created_at)->format('d M Y') }}
                    </div>
                </div>
            </div>

            <!-- Form Saran -->
            <form action="{{ route('petugas.kirim.saran', $pengaduan->id_pengaduan) }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="mb-4">
                    <label for="saran_petugas" class="form-label fw-semibold">
                        <i class="fas fa-edit me-2"></i>Saran Petugas
                    </label>
                    <textarea
                        class="form-control @error('saran_petugas') is-invalid @enderror"
                        id="saran_petugas"
                        name="saran_petugas"
                        rows="6"
                        placeholder="Masukkan saran, catatan, atau solusi yang telah dilakukan untuk pengaduan ini..."
                        required>{{ old('saran_petugas') }}</textarea>

                    @error('saran_petugas')
                        <div class="invalid-feedback">
                            <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                        </div>
                    @enderror

                    <div class="form-text">
                        <i class="fas fa-lightbulb me-1"></i>
                        Saran minimal 5 karakter dan maksimal 1000 karakter.
                    </div>
                </div>

                <div class="mb-4">
                    <label for="foto_saran" class="form-label fw-semibold">
                        <i class="fas fa-camera me-2"></i>Foto Saran (Opsional)
                    </label>
                    <input
                        type="file"
                        class="form-control @error('foto_saran') is-invalid @enderror"
                        id="foto_saran"
                        name="foto_saran"
                        accept="image/*">

                    @error('foto_saran')
                        <div class="invalid-feedback">
                            <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                        </div>
                    @enderror

                    <div class="form-text">
                        <i class="fas fa-info-circle me-1"></i>
                        Upload foto hasil perbaikan atau dokumentasi (maksimal 2MB, format: JPG, PNG, JPEG).
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('petugas.dashboard') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                    
                    <button type="submit" class="btn btn-submit">
                        <i class="fas fa-paper-plane me-2"></i>Kirim Saran
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Validasi client-side
        document.querySelector('form').addEventListener('submit', function(e) {
            const saran = document.getElementById('saran_petugas').value.trim();
            
            if (saran.length < 5) {
                e.preventDefault();
                alert('Saran harus minimal 5 karakter!');
                return false;
            }
            
            if (saran.length > 1000) {
                e.preventDefault();
                alert('Saran maksimal 1000 karakter!');
                return false;
            }
        });

        // Auto-resize textarea
        const textarea = document.getElementById('saran_petugas');
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });
    </script>
</body>
</html>