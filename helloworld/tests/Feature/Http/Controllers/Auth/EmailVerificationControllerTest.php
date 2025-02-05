<?php

namespace Tests\Feature\Http\Controllers\Auth;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\ValidateSignature;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EmailVerificationControllerTest extends TestCase
{
    /**
     * verification.notice: 이메일 인증되지 않았을 경우 진입
     */
    public function testReturnsVerifyEmailViewForUnverifiedUser(): void
    {
        $this->withoutMiddleware(Authenticate::class) // 사용자 인증 여부 검증하는 auth 미들웨어 제외
        ->get(route('verification.notice'))
        ->assertOk()
        ->assertViewIs('auth.verify-email'); // 뷰 체크
    }

    /**
     * verification.verify: 이메일 인증 유입 경로
     */
    public function testVerifyEmail(): void
    {
        $user = User::factory()->unverified()->create(); // 이메일 인증되지 않은 User 생성

        $this->actingAs($user) // 로그인 된 것으로 간주
        ->withoutMiddleware(ValidateSignature::class) // 전자서명 검증하는 signed 미들웨어 제외
        ->get(route('verification.verify', [
            'id' => $user->getKey(),
            'hash' => sha1($user->getEmailForVerification())
        ]))
        ->assertRedirect(RouteServiceProvider::HOME);

        $this->assertTrue($user->hasVerifiedEmail()); // 사용자 이메일 검증여부 체크
    }

    /**
     * verification.send: 이메일 재전송
     */
    public function testSendEmailForEmailVerification(): void
    {
        Notification::fake(); // 알림 전송 제한 Fake

        $user = User::factory()->unverified()->create(); // 이메일 인증되지 않은 User 생성

        $this->actingAs($user) // 로그인 된 것으로 간주
        ->post(route('verification.send'))
        ->assertRedirect();
        
        Notification::assertSentTo($user, VerifyEmail::class); // 알림 전송 검증
    }
}
