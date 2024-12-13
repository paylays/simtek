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
        Schema::create('medicine_devices', function (Blueprint $table) {
            $table->id();
            $table->string('kode_produk')->unique();
            $table->string('nama_alatkesehatan');
            $table->foreignId('kategori_id')->constrained('categories')->onDelete('cascade');
            $table->foreignId('satuan_id')->constrained('units')->onDelete('cascade');
            $table->integer('stok');
            $table->decimal('harga', 10);
            $table->text('keterangan');
            $table->foreignId('suplier_id')->constrained('suppliers')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicine_devices');
    }
};
