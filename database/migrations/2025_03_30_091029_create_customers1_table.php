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
        Schema::create('customers', function (Blueprint $table) {
            $table->id('id_karyawan');
            $table->unsignedBigInteger('id_user')->nullable();
            $table->string('nama')->nullable();
            $table->string('email')->nullable()->unique();
            $table->string('no_telp')->nullable();
            $table->text('alamat')->nullable();
            $table->timestamps();

            $table->foreign('id_user')->references('id')->on( 'users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
