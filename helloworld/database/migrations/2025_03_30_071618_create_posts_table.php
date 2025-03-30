<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Blog::class) // Blog 테이블의 외래키 설정
            ->constrained() // 자동으로 blogs.id 참조하도록 설정
            ->cascadeOnDelete(); // Blog가 삭제되면 자동 삭제
            $table->string('title'); // 제목
            $table->text('content'); // 내용
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
