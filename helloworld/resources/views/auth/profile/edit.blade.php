@extends('layouts.app')

@section('title', '마이페이지-개인정보수정')

@section('content')
<form action="{{ route('profile.update') }}" method="POST">
    @method('PUT')
    @csrf
    <div class="row mb-3">
        <label for="name" class="col-sm-2 col-form-label">이름</label>
        <div class="col-sm-10">
            @php $invalid = $errors->has('name') ? 'is-invalid' : ''; @endphp
            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control {{ $invalid }}" placeholder="이름을 입력하세요." required />
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="row mb-3">
        <label for="email" class="col-sm-2 col-form-label">이메일</label>
        <div class="col-sm-10">
            <input type="text" name="email" value="{{ $user->email }}" class="form-control" readonly disabled />
        </div>
    </div>
    
    @if(session()->socialiteMissingAll())
    <div class="row mb-3">
        <label for="password" class="col-sm-2 col-form-label">비밀번호</label>
        <div class="col-sm-10">
            @php $invalid = $errors->has('password') ? 'is-invalid' : ''; @endphp
            <input type="password" name="password" class="form-control {{ $invalid }}" placeholder="비밀번호를 입력하세요." />
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="row mb-3">
        <label for="password" class="col-sm-2 col-form-label">비밀번호 확인</label>
        <div class="col-sm-10">
            <input type="password" name="password_confirmation" class="form-control" placeholder="비밀번호 확인을 입력하세요." />
        </div>
    </div>
    @endif

    <button type="submit" class="btn btn-primary">개인정보 변경하기</button>
</form>

@endsection