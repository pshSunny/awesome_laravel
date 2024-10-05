@extends('layouts.app')

@section('content')
<h2>Admin Dashboard</h1>
<p>Welcom, Admin {{ Auth::user()->name }}!</p>
@endsection