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
        Schema::create('comment_post', function (Blueprint $table) {
            $table->id('id_comment');
            $table->foreignId('id_blog')->constrained('blog','id_blog')->onDelete('cascade');
            $table->foreignId('id_user')->constrained('users','id')->onDelete('cascade');
            $table->text('comment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comment_post');
    }
};
