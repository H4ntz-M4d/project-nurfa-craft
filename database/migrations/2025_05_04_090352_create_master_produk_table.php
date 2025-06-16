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
        Schema::create('produk_master', function (Blueprint $table) {
            $table->id('id_master_produk');
            $table->foreignId('id_ktg_produk')->references('id_ktg_produk')->on('kategori_produk')->onDelete('cascade');
            $table->string('nama_produk')->nullable();
            $table->text('deskripsi')->nullable();
            $table->enum('status',['published','unpublished'])->nullable();
            $table->enum('use_variant',['yes','no'])->default('no');
            $table->string('meta_keywords')->nullable();
            $table->text('meta_desc')->nullable();
            $table->string('gambar')->nullable();
            $table->string('slug')->unique();
            $table->timestamps();
        });

        Schema::create('detail_produk_master', function (Blueprint $table) {
            $table->id('id_detail_produk');
            $table->foreignId('id_master_produk')->references('id_master_produk')->on('produk_master')->onDelete('cascade');
            $table->string('sku')->nullable();
            $table->double('harga')->nullable();
            $table->string('stok')->nullable();
            $table->string('slug')->unique();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_produk');
    }
};
