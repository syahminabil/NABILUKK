@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Detail Pengaduan</h5>
        </div>
        <div class="card-body">
            <h5>{{ $pengaduan->nama_pengaduan }}</h5>
            <p class="text-muted mb-2">Diajukan pada: {{ \Carbon\Carbon::parse($pengaduan->tgl_pengajuan)->format('d M Y H:i') }}</p>
            <hr>

            <p><strong>Isi Laporan:</strong></p>
            <p>{{ $pengaduan->isi_laporan }}</p>

            @if ($pengaduan->foto)
                <div class="mt-3">
                    <strong>Foto Bukti:</strong><br>
                    <img src="{{ asset('storage/' . $pengaduan->foto) }}" class="img-fluid rounded mt-2" style="max-width: 400px;">
                </div>
            @endif

            <div class="mt-3">
                <strong>Status:</strong>
                @if ($pengaduan->status == 'Diajukan')
                    <span class="badge bg-warning text-dark">{{ $pengaduan->status }}</span>
                @elseif ($pengaduan->status == 'Diproses')
                    <span class="badge bg-info text-dark">{{ $pengaduan->status }}</span>
                @elseif ($pengaduan->status == 'Selesai')
                    <span class="badge bg-success">{{ $pengaduan->status }}</span>
                @else
                    <span class="badge bg-secondary">{{ $pengaduan->status }}</span>
                @endif
            </div>
        </div>
        <div class="card-footer text-end">
            <a href="{{ url('/user/dashboard') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>
@endsection
