<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penolakan', function (Blueprint $table) {
            $table->id('id_penolakan');
            $table->unsignedBigInteger('id_pengaduan');
            $table->unsignedBigInteger('id_petugas')->nullable();
            $table->text('alasan')->nullable(); // alasan penolakan
            $table->timestamps();

            // Relasi ke pengaduan & petugas
            $table->foreign('id_pengaduan')->references('id_pengaduan')->on('pengaduan')->onDelete('cascade');
            $table->foreign('id_petugas')->references('id_petugas')->on('petugas')->onDelete('set null');

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penolakan');
    }
};
