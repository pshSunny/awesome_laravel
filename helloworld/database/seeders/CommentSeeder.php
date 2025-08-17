<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Post::all()->each(function (Post $post) {
            $factory = Comment::factory()
                ->for($post, 'commentable') // 코멘트 댓글이 어떤 게시물에 속하는지 정보를 저장
                ->state(function (array $attributes) {
                    return [
                        'user_id' => User::pluck('id')->random(), // 코멘트 댓글의 작성자 정보를 설정
                    ];
                }) // 모델 팩토리 호출될 때마다 지정될 상태 지정
                ;
            $factory->has($factory->count(2), 'replies')->create(); // 자식 댓글 2개 있는 댓글 생성
            $factory->create(); // 자식 댓글 없는댓글 생성
        });
    }
}
