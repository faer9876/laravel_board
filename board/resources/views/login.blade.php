@extends('layout.layout')

@section('title','Login')

@section('contents')
@if(session('id'))
<a href="{{ route('boards.create') }}">작성하기</a>
@else
<a href="#" onclick="alert('로그인해라')">작성하기</a>
@endif

@include('layout.errorsvalidate')
<div>{!! session()->has('success')?session('success'):"" !!}</div>
@if(!session('id'))
<h1>LOGIN</h1>
<form action="{{ route('users.login.post') }}" method="post">
    @csrf
    @method('post')
    <label for="email">Email : </label>
    <input type="text" name="email" id="email">
    <label for="password">Password : </label>
    <input type="password" name="password" id="password">
    <br><br>
    <button type="submit">Login</button>
    <button type="button" onclick="location.href='{{ route('users.registration') }}'">Registration</button>
</form>
@endif
@endsection
