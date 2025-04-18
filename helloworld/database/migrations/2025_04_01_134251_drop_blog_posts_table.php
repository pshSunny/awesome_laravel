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
        Schema::dropIfExists('blog_posts'); // 테이블 삭제
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('blog_posts', function (Blueprint $table) {
            $table->id();
            $table->text('title');
            $table->text('body');
            $table->text('user_id');
            $table->timestamps();
        });
    }
};
