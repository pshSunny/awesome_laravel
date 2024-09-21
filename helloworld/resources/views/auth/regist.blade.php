@extends('layouts.app')
@section('content')
<form method="post">
    @csrf
    <div class="row">
        <div class="col-12 control-group">
            <label for="name">이름</label>
            <input type="text" name="name" class="form-control" placeholder="이름을 입력하세요." required />
        </div>
    </div>
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
    <input type="submit" value="회원 가입" class="btn btn-primary" />
</form>
@endsection