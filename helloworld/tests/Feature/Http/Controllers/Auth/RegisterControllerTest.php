<?php

namespace Tests\Feature\Http\Controllers\Auth;

use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class RegisterControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * 회원가입 폼 뷰 반환 검증
     */
    public function testReturnRegisterView()
    {
        $this->get(route('register'))->assertOk()->assertViewIs('auth.register');
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

        $this->assertDatabaseHas('user', ['email', $email]); // 데이터베이스 검증

        $this->assertAuthenticated(); // 사용자 인증 여부 검증

        Event::assertDispatched(Registered::class); // 이벤트 디스패치 검증
    }
}
