<?php

namespace Tests\Feature\Http\Middleware;

use App\Enums\Provider;
use App\Http\Middleware\RequirePassword;
use Illuminate\Contracts\Session\Session;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Tests\TestCase;

class RequirePasswordTest extends TestCase
{
    use WithFaker;

    /**
     * 비밀번호 확인 미들웨어 검증
     */
    public function testRequirePasswordRedirect(): void
    {
        $requirePasswordMiddleware = app(RequirePassword::class);

        $request = app(Request::class);
        $request->setLaravelSession(app(Session::class));

        $response = $requirePasswordMiddleware->handle($request, function () {});

        $this->assertEquals($response->getStatuscode(), 302);
    }

    public function testRequirePasswordDoesNotRedirect(): void
    {
        $requirePasswordMiddleware = app(RequirePassword::class);

        $request = app(Request::class);
        $request->setLaravelSession(app(Session::class));
        $request->session()->socialite(Provider::Github, $this->faker->safeEmail);

        $response = $requirePasswordMiddleware->handle($request, function () {});

        $this->assertEquals($response, null);
    }
}
