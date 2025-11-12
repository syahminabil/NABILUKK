<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pengaduan', function (Blueprint $table) {
            $table->id('id_pengaduan');
            $table->string('nama_pengaduan', 200);
            $table->text('deskripsi')->nullable();
            $table->string('lokasi', 200)->nullable();
            $table->string('foto', 200)->nullable();
            $table->enum('status', ['Diajukan','Disetujui','Ditolak','Diproses','Selesai'])->default('Diajukan');

            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_petugas');
            $table->unsignedBigInteger('id_item');

            $table->date('tgl_pengajuan');
            $table->date('tgl_selesai')->nullable();
            $table->text('saran_petugas')->nullable();
            $table->timestamps();

            // foreign keys
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_petugas')->references('id_petugas')->on('petugas')->onDelete('cascade');
            $table->foreign('id_item')->references('id_item')->on('items')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengaduan');
    }
};
