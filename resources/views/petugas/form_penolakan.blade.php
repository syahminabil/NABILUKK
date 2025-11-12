<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Penolakan Pengaduan</title>
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
            padding: 20px;
        }
        .form-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            overflow: hidden;
            max-width: 700px;
            width: 100%;
        }
        .form-header {
            background: linear-gradient(135deg, #e11d48 0%, #be123c 100%);
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
            border-left: 4px solid #e11d48;
        }
        .btn-tolak {
            background: linear-gradient(135deg, #e11d48 0%, #be123c 100%);
            border: none;
            padding: 12px 30px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-tolak:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(225, 29, 72, 0.4);
        }
        .info-item {
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e9ecef;
        }
        .info-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <div class="form-header">
            <h3><i class="fa fa-times-circle me-2"></i>Form Penolakan Pengaduan</h3>
            <p class="mb-0">Berikan alasan penolakan pengaduan dengan jelas</p>
        </div>
        
        <div class="form-body">
            <!-- Informasi Pengaduan -->
            <div class="pengaduan-info">
                <h5 class="text-danger mb-3"><i class="fa fa-info-circle me-2"></i>Informasi Pengaduan</h5>
                <div class="info-item">
                    <strong>Judul Pengaduan:</strong><br>
                    <span class="text-dark">{{ $pengaduan->nama_pengaduan }}</span>
                </div>
                <div class="info-item">
                    <strong>Pelapor:</strong><br>
                    <span class="text-dark">{{ $pengaduan->user->name ?? '-' }}</span>
                </div>
                <div class="info-item">
                    <strong>Deskripsi:</strong><br>
                    <span class="text-dark">{{ $pengaduan->deskripsi ?? '-' }}</span>
                </div>
                <div class="info-item">
                    <strong>Lokasi:</strong><br>
                    <span class="text-dark">{{ $pengaduan->lokasi ?? '-' }}</span>
                </div>
                <div>
                    <strong>Tanggal Pengajuan:</strong><br>
                    <span class="text-dark">{{ \Carbon\Carbon::parse($pengaduan->created_at)->format('d M Y H:i') }}</span>
                </div>
            </div>

            <!-- Form Penolakan -->
            <form method="POST" action="{{ route('petugas.pengaduan.tolak', $pengaduan->id_pengaduan) }}">
                @csrf
                
                <div class="mb-4">
                    <label for="alasan" class="form-label fw-semibold">
                        <i class="fa fa-edit me-2"></i>Alasan Penolakan *
                    </label>
                    <textarea 
                        class="form-control @error('alasan') is-invalid @enderror" 
                        id="alasan" 
                        name="alasan" 
                        rows="5" 
                        placeholder="Masukkan alasan penolakan pengaduan ini secara detail dan jelas..."
                        required>{{ old('alasan') }}</textarea>
                    
                    @error('alasan')
                        <div class="invalid-feedback">
                            <i class="fa fa-exclamation-circle me-1"></i>{{ $message }}
                        </div>
                    @enderror
                    
                    <div class="form-text">
                        <i class="fa fa-lightbulb me-1"></i>
                        Berikan alasan yang jelas dan sopan untuk penolakan ini.
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('petugas.dashboard') }}" class="btn btn-outline-secondary">
                        <i class="fa fa-arrow-left me-2"></i>Kembali
                    </a>
                    
                    <button type="submit" class="btn btn-tolak text-white">
                        <i class="fa fa-times me-2"></i>Tolak Pengaduan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Validasi client-side
        document.querySelector('form').addEventListener('submit', function(e) {
            const alasan = document.getElementById('alasan').value.trim();
            
            if (alasan.length < 10) {
                e.preventDefault();
                alert('Alasan penolakan harus minimal 10 karakter!');
                return false;
            }
        });

        // Auto-resize textarea
        const textarea = document.getElementById('alasan');
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });
    </script>
</body>
</html>