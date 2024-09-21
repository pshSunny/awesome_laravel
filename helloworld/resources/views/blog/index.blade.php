@extends('layouts.app')
@section('content')
<div class="row">
    <ul>
        @forelse ($blogPosts as $blogPost)
            <li><a href="/blog/{{ $blogPost->id }}">{{ $blogPost->title }}</a></li>
        @empty
            <li><p>글이 없습니다.</p></li>
        @endforelse
    </ul>
</div>
<div class="row">
    <div class="col-12">
        <a href="/blog/create" class="btn btn-primary btn-sm">글쓰기</a>
    </div>
</div>
@endsection