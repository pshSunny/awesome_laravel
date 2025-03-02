@extends('layouts.app')

@section('title', '비밀번호 재설정')

@section('content')
    @if (session()->has('status'))
        <div class="alert alert-primary">{{ session()->get('status') }}</div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
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
        
        <button type="submit" class="btn btn-primary">비밀번호 재설정 이메일 보내기</button>
    </form>
@endsection