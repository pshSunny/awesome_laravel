<?php

namespace Tests\Feature\Http\Controllers\Blog;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SubscribeControllerTest extends TestCase
{
    use RefreshDatabase; // 테스트 케이스가 한 번 실행되면 데이터베이스 초기화

    /**
     * 구독자 지정 테스트
     */
    public function testUserSubscribeBlog(): void
    {
        $user = User::factory()->create();
        $blog = Blog::factory()->create();

        $this->actingAs($user) // 로그인 된 것으로 간주
            ->post(route('subscribe'), [
                'blog_id' => $blog->id
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('blog_user', [
            'user_id' => $user->id,
            'blog_id' => $blog->id
        ]); // 데이터베이스 검증
    }

    /**
     * 구독 취소
     */
    public function testUserUnsubscribeBlog(): void
    {
        $user = User::factory()->create();

        $blog = Blog::factory()->hasAttached(
            factory: $user,
            relationship: 'subscribers'
        )->create();

        $this->actingAs($user) // 로그인 된 것으로 간주
            ->post(route('unsubscribe'), [
                'blog_id' => $blog->id
            ])
            ->assertRedirect();

        $this->assertDatabaseMissing('blog_user', [
            'user_id' => $user->id,
            'blog_id' => $blog->id
        ]); // 데이터베이스 검증
    }
}
