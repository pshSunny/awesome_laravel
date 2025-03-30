@extends('layouts.app')

@section('title', $blog->display_name)

@section('content')
    <h3>{{ $blog->display_name }}</h3>
    @auth
    <ul>
        <li><a href="{{ route('blogs.edit', $blog) }}">블로그 관리</a></li>
    </ul>
    @endauth

    @unless ($owned)
        @unless ($subscribed)
            <form action="{{ route('subscribe') }}" method="POST">
                @csrf
                <input type="hidden" name="blog_id" value="{{ $blog->id }}">
                <button type="submit">구독</button>
            </form>
        @else
            <form action="{{ route('unsubscribe') }}" method="post">
                <input type="hidden" name="blog_id" value="{{ $blog->id }}">
                <button type="submit">구독취소</button>
            </form>
        @endunless
    @endunless
@endsection