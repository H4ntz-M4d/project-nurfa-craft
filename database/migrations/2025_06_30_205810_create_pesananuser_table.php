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
        Schema::create('pesanan', function (Blueprint $table) {
            $table->id('id_pesanan');
            $table->foreignId('id_transaction')->constrained('transactions', 'id_transaction')->onDelete('cascade');
            $table->enum('status', ['proses', 'dikirim', 'selesai'])->default('proses');
            $table->string('jasa_pengiriman')->nullable();
            $table->string('no_resi')->nullable();
            $table->double('harga_pengiriman')->nullable();
            $table->text('keterangan')->nullable();
            $table->string('slug')->nullable()->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanan');
    }
};
