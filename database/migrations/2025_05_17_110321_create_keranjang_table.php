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
        Schema::create('keranjang', function (Blueprint $table) {
            $table->id('id_keranjang');
            $table->foreignId('id_user')->constrained('users','id')->onDelete('cascade');
            $table->foreignId('id_master_produk')->constrained('produk_master', 'id_master_produk')
            ->onDelete('cascade');
            $table->integer('jumlah');
            $table->decimal('total_harga');
            $table->string('slug')->unique();
            $table->timestamps();
        });

        // Migration: cart_variants
        Schema::create('keranjang_variant', function (Blueprint $table) {
            $table->id('id_keranjang_variant');
            $table->foreignId('id_keranjang')->constrained('keranjang', 'id_keranjang')->onDelete('cascade');
            $table->foreignId('id_product_variant_value')->constrained('produk_variant_values', 'id_product_variant_value')
            ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keranjang');
    }
};
