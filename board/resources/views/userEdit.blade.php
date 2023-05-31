@extends('layout.layout')

@section('title','Edit')

@section('contents')
@include('layout.errorsvalidate')
    <form action="{{ route('users.userEditUpdate')}}" method="post">
        @csrf

        <label for="email">email</label>
        <input type="email" name="email" id="email" value="{{ $data->email }}">
        <br>

        <label for="name">name</label>
        <input type="name" name="name" id="name" value="{{ $data->name }}">
        <br>

        <label for="bpassword">bpassword</label>
        <input type="password" name="bpassword" id="bpassword">
        <br>

        <label for="password">password</label>
        <input type="password" name="password" id="password">
        <br>

        <label for="passwordChk">passwordChk</label>
        <input type="password" name="passwordChk" id="passwordChk">
        <button type="submit">수정</button>
        <br>
        <button type="button" onclick="location.href='{{ route('users.login',['user'=> $data->id ]) }}'">취소</button>
    </form>
@endsection





