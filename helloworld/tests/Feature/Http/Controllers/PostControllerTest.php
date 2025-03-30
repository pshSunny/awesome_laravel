<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Blog;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    use RefreshDatabase; // 테스트 케이스가 한 번 실행되면 데이터베이스 초기화
    use WithFaker; // 모델 팩토리에서 Faker($this->faker) 사용 허용

    /**
     * 블로그 글 리스트 뷰 반환 검증
     */
    public function testReturnsIndexViewForListOfPost(): void
    {
        $blog = Blog::factory()->create();

        $this->actingAs($blog->user) // 로그인 된 것으로 간주
            ->get(route('blogs.posts.index', $blog))
            ->assertOk()
            ->assertViewIs('blogs.posts.index');
    }

    /**
     * 블로그 글 생성 폼 뷰 반환 검증
     */
    public function testReturnsCreateViewForPost(): void
    {
        $blog = Blog::factory()->create();

        $this->actingAs($blog->user) // 로그인 된 것으로 간주
            ->get(route('blogs.posts.create', $blog))
            ->assertOk()
            ->assertViewIs('blogs.posts.create');
    }

    /**
     * 블로그 글 생성 검증
     */
    public function testCreatePostForBlog()
    {
        $blog = Blog::factory()->hasSubscribers()->create();

        $data = [
            'title' => $this->faker->text(50),
            'content' => $this->faker->text
        ];

        $this->actingAs($blog->user) // 로그인 된 것으로 간주
            ->post(route('blogs.posts.store', $blog), $data)
            ->assertRedirect();

        $this->assertCount(1, $blog->posts);
        $this->assertDatabaseHas('posts', $data);
    }

    /**
     * 블로그 글 상세페이지 뷰 반환 검증
     */
    public function testReturnsShowViewForPost(): void
    {
        $post = Post::factory()->create();

        $this->actingAs($post->blog->user) // 로그인 된 것으로 간주
            ->get(route('posts.show', $post))
            ->assertOk()
            ->assertViewIs('blogs.posts.show');
    }

    /**
     * 블로그 글 관리 뷰 반환 검증
     */
    public function testReturnsEditViewForPost(): void
    {
        $post = Post::factory()->create();

        $this->actingAs($post->blog->user) // 로그인 된 것으로 간주
            ->get(route('posts.edit', $post))
            ->assertOk()
            ->assertViewIs('blogs.posts.edit');
    }

    /**
     * 블로그 글 수정 검증
     */
    public function testUpdatePost()
    {
        $post = Post::factory()->create();

        $data = [
            'title' => $this->faker->text(50),
            'content' => $this->faker->text
        ];

        $this->actingAs($post->blog->user) // 로그인 된 것으로 간주
            ->put(route('posts.update', $post), $data)
            ->assertRedirect();

        $this->assertDatabaseHas('posts', $data);
    }

    /**
     * 블로그 글 삭제 검증
     */
    public function testDeletePost()
    {
        $post = Post::factory()->create();

        $this->actingAs($post->blog->user) // 로그인 된 것으로 간주
            ->delete(route('posts.destroy', $post))
            ->assertRedirect();

        $this->assertDatabaseMissing('posts', [
            'id' => $post->id,
        ]);
    }
}
