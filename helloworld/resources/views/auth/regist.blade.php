@extends('layouts.app')

@section('title', '회원가입')

@section('content')
<form action="{{ route('regist') }}" method="post">
    @csrf
    <div class="row">
        <div class="col-12 control-group">
            <label for="name">이름</label>
            <input type="text" name="name" value="{{ old('name') }}" class="form-control" placeholder="이름을 입력하세요." required />
            @error('name')
                <span>{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="row">
        <div class="col-12 control-group">
            <label for="email">이메일</label>
            <input type="text" name="email" value="{{ old('email') }}" class="form-control" placeholder="이메일을 입력하세요." required />
            @error('email')
                <span>{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="row">
        <div class="col-12 control-group">
            <label for="password">비밀번호</label>
            <input type="password" name="password" class="form-control" placeholder="비밀번호를 입력하세요." required />
            @error('password')
                <span>{{ $message }}</span>
            @enderror
        </div>
    </div>
    <input type="submit" value="회원 가입" class="btn btn-primary" />
</form>
@endsection