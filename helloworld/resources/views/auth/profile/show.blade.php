@extends('layouts.app')

@section('title', '마이페이지')

@section('content')
<form action="{{ route('profile.edit') }}" method="GET">        
    <div class="row mb-3">
        <label for="name" class="col-sm-2 col-form-label">이름</label>
        <div class="col-sm-10">
            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control" readonly disabled />
        </div>
    </div>
    <div class="row mb-3">
        <label for="email" class="col-sm-2 col-form-label">이메일</label>
        <div class="col-sm-10">
            <input type="text" name="email" value="{{ $user->email }}" class="form-control" readonly disabled />
        </div>
    </div>

    <button type="submit" class="btn btn-primary">개인정보 변경하기</button>
</form>
@endsection