<?php

namespace Tests\Feature\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EmailVerificationControllerTest extends TestCase
{
    /**
     * verification.verify: 이메일 인증 유입 경로
     */
    public function testVerifyEmail(): void
    {
        $user = User::factory()->unverified()->create(); // 이메일 인증되지 않은 User 생성


    }
}