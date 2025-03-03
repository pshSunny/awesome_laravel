<?php

namespace Tests\Feature;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BlogControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * 블로그 리스트 뷰 반환 검증
     * GET|HEAD blogs ... blogs.index › BlogController@index
     */
    public function testReturnsIndexViewForListOfBlog(): void
    {
        $user = User::factory()->create(); // User 생성

        $this->actingAs($user) // 로그인 된 것으로 간주
            ->get(route('blogs.index'))
            ->assertViewIs('blogs.index');
    }

    /**
     * 블로그 생성 폼 뷰 반환 검증
     * GET|HEAD blogs/create ... blogs.create › BlogController@create
     */
    public function testReturnsCreateViewForBlog(): void
    {
        $user = User::factory()->create(); // User 생성

        $this->actingAs($user) // 로그인 된 것으로 간주
            ->get(route('blogs.create'))
            ->assertViewIs('blogs.create');
    }

    /**
     * 블로그 생성 검증
     * POST blogs ... blogs.store › BlogController@store
     */
    public function testCreateBlog()
    {
        $user = User::factory()->create();

        $data = [
            'name' => $this->faker->userName,
            'display_name' => $this->faker->unique()->words(3, true)
        ];

        $this->actingAs($user) // 로그인 된 것으로 간주
            ->post(route('blogs.store'), $data)
            ->assertRedirect();

        $this->assertDatabaseHas('blogs', $data);
    }

    /**
     * 블로그 상세페이지 뷰 반환 검증
     * GET|HEAD blogs/{blog} ... blogs.show › BlogController@show
     */
    public function testReturnsShowViewForBlog(): void
    {
        $user = User::factory()->create();
        $blog = Blog::factory()->create();

        $this->actingAs($user) // 로그인 된 것으로 간주
            ->get(route('blogs.show', $blog))
            ->assertOk()
            ->assertViewIs('blogs.show');
    }

    /**
     * 블로그 관리 뷰 반환 검증
     * GET|HEAD blogs/{blog}/edit ... blogs.edit › BlogController@edit
     */
    public function testReturnsEditviewForBlog(): void
    {
        $blog = Blog::factory()->create();

        $this->actingAs($blog->user) // 로그인 된 것으로 간주
            ->get(route('blogs.edit', $blog))
            ->assertOk()
            ->assertViewIs('blogs.edit');
    }

    /**
     * 블로그 수정 검증
     * PUT|PATCH blogs/{blog} ... blogs.update › BlogController@update
     */
    public function testUpdateBlog(): void
    {
        $blog = Blog::factory()->create();

        $data = [
            'name' => $this->faker->userName,
            'display_name' => $this->faker->words(3, true)
        ];

        $this->actingAs($blog->user) // 로그인 된 것으로 간주
            ->put(route('blogs.update', $blog), $data)
            ->assertRedirect();

        $this->assertDatabaseHas('blogs', $data);
    }

    /**
     * 블로그 삭제 검증
     * DELETE blogs/{blog} ... blogs.destroy › BlogController@destroy
     */
    public function testDeleteBlog(): void
    {
        $blog = Blog::factory()->create();

        $this->actingAs($blog->user) // 로그인 된 것으로 간주
            ->delete(route('blogs.destroy', $blog))
            ->assertRedirect();

        $this->assertDatabaseMissing('blogs', [
            'name' => $blog->name
        ]);
    }
}
