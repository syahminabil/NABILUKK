<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::table('pengaduan', function (Blueprint $table) {
        // Hapus baris saran_petugas
        // $table->text('saran_petugas')->nullable()->after('status');
        
        $table->string('foto_saran')->nullable()->after('saran_petugas');
    });
}

public function down()
{
    Schema::table('pengaduan', function (Blueprint $table) {
        $table->dropColumn(['foto_saran']);
    });
}

};
