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
        Schema::create('stok_record', function (Blueprint $table) {
            $table->id('id_stok_record');
            $table->foreignId('id_user')->constrained('users','id')->onDelete('cascade');

            $table->foreignId('id_master_produk')
                ->constrained('produk_master','id_master_produk')->onDelete('cascade');

            $table->foreignId('id_detail_produk')->nullable()
            ->constrained('detail_produk_master','id_detail_produk')->onDelete('cascade');

            $table->foreignId('id_var_produk')->nullable()
            ->constrained('produk_variant','id_var_produk')->onDelete('cascade');

            $table->integer('stok_awal')->default(0);
            $table->integer('stok_masuk')->default(0);
            $table->integer('stok_akhir')->default(0);
            $table->string('keterangan')->nullable();
            $table->string('slug')->unique();
            $table->timestamps();

            $table->index(['id_master_produk', 'id_var_produk', 'id_detail_produk'], 'idx_stok_produk_variant');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stok_record');
    }
};
