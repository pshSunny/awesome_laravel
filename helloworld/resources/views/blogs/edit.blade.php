@extends('layouts.app')

@section('title', '블로그 관리')

@section('content')
    <form action="{{ route('blogs.update', $blog) }}" method="POST">
        @method('PUT')
        @csrf
        <div class="row mb-3">
            <label for="name" class="col-sm-2 col-form-label">name</label>
            <div class="col-sm-10">
                @php $invalid = $errors->has('name') ? 'is-invalid' : ''; @endphp
                <input type="text" name="name" value="{{ $blog->name }}" class="form-control {{ $invalid }}" placeholder="name을 입력하세요." required />
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="row mb-3">
            <label for="display_name" class="col-sm-2 col-form-label">display_name</label>
            <div class="col-sm-10">
                @php $invalid = $errors->has('display_name') ? 'is-invalid' : ''; @endphp
                <input type="text" name="display_name" value="{{ $blog->display_name }}" class="form-control {{ $invalid }}" placeholder="display_name을 입력하세요." required />
                @error('display_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <button type="submit" class="btn btn-primary">이름 바꾸기</button>
    </form>

    <div class="position-relative">
        <div class="position-absolute" style="top: -38px; left: 110px;">
            <form action="{{ route('blogs.destroy', $blog) }}" method="POST">
                @method('DELETE')
                @csrf
                <button type="submit" class="btn btn-danger">삭제</button>
            </form>
        </div>
    </div>

    <h3>글</h3>
    <ul>
        @foreach ($blog->posts as $post)
            <li>
                <a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a>
                <a href="{{ route('posts.edit', $post) }}" class="btn btn-secondary btn-sm">수정</a>
                <form action="{{ route('posts.destroy', $post) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">삭제</button>
                </form>
            </li>
        @endforeach
    </ul>

    <h3>댓글</h3>
    <ul>
        @foreach ($blog->comments as $comment)
            <li>
                <a href="{{ route('posts.show', $comment->commentable) }}">{{ $comment->commentable->title }}</a>
                <h4>{{ $comment->user->name }}</h4>
                <p>{{ $comment->content }}</p>
                <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">삭제</button>
                </form>
            </li>
        @endforeach
    </ul>
@endsection
