<?php

namespace Tests\Feature\Http\Controllers\Auth;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase; // 테스트 케이스가 한 번 실행되면 데이터베이스 초기화
    use WithFaker; // 모델 팩토리에서 Faker($this->faker) 사용 허용

    /**
     * 로그인 폼 뷰 반환 검증
     */
    public function testReturnsLoginView(): void
    {
        $this->get(route('login'))
        ->assertOk()
        ->assertViewIs('auth.login');
    }

    /**
     * 로그인 성공 검증
     */
    public function testLoginForValidCredentials(): void
    {
        // App\Models\User->setPasswordAttribute()에서 비밀번호 해싱하므로 아래와 같이 password 값을 인자로 전달하여 테스트
        // $user = User::factory()->create(); // User 생성
        $user = User::factory()->create(['password' => 'password']); // User 생성

        $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password',
        ])
        ->assertRedirect(); // 리다이렉트 응답 검증

        $this->assertAuthenticated(); // 사용자 인증 여부 검증
    }

    /**
     * 로그인 실패 검증
     */
    public function testFailToLoginForInvalidCredentials()
    {
        $user = User::factory()->create(); // User 생성

        $this->post(route('login'), [
            'email' => $user->email,
            'password' => $this->faker->password(8),
        ])
        ->assertRedirect() // 리다이렉트 응답 검증
        ->assertSessionHasErrors('failed'); // failed 세션 에러 가지고 있는지 검증

        $this->assertGuest(); // 로그인 되지 않았음을 검증
    }

    /**
     * 로그아웃 검증
     */
    public function testLogout()
    {
        $user = User::factory()->create(); // User 생성

        $this->actingAs($user) // 로그인 된 것으로 간주
        ->post(route('logout'))
        ->assertRedirect(RouteServiceProvider::HOME);

        $this->assertGuest(); // 로그인 되지 않았음을 검증
    }
}
