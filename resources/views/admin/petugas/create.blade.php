<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Tambah Petugas | Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
  <div class="d-flex justify-content-between mb-4">
    <h3>Tambah Petugas</h3>
    <a href="{{ route('admin.petugas.index') }}" class="btn btn-secondary">← Kembali</a>
  </div>

  @if ($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach ($errors->all() as $err)
          <li>{{ $err }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <div class="card p-4 shadow-sm">
    <form action="{{ route('admin.petugas.store') }}" method="POST">
      @csrf

      {{-- NAMA --}}
      <div class="mb-3">
        <label for="name" class="form-label fw-semibold">Nama</label>
        <input id="name" name="name" type="text" 
               class="form-control @error('name') is-invalid @enderror"
               value="{{ old('name') }}" placeholder="Masukkan nama anda" required>
        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>

      {{-- EMAIL --}}
      <div class="mb-3">
        <label for="email" class="form-label fw-semibold">Email</label>
        <input id="email" name="email" type="email" 
               class="form-control @error('email') is-invalid @enderror"
               value="{{ old('email') }}" placeholder="contoh@email.com" required>
        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>

      {{-- PASSWORD --}}
      <div class="mb-3">
        <label for="password" class="form-label fw-semibold">Password</label>
        <input id="password" name="password" type="password"
               class="form-control @error('password') is-invalid @enderror" 
               placeholder="Minimal 8 karakter" required>
        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>

      {{-- ROLE --}}
      <div class="mb-3">
        <label for="role" class="form-label fw-semibold">Role</label>
        <select id="role" name="role" class="form-select @error('role') is-invalid @enderror" required>
          <option value="petugas" {{ old('role')=='petugas' ? 'selected' : '' }}>Petugas</option>
        </select>
        @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>

      {{-- TELEPON --}}
      <div class="mb-3">
        <label for="telp" class="form-label fw-semibold">No. Telepon</label>
        <input id="telp" name="telp" type="text" 
               class="form-control @error('telp') is-invalid @enderror"
               value="{{ old('telp') }}" placeholder="08xxxxxxxxxx" required>
        @error('telp') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>

      {{-- JENIS KELAMIN --}}
      <div class="mb-4">
        <label for="gender" class="form-label fw-semibold">Jenis Kelamin</label>
        <select id="gender" name="gender" class="form-select @error('gender') is-invalid @enderror" required>
          <option value="">-- Pilih --</option>
          <option value="L">Laki-laki</option>
          <option value="P">Perempuan</option>
        </select>
        @error('gender') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>

      <button class="btn btn-success px-4 py-2 fw-semibold">Simpan Petugas</button>
    </form>
  </div>
</div>
</body>
</html>
