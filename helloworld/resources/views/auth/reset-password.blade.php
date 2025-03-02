@extends('layouts.app')

@section('title', '새로운 비밀번호 설정')

@section('content')
    @if (session()->has('status'))
        <div class="alert alert-primary">{{ session()->get('status') }}</div>
    @endif

    <form action="{{ route('password.update') }}" method="POST">
        @csrf
        <div class="row mb-3">
            <label for="email" class="col-sm-2 col-form-label">이메일</label>
            <div class="col-sm-10">
                @php $invalid = $errors->has('email') ? 'is-invalid' : ''; @endphp
                <input type="text" name="email" value="{{  old('email') }}" class="form-control {{ $invalid }}" placeholder="이메일을 입력하세요." required />
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="row mb-3">
            <label for="password" class="col-sm-2 col-form-label">비밀번호</label>
            <div class="col-sm-10">
                @php $invalid = $errors->has('password') ? 'is-invalid' : ''; @endphp
                <input type="password" name="password" class="form-control {{ $invalid }}" placeholder="비밀번호를 입력하세요." required />
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="row mb-3">
            <label for="password" class="col-sm-2 col-form-label">비밀번호 확인</label>
            <div class="col-sm-10">
                <input type="password" name="password_confirmation" class="form-control" placeholder="비밀번호를 입력하세요." required />
            </div>
        </div>

        <input type="hidden" name="token" value="{{ $token }}">
        <button type="submit" class="btn btn-primary">비밀번호 재설정하기</button>
    </form>
@endsection