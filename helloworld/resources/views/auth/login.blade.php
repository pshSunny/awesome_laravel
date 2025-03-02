@extends('layouts.app')

@section('title', '로그인')

@section('content')
    @if (session()->has('status'))
        <div class="alert alert-primary">{{ session()->get('status') }}</div>
    @endif

    @if ($errors->has('failed'))
        <div class="alert alert-danger">
            {{ $errors->first('failed') }}
        </div>
    @endif

    <form method="post">
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
                <label><input type="checkbox" name="remember" /> 로그인 유지</label>
            </div>
        </div>
        <input type="submit" value="로그인" class="btn btn-primary" />
    </form>

    <div class="btn-group mt-3" role="group">
        @each('auth.social', $providers, 'provider')
    </div>

    <div class="mt-3">
        <a href="{{ route('password.request') }}">비밀번호 재설정</a>
    </div>
@endsection