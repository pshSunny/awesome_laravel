@extends('layouts.app')
@section('content')
<form method="post">
    @csrf
    <div class="row">
        <div class="col-12 control-group">
            <label for="title">제목</label>
            <input type="text" name="title" class="form-control" placeholder="제목을 입력하세요." required />
        </div>
    </div>
    <div class="row">
        <div class="col-12 control-group">
            <label for="body">본문</label>
            <textarea name="body" class="form-control" placeholder="본문을 입력하세요." required></textarea>
        </div>
    </div>
    <input type="submit" value="저장" class="btn btn-primary" />
    <a href="/blog" class="btn btn-secondary">목록으로</a>
</form>
@endsection