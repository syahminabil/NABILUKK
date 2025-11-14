<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Petugas - Pengaduan Sarpras</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

  <style>
    body { background: #f4f6f9; font-family: Arial, sans-serif; }
    /* Navbar (menggantikan sidebar) - biru dengan lengkung sedikit */
    .navbar-custom {
      background: linear-gradient(180deg, #0d6efd 0%, #0b5ed7 100%); /* gradasi biru */
      border-bottom-left-radius: 10px;
      border-bottom-right-radius: 10px;
      box-shadow: 0 6px 18px rgba(13, 110, 253, 0.12);
      z-index: 1030; /* pastikan di atas konten */
      transition: all 0.2s ease-in-out;
    }
    .navbar-custom .navbar-brand {
      color: #fff;
      font-weight: 700;
    }
    .navbar-custom .nav-link {
      color: rgba(255,255,255,0.9) !important;
      transition: 0.2s;
      margin-right: 6px;
    }
    .navbar-custom .nav-link:hover { color: #fff !important; opacity: 0.95; }
    .navbar-custom .nav-link.active {
      background: rgba(255,255,255,0.12); color: #fff !important; border-radius: 6px; padding-left: 10px; padding-right: 10px;
    }
  /* Beri sedikit ruang ekstra karena navbar lebih tinggi saat responsive */
  .main-content { margin-top: 86px; padding: 25px; max-width: 1200px; margin-left: auto; margin-right: auto; }
    .card { border-radius: 10px; box-shadow: 0 3px 10px rgba(0,0,0,0.1); }
    table th { background-color: #0d6efd; color: #fff; }
    .modal-img { max-width: 100%; border-radius: 10px; }
    
    /* Perbaikan untuk tabel */
    .table-container {
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 0 10px rgba(0,0,0,0.05);
    }
    .table th {
      background-color: #0d6efd;
      color: white;
      font-weight: 600;
      padding: 12px 15px;
      border: none;
    }
    .table td {
      padding: 12px 15px;
      vertical-align: middle;
      border-bottom: 1px solid #dee2e6;
    }
    .table tbody tr:hover {
      background-color: rgba(13, 110, 253, 0.05);
    }
    .table-responsive {
      border-radius: 10px;
    }
    /* Kartu daftar agar tidak terlalu melebar dan selalu berada di tengah */
    .table-card { max-width: 1100px; }
    .badge {
      font-size: 0.75em;
      padding: 6px 10px;
    }
    .action-buttons {
      display: flex;
      flex-wrap: wrap;
      gap: 5px;
    }
    .action-buttons .btn {
      font-size: 0.8rem;
      padding: 5px 8px;
    }
    .empty-state {
      padding: 40px 20px;
      text-align: center;
      color: #6c757d;
    }
    .empty-state i {
      font-size: 3rem;
      margin-bottom: 15px;
      opacity: 0.5;
    }
    /* Foto styles */
    .photo-thumb {
      width: 60px;
      height: 60px;
      object-fit: cover;
      border-radius: 6px;
      cursor: pointer;
      transition: transform 0.2s;
    }
    .photo-thumb:hover {
      transform: scale(1.05);
    }
    #photoModal .modal-body {
      padding: 0;
      background: #000;
      border-radius: 0.5rem;
    }
    #photoModal img {
      max-width: 100%;
      height: auto;
      display: block;
      margin: 0 auto;
    }
  </style>
</head>

<body>

  <!-- Navbar (menggantikan sidebar) -->
  <nav class="navbar navbar-expand-lg navbar-dark navbar-custom fixed-top">
    <div class="container-fluid">
      <a class="navbar-brand" href="#"><i class="fa fa-user-shield"></i> DASHBOARD PETUGAS</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('petugas.dashboard') ? 'active' : '' }}" href="{{ route('petugas.dashboard') }}"><i class="fa fa-home"></i> DASHBOARD</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('petugas.lokasi.index') ? 'active' : '' }}" href="{{ route('petugas.lokasi.index') }}"><i class="fa fa-box"></i> BARANG</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('petugas.lokasi.crud.index') ? 'active' : '' }}" href="{{ route('petugas.lokasi.crud.index') }}"><i class="fa fa-list"></i> DAFTAR RUANG</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('petugas.penolakan.index') ? 'active' : '' }}" href="{{ route('petugas.penolakan.index') }}"><i class="fa fa-ban"></i> DITOLAK</a>
          </li>
        </ul>

        <form method="POST" action="{{ route('logout') }}" class="d-flex ms-auto">
          @csrf
          <button class="btn btn-danger" type="submit"><i class="fa fa-sign-out-alt"></i> Logout</button>
        </form>
      </div>
    </div>
  </nav>

  <!-- Main -->
  <div class="main-content">
    <h4 class="fw-bold text-primary mb-4"><i class="fa fa-gauge"></i> Dashboard Petugas</h4>

    @if (session('success'))
      <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    <!-- Statistik -->
  <div class="row g-3 mb-4 justify-content-center">
      <div class="col-md-3"><div class="card text-center border-primary"><div class="card-body"><h6>Total Pengaduan</h6><h3 class="text-primary fw-bold">{{ $totalPengaduan }}</h3></div></div></div>
      <div class="col-md-3"><div class="card text-center border-info"><div class="card-body"><h6>Sedang Diproses</h6><h3 class="text-info fw-bold">{{ $pengaduanProses }}</h3></div></div></div>
      <div class="col-md-3"><div class="card text-center border-success"><div class="card-body"><h6>Selesai</h6><h3 class="text-success fw-bold">{{ $pengaduanSelesai }}</h3></div></div></div>
      <div class="col-md-3"><div class="card text-center border-danger"><div class="card-body"><h6>Ditolak</h6><h3 class="text-danger fw-bold">{{ $jumlahPenolakan }}</h3></div></div></div>
    </div>

    <!-- Daftar Pengaduan -->
  <div class="card table-card mx-auto">
      <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <div>
          <i class="fa fa-list"></i> Daftar Pengaduan Terbaru
        </div>
        <div class="text-white-50 small">
          Total: {{ $pengaduanTerbaru->count() }} pengaduan
        </div>
      </div>
      <div class="card-body">
        <!-- Search Form -->
        <div class="mb-4">
          <form action="{{ route('petugas.dashboard') }}" method="GET" class="d-flex gap-2">
            <div class="flex-grow-1">
              <input type="text" name="search" class="form-control" placeholder="Cari berdasarkan judul, nama pelapor, atau status..." value="{{ request('search') }}">
            </div>
            <button type="submit" class="btn btn-primary">
              <i class="fas fa-search"></i> Cari
            </button>
            @if(request('search'))
              <a href="{{ route('petugas.dashboard') }}" class="btn btn-secondary">
                <i class="fas fa-times"></i> Reset
              </a>
            @endif
          </form>
        </div>
        
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0">
            <thead>
              <tr>
                <th width="5%" class="text-center">No</th>
                <th width="15%">Nama Pelapor</th>
                <th width="18%">Judul Pengaduan</th>
                <th width="10%">Foto</th>
                <th width="10%" class="text-center">Tanggal</th>
                <th width="12%" class="text-center">Status</th>
                <th width="20%" class="text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse($pengaduanTerbaru as $index => $p)
                <tr>
                  <td class="text-center fw-bold">{{ $index + 1 }}</td>
                  <td class="fw-medium">{{ $p->user->name ?? '-' }}</td>
                  <td>
                    <div class="text-truncate" style="max-width: 200px;" title="{{ $p->nama_pengaduan ?? '-' }}">
                      {{ $p->nama_pengaduan ?? '-' }}
                    </div>
                  </td>
                  <td class="text-center">
                    @if($p->foto)
                      <img 
                        src="{{ asset('storage/' . $p->foto) }}" 
                        class="photo-thumb" 
                        alt="Foto Pengaduan"
                        onclick="showPhoto('{{ asset('storage/' . $p->foto) }}')"
                        title="Klik untuk memperbesar"
                      >
                    @else
                      <span class="text-muted">-</span>
                    @endif
                  </td>
                  <td class="text-center">{{ \Carbon\Carbon::parse($p->created_at)->format('d M Y') }}</td>
                  <td class="text-center">
                    @if($p->status == 'Diajukan')
                      <span class="badge bg-secondary">Diajukan</span>
                    @elseif($p->status == 'Disetujui')
                      <span class="badge bg-primary">Disetujui</span>
                    @elseif($p->status == 'Diproses')
                      <span class="badge bg-info">Diproses</span>
                    @elseif($p->status == 'Selesai')
                      <span class="badge bg-success">Selesai</span>
                    @elseif($p->status == 'Ditolak')
                      <span class="badge bg-danger">Ditolak</span>
                    @endif
                  </td>
                  <td class="text-center">
                    <div class="action-buttons justify-content-center">

                      <!-- Tombol Detail -->
                      <button 
                        class="btn btn-sm btn-outline-primary"
                        data-bs-toggle="modal"
                        data-bs-target="#detailModal"
                        data-nama="{{ $p->nama_pengaduan }}"
                        data-deskripsi="{{ $p->deskripsi }}"
                        data-lokasi="{{ $p->lokasi }}"
                        data-foto="{{ asset('storage/' . $p->foto) }}"
                        data-status="{{ $p->status }}"
                        data-user="{{ $p->user->name ?? '-' }}"
                        data-petugas="{{ $p->petugas->nama ?? '-' }}"
                        data-tglpengajuan="{{ \Carbon\Carbon::parse($p->tgl_pengajuan)->format('d M Y') }}"
                        data-tglselesai="{{ $p->tgl_selesai ? \Carbon\Carbon::parse($p->tgl_selesai)->format('d M Y') : '-' }}"
                        data-saran="{{ $p->saran_petugas ?? '-' }}"
                        title="Lihat Detail">
                        <i class="fa fa-eye"></i>
                      </button>

                      {{-- Tombol aksi berdasarkan status --}}
                      @if($p->status === 'Diajukan' || $p->status === 'Disetujui')
                          <!-- MULAI pengerjaan -->
                          <form method="POST" action="{{ route('petugas.pengaduan.mulai', $p->id_pengaduan) }}" class="d-inline">
                              @csrf
                              <button type="submit" class="btn btn-sm btn-outline-warning" onclick="return confirm('Mulai pengerjaan pengaduan ini?')" title="Mulai Pengerjaan">
                                  <i class="fa fa-play"></i> Mulai
                              </button>
                          </form>

                      @elseif($p->status === 'Diproses')
                          <!-- SELESAIKAN -->
                          <form method="POST" action="{{ route('petugas.pengaduan.selesai', $p->id_pengaduan) }}" class="d-inline">
                              @csrf
                              <button type="submit" class="btn btn-sm btn-outline-success" onclick="return confirm('Yakin ingin menyelesaikan pengaduan ini?')" title="Selesaikan Pengaduan">
                                  <i class="fa fa-check-double"></i>
                              </button>
                          </form>

                      @elseif($p->status === 'Selesai')
                          <!-- SARAN -->
                          @if(!$p->saran_petugas)
                              <a href="{{ route('petugas.formsaran', $p->id_pengaduan) }}" class="btn btn-sm btn-outline-primary" title="Kirim Saran">
                                  <i class="fa fa-comment-dots"></i>
                              </a>
                          @else
                              <span class="text-success small" title="Saran sudah dikirim">
                                  <i class="fa fa-check-circle"></i>
                              </span>
                          @endif
                      @endif

                      <!-- Tombol Cetak -->
                      <button type="button" 
                              class="btn btn-sm btn-outline-secondary btn-print" 
                              title="Cetak"
                              data-item='@json($p)'
                              onclick="printFromData(this)">
                        <i class="fa fa-print"></i>
                      </button>

                    </div>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="7" class="empty-state">
                    <i class="fa fa-inbox"></i>
                    <p class="mb-0">Belum ada pengaduan.</p>
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Foto -->
  <div class="modal fade" id="photoModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header bg-dark text-white">
          <h5 class="modal-title"><i class="fa fa-image"></i> Foto Pengaduan</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body p-0">
          <img id="modalImage" src="" alt="Foto Pengaduan" style="width:100%;">
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Detail -->
  <div class="modal fade" id="detailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content border-0">
        <div class="modal-header bg-dark text-white py-3">
          <h5 class="modal-title mb-0">
            <i class="fa fa-info-circle me-2"></i>
            <span class="fw-semibold">Detail Pengaduan</span>
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body p-4">
          <div class="row">
            <div class="col-md-6">
              <div class="card border-0 bg-light">
                <div class="card-body">
                  <div class="mb-3">
                    <label class="text-muted small mb-1">Nama Pengaduan</label>
                    <div class="fs-6 fw-semibold" id="detailNama"></div>
                  </div>
                  <div class="mb-3">
                    <label class="text-muted small mb-1">Deskripsi</label>
                    <div class="fs-6" id="detailDeskripsi" style="text-align: justify;"></div>
                  </div>
                  <div class="row mb-3">
                    <div class="col-6">
                      <label class="text-muted small mb-1">Lokasi</label>
                      <div class="fs-6" id="detailLokasi"></div>
                    </div>
                    <div class="col-6">
                      <label class="text-muted small mb-1">Status</label>
                      <div class="fs-6" id="detailStatus"></div>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <div class="col-6">
                      <label class="text-muted small mb-1">Nama User</label>
                      <div class="fs-6" id="detailUser"></div>
                    </div>
                    <div class="col-6">
                      <label class="text-muted small mb-1">Nama Petugas</label>
                      <div class="fs-6" id="detailPetugas"></div>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <div class="col-6">
                      <label class="text-muted small mb-1">Tanggal Pengajuan</label>
                      <div class="fs-6" id="detailTglPengajuan"></div>
                    </div>
                    <div class="col-6">
                      <label class="text-muted small mb-1">Tanggal Selesai</label>
                      <div class="fs-6" id="detailTglSelesai"></div>
                    </div>
                  </div>
                  <div class="mb-3">
                    <label class="text-muted small mb-1">Saran Petugas</label>
                    <div class="fs-6" id="detailSaran" style="text-align: justify;"></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="card h-100 border-0 shadow-sm">
                <div class="card-body p-0">
                  <img 
                    id="detailFoto" 
                    src="" 
                    alt="Foto Pengaduan" 
                    class="img-fluid rounded"
                    style="width: 100%; height: 100%; object-fit: cover; cursor: pointer;" 
                    onclick="showPhoto(this.src)"
                    title="Klik untuk memperbesar">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Saat tombol Detail diklik, isi data ke dalam modal
    const detailModal = document.getElementById('detailModal');
    detailModal.addEventListener('show.bs.modal', event => {
      const button = event.relatedTarget;

      document.getElementById('detailNama').textContent = button.getAttribute('data-nama');
      document.getElementById('detailDeskripsi').textContent = button.getAttribute('data-deskripsi');
      document.getElementById('detailLokasi').textContent = button.getAttribute('data-lokasi');
      document.getElementById('detailStatus').textContent = button.getAttribute('data-status');
      document.getElementById('detailUser').textContent = button.getAttribute('data-user');
      document.getElementById('detailPetugas').textContent = button.getAttribute('data-petugas');
      document.getElementById('detailTglPengajuan').textContent = button.getAttribute('data-tglpengajuan');
      document.getElementById('detailTglSelesai').textContent = button.getAttribute('data-tglselesai');
      document.getElementById('detailSaran').textContent = button.getAttribute('data-saran');
      document.getElementById('detailFoto').src = button.getAttribute('data-foto');
    });

    // Fungsi untuk menampilkan foto dalam modal
    function showPhoto(photoUrl) {
      document.getElementById('modalImage').src = photoUrl;
      new bootstrap.Modal(document.getElementById('photoModal')).show();
    }

    // Fungsi untuk membuka window cetak berdasarkan data item (dipass melalui data-item)
    function printFromData(btn) {
      try {
        const item = JSON.parse(btn.getAttribute('data-item'));
        const fotoSrc = item.foto ? ('/storage/' + item.foto) : null;

        const html = `
          <html>
            <head>
              <title>Cetak Pengaduan - ${item.nama_pengaduan || ''}</title>
              <style>
                body { font-family: Arial, Helvetica, sans-serif; padding: 20px; color: #222 }
                .header { text-align: center; margin-bottom: 20px }
                .header h2 { margin: 0 }
                .meta { margin-bottom: 10px }
                .meta strong { display: inline-block; width: 160px }
                .foto { margin-top: 20px; text-align: center }
                img { max-width: 100%; height: auto; border-radius: 6px; }
                .section { margin-top: 12px }
              </style>
            </head>
            <body>
              <div class="header">
                <h2>Detail Pengaduan</h2>
                <div class="small">${new Date().toLocaleString('id-ID')}</div>
              </div>

              <div class="meta">
                <div><strong>Nama Pengaduan:</strong> ${item.nama_pengaduan || '-'}</div>
                <div><strong>Lokasi:</strong> ${item.lokasi || '-'}</div>
                <div><strong>Status:</strong> ${item.status || '-'}</div>
                <div><strong>Nama User:</strong> ${item.user && item.user.name ? item.user.name : (item.nama_user || '-')}</div>
                <div><strong>Nama Petugas:</strong> ${item.petugas && item.petugas.nama ? item.petugas.nama : (item.nama_petugas || '-')}</div>
                <div><strong>Tgl Pengajuan:</strong> ${item.tgl_pengaduan || item.tgl_pengajuan || '-'}</div>
                <div><strong>Tgl Selesai:</strong> ${item.tgl_selesai || '-'}</div>
              </div>

              <div class="section">
                <h4>Deskripsi</h4>
                <div>${item.deskripsi || '-'}</div>
              </div>

              ${fotoSrc ? `<div class="foto"><img src="${fotoSrc}" alt="Foto Pengaduan"></div>` : ''}

            </body>
          </html>
        `;

        const w = window.open('', '_blank');
        w.document.open();
        w.document.write(html);
        w.document.close();
        // Tunggu sebentar agar gambar termuat, lalu panggil print
        w.onload = function() {
          setTimeout(() => {
            w.print();
          }, 300);
        };
      } catch (err) {
        console.error('Gagal mencetak:', err);
        alert('Terjadi error saat menyiapkan cetak.');
      }
    }
  </script>
</body>
</html>