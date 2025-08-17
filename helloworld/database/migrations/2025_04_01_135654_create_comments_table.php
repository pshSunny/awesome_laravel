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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\User::class) // User 테이블의 외래키 설정
                ->constrained() // 자동으로 users.id 참조하도록 설정
                ->cascadeOnDelete(); // User가 삭제되면 자동 삭제
            $table->foreignIdFor(\App\Models\Comment::class, 'parent_id') // 부모 댓글의 외래키 설정
                ->nullable() // 부모 댓글이 없는 경우 null 처리
                ->constrained('comments') // 자동으로 comments.id 참조하도록 설정
                ->cascadeOnDelete(); // 부모 댓글이 삭제되면 자동 삭제
            $table->morphs('commentable'); // 코멘트 댓글이 어떤 게시물에 속하는지 정보를 저장
            $table->text('content'); // 내용
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
