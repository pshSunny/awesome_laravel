@extends('layouts.app')

@section('title', '새로운 비밀번호 설정')

@section('content')
    <form action="{{ route('password.update') }}" method="POST">
        @csrf
        이메일 <input type="text" name="email"><br/>
        비밀번호 <input type="password" name="password"><br/>
        비밀번호 확인 <input type="password" name="password_confirmation"><br/>
        <input type="hidden" name="token" value="{{ $token }}">

        <button type="submit">비밀번호 재설정하기</button>
    </form>

    @if (session()->has('status'))
        <div>{{ session()->get('status') }}</div>
    @endif
@endsection