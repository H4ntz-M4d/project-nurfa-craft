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
        Schema::create('logs_view_product', function (Blueprint $table) {
            $table->id('id_view_product');
            $table->foreignId('id_user')->constrained('users','id')->onDelete('cascade');
            $table->foreignId('id_master_produk')->constrained('produk_master','id_master_produk')->onDelete('cascade');
            $table->unique(['id_user','id_master_produk']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logs_view_product');
    }
};
