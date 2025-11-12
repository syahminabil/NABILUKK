<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>ADMIN | Edit Ruang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', sans-serif;
            color: #111;
        }
        .container-custom {
            max-width: 600px;
            margin: 60px auto;
            background: #fff;
            border-radius: 16px;
            padding: 30px 40px;
            box-shadow: 0 6px 18px rgba(0,0,0,0.08);
            border-top: 5px solid #dc3545;
        }
        h3 {
            font-weight: 700;
            color: #000;
            margin-bottom: 25px;
        }
        label {
            font-weight: 600;
            color: #111;
        }
        .form-control {
            border-radius: 8px;
            font-size: 14px;
            padding: 10px;
        }
        .form-control:focus {
            border-color: #dc3545;
            box-shadow: 0 0 0 0.2rem rgba(220,53,69,.25);
        }
        .btn-submit {
            background-color: #dc3545;
            border: none;
            color: #fff;
            border-radius: 8px;
            font-weight: 500;
            padding: 8px 16px;
            transition: 0.2s;
        }
        .btn-submit:hover {
            background-color: #b02a37;
        }
        .btn-back {
            background-color: #000;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-weight: 500;
            padding: 8px 16px;
            transition: 0.2s;
            text-decoration: none;
        }
        .btn-back:hover {
            background-color: #dc3545;
        }
        .alert-danger {
            border-left: 4px solid #dc3545;
            border-radius: 6px;
        }
        .alert-danger ul {
            margin: 0;
            padding-left: 20px;
        }
        .alert-danger li {
            font-size: 14px;
        }
    </style>
</head>
<body>

<div class="container-custom">
    <h3>✏️ Edit Ruang</h3>

    @if ($errors->any())
    <div class="alert alert-danger">
        <strong>Terjadi kesalahan:</strong>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('admin.lokasi.crud.update', $lokasi->id_lokasi) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nama_lokasi" class="form-label">Nama Ruang</label>
            <input 
                type="text" 
                name="nama_lokasi" 
                class="form-control" 
                id="nama_lokasi" 
                value="{{ $lokasi->nama_lokasi }}" 
                required>
        </div>

        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('admin.lokasi.crud.index') }}" class="btn-back">← Kembali</a>
            <button type="submit" class="btn-submit">💾 Update Ruang</button>
        </div>
    </form>
</div>

</body>
</html>
