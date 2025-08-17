<li>
    <div>{{ $comment->user->name }}</div>
    <div>{{ $comment->created_at->diffForHumans(now()) }} {{-- 현재로부터 시간 경과 표시, Carbon 외부 라이브러리 사용됨 --}}</div>

    <p>{{ $comment->trashed() ? '삭제된 댓글입니다.' : $comment->content }}</p>

    @unless ($comment->trashed())
        @can(['update', 'delete'], $comment)
            <form action="{{ route('comments.destroy', $comment) }}" method="post">
                @csrf
                @method('DELETE')
                <button type="submit">삭제</button>
            </form>

            <form action="{{ route('comments.update', $comment) }}" method="post">
                @csrf
                @method('PUT')
                <textarea name="content">{{ $comment->content }}</textarea>
                <button type="submit">수정</button>
            </form>
        @endcan
    @endunless
</li>
