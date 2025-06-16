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
        Schema::create('produk_variant', function (Blueprint $table) {
            $table->id('id_var_produk');
            $table->foreignId('id_master_produk')->references('id_master_produk')->on('produk_master')->onDelete('cascade');
            $table->string('sku')->nullable();
            $table->double('harga')->nullable();
            $table->string('stok')->nullable();
            $table->string('slug')->unique();
            $table->timestamps();
        });
        
        Schema::create('variant_attributes', function (Blueprint $table) {
            $table->id('id_variant_attributes');
            $table->string('nama_variant');  // Color, Size, etc.
            $table->string('slug')->unique();
            $table->timestamps();
        });
        
        Schema::create('variant_values', function (Blueprint $table) {
            $table->id('id_variant_value');
            $table->foreignId('id_variant_attributes')->references('id_variant_attributes')
                ->on('variant_attributes')
                ->onDelete('cascade');
            $table->string('value');
            $table->timestamps();
        });
        
        Schema::create('produk_variant_values', function (Blueprint $table) {
            $table->id('id_product_variant_value');
            $table->foreignId('id_var_produk')->references('id_var_produk')->on('produk_variant')->onDelete('cascade');
            $table->foreignId('id_variant_attributes')->references('id_variant_attributes')->on('variant_attributes')->onDelete('cascade');
            $table->foreignId('id_variant_value')->references('id_variant_value')->on('variant_values')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk_varian');
    }
};
