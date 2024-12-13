<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('medicines', function (Blueprint $table) {
            $table->string('kode_produk')->unique()->before('nama_obat'); // Menambahkan kolom kode_produk setelah id
        });
    }
    
    public function down(): void
    {
        Schema::table('medicines', function (Blueprint $table) {
            $table->dropColumn('kode_produk'); // Menghapus kolom kode_produk saat rollback
        });
    }
    
};
