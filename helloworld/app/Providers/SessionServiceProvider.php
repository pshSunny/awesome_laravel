<?php

namespace App\Providers;

use App\Enums\Provider;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;

class SessionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // 소셜 로그인 사용자로 세션 지정
        Session::macro('socialite', function (Provider $provider, string $email = null) {
            if (is_null($email)) {
                return $this->get('socialite.' . $provider->value);
            }
            $this->put('socialite.' . $provider->value, $email);
        });

        // 소셜 로그인으로 로그인하지 않았는지 여부 반환
        Session::macro('socialiteMissingAll', function () {
            return $this->missing('socialite');
        });
    }
}
