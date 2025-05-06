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
            $table->unsignedBigInteger('id_ktg_produk')->nullable();
            $table->string('nama_produk')->nullable();
            $table->text('deskripsi')->nullable();
            $table->enum('status',['published','unpublished'])->nullable();
            $table->string('meta_keywords')->nullable();
            $table->string('meta_desc')->nullable();
            $table->string('gambar')->nullable();
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
