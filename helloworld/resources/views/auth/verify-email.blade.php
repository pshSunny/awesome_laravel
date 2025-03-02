@extends('layouts.app')

@section('title', '이메일 인증')

@section('content')
    @if (session('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @else
        <div class="alert alert-warning" role="alert">이메일 인증이 필요합니다.</div> 
    @endif

    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit" class="btn btn-primary">이메일 재전송</button>
    </form>
@endsection