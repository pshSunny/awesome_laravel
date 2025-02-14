@extends('layouts.app')

@section('title', '마이페이지-개인정보수정')

@section('content')
<form action="{{ route('profile.update') }}" method="POST">
    @method('PUT')
    @csrf
    <div class="row">
        <div class="col-12 control-group">
            <label for="name">이름</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control" placeholder="이름을 입력하세요." required />
            @error('name')
                <span>{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="row">
        <div class="col-12 control-group">
            <label for="email">이메일</label>
            <input type="text" name="email" value="{{ $user->email }}" class="form-control" readonly disabled />
        </div>
    </div>
    
    @if(session()->socialiteMissingAll())
    <div class="row">
        <div class="col-12 control-group">
            <label for="password">비밀번호</label>
            <input type="password" name="password" class="form-control" placeholder="비밀번호를 입력하세요." />
            @error('password')
                <span>{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="row">
        <div class="col-12 control-group">
            <label for="password">비밀번호 확인</label>
            <input type="password" name="password_confirmation" class="form-control" placeholder="비밀번호 확인을 입력하세요." />
        </div>
    </div>
    @endif

    <button type="submit">개인정보 변경하기</button>
</form>
@endsection