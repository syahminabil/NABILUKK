<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Edit Ruang - Petugas</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<style>
  :root { --indigo:#4338ca; --blue:#2563eb; --gray:#f8fafc; --white:#ffffff; --text-dark:#1e293b; }
  body { background-color: var(--gray); font-family:'Segoe UI', sans-serif; color: var(--text-dark); }
  .container-custom { max-width: 700px; margin: 60px auto; background: var(--white); border-radius: 20px; padding: 30px 40px; box-shadow: 0 6px 20px rgba(0,0,0,0.08); border-top: 6px solid var(--blue); }
  h3 { font-weight: 700; color: var(--indigo); }
  .form-control { border-radius: 10px; }
  .form-control:focus { border-color: var(--blue); box-shadow: 0 0 0 0.2rem rgba(37,99,235,.25); }
  .btn-success, .btn-secondary { border: none; border-radius: 10px; }
  .btn-success { background: linear-gradient(to right, var(--indigo), var(--blue)); font-weight: 600; }
  .btn-success:hover { opacity: 0.9; transform: translateY(-2px); }
</style>
</head>
<body>
<div class="container-custom">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h3 class="mb-0"><i class="fa fa-edit"></i> Edit Ruang</h3>
      <a href="{{ route('petugas.dashboard') }}" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Kembali ke Dashboard</a>
    </div>

    <form action="{{ route('petugas.lokasi.crud.update', $lokasi->id_lokasi) }}" method="POST" class="mt-3">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nama_lokasi" class="form-label">Nama Ruang</label>
            <input type="text" id="nama_lokasi" name="nama_lokasi" 
                   value="{{ old('nama_lokasi', $lokasi->nama_lokasi) }}" 
                   class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">
            <i class="fa fa-save"></i> Update
        </button>
        
    </form>
</div>
</body>
</html>