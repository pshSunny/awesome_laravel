<?php

namespace Tests\Feature\Http\Controllers\Dashboard;

use App\Http\Middleware\RequirePassword;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BlogControllerTest extends TestCase
{
    use RefreshDatabase; // 테스트 케이스가 한 번 실행되면 데이터베이스 초기화

    /**
     * 블로그 대시보드 뷰 반환 검증
     * GET|HEAD dashboard/blogs ... dashboard.blogs › Dashboard\BlogController
     */
    public function testReturnsBlogsDashboardViewForListOfBlog(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->withoutMiddleware(RequirePassword::class)
            ->get(route('dashboard.blogs'))
            ->assertOk()
            ->assertViewIs('dashboard.blogs');
    }
}
