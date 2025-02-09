<?php

namespace Tests\Feature\Providers;

use App\Enums\Provider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class SessionServiceProviderTest extends TestCase
{
    use WithFaker;

    /**
     * 소셜 로그인 사용자로 세션 지정 검증
     */
    public function testSocialiteMacro(): void
    {
        $this->assertTrue(Session::hasMacro('socialite'));

        Session::socialite(Provider::Github, $this->faker->safeEmail());

        $this->assertTrue(Session::has('socialite.github'));
    }

    /**
     * 소셜 로그인으로 로그인하지 않았는지 여부 반환 검증
     */
    public function testSocialiteMissingAllMacro(): void{
        $this->assertTrue(Session::hasMacro('socialiteMissingAll'));

        // 소셜 로그인으로 로그인하지 않았을 때 True
        $this->assertTrue(Session::socialiteMissingAll());

        // 소셜 로그인으로 로그인 했을 때 False
        Session::put('socialite.github', $this->faker->safeEmail());

        $this->assertFalse(Session::socialiteMissingAll());
    }
}
