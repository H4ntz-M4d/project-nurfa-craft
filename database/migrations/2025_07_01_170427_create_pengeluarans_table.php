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
        Schema::create('pengeluaran', function (Blueprint $table) {
            $table->id('id_pengeluaran');
            $table->string('kategori_pengeluaran')->nullable();
            $table->string('nama_pengeluaran')->nullable();
            $table->decimal('jumlah_pengeluaran', 15, 2)->nullable(); // up to 999 triliun dengan 2 desimal
            $table->date('tanggal_pengeluaran')->nullable();
            $table->string('keterangan')->nullable();
            $table->string('slug')->unique();
            $table->foreignId('id_user')->constrained('users', 'id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengeluaran');
    }
};
