<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Admin</title>

  <!-- Bootstrap & Font Awesome -->
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

    /* ===== NAVBAR ===== */
    .navbar-custom {
      background: linear-gradient(90deg, var(--indigo), var(--blue));
      color: var(--white);
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
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
      letter-spacing: 0.5px;
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
      color: #fff !important;
      background: rgba(255, 255, 255, 0.15);
    }

    .navbar-custom .btn-logout {
      background: #e11d48;
      color: white;
      border-radius: 8px;
      padding: 5px 12px;
      transition: 0.3s;
    }

    .navbar-custom .btn-logout:hover {
      background: #be123c;
    }

    /* ===== MAIN CONTENT ===== */
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
      box-shadow: 0 3px 8px rgba(0, 0, 0, 0.08);
      margin-bottom: 25px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .topbar h4 {
      color: var(--blue);
      font-weight: 700;
    }

    /* ===== CARD STAT ===== */
    .card-stat {
      text-align: center;
      color: var(--white);
      padding: 25px 10px;
      border-radius: 12px;
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .card-stat:hover {
      transform: translateY(-4px);
      box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
    }

    .bg-blue { background: var(--blue); }
    .bg-indigo { background: var(--indigo); }
    .bg-cyan { background: #06b6d4; }
    .bg-teal { background: #0d9488; }
    .bg-warning { background: #facc15; color: var(--text-dark); }

    /* ===== TABLE ===== */
    table {
      background: var(--white);
      border-radius: 10px;
      overflow: hidden;
      width: 100%;
    }

    thead.table-dark {
      background-color: var(--indigo) !important;
    }

    thead th {
      color: var(--white);
      text-transform: uppercase;
      font-size: 13px;
      text-align: center;
    }

    tbody tr:hover {
      background-color: #eef2ff;
    }

    .photo-thumbnail {
      width: 60px;
      height: 60px;
      border-radius: 8px;
      object-fit: cover;
      border: 2px solid #e2e8f0;
      transition: transform 0.2s ease-in-out;
    }

    /* Table center wrapper */
    .table-centered {
      display: flex;
      justify-content: center;
    }

    /* Tighter table styles */
    .table-sm td, .table-sm th { padding: .5rem .6rem; }
    .table thead th { text-align: center; vertical-align: middle; }
    .table tbody td { vertical-align: middle; }

    .col-name { max-width: 220px; }
    .text-truncate-200 { max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    .actions { white-space: nowrap; }

    .photo-thumbnail:hover {
      transform: scale(1.05);
      border-color: var(--blue);
    }

    .modal-photo {
      display: block;
      margin: 0 auto;
      max-height: 80vh;
      object-fit: contain;
    }

    html { scroll-behavior: smooth; }
  </style>
</head>
<body>

  <!-- ===== NAVBAR ===== -->
  <nav class="navbar navbar-expand-lg navbar-custom px-4">
    <li class="nav-item">
    <a class="nav-link" href="{{ route('admin.users.index') }}">
        <i class="fa fa-users"></i> Data User
    </a>
</li>
    <div class="container-fluid">
      <a class="navbar-brand" href="{{ route('dashboard') }}">
        <i class="fa fa-home"></i> Dashboard
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon text-white"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mx-auto">
          <li class="nav-item"><a class="nav-link active" href="#data-pengaduan"><i class="fa fa-database"></i> Data Pengaduan</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('admin.users.index') }}"><i class="fa fa-users"></i> Data User</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('admin.petugas.index') }}"><i class="fa fa-user-tie"></i> Petugas</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('admin.daftarAdmin') }}"><i class="fa fa-user-cog"></i> Daftar Admin</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('admin.lokasi.crud.index') }}"><i class="fa fa-list"></i> Daftar Ruang</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('lokasi.index') }}"><i class="fa fa-box"></i> Tambah Barang</a></li>
        </ul>

        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button class="btn btn-logout"><i class="fa fa-sign-out-alt"></i> Logout</button>
        </form>
      </div>
    </div>
  </nav>

  <!-- ===== MAIN CONTENT ===== -->
  <div class="main-content container-fluid">
    <div class="topbar">
      <h4>Dashboard Admin</h4>
      <span>Selamat datang, <b>{{ Auth::user()->name }}</b></span>
    </div>

    <!-- Statistik -->
    <div class="row g-4">
      <div class="col-md-3">
        <div class="card-stat bg-blue">
          <i class="fa fa-users fa-2x"></i>
          <h3>{{ $totalUser ?? 0 }}</h3>
          <p>Jumlah Pengguna</p>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card-stat bg-indigo">
          <i class="fa fa-user-tie fa-2x"></i>
          <h3>{{ $totalPetugas ?? 0 }}</h3>
          <p>Jumlah Petugas</p>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card-stat bg-warning">
          <i class="fa fa-box fa-2x"></i>
          <h3>{{ $totalItem ?? 0 }}</h3>
          <p>Jumlah Barang</p>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card-stat bg-cyan">
          <i class="fa fa-file-alt fa-2x"></i>
          <h3>{{ $totalPengaduan ?? 0 }}</h3>
          <p>Total Pengaduan</p>
        </div>
      </div>
    </div>

    <!-- Data Pengaduan -->
    <div id="data-pengaduan" class="mt-5 container">
      <div class="d-flex flex-column align-items-center mb-3">
        <h5 class="text-primary fw-bold text-center mb-3">Data Pengaduan</h5>
        <form method="GET" action="{{ route('dashboard') }}" class="w-100" style="max-width:720px;">
          <div class="input-group">
            <input type="search" name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari pengaduan (judul, deskripsi, lokasi, user)...">
            <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i> Cari</button>
            @if(request('q'))
              <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">Reset</a>
            @endif
          </div>
        </form>
      </div>
      <div class="row justify-content-center">
        <div class="col-12">
          <div class="table-responsive">
            <table class="table table-bordered table-striped table-sm align-middle mx-auto" style="max-width:1100px;">
          <thead class="table-dark">
            <tr>
              <th style="width:48px">No</th>
              <th class="col-name">Nama Pengaduan</th>
              <th style="width:130px">Lokasi</th>
              <th style="width:90px">Foto</th>
              <th style="width:110px">Status</th>
              <th style="width:110px">Tgl Pengajuan</th>
              <th style="width:110px">Tgl Selesai</th>
              <th style="width:170px">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($pengaduan as $i => $item)
              @php
                $badge = match($item->status) {
                  'Diajukan'  => 'bg-primary',
                  'Disetujui' => 'bg-success',
                  'Ditolak'   => 'bg-danger',
                  'Diproses'  => 'bg-warning',
                  default     => 'bg-secondary',
                };
              @endphp
              <tr>
                <td>{{ $i + 1 }}</td>
                <td class="col-name"><div class="text-truncate-200" title="{{ $item->nama_pengaduan }}">{{ $item->nama_pengaduan }}</div></td>
                <td><div class="text-truncate-200" title="{{ $item->lokasi }}">{{ $item->lokasi }}</div></td>
                <td>
                  @if($item->foto)
                    <img src="{{ asset('storage/' . $item->foto) }}" class="photo-thumbnail" data-photo="{{ asset('storage/' . $item->foto) }}" alt="Foto">
                  @else
                    <span class="text-muted">Tidak ada</span>
                  @endif
                </td>
                <td><span class="badge {{ $badge }}">{{ $item->status }}</span></td>
                <td>{{ \Carbon\Carbon::parse($item->tgl_pengajuan)->format('d-m-Y') }}</td>
                <td>{!! $item->tgl_selesai ? \Carbon\Carbon::parse($item->tgl_selesai)->format('d-m-Y') : '<span class="text-muted">-</span>' !!}</td>
                <td>
                 <div class="d-flex flex-wrap gap-2 actions">
  <button class="btn btn-info btn-sm btn-detail" data-item='@json($item)'><i class="fas fa-eye"></i></button>
  <button type="button" class="btn btn-secondary btn-sm btn-print" data-item='@json($item)' onclick="printFromData(this)"><i class="fa fa-print"></i></button>

  <!-- ✅ Tombol Setujui - HANYA untuk status Diajukan -->
  @if($item->status === 'Diajukan')
    <form method="POST" action="{{ route('admin.pengaduan.updateStatus', $item->id_pengaduan) }}" onsubmit="return confirm('Setujui pengaduan ini?');">
      @csrf
      @method('PUT')
      <input type="hidden" name="status" value="Disetujui">
      <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-check"></i></button>
    </form>
  @endif

  <!-- ❌ Tombol Tolak dengan Saran - hanya untuk status Diajukan -->
  @if($item->status === 'Diajukan')
    <form method="POST" action="{{ route('admin.pengaduan.tolakWithSaran', $item->id_pengaduan) }}" class="d-inline">
      @csrf
      @method('PUT')
      <input type="hidden" name="status" value="Ditolak">
      <button type="button" class="btn btn-danger btn-sm"
              onclick="if(confirm('Tolak pengaduan ini?')) {
                var saran = prompt('Berikan alasan penolakan / saran untuk perbaikan:');
                if(saran !== null) {
                  this.form.querySelector('input[name=\'saran_petugas\']').value = saran;
                  this.form.submit();
                }
              }">
        <i class="fa fa-times"></i>
      </button>
      <input type="hidden" name="saran_petugas" value="">
    </form>
  @endif

  <!-- Form delete -->
  <form method="POST" action="{{ route('admin.pengaduan.destroy', $item->id_pengaduan) }}" onsubmit="return confirm('Yakin ingin menghapus pengaduan ini?');" class="d-inline">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-outline-danger btn-sm"><i class="fa fa-trash"></i></button>
  </form>
</div>

                </td>
              </tr>
            @empty
              <tr>
                <td colspan="8" class="text-center text-muted">Belum ada data pengaduan.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- MODAL FOTO -->
  <div class="modal fade" id="photoModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Foto Pengaduan</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body text-center">
          <img src="" class="modal-photo rounded img-fluid" alt="Foto Pengaduan">
        </div>
      </div>
    </div>
  </div>

  <!-- MODAL DETAIL -->
  <div class="modal fade" id="detailModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Detail Pengaduan</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body"></div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
document.querySelectorAll('.btn-detail').forEach(btn => {
  btn.addEventListener('click', function() {
    const item = JSON.parse(this.dataset.item);
    const namaUser = item.user ? item.user.name : '-';
    const namaPetugas = item.petugas ? item.petugas.nama : '-';
    const namaItem = item.item ? item.item.nama_item : '-';
    const modalBody = document.querySelector('#detailModal .modal-body');
    modalBody.innerHTML = `
      <div class="row">
        <div class="col-md-6">
          <h6>Informasi Pengaduan</h6>
          <table class="table table-sm">
            <tr><td><strong>Nama Pengaduan</strong></td><td>${item.nama_pengaduan}</td></tr>
            <tr><td><strong>Lokasi</strong></td><td>${item.lokasi}</td></tr>
            <tr><td><strong>Status</strong></td><td><span class="badge ${getBadge(item.status)}">${item.status}</span></td></tr>
            <tr><td><strong>Tgl Pengajuan</strong></td><td>${formatDate(item.tgl_pengajuan)}</td></tr>
            <tr><td><strong>Tgl Selesai</strong></td><td>${item.tgl_selesai ? formatDate(item.tgl_selesai) : '-'}</td></tr>
          </table>
        </div>
        <div class="col-md-6">
          <h6>Data Terkait</h6>
          <table class="table table-sm">
            <tr><td><strong>Nama User</strong></td><td>${namaUser}</td></tr>
            <tr><td><strong>Nama Petugas</strong></td><td>${namaPetugas}</td></tr>
            <tr><td><strong>Nama Item</strong></td><td>${namaItem}</td></tr>
          </table>
        </div>
      </div>
      <div class="mt-3"><h6>Deskripsi</h6><p>${item.deskripsi || '-'}</p></div>
      ${item.saran_petugas ? `<div class="mt-3"><h6>Saran Petugas</h6><p class="text-muted">${item.saran_petugas}</p></div>` : ''}
  ${item.foto ? `<div class="mt-3 text-center"><img src="/storage/${item.foto}" class="img-fluid rounded shadow-sm" style="cursor:pointer;" onclick="showPhoto('/storage/${item.foto}')" alt="Foto Pengaduan"></div>` : ''}
    `;
    new bootstrap.Modal(document.getElementById('detailModal')).show();
  });
});

const getBadge = status => ({
  'Diajukan': 'bg-primary',
  'Disetujui': 'bg-success',
  'Ditolak': 'bg-danger',
  'Diproses': 'bg-warning'
}[status] || 'bg-secondary');

const formatDate = d => new Date(d).toLocaleDateString('id-ID', {
  day: '2-digit', month: '2-digit', year: 'numeric'
});

// Fungsi untuk menampilkan foto di modal foto (reused)
function showPhoto(src) {
  const img = document.querySelector('#photoModal .modal-photo');
  if (img) img.src = src;
  new bootstrap.Modal(document.getElementById('photoModal')).show();
}

// Fungsi cetak client-side berdasarkan data-item JSON
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

          ${item.saran_petugas ? `<div class="section"><h4>Saran Petugas</h4><div>${item.saran_petugas}</div></div>` : ''}

          ${fotoSrc ? `<div class="foto"><img src="${fotoSrc}" alt="Foto Pengaduan"></div>` : ''}

        </body>
      </html>
    `;

    const w = window.open('', '_blank');
    w.document.open();
    w.document.write(html);
    w.document.close();
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