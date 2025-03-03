<?php

namespace Tests\Feature\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Tests\TestCase;

class PasswordResetControllerTest extends TestCase
{
    use RefreshDatabase; // 테스트 케이스가 한 번 실행되면 데이터베이스 초기화
    use WithFaker; // 모델 팩토리에서 Faker($this->faker) 사용 허용

    /**
     * 비밀번호 재설정 요청 폼 뷰 반환 검증
     */
    public function testReturnsForgotPasswordView(): void
    {
        $this->get(route('password.request'))
        ->assertOk()
        ->assertViewIs('auth.forgot-password');
    }

    /**
     * 비밀번호 재설정 링크 이메일 발송 검증
     */
    public function testSendMailForPasswordResets(): void
    {
        Notification::fake();

        $user = User::factory()->create();

        $this->post(route('password.email'), [
            'email' => $user->email,
        ])
        ->assertRedirect()
        ->assertSessionHas('status');

        Notification::assertSentTo(
            $user,
            ResetPassword::class
        );
    }

    /**
     * 비밀번호 재설정 링크 이메일 발송 실패 검증
     */
    public function testFailToSendMailForPasswordResets(): void
    {
        Mail::fake();

        $this->post(route('password.email'), [
            'email' => $this->faker->safeEmail,
        ])
        ->assertRedirect()
        ->assertSessionHasErrors('email');

        Mail::assertNothingSent();
    }

    /**
     * 비밀번호 재설정 폼 뷰 반환 검증
     */
    public function testReturnsResetPasswordView(): void
    {
        $token = Str::random(32);

        $this->get(route('password.reset', [
            'token' => $token,
        ]))
        ->assertOk()
        ->assertViewIs('auth.reset-password');
    }

    /**
     * 비밀번호 재설정 업데이트 검증
     */
    public function testPasswordResetsForValidToken(): void
    {
        Event::fake();

        $user = User::factory()->create();

        $token = Password::createToken($user);

        $this->post(route('password.update'), [
            'email' => $user->email,
            'password' => 'password',
            'password_confirmation' => 'password',
            'token' => $token,
        ])
        ->assertRedirect()
        ->assertSessionHas('status');

        Event::assertDispatched(PasswordReset::class);
    }

    /**
     * 비밀번호 재설정 업데이트 실패 검증: 임의 토큰 요청
     */
    public function testFailToPasswordResetsForValidToken(): void
    {
        Event::fake();

        $this->post(route('password.update'), [
            'email' => $this->faker->safeEmail,
            'password' => 'password',
            'password_confirmation' => 'password',
            'token' => Str::random(),
        ])
        ->assertRedirect()
        ->assertSessionHasErrors('email');

        Event::assertNotDispatched(PasswordReset::class);
    }
}
