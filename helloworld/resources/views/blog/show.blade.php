@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-12">
        <h1>{{ $blogPost->title }}</h1>
        <p>{{ $blogPost->body }}</p>
    </div>
</div>

<div class="row">
    <div class="col-1">
        @if (Auth::check() && Auth::id() == $blogPost->user_id)
            <a href="/blog/edit/{{ $blogPost->id }}" class="btn btn-primary btn-sm">수정</a>
        @endif
    </div>
    <div class="col-1">
        @if (Auth::check() && Auth::id() == $blogPost->user_id)
            <form method="post" action="/blog/{{ $blogPost->id }}">
                @method('DELETE')
                @csrf
                <input type="submit" value="삭제" />
            </form>
        @endif
    </div>
</div>

<hr />
<div class="row">
    <div class="col-12">
        <h2>댓글은 사랑입니다.</h2>
        <ul id="comment_list">
            @forelse ($blogPost->comments as $comment)
                <li id="li_comment_{{ $comment->id }}">{{ $comment->body }}</li>
            @empty
                댓글이 없습니다.
            @endforelse
        </ul>
    </div>
</div>

<hr/>
<div class="row">
    <div class="col-12">
        @if (Auth::check())
            <input type="text" id="comment_body" placeholder="댓글을 입력하세요." />
            <input type="button" id="comment_save" value="댓글등록" />
        @endif
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#comment_save').click(function() {
            let blog_post_id = '{{ $blogPost->id }}';
            let comment_body = $('#comment_body').val();

            $.post('/comment', {
                'blog_post_id' : blog_post_id,
                'body' : comment_body
            }).done(function(data) {
                let is_success = data.is_success;
                let reason = data.reason;

                if (is_success) {
                    alert('저장되었습니다.');
                    $('#comment_list').append('<li id="li_comment_' + data.comment_id + '">' + comment_body + '</li>');
                } else {
                    alert(reason);
                }
            });
        });
    });
</script>
@endsection