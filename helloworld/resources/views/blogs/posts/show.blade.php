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

    <form action="{{ route('posts.comments.store', $post) }}" method="POST">
        @csrf
        <textarea type="text" name="content" placeholder="댓글 입력">{{ old('content') }}</textarea>
        <button type="submit">댓글 달기</button>
    </form>

    <h3>{{ $post->comments_count . "개의 댓글이 있습니다." }}{{-- Model::loadCount() 통해 comments_count 표기 가능함 --}}</h3>

    <ul>
        @foreach ($comments as $comment)
            <li>
                <ul>
                    @include('blogs.posts.show.comments.item') {{-- 댓글 표기 및 수정/삭제 --}}

                    <li>
                        @unless($comment->trashed()) {{-- 소프트 삭제 검사, 대댓글 작성 제한 --}}
                            <form action="{{ route('posts.comments.store', $comment->commentable) }}" method="post" class="d-inline">
                                @csrf
                                <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                <textarea name="content">{{ old('content') }}</textarea>
                                <button type="submit">답글</button>
                            </form>
                        @endunless
                    </li>

                    <li>
                        <ul>
                            @each('blogs.posts.show.comments.item', $comment->replies, 'comment') {{-- 대댓글 표기 및 수정/삭제 --}}
                        </ul>
                    </li>
                </ul>
            </li>
        @endforeach
    </ul>

@endsection
