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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id('id_transaction');
            $table->string('order_id')->nullable()->unique();
            $table->string('snap_token')->nullable();
            $table->foreignId('id_user')->nullable(); 
            $table->foreign('id_user')->references('id')->on('users')->nullOnDelete(); 
            $table->dateTime('tanggal')->useCurrent();
            $table->decimal('total', 12, 2);
            $table->enum('status',['unpaid','pending','paid'])->default('unpaid');

            // Alamat pengiriman snapshot
            $table->string('provinsi')->nullable();
            $table->string('kota')->nullable();
            $table->string('alamat_pengiriman')->nullable();
            $table->string('telepon')->nullable();
            $table->string('slug')->nullable()->unique();

            $table->timestamps();
        });

        Schema::create('transaction_details', function (Blueprint $table) {
            $table->id('id_transaction_detail');

            $table->foreignId('id_transaction')->nullable();
            $table->foreign('id_transaction')->references('id_transaction')->on('transactions')->nullOnDelete();

            $table->foreignId('id_master_produk')->nullable();
            $table->foreign('id_master_produk')->references('id_master_produk')->on('produk_master')->nullOnDelete();

            $table->string('nama_produk');
            $table->integer('jumlah');
            $table->decimal('harga', 12, 2);
            $table->timestamps();
        });


        Schema::create('transaction_detail_variants', function (Blueprint $table) {
            $table->id();

            $table->foreignId('id_transaction_detail')->nullable();
            $table->foreign('id_transaction_detail')->references('id_transaction_detail')->on('transaction_details')->nullOnDelete();

            $table->string('nama_atribut');
            $table->string('nilai_variant');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction');
    }
};
