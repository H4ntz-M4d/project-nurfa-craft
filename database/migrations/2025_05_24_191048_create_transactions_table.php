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
            $table->foreignId('id_user')->constrained('users','id')->onDelete('cascade');
            $table->dateTime('tanggal')->useCurrent();
            $table->decimal('total', 12, 2);
            $table->enum('status',['unpaid','pending','paid'])->default('unpaid');

            // Alamat pengiriman snapshot
            $table->string('provinsi')->nullable();
            $table->string('kota')->nullable();
            $table->string('alamat_pengiriman')->nullable();
            $table->string('telepon')->nullable();

            $table->timestamps();
        });

        Schema::create('transaction_details', function (Blueprint $table) {
            $table->id('id_transaction_detail');
            $table->foreignId('id_transaction')->constrained('transactions','id_transaction')->onDelete('cascade');
            $table->foreignId('id_master_produk')->constrained('produk_master','id_master_produk')->onDelete('cascade');
            $table->string('nama_produk');
            $table->integer('jumlah');
            $table->decimal('harga', 12, 2);
            $table->timestamps();
        });

        Schema::create('transaction_detail_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_transaction_detail')->constrained('transaction_details','id_transaction_detail')
                ->nullable()->onDelete('cascade');

            $table->foreignId('id_variant_attributes')->constrained('variant_attributes','id_variant_attributes')
                ->nullable()->onDelete('cascade');

            $table->foreignId('id_variant_value')->constrained('variant_values','id_variant_value')
                ->nullable()->onDelete('cascade');
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
