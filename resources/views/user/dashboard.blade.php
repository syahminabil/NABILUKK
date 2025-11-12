<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Pengguna - Pengaduan Sarpras</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

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
      font-family: "Poppins", sans-serif;
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

    .navbar-custom .dropdown-item:hover,
    .navbar-custom .dropdown-item.active {
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

    /* Content */
    .main-content {
      padding: 30px;
      background: linear-gradient(180deg, var(--light-blue), var(--white));
      min-height: 100vh;
    }

    .topbar {
      background: var(--white);
      border-left: 5px solid var(--blue);
      padding: 15px 25px;
      border-radius: 15px;
      box-shadow: 0 3px 8px rgba(0,0,0,0.08);
      margin-bottom: 25px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .photo-thumb {
      width: 80px;
      border-radius: 6px;
      transition: 0.3s;
    }
    .photo-thumb:hover { transform: scale(1.05); }

    /* Quick Action Cards */
    .icon-circle {
      width: 70px;
      height: 70px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 1rem;
      transition: all 0.3s ease;
    }

    .hover-card {
      transition: all 0.3s ease;
      border: 2px solid transparent !important;
    }

    .hover-card:hover {
      transform: translateY(-5px);
    }

    .hover-card:hover .icon-circle {
      transform: scale(1.1);
    }

    /* Status-specific card styles */
    .card h5 {
      color: var(--text-dark);
      font-weight: 600;
    }

    .card-header {
      border-bottom: 1px solid #e5e7eb;
    }

    /* Table styles */
    .table-container {
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 0 10px rgba(0,0,0,0.05);
    }
    
    .table {
      margin-bottom: 0;
      background: white;
      font-size: 13px;
    }
    
    .table th {
      background-color: #0d6efd;
      color: white;
      font-weight: 600;
      padding: 8px 10px;
      border: none;
      white-space: nowrap;
      font-size: 13px;
    }

    .table td {
      padding: 8px 10px;
      vertical-align: middle;
      border-bottom: 1px solid #dee2e6;
      max-width: 0;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
    }

    .table td.description-cell {
      white-space: normal;
      min-width: 200px;
      max-width: none;
      line-height: 1.4;
    }

    .table tbody tr:hover {
      background-color: rgba(13, 110, 253, 0.05);
    }

    .table-responsive {
      border-radius: 8px;
      overflow-x: auto;
    }

    .badge {
      white-space: nowrap;
    }

    /* Card containing table */
    .table-card { 
      max-width: 98%; 
      margin-left: auto;
      margin-right: auto;
    }

    /* Photo thumbnail in table */
    .photo-thumb {
      width: 40px;
      height: 40px;
      object-fit: cover;
      border-radius: 4px;
    }

    /* Action buttons in table */
    .action-buttons {
      display: flex;
      flex-wrap: wrap;
      gap: 5px;
    }
    
    .action-buttons .btn {
      font-size: 0.8rem;
      padding: 5px 8px;
    }

    /* Custom status colors */
    .bg-warning {
      background-color: #f59e0b !important;
    }

    .text-warning {
      color: #f59e0b !important;
    }

    .bg-success {
      background-color: #10b981 !important;
    }

    .bg-danger {
      background-color: #ef4444 !important;
    }

    /* Modal styles */
    .modal-photo {
      max-width: 100%;
      height: auto;
      border-radius: 8px;
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
        <span class="navbar-toggler-icon text-white"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarUser">
        <ul class="navbar-nav mx-auto">
          <li class="nav-item"><a class="nav-link {{ !request('status') ? 'active' : '' }}" href="{{ route('user.dashboard') }}">
            <i class="fa fa-home"></i> Dashboard
          </a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('user.pengaduan.create') }}">
            <i class="fa fa-plus"></i> Buat Pengaduan
          </a></li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle {{ request('status') ? 'active' : '' }}" href="#" id="historyDropdown" role="button" data-bs-toggle="dropdown">
              <i class="fa fa-history"></i> Riwayat Pengaduan
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item {{ request('status') == 'process' ? 'active' : '' }}" href="{{ route('user.dashboard', ['status' => 'process']) }}">
                <i class="fa fa-spinner fa-spin"></i> Sedang Diproses
              </a></li>
              <li><a class="dropdown-item {{ request('status') == 'done' ? 'active' : '' }}" href="{{ route('user.dashboard', ['status' => 'done']) }}">
                <i class="fa fa-check-circle"></i> Selesai
              </a></li>
              <li><a class="dropdown-item {{ request('status') == 'rejected' ? 'active' : '' }}" href="{{ route('user.dashboard', ['status' => 'rejected']) }}">
                <i class="fa fa-times-circle"></i> Ditolak
              </a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item {{ !request('status') ? 'active' : '' }}" href="{{ route('user.dashboard') }}">
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

  <!-- Content -->
  <div class="main-content container-fluid">
    <div class="topbar mb-4">
      <div>
        <h4>Halo, {{ Auth::user()->name }}</h4>
        <span>Selamat datang di sistem pengaduan sarpras</span>
      </div>
    </div>

    <!-- Quick Actions -->
    <div class="row g-4 mb-4">
      <!-- Create New -->
      <div class="col-md-6 col-lg-3">
        <a href="{{ route('user.pengaduan.create') }}" class="card h-100 border-0 shadow-sm hover-card text-decoration-none">
          <div class="card-body d-flex flex-column align-items-center text-center p-4">
            <div class="icon-circle bg-primary text-white mb-3">
              <i class="fas fa-plus fa-2x"></i>
            </div>
            <h5 class="card-title mb-2">Buat Pengaduan</h5>
            <p class="card-text text-muted small">Ajukan pengaduan baru untuk sarpras</p>
          </div>
        </a>
      </div>

      <!-- In Progress -->
      <div class="col-md-6 col-lg-3">
        <a href="{{ route('user.dashboard', ['status' => 'process']) }}" class="card h-100 border-0 shadow-sm hover-card text-decoration-none">
          <div class="card-body d-flex flex-column align-items-center text-center p-4">
            <div class="icon-circle bg-warning text-white mb-3">
              <i class="fas fa-clock fa-2x"></i>
            </div>
            <h5 class="card-title mb-2">Sedang Diproses</h5>
            <p class="card-text text-muted small">Lihat pengaduan yang sedang ditangani</p>
          </div>
        </a>
      </div>

      <!-- Completed -->
      <div class="col-md-6 col-lg-3">
        <a href="{{ route('user.dashboard', ['status' => 'done']) }}" class="card h-100 border-0 shadow-sm hover-card text-decoration-none">
          <div class="card-body d-flex flex-column align-items-center text-center p-4">
            <div class="icon-circle bg-success text-white mb-3">
              <i class="fas fa-check-circle fa-2x"></i>
            </div>
            <h5 class="card-title mb-2">Selesai</h5>
            <p class="card-text text-muted small">Lihat pengaduan yang telah selesai</p>
          </div>
        </a>
      </div>

      <!-- Rejected -->
      <div class="col-md-6 col-lg-3">
        <a href="{{ route('user.dashboard', ['status' => 'rejected']) }}" class="card h-100 border-0 shadow-sm hover-card text-decoration-none">
          <div class="card-body d-flex flex-column align-items-center text-center p-4">
            <div class="icon-circle bg-danger text-white mb-3">
              <i class="fas fa-times-circle fa-2x"></i>
            </div>
            <h5 class="card-title mb-2">Ditolak</h5>
            <p class="card-text text-muted small">Lihat pengaduan yang ditolak</p>
          </div>
        </a>
      </div>
    </div>

    <!-- Status Summary -->
    @php
      $status = request('status');
      $statusTitle = match($status) {
        'process' => 'Sedang Diproses',
        'done' => 'Selesai',
        'rejected' => 'Ditolak',
        default => 'Semua Status'
      };
      $statusIcon = match($status) {
        'process' => 'spinner fa-spin text-warning',
        'done' => 'check-circle text-success',
        'rejected' => 'times-circle text-danger',
        default => 'list text-primary'
      };
    @endphp

    <div class="card border-0 shadow-sm">
      <div class="card-header bg-white py-3">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <h5 class="mb-0">
              <i class="fa fa-{{ $statusIcon }} me-2"></i>
              Pengaduan {{ $statusTitle }}
            </h5>
          </div>
          <div>
          </div>
        </div>
      </div>
      <div class="card-body p-4">

      @php
        $filteredPengaduan = $pengaduan->filter(function($p) use ($status) {
          return match($status) {
            'process' => in_array($p->status, ['Diajukan', 'Diproses']),
            'done' => $p->status === 'Selesai',
            'rejected' => $p->status === 'Ditolak',
            default => true
          };
        });
      @endphp

      @if($filteredPengaduan->count() > 0)
      <div class="card table-card">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
          <div><i class="fa fa-list"></i> Daftar Pengaduan {{ $statusTitle }}</div>
          <div class="text-white-50 small">Total: {{ $filteredPengaduan->count() }} pengaduan</div>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table align-middle mb-0">
              <thead>
                <tr>
                  <th width="3%" class="text-center">No</th>
                  <th width="15%">Nama Pengaduan</th>
                  <th width="20%">Deskripsi</th>
                  <th width="12%">Lokasi</th>
                  <th width="8%" class="text-center">Foto</th>
                  <th width="8%" class="text-center">Status</th>
                  <th width="10%">Petugas</th>
                  <th width="10%" class="text-center">Tgl Pengajuan</th>
                  <th width="10%" class="text-center">Tgl Selesai</th>
                  <th width="15%">Saran Petugas</th>
                  <th width="10%" class="text-center">Foto Saran</th>
                </tr>
              </thead>
              <tbody>
                @foreach($filteredPengaduan as $i => $p)
                @php
                  $badge = match($p->status) {
                    'Diajukan' => 'bg-primary',
                    'Diproses' => 'bg-warning text-dark',
                    'Selesai'  => 'bg-success',
                    'Ditolak'  => 'bg-danger',
                    default => 'bg-secondary',
                  };
                @endphp
                <tr>
                  <td class="text-center">{{ $i + 1 }}</td>
                  <td title="{{ $p->nama_pengaduan }}">{{ $p->nama_pengaduan }}</td>
                  <td class="description-cell">{{ $p->deskripsi }}</td>
                  <td title="{{ $p->lokasi }}">{{ $p->lokasi }}</td>

                  {{-- Foto Pengaduan --}}
                  <td class="text-center">
                    @if($p->foto)
                      <img src="{{ asset('storage/' . $p->foto) }}" class="photo-thumb" alt="Foto Pengaduan" 
                           style="cursor: pointer;" onclick="showPhoto('{{ asset('storage/' . $p->foto) }}')">
                    @else
                      <span class="text-muted">-</span>
                    @endif
                  </td>

                  {{-- Status --}}
                  <td class="text-center"><span class="badge {{ $badge }}">{{ $p->status }}</span></td>

                  {{-- Nama Petugas --}}
                  <td title="{{ $p->petugas->nama ?? '-' }}">{{ $p->petugas->nama ?? '-' }}</td>

                  {{-- Tanggal Pengajuan --}}
                  <td class="text-center">
                    {{ \Carbon\Carbon::parse($p->tgl_pengajuan)->format('d-m-Y') }}
                  </td>

                  {{-- Tanggal Selesai --}}
                  <td class="text-center">
                    {{ $p->tgl_selesai ? \Carbon\Carbon::parse($p->tgl_selesai)->format('d-m-Y') : '-' }}
                  </td>

                  {{-- Saran Petugas --}}
                  <td>{{ $p->saran_petugas ?? '-' }}</td>

                  {{-- Foto Saran --}}
                  <td class="text-center">
                    @if($p->foto_saran)
                      <img src="{{ asset('storage/' . $p->foto_saran) }}" alt="Foto Saran" 
                           style="max-height: 40px; cursor: pointer;" 
                           onclick="showPhoto('{{ asset('storage/' . $p->foto_saran) }}')">
                    @else
                      <span class="text-muted">-</span>
                    @endif
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
      @else
        <div class="text-center py-4">
          <i class="fa fa-{{ $statusIcon }} fa-3x mb-3 text-muted"></i>
          <p class="text-muted">
            @if($status)
              Tidak ada pengaduan dengan status "{{ $statusTitle }}".
            @else
              Belum ada pengaduan yang diajukan.
            @endif
          </p>
          <a href="{{ route('user.pengaduan.create') }}" class="btn btn-primary mt-2">
            <i class="fa fa-plus"></i> Buat Pengaduan Baru
          </a>
        </div>
      @endif
      </div>
    </div>
  </div>

  <!-- Photo Modal -->
  <div class="modal fade" id="photoModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Foto</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body text-center">
          <img src="" class="modal-photo img-fluid" alt="Foto">
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Fungsi untuk menampilkan foto di modal
    function showPhoto(src) {
      const img = document.querySelector('#photoModal .modal-photo');
      if (img) {
        img.src = src;
        const photoModal = new bootstrap.Modal(document.getElementById('photoModal'));
        photoModal.show();
      }
    }

    // Tambahkan event listener untuk semua foto yang bisa diklik
    document.addEventListener('DOMContentLoaded', function() {
      // Foto pengaduan
      document.querySelectorAll('img[onclick*="showPhoto"]').forEach(img => {
        img.style.cursor = 'pointer';
      });
    });
  </script>
</body>
</html>