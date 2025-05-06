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
        Schema::create('kategori_produk', function (Blueprint $table) {
            $table->id('id_ktg_produk');
            $table->string('nama_kategori',100)->nullable();
            $table->string('deskripsi')->nullable();
            $table->enum('status',['published','unpublished'])->nullable();
            $table->string('meta_keywords')->nullable();
            $table->string('meta_desc')->nullable();
            $table->string('gambar')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kategori_produk');
    }
};
