<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('temporary_item', function (Blueprint $table) {
            $table->string('foto', 255)->nullable()->after('lokasi_barang_baru');
            $table->unsignedBigInteger('id_pengaduan')->nullable()->after('foto');
            $table->unsignedBigInteger('id_user')->nullable()->after('id_pengaduan');
            $table->enum('status', ['pending','approved','rejected'])->default('pending')->after('id_user');

            $table->foreign('id_pengaduan')->references('id_pengaduan')->on('pengaduan')->onDelete('set null');
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('temporary_item', function (Blueprint $table) {
            $table->dropForeign(['id_pengaduan']);
            $table->dropForeign(['id_user']);
            $table->dropColumn(['foto', 'id_pengaduan', 'id_user', 'status']);
        });
    }
};