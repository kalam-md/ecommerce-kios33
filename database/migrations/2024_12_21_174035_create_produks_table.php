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
        Schema::create('produks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kategori_id');
            $table->foreign('kategori_id')->references('id')->on('kategoris')->onDelete('cascade');
            $table->string('nama_produk');
            $table->string('slug')->unique();
            $table->string('sku')->unique()->nullable();
            $table->text('deskripsi');
            $table->decimal('harga', 15, 2);
            $table->integer('stok');
            $table->enum('satuan', ['pcs', 'kg', 'lusin']);
            $table->string('gambar')->nullable();
            $table->integer('berat')->nullable(); // dalam gram
            $table->string('dimensi')->nullable(); // format: PxLxT dalam cm
            $table->text('spesifikasi')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produks');
    }
};
