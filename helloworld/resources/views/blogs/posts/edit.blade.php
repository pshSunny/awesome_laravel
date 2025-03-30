@extends('layouts.app')

@section('title', '글 수정')

@section('content')
    <form action="{{ route('posts.update', $post) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="title">제목</label>
            <input type="text" name="title" class="form-control" id="title" placeholder="제목을 입력하세요." value="{{ old('title', $post->title) }}" required autofocus>
        </div>
        <div class="form-group">
            <label for="content">내용</label>
            <textarea name="content" class="form-control" id="content" placeholder="내용을 입력하세요." rows="5" required>{{ old('content', $post->content) }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">글수정</button>    
    </form>
@endsection