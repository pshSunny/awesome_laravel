@extends('layouts.app')

@section('title', '새로운 블로그 만들기')

@section('content')
    <form action="{{ route('blogs.store') }}" method="POST">
        @csrf
        <div class="row mb-3">
            <label for="name" class="col-sm-2 col-form-label">name</label>
            <div class="col-sm-10">
                @php $invalid = $errors->has('name') ? 'is-invalid' : ''; @endphp
                <input type="text" name="name" value="{{ old('name') }}" class="form-control {{ $invalid }}" placeholder="name을 입력하세요." required />
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="row mb-3">
            <label for="display_name" class="col-sm-2 col-form-label">display_name</label>
            <div class="col-sm-10">
                @php $invalid = $errors->has('display_name') ? 'is-invalid' : ''; @endphp
                <input type="text" name="display_name" value="{{ old('display_name') }}" class="form-control {{ $invalid }}" placeholder="display_name을 입력하세요." required />
                @error('display_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <button type="submit" class="btn btn-primary">블로그 만들기</button>
    </form>
@endsection