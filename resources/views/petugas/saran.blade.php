@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Berikan Saran untuk Pengaduan: {{ $pengaduan->nama_pengaduan }}</h4>

    <form action="{{ route('petugas.simpanSaran', $pengaduan->id) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="saran_petugas" class="form-label">Saran Petugas</label>
            <textarea name="saran_petugas" id="saran_petugas" class="form-control" rows="4" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Simpan Saran</button>
    </form>
</div>
@endsection
