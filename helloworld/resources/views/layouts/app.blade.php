<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name') }} - @yield('title', '^^')</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-12 pt-2">
                    <div class="row">
                        <div class="col-8">
                            <h1 class="display-one"><a href="{{ url('/') }}">라라벨 가볍게 따라하기</a></h1>
                            <h2>@yield('title')</h2>
                        </div>
                        <div class="col-4">
                            @if (Auth::check())
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit">로그아웃</button>
                                </form>
                            @else
                                <a href="{{ route('login') }}">로그인</a>
                                <a href="{{ route('register') }}">회원가입</a>
                            @endif
                            <a href="{{ route('admin.dashboard') }}">어드민</a>
                            <a href="{{ route('blog_index') }}">Blog</a>
                        </div>
                    </div>
                    @yield('content')
                </div>
            </div>
        </div>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha256-PI8n5gCcz9cQqQXm3PEtDuPG8qx9oFsFctPg0S5zb8g=" crossorigin="anonymous">
    </body>
</html>