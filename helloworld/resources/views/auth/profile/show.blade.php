@extends('layouts.app')

@section('title', '마이페이지')

@section('content')
<form action="{{ route('profile.edit') }}" method="GET">        
    <div class="row">
        <div class="col-12 control-group">
            <label for="name">이름</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control" readonly disabled />
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

    <button type="submit">개인정보 변경하기</button>
</form>
@endsection