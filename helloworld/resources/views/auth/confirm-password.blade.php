@extends('layouts.app')

@section('title', '비밀번호 확인')

@section('content')
    <form action="{{ route('password.confirm') }}" method="POST">
        @csrf
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
        <button type="submit" class="btn btn-primary">비밀번호 확인하기</button>
    </form>
@endsection