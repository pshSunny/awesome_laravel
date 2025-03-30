@extends('layouts.app')

@section('title', '글쓰기')

@section('content')
    <form action="{{ route('blogs.posts.store', $blog) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="title">제목</label>
            <input type="text" name="title" class="form-control" id="title" placeholder="제목을 입력하세요." value="{{ old('title') }}" required autofocus>
        </div>
        <div class="form-group">
            <label for="content">내용</label>
            <textarea name="content" class="form-control" id="content" placeholder="내용을 입력하세요." rows="5" required>{{ old('content') }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">글쓰기</button>
    </form>
@endsection