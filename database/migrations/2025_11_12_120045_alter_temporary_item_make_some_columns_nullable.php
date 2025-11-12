<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('temporary_item', function (Blueprint $table) {
            $table->unsignedBigInteger('id_item')->nullable()->change();
            $table->string('nama_barang_baru', 50)->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('temporary_item', function (Blueprint $table) {
            $table->unsignedBigInteger('id_item')->nullable(false)->change();
            $table->string('nama_barang_baru', 50)->nullable(false)->change();
        });
    }
};