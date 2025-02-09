<?php

namespace Tests\Feature\Providers;

use Illuminate\Contracts\Validation\UncompromisedVerifier;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Tests\TestCase;

class PasswordServiceProviderTest extends TestCase
{
    /**
     * 비밀번호 유효성 성공 테스트
     */
    public function testPasswordRule(): void
    {
        $validator = Validator::make(['password' => 'password'], [
            'password' => Password::default(),
        ]);

        $this->assertTrue(
            $validator->passes()
        );
    }

    /**
     * 프로덕션 모드에서 대소문자, 숫자, 특수문자 유효성 테스트
     */
    public function testPasswordRuleInProduction(): void
    {
        $this->app->bind('env', function () {
            return 'production';
        });

        $this->mock(UncompromisedVerifier::class, function ($mock) {
            $mock->shouldReceive('verify')
            ->once()
            ->andReturn(true);
        });

        $validator = Validator::make(['password' => 'password'], [
            'password' => Password::default(),
        ]);

        $this->assertFalse(
            $validator->passes()
        );

        $validator->setData(['password' => 'p@ssW0rd']);

        $this->assertTrue(
            $validator->passes()
        );
    }
}
