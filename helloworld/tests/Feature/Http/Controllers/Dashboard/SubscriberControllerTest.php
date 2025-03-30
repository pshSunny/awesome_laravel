<?php

namespace Tests\Feature\Http\Controllers\Dashboard;

use App\Http\Middleware\RequirePassword;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SubscriberControllerTest extends TestCase
{
    use RefreshDatabase; // 테스트 케이스가 한 번 실행되면 데이터베이스 초기화

    /**
     * 구독자 대시보드 뷰 반환 검증
     */
    public function testReturnsSubscribersDashboardViewForListOfSubscriber(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user) // 로그인 된 것으로 간주
            ->withoutMiddleware(RequirePassword::class)
            ->get(route('dashboard.subscribers'))
            ->assertOk()
            ->assertViewIs('dashboard.subscribers');
    }
}
