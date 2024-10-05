<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminIP
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 허용된 IP 주소 목록
        $allowedIps = ['111.222.333.444', '127.0.0.1']; // @TODO DB로 관리하기

        // 클라이언트의 IP 주소를 확인
        if (!in_array($request->ip(), $allowedIps)) {
            // 허용되지 않은 IP 주소는 403 에러 반환
            abort(403, 'Unauthorized action. Request IP : ' . $request->ip());
        }

        return $next($request);
    }
}
