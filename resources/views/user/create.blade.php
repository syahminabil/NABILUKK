<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Buat Pengaduan | Aplikasi Sarpras</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <style>
    :root {
      --indigo: #4338ca;
      --blue: #2563eb;
      --light-blue: #eff6ff;
      --white: #ffffff;
      --gray: #f9fafb;
      --text-dark: #1e293b;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: var(--gray);
      color: var(--text-dark);
      margin: 0;
      padding-top: 80px;
    }

    /* Navbar */
    .navbar-custom {
      background: linear-gradient(90deg, var(--indigo), var(--blue));
      color: var(--white);
      box-shadow: 0 2px 10px rgba(0,0,0,0.2);
      border-bottom-left-radius: 25px;
      border-bottom-right-radius: 25px;
      position: fixed;
      top: 0;
      width: 100%;
      z-index: 1000;
      padding: 10px 0;
    }

    .navbar-custom .navbar-brand {
      font-weight: 700;
      color: var(--white) !important;
    }

    .navbar-custom .nav-link {
      color: #e0e7ff !important;
      font-weight: 500;
      transition: 0.3s;
      border-radius: 8px;
      padding: 6px 12px;
    }

    .navbar-custom .nav-link:hover,
    .navbar-custom .nav-link.active {
      background: rgba(255, 255, 255, 0.15);
      color: #fff !important;
    }

    .navbar-custom .dropdown-menu {
      background: var(--white);
      border: none;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      padding: 8px;
      margin-top: 10px;
    }

    .navbar-custom .dropdown-item {
      color: var(--text-dark);
      border-radius: 8px;
      padding: 8px 16px;
      font-size: 14px;
      transition: all 0.2s;
    }

    .navbar-custom .dropdown-item i {
      width: 20px;
      margin-right: 8px;
    }

    .navbar-custom .dropdown-item:hover {
      background: var(--light-blue);
      color: var(--blue);
    }

    .navbar-custom .dropdown-divider {
      margin: 4px 8px;
      border-color: #e5e7eb;
    }

    .btn-logout {
      background: #e11d48;
      color: white;
      border-radius: 8px;
      padding: 5px 12px;
      transition: 0.3s;
    }

    .btn-logout:hover { background: #be123c; }

    /* Content Area */
    .content-wrapper {
      min-height: 100vh;
      padding: 30px;
      background: linear-gradient(180deg, var(--light-blue), var(--white));
    }

    .card {
      background: #ffffff;
      border: none;
      border-radius: 20px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
      width: 100%;
      max-width: 800px;
      padding: 40px;
      position: relative;
    }

    .card h4 {
      text-align: center;
      font-weight: 700;
      color: #1e40af;
      margin-bottom: 30px;
    }

    .form-control, .form-select {
      border-radius: 12px;
      border: 1px solid #cbd5e1;
      padding: 10px 14px;
      font-size: 15px;
      transition: all 0.25s ease;
      background-color: #f9fafb;
    }

    .form-control:focus, .form-select:focus {
      border-color: #2563eb;
      background-color: #fff;
      box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.25);
    }

    textarea.form-control {
      resize: none;
    }

    /* Tombol Kirim (besar di tengah, sedikit lebih naik) */
    .btn-submit {
      display: block;
      margin: 25px auto 10px auto; /* naik sedikit dari bawah */
      background: linear-gradient(90deg, #2563eb, #1d4ed8);
      color: white;
      font-weight: 600;
      border: none;
      border-radius: 12px;
      padding: 12px 0;
      width: 55%;
      font-size: 16px;
      box-shadow: 0 6px 15px rgba(37, 99, 235, 0.35);
      transition: all 0.3s ease;
      text-align: center;
    }

    .btn-submit:hover {
      background: linear-gradient(90deg, #1d4ed8, #1e40af);
      transform: translateY(-2px);
      box-shadow: 0 8px 18px rgba(37, 99, 235, 0.45);
    }

    /* Tombol Kembali (kecil di kanan bawah) */
    .btn-kembali {
      position: absolute;
      bottom: 15px;
      right: 20px;
      background-color: #e0e7ff;
      color: #1e3a8a;
      border: none;
      font-size: 14px;
      font-weight: 600;
      border-radius: 8px;
      padding: 6px 14px;
      transition: all 0.3s ease;
      text-decoration: none;
    }

    .btn-kembali:hover {
      background-color: #c7d2fe;
      color: #1e40af;
      transform: translateY(-1px);
    }

    .alert {
      border-radius: 10px;
      font-size: 14px;
    }
  </style>
</head>

<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-custom px-4">
    <div class="container-fluid">
      <a class="navbar-brand" href="{{ route('user.dashboard') }}">
        <i class="fa fa-user"></i> Dashboard Pengguna
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarUser">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarUser">
        <ul class="navbar-nav mx-auto">
          <li class="nav-item"><a class="nav-link" href="{{ route('user.dashboard') }}"><i class="fa fa-home"></i> Dashboard</a></li>
          <li class="nav-item"><a class="nav-link active" href="{{ route('user.pengaduan.create') }}"><i class="fa fa-plus"></i> Buat Pengaduan</a></li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="historyDropdown" role="button" data-bs-toggle="dropdown">
              <i class="fa fa-history"></i> Riwayat Pengaduan
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="{{ route('user.dashboard', ['status' => 'process']) }}">
                <i class="fa fa-spinner fa-spin"></i> Sedang Diproses
              </a></li>
              <li><a class="dropdown-item" href="{{ route('user.dashboard', ['status' => 'done']) }}">
                <i class="fa fa-check-circle"></i> Selesai
              </a></li>
              <li><a class="dropdown-item" href="{{ route('user.dashboard', ['status' => 'rejected']) }}">
                <i class="fa fa-times-circle"></i> Ditolak
              </a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="{{ route('user.dashboard') }}">
                <i class="fa fa-list"></i> Semua Pengaduan
              </a></li>
            </ul>
          </li>
        </ul>

        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button class="btn btn-logout"><i class="fa fa-sign-out-alt"></i> Logout</button>
        </form>
      </div>
    </div>
  </nav>

  <div class="content-wrapper">
    <div class="card">
      <h4><i class="fa fa-file-pen me-2"></i> Formulir Pengaduan Sarpras</h4>

    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
      <div class="alert alert-danger">
        <ul class="mb-0">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('user.pengaduan.store') }}" method="POST" enctype="multipart/form-data">
      @csrf

      <div class="mb-3">
        <label for="nama_pengaduan" class="form-label">Judul Pengaduan</label>
        <input type="text" name="nama_pengaduan" id="nama_pengaduan" class="form-control" required value="{{ old('nama_pengaduan') }}">
      </div>

      <div class="mb-3">
        <label for="id_lokasi" class="form-label">Pilih Lokasi</label>
        <select name="id_lokasi" id="id_lokasi" class="form-select" required>
          <option value="">-- Pilih Lokasi --</option>
          @foreach($lokasiList as $lokasi)
            <option value="{{ $lokasi->id_lokasi }}" {{ old('id_lokasi') == $lokasi->id_lokasi ? 'selected' : '' }}>{{ $lokasi->nama_lokasi }}</option>
          @endforeach
        </select>
      </div>

      <!-- Switch Button untuk Pilih Barang -->
      <div class="mb-3">
        <label class="form-label">Pilih Sumber Barang</label>
        <div class="btn-group w-100" role="group" id="barangModeGroup">
          <input type="radio" class="btn-check" name="barang_mode" id="barang_existing" value="existing" {{ old('barang_mode', 'existing') === 'existing' ? 'checked' : '' }}>
          <label class="btn btn-outline-primary" for="barang_existing">
            <i class="fa fa-list me-2"></i> Pilih Barang yang Ada
          </label>

          <input type="radio" class="btn-check" name="barang_mode" id="barang_new" value="new" {{ old('barang_mode') === 'new' ? 'checked' : '' }}>
          <label class="btn btn-outline-success" for="barang_new">
            <i class="fa fa-plus me-2"></i> Ajukan Barang Baru
          </label>
        </div>
      </div>

      <!-- Section untuk Pilih Barang Existing -->
      <div id="section_existing" class="barang-section">
        <div class="mb-3">
          <label for="id_item" class="form-label">Pilih Barang</label>
          <select name="id_item" id="id_item" class="form-select" data-old="{{ old('id_item') }}">
            <option value="">-- Pilih Barang --</option>
          </select>
        </div>
      </div>

      <!-- Section untuk Input Barang Baru -->
      <div id="section_new" class="barang-section" style="display: none;">
        <div class="mb-3">
          <label for="nama_barang_baru" class="form-label">Nama Barang Baru <span class="text-danger">*</span></label>
          <input type="text" name="nama_barang_baru" id="nama_barang_baru" class="form-control" 
                 placeholder="Masukkan nama barang yang ingin diajukan" value="{{ old('nama_barang_baru') }}">
        </div>
        <div class="mb-3">
          <label for="deskripsi_barang" class="form-label">Deskripsi Barang (Opsional)</label>
          <textarea name="deskripsi_barang" id="deskripsi_barang" class="form-control" rows="4" 
                    placeholder="Deskripsi barang yang ingin diajukan">{{ old('deskripsi_barang') }}</textarea>
        </div>
        <div class="mb-4">
          <label for="foto_barang" class="form-label">Foto Barang (Opsional)</label>
          <input type="file" name="foto_barang" id="foto_barang" class="form-control" accept="image/*">
          <small class="text-muted">Format: JPG, JPEG, PNG. Maksimal 2MB</small>
        </div>
      </div>

      <!-- Section untuk Deskripsi dan Foto Pengaduan (muncul saat pilih barang existing) -->
      <div id="section_pengaduan" class="pengaduan-section">
        <div class="mb-3">
          <label for="isi_laporan" class="form-label">Deskripsi Pengaduan</label>
          <textarea name="isi_laporan" id="isi_laporan" class="form-control" rows="4" required>{{ old('isi_laporan') }}</textarea>
        </div>

        <div class="mb-4">
          <label for="foto" class="form-label">Foto Pengaduan (Opsional)</label>
          <input type="file" name="foto" id="foto" class="form-control" accept="image/*">
          <small class="text-muted">Format: JPG, JPEG, PNG. Maksimal 2MB</small>
        </div>
      </div>

      <!-- Tombol Kirim di tengah -->
      <button type="submit" class="btn-submit">
        <i class="fa fa-paper-plane me-2"></i> Kirim Pengaduan
      </button>

      <div class="mt-3">
        <a href="{{ route('user.dashboard') }}" class="btn btn-outline-secondary">
          <i class="fa fa-arrow-left"></i> Kembali ke Dashboard
        </a>
      </div>
    </form>
  </div>
  </div>

  <script>
    function toggleBarangSection(mode) {
      if (mode === 'existing') {
        // Mode: Pilih Barang yang Ada
        $('#section_existing').show();
        $('#section_new').hide();
        $('#section_pengaduan').show(); // Tampilkan foto dan deskripsi pengaduan
        $('#id_item').prop('required', true).prop('disabled', false);
        $('#nama_barang_baru').prop('required', false);
        $('#isi_laporan').prop('required', true); // Deskripsi pengaduan wajib
        $('#deskripsi_barang').prop('required', false);
      } else {
        // Mode: Ajukan Barang Baru
        $('#section_existing').hide();
        $('#section_new').show();
        $('#section_pengaduan').hide(); // Sembunyikan foto dan deskripsi pengaduan
        $('#id_item').prop('required', false).prop('disabled', true).val('');
        $('#nama_barang_baru').prop('required', true);
        $('#isi_laporan').prop('required', false); // Deskripsi pengaduan tidak wajib
        $('#deskripsi_barang').prop('required', false);
      }
    }

    // Toggle antara pilih barang existing atau input barang baru
    $('input[name="barang_mode"]').on('change', function() {
      const mode = $(this).val();
      toggleBarangSection(mode);
    });

    // Load barang berdasarkan lokasi
    $('#id_lokasi').on('change', function () {
      let idLokasi = $(this).val();
      $('#id_item').html('<option value="">Memuat...</option>');

      if (idLokasi) {
        // Gunakan route name untuk membangun URL
        let url = "{{ route('user.barang_by_lokasi', ':id') }}".replace(':id', idLokasi);
        $.get(url, function (data) {
          let options = '<option value="">-- Pilih Barang --</option>';
          if (data.length > 0) {
            data.forEach(function (item) {
              options += `<option value="${item.id_item}">${item.nama_item}</option>`;
            });
          } else {
            options = '<option value="">Tidak ada barang di lokasi ini</option>';
          }
          $('#id_item').html(options);
          const oldItem = $('#id_item').data('old');
          if (oldItem) {
            $('#id_item').val(oldItem);
            $('#id_item').data('old', '');
          }
        }).fail(function() {
          console.error('Gagal memuat data barang');
          $('#id_item').html('<option value="">Gagal memuat data</option>');
        });
      } else {
        $('#id_item').html('<option value="">-- Pilih Barang --</option>');
      }
    });

    // Set tampilan awal berdasarkan nilai lama
    $(document).ready(function() {
      const initialMode = $('input[name="barang_mode"]:checked').val() || 'existing';
      toggleBarangSection(initialMode);

      const oldLokasi = @json(old('id_lokasi'));
      if (oldLokasi) {
        $('#id_lokasi').trigger('change');
      }
    });

    // Validasi form sebelum submit
    $('form').on('submit', function(e) {
      const mode = $('input[name="barang_mode"]:checked').val();
      
      if (mode === 'existing') {
        if (!$('#id_item').val()) {
          e.preventDefault();
          alert('Silakan pilih barang yang ada atau pilih opsi "Ajukan Barang Baru"');
          return false;
        }
        if (!$('#isi_laporan').val().trim()) {
          e.preventDefault();
          alert('Silakan isi deskripsi pengaduan');
          return false;
        }
      } else {
        if (!$('#nama_barang_baru').val().trim()) {
          e.preventDefault();
          alert('Silakan masukkan nama barang baru');
          return false;
        }
      }
    });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
</body>
</html>