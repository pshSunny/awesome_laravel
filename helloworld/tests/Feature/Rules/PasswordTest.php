<?php

namespace Tests\Feature\Rules;

use App\Rules\Password;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class PasswordTest extends TestCase
{
    /**
     * 비밀번호 유효성 성공 테스트
     */
    public function testAcceptsValidPasswords(): void
    {
        // 최소 1개의 대소문자, 숫자, 특수문자
        $validator = Validator::make(['password' => 'p@ssW0rd'], ['password' => new Password()]);

        $this->assertTrue($validator->passes());
    }

    /**
     * 비밀번호 유효성 실패 테스트
     */
    public function testRejectsInvalidPasswords(): void
    {
        $validator = Validator::make(['password' => 'password'], ['password' => new Password()]);

        $this->assertFalse($validator->passes());
    }
}
