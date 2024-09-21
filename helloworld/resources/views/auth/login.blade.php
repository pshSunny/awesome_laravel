@extends('layouts.app')
@section('content')
<form method="post">
    @csrf
    <div class="row">
        <div class="col-12 control-group">
            <label for="email">이메일</label>
            <input type="text" name="email" class="form-control" placeholder="이메일을 입력하세요." required />
        </div>
    </div>
    <div class="row">
        <div class="col-12 control-group">
            <label for="password">비밀번호</label>
            <input type="password" name="password" class="form-control" placeholder="비밀번호를 입력하세요." required />
        </div>
    </div>
    <input type="submit" value="로그인" class="btn btn-primary" />
    @if ($errors->any())
        <p><strong>{{ $errors->first() }}</strong></p>
    @endif
</form>
@endsection