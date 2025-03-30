<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.ㅡ
     */
    public function up(): void
    {
        Schema::create('blog_user', function (Blueprint $table) {
            $table->foreignIdFor(\App\Models\User::class) // User 테이블의 외래키 설정
            ->constrained() // 자동으로 users.id 참조하도록 설정
            ->cascadeOnDelete(); // User가 삭제되면 자동 삭제
            $table->foreignIdFor(\App\Models\Blog::class) // Blog 테이블의 외래키 설정
            ->constrained() // 자동으로 blogs.id 참조하도록 설정
            ->cascadeOnDelete(); // Blog가 삭제되면 자동 삭제
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_user');
    }
};
