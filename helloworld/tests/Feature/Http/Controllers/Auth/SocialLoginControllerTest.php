<?php

namespace Tests\Feature\Http\Controlers\Auth;

use App\Enums\Provider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Socialite\Contracts\User as SocialiteUser;
use Laravel\Socialite\Facades\Socialite;
use Mockery\MockInterface;
use Tests\TestCase;

class SocialLoginControllerTest extends TestCase
{
    use WithFaker;

    /**
     * 서비스 제공자의 권한 승인 페이지로 리다이렉트 검증
     */
    public function testRedirectToProvider(): void
    {
        $provider = Provider::Github;

        /** @see \Laravel\Socialite\Two\GithubProvider::getAuthUrl() */
        $this->get(route('login.social', $provider))
        ->assertRedirectContains('https://github.com/login/oauth/authorize');
    }

    /**
     * 콜백 & 사용자 업데이트 또는 생성
     */
    public function testSocialLoginAndUpdateOrCreateUser()
    {
        $provider = Provider::Github;

        $data = [
            'email' => $this->faker->safeEmail,
            'name' => $this->faker->name,
        ];

        // 사용자 Mock 준비
        $socialUser = $this->mock(SocialiteUser::class, function (MockInterface $mock) use ($data) {
            $mock->shouldReceive('getEmail')->andReturn($data['email']);
            $mock->shouldReceive('getName')->andReturn($data['name']);
        });

        // Socialite 파사드 호출 자체를 페이크
        // shouldReceive() 사용하여 driver->user를 Mock하고, 미리 준비해둔 가짜 사용자($socialUser)를 반환
        Socialite::shouldReceive('driver->user')->once()->andReturn($socialUser);

        // login.social.callback 요청
        $this->get(route('login.social.callback', $provider))->assertRedirect();

        $this->assertEquals(session()->socialite($provider), $socialUser->getEmail()); // 세션 설정 검증

        $this->assertAuthenticated(); // 사용자 인증 여부 검증

        $this->assertDatabaseHas('users', $data); // 데이터베이스 검증
    }
}
