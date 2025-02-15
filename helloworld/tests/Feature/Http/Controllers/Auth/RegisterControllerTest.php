<?php

namespace Tests\Feature\Http\Controllers\Auth;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class RegisterControllerTest extends TestCase
{
    use RefreshDatabase; // 테스트 케이스가 한 번 실행되면 데이터베이스 초기화
    use WithFaker; // 모델 팩토리에서 Faker($this->faker) 사용 허용

    /**
     * 회원가입 폼 뷰 반환 검증
     */
    public function testReturnRegisterView()
    {
        $this->get(route('register'))->assertOk()->assertViewIs('auth.register');
    }

    /**
     * 회원가입 폼 뷰 반환 실패(로그인 상태) 검증
     */
    public function testFailToReturnRegisterView()
    {
        $user = User::factory()->create();

        $this->actingAs($user) // 로그인 된 것으로 간주
        ->get(route('register'))
        ->assertRedirect(RouteServiceProvider::HOME);
    }

    /**
     * 회원등록 검증
     */
    public function testUserRegistration()
    {
        Event::fake(); // 이벤트 리스트 처리 제한

        $email = $this->faker->safeEmail; // 더미 이메일

        $this->post( // POST 요청 보내 사용자 생성 검증
            route('register'),
            [
                'name' => $this->faker->name(),
                'email' => $email,
                'password' => 'password',
            ]
        )
        ->assertRedirect( // 리다이렉트 응답 검증
            route('verification.notice')
        );

        $this->assertDatabaseHas('users', ['email' => $email]); // 데이터베이스 검증

        $this->assertAuthenticated(); // 사용자 인증 여부 검증

        Event::assertDispatched(Registered::class); // 이벤트 디스패치 검증
    }
}
