<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name') }}</title>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-12 pt-2">
                    <div class="row">
                        <div class="col-8">
                            <h1 class="display-one">라라벨 가볍게 따라하기</h1>
                            <p>세시간만에 라라벨 9버전을 배워 봅시다.</p>
                        </div>
                        <div class="col-4">
                            @if (Auth::check())
                                <a href="/auth/logout">로그아웃</a>
                            @else
                                <a href="/auth/login">로그인</a>
                                <a href="/auth/regist">회원가입</a>
                            @endif
                        </div>
                    </div>
                    @yield('content')
                </div>
            </div>
        </div>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha256-PI8n5gCcz9cQqQXm3PEtDuPG8qx9oFsFctPg0S5zb8g=" crossorigin="anonymous">
    </body>
</html>