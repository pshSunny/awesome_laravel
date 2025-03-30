@extends('layouts.app')

@section('title', $post->title)

@section('content')
    <header>
        <h1>{{ $post->title }}</h1>

        @can(['update', 'delete'], $post)
            <a href="{{ route('posts.edit', $post) }}" class="btn btn-primary">수정</a>
            <form action="{{ route('posts.destroy', $post) }}" method="post" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">삭제</button>    
            </form>
        @endcan
    </header>
    <article>{{ $post->content }}</article>
@endsection