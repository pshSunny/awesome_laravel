@extends('layouts.app')

@section('title', '블로그 목록')

@section('content')
<table class="table table-striped">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Display Name</th>
            <th scope="col">Blog Name</th>
            <th scope="col">User Name</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($blogs as $blog)
        <tr>
            <td></td>
            <th><a href="{{ route('blogs.show', $blog) }}">{{ $blog->display_name }}</a></th>
            <td>{{ $blog->name }}</td>
            <td>{{ $blog->user->name }}</td>
        </li>
    @endforeach
    </tbody>
</table>


{{ $blogs->links() }}

<a href="{{ route('blogs.create') }}" class="btn btn-primary btn-sm">생성</a>
@endsection