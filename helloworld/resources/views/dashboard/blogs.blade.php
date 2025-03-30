@extends('layouts.app')

@section('title', '블로그 대시보드')

@section('content')
    @include('dashboard.menu')

    <div><a href="{{ route('blogs.create') }}" class="btn btn-outline-primary">새로운 블로그 만들기</a></div>

    <ol class="list-group list-group-numbered mt-3">
        @foreach ($blogs as $blog)
            <li class="list-group-item">
                <a href="{{ route('blogs.show', $blog) }}">{{ $blog->display_name }}</a>
                <a href="{{ route('blogs.edit', $blog) }}" class="btn btn-secondary btn-sm">블로그 관리</a>
            </li>
        @endforeach
    </ol>
@endsection