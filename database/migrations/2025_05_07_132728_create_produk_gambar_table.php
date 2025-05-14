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
        Schema::create('produk_gambar', function (Blueprint $table) {
            $table->id('id_produk_gambar');
            $table->foreignId('id_master_produk')->constrained('produk_master', 'id_master_produk')->onDelete('cascade');
            $table->string('gambar')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk_gambar');
    }
};
