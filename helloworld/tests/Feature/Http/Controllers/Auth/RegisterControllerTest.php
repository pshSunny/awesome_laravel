<?php

namespace Tests\Feature\Http\Controllers\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class RegisterControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * 회원가입 폼 뷰 반환 검증
     */
    public function testReturnRegisterView() {
        $this->get(route('register'))->assertOk()->assertViewIs('auth.register');
    }

    /**
     * 회원등록 검증
     */
    public function testUserRegistration() {
        Event::fake(); // 이벤트 리스트 처리 제한

        $email = $this->faker->safeEmail; // 더미 이메일

        $this->post(route('register'), [
            'name' => $this->faker->name(),
            'email' => $email,
            'password' => 'password',
        ])
        ->assertRedirect(
            route('verification.notice')
        );

        $this->assertDatabaseHas('user', ['email', $email]);

    }
}
