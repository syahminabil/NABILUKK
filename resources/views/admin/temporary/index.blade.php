<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN | Temporary Items</title>
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
            max-width: 1200px;
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

        .badge-pending { background: #f59e0b; color: #fff; }
        .badge-approved { background: #10b981; color: #fff; }
        .badge-rejected { background: #ef4444; color: #fff; }

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

        .photo-thumbnail {
            width: 60px;
            height: 60px;
            border-radius: 8px;
            object-fit: cover;
            border: 2px solid #e2e8f0;
            cursor: pointer;
            transition: transform 0.2s ease-in-out;
        }

        .photo-thumbnail:hover {
            transform: scale(1.05);
            border-color: var(--blue);
        }
        @media (max-width: 576px) {
            .container-custom { padding: 20px; }
            h3 { font-size: 1.25rem; }
            thead th, tbody td { font-size: 13px; }
            .photo-thumbnail { width: 50px; height: 50px; }
        }
    </style>
</head>
<body>

<div class="container-custom">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3><i class="fa fa-clock me-2"></i> Temporary Items</h3>
        <div>
            <a href="{{ route('dashboard') }}" class="btn btn-back btn-custom">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
    @endif

    <div class="table-responsive">
    <table class="table table-hover table-custom align-middle shadow-sm">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Lokasi</th>
                <th>Foto</th>
                <th>Status</th>
                <th>Dibuat Oleh</th>
                <th>Tanggal Dibuat</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @if(isset($temporaryItems) && $temporaryItems->count() > 0)
                @foreach($temporaryItems as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->nama_barang_baru ?? '-' }}</td>
                        <td>{{ $item->lokasi_barang_baru ?? '-' }}</td>
                        <td>
                            @if($item->foto)
                                <img src="{{ asset('storage/' . $item->foto) }}" 
                                     class="photo-thumbnail" 
                                     alt="Foto"
                                     onclick="showPhoto('{{ asset('storage/' . $item->foto) }}')">
                            @else
                                <span class="text-muted">Tidak ada</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge badge-{{ $item->status ?? 'pending' }}">
                                {{ ucfirst($item->status ?? 'pending') }}
                            </span>
                        </td>
                        <td>{{ $item->user->name ?? '-' }}</td>
                        <td>
                            @if(isset($item->created_at) && !is_null($item->created_at))
                                {{ $item->created_at->format('d M Y H:i') }}
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td class="actions">
                            @if($item->status === 'pending')
                                <form action="{{ route('admin.temporary.approve', $item->id_temporary) }}" 
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('Setujui dan pindahkan barang ini ke daftar items?')">
                                    @csrf
                                    @method('POST')
                                    <button type="submit" class="btn btn-success btn-sm" title="Approve">
                                        <i class="fa fa-check"></i> Approve
                                    </button>
                                </form>
                                
                                <button type="button" class="btn btn-danger btn-sm" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#rejectModal{{ $item->id_temporary }}"
                                        title="Reject">
                                    <i class="fa fa-times"></i> Tolak
                                </button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="8" class="text-center text-muted py-4">
                        <i class="fa fa-clock fa-2x mb-2"></i><br>
                        Belum ada temporary items.
                    </td>
                </tr>
            @endif
        </tbody>
    </table>
    </div>
</div>

<!-- Modal Foto -->
<div class="modal fade" id="photoModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Foto Barang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img src="" class="img-fluid rounded" alt="Foto Barang" id="modalPhoto">
            </div>
        </div>
    </div>
</div>

<!-- Modal Reject untuk setiap item -->
@if(isset($temporaryItems) && $temporaryItems->count() > 0)
    @foreach($temporaryItems as $item)
        @if($item->status === 'pending')
        <div class="modal fade" id="rejectModal{{ $item->id_temporary }}" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title"><i class="fa fa-times-circle me-2"></i>Tolak Barang Temporary</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('admin.temporary.reject', $item->id_temporary) }}" method="POST">
                        @csrf
                        @method('POST')
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label"><strong>Nama Barang:</strong></label>
                                <p class="text-muted">{{ $item->nama_barang_baru ?? '-' }}</p>
                            </div>
                            <div class="mb-3">
                                <label for="alasan{{ $item->id_temporary }}" class="form-label">
                                    <strong>Alasan Penolakan <span class="text-danger">*</span></strong>
                                </label>
                                <textarea class="form-control" 
                                          id="alasan{{ $item->id_temporary }}" 
                                          name="alasan" 
                                          rows="4" 
                                          placeholder="Masukkan alasan penolakan..." 
                                          required
                                          minlength="5"
                                          maxlength="500"></textarea>
                                <small class="form-text text-muted">Minimal 5 karakter, maksimal 500 karakter.</small>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-danger">
                                <i class="fa fa-times me-1"></i>Tolak dan Masukkan ke Penolakan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endif
    @endforeach
@endif

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function showPhoto(src) {
        document.getElementById('modalPhoto').src = src;
        new bootstrap.Modal(document.getElementById('photoModal')).show();
    }
</script>
</body>
</html>

