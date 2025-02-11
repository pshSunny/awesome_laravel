@extends('layouts.app')

@section('title', '비밀번호 재설정')

@section('content')
    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <input type="text" name="email">
        <button type="submit">비밀번호 재설정 이메일 보내기</button>
    </form>
    
    @if ($errors->any())
        <p><strong>{{ $errors->first() }}</strong></p>
    @endif

    @if (session()->has('status'))
        <div>{{ session()->get('status') }}</div>
    @endif
@endsection