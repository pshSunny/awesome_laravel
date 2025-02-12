<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Auth\Middleware\RequirePassword as Middleware;
use Symfony\Component\HttpFoundation\Response;

class RequirePassword extends Middleware
{
    protected function shouldConfirmPassword($request, $passwordTimeoutSeconds = null)
    {
        return session()->socialiteMissingAll() && parent::shouldConfirmPassword($request, $passwordTimeoutSeconds);
    }
}
