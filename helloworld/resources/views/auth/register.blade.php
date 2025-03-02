@extends('layouts.app')

@section('title', '회원가입')

@section('content')
    <form action="{{ route('register') }}" method="post">
        @csrf
        <div class="row mb-3">
            <label for="name" class="col-sm-2 col-form-label">이름</label>
            <div class="col-sm-10">
                @php $invalid = $errors->has('name') ? 'is-invalid' : ''; @endphp
                <input type="text" name="name" value="{{ old('name') }}" class="form-control {{ $invalid }}" placeholder="이름을 입력하세요." required />
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="row mb-3">
            <label for="email" class="col-sm-2 col-form-label">이메일</label>
            <div class="col-sm-10">
                @php $invalid = $errors->has('email') ? 'is-invalid' : ''; @endphp
                <input type="text" name="email" value="{{ old('email') }}" class="form-control {{ $invalid }}" placeholder="이메일을 입력하세요." required />
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
        <input type="submit" value="회원 가입" class="btn btn-primary" />
    </form>

    <div class="btn-group mt-3" role="group">
        @each('auth.social', $providers, 'provider')
    </div>
@endsection