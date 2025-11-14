<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('temporary_item', function (Blueprint $table) {
            $table->unsignedBigInteger('id_lokasi')->nullable()->after('lokasi_barang_baru');
            $table->string('judul_pengaduan', 255)->nullable()->after('id_lokasi');
            $table->text('deskripsi_pengaduan')->nullable()->after('judul_pengaduan');
            $table->string('foto_pengaduan', 255)->nullable()->after('deskripsi_pengaduan');
            $table->text('deskripsi_barang_baru')->nullable()->after('foto_pengaduan');

            $table->foreign('id_lokasi')->references('id_lokasi')->on('lokasi')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('temporary_item', function (Blueprint $table) {
            $table->dropForeign(['id_lokasi']);
            $table->dropColumn([
                'id_lokasi',
                'judul_pengaduan',
                'deskripsi_pengaduan',
                'foto_pengaduan',
                'deskripsi_barang_baru',
            ]);
        });
    }
};

