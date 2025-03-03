<?php

namespace Tests\Feature\Http\Controllers\Auth;

use App\Http\Middleware\RequirePassword;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ProfileControllerTest extends TestCase
{
    use RefreshDatabase; // 테스트 케이스가 한 번 실행되면 데이터베이스 초기화
    use WithFaker; // 모델 팩토리에서 Faker($this->faker) 사용 허용

    /**
     * Display the resource. 뷰 리턴 검증
     */
    public function testReturnsShowView(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
        ->withoutMiddleware(RequirePassword::class)
        ->get(route('profile.show'))
        ->assertOk()
        ->assertViewIs('auth.profile.show');
    }

    /**
     * Show the form for editing the resource. 뷰 리턴 검증
     */
    public function testReturnsEditView()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
        ->withoutMiddleware(RequirePassword::class)
        ->get(route('profile.edit'))
        ->assertOk()
        ->assertViewIs('auth.profile.edit');
    }

    /**
     * 이름 변경, 비밀번호 미변경 검증
     */
    public function testUpdate()
    {
        // App\Models\User->setPasswordAttribute()에서 비밀번호 해싱하므로 아래와 같이 password 값을 인자로 전달하여 테스트
        // $user = User::factory()->create(); // User 생성
        $user = User::factory()->create(['password' => 'password']); // User 생성

        $data = [
            'name' => $this->faker->name(),
        ];

        $this->actingAs($user)
        ->withoutMiddleware(RequirePassword::class)
        ->put(route('profile.update'), $data)
        ->assertRedirect(route('profile.show'));

        $this->assertTrue(
            Hash::check('password', $user->getAuthPassword()) // 비밀번호 미변경 검증
        );

        $this->assertDatabaseHas('users', [
            'name' => $data['name'],
        ]);
    }

    /**
     * 이름 변경, 비밀번호 변경 검증
     */
    public function testUpdateContainsPassword()
    {
        // App\Models\User->setPasswordAttribute()에서 비밀번호 해싱하므로 아래와 같이 password 값을 인자로 전달하여 테스트
        // $user = User::factory()->create(); // User 생성
        $user = User::factory()->create(['password' => 'password']); // User 생성
        $password = $this->faker->password(8);

        $data = [
            'name' => $this->faker->name(),
            'password' => $password,
            'password_confirmation' => $password,
        ];

        $this->actingAs($user)
        ->withoutMiddleware(RequirePassword::class)
        ->put(route('profile.update'), $data)
        ->assertRedirect(route('profile.show'));

        $this->assertTrue(
            Hash::check($password, $user->getAuthPassword()) // 비밀번호 변경 검증
        );

        $this->assertDatabaseHas('users', [
            'name' => $data['name'],
        ]);
    }
}
