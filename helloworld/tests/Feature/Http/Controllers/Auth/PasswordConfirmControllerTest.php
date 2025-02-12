<?php

namespace Tests\Feature\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PasswordConfirmControllerTest extends TestCase
{
    use WithFaker;

    /**
     * 비밀번호 확인 폼 반환 검증
     */
    public function testReturnsPasswordConfirmView(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
        ->get(route('password.confirm'))
        ->assertOk()
        ->assertViewIs('auth.confirm-password');
    }

    /**
     * 비밀번호 확인 검증
     */
    public function testConfirmsPasswordForCorrentPassword()
    {
        // App\Models\User->setPasswordAttribute()에서 비밀번호 해싱하므로 아래와 같이 password 값을 인자로 전달하여 테스트
        // $user = User::factory()->create(); // User 생성
        $user = User::factory()->create(['password' => 'password']); // User 생성

        $this->actingAs($user)
        ->post(route('password.confirm'), [
            'password' => 'password',
        ])
        ->assertRedirect();
    }

    /**
     * 비밀번호 확인 실패 검증
     */
    public function testFailToConfirmsPasswordForIncorrentPassword()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
        ->post(route('password.confirm'), [
            'password' => $this->faker->password(8),
        ])
        ->assertRedirect()
        ->assertSessionHasErrors('password');
    }
}
